<?php get_template_part('components/head'); ?>
<?php get_template_part('components/breadcrumb'); ?>

<?php get_template_part('components/sub-mv'); ?>

<div class="sub-layout" id="sub-layout">
    <div class="sub-layout__left">
        <div class="editor">
            <div class="editor__inner">
                <?php the_content(); ?>
            </div>
        </div>
        <a href="/" class="btn btn--left btn--reverse"><p class="btn__text">トップページに戻る</p></a>
    </div>
    <div class="sub-layout__right">
        <?php get_template_part('components/sidebar'); ?>
    </div>
</div>


<?php get_template_part('components/foot'); ?>