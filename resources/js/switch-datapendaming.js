document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.getElementById('togglePendamping');
  const hiddenFlag = document.getElementById('pakaiPendamping');
  const fields = document.querySelectorAll('.js-pendamping-field');

  if (!toggle || fields.length === 0) return;

  function setPendampingEnabled(enabled, clear = false) {
    // update hidden flag buat dikirim ke controller
    if (hiddenFlag) {
      hiddenFlag.value = enabled ? 1 : 0;
    }

    fields.forEach(function (el) {
      el.disabled = !enabled;

      if (enabled) {
        el.setAttribute('required', 'required');
      } else {
        el.removeAttribute('required');

        if (clear) {
          if (el.tagName === 'INPUT') {
            el.value = '';
          } else if (el.tagName === 'SELECT') {
            el.selectedIndex = 0;
          }
        }
      }
    });
  }

  // ikutin awal checkbox
  setPendampingEnabled(toggle.checked, false);

  // Kalau user ngubah switch
  toggle.addEventListener('change', function () {
    const enabled = toggle.checked;
    // kalau dimatiin, baru clear isi
    setPendampingEnabled(enabled, !enabled);
  });
});
