$(document).ready(function() {
    $(document).on('submit', 'form', function(e) {
        if ($(this).attr('id') === 'editForm') {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    });
});
let currentEditId = null;
function getRoute(routeName, id) {
    if (!window.routes || !window.routes[routeName]) {
        console.error(`Route ${routeName} not found`, window.routes);
        return null;
    }
    return window.routes[routeName].replace('__ID__', id);
}

function showModalLoading(show) {
    if (show) {
        if (!$('#modal-loader').length) {
            $('#editSalesMatrialTypeModal .modal-content').css('position', 'relative');
            $('#editSalesMatrialTypeModal .modal-content').append(`
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
        $('#editSalesMatrialTypeModal .modal-content').css('position', '');
    }
}

function fillEditForm(data) {
    if (data.translations && Array.isArray(data.translations)) {
        window.locales.forEach(locale => {
            const translation = data.translations.find(t => t.locale === locale);
            $(`#edit_name_${locale}`).val(translation?.name || '');
        });
    }
    const isActive = data.is_active == 1;
    $('#editIsActiveSwitch').prop('checked', isActive);
    $('#editIsActiveLabel').text(isActive ? window.translations.active : window.translations.inactive);
    const updateUrl = getRoute('update', data.id);
    if (updateUrl) {
        $('#editForm').attr('action', updateUrl);
    }
}

function resetEditForm() {
    $('#editForm')[0]?.reset();
    $('#editForm').attr('action', '');
    currentEditId = null;
    if (window.locales) {
        window.locales.forEach(locale => {
            $(`#edit_name_${locale}`).val('');
        });
    }
    $('#editIsActiveSwitch').prop('checked', false);
    $('#editIsActiveLabel').text(window.translations?.inactive || 'Inactive');
}

$(document).on('click', '.btn-edit-sales-matrial-type', function(e) {
    e.preventDefault();
    currentEditId = $(this).data('id');  
    const editUrl = getRoute('edit', currentEditId);
    if (!editUrl) {
        Alert.error('حدث خطأ: رابط التعديل غير موجود');
        return;
    }
    $('#editSalesMatrialTypeModal').modal('show');
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
            console.error('AJAX Error:', xhr);
            let errorMsg = 'حدث خطأ في جلب البيانات';
            if (xhr.status === 404) errorMsg = 'العنصر غير موجود';
            else if (xhr.status === 500) errorMsg = 'خطأ في السيرفر';
            else if (xhr.responseJSON?.message) errorMsg = xhr.responseJSON.message;
            Alert.error(errorMsg);
            $('#editSalesMatrialTypeModal').modal('hide');
        },
        complete: function() {
            showModalLoading(false);
        }
    });
});

$(document).on('click', '#editForm button[type="submit"]', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    console.log('Save button clicked');
    
    const form = $('#editForm');
    const updateUrl = form.attr('action');
    
    if (!updateUrl) {
        Alert.error('حدث خطأ في تحديد رابط التحديث');
        return;
    }
    
    if (!currentEditId) {
        Alert.error('لا يوجد عنصر للتعديل');
        return;
    }
    
    // جمع البيانات
    const formData = new FormData(form[0]);
    formData.set('_method', 'PUT');
    
    console.log('Submitting to:', updateUrl);
    console.log('Form data:', Object.fromEntries(formData));
    
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
            console.log('Update response:', response);
            
            if (response.success) {
                Alert.success(response.message);
                $('#editSalesMatrialTypeModal').modal('hide');
                if (window.LaravelDataTables && window.LaravelDataTables['sales_matrial_types_datatable']) {
                    window.LaravelDataTables['sales_matrial_types_datatable'].ajax.reload(null, false);
                }
                
                resetEditForm();
            } else {
                Alert.error(response.message || window.translations?.error);
            }
        },
        error: function(xhr) {
            console.error('Update error:', xhr);
            
            let errorMessage = window.translations?.error || 'حدث خطأ';
            
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors).flat().join('\n');
            } else if (xhr.responseJSON?.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            Alert.error(errorMessage);
        },
        complete: function() {
            submitBtn.prop('disabled', false).html(originalText);
        }
    });
    
    return false;
});
$(document).on('change', '#editIsActiveSwitch', function() {
    const isChecked = $(this).is(':checked');
    $('#editIsActiveLabel').text(isChecked ? window.translations.active : window.translations.inactive);
});
$('#editSalesMatrialTypeModal').on('hidden.bs.modal', function() {
    resetEditForm();
    showModalLoading(false);
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
// ========================
// 3. DELETE -  Ajax
// ========================
let deleteId = null;
$(document).on('click', '.btn-delete-sales-matrial-type', function(e) {
    e.preventDefault();
    deleteId = $(this).data('id');
    const name = $(this).data('name');
    $('#deleteMessage').text(`هل أنت متأكد من حذف "${name}"؟`);
    $('#deleteSalesMatrialTypeModal').modal('show');
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
    console.log('Deleting:', deleteUrl);
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
            console.log('Delete response:', response);
            
            if (response.success) {
                Alert.success(response.message);
                $('#deleteSalesMatrialTypeModal').modal('hide');
                if (window.LaravelDataTables && window.LaravelDataTables['sales_matrial_types_datatable']) {
                    window.LaravelDataTables['sales_matrial_types_datatable'].ajax.reload(null, false);
                }
                else {
                    //console.log('Available DataTables:', Object.keys(window.LaravelDataTables || {}));
                    Alert.warning('تم الحذف بنجاح، لكن لم يتم تحديث الجدول تلقائياً');
                }   
                deleteId = null;
            } else {
                Alert.error(response.message || window.translations?.error);
            }
        },
        error: function(xhr) {
            console.error('Delete error:', xhr);
            let errorMessage = window.translations?.error || 'حدث خطأ في الحذف';
            if (xhr.status === 404) {
                errorMessage = 'العنصر غير موجود';
            } else if (xhr.status === 500) {
                errorMessage = 'خطأ في السيرفر';
            } else if (xhr.responseJSON?.message) {
                errorMessage = xhr.responseJSON.message;
            }            
            Alert.error(errorMessage);
        },
        complete: function() {
            deleteBtn.prop('disabled', false).html(originalText);
        }
    });
});

$('#deleteSalesMatrialTypeModal').on('hidden.bs.modal', function() {
    deleteId = null;
    $('#deleteMessage').text('');
});