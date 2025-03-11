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
 * Product Category Tabs widget
 */
class Product_Category_Tabs extends Widget_Base {
    use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-product-category-tabs';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Product Category Tabs', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-tabs';
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
		$this->start_controls_section(
			'section_options',
			[
				'label' => __( 'Categories', 'ecomus-addons' ),
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'category_type',
			[
				'label' => __( 'Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'category',
				'options' => [
					'category'  => esc_html__( 'Product Category', 'ecomus-addons' ),
					'custom' => esc_html__( 'Custom Link', 'ecomus-addons' ),
				],
			]
		);

        $repeater->add_control(
			'product_cat',
			[
				'label'       => esc_html__( 'Product Category', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => false,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition' => [
					'category_type' => 'category',
				],
			]
		);

		$repeater->add_control(
			'custom_text',
			[
				'label'   => esc_html__( 'Text', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXT,
				'placeholder'   => esc_html__( 'Text', 'ecomus-addons' ),
				'default' => '',
				'condition' => [
					'category_type' => 'custom',
				],
			]
		);

		$repeater->add_control(
			'custom_link', [
				'label'         => esc_html__( 'Link', 'ecomus-addons' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'ecomus-addons' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition' => [
					'category_type' => 'custom',
				],
			]
		);

		$repeater->add_control(
			'custom_count',
			[
				'label'   => __( 'Count', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '',
				'min'     => 1,
				'max'	  => 100,
				'step'    => 1,
				'frontend_available' => true,
				'condition' => [
					'category_type' => 'custom',
				],
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
			'categories',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [],
				'title_field'   => '{{{ product_cat }}}',
				'prevent_empty' => false,
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
			'gap',
			[
				'label'      => esc_html__( 'Gap', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-category-tabs' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'items_heading',
			[
				'label' => esc_html__( 'Categories', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'items_width',
			[
				'label'     => esc_html__( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__items' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_responsive_control(
			'items_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-category-tabs__items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-category-tabs__items' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-product-category-tabs__items',
			]
		);

        $this->add_responsive_control(
			'items_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-category-tabs__items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-category-tabs__items' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'item_heading',
			[
				'label' => esc_html__( 'Category', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-category-tabs__item span:not(.ecomus-svg-icon)',
			]
		);

        $this->add_control(
			'item_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_color_hover',
			[
				'label' => __( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item:hover' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_color_active',
			[
				'label' => __( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item[data-active="true"]' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'item_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-category-tabs__item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_border_width',
			[
				'label'   => __( 'Border Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_control(
			'item_border_color',
			[
				'label' => __( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item' => 'border-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_border_color_hover',
			[
				'label' => __( 'Hover Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_border_color_active',
			[
				'label' => __( 'Active Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item[data-active="true"]' => 'border-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_count_heading',
			[
				'label' => esc_html__( 'Count', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_count_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-category-tabs__item span:not(.ecomus-svg-icon) span',
			]
		);

        $this->add_control(
			'item_count_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item span:not(.ecomus-svg-icon) span' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_count_color_hover',
			[
				'label' => __( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item:hover span:not(.ecomus-svg-icon) span' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_count_color_active',
			[
				'label' => __( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item[data-active="true"] span:not(.ecomus-svg-icon) span' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'item_count_spacing',
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
					'{{WRAPPER}} .ecomus-product-category-tabs__item span:not(.ecomus-svg-icon) span' => 'margin-left: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-category-tabs__item span:not(.ecomus-svg-icon) span' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				],
			]
		);

        $this->add_control(
			'item_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

        $this->add_responsive_control(
			'item_icon_size',
			[
				'label'     => esc_html__( 'Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item span.ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_control(
			'item_icon_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item span.ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_icon_color_hover',
			[
				'label' => __( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item:hover span.ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'item_icon_color_active',
			[
				'label' => __( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__item[data-active="true"] span.ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Images', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'images_width',
			[
				'label'     => esc_html__( 'Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-category-tabs__images' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->register_aspect_ratio_controls( [], [ 'aspect_ratio_type' => 'horizontal' ] );

        $this->add_responsive_control(
			'image_border_radius',
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

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
        $images = [];
        $i = 0;

        $this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-product-category-tabs', 'ecomus-tabs--elementor', 'em-flex' ] );
        $this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );

        $this->add_render_attribute( 'items', 'class', [ 'ecomus-product-category-tabs__items', 'em-flex', 'em-flex-column' ] );

        $this->add_render_attribute( 'images', 'class', [ 'ecomus-product-category-tabs__images' ] );
        ?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'items' ); ?>>
            <?php foreach( $settings['categories'] as $index => $category ) :
				if( empty( $category ) ) {
					continue;
				}

				$item = $this->get_repeater_setting_key( 'item', 'product-category-tabs', $index );
				$link = $this->get_repeater_setting_key( 'link', 'product-category-tabs', $index );

				$this->add_render_attribute( $item, 'class', [ 'ecomus-product-category-tabs__item', 'em-button', 'em-button-subtle' ] );
				$this->add_render_attribute( $link, 'class', [ 'em-ratio', 'ecomus-tab-item--elementor' ] );

				$name = $count = $url = '';

				if( $category['category_type'] == 'category' ) {
					$term = get_term_by( 'slug', $category['product_cat'], 'product_cat' );

					if( is_wp_error( $term ) || empty( $term ) ) {
						continue;
					}

					$name = $term->name;
					$count = $term->count;
					$url = get_term_link( $category['product_cat'], 'product_cat' );
				} else {
					$name = $category['custom_text'];
					$count = $category['custom_count'];
					$url = $category['custom_link']['url'];
				}

				$boolean = $i == 0 ? "true" : "false";

				if( ! empty( $category['image'] ) && ! empty( $category['image']['url'] ) ) {
					$this->add_render_attribute( $item, 'class', [ 'ecomus-tab--elementor' ] );
					$this->add_render_attribute( $item, 'data-tab', $i );
					$this->add_render_attribute( $item, 'data-active', $boolean );
					$this->add_render_attribute( $link, 'data-tab', $i );
					$this->add_render_attribute( $link, 'data-active', $boolean );
				} else {
					$this->add_render_attribute( $link, 'data-active', 'false' );
				}

				?>
				<div <?php echo $this->get_render_attribute_string( $item ); ?>>
					<?php if( empty( $category['image']['url'] ) ) : ?>
						<a class="em-flex em-flex-align-center em-flex-space-between" href="<?php echo esc_url( $url ); ?>">
					<?php endif;?>
						<span class="em-flex em-font-medium">
							<?php echo wp_kses_post( $name ); ?>
							<span class="em-font-normal"><?php echo wp_kses_post( $count ); ?></span>
						</span>
						<?php echo \Ecomus\Addons\Helper::get_svg( 'arrow-top' ); ?>
					<?php if( empty( $category['image']['url'] ) ) : ?>
						</a>
					<?php endif;?>
				</div>
				<?php
				$image_html = '';
				if( ! empty( $category['image'] ) && ! empty( $category['image']['url'] ) ) {
					$settings['image'] = $category['image'];
					$settings['image_size'] = 'full';
					$image_html = wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
				}
				?>
                <?php $images[] = '<a href="'. esc_url( $url ) .'" '. $this->get_render_attribute_string( $link ) .'">'. $image_html .'</a>'; ?>
            <?php $i++; endforeach; ?>
            </div>
            <div <?php echo $this->get_render_attribute_string( 'images' ); ?>>
                <?php echo implode( '', $images ); ?>
            </div>
        </div>
        <?php
	}
}
