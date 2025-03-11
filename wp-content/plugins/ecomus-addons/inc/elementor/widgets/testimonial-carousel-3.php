<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Testimonial Carousel 3 widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Testimonial_Carousel_3 extends Carousel_Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Image Box widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-testimonial-carousel-3';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Image Box widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Testimonial Carousel 3', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve Image Box widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-testimonial-carousel';
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
		return [ 'testimonial carousel', 'carousel', 'testimonial', 'ecomus' ];
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
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'testimonial_name',
			[
				'label' => __( 'Name', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'ecomus-addons' ),
				'label_block' => true,
				'separator' => 'before',
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'testimonial_text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Verify customer', 'ecomus-addons' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'testimonial_rating',
			[
				'label'   => esc_html__( 'Rating', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0'    => __( 'None', 'ecomus-addons' ),
					'1'    => __( '1 Star', 'ecomus-addons' ),
					'2'    => __( '2 Stars', 'ecomus-addons' ),
					'3'    => __( '3 Stars', 'ecomus-addons' ),
					'4'    => __( '4 Stars', 'ecomus-addons' ),
					'5'    => __( '5 Stars', 'ecomus-addons' ),
				],
				'default' => 5,
			]
		);

		$repeater->add_control(
			'testimonial_title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Our customers reviews', 'ecomus-addons' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'testimonial_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'rows' => '10',
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => __( 'Testimonials', 'ecomus-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ testimonial_name }}}',
				'default' => [
					[
						'testimonial_name'    => __( 'Name #1', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #2', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #3', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #4', 'ecomus-addons' ),
					],
					[
						'testimonial_name'    => __( 'Name #5', 'ecomus-addons' ),
					]
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Carousel Settings
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Carousel Settings', 'ecomus-addons' ),
			]
		);

		$controls = [
			'slides_to_show'   => 4,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'dots',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => __( 'Testimonial Item', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-3__item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__item' => '--em-rounded-md: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-3__item' => '--em-rounded-md: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'name_group_heading',
			[
				'label' => esc_html__( 'Name Group', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'name_group_gap',
			[
				'label'     => __( 'Gap', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__name-group' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'name_group_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__name-group' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'name_heading',
			[
				'label' => esc_html__( 'Name', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-3__name',
			]
		);

		$this->add_control(
			'text_heading',
			[
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-3__text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_heading',
			[
				'label' => esc_html__( 'Rating', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'rating_size',
			[
				'label'     => __( 'Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__rating.star-rating' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => esc_html__( 'Color Active', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__rating.star-rating .user-rating' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-3__rating' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-3__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
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

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-3__content',
			]
		);

		$this->add_responsive_control(
			'content_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-3__content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->section_style_carousel();
	}

	protected function section_style_carousel() {
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls( 'outline' );

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

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-testimonial-carousel-3', 'ecomus-carousel--elementor', 'swiper' ] );
		$this->add_render_attribute( 'wrapper', 'style', $this->render_space_between_style() );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-testimonial-carousel-3__inner', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
		$this->add_render_attribute( 'item', 'class', [ 'ecomus-testimonial-carousel-3__item', 'swiper-slide' ] );

		$this->add_render_attribute( 'rating', 'class', [ 'ecomus-testimonial-carousel-3__rating', 'star-rating' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-testimonial-carousel-3__title', 'em-font-semibold' ] );
		$this->add_render_attribute( 'content', 'class', [ 'ecomus-testimonial-carousel-3__content' ] );
		$this->add_render_attribute( 'name', 'class', [ 'ecomus-testimonial-carousel-3__name', 'em-font-semibold' ] );
		$this->add_render_attribute( 'text', 'class', [ 'ecomus-testimonial-carousel-3__text' ] );
	?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' );?>>
			<div <?php echo $this->get_render_attribute_string( 'inner' );?>>
			<?php foreach( $settings['testimonials'] as $testimonial ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'item' );?>>
					<div class="ecomus-testimonial-carousel-3__name-group em-flex em-flex-align-center">
						<?php if(  ! empty( $testimonial['testimonial_name'] ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'name' );?>><?php echo wp_kses_post( $testimonial['testimonial_name'] ); ?></div>
						<?php endif; ?>
						<?php if(  ! empty( $testimonial['testimonial_text'] ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'text' );?>>
								<?php echo \Ecomus\Addons\Helper::inline_svg('icon=check'); ?>
								<?php echo wp_kses_post( $testimonial['testimonial_text'] ); ?>
							</div>
						<?php endif; ?>
					</div>
					<div <?php echo $this->get_render_attribute_string( 'rating' ); ?>><?php echo $this->star_rating_html( $testimonial['testimonial_rating'] ); ?></div>
					<?php if(  ! empty( $testimonial['testimonial_title'] ) ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'title' );?>><?php echo wp_kses_post( $testimonial['testimonial_title'] ); ?></div>
					<?php endif; ?>
					<?php if(  ! empty( $testimonial['testimonial_content'] ) ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'content' );?>><?php echo wp_kses_post( $testimonial['testimonial_content'] ); ?></div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
			</div>
			<?php echo $this->render_pagination(); ?>
		</div>
		<?php echo $this->render_arrows(); ?>
	<?php
	}

	public function star_rating_html( $count ) {
		$html = '<span class="max-rating rating-stars">'
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . \Ecomus\Addons\Helper::inline_svg('icon=star')
		        . '</span>';
		$html .= '<span class="user-rating rating-stars" style="width:' . ( ( $count / 5 ) * 100 ) . '%">'
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
				. \Ecomus\Addons\Helper::inline_svg('icon=star')
		         . '</span>';

		$html .= '<span class="screen-reader-text">';

		$html .= '</span>';

		return $html;
	}
}