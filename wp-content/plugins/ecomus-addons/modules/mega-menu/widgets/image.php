<?php
/**
 * Widget Image
 */

namespace Ecomus\Addons\Modules\Mega_Menu\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Image widget class
 */
class Image extends Widget_Base {

	/**
	 * Set the widget name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'image';
	}

	/**
	 * Set the widget label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Image Box', 'ecomus-addons' );
	}

	/**
	 * Default widget options
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'image'  => array( 'id' => '', 'url' => '' ),
			'link'   => array( 'url' => '', 'target' => '' ),
			'button' => '',
			'badge_new' => '',
			'badge_trend' => '',
			'badge_hot' => '',
		);
	}

	/**
	 * Render widget content
	 */
	public function render() {
		$data = $this->get_data();

		$this->render_link_open( $data['link'] );
		echo '<div class="menu-widget-image">';
		$this->render_image( $data['image'], 'full', array( 'alt' => esc_html__( 'Mega Menu Image', 'ecomus-addons' ) . $data['image']['id'] ) );

		if ( ! empty( $data['badge_new'] ) || ! empty( $data['badge_trend'] ) || ! empty( $data['badge_hot'] ) ) {
			echo '<span class="mega-menu__badge-wrapper">';

			if ( ! empty( $data['badge_new'] ) ) {
				echo '<span class="mega-menu__badge mega-menu__badge--new">'. esc_html__( 'New', 'ecomus-addons' ) .'</span>';
			}

			if ( ! empty( $data['badge_trend'] ) ) {
				echo '<span class="mega-menu__badge mega-menu__badge--trend">'. esc_html__( 'Trend', 'ecomus-addons' ) .'</span>';
			}

			if ( ! empty( $data['badge_hot'] ) ) {
				echo '<span class="mega-menu__badge mega-menu__badge--hot">'. esc_html__( 'Hot', 'ecomus-addons' ) .'</span>';
			}

			echo '</span>';
		}

		echo '</div>';

		echo '<span class="menu-widget-image__button">' . esc_html( $data['button'] ) . '</span>';

		$this->render_link_close( $data['link'] );

	}

	/**
	 * Widget setting fields.
	 */
	public function add_controls() {
		$this->add_control( array(
			'type' => 'image',
			'label' => __( 'Image', 'ecomus-addons' ),
			'name' => 'image',
		) );

		$this->add_control( array(
			'type' => 'link',
			'name' => 'link',
		) );

		$this->add_control( array(
			'type' => 'text',
			'name' => 'button',
			'label' => __( 'Button', 'ecomus-addons' ),
		) );

		$this->add_control( array(
			'type' => 'checkbox',
			'name' => 'badge_new',
			'label' => esc_html__( 'Enable new badge', 'ecomus-addons' ),
			'options' => [
				'value' => ''
			]
		) );

		$this->add_control( array(
			'type' => 'checkbox',
			'name' => 'badge_trend',
			'label' => esc_html__( 'Enable trend badge', 'ecomus-addons' ),
			'options' => [
				'value' => ''
			]
		) );

		$this->add_control( array(
			'type' => 'checkbox',
			'name' => 'badge_hot',
			'label' => esc_html__( 'Enable hot badge', 'ecomus-addons' ),
			'options' => [
				'value' => ''
			]
		) );
	}
}