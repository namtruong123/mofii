<?php

namespace Ecomus\Addons\Modules\Size_Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Frontend {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	const POST_TYPE     = 'ecomus_size_guide';
	const OPTION_NAME   = 'ecomus_size_guide';


	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );

		// Display size guide.
		add_action( 'woocommerce_before_single_product', array( $this, 'display_size_guide'  ) );
		add_action( 'ecomus_before_single_product', array( $this, 'display_size_guide'  ) );
		add_action( 'ecomus_woocommerce_before_product_quickview_summary', array( $this, 'display_size_guide' ) );

		// Add product tab
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'product_data_tab' ) );


	}

	public function scripts() {
		wp_enqueue_style( 'ecomus-size-guide-content', ECOMUS_ADDONS_URL . 'modules/size-guide/assets/css/size-guide.css', array(), '1.0' );
		wp_enqueue_script('ecomus-size-guide-content', ECOMUS_ADDONS_URL . 'modules/size-guide/assets/js/size-guide-tab.js');
	}

	/**
	 * Get option of size guide.
     *
	 * @since 1.0.0
	 *
	 * @param string $option
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get_option( $option = '', $default = false ) {
		if ( ! is_string( $option ) ) {
			return $default;
		}

		if ( empty( $option ) ) {
			return get_option( self::OPTION_NAME, $default );
		}

		return get_option( sprintf( '%s_%s', self::OPTION_NAME, $option ), $default );
	}

	/**
	 * Hooks to display size guide.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_size_guide() {
		global $product;

		if ( 'yes' == $this->get_option( 'variable_only' ) && ! $product->is_type( 'variable' ) ) {
			return;
		}

		$guide_id = $this->get_product_size_guide_id();

		if ( ! $guide_id ) {
			return;
		}

		$guide_settings = get_post_meta( $product->get_id(), 'ecomus_size_guide', true );
		$display = ( is_array( $guide_settings ) && ! empty( $guide_settings['display'] ) ) ? $guide_settings['display'] : $this->get_option( 'display' );

		if ( 'tab' == $display ) {
			add_filter( 'woocommerce_product_tabs', array( $this, 'size_guide_tab' ) );
		} else {
			$button_position = ( is_array( $guide_settings ) && ! empty( $guide_settings['button_position'] ) ) ? $guide_settings['button_position'] : $this->get_option( 'button_position' );

			switch ( $button_position ) {
				case 'bellow_summary':
					add_action( 'woocommerce_single_product_summary', array( $this, 'size_guide_button' ), 21 );
					add_action( 'ecomus_woocommerce_product_quickview_summary', array( $this, 'size_guide_button' ), 32 );
					add_action( 'woocommerce_after_single_product_summary', array( $this, 'size_guide_panel' ), 12 );
					add_action( 'ecomus_woocommerce_after_product_quickview_summary', array( $this, 'size_guide_panel' ), 12 );
					add_action( 'ecomus_footer_elementor', array( $this, 'size_guide_panel' ), 12 );
					break;

				case 'bellow_price':
					add_action( 'woocommerce_single_product_summary', array( $this, 'size_guide_button' ), 12 );
					add_action( 'ecomus_woocommerce_product_quickview_summary', array( $this, 'size_guide_button' ), 29 );
					add_action( 'woocommerce_after_single_product_summary', array( $this, 'size_guide_panel' ), 12 );
					add_action( 'ecomus_woocommerce_after_product_quickview_summary', array( $this, 'size_guide_panel' ), 12 );
					add_action( 'ecomus_footer_elementor', array( $this, 'size_guide_panel' ), 12 );
					break;

				case 'bellow_button':
					add_action( 'woocommerce_after_add_to_cart_form', array( $this, 'size_guide_button' ), 9 );
					add_action( 'woocommerce_after_single_product_summary', array( $this, 'size_guide_panel' ), 12 );
					add_action( 'ecomus_woocommerce_after_product_quickview_summary', array( $this, 'size_guide_panel' ), 12 );
					add_action( 'ecomus_footer_elementor', array( $this, 'size_guide_panel' ), 12 );
					break;

				case 'beside_attribute':
					if ( ! $product->is_type( 'variable' ) ) {
						break;
					}

					$attribute = $this->get_option( 'attribute' );

					if ( is_array( $guide_settings ) && 'panel' == $guide_settings['display'] && 'beside_attribute' == $guide_settings['button_position'] ) {
						$attribute = $guide_settings['attribute'];
					}

					if ( empty( $attribute ) ) {
						break;
					}

					$variations = $product->get_variation_attributes();
					$attributes = array_keys( $variations );

					if ( empty( $variations ) ) {
						break;
					}

					if ( in_array( $attribute, $attributes ) || in_array( 'pa_' . $attribute, $attributes ) ) {
						add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'size_guide_attribute_button' ), 999, 2 );
						add_action( 'woocommerce_after_single_product_summary', array( $this, 'size_guide_panel' ), 20 );
						add_action( 'ecomus_woocommerce_after_product_quickview_summary', array( $this, 'size_guide_panel' ), 12 );
						add_action( 'ecomus_footer_elementor', array( $this, 'size_guide_panel' ), 12 );
					}

					break;
			}

		}
	}

	/**
	 * Add size guide tab to product tabs.
     *
	 * @since 1.0.0
	 *
	 * @param array $tabs
	 * @return array
	 */
	public function size_guide_tab( $tabs ) {
		$guide = $this->get_product_size_guide_id();

		$text = $this->get_option( 'button_text' );

		$button_text = $text ? $text : esc_html__('Size Guide' , 'ecomus-addons');

		if ( $guide ) {
			$tabs['ecomus_size_guide'] = array(
				'title' 	=> $button_text,
				'priority' 	=> 50,
				'callback' 	=> array( $this, 'size_guide_content' ),
			);
		}

		return $tabs;
	}

	/**
	 * Get HTML of size guide button
     *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	protected function get_size_guide_button() {
		global $product;

		$button_text = esc_html__('Find your size' , 'ecomus-addons');

		$guide_settings = get_post_meta( $product->get_id(), 'ecomus_size_guide', true );

		$class = ( is_array( $guide_settings ) && ! empty( $guide_settings['button_position'] ) ) ? $guide_settings['button_position'] : $this->get_option( 'button_position' );;

		return apply_filters(
			'ecomus_size_guide_button',
			sprintf(
				'<p class="product-size-guide %s"><a href="#" data-toggle="modal" data-target="size-guide-modal" class="size-guide-button em-button-subtle em-font-semibold">%s</a></p>',
				$class, $button_text
			)
		);
	}

	/**
	 * Display the button to open size guide.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function size_guide_button() {
		echo $this->get_size_guide_button();
	}

	/**
	 * Filter function to add size guide button bellow selected attribute.
     *
	 * @since 1.0.0
	 *
	 * @param string $html
	 * @param array $args
	 * @return string
	 */
	public function size_guide_attribute_button( $html, $args ) {
		global $product;

		$attribute = $this->get_option( 'attribute' );
		$guide_settings = get_post_meta( $product->get_id(), 'ecomus_size_guide', true );

		if ( is_array( $guide_settings ) && 'panel' == $guide_settings['display'] && 'beside_attribute' == $guide_settings['button_position'] ) {
			$attribute = $guide_settings['attribute'];
		}

		if ( $attribute == $args['attribute'] || ( 'pa_' . $attribute ) == $args['attribute'] ) {
			$html .= $this->get_size_guide_button();
		}

		return $html;
	}

	/**
	 * Size guide panel.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function size_guide_panel() {
		global $product;
		$guide_settings = get_post_meta( $product->get_id(), 'ecomus_size_guide', true );
		$display = ( is_array( $guide_settings ) && ! empty( $guide_settings['display'] ) ) ? $guide_settings['display'] : $this->get_option( 'display' );
		?>
		<div id="size-guide-modal" class="modal size-guide-modal">
			<div class="modal__backdrop"></div>
			<div class="modal__container">
				<div class="modal__wrapper">
					<div class="modal__header">
						<h3 class="modal__title em-font-h5"><?php esc_html_e( 'Size chart', 'ecomus-addons' ) ?></h3>
						<a href="#" class="modal__button-close">
							<?php echo \Ecomus\Addons\Helper::get_svg( 'close', 'ui' ); ?>
						</a>
					</div>
					<div class="modal__content modal-size-chart">
						<?php $this->size_guide_content(); ?>
					</div>
				</div>
			</div>
			<span class="modal__loader"><span class="ecomusSpinner"></span></span>
		</div>
		<?php
	}

	/**
	 * Display product size guide as a tab.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function size_guide_content() {
		$guide_id = $this->get_product_size_guide_id();

		if ( ! $guide_id ) {
			return;
		}

		$guide = get_post( $guide_id );

		echo '<div class="ecomus-size-guide">';

		if ( ! empty( $guide->post_content ) ) {
			echo '<div class="ecomus-size-guide--global-content">' . $this->kses_content( $guide->post_content, $guide ) . '</div>';
		}

		$size_guides = get_post_meta( $guide_id, 'size_guides', true );

		if ( ! $size_guides || ! is_array( $size_guides ) || empty( $size_guides['tables'] ) ) {
			echo '</div>';
			return;
		}

		// Display tabs.
		if ( 1 < count( $size_guides['tables'] ) ) {
			$tabs = array();

			foreach ( $size_guides['tabs'] as $index => $tab ) {
				$tabs[] = sprintf( '<li data-target="%s" class="%s">%s</li>', esc_attr( $index + 1 ), ( $index ? '' : 'active' ), esc_html( $tab ) );
			}

			echo '<div class="ecomus-size-guide-tabs">';
			echo '<ul class="ecomus-size-guide-tabs__nav">' . implode( '', $tabs ) . '</ul>';
			echo '<div class="ecomus-size-guide-tabs__panels">';
		}

		foreach ( $size_guides['tables'] as $index => $table ) {
			echo '<div class="ecomus-size-guide-tabs__panel ' . ( $index ? '' : 'active' ) . '" data-panel="' . esc_attr( $index + 1 ) . '">';

			if ( ! empty( $size_guides['names'][ $index ] ) ) {
				echo '<h4 class="ecomus-size-guide__name em-font-h6">' . wp_kses_post( $size_guides['names'][ $index ] ) . '</h4>';
			}

			if ( ! empty( $table ) ) {
				$table = json_decode( $table, true );

				echo '<div class="ecomus-size-guide__table-wrapper">';
				echo '<table class="ecomus-size-guide__table">';

				foreach ( $table as $row => $columns ) {
					if ( 0 === $row ) {
						echo '<thead>';
					} elseif ( 1 === $row ) {
						echo '</thead><tbody>';
					}

					echo '<tr>';

					if ( 0 === $row ) {
						echo '<th>' . implode( '</th><th>', $columns ) . '</th>';
					} else {
						echo '<td>' . implode( '</td><td>', $columns ) . '</td>';
					}

					echo '</tr>';
				}

				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}

			if ( ! empty( $size_guides['information'][ $index ] ) ) {
				echo '<div class="ecomus-size-guide__info">' . wp_kses_post( $size_guides['information'][ $index ] ) . '</div>';
			}

			if ( ! empty( $size_guides['descriptions'][ $index ] ) ) {
				echo '<div class="ecomus-size-guide__description">' . wp_kses_post( $size_guides['descriptions'][ $index ] ) . '</div>';
			}

			echo '</div>';
		}

		if ( 1 < count( $size_guides['tables'] ) ) {
			echo '</div></div>';
		}

		echo '</div>';
	}

	/**
	 * Add the_content filter to the guide content
	 *
	 * @param  string $content
	 * @param  WP_Post $guide
	 * @return string
	 */
	protected function kses_content( $content, $guide ) {
		$_post_object = $GLOBALS['post'];
		$GLOBALS['post'] = $guide;
		$content = apply_filters( 'the_content', $content );
		$GLOBALS['post'] = $_post_object;

		return $content;
	}

	/**
	 * Get assigned size guide of the product.
     *
	 * @since 1.0.0
	 *
	 * @param int|object $object Product object
	 * @return object
	 */
	public function get_product_size_guide_id( $object = false ) {
		global $product;

		$_product = $object ? wc_get_product( $object ) : $product;

		if ( ! $_product ) {
			return false;
		}

		$size_guide = get_post_meta( $_product->get_id(), 'ecomus_size_guide', true );

		// Return selected guide.
		if ( is_array( $size_guide ) ) {
			if ( 'none' == $size_guide['guide'] ) {
				return false;
			}

			if ( ! empty( $size_guide['guide'] ) ) {
				return $size_guide['guide'];
			}
		}


		// Get default size guide.
		$categories = $_product->get_category_ids();

		// Firstly, get size guide that assign for these categories directly.
		$guides = new \WP_Query( array(
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'suppress_filters'       => false,
			'meta_query '    => array(
				array(
					'key' => 'size_guide_category',
					'value' => array( 'none', 'all' ),
					'compare' => 'NOT IN',
				),
			),
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $categories,
				),
			),
		) );

		if ( $guides->have_posts() ) {
			$id = current( $guides->posts );

			return $this->get_translated_object_id( $id, self::POST_TYPE );
		}

		// Return global guide if it is availabel.
		$guides = new \WP_Query( array(
			'post_type'              => self::POST_TYPE,
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'meta_key'               => 'size_guide_category',
			'meta_value'             => 'all',
			'suppress_filters'       => false,
		) );


		if ( $guides->have_posts() ) {
			$id = current( $guides->posts );

			return $this->get_translated_object_id( $id, self::POST_TYPE );
		}

		return false;
	}

	/**
	 * Add new product data tab for size guide
     *
	 * @since 1.0.0
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function product_data_tab( $tabs ) {
		$tabs['ecomus_size_guide'] = array(
			'label'    => esc_html__( 'Size Guide', 'ecomus-addons' ),
			'target'   => 'ecomus-size-guide',
			'class'    => array( 'ecomus-size-guide', ),
			'priority' => 62,
		);

		return $tabs;
	}

	/**
	 * Get translated object ID if the WPML plugin is installed
	 * Return the original ID if this plugin is not installed
     *
	 * @since 1.0.0
	 *
	 * @param int    $id            The object ID
	 * @param string $type          The object type 'post', 'page', 'post_tag', 'category' or 'attachment'. Default is 'page'
	 * @param bool   $original      Set as 'true' if you want WPML to return the ID of the original language element if the translation is missing.
	 * @param bool   $language_code If set, forces the language of the returned object and can be different than the displayed language.
	 *
	 * @return mixed
	 */
	function get_translated_object_id( $id, $type = 'page', $original = true, $language_code = null ) {
		return apply_filters( 'wpml_object_id', $id, $type, $original, $language_code );
	}
}