<?php
/**
 * Elementor Global init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Elementor\Page_Settings;

use \Elementor\Controls_Manager;
use Elementor\Core\DocumentTypes\PageBase as PageBase;

/**
 * Integrate with Elementor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Controls {

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

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		if ( ! class_exists( '\Elementor\Core\DocumentTypes\PageBase' ) ) {
			return;
		}

		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_styles' ) );

		add_action( 'elementor/documents/register_controls', [ $this, 'register_display_controls' ] );

	}


	/**
	 * Preview Elementor Page
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'reload_elementor', ECOMUS_ADDONS_URL . "/inc/elementor/page-settings/reload-elementor.js", array( 'jquery' ), '20240605', true );
	}

	/**
	 * Inline Style
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_add_inline_style( 'elementor-editor', '#elementor-panel .elementor-control-hide_title{display:none}' );
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

		if ( 'page' != $post_type ) {
			return;
		}

		$this->register_header_controls( $document );
		$this->register_page_header_controls( $document );
		$this->register_content_controls( $document );

	}

	/**
	 * Register template controls of the site header.
	 *
	 * @param object $document
	 */
	protected function register_header_controls( $document ) {
		$document->start_controls_section(
			'section_site_header',
			[
				'label' => __( 'Header Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_control(
			'hide_header_section',
			[
				'label'        => esc_html__( 'Hide Header Section', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',

			]
		);

		$document->add_control(
			'header_layout',
			[
				'label'       => esc_html__( 'Header Layout', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'' => esc_html__( 'Default', 'ecomus-addons' ),
					'v1'      => esc_html__( 'Header V1', 'ecomus-addons' ),
					'v2'      => esc_html__( 'Header V2', 'ecomus-addons' ),
					'v3'      => esc_html__( 'Header V3', 'ecomus-addons' ),
					'v4'      => esc_html__( 'Header V4', 'ecomus-addons' ),
					'v5'      => esc_html__( 'Header V5', 'ecomus-addons' ),
					'v6'      => esc_html__( 'Header V6', 'ecomus-addons' ),
				],
				'default'     => '',
			]
		);

		$document->add_control(
			'header_container',
			[
				'label'       => esc_html__( 'Header Container', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'' 			=> esc_html__( 'Default', 'ecomus-addons' ),
					'container' => esc_html__( 'Container', 'ecomus-addons' ),
					'fullwidth' => esc_html__( 'Full Width', 'ecomus-addons' ),
				],
				'default'     => '',
			]
		);

		$document->add_control(
			'header_mobile_layout',
			[
				'label'       => esc_html__( 'Header Mobile Layout', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'' => esc_html__( 'Default', 'ecomus-addons' ),
					'v1'      => esc_html__( 'Header V1', 'ecomus-addons' ),
					'v2'      => esc_html__( 'Header V2', 'ecomus-addons' ),
				],
				'default'     => '',
			]
		);

		$document->add_control(
			'header_background',
			[
				'label'       => esc_html__( 'Header Background', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''     => esc_html__( 'Default', 'ecomus-addons' ),
					'transparent' => esc_html__( 'Transparent', 'ecomus-addons' ),
				],
				'default'     => '',
			]
		);

		$document->add_control(
			'header_text_color',
			[
				'label'       => esc_html__( 'Header Text Color', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'' => esc_html__( 'Default', 'ecomus-addons' ),
					'light'   => esc_html__( 'Light', 'ecomus-addons' ),
					'dark'   => esc_html__( 'Dark', 'ecomus-addons' ),
				],
				'default'     => '',
				'condition' => [
					'header_background' 	=> 'transparent',
				],
			]
		);

		$document->add_control(
			'header_logo_type',
			[
				'label'       => esc_html__( 'Logo Type', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'' => esc_html__( 'Default', 'ecomus-addons' ),
					'image' => esc_html__( 'Image', 'ecomus-addons' ),
					'text'  => esc_html__( 'Text', 'ecomus-addons' ),
					'svg_upload'   => esc_html__( 'SVG', 'ecomus-addons' ),
				],
				'default'     => '',
			]
		);

		$document->add_control(
			'header_logo_image',
			[
				'label'       => esc_html__( 'Logo Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'header_logo_type',
							'value' => 'image',
						],

					],
				],
			]
		);

		$document->add_control(
			'header_logo_image_light',
			[
				'label'       => esc_html__( 'Logo Image Light', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'header_logo_type',
							'value' => 'image',
						],
					],
				],
			]
		);

		$document->add_control(
			'header_logo_text',
			[
				'label'   => esc_html__( 'Logo Text', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'header_logo_type',
							'value' => 'text',
						],
					],
				],
			]
		);

		$document->add_control(
			'header_logo_svg',
			[
				'label'   => esc_html__( 'Logo SVG', 'ecomus-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [],
				'conditions' => [
					'terms' => [
						[
							'name' => 'header_logo_type',
							'value' => 'svg_upload',
						],
					],
				],
			]
		);

		$document->add_control(
			'header_logo_width',
			[
				'label' => __( 'Logo Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'conditions' => [
					'terms' => [
						[
							'name' => 'header_logo_type',
							'operator' => 'in',
							'value' => ['image', 'svg_upload'],
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .header-logo > a img, .header-logo > a svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$document->add_control(
			'header_logo_height',
			[
				'label' => __( 'Logo Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					]
				],
				'default' => [],
				'conditions' => [
					'terms' => [
						[
							'name' => 'header_logo_type',
							'operator' => 'in',
							'value' => ['image', 'svg_upload'],
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} .header-logo > a img, .header-logo > a svg' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$document->end_controls_section();
	}

	/**
	 * Register template controls of the site header.
	 *
	 * @param object $document
	 */
	protected function register_page_header_controls( $document ) {
		// Page Header
		$document->start_controls_section(
			'section_page_header_settings',
			[
				'label' => esc_html__( 'Page Header Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_control(
			'hide_page_header',
			[
				'label'        => esc_html__( 'Hide Page Header', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => ''
			]
		);

		$document->add_control(
			'hide_page_header_title',
			[
				'label'        => esc_html__( 'Hide Title', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => ''
			]
		);

		$document->add_control(
			'hide_page_header_breadcrumb',
			[
				'label'        => esc_html__( 'Hide Breadcrumb', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => ''
			]
		);

		$document->add_control(
			'page_header_image',
			[
				'label'     => esc_html__( 'Image', 'ecomus-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [],
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--page' => 'background-image: url("{{URL}}");',
				],
			]
		);

		$document->add_control(
			'page_header_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--page::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$document->add_control(
			'page_header_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--page .page-header__title' => 'color: {{VALUE}};',
				],
			]
		);

		$document->add_control(
			'page_header_breadcrumb_link_color',
			[
				'label'     => esc_html__( 'Breadcrumb Link Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--page .site-breadcrumb a' => 'color: {{VALUE}};',
				],
			]
		);

		$document->add_control(
			'page_header_breadcrumb_color',
			[
				'label'     => esc_html__( 'Breadcrumb Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--page .site-breadcrumb' => 'color: {{VALUE}};',
				],
			]
		);

		$document->add_control(
			'page_header_spacing',
			[
				'label'       => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'default' => esc_html__( 'Default', 'ecomus-addons' ),
					'custom'  => esc_html__( 'Custom', 'ecomus-addons' ),
				),
				'default'     => 'default',
				'label_block' => true,
			]
		);

		$document->add_control(
			'page_header_top_padding',
			[
				'label'     => esc_html__( 'Top Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 300,
						'min' => 0,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 69,
				],
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--page' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'page_header_spacing' => 'custom',
				],
			]
		);

		$document->add_control(
			'page_header_bottom_padding',
			[
				'label'     => esc_html__( 'Bottom Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 300,
						'min' => 0,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 65,
				],
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--page' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'page_header_spacing' => 'custom',
				],
			]
		);

		$document->end_controls_section();
	}

	/**
	 * Register template controls of the site header.
	 *
	 * @param object $document
	 */
	protected function register_content_controls( $document ) {
		$document->start_controls_section(
			'section_content_settings',
			[
				'label' => esc_html__( 'Content Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_control(
			'content_top_spacing',
			[
				'label'       => esc_html__( 'Top Spacing', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__( 'Default', 'ecomus-addons' ),
					'custom'  => esc_html__( 'Custom', 'ecomus-addons' ),
				),
				'default'     => '',
				'label_block' => true,
			]
		);

		$document->add_control(
			'content_top_padding',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 300,
						'min' => 0,
					],
				],
				'default'   => [
				],
				'selectors' => [
					'{{WRAPPER}} .site-content' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_top_spacing' => 'custom',
				],
			]
		);

		$document->add_control(
			'content_bottom_spacing',
			[
				'label'       => esc_html__( 'Bottom Spacing', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__( 'Default', 'ecomus-addons' ),
					'custom'  => esc_html__( 'Custom', 'ecomus-addons' ),
				),
				'default'     => '',
				'label_block' => true,
			]
		);

		$document->add_control(
			'content_bottom_padding',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 300,
						'min' => 0,
					],
				],
				'default'   => [
				],
				'selectors' => [
					'{{WRAPPER}} .site-content' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'content_bottom_spacing' => 'custom',
				],
			]
		);

		$document->end_controls_section();
	}
}