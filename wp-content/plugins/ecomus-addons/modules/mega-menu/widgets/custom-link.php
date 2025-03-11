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
class Custom_Link extends Widget_Base {

	/**
	 * Set the widget name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'custom-link';
	}

	/**
	 * Set the widget label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Custom Link', 'ecomus-addons' );
	}

	/**
	 * Default widget options
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'link'   	=> array( 'url' => '', 'target' => '' ),
			'title'  	=> '',
			'badge_new' => '',
			'badge_hot' => '',
			'badge_custom' => '',
			'badge_custom_text' => '',
		);
	}

	/**
	 * Render widget content
	 */
	public function render() {
		$data = $this->get_data();

		$data['link']['class'] = $data['classes'] ? $data['classes'] : '';
		$data['link']['target'] = $data['link']['target'] ? $data['link']['target'] : '';

		$this->render_link_open( $data['link']);

		echo '<span class="mega-menu__link-text">' . $data['title'] . '</span>';

		if ( ! empty( $data['badge_new'] ) || ! empty( $data['badge_custom'] ) || ! empty( $data['badge_hot'] ) ) {
			$classes = strlen($data['title']) > 20 ? ' text-full' : '';
			echo '<span class="mega-menu__badge-wrapper'. esc_attr( $classes ) .'">';

			if ( ! empty( $data['badge_new'] ) ) {
				echo '<span class="mega-menu__badge mega-menu__badge--new">'. esc_html__( 'New', 'ecomus-addons' ) .'</span>';
			}

			if ( ! empty( $data['badge_hot'] ) ) {
				echo '<span class="mega-menu__badge mega-menu__badge--hot">'. esc_html__( 'Hot', 'ecomus-addons' ) .'</span>';
			}

			if ( ! empty( $data['badge_custom'] ) ) {
				echo '<span class="mega-menu__badge mega-menu__badge--custom">'. esc_html( $data['badge_custom_text'] ) .'</span>';
			}

			echo '</span>';
		}

		$this->render_link_close( $data['link'] );
	}

	/**
	 * Widget setting fields.
	 */
	public function add_controls() {
		$this->add_control( array(
			'type' => 'text',
			'name' => 'title',
			'label' => esc_html__( 'Link Text', 'ecomus-addons' ),
		) );

		$this->add_control( array(
			'type' => 'link',
			'name' => 'link',
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
			'name' => 'badge_hot',
			'label' => esc_html__( 'Enable hot badge', 'ecomus-addons' ),
			'options' => [
				'value' => ''
			]
		) );

		$this->add_control( array(
			'type' => 'checkbox',
			'name' => 'badge_custom',
			'label' => esc_html__( 'Enable custom badge', 'ecomus-addons' ),
			'options' => [
				'value' => ''
			]
		) );

		$this->add_control( array(
			'type' => 'text',
			'name' => 'badge_custom_text',
			'label' => esc_html__( 'Custom badge text', 'ecomus-addons' ),
		) );
	}
}