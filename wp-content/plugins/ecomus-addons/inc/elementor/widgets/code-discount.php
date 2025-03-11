<?php

namespace Ecomus\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Code_Discount extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-code-discount';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Code Discount', 'ecomus-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-copy';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
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
	 * Register button widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

        $this->add_control(
			'code',
			[
				'label' => __( 'Code', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your code', 'ecomus-addons' ),
				'default' => __( 'CODE6789', 'ecomus-addons' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'alignments',
			[
				'label'       => esc_html__( 'Alignments', 'ecomus-addons' ),
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
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-code-discount' => 'justify-content: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'code_heading',
			[
				'label' => esc_html__( 'Code', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'code_typography',
				'selector' => '{{WRAPPER}} .ecomus-code-discount__span',
			]
		);

        $this->add_control(
			'code_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__span' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'code_background_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__span' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'code_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-code-discount__span' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'code_border_radius',
			[
				'label'      => __( 'Border radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__span' => '--em-input-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-code-discount__span' => '--em-input-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'ecomus-addons' ),
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
					'{{WRAPPER}} .ecomus-code-discount__copy' => '--em-button-icon-size: {{SIZE}}{{UNIT}};',

				],
			]
		);

        $this->add_control(
			'button_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__copy .ecomus-svg-icon svg' => 'stroke: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'button_color_hover',
			[
				'label'      => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__copy:hover .ecomus-svg-icon svg' => 'stroke: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'button_background_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__copy' => '--em-button-bg-color: {{VALUE}}; --em-button-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'button_background_color_hover',
			[
				'label'      => esc_html__( 'Hover Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__copy' => '--em-button-bg-color-hover: {{VALUE}}; --em-button-color-hover: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__copy' => '--em-button-padding-top: {{TOP}}{{UNIT}}; --em-button-padding-right: {{RIGHT}}{{UNIT}}; --em-button-padding-bottom: {{BOTTOM}}{{UNIT}}; --em-button-padding-left: {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-code-discount__copy' => '--em-button-padding-top: {{TOP}}{{UNIT}}; --em-button-padding-right: {{LEFT}}{{UNIT}}; --em-button-padding-bottom: {{BOTTOM}}{{UNIT}}; --em-button-padding-left: {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-code-discount__copy' => '--em-input-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-code-discount__copy' => '--em-input-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();

		if ( empty( $settings['code'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-code-discount', 'em-flex' ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-code-discount__inner', 'em-relative' ] );
		$this->add_render_attribute( 'input', 'id', 'ecomus-code-discount__input' );
		$this->add_render_attribute( 'input', 'class', [ 'ecomus-code-discount__input', 'em-font-bold' ] );
		$this->add_render_attribute( 'span', 'class', [ 'ecomus-code-discount__span', 'em-font-bold' ] );
		$this->add_render_attribute( 'copy', 'class', [ 'ecomus-code-discount__copy', 'em-absolute', 'em-tooltip' ] );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
                <input type="text" <?php echo $this->get_render_attribute_string( 'input' );?> value="<?php echo esc_attr( $settings['code'] );?>" aria-label="<?php esc_attr_e('Discount Code Input', 'ecomus-addons') ?>" readonly />
                <button <?php echo $this->get_render_attribute_string( 'copy' );?> data-tooltip="<?php esc_attr_e( 'Copy', 'ecomus-addons' ); ?>" data-tooltip_added="<?php esc_attr_e( 'Copied:', 'ecomus-addons' ); ?> <?php echo esc_attr( $settings['code'] );?>">
                    <?php echo \Ecomus\Addons\Helper::get_svg( 'copy' ); ?>
                    <span class="screen-reader-text"><?php esc_html_e( 'Copy', 'ecomus-addons' ); ?></span>
                </button>
            </div>
        </div>
        <?php
	}
}
