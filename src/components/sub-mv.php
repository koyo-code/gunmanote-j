<section class="sub-mv">
    <div class="sub-mv__inner">

        <hgroup class="sub-mv__title">
            <h1 class="sub-mv__title-ja">
                <?php
                function get_custom_post_type_label($post_type)
                {
                    $post_type_obj = get_post_type_object($post_type);
                    return $post_type_obj ? $post_type_obj->label : '';
                }
                if (is_post_type_archive()) {
                    $post_type = get_query_var('post_type');
                    echo get_custom_post_type_label($post_type);
                } else if (is_search()) {
                    echo "検索結果";
                } else if (is_404()) {
                    echo "404";
                } else {
                    the_title();
                }
                ?>
            </h1>
            <p class="sub-mv__title-en" aria-hidden="true">
                <?php
                if (is_404()) {
                    echo "NOT FOUND";
                } else {
                    echo strtoupper(getFormattedSection(getCurrentUrl()));
                }
                ?>
            </p>
        </hgroup>
    </div>
    <?php if (!is_post_type_archive("spot") && !is_post_type_archive("articles")): ?>
        <div class="sub-mv__img">
            <div class="sub-mv__img-sub">
                <?php
                $size = 'large';
                if (is_404()) {
                    $attachment_id = 117;
                    echo wp_get_attachment_image($attachment_id, $size);
                } else if (has_post_thumbnail()) {
                    the_post_thumbnail('large');
                }
                ?>
            </div>
            <div class="sub-mv__img-main">
                <?php
                $size = 'large';
                if (is_404()) {
                    $attachment_id = 117;
                    echo wp_get_attachment_image($attachment_id, $size);
                } else if (has_post_thumbnail()) {
                    the_post_thumbnail('large');
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
</section>