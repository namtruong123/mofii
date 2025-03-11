<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Products_Widget_Base;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Recently_Viewed extends Products_Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-recently-viewed';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Recently Viewed', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
		return ['ecomus-addons'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'product', 'recently', 'viewed' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
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
			'section_recently_viewed_products_content',
			[
				'label' => esc_html__( 'Recently Viewed Products', 'ecomus-addons' ),
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
			'limit',
			[
				'label' => esc_html__( 'Limit', 'ecomus-addons' ),
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
			'ajax_enable',
			[
				'label'       => esc_html__( 'Load With Ajax', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'frontend_available' => true
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
					'{{WRAPPER}} .recently-viewed-products__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .recently-viewed-products__title',
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
					'{{WRAPPER}} .recently-viewed-products__title' => 'text-align: {{VALUE}}',
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
					'{{WRAPPER}} .recently-viewed-products__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_style',
			[
				'label'     => __( 'Carousel Style', 'ecomus-addons' ),
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
		$settings = $this->get_settings_for_display();

		$limit = 5;
		$columns = 4;

		if ( ! empty( $settings['limit'] ) ) {
			$limit = $settings['limit'];
		}

		if ( ! empty( $settings['slides_to_show'] ) ) {
			$columns = $settings['slides_to_show'];
		}

		$heading = ! empty( $settings['heading'] ) ? sprintf( '<h2 class="recently-viewed-products__title">%s</h2>', $settings['heading'] ) : '';

		$this->add_render_attribute( 'wrapper', 'class', [
			'recently-viewed-product__carousel',
			'ecomus-products-carousel--elementor',
			'ecomus-carousel--elementor',
			'woocommerce'
		] );

		if( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			?>
			<?php echo $heading; ?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ) ?>>
				<section class="recently-viewed-products products <?php echo $settings['ajax_enable'] == 'yes' ? 'has-ajax' : ''; ?>">
					<?php echo $this->render_products_settings( array( 'type' => 'recent_products', 'limit' => $limit, 'columns' => $columns ) ); ?>
				</section>
				<?php echo $this->render_arrows(); ?>
				<?php echo $this->render_pagination(); ?>
			</div>
			<?php
		} else {
			if( ! self::get_product_recently_viewed_ids() ) {
				return;
			}

			?>
			<?php echo $heading; ?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ) ?>>
				<section class="recently-viewed-products products <?php echo $settings['ajax_enable'] == 'yes' ? 'has-ajax' : ''; ?>" data-settings="<?php esc_attr_e( json_encode( [ 'limit' => $limit, 'columns' => $columns ] ) ) ?>">
					<?php
					if( $settings['ajax_enable'] !== 'yes' ) {
						self::get_recently_viewed_products();
					}?>
				</section>
				<?php echo $this->render_arrows(); ?>
				<?php echo $this->render_pagination(); ?>
			</div>
			<?php
		}
	}

	/**
	 * Get products recently viewed
	 *
	 * @return void
	 *
	 */
	public function get_recently_viewed_products() {
		$products_ids = self::get_product_recently_viewed_ids();
		$settings = $this->get_settings_for_display();

		$limit = 5;
		$columns = 4;

		if ( ! empty( $settings['limit'] ) ) {
			$limit = $settings['limit'];
		}

		if ( ! empty( $settings['slides_to_show'] ) ) {
			$columns = $settings['slides_to_show'];
		}

		if ( empty( $products_ids ) ) {
			?>
				<div class="no-products">
					<p><?php echo esc_html__( 'No products in recent viewing history.', 'ecomus' ) ?></p>
				</div>

			<?php
		} else {
			update_meta_cache( 'post', $products_ids );
			update_object_term_cache( $products_ids, 'product' );

			$original_post = $GLOBALS['post'];

			wc_setup_loop(
				array(
					'columns' => $columns
				)
			);

			woocommerce_product_loop_start();

			$index = 0;

			foreach ( $products_ids as $product_id ) {
				if ( $index > intval( $limit ) ) {
					break;
				}

				$product_id = apply_filters('wpml_object_id', $product_id, 'product', true);
				if (empty($product_id)) {
					continue;
				}

				$index ++;

				$product = get_post( $product_id );
				if ( empty( $product ) ) {
					continue;
				}

				$GLOBALS['post'] = $product; // WPCS: override ok.
				setup_postdata( $GLOBALS['post'] );
				wc_get_template_part( 'content', 'product' );
			}

			$GLOBALS['post'] = $original_post; // WPCS: override ok.

			woocommerce_product_loop_end();

			wp_reset_postdata();
			wc_reset_loop();
		}
	}

	/**
	 * Get recently viewed ids
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_product_recently_viewed_ids() {
		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();

		return array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
	}
}
