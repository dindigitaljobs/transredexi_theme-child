<?php
/**
 * Enqueue Styles
 */
function theme_enqueue_styles() {
  $parent_style = 'parent-style';
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style',
      get_stylesheet_directory_uri() . '/assets/css/main.css',
      array( $parent_style )
  );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
 * Enqueue Scripts
 */
function theme_enqueue_scripts() {
  wp_enqueue_script( 'theme-init', get_bloginfo( 'stylesheet_directory' ) . '/js/theme-init.js', '1.0.0' );
  wp_enqueue_script(
    'vendor',
    get_stylesheet_directory_uri() . '/assets/js/vendor.js'
  );
  wp_enqueue_script(
    'main',
    get_stylesheet_directory_uri() . '/assets/js/main.js'
  );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );