<?php

 $contents = get_query_var('contents', '');
 $s = get_query_var('s', '');


 $contentsArray = explode(",", $contents);
 ?>
<div class="form" id="searchform">
    <div class="form__inner">
        <p class="form__title"><img src="<?= IMGS . "/common/search.svg" ?>" alt="検索アイコン">条件付きでさがす</p>
        <div class="form__container">
        <div class="form__wrap">
            <button class="form__cat-button">内容を選ぶ</button>
            <div class="form__window-wrap">
                <input class="form__window" name="s" type="text" placeholder="キーワードでさがす" value="<?=  $s; ?>">
                <div class="form__cross"></div>
            </div>
            <div class="form__overlay"></div>
        </div>
        <div class="form__buttons">
                <button class="form__submit">検索する</button>
                <button class="form__reset">条件をリセット</button>
        </div>
        <div class="form__modals">
                <div class="form__modal">
                <button class="form__modal-close"></button>
                <div class="form__modal-contents form__modal-contents--no-child">
                <?php
                $parent_terms = get_terms(array(
                    'taxonomy'   => 'contents',
                    'parent'     => 0,
                    'hide_empty' => false,
                ));

                if (!empty($parent_terms )) :
                    foreach ($parent_terms  as $parent) :
                        $child_terms = get_terms(array(
                            'taxonomy'   => 'contents',
                            'parent'     => $parent->term_id,
                            'hide_empty' => false,
                        ));
                    ?>
                        <div class="form__cat-wrap">
                            <label class="form__cat-title" for="<?= $parent->slug ?>" >
                                <input class="form__cat-parenet-input" type="checkbox" id="<?= $parent->slug ?>" name="<?= $parent->slug ?>" <?= in_array($parent->slug, $contentsArray) ? "checked" : "" ?>>
                                <p class="form__label-text"><?php echo esc_html($parent->name); ?></p>
                            </label>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
                </div>
                </div>
        </div>
</div>
</div>
</div>