<?php
/**
 * Widget Image
 */

namespace Ecomus\Addons\Modules\Mega_Menu\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Taxonomy List widget class
 */
class Taxonomy_List extends Widget_Base {

	/**
	 * Set the widget name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'taxonomy-list';
	}

	/**
	 * Set the widget label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Taxonomy List', 'ecomus-addons' );
	}

	/**
	 * Default widget options
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'taxonomy'  	=> 'product_cat',
			'parent_cat'  	=> '',
			'limit'  		=> '',
			'cat_order'     => '',
			'cat_orderby'   => '',
			'offset'        => '',
			'hide_empty'    => '',
		);
	}

	/**
	 * Render widget content
	 */
	public function render() {
		$data = $this->get_data();

		$args = array(
			'taxonomy' 		=> $data['taxonomy'],
			'number' 		=> $data['limit'],
			'child_of' 		=> $data['parent_cat'],
		);

		$args['order'] 		= $data['cat_order'] ? $data['cat_order'] : 'asc';
		$args['offset'] 	= $data['offset'] ? $data['offset'] : '';
		$args['hide_empty'] = $data['hide_empty'] ? true : false;

		if ( $data['cat_orderby'] ) {
			$args['orderby'] = $data['cat_orderby'];

			if ( $data['cat_orderby'] == 'count' ) {
				$args['order'] = 'desc';
			}
		} else {
			$args['orderby'] = 'title';
		}

		$args = apply_filters( 'ecomus_addons_menu_widget_taxonomy_list_args', $args );

		$terms = get_terms( $args );

		if ( empty( $terms ) ) {
			return;
		}

		$classes = $data['classes'] ? ' ' . $data['classes'] : '';

		echo '<ul class="menu-taxonomy-list-widget'. esc_attr( $classes ) .'">';
		$parent_id = ! empty( $data['parent_cat'] ) ? (int) $data['parent_cat'] : 0;
		foreach ( $terms as $term ) {
			if( $term->parent == $parent_id ) {
				echo '<li class="menu-item--widget menu-taxonomy-list-widget__item">';
				echo '<a href="'. get_term_link( $term->slug, $data['taxonomy'] ) .'">'. esc_html( $term->name ) .'</a>';
				echo '</li>';

				foreach( $terms as $subcategory ) {
					if($subcategory->parent == $term->term_id) {
						echo '<li class="menu-item--widget menu-taxonomy-list-widget__item menu-taxonomy-list-widget__subitem">';
						echo '<a href="'. get_term_link( $subcategory->slug, $data['taxonomy'] ) .'">'. esc_html( $subcategory->name ) .'</a>';
						echo '</li>';
					}
				}
			}
		}

		echo '</ul>';
	}

	/**
	 * Widget setting fields.
	 */
	public function add_controls() {
		$this->add_control( array(
			'type' => 'select',
			'name' => 'taxonomy',
			'label' => esc_html__( 'Taxonomy', 'ecomus-addons' ),
			'class' => 'ecomus-menu-item-taxonomy',
			'options' => self::get_taxonomy(),
		) );

		$this->add_control( array(
			'type' 	=> 'select',
			'name' 	=> 'parent_cat',
			'label' => esc_html__( 'Parent Category', 'ecomus-addons' ),
			'class' => 'ecomus-menu-item-taxonomy-category',
			'options' => self::get_categories(),
		) );

		$this->add_control( array(
			'type' => 'select',
			'name' => 'cat_order',
			'label' => esc_html__( 'Order', 'ecomus-addons' ),
			'options' => array(
				'0'  	=> esc_html__( 'Default', 'ecomus-addons' ),
				'asc'  	=> esc_html__( 'Ascending', 'ecomus-addons' ),
				'desc' 	=> esc_html__( 'Descending', 'ecomus-addons' ),
			),
		) );

		$this->add_control( array(
			'type' => 'select',
			'name' => 'cat_orderby',
			'label' => esc_html__( 'Order By', 'ecomus-addons' ),
			'options' => array(
				'0'  			=> esc_html__( 'Default', 'ecomus-addons' ),
				'id'  			=> esc_html__( 'ID', 'ecomus-addons' ),
				'title' 		=> esc_html__( 'Title', 'ecomus-addons' ),
				'menu_order' 	=> esc_html__( 'Menu Order', 'ecomus-addons' ),
				'count' 		=> esc_html__( 'Product Counts', 'ecomus-addons' ),
			),
		) );

		$this->add_control( array(
			'type' => 'text',
			'name' => 'limit',
			'label' => esc_html__( 'Limit', 'ecomus-addons' ),
		) );

		$this->add_control( array(
			'type' => 'text',
			'name' => 'offset',
			'label' => esc_html__( 'Offset', 'ecomus-addons' ),
		) );

		$this->add_control( array(
			'type' => 'checkbox',
			'name' => 'hide_empty',
			'options' => array(
				'1'  => esc_html__( 'Hide empty categories', 'ecomus-addons' ),
			),
		) );
	}

	/**
	 * Get categories
	 *
	 * @return option
	 */
	public function get_categories() {
		$terms = \Ecomus\Addons\Helper::get_terms_hierarchy( 'product_cat', '&#8212;', false );

		if ( empty( $terms ) ) {
			return;
		}

		$options = wp_list_pluck( $terms, 'name', 'term_id' );
		$options = array( '' => esc_html__( 'Choose a category', 'ecomus-addons' ) ) + $options;

		return $options;
	}

	/**
	 * Get categories
	 *
	 * @return option
	 */
	public function get_taxonomy() {
		$options = array( 'product_cat' => esc_html__( 'Product Category', 'ecomus-addons' ) );

		if ( get_option( 'ecomus_product_brand', 'yes' ) == 'yes' ) {
			$taxonomy_brand = array( 'product_brand' => esc_html__( 'Product Brand', 'ecomus-addons' ) );
			$options = $options + $taxonomy_brand;
		}

		return $options;
	}
}