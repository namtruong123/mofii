<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Stores Location widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Store_Locations extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Stores Location widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-store-locations';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve Stores Location widget title
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( '[Ecomus] Store Locations', 'ecomus-addons' );
	}

	/**
	 * Get widget icon
	 *
	 * Retrieve TeamMemberGrid widget icon
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'eicon-map-pin';
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
		return [ 'stores', 'location', 'locations', 'map', 'ecomus-addons' ];
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

	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'ecomus-addons' ),
			]
		);

		$repeater = new Repeater();

        $repeater->add_control(
			'title', [
				'label' => esc_html__( 'Store title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'address',
			[
				'label' => esc_html__( 'Location', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
					],
				],
				'ai' => [
					'active' => false,
				],
				'placeholder' => esc_html__( 'London Eye, London, United Kingdom', 'ecomus-addons' ),
				'default' => esc_html__( 'London Eye, London, United Kingdom', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'phone', [
				'label' => esc_html__( 'Phone', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'email', [
				'label' => esc_html__( 'Email', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'locations',
			[
				'label' => esc_html__( 'Locations', 'ecomus-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
                        'title' => esc_html__( 'Store Title', 'ecomus-addons' ),
                        'location' => esc_html__( 'London Eye, London, United Kingdom', 'ecomus-addons' ),
                        'phone' => esc_html__( '(+00) 123 4567', 'ecomus-addons' ),
                        'email' => esc_html__( 'info@example.com', 'ecomus-addons' ),
					],
					[
                        'title' => esc_html__( 'Store Title', 'ecomus-addons' ),
                        'location' => esc_html__( 'London Eye, London, United Kingdom', 'ecomus-addons' ),
                        'phone' => esc_html__( '(+00) 123 4567', 'ecomus-addons' ),
                        'email' => esc_html__( 'info@example.com', 'ecomus-addons' ),
					],
					[
                        'title' => esc_html__( 'Store Title', 'ecomus-addons' ),
                        'location' => esc_html__( 'London Eye, London, United Kingdom', 'ecomus-addons' ),
                        'phone' => esc_html__( '(+00) 123 4567', 'ecomus-addons' ),
                        'email' => esc_html__( 'info@example.com', 'ecomus-addons' ),
					],
				],
			]
		);

        $this->add_control(
			'zoom',
			[
				'label' => esc_html__( 'Zoom', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 12,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 1440,
					],
				],
				'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style() {
		// Style
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Map Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-store-locations' => '--em-rounded-iframe: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-store-locations' => '--em-rounded-iframe: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-store-locations', 'em-flex' ] );
		$this->add_render_attribute( 'tabs', 'class', [ 'ecomus-store-locations__tabs', 'em-relative' ] );
		$this->add_render_attribute( 'tabs_scroll', 'class', [ 'ecomus-store-locations__scroll', 'em-flex', 'em-flex-column', 'em-absolute' ] );
		$this->add_render_attribute( 'tab', 'class', 'ecomus-store-locations__tab' );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-store-locations__title', 'em-flex', 'em-flex-align-center' ] );
		$this->add_render_attribute( 'info', 'class', 'ecomus-store-locations__info' );
		$this->add_render_attribute( 'span', 'class', 'em-font-semibold' );

        $tabs = [];
        $tab  = [];

        $i = 0;
        foreach ( $settings['locations'] as $location ) :
            if ( empty( $location['address'] ) ) {
                return;
            }

            if( $i == 0 ) {
                $this->add_render_attribute( 'content', 'class', 'active' );
            } else {
                $this->remove_render_attribute( 'content' );
            }

            $this->add_render_attribute( 'content', 'class', 'ecomus-store-locations__content' );

            $this->add_render_attribute( 'content', 'data-tab', 'tab-' . $i );

            $title   = ! empty( $location['title'] ) ? '<div '. $this->get_render_attribute_string( 'title' ) .'>' .\Ecomus\Addons\Helper::get_svg( 'location' ) . wp_kses_post( $location['title'] ) .'</div>' : '';
            $address = ! empty( $location['address'] ) ? '<div '. $this->get_render_attribute_string( 'info' ) .'><span '. $this->get_render_attribute_string( 'span' ) .'>'. esc_html__( 'Address', 'ecomus-addons' ) .'</span><div>'. wp_kses_post( $location['address'] ) .'</div></div>' : '';
            $phone   = ! empty( $location['phone'] ) ? '<div '. $this->get_render_attribute_string( 'info' ) .'><span '. $this->get_render_attribute_string( 'span' ) .'>'. esc_html__( 'Phone', 'ecomus-addons' ) .'</span><div>'. wp_kses_post( $location['phone'] ) .'</div></div>' : '';
            $email   = ! empty( $location['email'] ) ? '<div '. $this->get_render_attribute_string( 'info' ) .'><span '. $this->get_render_attribute_string( 'span' ) .'>'. esc_html__( 'Email', 'ecomus-addons' ) .'</span><div>'. wp_kses_post( $location['email'] ) .'</div></div>' : '';

            $tabs[] = sprintf(
                            '<div %s>
                                %s
                                %s
                                %s
                                %s
                            </div>',
                            $this->get_render_attribute_string( 'content' ),
                            $title,
                            $address,
                            $phone,
                            $email,
                        );

            if ( 0 === absint( $settings['zoom']['size'] ) ) {
                $settings['zoom']['size'] = 10;
            }

            $params = [
                rawurlencode( $location['address'] ),
                absint( $settings['zoom']['size'] ),
            ];

            $url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';

            if( $i == 0 ) {
                $this->add_render_attribute( 'embed', 'class', 'active' );
            } else {
                $this->remove_render_attribute( 'embed' );
            }

            $this->add_render_attribute( 'embed', 'class', 'ecomus-store-locations__embed' );
            $this->add_render_attribute( 'embed', 'data-tab', 'tab-' . $i );

            $tab[] = sprintf(
                            '<div %s>
                                <iframe loading="lazy"
                                        src="%s"
                                        title="%s"
                                        aria-label="%s"
                                        width="950"
                                        height="985"
                                ></iframe>
                            </div>',
                            $this->get_render_attribute_string( 'embed' ),
                            esc_url( vsprintf( $url, $params ) ),
                            esc_attr( $location['address'] ),
                            esc_attr( $location['address'] )
                        );
            $i++;
        endforeach;
        ?>
        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <div <?php $this->print_render_attribute_string( 'tabs' ); ?>>
                <div <?php $this->print_render_attribute_string( 'tabs_scroll' ); ?>>
                    <?php echo implode( '', $tabs ); ?>
                </div>
            </div>
            <div <?php $this->print_render_attribute_string( 'tab' ); ?>>
                <?php echo implode( '', $tab ); ?>
            </div>
        </div>
    <?php
	}
}