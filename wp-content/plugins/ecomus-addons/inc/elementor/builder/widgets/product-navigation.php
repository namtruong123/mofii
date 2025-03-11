<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Navigation extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-navigation';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Navigation', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-post-navigation';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'navigation', 'product' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_navigation',
			[
				'label' => esc_html__( 'Product Navigation', 'ecomus-addons' ),
			]
		);

        $this->add_control(
			'icon_previous',
			[
				'label' => __( 'Icon Previous', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

        $this->add_control(
			'icon_next',
			[
				'label' => __( 'Icon Next', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

        $this->add_control(
			'icon_category',
			[
				'label' => __( 'Icon Category', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_navigation_style',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'gap',
			[
				'label' => __( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .product-navigation' => 'gap: {{SIZE}}{{UNIT}};',
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
			'icon_size',
			[
				'label' => __( 'Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .product-navigation__button .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-navigation__button .ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-navigation__button:hover .ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		global $product;

        $product = $this->get_product();

		if ( ! $product ) {
			return;
		}

        $term        = $product->get_category_ids()[0];
		$taxonomy    = 'product_cat';
		$prevProduct = get_previous_post( true, '', $taxonomy );
		$nextProduct = get_next_post( true, '', $taxonomy );

        $this->add_render_attribute( 'navigation', 'class', 'product-navigation' );
		$this->add_render_attribute( 'navigation_button', 'class', 'product-navigation__button' );

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$prevProduct = true;
			$nextProduct = true;
			$prevProductTitle = esc_html__( 'Previous Product Title', 'ecomus-addons' );
			$nextProductTitle = esc_html__( 'Next Product Title', 'ecomus-addons' );
		} else {
			if( ! empty( $prevProduct ) ) {
				$prevProductTitle = $prevProduct->post_title;
			}
			
			if( ! empty( $nextProduct ) ) {
                $nextProductTitle = $nextProduct->post_title;
            }
		}

        ?>
            <div <?php echo $this->get_render_attribute_string( 'navigation' ); ?>>
				<?php if( is_rtl() ) : ?>
					<?php if( ! empty( $nextProduct ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( 'navigation_button' ); ?> href="<?php echo esc_url( get_permalink( $nextProduct ) ); ?>" title="<?php echo esc_html( $nextProductTitle ); ?>" data-text="<?php echo esc_html( $nextProductTitle ); ?>">
                            <?php if( $settings['icon_next'] && $settings['icon_next']['value'] ) {
                                    echo '<span class="ecomus-svg-icon ecomus-svg-icon--next">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon_next'], [ 'aria-hidden' => 'true' ] ) . '</span>';
                                } else {
							        echo \Ecomus\Addons\Helper::get_svg( 'right-mini' ); 
                                } ?>
						</a>
					<?php endif; ?>
				<?php else : ?>
					<?php if( ! empty( $prevProduct ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( 'navigation_button' ); ?> href="<?php echo esc_url( get_permalink( $prevProduct ) ); ?>" title="<?php echo esc_html( $prevProductTitle ); ?>" data-text="<?php echo esc_html( $prevProductTitle ); ?>">
                            <?php if( $settings['icon_previous'] && $settings['icon_previous']['value'] ) {
                                    echo '<span class="ecomus-svg-icon ecomus-svg-icon--previous">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon_previous'], [ 'aria-hidden' => 'true' ] ) . '</span>';
                                } else {
							        echo \Ecomus\Addons\Helper::get_svg( 'left-mini' ); 
                                } ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>

				<a <?php echo $this->get_render_attribute_string( 'navigation_button' ); ?> href="<?php echo get_term_link( $term, $taxonomy ); ?>" title="<?php echo get_term( $term )->name; ?>" data-text="<?php echo esc_html( 'Back to', 'ecomus' ) . ' ' . get_term( $term )->name; ?>">
                    <?php if( $settings['icon_category'] && $settings['icon_category']['value'] ) {
                            echo '<span class="ecomus-svg-icon ecomus-svg-icon--category">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon_category'], [ 'aria-hidden' => 'true' ] ) . '</span>';
                        } else {
                            echo \Ecomus\Addons\Helper::get_svg( 'object-column' ); 
                        } ?>
				</a>

				<?php if( is_rtl() ) : ?>
					<?php if( ! empty( $prevProduct ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( 'navigation_button' ); ?> href="<?php echo esc_url( get_permalink( $prevProduct ) ); ?>" title="<?php echo esc_html( $prevProductTitle ); ?>" data-text="<?php echo esc_html( $prevProductTitle ); ?>">
                            <?php if( $settings['icon_previous'] && $settings['icon_previous']['value'] ) {
                                    echo '<span class="ecomus-svg-icon ecomus-svg-icon--previous">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon_previous'], [ 'aria-hidden' => 'true' ] ) . '</span>';
                                } else {
							        echo \Ecomus\Addons\Helper::get_svg( 'left-mini' ); 
                                } ?>
						</a>
					<?php endif; ?>
				<?php else : ?>
					<?php if( ! empty( $nextProduct ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( 'navigation_button' ); ?> href="<?php echo esc_url( get_permalink( $nextProduct ) ); ?>" title="<?php echo esc_html( $nextProductTitle ); ?>" data-text="<?php echo esc_html( $nextProductTitle ); ?>">
                            <?php if( $settings['icon_next'] && $settings['icon_next']['value'] ) {
                                    echo '<span class="ecomus-svg-icon ecomus-svg-icon--next">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon_next'], [ 'aria-hidden' => 'true' ] ) . '</span>';
                                } else {
							        echo \Ecomus\Addons\Helper::get_svg( 'right-mini' ); 
                                } ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
        <?php
	}
}