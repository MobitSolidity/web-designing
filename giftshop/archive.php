<?php get_header(); ?>
<div class="site-content">
    <header class="section">
        <h1 class="section-title"><?php the_archive_title(); ?></h1>
        <?php if ( get_the_archive_description() ) : ?>
            <div class="archive-description"><?php the_archive_description(); ?></div>
        <?php endif; ?>
    </header>

    <?php if ( have_posts() ) :
        while ( have_posts() ) :
            the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
                <h2 class="section-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile;
        the_posts_navigation();
    else : ?>
        <p>موردی یافت نشد.</p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
