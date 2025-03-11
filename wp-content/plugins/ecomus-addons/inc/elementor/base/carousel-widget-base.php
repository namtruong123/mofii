<?php
namespace Ecomus\Addons\Elementor\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Ecomus\Addons\Helper;

abstract class Carousel_Widget_Base extends Widget_Base {
	/**
	 * Register controls
	 *
	 * @param array $controls
	 */
	protected function register_carousel_controls( $controls = [] ) {
		$supported_controls = [
			'slides_to_show'    				=> 1,
			'slides_to_scroll'     				=> 1,
			'space_between'  					=> 30,
			'navigation'    					=> '',
			'autoplay' 							=> '',
			'autoplay_speed'      				=> 3000,
			'pause_on_hover'    				=> 'yes',
			'animation_speed'  					=> 800,
			'infinite'  						=> '',
		];

		$controls = 'all' == $controls ? $supported_controls : $controls;

		foreach ( $controls as $option => $default ) {
			switch ( $option ) {
				case 'slides_to_show':
					$this->add_responsive_control(
						'slides_to_show',
						[
							'label'     => __( 'Slides to Show', 'ecomus-addons' ),
							'type'      => Controls_Manager::NUMBER,
							'min'       => 1,
							'max'       => 50,
							'step'      => 1,
							'default'   => $default,
							'frontend_available' => true,
						]
					);
					break;

				case 'slides_to_scroll':
					$this->add_responsive_control(
						'slides_to_scroll',
						[
							'label'     => __( 'Slides to Scroll', 'ecomus-addons' ),
							'type'      => Controls_Manager::NUMBER,
							'min'       => 1,
							'max'       => 50,
							'step'      => 1,
							'default'   => $default,
							'frontend_available' => true,
						]
					);
					break;

				case 'space_between':
					$this->add_responsive_control(
						'image_spacing_custom',
						[
							'label'     => __( 'Space Between', 'ecomus-addons' ),
							'type'      => Controls_Manager::NUMBER,
							'min'       => 0,
							'max'       => 200,
							'step'      => 5,
							'default'   => $default,
							'frontend_available' => true,
							'render_type' => 'none',
						]
					);
					break;

				case 'navigation':
					$this->add_control(
						'navigation',
						[
							'label' => __( 'Navigation', 'ecomus-addons' ),
							'type' => Controls_Manager::HIDDEN,
							'default' => 'both',
							'frontend_available' => true,
						]
					);
					$this->add_responsive_control(
						'navigation_classes',
						[
							'label' => __( 'Navigation', 'ecomus-addons' ),
							'type' => Controls_Manager::SELECT,
							'options' => [
								'arrows' => esc_html__('Arrows', 'ecomus-addons'),
								'dots' => esc_html__('Dots', 'ecomus-addons'),
								'both' => esc_html__('Arrows and Dots', 'ecomus-addons'),
								'none' => esc_html__('None', 'ecomus-addons'),
							],
							'default' => 'arrows',
							'prefix_class' => 'navigation-class-%s',
						]
					);
					break;

				case 'autoplay':
					$this->add_control(
						'autoplay',
						[
							'label' => __( 'Autoplay', 'ecomus-addons' ),
							'type'      => Controls_Manager::SWITCHER,
							'label_off' => __( 'Off', 'ecomus-addons' ),
							'label_on'  => __( 'On', 'ecomus-addons' ),
							'default'   => '',
							'frontend_available' => true,
						]
					);
					break;

				case 'autoplay_speed':
					$this->add_control(
						'autoplay_speed',
						[
							'label'   => __( 'Autoplay Speed', 'ecomus-addons' ),
							'type'    => Controls_Manager::NUMBER,
							'default' => $default,
							'min'     => 100,
							'step'    => 100,
							'frontend_available' => true,
							'condition' => [
								'autoplay' => 'yes',
							],
			]
					);
					break;

				case 'pause_on_hover':
					$this->add_control(
						'pause_on_hover',
						[
							'label'   => __( 'Pause on Hover', 'ecomus-addons' ),
							'type'    => Controls_Manager::SWITCHER,
							'label_off' => __( 'Off', 'ecomus-addons' ),
							'label_on'  => __( 'On', 'ecomus-addons' ),
							'default'   => $default,
							'frontend_available' => true,
							'condition' => [
								'autoplay' => 'yes',
							],
						]
					);
					break;

				case 'animation_speed':
					$this->add_control(
						'speed',
						[
							'label'       => __( 'Animation Speed', 'ecomus-addons' ),
							'type'        => Controls_Manager::NUMBER,
							'default'     => $default,
							'min'         => 100,
							'step'        => 50,
							'frontend_available' => true,
						]
					);
					break;

				case 'infinite':
					$this->add_control(
						'infinite',
						[
							'label'       => __( 'Infinite Loop', 'ecomus-addons' ),
							'type'    => Controls_Manager::SWITCHER,
							'label_off' => __( 'Off', 'ecomus-addons' ),
							'label_on'  => __( 'On', 'ecomus-addons' ),
							'default'   => $default,
							'frontend_available' => true,
						]
					);
					break;
			}

		}
	}

