<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Ecomus\Addons\Helper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Image Hotspot widget
 */
class Image_Hotspot extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Aspect_Ratio_Base;
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-image-hotspot';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Image Hotspot', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-nested-carousel';
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
		$this->section_content_slides();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_contents',
			[
				'label' => __( 'Contents', 'ecomus-addons' ),
			]
		);

		$this->add_responsive_control(
			'image',
			[
				'label'     => __( 'Image', 'ecomus-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1440x706/f1f1f1?text=image',
				],
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'product_items_ids',
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


		$repeater->add_responsive_control(
			'product_items_position_x',
			[
				'label'      => esc_html__( 'Point Position X', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 30,
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}}' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
			]
		);

		$repeater->add_responsive_control(
			'product_items_position_y',
			[
				'label'      => esc_html__( 'Point Position Y', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 30,
				],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'product_items_content_heading',
			[
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater->add_responsive_control(
			'product_content_items_position_x',
			[
				'label'      => esc_html__( 'Product Position X', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 1000,
						'max' => 1000,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}} .ecomus-image-hotspot__product-inner' => 'left: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}} .ecomus-image-hotspot__product-inner' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
			]
		);

		$repeater->add_responsive_control(
			'product_content_items_position_y',
			[
				'label'      => esc_html__( 'Product Position Y', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 1000,
						'max' => 1000,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}} .ecomus-image-hotspot__product-inner' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$repeater->add_control(
			'product_items_arrow_heading',
			[
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'Arrow', 'ecomus-addons' ),
			]
		);

		$repeater->add_responsive_control(
			'product_arrow_items_position_x',
			[
				'label'      => esc_html__( 'Product Position X', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 1000,
						'max' => 1000,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}} .ecomus-image-hotspot__arrow' => 'left: {{SIZE}}{{UNIT}}; transform: translate(0, 0);',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}} .ecomus-image-hotspot__arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto; transform: translate(0, 0);',
				],
			]
		);

		$repeater->add_responsive_control(
			'product_arrow_items_position_y',
			[
				'label'      => esc_html__( 'Product Position Y', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 1000,
						'max' => 1000,
					],
					'%'  => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-hotspot {{CURRENT_ITEM}} .ecomus-image-hotspot__arrow' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'items',
			[
				'label'      => '',
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [],
			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->section_style_content();
	}

	protected function section_style_content() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Contents', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_aspect_ratio_controls();

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-image-hotspot__image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-image-hotspot__image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_dots_bgcolor',
			[
				'label'     => esc_html__( 'Dots Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-hotspot__button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_dots_color',
			[
				'label'     => esc_html__( 'Dots Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-hotspot__button span' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_title_heading',
			[
				'label'     => esc_html__( 'Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-hotspot__product-title',
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-hotspot__product-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-hotspot__product-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_price_heading',
			[
				'label'     => esc_html__( 'Price', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_price_typography',
				'selector' => '{{WRAPPER}} .ecomus-image-hotspot__product-price',
			]
		);

		$this->add_control(
			'item_price_color',
			[
				'label'     => esc_html__( 'Regular Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-hotspot__product-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_price_color_ins',
			[
				'label'     => esc_html__( 'Sale Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-image-hotspot__product-price ins' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_button_heading',
			[
				'label'     => esc_html__( 'Button', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->register_button_style_controls( 'light' );

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-image-hotspot', 'em-relative' ] );
        $this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );
		$this->add_render_attribute( 'item', 'class', [ 'ecomus-image-hotspot__item', 'em-relative' ] );

        $this->add_render_attribute( 'image', 'class', [ 'ecomus-image-hotspot__image', 'em-image-rounded' ] );

        $this->add_render_attribute( 'product', 'class', [ 'ecomus-image-hotspot__product', 'em-absolute' ] );
        $this->add_render_attribute( 'product_inner', 'class', [ 'ecomus-image-hotspot__product-inner', 'em-absolute', 'em-flex-align-center', 'hidden-xs' ] );
        $this->add_render_attribute( 'product_summary', 'class', [ 'ecomus-image-hotspot__product-summary' ] );
        $this->add_render_attribute( 'product_image', 'class', [ 'ecomus-image-hotspot__product-image', 'em-ratio' ] );
        $this->add_render_attribute( 'product_title', 'class', [ 'ecomus-image-hotspot__product-title' ] );
        $this->add_render_attribute( 'product_price', 'class', [ 'ecomus-image-hotspot__product-price' ] );
        $this->add_render_attribute( 'arrow', 'class', [ 'ecomus-image-hotspot__arrow', 'em-absolute', 'hidden-xs' ] );
        $this->add_render_attribute( 'button', 'class', [ 'ecomus-image-hotspot__button', 'em-relative' ] );

        $this->add_render_attribute( 'quickview', 'class', [ 'ecomus-image-hotspot__quickview', 'ecomus-quickview-button', 'em-flex-align-center', 'em-flex-center', 'ecomus-button', 'em-button', 'em-tooltip' ] );

		if ( ! empty( $settings['button_style'] ) ) {
			$this->add_render_attribute( 'quickview', 'class', [ 'em-button-' . $settings['button_style'] ] );
		}
    ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'image' ); ?>>
				<?php echo Helper::get_responsive_image_elementor( $settings ); ?>
			</div>

				<?php foreach( $settings['items'] as $index => $item ) :
					$product_key  		= $this->get_repeater_setting_key( 'product', 'image_hotspot', $index );
					$this->add_render_attribute( $product_key, 'class', [ 'ecomus-image-hotspot__product', 'em-absolute', 'elementor-repeater-item-' . esc_attr( $item['_id'] ) ] );
					?>
					<?php
							$product_id    = $item[ "product_items_ids" ];
							if( ! empty( $product_id ) ) :
								$product = wc_get_product( $product_id );
								if( ! empty( $product ) ) : ?>
									<div <?php echo $this->get_render_attribute_string( $product_key ); ?> data-id="<?php echo esc_attr( $item['_id'] ); ?>">
										<div <?php echo $this->get_render_attribute_string( 'product_inner' ); ?>>
											<div <?php echo $this->get_render_attribute_string( 'product_image' ); ?>>
												<?php echo $product->get_image(); ?>
											</div>
											<div <?php echo $this->get_render_attribute_string( 'product_summary' ); ?>>
												<h6 <?php echo $this->get_render_attribute_string( 'product_title' ); ?>>
													<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" aria-label="<?php echo esc_html( $product->get_name() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
												</h6>
												<div <?php echo $this->get_render_attribute_string( 'product_price' ); ?>>
													<?php echo wp_kses_post( $product->get_price_html() ); ?>
												</div>
											</div>
											<?php if ( \Ecomus\Helper::get_option( 'product_card_quick_view' ) ) : ?>
												<a <?php echo $this->get_render_attribute_string( 'quickview' ); ?> href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" data-toggle="modal" data-target="quick-view-modal" data-id="<?php echo esc_attr( $product_id ); ?>" data-tooltip="<?php echo esc_attr__( 'Quick View', 'ecomus' ); ?>" rel="nofollow">
													<?php echo \Ecomus\Addons\Helper::inline_svg( 'icon=eye' ); ?>
												</a>
											<?php endif; ?>
										</div>
										<div <?php echo $this->get_render_attribute_string( 'arrow' ); ?>></div>
										<?php
										$link_for = esc_html__('Hotpot for', 'ecomus-addons');
										$link_for .= ' ' . $product->get_name();
										$this->add_render_attribute( 'button', 'aria-label', [ $link_for ] );
										?>
										<button <?php echo $this->get_render_attribute_string( 'button' ); ?> data-toggle="popover" data-target="image-hotspot-popover" data-device="mobile">
											<span></span>
										</button>
									</div>
								<?php endif; ?>
					<?php 	endif; ?>
			<?php endforeach; ?>
        </div>

		<div id="image-hotspot-popover" class="image-hotspot-popover popover hidden-lg hidden-md hidden-sm">
			<div class="popover__backdrop"></div>
			<div class="popover__container">
				<div class="popover__wrapper">
					<?php echo \Ecomus\Addons\Helper::get_svg( 'close', 'ui', [ 'class' => 'em-button em-button-icon em-button-light popover__button-close' ] ); ?>
					<div class="popover__content image-hotspot-content em-flex em-flex-align-center"></div>
				</div>
			</div>
		</div>
    <?php
	}
}