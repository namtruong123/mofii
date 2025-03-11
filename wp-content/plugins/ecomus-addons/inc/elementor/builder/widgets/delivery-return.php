<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Delivery_Return extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-delivery-return';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Delivery Return', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-undo';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'delivery', 'return', 'product' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-product' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Delivery & Return', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'page_id',
			[
				'label' => __( 'Select Page', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => false,
				'source'      => 'page',
				'sortable'    => true,
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_style',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->add_control(
			'link_heading',
			[
				'label' => esc_html__( 'Link', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-extra-link-item',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Link Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label' => esc_html__( 'Hover Link Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item:hover' => 'color: {{VALUE}}',
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		global $product;

		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}
		
		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$this->get_delivery_return_button( $settings );
		} else {
			if( ! empty( $settings['page_id'] ) ) {
				$this->get_delivery_return_button( $settings );
			}
		}

		if( ! empty( $settings['page_id'] ) ) {
			add_action( 'wp_footer', [ $this, 'delivery_return_content' ], 40 );
		}
	}

	public function get_delivery_return_button( $settings ) {
		echo '<div class="ecomus-product-extra-link">';
			echo '<a href="#" class="ecomus-extra-link-item ecomus-extra-link-item--delivery-return em-font-semibold" data-toggle="modal" data-target="product-delivery-return-modal-'. esc_attr( $this->get_id() ) .'">';
				if( ! empty( $settings['icon']['value'] ) ) {
					echo '<span class="ecomus-svg-icon ecomus-svg-icon--delivery">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
				} else {
					echo \Ecomus\Addons\Helper::get_svg( 'delivery' );
				}

				if( ! empty( $settings['text'] ) ) {
					echo esc_html( $settings['text'] );
				} else {
					echo esc_html__( 'Delivery & Return', 'ecomus' );
				}
			echo '</a>';
		echo '</div>';
	}

	/**
	 * Product Share content
	 */
	public function delivery_return_content() {
		$settings = $this->get_settings_for_display();

		if( empty( $settings['page_id'] ) ) {
			return;
		}

		$content = '';

		if( class_exists('\Elementor\Plugin') ) {
			$elementor_instance = \Elementor\Plugin::instance();
			$css_bool = \Ecomus\Addons\Elementor\Builder\Helper::check_elementor_css_print_method() ? false : true;
			$document = $elementor_instance->documents->get( $settings['page_id'] );
			if ( $document && $document->is_built_with_elementor() ) {
				$content = $elementor_instance->frontend->get_builder_content_for_display( $settings['page_id'], $css_bool );
			}
		}

		if ( empty( $content ) ) {
			$the_post 	= get_post( $settings['page_id'] );
			if( $the_post ) {
				$content 	= $the_post->post_content;
			}
		}

		?>
		<div class="product-delivery-return-modal modal product-extra-link-modal" data-id="product-delivery-return-modal-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="modal__backdrop"></div>
			<div class="modal__container">
				<div class="modal__wrapper">
					<div class="modal__header">
						<h3 class="modal__title em-font-h5"><?php echo get_the_title( $settings['page_id'] ); ?></h3>
						<a href="#" class="modal__button-close">
							<?php echo \Ecomus\Addons\Helper::get_svg( 'close', 'ui' ); ?>
						</a>
					</div>
					<div class="modal__content delivery-return-content"><?php echo ! empty( $content ) ? $content : ''; ?></div>
				</div>
			</div>
			<span class="modal__loader"><span class="ecomusSpinner"></span></span>
		</div>
		<?php
	}
}
