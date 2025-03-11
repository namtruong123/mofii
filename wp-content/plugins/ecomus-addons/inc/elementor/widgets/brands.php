<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Brands widget
 */
class Brands extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-brands';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Brands', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
	 * Script
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
		$this->start_controls_section(
			'section_options',
			[
				'label' => __( 'Brands', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'type',
			[
				'label' => __( 'Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid' => __( 'Grid', 'ecomus-addons' ),
					'list' => __( 'List', 'ecomus-addons' ),
				],
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label'        => esc_html__( 'Hide empty brands', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ecomus-addons' ),
				'label_off'    => esc_html__( 'Hide', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();

		$this->style_options();
	}

	public function style_options() {
		$this->tabs_style_options();
		$this->brands_style_options();
	}

	public function tabs_style_options() {
		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => esc_html__( 'Tabs', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tabs_max_width',
			[
				'label'     => esc_html__( 'Max Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-brands-filters' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_gap',
			[
				'label'     => esc_html__( 'Gap', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-brands-filters' => 'gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-brands-filters' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; min-width: 0;',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}; min-width: 0;',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; min-width: 0;',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}; min-width: 0;',
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
					'button_color',
					[
						'label'      => esc_html__( 'Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'button_background_color',
					[
						'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button' => 'background-color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'button_border_color',
					[
						'label'      => esc_html__( 'Border Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button' => 'border-color: {{VALUE}}',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_button_active',
				[
					'label' => __( 'Active', 'ecomus-addons' ),
				]
			);

				$this->add_control(
					'button_color_active',
					[
						'label'      => esc_html__( 'Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button.active' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'button_background_color_active',
					[
						'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button.active' => 'background-color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'button_border_color_active',
					[
						'label'      => esc_html__( 'Border Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button.active' => 'border-color: {{VALUE}}',
						],
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_button_disable',
				[
					'label' => __( 'Disable', 'ecomus-addons' ),
				]
			);

				$this->add_control(
					'button_color_disable',
					[
						'label'      => esc_html__( 'Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button.disable' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'button_background_color_disable',
					[
						'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button.disable' => 'background-color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'button_border_color_disable',
					[
						'label'      => esc_html__( 'Border Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__button.disable' => 'border-color: {{VALUE}}',
						],
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function brands_style_options() {
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Brands', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-brands .ecomus-brands-filters__items' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'border',
				'selector'  => '{{WRAPPER}} .ecomus-brands--grid .ecomus-brands-filters__items',
				'condition' => [
					'type' => 'grid',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands--grid .ecomus-brands-filters__items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-brands--grid .ecomus-brands-filters__items' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
				'condition' => [
					'type' => 'grid',
				],
			]
		);

		$this->add_control(
			'heading_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'      => esc_html__( 'Heading Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands .ecomus-brands-filters__heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label'      => esc_html__( 'Spacing bottom', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands--grid .ecomus-brands-filters__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'type' => 'grid',
				],
			]
		);

		$this->add_control(
			'brands_heading',
			[
				'label' => esc_html__( 'Brands', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'brands_typography',
				'selector' => '{{WRAPPER}} .ecomus-brands-filters__item',
			]
		);

		$this->add_control(
			'brands_color',
			[
				'label'      => esc_html__( 'Heading Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands-filters__item a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'brands_color_hover',
			[
				'label'      => esc_html__( 'Heading Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands-filters__item a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'brands_spacing',
			[
				'label'      => esc_html__( 'Spacing bottom', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-brands-filters__item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'type' => 'grid',
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

		$classes = [
			'ecomus-brands',
			'ecomus-brands--' . $settings['type'],
		];

		$atts = [
			'taxonomy'   	=> 'product_brand',
			'hide_empty' 	=> $settings['hide_empty'] == 'yes' ? true : false,
		];

		$terms   = get_terms( $atts );
		$outputs = array();
		$enable  = array();

		if ( is_wp_error( $terms ) ) {
			return;
		}

		if ( empty( $terms ) || ! is_array( $terms ) ) {
			return;
		}

		foreach ( $terms as $term ) {
			$key = mb_substr( $term->slug, 0, 1 );
			$key = is_numeric( $key) ? '123' : $key;

			$thumbnail_id = '';
			if ( function_exists( 'get_term_meta' ) ) {
				$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				if( empty($thumbnail_id) ) {
					$thumbnail_id = absint( get_term_meta( $term->term_id, 'brand_thumbnail_id', true ) );
				}
			}

			$image = $thumbnail_id ? '<a href="'. esc_url( get_term_link( $term->term_id, 'product_brand' ) ) .'">' . wp_get_attachment_image($thumbnail_id, 'full') .'</a>' : '';

			$outputs[$key][] = sprintf(
				'<div class="ecomus-brands-filters__item">' .
					'%s' .
					'<a href="%s">%s</a>' .
				'</div>',
				$settings['type'] == 'list' && ! empty( $thumbnail_id ) ? $image : '',
				esc_url( get_term_link( $term->term_id, 'product_brand' ) ),
				esc_html( $term->name )
			);

			$enable[] = $key;
		}

		$enable = array_unique( $enable );

		$this->add_render_attribute('wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="ecomus-brands-filters">
				<button class="ecomus-brands-filters__button em-font-semibold active" data-filter="all"><?php esc_html_e( 'Show all', 'ecomus-addons' ); ?></button>
				<button class="ecomus-brands-filters__button em-font-semibold <?php echo in_array( '123', $enable ) ? '' : 'disable'; ?>" data-filter="123"><?php esc_html_e( '123', 'ecomus-addons' ); ?></button>
				<?php foreach( range('a', 'z') as $index ) : ?>
					<button class="ecomus-brands-filters__button em-font-semibold <?php echo in_array( strtolower( $index ), $enable ) ? '' : 'disable'; ?>" data-filter="<?php echo esc_attr( $index ); ?>"><?php echo esc_html( $index ); ?></button>
				<?php endforeach; ?>
			</div>
			<div class="ecomus-brands-filters__wrapper em-flex em-flex-wrap">
				<?php foreach( $outputs as $key => $index ) : ?>
					<div class="ecomus-brands-filters__items active" data-filter="<?php echo esc_attr( $key ); ?>">
						<div class="ecomus-brands-filters__inner em-flex">
							<div class="ecomus-brands-filters__heading"><?php echo esc_html( $key ); ?></div>
							<div class="ecomus-brands-filters__content">
								<?php echo implode( '', $outputs[$key] ); ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
