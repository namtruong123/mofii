<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Ecomus\Addons\Helper;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor categories grid widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Categories_Grid extends Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Get widget name.
	 *
	 * Retrieve categories grid widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-categories-grid';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve categories grid widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Product Categories Grid', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve product categories widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-product-categories';
	}

	/**
	 * Get widget categories
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return string Widget categories
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

	/**
	 * Get widget keywords.
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'collection', 'list', 'categories', 'ecomus-addons' ];
	}

	/**
	 * Register categories grid widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Categories', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'       => esc_html__( 'Source', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'default' => esc_html__( 'Default', 'ecomus-addons' ),
					'custom'  => esc_html__( 'Custom', 'ecomus-addons' ),
				],
				'default'     => 'default',
				'label_block' => true,
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
				'condition'   => [
					'source' => 'custom',
				],
			]
		);

		$this->add_control(
			'number',
			[
				'label'           => esc_html__( 'Item Per Page', 'ecomus-addons' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 50,
				'default' 		=> '6',
				'frontend_available' => true,
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'ecomus-addons' ),
				'type'           => Controls_Manager::NUMBER,
				'min'            => 1,
				'max'            => 10,
				'step'           => 1,
				'default'        => 3,
				'tablet_default' => 2,
				'mobile_default' => 2,
				'selectors' => [
					'{{WRAPPER}} .ecomus-categories-grid__items' => '--em-categories-grid-columns: {{VALUE}}',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'ecomus-addons' ),
					'date'       => esc_html__( 'Date', 'ecomus-addons' ),
					'title'      => esc_html__( 'Title', 'ecomus-addons' ),
					'count'      => esc_html__( 'Count', 'ecomus-addons' ),
					'menu_order' => esc_html__( 'Menu Order', 'ecomus-addons' ),
				],
				'default'   => '',
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'        => __( 'Navigation', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'return_value' => 'yes',
				'condition'   => [
					'source' => 'default',
				],
			]
		);

		$this->end_controls_section();

		$this->section_style();

	}

	// Tab Style
	protected function section_style() {
		$this->start_controls_section(
			'section_style_categories',
			[
				'label' => esc_html__( 'Categories', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
				'tablet_default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
				'mobile_default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-grid__items' => '--em-categories-grid-col-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
				'tablet_default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
				'mobile_default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-categories-grid__items' => '--em-categories-grid-row-gap: {{SIZE}}{{UNIT}};',
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

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'vertical' ] );

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
			'button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_style_controls( 'light' );

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-categories-grid' ] );
		$this->add_render_attribute( 'wrapper', 'style', [$this->render_aspect_ratio_style() ] );

		echo sprintf(
			'<div %s>
				<div class="ecomus-categories-grid__items em-flex">%s</div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$this->get_categories_content( $settings )
		);
	}

	/**
	 * Get Categories
	 */
	protected function get_categories_content( $settings ) {
		$output = [];

		$button_class = ! empty( $settings['button_style'] ) ? ' em-button-'  . $settings['button_style'] : '';

		if ( $settings['product_cat'] ) {
			$cats = explode(',', $settings['product_cat']);
			$output[] = '';

			foreach ( $cats as $tab ) {
				$term = get_term_by( 'slug', $tab, 'product_cat' );

				if( is_wp_error( $term ) || empty( $term ) ) {
					continue;
				}

				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
				$image = $image ? '<div class="ecomus-categories-grid__image"> '.$image.'</div>' : '';

				if ( empty( $image ) ) {
					$image = '<img src="'. wc_placeholder_img_src() .'" title="'. esc_attr( $term->name ) .'" alt="'. esc_attr( $term->name ) .'" loading="lazy"/>';
				}

				$output[] = sprintf(
					'<div class="ecomus-categories-grid__item">
						<a href="%s" class="em-relative em-ratio em-eff-img-zoom">
							%s
							<span class="ecomus-categories-grid__title ecomus-button em-button%s em-font-medium">
								<span class="ecomus-categories-grid__text">%s</span>
								%s
							</span>
						</a>
					</div>',
					esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
					$image,
					esc_attr($button_class),
					esc_html( $term->name ),
					\Ecomus\Addons\Helper::get_svg( 'arrow-top' )
				);
			}

		} else{
			$term_args = [
				'taxonomy' => 'product_cat',
				'orderby'  => $settings['orderby'],
			];

			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$total_terms = count(get_terms('product_cat'));

			if( $settings['number'] ) {
				$term_args['number'] = intval( $settings['number'] );
				$term_args['offset'] = ( $paged - 1 ) * intval( $settings['number'] );
			}

			$terms = get_terms( $term_args );

			foreach ( $terms as $term ) {
				$thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
				$settings['image']['url'] = wp_get_attachment_image_src( $thumbnail_id );
				$settings['image']['id']  = $thumbnail_id;
				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );

				if ( empty( $image ) ) {
					$image = '<img src="'. wc_placeholder_img_src() .'" title="'. esc_attr( $term->name ) .'" alt="'. esc_attr( $term->name ) .'" loading="lazy"/>';
				}


				$output[] = sprintf(
					'<div class="ecomus-categories-grid__item">
						<a href="%s" class="em-relative em-ratio em-eff-img-zoom">
							%s
							<span class="ecomus-categories-grid__title ecomus-button em-button%s em-font-medium">
								<span class="ecomus-categories-grid__text">%s</span>
								%s
							</span>
						</a>
					</div>',
					esc_url( get_term_link( $term->term_id, 'product_cat' ) ),
					$image,
					esc_attr($button_class),
					esc_html( $term->name ),
					\Ecomus\Addons\Helper::get_svg( 'arrow-top' )
				);
			}

			if ( $settings['navigation'] ) {
				$output[] = '<nav class="woocommerce-pagination woocommerce-pagination--catalog woocommerce-button em-button-outline">';

				$big = 999999999;
				$output[] = paginate_links(array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => $paged,
					'total' => ceil( $total_terms / intval( $settings['number'] ) ),
					'type' => 'list',
					'prev_text' => \Ecomus\Addons\Helper::get_svg( 'left-mini' ),
					'next_text' => \Ecomus\Addons\Helper::get_svg( 'right-mini' ),
				));

				$output[] = '</nav>';
			}
		}

		return implode( '', $output );
	}
}