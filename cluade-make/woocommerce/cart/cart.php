<?php
/**
 * Cart Page
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>
<section class="cart" dir="rtl">
    <div class="container">
        <h1 class="section__title">سبد خرید</h1>
        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>

            <table class="shop_table shop_table_responsive cart" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">محصول</th>
                        <th class="product-name">نام</th>
                        <th class="product-price">قیمت</th>
                        <th class="product-quantity">تعداد</th>
                        <th class="product-subtotal">جمع جزء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php do_action('woocommerce_before_cart_contents'); ?>

                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                            <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                                <td class="product-remove">
                                    <?php
                                        echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                            '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">×</a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            esc_html__('Remove this item', 'woocommerce'),
                                            esc_attr($product_id),
                                            esc_attr($_product->get_sku())
                                        ), $cart_item_key);
                                    ?>
                                </td>

                                <td class="product-thumbnail">
                                    <?php
                                    $thumbnail = $_product->get_image('giftshop-product-thumb');
                                    if (!$product_permalink) {
                                        echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    } else {
                                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    }
                                    ?>
                                </td>

                                <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                    <?php
                                    if (!$product_permalink) {
                                        echo wp_kses_post($_product->get_name() . '&nbsp;');
                                    } else {
                                        echo wp_kses_post(sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()));
                                    }

                                    // Personalization summary
                                    if (!empty($cart_item['gift_recipient_name']) || !empty($cart_item['gift_card_message'])) {
                                        echo '<div class="cart-personalization">';
                                        if (!empty($cart_item['gift_recipient_name'])) {
                                            echo '<p><strong>برای:</strong> ' . esc_html($cart_item['gift_recipient_name']) . '</p>';
                                        }
                                        if (!empty($cart_item['gift_occasion'])) {
                                            echo '<p><strong>مناسبت:</strong> ' . esc_html($cart_item['gift_occasion']) . '</p>';
                                        }
                                        if (!empty($cart_item['gift_card_message'])) {
                                            echo '<p class="muted">پیام: ' . esc_html(wp_trim_words($cart_item['gift_card_message'], 16, '…')) . '</p>';
                                        }
                                        echo '</div>';
                                    }

                                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                                    ?>
                                </td>

                                <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                    <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </td>

                                <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                    <?php
                                        if ($_product->is_sold_individually()) {
                                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', esc_attr($cart_item_key));
                                        } else {
                                            $product_quantity = woocommerce_quantity_input(array(
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $_product->get_max_purchase_quantity(),
                                                'min_value'    => '0',
                                                'product_name' => $_product->get_name(),
                                            ), $_product, false);
                                        }

                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    ?>
                                </td>

                                <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                    <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                    <?php do_action('woocommerce_cart_contents'); ?>

                    <tr>
                        <td colspan="6" class="actions">
                            <?php if (wc_coupons_enabled()) { ?>
                                <div class="coupon">
                                    <label for="coupon_code">کد تخفیف:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="کد خود را وارد کنید" />
                                    <button type="submit" class="btn" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">اعمال</button>
                                    <?php do_action('woocommerce_cart_coupon'); ?>
                                </div>
                            <?php } ?>

                            <button type="submit" class="btn" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">به‌روزرسانی</button>

                            <?php do_action('woocommerce_cart_actions'); ?>

                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                        </td>
                    </tr>

                    <?php do_action('woocommerce_after_cart_contents'); ?>
                </tbody>
            </table>
            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>

        <div class="cart-upsell">
            <h3>کادو را کامل‌تر کن</h3>
            <p class="muted">اضافه کنید تا سورپرایز کامل شود.</p>
            <div class="cart-upsell__items">
                <div class="cart-upsell__item">🎈 بادکنک هلیومی</div>
                <div class="cart-upsell__item">🍫 شکلات اضافه</div>
                <div class="cart-upsell__item">💌 کارت تبریک چاپی</div>
            </div>
        </div>

        <div class="cart-collaterals">
            <?php do_action('woocommerce_cart_collaterals'); ?>
        </div>
    </div>
</section>

<?php do_action('woocommerce_after_cart'); ?>
