<?php
/**
 * Product loop card
 * Custom grid card tuned for gifting context.
 *
 * @package Giftshop
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

$product_id    = $product->get_id();
$shipping_slug = $product->get_shipping_class();
$has_fast_delivery = ($shipping_slug && strpos($shipping_slug, 'fast') !== false)
    || has_term('fast-delivery', 'product_tag', $product_id)
    || get_post_meta($product_id, '_giftshop_fast_delivery', true) === 'yes';

$is_luxury   = giftshop_is_luxury_product($product_id);
$is_economic = giftshop_is_economic_product($product_id);
$is_new      = (time() - get_post_time('U', true, $product_id)) < 30 * DAY_IN_SECONDS;
$is_bestseller = (int) $product->get_total_sales() >= 10;
$is_sale     = $product->is_on_sale();

$tagline_meta = get_post_meta($product_id, 'giftshop_tagline', true);
$tagline = $tagline_meta ? $tagline_meta : (has_excerpt($product_id) ? wp_trim_words(get_the_excerpt(), 16, '…') : 'کادوی مناسب برای لحظات خاص زندگی');
$delivery_text = $has_fast_delivery ? 'ارسال سریع در چهارمحال و بختیاری' : 'اگر مقصد خارج از چهارمحال و بختیاری باشد: تحویل ۲–۴ روز کاری';
?>

<li <?php wc_product_class('gift-card', $product); ?>>
    <a class="gift-card__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
        <div class="gift-card__image-wrap">
            <?php echo woocommerce_get_product_thumbnail('giftshop-product-thumb'); ?>
            <div class="gift-card__badges">
                <?php if ($is_luxury) : ?><span class="badge badge--luxury">لاکچری</span><?php endif; ?>
                <?php if ($is_economic) : ?><span class="badge badge--economic">اقتصادی</span><?php endif; ?>
                <?php if ($is_bestseller) : ?><span class="badge badge--bestseller">پرفروش</span><?php endif; ?>
                <?php if ($is_new) : ?><span class="badge badge--new">جدید</span><?php endif; ?>
                <?php if ($is_sale) : ?><span class="badge badge--sale">تخفیف</span><?php endif; ?>
            </div>
        </div>
    </a>
    <div class="gift-card__body">
        <a href="<?php the_permalink(); ?>" class="gift-card__title-link">
            <h3 class="gift-card__title"><?php the_title(); ?></h3>
            <p class="gift-card__tagline"><?php echo esc_html($tagline); ?></p>
        </a>
        <div class="gift-card__price-row">
            <div class="gift-card__price"><?php echo $product->get_price_html(); ?></div>
            <?php if ($product->is_type('simple')) : ?>
                <span class="gift-card__delivery"><?php echo esc_html($delivery_text); ?></span>
            <?php endif; ?>
        </div>
        <div class="gift-card__footer">
            <span class="gift-card__cta">مشاهده و خرید</span>
            <?php woocommerce_template_loop_add_to_cart(array('class' => 'button gift-card__mini-cart')); ?>
        </div>
    </div>
</li>
