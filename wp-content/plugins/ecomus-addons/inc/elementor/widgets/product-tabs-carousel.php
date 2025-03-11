<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Tabs Carousel widget
 */
class Product_Tabs_Carousel extends Carousel_Widget_Base {
    use \Ecomus\Addons\Woocommerce\Products_Base;
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-product-tabs-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Product Tabs Carousel', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-tabs';
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
	 * Scripts
	 *
	 * @return void
	 */
	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
		];
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
			[ 'label' => esc_html__( 'Product Tabs', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Total Products', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Heading', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is heading', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
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
			]
		);

		$repeater->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options' => $this->get_options_product_orderby(),
				'condition' => [
					'products' => ['featured_products', 'sale_products', 'custom_products']
				],
				'default'   => 'date',
			]
		);

		$repeater->add_control(
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
					'products' => ['featured_products', 'sale_products', 'custom_products'],
					'orderby!' => ['rand'],
				],
				'default'   => '',
			]
		);

		$repeater->add_control(
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
			]
		);

		$repeater->add_control(
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
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

		$repeater->add_control(
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
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

		$repeater->add_control(
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
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

        $this->add_control(
			'tabs',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'heading' => esc_html__( 'Best seller', 'ecomus-addons' ),
						'products'  => 'best_selling_products'
					],
					[
						'heading' => esc_html__( 'New arrivals', 'ecomus-addons' ),
						'products'  => 'recent_products'
					],
					[
						'heading' => esc_html__( 'On Sale', 'ecomus-addons' ),
						'products'  => 'sale_products'
					]
				],
				'title_field'   => '{{{ heading }}}',
				'prevent_empty' => false,
			]
		);

		$this->end_controls_section();

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

	// Tab Style
	protected function section_style() {
		$this->start_controls_section(
			'section_style_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'heading_horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .ecomus-product-tabs-carousel__heading' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'heading_gap',
			[
				'label'     => __( 'Gap', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 500,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-carousel__heading' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_heading_style' );

		$this->start_controls_tab(
			'tab_heading_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-tabs-carousel__heading span',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-carousel__heading span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_hover_color',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-carousel__heading span:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_heading_active',
			[
				'label' => __( 'Active', 'ecomus-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_active_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-tabs-carousel__heading span.active',
			]
		);

		$this->add_control(
			'heading_active_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-carousel__heading span.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-carousel__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_products',
			[
				'label' => esc_html__( 'Products', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border',
			[
				'label'        => __( 'Border', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => '',
				'separator'    => 'before',
				'prefix_class' => 'ecomus-show-border-',
			]
		);

		$this->add_control(
			'product_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.ecomus-show-border-yes ul.products li.product' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}}.ecomus-show-border-yes ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}.ecomus-show-border-yes ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
			'section_style',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

        $query_args = [];

        $this->add_render_attribute( 'wrapper', 'class', 'ecomus-product-tabs-carousel', );
        $this->add_render_attribute( 'heading', 'class', [ 'ecomus-product-tabs-carousel__heading', 'em-flex', 'em-flex-center' ] );

        $this->add_render_attribute( 'items', 'class', [ 'ecomus-product-tabs-carousel__items', 'em-relative' ] );
        $this->add_render_attribute( 'item', 'class', [ 'ecomus-product-tabs-carousel__item', 'ecomus-carousel--elementor', 'active' ] );
        $this->add_render_attribute( 'item', 'data-panel', '1' );
		$this->add_render_attribute( 'swiper', 'class', [ 'swiper' ] );

        $this->add_render_attribute( 'loading', 'class', [ 'ecomus-product-tabs-carousel__loading', 'em-absolute', 'em-loading-spin' ] );

        echo '<div '. $this->get_render_attribute_string( 'wrapper' ) . '>';
            echo '<div '. $this->get_render_attribute_string( 'heading' ) . '>';
                    $a = 1;
                    foreach( $settings['tabs'] as $key => $tab ):
                        if( ! empty( $tab['heading'] ) ) :
                            $attr = [
                                'type'           => $tab['products'],
                                'orderby'        => $tab['orderby'],
                                'order'          => $tab['order'],
                                'category'       => $tab['product_cat'],
                                'tag'            => $tab['product_tag'],
                                'product_brands' => $tab['product_brand'],
                                'ids'            => $tab['ids'],
                                'per_page'       => $settings['limit'],
                                'columns'        => $settings['slides_to_show'],
                                'swiper'         => true,
                            ];

                            $tab_key = $this->get_repeater_setting_key( 'tab', 'products_tab', $key );

					        $this->add_render_attribute( $tab_key, [ 'data-target' => $a, 'data-atts' => json_encode( $attr ) ] );

                            if ( 1 === $a ) {
                                $this->add_render_attribute( $tab_key, 'class', 'active' );
                                $query_args = $attr;
                            }

                            ?>
                            <span <?php echo $this->get_render_attribute_string( $tab_key ); ?>><?php echo wp_kses_post( $tab['heading'] ); ?></span>
                            <?php
                        endif;
                    $a++;
                    endforeach;
            echo '</div>';
        ?>
            <div <?php echo $this->get_render_attribute_string( 'items' ) ?>>
                <div <?php echo $this->get_render_attribute_string( 'loading' ) ?>></div>
                <div <?php echo $this->get_render_attribute_string( 'item' ) ?>>
					<div <?php echo $this->get_render_attribute_string( 'swiper' ) ?>>
						<?php echo $this->render_products( $query_args ); ?>
					</div>
                </div>
                <div class="navigation-original hidden">
                    <?php echo $this->render_arrows( 'em-button-light arrow-primary' ); ?>
				    <?php echo $this->render_pagination(); ?>
                </div>
            </div>
        <?php
        echo '</div>';
	}
}