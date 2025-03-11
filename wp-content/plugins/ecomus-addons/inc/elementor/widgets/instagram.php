<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Pricing Table widget
 */
class Instagram extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-instagram';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Instagram', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-instagram-gallery';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['ecomus-addons'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'instagram', 'ecomus' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
		];
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
	   	$this->start_controls_section(
			'section_instagram',
			[ 'label' => __( 'Instagram', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'instagram_type',
			[
				'label' => esc_html__( 'Instagram type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'token' 	=> __( 'Token', 'ecomus-addons' ),
					'custom' 	=> __( 'Custom', 'ecomus-addons' ),
				],
				'default' => 'token',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'product_id',
			[
				'label'       => esc_html__( 'Product', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => false,
				'source'      => 'product',
				'sortable'    => true,
			]
		);

		$this->add_control(
			'instagrams',
			[
				'label' => esc_html__( 'Instagram', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'conditions' => [
					'terms' => [
						[
							'name' => 'instagram_type',
							'value' => 'custom',
						],
					],
				],
			]
		);

		$this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_aspect_ratio_controls( [ 'instagram_type' => 'custom' ] );

		$this->add_control(
			'limit',
			[
				'label'   => __( 'Number of Photos', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 12,
				'conditions' => [
					'terms' => [
						[
							'name' => 'instagram_type',
							'value' => 'token',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_video',
			[
				'label'     => esc_html__( 'Show Video', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'ecomus-addons' ),
				'label_off' => esc_html__( 'No', 'ecomus-addons' ),
				'default'   => 'no',
			]
		);

		$this->end_controls_section();

		// Carousel Settings
		$this->start_controls_section(
			'section_products_carousel',
			[
				'label' => __( 'Carousel Settings', 'ecomus-addons' ),
			]
		);

		$controls = [
			'slides_to_show'    				=> 5,
			'slides_to_scroll'     				=> 1,
			'space_between'  					=> 7,
			'navigation'    					=> 'none',
			'navigation_classes'    			=> 'none',
			'autoplay' 							=> '',
			'autoplay_speed'      				=> 3000,
			'pause_on_hover'    				=> 'yes',
			'animation_speed'  					=> 800,
			'infinite'  						=> '',
		];

		$this->register_carousel_controls($controls);

		$this->end_controls_section();

		// Content style
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Image Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'condition' => [
					'instagram_type' => 'custom',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'        => __( 'Show button', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'hover' 	=> __( 'Hover on Display', 'ecomus-addons' ),
					'always' 	=> __( 'Always on Display', 'ecomus-addons' ),
				],
				'default' => 'hover',
				'prefix_class' => 'ecomus-hover-show-button-',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-instagram__item a.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-instagram__item a.button' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'button_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} a.button .ecomus-svg-icon' => '--em-button-icon-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'instagram_type' => 'custom',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
				'condition' => [
					'instagram_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.button' => '--em-button-bg-color: {{VALUE}};',
				],
				'condition' => [
					'instagram_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} a.button' => '--em-button-color: {{VALUE}};',
				],
				'condition' => [
					'instagram_type' => 'custom',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
				'condition' => [
					'instagram_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.button' => '--em-button-bg-color-hover: {{VALUE}};',
				],
				'condition' => [
					'instagram_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.button' => '--em-button-color-hover: {{VALUE}};',
				],
				'condition' => [
					'instagram_type' => 'custom',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Carousel Options', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->add_control (
			'dots_position',
			[
				'label' => esc_html__( 'Position', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'outside',
				'options' => [
					'inside' => [
						'title' => esc_html__( 'Inside', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'outside' => [
						'title' => esc_html__( 'Outside', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-stretch',
					],
				],
				'prefix_class' => 'ecomus-carousel__dots-position-',
				'toggle' => false,
			]
		);

		$this->end_controls_section();
	}


	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! class_exists( '\Ecomus\Addons\Helper' ) && ! method_exists( '\Ecomus\Addons\Helper', 'ecomus_get_instagram_images' ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', [
			'ecomus-instagram',
			'ecomus-instagram--elementor',
			'ecomus-carousel--elementor swiper',
		] );

		$this->add_render_attribute( 'wrapper', 'style', [ $this->render_space_between_style(), $this->render_aspect_ratio_style() ] );

		$output = array();

		if ( $settings['instagram_type'] == 'custom' && $settings['instagrams'] ) {
			foreach ( $settings['instagrams'] as $instagram ) {
				$image_html = '';
				if( ! empty( $instagram['image'] ) && ! empty( $instagram['image']['url'] ) ) {
					$settings['image'] = $instagram['image'];
					$settings['image_size'] = 'full';
					$image_html = wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
				}
				add_filter('ecomus_add_to_cart_button_classes', array( $this, 'add_to_cart_button_classes' ));
				$output[] = sprintf(
					'<li class="ecomus-instagram__item swiper-slide">
						<%s class="ecomus-instagram__link em-eff-img-zoom" %s>%s</%s>
						%s
					</li>',
					! empty( $instagram['link'] ) ? 'a' : 'span',
					! empty( $instagram['link'] ) ? 'href="'. esc_url( $instagram['link'] ) .'"' : '',
					$image_html,
					! empty( $instagram['link'] ) ? 'a' : 'span',
					! empty( $instagram[ 'product_id' ] ) ? do_shortcode( '[add_to_cart id="'. $instagram[ 'product_id' ] .'" show_price="false" style=""]' ) : '',
				);
				remove_filter('ecomus_add_to_cart_button_classes', array( $this, 'add_to_cart_button_classes' ));
			}
		} else {
			$medias = \Ecomus\Addons\Helper::ecomus_get_instagram_images( $settings['limit'] );

			if ( is_wp_error( $medias ) ) {
				echo $medias->get_error_message();
			} elseif ( is_array( $medias ) ) {
				$medias = array_slice( $medias, 0, $settings['limit'] );
				$show_video = $settings['show_video'] == 'yes' ? true : false;
				foreach ( $medias as $media ) {
					$output[] = sprintf(
						'<li class="ecomus-instagram__item swiper-slide">%s</li>',
						\Ecomus\Addons\Helper::ecomus_instagram_image( $media, '', $show_video )
					);
				}
			}
		}

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

		echo sprintf(
			'<div %s><ul class="ecomus-instagram__list swiper-wrapper mobile-col-%s tablet-col-%s columns-%s">%s</ul>%s%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			esc_attr( $col_mobile ),
			esc_attr( $col_tablet ),
			esc_attr( $col ),
			implode('', $output ),
			$this->render_arrows(),
			$this->render_pagination()
		);
	}

	function add_to_cart_button_classes($button_classes) {
		$button_classes .= ' em-tooltip';

		return $button_classes;
	}
}