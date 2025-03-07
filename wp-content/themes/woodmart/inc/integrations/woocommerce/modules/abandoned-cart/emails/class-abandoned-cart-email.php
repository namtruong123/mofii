<?php
/**
 * Send abandoned cart email.
 *
 * @package XTS
 */

namespace XTS\Modules\Abandoned_Cart\Emails;

use WC_Email;
use WC_Coupon;

if ( ! class_exists( 'XTS\Modules\Abandoned_Cart\Emails\Abandoned_Cart_Email' ) ) :

	/**
	 * Send abandoned cart email.
	 */
	class Abandoned_Cart_Email extends WC_Email {
		/**
		 * True when the email notification is sent to customers.
		 *
		 * @var bool
		 */
		protected $customer_email = true;

		/**
		 * Strings to find/replace in subjects/headings.
		 *
		 * @var array|string[]
		 */
		protected $loop_placeholders = array();

		/**
		 * Email content html.
		 *
		 * @var string
		 */
		protected $content_html = '';

		/**
		 * Email content html.
		 *
		 * @var string
		 */
		protected $content_text = '';

		/**
		 * List of registered placeholder keys for show in content options descritions..
		 *
		 * @var array
		 */
		protected $placeholders_text = array();

		/**
		 * WC_Product instance.
		 *
		 * @var WC_Product;
		 */
		public $object;

		/**
		 * WC_Coupon instance.
		 *
		 * @var WC_Coupon|false
		 */
		public $coupon;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id          = 'woodmart_abandoned_cart_email';
			$this->title       = esc_html__( 'Reminder: Incomplete Purchase Notification', 'woodmart' );
			$this->description = esc_html__( 'This email reminds customers about their incomplete purchases, encouraging them to complete their orders.', 'woodmart' );

			$this->heading = wp_kses_post( __( 'Don\'t Forget to Complete Your Purchase!', 'woodmart' ) );
			$this->subject = wp_kses_post( __( 'Don\'t Forget to Complete Your Purchase!', 'woodmart' ) );

			$this->template_html  = 'emails/abandoned-cart.php';
			$this->template_plain = 'emails/plain/abandoned-cart.php';

			$this->content_html = $this->get_option( 'content_html' );
			$this->content_text = $this->get_option( 'content_text' );

			// Triggers for this email.
			add_action( 'woodmart_send_abandoned_cart_notification', array( $this, 'trigger' ) );

			add_filter( 'woodmart_emails_list', array( $this, 'register_woodmart_email' ) );

			// Call parent constructor.
			parent::__construct();

			if ( defined( 'WCML_VERSION' ) ) {
				add_filter( 'woodmart_custom_html_content_' . $this->id, array( $this, 'meybe_translate_content_html' ), 10, 2 );
				add_filter( 'woodmart_custom_text_content_' . $this->id, array( $this, 'meybe_translate_content_text' ), 10, 2 );
			}
		}

		public function register_woodmart_email( $email_class ) {
			$email_class[] = get_class( $this );

			return $email_class;
		}

		/**
		 * Translates the HTML content of a product email if necessary.
		 *
		 * @param string $content The original HTML content.
		 * @param Object $cart_object Abandoned cart data object.
		 *
		 * @return string The translated HTML content.
		 */
		public function meybe_translate_content_html( $content, $cart_object ) {
			$translated_value = $this->translate_content( 'content_html', $cart_object );

			if ( ! empty( $translated_value ) ) {
				return $this->format_string( $translated_value );
			}

			return $content;
		}

		/**
		 * Translates the text content of a product email if necessary.
		 *
		 * @param string $content The original text content.
		 * @param Object $cart_object Abandoned cart data object.
		 *
		 * @return string The translated text content.
		 */
		public function meybe_translate_content_text( $content, $cart_object ) {
			$translated_value = $this->translate_content( 'content_text', $cart_object );

			if ( ! empty( $translated_value ) ) {
				return $this->format_string( $translated_value );
			}

			return $content;
		}

		/**
		 * Translates the content of a product email based on the specified key.
		 *
		 * @param string $key The key identifying the type of content (e.g., 'content_html' or 'content_text').
		 * @param Object $cart_object Abandoned cart data object.
		 *
		 * @return string The translated content.
		 */
		public function translate_content( $key, $cart_object ) {
			$translated_language = $cart_object->_language;

			$option_name    = 'woocommerce_' . $this->id . '_settings';
			$domain         = 'admin_texts_woocommerce_' . $this->id . '_settings';
			$options        = get_option( $option_name );
			$original_value = isset( $options[ $key ] ) ? $options[ $key ] : '';

			$translated_value = apply_filters( 'wpml_translate_single_string', $original_value, $domain, '[' . $option_name . ']' . $key, $translated_language ); // phpcs:ignore.

			return $translated_value;
		}

		/**
		 * Method triggered to send email.
		 *
		 * @param array $cart_data Abandoned art data.
		 *
		 * @return void
		 */
		public function trigger( $cart_data ) {
			$this->object       = $cart_data;
			$this->recipient    = $this->object->_user_email;
			$this->content_html = $this->get_option( 'content_html' );
			$this->content_text = $this->get_option( 'content_text' );

			if ( ! $this->is_enabled() || ! $this->get_recipient() || ! $this->object ) {
				return;
			}

			$this->send(
				$this->get_recipient(),
				$this->get_subject(),
				$this->get_content(),
				$this->get_headers(),
				$this->get_attachments()
			);
		}

		/**
		 * Get email content.
		 *
		 * @return string
		 */
		public function get_content() {
			$user = get_user_by( 'email', $this->recipient );

			if ( $user instanceof WP_User ) {
				$user_name = $user->display_name;
			} elseif ( ! empty( $this->object->_user_first_name ) || ! empty( $this->object->_user_last_name ) ) {
				$user_name = $this->object->_user_first_name . ' ' . $this->object->_user_last_name;
			} else {
				$user_name = esc_html__( 'Customer', 'woodmart' );
			}

			$this->coupon       = $this->create_and_get_coupon();
			$coupon_value       = 0;
			$cart_with_discount = 0;
			$date_expires       = '';
			$subtotal           = intval( $this->object->_cart->get_subtotal() );

			if ( wc_tax_enabled() && 'excl' === get_option( 'woocommerce_tax_display_cart' ) ) {
				$subtotal += $this->object->_cart->get_subtotal_tax();
			}

			if ( $this->coupon ) {
				$coupon_ammunt = $this->coupon->get_amount();
				$coupon_type   = $this->coupon->get_discount_type();
				$date_expires  = $this->coupon->get_date_expires();

				if ( $date_expires ) {
					$date_expires = $date_expires->date( get_option( 'date_format' ) );
				}

				if ( 'percent' === $coupon_type ) {
					$coupon_value       = $coupon_ammunt . '%';
					$cart_with_discount = $subtotal - ( $subtotal * ( $coupon_ammunt / 100 ) );
				} elseif ( 'fixed_cart' === $coupon_type ) {
					$coupon_value       = wc_price( $coupon_ammunt, array( 'currency' => $this->object->_user_currency ) );
					$cart_with_discount = $subtotal - $coupon_ammunt;
				}
			}

			$cart_with_discount = wc_price( $cart_with_discount, array( 'currency' => $this->object->_user_currency ) );

			$this->placeholders = array_merge(
				$this->placeholders,
				array(
					'{coupon_code}'         => $this->coupon ? strtoupper( $this->coupon->get_code() ) : '',
					'{coupon_value}'        => $coupon_value,
					'{cart_with_discount}'  => $cart_with_discount,
					'{coupon_date_expires}' => $date_expires,
					'{user_first_name}'     => $this->object->_user_first_name,
					'{user_last_name}'      => $this->object->_user_last_name,
					'{user_name}'           => $user_name,
					'{user_email}'          => $this->recipient,
					'{cart_subtotal}'       => wc_price( $subtotal, array( 'currency' => $this->object->_user_currency ) ),
					'{date}'                => $this->object->post_modified,
				)
			);

			$this->loop_placeholders = array_merge(
				$this->loop_placeholders,
				array(
					'{product_name}'     => '{product_name_%d}',
					'{product_quantity}' => '{product_quantity_%d}',
					'{product_subtotal}' => '{product_subtotal_%d}',
					'{product_price}'    => '{product_price_%d}',
					'{product_url}'      => '{product_url_%d}',
				)
			);

			foreach ( $this->object->_cart->get_cart_contents() as $cart_id => $cart_item ) {
				$id      = isset( $cart_item['variation_id'] ) && ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
				$product = $cart_item['data'];

				$this->placeholders = array_merge(
					$this->placeholders,
					array(
						'{product_name_' . $id . '}'     => $product ? $product->get_title() : '',
						'{product_quantity_' . $id . '}' => $cart_item['quantity'] ? $cart_item['quantity'] : '',
						'{product_subtotal_' . $id . '}' => $cart_item['line_subtotal'] ? wc_price( $cart_item['line_subtotal'], array( 'currency' => $this->object->_user_currency ) ) : '',
						'{product_price_' . $id . '}'    => $product ? $product->get_price_html() : '',
						'{product_url_' . $id . '}'      => $product ? $product->get_permalink() : '',
					)
				);
			}

			return parent::get_content();
		}

		/**
		 * Get content html.
		 *
		 * @return string
		 */
		public function get_content_html() {
			ob_start();

			wc_get_template(
				$this->template_html,
				array(
					'email'            => $this,
					'email_heading'    => $this->get_heading(),
					'email_content'    => $this->get_custom_content_html(),
					'unsubscribe_link' => $this->get_unsubscribe_link(),
					'sent_to_admin'    => false,
					'plain_text'       => false,
				)
			);

			return ob_get_clean();
		}

		/**
		 * Get content plain.
		 *
		 * @return string
		 */
		public function get_content_plain() {
			ob_start();

			wc_get_template(
				$this->template_plain,
				array(
					'email'            => $this,
					'email_heading'    => $this->get_heading(),
					'email_content'    => $this->get_custom_content_plain(),
					'unsubscribe_link' => $this->get_unsubscribe_link(),
					'sent_to_admin'    => false,
					'plain_text'       => true,
				)
			);

			return ob_get_clean();
		}

		/**
		 * Retrieve custom email html content
		 *
		 *  @return string custom content, with replaced values.
		 */
		public function get_custom_content_html() {
			$image_size = apply_filters( 'woodmart_abandoned_cart_email_thumbnail_item_size', array( 32, 32 ) );

			$this->loop_placeholders = array_merge(
				$this->loop_placeholders,
				array(
					'{product_image}' => '{product_image_%d}',
				)
			);

			$this->placeholders = array_merge(
				$this->placeholders,
				array(
					'{recover_button}' => '<div style="margin:0 0 16px;"><a class="xts-add-to-cart" href="' . esc_url( $this->get_recover_button_link() ) . '">' . apply_filters( 'woodmart_waitlist_label_confirm_button', __( 'Recover cart', 'woodmart' ) ) . '</a></div>',
				)
			);

			foreach ( $this->object->_cart->get_cart_contents() as $cart_id => $cart_item ) {
				$id      = isset( $cart_item['variation_id'] ) && ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
				$product = $cart_item['data'];

				$this->placeholders = array_merge(
					$this->placeholders,
					array(
						'{product_image_' . $id . '}' => $product ? apply_filters( 'woodmart_abandoned_cart_email_item_thumbnail', '<div style="margin-bottom: 5px"><img src="' . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woodmart' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . esc_attr( $image_size[0] ) . '" style="vertical-align:middle; margin-' . ( is_rtl() ? 'left' : 'right' ) . ': 10px;" /></div>', $product ) : '',
					)
				);
			}

			return apply_filters( 'woodmart_custom_html_content_' . $this->id, $this->format_string( stripcslashes( $this->content_html ) ), $this->object );
		}

		/**
		 * Get confirm subscription link.
		 * Create confirm token if not exists.
		 *
		 * @return string Confirm subscription url.
		 */
		public function get_recover_button_link() {
			$args = array( 'wd_rec_cart' => $this->object->ID );

			if ( $this->coupon ) {
				$args['coupon_code'] = $this->coupon->get_code();
			}

			return add_query_arg( $args, wc_get_cart_url() );
		}

		/**
		 * Get unsubscribe link.
		 * Create unsubscribe token if not exists.
		 *
		 * @return string Unsubscribe url.
		 */
		public function get_unsubscribe_link() {
			$unsubscribe_token = hash_hmac( 'sha256', $this->object->_user_email, 'woodmart_abandoned_cart_unsubscribe' );

			return add_query_arg(
				array(
					'token' => $unsubscribe_token,
					'email' => $this->object->_user_email,
				),
				wc_get_page_permalink( 'shop' )
			);
		}

		/**
		 * Retrieve custom email text content
		 *
		 *  @return string custom content, with replaced values.
		 */
		public function get_custom_content_plain() {
			$this->placeholders = array_merge(
				$this->placeholders,
				array(
					'{recover_button}' => esc_url( $this->get_recover_button_link() ),
				)
			);

			return apply_filters( 'woodmart_custom_text_content_' . $this->id, $this->format_string( stripcslashes( $this->content_text ) ), $this->object );
		}

		/**
		 * Format email string.
		 *
		 * @param mixed $content_string Text to replace placeholders in.
		 *
		 * @return string
		 */
		public function format_string( $content_string ) {
			$start = '{loop}';
			$end   = '{endloop}';

			if ( ! strpos( $content_string, $start ) || ! strpos( $content_string, $end ) ) {
				return parent::format_string( $content_string );
			}

			$start_pos           = strpos( $content_string, $start ) + strlen( $start );
			$end_pos             = strpos( $content_string, $end, $start_pos );
			$default_loop_string = substr( $content_string, $start_pos, $end_pos - $start_pos );
			$loop_string         = '';

			foreach ( $this->object->_cart->get_cart_contents() as $cart_id => $cart_item ) {
				$id = isset( $cart_item['variation_id'] ) && ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];

				$loop_string .= str_replace(
					array_keys( $this->loop_placeholders ),
					array_map(
						'sprintf',
						array_values( $this->loop_placeholders ),
						array_fill( 0, count( $this->loop_placeholders ), $id )
					),
					$default_loop_string
				);
			}

			$content_string = str_replace(
				array( $start, $end, $default_loop_string ),
				array( '', '', $loop_string ),
				$content_string
			);

			return parent::format_string( $content_string );
		}

		/**
		 * Init fields that will store admin preferences.
		 *
		 * @return void
		 */
		public function init_form_fields() {
			parent::init_form_fields();

			unset( $this->form_fields['additional_content'] );

			$this->form_fields['content_html'] = array(
				'title'       => esc_html__( 'Email HTML content', 'woodmart' ),
				'type'        => 'textarea',
				'description' => sprintf(
					// translators: %1$s: List of available placeholders. %2$s: The {loop}...{endloop} tags. %3$s: Additional placeholders to be used within the loop tags.
					esc_html__( 'This field lets you modify the main content of the HTML email. You can use the following placeholders: %1$s. Next placeholders you must use only within %2$s tags: %3$s', 'woodmart' ),
					$this->get_placeholder_text_string( $this->get_placeholder_text() ),
					'<code>{loop}...{endloop}</code>',
					$this->get_placeholder_text_string( $this->get_loop_placeholder_text( 'html' ) )
				),
				'placeholder' => '',
				'css'         => 'min-height: 250px;',
				'default'     => $this->get_default_content( 'html' ),
			);

			$this->form_fields['content_text'] = array(
				'title'       => esc_html__( 'Email text content', 'woodmart' ),
				'type'        => 'textarea',
				'description' => sprintf(
					// translators: %1$s: List of available placeholders. %2$s: The {loop}...{endloop} tags. %3$s: Additional placeholders to be used within the loop tags.
					esc_html__( 'This field lets you modify the main content of the text email. You can use the following placeholders: %1$s. Next placeholders you must use only within %2$s tags: %3$s', 'woodmart' ),
					$this->get_placeholder_text_string( $this->get_placeholder_text() ),
					'<code>{loop}...{endloop}</code>',
					$this->get_placeholder_text_string( $this->get_loop_placeholder_text( 'plain' ) )
				),
				'placeholder' => '',
				'css'         => 'min-height: 250px;',
				'default'     => $this->get_default_content( 'plain' ),
			);
		}

		/**
		 * Create a new coupon to send with email and return WC_Coupon instance.
		 *
		 * @return WC_Coupon|false
		 */
		public function create_and_get_coupon() {
			$coupon_enabled = woodmart_get_opt( 'abandoned_cart_coupon_enabled' );
			$discount_type  = woodmart_get_opt( 'abandoned_cart_coupon_discount_type', 'percent' );
			$coupon_amount  = woodmart_get_opt( 'abandoned_cart_coupon_amount', 10 );

			if ( ! $coupon_enabled || ! $discount_type || ! $coupon_amount ) {
				return false;
			}

			$coupon_prefix = woodmart_get_opt( 'abandoned_cart_coupon_prefix', 'WD' );
			$coupon_code   = substr( strtoupper( uniqid( $coupon_prefix . '_', true ) ), 0, apply_filters( 'woodmart_abandoned_cart_coupon_code_length', 10 ) );
			$coupon        = new WC_Coupon( $coupon_code );
			$expiry_date   = '';

			if ( woodmart_get_opt( 'abandoned_cart_delete_expired_coupons', true ) ) {
				$expiry_date = time() + intval( woodmart_get_opt( 'abandoned_cart_coupon_timeframe', 1 ) ) * intval( woodmart_get_opt( 'abandoned_cart_coupon_timeframe_period', DAY_IN_SECONDS ) );
				$expiry_date = gmdate( 'Y-m-d h:i:s', $expiry_date );
			}

			if ( $coupon->get_amount() ) {
				$new_coupon_id = $coupon->get_id();
			} else {
				$new_coupon_id = wp_insert_post(
					array(
						'post_title'   => $coupon_code,
						'post_content' => '',
						'post_status'  => 'publish',
						'post_author'  => 1,
						'post_type'    => 'shop_coupon',
					)
				);
			}

			$args = apply_filters(
				'woodmart_coupon_args',
				array(
					'discount_type'            => $discount_type,
					'coupon_amount'            => $coupon_amount,
					'individual_use'           => 'yes',
					'product_ids'              => '',
					'exclude_product_ids'      => '',
					'usage_limit'              => '1',
					'expiry_date'              => $expiry_date,
					'apply_before_tax'         => 'yes',
					'free_shipping'            => 'no',
					'wd_abandoned_cart_coupon' => 'yes',
				),
				$new_coupon_id,
				$this->object->ID // Abandoned cart id.
			);

			if ( $args ) {
				foreach ( $args as $key => $arg ) {
					update_post_meta( $new_coupon_id, $key, $arg );
				}
			}

			return new WC_Coupon( $coupon_code );
		}

		/**
		 * Returns text with placeholders that can be used in this email
		 *
		 * @param string $email_type Email type.
		 *
		 * @return array
		 */
		public function get_loop_placeholder_text( $email_type ) {
			$placeholders = array(
				'product_name',
				'product_quantity',
				'product_subtotal',
				'product_price',
				'product_url',
			);

			if ( 'html' === $email_type ) {
				$placeholders = array_merge(
					$placeholders,
					array(
						'product_image',
					)
				);
			}

			return $placeholders;
		}

		/**
		 * Returns text with placeholders that can be used in this email
		 *
		 * @return array
		 */
		public function get_placeholder_text() {
			return array(
				// Default placeholders.
				'site_title',
				'site_address',
				'site_url',

				// Custom placeholders.
				'coupon_code',
				'coupon_value',
				'cart_with_discount',
				'coupon_date_expires',
				'user_first_name',
				'user_last_name',
				'user_name',
				'user_email',
				'cart_subtotal',
				'recover_button',
				'date',
			);
		}

		/**
		 * Convert list of registered placeholder keys to string for show in content options descritions.
		 *
		 * @param array $placeholders List of registered placeholder keys.
		 */
		public function get_placeholder_text_string( $placeholders ) {
			$placeholders = array_map(
				function ( $placeholder ) {
					return sprintf(
						'<code>{%s}</code>',
						$placeholder
					);
				},
				$placeholders
			);

			return implode( ' ', $placeholders );
		}

		/**
		 * Returns default email content.
		 *
		 * @param string $email_type Email type.
		 *
		 * @return string Placeholders
		 */
		public static function get_default_content( $email_type ) {
			if ( 'plain' === $email_type ) {
				$content  = __( "Hi {user_name},\n", 'woodmart' );
				$content .= __( "We noticed that you left a few items in your cart and didn't complete your purchase. We just wanted to remind you that those great finds are still waiting for you!\n", 'woodmart' );
				$content .= __( "Here's what you left behind:\n", 'woodmart' );
				$content .= "{loop}\n";
				$content .= "{product_name} x{product_quantity} {product_subtotal}\n";
				$content .= "{endloop}\n";
				$content .= __( "Cart subtotal: {cart_subtotal}\n", 'woodmart' );
				$content .= __( "Simply click the button below to complete your purchase: {recover_button}\n", 'woodmart' );
				$content .= __( "We're eager to get these items to you. Don't miss out on them!\n", 'woodmart' );
				$content .= __( "Best regards, {site_title}\n", 'woodmart' );

				return trim( $content );
			} else {
				ob_start();
				?>
				<p><?php esc_html_e( 'Hi {user_name}', 'woodmart' ); ?></p>
				<p><?php echo wp_kses_post( __( 'We noticed that you left a few items in your cart and didn\'t complete your purchase. We just wanted to remind you that those great finds are still waiting for you!', 'woodmart' ) ); ?></p>
				<p><?php echo wp_kses_post( __( 'Here\'s what you left behind:', 'woodmart' ) ); ?></p>
				<table class="td xts-prod-table" cellspacing="0" cellpadding="6" border="1">
					<thead>
						<tr>
							<th class="td" scope="col"></th>
							<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Product', 'woodmart' ); ?></th>
							<th class="td xts-align-end" scope="col"><?php esc_html_e( 'Price', 'woodmart' ); ?></th>
						</tr>
					</thead>
					<tbody>
						{loop}
							<tr>
								<td class="td xts-tbody-td xts-img-col xts-align-start">
									<a href="{product_url}">
										{product_image}
									</a>
								</td>
								<td class="td xts-tbody-td xts-align-start">
									<a href="{product_url}">
										{product_name}
									</a>
									<small>x{product_quantity}</small>
								</td>
								<td class="td xts-tbody-td xts-align-end">{product_subtotal}</td>
							</tr>
						{endloop}
						<tr>
							<td class="xts-align-start" colspan="2">
								<strong><?php esc_html_e( 'Cart subtotal', 'woodmart' ); ?></strong>
							</td>
							<td class="xts-align-end">{cart_subtotal}</td>
						</tr>
					</tbody>
				</table>
				<p style="margin-top: 30px;"><?php esc_html_e( 'Simply click the button below to complete your purchase:', 'woodmart' ); ?></p>
				{recover_button}
				<p><?php echo wp_kses_post( __( 'We\'re eager to get these items to you. Don\'t miss out on them!', 'woodmart' ) ); ?></p>
				<p><?php echo wp_kses_post( __( 'Best regards, {site_title}', 'woodmart' ) ); ?></p>
				<?php
				$content = ob_get_clean();
				$content = trim( preg_replace( '/^\t{4}/m', '', $content ) );

				return $content;
			}
		}
	}

endif;

return new Abandoned_Cart_Email();
