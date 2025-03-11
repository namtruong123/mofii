<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Ecomus\Addons\Helper;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Countdown widget
 */
class Countdown extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-countdown';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Countdown', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-countdown';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-coundown',
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

	/**
	 * Section Content
	 */
	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'due_date',
			[
				'label'   => esc_html__( 'Date', 'ecomus-addons' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => date( 'Y/m/d', strtotime( '+5 days' ) ),
			]
		);

		$this->add_responsive_control(
			'form_align',
			[
				'label'       => esc_html__( 'Align', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .ecomus-time-countdown' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->start_controls_section(
			'section_digit_style',
			[
				'label' => __( 'Coundown', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'type',
			[
				'label'   => esc_html__( 'Type', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1'   	 => esc_html__( 'Type 1', 'ecomus-addons' ),
					'2' 	 => esc_html__( 'Type 2', 'ecomus-addons' ),
				],
				'default' => '1',
			]
		);

		$this->add_responsive_control(
			'timer_gap',
			[
				'label' => __( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown .ecomus-time-countdown__wrapper' => 'gap: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ecomus-time-countdown--2 .timer .divider' => 'margin-left: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-time-countdown--2 .timer .divider' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown--2 .ecomus-time-countdown__wrapper' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'type' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-time-countdown--2 .ecomus-time-countdown__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-time-countdown--2 .ecomus-time-countdown__wrapper' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition' => [
					'type' => '2',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-time-countdown--2 .ecomus-time-countdown__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-time-countdown--2 .ecomus-time-countdown__wrapper' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
				'condition' => [
					'type' => '2',
				],
			]
		);

		$this->add_control(
			'icon_heading',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'type' => '2',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown .ecomus-svg-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'type' => '2',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'     => __( 'Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'type' => '2',
				],
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown .ecomus-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-time-countdown .ecomus-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right:0;',
				],
				'condition' => [
					'type' => '2',
				],
			]
		);

		$this->add_control(
			'timer_heading',
			[
				'label' => __( 'Timer', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'timer_width',
			[
				'label' => __( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-countdown .timer' => 'min-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'type' => '1',
				],
			]
		);

		$this->add_responsive_control(
			'timer_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-time-countdown .timer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-time-countdown .timer' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition' => [
					'type' => '1',
				],
			]
		);

		$this->add_control(
			'timer_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown .timer' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'type' => '1',
				],
			]
		);

		$this->add_control(
			'timer_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown .timer' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'timer_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-time-countdown .timer',
				'condition' => [
					'type' => '1',
				],
			]
		);

		$this->add_control(
			'timer_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-time-countdown .timer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-time-countdown .timer' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
				'condition' => [
					'type' => '1',
				],
			]
		);

		$this->add_responsive_control(
			'timer_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-countdown .timer' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'type' => '1',
				],
			]
		);

		$this->add_control(
			'digit_heading',
			[
				'label' => __( 'Digit', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'digit_typography',
				'selector' => '{{WRAPPER}} .ecomus-time-countdown .timer .digits',
			]
		);

		$this->add_responsive_control(
			'digit_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-time-countdown .digits' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'type' => '1',
				],
			]
		);

		$this->add_control(
			'label_heading',
			[
				'label' => __( 'Label', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-time-countdown .timer .text',
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

		$this->add_render_attribute(
			'wrapper', 'class', [
				'ecomus-time-countdown',
				'ecomus-time-countdown--' . esc_attr( $settings['type'] )
			]
		);

		$this->add_render_attribute(
			'inner', 'class', [
				'ecomus-time-countdown__wrapper ecomus-countdown',
			]
		);

		$second = 0;
		if ( $settings['due_date'] ) {
			$second_current  = strtotime( current_time( 'Y/m/d H:i:s' ) );
			$second_discount = strtotime( $this->get_settings( 'due_date' ) );

			if ( $second_discount > $second_current ) {
				$second = $second_discount - $second_current;
			}

			$second = apply_filters( 'ecomus_countdown_shortcode_second', $second );
		}

		if( $settings['type'] == '2' ) {
			$this->add_render_attribute( 'inner', 'data-icon', esc_attr( Helper::get_svg( 'clock-2') ) );
		}

		$this->add_render_attribute( 'inner', 'data-expire', [$second] );
		$this->add_render_attribute( 'inner', 'data-text', wp_json_encode( $settings['type'] == '1' ? Helper::get_countdown_shorten_texts() : self::get_countdown_shorten_texts() ) );
		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
            </div>
        </div>
		<?php
	}

	/**
	 * Functions that used to get coutndown texts
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_countdown_shorten_texts() {
		return apply_filters( 'ecomus_get_countdown_texts', array(
			'weeks'    => esc_html__( 'W', 'ecomus-addons' ),
			'days'    => esc_html__( 'D', 'ecomus-addons' ),
			'hours'   => esc_html__( 'H', 'ecomus-addons' ),
			'minutes' => esc_html__( 'M', 'ecomus-addons' ),
			'seconds' => esc_html__( 'S', 'ecomus-addons' )
		) );
	}
}