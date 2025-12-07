document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('petugasSearch');
  if (!searchInput) return;

  const cards = document.querySelectorAll('.petugas-card');
  const norm  = s => (s || '').toLowerCase().trim();

  searchInput.addEventListener('input', function () {
    const v = norm(this.value);

    cards.forEach(card => {
      const text = norm(card.textContent);
      card.style.display = text.includes(v) ? '' : 'none';
    });
  });
});
