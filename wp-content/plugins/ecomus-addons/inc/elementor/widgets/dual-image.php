<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Collage Images widget
 */
class Dual_Image extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-dual-image';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( '[Ecomus] Collage Images', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
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
		return [ 'image', 'dual', 'photo', 'ecomus-addons' ];
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
			'section_options',
			[
				'label' => __( 'Images', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Layout 1', 'ecomus-addons' ),
					'2' => esc_html__( 'Layout 2', 'ecomus-addons' ),
					'3' => esc_html__( 'Layout 3', 'ecomus-addons' ),
					'4' => esc_html__( 'Layout 4', 'ecomus-addons' ),
				],
			]
		);

        $this->add_responsive_control(
			'primary_image',
			[
				'label'   => esc_html__( 'Primary Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://placehold.co/490x536?text=Primary+Image',
				],
			]
		);

		$this->add_control(
			'primary_link_to',
			[
				'label' => esc_html__( 'Primary Link', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'ecomus-addons' ),
					'custom' => esc_html__( 'Custom URL', 'ecomus-addons' ),
				],
				'condition' => [
					'primary_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'primary_link',
			[
				'label' => esc_html__( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'primary_image[url]!' => '',
					'primary_link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'primary_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__primary-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-dual-image__primary-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'secondary_image',
			[
				'label'   => esc_html__( 'Secondary Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://placehold.co/337x388?text=Secondary+Image',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'secondary_link_to',
			[
				'label' => esc_html__( 'Secondary Link', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'ecomus-addons' ),
					'custom' => esc_html__( 'Custom URL', 'ecomus-addons' ),
				],
				'condition' => [
					'secondary_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_link',
			[
				'label' => esc_html__( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'secondary_image[url]!' => '',
					'secondary_link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'secondary_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__secondary-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-dual-image__secondary-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'third_image',
			[
				'label'   => esc_html__( 'Third Image', 'ecomus-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'third_link_to',
			[
				'label' => esc_html__( 'Third Link', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'ecomus-addons' ),
					'custom' => esc_html__( 'Custom URL', 'ecomus-addons' ),
				],
				'condition' => [
					'third_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'third_link',
			[
				'label' => esc_html__( 'Link', 'ecomus-addons' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'third_image[url]!' => '',
					'third_link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'third_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__third-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-dual-image__third-image' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Style', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_primary_heading',
			[
				'label' => esc_html__( 'Primary Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'image_primary_grid_column',
			[
				'label' => esc_html__( 'Grid Column', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Eg: 1/10', 'textdomain' ),
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__primary-image' => 'grid-column: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_primary_grid_row',
			[
				'label' => esc_html__( 'Grid Row', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Eg: 1/11', 'textdomain' ),
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__primary-image' => 'grid-row: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_second_heading',
			[
				'label' => esc_html__( 'Second Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_second_grid_column',
			[
				'label' => esc_html__( 'Grid Column', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Eg: 7/13', 'textdomain' ),
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__secondary-image' => 'grid-column: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_second_grid_row',
			[
				'label' => esc_html__( 'Grid Row', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Eg: 5/12', 'textdomain' ),
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__secondary-image' => 'grid-row: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_third_heading',
			[
				'label' => esc_html__( 'Third Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_third_grid_column',
			[
				'label' => esc_html__( 'Grid Column', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Eg: 1/10', 'textdomain' ),
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__third-image' => 'grid-column: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_third_grid_row',
			[
				'label' => esc_html__( 'Grid Row', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Eg: 1/11', 'textdomain' ),
				'selectors'  => [
					'{{WRAPPER}} .ecomus-dual-image__third-image' => 'grid-row: {{VALUE}};',
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

		$classes = $settings['layout'] == '2' ? 'em-eff-img-zoom' : '';
		$classes = ! empty( $settings['third_image']['url'] ) ? '' : $classes;

		$this->add_render_attribute( 'wrapper', 'class', [
			'ecomus-dual-image-elementor',
			'ecomus-dual-image--layout-' . esc_attr( $settings['layout'] ),
			'em-relative' ] );
		$this->add_render_attribute( 'primary-image', 'class', [ 'ecomus-dual-image__primary-image em-ratio', esc_attr( $classes ) ] );
		$this->add_render_attribute( 'secondary-image', 'class', [ 'ecomus-dual-image__secondary-image em-ratio', esc_attr( $classes ) ] );
		$this->add_render_attribute( 'third-image', 'class', [ 'ecomus-dual-image__third-image em-ratio', esc_attr( $classes ) ] );

		if ( $settings['primary_link_to'] == 'custom' ) {
			$this->add_link_attributes( 'primary_link', $settings['primary_link'] );
			$this->add_render_attribute( 'primary_link', 'class', 'ecomus-button-link' );
		}

		if ( $settings['secondary_link_to'] == 'custom' ) {
			$this->add_link_attributes( 'secondary_link', $settings['secondary_link'] );
			$this->add_render_attribute( 'secondary_link', 'class', 'ecomus-button-link' );
		}

		if ( $settings['third_link_to'] == 'custom' ) {
			$this->add_link_attributes( 'third_link', $settings['third_link'] );
			$this->add_render_attribute( 'third_link', 'class', 'ecomus-button-link' );
		}
		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'primary-image' ); ?>>
				<?php
					if ( $settings['primary_link_to'] == 'custom' && ! empty( $settings['primary_link']['url'] )) {
						echo '<a '. $this->get_render_attribute_string( 'primary_link' ) .'>';
					}
				?>
				<?php
					if ( $settings['primary_image']['url'] ) {
						$image_args = [
							'image'        => ! empty( $settings['primary_image'] ) ? $settings['primary_image'] : '',
							'image_tablet' => ! empty( $settings['primary_image_tablet'] ) ? $settings['primary_image_tablet'] : '',
							'image_mobile' => ! empty( $settings['primary_image_mobile'] ) ? $settings['primary_image_mobile'] : '',
						];
						echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args );
					}
				?>
				<?php
					if ( $settings['primary_link_to'] == 'custom' && ! empty( $settings['primary_link']['url'] )) {
						echo '</a>';
					}
				?>
			</div>
			<div <?php echo $this->get_render_attribute_string( 'secondary-image' ); ?>>
				<?php
					if ( $settings['secondary_link_to'] == 'custom' && ! empty( $settings['secondary_link']['url'] )) {
						echo '<a '. $this->get_render_attribute_string( 'secondary_link' ) .'>';
					}
				?>
					<?php
						if ( $settings['secondary_image'] ) {
							$image_args = [
								'image'        => ! empty( $settings['secondary_image'] ) ? $settings['secondary_image'] : '',
								'image_tablet' => ! empty( $settings['secondary_image_tablet'] ) ? $settings['secondary_image_tablet'] : '',
								'image_mobile' => ! empty( $settings['secondary_image_mobile'] ) ? $settings['secondary_image_mobile'] : '',
							];
							echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args );
						}
					?>
				<?php
					if ( $settings['secondary_link_to'] == 'custom' && ! empty( $settings['secondary_link']['url'] )) {
						echo '</a>';
					}
				?>
			</div>
			<?php if ( $settings['third_image']['url'] ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'third-image' ); ?>>
					<?php
						if ( $settings['third_link_to'] == 'custom' && ! empty( $settings['third_link']['url'] )) {
							echo '<a '. $this->get_render_attribute_string( 'third_link' ) .'>';
						}
					?>
						<?php
							if ( $settings['third_image'] ) {
								$image_args = [
									'image'        => ! empty( $settings['third_image'] ) ? $settings['third_image'] : '',
									'image_tablet' => ! empty( $settings['third_image_tablet'] ) ? $settings['third_image_tablet'] : '',
									'image_mobile' => ! empty( $settings['third_image_mobile'] ) ? $settings['third_image_mobile'] : '',
								];
								echo \Ecomus\Addons\Helper::get_responsive_image_elementor( $image_args );
							}
						?>
					<?php
						if ( $settings['third_link_to'] == 'custom' && ! empty( $settings['third_link']['url'] )) {
							echo '</a>';
						}
					?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
