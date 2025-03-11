<?php
namespace Ecomus\Addons\Elementor\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Current_Query_Renderer extends Base_Products_Renderer {

	private $settings = [];

	public function __construct( $settings = [], $type = 'products' ) {
		$columns_default = isset( $settings['shop_columns'] ) ? $settings['shop_columns'] : get_option('woocommerce_catalog_columns', 4);
		$columns = isset( $settings['shop_columns'] ) ? $settings['shop_columns'] : get_option('woocommerce_catalog_columns', 4);
		$columns = isset( $settings['show_default_view'] ) && $settings['show_default_view'] == 'list' ? 1 : $columns;

		if ( ! \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$columns = isset( $_COOKIE['catalog_view'] ) ? intval( preg_replace("/[^0-9]/", '', $_COOKIE['catalog_view']) ) : $columns;
			$columns = $columns == 0 ? 1 : $columns;
		}
		
		$columns = isset( $_GET['column'] ) ? $_GET['column'] : $columns;
		$rows = isset( $settings['shop_rows'] ) ? $settings['shop_rows'] : get_option('woocommerce_catalog_rows', 4);
		
		$this->settings = $settings;
		$this->type = $type;
		$this->attributes = $this->parse_attributes( [
			'columns'  => $columns,
			'rows'     => $rows,
			'limit'	   => intval( $columns ) == 1 ? ( intval( $columns_default ) * intval( $rows ) ) : ( intval( $columns ) * intval( $rows ) ),
			'paginate' => isset( $settings['paginate'] ) ? $settings['paginate'] : true,
			'cache'    => false,
		] );
		$this->query_args = $this->parse_query_args();
	}

   	public function get_query_results() {
		$settings = &$this->settings;

		$this->query_args = $this->merge_queries( $this->query_args, $this->get_queries_by_applied_filters() );

		if( isset( $_GET['product_status'] ) && $_GET['product_status'] == 'on_sale' ) {
			$this->query_args = $this->filter_query_to_only_include_ids( $this->query_args, wc_get_product_ids_on_sale() );
		}
		
		$query = new \WP_Query( $this->query_args );

		$paginated = ! $query->get( 'no_found_rows' );

		$results = (object) array(
			'ids'          => wp_parse_id_list( $query->posts ),
			'total'        => $paginated ? (int) $query->found_posts : count( $query->posts ),
			'total_pages'  => $paginated ? (int) $query->max_num_pages : 1,
			'per_page'     => ! empty( $this->attributes['limit'] ) ? intval( $this->attributes['limit'] ) : $query->per_page,
			'current_page' => $paginated ? (int) max( 1, $query->get( 'paged', 1 ) ) : 1,
		);

		/**
		* Filter shortcode products query results.
		*
		* @since 4.0.0
		* @param stdClass $results Query results.
		* @param WC_Shortcode_Products $this WC_Shortcode_Products instance.
		*/
		return apply_filters( 'woocommerce_shortcode_products_query_results', $results, $this );
   	}

	protected function parse_query_args() {
		$settings = &$this->settings;

		if ( ! is_page( wc_get_page_id( 'shop' ) ) ) {
			$query_args = $GLOBALS['wp_query']->query_vars;
		}

		if( isset( $_GET['products_group'] ) ) {
			if ( method_exists( $this, "set_{$_GET["products_group"]}_products_query_args" ) ) {
				$this->{"set_{$_GET["products_group"]}_products_query_args"}( $query_args );
			} else {
				$this->{"set_recent_products_query_args"}( $query_args );
			}
		}

		$query_args['posts_per_page'] = intval( $this->attributes['limit'] );

		$query_args['orderby'] = empty( $_GET['orderby'] ) ? $this->attributes['orderby'] : wc_clean( wp_unslash( $_GET['orderby'] ) );
		$orderby_value         = explode( '-', $query_args['orderby'] );
		$orderby               = esc_attr( $orderby_value[0] );
		$order                 = ! empty( $orderby_value[1] ) ? $orderby_value[1] : strtoupper( $this->attributes['order'] );
		$query_args['orderby'] = $orderby;
		$query_args['order']   = $order;
		$ordering_args         = WC()->query->get_catalog_ordering_args( $query_args['orderby'], $query_args['order'] );
		$query_args['orderby'] = $ordering_args['orderby'];
		$query_args['order']   = $ordering_args['order'];

		add_action( "woocommerce_shortcode_before_{$this->type}_loop", function () {
			wc_set_loop_prop( 'is_shortcode', false );
		} );

		if ( isset( $settings['paginate'] ) && 'yes' === $settings['paginate'] ) {
			$page = get_query_var( 'paged', 1 );

			if ( 1 < $page ) {
				$query_args['paged'] = $page;
			}
		}

		remove_all_actions( 'woocommerce_before_shop_loop' );

		// Always query only IDs.
		$query_args['fields'] = 'ids';
		
		return $query_args;
	}

