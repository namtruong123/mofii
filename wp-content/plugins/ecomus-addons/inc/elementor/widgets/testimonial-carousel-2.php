<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Testimonial Carousel 2 widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Testimonial_Carousel_2 extends Carousel_Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Image Box widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-testimonial-carousel-2';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Image Box widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Testimonial Carousel 2', 'ecomus-addons' );
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
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

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
			'testimonial_icon_type',
			[
				'label' => __( 'Icon Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'icon' => __( 'Icon', 'ecomus-addons' ),
					'image' => __( 'Image', 'ecomus-addons' ),
					'external' => __( 'External', 'ecomus-addons' ),
				],
				'default' => 'icon',
			]
		);

		$repeater->add_control(
			'testimonial_icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'testimonial_icon_type' => 'icon',
				],
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
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'testimonial_icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'testimonial_icon_url',
			[
				'label' => __( 'External Icon URL', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'testimonial_icon_type' => 'external',
				],
			]
		);

		$repeater->add_control(
			'testimonial_text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Customer from USA', 'ecomus-addons' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
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
				'default' => 5,
			]
		);

		$repeater->add_control(
			'testimonial_product_id',
			[
				'label'       => esc_html__( 'Product', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => false,
				'source'      => 'product',
				'sortable'    => true,
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
					],
					[
						'testimonial_name'    => __( 'Name #2', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #3', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #4', 'ecomus-addons' ),
					]
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Carousel Settings
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Carousel Settings', 'ecomus-addons' ),
			]
		);

		$controls = [
			'slides_to_show'  => 3,
			'slides_to_scroll' => 1,
			'space_between'   => 30,
			'navigation'      => 'arrows',
			'autoplay'        => '',
			'autoplay_speed'  => 3000,
			'animation_speed' => 800,
			'infinite'        => '',
		];

		$this->register_carousel_controls($controls);

		$this->add_responsive_control(
			'slidesperview_auto',
			[
				'label' => __( 'Slides Per View Auto', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'ecomus-addons' ),
				'label_on'  => __( 'On', 'ecomus-addons' ),
				'default'   => '',
				'responsive' => true,
				'frontend_available' => true,
				'prefix_class' => 'ecomus%s-slidesperview-auto--'
			]
		);

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

		$this->add_control(
			'item_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_border',
				'selector'  => '{{WRAPPER}} .ecomus-testimonial-carousel-2__item::before',
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__item::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__item' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__item::before' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__image' => '--em-image-rounded: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rating_heading',
			[
				'label' => esc_html__( 'Rating', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'rating_size',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__rating.star-rating' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Color Active', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__rating.star-rating .user-rating' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__rating' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-2__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_heading',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-2__content',
			]
		);

		$this->add_responsive_control(
			'content_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'name_heading',
			[
				'label' => esc_html__( 'Name', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-2__name',
			]
		);

		$this->add_responsive_control(
			'name_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_heading',
			[
				'label' => esc_html__( 'Icon', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__text .ecomus-testimonial-carousel-2__text-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__text .ecomus-testimonial-carousel-2__text-icon' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__text.icon-type-image .ecomus-testimonial-carousel-2__text-icon' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__text .ecomus-testimonial-carousel-2__text-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__text .ecomus-testimonial-carousel-2__text-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->add_control(
			'text_heading',
			[
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-2__text',
			]
		);

		$this->add_responsive_control(
			'text_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->section_style_product();

		$this->section_style_carousel();
	}

	protected function section_style_product() {
		$this->start_controls_section(
			'section_product_style',
			[
				'label'     => __( 'Product', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_gap',
			[
				'label'      => esc_html__( 'Gap', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__product' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__product' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-2__product' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'product_border',
				'selector'  => '{{WRAPPER}} .ecomus-testimonial-carousel-2__product',
			]
		);

		$this->add_control(
			'product_image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'product_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-2__product-title',
			]
		);

		$this->add_control(
			'product_title_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_title_color_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_title_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_price_heading',
			[
				'label' => esc_html__( 'Price', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

			$this->start_controls_tab(
				'tab_button_normal',
				[
					'label' => __( 'Normal', 'ecomus-addons' ),
				]
			);

				$this->add_control(
					'product_button_color',
					[
						'label'     => esc_html__( 'Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-button' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'product_button_background_color',
					[
						'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-button' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'product_button_border_color',
					[
						'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-button' => 'border-color: {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_button_hover',
				[
					'label' => __( 'Hover', 'ecomus-addons' ),
				]
			);
				$this->add_control(
					'product_button_color_hover',
					[
						'label'     => esc_html__( 'Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-button:hover' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'product_button_background_color_hover',
					[
						'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-button:hover' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'product_button_border_color_hover',
					[
						'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .ecomus-testimonial-carousel-2__product-button:hover' => 'border-color: {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_style_carousel() {
		$this->start_controls_section(
			'section_carousel_style',
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
				'default' => 'center',
				'options' => [
					'bottom' => __( 'Left Bottom', 'ecomus-addons' ),
					'center' => __( 'Center Center', 'ecomus-addons' ),
				],
				'prefix_class' => 'ecomus-testimonial__navigation-position--',
			]
		);

		$this->register_carousel_style_controls( 'outline' );

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

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

		$this->add_render_attribute( 'container', 'class', [ 'ecomus-testimonial-carousel-2', 'ecomus-carousel--slidesperview-auto' ] );
		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-carousel--elementor', 'swiper' ] );
		$this->add_render_attribute( 'wrapper', 'style', $this->render_space_between_style() );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-testimonial-carousel-2__inner', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
		$this->add_render_attribute( 'item', 'class', [ 'ecomus-testimonial-carousel-2__item', 'swiper-slide' ] );

		$this->add_render_attribute( 'image', 'class', [ 'ecomus-testimonial-carousel-2__image' ] );
		$this->add_render_attribute( 'summary', 'class', [ 'ecomus-testimonial-carousel-2__summary' ] );

		$this->add_render_attribute( 'rating', 'class', [ 'ecomus-testimonial-carousel-2__rating', 'star-rating' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-testimonial-carousel-2__title', 'em-font-semibold' ] );
		$this->add_render_attribute( 'content', 'class', [ 'ecomus-testimonial-carousel-2__content' ] );
		$this->add_render_attribute( 'name', 'class', [ 'ecomus-testimonial-carousel-2__name', 'em-font-semibold' ] );
		$this->add_render_attribute( 'text', 'class', [ 'ecomus-testimonial-carousel-2__text' ] );

		$this->add_render_attribute( 'product', 'class', [ 'ecomus-testimonial-carousel-2__product', 'em-flex', 'em-flex-align-center' ] );
		$this->add_render_attribute( 'product_image', 'class', [ 'ecomus-testimonial-carousel-2__product-image' ] );
		$this->add_render_attribute( 'product_summary', 'class', [ 'ecomus-testimonial-carousel-2__product-summary' ] );
		$this->add_render_attribute( 'product_title', 'class', [ 'ecomus-testimonial-carousel-2__product-title' ] );
		$this->add_render_attribute( 'product_price', 'class', [ 'ecomus-testimonial-carousel-2__product-price', 'em-flex' ] );
		$this->add_render_attribute( 'product_button', 'class', [ 'ecomus-testimonial-carousel-2__product-button', 'em-flex-center', 'em-flex-align-center' ] );
	?>
		<div <?php echo $this->get_render_attribute_string( 'container' );?>>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' );?>>
				<div <?php echo $this->get_render_attribute_string( 'inner' );?>>
				<?php foreach( $settings['testimonials'] as $testimonial ) : ?>
					<?php
						$icon_exist = true;

						if ( 'image' == $testimonial['testimonial_icon_type'] ) {
							$icon_exist = ! empty($testimonial['testimonial_image']) ? true : false;
						} elseif ( 'external' == $testimonial['testimonial_icon_type'] ) {
							$icon_exist = ! empty($testimonial['testimonial_icon_url']) ? true : false;
						} else {
							$icon_exist = ! empty($testimonial['testimonial_icon']) && ! empty($testimonial['testimonial_icon']['value']) ? true : false;
						}
					?>
					<div <?php echo $this->get_render_attribute_string( 'item' );?> data-image="<?php echo ! empty( $testimonial['image']['url'] ) ? 'true' : 'false'; ?>">
						<?php if ( ! empty( $testimonial['image']['url'] ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'image' );?>>
								<?php
									$settings['image'] = $testimonial['image'];
									$settings['image_size'] = 'full';
									echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
								?>
							</div>
						<?php endif; ?>
						<div <?php echo $this->get_render_attribute_string( 'summary' );?>>
							<div <?php echo $this->get_render_attribute_string( 'rating' ); ?>><?php echo $this->star_rating_html( $testimonial['testimonial_rating'] ); ?></div>
							<?php if(  ! empty( $testimonial['testimonial_title'] ) ) : ?>
								<div <?php echo $this->get_render_attribute_string( 'title' );?>><?php echo wp_kses_post( $testimonial['testimonial_title'] ); ?></div>
							<?php endif; ?>
							<?php if(  ! empty( $testimonial['testimonial_content'] ) ) : ?>
								<div <?php echo $this->get_render_attribute_string( 'content' );?>><?php echo wp_kses_post( $testimonial['testimonial_content'] ); ?></div>
							<?php endif; ?>
							<?php if(  ! empty( $testimonial['testimonial_name'] ) ) : ?>
								<div <?php echo $this->get_render_attribute_string( 'name' );?>><?php echo wp_kses_post( $testimonial['testimonial_name'] ); ?></div>
							<?php endif; ?>
							<?php if(  ! empty( $testimonial['testimonial_text'] ) || $icon_exist ) : ?>
								<div class="ecomus-testimonial-carousel-2__text icon-type-<?php echo $testimonial['testimonial_icon_type']; ?>">
									<?php
									if( $icon_exist ) {
										if ( 'image' == $testimonial['testimonial_icon_type'] ) {
											if( ! empty( $testimonial['testimonial_image'] ) && ! empty( $testimonial['testimonial_image']['url'] ) ) :
												$testimonial['image_size'] = 'thumbnail';
												echo '<span class="ecomus-testimonial-carousel-2__text-icon">';
													echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $testimonial ) );
												echo '</span>';
											endif;
										} elseif ( 'external' == $testimonial['testimonial_icon_type'] ) {
											echo '<span class="ecomus-testimonial-carousel-2__text-icon">';
												echo $testimonial['testimonial_icon_url'] ? sprintf( '<img alt="%s" src="%s">', esc_attr( $testimonial['testimonial_name'] ), esc_url( $testimonial['testimonial_icon_url'] ) ) : '';
											echo '</span>';
										} else {
											echo '<span class="ecomus-svg-icon ecomus-testimonial-carousel-2__text-icon">';
												Icons_Manager::render_icon( $testimonial['testimonial_icon'], [ 'aria-hidden' => 'true' ] );
											echo '</span>';
										}
									}
									?>
									<?php echo wp_kses_post( $testimonial['testimonial_text'] ); ?>
								</div>
							<?php endif; ?>

							<?php
								$product_id = $testimonial[ 'testimonial_product_id' ];

								if( ! empty( $product_id ) ) :
									$product = wc_get_product( $product_id );
									if( ! empty( $product ) ) :?>
										<div <?php echo $this->get_render_attribute_string( 'product' ); ?>>
											<div <?php echo $this->get_render_attribute_string( 'product_image' ); ?>>
												<?php echo $product->get_image(); ?>
											</div>
											<div <?php echo $this->get_render_attribute_string( 'product_summary' ); ?>>
												<span <?php echo $this->get_render_attribute_string( 'product_title' ); ?>>
													<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
												</span>
												<div <?php echo $this->get_render_attribute_string( 'product_price' ); ?>>
													<?php echo wp_kses_post( $product->get_price_html() ); ?>
												</div>
											</div>
											<a <?php echo $this->get_render_attribute_string( 'product_button' ); ?> href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" aria-label=<?php esc_attr_e('Testimonial Product Link', 'ecomus-addons'); ?>>
												<?php echo \Ecomus\Addons\Helper::get_svg( 'arrow-top' ); ?>
											</a>
										</div>
									<?php endif; ?>
								<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
				<?php echo $this->render_pagination(); ?>
			</div>
		<?php echo $this->render_arrows(); ?>
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