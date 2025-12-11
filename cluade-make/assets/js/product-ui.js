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

  // Simple 360° frame rotator (graceful fallback if no frames)
  doc.querySelectorAll('[data-immersive]').forEach((wrap) => {
    let frames = [];
    try {
      frames = JSON.parse(wrap.getAttribute('data-frames')) || [];
    } catch (e) {
      frames = [];
    }

    const modelUrl = wrap.getAttribute('data-model');
    const stage = wrap.querySelector('.pdp-immersive__stage');
    const trigger = wrap.querySelector('.pdp-immersive__trigger');

    if (!stage || (!frames.length && !modelUrl)) {
      wrap.classList.add('is-inactive');
      return;
    }

    let current = 0;
    let isDragging = false;
    let startX = 0;

    const renderFrame = () => {
      if (modelUrl) {
        stage.innerHTML = `<div class="pdp-immersive__model">مدل ۳D: ${modelUrl}</div>`;
        return;
      }
      const src = frames[current];
      stage.innerHTML = `<img src="${src}" alt="نمای ۳۶۰ محصول" loading="lazy" />`;
    };

    const dragHandler = (event) => {
      if (!isDragging || !frames.length) return;
      const x = event.type.includes('touch') ? event.touches[0].clientX : event.clientX;
      const delta = x - startX;
      if (Math.abs(delta) > 12) {
        current = (current + (delta > 0 ? 1 : frames.length - 1)) % frames.length;
        startX = x;
        renderFrame();
      }
    };

    const startDrag = (event) => {
      isDragging = true;
      startX = event.type.includes('touch') ? event.touches[0].clientX : event.clientX;
    };

    const endDrag = () => {
      isDragging = false;
    };

    const activate = () => {
      wrap.classList.add('is-active');
      renderFrame();
    };

    if (trigger) {
      trigger.addEventListener('click', activate, { once: true });
    } else {
      activate();
    }

    stage.addEventListener('mousedown', startDrag);
    stage.addEventListener('touchstart', startDrag, { passive: true });
    stage.addEventListener('mousemove', dragHandler);
    stage.addEventListener('touchmove', dragHandler, { passive: true });
    doc.addEventListener('mouseup', endDrag);
    doc.addEventListener('touchend', endDrag);
  });
})();