	/**
	 * Return queries that are generated by query args.
	 *
	 * @return array
	 */
	public function get_queries_by_applied_filters() {
		return array(
			'price_filter'        => $this->get_filter_by_price_query(),
			'attributes_filter'   => $this->get_filter_by_attributes_query(),
			'stock_status_filter' => $this->get_filter_by_stock_status_query(),
			'rating_filter'       => $this->get_filter_by_rating_query(),
		);
	}

	/**
	 * Merge in the first parameter the keys "post_in", "meta_query" and "tax_query" of the second parameter.
	 *
	 * @param array[] ...$queries Query arrays to be merged.
	 * @return array
	 */
	public function merge_queries( ...$queries ) {
		$merged_query = array_reduce(
			$queries,
			function( $acc, $query ) {
				if ( ! is_array( $query ) ) {
					return $acc;
				}
				// If the $query doesn't contain any valid query keys, we unpack/spread it then merge.
				if ( empty( array_intersect( $this->get_valid_query_vars(), array_keys( $query ) ) ) ) {
					return $this->merge_queries( $acc, ...array_values( $query ) );
				}
				return $this->array_merge_recursive_replace_non_array_properties( $acc, $query );
			},
			array()
		);

		/**
		 * If there are duplicated items in post__in, it means that we need to
		 * use the intersection of the results, which in this case, are the
		 * duplicated items.
		 */
		if (
			! empty( $merged_query['post__in'] ) &&
			is_array( $merged_query['post__in'] ) &&
			count( $merged_query['post__in'] ) > count( array_unique( $merged_query['post__in'] ) )
		) {
			$merged_query['post__in'] = array_unique(
				array_diff(
					$merged_query['post__in'],
					array_unique( $merged_query['post__in'] )
				)
			);
		}

		return $merged_query;
	}

	/**
	 * Return or initialize $valid_query_vars.
	 *
	 * @return array
	 */
	private function get_valid_query_vars() {

		$valid_query_vars       = array_keys( ( new \WP_Query() )->fill_query_vars( array() ) );
		$valid_query_vars = array_merge(
			$valid_query_vars,
			// fill_query_vars doesn't include these vars so we need to add them manually.
			array(
				'date_query',
				'exact',
				'ignore_sticky_posts',
				'lazy_load_term_meta',
				'meta_compare_key',
				'meta_compare',
				'meta_query',
				'meta_type_key',
				'meta_type',
				'nopaging',
				'offset',
				'order',
				'orderby',
				'page',
				'post_type',
				'posts_per_page',
				'suppress_filters',
				'tax_query',
			)
		);

		return $valid_query_vars;
	}

