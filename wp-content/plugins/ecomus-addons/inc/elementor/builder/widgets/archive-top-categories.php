<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Archive_Top_Categories extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;

	public function get_name() {
		return 'ecomus-archive-top-categories';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Archive Top Categories', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'archive', 'categories', 'top' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-archive-product' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-product-elementor-widgets'
		];
	}

	protected function register_controls() {
        $this->start_controls_section(
			'section_content',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'limit',
			[
				'label'     	  => esc_html__( 'Limit', 'ecomus' ),
				'description'     => esc_html__( 'Enter 0 to get all categories. Enter a number to get limit number of top categories.', 'ecomus' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__( 'Order By', 'ecomus' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'order' => esc_html__( 'Category Order', 'ecomus' ),
					'name'  => esc_html__( 'Category Name', 'ecomus' ),
					'id'    => esc_html__( 'Category ID', 'ecomus' ),
					'count' => esc_html__( 'Product Counts', 'ecomus' ),
				],
				'default'     => 'order',
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

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => '' ] );

		$this->add_control(
			'button_heading',
			[
				'label'     => esc_html__( 'Button', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$controls = [
			'slides_to_show'   => 5,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'both',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-top-categories__item' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-top-categories__item' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_style_heading',
			[
				'label'     => esc_html__( 'Button', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'   => __( 'Style', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					''             => __( 'Solid Dark', 'ecomus-addons' ),
					'light'        => __( 'Solid Light', 'ecomus-addons' ),
					'outline-dark' => __( 'Outline Dark', 'ecomus-addons' ),
					'outline'      => __( 'Outline Light', 'ecomus-addons' ),
					'subtle'       => __( 'Underline', 'ecomus-addons' ),
					'text'         => __( 'Text', 'ecomus-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-top-categories__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-top-categories__title' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-top-categories__title' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-top-categories__title' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .catalog-top-categories__title',
			]
		);

		$this->add_responsive_control(
			'button_border_width',
			[
				'label' => esc_html__( 'Border Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => [ 'outline-dark', 'outline' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_icon_style_heading',
			[
				'label'     => esc_html__( 'Button Icon', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}; --em-button-icon-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_spacing',
			[
				'label'     => __( 'Icon Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .catalog-top-categories__title:hover .ecomus-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-top-categories__title:hover .ecomus-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel Style', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$args = array(
				'taxonomy' => 'product_cat',
				'parent'   => 0,
			);
		} else {
			if( is_search() ) {
				return;
			}

			$queried        = get_queried_object();
			if( empty( $queried ) ) {
				return;
			}
			$current_term   = ! empty ( $queried->term_id ) ? $queried->term_id : '';
			$ouput          = array();

			if( $this->is_shop() ) {
				$args = array(
					'taxonomy' => 'product_cat',
					'parent'   => 0,
				);
			} else {
				$termchildren  = get_term_children( $queried->term_id, $queried->taxonomy );

				$args = array(
					'taxonomy' => $queried->taxonomy,
				);

				if( ! empty( $termchildren ) ) {
					$args['parent'] = $queried->term_id;

					if( count( $termchildren ) == 1 ) {
						$term = get_term_by( 'id', $termchildren[0], $queried->taxonomy );

						if( $term->count == 0 ) {
							$args['parent'] = $queried->parent;
						}
					}

				} else {
					$args['parent'] = $queried->parent;
				}
			}
		}

		if ( ! empty( $settings['orderby'] ) ) {
			$args['orderby'] = $settings['orderby'];

			if ( $settings['orderby'] == 'order' ) {
				$args['menu_order'] = 'asc';
			} else {
				if ( $settings['orderby'] == 'count' ) {
					$args['order'] = 'desc';
				}
			}
		}

		if( ! empty ( $settings['limit'] ) && $settings['limit'] !== '0' ) {
			$args['number'] =  $settings['limit'];
		}

		$terms = get_terms( $args );

		if ( is_wp_error( $terms ) || ! $terms ) {
			return;
		}

		$thumbnail_size = 'full';

		$button_icon = ! empty( $settings['button_icon']['value'] ) ? '<span class="ecomus-svg-icon ecomus-svg-icon--arrow-top">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ) . '</span>' : '';

		foreach( $terms as $term ) {
			$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
			$images = ! empty( wp_get_attachment_image_src( $thumb_id, $thumbnail_size ) ) ? wp_get_attachment_image_src( $thumb_id, $thumbnail_size )[0] : wc_placeholder_img_src( $thumbnail_size );

			$thumb_url = !empty( $thumb_id ) ? $images : wc_placeholder_img_src( $thumbnail_size );
			$term_img = !empty( $thumb_url ) ? '<img class="catalog-top-categories__image" src="' . esc_url( $thumb_url ) . '" alt="' . esc_attr( $term->name ) . '" />' : '<span class="catalog-top-categories__image">' . esc_attr( $term->name ) . '</span>';

			$ouput[] = sprintf(
						'<div class="catalog-top-categories__item swiper-slide %s"><a class="catalog-top-categories__inner em-ratio em-eff-img-zoom em-image-rounded" href="%s">
							%s
							<span class="catalog-top-categories__title em-button em-button-%s em-font-medium"><span class="catalog-top-categories__text">%s</span>%s</span>
						</a></div>',
						( !empty( $current_term ) && $current_term == $term->term_id ) ? 'active' : '',
						esc_url( get_term_link( $term->term_id ) ),
						$term_img,
						esc_attr( $settings['button_style'] ),
						esc_html( $term->name ),
						$button_icon
					);
		}

		$this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );

		echo sprintf(
				'<div class="catalog-top-categories--elementor em-ratio--portrait swiper ecomus-carousel--elementor" %s>
					<div class="catalog-top-categories__wrapper swiper-wrapper mobile-col-2 tablet-col-3 columns-5">%s</div>
					%s
					%s
				</div>',
				$this->get_render_attribute_string( 'wrapper' ),
				implode( '', $ouput ),
				$this->render_pagination(),
				$this->render_arrows(),
			);
	}

	/**
	 * Check is shop
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function is_shop() {
		if( function_exists('is_product_category') && is_product_category() ) {
			return false;
		} elseif( function_exists('is_shop') && is_shop() ) {
			if ( ! empty( $_GET ) && ( isset($_GET['product_cat']) )) {
				return false;
			}

			return true;
		}

		return true;
	}
}
