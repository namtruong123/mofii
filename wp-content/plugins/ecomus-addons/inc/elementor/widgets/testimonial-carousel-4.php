<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Testimonial Carousel 4 widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Testimonial_Carousel_4 extends Carousel_Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Image Box widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-testimonial-carousel-4';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Image Box widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Testimonial Carousel 4', 'ecomus-addons' );
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
			'testimonial_text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is Text', 'ecomus-addons' ),
				'label_block' => true,
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

		$repeater->add_control(
			'positioning_heading',
			[
				'label' => esc_html__( 'Positioning', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'positioning_icon_type',
			[
				'label' => __( 'Icon Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'image'    => __( 'Image', 'ecomus-addons' ),
					'external' => __( 'External', 'ecomus-addons' ),
				],
				'default' => 'image',
			]
		);

		$repeater->add_control(
			'positioning_image',
			[
				'label' => __( 'Choose Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'positioning_icon_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'positioning_icon_url',
			[
				'label' => __( 'External Icon URL', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'positioning_icon_type' => 'external',
				],
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => __( 'Testimonials', 'ecomus-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default' => [
					[
						'testimonial_text'    => __( 'This is Text', 'ecomus-addons' ),
					],
					[
						'testimonial_text'    => __( 'This is Text', 'ecomus-addons' ),
					],
					[
						'testimonial_text'    => __( 'This is Text', 'ecomus-addons' ),
					],
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
			'slides_to_show'   => 1,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'none',
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

		$this->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__item' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-4__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-testimonial-carousel-4__text' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_heading',
			[
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-4__text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ecomus-testimonial-carousel-4__content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_positioning',
			[
				'label' => __( 'Positioning', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'positioning_max_width',
			[
				'label'     => __( 'Max Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1000,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__positioning img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'positioning_spacing',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__positioning' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'positioning_gap',
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
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__positioning' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'positioning_alignments',
			[
				'label'       => esc_html__( 'Alignments', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'space-between'  => [
						'title' => esc_html__( 'space-between', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-testimonial-carousel-4__positioning' => 'justify-content: {{VALUE}}',
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

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-testimonial-carousel-4', 'ecomus-carousel--elementor', 'swiper' ] );
		$this->add_render_attribute( 'wrapper', 'style', $this->render_space_between_style() );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-testimonial-carousel-4__inner', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
		$this->add_render_attribute( 'item', 'class', [ 'ecomus-testimonial-carousel-4__item', 'swiper-slide' ] );

		$this->add_render_attribute( 'text', 'class', [ 'ecomus-testimonial-carousel-4__text' ] );
		$this->add_render_attribute( 'content', 'class', [ 'ecomus-testimonial-carousel-4__content' ] );
	?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' );?>>
			<div <?php echo $this->get_render_attribute_string( 'inner' );?>>
			<?php foreach( $settings['testimonials'] as $testimonial ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'item' );?>>
					<?php if(  ! empty( $testimonial['testimonial_text'] ) ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'text' );?>><?php echo wp_kses_post( $testimonial['testimonial_text'] ); ?></div>
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
		<?php $this->positioning( $settings ); ?>
	<?php
	}

	public function positioning( $settings ) {
		$this->add_render_attribute( 'positioning', 'class', [ 'ecomus-testimonial-carousel-4__positioning', 'em-flex', 'em-flex-align-center' ] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'positioning' );?>>
		<?php foreach( $settings['testimonials'] as $key => $testimonial ) : ?>
			<?php if( $testimonial['positioning_icon_type'] == 'image' ) : ?>
				<?php if( ! empty( $testimonial['positioning_image']['id'] ) ) : ?>
					<div class="ecomus-testimonial-carousel-4__positioning-item <?php echo $key == 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $key ); ?>">
						<?php echo wp_get_attachment_image( $testimonial['positioning_image']['id'], 'full' ); ?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php if( ! empty( $testimonial['positioning_icon_url'] ) ) : ?>
					<div class="ecomus-testimonial-carousel-4__positioning-item <?php echo $key == 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $key ); ?>">
						<?php echo sprintf( '<img alt="%s" src="%s">', esc_attr( $testimonial['testimonial_text'] ), esc_url( $testimonial['positioning_icon_url'] ) ); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
		</div>
		<?php
	}
}