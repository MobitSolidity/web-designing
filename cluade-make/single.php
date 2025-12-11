<?php get_header(); ?>

<div class="container">
    <div class="content-area" style="padding: 2rem 0; max-width: 800px; margin: 0 auto;">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="entry-header" style="margin-bottom: 2rem; text-align: center;">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    
                    <div class="entry-meta" style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 1rem;">
                        <span>نویسنده: <?php the_author(); ?></span>
                        <span style="margin: 0 0.5rem;">|</span>
                        <span><?php echo get_the_date('Y/m/d'); ?></span>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail" style="margin-bottom: 2rem;">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-gray-200);">
                    <?php
                    $categories = get_the_category();
                    if ($categories) {
                        echo '<div style="margin-bottom: 1rem;"><strong>دسته‌بندی:</strong> ';
                        foreach ($categories as $category) {
                            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a> ';
                        }
                        echo '</div>';
                    }

                    $tags = get_the_tags();
                    if ($tags) {
                        echo '<div><strong>برچسب‌ها:</strong> ';
                        foreach ($tags as $tag) {
                            echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a> ';
                        }
                        echo '</div>';
                    }
                    ?>
                </footer>
                
            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
            
        <?php endwhile; ?>
        
    </div>
</div>

<?php get_footer(); ?>