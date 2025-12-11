<div class="ai-assistant" dir="rtl">
    <button class="ai-assistant__toggle" data-ai-toggle aria-expanded="false">
        🤖 <span>دستیار انتخاب کادو</span>
    </button>
    <div class="ai-assistant__panel" data-ai-panel>
        <div class="ai-assistant__header">
            <div>
                <p class="ai-assistant__eyebrow">نسخه آزمایشی</p>
                <h3 class="ai-assistant__title">دستیار هوشمند کادو</h3>
                <p class="ai-assistant__subtitle">به زودی با هوش مصنوعی پاسخ می‌دهد. فعلاً می‌توانید راهنمای انتخاب کادو را باز کنید.</p>
            </div>
            <button class="ai-assistant__close" type="button" data-ai-toggle aria-label="بستن">✕</button>
        </div>
        <div class="ai-assistant__actions">
            <a class="btn btn--primary" href="<?php echo esc_url(site_url('/gift-finder/')); ?>">کمکم کن کادو انتخاب کنم</a>
            <a class="btn btn--ghost" href="<?php echo esc_url(site_url('/contact/')); ?>">سوال پشتیبانی دارم</a>
        </div>
        <div class="ai-assistant__hint">تابع callGiftAssistant(message, context) برای اتصال آینده به AI آماده است.</div>
    </div>
</div>
