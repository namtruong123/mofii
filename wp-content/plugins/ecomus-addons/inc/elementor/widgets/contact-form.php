<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Contact_Form extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-contact-form';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Contact Form', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-kit-details';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['ecomus-addons'];
	}

	/**
	 * Get widget keywords.
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'contact form', 'form', 'ecomus-addons' ];
	}

	/**
	 * Register the widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		// Content
		$this->start_controls_section(
			'section_subscribe_box',
			[ 'label' => __( 'Contact Form', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'form_shortcode',
			[
				'label' => __( 'Enter your shortcode', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => '[contact-form-7 id="11" title="Contact form 1"]',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Form', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'custom_width',
			[
				'label'     => esc_html__( 'Button Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit' => 'width: auto; min-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .em-col' => 'text-align: center;',
				],
			]
		);

		$this->end_controls_section();
	}

		/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'ecomus-contact-form ecomus-custom-button--skin' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo do_shortcode(  $settings['form_shortcode']  ) ?>
		</div>
		<?php
	}
}