<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Ecomus\Addons\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Testimonial Carousel widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Testimonial_Carousel extends Carousel_Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Image Box widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-testimonial-carousel';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Image Box widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Testimonial Carousel', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve Image Box widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	/**
	 * Get widget categories
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return string Widget categories
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

	/**
	 * Get widget keywords.
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'testimonial carousel', 'carousel', 'testimonial', 'ecomus' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
		];
	}


	/**
	 * Register heading widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'testimonial_title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Our customers reviews', 'ecomus-addons' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'testimonial_subtitle',
			[
				'label' => __( 'Subtitle', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'testimonial_quote',
			[
				'label' => __( 'Quote Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
			]
		);

		$repeater->add_control(
			'testimonial_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'rows' => '10',
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
			]
		);

		$repeater->add_control(
			'testimonial_image',
			[
				'label' => __( 'Choose Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'testimonial_image',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'testimonial_image_2',
			[
				'label' => __( 'Choose Image 2', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'testimonial_image_2',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'testimonial_name',
			[
				'label' => __( 'Name', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'ecomus-addons' ),
				'label_block' => true,
				'separator' => 'before',
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'testimonial_company',
			[
				'label' => __( 'Company/Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Company Name', 'ecomus-addons' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'testimonial_link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
			]
		);

		$repeater->add_control(
			'testimonial_rating',
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
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => __( 'Testimonials', 'ecomus-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ testimonial_name }}}',
				'default' => [
					[
						'testimonial_name'    => __( 'Name #1', 'ecomus-addons' ),
						'testimonial_company' => __( 'Company #1', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #2', 'ecomus-addons' ),
						'testimonial_company' => __( 'Company #2', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #3', 'ecomus-addons' ),
						'testimonial_company' => __( 'Company #3', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #4', 'ecomus-addons' ),
						'testimonial_company' => __( 'Company #4', 'ecomus-addons' ),
					]
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Carousel Settings
		$this->start_controls_section(
			'section_products_carousel',
			[
				'label' => __( 'Carousel Settings', 'ecomus-addons' ),
			]
		);

		$controls = [
			'navigation' 						=> 'arrows',
			'autoplay' 							=> '',
			'autoplay_speed'      				=> 3000,
			'pause_on_hover'    				=> 'yes',
			'animation_speed'  					=> 800,
			'infinite'  						=> '',
		];

		$this->register_carousel_controls($controls);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => __( 'Testimonial Item', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel--elementor' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel--elementor' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_thumbnail_style',
			[
				'label'     => __( 'Thumbnail', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'thumbnail_width',
			[
				'label'      => esc_html__( 'Width', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial__image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}}.ecomus-testimonial__image-position--left .ecomus-testimonial__image' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.ecomus-testimonial__image-position--right .ecomus-testimonial__image' => 'padding-left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}.ecomus-testimonial__image-position--left .ecomus-testimonial__image' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: 0;',
					'.ecomus-rtl-smart {{WRAPPER}}.ecomus-testimonial__image-position--right .ecomus-testimonial__image' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: 0;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Width', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial__inner' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'space_between',
			[
				'label'     => __( 'Gap', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 250,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'image_item_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_item_position',
			[
				'label'   => __( 'Position', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left' 	=> __( 'Left', 'ecomus-addons' ),
					'right' => __( 'Right', 'ecomus-addons' ),
				],
				'prefix_class' => 'ecomus-testimonial__image-position--',
			]
		);

		$this->add_control(
			'image_item_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial__photo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial__photo img' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image1_item_heading',
			[
				'label' => esc_html__( 'Image 1', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_item_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial__thumbnail-item[data-image="2"] .ecomus-testimonial__photo-1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial__thumbnail-item[data-image="2"] .ecomus-testimonial__photo-1' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'quoter_item_heading',
			[
				'label' => esc_html__( 'Quoter Icon', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'quoter_item_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__quote' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'quoter_item_size',
			[
				'label'     => __( 'Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__quote' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_item_title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_item_title_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_item_title_typo',
				'selector' => '{{WRAPPER}} .ecomus-testimonial__title',
			]
		);

		$this->add_responsive_control(
			'content_item_title_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_item_subtitle_heading',
			[
				'label' => esc_html__( 'Subtitle', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_item_subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_item_subtitle_typo',
				'selector' => '{{WRAPPER}} .ecomus-testimonial__subtitle',
			]
		);

		$this->add_responsive_control(
			'content_item_subtitle_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_item_content_heading',
			[
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_item_content_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_item_content_typo',
				'selector' => '{{WRAPPER}} .ecomus-testimonial__description',
			]
		);

		$this->add_responsive_control(
			'content_item_content_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__description' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_item_name_heading',
			[
				'label' => esc_html__( 'Name', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label'        => esc_html__( 'Show Divider', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ecomus-addons' ),
				'label_off'    => esc_html__( 'Hide', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'ecomus-testimonial__divider-',
			]
		);

		$this->add_control(
			'content_item_name_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_item_name_typo',
				'selector' => '{{WRAPPER}} .ecomus-testimonial__name',
			]
		);

		$this->add_responsive_control(
			'content_item_name_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__information' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_item_company_heading',
			[
				'label' => esc_html__( 'Company', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_item_company_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__company' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_item_company_color_hover',
			[
				'label'     => esc_html__( 'Color Hover', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__company:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_item_company_typo',
				'selector' => '{{WRAPPER}} .ecomus-testimonial__company',
			]
		);

		$this->add_control(
			'content_item_rating_heading',
			[
				'label' => esc_html__( 'Rating', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_item_rating_size',
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
					'{{WRAPPER}} .ecomus-testimonial__rating.star-rating' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_item_rating_color',
			[
				'label'     => esc_html__( 'Color Active', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__rating.star-rating .user-rating' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_item_rating_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial__rating' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		$this->section_style_carousel();
	}

	protected function section_style_carousel() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'   => __( 'Arrows Position', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Left Bottom', 'ecomus-addons' ),
					'center' => __( 'Center Center', 'ecomus-addons' ),
				],
				'prefix_class' => 'ecomus-testimonial__navigation-position--',
			]
		);

		$this->register_carousel_style_controls( 'outline-dark', true );

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'ecomus-testimonial-carousel--elementor',
			'ecomus-carousel--elementor',
			'em-flex',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$this->add_render_attribute( 'wrapper', 'style', $this->render_space_between_style( $settings['space_between']['size'] ) );

		$gallery = $thumbnails = array();

		foreach( $settings['testimonials'] as $index => $slide ) {
			$wrapper_gallery_key   = $this->get_repeater_setting_key( 'slide_wrapper_gallery', 'testimonial', $index );
			$wrapper_thumbnail_key = $this->get_repeater_setting_key( 'slide_wrapper_thumbnails', 'testimonial', $index );
			$img_key               = $this->get_repeater_setting_key( 'image', 'testimonial', $index );
			$img_key_2             = $this->get_repeater_setting_key( 'image_2', 'testimonial', $index );
			$name_key              = $this->get_repeater_setting_key( 'name', 'testimonial', $index );
			$company_key           = $this->get_repeater_setting_key( 'company', 'testimonial', $index );
			$link_key          	   = $this->get_repeater_setting_key( 'link', 'testimonial', $index );
			$title_key             = $this->get_repeater_setting_key( 'title', 'testimonial', $index );
			$subtitle_key          = $this->get_repeater_setting_key( 'subtitle', 'testimonial', $index );
			$desc_key              = $this->get_repeater_setting_key( 'desc', 'testimonial', $index );
			$rating_key            = $this->get_repeater_setting_key( 'rating', 'testimonial', $index );

			$this->add_render_attribute( $wrapper_gallery_key, 'class', [ 'ecomus-testimonial__gallery-item', 'swiper-slide' ] );
			$this->add_render_attribute( $wrapper_thumbnail_key, 'class', [ 'ecomus-testimonial__thumbnail-item', 'swiper-slide' ] );
			$this->add_render_attribute( $img_key, 'class', [ 'ecomus-testimonial__photo', 'ecomus-testimonial__photo-1' ] );
			$this->add_render_attribute( $img_key_2, 'class', [ 'ecomus-testimonial__photo', 'ecomus-testimonial__photo-2' ] );
			$this->add_render_attribute( $name_key, 'class', 'ecomus-testimonial__name em-font-semibold' );
			$this->add_render_attribute( $company_key, 'class', 'ecomus-testimonial__company em-font-semibold' );
			$this->add_render_attribute( $link_key, 'class', 'ecomus-testimonial__link' );
			$this->add_render_attribute( $title_key, 'class', 'ecomus-testimonial__title' );
			$this->add_render_attribute( $subtitle_key, 'class', [ 'ecomus-testimonial__subtitle', 'em-font-bold' ] );
			$this->add_render_attribute( $desc_key, 'class', 'ecomus-testimonial__description' );
			$this->add_render_attribute( $rating_key, 'class', [ 'ecomus-testimonial__rating', 'star-rating' ] );

			$image = '<div ' . $this->get_render_attribute_string( $img_key ) . '>';
			if ( $slide['testimonial_image']['url'] ) {
				$image .= Group_Control_Image_Size::get_attachment_image_html( $slide, 'testimonial_image' );
			}
			$image .= '</div>';

			$image_2 = '<div ' . $this->get_render_attribute_string( $img_key_2 ) . '>';
			if ( $slide['testimonial_image_2']['url'] ) {
				$image_2 .= Group_Control_Image_Size::get_attachment_image_html( $slide, 'testimonial_image_2' );
			}
			$image_2 .= '</div>';

			$title    = $slide['testimonial_title'] ? '<h4 ' . $this->get_render_attribute_string( $title_key ) . '>'. wp_kses_post( $slide['testimonial_title'] ) .'</h4>' : '';
			$subtitle = $slide['testimonial_subtitle'] ? '<div ' . $this->get_render_attribute_string( $subtitle_key ) . '>'. wp_kses_post( $slide['testimonial_subtitle'] ) .'</div>' : '';
			$content  = $slide['testimonial_content'] ? '<div ' . $this->get_render_attribute_string( $desc_key ) . '>'. wp_kses_post( $slide['testimonial_content'] ) .'</div>' : '';
			$rating   = $slide['testimonial_rating'] ? '<div ' . $this->get_render_attribute_string( $rating_key ) . '>'. $this->star_rating_html( $slide['testimonial_rating'] ) .'</div>' : '';
			$name     = $slide['testimonial_name'] ? '<div ' . $this->get_render_attribute_string( $name_key ) . '>'. esc_html( $slide['testimonial_name'] ) .'</div>' : '';

			$a_open = $a_close = '';
			if( ! empty( $slide['testimonial_link']['url'] ) ) {
				$a_open = '<a href="'. esc_url( $slide['testimonial_link']['url'] ) .'">';
				$a_close = '</a>';
			}

			$company  = $slide['testimonial_company'] ? '<div ' . $this->get_render_attribute_string( $company_key ) . '>'. $a_open .'<span class="text em-font-normal">'. esc_html__( 'Purchase item:', 'ecomus-addons' ) . '</span> '. $slide['testimonial_company'] . $a_close .'</div>' : '';

			$quote = '';
			if ( ! empty($slide['testimonial_quote']) && ! empty($slide['testimonial_quote']['value']) ) {
				$quote = '<span class="ecomus-svg-icon">'. $this->get_icon_html( $slide['testimonial_quote'], [ 'aria-hidden' => 'true' ] ) .'</span>';
			} else {
				$quote = \Ecomus\Addons\Helper::get_svg( 'quote' );
			}

			$gallery[] = sprintf(
				'<div %s>
					<div class="ecomus-testimonial__gallery-content">
						%s
						<div class="ecomus-testimonial__quote">%s</div>
						%s
						%s
						%s
						<div class="ecomus-testimonial__information">
							<div class="ecomus-testimonial__information-image hidden-sm hidden-md hidden-lg">
								%s
							</div>
							<div class="ecomus-testimonial__information-content">
								%s
								%s
							</div>
						</div>
					</div>
				</div>',
				$this->get_render_attribute_string( $wrapper_gallery_key ),
				$title,
				$quote,
				$subtitle,
				$rating,
				$content,
				$image,
				$name,
				$company,
			);

			$thumbnails[] = sprintf(
				'<div %s data-image="%s">%s%s</div>',
				$this->get_render_attribute_string( $wrapper_thumbnail_key ),
				! empty( $slide['testimonial_image_2']['url'] ) ? 2 : 1,
				$image,
				$image_2,
			);
		}

		$gallery = sprintf(
			'<div class="ecomus-testimonial__gallery swiper">
				<div class="ecomus-testimonial__gallery-wrapper swiper-wrapper">
					%s
				</div>
			</div>',
			implode( '', $gallery ),
		);

		$thumbnails = sprintf(
			'<div class="ecomus-testimonial__thumbnail swiper">
				<div class="ecomus-testimonial__thumbnail-wrapper swiper-wrapper">
					%s
				</div>
			</div>',
			implode( '', $thumbnails ),
		);

		echo sprintf(
			'<div %s>
				<div class="ecomus-testimonial__inner">
					%s
					%s
					%s
				</div>
				<div class="ecomus-testimonial__image hidden-xs">
					%s
				</div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$gallery,
			$this->render_arrows('swiper-button-small'),
			$this->render_pagination(),
			$thumbnails,
		);
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

	/**
	 * @param array $icon
	 * @param array $attributes
	 * @param $tag
	 * @return bool|mixed|string
	 */
	function get_icon_html( array $icon, array $attributes, $tag = 'i' ) {
		/**
		 * When the library value is svg it means that it's a SVG media attachment uploaded by the user.
		 * Otherwise, it's the name of the font family that the icon belongs to.
		 */
		if ( 'svg' === $icon['library'] ) {
			$output = Icons_Manager::render_uploaded_svg_icon( $icon['value'] );
		} else {
			$output = Icons_Manager::render_font_icon( $icon, $attributes, $tag );
		}
		return $output;
	}
}