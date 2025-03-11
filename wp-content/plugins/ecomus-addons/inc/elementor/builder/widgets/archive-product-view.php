<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Ecomus\Addons\Elementor\Builder\Current_Query_Renderer;
use Ecomus\Addons\Elementor\Builder\Products_Renderer;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Archive_Product_View extends Widget_Base {

	public function get_name() {
		return 'ecomus-archive-product-view';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Archive View', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-preview-thin';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'archive', 'product', 'view' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-archive-product' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-product-elementor-widgets'
		];
	}

	protected function register_controls() {
        $this->start_controls_section(
            'view_content',
            [
                'label' => __( 'View', 'ecomus-addons' ),
            ]
        );

		$this->add_control(
			'views',
			[
				'label' => esc_html__( 'Show Views', 'ecomus-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'1'       => esc_html__( 'List', 'ecomus' ),
					'2'       => esc_html__( 'Grid 2 Columns', 'ecomus' ),
					'3'       => esc_html__( 'Grid 3 Columns', 'ecomus' ),
					'4'       => esc_html__( 'Grid 4 Columns', 'ecomus' ),
					'5'       => esc_html__( 'Grid 5 Columns', 'ecomus' ),
					'6'       => esc_html__( 'Grid 6 Columns', 'ecomus' ),
				],
				'default' => [ '1', '2', '3', '4', '5' ],
			]
		);

		$this->add_control(
			'views_default',
			[
				'label' => esc_html__( 'Show Active View Default', 'ecomus-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'options' => [
					'1'       => esc_html__( 'List', 'ecomus' ),
					'2'       => esc_html__( 'Grid 2 Columns', 'ecomus' ),
					'3'       => esc_html__( 'Grid 3 Columns', 'ecomus' ),
					'4'       => esc_html__( 'Grid 4 Columns', 'ecomus' ),
					'5'       => esc_html__( 'Grid 5 Columns', 'ecomus' ),
					'6'       => esc_html__( 'Grid 6 Columns', 'ecomus' ),
				],
				'default' => '4',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'view_style',
            [
                'label' => __( 'View', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .ecomus-toolbar-view' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => esc_html__( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-toolbar-view' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-toolbar-view a' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-toolbar-view a.current, {{WRAPPER}} .ecomus-toolbar-view a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		global $wp;

		if( isset( $_GET['column'] ) && ! empty( $_GET['column'] ) && ! \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$default = $_GET['column'] == '1' ? 'list' : 'grid-' . $_GET['column'];
		} else {
			if( isset( $_COOKIE['catalog_view'] ) && ! \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
				$default = $_COOKIE['catalog_view'];
			}  else {
				$default_column = apply_filters( 'ecomus_catalog_default_columns', isset( $settings['views_default'] ) ? $settings['views_default'] : get_option( 'woocommerce_catalog_columns', 4 ) );
				$default = $default_column == '1' ? 'list' : 'grid-' . $default_column;
			}
		}
		$class = $mobile_class = $tablet_class = '';

		foreach( $settings['views'] as $column ) {
			if( $column == '1' ) {
				$view = 'list';
				$icon = 'list';
				$class = 'list';
			} else {
				$view = 'grid';
				$icon = 'grid-' . $column;
				$class = 'grid grid-' . $column;
			}
			$class .= $default == $icon ? ' current' : '';
			$tablet_class = $view == 'grid' && $column != '2' && empty( $tablet_class ) ? 'grid-' . $column : $tablet_class;
			$mobile_class = $view == 'grid' && empty( $mobile_class ) ? 'grid-' . $column : $mobile_class;

			$class .= $tablet_class == 'grid-' . $column ? ' tablet-active' : '';
			$class .= $mobile_class == 'grid-' . $column ? ' mobile-active' : '';

			$link_url = array(
				'column' => $column
			);

			if( isset( $_GET ) ) {
				$link_url = wp_parse_args(
					$link_url,
					$_GET
				);
			}

			$current = home_url( $wp->request );

			$current_url = add_query_arg(
				$link_url,
				substr( $current, 0, strpos( $current, 'page/') )
			);

			$output_type[] = sprintf(
				'<a href="%s" class="%s" data-column="%s">%s</a>',
				esc_url($current_url),
				esc_attr( $class ),
				esc_attr( $column ),
				\Ecomus\Addons\Helper::get_svg( $icon ),
			);
		}

		echo sprintf(
			'<div id="ecomus-toolbar-view" class="ecomus-toolbar-view">%s</div>',
			implode( $output_type )
		);
	}
}
