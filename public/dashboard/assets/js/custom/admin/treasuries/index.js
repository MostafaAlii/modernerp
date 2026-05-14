// is_master label Create Modal
document.getElementById('isMasterSwitch')?.addEventListener('change', function () {
    document.getElementById('isMasterLabel').textContent = this.checked
        ? window.translations.master
        : window.translations.sub;
});

// is_active label Create Modal
document.getElementById('isActiveSwitch')?.addEventListener('change', function () {
    document.getElementById('isActiveLabel').textContent = this.checked
        ? window.translations.active
        : window.translations.inactive;
});

// is_master label Edit Modal
document.addEventListener('change', function (e) {
    if (e.target.matches('[id^="isMasterSwitch"]') && e.target.id !== 'isMasterSwitch') {
        var id = e.target.id.replace('isMasterSwitch', '');
        document.getElementById('isMasterLabel' + id).textContent = e.target.checked
            ? window.translations.master
            : window.translations.sub;
    }

    // is_active label Edit Modal
    if (e.target.matches('[id^="isActiveSwitch"]') && e.target.id !== 'isActiveSwitch') {
        var id = e.target.id.replace('isActiveSwitch', '');
        document.getElementById('isActiveLabel' + id).textContent = e.target.checked
            ? window.translations.active
            : window.translations.inactive;
    }
});

// Update Status
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

// Update Type (is_master column)
document.addEventListener('change', function (e) {
    if (e.target.matches('.toggle-master')) {
        const route   = e.target.dataset.route;
        const toggle  = e.target;
        const badgeEl = toggle.closest('.d-flex').querySelector('.badge-master');

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


// ========== Show Modal — Treasury Delivery ==========

function initTreasuryShowModal(id) {
    var config     = window.TreasuryShow?.[id];
    if (! config) return;
    var modalEl    = document.getElementById('showModal' + id);
    var toggleBtn  = document.getElementById('toggleDeliveryForm' + id);
    var cancelBtn  = document.getElementById('cancelDeliveryForm' + id);
    var form       = document.getElementById('deliveryForm' + id);
    var detailForm = document.getElementById('deliveryDetailForm' + id);
    var tableBody  = document.getElementById('deliveryTableBody' + id);
    if (! modalEl) return;
    // ===== Show / Hide Form =====
    function showForm() {
        form.style.display = 'block';
        setTimeout(() => {
            form.style.maxHeight = '200px';
            form.style.opacity   = '1';
        }, 10);
        toggleBtn.classList.replace('btn-success', 'btn-secondary');
        toggleBtn.innerHTML = '<i class="fas fa-minus me-1"></i> ' + config.trans.cancel;
    }

    function hideForm() {
        form.style.maxHeight = '0';
        form.style.opacity   = '0';
        setTimeout(() => { form.style.display = 'none'; }, 400);
        toggleBtn.classList.replace('btn-secondary', 'btn-success');
        toggleBtn.innerHTML = '<i class="fas fa-plus me-1"></i> ' + config.trans.add;
    }

    // ===== Load Deliveries =====
    function loadDeliveries() {
        fetch(config.routes.getDeliveries, {
            headers: {
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(res => res.json())
        .then(data => {
            if (! data.deliveries.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-muted py-3">
                            <i class="fas fa-inbox me-1"></i>
                            ${config.trans.no_deliveries}
                        </td>
                    </tr>`;
                return;
            }

            tableBody.innerHTML = data.deliveries.map((d, i) => `
                <tr style="transition: background 0.2s;"
                    onmouseover="this.style.background='#f8f9ff'"
                    onmouseout="this.style.background=''">
                    <td class="text-muted" style="padding:10px;">${i + 1}</td>
                    <td style="padding:10px; font-weight:500;">${d.treasury}</td>
                    <td style="padding:10px;">${d.added_by}</td>
                    <td style="padding:10px;">
                        <span class="badge" style="background:#f0f0ff; color:#667eea; font-weight:500;">
                            ${d.date}
                        </span>
                    </td>
                    <td style="padding:10px;">
                        <button class="btn btn-sm btn-danger delete-delivery"
                            data-id="${d.id}"
                            style="border-radius:6px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

            // Delete
            tableBody.querySelectorAll('.delete-delivery').forEach(btn => {
                btn.addEventListener('click', function () {
                    const route = config.routes.destroyDelivery.replace('__id__', this.dataset.id);
                    const row   = this.closest('tr');

                    row.style.opacity = '0.5';

                    fetch(route, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept':       'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Alert.success(data.message);
                            loadDeliveries();
                        } else {
                            row.style.opacity = '1';
                            Alert.error(data.message);
                        }
                    })
                    .catch(() => {
                        row.style.opacity = '1';
                        Alert.error(window.translations.error);
                    });
                });
            });
        })
        .catch(() => {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-danger py-3">
                        ${window.translations.error}
                    </td>
                </tr>`;
        });
    }

    // ===== Store Delivery =====
    detailForm?.addEventListener('submit', function (e) {
        e.preventDefault();
        const subTreasuryId = document.getElementById('subTreasurySelect' + id)?.value;
        if (! subTreasuryId) {
            Alert.warning(config.trans.select_sub);
            return;
        }
        fetch(config.routes.storeDelivery, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept':       'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ sub_treasury_id: subTreasuryId }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Alert.success(data.message);
                hideForm();
                loadDeliveries();
            } else {
                Alert.error(data.message);
            }
        })
        .catch(() => {
            Alert.error(window.translations.error);
        });
    });
    // ===== Events =====
    modalEl.addEventListener('shown.bs.modal',  loadDeliveries);
    modalEl.addEventListener('hidden.bs.modal', hideForm);
    toggleBtn?.addEventListener('click', () => form.style.display === 'none' ? showForm() : hideForm());
    cancelBtn?.addEventListener('click', hideForm);
}

document.addEventListener('show.bs.modal', function (e) {
    var modalEl = e.target;
    if (! modalEl.id.startsWith('showModal')) return;
    var id = modalEl.id.replace('showModal', '');
    if (modalEl.dataset.initialized) return;
    modalEl.dataset.initialized = 'true';
    initTreasuryShowModal(id);
});