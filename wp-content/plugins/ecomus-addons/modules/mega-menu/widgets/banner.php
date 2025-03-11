<?php
/**
 * Widget Image
 */

namespace Ecomus\Addons\Modules\Mega_Menu\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Banner widget class
 */
class Banner extends Widget_Base {

	/**
	 * Set the widget name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'banner';
	}

	/**
	 * Set the widget label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Banner', 'ecomus-addons' );
	}

	/**
	 * Default widget options
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'image'  		=> array( 'id' => '', 'url' => '' ),
			'link'   		=> array( 'url' => '', 'target' => '' ),
			'title'  		=> '',
			'ratio'  		=> 'vertical',
			'aspect_ratio' 	=> '',
		);
	}

	/**
	 * Render widget content
	 */
	public function render() {
		$data = $this->get_data();

		$this->render_link_open( $data['link'] );

		$classes = $data['classes'] ? ' ' . $data['classes'] : '';
		$ratio = '';

		if ( $data['ratio'] ) {
			$ratio = $this->render_aspect_ratio_style();
		}

		echo '<div class="menu-widget-banner em-ratio em-eff-img-zoom em-image-rounded em-responsive'. esc_attr( $classes ) .'" '. $ratio .'>';

		if ( $data['image'] ) {
			$this->render_image( $data['image'], 'full', array( 'alt' => esc_html__( 'Mega Menu Banner', 'ecomus-addons' ) . $data['image']['id'] ) );
		}

		if ( $data['title'] ) {
			echo sprintf(
				'<span class="menu-widget-banner__title em-button em-button-light em-font-medium">
					<span class="menu-widget-banner__text">%s</span>
					%s
				</span>',
				wp_kses_post( $data['title'] ),
				\Ecomus\Addons\Helper::get_svg( 'arrow-top' )
			);
		}

		echo '</div>';

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
			'type' => 'select',
			'name' => 'ratio',
			'label' => __( 'Ratio', 'ecomus-addons' ),
			'options' => array(
				'square'     => __( 'Square', 'ecomus-addons' ),
				'vertical'   => __( 'Vertical rectangle', 'ecomus-addons' ),
				'horizontal' => __( 'Horizontal rectangle', 'ecomus-addons' ),
				'custom'     => __( 'Custom', 'ecomus-addons' ),
			),
		) );

		$this->add_control( array(
			'type' => 'text',
			'label'       => __( 'Aspect ratio (Eg: 3:4)', 'ecomus-addons' ),
			'description' => __( 'When you choose the "Custom" ratio, the image will be cropped to fit the specified aspect ratio.', 'ecomus-addons' ),
			'name' => 'aspect_ratio',
		) );

		$this->add_control( array(
			'type' => 'text',
			'label' => __( 'Title', 'ecomus-addons' ),
			'name' => 'title',
		) );

		$this->add_control( array(
			'type' => 'link',
			'name' => 'link',
		) );
	}

	/**
	 * Render aspect ratio style
	 *
	 * @return void
	 */
    protected function render_aspect_ratio_style() {
		$data = $this->get_data();
		$aspect_ratio = 1;

        if( $data['ratio'] == 'vertical' ) {
            $aspect_ratio = 0.79;
        }

        if( $data['ratio'] == 'horizontal' ) {
            $aspect_ratio = 1.3678977272727273;
        }

        if( $data['ratio'] == 'custom' && ! empty( $data['aspect_ratio'] ) ) {
            if( ! is_numeric( $data['aspect_ratio'] ) ) {
                $cropping_split = explode( ':', $data['aspect_ratio'] );
                $width          = max( 1, (float) current( $cropping_split ) );
                $height         = max( 1, (float) end( $cropping_split ) );
                $aspect_ratio   = floatval( $width / $height );
            } else {
                $aspect_ratio = $data['aspect_ratio'];
            }
        }

        return 'style="--em-ratio-percent: '. round( 100 / $aspect_ratio ) . '%;"';
    }
}