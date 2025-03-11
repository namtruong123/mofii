<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Stroke;
use \Ecomus\Addons\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Slides widget
 */
class Slides extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-slides';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Slides', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

	/**
	 * Scripts
	 *
	 * @return void
	 */
	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_content_slides();
		$this->section_slider_options();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'ecomus-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );


		$repeater->start_controls_tab( 'text_content', [ 'label' => esc_html__( 'Content', 'ecomus-addons' ) ] );

		$repeater->add_control(
			'before_title',
			[
				'label'       => esc_html__( 'Before Title', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Slide Title', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'sub_description',
			[
				'label'     => esc_html__( 'Sub Description', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'ecomus-addons' ),
				'label_off' => esc_html__( 'No', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'   => '',
			]
		);

		$repeater->add_control(
			'sub_description_rating',
			[
				'label'   => esc_html__( 'Rating', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0'    => __( 'None', 'ecomus-addons' ),
					'1'    => __( '1 Star', 'ecomus-addons' ),
					'2'    => __( '2 Stars', 'ecomus-addons' ),
					'3'    => __( '3 Stars', 'ecomus-addons' ),
					'4'    => __( '4 Stars', 'ecomus-addons' ),
					'5'    => __( '5 Stars', 'ecomus-addons' ),
				],
				'default'            => 5,
				'condition' => [
					'sub_description' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'sub_description_text',
			[
				'label'       => esc_html__( 'Text', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
				'condition' => [
					'sub_description' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_repeater_controls($repeater);

		$repeater->add_control(
			'button_link_type',
			[
				'label'   => esc_html__( 'Apply Primary Link On', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Button Only', 'ecomus-addons' ),
					'slide'  => esc_html__( 'Whole Slide', 'ecomus-addons' ),
				],
				'default' => 'only',
				'conditions' => [
					'terms' => [
						[
							'name' => 'button_link[url]',
							'operator' => '!=',
							'value' => '',
						],
						[
							'name' => 'button_second_text',
							'operator' => '==',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'button_second_heading',
			[
				'label' => esc_html__( 'Button Second', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'button_second_text',
			[
				'label'       => __( 'Text', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Click here', 'ecomus-addons' ),
			]
		);

		$repeater->add_control(
			'button_second_link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
				'default'     => [],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'ecomus-addons' ) ] );

		$repeater->add_responsive_control(
			'banner_background_img',
			[
				'label'    => __( 'Background Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/800x400/f1f1f1?text=image',
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}}:not(.swiper-lazy)' => 'background-image: url("{{URL}}");',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_size',
			[
				'label'     => esc_html__( 'Background Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'ecomus-addons' ),
					'contain' => esc_html__( 'Contain', 'ecomus-addons' ),
					'auto'    => esc_html__( 'Auto', 'ecomus-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}}' => 'background-size: {{VALUE}}',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position',
			[
				'label'     => esc_html__( 'Background Position', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'responsive' => true,
				'options'   => [
					''              => esc_html__( 'Default', 'ecomus-addons' ),
					'left top'      => esc_html__( 'Left Top', 'ecomus-addons' ),
					'left center'   => esc_html__( 'Left Center', 'ecomus-addons' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'ecomus-addons' ),
					'right top'     => esc_html__( 'Right Top', 'ecomus-addons' ),
					'right center'  => esc_html__( 'Right Center', 'ecomus-addons' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'ecomus-addons' ),
					'center top'    => esc_html__( 'Center Top', 'ecomus-addons' ),
					'center center' => esc_html__( 'Center Center', 'ecomus-addons' ),
					'center bottom' => esc_html__( 'Center Bottom', 'ecomus-addons' ),
					'initial' 		=> esc_html__( 'Custom', 'ecomus-addons' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}}' => 'background-position: {{VALUE}};',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_x',
			[
				'label' => esc_html__( 'X Position', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'responsive' => true,
				'size_units' => [ 'px', 'em', '%', 'vw' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
					'em' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}}' => 'background-position: {{SIZE}}{{UNIT}} {{background_position_y.SIZE}}{{background_position_y.UNIT}}',
				],
				'condition' => [
					'background_position' => [ 'initial' ],
				],
				'required' => true,
			]
		);

		$repeater->add_responsive_control(
			'background_position_y',
			[
				'label' => esc_html__( 'Y Position', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'responsive' => true,
				'size_units' => [ 'px', 'em', '%', 'vh' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
					'em' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}}' => 'background-position: {{background_position_x.SIZE}}{{background_position_x.UNIT}} {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'background_position' => [ 'initial' ],
				],
				'required' => true,
			]
		);

		$repeater->add_responsive_control(
			'background_repeat',
			[
				'label'     => esc_html__( 'Background Repeat', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'repeat'    => esc_html__( 'Repeat', 'ecomus-addons' ),
					'no-repeat' => esc_html__( 'No Repeat', 'ecomus-addons' ),
				],
				'default'   => 'no-repeat',
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}}' => 'background-repeat: {{VALUE}};',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_color',
			[
				'label'      => esc_html__( 'Background Overlay', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}}::before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => esc_html__( 'Style', 'ecomus-addons' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label'       => esc_html__( 'Custom', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set custom style that will only affect this specific slide.', 'ecomus-addons' ),
			]
		);

		$repeater->add_responsive_control(
			'custom_slides_horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => '',
				'selectors'            => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'custom_slides_vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'   => [
						'title' => esc_html__( 'Top', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'  => [
						'title' => esc_html__( 'Bottom', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'     => '',
				'selectors'            => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'   => 'flex-start',
					'middle' => 'center',
					'bottom'  => 'flex-end',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'custom_slides_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide' => 'text-align: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'content_heading_name',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'content_custom_bg_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide .ecomus-slide__content' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'title_heading_name',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'title_custom_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide .ecomus-slide__title' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_custom_text_stroke',
				'selector' => '{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide .ecomus-slide__title',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'desc_heading_name',
			[
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'content_custom_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide .ecomus-slide__description' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				]
			]
		);

		$repeater->add_control(
			'custom_button_options',
			[
				'label'        => __( 'Button', 'ecomus-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'ecomus-addons' ),
				'label_on'     => __( 'Custom', 'ecomus-addons' ),
				'return_value' => 'yes',
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->start_popover();

		$repeater->add_control(
			'custom_button_style_normal_heading',
			[
				'label' => esc_html__( 'Normal', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'custom_button_background_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide__button' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'custom_button_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide__button' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'custom_button_border_color',
			[
				'label' => __( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide__button' => 'border-color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'custom_button_style_hover_heading',
			[
				'label' => esc_html__( 'Hover', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

			$repeater->add_control(
				'custom_button_hover_background_color',
				[
					'label' => __( 'Background Color', 'ecomus-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide__button:hover' => 'background-color: {{VALUE}};',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'custom_style',
								'value' => 'yes',
							],
						],
					],
				]
			);

			$repeater->add_control(
				'custom_button_hover_color',
				[
					'label' => __( 'Color', 'ecomus-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide__button:hover' => 'color: {{VALUE}};',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'custom_style',
								'value' => 'yes',
							],
						],
					],
				]
			);

			$repeater->add_control(
				'custom_button_hover_border_color',
				[
					'label' => __( 'Border Color', 'ecomus-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ecomus-slides-elementor {{CURRENT_ITEM}} .ecomus-slide__button:hover' => 'border-color: {{VALUE}};',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'custom_style',
								'value' => 'yes',
							],
						],
					],
				]
			);

		$repeater->end_popover();

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides', 'ecomus-addons' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title'            => esc_html__( 'Slide 1 Title', 'ecomus-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ecomus-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'ecomus-addons' ),
					],
					[
						'title'          => esc_html__( 'Slide 2 Title', 'ecomus-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ecomus-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'ecomus-addons' ),
					],
					[
						'title'          => esc_html__( 'Slide 3 Title', 'ecomus-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ecomus-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'ecomus-addons' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label'     => esc_html__( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 650,
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slides-elementor__item' => 'height: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'button_icon_heading',
			[
				'label' => __( 'Button Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_icon_controls();

		$this->end_controls_section();
	}

	protected function section_slider_options() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'ecomus-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'effect',
			[
				'label'   => esc_html__( 'Effect', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'fade'   	 => esc_html__( 'Fade', 'ecomus-addons' ),
					'slide' 	 => esc_html__( 'Slide', 'ecomus-addons' ),
				],
				'default' => 'slide',
				'toggle'  => false,
				'frontend_available' => true,
			]
		);

		$controls = [
			'slides_to_show'   => 1,
			'slides_to_scroll' => 1,
			'navigation'       => 'dots',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

		$this->add_control(
			'center_mode',
			[
				'label'       => __( 'Center Mode', 'ecomus-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'ecomus-addons' ),
				'label_on'  => __( 'On', 'ecomus-addons' ),
				'frontend_available' => true,
				'prefix_class' => 'ecomus-centermode-auto--'
			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_button();
		$this->section_style_button_second();
		$this->section_style_carousel();
	}

	// Els
	protected function section_style_title() {
		$this->add_control(
			'heading_title',
			[
				'label'     => esc_html__( 'Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_text_stroke',
				'selector' => '{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
	}

	protected function section_style_before_title() {
		$this->add_control(
			'heading_before_title',
			[
				'label'     => esc_html__( 'Before Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'before_title_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'before_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title',
			]
		);


		$this->add_responsive_control(
			'before_title_background_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'before_title_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'before_title_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'before_title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__before-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);
	}

	protected function section_style_desc() {
		// Description
		$this->add_control(
			'heading_description',
			[
				'label'     => esc_html__( 'Description', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__description',
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'description_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__description' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);
	}

	protected function section_style_sub_desc() {
		// Description
		$this->add_control(
			'heading_sub_description',
			[
				'label'     => esc_html__( 'Sub Description Text', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'sub_description_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__sub-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_description_typography',
				'selector' => '{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__sub-description',
			]
		);

		$this->add_responsive_control(
			'sub_description_margin',
			[
				'label'      => esc_html__( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__sub-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .ecomus-slide .ecomus-slide__sub-description' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_sub_description_rating',
			[
				'label'     => esc_html__( 'Sub Description Rating', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'sub_description_rating_size',
			[
				'label'     => __( 'Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slide__sub-description .star-rating' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_description_rating_gap',
			[
				'label'     => __( 'Gap', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-slide__sub-description .star-rating' => '--em-rating-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sub_description_rating_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-slide__sub-description .star-rating .max-rating' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sub_description_rating_color_active',
			[
				'label'     => esc_html__( 'Color Active', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-slide__sub-description .star-rating .user-rating' => 'color: {{VALUE}};',
				],
			]
		);
	}

	protected function section_style_content() {
		$this->start_controls_section(
			'section_style_slides',
			[
				'label' => esc_html__( 'Slides', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slides_container_width',
			[
				'label'      => esc_html__( 'Container Width', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1900,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-slides-elementor .swiper-arrows' => 'max-width: {{SIZE}}{{UNIT}};',
					'(desktop){{WRAPPER}}.ecomus-centermode-auto--yes .swiper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .em-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .em-container' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slides-elementor__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .ecomus-slides-elementor__item' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'     => '',
				'selectors'            => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide' => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .ecomus-slide__sub-description' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'slides_vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'   => [
						'title' => esc_html__( 'Top', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'  => [
						'title' => esc_html__( 'Bottom', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'     => '',
				'selectors'            => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'   => 'flex-start',
					'middle' => 'center',
					'bottom'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'slides_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'slides_content_width',
			[
				'label'      => esc_html__( 'Width', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1900,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_content_background_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__content' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'slides_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slides_content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-slides-elementor .ecomus-slide__content' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->section_style_title();

		$this->section_style_before_title();

		$this->section_style_desc();

		$this->section_style_sub_desc();

		$this->end_controls_section();
	}

	protected function section_style_button() {
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();
	}

	protected function section_style_button_second() {
		$this->start_controls_section(
			'section_style_button_second',
			[
				'label' => esc_html__( 'Button Second', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_second_spacing_left',
			[
				'label'     => esc_html__( 'Spacing Left', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => 'margin-left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-button__second' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				],
			]
		);

		$this->add_control(
			'button_second_style',
			[
				'label'   => __( 'Style', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''             => __( 'Solid Dark', 'ecomus-addons' ),
					'light'        => __( 'Solid Light', 'ecomus-addons' ),
					'outline-dark' => __( 'Outline Dark', 'ecomus-addons' ),
					'outline'      => __( 'Outline Light', 'ecomus-addons' ),
					'subtle'       => __( 'Underline', 'ecomus-addons' ),
					'text'         => __( 'Text', 'ecomus-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'button_second_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-button__second' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-button__second' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_second_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-button__second' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_second_typography',
				'selector' => '{{WRAPPER}} .ecomus-button__second',
			]
		);

		$this->add_responsive_control(
			'button_second_min_width',
			[
				'label' => esc_html__( 'Min Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_second_min_height',
			[
				'label' => esc_html__( 'Min Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_second_border_width',
			[
				'label' => esc_html__( 'Border Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => [ 'outline-dark', 'outline' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_second_style' );

		$this->start_controls_tab(
			'tab_button_second_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'button_second_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_second_text_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_second_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_second_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'button_second_background_hover_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_second_hover_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_second_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_second_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button__second' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['']
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_style_carousel() {
		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Slider Options', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->add_control (
			'dots_position',
			[
				'label' => esc_html__( 'Position', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'bottom',
				'options' => [
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'ecomus-slides__dots-position-',
				'toggle' => false,
				'condition' => [
					'dots_type!' => 'line'
				]
			]
		);

		$this->add_responsive_control(
			'dot_align',
			[
				'label'       => esc_html__( 'Alignment', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-slides-elementor .swiper-pagination' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'dots_position' => 'bottom',
				],
			]
		);

		$this->add_responsive_control (
			'dot_align_position_right',
			[
				'label'       => esc_html__( 'Alignment', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}}.ecomus-slides__dots-position-right .ecomus-slides-elementor .swiper-pagination' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'condition' => [
					'dots_position' => 'right',
					'dots_type!' => 'line'
				],
			]
		);

		$this->add_responsive_control(
			'dot_position_right_spacing',
			[
				'label'     => esc_html__( 'Margin', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.ecomus-slides__dots-position-right .ecomus-slides-elementor .swiper-pagination-bullets' => 'right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}}.ecomus-slides__dots-position-right .ecomus-slides-elementor .swiper-pagination-bullets' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
				'condition' => [
					'dots_position' => 'right',
					'dots_type!' => 'line'
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-slides-elementor', 'ecomus-carousel--elementor', 'swiper' ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-slides-elementor__inner', 'swiper-wrapper' ] );

		$this->add_render_attribute( 'slide', 'class', [ 'ecomus-slide', 'em-container', 'em-flex' ] );
		$this->add_render_attribute( 'content', 'class', [ 'ecomus-slide__content' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-slide__title' ] );
		$this->add_render_attribute( 'before_title', 'class', [ 'ecomus-slide__before-title' ] );
		$this->add_render_attribute( 'description', 'class', [ 'ecomus-slide__description' ] );
		$this->add_render_attribute( 'button', 'class', [ 'ecomus-slide__button', 'em-button' ] );

		if ( ! empty( $settings['slides_content_background_color'] ) ) {
			$this->add_render_attribute( 'slide', 'class', [ 'ecomus-slide__content-background' ] );
		}
	?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
			<?php
				$slides_count = count( $settings['slides'] );
				$slide_classes = $slides_count == 1 ? 'swiper-slide-active' : '';
				foreach ( $settings['slides'] as $index => $slide ) {
					$button_classes = ' ecomus-slide__button';

					$sub_description 		= $this->get_repeater_setting_key( 'sub_description', 'slides', $index );
					$sub_desc_rating_key 	= $this->get_repeater_setting_key( 'sub_desc_rating', 'slides', $index );
					$sub_desc_text_key 		= $this->get_repeater_setting_key( 'sub_desc_text', 'slides', $index );
					$link_key 	  			= $this->get_repeater_setting_key( 'link', 'slides', $index );

					$this->add_render_attribute( $sub_description, 'class', [ 'ecomus-slide__sub-description', 'em-flex', 'em-flex-align-center' ] );
					$this->add_render_attribute( $sub_desc_rating_key, 'class', [ 'ecomus-slide__sub-description--rating', 'star-rating' ] );
					$this->add_render_attribute( $sub_desc_text_key, 'class', [ 'ecomus-slide__sub-description--text' ] );
					$this->add_link_attributes( $link_key, $slide['button_link'] );
					$this->add_render_attribute( $link_key, 'class', [ 'ecomus-slide__button--all', 'em-absolute' ] );
				?>
					<div class="elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?> ecomus-slides-elementor__item swiper-slide <?php echo esc_attr( $slide_classes ); ?>">
						<div <?php echo $this->get_render_attribute_string( 'slide' ); ?>>
							<?php
								if ( $slide['button_link_type'] == 'slide' ) {
									if( ! empty( $slide['button_link']['url'] ) ) {
										echo '<a '. $this->get_render_attribute_string( $link_key ) .'>';
										echo '<span class="screen-reader-text">'. $slide['button_text'] .'</span>';
										echo '</a>';
									}
								}
							?>
							<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
								<?php if ( $slide['before_title'] ) : ?>
									<div <?php echo $this->get_render_attribute_string( 'before_title' ); ?>><?php echo wp_kses_post( $slide['before_title'] ); ?></div>
								<?php endif; ?>

								<?php if ( $slide['title'] ) : ?>
									<h2 <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $slide['title'] ); ?></h2>
								<?php endif; ?>

								<?php if ( $slide['description'] ) : ?>
									<div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $slide['description'] ); ?></div>
								<?php endif; ?>

								<?php if ( $slide['sub_description'] == 'yes' ) : ?>
									<div <?php echo $this->get_render_attribute_string( $sub_description ); ?>>
										<div <?php echo $this->get_render_attribute_string( $sub_desc_rating_key ); ?>>
											<?php echo $this->star_rating_html( $slide['sub_description_rating'] ); ?>
										</div>
										<?php if ( $slide['sub_description_text'] ) : ?>
											<div <?php echo $this->get_render_attribute_string( $sub_desc_text_key ); ?>><?php echo wp_kses_post( $slide['sub_description_text'] ); ?></div>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<?php
									$slide['button_style'] = $settings['button_style'];
									$slide['button_classes'] = $button_classes;
									$this->render_button( $slide, $index );

									if( ! empty( $slide['button_second_text'] ) && ! empty( $slide['button_second_link']['url'] ) ) {
										$button_second = array(
											'button_text'    => $slide['button_second_text'],
											'button_link'    => $slide['button_second_link'],
											'button_style'   => $settings['button_second_style'],
											'button_classes' => ' ecomus-slide__button ecomus-button__second'
										);
										$this->render_button( $button_second, $index . '_second' );
									}
								?>
							</div>
						</div>
					</div>
				<?php
				}
			?>
			</div>
			<div class="swiper-arrows">
				<?php echo $this->render_arrows(); ?>
			</div>
			<?php
				$classes = ' em-container';
				echo $this->render_pagination( $classes );
			?>
		</div>
	<?php
	}

	public function star_rating_html( $count ) {
		$html = '<span class="max-rating rating-stars">'
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . '</span>';
		$html .= '<span class="user-rating rating-stars" style="width:' . ( ( $count / 5 ) * 100 ) . '%">'
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
		         . '</span>';

		$html .= '<span class="screen-reader-text">';

		$html .= '</span>';

		return $html;
	}
}