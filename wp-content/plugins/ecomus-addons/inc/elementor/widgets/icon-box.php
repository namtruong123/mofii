<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Stack ;
use Elementor\Group_Control_Border ;
use Ecomus\Addons\Helper;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Icon_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-icon-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Icon Box', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-icon-box';
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
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
   	public function get_keywords() {
	   return [ 'icon box', 'icon', 'box', 'ecomus-addons' ];
   	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->content_sections();
		$this->style_sections();
	}

	protected function content_sections() {
		$this->start_controls_section(
			'section_icon',
			[ 'label' => __( 'Icon Box', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'icon_type',
			[
				'label' => __( 'Icon Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'icon' => __( 'Icon', 'ecomus-addons' ),
					'image' => __( 'Image', 'ecomus-addons' ),
					'external' => __( 'External', 'ecomus-addons' ),
				],
				'default' => 'icon',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'ecomus-addons' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'icon_url',
			[
				'label' => __( 'External Icon URL', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'icon_type' => 'external',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title & Description', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your title', 'ecomus-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description',
			[
				'label' => '',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your description', 'ecomus-addons' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
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
				'default' => 'h5',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
			]
		);

		$this->end_controls_section();
	}

	protected function style_sections() {
		$this->content_style_sections();
		$this->icon_style_sections();
	}

	protected function icon_style_sections() {
		// Style Icon
		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => __( 'Icon', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Primary Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'icon_type' => 'icon'
				]
			]
		);

		$this->add_responsive_control(
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
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .icon-type-image .ecomus-icon-box__icon' => 'max-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-icon-box__icon',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-icon-box__icon' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box__icon' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box__icon' => '--em-image-rounded: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box__icon' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__icon' => '--ecomus-icon-box-margin: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->end_controls_section();
	}

	protected function content_style_sections() {
		// Content style
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'position',
			[
				'label' => esc_html__( 'Icon Position', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'ecomus-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'ecomus%s-icon-box__icon-position--',
				'toggle' => false,
			]
		);

		$this->add_control(
			'vertical_alignment',
			[
				'label' => esc_html__( 'Vertical Alignment', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => esc_html__( 'Top', 'ecomus-addons' ),
					'middle' => esc_html__( 'Middle', 'ecomus-addons' ),
					'bottom' => esc_html__( 'Bottom', 'ecomus-addons' ),
				],
				'default' => 'top',
				'prefix_class' => 'ecomus-icon-box__vertical-align-',
				'conditions' => [
					'terms' => [
						[
							'name' => 'position',
							'operator' => '!=',
							'value' => 'top'
						],
					]
				]
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'                => esc_html__( 'Alignment', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default'              => '',
				'prefix_class' => 'ecomus%s-icon-box__icon-alignment--',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-icon-box' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_box_shadow',
				'label' => __( 'Box Shadow', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-icon-box',
			]
		);

		$this->add_control(
			'title_style_heading',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ecomus-icon-box__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_style_heading',
			[
				'label' => __( 'Description', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-icon-box__content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ecomus-icon-box__content',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', ['ecomus-icon-box', 'icon-type-' . $settings['icon_type']] );
		$this->add_render_attribute( 'content_wrapper', 'class', 'ecomus-icon-box__wrapper' );
		$this->add_render_attribute( 'icon', 'class', 'ecomus-icon-box__icon' );
		$this->add_render_attribute( 'title', 'class', 'ecomus-icon-box__title' );
		$this->add_render_attribute( 'description', 'class', 'ecomus-icon-box__content' );

		$this->add_inline_editing_attributes( 'title', 'none' );
		$this->add_inline_editing_attributes( 'description', 'basic' );

		$this->add_link_attributes( 'link', $settings['link'] );
		$this->add_render_attribute( 'link', 'class', 'ecomus-button-link' );

		$icon_exist = true;

		if ( 'image' == $settings['icon_type'] ) {
			$icon_exist = ! empty($settings['image']) ? true : false;
		} elseif ( 'external' == $settings['icon_type'] ) {
			$icon_exist = ! empty($settings['icon_url']) ? true : false;
		} else {
			$icon_exist = ! empty($settings['icon']) && ! empty($settings['icon']['value']) ? true : false;
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $icon_exist ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'icon' ); ?>>
					<?php
					if( ! empty( $settings['link']['url'] ) ) {
						echo '<a '. $this->get_render_attribute_string( 'link' ) .'>';
					}

					if ( 'image' == $settings['icon_type'] ) {
						if( ! empty( $settings['image'] ) && ! empty( $settings['image']['url'] ) ) :
							$settings['image_size'] = 'full';
							echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
						endif;
					} elseif ( 'external' == $settings['icon_type'] ) {
						echo $settings['icon_url'] ? sprintf( '<img alt="%s" src="%s">', esc_attr( $settings['title'] ), esc_url( $settings['icon_url'] ) ) : '';
					} else {
						echo '<span class="ecomus-svg-icon">';
							Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
						echo '</span>';
					}

					if( ! empty( $settings['link']['url'] ) ) {
						echo '</a>';
					}
					?>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'content_wrapper' ); ?>>
				<?php if( ! empty( $settings['title'] ) ) : ?>
					<?php
						if( ! empty( $settings['link']['url'] ) ) {
							echo '<a '. $this->get_render_attribute_string( 'link' ) .'>';
						}
					?>
					<<?php Utils::print_validated_html_tag( $settings['title_size'] ); ?> <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $settings['title'] ) ?></<?php Utils::print_validated_html_tag( $settings['title_size'] ); ?>>
					<?php
						if( ! empty( $settings['link']['url'] ) ) {
							echo '</a>';
						}
					?>
				<?php endif; ?>
				<?php if( ! empty( $settings['description'] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $settings['description'] ) ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}