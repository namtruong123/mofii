<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Share extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-share';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Share', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-share';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'social', 'share', 'product' ];
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
				'placeholder' => __( 'Share', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'socials',
			[
				'label' => esc_html__( 'Select socials', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'facebook'    => esc_html__( 'Facebook', 'ecomus-addons' ),
					'twitter'     => esc_html__( 'Twitter', 'ecomus-addons' ),
					'googleplus'  => esc_html__( 'Google Plus', 'ecomus-addons' ),
					'pinterest'   => esc_html__( 'Pinterest', 'ecomus-addons' ),
					'tumblr'      => esc_html__( 'Tumblr', 'ecomus-addons' ),
					'reddit'      => esc_html__( 'Reddit', 'ecomus-addons' ),
					'linkedin'    => esc_html__( 'Linkedin', 'ecomus-addons' ),
					'stumbleupon' => esc_html__( 'StumbleUpon', 'ecomus-addons' ),
					'digg'        => esc_html__( 'Digg', 'ecomus-addons' ),
					'telegram'    => esc_html__( 'Telegram', 'ecomus-addons' ),
					'whatsapp'    => esc_html__( 'WhatsApp', 'ecomus-addons' ),
					'vk'          => esc_html__( 'VK', 'ecomus-addons' ),
					'email'       => esc_html__( 'Email', 'ecomus-addons' ),
				],
				'default' => [ 'facebook', 'twitter', 'tumblr', 'whatsapp', 'email' ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'whatsapp_number',
			[
				'label' => esc_html__( 'WhatsApp Phone Number', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'conditions' => [
					'terms' => [
						[
							'name' => 'socials',
							'operator' => 'contains',
							'value' => 'whatsapp',
						],
					],
				],
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
			$this->get_product_share_button( $settings );
		} else {
			if( ! empty( $settings['socials'] ) ) {
				$this->get_product_share_button( $settings );
			}
		}

		if( ! empty( $settings['socials'] ) ) {
			add_action( 'wp_footer', [ $this, 'product_share_content' ], 40 );
		}
	}

	public function get_product_share_button( $settings ) {
		echo '<div class="ecomus-product-extra-link">';
			echo '<a href="#" class="ecomus-extra-link-item ecomus-extra-link-item--share em-font-semibold" data-toggle="modal" data-target="product-share-modal-'. esc_attr( $this->get_id() ) .'">';
				if( ! empty( $settings['icon']['value'] ) ) {
					echo '<span class="ecomus-svg-icon ecomus-svg-icon--share">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
				} else {
					echo \Ecomus\Addons\Helper::get_svg( 'share' );
				}

				if( ! empty( $settings['text'] ) ) {
					echo esc_html( $settings['text'] );
				} else {
					echo esc_html__( 'Share', 'ecomus' );
				}
			echo '</a>';
		echo '</div>';
	}

	/**
	 * Product Share content
	 */
	public function product_share_content() {
		$settings = $this->get_settings_for_display();
		if( empty( $settings['socials'] ) ) {
			return;
		}

		?>
		<div class="product-share-modal modal product-extra-link-modal" data-id="product-share-modal-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="modal__backdrop"></div>
			<div class="modal__container">
				<div class="modal__wrapper">
					<div class="modal__header">
						<h3 class="modal__title em-font-h6"><?php esc_html_e( 'Share', 'ecomus' ); ?></h3>
						<a href="#" class="modal__button-close">
							<?php echo \Ecomus\Addons\Helper::get_svg( 'close', 'ui' ); ?>
						</a>
					</div>
					<div class="modal__content">
						<div class="product-share__share">
							<div class="product-share__copylink-heading em-font-h6 hidden"><?php echo esc_html__( 'Share', 'ecomus' ); ?></div>
							<?php echo ! empty( $this->share_socials( $settings['socials'], $settings['whatsapp_number'] ) ) ? $this->share_socials( $settings['socials'], $settings['whatsapp_number'] ) : '' ; ?>
						</div>
						<div class="product-share__copylink">
							<form class="em-responsive">
								<input class="product-share__copylink--link ecomus-copylink__link" type="text" value="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" readonly="readonly" />
								<button class="product-share__copylink--button ecomus-copylink__button"><?php echo esc_html__( 'Copy', 'ecomus' ); ?></button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<span class="modal__loader"><span class="ecomusSpinner"></span></span>
		</div>
		<?php
	}

	/**
	 * Button Share
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function share_socials( $socials, $whatsapp_number ) {
		if ( ! class_exists( '\Ecomus\Addons\Helper' ) && ! method_exists( '\Ecomus\Addons\Helper','share_link' )) {
			return;
		}

		$args = array();
		if ( ( ! empty( $socials ) ) ) {
			$output = array();

			foreach ( $socials as $social => $value ) {
				if( $value == 'whatsapp' ) {
					$args['whatsapp_number'] = $whatsapp_number;
				}

				if( $value == 'facebook' ) {
					$args[$value]['icon'] = 'facebook-f';
				}

				$output[] = \Ecomus\Addons\Helper::share_link( $value, $args );
			}
			return sprintf( '<div class="post__socials-share">%s</div>', implode( '', $output )	);
		};
	}
}
