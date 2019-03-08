<?php
// Load translation files from your child theme instead of the parent theme
function my_child_theme_locale() {
  // var_dump(load_child_theme_textdomain( 'logistic-company', get_stylesheet_directory() . '/languages' ));
  load_child_theme_textdomain( 'logistic-company', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_locale' );