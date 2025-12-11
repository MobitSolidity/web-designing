<section class="collections-section">
    <div class="container">
        
        <div class="section-header">
            <h2 class="section-title">کادوهای ویژه ما</h2>
            <p class="section-subtitle">
                از باکس‌های لاکچری تا گزینه‌های اقتصادی، برای هر مناسبتی
            </p>
        </div>

        <!-- Luxury Collection -->
        <div class="collection-block product-line--luxury">
            <h3 class="collection-title">باکس‌های لاکچری</h3>
            <p class="collection-desc">
                برای لحظات استثنایی و افراد خاص، باکس‌هایی با کیفیت برتر و طراحی منحصر به فرد
            </p>
            
            <?php
            // Display luxury products
            echo do_shortcode('[products limit="4" category="luxury" orderby="popularity"]');
            ?>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="<?php echo esc_url(home_url('/product-category/luxury/')); ?>" class="btn btn-luxury">
                    مشاهده همه باکس‌های لاکچری
                </a>
            </div>
        </div>

        <!-- Economic Collection -->
        <div class="collection-block product-line--economic" style="margin-top: 3rem;">
            <h3 class="collection-title">کادوهای اقتصادی</h3>
            <p class="collection-desc">
                کادوهای شیک و با کیفیت با قیمت مناسب، برای هر روز و هر بودجه‌ای
            </p>
            
            <?php
            // Display economic products
            echo do_shortcode('[products limit="4" category="economic" orderby="popularity"]');
            ?>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="<?php echo esc_url(home_url('/product-category/economic/')); ?>" class="btn btn-economic">
                    مشاهده همه کادوهای اقتصادی
                </a>
            </div>
        </div>
        
    </div>
</section>