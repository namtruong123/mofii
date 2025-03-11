<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_SKU extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-sku';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product SKU', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-meta';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'sku', 'product' ];
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
			'label',
			[
				'label' => __( 'Label', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'SKU:', 'ecomus-addons' ),
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
				'selector' => '{{WRAPPER}} .sku_wrapper',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sku_wrapper' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sku_heading',
			[
				'label' => esc_html__( 'SKU', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sku_typography',
				'selector' => '{{WRAPPER}} .sku_wrapper .sku',
			]
		);

		$this->add_control(
			'sku_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sku_wrapper .sku' => 'color: {{VALUE}};',
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

		if ( ! \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			if( ! wc_product_sku_enabled() ) {
				return;
			}
		}
		?>
		<div class="product_meta">
			<span class="sku_wrapper"><?php echo ! empty( $settings['label'] ) ? $settings['label'] : esc_html_e( 'SKU:', 'ecomus' ); ?>
				<span class="sku">
					<?php if ( $sku = $product->get_sku() ) {
						echo !empty( $sku ) ? $sku : '';
					} else {
						esc_html_e( 'N/A', 'ecomus' );
					}   ?>
				</span>
			</span>
		</div>
		<?php
	}
}
