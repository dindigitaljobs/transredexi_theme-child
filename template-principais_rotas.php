<?php
/**
 * Template Name: Principais Rotas
 */
get_header(); 

?>

<?php while(have_posts()):
      the_post(); ?>
  <section class="post_featured">
    <div class="post_thumb" data-image="<?php the_post_thumbnail_url(); ?>" data-title="<?php the_title(); ?>">
      <a class="hover_icon hover_icon_view inited" href="<?php the_post_thumbnail_url(); ?>" title="<?php the_title(); ?>" rel="prettyPhoto[slideshow]"><img class="wp-post-image" alt="<?php the_post_thumbnail_caption(); ?>" src="<?php the_post_thumbnail_url('large'); ?>" itemprop="image"></a>
    </div>
  </section>

  <section class="post_content">
    <?php the_content(); ?>
  </section>
<?php endwhile; ?>

<?php get_footer(); ?>