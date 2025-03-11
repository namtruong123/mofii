<?php
/**
 * Theme widgets for WooCommerce.
 *
 * @package Ecomus
 */

namespace Ecomus\Addons\Widgets;

use \Ecomus\Addons\Helper;

/**
 * Icon Box widget class.
 */
class IconBox extends \WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $default;


	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->defaults = array(
			'title'         => '',
			'box'           => array(),
			'style'        => 'normal',
		);

		if ( is_admin() ) {
			$this->admin_hooks();
		}

		parent::__construct(
			'ecomus-icon-box',
			esc_html__( 'Ecomus - Icon Box', 'ecomus-addons' ),
			array(
				'classname'                   => 'icon-box-widget',
				'customize_selective_refresh' => true,
			),
			array( 'width' => 560 )
		);
	}

	/**
	 * Admin hooks
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, '_setting_fields_template' ) );
		add_action( 'admin_footer', array( $this, '_setting_fields_template' ) );
	}

	/**
	 * Output the widget content.
	 *
	 * @since 1.0.0
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments
	 * @param array $instance Saved values from database
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		echo $args['before_widget'];

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		if ( ! empty( $instance['box'] ) ) {
			?><div class="ecomus-icon-box-widget"><?php
				foreach ( $instance['box'] as $box ) {
					$tag = ! empty( $box['link'] ) ? 'a' : 'div';
					$href = ! empty( $box['link'] ) ? 'href=' . esc_url( $box['link'] ) : '';
					?>
					<<?php echo $tag; ?> <?php echo esc_attr( $href ); ?> class="ecomus-icon-box-widget__item <?php echo esc_attr( $instance['style'] ); ?>">
						<?php if ( $box['icon'] ) : ?>
							<span class="ecomus-icon-box-widget__icon ecomus-svg-icon"><?php echo \Ecomus\Addons\Helper::sanitize_svg( $box['icon'] ); ?></span>
						<?php endif; ?>
						<div class="ecomus-icon-box-widget__text">
							<?php if ( $box['text'] ) : ?>
								<div class="ecomus-icon-box-widget__title"><?php echo wp_kses_post( $box['text'] ); ?></div>
							<?php endif; ?>
							<?php if ( !empty($box['desc']) ) : ?>
								<div class="ecomus-icon-box-widget__desc"><?php echo wp_kses_post( $box['desc'] ); ?></div>
							<?php endif; ?>
						</div>
					</<?php echo $tag;?>>
					<?php
				}
			?></div><?php
		}

		echo $args['after_widget'];
	}

	/**
	 * Outputs the settings form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'ecomus-addons' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<div class="ecomus-icon-box__tabs">
			<a href="#" class="ecomus-icon-box__section active" data-tab="ecomus-icon-box__section"><?php esc_html_e( 'Settings', 'ecomus-addons' ); ?></a>
			<a href="#" class="ecomus-icon-box__style" data-tab="ecomus-icon-box__style"><?php esc_html_e( 'Style', 'ecomus-addons' ); ?></a>
		</div>
		<hr/>
		<div class="ecomus-icon-box__section ecomus-icon-box__tab active">
			<div class="ecomus-icon-box__fields">
				<?php $this->_setting_fields( $instance['box'] ); ?>
			</div>

			<p class="ecomus-icon-box__actions">
				<button type="button" class="ecomus-icon-box__add-new button-link" data-name="<?php echo esc_attr( $this->get_field_name( 'box' ) ); ?>" data-count="<?php echo count( $instance['box'] ) ?>">+ <?php esc_html_e( 'Add a new box', 'ecomus-addons' ) ?></button>
			</p>
		</div>
		<div class="ecomus-icon-box__style ecomus-icon-box__tab">
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style', 'ecomus-addons' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
					<option value="horizontal" <?php selected( 'horizontal', $instance['style'] ) ?>><?php esc_html_e( 'Horizontal', 'ecomus-addons' ) ?></option>
					<option value="vertical" <?php selected( 'vertical', $instance['style'] ) ?>><?php esc_html_e( 'Vertical', 'ecomus-addons' ) ?></option>
				</select>
			</p>
		</div>

		<?php
	}

	/**
	 * Get the setting array fields.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_fields_settings() {
		if ( isset( $this->box_settings ) ) {
			return $this->box_settings;
		}

		$this->box_settings = array(
			'icon' => array(
				'type' => 'textarea',
				'label' => __( 'Icon', 'ecomus-addons' ),
			),
			'text' => array(
				'type' => 'textarea',
				'label' => __( 'Title', 'ecomus-addons' ),
			),
			'desc' => array(
				'type' => 'textarea',
				'label' => __( 'Description', 'ecomus-addons' ),
			),
			'link' => array(
				'type' => 'text',
				'label' => __( 'Link', 'ecomus-addons' ),
			),
		);

		return $this->box_settings;
	}

	/**
	 * Display sets of filter setting fields
	 *
	 * @since 1.0.0
	 *
	 * @param string $context
	 */
	protected function _setting_fields( $fields = array(), $context = 'display' ) {
		$box_settings = $this->get_fields_settings();
		$_fields   = 'display' == $context ? $fields : array( 1 );

		foreach ( $_fields as $index => $field ) :
			$title = ! empty( $field['text'] ) ? $field['text'] : esc_html__( 'Item', 'ecomus-addons' );
			?>
			<div class="ecomus-icon-box__field">
				<div class="ecomus-icon-box__field-top">
					<button type="button" class="ecomus-icon-box__field-toggle">
						<span class="ecomus-icon-box__field-toggle-indicator" aria-hidden="true"></span>
					</button>

					<div class="ecomus-icon-box__field-title"><?php echo $title; ?></div>

					<div class="ecomus-icon-box__field-actions">
						<button type="button" class="ecomus-icon-box__remove button-link button-link-delete">
							<span class="screen-reader-text"><?php esc_html_e( 'Remove', 'ecomus-addons' ) ?></span>
							<span class="dashicons dashicons-no-alt"></span>
						</button>
					</div>
				</div>
				<div class="ecomus-icon-box__field-options">
					<?php
					foreach ( $box_settings as $name => $options ) {
						$options['name']  = 'display' == $context ? "box[$index][$name]" : '{{data.name}}[{{data.count}}][' . $name . ']';
						$options['value'] = ! empty( $field[ $name ] ) ? $field[ $name ] : '';
						$options['class'] = 'ecomus-icon-box__field-option';
						$options['attributes'] = array( 'data-option' => 'box:' . $name );
						$options['__instance'] = $field;

						$this->setting_field( $options, $context );
					}
					?>
				</div>
			</div>
			<?php
		endforeach;
	}

	/**
	 * Render setting field
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 * @param string $context
	 */
	protected function setting_field( $args, $context = 'display' ) {
		$args = wp_parse_args( $args, array(
			'name'        => '',
			'label'       => '',
			'type'        => 'text',
			'value'       => '',
			'class'       => '',
			'input_class' => '',
			'attributes'  => array(),
			'options'     => array(),
			'__instance'  => null,
		) );

		// Build field attributes.
		$field_attributes = array(
			'class' => $args['class'],
			'data-option' => $args['name'],
		);

		if ( ! empty( $args['attributes'] ) ) {
			foreach ( $args['attributes'] as $attr_name => $attr_value ) {
				$field_attributes[ $attr_name ] = is_array( $attr_value ) ? implode( ' ', $attr_value ) : $attr_value;
			}
		}

		$field_attributes_string = '';

		foreach ( $field_attributes as $name => $value ) {
			$field_attributes_string .= " $name=" . '"' . esc_attr( $value ) . '"';
		}

		// Build input attributes.
		$input_attributes = array(
			'id' => 'display' == $context ? $this->get_field_id( $args['name'] ) : '',
			'name' => 'display' == $context ? $this->get_field_name( $args['name'] ) : $args['name'],
			'class' => 'widefat ' . $args['input_class'],
		);

		if( 'color' == $args['type'] ) {
			$input_attributes[ 'class' ] = $input_attributes[ 'class' ] . ' ecomus-color-widget';
		}

		if ( ! empty( $args['options'] ) && 'select' != $args['type'] ) {
			foreach ( $args['options'] as $attr_name => $attr_value ) {
				$input_attributes[ $attr_name ] = is_array( $attr_value ) ? implode( ' ', $attr_value ) : $attr_value;
			}
		}

		$input_attributes_string = '';

		foreach ( $input_attributes as $name => $value ) {
			$input_attributes_string .= " $name=" . '"' . esc_attr( $value ) . '"';
		}

		// Render field.
		echo '<p ' . $field_attributes_string . '>';

		switch ( $args['type'] ) {
			case 'color':
				?>
				<label for="<?php echo esc_attr( $input_attributes['id'] ); ?>"><?php echo esc_html( $args['label'] ); ?></label>
				<input type="text" value="<?php echo esc_attr( $args['value'] ); ?>" <?php echo $input_attributes_string ?> />
				<?php
				break;

			case 'textarea':
				?>
				<label for="<?php echo esc_attr( $input_attributes['id'] ); ?>"><?php echo esc_html( $args['label'] ); ?></label>
				<textarea <?php echo $input_attributes_string ?>><?php echo esc_textarea( $args['value'] ) ?></textarea>
				<?php
				break;

			default:
				?>
				<label for="<?php echo esc_attr( $input_attributes['id'] ); ?>"><?php echo esc_html( $args['label'] ); ?></label>
				<input type="<?php echo esc_attr( $args['type'] ) ?>" value="<?php echo esc_attr( $args['value'] ); ?>" <?php echo $input_attributes_string ?>/>
				<?php
				break;
		}

		echo '</p>';
	}

	/**
	 * Updates a particular instance of a widget
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $new_instance;
		$instance['title'] = strip_tags( $instance['title'] );
		$instance['style'] = $instance['style'];

		// Reorder filters.
		if ( isset( $instance['box'] ) ) {
			$instance['box'] = array();

			foreach ( $new_instance['box'] as $box ) {
				array_push( $instance['box'], $box );
			}
		}

		return $instance;
	}

	/**
	 * Enqueue scripts in the backend.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_scripts( $hook ) {
		if ( 'widgets.php' != $hook ) {
			return;
		}

		wp_enqueue_style( 'ecomus-icon-box-admin', ECOMUS_ADDONS_URL . 'inc/widgets/icon-box/assets/css/icon-box-admin.css', array(), '20210311' );
		wp_enqueue_script( 'ecomus-icon-box-widget-admin', ECOMUS_ADDONS_URL . 'inc/widgets/icon-box/assets/js/icon-box-admin.js', array( 'wp-util' ), '20210311', true );
	}

	/**
	 * Underscore template for filter setting fields
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function _setting_fields_template() {
		global $pagenow;

		if ( 'widgets.php' != $pagenow && 'customize.php' != $pagenow ) {
			return;
		}
		?>

        <script type="text/template" id="tmpl-ecomus-icon-box">
			<?php $this->_setting_fields( array(), 'template' ); ?>
        </script>

		<?php
	}
}
