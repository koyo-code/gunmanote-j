<?php get_template_part('components/head'); ?>

<section class="mv">
    <div class="sns sns--mv">
        <ul class="sns__list">
            <li class="sns__item">
                <a target="_blank" title="Instagram" href="https://www.instagram.com/koyo_films/" class="sns__link sns__link--white sns__link--instagram"></a>
            </li>
            <li class="sns__item">
                <a target="_blank" title="note" href="https://note.com/gunmanote/" class="sns__link sns__link--white  sns__link--note"></a>
            </li>
        </ul>
    </div>

    <h1 class="mv__title">
        <img src="<?= IMGS . "/common/mv-logo.svg" ?>" alt="ぐんまノート（ぐんまのーと）">
    </h1>
    <div class="mv-swiper">
        <div class="swiper mvSlider">
            <div class="swiper-wrapper">
                <?php
                $imgGroup = SCF::get('imgs');
                $i = 0;
                foreach ($imgGroup as $imgItem) {
                    $img_data = wp_get_attachment_image_src($imgItem['img'], 'full');
                    $url = $img_data[0];
                    $width = $img_data[1];
                    $height = $img_data[2];
                    $alt = get_post_meta($imgItem['img'], '_wp_attachment_image_alt', true) ?: get_post($imgItem['img'])->post_title;
                    echo '<div class="swiper-slide' . ($i === 0 ? ' swiper-slide-active' : '') . '">';
                    echo '<img width="' . $width . '" height="' . $height . '" src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '">';
                    echo "</div>";
                    $i++;
                }
                ?>
            </div>
        </div>
    </div>
</section>



<section class="article">
    <div class="article__inner">
        <hgroup class="section-title">
            <h2 class="section-title__main">記事</h2>
            <p class="section-title__sub" aria-hidden="true">ARTICLES</p>
        </hgroup>
        <ul class="article__list">
            <?php
            $args = [
                'post_type' => array('articles'),
                'posts_per_page' => 4,
            ];
            $the_query = new WP_Query($args);
            $index = 0;
            if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                    <?php $index++; ?>
                    <li class="article-item article-item--<?= $index; ?> <?= $index !== 1 ? "article-item--row" : ""; ?>">
                        <a class="article-item__link" href="<?php the_permalink(); ?>">
                            <div class="article-item__img <?= $index === 1 ? "article-item__img--full" : ""; ?>">
                                <?php the_post_thumbnail('medium') ?>
                            </div>
                            <div class="article-item__content">
                                <div class="article-item__top">
                                    <p class="article-item__date"><img width="14" height="14" class="article-item__date-icon" src="<?= IMGS . "/common/time.svg" ?>" alt=""><?php the_time(get_option('date_format')); ?></p>
                                    <p class="article-item__category">
                                        <?php
                                        $post_id = get_the_ID();
                                        $terms = wp_get_post_terms($post_id, "contents");
                                        foreach ($terms as $term) {
                                            echo  $term->name;
                                        }
                                        ?>
                                    </p>
                                </div>
                                <h3 class="article-item__title"><?php the_title(); ?></h3>
                                <p class="article-item__text"><?php the_excerpt(); ?></p>
                            </div>
                        </a>
                    </li>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
        <a href="/articles/" class="btn btn--right">
            <p class="btn__text">記事をもっと見る</p>
        </a>
    </div>
</section>
<section class="season">
    <div class="season__inner">
        <hgroup class="section-title section-title--center">
            <h2 class="section-title__main">今月のおすすめスポット</h2>
            <p class="section-title__sub" aria-hidden="true">RECOMMEND</p>
        </hgroup>
        <?
        $nowDateEn = strtolower(date('F'));
        $args = [
            'post_type' => array('spot'),
            'tax_query' => [
                [
                    'taxonomy' => 'season',
                    'field' => 'slug',
                    'terms' => $nowDateEn,
                ],
            ],
            'posts_per_page' => 16,
        ];
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) : ?>
            <div class="swiper-container">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper seasonSlider">
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
        <a href="/spot/?season=<?= $nowDateEn; ?>&area=&genre=&s=" class="btn btn--right">
            <p class="btn__text">おすすめをもっと見る</p>
        </a>
    </div>
</section>

