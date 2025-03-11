<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Ecomus\Addons\Elementor\Builder\Current_Query_Renderer;
use Ecomus\Addons\Elementor\Builder\Products_Renderer;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Archive_Products extends Widget_Base {

	public function get_name() {
		return 'ecomus-archive-products';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Archive s', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'archive', 'product' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-archive-product' ];
	}

	protected function register_controls() {
        $this->start_controls_section(
			'section_content',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'show_default_view',
			[
				'label' => esc_html__( 'Shop Default View', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'list'       => esc_html__( 'List', 'ecomus' ),
					'grid'       => esc_html__( 'Grid', 'ecomus' ),
				],
				'default' => 'grid',
			]
		);

        $this->add_responsive_control(
			'shop_columns',
			[
				'label'     => esc_html__( 'Shop Grid Columns', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'2'  => esc_attr__( '2 Columns', 'ecomus-addons' ),
					'3'  => esc_attr__( '3 Columns', 'ecomus-addons' ),
					'4'  => esc_attr__( '4 Columns', 'ecomus-addons' ),
					'5'  => esc_attr__( '5 Columns', 'ecomus-addons' ),
					'6'  => esc_attr__( '6 Columns', 'ecomus-addons' ),
				],
				'default'   => '4',
			]
		);

		$this->add_control(
			'shop_rows',
			[
				'label'   => esc_html__( 'Shop Grid Rows', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'default' => 4,
			]
		);

        $this->add_control(
			'pagination',
			[
				'label'     => esc_html__( 'Pagination', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'numeric'  => esc_attr__( 'Numeric', 'ecomus' ),
					'infinite' => esc_attr__( 'Infinite Scroll', 'ecomus' ),
					'loadmore' => esc_attr__( 'Load More', 'ecomus' ),
				],
				'default'   => 'numeric',
			]
		);

		$this->add_control(
			'loadmore_text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Load More', 'ecomus-addons' ),
				'label_block' => true,
				'condition' => [
					'pagination' => 'loadmore',
				]
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label' => esc_html__( 'Pagination', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pagination_spacing_top',
			[
				'label' => __( 'Spacing Top', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pagination_gap',
			[
				'label' => __( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination ul' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'selector' => '{{WRAPPER}} .woocommerce-pagination a, {{WRAPPER}} .woocommerce-pagination ul .page-numbers',
			]
		);

		$this->add_control(
			'pagination_icon_size',
			[
				'label' => __( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination ul .page-numbers.prev' => '--em-button-icon-size: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .woocommerce-pagination ul .page-numbers.next' => '--em-button-icon-size: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination a, {{WRAPPER}} .woocommerce-pagination ul .page-numbers' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination a, {{WRAPPER}} .woocommerce-pagination ul .page-numbers' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination a, {{WRAPPER}} .woocommerce-pagination ul .page-numbers' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-pagination a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .woocommerce-pagination ul .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-cart-tracking__badges' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-pagination ul .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pagination_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-pagination a' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .woocommerce-pagination ul .page-numbers' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-cart-tracking__badges' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-pagination ul .page-numbers' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pagination_hover_active_heading',
			[
				'label'     => esc_html__( 'Hover & Active', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination a' => '--em-button-color-hover: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-pagination ul .page-numbers.current' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination a' => '--em-button-bg-color-hover: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-pagination ul .page-numbers.current' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination a' => '--em-button-border-color-hover: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-pagination ul .page-numbers.current' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$settings['paginate'] = true;
		$shop_columns_tablet = isset( $settings['shop_columns_tablet'] ) ? $settings['shop_columns_tablet'] : 3;
		$shop_columns_mobile = isset( $settings['shop_columns_mobile'] ) ? $settings['shop_columns_mobile'] : 2;

		add_filter( 'loop_shop_columns', [ $this, 'shop_columns' ] );
		add_filter( 'loop_shop_per_page', [ $this, 'shop_per_page' ] );
		add_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ] );
		add_filter( 'ecomus_mobile_product_columns', [ $this, 'mobile_product_columns' ] );
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$shortcode = new Products_Renderer( $settings, 'products' );
		} else {
			add_action( 'woocommerce_after_shop_loop', [ $this, 'pagination' ] );
			$shortcode = new Current_Query_Renderer( $settings, 'current_query' );
		}

		$content = $shortcode->get_content();

		echo '<div class="ecomus-archive-products ecomus-shop-content">';
		if ( $content ) {
			$content = str_replace( '<ul class="products', '<ul class="products products-elementor tablet-col-'. esc_attr( $shop_columns_tablet ), $content );

			echo $content;
		} else {
			echo '<div class="elementor-nothing-found ecomus-products-nothing-found woocommerce-info">' . esc_html__('No products were found matching your selection.', 'ecomus-addons') . '</div>';
			echo '<ul class="products products-elementor columns-'. esc_attr( $this->shop_columns() ) .' tablet-col-'. esc_attr( $shop_columns_tablet ) .' mobile-col-' . esc_attr( $shop_columns_mobile ). '"></ul>';
		}

		echo '</div>';

		remove_filter( 'loop_shop_columns', [ $this, 'shop_columns' ] );
		remove_filter( 'loop_shop_per_page', [ $this, 'shop_per_page' ] );
		remove_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ] );
		remove_filter( 'ecomus_mobile_product_columns', [ $this, 'mobile_product_columns' ] );
		remove_action( 'woocommerce_after_shop_loop', [ $this, 'pagination' ] );
	}

	public function shop_columns() {
		$settings = $this->get_settings_for_display();
		$shop_columns = $settings['show_default_view'] == 'list' ? 1 : $settings['shop_columns'];

		if ( ! \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$shop_columns = isset( $_COOKIE['catalog_view'] ) ? intval(preg_replace("/[^0-9]/", '', $_COOKIE['catalog_view'])) : $shop_columns;
			$shop_columns = $shop_columns == 0 ? 1 : $shop_columns;
		}

		$shop_columns = isset( $_GET['column'] ) ? $_GET['column'] : $shop_columns;

		return $shop_columns;
	}

	public function shop_per_page() {
		$settings = $this->get_settings_for_display();

		return ( intval( $settings['shop_columns'] ) * intval( $settings['shop_rows'] ) );
	}

	public function mobile_product_columns() {
		$settings = $this->get_settings_for_display();
		$shop_columns_mobile = isset( $settings['shop_columns_mobile'] ) ? $settings['shop_columns_mobile'] : 2;
		return $shop_columns_mobile;
	}

	public function product_card_layout( $layout ) {
		$settings = $this->get_settings_for_display();
		$new_layout = $settings['show_default_view'] == 'list' ? 'list' : $layout;

		if ( ! \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			if( isset( $_COOKIE['catalog_view'] ) ) {
				if( intval(preg_replace("/[^0-9]/", '', $_COOKIE['catalog_view'])) == 0 ) {
					$new_layout = 'list';
				} else {
					$new_layout = $layout;
				}
			}
		}

		if( isset( $_GET['column'] ) ) {
			if( $_GET['column'] == 1 ) {
				$new_layout = 'list';
			} else {
				$new_layout = $layout;
			}
		}

		return apply_filters( 'ecomus_product_card_layout_builder', $new_layout );
	}

	/**
	 * Products pagination.
	 */
	public function pagination() {
		$settings = $this->get_settings_for_display();
		$nav_type = apply_filters( 'ecomus_product_catalog_pagination_builder', $settings['pagination'] );

		if ( 'numeric' == $nav_type ) {
			woocommerce_pagination();
			return;
		}

		global $wp_query;

		$max_page = $wp_query->max_num_pages;

		if( $max_page <= 1 ) {
			return;
		}


		$classes = array(
			'woocommerce-pagination',
			'woocommerce-pagination--catalog',
			'next-posts-pagination',
			'woocommerce-pagination--ajax',
			'woocommerce-pagination--' . esc_attr( $nav_type ),
			'text-center'
		);

		add_filter( 'next_posts_link_attributes', array( $this, 'ecomus_next_posts_link_attributes' ), 10, 1 );

		echo '<nav class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
				?>
					<a href="#" class="woocommerce-pagination-button em-button em-button-outline <?php echo $nav_type == 'infinite' ? 'loading' : ''; ?>">
						<span><?php echo ! empty( $settings['loadmore_text'] ) ? $settings['loadmore_text'] : esc_html__( 'Load more', 'ecomus' ); ?></span>
					</a>
				<?php
			} else {
				$text = ! empty( $settings['loadmore_text'] ) ? $settings['loadmore_text'] : esc_html__( 'Load more', 'ecomus' );
				next_posts_link( '<span>' . $text . '</span>', wc_get_loop_prop( 'total_pages' ) );
			}
		echo '</nav>';
	}

	/**
	 * Next posts link attributes
	 *
	 * @return string $attr
	 */
	public function ecomus_next_posts_link_attributes( $attr ) {
		$settings = $this->get_settings_for_display();
		$nav_type = apply_filters( 'ecomus_product_catalog_pagination_builder', $settings['pagination'] );
		if( $nav_type !== 'numeric' ) {
			$attr = 'class="woocommerce-pagination-button em-button em-button-outline"';
		}

		return $attr;
	}
}