<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Categories_Carousel extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Get widget name.
	 *
	 * Retrieve Stores Location widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-categories-carousel';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Stores Location widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Product Categories Carousel', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve TeamMemberGrid widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-carousel';
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
				'label' => __( 'Categories', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'show_heading',
			[
				'label'        => __( 'Show heading with navigation', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => 'no',
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your heading', 'ecomus-addons' ),
				'label_block' => true,
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_navigation_type',
			[
				'label' => __( 'Navigation', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'arrows' => esc_html__('Arrows', 'ecomus-addons'),
					'dots'   => esc_html__('Dots', 'ecomus-addons'),
				],
				'default' => 'arrows',
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'ecomus-addons' ),
					'custom'  => esc_html__( 'Custom', 'ecomus-addons' ),
				],
				'default'     => 'default',
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'number',
			[
				'label'           => esc_html__( 'Item Per Page', 'ecomus-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 50,
				'default' 		=> '6',
				'frontend_available' => true,
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'ecomus-addons' ),
					'date'       => esc_html__( 'Date', 'ecomus-addons' ),
					'title'      => esc_html__( 'Title', 'ecomus-addons' ),
					'count'      => esc_html__( 'Count', 'ecomus-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'ecomus-addons' ),
				],
				'default'   => '',
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$repeater->add_control(
			'product_cat',
			[
				'label'       => esc_html__( 'Product Categories', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => false,
				'source'      => 'product_cat',
				'sortable'    => true,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field'   => '{{{ product_cat }}}',
				'condition'   => [
					'source' => 'custom',
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
			'hide_cat_title',
			[
				'label'     => esc_html__( 'Hide Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'default'	=> '',
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__title' => 'display: none;',
				],
			]
		);

		$this->add_control(
			'hide_cat_count',
			[
				'label'     => esc_html__( 'Hide Count', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'default'	=> '',
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__cat-count' => 'display: none;',
				],
			]
		);

		$this->add_control(
			'button_control_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_controls(true);

		$this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'horizontal' ] );

		$this->end_controls_section();

		$this->section_view_all_button_options();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$controls = [
			'slides_to_show'   => 4,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'both',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
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

		$this->add_responsive_control(
			'width',
			[
				'label'     => esc_html__( 'Width of slide item', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'responsive' => true,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition' => [
					'slidesperview_auto' => ['yes']
				],
				'selectors' => [
					'{{WRAPPER}}.ecomus-slidesperview-auto--yes .ecomus-categories-carousel__image' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_view_all_button_options() {
		$this->start_controls_section(
			'section_view_all_options',
			[
				'label' => esc_html__( 'View All Options', 'ecomus-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'view_all_btn_heading',
			[
				'label' => esc_html__( 'View All Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_view_all_btn',
			[
				'label'        => __( 'Show View All Button', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => 'no',
			]
		);

        $this->add_responsive_control(
			'view_all_btn_image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => wc_placeholder_img_src(),
				],
                'condition' => [
					'show_view_all_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_btn_title', [
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default'     => __( 'View All', 'ecomus-addons' ),
				'condition'   => [
					'show_view_all_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_btn_text', [
				'label' => esc_html__( 'Button Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default'     => __( 'Click here', 'ecomus-addons' ),
				'condition'   => [
					'show_view_all_btn' => 'yes',
				],
			]
		);

        $this->add_control(
			'view_all_btn_link',
			[
				'label'       => __( 'Button Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
				'default'     => [
					'url' => '#',
				],
				'condition'   => [
					'show_view_all_btn' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

    // Tab Style
	protected function section_style() {
		// Style
		$this->start_controls_section(
			'section_style_heading',
			[
				'label'     => __( 'Heading', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-categories-carousel__heading h4',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel__heading h4' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel__heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-categories-carousel__heading' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'   => esc_html__( 'Content position', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'side'  => esc_html__( 'Side on image', 'ecomus-addons' ),
					'below' => esc_html__( 'Below the image', 'ecomus-addons' ),
				],
				'default' => 'below',
			]
		);

		$this->add_responsive_control(
			'content_align',
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
				'default'     => 'left',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-categories-carousel__content--below' => 'text-align: {{VALUE}}',
				],
				'condition'   => [
					'content_position' => 'below',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-categories-carousel__item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-categories-carousel__item' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_style_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel__image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
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

		$this->add_responsive_control(
			'image_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel__image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'content_position' => 'below',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-categories-carousel__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'count_heading',
			[
				'label' => esc_html__( 'Count', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'count_typography',
				'selector' => '{{WRAPPER}} .ecomus-categories-carousel__cat-count',
			]
		);

		$this->add_control(
			'count_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__cat-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'count_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel__cat-count' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-button' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->register_button_style_controls( 'light' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel Style', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->add_control(
			'arrows_heading_style_heading',
			[
				'label' => esc_html__( 'Arrows on heading', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'arrows_heading_gap',
			[
				'label'      => esc_html__( 'Gap', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1170,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel .ecomus-categories-carousel__heading .swiper-button' => 'margin-left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-categories-carousel .ecomus-categories-carousel__heading .swiper-button' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_heading_spacing',
			[
				'label'      => esc_html__( 'Spacing Top', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1170,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-carousel .ecomus-categories-carousel__heading .swiper-arrows' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_heading_size',
			[
				'label'     => __( 'Icon Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel .ecomus-categories-carousel__heading .swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_heading_width',
			[
				'label'     => __( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel .ecomus-categories-carousel__heading .swiper-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_heading_height',
			[
				'label'     => __( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-carousel .ecomus-categories-carousel__heading .swiper-button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

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

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-categories-carousel', 'ecomus-carousel--elementor', 'ecomus-carousel--slidesperview-auto' ] );
		$this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-categories-carousel__inner', 'swiper' ] );
		$this->add_render_attribute( 'wrapper_inner', 'class', [ 'ecomus-categories-carousel__wrapper', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
		$this->add_render_attribute( 'heading', 'class', [ 'ecomus-categories-carousel__heading', 'heading--carousel' ] );

		$this->add_render_attribute( 'wrapper_inner', 'style', $this->render_space_between_style() );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
			if ( $settings['show_heading'] == 'yes' && ! empty( $settings['heading'] ) ) {
				echo '<div ' . $this->get_render_attribute_string( 'heading' ) . '>';
					echo '<h4>'. esc_html( $settings['heading'] ) .'</h4>';
					echo '<div class="swiper-arrows">';
						echo $settings['heading_navigation_type'] == 'arrows' ? $this->render_arrows( 'swiper-button-outline-dark' ) : $this->render_pagination( 'hidden-xs pagination-heading');
					echo '</div>';
				echo '</div>';
			}
			echo '<div ' . $this->get_render_attribute_string( 'inner' ) . '>';
				echo '<div ' . $this->get_render_attribute_string( 'wrapper_inner' ) . '>';
					if ( $settings['source'] == 'default' ) {
						$term_args = [
							'taxonomy' => 'product_cat',
							'orderby'  => $settings['orderby'],
						];

						if( $settings['number'] ) {
							$limit = $settings['show_view_all_btn'] == 'yes' ? intval( $settings['number'] ) - 1 : intval( $settings['number'] );
							$term_args['number'] = $limit;
						}

						$terms = get_terms( $term_args );

						foreach ( $terms as $index => $term ) {
							$item_key  = $this->get_repeater_setting_key( 'item', 'categories_carousel', $index );
							$image_key  = $this->get_repeater_setting_key( 'image', 'categories_carousel', $index );
							$content_key  = $this->get_repeater_setting_key( 'content', 'categories_carousel', $index );
							$this->add_render_attribute( $item_key, 'class', [ 'ecomus-categories-carousel__item', 'swiper-slide', 'ecomus-categories-carousel__content--' . $settings['content_position'] ] );
							$this->add_render_attribute( $image_key, 'class', [ 'ecomus-categories-carousel__image', 'em-relative' ] );
							$this->add_render_attribute( $content_key, 'class', [ 'ecomus-categories-carousel__content' ] );

							$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
							$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
							$settings['image']['id']  = $thumbnail_id;
							$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

							if ( empty( $image ) ) {
								$image = '<img src="'. wc_placeholder_img_src() .'" title="'. esc_attr( $term->name ) .'" alt="'. esc_attr( $term->name ) .'" loading="lazy"/>';
							}

							$count_html = '<div class="ecomus-categories-carousel__cat-count">';
							$count = (int) $term->count;
							$product_text = $count > 1 ? esc_html__('items', 'ecomus-addons')  : esc_html__('item', 'ecomus-addons');
							$count_html .= sprintf( '%s %s', $count, $product_text );
							$count_html .= '</div>';

							$button_link = ['url' => get_term_link( $term->term_id, 'product_cat' ) ];
							?>
								<div <?php echo $this->get_render_attribute_string( $item_key ); ?>>
									<div <?php echo $this->get_render_attribute_string( $image_key ); ?>>
										<a class="ecomus-categories-carousel__thumbnail em-ratio em-eff-img-zoom" href="<?php echo esc_url( get_term_link( $term->term_id, 'product_cat' ) ); ?>"><?php echo $image; ?></a>
										<?php $this->render_button( '', $index, $button_link ); ?>
									</div>
									<div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
										<h5 class="ecomus-categories-carousel__title em-font-medium"><a href="<?php echo esc_url( get_term_link( $term->term_id, 'product_cat' ) ); ?>"><?php echo esc_html( $term->name ); ?></a></h5>
										<?php echo $count_html; ?>
									</div>
								</div>
							<?php
						}
					} else {
						foreach( $settings['items'] as $index => $item ) {
							$item_key  = $this->get_repeater_setting_key( 'item', 'categories_carousel', $index );
							$image_key  = $this->get_repeater_setting_key( 'image', 'categories_carousel', $index );
							$content_key  = $this->get_repeater_setting_key( 'content', 'categories_carousel', $index );
							$this->add_render_attribute( $item_key, 'class', [ 'ecomus-categories-carousel__item', 'swiper-slide', 'ecomus-categories-carousel__content--' . $settings['content_position'] ] );
							$this->add_render_attribute( $image_key, 'class', [ 'ecomus-categories-carousel__image', 'em-relative' ] );
							$this->add_render_attribute( $content_key, 'class', [ 'ecomus-categories-carousel__content' ] );

							$term = get_term_by( 'slug', $item['product_cat'], 'product_cat' );

							if( is_wp_error( $term ) || empty( $term ) ) {
								continue;
							}
							$settings['image'] = $item['image'];
							$settings['image_size'] = 'full';
							$image_html = wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );

							if ( empty( $item['image']['url'] ) ) {
								$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
								$image_html = wp_get_attachment_image( $thumbnail_id, 'full' );
							}

							$count_html = '<div class="ecomus-categories-carousel__cat-count">';
							$count = (int) $term->count;
							$product_text = $count > 1 ? esc_html__('items', 'ecomus-addons')  : esc_html__('item', 'ecomus-addons');
							$count_html .= sprintf( '%s %s', $count, $product_text );
							$count_html .= '</div>';

							$button_link = ['url' => get_term_link( $term->term_id, 'product_cat' ) ];
							?>
								<div <?php echo $this->get_render_attribute_string( $item_key ); ?>>
									<div <?php echo $this->get_render_attribute_string( $image_key ); ?>>
										<a class="ecomus-categories-carousel__thumbnail em-ratio em-eff-img-zoom" href="<?php echo esc_url( get_term_link( $term->term_id, 'product_cat' ) ); ?>">
											<?php echo $image_html; ?>
										</a>
										<?php $this->render_button( '', $index, $button_link ); ?>
									</div>
									<div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
										<h5 class="ecomus-categories-carousel__title em-font-medium"><a href="<?php echo esc_url( get_term_link( $term->term_id, 'product_cat' ) ); ?>"><?php echo esc_html( $term->name ); ?></a></h5>
										<?php echo $count_html; ?>
									</div>
								</div>
							<?php
						}
					}

					$this->view_all_button();

				echo '</div>';
			echo '</div>';
			echo $this->render_pagination();
			echo '<div class="swiper-navigation">';
				echo $this->render_arrows();
			echo '</div>';
		echo '</div>';
	}

	protected function view_all_button() {
		$settings = $this->get_settings_for_display();

		if ( $settings['show_view_all_btn'] != 'yes' ) {
			return;
		}

		$count_html = '<div class="ecomus-categories-carousel__cat-count">';
		$count = wp_count_posts('product')->publish;
		$product_text = $count > 1 ? esc_html__('items', 'ecomus-addons')  : esc_html__('item', 'ecomus-addons');
		$count_html .= sprintf( '%s %s', $count, $product_text );
		$count_html .= '</div>';

		$this->add_render_attribute( 'view_all_item', 'class', [ 'ecomus-categories-carousel__item', 'swiper-slide', 'ecomus-categories-carousel__content--' . $settings['content_position'] ] );
		$this->add_render_attribute( 'view_all_image', 'class', [ 'ecomus-categories-carousel__image', 'em-relative' ] );
		$this->add_render_attribute( 'view_all_content', 'class', [ 'ecomus-categories-carousel__content' ] );
		?>
			<div <?php echo $this->get_render_attribute_string( 'view_all_item' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'view_all_image' ); ?>>
					<?php if( !empty( $settings['view_all_btn_link']['url'] ) ) {
						$link_for = esc_html__('Link for', 'ecomus-addons');
						$link_for .= ' ' . $settings['view_all_btn_text'];

						$settings['button_text'] = $settings['view_all_btn_text'];
						$settings['button_link'] = $settings['view_all_btn_link'];
					} ?>
					<?php if( !empty( $settings['view_all_btn_link']['url'] ) ) : ?><a class="ecomus-categories-carousel__thumbnail em-eff-img-zoom em-ratio" href="<?php echo esc_url( $settings['view_all_btn_link']['url'] ); ?>" aria-label="<?php echo esc_attr($link_for);?>"><?php else: ?> <div class="ecomus-image-box-grid__link"><?php endif; ?>
						<?php if( ! empty( $settings['view_all_btn_image'] ) && ! empty( $settings['view_all_btn_image']['url'] ) ) : ?>
							<?php
								$settings['image'] = $settings['view_all_btn_image'];
								$settings['image_size'] = 'thumbnail';
								echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
							?>
						<?php endif; ?>
					<?php if( ! empty( $settings['view_all_btn_link']['url'] ) ) : ?></a><?php else: ?></div><?php endif; ?>
					<?php $this->render_button($settings, 'view_all_btn'); ?>
				</div>
				<div <?php echo $this->get_render_attribute_string( 'view_all_content' ); ?>>
					<h5 class="ecomus-categories-carousel__title em-font-medium"><a href="<?php echo esc_url( $settings['view_all_btn_link']['url'] ); ?>"><?php echo esc_html( $settings['view_all_btn_title'] ); ?></a></h5>
					<?php echo $count_html; ?>
				</div>
			</div>
		<?php
	}
}