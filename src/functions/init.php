<?php
function remove_menus()
{
  remove_menu_page('edit.php');
  remove_menu_page( 'edit-comments.php' );
}

function delete_jquery() {
  if (!is_admin()) {
    wp_deregister_script('jquery');
  }
}
add_action('init', 'delete_jquery');

function custom_search_template($template){
  if ( is_search() ){
    $post_types = get_query_var('post_type');
    foreach ( (array) $post_types as $post_type )
      $templates[] = "search-{$post_type}.php";
    $templates[] = 'search.php';
    $template = get_query_template('search',$templates);
  }
  return $template;
}
function register_javascript() {
    wp_deregister_script('wp-embed');
  }
add_action('wp_enqueue_scripts', 'register_javascript');

function add_custom_query_vars($vars) {
  $vars[] = 'season';
  $vars[] = 'area';
  $vars[] = 'genre';
  $vars[] = 'contents';
  return $vars;
}

function theme_setup() {
  add_theme_support('post-thumbnails');
}

add_action('init', function () {
  remove_filter('the_excerpt', 'wpautop');
  remove_filter('the_content', 'wpautop');
});



add_action('admin_menu', 'remove_menus', 999);
add_filter( 'author_rewrite_rules', '__return_empty_array' );

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_filter('template_include','custom_search_template');
add_filter('query_vars', 'add_custom_query_vars');

add_action('after_setup_theme', 'theme_setup');
