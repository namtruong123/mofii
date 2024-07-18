<?php

if ( function_exists('vc_map') && class_exists('WPBakeryShortCode') ) {

    function yozi_get_post_categories() {
        $return = array( esc_html__(' --- Choose a Category --- ', 'yozi') => '' );

        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'taxonomy' => 'category'
        );

        $categories = get_categories( $args );
        yozi_get_post_category_childs( $categories, 0, 0, $return );

        return $return;
    }

    function yozi_get_post_category_childs( $categories, $id_parent, $level, &$dropdown ) {
        foreach ( $categories as $key => $category ) {
            if ( $category->category_parent == $id_parent ) {
                $dropdown = array_merge( $dropdown, array( str_repeat( "- ", $level ) . $category->name => $category->slug ) );
                unset($categories[$key]);
                yozi_get_post_category_childs( $categories, $category->term_id, $level + 1, $dropdown );
            }
        }
	}

	function yozi_load_post2_element() {
		$layouts = array(
			esc_html__('Grid', 'yozi') => 'grid',
			esc_html__('List', 'yozi') => 'list',
			esc_html__('Carousel', 'yozi') => 'carousel',
		);
		$layouts_item = array(
			esc_html__('Item 1', 'yozi') => 'inner-grid-v2',
			esc_html__('Item 2', 'yozi') => 'inner-grid-v3',
		);
		$columns = array(1,2,3,4,6);
		$categories = array();
		if ( is_admin() ) {
			$categories = yozi_get_post_categories();
		}
		vc_map( array(
			'name' => esc_html__( 'Apus Grid Posts', 'yozi' ),
			'base' => 'apus_gridposts',
			'icon' => 'icon-wpb-news-12',
			"category" => esc_html__('Apus Post', 'yozi'),
			'description' => esc_html__( 'Create Post having blog styles', 'yozi' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'yozi' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'yozi' ),
					"admin_label" => true
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Category','yozi'),
	                "param_name" => 'category',
	                "value" => $categories
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Order By','yozi'),
	                "param_name" => 'orderby',
	                "value" => array(
	                	esc_html__('Date', 'yozi') => 'date',
	                	esc_html__('ID', 'yozi') => 'ID',
	                	esc_html__('Author', 'yozi') => 'author',
	                	esc_html__('Title', 'yozi') => 'title',
	                	esc_html__('Modified', 'yozi') => 'modified',
	                	esc_html__('Parent', 'yozi') => 'parent',
	                	esc_html__('Comment count', 'yozi') => 'comment_count',
	                	esc_html__('Menu order', 'yozi') => 'menu_order',
	                	esc_html__('Random', 'yozi') => 'rand',
	                )
	            ),
	            array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Sort order','yozi'),
	                "param_name" => 'order',
	                "value" => array(
	                	esc_html__('Descending', 'yozi') => 'DESC',
	                	esc_html__('Ascending', 'yozi') => 'ASC',
	                )
	            ),
	            array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Limit', 'yozi' ),
					'param_name' => 'posts_per_page',
					'description' => esc_html__( 'Enter limit posts.', 'yozi' ),
					'std' => 4,
					"admin_label" => true
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show Pagination?', 'yozi' ),
					'param_name' => 'show_pagination',
					'description' => esc_html__( 'Enables to show paginations to next new page.', 'yozi' ),
					'value' => array( esc_html__( 'Yes, to show pagination', 'yozi' ) => 'yes' )
				),
				array(
	                "type" => "dropdown",
	                "heading" => esc_html__('Grid Columns','yozi'),
	                "param_name" => 'grid_columns',
	                "value" => $columns
	            ),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Layout Type", 'yozi'),
					"param_name" => "layout_type",
					"value" => $layouts
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Layout Item", 'yozi'),
					"param_name" => "layout_item",
					"value" => $layouts_item
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Thumbnail size', 'yozi' ),
					'param_name' => 'thumbsize',
					'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'yozi' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'yozi' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yozi' )
				)
			)
		) );
	}

	add_action( 'vc_after_set_mode', 'yozi_load_post2_element', 99 );

	class WPBakeryShortCode_apus_gridposts extends WPBakeryShortCode {}
}