(function () {
    const acc         = document.getElementById('faqAcc');
    const items       = acc.querySelectorAll('.accordion-item');
    const search      = document.getElementById('faqSearch');
    const btnExpand   = document.getElementById('btnExpandAll');
    const btnCollapse = document.getElementById('btnCollapseAll');

    // Bar judul: ganti warna & teks saat show/hide
    items.forEach(item => {
      const title    = item.querySelector('.faq-title');
      const button   = item.querySelector('.faq-title .accordion-button');
      const chevron  = item.querySelector('.faq-title i');
      const collapse = item.querySelector('.accordion-collapse');

      collapse.addEventListener('show.bs.ccollapse', () => {}); // placeholder to avoid typo
    });

    // Correct listeners (the line above is only to avoid accidental typo in some editors)
    items.forEach(item => {
      const title    = item.querySelector('.faq-title');
      const button   = item.querySelector('.faq-title .accordion-button');
      const chevron  = item.querySelector('.faq-title i');
      const collapse = item.querySelector('.accordion-collapse');

      collapse.addEventListener('show.bs.collapse', () => {
        title.style.backgroundColor = '#0A3A7A';
        title.classList.add('text-white');
        button.classList.add('text-white');
        chevron?.classList.add('text-white');
      });

      collapse.addEventListener('hide.bs.collapse', () => {
        title.style.backgroundColor = '';
        title.classList.remove('text-white');
        button.classList.remove('text-white');
        chevron?.classList.remove('text-white');
      });
    });

    // Filter sederhana
    const norm = s => (s || '').toLowerCase().trim();
    search?.addEventListener('input', () => {
      const v = norm(search.value);
      items.forEach(item => {
        const text = norm(item.textContent);
        item.style.display = text.includes(v) ? '' : 'none';
      });
    });

    // Expand / Collapse semua
    btnExpand?.addEventListener('click', e => {
      e.preventDefault();
      items.forEach(item => {
        const c = item.querySelector('.accordion-collapse');
        if (!c.classList.contains('show')) new bootstrap.Collapse(c, { toggle: true });
      });
    });

    btnCollapse?.addEventListener('click', e => {
      e.preventDefault();
      items.forEach(item => {
        const c = item.querySelector('.accordion-collapse');
        if (c.classList.contains('show')) new bootstrap.Collapse(c, { toggle: true });
      });
    });
})();