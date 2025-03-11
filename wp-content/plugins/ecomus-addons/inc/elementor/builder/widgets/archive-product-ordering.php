<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Archive_Product_Ordering extends Widget_Base {

	public function get_name() {
		return 'ecomus-archive-product-ordering';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Archive Ordering', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-sort-amount-desc';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'archive', 'product', 'ordering' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-archive-product' ];
	}

	public function get_style_depends() {
		return [ 'select2' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
            'content',
            [
                'label' => __( 'Content', 'ecomus-addons' ),
            ]
        );

		$this->add_responsive_control(
			'alignment',
			[
				'label'       => esc_html__( 'Alignment', 'ecomus-addons' ),
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
					'{{WRAPPER}} .catalog-toolbar__item' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'mobile_content',
			[
				'label' => esc_html__( 'Mobile', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'mobile_text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Sort', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'desktop_style',
            [
                'label' => __( 'Desktop Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'desktop_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ordering select' => '--em-input-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_border_width',
			[
				'label' => esc_html__( 'Border Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ordering select' => '--em-input-border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desktop_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ordering select' => '--em-input-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-ordering select' => '--em-input-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-ordering select' => '--em-input-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desktop_hover_heading',
			[
				'label'     => esc_html__( 'Hover', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desktop_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ordering select:hover' => '--em-input-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desktop_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-ordering select' => '--em-input-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'mobile_style',
            [
                'label' => __( 'Mobile Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'mobile_button_style',
			[
				'label'   => __( 'Style', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'outline',
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
			'mobile_button_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-toolbar__orderby-button' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mobile_button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-toolbar__orderby-button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mobile_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'mobile_button_typography',
				'selector' => '{{WRAPPER}} .catalog-toolbar__orderby-button',
			]
		);

		$this->add_responsive_control(
			'mobile_button_border_width',
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
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mobile_button_style' => [ 'outline-dark', 'outline' ],
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
			'mobile_button_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_button_text_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_button_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-border-color: {{VALUE}};',
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
			'mobile_button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_button_hover_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__orderby-button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
				'condition' => [
					'mobile_button_style' => ['']
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$icon = '';
		if( ! empty( $settings['mobile_icon']['value'] ) ) {
			$icon = '<span class="ecomus-svg-icon ecomus-svg-icon--arrow-bottom">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['mobile_icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
		} else {
			$icon = \Ecomus\Addons\Helper::get_svg( 'arrow-bottom' );
		}

		$text = '';
		if( ! empty( $settings['mobile_text'] ) ) {
			$text = esc_html( $settings['mobile_text'] );
		} else {
			$text = esc_html__('Sort', 'ecomus');
		}

		if( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			?>
			<div class="catalog-toolbar__item">
				<select name="orderby" class="orderby hidden-xs" aria-label="Shop order">
					<option value="menu_order" selected="selected"><?php echo __( 'Default sorting', 'woocommerce' ); ?></option>
					<option value="popularity"><?php echo __( 'Sort by popularity', 'woocommerce' ); ?></option>
					<option value="rating"><?php echo __( 'Sort by average rating', 'woocommerce' ); ?></option>
					<option value="date"><?php echo __( 'Sort by latest', 'woocommerce' ); ?></option>
					<option value="price"><?php echo __( 'Sort by price: low to high', 'woocommerce' ); ?></option>
					<option value="price-desc"><?php echo __( 'Sort by price: high to low', 'woocommerce' ); ?></option>
				</select>

				<?php echo sprintf( '<button class="em-button-%s catalog-toolbar__orderby-button hidden-sm hidden-md hidden-lg" data-toggle="popover" data-target="mobile-orderby-popover">%s %s</button>',
								esc_attr( $settings['mobile_button_style'] ),
								$text,
								$icon
							);
							?>
			</div>
			<?php
			return;
		}

		\Ecomus\Theme::set_prop( 'popovers', 'mobile-orderby' );

		echo '<div class="catalog-toolbar__item">';
			echo '<div class="hidden-xs">';
				woocommerce_catalog_ordering();
			echo '</div>';
			echo '<button class="em-button-'. esc_attr( $settings['mobile_button_style'] ) .' catalog-toolbar__orderby-button hidden-sm hidden-md hidden-lg" data-toggle="popover" data-target="mobile-orderby-popover">' . $text . $icon .'</button>';
		echo '</div>';
	}
}
