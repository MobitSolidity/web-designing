<?php
/**
 * Giftshop Theme Functions
 * 
 * @package Giftshop
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function giftshop_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');
    
    // Let WordPress manage the document title
    add_theme_support('title-tag');
    
    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    
    // Set post thumbnail size
    set_post_thumbnail_size(600, 600, true);
    
    // Add additional image sizes
    add_image_size('giftshop-product-thumb', 300, 300, true);
    add_image_size('giftshop-hero', 1200, 600, true);
    
    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));
    
    // Add support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'giftshop'),
        'footer'  => __('Footer Menu', 'giftshop'),
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'giftshop_setup');

/**
 * Set content width
 */
function giftshop_content_width() {
    $GLOBALS['content_width'] = apply_filters('giftshop_content_width', 1200);
}
add_action('after_setup_theme', 'giftshop_content_width', 0);

/**
 * Enqueue scripts and styles
 */
function giftshop_scripts() {
    // Main stylesheet
    wp_enqueue_style('giftshop-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Persian font from CDN
    wp_enqueue_style(
        'vazirmatn-font',
        'https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css',
        array(),
        null
    );
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'giftshop_scripts');

/**
 * Get cart item count for header
 */
function giftshop_cart_count() {
    if (function_exists('WC')) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}

/**
 * Format price in Toman with thousands separator
 */
function giftshop_format_toman($price) {
    // Convert from Rial to Toman (divide by 10)
    $toman = $price / 10;
    
    // Format with Persian/Arabic numerals and thousands separator
    $formatted = number_format($toman, 0, '.', ',');
    
    // Convert to Persian numerals
    $persian_numerals = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $english_numerals = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    
    $formatted = str_replace($english_numerals, $persian_numerals, $formatted);
    
    return $formatted . ' تومان';
}

/**
 * Override WooCommerce price display format
 */
add_filter('woocommerce_price_format', function() {
    return '%2$s %1$s'; // Symbol after price for RTL
});

/* ============================================================================
   GIFT PERSONALIZATION FUNCTIONALITY
   ============================================================================ */

/**
 * Add gift personalization fields to product page
 */
function giftshop_add_gift_fields() {
    ?>
    <div class="gift-personalization">
        <h3>
            <span>🎁</span>
            <span>گزینه‌های شخصی‌سازی کادو</span>
        </h3>
        
        <?php wp_nonce_field('giftshop_gift_fields', 'giftshop_gift_nonce'); ?>
        
        <div class="gift-field">
            <label>
                <input type="checkbox" name="is_gift" id="is_gift" value="yes" checked>
                این محصول یک کادو است
            </label>
        </div>
        
        <div class="gift-field">
            <label for="gift_recipient_name">نام گیرنده کادو</label>
            <input 
                type="text" 
                name="gift_recipient_name" 
                id="gift_recipient_name" 
                placeholder="مثال: مریم"
                maxlength="50"
            >
        </div>
        
        <div class="gift-field">
            <label for="gift_card_message">متن کارت تبریک (حداکثر ۲۰۰ کاراکتر)</label>
            <textarea 
                name="gift_card_message" 
                id="gift_card_message" 
                placeholder="پیام شما برای گیرنده کادو..."
                maxlength="200"
                rows="4"
            ></textarea>
            <div class="char-counter">
                <span id="char-count">0</span> / 200 کاراکتر
            </div>
        </div>
        
        <div class="gift-field">
            <label for="gift_sender_name">امضای فرستنده</label>
            <input 
                type="text" 
                name="gift_sender_name" 
                id="gift_sender_name" 
                placeholder="مثال: علی و سارا"
                maxlength="50"
            >
        </div>
        
        <div class="gift-field">
            <label>
                <input type="checkbox" name="hide_price" id="hide_price" value="yes">
                قیمت برای گیرنده نمایش داده نشود
            </label>
        </div>
    </div>
    
    <script>
    (function() {
        var textarea = document.getElementById('gift_card_message');
        var counter = document.getElementById('char-count');
        
        if (textarea && counter) {
            textarea.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }
    })();
    </script>
    <?php
}
add_action('woocommerce_before_add_to_cart_button', 'giftshop_add_gift_fields');

/**
 * Validate gift fields before adding to cart
 */
function giftshop_validate_gift_fields($passed, $product_id, $quantity) {
    // Verify nonce
    if (!isset($_POST['giftshop_gift_nonce']) || 
        !wp_verify_nonce($_POST['giftshop_gift_nonce'], 'giftshop_gift_fields')) {
        return $passed;
    }
    
    // If it's marked as a gift, validate fields
    if (isset($_POST['is_gift']) && $_POST['is_gift'] === 'yes') {
        if (isset($_POST['gift_recipient_name']) && 
            strlen($_POST['gift_recipient_name']) > 50) {
            wc_add_notice('نام گیرنده نباید بیشتر از ۵۰ کاراکتر باشد', 'error');
            $passed = false;
        }
        
        if (isset($_POST['gift_card_message']) && 
            strlen($_POST['gift_card_message']) > 200) {
            wc_add_notice('متن کارت تبریک نباید بیشتر از ۲۰۰ کاراکتر باشد', 'error');
            $passed = false;
        }
        
        if (isset($_POST['gift_sender_name']) && 
            strlen($_POST['gift_sender_name']) > 50) {
            wc_add_notice('امضای فرستنده نباید بیشتر از ۵۰ کاراکتر باشد', 'error');
            $passed = false;
        }
    }
    
    return $passed;
}
add_filter('woocommerce_add_to_cart_validation', 'giftshop_validate_gift_fields', 10, 3);

/**
 * Save gift fields to cart item data
 */
function giftshop_add_gift_data_to_cart($cart_item_data, $product_id) {
    // Verify nonce
    if (!isset($_POST['giftshop_gift_nonce']) || 
        !wp_verify_nonce($_POST['giftshop_gift_nonce'], 'giftshop_gift_fields')) {
        return $cart_item_data;
    }
    
    if (isset($_POST['is_gift']) && $_POST['is_gift'] === 'yes') {
        $cart_item_data['is_gift'] = 'yes';
        
        if (!empty($_POST['gift_recipient_name'])) {
            $cart_item_data['gift_recipient_name'] = sanitize_text_field($_POST['gift_recipient_name']);
        }
        
        if (!empty($_POST['gift_card_message'])) {
            $cart_item_data['gift_card_message'] = sanitize_textarea_field($_POST['gift_card_message']);
        }
        
        if (!empty($_POST['gift_sender_name'])) {
            $cart_item_data['gift_sender_name'] = sanitize_text_field($_POST['gift_sender_name']);
        }
        
        if (isset($_POST['hide_price']) && $_POST['hide_price'] === 'yes') {
            $cart_item_data['hide_price'] = 'yes';
        }
    }
    
    return $cart_item_data;
}
add_filter('woocommerce_add_cart_item_data', 'giftshop_add_gift_data_to_cart', 10, 2);

/**
 * Display gift data in cart (fallback method - template override takes precedence)
 */
function giftshop_display_gift_data_in_cart($item_data, $cart_item) {
    if (isset($cart_item['is_gift']) && $cart_item['is_gift'] === 'yes') {
        $item_data[] = array(
            'name'  => '🎁 این محصول یک کادو است',
            'value' => '',
        );
        
        if (!empty($cart_item['gift_recipient_name'])) {
            $item_data[] = array(
                'name'  => 'برای',
                'value' => esc_html($cart_item['gift_recipient_name']),
            );
        }
        
        if (!empty($cart_item['gift_card_message'])) {
            $item_data[] = array(
                'name'  => 'پیام کارت',
                'value' => esc_html($cart_item['gift_card_message']),
            );
        }
        
        if (!empty($cart_item['gift_sender_name'])) {
            $item_data[] = array(
                'name'  => 'از طرف',
                'value' => esc_html($cart_item['gift_sender_name']),
            );
        }
        
        if (isset($cart_item['hide_price']) && $cart_item['hide_price'] === 'yes') {
            $item_data[] = array(
                'name'  => 'قیمت پنهان',
                'value' => 'بله',
            );
        }
    }
    
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'giftshop_display_gift_data_in_cart', 10, 2);

/**
 * Save gift data to order item meta
 */
function giftshop_add_gift_data_to_order($item, $cart_item_key, $values, $order) {
    if (isset($values['is_gift']) && $values['is_gift'] === 'yes') {
        $item->add_meta_data('_is_gift', 'yes', true);
        
        if (!empty($values['gift_recipient_name'])) {
            $item->add_meta_data('نام گیرنده', $values['gift_recipient_name'], true);
        }
        
        if (!empty($values['gift_card_message'])) {
            $item->add_meta_data('پیام کارت', $values['gift_card_message'], true);
        }
        
        if (!empty($values['gift_sender_name'])) {
            $item->add_meta_data('از طرف', $values['gift_sender_name'], true);
        }
        
        if (isset($values['hide_price']) && $values['hide_price'] === 'yes') {
            $item->add_meta_data('قیمت پنهان', 'بله', true);
        }
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'giftshop_add_gift_data_to_order', 10, 4);

/* ============================================================================
   PRODUCT LINE HELPERS (LUXURY VS ECONOMIC)
   ============================================================================ */

/**
 * Helper function to check if product is in luxury category
 */
function giftshop_is_luxury_product($product_id) {
    return has_term('luxury', 'product_cat', $product_id);
}

/**
 * Helper function to check if product is in economic category
 */
function giftshop_is_economic_product($product_id) {
    return has_term('economic', 'product_cat', $product_id);
}

/**
 * Get product line class based on categories
 */
function giftshop_get_product_line_class($product_id) {
    if (giftshop_is_luxury_product($product_id)) {
        return 'product-line--luxury';
    } elseif (giftshop_is_economic_product($product_id)) {
        return 'product-line--economic';
    }
    return '';
}

/**
 * Get product line badge
 */
function giftshop_get_product_line_badge($product_id) {
    if (giftshop_is_luxury_product($product_id)) {
        return '<span class="product-badge badge-luxury">لاکچری</span>';
    } elseif (giftshop_is_economic_product($product_id)) {
        return '<span class="product-badge badge-economic">اقتصادی</span>';
    }
    return '';
}

/* ============================================================================
   WOOCOMMERCE CUSTOMIZATIONS
   ============================================================================ */

/**
 * Add custom fields to checkout for Iranian address
 */
function giftshop_custom_checkout_fields($fields) {
    // Customize billing fields for Iranian addresses
    $fields['billing']['billing_state']['label'] = 'استان';
    $fields['billing']['billing_state']['placeholder'] = 'انتخاب استان';
    
    $fields['billing']['billing_city']['label'] = 'شهر';
    $fields['billing']['billing_city']['placeholder'] = 'نام شهر';
    
    $fields['billing']['billing_address_1']['label'] = 'آدرس کامل (خیابان، کوچه، پلاک)';
    $fields['billing']['billing_address_1']['placeholder'] = 'مثال: خیابان ولیعصر، کوچه ۱۵، پلاک ۲۳';
    
    $fields['billing']['billing_address_2']['label'] = 'واحد / طبقه';
    $fields['billing']['billing_address_2']['placeholder'] = 'مثال: طبقه ۳، واحد ۵';
    
    $fields['billing']['billing_postcode']['label'] = 'کد پستی (۱۰ رقمی)';
    $fields['billing']['billing_postcode']['placeholder'] = '۱۲۳۴۵۶۷۸۹۰';
    
    // Customize shipping fields
    if (isset($fields['shipping'])) {
        $fields['shipping']['shipping_state']['label'] = 'استان';
        $fields['shipping']['shipping_city']['label'] = 'شهر';
        $fields['shipping']['shipping_address_1']['label'] = 'آدرس کامل';
        $fields['shipping']['shipping_address_2']['label'] = 'واحد / طبقه';
        $fields['shipping']['shipping_postcode']['label'] = 'کد پستی';
    }
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'giftshop_custom_checkout_fields');

/**
 * Remove WooCommerce default styles (we use custom CSS)
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Modify products per page
 */
function giftshop_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'giftshop_products_per_page', 20);

/**
 * Add custom body classes based on product categories
 */
function giftshop_body_classes($classes) {
    if (is_product()) {
        global $post;
        $product_id = $post->ID;
        
        if (giftshop_is_luxury_product($product_id)) {
            $classes[] = 'product-luxury';
        } elseif (giftshop_is_economic_product($product_id)) {
            $classes[] = 'product-economic';
        }
    }
    
    if (is_product_category()) {
        $current_cat = get_queried_object();
        if ($current_cat && $current_cat->slug === 'luxury') {
            $classes[] = 'category-luxury';
        } elseif ($current_cat && $current_cat->slug === 'economic') {
            $classes[] = 'category-economic';
        }
    }
    
    return $classes;
}
add_filter('body_class', 'giftshop_body_classes');

/**
 * Customize WooCommerce breadcrumbs for RTL
 */
function giftshop_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' &larr; ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => 'خانه',
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'giftshop_woocommerce_breadcrumbs');

/**
 * Change "Add to Cart" button text
 */
function giftshop_custom_cart_button_text() {
    return 'افزودن به سبد خرید';
}
add_filter('woocommerce_product_single_add_to_cart_text', 'giftshop_custom_cart_button_text');
add_filter('woocommerce_product_add_to_cart_text', 'giftshop_custom_cart_button_text');

/**
 * Customize sale badge text
 */
function giftshop_custom_sale_badge($html, $post, $product) {
    return '<span class="onsale">تخفیف!</span>';
}
add_filter('woocommerce_sale_flash', 'giftshop_custom_sale_badge', 10, 3);

/**
 * Add wishlist icon placeholder (for future implementation)
 */
function giftshop_add_wishlist_button() {
    // Placeholder for wishlist functionality
    // Can be integrated with YITH Wishlist or custom solution
    echo '<div class="product-wishlist-placeholder"></div>';
}
// add_action('woocommerce_after_add_to_cart_button', 'giftshop_add_wishlist_button');