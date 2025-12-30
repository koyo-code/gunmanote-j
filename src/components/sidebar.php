<aside class="sidebar">
    <div class="author">
            <div class="author__inner">
                <div class="author__bg-img">
                    <img width="292" height="164" src="<?= IMGS . "/common/koyo-bg.jpg" ?>" alt="KOYO / ぐんまノート background">
                </div>
                <div class="author__main-img">
                    <img height="94" width="94" src="<?= IMGS . "/common/koyo.jpg" ?>" alt="KOYO | ぐんまノート">
                </div>
                <div class="author__content">
                <p class="author__name">
                    KOYO | ぐんまノート
                </p>
                <p class="author__text">
                群馬に引っ越してきて数年、まだ何も知らなかったこの地で見つけてきた観光スポット・イベント・暮らしなど様々な情報を発信しています！
                </p>
                <ul class="author__infos">
                    <li class="author__info"><a class="author__link" href="/about/">ぐんまノートについて</a></li>
                    <li class="author__info"><a class="author__link" href="/contact/">お問い合わせ</a></li>
                </ul>
                <div class="sns">
                    <ul class="sns__list sns__list--right">
                        <li class="sns__item">
                            <a target="_blank" title="Instagram" href="https://www.instagram.com/koyo_films/" class="sns__link sns__link--black sns__link--instagram"></a>
                        </li>
                        <li class="sns__item">
                            <a target="_blank" title="note" href="https://note.com/gunmanote/" class="sns__link sns__link--black  sns__link--note"></a>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
    </div>

    <?php if(is_singular( 'spot' )): ?>
        <?php
            $current_post_id = get_the_ID();
            $args = [
                'orderby' => 'rand',
                'post_type' => array('spot'),
                'posts_per_page' => 3,
                'post__not_in' => [$current_post_id]
            ];
          $the_query = new WP_Query($args);
          if ($the_query->have_posts()) : ?>
            <div class="other">
            <p class="sidebar__title">他のスポットを見る</p>
            <ul class="other__list">
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <li class="other__item">
                <a class="other__link" href="<?php the_permalink(); ?>">
                    <div class="other__img">
                        <?php the_post_thumbnail("middium") ?>
                    </div>
                    <div class="other__content">
                        <div class="">
                            <?php
                                $post_id = get_the_ID();
                                $terms = wp_get_post_terms($post_id, "area");
                                $isMunicipalitiesOrCategory = ["",""];
                                $isMunicipalitiesOrCategorySlug = ["",""];
                                foreach ( $terms as $term ){
                                if(str_contains($term->name, '市')||str_contains($term->name, '区')||str_contains($term->name, '町')||str_contains($term->name, '村')){
                                    $isMunicipalitiesOrCategory[0] = $term->name;
                                    $isMunicipalitiesOrCategorySlug[0] = $term->slug;
                                }else{
                                    $isMunicipalitiesOrCategory[1] = $term->name;
                                    $isMunicipalitiesOrCategorySlug[1] = $term->slug;
                                }
                                }
                                echo '<p class="other__category other__category--'.  $isMunicipalitiesOrCategorySlug[1] .'">' . $isMunicipalitiesOrCategory[1] . '</p>';
                                ?>
                        </div>
                        <h3 class="other__title"><?php the_title(); ?></h3>
                        <p class="other__text"><?php the_excerpt(); ?></p>
                    </div>
                </a>
            </li>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            </ul>
            </div>
          <?php endif; ?>

        <?php
            // 第一階層のタクソノミーを取得
            $first_level_terms = get_terms( array(
                'taxonomy'   => 'season',
                'parent'     => 0, // 親がない＝第一階層
                'hide_empty' => false,
            ) );

            $second_level_terms = array();

            if ( ! is_wp_error( $first_level_terms ) && ! empty( $first_level_terms ) ) {
                // 第二階層以降のタクソノミーを取得
                foreach ( $first_level_terms as $term ) {
                    $child_terms = get_terms( array(
                        'taxonomy'   => 'season',
                        'parent'     => $term->term_id, // 第一階層の子
                        'hide_empty' => false,
                    ) );
                    if ( ! is_wp_error( $child_terms ) && ! empty( $child_terms ) ) {
                        $second_level_terms = array_merge( $second_level_terms, $child_terms );
                    }
                }
            }

            $month_order = array_flip([
                '1月', '2月', '3月', '4月', '5月', '6月',
                '7月', '8月', '9月', '10月', '11月', '12月'
            ]);

            usort($second_level_terms, function($a, $b) use ($month_order) {
                return $month_order[$a->name] - $month_order[$b->name];
            });


            if ( ! empty( $second_level_terms ) ): ?>
                <div class="tag-area">
                    <p class="sidebar__title">月別でスポットさがす</p>
                    <ul class="tag-area__list">
                        <?php foreach ( $second_level_terms as $term ): ?>
                            <li class="tag-area__item">
                                <a class="tag-area__item-link" href="/spot/?season=<?= $term->slug ?>&area=&genre=&s=">
                                    <?= esc_html( $term->name ) ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php else: ?>
               <p>タグが見つかりませんでした。</p>
            <?php endif; ?>

            <?php
            // 第一階層のタクソノミーを取得
            $first_level_terms = get_terms( array(
                'taxonomy'   => 'area',
                'parent'     => 0, // 親がない＝第一階層
                'hide_empty' => false,
            ) );

            $second_level_terms = array();

            if ( ! is_wp_error( $first_level_terms ) && ! empty( $first_level_terms ) ) {
                // 第二階層以降のタクソノミーを取得
                foreach ( $first_level_terms as $term ) {
                    $child_terms = get_terms( array(
                        'taxonomy'   => 'area',
                        'parent'     => $term->term_id, // 第一階層の子
                        'hide_empty' => false,
                    ) );
                    if ( ! is_wp_error( $child_terms ) && ! empty( $child_terms ) ) {
                        $second_level_terms = array_merge( $second_level_terms, $child_terms );
                    }
                }
            }

            if ( ! empty( $second_level_terms ) ): ?>
                <div class="tag-area">
                    <p class="sidebar__title">市町村別でスポットをさがす</p>
                    <ul class="tag-area__list">
                        <?php foreach ( $second_level_terms as $term ): ?>
                            <li class="tag-area__item">
                                <a class="tag-area__item-link" href="/spot/?season=&area=<?= $term->slug ?>&genre=&s=">
                                    <?= esc_html( $term->name ) ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php else: ?>
               <p>タグが見つかりませんでした。</p>
            <?php endif; ?>
    <?php endif; ?>


    <?php if(is_singular( 'articles' )): ?>
            <?php
            $current_post_id = get_the_ID();
            $args = [
                'orderby' => 'rand',
                'post_type' => array('articles'),
                'posts_per_page' => 3,
                'post__not_in' => [$current_post_id]
            ];
          $the_query = new WP_Query($args);
          if ($the_query->have_posts()) : ?>
            <div class="other">
            <p class="sidebar__title">他の記事を見る</p>
            <ul class="other__list">
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <li class="other__item other__item--column">
                <a class="other__link" href="<?php the_permalink(); ?>">
                    <div class="other__img">
                        <?php the_post_thumbnail("middium") ?>
                    </div>
                    <div class="other__content">
                        <div class="">
                            <?php
                                $post_id = get_the_ID();
                                $terms = wp_get_post_terms($post_id, "contents");
                                echo '<p class="other__category other__category--article">' . $terms[0]->name . '</p>';
                                ?>
                        </div>
                        <h3 class="other__title"><?php the_title(); ?></h3>
                        <p class="other__text"><?php the_excerpt(); ?></p>
                    </div>
                </a>
            </li>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            </ul>
        </div>
          <?php endif; ?>


          <?php
            // 第一階層のタクソノミーを取得
            $first_level_terms = get_terms( array(
                'taxonomy'   => 'contents',
                'parent'     => 0,
                'hide_empty' => false,
            ) );

            if ( ! empty( $first_level_terms ) ): ?>
                <div class="tag-area">
                    <p class="sidebar__title">内容で記事をさがす</p>
                    <ul class="tag-area__list">
                        <?php foreach ( $first_level_terms as $term ): ?>
                            <li class="tag-area__item">
                                <a class="tag-area__item-link" href="/articles/?contents=<?= $term->slug ?>&s=">
                                    <?= esc_html( $term->name ) ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php else: ?>
               <p>タグが見つかりませんでした。</p>
            <?php endif; ?>

    <?php endif; ?>


</aside>