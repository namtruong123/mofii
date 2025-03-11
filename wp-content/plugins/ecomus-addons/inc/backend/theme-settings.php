<?php
/**
 * Register footer builder
 */

namespace Ecomus\Addons;

class Theme_Settings {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}


	public function theme_settings_page() {
		echo '<form action="options.php" method="post">';
		settings_fields("theme_settings");
		do_settings_sections( 'theme_settings' );
		submit_button();
		echo '</form>';
	}

	public function register_settings() {
		do_action('ecomus_register_theme_settings');
	}

	public function register_admin_menu() {
		$ecomus_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNTciIGhlaWdodD0iMjU3IiB2aWV3Qm94PSIwIDAgMjU3IDI1NyIgZmlsbD0ibm9uZSI+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xOTIuODUxIDIzOS41MTdDMjM4LjYxOSAyMTMuMDkzIDI2MS44OTUgMTYyLjY3MyAyNTUuOTYyIDExMy4zMjRMMjEwLjUxNyAxMzkuNTYyQzIwNy4yMzcgMTY0LjAxIDE5My4wNTkgMTg2LjcyNiAxNzAuMDQ0IDIwMC4wMTRDMTMwLjY0IDIyMi43NjQgODAuMjUzNSAyMDkuMjYzIDU3LjUwMzQgMTY5Ljg1OEMzNC43NTMyIDEzMC40NTQgNDguMjU0NCA4MC4wNjc4IDg3LjY1ODUgNTcuMzE3OEMxMTguNzI0IDM5LjM4MjQgMTU2LjYxNCA0My45NzggMTgyLjQwOCA2Ni4wMzQ0TDExMi4yOTkgMTA2LjUxMkwxMDEuMDc2IDE2Ni4yTDIwNy42NzkgMTA0LjY1M0wyMzcuNzI1IDg3LjMwNTlMMjQ3Ljg0NyA4MS40NjE4QzI0NS41NzUgNzUuNzU1NCAyNDIuODY0IDcwLjE0MjEgMjM5LjcwMyA2NC42NjU3QzIwNC4zNTYgMy40NDQyIDEyNi4wNzMgLTE3LjUzMTkgNjQuODUxMyAxNy44MTQ1QzMuNjI5NTUgNTMuMTYwOCAtMTcuMzQ2MiAxMzEuNDQ0IDE4IDE5Mi42NjZDNTMuMzQ2MyAyNTMuODg3IDEzMS42MyAyNzQuODYzIDE5Mi44NTEgMjM5LjUxN1oiIGZpbGw9InVybCgjcGFpbnQwX2xpbmVhcl81NjA1XzEyNSkiPjwvcGF0aD48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9InBhaW50MF9saW5lYXJfNTYwNV8xMjUiIHgxPSIyNi4wMDAxIiB5MT0iMTg1IiB4Mj0iMjMyLjEzNiIgeTI9IjQ4LjE2NjUiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBzdG9wLWNvbG9yPSIjYTdhYWFkIj48L3N0b3A+PHN0b3Agb2Zmc2V0PSIwLjUwNTIwOCIgc3RvcC1jb2xvcj0iI2E3YWFhZCI+PC9zdG9wPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2E3YWFhZCI+PC9zdG9wPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjwvc3ZnPg==';
		add_menu_page(
			esc_html__( 'Ecomus', 'ecomus-addons' ),
			esc_html__( 'Ecomus', 'ecomus-addons' ),
			'manage_options',
			'ecomus_dashboard',
			array($this, 'ecomus_dashboard_page_content'),
			$ecomus_icon,
			59
		);

		add_submenu_page(
			'ecomus_dashboard',
			esc_html__( 'Theme Settings', 'ecomus-addons' ),
			esc_html__( 'Theme Settings', 'ecomus-addons' ),
			'manage_options',
			'theme_settings',
			array($this, 'theme_settings_page')
		);
	}

	public function ecomus_dashboard_page_content() {
		?>
		<h1><?php esc_html_e('Ecomus - Multipurpose WooCommerce Theme', 'ecomus-addons') ?></h1>
		<p>
			<strong><?php esc_html_e( 'Thank you for purchasing Ecomus theme!  First, check our handy Documentation for solutions.  Still stuck? Open a support ticket and our team will assist you promptly.', 'ecomus-addons' ); ?></strong>
		</p>
		<p>
			<strong>
				<a href="https://wpecomus.com/doc/#/" target="_blank"><?php esc_html_e('Documentation', 'ecomus-addons'); ?></a> |
				<a href="https://drfuri.ticksy.com/" target="_blank"><?php esc_html_e('Support Ticket', 'ecomus-addons'); ?></a>
			</strong>
		</p>
		<?php
	}
}