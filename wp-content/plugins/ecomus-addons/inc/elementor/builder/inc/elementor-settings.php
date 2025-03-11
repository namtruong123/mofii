<?php
namespace Ecomus\Addons\Elementor\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Base\Module;
use Elementor\Controls_Manager;
use Elementor\Core\DocumentTypes\PageBase as PageBase;

class Elementor_Settings extends Module {
	/**
	 * Get module name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'ecomus-elementor-settings';
	}

	/**
	 * Module constructor.
	 */
	public function __construct() {
		add_action( 'elementor/documents/register_controls', [ $this, 'register_display_controls' ] );

		add_action( 'elementor/document/after_save', array( $this, 'save_post_meta' ), 10, 2 );
	}


	/**
	 * Register display controls.
	 *
	 * @param object $document
	 */
	public function register_display_controls( $document ) {
		if ( ! $document instanceof PageBase ) {
			return;
		}

		$post_type = get_post_type( $document->get_main_id() );

		if ( 'ecomus_builder' != $post_type ) {
			return;
		}

		$terms = get_the_terms( $document->get_main_id(), 'ecomus_builder_type' );
        $terms = ! is_wp_error( $terms ) &&  $terms ? wp_list_pluck($terms, 'slug') : '';

        if( ! $terms ) {
            return;
        }

		if( in_array( 'footer', $terms ) ) {
			$this->register_builder_footer_content($document);
		} else {
			$this->register_builder_content($document);
		}

		if( in_array( 'product', $terms ) ) {
			$this->register_builder_product_content($document);
		}
	}

	/**
	 * Register template controls of display.
	 *
	 * @param object $document
	 */
	protected function register_builder_content( $document ) {
		$document->start_controls_section(
			'section_site_content_settings',
			[
				'label' => __( 'Site Content Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_responsive_control(
			'site_content_spacing_top',
			[
				'label' => __( 'Spacing Top', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 42,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 31,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 22.5,
					'unit' => 'px',
				],
				'selectors' => [
					'.ecomus-woocommerce-elementor.ecomus-elementor-id-'.$document->get_id().' .site-content' => 'padding-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .site-content' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$document->add_responsive_control(
			'site_content_spacing_bottom',
			[
				'label' => __( 'Spacing Bottom', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 100,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 100,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 75,
					'unit' => 'px',
				],
				'selectors' => [
					'.ecomus-woocommerce-elementor.ecomus-elementor-id-'.$document->get_id().' .site-content' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .site-content' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$document->end_controls_section();
	}

	/**
	 * Register template footer controls of display.
	 *
	 * @param object $document
	 */
	protected function register_builder_footer_content( $document ) {
		$document->start_controls_section(
			'section_footer_settings',
			[
				'label' => __( 'Footer Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_control(
			'include_page_ids',
			[
				'label' => __( 'Include Pages', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => true,
				'source'      => 'page',
				'sortable'    => true,
				'label_block' => true,
			]
		);

		$document->add_control(
			'exclude_page_ids',
			[
				'label' => __( 'Exclude Pages', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => true,
				'source'      => 'page',
				'sortable'    => true,
				'label_block' => true,
			]
		);

		$document->end_controls_section();

	}

	/**
	 * Register template single product controls of display.
	 *
	 * @param object $document
	 */
	protected function register_builder_product_content( $document ) {
		$document->start_controls_section(
			'section_product_settings',
			[
				'label' => __( 'Single Product Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_control(
			'include_page_ids',
			[
				'label' => __( 'Include Products', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => true,
				'label_block' => true,
			]
		);

		$document->add_control(
			'include_category_slugs',
			[
				'label' => __( 'Include Categories', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'label_block' => true,
			]
		);

		$document->end_controls_section();
	}

	/**
	 * Save post meta when save page settings in Elementor
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function save_post_meta( $document, $data ) {
		$post_type = get_post_type( $document->get_main_id() );

		if ( 'ecomus_builder' != $post_type ) {
			return;
		}

		$terms = get_the_terms( $document->get_main_id(), 'ecomus_builder_type' );
        $terms = ! is_wp_error( $terms ) &&  $terms ? wp_list_pluck($terms, 'slug') : '';

        if( ! $terms ) {
            return;
        }

		if ( ! isset( $data['settings'] ) ) {
			return;
		}

		$settings = $data['settings'];

		if( in_array( 'footer', $terms ) || in_array( 'product', $terms ) ) {
			$include_ids = 0;
			if(! empty( $settings['include_page_ids'] )) {
				$include_ids = $settings['include_page_ids'];
				if (strpos($include_ids, ',') === 0) {
					$include_ids = $include_ids . ',';
				} else {
					$include_ids = ',' . $include_ids . ',';
				}
			}

			update_post_meta( $document->get_main_id(), 'page_include', $include_ids );
		}

		if( in_array( 'footer', $terms ) ) {
			$exclude_ids = 0;
			if(! empty( $settings['exclude_page_ids'] )) {
				$exclude_ids = $settings['exclude_page_ids'];
				if (strpos($exclude_ids, ',') === 0) {
					$exclude_ids = $exclude_ids  . ',';
				} else {
					$exclude_ids = ',' . $exclude_ids  . ',';
				}
			}

			update_post_meta( $document->get_main_id(), 'page_exclude', $exclude_ids );
		}

		if( in_array( 'product', $terms ) ) {
			$category_slug = 0;
			if(! empty( $settings['include_category_slugs'] )) {
				$category_slug = $settings['include_category_slugs'];
				if (strpos($category_slug, ',') === 0) {
					$category_slug = $category_slug  . ',';
				} else {
					$category_slug = ',' . $category_slug  . ',';
				}
			}

			update_post_meta( $document->get_main_id(), 'product_cat_include', $category_slug );
		}
	}
}