<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Archive_Page_Header extends Widget_Base {

	public function get_name() {
		return 'ecomus-archive-page-header';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Archive Page Header', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'archive', 'product', 'page', 'header' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-archive-product' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
            'page_header_content',
            [
                'label' => __( 'Page Header', 'ecomus-addons' ),
            ]
        );

		$this->add_control(
			'elements',
			[
				'label' => esc_html__( 'Show Elements', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'title'       => esc_html__('Title', 'ecomus'),
					'breadcrumb'  => esc_html__('BreadCrumb', 'ecomus'),
					'description' => esc_html__('Description', 'ecomus'),
				],
				'default' => [ 'title', 'description' ],
			]
		);

		$this->add_control(
			'shop_header_number_words',
			[
				'label' => esc_html__( 'Number Words Of Description', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 1,
				'default' => 20,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'page_header_style',
            [
                'label' => __( 'Style', 'ecomus-addons' ),
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
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .page-header__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'background_image',
			[
				'label'   => esc_html__( 'Background Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
				],
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--shop' => 'background-image: url("{{URL}}");',
				],
			]
		);

		$this->add_control(
			'background_color_overlay',
			[
				'label' => esc_html__( 'Background Color Overlay', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-header.page-header--shop::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .page-header.page-header--shop' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .page-header.page-header--shop' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .page-header__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-header__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .page-header__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_heading',
			[
				'label' => esc_html__( 'Breadcrumb', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'breadcrumb_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .site-breadcrumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'breadcrumb_text_heading',
			[
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumb_text_typography',
				'selector' => '{{WRAPPER}} .site-breadcrumb',
			]
		);

		$this->add_control(
			'breadcrumb_text_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .site-breadcrumb' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'breadcrumb_link_heading',
			[
				'label' => esc_html__( 'Link', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumb_link_typography',
				'selector' => '{{WRAPPER}} .site-breadcrumb a',
			]
		);

		$this->add_control(
			'breadcrumb_link_color',
			[
				'label' => esc_html__( 'Link Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .site-breadcrumb a, {{WRAPPER}} .site-breadcrumb span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'breadcrumb_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'breadcrumb_icon_size',
			[
				'label' => __( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .site-breadcrumb .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'breadcrumb_icon_color',
			[
				'label' => __( 'Icon Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .site-breadcrumb .ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'breadcrumb_icon_spacing',
			[
				'label' => __( 'Icon Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .site-breadcrumb .ecomus-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_heading',
			[
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .page-header__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-header__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if( empty( $settings['elements'] ) ) {
			return;
		}
		?>
		<div id="page-header" class="page-header page-header--shop">
			<div class="page-header__content em-flex em-flex-column em-flex-align-center">
				<?php 
					if( in_array( 'title', $settings['elements'] ) ) {
						$this->title();
					}
				?>
				<?php
					if( in_array( 'breadcrumb', $settings['elements'] ) ) {
						$this->breadcrumb();
					}
				?>
				<?php
					if( in_array( 'description', $settings['elements'] ) ) {
						$this->description( $settings );
					}
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Show title
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function title() {
		$title = '<h1 class="page-header__title em-font-h4">' . get_the_archive_title() . '</h1>';
		echo apply_filters('ecomus_page_header_title', $title);
	}

	/**
	 * Show breadcrumb
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function breadcrumb() {
		\Ecomus\Breadcrumb::instance()->breadcrumb();
	}

	/**
	 * Get description
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function description( $settings, $description = '' ) {
		ob_start();
		if( function_exists('is_shop') && is_shop() ) {
			woocommerce_product_archive_description();
		}

		$description = ob_get_clean();

		if ( is_tax() ) {
			$term = get_queried_object();
			if ( $term ) {
				$description = $term->description;
			}
		}

		if( empty( $description ) ) {
			if( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
				$description = esc_html__( 'This is a description of the archive product.', 'ecomus-addons' );
			}
		}

		if( $description ) {
			$number = ! empty( $settings[ 'shop_header_number_words' ] ) ? $settings[ 'shop_header_number_words' ] : 20;
			$description = wp_trim_words( $description, $number );
			echo '<div class="page-header__description">'. $description .'</div>';
		}
	}
}
