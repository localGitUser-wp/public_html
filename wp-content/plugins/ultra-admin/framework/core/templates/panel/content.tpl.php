<?php
	/**
	 * The template for the main content of the panel.
	 *
	 * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
	 *
	 * @author 		Redux Framework
	 * @package 	ReduxFramework/Templates
	 * @version     3.4.3
	 */
?>
<!-- Header Block -->
<?php $this->get_template( 'header.tpl.php' ); ?>

<!-- Intro Text -->
<?php if ( isset( $this->parent->args['intro_text'] ) ) : ?>
	<div id="redux-intro-text"><?php echo $this->parent->args['intro_text']; ?></div>
<?php endif; ?>




<?php $this->get_template( 'menu_container.tpl.php' ); ?>

<div class="redux-main">
	<!-- Stickybar -->
	<?php $this->get_template( 'header_stickybar.tpl.php' ); ?>
	<div id="redux_ajax_overlay">&nbsp;</div>
	<?php
		foreach ( $this->parent->sections as $k => $section ) {
			if ( isset( $section['customizer_only'] ) && $section['customizer_only'] == true ) {
				continue;
			}

			//$active = ( ( is_numeric($this->parent->current_tab) && $this->parent->current_tab == $k ) || ( !is_numeric($this->parent->current_tab) && $this->parent->current_tab === $k )  ) ? ' style="display: block;"' : '';
			$section['class'] = isset( $section['class'] ) ? ' ' . $section['class'] : '';
			echo '<div id="' . $k . '_section_group' . '" class="redux-group-tab' . $section['class'] . '" data-rel="' . $k . '">';
			//echo '<div id="' . $k . '_nav-bar' . '"';
			/*
		if ( !empty( $section['tab'] ) ) {

			echo '<div id="' . $k . '_section_tabs' . '" class="redux-section-tabs">';

			echo '<ul>';

			foreach ($section['tab'] as $subkey => $subsection) {
				//echo '-=' . $subkey . '=-';
				echo '<li style="display:inline;"><a href="#' . $k . '_section-tab-' . $subkey . '">' . $subsection['title'] . '</a></li>';
			}

			echo '</ul>';
			foreach ($section['tab'] as $subkey => $subsection) {
				echo '<div id="' . $k .'sub-'.$subkey. '_section_group' . '" class="redux-group-tab" style="display:block;">';
				echo '<div id="' . $k . '_section-tab-' . $subkey . '">';
				echo "hello ".$subkey;
				do_settings_sections( $this->parent->args['opt_name'] . $k . '_tab_' . $subkey . '_section_group' );
				echo "</div>";
				echo "</div>";
			}
			echo "</div>";
		} else {
			*/

			// Don't display in the
			$display = true;
			if ( isset( $_GET['page'] ) && $_GET['page'] == $this->parent->args['page_slug'] ) {
				if ( isset( $section['panel'] ) && $section['panel'] == "false" ) {
					$display = false;
				}
			}

			if ( $display ) {
				$this->output_section( $k );
			}
			//}
			echo "</div>";
			//echo '</div>';
		}

    //
	//	// Debug object output
	//	if ( $this->parent->args['dev_mode'] == true ) {
	//		$this->parent->debug->render();
	//	}
	//?>
	<?php //if ( $this->parent->args['system_info'] === true ) :
	//	require_once ReduxFramework::$_dir . 'inc/sysinfo.php';
	//	$system_info = new Simple_System_Info();
	//	?>
	<!--	<div id="system_info_default_section_group" class="redux-group-tab">-->
	<!--		<h3>--><?php //_e( 'System Info', 'ultra_framework' );?><!--</h3>-->
    <!---->
	<!--		<div id="redux-system-info">-->
	<!--			--><?php //echo $system_info->get( true );?>
	<!--		</div>-->
    <!---->
	<!--	</div>-->
	<?php //endif; ?>
	<?php
		/**
		 * action 'redux/page-after-sections-{opt_name}'
		 *
		 * @deprecated
		 *
		 * @param object $this ReduxFramework
		 */
		do_action( "redux/page-after-sections-{$this->parent->args['opt_name']}", $this ); // REMOVE LATER

		/**
		 * action 'redux/page/{opt_name}/sections/after'
		 *
		 * @param object $this ReduxFramework
		 */
		do_action( "redux/page/{$this->parent->args['opt_name']}/sections/after", $this );
	?>
	<div class="clear"></div>
	<!-- Footer Block -->
	<?php $this->get_template( 'footer.tpl.php' ); ?>
	<div id="redux-sticky-padder" style="display: none;">&nbsp;</div>
</div>
<div class="clear"></div>