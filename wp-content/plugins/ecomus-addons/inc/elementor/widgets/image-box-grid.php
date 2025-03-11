<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;

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
class Image_Box_Grid extends Widget_Base {
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
		return 'ecomus-image-box-grid';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Stores Location widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Image Box Grid', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve TeamMemberGrid widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-image-box';
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
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

        $this->add_control(
			'horizontal_scrollable',
			[
				'label' => esc_html__( 'Horizontal Scrollable', 'ecomus-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => esc_html__( 'Yes', 'ecomus-addons' ),
				'label_off' => esc_html__( 'No', 'ecomus-addons' ),
				'prefix_class' => 'ecomus-image-box-grid-scroll--',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'ecomus-addons' ),
				'type'           => Controls_Manager::NUMBER,
				'min'            => 1,
				'max'            => 10,
				'step'           => 1,
				'default'        => 8,
				'tablet_default' => 5,
				'mobile_default' => 3,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__item' => '--em-image-box-grid-columns: {{VALUE}}',
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label'   => esc_html__( 'Item Width', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__item' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'horizontal_scrollable' => 'yes',
				],
				'separator'      => 'after',
			]
		);

		$repeater = new Repeater();

        $repeater->add_control(
			'type',
			[
				'label' => __( 'Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'icon' => __( 'Icon', 'ecomus-addons' ),
					'image' => __( 'Image', 'ecomus-addons' ),
					'text' => __( 'Text', 'ecomus-addons' ),
				],
				'default' => 'image',
			]
		);

        $repeater->add_responsive_control(
			'image',
			[
				'label'    => __( 'Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
				],
                'condition' => [
					'type' => 'image',
				],
			]
		);

        $repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'text', [
				'label' => esc_html__( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'badges', [
				'label' => esc_html__( 'Badge', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'description', [
				'label' => esc_html__( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
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

		$repeater->add_control(
			'style_heading',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'item_style_bg',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ecomus-image-box-grid__content' => 'background-color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'item_style_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ecomus-image-box-grid__content' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .ecomus-image-box-grid__title' => 'color: inherit;',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #1', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #2', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #3', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #4', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #5', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #6', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #7', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
					[
						'image' => [
							'url' => 'https://via.placeholder.com/130x130/f1f1f1?text=image',
						],
						'title' => __( 'This is the title #8', 'ecomus-addons' ),
						'link' => [
							'url' => '#',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

    // Tab Style
	protected function section_style() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'column_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__inner' => '--em-image-box-grid-col-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__inner' => '--em-image-box-grid-row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => esc_html__( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-grid__item' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'image_icon_heading',
			[
				'label' => esc_html__( 'Image & Icon', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'square' ] );

        $this->add_responsive_control(
			'max_width',
			[
				'label'   => esc_html__( 'Max Width', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__image a' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-image-box-grid__image .ecomus-image-box-grid__link' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_spacing_top',
			[
				'label'   => esc_html__( 'Spacing Top', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__image' => 'top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .ecomus-image-box-grid__image a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-image-box-grid__image a .ecomus-svg-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-image-box-grid__image .ecomus-image-box-grid__link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-grid__image a' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-grid__image a .ecomus-svg-icon' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-grid__image .ecomus-image-box-grid__link' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
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

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-grid__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-box-grid__content' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-image-box-grid__text',
			]
		);

        $this->add_control(
			'text_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__text' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'text_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__image[data-type="text"] .ecomus-image-box-grid__link' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-image-box-grid__image[data-type="text"] .ecomus-image-box-grid__link .ecomus-image-box-grid__text' => 'border-color: {{VALUE}};',
				],
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

        $this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__image a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-image-box-grid__image .ecomus-image-box-grid__link' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'icon_color_hover',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__image a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-image-box-grid__image .ecomus-image-box-grid__link:hover' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .ecomus-image-box-grid__title',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__title' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'title_color_hover',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'   => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-box-grid__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .ecomus-image-box-grid__description',
			]
		);

        $this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-box-grid__description' => 'color: {{VALUE}};',
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

        $this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-image-box-grid' ] );
		$this->add_render_attribute( 'wrapper', 'style', $this->render_aspect_ratio_style() );
        $this->add_render_attribute( 'inner', 'class', [ 'ecomus-image-box-grid__inner', 'em-flex' ] );
        $this->add_render_attribute( 'image', 'class', [ 'ecomus-image-box-grid__image', 'em-relative' ] );
        $this->add_render_attribute( 'badges', 'class', [ 'ecomus-image-box-grid__badges', 'em-absolute' ] );
		$this->add_render_attribute( 'description', 'class', [ 'ecomus-image-box-grid__description', 'text-center' ] );
        $this->add_render_attribute( 'content', 'class', [ 'ecomus-image-box-grid__content' ] );

    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
                <?php foreach( $settings['items'] as $index => $item ) : ?>
					<?php
						$slide_item   = $this->get_repeater_setting_key( 'item', 'slide', $index );
						$slide_link_img   	= $this->get_repeater_setting_key( 'link-img', 'slide', $index );
						$slide_link_title   = $this->get_repeater_setting_key( 'link-title', 'slide', $index );
						$this->add_render_attribute( $slide_item, 'class', [ 'elementor-repeater-item-' . esc_attr( $item['_id'] ), 'ecomus-image-box-grid__item' ] );

						$this->add_link_attributes( $slide_link_img, $item['link'] );
						$this->add_render_attribute( $slide_link_img, 'class', 'ecomus-image-box-grid__link em-ratio' );

						$this->add_link_attributes( $slide_link_title, $item['link'] );
						$this->add_render_attribute( $slide_link_title, 'class', 'ecomus-image-box-grid__title text-center em-font-semibold' );
					?>
                    <div <?php echo $this->get_render_attribute_string( $slide_item ); ?>>
                        <div <?php echo $this->get_render_attribute_string( 'image' ); ?> data-type="<?php echo esc_attr( $item['type'] ); ?>">
							<?php
								if ( ! empty( $item['link']['url'] ) ) {
									echo '<a '. $this->get_render_attribute_string( $slide_link_img ) .'>';
								} else {
									echo '<div class="ecomus-image-box-grid__link em-ratio">';
								}
							?>
                                <?php if( $item['type'] == 'image' ) { ?>
                                    <?php if( ! empty( $item['image'] ) && ! empty( $item['image']['url'] ) ) : ?>
										<?php
											$image_args = [
												'image'        => ! empty( $item['image'] ) ? $item['image'] : '',
												'image_tablet' => ! empty( $item['image_tablet'] ) ? $item['image_tablet'] : '',
												'image_mobile' => ! empty( $item['image_mobile'] ) ? $item['image_mobile'] : '',
											];
											echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args );
										?>
									 <?php endif; ?>
                                <?php } else if( $item['type'] == 'icon' ) { ?>
                                    <span class="ecomus-svg-icon">
                                        <?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </span>
								<?php } else { ?>
									<span class="ecomus-svg-icon ecomus-image-box-grid__text em-font-semibold">
										<?php echo wp_kses_post( $item['text'] ); ?>
                                    </span>
                                <?php } ?>
							<?php
								if ( ! empty( $item['link']['url'] ) ) {
									echo '</a>';
								} else {
									echo '</div>';
								}
							?>
                            <?php if( ! empty( $item['badges'] ) ) : ?>
                                <span <?php echo $this->get_render_attribute_string( 'badges' ); ?>><?php echo wp_kses_post( $item['badges'] ); ?></span>
                            <?php endif; ?>
                        </div>
						<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
							<?php if( ! empty( $item['title'] ) ) : ?>
								<?php
									if ( ! empty( $item['link']['url'] ) ) {
										echo '<a '. $this->get_render_attribute_string( $slide_link_title ) .'>';
									} else {
										echo '<div class="ecomus-image-box-grid__title text-center em-font-semibold">';
									}
								?>
									<?php echo wp_kses_post( $item['title'] ); ?>
								<?php
									if ( ! empty( $item['link']['url'] ) ) {
										echo '</a>';
									} else {
										echo '</div>';
									}
								?>
							<?php endif; ?>
							<?php if( ! empty( $item['description'] ) ) : ?>
								<div <?php echo $this->get_render_attribute_string( 'description' ); ?>>
									<?php echo wp_kses_post( $item['description'] ); ?>
								</div>
							<?php endif; ?>
						</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
	}
}