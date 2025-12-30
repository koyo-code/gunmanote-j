<?php get_template_part('components/head'); ?>
<?php get_template_part('components/breadcrumb'); ?>

<?php get_template_part('components/sub-mv'); ?>

<div class="sub-layout sub-layout--archive" id="sub-layout">
  <div class="sub-layout__left sub-layout__left--full">

    <?php get_template_part('components/search-articles'); ?>
    <div class="archive" id="archive">
      <?php
      $paged = get_query_var("paged") ? get_query_var("paged") : 1;
      $args = array(
        'post_type' => ["articles"],
        'posts_per_page' => 12,
        's' => $s,
        'paged' => $paged
      );
      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) : ?>

        <?php
        my_result_count($the_query);
        ?>

        <ul class="archive__list">
          <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <li class="article-item">
              <a class="article-item__link" href="<?php the_permalink(); ?>">
                <div class="article-item__img article-item__img--full">
                  <?php the_post_thumbnail('medium') ?>
                </div>
                <div class="article-item__content">
                  <div class="article-item__top">
                    <p class="article-item__date"><img class="article-item__date-icon" src="<?= IMGS . "/common/time.svg" ?>" alt=""><?php the_time(get_option('date_format')); ?></p>
                    <?php
                    $terms = get_the_terms($post->ID, 'contents');
                    if ($terms) :
                      foreach ($terms as $term) :
                        echo '<p class="article-item__category">' . $term->name . '</p>';
                      endforeach;
                    endif;
                    ?>
                  </div>
                  <h2 class="article-item__title"><?php the_title(); ?></h2>
                  <p class="article-item__text"><?php the_excerpt(); ?></p>
                </div>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
        <?php myPagenation($the_query) ?>

      <?php else: ?>
        <p>お探しの条件ではみつかりませんでした</p>
      <?php endif; ?>
      <?php wp_reset_postdata();
      ?>
    </div>
    <a href="/" class="btn btn--left btn--reverse">
      <p class="btn__text">トップページに戻る</p>
    </a>
  </div>
</div>


<?php get_template_part('components/foot'); ?>