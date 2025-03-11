<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Short_Description extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-short-description';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Short Description', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-description';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'short', 'description', 'product' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-product-elementor-widgets'
		];
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
			[ 'label' => __( 'Content', 'ecomus-addons' ) ]
		);

		$this->add_control(
            'description_lines',
            [
                'label'     => __( 'Product Description Lines', 'ecomus-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 1,
                'max'       => 50,
                'step'      => 1,
                'default'   => 4,
                'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}}' => '--em-product-description-lines: {{VALUE}}',
				],
            ]
        );

		$this->add_control(
			'more_text',
			[
				'label' => __( 'Show More Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Show More', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'less_text',
			[
				'label' => __( 'Show Less Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Show Less', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .short-description__content',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .short-description__content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'   => __( 'Style', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'subtle',
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
			'button_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .short-description .short-description__more' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .short-description__more',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .short-description__more',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .short-description__more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .short-description__more' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .short-description__more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .short-description__more' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab(
			'button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .short-description__more' => '--em-button-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .short-description__more' => '--em-button-bg-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .short-description__more' => '--em-button-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .short-description__more' => '--em-button-bg-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .short-description__more:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .short-description__more' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		
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

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$this->short_description_html( $settings );
			return;
		}

		$content = $product->get_short_description();
		if( empty( $content ) ) {
			return;
		}

		echo '<div class="short-description">';
			$option = array(
				'more'   => ! empty( $settings['more_text'] ) ? $settings['more_text'] : esc_html__( 'Show More', 'ecomus' ),
				'less'   => ! empty( $settings['less_text'] ) ? $settings['less_text'] : esc_html__( 'Show Less', 'ecomus' )
			);

			echo sprintf('<div class="short-description__content">%s</div>', wp_kses_post( do_shortcode($content) ));
			echo sprintf('
				<button class="short-description__more em-button-%s show hidden" data-settings="%s">%s</button>',
				esc_attr( $settings['button_style'] ),
				htmlspecialchars(json_encode( $option )),
				$option['more']
			);
		echo '</div>';
	}

	public function short_description_html( $settings ) {
		echo '<div class="short-description">';
			$option = array(
				'more'   => ! empty( $settings['more_text'] ) ? $settings['more_text'] : esc_html__( 'Show More', 'ecomus' ),
				'less'   => ! empty( $settings['less_text'] ) ? $settings['less_text'] : esc_html__( 'Show Less', 'ecomus' )
			);

			?><div class="short-description__content">
				<?php esc_html_e( "Button-up shirt sleeves and a relaxed silhouette. It’s tailored with drapey, crinkle-texture fabric that’s made from LENZING™ ECOVERO™ Viscose — responsibly sourced wood-based fibres produced through a process that reduces impact on forests, biodiversity and water supply. The Company Private Limited and each of their respective subsidiary, parent and affiliated companies is deemed to operate this Website (“we” or “us”) recognizes that you care how information about you is used and shared. Please be advised that the practices described in this Privacy Policy apply to information gathered by us or our subsidiaries, affiliates or agents: (i) through this Website, (ii) where applicable, through our Customer Service Department in connection with this Website, (iii) through information provided to us in our free standing retail stores, and (iv) through information provided to us in conjunction with marketing promotions and sweepstakes.", 'ecomus-addons' ); ?>
			</div><?php
			echo sprintf('
				<button class="short-description__more em-button-%s show hidden" data-settings="%s">%s</button>',
				esc_attr( $settings['button_style'] ),
				htmlspecialchars(json_encode( $option )),
				$option['more']
			);
		echo '</div>';
	}
}
