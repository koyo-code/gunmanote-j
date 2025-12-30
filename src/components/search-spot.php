<?php
 $season = get_query_var('season', '');
 $area = get_query_var('area', '');
 $genre = get_query_var('genre', '');
 $s = get_query_var('s', '');

 $seasonArray = explode(",", $season);
 $areaArray = explode(",", $area);
 $genreArray = explode(",", $genre);

 ?>
<div class="form" id="searchform">
    <div class="form__inner">
        <p class="form__title"><img src="<?= IMGS . "/common/search.svg" ?>" alt="検索アイコン">条件付きでさがす</p>
        <div class="form__container">
        <div class="form__wrap">
            <button class="form__cat-button">季節を選ぶ</button>
            <button class="form__cat-button">地域を選ぶ</button>
            <button class="form__cat-button">ジャンルを選ぶ</button>
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
                        <div class="form__modal-contents">
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
                        <div class="form__cat-wrap">
                            <label class="form__cat-title" for="<?= $parent->slug ?>" >
                                <input class="form__cat-parenet-input" type="checkbox" id="<?= $parent->slug ?>" name="<?= $parent->slug ?>" <?= in_array($parent->slug, $seasonArray) ? "checked" : "" ?>>
                                <p class="form__label-text"><?php echo esc_html($parent->name); ?></p>
                            </label>
                            <?php if (!empty($child_terms) && !is_wp_error($child_terms)) : ?>
                                <div class="form__list">
                                    <?php foreach ($child_terms as $child) : ?>
                                        <label class="form__item" for="<?= $child->slug ?>">
                                            <input class="form__item-child" type="checkbox" id="<?= $child->slug ?>" name="<?= $child->slug ?>" <?= in_array($child->slug, $seasonArray) ? "checked" : "" ?>>
                                            <p class="form__label-text"><?php echo esc_html($child->name); ?></p>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>

                        </div>




                </div>

                <div class="form__modal">
                <button class="form__modal-close"></button>
                <div class="form__modal-contents">
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


                if (!empty($sorted_parents )) :
                    foreach ($sorted_parents as $parent) :
                        $child_terms = get_terms(array(
                            'taxonomy'   => 'area',
                            'parent'     => $parent->term_id,
                            'hide_empty' => false,
                        ));
                ?>
                        <div class="form__cat-wrap">
                            <label class="form__cat-title" for="<?= $parent->slug ?>" >
                                <input class="form__cat-parenet-input" type="checkbox" id="<?= $parent->slug ?>" name="<?= $parent->slug ?>" <?= in_array($parent->slug, $areaArray) ? "checked" : "" ?>>
                                <p class="form__label-text"><?php echo esc_html($parent->name); ?></p>
                            </label>


                            <?php if (!empty($child_terms) && !is_wp_error($child_terms)) : ?>
                                <div class="form__list">
                                    <?php foreach ($child_terms as $child) : ?>
                                        <label class="form__item" for="<?= $child->slug ?>">
                                            <input class="form__item-child" type="checkbox" id="<?= $child->slug ?>" name="<?= $child->slug ?>" <?= in_array($child->slug, $areaArray) ? "checked" : "" ?>>
                                            <p class="form__label-text"><?php echo esc_html($child->name); ?></p>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>


                        </div>
                <?php
                    endforeach;
                endif;
                ?>
                </div>


                </div>

                <div class="form__modal">
                <button class="form__modal-close"></button>
                <div class="form__modal-contents form__modal-contents--no-child">
                <?php
                $parent_terms = get_terms(array(
                    'taxonomy'   => 'genre',
                    'parent'     => 0,
                    'hide_empty' => false,
                ));

                if (!empty($parent_terms )) :
                    foreach ($parent_terms  as $parent) :
                        $child_terms = get_terms(array(
                            'taxonomy'   => 'genre',
                            'parent'     => $parent->term_id,
                            'hide_empty' => false,
                        ));
                ?>
                        <div class="form__cat-wrap">
                            <label class="form__cat-title" for="<?= $parent->slug ?>" >
                                <input class="form__cat-parenet-input" type="checkbox" id="<?= $parent->slug ?>" name="<?= $parent->slug ?>" <?= in_array($parent->slug, $genreArray) ? "checked" : "" ?>>
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