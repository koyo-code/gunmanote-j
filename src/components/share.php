<?php
  $url_encode = urlencode(get_permalink());
  $title_encode = urlencode(get_the_title());
?>
<div class="share <?php echo is_singular( 'articles' ) ? "share--mt-0" : "" ?>">
  <p class="share__title">\ シェアする /</p>
<ul class="share__buttons">
  <li class="share__button">
    <a class="share__link share__link--x" href="https://x.com/share?url=<?php echo $url_encode ?>&text=<?php echo $title_encode;?>" target="_blank" rel="nofollow noopener">
      <img class="share__img share__img" src="<?= IMGS . "/common/x.svg" ?>" alt="X">
    </a>
  </li>
  <li class="share__button">
    <a class="share__link share__link--facebook" href="https://www.facebook.com/share.php?u=<?php echo $url_encode ?>" target="_blank" rel="nofollow noopener">
      <img class="share__img share__img--facebook" src="<?= IMGS . "/common/facebook.svg" ?>" alt="Facebook">
    </a>
  </li>
  <li class="share__button">
    <a class="share__link share__link--line" href="https://social-plugins.line.me/lineit/share?url=<?php echo $url_encode ?>" target="_blank" rel="nofollow noopener">
      <img class="share__img share__img--line" src="<?= IMGS . "/common/line.svg" ?>" alt="LINE">
    </a>
  </li>
  <li class="share__button">
    <button class="share__link share__link--copy">
      <img class="share__img share__img" src="<?= IMGS . "/common/copy.svg" ?>" alt="Copy">
    </button>
  </li>
</ul>
</div>