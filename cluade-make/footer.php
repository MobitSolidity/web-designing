</main><!-- #primary -->

<footer class="site-footer" dir="rtl">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-section">
                <h4>فروشگاه</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/shop/')); ?>">همه محصولات</a></li>
                    <li><a href="<?php echo esc_url(add_query_arg('gift_line', 'economic', home_url('/shop/'))); ?>">کادوهای اقتصادی</a></li>
                    <li><a href="<?php echo esc_url(add_query_arg('gift_line', 'signature', home_url('/shop/'))); ?>">کالکشن‌های امضایی</a></li>
                    <li><a href="<?php echo esc_url(home_url('/gift-finder/')); ?>">راهنمای انتخاب کادو</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>پشتیبانی مشتریان</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">سؤالات متداول</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shipping/')); ?>">شیوه‌های ارسال</a></li>
                    <li><a href="<?php echo esc_url(home_url('/returns/')); ?>">مرجوعی و بازگشت</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>درباره ما</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">داستان ما</a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">مجله کادو</a></li>
                    <li><a href="<?php echo esc_url(home_url('/corporate-gifts/')); ?>">هدایای شرکتی</a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">شرایط و قوانین</a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">حریم خصوصی</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>اطلاعات تماس</h4>
                <p class="footer-meta">
                    شهرکرد، استان چهارمحال و بختیاری<br>
                    تلفن: ۰۳۸-۱۲۳۴۵۶۷۸<br>
                    ایمیل: info@giftshop.ir
                </p>
                <div class="trust-badges">
                    <div class="badge-placeholder">eNamad</div>
                    <div class="badge-placeholder">پرداخت امن</div>
                    <div class="badge-placeholder">حمایت از حقوق مصرف‌کننده</div>
                </div>
                <h4 class="footer-subheading">ما را دنبال کنید</h4>
                <div class="social-links">
                    <a href="https://instagram.com/" class="social-icon" aria-label="Instagram" target="_blank" rel="noopener">IG</a>
                    <a href="https://t.me/" class="social-icon" aria-label="Telegram" target="_blank" rel="noopener">TG</a>
                    <a href="https://wa.me/" class="social-icon" aria-label="WhatsApp" target="_blank" rel="noopener">WA</a>
                    <a href="https://aparat.com/" class="social-icon" aria-label="Aparat" target="_blank" rel="noopener">AP</a>
                </div>
            </div>
        </div>
        <p class="footer-credit">ارسال سریع برای چهارمحال و بختیاری | سایر استان‌ها ۲ تا ۴ روز کاری</p>
    </div>
</footer>

<?php get_template_part('template-parts/ai-assistant'); ?>
</div><!-- #page -->
<?php wp_footer(); ?>
