<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Ecomus\Addons\Helper;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Heading extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-heading';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve heading widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Heading', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve heading widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-t-letter';
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
	 * Get widget keywords.
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'heading', 'title', 'text', 'ecomus-addons' ];
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
			'section_title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your title', 'ecomus-addons' ),
				'default' => __( 'Add Your Heading Text Here', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'ecomus-addons' ),
					'normal'  => __( 'Normal', 'ecomus-addons' ),
					'medium'  => __( 'Medium', 'ecomus-addons' ),
					'large'   => __( 'Large', 'ecomus-addons' ),
				],
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'HTML Tag', 'ecomus-addons' ),
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
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'                => esc_html__( 'Horizontal Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
					'space-between' => [
						'title' => __( 'Between', 'ecomus-addons' ),
						'icon' => 'eicon-justify-space-between-h',
					],
				],
				'default'     => '',
				'selectors'            => [
					'{{WRAPPER}} .ecomus-heading' => 'justify-content: {{VALUE}}; text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icons', 'ecomus-addons' ),
			]
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
				'default' => [],
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
				'default' => [],
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

		$this->end_controls_section();

		// Style before Title
		$this->start_controls_section(
			'section_style_content',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'heading_title',
			[
				'label'     => esc_html__( 'Title', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .ecomus-heading',
			]
		);

		$this->end_controls_section();

		// Style before Title
		$this->start_controls_section(
			'section_style_icons',
			[
				'label'     => __( 'Icons', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Primary Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-heading__icon' => 'color: {{VALUE}}',
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
						'max' => 200,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .ecomus-heading__icon' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .icon-type-image .ecomus-heading__icon' => 'max-width: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .ecomus-heading__icon' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-heading__icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
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

		if ( empty( $settings['title'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-heading-elementor' ] );

		$this->add_render_attribute( 'title', 'class', [ 'ecomus-heading', 'em-flex', 'em-flex-align-center', 'ecomus-heading--' . $settings['size'] ] );
		$this->add_render_attribute( 'icon', 'class', 'ecomus-heading__icon' );

		$this->add_inline_editing_attributes( 'title' );

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
				<<?php echo esc_attr( $settings['title_size'] ); ?> <?php echo $this->get_render_attribute_string( 'title' ); ?>>
					<?php if ( $icon_exist ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'icon' ); ?>>
							<?php
							if ( 'image' == $settings['icon_type'] ) {
								if( ! empty( $settings['image'] ) && ! empty( $settings['image']['url'] ) ) :
									$settings['image_size'] = 'thumbnail';
									echo wp_kses_post( \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ) );
								endif;
							} elseif ( 'external' == $settings['icon_type'] ) {
								echo $settings['icon_url'] ? sprintf( '<img alt="%s" src="%s">', esc_attr( $settings['title'] ), esc_url( $settings['icon_url'] ) ) : '';
							} else {
								echo '<span class="ecomus-svg-icon">';
									Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
								echo '</span>';
							}
							?>
						</div>
					<?php endif; ?>
					<?php echo wp_kses_post( do_shortcode($settings['title']) ); ?>
				</<?php echo esc_attr( $settings['title_size'] ); ?>>
			</div>
		<?php
	}
}