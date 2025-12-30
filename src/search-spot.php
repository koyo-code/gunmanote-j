<?php get_template_part('components/head'); ?>
<?php get_template_part('components/breadcrumb'); ?>

<?php get_template_part('components/search-result'); ?>

<?php get_template_part('components/sub-mv'); ?>

<div class="sub-layout  sub-layout--archive" id="sub-layout">
    <div class="sub-layout__left sub-layout__left--full">


<?php get_template_part('components/search-spot'); ?>

<div class="archive" id="archive">

    <?php

    $args = [
        'post_type' => 'spot', // カスタム投稿タイプを指定する場合は変更
        'posts_per_page' => 12, // 1ページあたりの投稿数
        's' => $s, // フリーワード検索
        'paged' => $paged,
        'tax_query' => [
            'relation' => 'AND',
        ],
    ];

    if (!empty($season)) {
        $array = explode(",", $season);
        $args['tax_query'][] = [
            'taxonomy' => 'season', // タクソノミー名
            'field' => 'slug',
            'terms' => $array ,
        ];
    }
    

    // 地域フィルタが設定されている場合
    if (!empty($area)) {
        $array = explode(",", $area);
        $args['tax_query'][] = [
            'taxonomy' => 'area', // タクソノミー名
            'field' => 'slug',
            'terms' => $array ,
        ];
    }

    // ジャンルフィルタが設定されている場合
    if (!empty($genre)) {
        $array = explode(",", $genre);
        $args['tax_query'][] = [
            'taxonomy' => 'genre', // タクソノミー名
            'field' => 'slug',
            'terms' => $array,
        ];
    }

    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) : ?>
      <?php my_result_count($the_query); ?>
      <ul class="archive__list">
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
          <li class="spot-item">
              <a href="<?php the_permalink() ?>" class="spot-item__link">
                  <div class="spot-item__img">
                        <?php the_post_thumbnail('medium') ?>
                  </div>
                  <div class="spot-item__card">
  <div class="spot-item__wrap">
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
              echo '<p class="spot-item__municipalities">' . $isMunicipalitiesOrCategory[0] . '</p>';
              echo '<p class="spot-item__category spot-item__category--'.  $isMunicipalitiesOrCategorySlug[1] .'">' . $isMunicipalitiesOrCategory[1] . '</p>';
          ?>
  </div>
  <h2 class="spot-item__title"><?php the_title() ?></h2>
  <p class="spot-item__text"><?php the_excerpt() ?></p>
                  </div>
              </a>
          </li>
      <?php endwhile; ?>
      </ul>
      <?php myPagenation($the_query) ?>
<?php else: ?>
<p>お探しの条件ではみつかりませんでした</p>
<?php endif; ?>
<?php wp_reset_postdata();?>
</div>
<a href="/" class="btn btn--left btn--reverse"><p class="btn__text">トップページに戻る</p></a>
</div>
</div>


<?php get_template_part('components/foot'); ?>