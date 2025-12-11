<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link sr-only" href="#primary">پرش به محتوا</a>

    <header class="site-header">
        <!-- Announcement Bar -->
        <div class="announcement-bar">
            <div class="container">
                <p>
                    ⚡ ارسال سریع ویژه استان چهارمحال و بختیاری | 
                    <a href="<?php echo esc_url(home_url('/product-category/luxury/')); ?>">مشاهده باکس‌های لاکچری</a>
                </p>
            </div>
        </div>

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <div class="header-inner">
                    <!-- Logo -->
                    <div class="site-branding">
                        <?php if (has_custom_logo()) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Header Actions -->
                    <div class="header-actions">
                        <!-- Search Icon -->
                        <a href="#" class="header-icon" aria-label="جستجو">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                        </a>

                        <!-- Account Icon -->
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="header-icon" aria-label="حساب کاربری">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </a>

                        <!-- Cart Icon with Count -->
                        <?php if (function_exists('WC')) : ?>
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="header-icon" aria-label="سبد خرید">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="9" cy="21" r="1"/>
                                    <circle cx="20" cy="21" r="1"/>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                </svg>
                                <?php 
                                $cart_count = giftshop_cart_count();
                                if ($cart_count > 0) : 
                                ?>
                                    <span class="cart-count"><?php echo esc_html($cart_count); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Primary Navigation -->
        <nav class="primary-nav" aria-label="Primary Navigation">
            <div class="container">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
            </div>
        </nav>
    </header>

    <main id="primary" class="site-content">