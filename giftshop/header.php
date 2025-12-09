<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="announcement-bar">ارسال سریع ویژه استان چهارمحال و بختیاری</div>
    <div class="header-inner">
        <div class="header-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></div>
        <nav class="nav-primary" aria-label="منوی اصلی">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => '__return_false',
                'depth'          => 1,
            ) );
            ?>
        </nav>
        <div class="header-cart">
            <a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                <span>سبد خرید</span>
                <span class="cart-count"><?php echo esc_html( giftshop_cart_count() ); ?></span>
            </a>
        </div>
    </div>
</header>
<main class="site-main">
