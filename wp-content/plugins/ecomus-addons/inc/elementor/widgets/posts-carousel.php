<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Ecomus\Addons\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Posts_Carousel extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-posts-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Posts Carousel', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-carousel';
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
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'post carousel', 'post', 'carousel', 'ecomus' ];
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
	 * Register heading widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style_carousel();
	}

	// Tab Content
	protected function section_content() {
		$this->start_controls_section(
			'section_posts_carousel',
			[ 'label' => __( 'Posts Carousel', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'limit',
			[
				'label'     => __( 'Total', 'ecomus-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -1,
				'max'       => 100,
				'step'      => 1,
				'default'   => 6,
			]
		);

		$this->add_control(
			'category',
			[
				'label'    => __( 'Category', 'ecomus-addons' ),
				'type'     => Controls_Manager::SELECT2,
				'options'  => self::get_terms_options(),
				'default'  => '',
				'multiple' => true,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'      => esc_html__( 'Order By', 'ecomus-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'date'       => esc_html__( 'Date', 'ecomus-addons' ),
					'name'       => esc_html__( 'Name', 'ecomus-addons' ),
					'id'         => esc_html__( 'Ids', 'ecomus-addons' ),
					'rand' 		=> esc_html__( 'Random', 'ecomus-addons' ),
				],
				'default'    => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'      => esc_html__( 'Order', 'ecomus-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''     => esc_html__( 'Default', 'ecomus-addons' ),
					'ASC'  => esc_html__( 'Ascending', 'ecomus-addons' ),
					'DESC' => esc_html__( 'Descending', 'ecomus-addons' ),
				],
				'default'    => '',
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

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'square' ] );

		$this->end_controls_section();

		$this->section_content_carousel();
	}

	protected function section_content_carousel() {
		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => __( 'Carousel Settings', 'ecomus-addons' ),
			]
		);

		$controls = [
			'slides_to_show'   => 3,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'arrows',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

		$this->end_controls_section();
	}

	protected function section_style_carousel() {
		$this->start_controls_section(
			'section_post_style',
			[
				'label'     => __( 'Posts', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'post_image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'post_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-image-rounded-post-card: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded-post-card: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_image_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .entry-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .post-thumbnail' => 'margin-bottom: 0;',
				],
			]
		);

		$this->add_control(
			'post_category_heading',
			[
				'label' => esc_html__( 'Category', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'post_carousel_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .em-button-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-button-category' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_carousel_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .em-badge' => '--em-badge-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-badge' => '--em-badge-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_carousel_typography',
				'selector' => '{{WRAPPER}} .em-button-category',
			]
		);

		$this->add_control(
			'post_carousel_background_color',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-button-category' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'post_carousel_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-button-category' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'post_title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_title_typography',
				'selector' => '{{WRAPPER}} .entry-title',
			]
		);

		$this->add_control(
			'post_title_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .entry-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'post_title_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'post_title_line',
			[
				'label'      => esc_html__( 'Post Title in', 'ecomus-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'none' => esc_html__( 'Default', 'ecomus-addons' ),
					'2'    => esc_html__( '2 lines', 'ecomus-addons' ),
					'3'    => esc_html__( '3 lines', 'ecomus-addons' ),
					'4'    => esc_html__( '4 lines', 'ecomus-addons' ),
				],
				'default'    => 'none',
				'selectors' => [
					'{{WRAPPER}} .entry-title' => '--em-line-clamp-count: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls( 'light' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-posts-carousel', 'hfeed', 'ecomus-carousel--elementor', 'swiper' ] );
        $this->add_render_attribute( 'wrapper', 'style', [ $this->render_space_between_style(), $this->render_aspect_ratio_style() ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-posts-carousel__inner', 'em-post-grid', 'em-flex', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
		$this->add_render_attribute( 'image', 'class', [ 'ecomus-posts-carousel__image', 'post-thumbnail', 'em-ratio', 'em-eff-img-zoom' ] );

		$output = array();

		$args = array(
			'post_type'              => 'post',
			'posts_per_page'         => $settings['limit'],
			'orderby'     			 => $settings['orderby'],
			'ignore_sticky_posts'    => 1,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'suppress_filters'       => false,
		);

		if ($settings['order'] != ''){
			$args['order'] = $settings['order'];
		}

		if ( $settings['category'] ) {
			$args['category_name'] = trim( $settings['category'] );
		}

		$posts = new \WP_Query( $args );

		if ( ! $posts->have_posts() ) {
			return '';
		}

		$button_class = ! empty( $settings['button_style'] ) ? ' em-button-'  . $settings['button_style'] : '';

		while ( $posts->have_posts() ) : $posts->the_post();
			$size = apply_filters( 'ecomus_get_post_thumbnail_size', 'large' );
			$image = wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $size);

			$categories = get_the_category( get_the_ID() );
			$link_for = esc_html__('Link for', 'ecomus-addons');
			$link_for .= ' ' . get_the_title();
			$this->add_render_attribute( 'image', 'aria-label', [ $link_for ] );
			$output[] = sprintf(
				'<article class="%s">
					<div class="entry-header em-relative">
						<a %s href="%s" aria-hidden="true" tabindex="-1">%s</a>
						<div class="entry-category">
							<a class="em-badge em-button-category em-badge-light" href="%s">%s</a>
						</div>
					</div>
					<div class="entry-summary">
						<h6 class="entry-title"><a href="%s" rel="bookmark">%s</a></h6>
						<div class="entry-read-more"><a class="em-button em-button-subtle em-font-semibold" href="%s"><span class="ecomus-button-text">%s</span> %s</a></div>
					</div>
				</article>',
				esc_attr( implode( ' ', get_post_class( 'swiper-slide' ) ) ),
				$this->get_render_attribute_string( 'image' ),
				esc_url( get_permalink() ),
				$image,
				esc_url( get_category_link( $categories[0]->term_id ) ),
				esc_html( $categories[0]->name ),
				esc_url( get_permalink() ),
				get_the_title(),
				esc_url( get_permalink() ),
				esc_html__( 'Read More', 'ecomus' ),
				\Ecomus\Addons\Helper::get_svg( 'arrow-top' )
			);

		endwhile;

		wp_reset_postdata();

		echo sprintf(
			'<div %s>
				<div %s>
					%s
				</div>
				%s%s
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$this->get_render_attribute_string( 'inner' ),
			implode( '', $output ),
			$this->render_arrows(),
			$this->render_pagination()
		);
	}

	/**
	 * Get terms array for select control
	 *
	 * @param string $taxonomy
	 * @return array
	 */
	public static function get_terms_options( $taxonomy = 'category' ) {
		$terms = Helper::get_terms_hierarchy( $taxonomy, '&#8212;' );

		if ( empty( $terms ) ) {
			return [];
		}

		$options = wp_list_pluck( $terms, 'name', 'slug' );

		return $options;
	}
}