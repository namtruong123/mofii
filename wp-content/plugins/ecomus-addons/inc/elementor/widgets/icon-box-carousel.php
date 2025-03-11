<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Stack ;
use Elementor\Group_Control_Border ;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Icon_Box_Carousel extends Carousel_Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-icon-box-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Icon Box Carousel', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-icon-box';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['ecomus-addons'];
	}

	/**
	 * Get widget keywords.
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
   	public function get_keywords() {
	   return [ 'icon box', 'icon', 'box', 'ecomus-addons' ];
   	}

	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
		];
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->content_sections();
		$this->style_sections();
	}

	protected function content_sections() {
		$this->start_controls_section(
			'section_icon',
			[ 'label' => __( 'Icon Box', 'ecomus-addons' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon_type',
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
			'icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'image',
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
					'icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'icon_url',
			[
				'label' => __( 'External Icon URL', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'icon_type' => 'external',
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title & Description', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the title', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your title', 'ecomus-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => '',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your description', 'ecomus-addons' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'title_size',
			[
				'label' => __( 'Title HTML Tag', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h5',
			]
		);

		$repeater->add_control(
			'link',
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
			'items_style_heading',
			[
				'label' => __( 'Style', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_responsive_control(
			'items_alignment',
			[
				'label'                => esc_html__( 'Alignment', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}}.ecomus-icon-box__icon-position--top {{CURRENT_ITEM}}' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icons_box',
			[
				'label'       => __( 'Icon Box', 'ecomus-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'icon'    => [
							'value' => 'fa fa-star',
							'library' => 'fa-solid',
						],
						'title' => __( 'This is the title', 'ecomus-addons' ),
						'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
					],
					[
						'icon'    => [
							'value' => 'fa fa-star',
							'library' => 'fa-solid',
						],
						'title' => __( 'This is the title #2', 'ecomus-addons' ),
						'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
					],
					[
						'icon'    => [
							'value' => 'fa fa-star',
							'library' => 'fa-solid',
						],
						'title' => __( 'This is the title #3', 'ecomus-addons' ),
						'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
					],
					[
						'icon'    => [
							'value' => 'fa fa-star',
							'library' => 'fa-solid',
						],
						'title' => __( 'This is the title #4', 'ecomus-addons' ),
						'description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
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
			'slides_to_show'    				=> 3,
			'slides_to_scroll'     				=> 1,
			'space_between'  					=> 30,
			'navigation'    					=> '',
			'autoplay' 							=> '',
			'autoplay_speed'      				=> 3000,
			'pause_on_hover'    				=> 'yes',
			'animation_speed'  					=> 800,
			'infinite'  						=> '',
		];

		$this->register_carousel_controls( $controls );

		$this->end_controls_section();
	}

	protected function style_sections() {
		$this->content_style_sections();
		$this->item_style_sections();
		$this->icon_style_sections();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();
	}

	protected function icon_style_sections() {
		// Style Icon
		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => __( 'Icon', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Primary Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_background_color',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .icon-type-image .ecomus-icon-box__icon' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-icon-box__icon',
			]
		);

		$this->add_control(
			'border_radius',
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

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box__icon' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
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
					'{{WRAPPER}} .ecomus-icon-box__icon' => '--ecomus-icon-box-margin: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->end_controls_section();
	}

	protected function content_style_sections() {
		// Content style
		$this->start_controls_section(
			'section_style_icon_box_carousel',
			[
				'label' => __( 'Icon Box Carousel', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_box_carousel_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box-carousel__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box-carousel__container' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_box_carousel_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-icon-box-carousel__container',
			]
		);

		$this->add_control(
			'icon_box_carousel_border_between',
			[
				'label'        => esc_html__( 'Border Between', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ecomus-addons' ),
				'label_off'    => esc_html__( 'Hide', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'ecomus-icon-box-carousel__border-between-',
			]
		);

		$this->add_responsive_control(
			'icon_box_item_border_color',
			[
				'label' => __( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ecomus-icon-box-carousel__border-between-yes .ecomus-icon-box:after' => 'background-color: {{VALUE}}',
				],
				'condition'   => [
					'icon_box_carousel_border_between' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_carousel_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box-carousel__container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box-carousel__container' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function item_style_sections() {
		// Content style
		$this->start_controls_section(
			'section_style_icon_box_item',
			[
				'label' => __( 'Icon Box Item', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'position',
			[
				'label' => esc_html__( 'Icon Position', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'ecomus%s-icon-box__icon-position--',
				'toggle' => false,
			]
		);

		$this->add_control(
			'vertical_alignment',
			[
				'label' => esc_html__( 'Vertical Alignment', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => esc_html__( 'Top', 'ecomus-addons' ),
					'middle' => esc_html__( 'Middle', 'ecomus-addons' ),
					'bottom' => esc_html__( 'Bottom', 'ecomus-addons' ),
				],
				'default' => 'top',
				'prefix_class' => 'ecomus-icon-box__vertical-align-',
				'conditions' => [
					'terms' => [
						[
							'name' => 'position',
							'operator' => '!=',
							'value' => 'top'
						],
					]
				]
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'                => esc_html__( 'Alignment', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-right',
					],
					'stretch'  => [
						'title' => esc_html__( 'Stretch', 'ecomus-addons' ),
						'icon' 	=> 'eicon-h-align-stretch',
					],
				],
				'default'              => '',
				'prefix_class' => 'ecomus%s-icon-box__icon-alignment--',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-icon-box',
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_box_shadow',
				'label' => __( 'Box Shadow', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-icon-box',
			]
		);

		$this->add_control(
			'title_style_heading',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => __( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__title a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-icon-box__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
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
					'{{WRAPPER}} .ecomus-icon-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'title_ellipsis',
			[
				'label'       => esc_html__( 'Text Ellipsis', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'prefix_class' => 'ecomus-icon-box__icon-text-ellipsis-',
			]
		);

		$this->add_control(
			'description_style_heading',
			[
				'label' => __( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-icon-box__content',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

		$this->add_render_attribute( 'wrapper_swiper', 'style', $this->render_space_between_style() );

		echo '<div class="ecomus-icon-box-carousel--elementor ecomus-carousel--elementor">';
			echo '<div class="ecomus-icon-box-carousel__container swiper" '. $this->get_render_attribute_string( 'wrapper_swiper' ) .'>';
				echo '<div class="ecomus-icon-box-carousel__wrapper swiper-wrapper mobile-col-'. esc_attr( $col_mobile ) .' tablet-col-'. esc_attr( $col_tablet ) .' columns-'. esc_attr( $col ) .'">';

					foreach( $settings['icons_box'] as $index => $slide ) {
						$wrapper_key 			= $this->get_repeater_setting_key( 'wrapper', 'icon_box', $index );
						$content_wrapper_key 	= $this->get_repeater_setting_key( 'content_wrapper', 'icon_box', $index );
						$icon_key     			= $this->get_repeater_setting_key( 'icon', 'icon_box', $index );
						$title_key    			= $this->get_repeater_setting_key( 'title', 'icon_box', $index );
						$desc_key    			= $this->get_repeater_setting_key( 'description', 'icon_box', $index );
						$link_key    			    = $this->get_repeater_setting_key( 'link', 'icon_box', $index );

						$this->add_render_attribute( $wrapper_key, 'class', ['elementor-repeater-item-' . $slide['_id'], 'ecomus-icon-box', 'icon-type-' . $slide['icon_type'], 'swiper-slide'] );
						$this->add_render_attribute( $content_wrapper_key, 'class', 'ecomus-icon-box__wrapper' );
						$this->add_render_attribute( $icon_key, 'class', 'ecomus-icon-box__icon' );
						$this->add_render_attribute( $title_key, 'class', 'ecomus-icon-box__title' );
						$this->add_render_attribute( $desc_key, 'class', 'ecomus-icon-box__content' );

						$this->add_inline_editing_attributes( 'title', 'none' );
						$this->add_inline_editing_attributes( 'description', 'basic' );

						$this->add_link_attributes( $link_key, $slide['link'] );
						$this->get_repeater_setting_key( $link_key, 'class', 'ecomus-button-link' );

						echo '<div '. $this->get_render_attribute_string( $wrapper_key ) .'>';
							echo '<div '. $this->get_render_attribute_string( $icon_key ) .'>';
								if( ! empty( $slide['link']['url'] ) ) {
									echo '<a '. $this->get_render_attribute_string( $link_key ) .'>';
								}

								if ( 'image' == $slide['icon_type'] ) {
									if( ! empty( $slide['image'] ) && ! empty( $slide['image']['url'] ) ) :
										$settings['image'] = $slide['image'];
										$settings['image_size'] = 'thumbnail';

										echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
									endif;
								} elseif ( 'external' == $slide['icon_type'] ) {

									echo $slide['icon_url'] ? sprintf( '<img alt="%s" src="%s">', esc_attr( $slide['title'] ), esc_url( $slide['icon_url'] ) ) : '';
								} else {
								if(!empty($slide['icon']['value'])) {
									echo '<span class="ecomus-svg-icon">';
										Icons_Manager::render_icon( $slide['icon'], [ 'aria-hidden' => 'true' ] );
									echo '</span>';
									}
								}

								if( ! empty( $slide['link']['url'] ) ) {
									echo '</a>';
								}
							echo '</div>';
							echo '<div '. $this->get_render_attribute_string( $content_wrapper_key ) .'>';
								if( ! empty( $slide['title'] ) ) {
									?>
									<<?php Utils::print_validated_html_tag( $slide['title_size'] ); ?> <?php echo $this->get_render_attribute_string( $title_key ); ?>>
									<?php if( ! empty( $slide['link']['url'] ) ) {
											echo '<a '. $this->get_render_attribute_string( $link_key ) .'>';
										} ?>

										<?php echo wp_kses_post( $slide['title'] ) ?>

										<?php if( ! empty( $slide['link']['url'] ) ) {
												echo '</a>';
											} ?>

										</<?php Utils::print_validated_html_tag( $slide['title_size'] ); ?>>
									<?php
								};
								if( ! empty( $slide['description'] ) ) {
									echo '<div '. $this->get_render_attribute_string( $desc_key ) .'>'. wp_kses_post( $slide['description'] ) .'</div>';
								}
							echo '</div>';
						echo '</div>';
					}

				echo '</div>';
			echo '</div>';
			echo $this->render_arrows();
			echo $this->render_pagination();
		echo '</div>';
	}
}