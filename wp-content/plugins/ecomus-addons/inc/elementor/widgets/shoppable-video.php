<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Video banner widget
 */
class Shoppable_Video extends Carousel_Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-shoppable-video';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Shoppable Video', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-slider-video';
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
	 * Scripts
	 *
	 * @return void
	 */
	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
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

	protected function section_content() {
		$this->section_content_video();
		$this->section_slider_options();
	}

	protected function section_content_video() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Videos', 'ecomus-addons' ) ]
		);

		$repeater = new Repeater();

		$repeater->add_control(
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

		$repeater->add_control(
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

		$repeater->add_control(
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

		$repeater->add_responsive_control(
			'video_thumbnail',
			[
				'label'   => esc_html__( 'Video Thumbnail', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1440x500/f1f1f1?text=Video%20Thumbnail',
				],
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
			'items',
			[
				'label' => esc_html__( 'Videos', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'video_thumbnail' => [
							'url' => 'https://via.placeholder.com/460x818/f1f1f1?text=Video+Thumnail',
						]
					],
					[
						'video_thumbnail' => [
							'url' => 'https://via.placeholder.com/460x818/f1f1f1?text==Video+Thumnail',
						]
					],
					[
						'video_thumbnail' => [
							'url' => 'https://via.placeholder.com/460x818/f1f1f1?text==Video+Thumnail',
						]
					],
					[
						'video_thumbnail' => [
							'url' => 'https://via.placeholder.com/460x818/f1f1f1?text==Video+Thumnail',
						]
					],
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
					'size' => 818,
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-shoppable-video__video-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function section_slider_options() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$controls = [
			'slides_to_show'   => 3,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'arrows',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->section_style_carousel();
	}

	protected function section_style_carousel() {
		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();
	}


	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-shoppable-video' ] );
		$this->add_render_attribute( 'swiper', 'style', $this->render_space_between_style() );
        $this->add_render_attribute( 'swiper', 'class', [ 'ecomus-shoppable-video__swiper', 'ecomus-carousel--elementor', 'swiper' ] );

		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-shoppable-video__inner', 'em-flex', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
        $this->add_render_attribute( 'item', 'class', [ 'ecomus-shoppable-video__item', 'em-flex', 'em-flex-column', 'em-relative', 'swiper-slide' ] );
        $this->add_render_attribute( 'video', 'class', [ 'ecomus-shoppable-video__video-wrapper' ] );

		$this->add_render_attribute( 'product', 'class', [ 'ecomus-shoppable-video__product', 'em-flex', 'em-flex-align-center' ] );
		$this->add_render_attribute( 'product_image', 'class', [ 'ecomus-shoppable-video__product-image', 'em-ratio' ] );
		$this->add_render_attribute( 'product_summary', 'class', [ 'ecomus-shoppable-video__product-summary' ] );
		$this->add_render_attribute( 'product_title', 'class', [ 'ecomus-shoppable-video__product-title' ] );
		$this->add_render_attribute( 'product_price', 'class', [ 'ecomus-shoppable-video__product-price', 'em-flex' ] );
		$this->add_render_attribute( 'product_button', 'class', [ 'ecomus-shoppable-video__product-button', 'ecomus-quickview-button', 'em-button', 'em-button-icon', 'em-button-circle', 'em-tooltip', 'em-flex-center', 'em-flex-align-center' ] );
		?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'swiper' ); ?>>
					<div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
						<?php foreach( $settings['items'] as $item ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'item' ); ?>>
								<div <?php echo $this->get_render_attribute_string( 'video' ); ?>>
									<?php
										$media = $this->get_video_html($item);

										if ( empty( $item['youtube_url'] ) && empty( $item['hosted_url'] ) ) {
											if ( $settings['video_thumbnail']['url'] ) {
												echo '<div class="ecomus-shoppable-video__video-thumbnail">';
													echo '<img src="'. esc_attr( $item['video_thumbnail']['url'] ) .'" alt="'. esc_attr__( 'Video Thumbnail' ) . $item['id'] .'"/>';
												echo '</div>';
											}
										}
										echo $media;
									?>
								</div>
								<?php
									$product_id = $item[ 'product_id' ];

									if( ! empty( $product_id ) ) :
										$product = wc_get_product( $product_id );
										if( ! empty( $product ) ) :?>
											<div <?php echo $this->get_render_attribute_string( 'product' ); ?>>
												<div <?php echo $this->get_render_attribute_string( 'product_image' ); ?>>
													<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>">
														<?php echo $product->get_image(); ?>
													</a>
												</div>
												<div <?php echo $this->get_render_attribute_string( 'product_summary' ); ?>>
													<span <?php echo $this->get_render_attribute_string( 'product_title' ); ?>>
														<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
													</span>
													<div <?php echo $this->get_render_attribute_string( 'product_price' ); ?>>
														<?php echo wp_kses_post( $product->get_price_html() ); ?>
													</div>
												</div>
												<?php if ( \Ecomus\Helper::get_option( 'product_card_quick_view' ) ) : ?>
													<a <?php echo $this->get_render_attribute_string( 'product_button' ); ?> href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" data-toggle="modal" data-target="quick-view-modal" data-id="<?php echo esc_attr( $product_id ); ?>" data-tooltip="<?php echo esc_attr__( 'Quick View', 'ecomus' ); ?>" rel="nofollow">
														<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=eye' ); ?>
													</a>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<?php echo $this->render_pagination(); ?>
				</div>
				<?php echo $this->render_arrows(); ?>
			</div>
			<div id="shoppable-video-popover" class="shoppable-video-popover popover hidden-lg hidden-md hidden-sm">
				<div class="popover__backdrop"></div>
				<div class="popover__container">
					<div class="popover__wrapper">
						<?php echo \Ecomus\Addons\Helper::get_svg( 'close', 'ui', [ 'class' => 'em-button em-button-icon em-button-light popover__button-close' ] ); ?>
						<div class="popover__content shoppable-video-content em-flex em-flex-align-center"></div>
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
	public function get_video_html($video_settings) {
		$settings = $this->get_settings_for_display();
		$video_html = '';
		if ( $video_settings['image_source'] == 'youtube' ) {
			if( $video_settings['youtube_url'] ) {
				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_settings['youtube_url'], $id_video );
				$video_url = str_replace( '/watch', '/embed', $video_settings['youtube_url'] );
				$loop = $settings['video_loop'] == 'yes' ? '&playlist='.$id_video[1] : '';
				$autoplay = $settings['video_autoplay'] == 'yes' ? '&autoplay=1' : '';
				$sound = $settings['video_mute'] == 'yes' ? '&mute=1' : '';
				$video_html .= '<iframe id="ecomus-shoppable-video__video" class="ecomus-shoppable-video__video" data-type="youtube" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" width="100%" height="100%" src="' . $video_url . '?enablejsapi=1&playsinline=1&playerapiid=ytplayer&showinfo=0&fs=0&modestbranding=0&rel=0&loop=1'.$loop.'&controls=0&autohide=1&html5=1'.$sound.'&start=1'.$autoplay.'"></iframe>';
				if( $settings['play_on_mobile'] ) {
					$video_html .= sprintf( "<script type='text/javascript'>
					var tag = document.createElement('script');
					tag.src = 'https://www.youtube.com/iframe_api';
					var firstScriptTag = document.getElementsByTagName('script')[0];
					firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
					var player;
					function onYouTubeIframeAPIReady() {
					player = new YT.Player('ecomus-shoppable-video__video', {
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
			$video_url = $video_settings['hosted_url'];

			if( $video_url ) {
				$video_url = $video_url['url'];
				$autoplay = $settings['video_autoplay'] == 'yes' ? ' autoplay' : '';
				$loop = $settings['video_loop'] == 'yes' ? 'loop="true"' : '';
				$sound = $settings['video_mute'] == 'yes' ? 'muted="muted"' : '';
				$controls = $settings['video_controls'] == 'yes' ? ' controls' : '';
				$video_html .= '<video id="ecomus-shoppable-video__video" class="ecomus-shoppable-video__video" data-type="'.$video_settings['image_source'].'" src="'.esc_url($video_url).'" poster="'. esc_attr( $video_settings['video_thumbnail']['url'] ) .'" '.$sound.' preload="auto" '.$loop.$autoplay.$controls.' playsinline></video>';
			}
		}

		return $video_html;
	}

}