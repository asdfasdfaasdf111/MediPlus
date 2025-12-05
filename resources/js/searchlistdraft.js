// resources/js/searchlistdraft.js
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('draftSearch');
  if (!searchInput) {
    console.warn('draftSearch tidak ditemukan');
    return;
  }

  const cards = document.querySelectorAll('.draft-item');
  const norm  = s => (s || '').toLowerCase().trim();

  searchInput.addEventListener('input', () => {
    const v = norm(searchInput.value);

    cards.forEach(card => {
      const text = norm(card.textContent);
      card.style.display = text.includes(v) ? '' : 'none';
    });
  });
});
