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