(function () {
  const root = document.querySelector('[data-assistant]');
  if (!root) return;

  const panel = root.querySelector('.assistant__panel');
  const closeBtn = root.querySelector('[data-assistant-close]');
  const messages = root.querySelector('[data-assistant-messages]');
  const input = root.querySelector('[data-assistant-input]');
  const sendBtn = root.querySelector('[data-assistant-send]');
  const quickBtns = root.querySelectorAll('[data-assistant-action]');
  const bubble = root.querySelector('[data-assistant-toggle]');

  const catalog = [
    { title: 'باکس ولنتاین رز مخملی', price: '۲٬۴۵۰٬۰۰۰ تومان', tag: 'رمانتیک', link: 'product.html', img: 'assets/img/box1.jpg' },
    { title: 'باکس شکلات و ماگ', price: '۴۹۰٬۰۰۰ تومان', tag: 'دوستانه', link: 'product.html', img: 'assets/img/box2.jpg' },
    { title: 'باکس گل و شمع', price: '۱٬۳۵۰٬۰۰۰ تومان', tag: 'سالگرد', link: 'product.html', img: 'assets/img/box3.jpg' },
    { title: 'باکس چای و شیرینی', price: '۶۵۰٬۰۰۰ تومان', tag: 'خانوادگی', link: 'product.html', img: 'assets/img/box6.jpg' },
  ];

  const appendMessage = (type, text) => {
    const msg = document.createElement('div');
    msg.className = `assistant__msg assistant__msg--${type}`;
    msg.textContent = text;
    messages.appendChild(msg);
    messages.scrollTop = messages.scrollHeight;
  };

  const suggestProducts = (context = '') => {
    const picks = catalog.slice(0, 3).map(item => `• ${item.title} – ${item.price}`);
    appendMessage('bot', `بر اساس گفته‌هایت، این‌ها رو پیشنهاد می‌کنم:\n${picks.join('\n')}`);
  };

  const handleSupport = (text) => {
    if (/ارسال|تحویل/.test(text)) {
      appendMessage('bot', 'ارسال شهرکرد و چهارمحال و بختیاری عموماً همان روز یا فرداست. سایر استان‌ها ۲–۴ روز کاری.');
      appendMessage('bot', 'هزینه ارسال بر اساس شهر مقصد محاسبه می‌شود و در مرحله پرداخت دیده می‌شود.');
    } else if (/پرداخت|بانکی|کارت/.test(text)) {
      appendMessage('bot', 'پرداخت امن از طریق درگاه‌های بانکی شتاب و کارت به کارت امکان‌پذیر است.');
    } else if (/پیگیری|سفارش|وضعیت/.test(text)) {
      appendMessage('bot', 'برای پیگیری سفارش، شماره سفارش یا موبایل را در صفحه پیگیری وارد کنید یا با پشتیبانی واتساپ تماس بگیرید.');
    } else {
      appendMessage('bot', 'سؤال پشتیبانی‌ات را کامل‌تر بگو تا راهنمایی کنم. موضوع: ارسال، پرداخت، پیگیری، یا لغو؟');
    }
  };

  const handleGiftFlow = (text) => {
    if (/تولد|سالگرد|ولنتاین|یلدا/.test(text)) {
      appendMessage('bot', 'عالیه! بودجه و جنسیت/سن حدودی گیرنده رو هم بگو تا دقیق‌تر پیشنهاد بدم.');
    } else if (/بودجه|تومان|میلیون|هزار/.test(text)) {
      appendMessage('bot', 'متوجه بودجه شدم. اگر نوع رابطه یا شهر مقصد رو بگی می‌تونم ارسال سریع رو لحاظ کنم.');
      suggestProducts(text);
    } else {
      appendMessage('bot', 'برای شروع بگو مناسبت و رابطه با گیرنده چیه (دوست، همسر، همکار...)');
    }
  };

  const sendUserMessage = (text) => {
    const clean = text.trim();
    if (!clean) return;
    appendMessage('user', clean);
    input.value = '';
    setTimeout(() => {
      if (/پشتیبانی/.test(clean)) {
        handleSupport(clean);
      } else if (/ارسال|پرداخت|لغو|بازگشت|پیگیری/.test(clean)) {
        handleSupport(clean);
      } else {
        handleGiftFlow(clean);
      }
    }, 250);
  };

  const togglePanel = () => {
    root.classList.toggle('is-open');
    if (root.classList.contains('is-open')) {
      panel.focus?.();
    }
  };

  root.addEventListener('assistant:toggle', togglePanel);
  bubble && bubble.addEventListener('keypress', (e) => { if (e.key === 'Enter') togglePanel(); });
  closeBtn && closeBtn.addEventListener('click', togglePanel);
  sendBtn && sendBtn.addEventListener('click', () => sendUserMessage(input.value));
  input && input.addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); sendUserMessage(input.value); } });

  quickBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const action = btn.getAttribute('data-assistant-action');
      if (action === 'gift') {
        appendMessage('bot', 'بگو برای چه مناسبت و چه کسی هدیه می‌خوای + بودجه تقریبی.');
      } else {
        appendMessage('bot', 'سؤالت در مورد ارسال، پرداخت، یا پیگیری سفارش رو بنویس.');
      }
    });
  });
})();
