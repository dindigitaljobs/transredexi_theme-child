<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'logistic_company_template_header_7_theme_setup' ) ) {
	add_action( 'logistic_company_action_before_init_theme', 'logistic_company_template_header_7_theme_setup', 1 );
	function logistic_company_template_header_7_theme_setup() {
		logistic_company_add_template(array(
			'layout' => 'header_7',
			'mode'   => 'header',
			'title'  => esc_html__('Header 7', 'logistic-company'),
			'icon'   => logistic_company_get_file_url('templates/headers/images/7.jpg'),
			'thumb_title'  => esc_html__('Original image', 'logistic-company'),
			'w'		 => null,
			'h_crop' => null,
			'h'      => null
			));
	}
}

// Template output
if ( !function_exists( 'logistic_company_template_header_7_output' ) ) {
	function logistic_company_template_header_7_output($post_options, $post_data) {

		// Get custom image (for blog) or featured image (for single)
		$header_css = '';
		if (empty($header_image))
			$header_image = logistic_company_get_custom_option('top_panel_image');
		if (empty($header_image))
			$header_image = get_header_image();
		if (!empty($header_image)) {
			$header_css = ' style="background-image: url('.esc_url($header_image).')"';
		}
		?>
		
		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_7 scheme_<?php echo esc_attr($post_options['scheme']); ?> top_panel_position_<?php echo esc_attr(logistic_company_get_custom_option('top_panel_position')); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_7 top_panel_position_<?php echo esc_attr(logistic_company_get_custom_option('top_panel_position')); ?>">

			<div class="top_panel_middle">
				<div class="content_wrap">
					<div class="contact_logo">
						<?php logistic_company_show_logo(true, true); ?>
					</div>
					<div class="menu_main_wrap">
						<nav class="menu_main_nav_area menu_hover_<?php echo esc_attr(logistic_company_get_theme_option('menu_hover')); ?>">
							<?php
							$menu_main = logistic_company_get_nav_menu('menu_main');
							if (empty($menu_main)) $menu_main = logistic_company_get_nav_menu();
							logistic_company_show_layout($menu_main);
							?>
						</nav>
						<?php

                        // Phone
						$contact_phone=trim(logistic_company_get_custom_option('contact_phone'));
                        $contact_fax=trim(logistic_company_get_custom_option('contact_fax'));
                        if (!empty($contact_phone) || !empty($contact_email)) {
                            ?><div class="contact_field contact_phone">
                            <span class="contact_label contact_phone icon-icon_1"><?php echo '<a href="tel:'.preg_replace('/[^A-Za-z0-9\-]/','',$contact_phone).'">'.wp_kses_data($contact_phone).'</a>'; ?></span><br>
                            <span class="contact_label contact_phone icon-icon_1">WhatsApp: <?php echo '<a href="https://api.whatsapp.com/send?phone='.preg_replace('/[^A-Za-z0-9\-]/','',$contact_fax).'">'.wp_kses_data($contact_fax).'</a>'; ?></span>
                            </div>
							<?php
                        }

                        if (logistic_company_get_custom_option('show_login')=='yes') {
                            if ( !is_user_logged_in() ) {
                                // Load core messages
                                logistic_company_enqueue_popup();
                                do_action('trx_utils_action_login');
                            } else {
                                ?>
                               <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="popup_links icon icon-logout"><?php esc_html_e('Client Logout', 'logistic-company'); ?></a>
                            <?php
                            }
                        }

						?>
					</div>
				</div>
			</div>
			

			</div>
		</header>
        <?php
        if (logistic_company_get_custom_option('show_page_image')=='yes') {
            ?>
            <section class="top_panel_image" <?php logistic_company_show_layout($header_css); ?>>
                <div class="top_panel_image_hover"></div>
                <div class="top_panel_image_header">
                    <?php if (!empty($post_icon)) { ?>
                        <div class="top_panel_image_icon <?php echo esc_attr($post_icon); ?>"></div>
                    <?php } ?>
                    <h1 itemprop="headline"
                        class="top_panel_image_title entry-title"><?php the_title(); ?></h1>

                    <div class="breadcrumbs">
                        <?php if (!is_404()) logistic_company_show_breadcrumbs(); ?>
                    </div>
                </div>
            </section>
        <?php
        }
		logistic_company_storage_set('header_mobile', array(
				 'open_hours' => false,
				 'login' => true,
				 'socials' => false,
				 'bookmarks' => false,
				 'contact_address' => false,
				 'contact_phone_email' => false,
				 'woo_cart' => true,
				 'search' => true
			)
		);
	}
}
?>