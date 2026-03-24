// is_master label
document.getElementById('isMasterSwitch')?.addEventListener('change', function () {
    document.getElementById('isMasterLabel').textContent = this.checked
        ? window.translations.master
        : window.translations.sub;
});

// is_active label
document.getElementById('isActiveSwitch')?.addEventListener('change', function () {
    document.getElementById('isActiveLabel').textContent = this.checked
        ? window.translations.active
        : window.translations.inactive;
});