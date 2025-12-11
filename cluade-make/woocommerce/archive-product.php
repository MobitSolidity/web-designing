<?php
/**
 * Custom Shop / Archive Template
 * Modern RTL gifting grid with mobile-first filters and sort controls.
 *
 * @package Giftshop
 */

defined('ABSPATH') || exit;

// Simplify the loop header hooks so we can render our own toolbar placement.
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

get_header('shop');
?>

<section class="shop-hero">
    <div class="container">
        <p class="shop-hero__kicker">لحظه‌های هدیه دادن</p>
        <h1 class="shop-hero__title">جعبه‌ها و گل‌های منتخب برای خوشحال کردن عزیزانتان</h1>
        <p class="shop-hero__subtitle">ارسال سریع، بسته‌بندی با سلیقه و پیام شخصی شما کنار هدیه</p>
        <div class="shop-hero__chips" aria-label="دسته‌های محبوب">
            <span class="chip">تولد</span>
            <span class="chip">سالگرد</span>
            <span class="chip">تشکر</span>
            <span class="chip">دوست داشتنی</span>
        </div>
    </div>
</section>

<section class="product-archive" aria-labelledby="shop-title">
    <div class="product-archive__bar" data-sticky-bar>
        <div class="container product-archive__bar-inner">
            <button class="filter-toggle" data-filter-toggle aria-expanded="false">
                <span>فیلتر و مرتب‌سازی</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 5h16M7 12h10M10 19h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
            <form class="sort-select" method="get">
                <label for="orderby">ترتیب:</label>
                <select name="orderby" id="orderby" class="sort-select__input" onchange="this.form.submit()">
                    <?php
                    $orderby_options = array(
                        'menu_order' => 'پیشنهادی',
                        'popularity' => 'پرفروش‌ترین',
                        'date'       => 'جدیدترین',
                        'price'      => 'ارزان‌ترین',
                        'price-desc' => 'گران‌ترین',
                    );
                    $current_orderby = isset($_GET['orderby']) ? wc_clean(wp_unslash($_GET['orderby'])) : apply_filters('woocommerce_default_catalog_orderby', 'menu_order');
                    foreach ($orderby_options as $id => $name) {
                        printf('<option value="%1$s" %2$s>%3$s</option>', esc_attr($id), selected($current_orderby, $id, false), esc_html($name));
                    }
                    ?>
                </select>
                <?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
            </form>
            <div class="product-archive__count">
                <?php woocommerce_result_count(); ?>
            </div>
        </div>
    </div>

    <form class="filter-sheet" data-filter-sheet aria-hidden="true" method="get">
        <div class="filter-sheet__header">
            <div>
                <p class="filter-sheet__eyebrow">شخصی‌سازی نتایج</p>
                <h2 class="filter-sheet__title">چه هدیه‌ای می‌خواهید پیدا کنید؟</h2>
            </div>
            <button class="filter-sheet__close" type="button" data-filter-close aria-label="بستن فیلترها">✕</button>
        </div>
        <div class="filter-sheet__body">
            <div class="filter-group">
                <p class="filter-group__title">مناسبت</p>
                <div class="filter-group__chips">
                    <label><input type="radio" name="occasion" value="birthday"> تولد</label>
                    <label><input type="radio" name="occasion" value="anniversary"> سالگرد</label>
                    <label><input type="radio" name="occasion" value="thankyou"> تشکر</label>
                    <label><input type="radio" name="occasion" value="proposal"> عاشقانه</label>
                </div>
            </div>
            <div class="filter-group">
                <p class="filter-group__title">برای چه کسی؟</p>
                <div class="filter-group__chips">
                    <label><input type="radio" name="recipient" value="her"> برای او</label>
                    <label><input type="radio" name="recipient" value="him"> برای او (آقا)</label>
                    <label><input type="radio" name="recipient" value="friend"> دوست</label>
                    <label><input type="radio" name="recipient" value="parent"> والدین</label>
                </div>
            </div>
            <div class="filter-group">
                <p class="filter-group__title">نوع هدیه</p>
                <div class="filter-group__chips">
                    <label><input type="checkbox" name="type[]" value="box"> باکس هدیه</label>
                    <label><input type="checkbox" name="type[]" value="flower"> گل</label>
                    <label><input type="checkbox" name="type[]" value="sweet"> شیرینی و شکلات</label>
                    <label><input type="checkbox" name="type[]" value="accessory"> اکسسوری</label>
                </div>
            </div>
            <div class="filter-group">
                <p class="filter-group__title">بازه قیمت</p>
                <div class="filter-group__range">
                    <label>از<input type="number" name="min_price" placeholder="۱۵۰٬۰۰۰"></label>
                    <label>تا<input type="number" name="max_price" placeholder="۲٬۰۰۰٬۰۰۰"></label>
                </div>
            </div>
            <div class="filter-group">
                <p class="filter-group__title">ارسال</p>
                <label class="filter-group__toggle">
                    <input type="checkbox" name="fast_delivery" value="yes">
                    <span>فقط نمایش گزینه‌های «ارسال سریع در چهارمحال و بختیاری»</span>
                </label>
            </div>
        </div>
        <div class="filter-sheet__footer">
            <button type="button" class="btn btn--ghost" data-filter-close>انصراف</button>
            <button type="submit" class="btn btn--primary">اعمال فیلتر</button>
        </div>
    </form>

    <div class="container">
        <?php if (woocommerce_product_loop()) : ?>
            <?php do_action('woocommerce_before_shop_loop'); ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                <?php do_action('woocommerce_shop_loop'); ?>
                <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php do_action('woocommerce_after_shop_loop'); ?>
        <?php else : ?>
            <?php do_action('woocommerce_no_products_found'); ?>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer('shop');
