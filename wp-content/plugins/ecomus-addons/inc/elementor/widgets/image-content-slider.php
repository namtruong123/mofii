<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use \Ecomus\Addons\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Content Slider widget
 */
class Image_Content_Slider extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-image-content-slider';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Image Content Slider', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slides';
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
		$this->section_content_slider();
		$this->section_slider_options();
	}

	protected function section_content_slider() {
		$this->start_controls_section(
			'section_options',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

            $repeater->start_controls_tab( 'content', [ 'label' => esc_html__( 'Content', 'ecomus-addons' ) ] );

                $repeater->add_control(
                    'title',
                    [
                        'label'       => esc_html__( 'Title', 'ecomus-addons' ),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__( 'Slide Title', 'ecomus-addons' ),
                        'label_block' => true,
                    ]
                );

                $repeater->add_control(
                    'description',
                    [
                        'label'       => esc_html__( 'Description', 'ecomus-addons' ),
                        'type'    => Controls_Manager::TEXTAREA,
                    ]
                );

				$repeater->add_control(
					'button_heading',
					[
						'label' => esc_html__( 'Button', 'ecomus-addons' ),
						'type'  => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

                $this->register_button_repeater_controls($repeater);

                $repeater->add_control(
                    'button_link_type',
                    [
                        'label'   => esc_html__( 'Apply Primary Link On', 'ecomus-addons' ),
                        'type'    => Controls_Manager::SELECT,
                        'options' => [
                            'only' => esc_html__( 'Button Only', 'ecomus-addons' ),
                            'slide'  => esc_html__( 'Whole Slide', 'ecomus-addons' ),
                        ],
                        'default' => 'slide',
                        'conditions' => [
                            'terms' => [
                                [
                                    'name' => 'button_link[url]',
                                    'operator' => '!=',
                                    'value' => '',
                                ],
                            ],
                        ],
                    ]
                );

            $repeater->end_controls_tab();

            $repeater->start_controls_tab( 'content_image', [ 'label' => esc_html__( 'Image', 'ecomus-addons' ) ] );
                $repeater->add_responsive_control(
                    'image',
                    [
                        'label'    => __( 'Image', 'ecomus-addons' ),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => 'https://via.placeholder.com/952x854/f1f1f1?text=image',
                        ],
                    ]
                );

				$repeater->add_responsive_control(
					'content_background_color_custom',
					[
						'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
						'type'       => Controls_Manager::COLOR,
						'selectors'  => [
							'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
						],
					]
				);
            $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Items', 'ecomus-addons' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title'            => esc_html__( 'Slide 1 Title', 'ecomus-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ecomus-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'ecomus-addons' ),
					],
					[
						'title'          => esc_html__( 'Slide 2 Title', 'ecomus-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ecomus-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'ecomus-addons' ),
					],
					[
						'title'          => esc_html__( 'Slide 3 Title', 'ecomus-addons' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'ecomus-addons' ),
						'button_text'      => esc_html__( 'Click Here', 'ecomus-addons' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
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
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-content-slider__image' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'button_icon_heading',
			[
				'label' => __( 'Button Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_icon_controls();

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
			'slides_to_show'   => 1,
			'slides_to_scroll' => 1,
			'navigation'       => 'dots',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

        $this->add_control(
			'effect',
			[
				'label'   => esc_html__( 'Effect', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'fade'   	 => esc_html__( 'Fade', 'ecomus-addons' ),
					'slide' 	 => esc_html__( 'Slide', 'ecomus-addons' ),
				],
				'default' => 'fade',
				'toggle'  => false,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

    // Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_button();
		$this->section_style_carousel();
	}

    protected function section_style_content() {
        $this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_direction',
				[
				'label' => esc_html__( 'Direction', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => esc_html__( 'Row - horizontal', 'ecomus-addons' ),
						'icon' => 'eicon-arrow-right',
					],
					'column' => [
						'title' => esc_html__( 'Column - vertical', 'ecomus-addons' ),
						'icon' => 'eicon-arrow-down',
					],
					'row-reverse' => [
						'title' => esc_html__( 'Row - reversed', 'ecomus-addons' ),
						'icon' => 'eicon-arrow-left',
					],
					'column-reverse' => [
						'title' => esc_html__( 'Column - reversed', 'ecomus-addons' ),
						'icon' => 'eicon-arrow-up',
					],
				],
				'default' => '',
				'selectors_dictionary' => [
					'row' => 'flex-direction: row; flex-grow: 1; align-self: stretch;',
					'column' => 'flex-direction: column; flex-grow: 0; align-self: initial; height: auto !important; justify-content: flex-end;',
					'row-reverse' => 'flex-direction: row-reverse; flex-grow: 1;align-self: stretch;',
					'column-reverse' => 'flex-direction: column-reverse; flex-grow: 0; align-self: initial; height: auto !important; justify-content: flex-end;',
				],
				'selectors' => [
					'{{SELECTOR}} .ecomus-image-content-slider__item' => '{{VALUE}};',
				],
				'responsive' => true,
			]
		);

		$this->add_responsive_control(
			'content_background_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-content-slider__item' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'content_align',
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
				'default'     => 'left',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-image-content-slider__content' => 'text-align: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-content-slider__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-content-slider__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label'     => esc_html__( 'Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-content-slider__title',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-content-slider__title' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'title_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-content-slider__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-content-slider__title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-content-slider__description',
			]
		);

        $this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-content-slider__description' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'description_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-content-slider__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-content-slider__description' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

    protected function section_style_button() {
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();
	}

    protected function section_style_carousel() {
		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Carousel Style', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

        $this->add_responsive_control(
			'dots_spacing_left',
			[
				'label'     => esc_html__( 'Spacing left', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-content-slider .swiper-pagination' => 'padding-left: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-content-slider .swiper-pagination' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: 0;',
				],
			]
		);

        $this->add_responsive_control(
			'dots_spacing_right',
			[
				'label'     => esc_html__( 'Spacing right', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-content-slider .swiper-pagination' => 'padding-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-content-slider .swiper-pagination' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: 0;',
				],
			]
		);

        $this->add_responsive_control(
			'dot_align',
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
					'{{WRAPPER}} .ecomus-image-content-slider .swiper-pagination' => 'text-align: {{VALUE}}',
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

        $this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-image-content-slider', 'ecomus-carousel--elementor', 'swiper' ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-image-content-slider__inner', 'swiper-wrapper' ] );

        $this->add_render_attribute( 'content', 'class', [ 'ecomus-image-content-slider__content', 'em-relative' ] );
        $this->add_render_attribute( 'image', 'class', [ 'ecomus-image-content-slider__image', 'em-ratio' ] );

        $this->add_render_attribute( 'title', 'class', [ 'ecomus-image-content-slider__title' ] );
		$this->add_render_attribute( 'description', 'class', [ 'ecomus-image-content-slider__description' ] );
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
            <?php
				$slides_count = count( $settings['slides'] );
				$slide_classes = $slides_count == 1 ? 'swiper-slide-active' : '';
                foreach ( $settings['slides'] as $index => $slide ) {
				$slide_item   = $this->get_repeater_setting_key( 'slide_item', 'slide', $index );
				$link_key 	  = $this->get_repeater_setting_key( 'link', 'slide', $index );

				$this->add_render_attribute( $slide_item, 'class', [ 'elementor-repeater-item-' . esc_attr( $slide['_id'] ), 'ecomus-image-content-slider__item', 'swiper-slide', 'em-flex', 'em-flex-align-center', esc_attr( $slide_classes ) ] );
				$this->add_link_attributes( $link_key, $slide['button_link'] );
				$this->add_render_attribute( $link_key, 'class', [ 'ecomus-image-content-slider__button--all', 'em-absolute' ] );

				$button_classes = ' ecomus-image-content-slider__button';
                ?>
                    <div <?php echo $this->get_render_attribute_string( $slide_item ); ?>>
                        <div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
                            <?php if ( $slide['title'] ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $slide['title'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( $slide['description'] ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $slide['description'] ); ?></div>
                            <?php endif; ?>

                            <?php
								$slide['button_style'] = $settings['button_style'];
								$slide['button_classes'] = $button_classes;
								$this->render_button( $slide, $index );
							?>
                        </div>
                        <div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
						<?php if( ! empty( $slide['image'] ) && ! empty( $slide['image']['url'] ) ) : ?>
							<?php
								$image_args = [
									'image'        => ! empty( $slide['image'] ) ? $slide['image'] : '',
									'image_tablet' => ! empty( $slide['image_tablet'] ) ? $slide['image_tablet'] : '',
									'image_mobile' => ! empty( $slide['image_mobile'] ) ? $slide['image_mobile'] : '',
								];
								echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args );
							?>
						 <?php endif; ?>
                        </div>
						<?php
							if ( $slide['button_link_type'] == 'slide' ) {
								if( ! empty( $slide['button_link']['url'] ) ) {
									echo '<a '. $this->get_render_attribute_string( $link_key ) .'>';
									echo '<span class="screen-reader-text">'. $slide['button_text'] .'</span>';
									echo '</a>';
								}
							}
						?>
                    </div>
            	<?php
                }
                ?>
            </div>
            <div class="swiper-arrows">
				<?php echo $this->render_arrows(); ?>
			</div>
            <?php
				echo $this->render_pagination();
			?>
        </div>
    <?php
	}
}
