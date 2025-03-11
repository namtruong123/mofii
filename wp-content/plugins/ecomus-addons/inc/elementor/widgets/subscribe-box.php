<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
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
class Subscribe_Box extends Widget_Base {
  /**
   * Retrieve the widget name.
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'ecomus-subscribe-box';
  }

  /**
   * Retrieve the widget title.
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( '[Ecomus] Subscribe Box', 'ecomus-addons' );
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
    return [ 'subscribe box', 'form', 'ecomus-addons' ];
  }

  /**
   * Register the widget controls.
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @access protected
   */
  protected function register_controls() {
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

    $this->end_controls_section();

    $this->start_controls_section(
			'style_content',
			[
				'label'     => __( 'Form', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
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
				'default' => 'column',
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
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-subscribe-box__type-row .ecomus-subscribe-box__content .mc4wp-form-fields' => 'justify-content: {{VALUE}}',
				],
        'condition'   => [
					'form_type' => 'row',
				],
			]
		);

    $this->add_control(
			'input_heading',
			[
				'label' => esc_html__( 'Input', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

    $this->add_responsive_control(
			'input_width',
			[
				'label'      => esc_html__( 'Container Width', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1900,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-subscribe-box__content input:not([type="submit"])' => 'max-width: {{SIZE}}{{UNIT}};',
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

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]',
			]
		);

    $this->add_control(
			'button_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => '--em-button-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'button_bgcolor',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'button_bordercolor',
			[
				'label' => __( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'button_hover_bgcolor',
			[
				'label' => __( 'Hover Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'button_hover_bordercolor',
			[
				'label' => __( 'Hover Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

    $this->add_control(
			'button_background_effect_hover_color',
			[
				'label'     => __( 'Hover Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
			]
		);

    $this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-subscribe-box__content [type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
					'{{WRAPPER}}' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

    $classes = [
      'ecomus-subscribe-box',
      'ecomus-subscribe-box__type-' . esc_attr( $settings['form_type'] ),
    ];

    $this->add_render_attribute( 'wrapper', 'class', $classes );

    $output = sprintf(
      '<div class="ecomus-subscribe-box__content">%s</div>',
      do_shortcode( '[mc4wp_form id="' . esc_attr( $settings['form'] ) . '"]' ),
    );
    ?>
    <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
      <?php
      if( $settings['type'] == 'mailchimp' ) {
        echo $output;
      } else {
        echo do_shortcode(  $settings['form_shortcode'] );
      }
      ?>
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
}