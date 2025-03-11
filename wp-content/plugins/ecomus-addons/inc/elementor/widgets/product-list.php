<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Ecomus\Addons\Elementor\Base\Products_Widget_Base;
use \Ecomus\Addons\Woocommerce\Products_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product List widget
 */
class Product_List extends Products_Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-product-list';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Products List', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
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
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'products_divider',
			[
				'label' => esc_html__( 'Products', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Total Products', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent_products'       => esc_html__( 'Recent', 'ecomus-addons' ),
					'featured_products'     => esc_html__( 'Featured', 'ecomus-addons' ),
					'best_selling_products' => esc_html__( 'Best Selling', 'ecomus-addons' ),
					'top_rated_products'    => esc_html__( 'Top Rated', 'ecomus-addons' ),
					'sale_products'         => esc_html__( 'On Sale', 'ecomus-addons' ),
					'custom_products'       => esc_html__( 'Custom', 'ecomus-addons' ),
				],
				'default'   => 'recent_products',
				'toggle'    => false,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'menu_order' => __( 'Menu Order', 'ecomus-addons' ),
					'date'       => __( 'Date', 'ecomus-addons' ),
					'title'      => __( 'Title', 'ecomus-addons' ),
					'price'      => __( 'Price', 'ecomus-addons' ),
				],
				'condition' => [
					'products'            => [ 'top_rated_products', 'sale_products', 'featured_products' ],
				],
				'default'   => 'date',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'ecomus-addons' ),
					'asc'  => esc_html__( 'Ascending', 'ecomus-addons' ),
					'desc' => esc_html__( 'Descending', 'ecomus-addons' ),
				],
				'condition' => [
					'products'            => [ 'top_rated_products', 'sale_products', 'featured_products' ],
				],
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'ids',
			[
				'label' => __( 'Products', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => true,
				'label_block' => true,
				'condition' => [
					'products' => ['custom_products']
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'product_cat',
			[
				'label'       => esc_html__( 'Product Categories', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'frontend_available' => true,
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

		$this->add_control(
			'product_tag',
			[
				'label'       => esc_html__( 'Product Tags', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
				'frontend_available' => true,
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

		$this->add_control(
			'product_brand',
			[
				'label'       => esc_html__( 'Product Brands', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
				'frontend_available' => true,
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

		$this->add_responsive_control(
			'scrollbar',
			[
				'label'      => __( 'Scrollbar', 'ecomus-addons' ),
				'type'       => Controls_Manager::SWITCHER,
				'label_off'  => __( 'Hide', 'ecomus-addons' ),
				'label_on'   => __( 'Show', 'ecomus-addons' ),
				'responsive' => true,
				'default'    => 'yes',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'condition' => [
					'scrollbar' => ['yes']
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-list' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->start_controls_section(
			'section_style_product',
			[
				'label' => esc_html__( 'Product', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'spacing',
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
					'{{WRAPPER}} .ecomus-product-list ul.products.product-card-layout-list li.product' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ecomus-product-list ul.products.product-card-layout-list li.product:last-child' => 'margin-bottom: 0',
				],
			]
		);

		$this->add_control(
			'product_image_heading',
			[
				'label' => esc_html__( 'Product Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'product_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-image-rounded-product-card: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded-product-card: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_title_heading',
			[
				'label' => esc_html__( 'Product Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_title_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products.product-card-layout-list li.product .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} ul.products.product-card-layout-list li.product .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_rating_heading',
			[
				'label' => esc_html__( 'Product Rating', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_rating_position',
			[
				'label'       => esc_html__( 'Position', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'before' => esc_html__( 'Before Product Title', 'ecomus-addons' ),
					'after'  => esc_html__( 'After Product Title', 'ecomus-addons' ),
				],
				'default'     => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'ecomus-product-list',
			isset( $settings['scrollbar'] ) && $settings['scrollbar'] == 'yes' ? 'ecomus-product-list--scrollbar' : '',
			isset( $settings['scrollbar_tablet'] ) && $settings['scrollbar_tablet'] == 'yes' ? 'ecomus-product-list--scrollbar-tablet' : '',
			isset( $settings['scrollbar_mobile'] ) && $settings['scrollbar_mobile'] == 'yes' ? 'ecomus-product-list--scrollbar-mobile' : '',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'ul', 'class', [ 'ecomus-product-list__products', 'products', 'product-card-layout-list', 'em-flex', 'em-flex-wrap' ] );
		$this->add_render_attribute( 'li', 'class', [ 'ecomus-product-list__product', 'product' ] );
		$this->add_render_attribute( 'thumbnail', 'class', [ 'ecomus-product-list__thumbnail', 'product-thumbnail' ] );
		$this->add_render_attribute( 'summary', 'class', [ 'ecomus-product-list__summary product-summary' ] );
		$this->add_render_attribute( 'product_title', 'class', [ 'ecomus-product-list__title', 'woocommerce-loop-product__title', 'em-font-normal' ] );
		$this->add_render_attribute( 'product_price', 'class', [ 'ecomus-product-list__price' ] );

		$attr = [
			'type'           => $settings['products'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'category'       => $settings['product_cat'],
			'tag'            => $settings['product_tag'],
			'product_brands' => $settings['product_brand'],
			'ids'            => $settings['ids'],
			'limit'          => $settings['limit'],
		];

		$product_ids = self::products_shortcode( $attr );

		$product_ids = ! empty($product_ids) ? $product_ids['ids'] : 0;
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<ul <?php echo $this->get_render_attribute_string( 'ul' ); ?>>
				<?php foreach( $product_ids as $id ) : $product = wc_get_product( $id ); ?>
					<li <?php echo $this->get_render_attribute_string( 'li' ); ?>>
						<div class="product-inner">
							<div <?php echo $this->get_render_attribute_string( 'thumbnail' ); ?>>
								<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'woocommerce_thumbnail' ); ?>
								<?php $image_src = $image ? $image[0] : ''; ?>
								<a class="woocommerce-loop-product__link woocommerce-LoopProduct-link" href="<?php echo esc_url( get_permalink( $id ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>" data-image="<?php echo esc_url( $image_src); ?>">
									<?php echo $product->get_image(); ?>
								</a>
							</div>

							<div <?php echo $this->get_render_attribute_string( 'summary' ); ?>>
								<?php
									if( $settings['product_rating_position'] == 'before' ) {
										self::product_rating( $product );
									}
								?>
								<h6 <?php echo $this->get_render_attribute_string( 'product_title' ); ?>>
									<a href="<?php echo esc_url( get_permalink( $id ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
								</h6>
								<?php
									if( $settings['product_rating_position'] == 'after' ) {
										self::product_rating( $product );
									}
								?>
								<div <?php echo $this->get_render_attribute_string( 'product_price' ); ?>>
									<span class="price">
										<?php echo wp_kses_post( $product->get_price_html() ); ?>
									</span>
								</div>
								<?php if( $product->is_type( 'variable' ) && class_exists( 'Ecomus\WooCommerce\Loop\Product_Attribute' ) ) : ?>
									<?php \Ecomus\WooCommerce\Loop\Product_Attribute::instance()->product_attribute( $product ); ?>
								<?php endif; ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Rating count open.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_rating( $product ) {
		echo '<div class="ecomus-rating em-flex em-flex-align-center">';
			if ( $product->get_rating_count() ) {
				if ( wc_review_ratings_enabled() ) {
					echo wc_get_rating_html( $product->get_average_rating() );
				}
			} else {
			?>
				<div class="star-rating" role="img">
					<span class="max-rating rating-stars">
						<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=star' ); ?>
						<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=star' ); ?>
						<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=star' ); ?>
						<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=star' ); ?>
						<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=star' ); ?>
					</span>
				</div>
			<?php
			}

			?>
			<div class="review-count"><?php echo '(' . esc_html( $product->get_review_count() ) . ')'; ?></div>
			<?php
		echo '</div>';
	}
}