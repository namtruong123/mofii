<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Ecomus\Addons\Elementor\Base\Carousel_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Button_Carousel extends Carousel_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-button-carousel';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Button Carousel', 'ecomus-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
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
		return [ 'button', 'carousel', 'ecomus-addons' ];
	}

	/**
	 * Script
	 *
	 * @return void
	 */
	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
		];
	}

	/**
	 * Register button widget controls.
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
			'section_button',
			[
				'label' => __( 'Button', 'ecomus-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$this->register_button_repeater_controls($repeater);

		$this->add_control(
			'buttons',
			[
				'label'       => __( 'Button Carousel', 'ecomus-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ button_text }}}',
				'default' => [
					[
						'button_text' => __( 'Button 1', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
					[
						'button_text' => __( 'Button 2', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
					[
						'button_text' => __( 'Button 3', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
					[
						'button_text' => __( 'Button 4', 'ecomus-addons' ),
						'button_link' => [ 'url' => '#' ],
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'slides_per_view',
			[
				'label'     => __( 'Slides Per View', 'ecomus-addons' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'	=> 'auto',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'space_between',
			[
				'label'     => __( 'Gap', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 250,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'button_icon_heading',
			[
				'label' => __( 'Button Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_icon_controls();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_responsive_control(
			'navigation_classes',
			[
				'label' => __( 'Navigation', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'dots' => esc_html__('Dots', 'ecomus-addons'),
					'none' => esc_html__('None', 'ecomus-addons'),
				],
				'default' => 'dots',
				'prefix_class' => 'navigation-class-%s',
			]
		);

		$this->end_controls_section();
	}

	protected function style_sections() {
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_button_style_controls();

		$this->end_controls_section();

		// Carousel Style
		$this->start_controls_section(
			'carousel_style',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_dots_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-button-carousel', 'ecomus-carousel--elementor', 'swiper' ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-button-carousel__inner', 'swiper-wrapper' ] );
		$this->add_render_attribute( 'inner', 'style', $this->render_space_between_style( $settings['space_between']['size'] ) );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
		echo '<div ' . $this->get_render_attribute_string( 'inner' ) . '>';


		foreach( $settings['buttons'] as $index => $slide ) {
			$item_key  		= $this->get_repeater_setting_key( 'item', 'button_carousel', $index );
			$this->add_render_attribute( $item_key, 'class', [ 'ecomus-button-carousel__item', 'swiper-slide' ] );

			echo '<div ' . $this->get_render_attribute_string( $item_key ) . '>';
			$this->render_button($slide, $index);
			echo '</div>';
		}

		echo '</div>';
		echo $this->render_pagination();
		echo '</div>';
	}

	/**
	 * Render button widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
	}

}
