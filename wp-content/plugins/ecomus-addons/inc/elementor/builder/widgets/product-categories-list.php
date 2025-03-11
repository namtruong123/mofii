<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Categories_List extends Widget_Base {
	public function get_name() {
		return 'ecomus-product-categories-list';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Categories List', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-editor-list-ul';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'categories', 'product', 'list' ];
	}

	/**
	 * Get HTML wrapper class.
	 *
	 * Retrieve the widget container class. Can be used to override the
	 * container class for specific widgets.
	 *
	 * @since 2.0.9
	 * @access protected
	 */
	protected function get_html_wrapper_class() {
		return 'elementor-widget-' . $this->get_name() . ' widget_product_categories';
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_settings',
			[ 
				'label' => __( 'Settings', 'ecomus-addons' ) 
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__( 'OrderBy', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'order' => esc_html__( 'Category order', 'ecomus-addons' ),
					'name'  => esc_html__( 'Name', 'ecomus-addons' ),
				],
				'default'     => 'name',
			]
		);

		$this->add_control(
			'count',
			[
				'label'        => esc_html__( 'Show product counts', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => true,
				'return_value' => true
			]
		);

		$this->add_control(
			'hierarchical',
			[
				'label'        => esc_html__( 'Show hierarchy', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => true
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label'        => esc_html__( 'Hide empty categories', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => true,
				'return_value' => true
			]
		);

		$this->add_control(
			'show_children_only',
			[
				'label'        => esc_html__( 'Only show children of current category', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => true
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		global $wp_query;

		$list_args = array(
			'show_count'   => $settings['count'],
			'hierarchical' => $settings['hierarchical'],
			'taxonomy'     => 'product_cat',
			'hide_empty'   => $settings['hide_empty'],
			'menu_order'   => false,
		);

		if ( 'order' === $settings['orderby'] ) {
			$list_args['orderby']  = 'meta_value_num';
			$list_args['meta_key'] = 'order';
		}

		$current_cat   = false;
		$cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {
			$current_cat   = $wp_query->queried_object;
			$cat_ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );

		} elseif ( is_singular( 'product' ) ) {
			$terms = wc_get_product_terms(
				get_the_ID(),
				'product_cat',
				apply_filters(
					'woocommerce_product_categories_widget_product_terms_args',
					array(
						'orderby' => 'parent',
						'order'   => 'DESC',
					)
				)
			);

			if ( $terms ) {
				$main_term           = apply_filters( 'woocommerce_product_categories_widget_main_term', $terms[0], $terms );
				$current_cat   = $main_term;
				$cat_ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
			}
		}

		if ( $settings['show_children_only'] && $current_cat ) {
			if ( $settings['hierarchical'] ) {
				$include = array_merge(
					$cat_ancestors,
					array( $current_cat->term_id ),
					get_terms(
						'product_cat',
						array(
							'fields'       => 'ids',
							'parent'       => 0,
							'hierarchical' => true,
							'hide_empty'   => false,
						)
					),
					get_terms(
						'product_cat',
						array(
							'fields'       => 'ids',
							'parent'       => $current_cat->term_id,
							'hierarchical' => true,
							'hide_empty'   => false,
						)
					)
				);
				// Gather siblings of ancestors.
				if ( $cat_ancestors ) {
					foreach ( $cat_ancestors as $ancestor ) {
						$include = array_merge(
							$include,
							get_terms(
								'product_cat',
								array(
									'fields'       => 'ids',
									'parent'       => $ancestor,
									'hierarchical' => false,
									'hide_empty'   => false,
								)
							)
						);
					}
				}
			} else {
				// Direct children.
				$include = get_terms(
					'product_cat',
					array(
						'fields'       => 'ids',
						'parent'       => $current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false,
					)
				);
			}

			$list_args['include']     = implode( ',', $include );

			if ( empty( $include ) ) {
				return;
			}
		} elseif ( $settings['show_children_only'] ) {
			$list_args['depth']            = true;
			$list_args['child_of']         = false;
			$list_args['hierarchical']     = true;
		}

		include_once( WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php' );
		$list_args['walker']                     = new \WC_Product_Cat_List_Walker();
		$list_args['title_li']                   = '';
		$list_args['show_option_none']           = __( 'No product categories exist.', 'ecomus-addons' );
		$list_args['current_category']           = ( $current_cat ) ? $current_cat->term_id : '';
		$list_args['current_category_ancestors'] = $cat_ancestors;

		echo '<ul class="product-categories">';
			wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );
		echo '</ul>';
	}
}