<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-T6HQ47PC');
    </script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="email=no,telephone=no,address=no" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Noto+Sans:wght@100..900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>

<body id="gunmanote">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6HQ47PC"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php get_template_part('components/header'); ?>
    <?php
    global $template;
    $current_file = basename($template);
    $current_template = str_replace(".php", "", $current_file);
    ?>

    <main id="main" class="main">
        <div data-page="<?= $current_template; ?>">