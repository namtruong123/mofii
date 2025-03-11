<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Ecomus\Addons\Elementor\Base\Products_Widget_Base;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Related extends Products_Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-related';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Related', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-related';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'product', 'related' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-product-elementor-widgets'
		];
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
			'section_related_products_content',
			[
				'label' => esc_html__( 'Related Products', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your title', 'ecomus-addons' ),
				'default' => '',
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Products Per Page', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5,
				'range' => [
					'px' => [
						'max' => 20,
					],
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => esc_html__( 'Date', 'ecomus-addons' ),
					'title'      => esc_html__( 'Title', 'ecomus-addons' ),
					'price'      => esc_html__( 'Price', 'ecomus-addons' ),
					'popularity' => esc_html__( 'Popularity', 'ecomus-addons' ),
					'rating'     => esc_html__( 'Rating', 'ecomus-addons' ),
					'rand'       => esc_html__( 'Random', 'ecomus-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'ecomus-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'ASC', 'ecomus-addons' ),
					'desc' => esc_html__( 'DESC', 'ecomus-addons' ),
				],
			]
		);

		$this->end_controls_section();

		$this->section_content_carousel();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .related-products__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .related-products__title',
			]
		);

		$this->add_responsive_control(
			'heading_text_align',
			[
				'label' => esc_html__( 'Text Align', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .related-products__title' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .related-products__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_style',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();
	}

	protected function section_content_carousel() {
		$this->start_controls_section(
			'section_products_carousel',
			[
				'label' => __( 'Carousel Settings', 'ecomus-addons' ),
			]
		);

		$controls = [
			'slides_to_show'   => 4,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => '',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls( $controls );

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
		global $product;
		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		$args = [
			'posts_per_page' => $settings['posts_per_page'],
			'columns' => 4,
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
		];

		if ( ! empty( $settings['slides_to_show'] ) ) {
			$args['columns'] = $settings['slides_to_show'];
		}

		if( function_exists('wc_set_loop_prop') ) {
			wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
		}

		$args = array_map( 'sanitize_text_field', $args );

		$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
		$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

		add_filter('woocommerce_product_related_products_heading', '__return_false');

		$heading = ! empty( $settings['heading'] ) ? sprintf( '<h2 class="related-products__title">%s</h2>', $settings['heading'] ) : '';

		$this->add_render_attribute( 'wrapper', 'class', [
			'related-product__carousel',
			'ecomus-products-carousel--elementor',
			'ecomus-carousel--elementor',
			'woocommerce',
		] );
		ob_start();
		wc_get_template( 'single-product/related.php', $args );
		$related_html = ob_get_clean();
		if( empty( $related_html ) ) {
			return;
		}
		?>
		<?php echo $heading; ?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ) ?>>
			<?php echo $related_html; ?>
			<?php echo $this->render_arrows(); ?>
			<?php echo $this->render_pagination(); ?>
		</div>
		<?php
	}
}
