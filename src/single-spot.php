<?php get_template_part('components/head'); ?>
<?php get_template_part('components/breadcrumb'); ?>


<div class="page-info">
    <div class="page-info__inner <?php if (is_page()) echo "page-info__inner--deco"  ?>">
        <div class="page-info__area">
            <?php
            $post_id = get_the_ID();
            $terms = wp_get_post_terms($post_id, "area");
            $isMunicipalitiesOrCategory = ["", ""];
            $isMunicipalitiesOrCategorySlug = ["", ""];
            $isMunicipalitiesOrCategorySlug = ["", ""];
            foreach ($terms as $term) {

                if (str_contains($term->name, '市') || str_contains($term->name, '区') || str_contains($term->name, '町') || str_contains($term->name, '村')) {
                    $isMunicipalitiesOrCategory[0] = $term->name;
                    $isMunicipalitiesOrCategorySlug[0] = $term->slug;
                } else {
                    $isMunicipalitiesOrCategory[1] = $term->name;
                    $isMunicipalitiesOrCategorySlug[1] = $term->slug;
                }
            }
            echo '<a href="/spot/?season=&area=' . $isMunicipalitiesOrCategorySlug[1]  . '&genre=&s=" class="page-info__category page-info__category--' . $isMunicipalitiesOrCategorySlug[1] . '">' . $isMunicipalitiesOrCategory[1] . '</a>';
            echo '<a href="/spot/?season=&area=' . $isMunicipalitiesOrCategorySlug[0]  . '&genre=&s=" class="page-info__municipalities">' . $isMunicipalitiesOrCategory[0] . '</a>';
            ?>
        </div>
        <div class="page-info__bottom">
            <h1 class="page-info__title"><?php the_title(); ?></h1>
            <div class="page-info__wrap">
                <p class="page-info__genre-title">
                    ジャンル：
                </p>
                <ul class="page-info__genres">
                    <?php
                    $terms = wp_get_post_terms(get_the_ID(), 'genre');
                    foreach ($terms as $term): ?>
                        <li class="page-info__genre">
                            <a href="/spot/?season=&area=&genre=<?= $term->slug ?>&s=" class="page-info__genre-link"><?= $term->name ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="swiper-container">
    <div class="swiper slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <?php the_post_thumbnail('large') ?>
            </div>
            <?php

            $imgGroup = SCF::get('images');
            $imgLength = 1;

            foreach ($imgGroup as $imgItem) {
                $imgLength++;
                $img_data = wp_get_attachment_image_src($imgItem['image'], 'large');
                $url = $img_data[0];
                $width = $img_data[1];
                $height = $img_data[2];
                $alt = get_post_meta($imgItem['image'], '_wp_attachment_image_alt', true) ?: get_post($imgItem['image'])->post_title;

                echo '<div class="swiper-slide">';
                echo '<img width="' . $width  . '" height="' . $height  . '" src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '">';
                echo "</div>";
            }
            ?>

        </div>
    </div>

    <div class="swiper thumbnail">
        <?php if ($imgLength > 5): ?>
            <div class="swiper-button-prev swiper-button-prev--1"></div>
            <div class="swiper-button-next swiper-button-next--1"></div>
        <?php endif; ?>
        <div class="swiper-wrapper <?= $imgLength < 5 ? 'swiper-wrapper--center' : '' ?>">
            <div class="swiper-slide">
                <?php the_post_thumbnail('large') ?>
            </div>
            <?php
            foreach ($imgGroup as $imgItem) {
                $img_data = wp_get_attachment_image_src($imgItem['image'], 'large');
                $url = $img_data[0];
                $width = $img_data[1];
                $height = $img_data[2];
                $alt = get_post_meta($imgItem['image'], '_wp_attachment_image_alt', true) ?: get_post($imgItem['image'])->post_title;
                echo '<div class="swiper-slide">';
                echo '<img width="' . $width  . '" height="' . $height  . '"  src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '">';
                echo "</div>";
            }
            ?>
        </div>
    </div>

</div>
<div class="sub-layout" id="sub-layout">
    <div class="sub-layout__left">
        <div class="editor">
            <div class="editor__inner">
                <?php the_content(); ?>
            </div>
            <?php get_template_part('components/share'); ?>
            <?php

            $nowDateEn = strtolower(date('F'));
            $nowDateNum = date("n");

            ?>
            <h2>他のスポットを見る</h2>

            <?
            $terms = wp_get_post_terms(get_the_ID(), 'season');

            $child_terms = [];
            foreach ($terms as $term) {
                if ($term->parent !== 0) {
                    $child_terms[] = $term->slug;
                }
            }

            $args = [
                'post_type' => array('spot'),
                'orderby' => 'rand',
                'post__not_in' => [$post_id],
                'posts_per_page' => 10,
            ];


            if (!empty($child_terms)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'season',
                        'field' => 'slug',
                        'terms' => $child_terms,
                    ],
                ];
            }

            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) : ?>
            <div class="swiper-container seasonSlider">
                <div class="swiper-button-prev swiper-button-prev--2"></div>
                <div class="swiper-button-next swiper-button-next--2"></div>
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                            <div class="swiper-slide spot-item">
                                <a href="<?php the_permalink() ?>" class="spot-item__link">
                                    <div class="spot-item__img">
                                        <?php the_post_thumbnail('medium') ?>
                                    </div>
                                    <div class="spot-item__card">
                                        <div class="spot-item__wrap">
                                            <?php
                                            $post_id = get_the_ID();
                                            $terms = wp_get_post_terms($post_id, "area");
                                            $isMunicipalitiesOrCategory = ["", ""];
                                            foreach ($terms as $term) {
                                                if (str_contains($term->name, '市') || str_contains($term->name, '区') || str_contains($term->name, '町') || str_contains($term->name, '村')) {
                                                    $isMunicipalitiesOrCategory[0] = $term->name;
                                                    $isMunicipalitiesOrCategorySlug[0] = $term->slug;
                                                } else {
                                                    $isMunicipalitiesOrCategory[1] = $term->name;
                                                    $isMunicipalitiesOrCategorySlug[1] = $term->slug;
                                                }
                                            }
                                            echo '<p class="spot-item__municipalities">' . $isMunicipalitiesOrCategory[0] . '</p>';
                                            echo '<p class="spot-item__category spot-item__category--' . $isMunicipalitiesOrCategorySlug[1] . '">' . $isMunicipalitiesOrCategory[1] . '</p>';
                                            ?>
                                        </div>
                                        <h3 class="spot-item__title"><?php the_title() ?></h3>
                                        <p class="spot-item__text"><?php the_excerpt() ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <a href="/" class="btn btn--left btn--reverse">
            <p class="btn__text">トップページに戻る</p>
        </a>
    </div>
    <div class="sub-layout__right">
        <?php get_template_part('components/sidebar'); ?>
    </div>
</div>


<?php get_template_part('components/foot'); ?>