<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * This template displays item data in the cart, including gift personalization details.
 * Override of WooCommerce default to show gift info in custom format.
 *
 * @package Giftshop
 * @version 3.0.0 (WooCommerce compatibility)
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get cart item data
$item_data = apply_filters('woocommerce_get_item_data', array(), $cart_item);

if (empty($item_data)) {
    return;
}

// Check if this is a gift item
$is_gift = isset($cart_item['is_gift']) && $cart_item['is_gift'] === 'yes';

if ($is_gift) {
    // Custom display for gift items
    ?>
    <div class="cart-gift-info" style="margin-top: 0.75rem; padding: 1rem; background: var(--color-gray-50); border-radius: var(--radius-md); border-right: 3px solid var(--luxury-accent);">
        
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
            <span style="font-size: 1.25rem;">🎁</span>
            <strong style="color: var(--color-gray-900); font-size: 0.9375rem;">این یک کادو است</strong>
        </div>

        <dl style="margin: 0; font-size: 0.875rem; line-height: 1.8;">
            <?php if (!empty($cart_item['gift_recipient_name'])) : ?>
                <div style="display: grid; grid-template-columns: 80px 1fr; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <dt style="color: var(--color-gray-600); font-weight: 600;">برای:</dt>
                    <dd style="margin: 0; color: var(--color-gray-900);">
                        <?php echo esc_html($cart_item['gift_recipient_name']); ?>
                    </dd>
                </div>
            <?php endif; ?>

            <?php if (!empty($cart_item['gift_card_message'])) : ?>
                <div style="display: grid; grid-template-columns: 80px 1fr; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <dt style="color: var(--color-gray-600); font-weight: 600;">پیام کارت:</dt>
                    <dd style="margin: 0; color: var(--color-gray-900); font-style: italic; background: var(--color-white); padding: 0.5rem; border-radius: var(--radius-sm);">
                        "<?php echo esc_html($cart_item['gift_card_message']); ?>"
                    </dd>
                </div>
            <?php endif; ?>

            <?php if (!empty($cart_item['gift_sender_name'])) : ?>
                <div style="display: grid; grid-template-columns: 80px 1fr; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <dt style="color: var(--color-gray-600); font-weight: 600;">از طرف:</dt>
                    <dd style="margin: 0; color: var(--color-gray-900);">
                        <?php echo esc_html($cart_item['gift_sender_name']); ?>
                    </dd>
                </div>
            <?php endif; ?>

            <?php if (isset($cart_item['hide_price']) && $cart_item['hide_price'] === 'yes') : ?>
                <div style="display: grid; grid-template-columns: 80px 1fr; gap: 0.5rem;">
                    <dt style="color: var(--color-gray-600); font-weight: 600;">قیمت پنهان:</dt>
                    <dd style="margin: 0; color: var(--color-success); font-weight: 600;">
                        ✓ بله
                    </dd>
                </div>
            <?php endif; ?>
        </dl>

        <!-- Optional: Add edit link for gift details -->
        <?php if (apply_filters('giftshop_show_edit_gift_link', false)) : ?>
            <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--color-gray-200);">
                <a href="#" class="edit-gift-details" style="font-size: 0.8125rem; color: var(--luxury-accent); text-decoration: underline;">
                    ویرایش اطلاعات کادو
                </a>
            </div>
        <?php endif; ?>
        
    </div>
    <?php
} else {
    // Default display for non-gift items (standard WooCommerce item data)
    ?>
    <dl class="variation">
        <?php foreach ($item_data as $data) : ?>
            <dt class="variation-<?php echo sanitize_html_class($data['key']); ?>">
                <?php echo wp_kses_post($data['key']); ?>:
            </dt>
            <dd class="variation-<?php echo sanitize_html_class($data['key']); ?>">
                <?php echo wp_kses_post(wpautop($data['display'])); ?>
            </dd>
        <?php endforeach; ?>
    </dl>
    <?php
}