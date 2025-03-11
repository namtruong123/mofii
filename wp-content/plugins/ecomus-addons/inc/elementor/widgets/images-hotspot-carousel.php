<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Images Hotspot Carousel widget
 */
class Images_Hotspot_Carousel extends Carousel_Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-images-hotspot-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Images Hotspot Carousel', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-nested-carousel';
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
		$this->section_slider_options();
	}

	protected function section_content_slides() {
		$control = apply_filters( 'ecomus_images_hotspot_carousel_section_number', 4 );
		for ( $i = 1; $i <= $control; $i ++ ) {
			$this->start_controls_section(
				'section_contents_' . $i,
				[
					'label' => __( 'Carousel Item', 'ecomus-addons' ) . ' ' . $i,
				]
			);

			$default_url = '';
			if( $i == 1 || $i == 2 ) {
				$default_url = \Elementor\Utils::get_placeholder_image_src();
			}

			$this->add_responsive_control(
				'image_'. $i,
				[
					'label'     => __( 'Image', 'ecomus-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'default' => [
						'url' => $default_url,
					],
				]
			);

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'product_items_ids',
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

			$repeater->add_control(
				'point_popover_toggle',
				[
					'label' => esc_html__( 'Point', 'ecomus-addons' ),
					'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
					'label_off' => esc_html__( 'Default', 'ecomus-addons' ),
					'label_on' => esc_html__( 'Custom', 'ecomus-addons' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$repeater->start_popover();

			$repeater->add_responsive_control(
				'product_items_position_x',
				[
					'label'      => esc_html__( 'Point Position X', 'ecomus-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
						'.ecomus-rtl-smart {{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}}' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_items_position_y',
				[
					'label'      => esc_html__( 'Point Position Y', 'ecomus-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->end_popover();

			$repeater->add_control(
				'content_popover_toggle',
				[
					'label' => esc_html__( 'Content', 'ecomus-addons' ),
					'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
					'label_off' => esc_html__( 'Default', 'ecomus-addons' ),
					'label_on' => esc_html__( 'Custom', 'ecomus-addons' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$repeater->start_popover();

			$repeater->add_control(
				'product_items_content_heading',
				[
					'type'  => Controls_Manager::HEADING,
					'label' => esc_html__( 'Content', 'ecomus-addons' ),
				]
			);

			$repeater->add_responsive_control(
				'product_content_items_position_x',
				[
					'label'      => esc_html__( 'Product Position X', 'ecomus-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}} .ecomus-images-hotspot__product-inner' => 'left: {{SIZE}}{{UNIT}};',
						'.ecomus-rtl-smart {{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}} .ecomus-images-hotspot__product-inner' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_content_items_position_y',
				[
					'label'      => esc_html__( 'Product Position Y', 'ecomus-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}} .ecomus-images-hotspot__product-inner' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_arrow_items_position_x',
				[
					'label'      => esc_html__( 'Arrow Position X', 'ecomus-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}} .ecomus-images-hotspot__arrow' => 'left: {{SIZE}}{{UNIT}}; transform: translate(0, 0);',
						'.ecomus-rtl-smart {{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}} .ecomus-images-hotspot__arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto; transform: translate(0, 0);',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_arrow_items_position_y',
				[
					'label'      => esc_html__( 'Arrow Position Y', 'ecomus-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .ecomus-images-hotspot-carousel .ecomus-images-hotspot__item-'. $i . ' {{CURRENT_ITEM}} .ecomus-images-hotspot__arrow' => 'top: {{SIZE}}{{UNIT}};',
					],
					'separator' => 'after',
				]
			);

			$repeater->end_popover();

			$this->add_control(
				'items_'. $i,
				[
					'label' => esc_html__( 'Hotspot items', 'ecomus-addons' ),
					'type'       => Controls_Manager::REPEATER,
					'show_label' => true,
					'fields'     => $repeater->get_controls(),
					'default'    => [],
				]
			);

			$this->end_controls_section();
		}
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
			'slides_to_show'   => 2,
			'slides_to_scroll' => 1,
			'space_between'    => 0,
			'navigation'       => 'dots',
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

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_carousel();
	}

	protected function section_style_content() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Contents', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
				'separator'  => 'before',
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

		$this->add_control(
			'item_dots_bgcolor',
			[
				'label'     => esc_html__( 'Dots Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-images-hotspot__button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_dots_color',
			[
				'label'     => esc_html__( 'Dots Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-images-hotspot__button span' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_style',
			[
				'label'     => __( 'Product', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_image_heading',
			[
				'label'     => esc_html__( 'Image', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'item_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-images-hotspot__product-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-images-hotspot__product-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_image_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-images-hotspot__product-inner' => 'gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'item_title_heading',
			[
				'label'     => esc_html__( 'Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-images-hotspot__product-title',
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-images-hotspot__product-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-images-hotspot__product-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_price_heading',
			[
				'label'     => esc_html__( 'Price', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_price_typography',
				'selector' => '{{WRAPPER}} .ecomus-images-hotspot__product-price',
			]
		);

		$this->add_control(
			'item_price_color',
			[
				'label'     => esc_html__( 'Regular Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-images-hotspot__product-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_price_color_ins',
			[
				'label'     => esc_html__( 'Sale Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-images-hotspot__product-price ins' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_button_heading',
			[
				'label'     => esc_html__( 'Button', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
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
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-button' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-button' => '--em-button-border-color: {{VALUE}};',
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
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
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
				'label' => esc_html__( 'Carousel Style', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->add_control(
			'arrows_dots_style_heading',
			[
				'label'     => esc_html__( 'Arrows And Dots', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'arrows_dots_background_color',
			[
				'label'     => esc_html__( 'Background color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination--dots-arrow__wrapper' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_dots_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination--dots-arrow__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination--dots-arrow__wrapper' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_dots_border_radius',
			[
				'label'      => __( 'Border radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination--dots-arrow__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination--dots-arrow__wrapper' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'arrows_dots_tabs'
		);

			$this->start_controls_tab(
				'arrows_dots_tab_arrows',
				[
					'label' => esc_html__( 'Arrows', 'ecomus-addons' ),
				]
			);

				$this->add_responsive_control(
					'arrows_dots_size_arrows',
					[
						'label'     => esc_html__( 'Size', 'ecomus-addons' ),
						'type'      => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'vh' ],
						'range'     => [
							'px' => [
								'min' => 0,
								'max' => 1000,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'arrows_dots_spacing_arrows',
					[
						'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
						'type'      => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'vh' ],
						'range'     => [
							'px' => [
								'min' => 0,
								'max' => 1000,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination' => 'margin: 0 {{SIZE}}{{UNIT}};',
						],
					]
				);

				$this->add_control(
					'arrows_dots_color_arrows',
					[
						'label'     => esc_html__( 'Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-button' => 'color: {{VALUE}}; opacity: 1;',
						],
					]
				);

				$this->add_control(
					'arrows_dots_disable_color_arrows',
					[
						'label'     => esc_html__( 'Disable Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-button.swiper-button-disabled' => 'color: {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'arrows_dots_tab_dots',
				[
					'label' => esc_html__( 'Dots', 'ecomus-addons' ),
				]
			);

				$this->add_responsive_control(
					'arrows_dots_size_dots',
					[
						'label'     => esc_html__( 'Size', 'ecomus-addons' ),
						'type'      => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'vh' ],
						'range'     => [
							'px' => [
								'min' => 0,
								'max' => 1000,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination-bullets .swiper-pagination-bullet:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'arrows_dots_gap_dots',
					[
						'label'     => __( 'Gap', 'ecomus-addons' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
							'px' => [
								'max' => 50,
								'min' => 0,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
						],
					]
				);

				$this->add_control(
					'arrows_dots_color_dots',
					[
						'label'     => esc_html__( 'Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination-bullets .swiper-pagination-bullet:before' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'arrows_dots_active_color_dots',
					[
						'label'     => esc_html__( 'Active Color', 'ecomus-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .swiper-pagination--dots-arrow .swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active, .swiper-pagination--dots-arrow .swiper-pagination-bullets .swiper-pagination-bullet:hover' => 'color: {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$random_id = rand();

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

        $this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-images-hotspot-carousel', 'ecomus-carousel--elementor', 'ecomus-carousel--slidesperview-auto' ] );
        $this->add_render_attribute( 'wrapper', 'style', [ $this->render_space_between_style() ] );
		$this->add_render_attribute( 'swiper', 'class', [ 'swiper' ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-images-hotspot__inner', 'em-flex', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
		$this->add_render_attribute( 'item', 'class', [ 'ecomus-images-hotspot__item', 'em-relative', 'swiper-slide' ] );

        $this->add_render_attribute( 'image', 'class', [ 'ecomus-images-hotspot__image' ] );

        $this->add_render_attribute( 'product', 'class', [ 'ecomus-images-hotspot__product', 'em-absolute' ] );
        $this->add_render_attribute( 'product_inner', 'class', [ 'ecomus-images-hotspot__product-inner', 'em-absolute', 'em-flex-align-center', 'hidden-xs' ] );
        $this->add_render_attribute( 'product_summary', 'class', [ 'ecomus-images-hotspot__product-summary' ] );
        $this->add_render_attribute( 'product_image', 'class', [ 'ecomus-images-hotspot__product-image', 'em-ratio' ] );
        $this->add_render_attribute( 'product_title', 'class', [ 'ecomus-images-hotspot__product-title' ] );
        $this->add_render_attribute( 'product_price', 'class', [ 'ecomus-images-hotspot__product-price' ] );
        $this->add_render_attribute( 'arrow', 'class', [ 'ecomus-images-hotspot__arrow', 'em-absolute', 'hidden-xs' ] );
        $this->add_render_attribute( 'button', 'class', [ 'ecomus-images-hotspot__button', 'em-relative' ] );

        $this->add_render_attribute( 'quickview', 'class', [ 'ecomus-images-hotspot__quickview', 'ecomus-quickview-button', 'em-flex-align-center', 'em-flex-center', 'ecomus-button', 'em-button',  'em-button-light', 'em-tooltip' ] );
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'swiper' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
				<?php $control = apply_filters( 'ecomus_images_hotspot_carousel_section_number', 4 );
					for ( $i = 1; $i <= $control; $i++ ) :
						if( ! empty( $settings['image_'. $i]['url'] ) ) : ?>
						<div class="ecomus-images-hotspot__item-<?php echo esc_attr( $i ); ?> ecomus-images-hotspot__item em-relative swiper-slide">
							<div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
								<?php
									$image_args = [
										'image'        => ! empty( $settings['image_'. $i] ) ? $settings['image_'. $i] : '',
										'image_tablet' => ! empty( $settings['image_'. $i . '_tablet'] ) ? $settings['image_'. $i . '_tablet'] : '',
										'image_mobile' => ! empty( $settings['image_'. $i . '_mobile'] ) ? $settings['image_'. $i . '_mobile'] : '',
									];
								?>
								<?php echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args ); ?>
							</div>
						<?php
							foreach( $settings['items_'. $i] as $item ) :
								$product_id    = $item[ "product_items_ids" ];
								if( ! empty( $product_id ) ) :
									$product = wc_get_product( $product_id );
									if( ! empty( $product ) ) : ?>
										<div class="elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?> ecomus-images-hotspot__product em-absolute">
											<div <?php echo $this->get_render_attribute_string( 'product_inner' ); ?>>
												<div <?php echo $this->get_render_attribute_string( 'product_image' ); ?>>
													<?php echo $product->get_image(); ?>
												</div>
												<div <?php echo $this->get_render_attribute_string( 'product_summary' ); ?>>
													<h6 <?php echo $this->get_render_attribute_string( 'product_title' ); ?>>
														<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
													</h6>
													<div <?php echo $this->get_render_attribute_string( 'product_price' ); ?>>
														<?php echo wp_kses_post( $product->get_price_html() ); ?>
													</div>
												</div>
												<?php if ( \Ecomus\Helper::get_option( 'product_card_quick_view' ) ) : ?>
													<a <?php echo $this->get_render_attribute_string( 'quickview' ); ?> href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" data-toggle="modal" data-target="quick-view-modal" data-id="<?php echo esc_attr( $product_id ); ?>" data-tooltip="<?php echo esc_attr__( 'Quick View', 'ecomus' ); ?>" aria-label="<?php esc_attr_e('Quick View on Hotpot', 'ecomus-addons') ;?>" rel="nofollow">
														<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=eye' ); ?>
													</a>
												<?php endif; ?>
											</div>
											<div <?php echo $this->get_render_attribute_string( 'arrow' ); ?>></div>
											<button <?php echo $this->get_render_attribute_string( 'button' ); ?> data-toggle="popover" data-target="images-hotspot-popover-<?php echo esc_attr( $random_id ); ?>" data-device="mobile" aria-label="<?php esc_attr_e('Hotpot Button', 'ecomus-addons') ?>">
												<span></span>
											</button>
										</div>
									<?php endif; ?>
						<?php 	endif;
							endforeach; ?>
						</div>
				<?php 	endif;
					endfor; ?>
				</div>
				<?php if( $settings['navigation_classes'] == 'both' ) {
						echo sprintf( '<div class="swiper-pagination--dots-arrow em-absolute"><div class="swiper-pagination--dots-arrow__wrapper em-relative">%s<div class="swiper-pagination"></div>%s</div></div>',
									\Ecomus\Addons\Helper::get_svg('left-mini', 'ui' , [ 'class' => 'elementor-swiper-button-prev swiper-button swiper-button-text' ] ),
									\Ecomus\Addons\Helper::get_svg('right-mini', 'ui' , [ 'class' => 'elementor-swiper-button-next swiper-button swiper-button-text' ] )
								);
					} else {
						echo $this->render_arrows();
						echo $this->render_pagination();
					} ?>
			</div>
        </div>

		<div id="images-hotspot-popover-<?php echo esc_attr( $random_id ); ?>" class="images-hotspot-popover-<?php echo esc_attr( $random_id ); ?> images-hotspot-popover popover hidden-lg hidden-md hidden-sm">
			<div class="popover__backdrop"></div>
			<div class="popover__container">
				<div class="popover__wrapper">
					<?php echo \Ecomus\Addons\Helper::get_svg( 'close', 'ui', [ 'class' => 'em-button em-button-icon em-button-light popover__button-close' ] ); ?>
					<div class="popover__content images-hotspot-content em-flex em-flex-align-center"></div>
				</div>
			</div>
		</div>
    <?php
	}
}