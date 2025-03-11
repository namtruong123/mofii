<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Category extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-category';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Category', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-meta';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'category', 'taxonomy', 'product' ];
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
			'section_title',
			[
				'label' => esc_html__( 'Product Category', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_taxonomy',
			[
				'label' => esc_html__( 'Product Taxonomy', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Category', 'ecomus-addons' ),
					'product_brand' => esc_html__( 'Brand', 'ecomus-addons' ),
				],
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_category_style',
			[
				'label' => esc_html__( 'Product Category', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .product-category',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_heading',
			[
				'label' => esc_html__( 'Link', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'selector' => '{{WRAPPER}} .product-category a',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-category a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-category a:hover' => 'color: {{VALUE}};',
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

		$this->add_render_attribute( 'title', 'class', [ 'product-category', 'meta', 'meta-cat' ] );
		$taxonomy = $settings['product_taxonomy'];
		$taxonomy = empty($taxonomy) ? 'product_cat' : $taxonomy;
		$terms = wp_get_post_terms( $product->get_id(), $taxonomy, array( 'orderby' => 'parent', 'order'   => 'DESC', ) );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return;
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'title' ); ?>>
			<?php echo ! empty( $settings['product_taxonomy'] ) ? esc_html__( 'Brand:', 'ecomus' ) : esc_html__( 'Category:', 'ecomus' ); ?>
			<a href="<?php echo esc_url( get_term_link( $terms[0] ), $taxonomy ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a>
		</div>
		<?php
	}
}
