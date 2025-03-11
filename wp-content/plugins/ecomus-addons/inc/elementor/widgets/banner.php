<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Banner widget
 */
class Banner extends Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Banner', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image';
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
	 * Register heading widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_options',
			[
				'label' => __( 'Banner', 'ecomus-addons' ),
			]
		);

        $this->add_responsive_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/705x660/666666?text=Banner',
				],
			]
		);

        $this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the title', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your title', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

        $this->add_control(
			'title_size',
			[
				'label' => __( 'Title HTML Tag', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h4',
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label' => __( 'Sub Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);

        $this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Height', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-banner' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_align',
			[
				'label' => esc_html__( 'Alignment', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'bottom',
				'options' => [
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'stretch' => [
						'title' => esc_html__( 'Stretch', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-stretch',
					],
				],
				'prefix_class' => 'ecomus-banner__align--',
				'toggle' => false,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'ecomus-addons' ),
			]
		);

		$this->register_button_controls();

		$this->add_control(
			'button_icon_position',
			[
				'label' => esc_html__( 'Icon Display', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'right',
				'options' => [
					'right' => [
						'title' => esc_html__( 'Inline', 'ecomus-addons' ),
						'icon' => 'eicon-h-align-right',
					],
					'top' => [
						'title' => esc_html__( 'Block', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-top',
					],
				],
				'prefix_class' => 'ecomus-banner__icon-position--',
				'condition'   => [
					'show_button_icon' => 'alway',
				],
				'toggle' => false,
			]
		);

		$this->add_control(
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
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Banner', 'ecomus-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_zoom',
			[
				'label'   => esc_html__( 'Zoom when hover image', 'ecomus-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
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
					'{{WRAPPER}} .ecomus-banner' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'condition'   => [
					'content_align' => 'bottom',
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
					'{{WRAPPER}} .ecomus-banner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'   => 'flex-start',
					'middle' => 'center',
					'bottom'  => 'flex-end',
				],
				'condition'   => [
					'content_align' => 'bottom',
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
				'prefix_class' => 'ecomus-banner__text_align--',
				'selectors'   => [
					'{{WRAPPER}} .ecomus-banner' => 'text-align: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'banner_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-banner .ecomus-banner__summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-banner .ecomus-banner__summary' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
					'{{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-banner__title',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-banner__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ecomus-banner__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-banner__title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'sub_title_heading',
			[
				'label' => esc_html__( 'Sub Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-banner__sub-title',
			]
		);

        $this->add_control(
			'sub_title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-banner__sub-title' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'sub_title_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-banner__sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-banner__sub-title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-banner__description',
			]
		);

        $this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-banner__description' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ecomus-banner__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-banner__description' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
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

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-banner__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-banner__button' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->register_button_style_controls('light');

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'banner', 'class', [ 'ecomus-banner', 'em-relative', 'em-flex', $settings['hover_zoom'] == 'yes' ? 'em-eff-img-zoom' : '' ] );

		$this->add_render_attribute( 'image', 'class', [ 'ecomus-banner__image', 'em-ratio' ] );
		$this->add_render_attribute( 'summary', 'class', [ 'ecomus-banner__summary', 'em-absolute' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-banner__title' ] );
		$this->add_render_attribute( 'sub_title', 'class', [ 'ecomus-banner__sub-title' ] );
		$this->add_render_attribute( 'description', 'class', [ 'ecomus-banner__description' ] );
		$this->add_render_attribute( 'button', 'class', [ 'ecomus-banner__button' ] );

		$this->add_link_attributes( 'link', $settings['button_link'] );
		$this->add_render_attribute( 'link', 'class', [ 'ecomus-button-link', 'ecomus-banner__button--all', 'em-absolute' ] );
        ?>

		<div <?php echo $this->get_render_attribute_string( 'banner' ); ?>>
			<?php
				if ( $settings['button_link_type'] == 'slide' ) {
					if( ! empty( $settings['button_link']['url'] ) ) {
						echo '<a '. $this->get_render_attribute_string( 'link' ) .'>';
						echo '<span class="screen-reader-text">'. $settings['button_text'] .'</span>';
						echo '</a>';
					}
				}
			?>
			<div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
				<?php if( ! empty( $settings['image'] ) && ! empty( $settings['image']['url'] ) ) : ?>
					<?php echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $settings ); ?>
				<?php endif; ?>
			</div>
            <div <?php echo $this->get_render_attribute_string( 'summary' ); ?>>
				<div class="ecomus-banner-content">
					<?php if( ! empty( $settings['title'] ) ) : ?>
						<<?php echo esc_attr( $settings['title_size'] ); ?> <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_size'] ); ?>>
					<?php endif; ?>
					<?php if( ! empty( $settings['sub_title'] ) ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'sub_title' ); ?>><?php echo wp_kses_post( $settings['sub_title'] ); ?></div>
					<?php endif; ?>
					<?php if( ! empty( $settings['description'] ) ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $settings['description'] ); ?></div>
					<?php endif; ?>
				</div>
                <?php $this->render_button(); ?>
            </div>
        </div>
        <?php
	}
}
