<?php
/**
 * The7 elements scroller widget for Elementor.
 *
 * @package The7
 */

namespace The7\Mods\Compatibility\Elementor\Widgets;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Stack;
use The7_Query_Builder;
use Elementor\Icons_Manager;
use The7\Mods\Compatibility\Elementor\The7_Elementor_Widget_Base;
use Elementor\Core\Responsive\Responsive;
use The7\Mods\Compatibility\Elementor\The7_Elementor_Less_Vars_Decorator_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Photo_Scroller extends The7_Elementor_Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve photo scroller widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'the7_photo-scroller';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve photo scroller widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	protected function the7_title() {
		return esc_html__( 'Photo Scroller', 'the7mk2' );
	}

	protected function the7_icon() {
		return 'eicon-slider-push';
	}

	protected function the7_keywords() {
		return [ 'photo', 'scroller', 'slider', 'carousel', 'gallery' ];
	}

	public function get_style_depends() {
		the7_register_style('dt-photo-scroller', PRESSCORE_THEME_URI . '/css/photo-scroller' );

		return [ 'dt-photo-scroller' ];
	}
	public function get_script_depends() {
		if ( Plugin::$instance->preview->is_preview_mode() ) {
			return [ 'the7-photo-scroller-widget-preview' ];
		}

		return ['dt-photo-scroller'];
	}
	/**
	 * Register photo scroller widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
        $this->start_controls_section(
			'section_photo_scroller_img',
			[
				'label' => esc_html__( 'Images', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);

		$this->add_control(
			'scroller',
			[
				'label' => esc_html__( 'Add Images', 'the7mk2' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Landscape images behavior', 'the7mk2' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_basic_responsive_control(
			'dk_ls_images_view',
			[
				'label' => esc_html__( 'Filling mode:', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'fit' => [
						'title' => esc_html__( 'Contain', 'plugin-domain' ),
						'icon' => 'eicon-frame-minimize',
					],
					'fill' => [
						'title' => esc_html__( 'Cover', 'plugin-domain' ),
						'icon' => 'eicon-frame-expand',
					],
				],
				'toggle' => false,
				'device_args' => [
					'tablet' => [
						'toggle' => true,
					],
					'mobile' => [
						'toggle' => true,
					],
				],
				'default' => 'fill',
				'show_label' => true,
			]
		);
		$this->add_basic_responsive_control(
			'ls_max_width',
			[
				'label' => esc_html__( 'Max width (%)', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '',
				],
				'show_label' => true,
			]
		);
		$this->add_basic_responsive_control(
			'ls_min_width',
			[
				'label' => esc_html__( 'Min width (%):', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '',
				],
				'show_label' => true,
				'separator' => 'after',
			]
		);

		$this->add_control(
			'p_title_options',
			[
				'label' => esc_html__( 'Portrait images behavior', 'the7mk2' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_basic_responsive_control(
			'dk_pt_images_view',
			[
				'label' => esc_html__( 'Filling mode:', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'fit' => [
						'title' => esc_html__( 'Contain', 'plugin-domain' ),
						'icon' => 'eicon-frame-minimize',
					],
					'fill' => [
						'title' => esc_html__( 'Cover', 'plugin-domain' ),
						'icon' => 'eicon-frame-expand',
					],
				],
				'default' => 'fit',
				'tablet_default' => 'fit',
				'mobile_default' => 'fit',
				'device_args' => [
					'tablet' => [
						'toggle' => true,
					],
					'mobile' => [
						'toggle' => true,
					],
				],
				'toggle' => false,
				'show_label' => true,
			]
		);


		$this->add_basic_responsive_control(
			'pt_max_width',
			[
				'label' => esc_html__( 'Max width  (%)', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '',
				],
				'show_label' => true,
			]
		);
		$this->add_basic_responsive_control(
			'pt_min_width',
			[
				'label' => esc_html__( 'Min width (%):', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '',
				],
				'show_label' => true,
				'separator' => 'after',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'the7mk2' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_photo_scroller',
			[
				'label' => esc_html__( 'Scroller', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);
		$scroller_height_options            = [
			'inherit'  => esc_html__( 'Full Height', 'the7mk2' ) . ' (100%)',
			'initial' => esc_html__( 'Custom', 'the7mk2' ),
		];
		$scroller_height_options_on_devices = [ '' => esc_html__( 'Default', 'the7mk2' ) ] + $scroller_height_options;

		$this->add_basic_responsive_control(
			'_element_height',
			[
				'label' => esc_html__( 'Height', 'the7mk2' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'initial',
				'tablet_default' => 'initial',
				'mobile_default' => 'initial',
				'options'              => [
					'inherit'  => esc_html__( 'Full Height', 'the7mk2' ) . ' (100%)',
					'initial' => esc_html__( 'Custom', 'the7mk2' ),
				],

				'render_type' => 'template',

			]
		);

		$this->add_basic_responsive_control(
			'photo_scroller_height',
			[
				'label' => esc_html__( 'Custom Height', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'size' => '',
				],

				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => '_element_height',
							'operator' => '===',
							'value'    => 'initial',
						],
						[
							'name'     => '_element_height_tablet',
							'operator' => '!==',
							'value'    => 'inherit',
						],
						[
							'name'     => '_element_height_mobile',
							'operator' => '!==',
							'value'    => 'inherit',
						],
					],
				],
				'size_units' => [ 'px' ],
			]
		);

		$this->end_controls_section();

		/**
		 * Arrows section.
		 */
		$this->start_controls_section(
			'arrows_section',
			[
				'label' => esc_html__( 'Arrows', 'the7mk2' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);

		$this->add_control(
			'arrows',
			[
				'label'        => esc_html__( 'Show Arrows On Desktop', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',

			]
		);

		$this->add_control(
			'arrows_tablet',
			[
				'label'        => esc_html__( 'Show Arrows On Tablet', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',

			]
		);

		$this->add_control(
			'arrows_mobile',
			[
				'label'        => esc_html__( 'Show Arrows On Mobile', 'the7mk2' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'y',
				'default'      => 'y',

			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_thumbs_options',
			[
				'label' => esc_html__( 'Thumbnails', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);


			$this->add_control(
				'thumbnails',
				[
					'label' => esc_html__( 'Thumbnails visibility', 'the7mk2' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'the7mk2' ),
					'label_off' => esc_html__( 'Hide', 'the7mk2' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'thumb_position',
				[
					'label' => esc_html__( 'Position', 'the7mk2' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'inside-hidden',
					'options' => [
						'inside' => esc_html__( 'On the scroller, fixed', 'the7mk2' ),
						'inside-visible' => esc_html__( 'On the scroller, visible by default', 'the7mk2' ),
						'inside-hidden' => esc_html__( 'On the scroller, hidden by default', 'the7mk2' ),
						'outside' => esc_html__( 'Below the scroller', 'the7mk2' ),
					],
					'condition' => [
						'thumbnails' => [ 'yes'],
					],
					'selectors_dictionary' => [
						'outside'    => $this->combine_to_css_vars_definition_string(
							[
								'thumbs-position' => 'calc(var(--thumbs-height, 60px) + var(--thumbs-padding-top, 5px) + var(--thumbs-padding-bottom, 5px))',
							]
						),
						'inside-hidden'   => $this->combine_to_css_vars_definition_string(
							[
								'thumbs-position' => '0px',
							]
						),
						'inside-visible'  => $this->combine_to_css_vars_definition_string(
							[
								'thumbs-position' => '0px',
							]
						),
						'inside' => $this->combine_to_css_vars_definition_string(
							[
								'thumbs-position' => '0px',
							]
						),
					],
					'selectors'            => [
						'{{WRAPPER}}' => '{{VALUE}}',
					],
					'render_type' => 'template',

				]
			);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_options',
			[
				'label' => esc_html__( 'Content', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'overlay_title',
			[
				'label' => esc_html__( 'Title', 'the7mk2' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'None', 'the7mk2' ),
					'title' => esc_html__( 'Title', 'the7mk2' ),
					'caption' => esc_html__( 'Caption', 'the7mk2' ),
					'alt' => esc_html__( 'Alt', 'the7mk2' ),
					'description' => esc_html__( 'Description', 'the7mk2' ),
				],
			]
		);

		$this->add_control(
			'overlay_description',
			[
				'label' => esc_html__( 'Description', 'the7mk2' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'None', 'the7mk2' ),
					'title' => esc_html__( 'Title', 'the7mk2' ),
					'caption' => esc_html__( 'Caption', 'the7mk2' ),
					'alt' => esc_html__( 'Alt', 'the7mk2' ),
					'description' => esc_html__( 'Description', 'the7mk2' ),
				],
			]
		);
		$this->add_control(
			'inactive_content',
			[
				'label' => esc_html__( 'Inactive images content', 'the7mk2' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'the7mk2' ),
				'label_off' => esc_html__( 'Hide', 'the7mk2' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);

		$this->add_control(
			'fullscreen',
			[
				'label' => esc_html__( 'Fullscreen', 'the7mk2' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'the7mk2' ),
				'label_off' => esc_html__( 'No', 'the7mk2' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'the7mk2' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'the7mk2' ),
				'label_off' => esc_html__( 'No', 'the7mk2' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'the7mk2' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);
		$this->add_control(
				'autoplay_on_hover',
				[
					'label' => esc_html__( 'Stop on hover', 'the7mk2' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'the7mk2' ),
					'label_off' => esc_html__( 'No', 'the7mk2' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
						'autoplay' => 'yes',
					],
				]
			);


		$this->end_controls_section();


		$this->start_controls_section(
			'section_photo_images_style',
			[
				'label' => esc_html__( 'Images', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_basic_responsive_control(
			'scroller_padding',
			[
				'label'      => esc_html__( 'Image paddings', 'the7mk2' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'default'    => [
					'top'      => '',
					'right'     => '',
					'bottom'   => '',
					'left'     => '',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_control(
			'overlay',
			[
				'label' => esc_html__( 'Pixel overlay', 'the7mk2' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'the7mk2' ),
				'label_off' => esc_html__( 'Hide', 'the7mk2' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'image_opacity',
			[
				'label' => esc_html__( 'Inactive image opacity (%)', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => '',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'navigation_style',
			[
				'label' => esc_html__( 'Thumbnails', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'thumbnails' => [ 'yes'],
				],
			]
		);


		$this->add_control(
				'thumb_width',
				[
					'label' => esc_html__( 'Thumbnail width', 'the7mk2' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => '',
					],
					'range' => [
						'px' => [
							'min' => 2,
							'max' => 400,
							'step' => 2,
						],
					],

					'condition' => [
						'thumbnails' => [ 'yes'],
					],
				]
			);
			$this->add_control(
				'thumb_height',
				[
					'label' => esc_html__( 'Thumbnail height', 'the7mk2' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => '',
					],
					'range' => [
						'px' => [
							'min' => 2,
							'max' => 400,
							'step' => 2,
						],
					],
					'condition' => [
						'thumbnails' => [ 'yes'],
					],
					'selectors'  => [
						'{{WRAPPER}}' => '--thumbs-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
		$this->add_control(
			'thumb_space',
			[
				'label' => esc_html__( 'Thumbnail Gap', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}}' => '--thumb-space: calc({{SIZE}}{{UNIT}}/2);',
				],
			]
		);
		$this->add_responsive_control(
			'padding_thumb_bg',
			[
				'label'      => esc_html__( 'Thumbnails Paddings', 'the7mk2' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'render_type' => 'template',
				'allowed_dimensions' => 'vertical',
				'selectors'  => [
					'{{WRAPPER}}' => '--thumbs-padding-top: {{TOP}}{{UNIT}}; --thumbs-padding-bottom: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} .scroller-thumbnails' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'thumb_bg_color',
			[
				'label'       => esc_html__( 'Thumbnails background', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .scroller-thumbnails' => 'background: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'controls_style',
			[
				'label' => esc_html__( 'Controls', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'thumbnails' => [ 'yes'],
				],
			]
		);
		$this->add_responsive_control(
			'controls_align',
			[
				'label'                => esc_html__( 'Alignment', 'the7mk2' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'center',
				'options'              => [
					'left'    => [
						'title' => esc_html__( 'Left', 'the7mk2' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'the7mk2' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'the7mk2' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'    => 'left: 0; right: auto; transform: translate(0, 0);',
					'center'  => 'left: 50%; right: auto; transform: translate(-50%, 0);',
					'right'   => 'right:0; left: auto; transform: translate(0, 0);',
				],
				'selectors'            => [
					'{{WRAPPER}} .btn-cntr' => '{{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'the7mk2' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-cntr' => '--icon-size: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'contr_width',
			[
				'label' => esc_html__( 'Min Width', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-cntr a' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'contr_height',
			[
				'label' => esc_html__( 'Min Height', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-cntr a' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'btn_space',
			[
				'label' => esc_html__( 'Icon Gap', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--btn-space: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'btn_space_bellow',
			[
				'label' => esc_html__( 'Gap Below Icons', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .btn-cntr' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'contr_bg_color',
			[
				'label'       => esc_html__( 'Controls background', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .btn-cntr a' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'contrl_icon_color',
			[
				'label'       => esc_html__( 'Controls icon color', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .btn-cntr a:before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'arrows_style',
			[
				'label' => esc_html__( 'Arrows', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'arrows',
							'value' => 'y',
						],
						[
							'name' => 'arrows_tablet',
							'value' => 'y',
						],
						[
							'name' => 'arrows_mobile',
							'value' => 'y',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_heading',
			[
				'label'     => esc_html__( 'Arrow Icon', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'next_icon',
			[
				'label'     => esc_html__( 'Choose next arrow icon', 'the7mk2' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'classes'   => [ 'elementor-control-icons-svg-uploader-hidden' ],
			]
		);

		$this->add_control(
			'prev_icon',
			[
				'label'     => esc_html__( 'Choose previous arrow icon', 'the7mk2' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-chevron-left',
					'library' => 'fa-solid',
				],
				'classes'   => [ 'elementor-control-icons-svg-uploader-hidden' ],
			]
		);

		$this->add_control(
			'arrow_icon_size',
			[
				'label'      => esc_html__( 'Arrow icon size', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--icon-font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .scroller-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .scroller-arrow svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_background_heading',
			[
				'label'     => esc_html__( 'Arrow Background', 'the7mk2' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'arrow_bg_width',
			[
				'label'      => esc_html__( 'Width', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .scroller-arrow' => 'width: max({{SIZE}}{{UNIT}}, var(--icon-font-size));',
				],
			]
		);

		$this->add_control(
			'arrow_bg_height',
			[
				'label'      => esc_html__( 'Height', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow' => 'height: max({{SIZE}}{{UNIT}}, var(--icon-font-size));',
				],
			]
		);

		$this->add_control(
			'arrow_border_radius',
			[
				'label'      => esc_html__( 'Arrow border radius', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
				],

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_border_width',
			[
				'label'      => esc_html__( 'Arrow border width', 'the7mk2' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 25,
						'step' => 1,
					],
				],

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'the7mk2' ),
			]
		);
		$this->add_control(
			'arrow_icon_color',
			[
				'label'       => esc_html__( 'Arrow icon color', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow i { background: none; }
					{{WRAPPER}} .scroller-arrow i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .scroller-arrow svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_border_color',
			[
				'label'       => esc_html__( 'Arrow border color', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'arrow_bg_color',
			[
				'label'       => esc_html__( 'Arrow background color', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'the7mk2' ),
			]
		);

		$this->add_control(
			'arrow_icon_color_hover',
			[
				'label'       => esc_html__( 'Arrow icon color hover', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow i { transition: color 0.3s; }
					{{WRAPPER}} .scroller-arrow:hover i { background: none; }
					{{WRAPPER}} .scroller-arrow:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .scroller-arrow:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_border_color_hover',
			[
				'label'       => esc_html__( 'Arrow border color hover', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_bg_color_hover',
			[
				'label'       => esc_html__( 'Arrow background hover color', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .scroller-arrow:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
		    'left_arrow_position_heading',
		    [
		        'label' => esc_html__( 'Left Arrow Position', 'the7mk2' ),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
		    ]
		);

		$this->add_basic_responsive_control(
			'l_arrow_v_position',
			[
				'label' => esc_html__( 'Vertical Position', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'the7mk2' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'the7mk2' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'the7mk2' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
			]
		);
		$this->add_basic_responsive_control(
			'l_arrow_h_position',
			[
				'label' => esc_html__( 'Horizontal Position', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'the7mk2' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'the7mk2' ),
						'icon' => 'eicon-v-align-middle',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'the7mk2' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->add_basic_responsive_control(
			'l_arrow_v_offset',
			[
				'label' => esc_html__( 'Vertical Offset', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => -1000,
						'max'  => 1000,
						'step' => 1,
					],
					'%' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_basic_responsive_control(
			'l_arrow_h_offset',
			[
				'label' => esc_html__( 'Horizontal Offset', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => -1000,
						'max'  => 1000,
						'step' => 1,
					],
					'%' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
		    'right_arrow_position_heading',
		    [
		        'label' => esc_html__( 'Right Arrow Position', 'the7mk2' ),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
		    ]
		);


		$this->add_basic_responsive_control(
			'r_arrow_v_position',
			[
				'label' => esc_html__( 'Vertical Position', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'the7mk2' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'the7mk2' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'the7mk2' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
			]
		);
		$this->add_basic_responsive_control(
			'r_arrow_h_position',
			[
				'label' => esc_html__( 'Horizontal Position', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'the7mk2' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'the7mk2' ),
						'icon' => 'eicon-v-align-middle',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'the7mk2' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
			]
		);

		$this->add_basic_responsive_control(
		    'r_arrow_v_offset',
		    [
		        'label' => esc_html__( 'Vertical Offset', 'the7mk2' ),
		        'type' => Controls_Manager::SLIDER,
		        'default'    => [
		            'unit' => 'px',
		            'size' => '',
		        ],
		        'size_units' => [ 'px', '%' ],
		        'range'      => [
		            'px' => [
		                'min'  => -1000,
		                'max'  => 1000,
		                'step' => 1,
		            ],
		            '%' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
		        ],
		    ]
		);

		$this->add_basic_responsive_control(
		    'r_arrow_h_offset',
		    [
		        'label' => esc_html__( 'Horizontal Offset', 'the7mk2' ),
		        'type' => Controls_Manager::SLIDER,
		        'default'    => [
		            'unit' => 'px',
		            'size' => '',
		        ],
		        'size_units' => [ 'px', '%' ],
		        'range'      => [
		            'px' => [
		                'min'  => -1000,
		                'max'  => 1000,
		                'step' => 1,
		            ],
		            '%' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
		        ],
		    ]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'overlay_content_style',
			[
				'label' => esc_html__( 'Content', 'the7mk2' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions'   => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'overlay_title',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'overlay_description',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],

				//TODO: add conditions for this section
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => esc_html__( 'Alignment', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'the7mk2' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'the7mk2' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'the7mk2' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => false,
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .album-content-description' => 'text-align: {{VALUE}}; left: 0;
					margin: 0; height: 100%;',
				],
			]
		);

		$this->add_control(
			'content_vertical_position',
			[
				'label' => esc_html__( 'Vertical Position', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'the7mk2' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'the7mk2' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'the7mk2' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'middle',
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .album-content-description' => 'display: inline-flex; flex-flow:column wrap; justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'content_horizontal_position',
			[
				'label' => esc_html__( 'Horizontal Position', 'the7mk2' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'the7mk2' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'the7mk2' ),
						'icon' => 'eicon-v-align-middle',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'the7mk2' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'left: 50%; transform: translate3d(-50%, 0, 0);',
					'right' => 'left: auto; right: 0;',
				],
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .album-content-description' => '{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'content_bg_color',
			[
				'label'       => esc_html__( 'Background color', 'the7mk2' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => true,
				'default'     => '',

				'selectors' => [
					'{{WRAPPER}} .album-content-description .content-description-inner' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_basic_responsive_control(
			'_content_width',
			[
				'label' => esc_html__( 'Content width', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 2000,
						'step' => 1,
					],
				],
				'default' => [
					'size' => '',
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .album-content-description' => 'width: {{SIZE}}{{UNIT}};',
				],
				'show_label' => true,
			]
		);
		$this->add_basic_responsive_control(
		    'content_padding',
		    [
		        'label'      => esc_html__( 'Content paddings', 'the7mk2' ),
		        'type'       => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'default'    => [
		            'top'      => '',
		            'right'    => '',
		            'bottom'   => '',
		            'left'     => '',
		            'unit'     => 'px',
		            'isLinked' => true,
		        ],
				'selectors' => [
					'{{WRAPPER}} .content-description-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions'   => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'overlay_title',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'overlay_description',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
		    ]
		);

		$this->add_control(
			'scroller_heading_title',
			[
				'label' => esc_html__( 'Title', 'the7mk2' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_control(
			'scroller_title_color',
			[
				'label' => esc_html__( 'Color', 'the7mk2' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .album-content-description .entry-title' => 'color: {{VALUE}}; margin: 0',
				],
				'default'     => '',

				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .album-content-description .entry-title',
				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'the7mk2' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .album-content-description .entry-title + p' => 'margin: {{SIZE}}{{UNIT}} 0 0 0',
				],

				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => esc_html__( 'Description', 'the7mk2' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'overlay_description!' => '',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Color', 'the7mk2' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .album-content-description p' => 'color: {{VALUE}}',
				],
				'default'     => '',
				'condition' => [
					'overlay_description!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .album-content-description p',
				'condition' => [
					'overlay_description!' => '',
				],
			]
		);

		$this->end_controls_section(); // overlay_content

	}

	/**
	 * Render photo scroller widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->print_inline_css();

		if ( empty( $settings['scroller'] ) ) {
			return;
		}

		$slides = [];

		$has_description = ! empty( $settings['overlay_description'] );

		$has_title = ! empty( $settings['overlay_title'] );

		foreach ( $settings['scroller'] as $index => $attachment ) {
			$image_url = wp_get_attachment_image_src( $attachment['id'], 'full' );

			if ( ! $image_url ) {
				continue;
			}

			$thumb_args = [
				'img_id' => $attachment['id'],
				'class'  => 'post-thumbnail-rollover',
				'href'   => '',
				'custom' => ' aria-label="' . esc_attr__( 'Post image', 'the7mk2' ) . '"',
				'echo'   => false,
			];
			if ( presscore_lazy_loading_enabled() ) {
				$thumb_args['lazy_loading'] = true;
				$thumb_args['lazy_class'] = 'photo-thumb-lazy-load';
			}
			$post_media = dt_get_thumb_img( $thumb_args );


			$link_tag = '';

			$link = $this->get_link_url( $attachment, $settings );

			if ( $link ) {
				$link_key = 'link_' . $index;

				if ( Plugin::$instance->editor->is_edit_mode() ) {
					$this->add_render_attribute( $link_key, [
						'class' => 'elementor-clickable',
					] );
				}

				$this->add_link_attributes( $link_key, $link );

				$link_tag = '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
			}
			$desc_html = '';
			$attachment_img = dt_get_attachment( $attachment['id'] );
			$title_type = $settings['overlay_title'];
			$description_type = $settings['overlay_description'];
			$image_data = [
				'caption' => wp_get_attachment_caption($attachment['id']),
				'description' => $attachment_img['description'],
				'title' => $attachment_img['title'],
				'alt' => $attachment_img['alt'],
			];
			$title = array_key_exists( $title_type, $image_data ) ? $image_data[ $title_type ] : '';
			$description = array_key_exists( $description_type, $image_data ) ? $image_data[ $description_type ] : '';
			if ( $title || $description ) {
				if(! empty( $image_data['caption'] ) || ! empty( $image_data['description'] ) || ! empty($image_data['title'] ) || ! empty( $image_data['alt'] )){
					$desc_html = '<div class="album-content-description" ><div class="content-description-inner">';
							if ( $has_title ) {
								$title = $image_data[ $settings['overlay_title'] ];

								if ( ! empty( $title ) ) {
								$desc_html .= '<h4 class="entry-title" >' .  $title . '</h3>';
								}

							}
							if ( $has_description ) {
								$description = $image_data[ $settings['overlay_description'] ];
								if ( ! empty( $description ) ) {
								$desc_html .= '<p class="text-small">' . $description . '</p>';
								}
							}

					$desc_html .= '</div></div>';
				}
			}

			$slide_html = '<figure data-width="' . esc_attr( $image_url[1] ) . '" data-height="' . esc_attr( $image_url[2] ) . '"><a href=" ' . esc_attr ($image_url[0]) . ' "'  . $post_media;
			$slide_html .= '</a>' . $desc_html . '</figure>';


			$slides[] = $slide_html;

		}

		if ( empty( $slides ) ) {
			return;
		}
		$data = [];
		if ( $settings['fullscreen'] === 'yes' ) {
			$class = ' fullscreen-on';
		}else {
			$class = ' fullscreen-off';
		}

		$this->add_render_attribute( [
			'scroller' => [
				'class' => 'photoSlider ',
			],
			'scroller-wrapper' => [
				'class' => 'photo-scroller ' . $this->get_unique_class() . $class .'',
				'data-scale' => $settings['dk_ls_images_view'],
				'data-autoslide' => ( $settings['autoplay'] == 'yes' ? 'true' : 'false' ),
				'data-play-on-hover' =>( $settings['autoplay_on_hover'] == 'yes' ? 'true' : 'false' ),
				'data-delay'     => $settings['autoplay_speed'] !== '' ? absint( $settings['autoplay_speed'] ) : 5000,
				'data-show-thumbnails' => ( $settings['thumbnails'] == 'yes' ? 'true' : 'false' ),
				'data-thumb-position' =>  $settings['thumb_position'],

				'data-thumb-height' => $settings['thumb_height']['size'] !== '' ? absint( $settings['thumb_height']['size']) : 60,
				'data-thumb-width' => $settings['thumb_width']['size'] !== '' ? absint( $settings['thumb_width']['size']) : 60,
				'data-thumb-space' => $settings['thumb_space']['size'] !== '' ? absint( $settings['thumb_space']['size']) : 5,
				'data-thumb-padding-top' => $settings['padding_thumb_bg']['top'] !== '' ? absint( $settings['padding_thumb_bg']['top']) : 5,
				'data-thumb-padding-bottom' => $settings['padding_thumb_bg']['bottom'] !== '' ? absint( $settings['padding_thumb_bg']['bottom']) : 5,
				'data-cntr-space-bottom' => $settings['btn_space_bellow']['size']!== '' ? absint( $settings['btn_space_bellow']['size']) : 5,

				'data-transparency' => $settings['image_opacity']['size'] !== '' ? absint($settings['image_opacity']['size'])/100 : 0.15,
				'data-arrows' => ( $settings['arrows'] == 'y' ? 'true' : 'false' ),
				'data-arrows_tablet' => ( $settings['arrows_tablet'] == 'y' ? 'true' : 'false' ),
				'data-arrows_mobile' => ( $settings['arrows_mobile'] == 'y' ? 'true' : 'false' ),
				'data-next-icon'            => $settings['next_icon']['value'],
				'data-prev-icon'            => $settings['prev_icon']['value'],
				'data-r-arrow-v-position'   => $settings['r_arrow_v_position'] ,
				'data-r-arrow-h-position'   => $settings['r_arrow_h_position'],
				'data-l-arrow-v-position'   => $settings['l_arrow_v_position'] ,
				'data-l-arrow-h-position'   => $settings['l_arrow_h_position'] ,

				'data-ls-fill-dt'  => esc_attr( $settings['dk_ls_images_view'] ),
				'data-ls-fill-tablet' => $settings['dk_ls_images_view_tablet'] !== '' ? esc_attr( $settings['dk_ls_images_view_tablet'] ) : esc_attr($settings['dk_ls_images_view']),

				'data-pt-fill-dt'  => esc_attr( $settings['dk_pt_images_view']),
				'data-pt-fill-tablet' => $settings['dk_pt_images_view_tablet'] !== '' ? esc_attr( $settings['dk_pt_images_view_tablet']) : esc_attr($settings['dk_pt_images_view']),
			],
		] );

		if ( ! empty( $settings['dk_pt_images_view_tablet'])) {
			$data['data-pt-fill-mob'] = $settings['dk_pt_images_view_mobile'] !== '' ? esc_attr( $settings['dk_pt_images_view_mobile'] ): esc_attr($settings['dk_pt_images_view_tablet']);
		}else{
			$data['data-pt-fill-mob'] = $settings['dk_pt_images_view_mobile'] !== '' ? esc_attr( $settings['dk_pt_images_view_mobile'] ): esc_attr($settings['dk_pt_images_view']);
		}
		if ( ! empty( $settings['dk_ls_images_view_tablet'])) {
			$data['data-ls-fill-mob'] = $settings['dk_ls_images_view_mobile'] !== '' ? esc_attr( $settings['dk_ls_images_view_mobile'] ): esc_attr($settings['dk_ls_images_view_tablet']);
		}else{
			$data['data-ls-fill-mob'] = $settings['dk_ls_images_view_mobile'] !== '' ? esc_attr( $settings['dk_ls_images_view_mobile'] ): esc_attr($settings['dk_ls_images_view']);
		}
		$data['data-padding-top'] = $settings['scroller_padding']['top'] !== '' ? absint( $settings['scroller_padding']['top']) : 0;
		$data['data-padding-bottom'] = $settings['scroller_padding']['bottom'] !== '' ? absint( $settings['scroller_padding']['bottom']) : 0;
		$data['data-padding-side'] = $settings['scroller_padding']['right'] !== '' ? absint( $settings['scroller_padding']['right']) : 0;
		$data['data-padding-left'] = $settings['scroller_padding']['left'] !== '' ? absint( $settings['scroller_padding']['left']) : 0;

		$data['data-t-padding-top'] = $settings['scroller_padding_tablet']['top'] !== '' ? absint( $settings['scroller_padding_tablet']['top']) : $data['data-padding-top'];
		$data['data-t-padding-bottom'] = $settings['scroller_padding_tablet']['bottom'] !== '' ? absint( $settings['scroller_padding_tablet']['bottom']) : $data['data-padding-bottom'];
		$data['data-t-padding-side']   = $settings['scroller_padding_tablet']['right'] !== '' ? absint( $settings['scroller_padding_tablet']['right']) :  $data['data-padding-side'];
		$data['data-t-padding-left']   = $settings['scroller_padding_tablet']['left'] !== '' ? absint( $settings['scroller_padding_tablet']['left']) : $data['data-padding-left'];

		$data['data-m-padding-top'] = $settings['scroller_padding_mobile']['top'] !== '' ? absint( $settings['scroller_padding_mobile']['top']) : $data['data-t-padding-top'];
		$data['data-m-padding-bottom'] = $settings['scroller_padding_mobile']['bottom'] !== '' ? absint( $settings['scroller_padding_mobile']['bottom']) : $data['data-t-padding-bottom'];
		$data['data-m-padding-side'] = $settings['scroller_padding_mobile']['right'] !== '' ? absint( $settings['scroller_padding_mobile']['right']) : $data['data-t-padding-side'];
		$data['data-m-padding-left' ] = $settings['scroller_padding_mobile']['left'] !== '' ? absint( $settings['scroller_padding_mobile']['left']) : $data['data-t-padding-left'];

		$data['data-ls-max'] = $settings['ls_max_width']['size'] !== '' ? absint( $settings['ls_max_width']['size']) : 100;
		$data['data-t-ls-max'] = $settings['ls_max_width_tablet']['size'] !== '' ? absint( $settings['ls_max_width_tablet']['size']) : $data['data-ls-max'];
		$data['data-m-ls-max'] = $settings['ls_max_width_mobile']['size'] !== '' ? absint( $settings['ls_max_width_mobile']['size']) : $data['data-t-ls-max'];
		$data['data-ls-min'] =  $settings['ls_min_width']['size'] !== ''? absint( $settings['ls_min_width']['size'] ) : 0;
		$data['data-t-ls-min'] =  $settings['ls_min_width_tablet']['size'] !== ''? absint( $settings['ls_min_width_tablet']['size'] ) : $data['data-ls-min'];
		$data['data-m-ls-min'] =  $settings['ls_min_width_mobile']['size'] !== ''? absint( $settings['ls_min_width_mobile']['size'] ) : $data['data-t-ls-min'];
		$data['data-pt-max'] = $settings['pt_max_width']['size'] !== '' ? absint( $settings['pt_max_width']['size']) : 100;
		$data['data-t-pt-max'] = $settings['pt_max_width_tablet']['size'] !== '' ? absint( $settings['pt_max_width_tablet']['size']) : $data['data-pt-max'];
		$data['data-m-pt-max'] = $settings['pt_max_width_mobile']['size'] !== '' ? absint( $settings['pt_max_width_mobile']['size']) : $data['data-t-pt-max'];
		$data['data-pt-min'] = $settings['pt_min_width']['size'] !== '' ? absint( $settings['pt_min_width']['size'] ): 0;
		$data['data-t-pt-min'] = $settings['pt_min_width_tablet']['size'] !== '' ? absint( $settings['pt_min_width_tablet']['size'] ): $data['data-pt-min'];
		$data['data-m-pt-min'] = $settings['pt_min_width_mobile']['size'] !== '' ? absint( $settings['pt_min_width_mobile']['size'] ): $data['data-t-pt-min'];

		$this->add_render_attribute('scroller-wrapper',  $data );

		$desktop = $settings['photo_scroller_height']['size'] !== '' ? absint($settings['photo_scroller_height']['size']) : 300;
		$tablet = $settings['photo_scroller_height_tablet']['size'] !== '' ? absint($settings['photo_scroller_height_tablet']['size']): $desktop;


		if ( 'initial' == $settings['_element_height'] ) {
			$this->add_render_attribute( 'scroller-wrapper', 'data-height', $desktop );
		}
		if (  'inherit' !== $settings['_element_height_tablet']) {
			$this->add_render_attribute( 'scroller-wrapper', 'data-tablet-height', $tablet );
		}
		if (  'inherit' !== $settings['_element_height_mobile']) {
			$mobile = $settings['photo_scroller_height_mobile']['size'] !== '' ? absint($settings['photo_scroller_height_mobile']['size']): $tablet;
			$this->add_render_attribute( 'scroller-wrapper', 'data-mobile-height', $mobile );
		}
		if ( 'yes' === $settings['overlay'] ) {
			$this->add_render_attribute( 'scroller-wrapper', 'class', 'show-overlay' );
		}
		if ( 'yes' != $settings['inactive_content'] ) {
			$this->add_render_attribute( 'scroller-wrapper', 'class', 'hide-inactive-content' );
		}

		if ('inside-hidden' === $settings['thumb_position'] ) {
			$this->add_render_attribute( 'scroller-wrapper', 'class', 'hide-thumbs' );
		}


		$slides_count = count( $settings['scroller'] );


			?>
		<div <?php echo $this->get_render_attribute_string( 'scroller-wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'scroller' ); ?>>
				<?php echo implode( '', $slides ); ?>
			</div>
			<div class="btn-cntr">
				<a href="#" class="hide-thumb-btn"></a>
				<a href="#" class="auto-play-btn"></a>
				<a href="#" class="full-screen-btn"></a>
			</div>
			<div class="scroller-arrow prev"><?php Icons_Manager::render_icon( $settings['prev_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
			<div class="scroller-arrow next"><?php Icons_Manager::render_icon( $settings['next_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
		</div>
		<?php
	}

	/**
	 * Retrieve photo scroller link URL.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param array $attachment
	 * @param object $instance
	 *
	 * @return array|string|false An array/string containing the attachment URL, or false if no link.
	 */
	private function get_link_url( $attachment, $instance ) {

		return [
			'url' => wp_get_attachment_url( $attachment['id'] ),
		];
	}

	/**
	 * Return shortcode less file absolute path to output inline.
	 *
	 * @return string
	 */
	protected function get_less_file_name() {
		return PRESSCORE_THEME_DIR . '/css/dynamic-less/elementor/the7-photo-scroller-widget.less';
	}

	/**
	 * Specify a vars to be inserted in to a less file.
	 */
	protected function less_vars( The7_Elementor_Less_Vars_Decorator_Interface $less_vars ) {
		// For project icon style, see `selectors` in settings declaration.

		$settings = $this->get_settings_for_display();

		$less_vars->add_keyword(
			'unique-shortcode-class-name',
			$this->get_unique_class() . '.photo-scroller',
			'~"%s"'
		);

		if ( ! empty( $settings['arrows']) || ! empty( $settings['arrows_tablet']) || ! empty( $settings['arrows_mobile'])) {
			$less_vars->add_keyword( 'arrow-right-v-position', $settings['r_arrow_v_position'] ? $settings['r_arrow_v_position'] : 'center' );
			$less_vars->add_keyword( 'arrow-right-v-position-tablet',  $settings['r_arrow_v_position_tablet'] ?  $settings['r_arrow_v_position_tablet'] :  $settings['r_arrow_v_position'] );
			if ( ! empty( $settings['r_arrow_v_position_tablet'])) {
				$less_vars->add_keyword( 'arrow-right-v-position-mobile', $settings['r_arrow_v_position_mobile'] ? $settings['r_arrow_v_position_mobile'] : $settings['r_arrow_v_position_tablet'] );
			}else{
				$less_vars->add_keyword( 'arrow-right-v-position-mobile', $settings['r_arrow_v_position_mobile'] ? $settings['r_arrow_v_position_mobile'] : $settings['r_arrow_v_position'] );
			}

			$less_vars->add_keyword( 'arrow-right-h-position', $settings['r_arrow_h_position'] ? $settings['r_arrow_h_position'] : 'right' );
			$less_vars->add_keyword( 'arrow-right-h-position-tablet', $settings['r_arrow_h_position_tablet'] ? $settings['r_arrow_h_position_tablet'] : $settings['r_arrow_h_position'] );
			if ( ! empty( $settings['r_arrow_h_position_tablet'])) {
				$less_vars->add_keyword( 'arrow-right-h-position-mobile', $settings['r_arrow_h_position_mobile'] ? $settings['r_arrow_h_position_mobile'] : $settings['r_arrow_h_position_tablet'] );
			}else {
				$less_vars->add_keyword( 'arrow-right-h-position-mobile', $settings['r_arrow_h_position_mobile'] ? $settings['r_arrow_h_position_mobile'] : $settings['r_arrow_h_position'] );
			}

			$r_arrow_v_offset       = array_merge( [ 'size' => 0 ], array_filter( $settings['r_arrow_v_offset'] ) );
			$r_arrow_v_offset_tablet = array_merge(
				$r_arrow_v_offset,
				$this->unset_empty_value( $settings['r_arrow_v_offset_tablet'] )
			);
			$r_arrow_v_offset_mobile = array_merge(
				$r_arrow_v_offset_tablet,
				$this->unset_empty_value( $settings['r_arrow_v_offset_mobile'] )
			);

			$less_vars->add_pixel_or_percent_number( 'r-arrow-v-position', $r_arrow_v_offset );
			$less_vars->add_pixel_or_percent_number( 'r-arrow-v-position-tablet', $r_arrow_v_offset_tablet );
			$less_vars->add_pixel_or_percent_number( 'r-arrow-v-position-mobile', $r_arrow_v_offset_mobile );

			$r_arrow_h_offset       = array_merge( [ 'size' => 0 ], array_filter( $settings['r_arrow_h_offset'] ) );
			$r_arrow_h_offset_tablet = array_merge(
				$r_arrow_h_offset,
				$this->unset_empty_value( $settings['r_arrow_h_offset_tablet'] )
			);
			$r_arrow_h_offset_mobile = array_merge(
				$r_arrow_h_offset_tablet,
				$this->unset_empty_value( $settings['r_arrow_h_offset_mobile'] )
			);
			$less_vars->add_pixel_or_percent_number( 'r-arrow-h-position', $r_arrow_h_offset );
			$less_vars->add_pixel_or_percent_number( 'r-arrow-h-position-tablet', $r_arrow_h_offset_tablet );
			$less_vars->add_pixel_or_percent_number( 'r-arrow-h-position-mobile', $r_arrow_h_offset_mobile );

			$less_vars->add_keyword( 'arrow-left-v-position', $settings['l_arrow_v_position'] ? $settings['l_arrow_v_position'] : 'center' );
			$less_vars->add_keyword( 'arrow-left-v-position-tablet', $settings['l_arrow_v_position_tablet'] ? $settings['l_arrow_v_position_tablet'] : $settings['l_arrow_v_position'] );
			if ( ! empty( $settings['l_arrow_v_position_tablet'])) {
				$less_vars->add_keyword( 'arrow-left-v-position-mobile', $settings['l_arrow_v_position_mobile'] ? $settings['l_arrow_v_position_mobile'] : $settings['l_arrow_v_position_tablet'] );
			}else{
				$less_vars->add_keyword( 'arrow-left-v-position-mobile', $settings['l_arrow_v_position_mobile'] ? $settings['l_arrow_v_position_mobile'] : $settings['l_arrow_v_position'] );
			}

			$less_vars->add_keyword( 'arrow-left-h-position', $settings['l_arrow_h_position'] ? $settings['l_arrow_h_position'] : 'left' );
			$less_vars->add_keyword( 'arrow-left-h-position-tablet', $settings['l_arrow_h_position_tablet'] ? $settings['l_arrow_h_position_tablet'] : $settings['l_arrow_h_position'] );
			if ( ! empty( $settings['l_arrow_h_position_tablet'])) {
				$less_vars->add_keyword( 'arrow-left-h-position-mobile', $settings['l_arrow_h_position_mobile'] ? $settings['l_arrow_h_position_mobile'] : $settings['l_arrow_h_position_tablet'] );
			}else{
				$less_vars->add_keyword( 'arrow-left-h-position-mobile', $settings['l_arrow_h_position_mobile'] ? $settings['l_arrow_h_position_mobile'] : $settings['l_arrow_h_position'] );
			}

			$l_arrow_v_offset       = array_merge( [ 'size' => 0 ], array_filter( $settings['l_arrow_v_offset'] ) );
			$l_arrow_v_offset_tablet = array_merge(
				$l_arrow_v_offset,
				$this->unset_empty_value( $settings['l_arrow_v_offset_tablet'] )
			);
			$l_arrow_v_offset_mobile = array_merge(
				$l_arrow_v_offset_tablet,
				$this->unset_empty_value( $settings['l_arrow_v_offset_mobile'] )
			);
			$less_vars->add_pixel_or_percent_number( 'l-arrow-v-position', $l_arrow_v_offset );
			$less_vars->add_pixel_or_percent_number( 'l-arrow-v-position-tablet', $l_arrow_v_offset_tablet );
			$less_vars->add_pixel_or_percent_number( 'l-arrow-v-position-mobile', $l_arrow_v_offset_mobile );

			$l_arrow_h_offset       = array_merge( [ 'size' => 0 ], array_filter( $settings['l_arrow_h_offset'] ) );
			$l_arrow_h_offset_tablet = array_merge(
				$l_arrow_h_offset,
				$this->unset_empty_value( $settings['l_arrow_h_offset_tablet'] )
			);
			$l_arrow_h_offset_mobile = array_merge(
				$l_arrow_h_offset_tablet,
				$this->unset_empty_value( $settings['l_arrow_h_offset_mobile'] )
			);
			$less_vars->add_pixel_or_percent_number( 'l-arrow-h-position', $l_arrow_h_offset );
			$less_vars->add_pixel_or_percent_number( 'l-arrow-h-position-tablet', $l_arrow_h_offset_tablet );
			$less_vars->add_pixel_or_percent_number( 'l-arrow-h-position-mobile', $l_arrow_h_offset_mobile );
		}
	}
}