	/**
	 * Merge two array recursively but replace the non-array values instead of
	 * merging them. The merging strategy:
	 *
	 * - If keys from merge array doesn't exist in the base array, create them.
	 * - For array items with numeric keys, we merge them as normal.
	 * - For array items with string keys:
	 *
	 *   - If the value isn't array, we'll use the value comming from the merge array.
	 *     $base = ['orderby' => 'date']
	 *     $new  = ['orderby' => 'meta_value_num']
	 *     Result: ['orderby' => 'meta_value_num']
	 *
	 *   - If the value is array, we'll use recursion to merge each key.
	 *     $base = ['meta_query' => [
	 *       [
	 *         'key'     => '_stock_status',
	 *         'compare' => 'IN'
	 *         'value'   =>  ['instock', 'onbackorder']
	 *       ]
	 *     ]]
	 *     $new  = ['meta_query' => [
	 *       [
	 *         'relation' => 'AND',
	 *         [...<max_price_query>],
	 *         [...<min_price_query>],
	 *       ]
	 *     ]]
	 *     Result: ['meta_query' => [
	 *       [
	 *         'key'     => '_stock_status',
	 *         'compare' => 'IN'
	 *         'value'   =>  ['instock', 'onbackorder']
	 *       ],
	 *       [
	 *         'relation' => 'AND',
	 *         [...<max_price_query>],
	 *         [...<min_price_query>],
	 *       ]
	 *     ]]
	 *
	 *     $base = ['post__in' => [1, 2, 3, 4, 5]]
	 *     $new  = ['post__in' => [3, 4, 5, 6, 7]]
	 *     Result: ['post__in' => [1, 2, 3, 4, 5, 3, 4, 5, 6, 7]]
	 *
	 * @param array $base First array.
	 * @param array $new  Second array.
	 */
	private function array_merge_recursive_replace_non_array_properties( $base, $new ) {
		foreach ( $new as $key => $value ) {
			if ( is_numeric( $key ) ) {
				$base[] = $value;
			} else {
				if ( is_array( $value ) ) {
					if ( ! isset( $base[ $key ] ) ) {
						$base[ $key ] = array();
					}
					$base[ $key ] = $this->array_merge_recursive_replace_non_array_properties( $base[ $key ], $value );
				} else {
					$base[ $key ] = $value;
				}
			}
		}

		return $base;
	}

	/**
	 * Return a query that filters products by price.
	 *
	 * @return array
	 */
	private function get_filter_by_price_query() {
		$min_price = get_query_var( \Automattic\WooCommerce\Blocks\BlockTypes\PriceFilter::MIN_PRICE_QUERY_VAR );
		$max_price = get_query_var( \Automattic\WooCommerce\Blocks\BlockTypes\PriceFilter::MAX_PRICE_QUERY_VAR );

		$max_price_query = empty( $max_price ) ? array() : [
			'key'     => '_price',
			'value'   => $max_price,
			'compare' => '<=',
			'type'    => 'numeric',
		];

		$min_price_query = empty( $min_price ) ? array() : [
			'key'     => '_price',
			'value'   => $min_price,
			'compare' => '>=',
			'type'    => 'numeric',
		];

		if ( empty( $min_price_query ) && empty( $max_price_query ) ) {
			return array();
		}

		return array(
			'meta_query' => array(
				array(
					'relation' => 'AND',
					$max_price_query,
					$min_price_query,
				),
			),
		);
	}

	/**
	 * Return a query that filters products by attributes.
	 *
	 * @return array
	 */
	public function get_filter_by_attributes_query() {
		$attributes_filter_query_args = $this->get_filter_by_attributes_query_vars();

		$queries = array_reduce(
			$attributes_filter_query_args,
			function( $acc, $query_args ) {
				$attribute_name       = $query_args['filter'];
				$attribute_query_type = $query_args['query_type'];

				$attribute_value = get_query_var( $attribute_name );
				$attribute_query = get_query_var( $attribute_query_type );

				if ( empty( $attribute_value ) ) {
					return $acc;
				}

				// It is necessary explode the value because $attribute_value can be a string with multiple values (e.g. "red,blue").
				$attribute_value = explode( ',', $attribute_value );

				$acc[] = array(
					'taxonomy' => str_replace( \Automattic\WooCommerce\Blocks\BlockTypes\AttributeFilter::FILTER_QUERY_VAR_PREFIX, 'pa_', $attribute_name ),
					'field'    => 'slug',
					'terms'    => $attribute_value,
					'operator' => 'and' === $attribute_query ? 'AND' : 'IN',
				);

				return $acc;
			},
			array()
		);

		if ( empty( $queries ) ) {
			return array();
		}

		return array(
			'tax_query' => array(
				array(
					'relation' => 'AND',
					$queries,
				),
			),
		);
	}

