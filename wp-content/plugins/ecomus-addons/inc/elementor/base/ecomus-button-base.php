<?php
namespace Ecomus\Addons\Elementor\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

trait Ecomus_Button_Base {
	/**
	 * Register controls
	 *
	 * @param array $controls
	 */
	protected function register_button_repeater_controls( $repeater ) {
		$repeater->add_control(
			'button_text',
			[
				'label'       => __( 'Text', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Click here', 'ecomus-addons' ),
				'placeholder' => __( 'Click here', 'ecomus-addons' ),
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
				'default'     => [
					'url' => '#',
				],
			]
		);
	}

	/**
	 * Register controls
	 *
	 * @param array $controls
	 */
	protected function register_button_controls( $hide_link = '' ) {
		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Text', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Click here', 'ecomus-addons' ),
				'placeholder' => __( 'Click here', 'ecomus-addons' ),
			]
		);

		if ( empty( $hide_link ) ) {
			$this->add_control(
				'button_link',
				[
					'label'       => __( 'Link', 'ecomus-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
					'default'     => [
						'url' => '#',
					],
				]
			);
		}

		$this->register_button_icon_controls();
	}

	/**
	 * Register controls style
	 *
	 * @param array $controls
	 */
	protected function register_button_style_controls( $default_style = '', $default_classes = '' ) {
		$default_classes = $default_classes != '' ? $default_classes : 'ecomus-button';

		$this->add_control(
			'button_style',
			[
				'label'   => __( 'Style', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $default_style,
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
					'{{WRAPPER}} .' . $default_classes => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .' . $default_classes => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
					'{{WRAPPER}} .' . $default_classes => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .' . $default_classes => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .' . $default_classes,
			]
		);

		$this->add_responsive_control(
			'button_min_width',
			[
				'label' => esc_html__( 'Min Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .' . $default_classes => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_min_height',
			[
				'label' => esc_html__( 'Min Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .' . $default_classes => 'min-height: {{SIZE}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .' . $default_classes => 'border-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .' . $default_classes => '--em-button-bg-color: {{VALUE}};',
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
					'{{WRAPPER}} .' . $default_classes => '--em-button-color: {{VALUE}};',
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
					'{{WRAPPER}} .' . $default_classes => '--em-button-border-color: {{VALUE}};',
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
					'{{WRAPPER}} .' . $default_classes => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .' . $default_classes => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .' . $default_classes => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .' . $default_classes => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['']
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_icon_style_heading',
			[
				'label' => __( 'Button Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_button_icon!' => 'none',
				],
			]
		);

		$this->register_button_icon_style_controls( $default_classes );
	}

	/**
	 * Register controls style
	 *
	 * @param array $controls
	 */
	protected function register_button_icon_controls() {
		$this->add_control(
			'show_button_icon',
			[
				'label'   => esc_html__( 'Show Icon', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'  => esc_html__( 'None', 'ecomus-addons' ),
					'hover' => esc_html__( 'Hover on Display', 'ecomus-addons' ),
					'alway' => esc_html__( 'Always on Display', 'ecomus-addons' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'            => __( 'Icon', 'ecomus-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'condition' => [
					'show_button_icon!' => 'none',
				],
			]
		);

		$this->add_control(
			'button_icon_align',
			[
				'label'     => __( 'Icon Position', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => __( 'Before', 'ecomus-addons' ),
					'right' => __( 'After', 'ecomus-addons' ),
				],
				'condition' => [
					'show_button_icon!' => 'none',
				],
			]
		);

	}

		/**
	 * Register controls style
	 *
	 * @param array $controls
	 */
	protected function register_button_icon_style_controls( $default_classes ) {
		$this->add_responsive_control(
			'button_icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .' . $default_classes => '--em-button-icon-spacing: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_button_icon!' => 'none',
				],
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
					'{{WRAPPER}} .ecomus-button .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}; --em-button-icon-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_button_icon!' => 'none',
				],
			]
		);
		$this->add_responsive_control(
			'button_icon_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-button .ecomus-svg-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-button .ecomus-svg-icon' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition' => [
					'show_button_icon!' => 'none',
				],
			]
		);
	}

	/**
	 * Render button for shortcode.
	 *
	 */
	protected function render_button( $repeater = '', $index = '', $button_link = '' ) {
		$settings 	= $this->get_settings_for_display();

		$repeater 	= ! empty( $repeater ) ? $repeater : $this->get_settings_for_display();
		if ( ! empty( $index ) ) {
			$button_key = $this->get_repeater_setting_key( 'button', 'button_index', $index );
			$text_key   = $this->get_repeater_setting_key( 'text', 'button_index', $index );
		} else {
			$button_key = 'button';
			$text_key   = 'text';
		}

		if ( $settings['show_button_icon'] == 'none' && empty( $repeater['button_text'] ) ) {
			return;
		}

		$is_new   	= Icons_Manager::is_migration_allowed();

		$button_link = ! empty( $button_link ) ? $button_link : $repeater['button_link'];

		if ( ! empty( $button_link['url'] ) ) {
			$this->add_link_attributes( $button_key, $button_link );
			$this->add_render_attribute( $button_key, 'class', 'ecomus-button-link' );
		}

		$this->add_render_attribute( $button_key, 'class', 'ecomus-button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( $button_key, 'id', $settings['button_css_id'] );
		}

		if ( isset( $repeater['button_text_classes'] ) ) {
			$this->add_render_attribute( $text_key, 'class', $repeater['button_text_classes'] );
		}

		$classes = 'em-button';
		if( empty($settings['button_style']) ) {
			$classes .= ' em-button-hover-eff';
		}
		$classes .= ! empty( $repeater['button_classes'] ) ? $repeater['button_classes'] : '';
		$classes .= ! empty( $settings['button_style'] ) ? ' em-button-'  . $settings['button_style'] : '';
		$classes .= isset( $settings['show_button_icon'] ) && $settings['show_button_icon'] != 'none' ? ' em-button-icon-'  . $settings['show_button_icon'] : '';

		$this->add_render_attribute( $button_key, 'class', $classes );

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'ecomus-button-content-wrapper',
			],
			'icon-align'      => [
				'class' => [
					'ecomus-svg-icon',
				],
			],
			$text_key            => [
				'class' => 'ecomus-button-text',
			],
		] );

		if ( isset( $settings['show_button_icon'] ) && $settings['show_button_icon'] != 'none' ) {
			$this->add_render_attribute( 'icon-align', 'class', 'ecomus-align-icon-' . $settings['button_icon_align'] );
		}

		$this->add_inline_editing_attributes( $text_key, 'none' );
		$button_text = sprintf('<span %s>%s</span>', $this->get_render_attribute_string( $text_key ), $repeater['button_text']);
		?>
		<a <?php echo $this->get_render_attribute_string( $button_key ); ?>>
			<?php
				if( $settings['button_icon_align'] == 'right' ) {
					echo $button_text;
				}
			?>
			<?php if ( isset( $settings['show_button_icon'] ) && ( $settings['show_button_icon'] ) != 'none' ) : ?>
				<?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
						<?php if ( $is_new ) :
							Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
						endif; ?>
					</span>
				<?php else : ?>
					<?php echo \Ecomus\Addons\Helper::get_svg( 'arrow-top', 'ui', 'class=ecomus-align-icon-' . $settings['button_icon_align'] ); ?>
				<?php endif; ?>
			<?php endif; ?>
			<?php
				if( $settings['button_icon_align'] != 'right' ) {
					echo $button_text;
				}
			?>
		</a>
		<?php
	}

}