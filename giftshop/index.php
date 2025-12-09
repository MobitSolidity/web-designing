<?php get_header(); ?>
<div class="site-content">
<?php if ( have_posts() ) :
    while ( have_posts() ) :
        the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
            <h2 class="section-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile;
else : ?>
    <p>محتوایی یافت نشد.</p>
<?php endif; ?>
</div>
<?php get_footer(); ?>
