<?php get_header(); ?>

<div class="container">
    <div class="content-area" style="padding: 2rem 0;">
        
        <?php if (have_posts()) : ?>
            
            <?php while (have_posts()) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 2rem;">
                    
                    <header class="entry-header">
                        <?php
                        if (is_singular()) :
                            the_title('<h1 class="entry-title">', '</h1>');
                        else :
                            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');
                        endif;
                        ?>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="entry-thumbnail" style="margin-bottom: 1rem;">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        if (is_singular()) :
                            the_content();
                        else :
                            the_excerpt();
                        endif;
                        ?>
                    </div>

                    <?php if (!is_singular()) : ?>
                        <div class="entry-footer">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-secondary">
                                ادامه مطلب
                            </a>
                        </div>
                    <?php endif; ?>
                    
                </article>
                
            <?php endwhile; ?>

            <?php the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '&rarr;',
                'next_text' => '&larr;',
            )); ?>

        <?php else : ?>
            
            <div class="no-content" style="text-align: center; padding: 3rem 0;">
                <h2>محتوایی یافت نشد</h2>
                <p>متأسفانه هیچ محتوایی در این بخش وجود ندارد.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    بازگشت به صفحه اصلی
                </a>
            </div>
            
        <?php endif; ?>
        
    </div>
</div>

<?php get_footer(); ?>