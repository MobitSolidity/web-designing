<?php
/**
 * Template Name: Gift Finder
 */

get_header();
?>

<section class="gift-finder" dir="rtl">
    <div class="container">
        <p class="section__eyebrow">راهنمای سریع</p>
        <h1 class="section__title">کمکت می‌کنیم بهترین کادو را انتخاب کنی</h1>
        <p class="section__subtitle">به چند سؤال کوتاه پاسخ بده تا ۳ تا ۶ پیشنهاد مناسب بودجه و مناسبتت دریافت کنی.</p>

        <div class="gift-finder__wizard" data-gift-finder>
            <div class="gift-finder__steps">
                <span data-step-indicator>1/5</span>
            </div>
            <form method="get" class="gift-finder__form">
                <div class="gift-finder__step" data-step>
                    <h3>رابطه شما با گیرنده چیست؟</h3>
                    <select name="relationship">
                        <option value="friend">دوست</option>
                        <option value="partner">همسر / نامزد</option>
                        <option value="family">خانواده</option>
                        <option value="coworker">همکار</option>
                    </select>
                    <div class="gift-finder__nav">
                        <button type="button" class="btn btn--primary" data-next>بعدی</button>
                    </div>
                </div>

                <div class="gift-finder__step" data-step>
                    <h3>مناسبت چیست؟</h3>
                    <select name="occasion">
                        <option value="birthday">تولد</option>
                        <option value="anniversary">سالگرد</option>
                        <option value="yalda">یلدا</option>
                        <option value="nowruz">نوروز</option>
                        <option value="valentine">ولنتاین</option>
                    </select>
                    <div class="gift-finder__nav">
                        <button type="button" class="btn" data-prev>قبلی</button>
                        <button type="button" class="btn btn--primary" data-next>بعدی</button>
                    </div>
                </div>

                <div class="gift-finder__step" data-step>
                    <h3>سن و جنسیت</h3>
                    <select name="age">
                        <option value="teen">نوجوان</option>
                        <option value="young">۲۰ تا ۳۰</option>
                        <option value="adult">۳۰ تا ۵۰</option>
                        <option value="senior">۵۰+</option>
                    </select>
                    <select name="gender">
                        <option value="any">فرقی ندارد</option>
                        <option value="female">خانم</option>
                        <option value="male">آقا</option>
                    </select>
                    <div class="gift-finder__nav">
                        <button type="button" class="btn" data-prev>قبلی</button>
                        <button type="button" class="btn btn--primary" data-next>بعدی</button>
                    </div>
                </div>

                <div class="gift-finder__step" data-step>
                    <h3>بودجه شما</h3>
                    <select name="budget">
                        <option value="under-500">زیر ۵۰۰ هزار</option>
                        <option value="500-1500">۵۰۰ تا ۱.۵ میلیون</option>
                        <option value="over-1500">بیش از ۱.۵ میلیون</option>
                    </select>
                    <div class="gift-finder__nav">
                        <button type="button" class="btn" data-prev>قبلی</button>
                        <button type="button" class="btn btn--primary" data-next>بعدی</button>
                    </div>
                </div>

                <div class="gift-finder__step" data-step>
                    <h3>مقصد ارسال</h3>
                    <select name="destination">
                        <option value="chb">چهارمحال و بختیاری</option>
                        <option value="tehran">تهران</option>
                        <option value="isfahan">اصفهان</option>
                        <option value="other">سایر استان‌ها</option>
                    </select>
                    <div class="gift-finder__nav">
                        <button type="button" class="btn" data-prev>قبلی</button>
                        <button type="submit" class="btn btn--primary">مشاهده پیشنهادها</button>
                    </div>
                </div>
            </form>
        </div>

        <?php
        $budget = isset($_GET['budget']) ? sanitize_text_field(wp_unslash($_GET['budget'])) : '';
        $occasion = isset($_GET['occasion']) ? sanitize_text_field(wp_unslash($_GET['occasion'])) : '';
        $gift_line = isset($_GET['budget']) && 'over-1500' === $budget ? 'signature' : 'economic';

        if (!empty($budget) && !empty($occasion)) {
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => 6,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'gift_line',
                        'field'    => 'slug',
                        'terms'    => $gift_line,
                    ),
                ),
            );

            if (!empty($occasion)) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $occasion,
                );
            }

            $results = new WP_Query($args);
            if ($results->have_posts()) {
                echo '<div class="gift-finder__results">';
                echo '<h3>پیشنهادهای مناسب شما</h3>';
                echo '<ul class="products products--grid">';
                while ($results->have_posts()) {
                    $results->the_post();
                    wc_get_template_part('content', 'product');
                }
                echo '</ul>';
                echo '</div>';
                wp_reset_postdata();
            } else {
                echo '<p class="muted">هنوز محصولی مطابق این شرایط نداریم، ولی به زودی اضافه می‌کنیم.</p>';
            }
        }
        ?>
    </div>
</section>

<?php get_footer(); ?>
