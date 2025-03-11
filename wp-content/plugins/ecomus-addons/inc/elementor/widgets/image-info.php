<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Info widget
 */
class Image_Info extends Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-image-info';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Image Info', 'ecomus-addons' );
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
				'label' => __( 'Image', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   => esc_html__( 'Source', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'image' => esc_html__( 'Image', 'ecomus-addons' ),
					'location' => esc_html__( 'Location', 'ecomus-addons' ),
				],
				'default' => 'image',
			]
		);

        $this->add_responsive_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1440x600/f1f1f1?text=Image',
				],
				'condition' => [
					'source' => 'image',
				],
			]
		);

		$this->add_control(
			'location',
			[
				'label' => esc_html__( 'Location', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
					],
				],
				'ai' => [
					'active' => false,
				],
				'placeholder' => esc_html__( 'London Eye, London, United Kingdom', 'ecomus-addons' ),
				'default' => esc_html__( 'London Eye, London, United Kingdom', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'content_heading',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
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
			'description',
			[
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
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
					'{{WRAPPER}} .ecomus-image-info__image' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ecomus-image-info__location' => 'height: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => esc_html__( 'Zoom', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 12,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'source' => 'location',
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .ecomus-image-info' => 'justify-content: {{VALUE}}',
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
					'{{WRAPPER}} .ecomus-image-info' => 'align-items: {{VALUE}}',
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
					'{{WRAPPER}} .ecomus-image-info' => 'text-align: {{VALUE}}',
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
					'{{WRAPPER}} .ecomus-image-info .ecomus-image-info__summary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-info .ecomus-image-info__summary' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
					'{{WRAPPER}} .ecomus-image-info .ecomus-image-info__summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-info .ecomus-image-info__summary' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'border_radius',
			[
				'label'      => __( 'Image Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-info' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-info' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'content_border_radius',
			[
				'label'      => __( 'Content Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-info__summary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-info__summary' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
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
					'{{WRAPPER}} .ecomus-image-info__summary' => 'min-width: {{SIZE}}{{UNIT}}',
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
				'selector' => '{{WRAPPER}} .ecomus-image-info__title',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-info__title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ecomus-image-info__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-info__title' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-image-info__description',
			]
		);

        $this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-info__description' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .ecomus-image-info__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-info__description' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

		$this->add_control(
			'image_button_icon',
			[
				'label'   => esc_html__( 'Select Icon', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'hover' => esc_html__( 'Hover on Display', 'ecomus-addons' ),
					'alway' => esc_html__( 'Always on Display', 'ecomus-addons' ),
				],
				'default' => 'alway',
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-carousel__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-carousel__button' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
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

        $this->add_render_attribute( 'banner', 'class', [ 'ecomus-image-info', 'em-relative', 'em-flex' ] );

		$this->add_render_attribute( 'image', 'class', [ 'ecomus-image-info__image', 'em-relative' ] );
		$this->add_render_attribute( 'location', 'class', [ 'ecomus-image-info__location', 'em-relative' ] );
		$this->add_render_attribute( 'summary', 'class', [ 'ecomus-image-info__summary', 'em-absolute' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-image-info__title' ] );
		$this->add_render_attribute( 'description', 'class', [ 'ecomus-image-info__description' ] );
		$this->add_render_attribute( 'button', 'class', [ 'ecomus-image-info__button', 'ecomus-image-info__button-' . esc_attr( $settings['image_button_icon'] ), 'em-font-semibold', 'em-relative' ] );
		$this->add_render_attribute( 'button_all', 'class', [ 'ecomus-image-info__button--all', 'em-absolute' ] );
        ?>

		<div <?php echo $this->get_render_attribute_string( 'banner' ); ?>>
			<?php if ( $settings['source'] == 'location' ) : ?>
				<?php
					$params = [
						rawurlencode( $settings['location'] ),
						absint( $settings['zoom']['size'] ),
					];

					$url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
				?>
				<div <?php echo $this->get_render_attribute_string( 'location' ); ?>>
					<iframe loading="lazy"
						src="<?php echo esc_url( vsprintf( $url, $params ) ); ?>"
						title="<?php echo esc_attr( $settings['location'] ); ?>"
						aria-label="<?php echo esc_attr( $settings['location'] ); ?>"
					></iframe>
				</div>
			<?php else : ?>
				<div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
					<?php echo ! empty( $settings['image']['id'] ) ? \Ecomus\Addons\Helper::get_responsive_image_elementor( $settings ) : ''; ?>
				</div>
			<?php endif; ?>
            <div <?php echo $this->get_render_attribute_string( 'summary' ); ?>>
				<div class="ecomus-image-info-content">
					<?php if( ! empty( $settings['title'] ) ) : ?>
						<<?php echo esc_attr( $settings['title_size'] ); ?> <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></<?php echo esc_attr( $settings['title_size'] ); ?>>
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
