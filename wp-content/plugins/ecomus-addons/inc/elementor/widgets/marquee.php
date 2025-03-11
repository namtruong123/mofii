<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Stroke;

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
class Marquee extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Stores Location widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-marquee';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Stores Location widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Marquee', 'ecomus-addons' );
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
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'type',
			[
				'label'   => esc_html__( 'Type', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon-text',
				'options' => [
					'icon-text' => esc_html__( 'Icon & text', 'ecomus-addons' ),
					'image'     => esc_html__( 'Image', 'ecomus-addons' ),
				],
			]
		);

        $repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fa fa-star',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'type',
							'value' => 'icon-text',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'text', [
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'type',
							'value' => 'icon-text',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/182x75/f1f1f1?text=image',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'type',
							'value' => 'image',
						],
					],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'text_stroke',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .ecomus-marquee__text',
			]
		);

		$repeater->add_control(
			'text_repeater_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ecomus-marquee__text' => 'color: {{VALUE}}',
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
                        'text' => esc_html__( 'Spring Clearance Event: Save Up to 70%', 'ecomus-addons' ),
					],
					[
                        'text' => esc_html__( 'Spring Clearance Event: Save Up to 70%', 'ecomus-addons' ),
					],
					[
                        'text' => esc_html__( 'Spring Clearance Event: Save Up to 70%', 'ecomus-addons' ),
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
			]
		);

		$this->end_controls_section();
	}

	protected function section_style() {
		// Style
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
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
				'default'   => 'yes',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-marquee' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-marquee' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label'      => esc_html__( 'Gap', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-marquee__items' => 'gap: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-marquee__items' => 'gap: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'      => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-marquee' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);

		$this->add_control(
			'icon_heading',
			[
				'label' => esc_html__( 'Icon', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Size', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-marquee__icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-marquee__icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-marquee__item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_heading',
			[
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-marquee__text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'      => esc_html__( 'Color', 'ecomus-addons' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ecomus-marquee__text' => 'color: {{VALUE}}',
				],
			]
		);

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
			'ecomus-marquee',
			'ecomus-elementor--marquee',
			$settings['hover_pause'] == 'yes' ? 'ecomus-marquee--hover-stop' : '',
		];

        $this->add_render_attribute( 'wrapper', 'class', $classes );
        $this->add_render_attribute( 'inner', 'class', [ 'ecomus-marquee__inner', 'ecomus-marquee--inner', 'em-relative', 'em-flex-align-center' ] );
        $this->add_render_attribute( 'items', 'class', [ 'ecomus-marquee__items', 'ecomus-marquee--items', 'ecomus-marquee--original', 'em-flex-align-center' ] );
        $this->add_render_attribute( 'icon', 'class', [ 'ecomus-marquee__icon', 'ecomus-svg-icon' ] );
        $this->add_render_attribute( 'text', 'class', [ 'ecomus-marquee__text' ] );
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'items' ); ?>>
					<?php foreach( $settings['items'] as $index => $item ) : ?>
						<?php
							$item_key = $this->get_repeater_setting_key( 'item', 'elementor-marquee', $index );
							$this->add_render_attribute( $item_key, 'class', [ 'ecomus-marquee__item', 'em-flex', 'em-flex-align-center', 'elementor-repeater-item-' . esc_attr( $item['_id'] ) ] );
						?>
						<div <?php echo $this->get_render_attribute_string( $item_key ); ?>>
							<?php if( $item['type'] == 'image' ) : ?>
								<?php
									$image_args = [
										'image'        => ! empty( $item['image'] ) ? $item['image'] : '',
										'image_tablet' => ! empty( $item['image_tablet'] ) ? $item['image_tablet'] : '',
										'image_mobile' => ! empty( $item['image_mobile'] ) ? $item['image_mobile'] : '',
									];
								?>
								<?php echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args, $settings['image_size'] ); ?>
							<?php else : ?>
								<?php if( ! empty( $item['icon'] ) && ! empty( $item['icon']['value'] ) ) : ?>
									<span <?php echo $this->get_render_attribute_string( 'icon' ); ?>>
										<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<div <?php echo $this->get_render_attribute_string( 'text' ); ?>>
									<?php echo wp_kses_post( $item['text'] ); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
            </div>
        </div>
    <?php
	}
}