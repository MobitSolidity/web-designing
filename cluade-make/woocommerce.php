<?php
/**
 * WooCommerce Template Wrapper
 * 
 * This template is a wrapper for all WooCommerce pages.
 * WooCommerce will inject its templates into this.
 */

get_header(); ?>

<div class="container">
    <div class="woocommerce-content" style="padding: 2rem 0;">
        <?php woocommerce_content(); ?>
    </div>
</div>

<?php get_footer(); ?>