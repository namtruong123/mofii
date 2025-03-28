<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;
use Ecomus\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Banner Video widget
 */
class Video_Popup extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-video-popup';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Video Popup', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-youtube';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'video', 'popup' ];
	}

	public function get_script_depends() {
		return [
			'magnific',
		];
	}

	public function get_style_depends() {
		return [
			'magnific'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	/**
	 * Section Content
	 */
	protected function section_content() {

		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'video_type',
			[
				'label' => __( 'Source', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => [
					'youtube' => __( 'YouTube', 'ecomus-addons' ),
					'vimeo' => __( 'Vimeo', 'ecomus-addons' ),
					'self_hosted' => __( 'Self Hosted', 'ecomus-addons' ),
				],
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => __( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your URL', 'ecomus-addons' ) . ' (YouTube)',
				'default' => 'https://www.youtube.com/watch?v=K4TOrB7at0Y',
				'label_block' => false,
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

		$this->add_control(
			'vimeo_url',
			[
				'label' => __( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your URL', 'ecomus-addons' ) . ' (Vimeo)',
				'default' => 'https://vimeo.com/235215203',
				'label_block' => false,
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'insert_url',
			[
				'label' => __( 'External URL', 'ecomus-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => 'self_hosted',
				],
			]
		);

		$this->add_control(
			'external_url',
			[
				'label' => __( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'Enter your URL', 'ecomus-addons' ),
				'autocomplete' => false,
				'options' => false,
				'label_block' => true,
				'show_label' => false,
				'media_type' => 'video',
				'condition' => [
					'video_type' => 'self_hosted',
					'insert_url' => 'yes'
				],
			]
		);

		$this->add_control(
			'hosted_url',
			[
				'label' => __( 'Choose File', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition' => [
					'video_type' => 'self_hosted',
					'insert_url' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'banners_background',
				'label'    => __( 'Background', 'ecomus-addons' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ecomus-video-popup__featured-image',
				'fields_options'  => [
					'background' => [
						'default' => 'classic',
					],
					'image' => [
						'default'   => [
							'url' => 'https://via.placeholder.com/1440x500/f1f1f1?text=Video%20Thumbnail',
						],
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'   => [
					'unit' => 'px',
					'size' => 710,
				],
				'range'     => [
					'px' => [
						'min' => 100,
						'max' => 1000
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-popup' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only'   => esc_html__( 'Only marker', 'ecomus-addons' ),
					'all' 	 => esc_html__( 'All banner', 'ecomus-addons' ),
				],
				'default' => 'only',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Section Style
	 */

	protected function section_style() {
		$this->start_controls_section(
			'style_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box_shadow',
			[
				'label'       => esc_html__( 'Box Shadow', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-video-popup__featured-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-video-popup__featured-image' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'marker_heading',
			[
				'label' => esc_html__( 'Marker', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Font Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-popup__marker .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-popup__marker .ecomus-svg-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-popup__marker' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_width',
			[
				'label'     => __( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-popup__marker' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_height',
			[
				'label'     => __( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-popup__marker' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'wrapper', 'class', [
				'ecomus-video-popup'
			]
		);

		$icon =  \Ecomus\Addons\Helper::get_svg('play');

		$marker_html =  sprintf('<span class="ecomus-video-popup__marker">%s</span>', $icon) ;

		$video_url = array();


		if ($settings['video_type'] == 'youtube') {

			$video_url['url'] = $settings['youtube_url'];

		} elseif ($settings['video_type'] == 'vimeo') {

			$video_url['url'] = $settings['vimeo_url'];

		} else {

			if ( ! empty( $settings['insert_url'] ) ) {
				$video_url['url'] = $settings['external_url']['url'];
			} else {
				$video_url['url'] = $settings['hosted_url']['url'];
			}
		}

		$video_url['is_external'] = $video_url['nofollow'] = '';

		$btn_full = '';
		if ( $video_url['url']) :
			if ( $settings['link_type'] == 'only') {
				$marker_html =  '<a href="'. ( $video_url['url'] ) .'" class="ecomus-video-popup__play">'. $marker_html .'</a>';
			} else {
				$btn_full =  '<a href="'. esc_url( $video_url['url'] ) .'" class="ecomus-video-popup__play full-box-button"></a>';
			}
		endif;

		echo sprintf(
			'<div %s>
				<div class="ecomus-video-popup__featured-image %s"></div>
				%s %s
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$settings['box_shadow'] == 'yes' ? 'has-box-shadow' : '',
			$marker_html, $btn_full
		);
	}
}