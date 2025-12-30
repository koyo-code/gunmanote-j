<div class="menu">
<?php if ( !is_search() && !is_front_page() && !is_archive() ): ?>
    <div class="toc">
        <button class="toc__button"
            type="button"
            aria-label="目次を開く"
            >
        </button>
        <div class="toc-menu" id="toc-menu">
            <div class="toc-menu__inner">
                <p class="toc-menu__title">目次</p>
                <ul class="toc-menu__list"></ul>
            </div>
        </div>
    </div>

    <?php endif; ?>


    <button class="page-top" data-link="gunmanote" aria-label="ページ上部に戻る"></button>
</div>