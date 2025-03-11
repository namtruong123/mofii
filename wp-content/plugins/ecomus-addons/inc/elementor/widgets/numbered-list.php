<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Numbered_List extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Numbered List widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-numbered-list';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Numbered List widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Numbered List', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve Numbered List widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-number-field';
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

	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text', [
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default' => [
					[
                        'text' => esc_html__( 'Numbered List 1', 'ecomus-addons' ),
					],
					[
                        'text' => esc_html__( 'Numbered List 2', 'ecomus-addons' ),
					],
					[
                        'text' => esc_html__( 'Numbered List 3', 'ecomus-addons' ),
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style() {
		// Style
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-numbered-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-numbered-list' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-numbered-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-numbered-list' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label'      => esc_html__( 'Gap', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-numbered-list__item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'      => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-numbered-list__item' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'number_heading',
			[
				'label' => esc_html__( 'Number', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'number_width',
			[
				'label'     => __( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-numbered-list__number' => 'width: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'number_height',
			[
				'label'     => __( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-numbered-list__number' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .ecomus-numbered-list__number',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-numbered-list__number' => 'color: {{VALUE}}; border-color: {{VALUE}}',
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
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-numbered-list__text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-numbered-list__text' => 'color: {{VALUE}}',
				],
			]
		);

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

		$classes = [
			'ecomus-numbered-list',
			'ecomus-elementor--numbered-list',
		];

        $this->add_render_attribute( 'wrapper', 'class', $classes );
        $this->add_render_attribute( 'items', 'class', [ 'ecomus-numbered-list__items', 'list-unstyled' ] );
        $this->add_render_attribute( 'item', 'class', [ 'ecomus-numbered-list__item', 'em-flex', 'em-flex-align-center' ] );
        $this->add_render_attribute( 'number', 'class', [ 'ecomus-numbered-list__number', 'em-flex', 'em-flex-align-center', 'em-flex-center' ] );
        $this->add_render_attribute( 'text', 'class', [ 'ecomus-numbered-list__text' ] );
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<ul <?php echo $this->get_render_attribute_string( 'items' ); ?>>
				<?php foreach( $settings['items'] as $index => $item ) : ?>
					<li <?php echo $this->get_render_attribute_string( 'item' ); ?>>
						<div <?php echo $this->get_render_attribute_string( 'number' ); ?>>
							<?php echo $index + 1; ?>
						</div>
						<div <?php echo $this->get_render_attribute_string( 'text' ); ?>>
							<?php echo wp_kses_post( $item['text'] ); ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
        </div>
    <?php
	}
}