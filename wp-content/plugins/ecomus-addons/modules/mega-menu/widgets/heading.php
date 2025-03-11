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
class Heading extends Widget_Base {

	/**
	 * Set the widget name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'heading';
	}

	/**
	 * Set the widget label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Heading', 'ecomus-addons' );
	}

	/**
	 * Default widget options
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'title'  	=> '',
			'link'   	=> array( 'url' => '', 'target' => '' ),
			'type' 		=> ''
		);
	}

	/**
	 * Render widget content
	 */
	public function render() {
		$data = $this->get_data();

		$data['link']['class'] = $data['classes'] ? $data['classes'] : '';
		$data['link']['target'] = $data['link']['target'] ? $data['link']['target'] : '';

		$this->render_link_open( $data['link'] );

		if ( empty( $data['link']['url'] ) ) {
			$classes = $data['classes'] ?  'class="' . $data['classes'] . '"' : '';
			echo '<span '. $classes .'>' . wp_kses_post( $data['title'] ) . '</span>';
		} else {
			echo wp_kses_post( $data['title'] );
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
			'label' => esc_html__( 'Navigation Label', 'ecomus-addons' ),
		) );

		$this->add_control( array(
			'type' => 'link',
			'name' => 'link',
		) );

		$this->add_control( array(
			'type' => 'select',
			'name' => 'type',
			'options' => array(
				'0' 		=> esc_html__( 'Default', 'ecomus-addons' ),
				'hidden' => esc_html__( 'Hidden', 'ecomus-addons' ),
				'empty' => esc_html__( 'Empty (keep spacing)', 'ecomus-addons' )
			),
		) );
	}
}