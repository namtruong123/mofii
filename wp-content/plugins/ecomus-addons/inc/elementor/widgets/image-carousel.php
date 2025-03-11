<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Image_Carousel extends Carousel_Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Stores Location widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-image-carousel';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Stores Location widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Images Carousel', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve TeamMemberGrid widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-carousel';
	}

	/**
	 * Get widget categories
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return string Widget categories
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
	 * Register heading widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

    // Tab Content
	protected function section_content() {
		$this->section_content_slides();
		$this->section_slider_options();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater = new Repeater();

        $repeater->add_responsive_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
				],
			]
		);

        $repeater->add_control(
			'link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'image' => [
							'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
						],
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
						],
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
						],
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
						],
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
						],
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
						],
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/175x72/f1f1f1?text=image',
						],
						'link' => [
							'url' => '#',
						],
					],
				],
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
			'slides_to_show'   => 6,
			'slides_to_scroll' => 1,
			'space_between'    => 0,
			'navigation'       => 'dots',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

		$this->add_responsive_control(
			'slidesperview_auto',
			[
				'label' => __( 'Slides Per View Auto', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'ecomus-addons' ),
				'label_on'  => __( 'On', 'ecomus-addons' ),
				'default'   => '',
				'responsive' => true,
				'frontend_available' => true,
				'prefix_class' => 'ecomus%s-slidesperview-auto--'
			]
		);

		$this->end_controls_section();
	}

    // Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_carousel();
	}

	protected function section_style_content() {
		// Style
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-carousel__item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-carousel' => '--em-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-carousel__swiper' => '--em-image-carousel-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-carousel__swiper' => '--em-image-carousel-border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-carousel__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-carousel__item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'Image_heading_style',
			[
				'label'      => __( 'Image', 'ecomus-addons' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);


		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'image_horizontal_position',
			[
				'label'                => esc_html__( 'Image Horizontal Position', 'ecomus-addons' ),
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
				'selectors'            => [
					'{{WRAPPER}} .ecomus-image-carousel__item' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-carousel__item' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-carousel__item' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
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
	 * Render heading widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col;

        $this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-image-carousel', 'ecomus-carousel--elementor' ] );
		$this->add_render_attribute( 'swiper', 'style', $this->render_space_between_style() );
        $this->add_render_attribute( 'swiper', 'class', [ 'ecomus-image-carousel__swiper', 'swiper' ] );

        $this->add_render_attribute( 'inner', 'class', [ 'ecomus-image-carousel__inner', 'em-flex', 'swiper-wrapper', 'mobile-col-'. esc_attr( $col_mobile ), 'tablet-col-'. esc_attr( $col_tablet ), 'columns-'. esc_attr( $col ) ] );
        $this->add_render_attribute( 'item', 'class', [ 'ecomus-image-carousel__item', 'em-flex', 'em-relative', 'swiper-slide' ] );
        $this->add_render_attribute( 'image', 'class', [ 'ecomus-image-carousel__image' ] );
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'swiper' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
                    <?php foreach( $settings['items'] as $index => $item ) : ?>
						<?php
							$link_key = $this->get_repeater_setting_key( 'link', 'image_carousel', $index );
							$this->add_link_attributes( $link_key, $item['link'] );
						?>
                        <div <?php echo $this->get_render_attribute_string( 'item' ); ?>>
                        <?php if( ! empty( $item['image'] ) && ! empty( $item['image']['url'] ) ) : ?>
                            <?php if( $item['link']['url'] ) : ?>
                                <a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                            <?php endif; ?>
								<?php
									$image_args = [
										'image'        => ! empty( $item['image'] ) ? $item['image'] : '',
										'image_tablet' => ! empty( $item['image_tablet'] ) ? $item['image_tablet'] : '',
										'image_mobile' => ! empty( $item['image_mobile'] ) ? $item['image_mobile'] : '',
									];
								?>
								<?php echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args ); ?>
                            <?php if( $item['link']['url'] ) : ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
				<?php echo $this->render_arrows(); ?>
            </div>
            <?php echo $this->render_pagination(); ?>
        </div>
    <?php
	}
}