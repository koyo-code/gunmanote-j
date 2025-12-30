<?php get_template_part('components/head'); ?>
<?php get_template_part('components/breadcrumb'); ?>

<div class="sub-layout" id="sub-layout">
    <div class="sub-layout__left">
    <div class="page-info">
            <div class="page-info__inner <?php if(is_page()) echo "page-info__inner--deco"  ?>">
            <?php if(is_single()): ?>
                <p class="page-info__date"><img class="page-info__date-icon" src="<?= IMGS . "/common/time.svg" ?>" alt=""><?php the_time( get_option( 'date_format' ) ); ?></p>
                    <?php
                        $post_id = get_the_ID();
                        $terms = wp_get_post_terms($post_id, "contents");
                        foreach ( $terms as $term ){
                            echo  '<a href="/articles/?contents=' . $term->slug . '&s=" class="page-info__category">' . $term->name . '</a>';
                        }
                    ?>
            <?php endif; ?>
                <h1 class="page-info__title"><?php the_title(); ?></h1>
            </div>
            <div class="page-info__img">
            <?php the_post_thumbnail('large') ?>
            </div>
        </div>
        <div class="editor">
            <div class="editor__inner">
                <?php the_content(); ?>
            </div>
        </div>
        <?php get_template_part('components/share'); ?>
        <a href="/" class="btn btn--left btn--reverse"><p class="btn__text">トップページに戻る</p></a>
    </div>
    <div class="sub-layout__right">
        <?php get_template_part('components/sidebar'); ?>
    </div>
</div>


<?php get_template_part('components/foot'); ?>