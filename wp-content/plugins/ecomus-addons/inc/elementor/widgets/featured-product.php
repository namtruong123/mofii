<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Featured Product widget
 */
class Featured_Product extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-featured-product';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Featured Product', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-single-product';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

    public function get_script_depends() {
		return [
            'imagesLoaded',
			'ecomus-elementor-widgets',
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'product_id',
			[
				'label' => __( 'Products', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => false,
				'source'      => 'product',
				'sortable'    => true,
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'gallery_layout',
			[
				'label'                => esc_html__( 'Gallery Layout', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'bottom'  => [
						'title' => esc_html__( 'Bottom', 'ecomus-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default' => 'bottom',
				'separator' => 'before',
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

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-featured-product', 'single-product', 'woocommerce', 'ecomus-featured-product__gallery--' . $settings['gallery_layout'] ] );

        if( empty( $settings['product_id'] ) ) {
            return;
        }

        $product = wc_get_product( intval( $settings['product_id'] ) );
	?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>

            <?php
            if( empty( $product ) ) {
                echo '<p>'. esc_html__( 'No products were found matching your selection.', 'ecomus-addons' ) .'</p>';
            } else {
                $original_post = $GLOBALS['post'];

                $GLOBALS['post'] = get_post( intval( $settings['product_id'] ) );
                setup_postdata( $GLOBALS['post'] );
				wc_get_template_part( 'content', 'single-product-summary' );
				$GLOBALS['post'] = $original_post;
                wp_reset_postdata();
            }
            ?>
        </div>
    <?php
	}
}