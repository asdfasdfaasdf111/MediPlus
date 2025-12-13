document.addEventListener('DOMContentLoaded', function () {
  const MAX_SIZE_MB    = 8;
  const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

  const form       = document.getElementById('formDataRujukan');
  const input      = document.getElementById('formulirRujukan');
  const errorJs    = document.getElementById('formulirRujukanErrorJs');
  const fileNameEl = document.getElementById('fileName');

  if (!form || !input || !errorJs || !fileNameEl) return;

  function clearJsError() {
    errorJs.textContent = '';
    input.classList.remove('is-invalid');
  }

  function setJsError(message) {
    errorJs.textContent = message;
    input.classList.add('is-invalid');
  }

  input.addEventListener('change', function () {
    clearJsError();

    const file = input.files[0];

    if (!file) {
      fileNameEl.textContent = 'No File Chosen';
      return;
    }

    // buat ngecek ukuran file
    if (file.size > MAX_SIZE_BYTES) {
      input.value = '';             // reset input
      fileNameEl.textContent = 'No File Chosen';
      setJsError(`Ukuran file maksimal ${MAX_SIZE_MB} MB.`);
      return;
    }

    // Kalau lolos, tampilkan nama file
    fileNameEl.textContent = file.name;
  });

  form.addEventListener('submit', function (e) {
    clearJsError();

    const file = input.files[0];

    // Kalau ini update, biarin
    if (!file && !input.hasAttribute('required')) {
      return;
    }

    // Kalau ini create dan user belum pilih file, laravel yang validasi
    if (!file && input.hasAttribute('required')) {
      return;
    }

    if (file && file.size > MAX_SIZE_BYTES) {
      e.preventDefault();
      setJsError(`Ukuran file maksimal ${MAX_SIZE_MB} MB.`);
    }
  });
});
