<?php get_template_part('components/head'); ?>
<?php get_template_part('components/breadcrumb'); ?>

<?php get_template_part('components/sub-mv'); ?>

<div class="sub-layout" id="sub-layout">
    <div class="sub-layout__left"  >
        <div class="editor">
            <div class="editor__inner">
                <?php the_content(); ?>
            </div>
        </div>
        <form class="contact-form" method="post" action="https://ssgform.com/s/hZLIc3P0HPUs">
                <div class="contact-form__inner">
                    <dl class="form-item">
                        <dt class="form-item__left">
                            <label for="お名前" class="form-item__text">お名前<span class="form-item__require">必須</span></label>
                        </dt>
                        <dd class="form-item__content">
                            <input type="text" name="お名前" placeholder="群馬 太郎" id="お名前" class="form-item__input"    />
                            <p class="form-item__v"></p>
                        </dd>
                    </dl>
                    <dl class="form-item">
                        <dt class="form-item__left">
                            <label for="メールアドレス" class="form-item__text">メールアドレス<span class="form-item__require">必須</span></label>
                        </dt>
                        <dd class="form-item__content">
                            <input type="email" placeholder="gunmanote@example.com" name="メールアドレス" id="メールアドレス" class="form-item__input"  />
                            <p class="form-item__v"></p>
                        </dd>
                    </dl>
                    <dl class="form-item">
                        <dt class="form-item__left">
                            <label for="お問い合わせ内容" class="form-item__text">お問い合わせ内容<span class="form-item__require">必須</span></label>
                        </dt>
                        <dd class="form-item__content">
                            <textarea name="お問い合わせ内容" id="お問い合わせ内容"  class="form-item__textarea" ></textarea>
                            <p class="form-item__v"></p>
                        </dd>
                    </dl>
                </div>

                <div class="contact-form__check">
                    <label for="確認"><input type="checkbox" id="確認" class="contact-form__check-box">上記の内容で送信します</label>
                </div>


            <div class="contact-form__buttons">
                <button class="contact-form__button btn" type="button">送信する</button>
            </div>
        </form>
        <a href="/" class="btn btn--left btn--reverse"><p class="btn__text">トップページに戻る</p></a>
    </div>
    <div class="sub-layout__right">
        <?php get_template_part('components/sidebar'); ?>
    </div>
</div>

<?php get_template_part('components/foot'); ?>