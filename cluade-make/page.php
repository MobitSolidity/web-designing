<?php get_header(); ?>

<div class="container">
    <div class="content-area" style="padding: 2rem 0;">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="entry-header" style="margin-bottom: 2rem;">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail" style="margin-bottom: 2rem;">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">صفحات: ',
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
                
            </article>
            
        <?php endwhile; ?>
        
    </div>
</div>

<?php get_footer(); ?>