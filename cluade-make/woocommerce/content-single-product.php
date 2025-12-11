<?php
/**
 * Single product content template
 * Experience-driven PDP with gifting focus.
 *
 * @package Giftshop
 */

defined('ABSPATH') || exit;

global $product;

if (!$product) {
    return;
}

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}

// Remove default sale badge to avoid duplicate badge stack.
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

$product_id         = $product->get_id();
$shipping_slug      = $product->get_shipping_class();
$has_fast_delivery  = ($shipping_slug && strpos($shipping_slug, 'fast') !== false)
    || has_term('fast-delivery', 'product_tag', $product_id)
    || get_post_meta($product_id, '_giftshop_fast_delivery', true) === 'yes';
$is_luxury          = has_term('luxury', 'product_cat', $product_id);
$is_economic        = has_term('economic', 'product_cat', $product_id) || has_term('budget-friendly', 'product_cat', $product_id);
$tagline            = has_excerpt($product_id) ? wp_trim_words(get_the_excerpt(), 24, '…') : 'باکسی از احساسات خوب برای کسی که دوستش دارید';
?>

<article id="product-<?php the_ID(); ?>" <?php wc_product_class('pdp', $product); ?>>
    <div class="container">
        <div class="pdp__breadcrumbs"><?php woocommerce_breadcrumb(); ?></div>

        <div class="pdp__layout">
            <div class="pdp__gallery-block">
                <div class="pdp__media">
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
            </div>

            <div class="pdp__summary">
                <div class="pdp__eyebrow">
                    <?php if ($is_luxury) : ?><span class="badge badge--luxury">لاکچری</span><?php endif; ?>
                    <?php if ($is_economic) : ?><span class="badge badge--economic">اقتصادی و به‌صرفه</span><?php endif; ?>
                </div>
                <h1 class="pdp__title"><?php the_title(); ?></h1>
                <p class="pdp__subtitle"><?php echo esc_html($tagline); ?></p>

                <div class="pdp__pricing">
                    <?php woocommerce_template_single_rating(); ?>
                    <?php woocommerce_template_single_price(); ?>
                </div>

                <div class="pdp__shipping" role="note">
                    <?php if ($has_fast_delivery) : ?>
                        <span class="pdp__shipping-icon">⚡️</span>
                        <div>
                            <p class="pdp__shipping-title">ارسال سریع در چهارمحال و بختیاری</p>
                            <p class="pdp__shipping-desc">سفارشات استان چهارمحال و بختیاری در همان روز یا روز بعد تحویل می‌شوند.</p>
                        </div>
                    <?php else : ?>
                        <span class="pdp__shipping-icon">🚚</span>
                        <div>
                            <p class="pdp__shipping-title">تحویل ۲ تا ۴ روز کاری</p>
                            <p class="pdp__shipping-desc">سفارشات سایر استان‌ها با بسته‌بندی امن و کارت تبریک دلخواه شما ارسال می‌شوند.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="pdp-purchase" id="pdp-add-to-cart">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                    <div class="pdp-purchase__assure">
                        <span>بسته‌بندی مخصوص هدیه + کارت پیام شما</span>
                        <span>امکان پنهان کردن قیمت برای گیرنده</span>
                        <span>بازگشت وجه در صورت آسیب ارسال</span>
                    </div>
                </div>

                <section class="pdp-section">
                    <h3 class="pdp-section__title">در این باکس چه چیزهایی هست؟</h3>
                    <ul class="pdp-section__list">
                        <?php
                        $attributes = $product->get_attributes();
                        if (!empty($attributes)) {
                            foreach ($attributes as $attribute) {
                                if ($attribute->is_taxonomy()) {
                                    $terms = wp_get_post_terms($product_id, $attribute->get_name(), array('fields' => 'names'));
                                    if (!empty($terms)) {
                                        printf('<li>%s: %s</li>', wc_attribute_label($attribute->get_name()), esc_html(implode('، ', $terms)));
                                    }
                                } else {
                                    printf('<li>%s: %s</li>', wc_attribute_label($attribute->get_name()), esc_html($attribute->get_options()[0] ?? ''));
                                }
                            }
                        } else {
                            echo '<li>ترکیبی از گل تازه، خوراکی باکیفیت و یادگاری ماندگار.</li>';
                        }
                        ?>
                    </ul>
                </section>

                <section class="pdp-section">
                    <h3 class="pdp-section__title">کیفیت و جزئیات</h3>
                    <p class="pdp-section__text">تمام اقلام از برندهای معتبر ایرانی انتخاب شده‌اند و بسته‌بندی، مهر و موم شده همراه با روبان و کارت تبریک اختصاصی شما انجام می‌شود.</p>
                </section>

                <section class="pdp-section">
                    <h3 class="pdp-section__title">توضیحات کامل</h3>
                    <div class="pdp-section__text">
                        <?php the_content(); ?>
                    </div>
                </section>

                <section class="pdp-section">
                    <h3 class="pdp-section__title">نظرات و تجربه خریداران</h3>
                    <?php comments_template(); ?>
                </section>
            </div>
        </div>
    </div>

    <?php do_action('woocommerce_after_single_product_summary'); ?>
</article>

<section class="pdp-related">
    <div class="container">
        <div class="pdp-related__header">
            <div>
                <p class="pdp-related__eyebrow">پیشنهادهای تکمیلی</p>
                <h2 class="pdp-related__title">این هدیه‌ها را هم دوست خواهید داشت</h2>
            </div>
            <p class="pdp-related__hint">برای تکمیل سورپرایز، یک باکس شکلات یا گل همراه کنید.</p>
        </div>
        <?php woocommerce_output_related_products(); ?>
    </div>
</section>

<div class="pdp-sticky" data-sticky-cart>
    <div class="pdp-sticky__price"><?php echo $product->get_price_html(); ?></div>
    <button type="button" class="pdp-sticky__cta" data-scroll-to="#pdp-add-to-cart">افزودن به سبد خرید</button>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
