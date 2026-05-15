$(document).ready(function() {
    let currentEditId = null;
    let deleteId = null;

    function getRoute(routeName, id) {
        if (!window.routes || !window.routes[routeName]) {
            console.error(`Route ${routeName} not found`, window.routes);
            return null;
        }
        return window.routes[routeName].replace('__ID__', id);
    }

    // Create Modal - is_active label
    $('#isActiveSwitch').on('change', function() {
        $('#isActiveLabel').text(this.checked ? window.translations.active : window.translations.inactive);
    });

    // ========================
    // EDIT
    // ========================
    $(document).on('click', '.btn-edit-store', function(e) {
        e.preventDefault();
        currentEditId = $(this).data('id');
        
        const editUrl = getRoute('edit', currentEditId);
        if (!editUrl) {
            Alert.error('حدث خطأ: رابط التعديل غير موجود');
            return;
        }
        
        $('#editStoreModal').modal('show');
        showModalLoading(true);
        
        $.ajax({
            url: editUrl,
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success && response.data) {
                    fillEditForm(response.data);
                } else {
                    Alert.error('البيانات غير صالحة');
                }
            },
            error: function(xhr) {
                Alert.error('حدث خطأ في جلب البيانات');
                $('#editStoreModal').modal('hide');
            },
            complete: function() {
                showModalLoading(false);
            }
        });
    });
    
    function showModalLoading(show) {
        if (show) {
            if (!$('#modal-loader').length) {
                $('#editStoreModal .modal-content').css('position', 'relative');
                $('#editStoreModal .modal-content').append(`
                    <div id="modal-loader" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.9); z-index: 9999; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                            <div class="mt-2">جاري تحميل البيانات...</div>
                        </div>
                    </div>
                `);
            }
        } else {
            $('#modal-loader').remove();
            $('#editStoreModal .modal-content').css('position', '');
        }
    }

    function fillEditForm(data) {
        if (data.translations && Array.isArray(data.translations)) {
            window.locales.forEach(locale => {
                const translation = data.translations.find(t => t.locale === locale);
                $(`#edit_name_${locale}`).val(translation?.name || '');
            });
        }

        $('#edit_phone').val(data.phone || '');
        $('#edit_address').val(data.address || '');
        $('#edit_date').val(data.date || '');
        
        const isActive = data.is_active == 1;
        $('#editIsActiveSwitch').prop('checked', isActive);
        $('#editIsActiveLabel').text(isActive ? window.translations.active : window.translations.inactive);
        
        const updateUrl = getRoute('update', data.id);
        if (updateUrl) {
            $('#editForm').attr('action', updateUrl);
        }
    }

    $(document).on('click', '#editForm button[type="submit"]', function(e) {
        e.preventDefault();
        
        const form = $('#editForm');
        const updateUrl = form.attr('action');
        
        if (!updateUrl || !currentEditId) {
            Alert.error('حدث خطأ في تحديد رابط التحديث');
            return;
        }
        
        const formData = new FormData(form[0]);
        formData.set('_method', 'PUT');
        
        const submitBtn = $(this);
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحفظ...');
        
        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    Alert.success(response.message);
                    $('#editStoreModal').modal('hide');
                    
                    if (window.LaravelDataTables && window.LaravelDataTables['stores_datatable']) {
                        window.LaravelDataTables['stores_datatable'].ajax.reload(null, false);
                    }
                    
                    resetEditForm();
                } else {
                    Alert.error(response.message || window.translations?.error);
                }
            },
            error: function(xhr) {
                Alert.error(window.translations?.error || 'حدث خطأ');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    $(document).on('change', '#editIsActiveSwitch', function() {
        const isChecked = $(this).is(':checked');
        $('#editIsActiveLabel').text(isChecked ? window.translations.active : window.translations.inactive);
    });

    function resetEditForm() {
        $('#editForm')[0]?.reset();
        $('#editForm').attr('action', '');
        currentEditId = null;
        
        if (window.locales) {
            window.locales.forEach(locale => {
                $(`#edit_name_${locale}`).val('');
            });
        }
        
        $('#edit_phone').val('');
        $('#edit_address').val('');
        $('#edit_date').val('');
        $('#editIsActiveSwitch').prop('checked', false);
        $('#editIsActiveLabel').text(window.translations?.inactive || 'Inactive');
    }

    $('#editStoreModal').on('hidden.bs.modal', function() {
        resetEditForm();
        showModalLoading(false);
    });

    // ========================
    // DELETE
    // ========================
    $(document).on('click', '.btn-delete-store', function(e) {
        e.preventDefault();
        deleteId = $(this).data('id');
        const name = $(this).data('name');
        
        $('#deleteMessage').text(`هل أنت متأكد من حذف "${name}"؟`);
        $('#deleteStoreModal').modal('show');
    });

    $(document).on('click', '#confirmDeleteBtn', function(e) {
        e.preventDefault();
        
        if (!deleteId) {
            Alert.error('لا يوجد عنصر للحذف');
            return;
        }
        
        const deleteUrl = getRoute('destroy', deleteId);
        if (!deleteUrl) {
            Alert.error('حدث خطأ: رابط الحذف غير موجود');
            return;
        }
        
        const deleteBtn = $(this);
        const originalText = deleteBtn.html();
        deleteBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> جاري الحذف...');
        
        $.ajax({
            url: deleteUrl,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    Alert.success(response.message);
                    $('#deleteStoreModal').modal('hide');
                    
                    if (window.LaravelDataTables && window.LaravelDataTables['stores_datatable']) {
                        window.LaravelDataTables['stores_datatable'].ajax.reload(null, false);
                    }
                    
                    deleteId = null;
                } else {
                    Alert.error(response.message || window.translations?.error);
                }
            },
            error: function(xhr) {
                Alert.error(window.translations?.error || 'حدث خطأ في الحذف');
            },
            complete: function() {
                deleteBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    $('#deleteStoreModal').on('hidden.bs.modal', function() {
        deleteId = null;
        $('#deleteMessage').text('');
    });

    document.getElementById('isActiveSwitch')?.addEventListener('change', function () {
        document.getElementById('isActiveLabel').textContent = this.checked
            ? window.translations.active
            : window.translations.inactive;
    });
    document.addEventListener('change', function (e) {
        if (e.target.matches('.toggle-status')) {
            const route  = e.target.dataset.route;
            const toggle = e.target;
            const badgeEl = toggle.closest('.d-flex').querySelector('.badge-status');
            fetch(route, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    badgeEl.innerHTML = data.badge;
                    Alert.success(data.message);
                } else {
                    toggle.checked = !toggle.checked;
                    Alert.error(data.message);
                }
            })
            .catch(() => {
                toggle.checked = !toggle.checked;
                Alert.error(window.translations.error);
            });
        }
    });
});