	public function get_filter_by_attributes_query_vars() {
		$attributes_filter_query_args = array_reduce(
			wc_get_attribute_taxonomies(),
			function( $acc, $attribute ) {
				$acc[ $attribute->attribute_name ] = array(
					'filter'     => \Automattic\WooCommerce\Blocks\BlockTypes\AttributeFilter::FILTER_QUERY_VAR_PREFIX . $attribute->attribute_name,
					'query_type' => \Automattic\WooCommerce\Blocks\BlockTypes\AttributeFilter::QUERY_TYPE_QUERY_VAR_PREFIX . $attribute->attribute_name,
				);
				return $acc;
			},
			array()
		);

		return $attributes_filter_query_args;
	}

	/**
	 * Return a query that filters products by stock status.
	 *
	 * @return array
	 */
	public function get_filter_by_stock_status_query() {
		if( ! isset( $_GET['product_status'] ) ) {
			return array();
		}

		if ( ! in_array( $_GET['product_status'], array_keys( $this->wc_get_product_stock_status_options() ) ) ) {
			return array();
		}

		if( $_GET['product_status'] == 'on_sale' ) {
			return array();
		}

		return array(
			'meta_query' => array(
				array(
					'key'      => '_stock_status',
					'value'    => $_GET['product_status'],
					'operator' => 'IN',
				),
			),
		);
	}

	public function wc_get_product_stock_status_options() {
		return apply_filters(
			'woocommerce_product_stock_status_options',
			array(
				'instock'     => __( 'In stock', 'woocommerce' ),
				'outofstock'  => __( 'Out of stock', 'woocommerce' ),
				'onbackorder' => __( 'On backorder', 'woocommerce' ),
			)
		);
	}

	/**
	 * Return a query that filters products by rating.
	 *
	 * @return array
	 */
	public function get_filter_by_rating_query() {
		$filter_rating_values = get_query_var( \Automattic\WooCommerce\Blocks\BlockTypes\RatingFilter::RATING_QUERY_VAR );
		if ( empty( $filter_rating_values ) ) {
			return array();
		}

		$parsed_filter_rating_values = explode( ',', $filter_rating_values );
		$product_visibility_terms    = wc_get_product_visibility_term_ids();

		if ( empty( $parsed_filter_rating_values ) || empty( $product_visibility_terms ) ) {
			return array();
		}

		$rating_terms = array_map(
			function( $rating ) use ( $product_visibility_terms ) {
				return $product_visibility_terms[ 'rated-' . $rating ];
			},
			$parsed_filter_rating_values
		);

		return array(
			'tax_query' => array(
				array(
					'field'         => 'term_taxonomy_id',
					'taxonomy'      => 'product_visibility',
					'terms'         => $rating_terms,
					'operator'      => 'IN',
					'rating_filter' => true,
				),
			),
		);
	}

	/**
	 * Set featured products query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_featured_products_query_args( &$query_args ) {
		$query_args = $this->filter_query_to_only_include_ids( $query_args, wc_get_featured_product_ids() );
	}

	/**
	 * Apply the query only to a subset of products
	 *
	 * @param array $query  The query.
	 * @param array $ids  Array of selected product ids.
	 *
	 * @return array
	 */
	private function filter_query_to_only_include_ids( $query, $ids ) {
		if ( ! empty( $ids ) ) {
			$query['post__in'] = empty( $query['post__in'] ) ?
				$ids : array_intersect( $ids, $query['post__in'] );
		}

		return $query;
	}
}