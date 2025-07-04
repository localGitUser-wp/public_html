<?php
/**
 * Frontend functions.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'presscore_register_scripts' ) ) :

	/**
	 * Register theme styles and scripts.
	 *
	 * @since 5.4.0
	 */
	function presscore_register_scripts() {
		$register_styles = [
			'dt-main'                 => [
				'src' => PRESSCORE_THEME_URI . '/css/main',
			],
			'the7-custom-scrollbar' => [
				'src' => PRESSCORE_THEME_URI . '/lib/custom-scrollbar/custom-scrollbar',
			],
		];

		foreach ( $register_styles as $name => $props ) {
			the7_register_style( $name, $props['src'] );
		}

		$register_scripts = [
			'dt-above-fold'     => [
				'src'       => PRESSCORE_THEME_URI . '/js/above-the-fold',
				'deps'      => [ 'jquery' ],
				'in_footer' => false,
			],
			'dt-main'           => [
				'src'       => PRESSCORE_THEME_URI . '/js/main',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			'dt-legacy'         => [
				'src'       => PRESSCORE_THEME_URI . '/js/legacy',
				'deps'      => [ 'jquery' ],
				'in_footer' => true,
			],
			'dt-photo-scroller' => [
				'src'       => PRESSCORE_THEME_URI . '/js/photo-scroller',
				'deps'      => [ 'dt-main' ],
				'in_footer' => true,
			],
			'the7-cookies'      => [
				'src'       => PRESSCORE_THEME_URI . '/js/cookies',
				'deps'      => [],
				'in_footer' => true,
			],
			'jquery-mousewheel' => [
				'src'       => PRESSCORE_THEME_URI . '/lib/jquery-mousewheel/jquery-mousewheel',
				'deps'      =>  [ 'jquery' ],
				'in_footer' => true,
			],
            'the7-custom-scrollbar' => [
				'src'       => PRESSCORE_THEME_URI . '/lib/custom-scrollbar/custom-scrollbar',
				'deps'      => ['jquery-mousewheel'],
				'in_footer' => true,
			],
		];

        if ( the7_elementor_is_active() ) {
			$register_scripts['dt-main']['deps'][] = 'the7-elementor-frontend-common';
        }

		$register_scripts['dt-woocommerce'] = [
			'src'       => PRESSCORE_THEME_URI . '/js/compatibility/woocommerce/woocommerce',
			'deps'      => [ 'jquery' ],
			'in_footer' => false,
		];

		foreach ( $register_scripts as $name => $props ) {
			the7_register_script( $name, $props['src'], $props['deps'], false, $props['in_footer'] );
		}
	}

endif;

if ( ! function_exists( 'presscore_localize_main_script' ) ) :

	/**
	 * Localize main script.
	 *
	 * @since 5.4.0
	 */
	function presscore_localize_main_script( $handle ) {
		global $post;

		$config = presscore_config();

		if ( is_page() ) {
			$page_data = array(
				'type'     => 'page',
				'template' => $config->get( 'template' ),
				'layout'   => $config->get( 'justified_grid' ) ? 'jgrid' : $config->get( 'layout' ),
			);
		} elseif ( is_archive() ) {
			$page_data = array(
				'type'     => 'archive',
				'template' => $config->get( 'template' ),
				'layout'   => $config->get( 'justified_grid' ) ? 'jgrid' : $config->get( 'layout' ),
			);
		} elseif ( is_search() ) {
			$page_data = array(
				'type'     => 'search',
				'template' => $config->get( 'template' ),
				'layout'   => $config->get( 'justified_grid' ) ? 'jgrid' : $config->get( 'layout' ),
			);
		} else {
			$page_data = false;
		}

		$custom_error_messages_validation = of_get_option( 'custom_error_messages_validation' );
		if ( empty( $custom_error_messages_validation ) ) {
			$custom_error_messages_validation = _x( 'One or more fields have an error. Please check and try again.', 'feedback msg', 'the7mk2' );
		}
		$header_layout = of_get_option( 'header-layout' );
		$header        = 'header-' . of_get_option( 'header-layout', 'inline' ) . '-';
		$header_height = '';
		if ( in_array( $header_layout, array( 'classic', 'inline', 'split' ), true ) ) {
			 $header_height = (int) of_get_option( "{$header}height" );
		}

		$dt_local = array(
			'themeUrl'        => get_template_directory_uri(),
			'passText'        => __( 'To view this protected post, enter the password below:', 'the7mk2' ),
			'moreButtonText'  => array(
				'loading'  => __( 'Loading...', 'the7mk2' ),
				'loadMore' => __( 'Load more', 'the7mk2' ),
			),
			'postID'          => empty( $post->ID ) ? null : $post->ID,
			'ajaxurl'         => esc_url( admin_url( 'admin-ajax.php' ) ),
			'REST'            => array(
				'baseUrl'   => esc_url_raw( rest_url( the7_get_rest_namespace() ) ),
				'endpoints' => array(
					'sendMail' => '/send-mail',
				),
			),
			'contactMessages' => array(
				'required'            => $custom_error_messages_validation,
				'terms'               => esc_html__( 'Please accept the privacy policy.', 'the7mk2' ),
				'fillTheCaptchaError' => esc_html__( 'Please, fill the captcha.', 'the7mk2' ),
			),
			'captchaSiteKey'  => of_get_option( 'contact_form_recaptcha_site_key' ),
			'ajaxNonce'       => wp_create_nonce( 'presscore-posts-ajax' ),
			'pageData'        => $page_data,
			'themeSettings'   => array(
				'smoothScroll'                   => of_get_option( 'general-smooth_scroll', 'on' ),
				'lazyLoading'                    => ( 'lazy_loading' === $config->get( 'load_style' ) ),
				'desktopHeader'                  => array(
					'height' => $header_height,
				),
				'ToggleCaptionEnabled' =>   $config->get( 'header.close.hamburger.caption'),
				'ToggleCaption' => of_get_option( 'header-menu-close_icon-caption-text' ),
				'floatingHeader'                 => array(
					'showAfter' => (int) $config->get( 'header.floating_navigation.show_after' ),
					'showMenu'  => dt_sanitize_flag( $config->get( 'header.floating_navigation.enabled' ) ),
					'height'    => (int) of_get_option( 'header-floating_navigation-height' ),
					'logo'      => array(
						'showLogo' => ( 'none' !== $config->get( 'header.floating_navigation.logo.style' ) ),
						'html'     => presscore_get_logo_image( presscore_get_floating_menu_logos_meta() ),
						'url'      => presscore_get_logo_url(),
					),
				),
				'topLine'                        => array(
					'floatingTopLine' => array(
						'logo' => array(
							'showLogo' => presscore_is_floating_transparent_top_line_header() && 'none' !== of_get_option( 'header-style-mixed-top_line-floating-choose_logo' ),
							'html'     => presscore_get_logo_image( presscore_get_top_line_floating_logo() ),
						),
					),
				),
				'mobileHeader'                   => array(
					'firstSwitchPoint'        => (int) of_get_option( 'header-mobile-first_switch-after' ),
					'secondSwitchPoint'       => (int) of_get_option( 'header-mobile-second_switch-after' ),
					'firstSwitchPointHeight'  => (int) of_get_option( 'header-mobile-first_switch-height' ),
					'secondSwitchPointHeight' => (int) of_get_option( 'header-mobile-second_switch-height' ),
					'mobileToggleCaptionEnabled' =>   $config->get( 'header.mobile.hamburger.caption' ),
					'mobileToggleCaption' => of_get_option( 'header-mobile-menu_icon-caption-text' ),
				),
				'stickyMobileHeaderFirstSwitch'  => array(
					'logo' => array(
						'html' => presscore_get_logo_image( presscore_get_floating_mobile_logos_meta() ),
					),
				),
				'stickyMobileHeaderSecondSwitch' => array(
					'logo' => array(
						'html' => presscore_get_logo_image( presscore_get_floating_mobile_logos_meta_second() ),
					),
				),
				'sidebar'                        => array(
					'switchPoint' => (int) of_get_option( 'sidebar-responsiveness' ),
				),
				'boxedWidth'                     => of_get_option( 'general-box_width' ),
			),
		);

		$dt_local = apply_filters( 'presscore_localized_script', $dt_local );

		wp_localize_script( $handle, 'dtLocal', $dt_local );
	}

endif;

if ( ! function_exists( 'presscore_enqueue_scripts' ) ) :

	/**
	 * Enqueue scripts and styles.
	 */
	function presscore_enqueue_scripts() {
		// Enqueue web fonts if needed.
		presscore_enqueue_web_fonts();
		presscore_register_scripts();

		wp_enqueue_style( 'dt-main' );

		// Get theme config.
		$config = presscore_config();

		// Loader inline css.
		if ( $config->get_bool( 'template.beautiful_loading.enabled' ) ) {
			wp_add_inline_style( 'dt-main', presscore_get_loader_inline_css() );
		}

		// Enqueue base js.
		wp_enqueue_script( 'dt-above-fold' );
		presscore_localize_main_script( 'dt-above-fold' );
		wp_enqueue_script( 'dt-main' );

		if ( dt_is_legacy_mode() ) {
			wp_enqueue_script( 'dt-legacy' );
		}

		// Queue dt-main js first.
		global $wp_scripts;

		$dt_main_key = array_search( 'dt-main', $wp_scripts->queue, true );
		if ( $dt_main_key !== false ) {
			unset( $wp_scripts->queue[ $dt_main_key ] );
		}

		array_unshift( $wp_scripts->queue, 'dt-main' );

		$dt_share = array(
			'shareButtonText' => apply_filters(
				'the7-popup-share-buttons-title',
				array(
					'facebook'  => __( 'Share on Facebook', 'the7mk2' ),
					'twitter'   => __( 'Share on X', 'the7mk2' ),
					'pinterest' => __( 'Pin it', 'the7mk2' ),
					'linkedin'  => __( 'Share on Linkedin', 'the7mk2' ),
					'whatsapp'  => __( 'Share on Whatsapp', 'the7mk2' ),
				)
			),
			'overlayOpacity'  => $config->get( 'template.lightbox.overlay.opacity' ),
		);

		wp_localize_script( 'dt-above-fold', 'dtShare', $dt_share );

		// Comments clear script.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		//TODO check when we need scrool in the menu
		//if (presscore_header_layout_is_side()){
			wp_enqueue_style( 'the7-custom-scrollbar' );
			wp_enqueue_script( 'the7-custom-scrollbar' );
        //}
	}

endif;

add_action( 'wp_enqueue_scripts', 'presscore_enqueue_scripts', 15 );

/**
 * Enqueue dynamic stylesheets.
 *
 * @since 3.7.1
 * @see dynamic-styleheets-functions.php
 */
add_action( 'wp_enqueue_scripts', 'presscore_enqueue_dynamic_stylesheets', 20 );

/**
 * Maybe regenerate dynamic stylesheets.
 *
 * @since 5.5.0
 */
add_action( 'wp_head', 'the7_maybe_regenerate_dynamic_css', 0 );

if ( ! function_exists( 'the7_enqueue_style_css' ) ) :

	/**
	 * Allow override css from theme options.
	 *
	 * @since 3.8.1
	 */
	function the7_enqueue_style_css() {
		wp_enqueue_style( 'style', get_stylesheet_uri(), array(), THE7_VERSION );
	}

	add_action( 'wp_enqueue_scripts', 'the7_enqueue_style_css', 30 );

endif;

/**
 * Print custom css from theme options.
 *
 * @since 6.8.0
 */
function the7_print_custom_css() {
	$custom_css = of_get_option( 'general-custom_css', '' );
	if ( $custom_css ) {
		printf( "<style id='the7-custom-inline-css' type='text/css'>\n%s\n</style>\n", $custom_css );
	}
}
add_action( 'wp_head', 'the7_print_custom_css', 9999 );

if ( ! function_exists( 'presscore_print_beautiful_loading_scripts_in_footer' ) ) :

	function presscore_print_beautiful_loading_scripts_in_footer() {
		if ( ! presscore_config()->get_bool( 'template.beautiful_loading.enabled' ) ) {
			return;
		}
		?>
<script type="text/javascript" id="the7-loader-script">
document.addEventListener("DOMContentLoaded", function(event) {
	var load = document.getElementById("load");
	if(!load.classList.contains('loader-removed')){
		var removeLoading = setTimeout(function() {
			load.className += " loader-removed";
		}, 300);
	}
});
</script>
		<?php
	}

	add_action( 'wp_head', 'presscore_print_beautiful_loading_scripts_in_footer', 20 );

endif;

/**
 * Add new body classes.
 */
if ( ! function_exists( 'presscore_body_class' ) ) :

	function presscore_body_class( $classes ) {
		$config         = presscore_config();
		$desc_on_hoover = ( 'under_image' !== $config->get( 'post.preview.description.style' ) );
		$template       = $config->get( 'template' );
		$layout         = $config->get( 'layout' );

		switch ( $template ) {
			case 'blog':
				$classes[] = 'blog';
				break;
			case 'portfolio':
				$classes[] = 'portfolio';
				break;
			case 'team':
				$classes[] = 'team';
				break;
			case 'testimonials':
				$classes[] = 'testimonials';
				break;
			case 'archive':
				$classes[] = 'archive';
				break;
			case 'search':
				$classes[] = 'search';
				break;
			case 'albums':
				$classes[] = 'albums';
				break;
			case 'media':
				$classes[] = 'media';
				break;
			case 'microsite':
				$classes[] = 'one-page-row';
				break;
		}

		switch ( $layout ) {
			case 'masonry':
				if ( $desc_on_hoover ) {
					$classes[] = 'layout-masonry-grid';

				} else {
					$classes[] = 'layout-masonry';
				}
				break;
			case 'grid':
				$classes[] = 'layout-grid';
				if ( $desc_on_hoover ) {
					$classes[] = 'grid-text-hovers';
				}
				break;
			case 'checkerboard':
			case 'list':
			case 'right_list':
				$classes[] = 'layout-list';
				break;
		}

		if ( in_array( $layout, array( 'masonry', 'grid' ), true ) && ! in_array( $template, array( 'testimonials', 'team' ), true ) ) {
			$classes[] = $desc_on_hoover ? 'description-on-hover' : 'description-under-image';
		}

		if ( in_array( $config->get( 'template' ), array( 'albums', 'portfolio' ), true ) && 'masonry' === $config->get( 'layout' ) ) {
			$show_dividers = $config->get( 'show_titles' ) || $config->get( 'show_details' ) || $config->get( 'show_excerpts' ) || $config->get( 'show_terms' ) || $config->get( 'show_links' );
			if ( ! $show_dividers ) {
				$classes[] = 'description-off';
			}
		}

		if ( is_single() && ( post_password_required() || ( ! comments_open() && 0 === (int) get_comments_number() ) ) ) {
			$classes[] = 'no-comments';
		}

		if ( presscore_mixed_header_with_top_line() ) {
			$classes[] = 'header-top-line-active';
		}

		if ( presscore_header_with_bg() && ! presscore_header_layout_is_side() ) {

			switch ( $config->get( 'header_background' ) ) {
				case 'overlap':
					$classes['header_background'] = 'overlap';
					break;
				case 'transparent':
					$classes['header_background'] = 'transparent';

					break;
			}

			if (
				$config->get_bool( 'header.slideshow.header_below' )
				&& 'slideshow' === $config->get( 'header_title' )
				&& in_array( $config->get( 'header_background' ), array( 'transparent', 'normal' ), true )
			) {
				$classes[] = 'floating-navigation-below-slider';
			}
		}
		if ( presscore_header_with_bg() && presscore_config()->get( 'header.layout' ) === 'top_line' ) {
			switch ( $config->get( 'header_background' ) ) {
				case 'transparent':
					$classes['header_background'] = 'transparent';

					break;
			}
		}

		if ( 'fancy' === $config->get( 'header_title' ) ) {
			$classes[] = 'fancy-header-on';

		} elseif ( 'slideshow' === $config->get( 'header_title' ) ) {
			$classes[] = 'slideshow-on';

			if ( the7_get_paged_var() > 1 && isset( $classes['header_background'] ) ) {
				unset( $classes['header_background'] );

			}
		} elseif ( 'disabled' === $config->get( 'header_title' ) ) {
			$classes[] = 'title-off';

		}

		switch ( $config->get( 'template.images.hover.style' ) ) {
			case 'grayscale':
				$classes[] = 'filter-grayscale-static';
				break;
			case 'gray_color':
				$classes[] = 'filter-grayscale';
				break;
		}

		if ( 'boxed' === $config->get( 'template.layout' ) ) {
			$classes[] = 'boxed-layout';
		}

		if ( ! presscore_responsive() ) {
			$classes[] = 'responsive-off';
		} else {
			$classes[] = 'dt-responsive-on';
		}

		if ( $config->get( 'justified_grid' ) ) {
			$classes[] = 'justified-grid';
		}

		switch ( $config->get( 'header.position' ) ) {
			case 'right':
				$classes[] = 'header-side-right';
				break;
			case 'left':
				$classes[] = 'header-side-left';
				break;
		}
		switch ( $config->get( 'header.mobile.menu-close_icon.position' )) {
			case 'left':
				$classes[] = 'left-mobile-menu-close-icon';
				break;
			case 'right':
				$classes[] = 'right-mobile-menu-close-icon';
				break;
			case 'center':
				$classes[] ='center-mobile-menu-close-icon';
				break;

			case 'outside':
				$classes[] ='ouside-mobile-menu-close-icon';
				break;
		}
		if( $config->get( 'header.mixed.menu-close_icon.position' ) == 'outside'){
			$classes[] ='ouside-menu-close-icon';
		}

		switch ( $config->get( 'header.mobile.close.hamburger.caption' )){
			case 'left':
				$classes[] = 'mobile-close-left-caption';
				break;
			case 'right':
				$classes[] = 'mobile-close-right-caption';
				break;
		}

		if ( in_array( $config->get( 'header.layout' ), array( 'top_line', 'side_line', 'menu_icon' ), true ) ) {
			switch ( $config->get( 'header.navigation' ) ) {
				case 'slide_out':
					$classes[] = 'sticky-header';
					break;
				case 'overlay':
					$classes[] = 'overlay-navigation';
					break;
			}
		}
		if ( in_array( $config->get( 'header.layout' ), array( 'top_line', 'side_line', 'menu_icon' ), true ) && $config->get( 'header.navigation' ) === 'slide_out' ) {
			switch ( $config->get( 'header.layout.slide_out.animation' ) ) {
				case 'fade':
					$classes[] = 'fade-header-animation';
					break;
				case 'slide':
					$classes[] = 'slide-header-animation';
					break;
			}
		}

		if ( 'side_line' === $config->get( 'header.layout' ) ) {
			$classes[] = 'header-side-line';
			$classes[] = 'left-side-line';
			$classes[] = 'header-above-side-line';
		}
		$classes[] = the7_array_match( $config->get( 'header.mobile.hamburger.close.bg' ), array(
			'enabled' => 'mobile-hamburger-close-bg-enable',
		) );
		$classes[] = the7_array_match( $config->get( 'header.mobile.hamburger.close.bg.hover' ), array(
			'enabled' => 'mobile-hamburger-close-bg-hover-enable',
		) );
		$classes[] = the7_array_match( $config->get( 'header.mobile.hamburger.close.border' ), array(
			'enabled' => 'mobile-hamburger-close-border-enable',
		) );
		$classes[] = the7_array_match( $config->get( 'header.mobile.hamburger.close.border.hover' ), array(
			'enabled' => 'mobile-hamburger-close-border-hover-enable',
		) );

		$classes[] = the7_array_match( $config->get( 'header.mobile.menu-close_icon.size' ), array(
			//'small' => 'small-mobile-menu-close-icon',
			'minus-medium' => 'minus-medium-mobile-menu-close-icon',
			'fade_medium' => 'fade-medium-mobile-menu-close-icon',
			'rotate_medium' => 'rotate-medium-mobile-menu-close-icon',
			'fade_big' => 'fade-big-mobile-menu-close-icon',
			'fade_thin'=> 'fade-thin-mobile-menu-close-icon',
			'fade_small' => 'fade-small-mobile-menu-close-icon',
			'v_dots' => 'v-dots-mobile-menu-close-icon',
			'h_dots' => 'h-dots-mobile-menu-close-icon',
			'scale_dot' => 'scale-dot-mobile-menu-close-icon',
		) );
		$classes[] = the7_array_match( $config->get( 'header.mixed.menu-close_icon.size' ), array(

			'minus-medium' => 'medium-menu-close-icon',
			'fade_medium' => 'fade-medium-menu-close-icon',
			'rotate_medium' => 'rotate-medium-menu-close-icon',
			'fade_big' => 'fade-big-menu-close-icon',
			'fade_thin'=> 'fade-thin-menu-close-icon',
			'fade_small' => 'fade-small-menu-close-icon',
			'v_dots' => 'v-dots-menu-close-icon',
			'h_dots' => 'h-dots-menu-close-icon',
			'scale_dot' => 'scale-dot-menu-close-icon',
		) );

		if ( 'gradient' === $config->get( 'template.accent.color.mode' ) ) {
			$classes[] = 'accent-gradient';
		}
		if ( $config->get( 'page.bg' ) ) {
			$classes[] = 'fixed-page-bg';
		}
		$classes[] = 'srcset-enabled';

		/*switch ( $config->get( 'buttons.style' ) ) {
			case '3d':
				$classes[] = 'btn-3d';
				break;
			default:
				$classes[] = 'btn-flat';
				break;
			case 'shadow':
				$classes[] = 'btn-shadow';
				break;
		}*/
		$classes[] = 'btn-flat';

		switch ( $config->get( 'buttons.text.color' ) ) {
			case 'accent':
				$classes[] = 'accent-btn-color';
				break;
			case 'color':
				$classes[] = 'custom-btn-color';
				break;
		}

		switch ( $config->get( 'buttons.background' ) ) {
			case 'disabled':
				$classes[] = 'btn-bg-off';
				break;
		}

		switch ( $config->get( 'buttons.hover.background' ) ) {
			case 'disabled':
				$classes[] = 'btn-hover-bg-off';
				break;
		}

		switch ( $config->get( 'buttons.hover.text.color' ) ) {
			case 'accent':
				$classes[] = 'accent-btn-hover-color';
				break;
			case 'color':
				$classes[] = 'custom-btn-hover-color';
				break;
		}

		if ( $config->get( 'template.footer.background.slideout_mode' ) ) {
			$classes[] = 'footer-overlap';
		}

		switch ( $config->get( 'template.content.boxes.background.decoration' ) ) {
			case 'shadow':
				$classes[] = 'shadow-element-decoration';
				break;
			case 'outline':
				$classes[] = 'outline-element-decoration';
				break;
		}

		if ( $config->get( 'header.floating_navigation.enabled' ) && ( $config->get( 'header.layout' ) === 'classic' || $config->get( 'header.layout' ) === 'inline' || $config->get( 'header.layout' ) === 'split' ) ) {

			$classes[] = the7_array_match(
				$config->get( 'header.floating_navigation.style' ),
				array(
					'fade'   => 'phantom-fade',
					'slide'  => 'phantom-slide',
					'sticky' => 'phantom-sticky',
				)
			);

			$classes[] = the7_array_match(
				$config->get( 'header.floating_navigation.decoraion' ),
				array(
					'disabled' => 'phantom-disable-decoration',
					'shadow'   => 'phantom-shadow-decoration',
					'line'     => 'phantom-line-decoration',
					'content-width-line'     => 'phantom-content-width-line-decoration',
				)
			);

			$classes[] = the7_array_match(
				$config->get( 'header.floating_navigation.logo.style' ),
				array(
					'custom' => 'phantom-custom-logo-on',
					'main'   => 'phantom-main-logo-on',
					'none'   => 'phantom-logo-off',
				)
			);

		}
		if ( $config->get( 'header.floating_top-bar.enabled' ) ) {
			$classes[] = 'floating-top-bar';
		}
		if ( $config->get( 'header.layout' ) !== 'disabled' ) {
			$classes[] = the7_array_match(
				$config->get( 'header.mobile.floatin_navigation' ),
				array(
					'sticky'    => 'sticky-mobile-header',
					'menu_icon' => 'floating-mobile-menu-icon',
				)
			);
		}

		// $classes[] = the7_array_match(
		// 	$config->get( 'header.mobile.floatin_navigation' ),
		// 	array(
		// 		'sticky'    => 'sticky-mobile-header',
		// 		'menu_icon' => 'floating-mobile-menu-icon',
		// 	)
		// );

		if ( 'disabled' !== $config->get( 'sidebar_position' ) && $config->get( 'sidebar_hide_on_mobile' ) ) {
			$classes[] = 'mobile-hide-sidebar';
		}

		if ( $config->get( 'footer_show' ) && $config->get( 'footer_hide_on_mobile' ) ) {
			$classes[] = 'mobile-hide-footer';
		}

		if ( in_array( $config->get( 'header.layout' ), array( 'classic', 'inline', 'split' ), true ) ) {
			$classes[] = 'top-header';
		}

		$classes[] = the7_array_match(
			$config->get( 'header.mobile.logo.first_switch.layout' ),
			array(
				'left_right'   => 'first-switch-logo-right first-switch-menu-left',
				'left_center'  => 'first-switch-logo-center first-switch-menu-left',
				'right_left'   => 'first-switch-logo-left first-switch-menu-right',
				'right_center' => 'first-switch-logo-center first-switch-menu-right',
			)
		);

		$classes[] = the7_array_match(
			$config->get( 'header.mobile.logo.second_switch.layout' ),
			array(
				'left_right'   => 'second-switch-logo-right second-switch-menu-left',
				'left_center'  => 'second-switch-logo-center second-switch-menu-left',
				'right_left'   => 'second-switch-logo-left second-switch-menu-right',
				'right_center' => 'second-switch-logo-center second-switch-menu-right',
			)
		);

		if ( 'right' === $config->get( 'header.mobile.menu.align' ) ) {
			$classes[] = 'right-mobile-menu';
		}

		if ( presscore_lazy_loading_enabled() ) {
			$classes[] = 'layzr-loading-on';
		}

		if ( ! get_option( 'show_avatars' ) ) {
			$classes[] = 'no-avatars';
		}

		if ( of_get_option( 'wpml_dt-custom_style' ) ) {
			$classes[] = 'dt-wpml';
		}

		if ( of_get_option( 'wc_dt-custom_style' ) ) {
			$classes[] = 'dt-wc-custom';
		}
		if ( function_exists( 'is_shop' ) && function_exists( 'is_product_taxonomy' ) && of_get_option( 'woocommerce_shop-sidebar-collapse' ) && 'disabled' !== presscore_config()->get( 'sidebar_position' )) {
			if ( is_shop() || is_product_taxonomy() ) {
				$classes[] = 'dt-wc-sidebar-collapse';
			}
		}

		if ( of_get_option( 'contact_form_message' ) ) {
			$classes[] = 'popup-message-style';
		} else {
			$classes[] = 'inline-message-style';
		}

		if ( 'fullscreen' === $config->get( 'post.media.photo_scroller.layout' ) ) {
			$classes[] = 'fullscreen-photo-scroller';
		}

		$classes[] = 'the7-ver-' . THE7_VERSION;

		return array_values( array_unique( $classes ) );
	}

	add_filter( 'body_class', 'presscore_body_class' );

endif;

if ( ! function_exists( 'presscore_get_default_avatar' ) ) :

	/**
	 * Get default avatar.
	 *
	 * @return string.
	 */
	function presscore_get_default_avatar() {
		return PRESSCORE_THEME_URI . '/images/no-avatar.gif';
	}

endif;

if ( ! function_exists( 'presscore_get_default_image' ) ) :

	/**
	 * Get default image.
	 *
	 * Return array( 'url', 'width', 'height' );
	 *
	 * @return array.
	 */
	function presscore_get_default_image() {
		return array( PRESSCORE_THEME_URI . '/images/noimage.jpg', 1000, 700 );
	}

endif;

if ( ! function_exists( 'presscore_get_default_thumbnail_image' ) ) :

	/**
	 * Get default image.
	 *
	 * Return array( 'url', 'width', 'height' );
	 *
	 * @return array.
	 */
	function presscore_get_default_thumbnail_image() {
		return array( PRESSCORE_THEME_URI . '/images/noimage-150x150.jpg', 150, 150 );
	}

endif;

if ( ! function_exists( 'presscore_get_default_small_image' ) ) :

	/**
	 * Get default image.
	 *
	 * Return array( 'url', 'width', 'height' );
	 *
	 * @return array.
	 */
	function presscore_get_default_small_image() {
		return presscore_get_default_thumbnail_image();
	}

endif;

/**
 * @return array
 */
function the7_get_gray_square_svg() {
	return [ PRESSCORE_THEME_URI . '/images/gray-square.svg', 1500, 1500 ];
}

if ( ! function_exists( 'presscore_get_widgetareas_options' ) ) :

	/**
	 * Prepare array with widgetareas options.
	 */
	function presscore_get_widgetareas_options() {
		global $wp_registered_sidebars;

		return wp_list_pluck( $wp_registered_sidebars, 'name', 'id' );
	}

endif;

if ( ! function_exists( 'presscore_enqueue_web_fonts' ) ) :

	/**
	 * Web fonts override.
	 */
	function presscore_enqueue_web_fonts() {
		if ( the7_is_elementor_theme_mode_active() ) {
			return;
		}

		$fonts         = array();
		$websafe_fonts = array_keys( presscore_options_get_safe_fonts() );
		$options       = _optionsframework_get_clean_options();
		foreach ( $options as $option ) {
			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$option_type = $option['type'];

			if ( ! in_array( $option_type, array( 'web_fonts', 'typography' ), true ) ) {
				continue;
			}

			if ( $option_type === 'typography' ) {
				$typography  = of_get_option( $option['id'] );
				$font_family = isset( $typography['font_family'] ) ? $typography['font_family'] : '';
			} else {
				$font_family = of_get_option( $option['id'] );
			}

			$font_obj = new The7_Web_Font( $font_family );

			if ( in_array( $font_obj->get_family(), $websafe_fonts, true ) ) {
				continue;
			}

			$font_obj->add_weight( '400' );
			$font_obj->add_weight( '600' );
			$font_obj->add_weight( '700' );

			$fonts[] = $font_obj;
		}

		if ( $fonts ) {
			$fonts_compressor = new The7_Web_Fonts_Compressor( $fonts );
			if ( The7_Admin_Dashboard_Settings::get( 'web-fonts-display-swap' ) ) {
				$fonts_compressor->add_display_prop( 'swap' );
			}

			wp_enqueue_style( 'dt-web-fonts', $fonts_compressor->compress_to_url(), false, null );
		}
	}

endif;

if ( ! function_exists( 'presscore_comment_id_fields_filter' ) ) :

	/**
	 * PressCore comments fields filter. Add Post Comment and clear links before hudden fields.
	 *
	 * @since presscore 0.1
	 */
	function presscore_comment_id_fields_filter( $result ) {
		$comment_buttons = presscore_get_button_html(
			array(
				'href'  => 'javascript:void(0);',
				'title' => __( 'Post comment', 'the7mk2' ),
				'class' => 'dt-btn dt-btn-m',
			)
		);

		return $comment_buttons . $result;
	}

endif;

add_filter( 'comment_id_fields', 'presscore_comment_id_fields_filter' );

if ( ! function_exists( 'presscore_add_compat_header' ) ) {

	add_filter( 'wp_headers', 'presscore_add_compat_header' );

	/**
	 * [presscore_add_compat_header description]
	 *
	 * @param  array $headers
	 * @return array
	 */
	function presscore_add_compat_header( $headers ) {
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) {
			$headers['X-UA-Compatible'] = 'IE=EmulateIE10';
		}

		return $headers;
	}
}
