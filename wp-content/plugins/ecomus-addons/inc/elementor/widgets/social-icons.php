<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor social icons widget.
 *
 * Elementor widget that displays icons to social pages like Facebook and Twitter.
 *
 * @since 1.0.0
 */
class Social_Icons extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve social icons widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-social-icons';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve social icons widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Social Icons', 'ecomus-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve social icons widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-social-icons';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['ecomus-addons'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'social', 'icon', 'link', 'ecomus-addons' ];
	}

	/**
	 * Register social icons widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->content_sections();
		$this->style_sections();
	}

	protected function content_sections() {
		$this->start_controls_section(
			'section_social_icon',
			[
				'label' => esc_html__( 'Social Icons', 'ecomus-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon_type',
			[
				'label' => esc_html__( 'Icon type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'image' => esc_html__( 'Image', 'ecomus-addons' ),
					'icon' 	=> esc_html__( 'Icon', 'ecomus-addons' ),
					'external' 	=> esc_html__( 'External', 'ecomus-addons' ),
				],
				'default' => 'icon',
			]
		);

		$repeater->add_control(
			'social_icon',
			[
				'label' => esc_html__( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'ecomus-addons',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mix',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'icon',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'social_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'social_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'social_color_hover',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'social_hover_background_color',
			[
				'label' => esc_html__( 'Hover Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'image',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'external_url',
			[
				'label' => esc_html__( 'External URL', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'external',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::URL,
				'default' => [
					'is_external' => 'true',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'social_icon_list',
			[
				'label' => esc_html__( 'Social Icons', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-youtube',
							'library' => 'fa-brands',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function style_sections() {
		$this->start_controls_section(
			'section_social_style',
			[
				'label' => esc_html__( 'Icon', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => __( 'None', 'ecomus-addons' ),
					'solid' => __( 'Solid', 'ecomus-addons' ),
					'outline' => __( 'Outline', 'ecomus-addons' ),
				],
				'default' => 'outline',
				'prefix_class' => 'ecomus-social-icons__style--',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ecomus-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ecomus-addons' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ecomus-addons' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'ecomus-addons' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
					'justify'  => 'space-between',
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-social-icons__wrapper' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-social-icons__item' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-social-icons__item' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'style' => 'solid',
				]
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-social-icons__item:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_background_color',
			[
				'label' => esc_html__( 'Hover Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-social-icons__item:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'style' => 'solid',
				]
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-social-icons__wrapper' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'size' => 14,
				],
				'selectors' => [
					'{{WRAPPER}}.ecomus-social-icons__style--none .ecomus-social-icons__item .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'style',
							'value' => 'none',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render social icons widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-facebook',
			'fa fa-twitter',
			'fa fa-google-plus',
		];

		$migration_allowed = Icons_Manager::is_migration_allowed();

		?>
		<div class="ecomus-social-icons__wrapper">
			<?php
			foreach ( $settings['social_icon_list'] as $index => $item ) {
				if ( $item['icon_type'] === 'icon' ) {
					$migrated = isset( $item['__fa4_migrated']['social_icon'] );
					$is_new = empty( $item['social'] ) && $migration_allowed;
					$social = '';

					// add old default
					if ( empty( $item['social'] ) && ! $migration_allowed ) {
						$item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
					}

					if ( ! empty( $item['social'] ) ) {
						$social = str_replace( 'fa fa-', '', $item['social'] );
					}

					if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
						$social = explode( ' ', $item['social_icon']['value'], 2 );
						if ( empty( $social[1] ) ) {
							$social = '';
						} else {
							$social = str_replace( 'fa-', '', $social[1] );
						}
					}
					if ( 'svg' === $item['social_icon']['library'] ) {
						$social = get_post_meta( $item['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
					}

					if ( ! empty( $social ) ) {
						$social = 'ecomus-social-icon-' . $social;
					}
				} else {
					$url = '';
					if( $item['icon_type'] === 'image' ) {
						$url = ! empty ( $item['image']['url'] ) ? $item['image']['url'] : '';
					} else {
						$url = ! empty ( $item['external_url'] ) ? $item['external_url'] : '';
					}
				}

				$link_key = 'link_' . $index;

				$this->add_render_attribute( $link_key, 'class', [
					'ecomus-social-icons__item',
					! empty( $social ) ? $social : '',
					'elementor-repeater-item-' . $item['_id'],
				] );

				$this->add_link_attributes( $link_key, $item['link'] );

				?>
				<a <?php $this->print_render_attribute_string( $link_key ); ?> aria-label=<?php esc_attr_e('Social Icon Link', 'ecomus-addons'); ?>>
					<?php if ( ! empty( $item['social_icon'] ) || ! empty( $item['image']['url'] ) || ! empty( $item['external_url'] ) ) : ?>
						<?php
						if ( $item['icon_type'] === 'icon' ) {
							if ( $is_new || $migrated ) {
							echo '<span class="ecomus-svg-icon">';
								Icons_Manager::render_icon( $item['social_icon'] );
							echo '</span>';}
							else { ?>
							<i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
							<?php }
						} else {
							echo sprintf( '<span class="ecomus-img-icon"><img alt="%s" src="%s"></span>', esc_html__( 'Social Icon', 'ecomus-addons' ), esc_url( $url ) );
						}
						?>
					<?php endif; ?>
				</a>
			<?php } ?>
		</div>
		<?php
	}
}
