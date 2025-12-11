<?php
/**
 * Front page template with unified gifting story.
 */

global $product;
get_header();
?>

<section class="hero hero--gift" dir="rtl">
    <div class="container hero__container">
        <div class="hero__copy">
            <p class="hero__eyebrow">کادوی درست، در لحظه درست</p>
            <h1 class="hero__title">انتخاب کادو برای عزیزانتان را ساده و لذت‌بخش کردیم</h1>
            <p class="hero__subtitle">از باکس‌های اقتصادی روزمره تا کالکشن‌های امضایی و خاص؛ با ارسال سریع برای چهارمحال و بختیاری</p>
            <div class="hero__actions">
                <a class="btn btn--primary" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">مشاهده همه کادوها</a>
                <a class="btn btn--ghost" href="<?php echo esc_url(site_url('/gift-finder/')); ?>">کمکم کن کادو انتخاب کنم</a>
            </div>
        </div>
        <div class="hero__visual">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('giftshop-hero', array('class' => 'hero__image')); ?>
            <?php else : ?>
                <div class="hero__placeholder">بسته‌بندی شیک + پیام اختصاصی شما</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="gift-line" id="economic-line">
    <div class="container section__header">
        <div>
            <p class="section__eyebrow">بودجه‌دوست</p>
            <h2 class="section__title">کادوهای اقتصادی و روزمره</h2>
            <p class="section__subtitle">گزینه‌های خوش‌قیمت که هر روز می‌توانید برای عزیزان خود بفرستید.</p>
        </div>
        <a class="section__link" href="<?php echo esc_url(add_query_arg('gift_line', 'economic', get_permalink(wc_get_page_id('shop')))); ?>">مشاهده همه اقتصادی‌ها</a>
    </div>
    <div class="container">
        <?php
        $economic_query = new WP_Query(array(
            'post_type'      => 'product',
            'posts_per_page' => 8,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'gift_line',
                    'field'    => 'slug',
                    'terms'    => 'economic',
                ),
            ),
            'meta_key' => 'total_sales',
            'orderby'  => 'meta_value_num',
            'order'    => 'DESC',
        ));
        if ($economic_query->have_posts()) {
            echo '<ul class="products products--grid">';
            while ($economic_query->have_posts()) {
                $economic_query->the_post();
                wc_get_template_part('content', 'product');
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p class="muted">به زودی محصولات اقتصادی بیشتری اضافه می‌شود.</p>';
        }
        ?>
    </div>
</section>

<section class="gift-line gift-line--signature" id="signature-line">
    <div class="container section__header">
        <div>
            <p class="section__eyebrow">خاص و امضایی</p>
            <h2 class="section__title">کالکشن‌های خاص و امضایی</h2>
            <p class="section__subtitle">برای لحظه‌های مهم؛ جعبه‌های curated با بهترین اقلام و بسته‌بندی لوکس.</p>
        </div>
        <a class="section__link" href="<?php echo esc_url(add_query_arg('gift_line', 'signature', get_permalink(wc_get_page_id('shop')))); ?>">مشاهده همه امضایی‌ها</a>
    </div>
    <div class="container">
        <?php
        $signature_query = new WP_Query(array(
            'post_type'      => 'product',
            'posts_per_page' => 8,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'gift_line',
                    'field'    => 'slug',
                    'terms'    => 'signature',
                ),
            ),
            'meta_key' => 'total_sales',
            'orderby'  => 'meta_value_num',
            'order'    => 'DESC',
        ));
        if ($signature_query->have_posts()) {
            echo '<ul class="products products--grid">';
            while ($signature_query->have_posts()) {
                $signature_query->the_post();
                wc_get_template_part('content', 'product');
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p class="muted">به زودی کالکشن‌های امضایی بیشتری اضافه می‌شود.</p>';
        }
        ?>
    </div>
</section>

<section class="occasions">
    <div class="container section__header">
        <div>
            <p class="section__eyebrow">براساس مناسبت</p>
            <h2 class="section__title">کادوی مناسب هر لحظه</h2>
        </div>
    </div>
    <div class="container occasions__grid">
        <?php
        $occasions = array(
            array('slug' => 'birthday', 'label' => 'تولد'),
            array('slug' => 'anniversary', 'label' => 'سالگرد'),
            array('slug' => 'yalda', 'label' => 'یلدا'),
            array('slug' => 'nowruz', 'label' => 'نوروز'),
            array('slug' => 'valentine', 'label' => 'ولنتاین'),
            array('slug' => 'religious', 'label' => 'مناسبت مذهبی'),
            array('slug' => 'mother-day', 'label' => 'روز مادر'),
            array('slug' => 'father-day', 'label' => 'روز پدر'),
        );
        foreach ($occasions as $occasion) {
            $link = get_term_link($occasion['slug'], 'product_cat');
            echo '<a class="occasion-card" href="' . esc_url($link) . '">' . esc_html($occasion['label']) . '</a>';
        }
        ?>
    </div>
</section>

<section class="bestsellers">
    <div class="container section__header">
        <div>
            <p class="section__eyebrow">اعتماد مشتریان</p>
            <h2 class="section__title">پرفروش‌ترین‌ها</h2>
        </div>
        <a class="section__link" href="<?php echo esc_url(add_query_arg('orderby', 'popularity', get_permalink(wc_get_page_id('shop')))); ?>">مشاهده همه</a>
    </div>
    <div class="container">
        <?php
        $best_sellers = wc_get_products(array(
            'status'  => 'publish',
            'limit'   => 6,
            'orderby' => 'total_sales',
            'order'   => 'DESC',
        ));
        if (!empty($best_sellers)) {
            echo '<ul class="products products--grid">';
            foreach ($best_sellers as $product) {
                $post_object = get_post($product->get_id());
                setup_postdata($GLOBALS['post'] =& $post_object);
                wc_get_template_part('content', 'product');
            }
            wp_reset_postdata();
            echo '</ul>';
        }
        ?>
    </div>
</section>

<section class="social-proof">
    <div class="container social-proof__strip">
        <?php
        $reviews = array(
            array('name' => 'نگین از شهرکرد', 'text' => 'بسته‌بندی خیلی شیک بود و پیام کارت دقیق چاپ شده بود.', 'rating' => '★★★★★'),
            array('name' => 'امیر از بروجن', 'text' => 'برای تولد دوستم سفارش دادم، همون روز تحویل شد!', 'rating' => '★★★★★'),
            array('name' => 'سارا از اصفهان', 'text' => 'کیفیت اقلام داخل باکس عالی بود و قیمت مناسب.', 'rating' => '★★★★☆'),
            array('name' => 'پویان از تهران', 'text' => 'پیشنهادات اقتصادی خوبی دارید، دوباره سفارش می‌دم.', 'rating' => '★★★★☆'),
        );
        foreach ($reviews as $review) {
            echo '<div class="social-proof__item">';
            echo '<div class="social-proof__rating">' . esc_html($review['rating']) . '</div>';
            echo '<p class="social-proof__text">' . esc_html($review['text']) . '</p>';
            echo '<p class="social-proof__author">' . esc_html($review['name']) . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<?php get_footer(); ?>
