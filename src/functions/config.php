<?php

define('ENTRY', 'js/main.js');

$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
$host = $_SERVER['HTTP_HOST'];

$urlFront = substr($host, 0, -4);
$assetsPort = (int) substr($host, -4) + 1;
$assetsUrl = $protocol . $urlFront . $assetsPort;

function dynamic_wp_urls()
{
    $host = $_SERVER['HTTP_HOST'];
    update_option('siteurl', 'http://' . $host);
    update_option('home', 'http://' . $host);
}



if (preg_match('/^(local|192\.|172\.)/', $host)) {
    define('DEV', true);
    define('RESOURCE', $assetsUrl . '');
    define('IMGS', $assetsUrl . '/imgs');
    define('VIDEOS', $assetsUrl . '/videos');
    define('PDFS', $assetsUrl . '/pdfs');
    add_action('init', 'dynamic_wp_urls');
} else {
    define('DEV', false);
    define('RESOURCE', get_template_directory_uri());
    define('IMGS',  RESOURCE . '/imgs');
    define('VIDEOS', RESOURCE . '/videos');
    define('PDFS', RESOURCE . '/pdfs');
}

add_action('wp_enqueue_scripts', 'head_import');

function head_import()
{
    echo "<script>window.RESOURCE = '" . RESOURCE . "';window.DEV = " . (DEV ? "true" : "false") . ";</script>";
    if (defined('DEV') && DEV === true) {
        wp_enqueue_script('vite-script', RESOURCE . "/" . ENTRY,);
    } else {
        $username = 'koyo';
        $password = '5040';
        $options = [
            'http' => [
                'header' => "Authorization: Basic " . base64_encode("$username:$password")
            ]
        ];
        $context = stream_context_create($options);
        $url = RESOURCE . '/.vite/manifest.json';
        $manifest = json_decode(file_get_contents($url, true, $context), true);
        if (array($manifest)) {
            $entryFile = $manifest[ENTRY];
            $js_file = $entryFile['file'];
            $css_file = $entryFile['css'][0];
            wp_enqueue_script('vite-script', RESOURCE . "/" . $js_file, [], null, true);
            wp_enqueue_style('vite-style', RESOURCE . "/" . $css_file, [], null);
        }
    }
}

add_filter('script_loader_tag', 'add_attr', 10, 3);
function add_attr($tag, $handle, $src)
{
    if ($handle === 'vite-script') {
        $src = preg_replace('/\?ver=.*/', '', $src);
        $src = $src . "?d=" . current_time('YmdH');
        $tag = '<script src="' . esc_url($src) . '" type="module" class="vite-script" crossorigin></script>';
    }
    return $tag;
}


add_filter('style_loader_tag', 'add_css_attr', 10, 4);
function add_css_attr($html, $handle, $href, $media)
{
    if ($handle === 'vite-style') {
        $href = preg_replace('/\?ver=.*/', '', $href);
        $href = $href . "?d=" . current_time('YmdH');
        $html = '<link rel="stylesheet" href="' . esc_url($href) . '" media="' . esc_attr($media) . '"  class="vite-style" crossorigin>';
    }
    return $html;
}

function IMG($path)
{
    $asset_url = IMGS . $path;
    $time = current_time('YmdH');
    return add_query_arg('d', $time, $asset_url);
}

function VIDEO($path)
{
    $asset_url = VIDEOS . $path;
    $time = current_time('YmdH');
    return add_query_arg('d', $time, $asset_url);
}
