<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Stores Tab widget
 */
class Stores_Tab extends Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-stores-tab';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Image Box Tabs', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
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
		$this->content_sections();
		$this->style_sections();
	}

	protected function content_sections() {
		$this->start_controls_section(
			'section_contents',
			[
				'label' => __( 'Stores', 'ecomus-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter heading', 'ecomus-addons' ),
				'label_block' => true,
                'separator' => 'after',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter title', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => '',
				'placeholder' => __( 'Click here', 'ecomus-addons' ),
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label'       => __( 'Button Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
				'default'     => [],
			]
		);

        $repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
			]
		);

		$this->add_control(
			'stores',
			[
				'label'      => esc_html__( 'Stores', 'ecomus-addons' ),
				'type'       => Controls_Manager::REPEATER,
				'fields'     => $repeater->get_controls(),
				'title_field' => '{{{ heading }}}',
				'default' => [
					[
						'heading' => __( 'Tab 1', 'ecomus-addons' ),
						'image'   => ['url' => 'https://via.placeholder.com/720x506/f5f5f5?text=Image'],
						'title'   => __( 'This is a title 1', 'ecomus-addons' ),
						'description'   => __( 'This is a description 1', 'ecomus-addons' ),
					],
					[
						'heading' => __( 'Tab 2', 'ecomus-addons' ),
						'image'   => ['url' => 'https://via.placeholder.com/720x506/f5f5f5?text=Image'],
						'title'   => __( 'This is a title 2', 'ecomus-addons' ),
						'description'   => __( 'This is a description 2', 'ecomus-addons' ),
					],
					[
						'heading' => __( 'Tab 3', 'ecomus-addons' ),
						'image'   => ['url' => 'https://via.placeholder.com/720x506/f5f5f5?text=Image'],
						'title'   => __( 'This is a title 3', 'ecomus-addons' ),
						'description'   => __( 'This is a description 3', 'ecomus-addons' ),
					],
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

	protected function style_sections() {
		$this->start_controls_section(
			'section_heading_style',
			[
				'label'     => __( 'Heading', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_animation',
			[
				'label' => __( 'Animation', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'underline' => 'Underline',
				],
				'default' => 'none',
			]
		);

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'horizontal' ] );

        $this->add_responsive_control(
			'heading_gap',
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
					'{{WRAPPER}} .ecomus-stores-tab__heading' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-stores-tab__heading span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-stores-tab__heading span' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-stores-tab__heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-stores-tab__heading' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_heading_style' );

		$this->start_controls_tab(
			'tab_heading_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-stores-tab__heading span',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__heading span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_border_color',
			[
				'label' => __( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__heading span' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_heading_active',
			[
				'label' => __( 'Active', 'ecomus-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_active_typography',
				'selector' => '{{WRAPPER}} .ecomus-stores-tab__heading span[data-active="true"]',
			]
		);

		$this->add_control(
			'heading_color_active',
			[
				'label' => __( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__heading span[data-active="true"]' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'heading_border_color_active',
			[
				'label' => __( 'Active Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__heading span[data-active="true"]' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Stores', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_reverse',
			[
				'label'     => esc_html__( 'Reverse', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'ecomus-addons' ),
				'label_off' => esc_html__( 'No', 'ecomus-addons' ),
				'default'   => '',
				'prefix_class' => 'ecomus-stores-tab-reverse--',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-stores-tab__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-stores-tab__content' => 'padding: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-stores-tab__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-stores-tab__content' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'content_text_align',
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
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-stores-tab__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__content' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'image_style_heading',
			[
				'label' => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-stores-tab__image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-stores-tab__image' => '--em-image-rounded: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',

				],
			]
		);

		$this->add_control(
			'title_style_heading',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-stores-tab__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_style_heading',
			[
				'label' => __( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-stores-tab__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-stores-tab__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

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

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-stores-tab', 'ecomus-tabs--elementor', 'em-relative' ] );
		$this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );

		$this->add_render_attribute( 'heading', 'class', [ 'ecomus-stores-tab__heading', 'em-flex', 'ecomus-stores-tab__animation--' . $settings['heading_animation'] ] );
		$this->add_render_attribute( 'span', 'class', [ 'ecomus-tab--elementor', 'text-center' ] );

		$this->add_render_attribute( 'item', 'class', [ 'ecomus-stores-tab__item', 'ecomus-tab-item--elementor', 'em-flex' ] );
		$this->add_render_attribute( 'content', 'class', [ 'ecomus-stores-tab__content', 'em-flex', 'em-flex-center', 'em-flex-column' ] );
		$this->add_render_attribute( 'title', 'class', 'ecomus-stores-tab__title' );
		$this->add_render_attribute( 'description', 'class', 'ecomus-stores-tab__description' );
        $this->add_render_attribute( 'image', 'class', [ 'ecomus-stores-tab__image', 'em-ratio', 'em-image-rounded' ]);
        $this->add_render_attribute( 'tab_button', 'class', 'ecomus-stores-tab__button' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'heading' ); ?>>
                <?php $a = 0; foreach( $settings['stores'] as $store ): ?>
                    <?php if( ! empty( $store['heading'] ) ) : ?>
                        <span <?php echo $this->get_render_attribute_string( 'span' ); ?> data-tab="<?php echo esc_attr( $a ); ?>" data-active="<?php echo $a == 0 ? 'true' : 'false'; ?>"><?php echo wp_kses_post( $store['heading'] ); ?></span>
                    <?php endif; ?>
                <?php $a++; endforeach; ?>
            </div>
			<?php $b = 0; foreach( $settings['stores'] as $index => $store ): ?>
                <?php if( ! empty( $store['heading'] ) ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'item' ); ?> data-tab="<?php echo esc_attr( $b ); ?>" data-active="<?php echo $b == 0 ? 'true' : 'false'; ?>">
                    <div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
                        <div <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $store['title'] ); ?></div>
                        <div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $store['description'] ); ?></div>
						<?php if ( $store['button_text'] ) : ?>
                        	<div <?php echo $this->get_render_attribute_string( 'tab_button' ); ?>><?php $this->render_button( $store, $index ); ?></div>
						<?php endif; ?>
					</div>
                    <div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
						<?php if( ! empty( $store['image'] ) && ! empty( $store['image']['url'] ) ) : ?>
							<?php
								$settings['image'] = $store['image'];
								$settings['image_size'] = 'full';
								echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
							?>
						 <?php endif; ?>
                    </div>
				</div>
                <?php endif; ?>
			<?php $b++; endforeach; ?>
		</div>
		<?php
	}
}
