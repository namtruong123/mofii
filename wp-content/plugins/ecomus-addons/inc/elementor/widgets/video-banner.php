<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Video banner widget
 */
class Video_Banner extends Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-video-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Video Banner', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-banner';
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

	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Banner', 'ecomus-addons' ) ]
		);

		$this->start_controls_tabs( 'banner_tabs' );

		$this->start_controls_tab( 'banner_tabs_content', [ 'label' => esc_html__( 'Content', 'ecomus-addons' ) ] );

		$this->add_control(
			'before_title',
			[
				'label'   => esc_html__( 'Before Title', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is before title', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is title', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_controls();

		$this->end_controls_tab();

		$this->start_controls_tab( 'banner_tabs_image', [ 'label' => esc_html__( 'Media', 'ecomus-addons' ) ] );

		$this->add_control(
			'image_source',
			[
				'label' => esc_html__( 'Media Source', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'youtube' 	=> esc_html__( 'Youtube', 'ecomus-addons' ),
					'hosted' 	=> esc_html__( 'Self Hosted', 'ecomus-addons' ),
				],
				'default' => 'youtube',
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => esc_html__( 'Youtube URL', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'https://www.youtube.com/watch?v=K4TOrB7at0Y',
				'condition' => [
					'image_source' => 'youtube',
				],
			]
		);

		$this->add_control(
			'hosted_url',
			[
				'label' => esc_html__( 'URL', 'ecomus-addons' ),
				'type' => Controls_Manager::URL,
				'autocomplete' => false,
				'options' => false,
				'label_block' => true,
				'show_label' => false,
				'media_type' => 'video',
				'placeholder' => esc_html__( 'Enter your URL', 'ecomus-addons' ),
				'condition' => [
					'image_source' => 'hosted',
				],
			]
		);

		$this->add_responsive_control(
			'video_thumbnail',
			[
				'label'   => esc_html__( 'Video Thumbnail', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1440x500/f1f1f1?text=Video%20Thumbnail',
				],
			]
		);

		$this->add_control(
			'video_options',
			[
				'label' => esc_html__( 'Video Options', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'video_autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'play_on_mobile',
			[
				'label' => esc_html__( 'Play On Mobile', 'ecomus-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'condition' => [
					'video_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'video_mute',
			[
				'label' => esc_html__( 'Mute', 'ecomus-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'video_loop',
			[
				'label' => esc_html__( 'Loop', 'ecomus-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'video_controls',
			[
				'label' => esc_html__( 'Player Controls', 'ecomus-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'ecomus-addons' ),
				'label_on' => esc_html__( 'Show', 'ecomus-addons' ),
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'image_source' => 'hosted',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 650,
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-banner' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->section_style_banner();
		$this->section_style_content();
		$this->section_style_button();
	}

	protected function section_style_content() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_text_align',
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
					'{{WRAPPER}} .ecomus-video-banner .ecomus-video-banner__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-video-banner__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-video-banner__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-banner__content' => 'background-color: {{VALUE}};',
				],
			]
		);

		// before title
		$this->add_control(
			'content_style_beforetitle',
			[
				'label' => __( 'Before Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' =>  ['before_title!' => ''] ,
			]
		);

		$this->add_responsive_control(
			'before_title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-banner__before-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' =>  ['before_title!' => ''] ,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'before_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-video-banner__before-title',
				'condition' =>  ['before_title!' => ''] ,
			]
		);

		$this->add_control(
			'before_title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-banner__before-title' => 'color: {{VALUE}};',
				],
				'condition' =>  ['before_title!' => ''] ,
			]
		);

		// title
		$this->add_control(
			'content_style_title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-banner__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-video-banner__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-video-banner__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function section_style_banner() {
		// Content
		$this->start_controls_section(
			'section_banner_style',
			[
				'label' => __( 'Banner', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'banner_horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} .ecomus-video-banner__wrapper' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'banner_vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'   => [
						'title' => esc_html__( 'Top', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'  => [
						'title' => esc_html__( 'Bottom', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .ecomus-video-banner__wrapper' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'   => 'flex-start',
					'middle' => 'center',
					'bottom'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-video-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-video-banner' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function section_style_button() {
		// Content
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();

	}


	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'ecomus-video-banner',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$media = $this->get_video_html();

		?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div class="ecomus-video-banner__featured-image">
					<?php
						if ( empty( $settings['youtube_url'] ) && empty( $settings['hosted_url'] ) ) {
							if ( $settings['video_thumbnail']['url'] ) {
								echo '<div class="ecomus-video-banner__video-thumbnail">';
									$image_args = [
										'image'        => ! empty( $settings['video_thumbnail'] ) ? $settings['video_thumbnail'] : '',
										'image_tablet' => ! empty( $settings['video_thumbnail_tablet'] ) ? $settings['video_thumbnail_tablet'] : '',
										'image_mobile' => ! empty( $settings['video_thumbnail_mobile'] ) ? $settings['video_thumbnail_mobile'] : '',
									];
									echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args );
								echo '</div>';
							}
						}
						echo $media;
					?>
				</div>
				<div class="ecomus-video-banner__wrapper em-flex em-container">
					<div class="ecomus-video-banner__content">
						<?php echo ! empty( $settings['before_title'] ) ? sprintf( '<h6 class="ecomus-video-banner__before-title">%s</h6>', $settings['before_title'] ) : ''; ?>
						<?php echo ! empty( $settings['title'] ) ? sprintf( '<h3 class="ecomus-video-banner__title">%s</h3>', $settings['title'] ) : '';?>
						<div class="ecomus-video-banner-button">
							<?php $this->render_button(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php
	}

	/**
	 * Render video html.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_video_html() {
		$settings = $this->get_settings_for_display();
		$video_html = '';
		if ( $settings['image_source'] == 'youtube' ) {
			if( $settings['youtube_url'] ) {
				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $settings['youtube_url'], $id_video );
				$video_url = str_replace( '/watch', '/embed', $settings['youtube_url'] );
				$loop = $settings['video_loop'] == 'yes' ? '&playlist='.$id_video[1] : '';
				$autoplay = $settings['video_autoplay'] == 'yes' ? '&autoplay=1' : '';
				$sound = $settings['video_mute'] == 'yes' ? '&mute=1' : '';
				$video_html .= '<iframe id="ecomus-video-banner__video" class="ecomus-video-banner__video" data-type="youtube" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" width="100%" height="100%" src="' . $video_url . '?enablejsapi=1&playsinline=1&playerapiid=ytplayer&showinfo=0&fs=0&modestbranding=0&rel=0&loop=1'.$loop.'&controls=0&autohide=1&html5=1'.$sound.'&start=1'.$autoplay.'"></iframe>';
				if( $settings['play_on_mobile'] ) {
					$video_html .= sprintf( "<script type='text/javascript'>
					var tag = document.createElement('script');
					tag.src = 'https://www.youtube.com/iframe_api';
					var firstScriptTag = document.getElementsByTagName('script')[0];
					firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
					var player;
					function onYouTubeIframeAPIReady() {
					player = new YT.Player('ecomus-video-banner__video', {
						videoId: '%s',
						playerVars: { 'autoplay': 1, 'playsinline': 1 },
						events: {
							'onReady': onPlayerReady
						}
					});
					}
					function onPlayerReady(event) {
						event.target.playVideo();
					}
				</script>", $id_video[1] );
				}
			}
		} else {
			$video_url = $settings['hosted_url'];

			if( $video_url ) {
				$video_url = $video_url['url'];
				$autoplay = $settings['video_autoplay'] == 'yes' ? ' autoplay' : '';
				$loop = $settings['video_loop'] == 'yes' ? 'loop="true"' : '';
				$sound = $settings['video_mute'] == 'yes' ? 'muted="muted"' : '';
				$controls = $settings['video_controls'] == 'yes' ? ' controls' : '';
				$video_html .= '<video id="ecomus-slide-banner__video" class="ecomus-slide-banner__video" data-type="'.$settings['image_source'].'" src="'.esc_url($video_url).'" poster="'. esc_attr( $settings['video_thumbnail']['url'] ) .'" '.$sound.' preload="auto" '.$loop.$autoplay.$controls.' playsinline></video>';
			}
		}

		return $video_html;
	}

}