<section class="area">
    <div class="area__inner">
        <hgroup class="section-title section-title--center">
            <h2 class="section-title__main">スポットをさがす</h2>
            <p class="section-title__sub" aria-hidden="true">SEARCH</p>
        </hgroup>
        <div class="tab">
            <ul class="tab__btns">
                <li class="tab__btn is-active" data-tab-btn="search">地域</li>
                <li class="tab__btn" data-tab-btn="search">季節</li>
                <li class="tab__btn" data-tab-btn="search">ジャンル</li>
            </ul>
            <ul class="tab__contents">
                <li class="tab__content is-active" data-tab-content="search">
                    <div class="area-wrap">
                        <?php
                        $area_order = array('西毛', '中毛', '東毛', '北毛');
                        $parent_terms = get_terms(array(
                            'taxonomy'   => 'area',
                            'parent'     => 0,
                            'hide_empty' => false,
                        ));
                        $sorted_parents = array();
                        foreach ($area_order as $area_name) {
                            foreach ($parent_terms as $term) {
                                if ($term->name === $area_name) {
                                    $sorted_parents[] = $term;
                                    break;
                                }
                            }
                        }

                        if (!empty($sorted_parents)) :
                            foreach ($sorted_parents as $parent) :
                                $child_terms = get_terms(array(
                                    'taxonomy'   => 'area',
                                    'parent'     => $parent->term_id,
                                    'hide_empty' => false,
                                ));
                        ?>
                                <div class="area-wrap__item">

                                    <a class="area-wrap__link area-wrap__link--<?= $parent->slug ?>" href="/spot/?area=<?= $parent->slug; ?>&genre=&season=&s=">
                                        <?= $parent->name ?>
                                        <div class="area-wrap__arrow"></div>
                                    </a>

                                    <?php if (!empty($child_terms) && !is_wp_error($child_terms)) : ?>
                                        <div class="area-wrap__list">
                                            <?php foreach ($child_terms as $child) : ?>
                                                <a href="/spot/?area=<?= $child->slug; ?>&genre=&season=&s=" class="area-wrap__subLink">
                                                    <?= $child->name ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>


                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </li>
                <li class="tab__content" data-tab-content="search">
                    <div class="area-wrap">
                        <?php
                        $season_order = array('春', '夏', '秋', '冬');
                        $parent_terms = get_terms(array(
                            'taxonomy'   => 'season',
                            'parent'     => 0,
                            'hide_empty' => false,
                        ));
                        $sorted_parents = array();
                        foreach ($season_order as $season_name) {
                            foreach ($parent_terms as $term) {
                                if ($term->name === $season_name) {
                                    $sorted_parents[] = $term;
                                    break;
                                }
                            }
                        }

                        if (!empty($sorted_parents)) :
                            foreach ($sorted_parents as $parent) :
                                $child_terms = get_terms(array(
                                    'taxonomy'   => 'season',
                                    'parent'     => $parent->term_id,
                                    'hide_empty' => false,
                                ));


                                usort($child_terms, function ($a, $b) use ($parent) {
                                    $numA = (int) filter_var($a->name, FILTER_SANITIZE_NUMBER_INT);
                                    $numB = (int) filter_var($b->name, FILTER_SANITIZE_NUMBER_INT);

                                    if ($parent->name === '冬') {
                                        if ($numA === 12) return -1;
                                        if ($numB === 12) return 1;
                                    }

                                    return $numA - $numB;
                                });



                        ?>
                                <div class="area-wrap__item">

                                    <a class="area-wrap__link area-wrap__link--<?= $parent->slug ?>" href="/spot/?season=<?= $parent->slug; ?>&genre=&area=&s=">
                                        <?= $parent->name ?>
                                        <div class="area-wrap__arrow"></div>
                                    </a>

                                    <?php if (!empty($child_terms) && !is_wp_error($child_terms)) : ?>
                                        <div class="area-wrap__list">
                                            <?php foreach ($child_terms as $child) : ?>
                                                <a href="/spot/?season=<?= $child->slug; ?>&genre=&area=&s=" class="area-wrap__subLink">
                                                    <?= $child->name ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>


                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </li>

                <li class="tab__content" data-tab-content="search">
                    <div class="area-wrap">
                        <div class="area-wrap__item">
                            <div class="area-wrap__list">

                                <?php
                                $parent_terms = get_terms(array(
                                    'taxonomy'   => 'genre',
                                    'parent'     => 0,
                                    'hide_empty' => false,
                                ));

                                if (!empty($parent_terms)) :
                                    foreach ($parent_terms  as $parent) :
                                ?>



                                        <a href="/spot/?season=&area=&genre=<?= $parent->slug; ?>&s=" class="area-wrap__subLink">
                                            <?= $parent->name ?>
                                        </a>


                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>

                        </div>

                    </div>
                </li>


            </ul>
        </div>
        <a href="/spot/" class="btn btn--right">
            <p class="btn__text">すべてのスポットを見る</p>
        </a>
    </div>
</section>

<div class="menu-area">
    <div class="menu-area__inner">
        <div class="menu-area__content">



            <?php
            $about_page = get_page_by_path('about');
            if ($about_page) {
                $about_page_id = $about_page->ID;

                $thumbnail_id = get_post_thumbnail_id($about_page_id);

                if ($thumbnail_id) {
                    echo wp_get_attachment_image($thumbnail_id, 'medium', false, array('class' => 'menu-area__img'));
                }
            }
            ?>

            <div class="menu-area__right">
                <hgroup class="menu-area__title">
                    <p class="menu-area__title--en">ABOUT</p>
                    <h2 class="menu-area__title--jp">ぐんまノートについて</h2>
                </hgroup>
                <p class="menu-area__text">
                    ぐんまノートの名前の由来、始めた理由などの詳細情報やロゴ、ハッシュタグなどについて説明しています。
                </p>
                <a href="/about/" class="btn btn--right">
                    <p class="btn__text">ぐんまノートについて知る</p>
                </a>
            </div>

        </div>
        <div class="menu-area__content">

            <?php
            $about_page = get_page_by_path('contact');
            if ($about_page) {
                $about_page_id = $about_page->ID;

                $thumbnail_id = get_post_thumbnail_id($about_page_id);

                if ($thumbnail_id) {
                    echo wp_get_attachment_image($thumbnail_id, 'medium', false, array('class' => 'menu-area__img'));
                }
            }
            ?>

            <div class="menu-area__right">
                <hgroup class="menu-area__title">
                    <p class="menu-area__title--en">CONTACT</p>
                    <h2 class="menu-area__title--jp">お問い合わせ</h2>
                </hgroup>
                <p class="menu-area__text">
                    サイトに掲載している記事や情報などは、運営者の主観や調べで記載しています。<br />
                    間違った情報などがございましたら、こちらのフォームまたはSNSのDMでいただけると幸いです。
                </p>
                <a href="/contact/" class="btn btn--right">
                    <p class="btn__text">お問い合わせをする</p>
                </a>
            </div>
        </div>
    </div>
</div>

<?php get_template_part('components/foot'); ?>