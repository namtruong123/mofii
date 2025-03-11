<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
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
class Hero_Images extends Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;
    use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Get widget name.
	 *
	 * Retrieve Stores Location widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-hero-images';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Stores Location widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Hero Images', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve TeamMemberGrid widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-animation';
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
			'imagesLoaded',
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

	protected function section_content() {
        $this->start_controls_section(
			'section_images',
			[
				'label' => __( 'Images', 'ecomus-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_responsive_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/640x817/f1f1f1?text=image',
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
                            'url' => 'https://via.placeholder.com/640x817/545454?text=image'
                        ],
					],
					[
                        'image' => [
                            'url' => 'https://via.placeholder.com/640x817/000000?text=image'
                        ],
					],
					[
                        'image' => [
                            'url' => 'https://via.placeholder.com/640x817/DB1215?text=image'
                        ],
					],
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => __( 'Speed', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '0.3',
				'min'     => 0.1,
				'max'	  => 0.9,
				'step'    => 0.1,
				'frontend_available' => true,
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

        $this->add_control(
            'subtitle',
            [
                'label' => __( 'Subtitle', 'ecomus-addons' ),
                'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'This is the subtitle', 'ecomus-addons' ),
            ],
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'ecomus-addons' ),
                'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'This is the title', 'ecomus-addons' ),
            ],
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

        $this->end_controls_section();
	}

	protected function section_style() {
		// Style
        $this->start_controls_section(
			'section_style_images',
			[
				'label'     => __( 'Image', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'hover_pause',
			[
				'label'     => esc_html__( 'Hover stop', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'ecomus-addons' ),
				'label_off' => esc_html__( 'No', 'ecomus-addons' ),
				'default'   => 'no',
			]
		);

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'vertical' ] );

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label'   => esc_html__( 'Width', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-hero-images__image::before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-hero-images__content' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'horizontal_position',
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
				'selectors'            => [
					'{{WRAPPER}} .ecomus-hero-images__summary' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_position',
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
				'selectors' => [
					'{{WRAPPER}} .ecomus-hero-images__summary' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'   => 'flex-start',
					'middle' => 'center',
					'bottom'  => 'flex-end',
				],
			]
		);

        $this->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'ecomus-addons' ),
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
					'{{WRAPPER}} .ecomus-hero-images__content' => 'text-align: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-hero-images__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-hero-images__content' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-hero-images__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-hero-images__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-hero-images__content' => '--em-rounded-md: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-hero-images__content' => '--em-rounded-md: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'min_width',
			[
				'label'     => esc_html__( 'Min Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-hero-images__content' => 'min-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_control(
			'subtitle_heading',
			[
				'label' => esc_html__( 'Subtitle', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .ecomus-hero-images__subtitle',
			]
		);

        $this->add_control(
			'subtitle_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-hero-images__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-hero-images__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-hero-images__subtitle' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-hero-images__title',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-hero-images__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ecomus-hero-images__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-hero-images__title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => __( 'Button', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

        $this->register_button_style_controls();

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

		$classes = [
			'ecomus-hero-images',
			'ecomus-elementor--marquee',
            'em-relative',
			$settings['hover_pause'] == 'yes' ? 'ecomus-hero-images--hover-stop' : '',
		];

        $this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );
        $this->add_render_attribute( 'inner', 'class', [ 'ecomus-hero-images__inner', 'ecomus-marquee--inner', 'em-relative', 'em-flex-align-center' ] );
        $this->add_render_attribute( 'items', 'class', [ 'ecomus-hero-images__items', 'ecomus-marquee--items', 'ecomus-marquee--original', 'em-flex-align-center' ] );
        $this->add_render_attribute( 'item', 'class', [ 'ecomus-hero-images__item', 'em-flex', 'em-flex-align-center' ] );
        $this->add_render_attribute( 'image', 'class', [ 'ecomus-hero-images__image', 'em-ratio' ] );

        $this->add_render_attribute( 'summary', 'class', [ 'ecomus-hero-images__summary', 'em-container', 'em-absolute', 'em-flex', 'em-flex-align-center' ] );
        $this->add_render_attribute( 'content', 'class', [ 'ecomus-hero-images__content', 'em-absolute' ] );
        $this->add_render_attribute( 'subtitle', 'class', [ 'ecomus-hero-images__subtitle', 'em-color-dark', 'em-font-bold' ] );
        $this->add_render_attribute( 'title', 'class', [ 'ecomus-hero-images__title' ] );
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'items' ); ?>>
					<?php foreach( $settings['items'] as $item ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'item' ); ?>>
							<div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
							<?php if( ! empty( $item['image'] ) && ! empty( $item['image']['url'] ) ) : ?>
								<?php
									$image_args = [
										'image'        => ! empty( $item['image'] ) ? $item['image'] : '',
										'image_tablet' => ! empty( $item['image_tablet'] ) ? $item['image_tablet'] : '',
										'image_mobile' => ! empty( $item['image_mobile'] ) ? $item['image_mobile'] : '',
									];
								?>
								<?php echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args ); ?>
							<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
            </div>
            <div <?php echo $this->get_render_attribute_string( 'summary' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
                    <div <?php echo $this->get_render_attribute_string('subtitle' );?>>
                        <?php echo wp_kses_post( $settings['subtitle'] ); ?>
                    </div>
                    <h3 <?php echo $this->get_render_attribute_string( 'title' );?>>
                        <?php echo wp_kses_post( $settings['title'] ); ?>
                    </h3>
                    <?php $this->render_button(); ?>
                </div>
            </div>
        </div>
    <?php
	}
}