<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Countdown extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-countdown';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Countdown', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'countdown', 'sale', 'product' ];
	}

	/**
	 * Get HTML wrapper class.
	 *
	 * Retrieve the widget container class. Can be used to override the
	 * container class for specific widgets.
	 *
	 * @since 2.0.9
	 * @access protected
	 */
	protected function get_html_wrapper_class() {
		return 'elementor-widget-' . $this->get_name() . ' entry-summary';
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Hurry Up! Sale ends in:', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .em-countdown-single-product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart.single-product.single-product-elementor div.product {{WRAPPER}} .em-countdown-single-product' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'max_width',
			[
				'label' => __( 'Max Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .em-countdown-single-product' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .em-countdown-single-product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-countdown-single-product' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .em-countdown-single-product' => '--em-rounded-xs: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-countdown-single-product' => '--em-rounded-xs: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-countdown-single-product' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'     => esc_html__( 'Text', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .em-product-countdown__text .em-countdown-text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-product-countdown__text .em-countdown-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
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
					'{{WRAPPER}} .em-product-countdown__text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_icon',
			[
				'label'     => esc_html__( 'Icon', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
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
					'{{WRAPPER}} .em-product-countdown__text .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-product-countdown__text .ecomus-svg-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
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
					'{{WRAPPER}} .em-product-countdown__text .ecomus-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-product-countdown__text .ecomus-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_timer_style',
			[
				'label' => esc_html__( 'Timer', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'timer_typography',
				'selector' => '{{WRAPPER}} .em-countdown-single-product .ecomus-countdown',
			]
		);

		$this->add_control(
			'timer_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-countdown-single-product .ecomus-countdown' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'timer_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
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
					'{{WRAPPER}} .em-countdown-single-product .ecomus-countdown .divider' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_digits',
			[
				'label'     => esc_html__( 'Digits', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'digits_min_width',
			[
				'label' => __( 'Min Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .em-countdown-single-product .ecomus-countdown .digits' => 'min-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .em-countdown-single-product .ecomus-countdown .days .digits' => 'min-width: auto;',
				],
			]
		);

		$this->add_control(
			'heading_days',
			[
				'label'     => esc_html__( 'Days', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'days_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
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
					'{{WRAPPER}} .em-countdown-single-product .ecomus-countdown .days .digits' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-countdown-single-product .ecomus-countdown .days .digits' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		global $product;
		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		$icon = \Ecomus\Icon::get_svg( 'clock', 'ui', 'class=em-countdown-icon em-vibrate' );
		$_text = esc_html__( 'Hurry Up! Sale ends in:', 'ecomus' );

		if( ! empty( $settings['icon']['value'] ) ) {
			$icon = '<span class="ecomus-svg-icon ecomus-svg-icon--clock em-countdown-icon em-vibrate">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
		}

		if( ! empty( $settings['text'] ) ) {
			$_text = esc_html( $settings['text'] );
		}

		$sale = array(
			'weeks'   => esc_html__( 'Weeks', 'ecomus' ),
			'week'    => esc_html__( 'Week', 'ecomus' ),
			'days'    => esc_html__( 'Days', 'ecomus' ),
			'day'     => esc_html__( 'Day', 'ecomus' ),
			'hours'   => esc_html__( 'Hours', 'ecomus' ),
			'hour'    => esc_html__( 'Hour', 'ecomus' ),
			'minutes' => esc_html__( 'Mins', 'ecomus' ),
			'minute'  => esc_html__( 'Min', 'ecomus' ),
			'seconds' => esc_html__( 'Secs', 'ecomus' ),
			'second'  => esc_html__( 'Sec', 'ecomus' ),
		);

		$text = $icon . '<span class="em-countdown-text em-font-bold">' . $_text . '</span>';

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			echo $this->get_countdown_html( $sale, $text, 'em-countdown-single-product' );
		} else {
			if ( 'grouped' == $product->get_type() ) {
				return '';
			}

			if ( $product->is_on_sale() ) {
				if( \Ecomus\WooCommerce\Helper::get_product_countdown( $sale, $text, 'em-countdown-single-product' ) ) {
					echo \Ecomus\WooCommerce\Helper::get_product_countdown( $sale, $text, 'em-countdown-single-product' );
				} else {
					if( $this->check_variation_countdown( $product, $sale, $text ) ) {
						echo '<div class="em-countdown-single-product hidden"></div>';
					}
				}
			}
		}
	}

	public function get_countdown_html( $sale, $text, $classes ) {
		$current_date = strtotime( current_time( 'Y-m-d H:i:s' ) );
    	$expire = strtotime( '00:00 next monday', $current_date ) - $current_date;
		$days = floor($expire / (60 * 60 * 24));
		$hours = str_pad(floor(($expire % (60 * 60 * 24)) / (60 * 60)), 2, '0', STR_PAD_LEFT);
		$minutes = str_pad(floor(($expire % (60 * 60)) / (60)), 2, '0', STR_PAD_LEFT);
		$seconds = str_pad(floor($expire % 60), 2, '0', STR_PAD_LEFT);

		if ( $text ) {
			$text = '<div class="em-product-countdown__text">'. $text .'</div>';
		}

		return sprintf( '<div class="em-product-countdown %s">
							%s
							<div class="ecomus-countdown" data-expire="%s" data-text="%s">
								<span class="days timer">
									<span class="digits">%s</span>
									<span class="text">%s</span>
									<span class="divider">:</span>
								</span>
								<span class="hours timer">
									<span class="digits">%s</span>
									<span class="text">%s</span>
									<span class="divider">:</span>
								</span>
								<span class="minutes timer">
									<span class="digits">%s</span>
									<span class="text">%s</span>
									<span class="divider">:</span>
								</span>
								<span class="seconds timer">
									<span class="digits">%s</span>
									<span class="text">%s</span>
								</span>
							</div>
						</div>',
					! empty( $classes ) ? esc_attr( $classes ) : '',
					$text,
					esc_attr( $expire ),
					esc_attr( wp_json_encode( $sale ) ),
					esc_html( $days ),
					$sale['days'],
					esc_html( $hours ),
					$sale['hours'],
					esc_html( $minutes ),
					$sale['minutes'],
					esc_html( $seconds ),
					$sale['seconds']
				);
	}

	public function check_variation_countdown( $product, $sale, $text ) {
		$bool = null;

		if( ! $product->is_type('variable') ) {
			return $bool;
		}

		$variation_ids = $product->get_visible_children();
		foreach( $variation_ids as $variation_id ) {
			$variation = wc_get_product( $variation_id );
			if ( $variation->is_on_sale() ) {
				$date_on_sale_to  = $variation->get_date_on_sale_to();

				if( ! empty( apply_filters( 'ecomus_countdown_product_second', $date_on_sale_to ) ) ) {
					$date_on_sale_to = strtotime( $date_on_sale_to );
					if( ! empty( \Ecomus\WooCommerce\Helper::get_product_countdown( $sale, $text, 'em-countdown-single-product--variable variation-id-' . esc_attr( $variation_id ), null, $date_on_sale_to ) ) ) {
						$bool = true;
					}
				}
			}
		}

		return $bool;
	}
}
