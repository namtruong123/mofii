<?php
namespace Ecomus\Addons\Elementor\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Ecomus\Addons\Elementor\Utils;

abstract class Products_Widget_Base extends Carousel_Widget_Base {
	use \Ecomus\Addons\Woocommerce\Products_Base;
	/**
	 * Register controls for products query
	 *
	 * @param array $controls
	 */
	protected function register_products_controls( $controls = [], $frontend_available = false ) {
		$supported_controls = [
			'product_card_layout'   => \Ecomus\Addons\Helper::product_card_layout_default(),
			'limit'    				=> 10,
			'type'     				=> 'recent_products',
			'ids'    				=> '',
			'category' 				=> '',
			'tag'      				=> '',
			'brand'    				=> '',
			'orderby'  				=> '',
			'order'    				=> 'DESC',
			'product_outofstock'    => 'no',
			'product_outofstock_last'=> 'no',
			'show_addtocart_button' => '',
		];

		$controls = 'all' == $controls ? $supported_controls : $controls;

		foreach ( $controls as $option => $default ) {
			switch ( $option ) {
				case 'product_card_layout':
					$this->add_control(
						'product_card_layout',
						[
							'label'     => __( 'Product card layout', 'ecomus-addons' ),
							'type' => Controls_Manager::SELECT,
							'options' => \Ecomus\Addons\Helper::product_card_layout_select(),
							'default' => $default,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'limit':
					$this->add_control(
						'limit',
						[
							'label'     => __( 'Number of Products', 'ecomus-addons' ),
							'type'      => Controls_Manager::NUMBER,
							'min'       => -1,
							'max'       => 100,
							'step'      => 1,
							'default'   => $default,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'type':
					$this->add_control(
						'type',
						[
							'label' => __( 'Type', 'ecomus-addons' ),
							'type' => Controls_Manager::SELECT,
							'options' => $this->get_options_product_type(),
							'default' => $default,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'product_outofstock':
					$this->add_control(
						'hide_product_outofstock',
						[
							'label'        => esc_html__( 'Hide Out Of Stock Products', 'ecomus-addons' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => esc_html__( 'Yes', 'ecomus-addons' ),
							'label_off'    => esc_html__( 'No', 'ecomus-addons' ),
							'return_value' => 'yes',
							'default'      => $default,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'product_outofstock_last':
					$this->add_control(
						'product_outofstock_last',
						[
							'label'        => esc_html__( 'Show out of stock products at the end', 'ecomus-addons' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => esc_html__( 'Yes', 'ecomus-addons' ),
							'label_off'    => esc_html__( 'No', 'ecomus-addons' ),
							'return_value' => 'yes',
							'default'      => $default,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'product_outofstock_last':
					$this->add_control(
						'product_outofstock_last',
						[
							'label'        => esc_html__( 'Show out of stock products at the end', 'ecomus-addons' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => esc_html__( 'Show', 'ecomus-addons' ),
							'label_off'    => esc_html__( 'Hide', 'ecomus-addons' ),
							'return_value' => 'yes',
							'default'      => $default,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'category':
					$this->add_control(
						'category',
						[
							'label' => __( 'Product Category', 'ecomus-addons' ),
							'type' => 'ecomus-autocomplete',
							'default' => $default,
							'multiple'    => true,
							'source'      => 'product_cat',
							'sortable'    => true,
							'label_block' => true,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'tag':
					$this->add_control(
						'tag',
						[
							'label' => __( 'Product Tag', 'ecomus-addons' ),
							'type' => Controls_Manager::SELECT2,
							'type' => 'ecomus-autocomplete',
							'default' => $default,
							'multiple'    => true,
							'source'      => 'product_tag',
							'sortable'    => true,
							'label_block' => true,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'brand':
					$this->add_control(
						'brand',
						[
							'label' => __( 'Product Brand', 'ecomus-addons' ),
							'type' => Controls_Manager::SELECT2,
							'type' => 'ecomus-autocomplete',
							'default' => $default,
							'multiple'    => true,
							'source'      => 'product_brand',
							'sortable'    => true,
							'label_block' => true,
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'ids':
					$this->add_control(
						'ids',
						[
							'label' => __( 'Products', 'ecomus-addons' ),
							'type' => 'ecomus-autocomplete',
							'default' => $default,
							'multiple'    => true,
							'source'      => 'product',
							'sortable'    => true,
							'label_block' => true,
							'condition' => [
								'type' => ['custom_products']
							],
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'orderby':
					$this->add_control(
						'orderby',
						[
							'label' => __( 'Order By', 'ecomus-addons' ),
							'type' => Controls_Manager::SELECT,
							'options' => $this->get_options_product_orderby(),
							'default' => $default,
							'condition' => [
								'type' => ['featured_products', 'sale_products', 'custom_products']
							],
							'frontend_available' => $frontend_available
						]
					);
					break;

				case 'order':
					$this->add_control(
						'order',
						[
							'label' => __( 'Order', 'ecomus-addons' ),
							'type' => Controls_Manager::SELECT,
							'options' => [
								'ASC'  => __( 'Ascending', 'ecomus-addons' ),
								'DESC' => __( 'Descending', 'ecomus-addons' ),
							],
							'default' => $default,
							'condition' => [
								'type' => ['featured_products', 'sale_products', 'custom_products'],
								'orderby!' => ['rand'],
							],
							'frontend_available' => $frontend_available
						]
					);
					break;
				case 'show_addtocart_button':
					$this->add_control(
						'show_addtocart_button',
						[
							'label'     => esc_html__( 'Show Add To Cart Button', 'ecomus-addons' ),
							'type'      => Controls_Manager::SWITCHER,
							'label_off' => __( 'Yes', 'ecomus-addons' ),
							'label_on'  => __( 'No', 'ecomus-addons' ),
							'return_value' => 'yes',
							'default'      => '',
							'selectors' => [
								'{{WRAPPER}} ul.products li.product .em-button-add-to-cart-mobile' => 'display: inline-flex;',
							],
							'prefix_class' => 'ecomus-addtocart-button-show--',
						]
					);
					break;
			}
		}
	}
	/**
	 * Render products loop content for shortcode.
	 *
	 * @param array $settings Shortcode attributes
	 */
	protected function render_products( $settings = null ) {
		$settings = ! empty( $settings ) ? $settings : $this->get_settings_for_display();
		return self::get_product_layout() . $this->get_products_loop_content( $settings ) . self::remove_product_layout();
	}

	/**
	 * Render products loop content for shortcode.
	 *
	 * @param array $settings Shortcode attributes
	 */
	protected function render_products_settings($settings) {
		return $this->get_products_loop_content( $settings );
	}

	protected function get_product_layout() {
		add_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ], 5 );
	}

	protected function remove_product_layout() {
		remove_filter( 'ecomus_product_card_layout', [ $this, 'product_card_layout' ], 5 );
	}

	public function product_card_layout() {
		$settings = $this->get_settings_for_display();
		return ! empty( $settings['product_card_layout'] ) ? esc_attr( $settings['product_card_layout'] ) : 1;
	}

	protected function register_aspect_ratio_controls( $conditions = [], $default = [] ) {
		$default = wp_parse_args( $default, [ 'aspect_ratio_type' => '' ] );

        $this->add_control(
			'aspect_ratio_type',
			[
				'label'   => esc_html__( 'Aspect Ratio', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''       => esc_html__( 'Default', 'ecomus-addons' ),
					'square' => esc_html__( 'Square', 'ecomus-addons' ),
					'custom' => esc_html__( 'Custom', 'ecomus-addons' ),
				],
				'default' => $default['aspect_ratio_type'],
				'condition' => $conditions,
			]
		);

		$conditions = wp_parse_args( $conditions, [ 'aspect_ratio_type' => 'custom' ] );
        $this->add_control(
			'aspect_ratio',
			[
				'label'       => esc_html__( 'Aspect ratio (Eg: 3:4)', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Images will be cropped to aspect ratio', 'ecomus-addons' ),
				'default'     => '',
				'label_block' => false,
                'condition' => $conditions,
			]
		);
	}

	/**
	 * Render aspect ratio style
	 *
	 * @return void
	 */
    protected function render_aspect_ratio_style( $style = '', $aspect_ratio = 1 ) {
        $settings = $this->get_settings_for_display();

		if( empty( $settings['aspect_ratio_type'] ) ) {
			return;
		}

        if( $settings['aspect_ratio_type'] == 'square' ) {
            $aspect_ratio = 1;
        }

        if( $settings['aspect_ratio_type'] == 'custom' && ! empty( $settings['aspect_ratio'] ) ) {
            if( ! is_numeric( $settings['aspect_ratio'] ) ) {
                $cropping_split = explode( ':', $settings['aspect_ratio'] );
                $width          = max( 1, (float) current( $cropping_split ) );
                $height         = max( 1, (float) end( $cropping_split ) );
                $aspect_ratio   = floatval( $width / $height );
            } else {
                $aspect_ratio = $settings['aspect_ratio'];
            }
        }

		$style = '--product-image-ratio-percent: '. round( 100 / $aspect_ratio ) . '%;';

        return $style;
    }
}