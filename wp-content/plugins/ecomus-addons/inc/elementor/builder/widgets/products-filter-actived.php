<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Ecomus\Addons\Elementor\Builder\Current_Query_Renderer;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Products_Filter_Actived extends Widget_Base {

	public function get_name() {
		return 'ecomus-products-filter-actived';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Products Filter Actived', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-filter';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'archive', 'product', 'filter', 'actived' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-archive-product' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
            'content_style',
            [
                'label' => __( 'Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
			'content_gap',
			[
				'label' => esc_html__( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__active-filters' => 'gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .catalog-toolbar__active-filters:not(.hidden)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-toolbar__active-filters:not(.hidden)' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'count_style',
			[
				'label' => esc_html__( 'Count', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'count_typography',
				'selector' => '{{WRAPPER}} .catalog-toolbar__result-count',
			]
		);

		$this->add_control(
			'count_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__result-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'count_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__result-count' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'count_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__result-count' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'filters_style',
            [
                'label' => __( 'Filters Actived', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
			'filters_gap',
			[
				'label' => esc_html__( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'filter_items_style',
			[
				'label' => esc_html__( 'Filters', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filters_typography',
				'selector' => '{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered:not(:last-child)',
			]
		);

		$this->add_control(
			'filters_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered:not(:last-child)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filters_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered:not(:last-child)' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'filters_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered:not(:last-child)' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'filters_remove_style',
			[
				'label' => esc_html__( 'Remove All', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filters_remove_typography',
				'selector' => '{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all',
			]
		);

		$this->add_control(
			'filters_remove_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filters_remove_hover_color',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filters_remove_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filters_remove_hover_background_color',
			[
				'label'     => __( 'Hover Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'filters_remove_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'filters_remove_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .catalog-toolbar__filters-actived .remove-filtered-all' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			?>
			<div class="catalog-toolbar__active-filters actived">
				<div class="catalog-toolbar__result-count">
					<span class="count">6</span><?php esc_html_e( 'Products Found', 'ecomus' ); ?>
				</div>
				<div class="catalog-toolbar__filters-actived active" data-clear-text="Remove all">
					<a href="#" class="remove-filtered" data-name="filter_color" data-value="color" rel="nofollow" aria-label="Remove filter"><?php esc_html_e( 'Color', 'ecomus' ); ?></a>
					<a href="#" class="remove-filtered remove-filtered-all"><?php esc_html_e( 'Remove all', 'ecomus' ); ?></a>
				</div>
			</div>
			<?php
			return;
		} else {
			global $wp_query;
			$shortcode = new Current_Query_Renderer( $wp_query->query, 'current_query' );
			$total = $shortcode->get_query_results()->total;
		}

		$filter_class = ! isset( $_GET['filter'] ) ? ' hidden' : '';
		$text = $total > 1 ? esc_html__( 'Products Found', 'ecomus' ) : esc_html__( 'Product Found', 'ecomus' );

		echo '<div class="catalog-toolbar__active-filters'. esc_attr( $filter_class ) .'">';
			echo '<div class="catalog-toolbar__result-count"><span class="count">'. $total .'</span>'. $text .'</div>';
			echo '<div class="catalog-toolbar__filters-actived" data-clear-text="'. esc_html__( 'Remove all', 'ecomus' ).'"></div>';
		echo '</div>';
	}
}
