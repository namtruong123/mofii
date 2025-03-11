<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Images extends Widget_Base {

	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-images';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Images', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-images';
	}

	public function get_categories() {
		return [ 'ecomus-addons-product' ];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'image', 'product', 'gallery', 'lightbox' ];
	}

	public function get_script_depends() {
		return [
			'imagesLoaded',
			'ecomus-product-elementor-widgets'
		];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_product_images',
			[ 'label' => __( 'Product Images', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'product_image_zoom',
			[
				'label'      => esc_html__( 'Image Zoom', 'ecomus-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'none'  	=> esc_html__( 'None', 'ecomus-addons' ),
					'bounding'  => esc_html__( 'Bounding Box', 'ecomus-addons' ),
					'inner'     => esc_html__( 'Inner Zoom', 'ecomus-addons' ),
					'magnifier' => esc_html__( 'Zoom Magnifier', 'ecomus-addons' ),
				],
				'default'    => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'thumbnails_layout',
			[
				'label'      => esc_html__( 'Thumbnails Layout', 'ecomus-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''                  => esc_html__( 'Left thumbnails', 'ecomus-addons' ),
					'grid-1'            => esc_html__( 'Grid 1', 'ecomus-addons' ),
					'grid-2'            => esc_html__( 'Grid 2', 'ecomus-addons' ),
					'stacked'           => esc_html__( 'Stacked', 'ecomus-addons' ),
					'right-thumbnails'  => esc_html__( 'Right thumbnails', 'ecomus-addons' ),
					'bottom-thumbnails' => esc_html__( 'Bottom thumbnails', 'ecomus-addons' ),
				],
				'default'    => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'product_thumbnails_animation',
			[
				'label'       => esc_html__( 'Thumbnails Animation', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'product_image_lightbox',
			[
				'label'       => esc_html__( 'Product Image LightBox', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'product_image_lightbox_icon',
			[
				'label'            => __( 'Custom LightBox Icon', 'ecomus-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'condition'   => [
					'product_image_lightbox' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_carousel',
			[ 'label' => __( 'Carousel', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'arrows_prev_icon',
			[
				'label'            => __( 'Custom Previous Icon', 'ecomus-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
			]
		);

		$this->add_control(
			'arrows_next_icon',
			[
				'label'            => __( 'Custom Next Icon', 'ecomus-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
			]
		);

		$this->end_controls_section();

		$this->section_style();
	}

	protected function section_style() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Styles', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'gallery_heading',
			[
				'label' => esc_html__( 'Gallery', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'gallery_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-product-gallery .woocommerce-product-gallery__image' => '--em-image-rounded-product-gallery: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-product-gallery .woocommerce-product-gallery__image' => '--em-image-rounded-product-gallery: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thumbnails_heading',
			[
				'label' => esc_html__( 'Thumbnails', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'thumbnails_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-gallery-thumbnails' => '--em-image-rounded-product-thumbnail: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-gallery-thumbnails' => '--em-image-rounded-product-thumbnail: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thumbnails_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-gallery-thumbnails .swiper-slide-thumb-active::after' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lightbox_heading',
			[
				'label' => esc_html__( 'LightBox Button', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'lightbox_width',
			[
				'label'     => esc_html__( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'lightbox_height',
			[
				'label'     => esc_html__( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'lightbox_icon',
			[
				'label'     => esc_html__( 'Icon Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'lightbox_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lightbox_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lightbox_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lightbox_hover_background_color',
			[
				'label' => esc_html__( 'Hover Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'lightbox_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-product-gallery .ecomus-button--product-lightbox' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_style',
			[
				'label'     => __( 'Carousel', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_type',
			[
				'label'   => esc_html__( 'Arrows Type', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'solid'        => esc_html__( 'Solid', 'ecomus-addons' ),
					'outline'      => esc_html__( 'Outline', 'ecomus-addons' ),
					'outline-dark' => esc_html__( 'Outline Dark', 'ecomus-addons' ),
				],
				'default' => 'solid',
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
					'{{WRAPPER}} .woocommerce-product-gallery .elementor-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-product-gallery .elementor-swiper-button-prev' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
					'{{WRAPPER}} .woocommerce-product-gallery .elementor-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-product-gallery .elementor-swiper-button-next' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
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
					'{{WRAPPER}} .swiper-button' => '--em-arrow-top: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[
				'label'     => __( 'Icon Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_width',
			[
				'label'     => __( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_height',
			[
				'label'     => __( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .swiper-button' => '--em-arrow-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'arrows_tabs'
		);
		$this->start_controls_tab(
			'arrows_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ecomus-addons' ),
			]
		);
		$this->add_control(
			'arrows_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrows_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'arrows_hover_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => '--em-arrow-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		global $product;

		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		$classes = [
			'product-gallery-summary',
			'ecomus-product-gallery'
		];

		$this->add_render_attribute( 'thumbnails', 'class', $classes );

		if ( ! empty( $settings['product_image_lightbox_icon']['value'] ) ) {
			$this->add_render_attribute( 'thumbnails', 'data-lightbox_icon', esc_attr( $this->get_icon_html( $settings['product_image_lightbox_icon'], [ 'aria-hidden' => 'true' ] ) ) );
		}

		if ( ! empty( $settings['arrows_prev_icon']['value'] ) ) {
			$this->add_render_attribute( 'thumbnails', 'data-prev_icon', esc_attr( $this->get_icon_html( $settings['arrows_prev_icon'], [ 'aria-hidden' => 'true' ] ) ) );
		}

		if ( ! empty( $settings['arrows_next_icon']['value'] ) ) {
			$this->add_render_attribute( 'thumbnails', 'data-next_icon', esc_attr( $this->get_icon_html( $settings['arrows_next_icon'], [ 'aria-hidden' => 'true' ] ) ) );
		}

		$this->add_render_attribute( 'thumbnails', 'data-arrows_type', esc_attr( $settings['arrows_type'] ) );

		add_filter( 'woocommerce_single_product_image_gallery_classes', array( $this, 'single_product_image_gallery_classes' ), 20, 1 );
		add_action( 'woocommerce_product_thumbnails', array( $this, 'product_gallery_thumbnails' ), 20 );
		?>

		<div <?php echo $this->get_render_attribute_string( 'thumbnails' ); ?>>
			<?php wc_get_template( 'single-product/product-image.php' ); ?>
			<?php
				if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {

					?>
					<script>
						jQuery( '.woocommerce-product-gallery' ).each( function() {
							jQuery( this ).css( 'opacity', '1' );
						} );
					</script>
					<?php
				} else {
					?>
					<script>
						jQuery( '.elementor-widget-ecomus-product-images .woocommerce-product-gallery__wrapper' ).css( 'opacity', '0' );
					</script>
					<?php
				}
			?>
		</div>
		<?php
	}

	/**
	 * Single product image gallery classes
	 *
	 * @param array $args
	 * @return array
	 */
	public function single_product_image_gallery_classes( $classes ) {
		$settings = $this->get_settings_for_display();
		global $product;

		if( empty( $settings['thumbnails_layout'] ) ) {
            $classes[] = 'woocommerce-product-gallery--vertical';
        } elseif ( $settings['thumbnails_layout'] == 'right-thumbnails' ) {
			$classes[] = 'woocommerce-product-gallery--vertical';
			$classes[] = 'woocommerce-product-gallery--vertical-right';
		} elseif( in_array( $settings['thumbnails_layout'], array( 'grid-1', 'grid-2', 'stacked' ) ) ) {
            $classes[] = 'woocommerce-product-gallery--grid';
            $classes[] = 'woocommerce-product-gallery--' . esc_attr( $settings['thumbnails_layout'] );
        } else {
			$classes[] = 'woocommerce-product-gallery--horizontal';
		}

		$key = array_search( 'images', $classes );
		if ( $key !== false ) {
			unset( $classes[ $key ] );
		}

		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids && $product->get_image_id() ) {
			$classes[] = 'woocommerce-product-gallery--has-thumbnails';
		}

		if( $settings['product_image_zoom'] !== 'none' ) {
			$classes[] = 'woocommerce-product-gallery--has-zoom';
		}

		return $classes;
	}

	/**
	 * Product gallery thumbnails
	 *
	 * @return void
	 */
	public function product_gallery_thumbnails() {
		$settings = $this->get_settings_for_display();
		global $product;

		$attachment_ids = apply_filters( 'ecomus_single_product_gallery_image_ids', $product->get_gallery_image_ids() );

		if ( $attachment_ids && $product->get_image_id() ) {
			add_filter( 'woocommerce_single_product_flexslider_enabled', '__return_false' );

			$thumbnails_class = $settings['product_thumbnails_animation'] == 'yes' ? ' em-thumbnails-animation': '';
			echo '<div class="ecomus-product-gallery-thumbnails'. $thumbnails_class .'">';
				echo apply_filters( 'ecomus_product_get_gallery_image', wc_get_gallery_image_html( $product->get_image_id() ), 1 );
				$index = 2;
				foreach ( $attachment_ids as $attachment_id ) {
					echo apply_filters( 'ecomus_product_get_gallery_thumbnail', wc_get_gallery_image_html( $attachment_id ), $index );
					$index++;
				}

			echo '</div>';
			$rm_filter = 'remove_filter';
			$rm_filter( 'woocommerce_single_product_flexslider_enabled', '__return_false' );
		}
	}

	/**
	 * @param array $icon
	 * @param array $attributes
	 * @param $tag
	 * @return bool|mixed|string
	 */
	function get_icon_html( array $icon, array $attributes, $tag = 'i' ) {
		/**
		 * When the library value is svg it means that it's a SVG media attachment uploaded by the user.
		 * Otherwise, it's the name of the font family that the icon belongs to.
		 */
		if ( 'svg' === $icon['library'] ) {
			$output = Icons_Manager::render_uploaded_svg_icon( $icon['value'] );
		} else {
			$output = Icons_Manager::render_font_icon( $icon, $attributes, $tag );
		}
		return $output;
	}

}
