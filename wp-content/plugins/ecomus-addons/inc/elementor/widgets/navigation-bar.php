<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Navigation Bar widget
 */
class Navigation_Bar extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-navigation-bar';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Navigation Bar', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-nav-menu';
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
		return [ 'navigation-bar', 'navigation', 'ecomus-addons' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_content_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_content_style_controls();
	}

	protected function section_content_settings_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter title text', 'ecomus-addons' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
			]
		);

		$repeater->add_control(
			'active',
			[
				'label' => esc_html__( 'Active', 'ecomus-addons' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title'   => esc_html__( 'Item #1', 'ecomus-addons' ),
						'link'    => ['url' => '#'],
					],
					[
						'title'   => esc_html__( 'Item #2', 'ecomus-addons' ),
						'link'    => ['url' => '#'],
					],
					[
						'title'   => esc_html__( 'Item #3', 'ecomus-addons' ),
						'link'    => ['url' => '#'],
					],
					[
						'title'   => esc_html__( 'Item #4', 'ecomus-addons' ),
						'link'    => ['url' => '#'],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_style_controls() {
		// Style Icon
		$this->start_controls_section(
			'section_style_content',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-navigation-bar',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-navigation-bar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-navigation-bar' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-navigation-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-navigation-bar' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-navigation-bar' ] );
		$content_html = [];

		foreach( $settings['items'] as $index => $items ) {
			$link_key 	  = $this->get_repeater_setting_key( 'link', 'slide', $index );
			$this->add_link_attributes( $link_key, $items['link'] );

			if( ! empty( $items['link']['url'] ) ) {
				$title = '<a '. $this->get_render_attribute_string( $link_key ) .'>';
				$title .= $items['title'];
				$title .= '</a>';
			} else {
				$title = $items['title'];
			}

			$classes = $items['active'] == 'yes' ? ' active' : '';

			$content_html[] = ! empty( $items['title'] ) ? '<div class="ecomus-navigation-bar__title ecomus-navigation-bar__title-item--' . $items['_id'] . $classes . '">' . $title . \Ecomus\Addons\Helper::get_svg( 'arrow-top', 'ui', 'class=ecomus-navigation-bar__icon'  ) . ' </div>' : '';

		}

		echo sprintf( '<div %s>%s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $content_html ),
			);
	}
}