<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Ecomus\Addons\Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
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
class Image_Box_Carousel extends Carousel_Widget_Base {
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
		return 'ecomus-image-box-carousel';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Stores Location widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Images Box Carousel', 'ecomus-addons' );
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
		$this->section_content_slides();
		$this->section_view_all_button_options();
		$this->section_slider_options();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'show_heading',
			[
				'label'        => __( 'Show heading with navigation', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => 'yes',
			]
		);

        $this->add_control(
			'heading',
			[
				'label'       => __( 'Heading', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'This is heading', 'ecomus-addons' ),
				'placeholder' => __( 'Heading', 'ecomus-addons' ),
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

		$repeater = new Repeater();

        $repeater->add_responsive_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/428x547/f1f1f1?text=image',
				],
			]
		);

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
				'default'     => '',
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
			'sale_text',
			[
				'label'       => esc_html__( 'Sale Text', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXT,
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

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'button_text' => __( 'Click Here', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
					[
						'button_text' => __( 'Click Here', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
					[
						'button_text' => __( 'Click Here', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
					[
						'button_text' => __( 'Click Here', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
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

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'horizontal' ] );

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
				'prefix_class' => 'ecomus-view-all-btn--'
			]
		);

		$this->add_control(
			'view_all_btn_type',
			[
				'label' => __( 'Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'icon' => __( 'Icon', 'ecomus-addons' ),
					'image' => __( 'Image', 'ecomus-addons' ),
					'text' => __( 'Text', 'ecomus-addons' ),
				],
				'default' => 'icon',
				'condition'   => [
					'show_view_all_btn' => 'yes',
				],
			]
		);

        $this->add_responsive_control(
			'view_all_btn_image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
				],
                'condition' => [
					'view_all_btn_type' => 'image',
					'show_view_all_btn' => 'yes',
				],
			]
		);

        $this->add_control(
			'view_all_btn_icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'view_all_btn_type' => 'icon',
					'show_view_all_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_btn_text', [
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'view_all_btn_type' => 'text',
					'show_view_all_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_btn_title', [
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition'   => [
					'show_view_all_btn' => 'yes',
				],
			]
		);

        $this->add_control(
			'view_all_btn_link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
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

    protected function section_slider_options() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Carousel Options', 'ecomus-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$controls = [
			'slides_to_show'   => 3,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'arrows',
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
			'slidesperview_width',
			[
				'label'     => __( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel .swiper-wrapper .ecomus-image-box-carousel__item' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'slidesperview_auto' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

    // Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_button();
		$this->section_style_carousel();
	}

	protected function section_style_content() {
		// Style
		$this->start_controls_section(
			'section_style_heading',
			[
				'label'     => __( 'Heading', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'heading_gap',
			[
				'label'      => esc_html__( 'Space between arrow and heading', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__heading' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'heading_spacing',
			[
				'label'      => esc_html__( 'Spacing bottom', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-box-carousel__heading .heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'      => esc_html__( 'Heading Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__heading .heading' => 'color: {{VALUE}}',
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

        $this->add_responsive_control(
			'content_horizontal_position',
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
				'selectors'            => [
					'{{WRAPPER}} .ecomus-image-box-carousel__item' => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .ecomus-image-box-carousel__view-all-outsite' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'content_vertical_position',
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
				'selectors'            => [
					'{{WRAPPER}} .ecomus-image-box-carousel__item' => 'align-items: {{VALUE}}',
					'{{WRAPPER}} .ecomus-image-box-carousel__view-all-outsite' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'   => 'flex-start',
					'middle' => 'center',
					'bottom'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'content_text_align',
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
				'default'     => 'left',
				'condition'   => [
					'content_position' => 'below',
				],
				'selectors'   => [
					'{{WRAPPER}} .ecomus-image-box-carousel__item-below' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'   => esc_html__( 'Content Position', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'side'  => esc_html__( 'On image', 'ecomus-addons' ),
					'below' => esc_html__( 'Below the image', 'ecomus-addons' ),
				],
				'default' => 'side',
			]
		);

		$this->add_control(
			'content_item_bg_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__item' => 'background-color: {{VALUE}};',
				],
				'condition'   => [
					'content_position' => 'below',
				],
			]
		);

		$this->add_responsive_control(
			'content_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition'   => [
					'content_position' => 'below',
				],
			]
		);

		$this->add_control(
			'content_item_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__item' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
				'condition' => [
					'content_position' => 'below',
				],
			]
		);

		$this->add_control(
			'image_heading_style',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hover_zoom',
			[
				'label'   => esc_html__( 'Zoom when hover image', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => 'no',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'selector'  => '{{WRAPPER}} .ecomus-image-box-carousel__image-bg',
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => esc_html__( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__image-bg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__image-bg' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__image-bg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__image-bg' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'summary_heading',
			[
				'label' => esc_html__( 'Summary', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'summary_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__summary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'summary_margin',
			[
				'label'      => esc_html__( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__summary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__summary' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'summary_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__summary' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'summary_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__summary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__summary' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'before_title_heading',
			[
				'label' => esc_html__( 'Before Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'before_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-box-carousel__before-title',
			]
		);

		$this->add_control(
			'before_title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__before-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'before_title_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__before-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__before-title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-image-box-carousel__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'description_heading',
			[
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-box-carousel__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__description' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sale_text_heading',
			[
				'label' => esc_html__( 'Sale', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_text_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-box-carousel__sale-text',
			]
		);

		$this->add_control(
			'sale_text_bg_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__sale-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sale_text_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-carousel__sale-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_text_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__sale-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__sale-text' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

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

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__button' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();
	}

    protected function section_style_carousel() {
		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
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
					'{{WRAPPER}} .ecomus-image-box-carousel .ecomus-image-box-carousel__heading .swiper-arrows' => 'gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ecomus-image-box-carousel .ecomus-image-box-carousel__heading .swiper-arrows' => 'margin-top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ecomus-image-box-carousel .ecomus-image-box-carousel__heading .swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ecomus-image-box-carousel .ecomus-image-box-carousel__heading .swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ecomus-image-box-carousel .ecomus-image-box-carousel__heading .swiper-button' => 'height: {{SIZE}}{{UNIT}};',
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
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col_tablet;

        $this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-image-box-carousel', 'ecomus-carousel--elementor', 'ecomus-carousel--slidesperview-auto' ] );
        $this->add_render_attribute( 'wrapper', 'style', [ $this->render_space_between_style(), $this->render_aspect_ratio_style() ] );
		$this->add_render_attribute( 'swiper', 'class', [ 'swiper', 'images-swiper--elementor' ] );
        $this->add_render_attribute( 'heading', 'class', [ 'ecomus-image-box-carousel__heading', 'ecomus-image-box-carousel__heading--' . esc_attr( $settings['heading_navigation_type'] ), 'heading--carousel', 'em-flex', 'em-flex-align-center', 'em-relative' ] );
        $this->add_render_attribute( 'inner', 'class', [ 'ecomus-image-box-carousel__inner', 'em-flex', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
        $this->add_render_attribute( 'item', 'class', [ 'ecomus-image-box-carousel__item', 'ecomus-image-box-carousel__item-' . $settings['content_position'], 'em-flex', 'em-relative', 'swiper-slide' ] );
        $this->add_render_attribute( 'image', 'class', [ 'ecomus-image-box-carousel__image', 'em-ratio', 'em-image-rounded', $settings['hover_zoom'] == 'yes' ? 'em-eff-img-zoom' : '' ] );
		$this->add_render_attribute( 'summary', 'class', [ 'ecomus-image-box-carousel__summary', 'em-absolute' ] );
		$this->add_render_attribute( 'before_title', 'class', [ 'ecomus-image-box-carousel__before-title' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-image-box-carousel__title' ] );
		$this->add_render_attribute( 'description', 'class', [ 'ecomus-image-box-carousel__description' ] );
		$this->add_render_attribute( 'sale_text', 'class', [ 'ecomus-image-box-carousel__sale-text', 'em-absolute' ] );
		$this->add_render_attribute( 'inner', 'style', '--em-swiper-items-space: ' . $settings['image_spacing_custom'] . 'px' );

		$button_classes = ' ecomus-image-box-carousel__button em-absolute';
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if( $settings['show_heading'] == 'yes' && ! empty( $settings['heading'] ) ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'heading' ); ?>>
					<?php if( $settings['heading_navigation_type'] == 'arrows' ) : ?>
						<span class="swiper-arrows"><?php echo $this->render_arrows( ' swiper-button-outline-dark' ); ?></span>
					<?php endif; ?>
					<h6 class="heading"><?php echo wp_kses_post( $settings['heading'] ); ?></h6>
					<?php if( $settings['heading_navigation_type'] == 'dots' ) : ?>
						<?php echo $this->render_pagination( 'hidden-xs pagination-heading' ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
            <div class="ecomus-products-carousel--relative">
				<div <?php echo $this->get_render_attribute_string( 'swiper' ); ?>>
					<div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
						<?php foreach( $settings['items'] as $index => $item ) : ?>
							<?php
								$image   = $this->get_repeater_setting_key( 'image', 'image_box', $index );
								$link   = $this->get_repeater_setting_key( 'link', 'image_box', $index );

								$this->add_render_attribute( $image, 'class', [ 'ecomus-image-box-carousel__image', 'em-ratio', 'em-image-rounded', $settings['hover_zoom'] == 'yes' ? 'em-eff-img-zoom' : '' ] );
								$this->add_link_attributes( $image, $item['button_link'] );
								$this->add_link_attributes( $link, $item['button_link'] );
							?>
							<div <?php echo $this->get_render_attribute_string( 'item' ); ?>>
							<?php ?>
							<?php if( ! empty( $item['image'] ) && ! empty( $item['image']['url'] ) ) : ?>
								<?php
									$image_args = [
										'image'        => ! empty( $item['image'] ) ? $item['image'] : '',
										'image_tablet' => ! empty( $item['image_tablet'] ) ? $item['image_tablet'] : '',
										'image_mobile' => ! empty( $item['image_mobile'] ) ? $item['image_mobile'] : '',
									];
									$image_html = \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args );
									$sale_text = $item['sale_text'] ? '<span '. $this->get_render_attribute_string( 'sale_text' ) .'>'. wp_kses_post( $item['sale_text'] ) .'</span>' : '';

									$image_html = $image_html . $sale_text;

									if ( ! empty( $item['button_link']['url'] ) ) {
										$link_for = esc_html__('Link for', 'ecomus-addons');
										$link_for .= ' ' . $item['button_text'];
										$this->add_render_attribute( 'image', 'aria-label', [ $link_for ]);
										$image_html = '<div class="ecomus-image-box-carousel__image-bg"><a ' . $this->get_render_attribute_string( 'image' ) . ' href="'. esc_url( $item['button_link']['url'] ) .'">' . $image_html . '</a></div>';
									} else {
										$image_html = '<div class="ecomus-image-box-carousel__image-bg">' . $image_html . '</div>';
									}

									echo $image_html;


								?>
							<?php endif; ?>
								<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
									<?php if ( $item['title'] || $item['description'] ) : ?>
										<div <?php echo $this->get_render_attribute_string( 'summary' ); ?>>
											<?php if ( $item['before_title'] ) : ?>
												<h6 <?php echo $this->get_render_attribute_string( 'before_title' ); ?>>
													<?php echo wp_kses_post( $item['before_title'] ); ?>
												</h6>
											<?php endif; ?>
											<?php if ( $item['title'] ) : ?>
												<h5 <?php echo $this->get_render_attribute_string( 'title' ); ?>>
													<?php
														if( ! empty( $item['button_link']['url'] ) ) {
															echo '<a '. $this->get_render_attribute_string( $link ) .'>';
														}
															echo wp_kses_post( $item['title'] );
														if( ! empty( $item['button_link']['url'] ) ) {
															echo '</a>';
														}
													?>
												</h5>
											<?php endif; ?>

											<?php if ( $item['description'] ) : ?>
												<div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $item['description'] ); ?></div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
								<?php
								$item['button_style'] = $settings['button_style'];
								$item['button_type'] = $settings['button_style'];
								$item['button_classes'] = $button_classes;
								$this->render_button( $item, $index );
								?>
							</div>
						<?php endforeach; ?>
						<?php $this->view_all_button( 'ecomus-image-box-carousel__item swiper-slide', 'view_all_1' ); ?>
					</div>
				</div>
				<?php echo $this->render_arrows(); ?>
				<?php echo $this->render_pagination(); ?>
			</div>
			<?php $this->view_all_button( 'ecomus-image-box-carousel__view-all-outsite', 'view_all_2' ); ?>
        </div>
    <?php
	}

	protected function view_all_button( $classes = '', $index = 'view_all_1' ) {
		$settings = $this->get_settings_for_display();

		if ( $settings['show_view_all_btn'] != 'yes' ) {
			return;
		}

		$item_key  		= $this->get_repeater_setting_key( 'view_all_item', 'view_all_button', $index );

		$this->add_render_attribute( $item_key, 'class', [ 'ecomus-image-box-carousel__item-' . $settings['content_position'], 'em-flex', 'em-relative', 'ecomus-image-box-carousel__item--view-all' ] );
		$this->add_render_attribute( 'view_all_image', 'class', [ 'ecomus-image-box-carousel__image', 'em-relative', 'ecomus-image-box-carousel__type--' . $settings['view_all_btn_type'] ] );
		if ( ! empty( $classes ) ) {
			$this->add_render_attribute( $item_key, 'class', [ $classes ] );
		}
		?>
			<div <?php echo $this->get_render_attribute_string( $item_key ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'view_all_image' ); ?>>
					<?php
						if ( ! empty( $settings['view_all_btn_link']['url'] ) ) {
							$this->add_link_attributes( 'view_all_btn_link', $settings['view_all_btn_link'] );
							$this->add_render_attribute( 'view_all_btn_link', 'class', 'ecomus-image-box-carousel__link em-ratio' );
							echo '<a '. $this->get_render_attribute_string( 'view_all_btn_link' ) .'>';

						} else {
							echo '<div class="ecomus-image-box-carousel__link em-ratio">';
						}

					?>
						<?php if( $settings['view_all_btn_type'] == 'image' ) { ?>
							<?php if( ! empty( $settings['view_all_btn_image'] ) && ! empty( $settings['view_all_btn_image']['url'] ) ) : ?>
								<?php
									$settings['image'] = $settings['view_all_btn_image'];
									$settings['image_size'] = 'thumbnail';
									echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
								?>
							<?php endif; ?>
						<?php } else if( $settings['view_all_btn_type'] == 'icon' ) { ?>
							<span class="ecomus-svg-icon">
								<?php Icons_Manager::render_icon( $settings['view_all_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php } else { ?>
							<span class="ecomus-svg-icon ecomus-image-box-carousel__text em-font-semibold">
								<?php echo wp_kses_post( $settings['view_all_btn_text'] ); ?>
							</span>
						<?php } ?>
					<?php
						if ( ! empty( $settings['view_all_btn_link']['url'] ) ) {
							echo '</a>';
						} else {
							echo '</div>';
						}
					?>
				</div>
				<?php
					$settings['button_text'] = $settings['view_all_btn_title'];
					$settings['button_link'] = $settings['view_all_btn_link'];
					$settings['button_classes'] = ' ecomus-image-box-carousel__button';
					$this->render_button($settings, 'view_all_btn');
				?>
			</div>
		<?php
	}
}