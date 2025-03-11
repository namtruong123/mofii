<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Ecomus\Addons\Woocommerce\Products_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Look Book Products
 */
class Lookbook_Products extends Widget_Base {
	use \Ecomus\Addons\Woocommerce\Products_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-lookbook-products';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Lookbook Products', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-hotspot';
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
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'lookbook', 'products', 'product', 'ecomus-addons' ];
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
	   	$this->start_controls_section(
			'section_lookbook',
			[ 'label' => __( 'Lookbook', 'ecomus-addons' ) ]
		);

		$this->add_responsive_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/850x1000/f1f1f1?text=image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'full',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the title', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your title', 'ecomus-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label' => __( 'Sub Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the sub title', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your sub title', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'product_id',
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

		$repeater->add_responsive_control(
			'pin_position_x',
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
					'size' => 30,
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-lookbook-products {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-lookbook-products {{CURRENT_ITEM}}' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
			]
		);

		$repeater->add_responsive_control(
			'pin_position_y',
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
					'size' => 55,
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-lookbook-products {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'lookbook_products',
			[
				'label' => esc_html__( 'Products', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'lookbook_type',
			[
				'label'   => esc_html__( 'Product Type', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'carousel' => esc_html__( 'Carousel', 'ecomus-addons' ),
					'list'  => esc_html__( 'List', 'ecomus-addons' ),
				],
				'default' => 'carousel',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Style
		$this->start_controls_section(
			'section_style_content',
			[
				'label'     => __( 'Lookbook', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_sticky',
			[
				'label'       => esc_html__( 'Sticky', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'content_heading',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label'      => esc_html__( 'Gap', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-lookbook-products' => 'gap: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-lookbook-products__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-lookbook-products__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-lookbook-products__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sub_title_heading',
			[
				'label' => esc_html__( 'Sub Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-lookbook-products__sub-title',
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-lookbook-products__sub-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'sub_title_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-lookbook-products__sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
					'{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .swiper-button-next' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
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
					'{{WRAPPER}} .swiper-button' => '--em-arrow-top: {{SIZE}}{{UNIT}} ;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$data_products = $product_ids = [];
		$price = 0;
		$data = [
			'currency_pos'    => get_option( 'woocommerce_currency_pos' ),
			'currency_symbol' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '',
			'thousand_sep'    => function_exists( 'wc_get_price_thousand_separator' ) ? wc_get_price_thousand_separator() : '',
			'decimal_sep'     => function_exists( 'wc_get_price_decimal_separator' ) ? wc_get_price_decimal_separator() : '',
			'price_decimals'  => function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : '',
		];

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-lookbook-products', 'ecomus-carousel--elementor', 'ecomus-lookbook__product-type--' . $settings['lookbook_type'], 'em-flex', 'ecomus-sticky--' . esc_attr( $settings['section_sticky'] ) ] );
		$this->add_render_attribute( 'wrapper', 'data-price', esc_attr( json_encode( $data ) ) );
		$this->add_render_attribute( 'image', 'class', [ 'ecomus-lookbook-products__image' ] );
		$this->add_render_attribute( 'image_inner', 'class', [ 'ecomus-lookbook-products__image-inner', 'em-relative' ] );
		$this->add_render_attribute( 'content', 'class', [ 'ecomus-lookbook-products__content' ] );
		$this->add_render_attribute( 'wrapper_inner', 'class', [ 'ecomus-lookbook-products__wrapper', 'em-relative' ] );


		$this->add_render_attribute( 'ul', 'class', [ 'ecomus-lookbook-products__products', 'products', 'product-card-layout-list', 'em-flex-wrap', 'swiper-wrapper' ] );
		$this->add_render_attribute( 'li', 'class', [ 'ecomus-lookbook-products__product', 'product', 'swiper-slide' ] );
		$this->add_render_attribute( 'thumbnail', 'class', [ 'ecomus-lookbook-products__product-thumbnail', 'product-thumbnail' ] );
		$this->add_render_attribute( 'summary', 'class', [ 'ecomus-lookbook-products__product-summary product-summary' ] );
		$this->add_render_attribute( 'product_title', 'class', [ 'ecomus-lookbook-products__product-title', 'woocommerce-loop-product__title', 'em-font-normal' ] );
		$this->add_render_attribute( 'product_price', 'class', [ 'ecomus-lookbook-products__product-price' ] );

		$this->add_render_attribute( 'title', 'class', [ 'ecomus-lookbook-products__title' ] );
		$this->add_render_attribute( 'sub_title', 'class', [ 'ecomus-lookbook-products__sub-title', 'em-font-bold' ] );
		$this->add_render_attribute( 'list_title', 'class', [ 'ecomus-lookbook-products__title', 'hidden-sm hidden-md hidden-lg' ] );
		$this->add_render_attribute( 'list_sub_title', 'class', [ 'ecomus-lookbook-products__sub-title', 'em-font-bold', 'em-color-dark', 'hidden-sm hidden-md hidden-lg' ] );

		if ( $settings['lookbook_type'] == 'list' ) {
			$this->add_render_attribute( 'title', 'class', [ 'hidden-xs' ] );
			$this->add_render_attribute( 'sub_title', 'class', [ 'hidden-xs' ] );
		}
	?>

	<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
		<div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
			<?php if( ! empty( $settings['sub_title'] ) && $settings['lookbook_type'] == 'list' ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'list_sub_title' ); ?>><?php echo wp_kses_post( $settings['sub_title'] ); ?></div>
			<?php endif; ?>
			<?php if( ! empty( $settings['title'] && $settings['lookbook_type'] == 'list' ) ) : ?>
				<h3 <?php echo $this->get_render_attribute_string( 'list_title' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></h3>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'image_inner' ); ?>>
				<?php echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $settings ); ?>
				<?php
					foreach( $settings['lookbook_products'] as $index => $lookbook ) :
					$button_content  = $this->get_repeater_setting_key( 'button_content', 'lookbook_products', $index );
					$button_item  = $this->get_repeater_setting_key( 'button_item', 'lookbook_products', $index );
					$this->add_render_attribute( $button_content, 'class', [ 'ecomus-lookbook-products__button-content', 'em-absolute', 'elementor-repeater-item-'. esc_attr( $lookbook['_id'] ) ] );
					$this->add_render_attribute( $button_item, 'class', [ 'ecomus-lookbook-products__button-item' ] );

					if( empty( $lookbook['product_id'] ) ) {
						continue;
					}

					$product = wc_get_product( $lookbook['product_id'] );

					if( empty( $product ) ) {
						continue;
					}

					if ( $product->is_type( 'grouped' ) ) {
						continue;
					}

					if ( ! $product->is_type( 'grouped' ) ) {
						$product_ids[] = $lookbook['product_id'];
					}

					$this->add_render_attribute( $button_item, 'data-id', $lookbook['product_id'] );
					$this->add_render_attribute( $button_item, 'data-index', $index );
				?>
					<div <?php echo $this->get_render_attribute_string( $button_content ); ?>>
						<button <?php echo $this->get_render_attribute_string( $button_item ); ?>>
							<span class="screen-reader-text"><?php echo esc_html__( 'Go to product ', 'ecomus-addons' ) . $product->get_name(); ?></span>
							<span class="ecomus-lookbook-products__button-dot"></span>
						</button>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'wrapper_inner' ); ?>>
				<?php if( ! empty( $settings['sub_title'] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'sub_title' ); ?>><?php echo wp_kses_post( $settings['sub_title'] ); ?></div>
				<?php endif; ?>
				<?php if( ! empty( $settings['title'] ) ) : ?>
					<h3 <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></h3>
				<?php endif; ?>
				<?php
					if ( $settings['lookbook_type'] == 'carousel' ) {
						$this->product_type_carousel( $settings, $product_ids );
					} else {
						$this->product_type_list( $settings, $price );
					}
				?>
			</div>
		</div>
	</div>
	<?php
	}

	public function product_type_carousel( $settings, $product_ids ) {
		if ( empty( $product_ids )) {
			return;
		}

		wc_setup_loop(
			array(
				'columns' => 1
			)
		);

		$this->add_render_attribute( 'content_inner', 'class', [ 'ecomus-lookbook-products__content-inner', 'em-relative' ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-lookbook-products__inner', 'swiper' ] );

		echo '<div '. $this->get_render_attribute_string( 'content_inner' ) .'>';
		echo '<div '. $this->get_render_attribute_string( 'inner' ) .'>';

		add_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ], 5 );

		self::get_template_loop( $product_ids );

		remove_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ], 5 );

		echo '</div>';

		echo \Ecomus\Addons\Helper::get_svg('left-mini', 'ui' , [ 'class' => 'swiper-button-prev ecomus-swiper-button swiper-button em-button-outline hidden-xs' ] );
		echo \Ecomus\Addons\Helper::get_svg('right-mini', 'ui' , [ 'class' => 'swiper-button-next ecomus-swiper-button swiper-button em-button-outline hidden-xs' ] );
		echo '<div class="swiper-pagination swiper-pagination-bullet--small hidden-sm hidden-md hidden-lg"></div>';

		echo '</div>';
	}

	public function product_type_list( $settings, $price ) {
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-lookbook-products__inner', 'swiper' ] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
			<ul <?php echo $this->get_render_attribute_string( 'ul' ); ?>>
				<?php foreach( $settings['lookbook_products'] as $index => $lookbook ) :
					$product = wc_get_product( $lookbook['product_id'] );
					if( empty( $product ) ) {
						continue;
					}

					if ( $product->is_type( 'grouped' ) ) {
						continue;
					}
					?>
					<?php $product_price = ! empty( $product->get_sale_price() ) ? $product->get_sale_price() : $product->get_regular_price(); ?>
					<li <?php echo $this->get_render_attribute_string( 'li' ); ?> data-type="<?php echo esc_attr( $product->get_type() ); ?>" data-active="<?php echo $product->is_type( 'variable' ) ? 'false' : 'true'; ?>" data-price="<?php echo $product->is_type( 'variable' ) ? 0 : $product_price; ?>" data-id="<?php echo esc_attr( $lookbook['product_id'] ); ?>">
						<div class="product-inner">
							<div <?php echo $this->get_render_attribute_string( 'thumbnail' ); ?>>
								<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $lookbook['product_id'] ), 'woocommerce_thumbnail' ); ?>

								<a class="woocommerce-loop-product__link" href="<?php echo esc_url( get_permalink( $lookbook['product_id'] ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>" data-image="<?php echo esc_url( $image[0] ); ?>">
									<?php echo $product->get_image(); ?>
								</a>
							</div>
							<div <?php echo $this->get_render_attribute_string( 'summary' ); ?>>
								<h6 <?php echo $this->get_render_attribute_string( 'product_title' ); ?>>
									<a href="<?php echo esc_url( get_permalink( $lookbook['product_id'] ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
								</h6>
								<div <?php echo $this->get_render_attribute_string( 'product_price' ); ?>>
									<span class="price">
										<?php echo wp_kses_post( $product->get_price_html() ); ?>
									</span>
								</div>
								<?php if( $product->is_type( 'variable' ) ) : ?>
									<form class="cart" action="<?php echo esc_url($product->get_permalink()) ?>" method="post" enctype="multipart/form-data">
										<?php $GLOBALS['product'] = ! isset( $GLOBALS['product'] ) ? $product : null;
										\Ecomus\Addons\Elementor\Base\Variation_Select::instance()->render( $product );
										$GLOBALS['product'] = null; ?>
										<input type="hidden" name="product_id" value="<?php echo esc_attr( $product->get_id() ) ?>">
									</form>
								<?php else : ?>
									<?php $data_products[] = [ 'type' => $product->get_type(), 'product_id' => $lookbook['product_id'] ]; ?>
									<?php $price += $product_price; ?>
								<?php endif; ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="swiper-pagination swiper-pagination-bullet--small hidden-lg"></div>

		<button type="submit" name="ecomus_lookbook_products_button" data-products="<?php echo ! empty( $data_products ) ? esc_attr( json_encode( $data_products ) ): ''; ?>" class="ecomus-lookbook-products__button">
			<?php echo esc_html__( 'Add Selected To Cart', 'ecomus-addons' ); ?>
			<span class="divide">-</span>
			<span class="price"><?php echo wc_price( $price ); ?></span>
		</button>
		<?php
	}

	public function product_card_layout() {
		return '1';
	}
}