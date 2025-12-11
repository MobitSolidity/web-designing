(function() {
  const doc = document;
  const menuToggle = doc.querySelector('[data-menu-toggle]');
  const mobileMenu = doc.querySelector('[data-mobile-menu]');
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('is-open');
    });
  }

  const filterToggle = doc.querySelector('[data-filter-toggle]');
  const filterSheet = doc.querySelector('[data-filter-sheet]');
  if (filterToggle && filterSheet) {
    const closeButtons = filterSheet.querySelectorAll('[data-filter-close]');
    const toggleState = (open) => {
      filterSheet.classList.toggle('is-open', open);
    };
    filterToggle.addEventListener('click', () => toggleState(true));
    closeButtons.forEach(btn => btn.addEventListener('click', () => toggleState(false)));
  }

  const toPersianDigits = (value) => {
    const map = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return String(value).replace(/[0-9]/g, d => map[d]);
  };

  doc.querySelectorAll('[data-char-counter]').forEach(counter => {
    const max = 200;
    const targetId = counter.getAttribute('data-char-for');
    const textarea = targetId ? doc.getElementById(targetId) : counter.previousElementSibling;
    if (!textarea) return;
    const update = (val) => {
      counter.textContent = `${toPersianDigits(val.length)} / ${toPersianDigits(max)} کاراکتر`;
    };
    textarea.addEventListener('input', () => update(textarea.value));
    update(textarea.value);
  });

  const giftToggle = doc.querySelector('[data-gift-toggle]');
  const giftFields = doc.querySelector('[data-gift-fields]');
  if (giftToggle && giftFields) {
    const sync = () => {
      const enabled = giftToggle.checked;
      giftFields.classList.toggle('is-disabled', !enabled);
      giftFields.querySelectorAll('input, textarea').forEach(el => el.disabled = !enabled);
    };
    giftToggle.addEventListener('change', sync);
    sync();
  }

  doc.querySelectorAll('[data-scroll-to]').forEach(btn => {
    const target = doc.querySelector(btn.getAttribute('data-scroll-to'));
    if (!target) return;
    btn.addEventListener('click', () => target.scrollIntoView({behavior:'smooth', block:'start'}));
  });

  // Lazy-load AI assistant when needed
  const assistantRoot = doc.querySelector('[data-assistant]');
  if (assistantRoot) {
    const bubble = assistantRoot.querySelector('[data-assistant-toggle]');
    let isLoading = false;
    const loadAssistant = () => {
      if (assistantRoot.dataset.assistantLoaded === 'true') return Promise.resolve();
      if (isLoading) return Promise.resolve();
      return new Promise((resolve, reject) => {
        isLoading = true;
        const script = doc.createElement('script');
        script.src = 'assets/js/assistant.js';
        script.defer = true;
        script.onload = () => {
          assistantRoot.dataset.assistantLoaded = 'true';
          isLoading = false;
          resolve();
        };
        script.onerror = (err) => { isLoading = false; reject(err); };
        doc.body.appendChild(script);
      });
    };

    bubble && bubble.addEventListener('click', (e) => {
      e.preventDefault();
      loadAssistant().then(() => {
        assistantRoot.dispatchEvent(new CustomEvent('assistant:toggle'));
      }).catch(() => {
        bubble.textContent = 'خطا در بارگذاری دستیار';
      });
    });
  }
})();
