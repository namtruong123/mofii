<?php
/**
 * Social links widget
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Widgets;
/**
 * Class Ecomus_Social_Links_Widget
 */
class Social_Links extends \WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $default;

	/**
	 * List of supported socials
	 *
	 * @var array
	 */
	protected $socials;

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function __construct() {
		$socials = array(
			'facebook'    => esc_html__( 'Facebook', 'ecomus-addons' ),
			'twitter'     => esc_html__( 'Twitter', 'ecomus-addons' ),
			'google-plus' => esc_html__( 'Google Plus', 'ecomus-addons' ),
			'tumblr'      => esc_html__( 'Tumblr', 'ecomus-addons' ),
			'linkedin'    => esc_html__( 'Linkedin', 'ecomus-addons' ),
			'pinterest'   => esc_html__( 'Pinterest', 'ecomus-addons' ),
			'flickr'      => esc_html__( 'Flickr', 'ecomus-addons' ),
			'instagram'   => esc_html__( 'Instagram', 'ecomus-addons' ),
			'dribbble'    => esc_html__( 'Dribbble', 'ecomus-addons' ),
			'behance'     => esc_html__( 'Behance', 'ecomus-addons' ),
			'github'      => esc_html__( 'Github', 'ecomus-addons' ),
			'youtube'     => esc_html__( 'Youtube', 'ecomus-addons' ),
			'vimeo'       => esc_html__( 'Vimeo', 'ecomus-addons' ),
			'rss'         => esc_html__( 'RSS', 'ecomus-addons' ),
			'tiktok'         => esc_html__( 'Tiktok', 'ecomus-addons' ),
			'telegram' => esc_html__( 'Telegram', 'ecomus-addons' ),
			'whatsapp'    => esc_html__( 'Whatsapp', 'ecomus-addons' ),
			'discord'    => esc_html__( 'Discord', 'ecomus-addons' ),
			'reddit'    => esc_html__( 'Reddit', 'ecomus-addons' ),
		);

		$this->socials = apply_filters( 'ecomus_social_media', $socials );
		$this->default = array(
			'title' => '',
			'type' => 'outline',
		);

		foreach ( $this->socials as $k => $v ) {
			$this->default["{$k}_title"] = $v;
			$this->default["{$k}_url"]   = '';
		}

		parent::__construct(
			'social-links-widget',
			esc_html__( 'Ecomus - Social Links', 'ecomus-addons' ),
			array(
				'classname'                   => 'ecomus-widget__social-links',
				'description'                 => esc_html__( 'Display links to social media networks.', 'ecomus-addons' ),
				'customize_selective_refresh' => true,
			),
			array( 'width' => 600 )
		);
	}

	/**
	 * Outputs the HTML for this widget.
     *
	 * @since 1.0.0
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 *
	 * @return void Echoes it's output
	 */
	function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->default );

		echo $args['before_widget'];

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div class="social-links">';

		foreach ( $this->socials as $social => $label ) {
			if ( empty( $instance[ $social . '_url' ] ) ) {
				continue;
			}

			$icon = $social;

			if ( 'google-plus' == $social ) {
				$icon = 'google';
			}

			printf(
				'<a href="%s" class="em-socials--%s social em-button-%s" rel="nofollow" title="%s" data-placement="top" target="_blank">%s</a>',
				esc_url( $instance[ $social . '_url' ] ),
				esc_attr( $social ),
				esc_attr( $instance['type'] ),
				esc_attr( $instance[ $social . '_title' ] ),
				\Ecomus\Addons\Helper::get_svg( $icon, '', 'social' )
			);
		}

		echo '</div>';

		echo $args['after_widget'];
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
	 * @since 1.0.0
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->default );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'ecomus-addons' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Type', 'ecomus-addons' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
				<option value="outline" <?php selected( 'outline', $instance['type'] ) ?>><?php esc_html_e( 'Outline', 'ecomus-addons' ) ?></option>
				<option value="text" <?php selected( 'text', $instance['type'] ) ?>><?php esc_html_e( 'Text', 'ecomus-addons' ) ?></option>
				<option value="solid" <?php selected( 'solid', $instance['type'] ) ?>><?php esc_html_e( 'Solid', 'ecomus-addons' ) ?></option>
			</select>
		</p>

		<?php
		foreach ( $this->socials as $social => $label ) {
			printf(
				'<div style="width: 280px; float: left; margin-right: 10px;">
					<label>%s</label>
					<p><input type="text" class="widefat" name="%s" placeholder="%s" value="%s"></p>
				</div>',
				$label,
				$this->get_field_name( $social . '_url' ),
				esc_html__( 'URL', 'ecomus-addons' ),
				$instance[ $social . '_url' ]
			);
		}
	}
}
