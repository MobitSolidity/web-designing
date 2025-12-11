<section class="bestsellers-section">
    <div class="container">
        
        <div class="section-header">
            <h2 class="section-title">پرفروش‌ترین کادوها</h2>
            <p class="section-subtitle">
                انتخاب هزاران مشتری راضی
            </p>
        </div>

        <div class="products-grid">
            <?php
            // Display bestselling products
            echo do_shortcode('[products limit="8" orderby="popularity"]');
            ?>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="btn btn-primary">
                مشاهده همه محصولات
            </a>
        </div>
        
    </div>
</section>