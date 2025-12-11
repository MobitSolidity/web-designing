<?php get_header(); ?>

<div class="container">
    <div class="content-area" style="padding: 2rem 0;">
        
        <header class="archive-header" style="margin-bottom: 2rem; text-align: center;">
            <?php
            the_archive_title('<h1 class="archive-title">', '</h1>');
            the_archive_description('<div class="archive-description" style="color: var(--color-gray-600); margin-top: 1rem;">', '</div>');
            ?>
        </header>

        <?php if (have_posts()) : ?>
            
            <div class="posts-grid" style="display: grid; gap: 2rem; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background: var(--color-gray-50); border-radius: var(--radius-lg); overflow: hidden;">
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 200px; object-fit: cover;')); ?>
                            </a>
                        <?php endif; ?>

                        <div style="padding: 1.5rem;">
                            <h2 style="font-size: 1.25rem; margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <div style="font-size: 0.875rem; color: var(--color-gray-600); margin-bottom: 1rem;">
                                <?php echo get_the_date('Y/m/d'); ?>
                            </div>

                            <div style="font-size: 0.9375rem; color: var(--color-gray-700);">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-secondary" style="margin-top: 1rem;">
                                ادامه مطلب
                            </a>
                        </div>
                        
                    </article>
                    
                <?php endwhile; ?>
                
            </div>

            <?php the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '&rarr;',
                'next_text' => '&larr;',
            )); ?>

        <?php else : ?>
            
            <div class="no-content" style="text-align: center; padding: 3rem 0;">
                <h2>محتوایی یافت نشد</h2>
                <p>هیچ مطلبی در این دسته‌بندی وجود ندارد.</p>
            </div>
            
        <?php endif; ?>
        
    </div>
</div>

<?php get_footer(); ?>