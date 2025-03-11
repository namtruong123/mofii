<?php
namespace Ecomus\Addons\Elementor\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

trait Aspect_Ratio_Base {
	/**
	 * Register controls for products query
	 *
	 * @param array $controls
	 */
	protected function register_aspect_ratio_controls( $conditions = [], $default = [] ) {
		$default = wp_parse_args( $default, [ 'aspect_ratio_type' => 'vertical' ] );

        $this->add_control(
			'aspect_ratio_type',
			[
				'label'   => esc_html__( 'Aspect Ratio', 'ecomus-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''           => esc_html__( 'Default', 'ecomus-addons' ),
					'square'     => esc_html__( 'Square', 'ecomus-addons' ),
					'vertical'   => esc_html__( 'Vertical rectangle', 'ecomus-addons' ),
					'horizontal' => esc_html__( 'Horizontal rectangle', 'ecomus-addons' ),
					'custom'     => esc_html__( 'Custom', 'ecomus-addons' ),
				],
				'default' => $default['aspect_ratio_type'],
				'condition' => $conditions,
			]
		);

		$conditions = wp_parse_args( $conditions, [ 'aspect_ratio_type' => 'custom' ] );
        $this->add_control(
			'aspect_ratio',
			[
				'label'       => esc_html__( 'Aspect ratio (Eg: 3:4)', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Images will be cropped to aspect ratio', 'ecomus-addons' ),
				'default'     => '',
				'label_block' => false,
                'condition' => $conditions,
			]
		);
	}

	/**
	 * Render aspect ratio style
	 *
	 * @return void
	 */
    protected function render_aspect_ratio_style( $style = '', $aspect_ratio = 1 ) {
        $settings = $this->get_settings_for_display();

        if( $settings['aspect_ratio_type'] == 'vertical' ) {
            $aspect_ratio = 0.79;
        }

        if( $settings['aspect_ratio_type'] == 'horizontal' ) {
            $aspect_ratio = 1.3678977272727273;
        }

        if( $settings['aspect_ratio_type'] == 'custom' && ! empty( $settings['aspect_ratio'] ) ) {
            if( ! is_numeric( $settings['aspect_ratio'] ) ) {
                $cropping_split = explode( ':', $settings['aspect_ratio'] );
                $width          = max( 1, (float) current( $cropping_split ) );
                $height         = max( 1, (float) end( $cropping_split ) );
                $aspect_ratio   = floatval( $width / $height );
            } else {
                $aspect_ratio = $settings['aspect_ratio'];
            }
        }

		if( ! empty( $settings['aspect_ratio_type'] ) ) {
        	$style = '--em-ratio-percent: '. round( 100 / $aspect_ratio ) . '%;';
		}

        return $style;
    }
}