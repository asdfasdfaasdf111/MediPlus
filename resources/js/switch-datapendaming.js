document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.getElementById('togglePendamping');
  const fields = document.querySelectorAll('.js-pendamping-field');

  if (!toggle) return;

  function syncPendampingFields() {
    const enabled = toggle.checked;

    fields.forEach(function (el) {
      el.disabled = !enabled;

    //   code ini kalo di switch Off jadi ke reset data yang diinput tadi
      if (!enabled) {
        if (el.tagName === 'INPUT') {
          el.value = '';
        }
        if (el.tagName === 'SELECT') {
          el.selectedIndex = 0;
        }
      }
    });
  }

  toggle.addEventListener('change', syncPendampingFields);
  syncPendampingFields();
});
