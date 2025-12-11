(function ($) {
  const doc = document;

  // Floating AI assistant toggle
  const aiButton = doc.querySelector('[data-ai-toggle]');
  const aiPanel = doc.querySelector('[data-ai-panel]');
  if (aiButton && aiPanel) {
    aiButton.addEventListener('click', () => {
      const isOpen = aiPanel.classList.toggle('is-open');
      aiButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  // Gift Finder wizard
  const wizard = doc.querySelector('[data-gift-finder]');
  if (wizard) {
    const steps = Array.from(wizard.querySelectorAll('[data-step]'));
    let current = 0;

    const showStep = (index) => {
      steps.forEach((step, i) => step.classList.toggle('is-active', i === index));
      wizard.querySelector('[data-step-indicator]').textContent = `${index + 1}/${steps.length}`;
    };

    wizard.querySelectorAll('[data-next]').forEach((btn) => {
      btn.addEventListener('click', () => {
        current = Math.min(current + 1, steps.length - 1);
        showStep(current);
      });
    });

    wizard.querySelectorAll('[data-prev]').forEach((btn) => {
      btn.addEventListener('click', () => {
        current = Math.max(current - 1, 0);
        showStep(current);
      });
    });

    showStep(current);
  }

  // Placeholder AI call
  window.callGiftAssistant = function (message, context) {
    console.log('AI stub called with: ', message, context);
    return {
      status: 'stub',
      reply: 'برای راهنمایی سریع روی «کمکم کن کادو انتخاب کنم» کلیک کنید.',
    };
  };
})(jQuery);
