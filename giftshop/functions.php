<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function giftshop_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'giftshop' ),
        'footer'  => __( 'Footer Menu', 'giftshop' ),
    ) );
}
add_action( 'after_setup_theme', 'giftshop_theme_setup' );

function giftshop_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );
    wp_enqueue_style( 'giftshop-style', get_stylesheet_uri(), array(), $theme_version );
    // Placeholder for Persian fonts; replace with self-hosted font files in production.
    wp_enqueue_style( 'giftshop-fonts', 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600;700&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'giftshop_scripts' );

function giftshop_cart_count() {
    if ( function_exists( 'WC' ) && WC()->cart ) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}