	/**
	 * Register controls style
	 *
	 * @param array $controls
	 */
	protected function register_carousel_style_controls( $arrows_type = 'solid', $arrows_position = false ) {
		$this->register_carousel_arrows_style_controls( $arrows_type, $arrows_position );
		$this->register_carousel_dots_style_controls();
	}
	/**
	 * Register controls style
	 *
	 * @param array $controls
	 */
	protected function register_carousel_arrows_style_controls( $arrows_type, $arrows_position ) {
		$condition  = [];
		if( $arrows_position ) {
			$condition = [
				'arrows_position' => 'center',
			];
		}
		// Arrows
		$this->add_control(
			'arrows_style_heading',
			[
				'label' => esc_html__( 'Arrows', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'arrows_show',
			[
				'label'        => __( 'Always show button', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'ecomus-addons' ),
				'label_on'     => __( 'On', 'ecomus-addons' ),
				'default'      => '',
				'return_value' => '1',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => 'opacity: {{VALUE}}; margin-left: 0; margin-right: 0;',
				]
			]
		);

		$this->add_control(
			'arrows_type',
			[
				'label'   => esc_html__( 'Arrows Type', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'solid'        => esc_html__( 'Solid', 'ecomus-addons' ),
					'outline'      => esc_html__( 'Outline', 'ecomus-addons' ),
					'outline-dark' => esc_html__( 'Outline Dark', 'ecomus-addons' ),
				],
				'default' => $arrows_type,
			]
		);

		$this->add_responsive_control(
			'arrows_horizontal_spacing',
			[
				'label'      => esc_html__( 'Horizontal Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 1170,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .elementor-swiper-button-prev' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
					'{{WRAPPER}} .elementor-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .elementor-swiper-button-next' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
				'condition' => $condition
			]
		);

		$this->add_responsive_control(
			'arrows_vertical_spacing',
			[
				'label'      => esc_html__( 'Vertical Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1170,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-top: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
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
					'{{WRAPPER}} .swiper-button' => '--em-arrow-font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_width',
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
					'{{WRAPPER}} .swiper-button' => '--em-arrow-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_height',
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
					'{{WRAPPER}} .swiper-button' => '--em-arrow-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .swiper-button' => '--em-arrow-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'arrows_tabs'
		);
		$this->start_controls_tab(
			'arrows_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ecomus-addons' ),
			]
		);
		$this->add_control(
			'arrows_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrows_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'arrows_hover_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrows_disable_tab',
			[
				'label' => esc_html__( 'Disable', 'ecomus-addons' ),
			]
		);
		$this->add_control(
			'arrows_disable_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button.swiper-button-disabled' => '--em-arrow-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_disable_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button.swiper-button-disabled' => '--em-arrow-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_disable_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button.swiper-button-disabled' => '--em-arrow-border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
	}
	/**
	 * Register controls style
	 *
	 * @param array $controls
	 */
	protected function register_carousel_dots_style_controls() {
		// Dots
		$this->add_control(
			'dots_style_heading',
			[
				'label' => esc_html__( 'Dots', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dots_type',
			[
				'label'   => esc_html__( 'Dots Type', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''           => esc_html__( 'Border Normal', 'ecomus-addons' ),
					'small'      => esc_html__( 'Border Small', 'ecomus-addons' ),
					'background' => esc_html__( 'Background', 'ecomus-addons' ),
					'long'       => esc_html__( 'Long', 'ecomus-addons' ),
					'line'       => esc_html__( 'Line', 'ecomus-addons' ),
				],
				'default' => 'small',
			]
		);

		$this->add_responsive_control(
			'dots_gap',
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
					'{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-pagination' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'dots_size',
			[
				'label'     => __( 'Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination:not(.swiper-pagination-bullet--small) .swiper-pagination-bullet:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-pagination.swiper-pagination-bullet--small .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'dots_type!' => [ 'long', 'line' ]
				]
			]
		);

		$this->add_responsive_control(
			'dots_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1000,
						'min' => 0,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullets' => '--em-swiper-pagination-spacing: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.ecomus-carousel__dots-position-inside .swiper-pagination-bullets' => '--em-swiper-pagination-spacing: 0; bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'dot_item_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => '--em-color__dark : {{VALUE}};',
					'{{WRAPPER}} .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dot_item_active_color',
			[
				'label'     => esc_html__( 'Color Active', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active, {{WRAPPER}} .swiper-pagination-bullet:hover' => '--em-color__dark : {{VALUE}};',
					'{{WRAPPER}} .swiper-pagination-bullet-active:before, {{WRAPPER}} .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_item_active_background_color',
			[
				'label'     => esc_html__( 'Background Color Active', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination.swiper-pagination-bullet--background .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'dots_type' => 'background',
				],
			]
		);
	}

	/**
	 * Render pagination for shortcode.
	 *
	 */
	protected function render_pagination( $classes = '' ) {
		$settings = $this->get_settings_for_display();
		$classes .= ! empty( $settings['dots_type'] ) ? ' swiper-pagination-bullet--' . $settings['dots_type'] : '';
		return '<div class="swiper-pagination '. esc_attr( $classes ) .'"></div>';
	}

	/**
	 * Render arrows for shortcode.
	 *
	 */
	protected function render_arrows( $class = "" ) {
		$settings = $this->get_settings_for_display();
		$class = isset($settings['arrows_horizontal_spacing']) && floatval( $settings['arrows_horizontal_spacing']['size'] ) < 0 ? $class . ' ecomus-swiper-button--outside' : $class;

		if ( $settings['arrows_type'] != 'solid' ) {
			$class .= ' swiper-button-' . $settings['arrows_type'];
		}

		$html = Helper::get_svg('left-mini', 'ui' , [ 'class' => 'elementor-swiper-button-prev swiper-button ' . $class ] );
		$html .= Helper::get_svg('right-mini', 'ui' , [ 'class' => 'elementor-swiper-button-next swiper-button ' . $class ] );

		return $html;
	}

	/**
	 * Render aspect ratio style
	 *
	 * @return void
	 */
    protected function render_space_between_style( $custom_space_between = null, $custom_space_between_tablet = null, $custom_space_between_mobile = null ) {
        $settings = $this->get_settings_for_display();

		$style = '';

		$space_between = ! empty( $settings['image_spacing_custom'] ) ? $settings['image_spacing_custom'] : 0;
		$space_between_tablet = ! empty( $settings['image_spacing_custom_tablet'] ) ? $settings['image_spacing_custom_tablet'] : $space_between;
		$space_between_mobile = ! empty( $settings['image_spacing_custom_mobile'] ) ? $settings['image_spacing_custom_mobile'] : $space_between_tablet;

		if( $space_between !== 30 ) {
			$style .= '--em-swiper-items-space: '. esc_attr( $space_between ) . 'px;';
		}

		if( $space_between_tablet !== 30 ) {
			$style .= '--em-swiper-items-space-tablet: '. esc_attr( $space_between_tablet ) . 'px;';
		}

		if( $space_between_mobile !== 15 ) {
			$style .= '--em-swiper-items-space-mobile: '. esc_attr( $space_between_mobile ) . 'px;';
		}

		if( $custom_space_between !== null ) {
			$space_between = $custom_space_between;
			$space_between_tablet = $custom_space_between_tablet !== null ? $custom_space_between_tablet : $space_between;
			$space_between_mobile = $custom_space_between_mobile !== null ? $custom_space_between_mobile : $space_between_tablet;

			if( isset( $space_between ) ) {
				$style .= '--em-swiper-items-space: '. esc_attr( $space_between ) . 'px;';
			}

			if( isset( $space_between_tablet ) ) {
				$style .= '--em-swiper-items-space-tablet: '. esc_attr( $space_between_tablet ) . 'px;';
			}

			if( isset( $space_between_mobile ) ) {
				$style .= '--em-swiper-items-space-mobile: '. esc_attr( $space_between_mobile ) . 'px;';
			}
		}

        return $style;
    }
}