<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Sidebar extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-sidebar';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Sidebar', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-sidebar';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'title', 'heading', 'product' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-product-elementor-widgets'
		];
	}

	/**
	 * Get HTML wrapper class.
	 *
	 * Retrieve the widget container class. Can be used to override the
	 * container class for specific widgets.
	 *
	 * @since 2.0.9
	 * @access protected
	 */
	protected function get_html_wrapper_class() {
		return 'elementor-widget-' . $this->get_name() . ' entry-summary';
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
		$this->section_content();
		$this->section_style();
	}

    protected function section_content() {
        $this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
			]
		);

		$this->add_responsive_control(
			'sidebar_type',
			[
				'label'       => esc_html__( 'Type', 'ecomus-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'panel'   => esc_html__( 'Panel', 'ecomus-addons' ),
					'sidebar' => esc_html__( 'Sidebar', 'ecomus-addons' ),
				],
				'default'     => 'panel',
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
				'source'      => 'page,elementor_library',
				'sortable'    => true,
				'label_block' => true,
			]
		);

		$this->add_control(
			'toggle_heading',
			[
				'label'       => esc_html__( 'Toggle Heading', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
				'frontend_available' => true
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
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
				'placeholder' => __( 'Open Sidebar', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'position',
			[
				'label' => esc_html__( 'Position', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'ecomus-addons' ),
					'right' => esc_html__( 'Right', 'ecomus-addons' ),
				],
				'default' => 'right',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_panel',
			[
				'label' => esc_html__( 'Panel', 'ecomus-addons' ),
			]
		);

        $this->add_control(
			'icon_panel',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'text_panel',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Sidebar Product', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

        $this->end_controls_section();
    }

    protected function section_style() {
        $this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sidebar-panel__button' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .sidebar-panel__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .sidebar-panel__button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'icon_heading',
			[
				'label'     => esc_html__( 'Icon', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .sidebar-panel__button .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sidebar-panel__button .ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'text_heading',
			[
				'label'     => esc_html__( 'Text', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'text_max_width',
			[
				'label' => esc_html__( 'Max width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .sidebar-panel__button:hover .button-text' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .sidebar-panel__button .button-text',
			]
		);

        $this->add_control(
			'text_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sidebar-panel__button .button-text' => 'color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_panel_style',
			[
				'label' => esc_html__( 'Panel Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'panel_max_width',
			[
				'label' => esc_html__( 'Max width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__container' => '--em-panel-content-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'panel_background_color',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__container' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'panel_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart .single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'panel_header_heading',
			[
				'label'     => esc_html__( 'Header', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'panel_header_typography',
				'selector' => '.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__header',
			]
		);

        $this->add_control(
			'panel_header_color',
			[
				'label' => __( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__header' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'panel_header_background_color',
			[
				'label' => __( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__header' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'panel_header_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__button-close' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'panel_header_icon_color',
			[
				'label' => __( 'Icon Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product-sidebar-panel--elementor.single-product-sidebar-panel .sidebar__button-close' => 'color: {{VALUE}}',
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
		$class_desktop = 'desktop-' . $settings['sidebar_type'];
		$class_tablet = ! empty( $settings['sidebar_type_tablet'] ) ? 'tablet-' . $settings['sidebar_type_tablet'] : 'tablet-' . $settings['sidebar_type'];
		$mobile = ! empty( $settings['sidebar_type_tablet'] ) ? $settings['sidebar_type_tablet'] : $settings['sidebar_type'];
		$class_mobile = ! empty( $settings['sidebar_type_mobile'] ) ? 'mobile-' . $settings['sidebar_type_mobile'] : 'mobile-' . $mobile;
		$classes = esc_attr( $class_desktop ) .' '. esc_attr( $class_tablet ) .' '. esc_attr( $class_mobile );

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			echo '<h6 class="product-sidebar-conditions text-center em-font-semibold '. esc_attr( $classes ) .'">'. esc_html__( 'The product sidebar widget is using absolute positioning to be anchored to the right side of the viewport, overriding normal document flow.', 'ecomus-addons' ) .'</h6>';
		}
		?>
		<div class="single-product-sidebar-panel__button sidebar-panel__button sidebar-panel__button--<?php echo esc_attr( $settings['position'] ); ?> em-fixed em-flex em-flex-align-center product-sidebar-conditions <?php echo esc_attr( $classes ); ?>" data-toggle="off-canvas" data-target="single-product-sidebar-panel">
			<?php
				if( ! empty( $settings['icon']['value'] ) ) {
					echo '<span class="ecomus-svg-icon ecomus-svg-icon--sidebar">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
				} else {
					echo \Ecomus\Addons\Helper::get_svg( 'sidebar' );
				}
			?>
			<span class="button-text em-font-medium"><?php echo ! empty( $settings['text'] ) ? $settings['text'] : esc_html__( 'Open Sidebar', 'ecomus' ); ?></span>
		</div>
		<?php
		$this->sidebar_panel( $classes );
	}

    public function sidebar_panel( $classes ) {
        $settings = $this->get_settings_for_display();
		$class_desktop = 'desktop-' . $settings['sidebar_type'];
		$class_tablet = ! empty( $settings['sidebar_type_tablet'] ) ? 'tablet-' . $settings['sidebar_type_tablet'] : 'tablet-' . $settings['sidebar_type'];
		$mobile = ! empty( $settings['sidebar_type_tablet'] ) ? $settings['sidebar_type_tablet'] : $settings['sidebar_type'];
		$class_mobile = ! empty( $settings['sidebar_type_mobile'] ) ? 'mobile-' . $settings['sidebar_type_mobile'] : 'mobile-' . $mobile;
		$class_position = esc_attr( $class_desktop ) .' '. esc_attr( $class_tablet ) .' '. esc_attr( $class_mobile );
        ?>
            <div id="single-product-sidebar-panel" class="offscreen-panel single-product-sidebar-panel single-product-sidebar-panel--elementor offscreen-panel--side-<?php echo esc_attr( $settings['position'] ); ?> product-sidebar-position <?php echo esc_attr( $classes ); ?>">
                <div class="sidebar__backdrop product-sidebar-conditions <?php echo esc_attr( $classes ); ?>"></div>
                <div class="sidebar__container product-sidebar-position <?php echo esc_attr( $classes ); ?>">
                    <?php
                        if( ! empty( $settings['icon_panel']['value'] ) ) {
                            echo '<span class="ecomus-svg-icon ecomus-svg-icon--close sidebar__button-close product-sidebar-conditions '. esc_attr( $classes ) .'">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon_panel'], [ 'aria-hidden' => 'true' ] ) . '</span>';
                        } else {
                            echo \Ecomus\Addons\Helper::get_svg( 'close', 'ui', [ 'class' => 'sidebar__button-close product-sidebar-conditions '. esc_attr( $classes ) ] );
                        }
                    ?>
                    <div class="sidebar__header product-sidebar-conditions <?php echo esc_attr( $classes ); ?>">
                        <?php echo ! empty( $settings['text_panel'] ) ? $settings['text_panel'] : esc_html__( 'Sidebar Product', 'ecomus' ); ?>
                    </div>
                    <div class="sidebar__content product-sidebar-position <?php echo esc_attr( $classes ); ?>">
                        <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( intval( $settings['page_id'] ), true ); ?>
                    </div>
                </div>
            </div>
        <?php
    }
}
