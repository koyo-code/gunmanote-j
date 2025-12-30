<header id="header" class="header">
    <div class="header__inner">
        <div class="header__left">
            <div class="header__logo">
                <a class="header__logo-link" href="/">
                    <img width="166" height="22" src="<?= IMGS . "/common/logo.svg" ?>" alt="ぐんまノート">
                </a>
            </div>
        </div>
        <div class="header__center">
            <nav class="g-nav">
                <ul class="g-nav__list">
                    <li class="g-nav__item">
                        <a href="/articles/" class="g-nav__link">記事</a>
                    </li>
                    <li class="g-nav__item">
                        <a href="/spot/" class="g-nav__link">スポット</a>
                    </li>
                    <li class="g-nav__item">
                        <a href="/about/" class="g-nav__link">ぐんまノートについて</a>
                    </li>
                    <li class="g-nav__item">
                        <a href="/contact/" class="g-nav__link">お問い合わせ</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="header__right">
            <button
             class="hamburger"
             type="button"
             aria-label="メニューボタン"
             >
                <div class="hamburger__inner">
                    <div class="hamburger__bar hamburger__bar--1"></div>
                    <div class="hamburger__bar hamburger__bar--2"></div>
                    <div class="hamburger__bar hamburger__bar--3"></div>
                </div>
            </button>
        </div>
        </div>
        <div id="hamburger-nav" class="hamburger-nav">
            <div class="hamburger-nav__inner">
                <ul class="hamburger-nav__list">
                    <li class="hamburger-nav__item">
                        <a class="hamburger-nav__link" href="/">ホーム<span class="hamburger-nav__en">HOME</span></a>
                    </li>
                    <li class="hamburger-nav__item">
                        <a class="hamburger-nav__link" href="/articles/">記事<span class="hamburger-nav__en">ARTICLES</span></a>
                    </li>
                    <li class="hamburger-nav__item">
                        <a class="hamburger-nav__link" href="/spot/">スポット<span class="hamburger-nav__en">SPOT</span></a>
                    </li>
                    <li class="hamburger-nav__item">
                        <a class="hamburger-nav__link" href="/about/">ぐんまノートについて<span class="hamburger-nav__en">ABOUT</span></a>
                    </li>
                    <li class="hamburger-nav__item">
                        <a class="hamburger-nav__link" href="/contact/">お問い合わせ<span class="hamburger-nav__en">CONTACT</span></a>
                    </li>
                </ul>
                <nav class="site-nav">
                    <ul class="site-nav__list">
                        <li class="site-nav__item">
                            <a href="/publish/" class="site-nav__link">掲載内容について</a>
                        </li>
                        <li class="site-nav__item">
                            <a href="/policy/" class="site-nav__link">ポリシー</a>
                        </li>
                    </ul>
                </nav>
                <div class="sns sns--mt">
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
</header>