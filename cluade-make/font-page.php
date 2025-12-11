<?php
/**
 * Front Page Template
 * 
 * @package Giftshop
 */

get_header(); ?>

<!-- Hero Section -->
<?php get_template_part('template-parts/home', 'hero'); ?>

<!-- Value Props -->
<?php get_template_part('template-parts/home', 'value-props'); ?>

<!-- Collections (Luxury & Economic) -->
<?php get_template_part('template-parts/home', 'collections'); ?>

<!-- Bestsellers -->
<?php get_template_part('template-parts/home', 'bestsellers'); ?>

<!-- How It Works -->
<?php get_template_part('template-parts/home', 'how-it-works'); ?>

<?php get_footer(); ?>