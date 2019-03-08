<?php
// Load translation files from your child theme instead of the parent theme
function my_child_theme_locale() {
  load_child_theme_textdomain( 'total', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_locale' );