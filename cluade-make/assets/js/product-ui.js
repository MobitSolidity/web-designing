(function () {
  const doc = document;

  const toPersianDigits = (value) => {
    const map = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return String(value).replace(/[0-9]/g, (d) => map[d]);
  };

  // Filter sheet toggle for mobile
  const filterToggle = doc.querySelector('[data-filter-toggle]');
  const filterSheet = doc.querySelector('[data-filter-sheet]');
  if (filterToggle && filterSheet) {
    const closeButtons = filterSheet.querySelectorAll('[data-filter-close]');
    const toggleState = (open) => {
      filterSheet.setAttribute('aria-hidden', open ? 'false' : 'true');
      filterToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      filterSheet.classList.toggle('is-open', open);
      doc.body.classList.toggle('is-filter-open', open);
    };

    filterToggle.addEventListener('click', () => toggleState(true));
    closeButtons.forEach((btn) => btn.addEventListener('click', () => toggleState(false)));
    filterSheet.addEventListener('click', (e) => {
      if (e.target === filterSheet) toggleState(false);
    });
  }

  // Character counter for gift message
  doc.querySelectorAll('[data-char-counter]').forEach((counter) => {
    const targetId = counter.getAttribute('data-char-for');
    const target = targetId ? doc.getElementById(targetId) : null;
    if (!target) return;

    const max = parseInt(target.getAttribute('maxlength'), 10) || 200;
    const updateCount = () => {
      const length = target.value.length;
      counter.textContent = `${toPersianDigits(length)} / ${toPersianDigits(max)} کاراکتر`;
    };

    target.addEventListener('input', updateCount);
    updateCount();
  });

  // Gift toggle hides/shows personalization fields
  const giftToggle = doc.querySelector('[data-gift-toggle]');
  const giftFields = doc.querySelector('[data-gift-fields]');
  if (giftToggle && giftFields) {
    const syncFields = () => {
      const isChecked = giftToggle.checked;
      giftFields.classList.toggle('is-disabled', !isChecked);
      giftFields.querySelectorAll('input, textarea').forEach((el) => {
        el.disabled = !isChecked;
      });
    };
    giftToggle.addEventListener('change', syncFields);
    syncFields();
  }

  // Sticky add to cart button scrolls to purchase box
  doc.querySelectorAll('[data-scroll-to]').forEach((btn) => {
    const target = doc.querySelector(btn.getAttribute('data-scroll-to'));
    if (!target) return;
    btn.addEventListener('click', () => {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

})();
