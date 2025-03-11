<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Timeline widget
 */
class Timeline extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-timeline';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Timeline', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-time-line';
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
	 * Register heading widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->content_sections();
		$this->style_sections();
	}

	protected function content_sections() {
		$this->start_controls_section(
			'section_contents',
			[
				'label' => __( 'Contents', 'ecomus-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'year',
			[
				'label' => __( 'Year', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter year', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter subtitle', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter title', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your description', 'ecomus-addons' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'timeline',
			[
				'label'      => esc_html__( 'Timeline', 'ecomus-addons' ),
				'type'       => Controls_Manager::REPEATER,
				'fields'     => $repeater->get_controls(),
				'title_field' => '{{{ year }}}',
				'default' => [
					[
						'year'        => __( '0000', 'ecomus-addons' ),
						'image'       => ['url' => 'https://via.placeholder.com/500x370/f5f5f5?text=Image'],
						'subtitle'    => __( 'Subtitle', 'ecomus-addons' ),
						'title'       => __( 'Title', 'ecomus-addons' ),
						'description' => __( 'Description', 'ecomus-addons' ),
					],
					[
						'year'        => __( '1000', 'ecomus-addons' ),
						'image'       => ['url' => 'https://via.placeholder.com/500x370/f5f5f5?text=Image'],
						'subtitle'    => __( 'Subtitle', 'ecomus-addons' ),
						'title'       => __( 'Title', 'ecomus-addons' ),
						'description' => __( 'Description', 'ecomus-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function style_sections() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Style', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_style_heading',
			[
				'label' => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-timeline__image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-timeline__image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'year_style_heading',
			[
				'label' => __( 'Year', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'year_typography',
				'selector' => '{{WRAPPER}} .ecomus-timeline__year',
			]
		);

		$this->add_control(
			'year_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-timeline__year' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'year_background_color',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-timeline__year' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'year_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-timeline__year' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-timeline__year' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'year_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-timeline__year' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-timeline__year' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'subtitle_style_heading',
			[
				'label' => __( 'Subtitle', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .ecomus-timeline__subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-timeline__subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_style_heading',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-timeline__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-timeline__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'description_style_heading',
			[
				'label' => __( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-timeline__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-timeline__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-timeline', 'em-relative' ] );
		$this->add_render_attribute( 'line', 'class', [ 'ecomus-timeline__line', 'em-absolute' ] );
		$this->add_render_attribute( 'item', 'class', [ 'ecomus-timeline__item', 'em-relative' ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-timeline__inner', 'em-relative', 'em-flex', 'em-flex-align-center' ] );
		$this->add_render_attribute( 'year', 'class', [ 'ecomus-timeline__year', 'em-absolute' ] );
		$this->add_render_attribute( 'image', 'class', 'ecomus-timeline__image' );
		$this->add_render_attribute( 'content', 'class', 'ecomus-timeline__content' );
		$this->add_render_attribute( 'subtitle', 'class', 'ecomus-timeline__subtitle' );
		$this->add_render_attribute( 'title', 'class', 'ecomus-timeline__title' );
		$this->add_render_attribute( 'description', 'class', 'ecomus-timeline__description' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<span <?php echo $this->get_render_attribute_string( 'line' ); ?>></span>
			<?php foreach( $settings['timeline'] as $timeline ): ?>
				<div <?php echo $this->get_render_attribute_string( 'item' ); ?>>
					<div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
						<span <?php echo $this->get_render_attribute_string( 'year' ); ?>><?php echo wp_kses_post( $timeline['year'] ); ?></span>
						<div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
							<?php if( ! empty( $timeline['image'] ) && ! empty( $timeline['image']['url'] ) ) : ?>
							<?php
								$settings['image'] = $timeline['image'];
								$settings['image_size'] = 'full';
								echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
							?>
						 <?php endif; ?>
						</div>
						<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
							<div <?php echo $this->get_render_attribute_string( 'subtitle' ); ?>><?php echo wp_kses_post( $timeline['subtitle'] ); ?></div>
							<div <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $timeline['title'] ); ?></div>
							<div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $timeline['description'] ); ?></div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
