<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Subscribe_Group extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-subscribe-group';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Subscribe Group', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-form-horizontal';
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
		return [ 'subscribe box', 'subscribe group', 'form', 'currency', 'language', 'ecomus-addons' ];
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
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->content_sections();
		$this->style_sections();
	}

	protected function content_sections() {
		// Content
		$this->start_controls_section(
			'section_subscribe_box',
			[ 'label' => __( 'Subscribe Box', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'type',
			[
				'label' => esc_html__( 'Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'mailchimp'  => esc_html__( 'Mailchimp', 'ecomus-addons' ),
					'shortcode' => esc_html__( 'Use Shortcode', 'ecomus-addons' ),
				],
				'default' => 'mailchimp',
			]
		);

		$this->add_control(
			'form',
			[
				'label'   => esc_html__( 'Mailchimp Form', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_contact_form(),
				'conditions' => [
					'terms' => [
						[
							'name' => 'type',
							'operator' => '==',
							'value' => 'mailchimp'
						],
					],
				],
			]
		);

		$this->add_control(
			'form_shortcode',
			[
				'label' => __( 'Enter your shortcode', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => '[gallery id="123" size="medium"]',
				'conditions' => [
					'terms' => [
						[
							'name' => 'type',
							'operator' => '==',
							'value' => 'shortcode'
						],
					],
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
			]
		);

		$this->add_control(
			'show_currency',
			[
				'label'        => __( 'Show Currency', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'ecomus-addons' ),
				'label_on'     => __( 'On', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_language',
			[
				'label'        => __( 'Show Language', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'ecomus-addons' ),
				'label_on'     => __( 'On', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

	}

	protected function style_sections() {
		$this->start_controls_section(
			'style_content',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'toggle_menu',
			[
				'label'        => __( 'Toggle Menu on Mobile', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'ecomus-addons' ),
				'label_on'     => __( 'On', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'heading_icon',
			[
				'label' => __( 'Arrow Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'toggle_menu' => 'yes',
				],
			]
		);

		$this->add_control(
			'style_icons',
			[
				'label' => __( 'Icon Normal', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
				'condition' => [
					'toggle_menu' => 'yes',
				],
			]
		);

		$this->add_control(
			'style_icons_active',
			[
				'label' => __( 'Icon Active', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [],
				'condition' => [
					'toggle_menu' => 'yes',
					'style_icons[value]!' => '',
				],
			]
		);

		$this->add_control(
			'style_form',
			[
				'label' => __( 'Form', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'form_type',
				[
				'label' => esc_html__( 'Type', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Row', 'ecomus-addons' ),
						'icon' => 'eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column', 'ecomus-addons' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'row',
			]
		);

		$this->add_control(
			'style_input',
			[
				'label' => __( 'Input', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'input_bgcolor',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content' => '--em-input-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content' => '--em-input-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_color',
			[
				'label' => __( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content' => '--em-input-border-color: {{VALUE}}; --em-input-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-input-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-input-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_spacing_right',
			[
				'label'     => esc_html__( 'Spacing Right', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__type-row input[type="email"]' => 'padding-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-subscribe-box__type-row input[type="email"]' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: var(--em-input-padding-x)',
				],
				'condition'   => [
					'form_type' => 'row',
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

    	$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style_message',
			[
				'label' => __( 'Message', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'message_error_color',
			[
				'label' => __( 'Error Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content .mc4wp-response .mc4wp-error' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-subscribe-box__content .mc4wp-response .mc4wp-error a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'message_success_color',
			[
				'label' => __( 'Success Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content .mc4wp-response .mc4wp-success' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-subscribe-box__content .mc4wp-response .mc4wp-success a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-subscribe-box__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style_description',
			[
				'label' => __( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-subscribe-box__description',
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style_currency_language',
			[
				'label' => __( 'Currency & Language', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'currency_language_position',
				[
				'label' => esc_html__( 'Dropdown Position', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-top',
					],
				],
				'default' => 'bottom',
			]
		);

		$this->add_control(
			'currency_language_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-currency-language .current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'currency_language_typography',
				'selector' => '{{WRAPPER}} .ecomus-currency-language .current',
			]
		);

		$this->add_responsive_control(
			'currency_language_spacing',
			[
				'label' => __( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__currency-language' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'ecomus-subscribe-box', 'ecomus-subscribe-group' );
		$this->add_render_attribute( 'content', 'class', [ 'ecomus-subscribe-box__content' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-subscribe-box__title', 'em-font-medium' ] );
		$this->add_render_attribute( 'description', 'class', 'ecomus-subscribe-box__description' );
		$this->add_render_attribute( 'currency-language', 'class', [ 'ecomus-subscribe-box__currency-language', 'em-flex', 'ecomus-subscribe-box__dropdown-position-' . $settings['currency_language_position'] ] );
		$this->add_render_attribute( 'currency', 'class', [ 'ecomus-currency', 'ecomus-currency-language' ] );
		$this->add_render_attribute( 'currency', 'data-toggle', 'popover' );
		$this->add_render_attribute( 'currency', 'data-target', 'currency-popover' );
		$this->add_render_attribute( 'currency', 'data-device', 'mobile' );
		$this->add_render_attribute( 'language', 'class', [ 'ecomus-language', 'ecomus-currency-language' ] );
		$this->add_render_attribute( 'language', 'data-toggle', 'popover' );
		$this->add_render_attribute( 'language', 'data-target', 'language-popover' );
		$this->add_render_attribute( 'language', 'data-device', 'mobile' );

		if ( $settings['toggle_menu'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-toggle-mobile__wrapper' ] );
			$this->add_render_attribute( 'content', 'class', [ 'ecomus-toggle-mobile__content' ] );
			$this->add_render_attribute( 'title', 'class', [ 'ecomus-toggle-mobile__title' ] );
		}

		$output = sprintf(
			'<div class="ecomus-subscribe-box__content ecomus-subscribe-box__type-%s">%s</div>',
			esc_attr( $settings['form_type'] ),
			do_shortcode( '[mc4wp_form id="' . esc_attr( $settings['form'] ) . '"]' ),
		);
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $settings['title'] ) : ?>
				<h6 <?php echo $this->get_render_attribute_string( 'title' ); ?>>
					<?php echo $settings['title']; ?>
					<?php if ( $settings['toggle_menu'] == 'yes' ) : ?>
						<?php
							if ( ! empty( $settings['style_icons']['value'] ) ) {
								$collapse_icon = '<span class="ecomus-svg-icon ecomus-subscribe-box__icon ecomus-subscribe-box__icon-default hidden-sm hidden-md hidden-lg">';
								$collapse_icon .= $this->get_icon_html( $settings['style_icons'], [ 'aria-hidden' => 'true' ] );
								$collapse_icon .= '</span>';

								if ( ! empty( $settings['style_icons_active']['value'] ) ) {
									$collapse_icon .= '<span class="ecomus-svg-icon ecomus-subscribe-box__icon ecomus-subscribe-box__icon-active hidden-sm hidden-md hidden-lg">';
									$collapse_icon .= $this->get_icon_html( $settings['style_icons_active'], [ 'aria-hidden' => 'true' ] );
									$collapse_icon .= '</span>';
								}
							} else {
								$collapse_icon = '<span class="em-collapse-icon"></span>';
							}

							echo $collapse_icon;
						?>
					<?php endif; ?>
				</h6>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
				<?php if ( $settings['description'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo $settings['description']; ?></div>
				<?php endif; ?>
				<?php
					if( $settings['type'] == 'mailchimp' ) {
						echo $output;
					} else {
						echo do_shortcode(  $settings['form_shortcode'] );
					}
				?>
				<?php if ( $settings['show_currency'] == 'yes' || $settings['show_language'] == 'yes' ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'currency-language' ); ?>>
				<?php endif; ?>
					<?php if ( $settings['show_currency'] == 'yes' && class_exists('\Ecomus\WooCommerce\Currency') ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'currency' ); ?>>
							<?php echo \Ecomus\WooCommerce\Currency::currency_switcher(); ?>
						</div>
					<?php endif; ?>
					<?php if ( $settings['show_language'] == 'yes' && class_exists('\Ecomus\WooCommerce\Language') ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'language' ); ?>>
							<?php echo \Ecomus\WooCommerce\Language::language_switcher(); ?>
						</div>
					<?php endif; ?>
				<?php if ( $settings['show_currency'] == 'yes' || $settings['show_language'] == 'yes' ) : ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get Contact Form
	 */
	protected function get_contact_form() {
		$mail_forms    = get_posts( 'post_type=mc4wp-form&posts_per_page=-1' );
		$mail_form_ids = array(
			'' => esc_html__( 'Select Form', 'ecomus-addons' ),
		);
		foreach ( $mail_forms as $form ) {
			$mail_form_ids[$form->ID] = $form->post_title;
		}

		return $mail_form_ids;
	}

	/**
	 * @param array $icon
	 * @param array $attributes
	 * @param $tag
	 * @return bool|mixed|string
	 */
	function get_icon_html( array $icon, array $attributes, $tag = 'i' ) {
		/**
		 * When the library value is svg it means that it's a SVG media attachment uploaded by the user.
		 * Otherwise, it's the name of the font family that the icon belongs to.
		 */
		if ( 'svg' === $icon['library'] ) {
			$output = Icons_Manager::render_uploaded_svg_icon( $icon['value'] );
		} else {
			$output = Icons_Manager::render_font_icon( $icon, $attributes, $tag );
		}
		return $output;
	}
}