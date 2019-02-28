<?php
  /**
   * Enqueue Styles
   */
  add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
  function my_theme_enqueue_styles() {
    $main = '/assets/css/main.css';
    wp_enqueue_style( $main, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
  }