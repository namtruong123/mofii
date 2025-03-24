=== WooCommerce Custom Payment Gateway Pro ===
Contributors: waseem_senjer
Donate link: https://wpruby.com
Tags: woocommerce,payment gateway, woocommerce extension, custom payment,payment, payment option, custom payment
Requires at least: 3.5.1
Tested up to: 6.7.2
Stable tag: 3.1.0
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Do not miss a single sale! This plugin is very useful to catch every possible sale.


== Description ==
If the customer can't pay with your payment gateways, give him the opportunity to submit the order and send to you a note on payment options he can pay you with. The plugin is very simple and effective. The more important is it's very easy to setup and use.

### Customer Message
A gateway description appears to the customer at the Checkout page to provide him with additional information about your custom gateway.

### Customer Note
A note for the customer for further instructions displayed after the checkout process.


## Pro Features

### Full Form Builder
A rich, dynamic and a drag-n-drop form builder to help you as much as possible to customize your gateway form. The form builder supports the following fields:
>
* Text
* Text Box
* Checkbox
* Radio Buttons
* Select Menu
* Email
* Date
* Time
* URL
* Currency
* Number
* Phone number
* Credit Card Form
* Instructions

All fields are highly customizable as you can change the name, label, size, default value, CSS class/es, and more.

### Unlimited Custom Gateways
Not only you can use the already created gateway, you can create an unlimited number of custom payment gateways and have full control of them.
### Custom Gateway Icon
You can differentiate your gateway with a special icon which will be displayed on the Checkout page.
### Order Status after Checkout
You can configure the status of the orders that were paid using your custom payment gateway.
### API Request after Checkout
A very powerful tool for allowing the payment information to be sent to an external API in order to process or store the payment information.
* You can redirect the customer to a custom URL after the checkout.
* Set the type of the API request, either POST or GET.
* Set the type of the data of the request, either FORM DATA or JSON.
* Setting API parameters and Key/Value combination of WooCommerce data such as:

>     * Order ID
    * Order Total
    * Customer First Name
    * Customer Last Name
    * Customer Postcode
    * Customer City
    * Customer State
    * Customer Country
    * Customer Email
    * Customer Phone
    * Customer IP Address>

* Setting any Extra API parameters such as API keys .. etc

### Adding Payment information to the Order’s email
An option is available to add the submitted payment information in the Order’s emails.

### Debugging Mode
The debug mode is an excellent tool to test out the plugin’s settings and the checkout page as the payment gateway will be only activated for you if the Debug Mode is enabled.



== Screenshots ==

1. Checkout Page Preview.
2. Payment Gateway Settings Page.
3. Order Notes.





== Installation ==



= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'WooCommerce Custom Payment Gateway'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `woocommerce-custom-payment-gateway.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `woocommerce-custom-payment-gateway.zip`
2. Extract the `woocommerce-custom-payment-gateway` directory to your computer
3. Upload the `woocommerce-custom-payment-gateway` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard




== Changelog ==
= 3.1.0 =
* Added: WooCommerce Checkout Blocks support for generated gateways.
* Fixed: PHP Fatal error when HPOS is not enabled.

= 3.0.0 =
* Added: WooCommerce Checkout Blocks support.
* Fixed: PHP deprecations warnings.

= 2.9.0 =
* Added: Add cc card expiry date validation.
* Fixed: delete payment information was not working
* Fixed: Not adding payment info in admin emails.
* Fixed: API headers were not saving.
* Fixed: Delete custom gateway with special characters in the name.

= 2.8.1 =
* Fixed: Fatal error when adding a new product.

= 2.8.0 =
* ADDED: WooCommerce HPOS support.

= 2.7.0 =
* ADDED: API URL filter hook `custom_payment_gateways_api_url`
* ADDED: payment method title to payment information.
* ADDED adding support for the WCFM plugin.
* FIXED: do not reduce stock when order status is pending.
* Declaring support for WooCommerce High-Performance Order Storage

= 2.6.0 =
* ADDED: File upload checkout field.

= 2.5.0 =
* ADDED: adding custom_payment_gateways_validate_field filter to add custom validation
* ADDED: adding payment info to the invoice generated by the WooCommerce PDF Invoices Packing Slips plugin.
* ADDED: add gateway_id to the custom_payment_gateways_api_data and custom_payment_gateways_json_post_headers filters.
* FIXED: undefined variable error.
* FIXED: mask credit card number when sending emails.
* FIXED: License handler update URL.

= 2.4.1 =
* FIXED: A new plugin updater API endpoint.

= 2.4.0 =
* ADDED: You can now have the option not to start the payment infromation in the Database.
* Updated: Plugin Updater update to the latest version.

= 2.3.1 =
* FIXED: fix headers appending on POST and content type JSON.

= 2.3.0 =
* ADDED: Now you can add headers to API requests from the plugin settings page.
* FIXED: reduce stock only if not redirecting the user.

= 2.2.0 =
* ADDED: credit card validation filter: `custom_payment_gateways_validate_card_number`
* FIXED: Update the order status.

= 2.1.1 =
* FIXED: Fix adding data to POST requests.

= 2.1.0 =
* ADDED: Add parsable values to select field value. {order_amount} added.
* FIXED: Escape the fields name and description in checkout.
* FIXED: Getting fields label

= 2.0.5 =
* FIXED: Fields at checkout were displaying the number 1 as a suffix.

= 2.0.4 =
* FIXED: Change multiple gateways saved data for no collision.
* FIXED: CSS non-unique to the plugin rules.

= 2.0.3 =
* FIXED: Adapting the new data structure when adding the Payment information to the emails.
* FIXED: CSS non-unique to the plugin rules.

= 2.0.2 =
* FIXED: PHP 5.6 compatibility.

= 2.0.1 =
* FIXED: storing Credit Card data.

= 2.0.0 =
* ADDED: Form Builder: Signature field to collect customers signature.
* ADDED: Form Builder: Password field.
* ADDED: Customer ID in the WooCommerce Parameters in the API request builder.
* ADDED: `custom_payment_gateways_api_url` filter hook to change the API url.
* ADDED: `custom_payment_gateways_json_post_headers` filter hook to change the headers of API requests.
* ADDED: Allow date picker to choose year and month.
* IMPROVED: Payment data storage.
* FIXED: Date was not active for multiple gateways.
* FIXED: Including frontend styles and javascript only in the checkout page.
* FIXED: HTML escaping in the instructions field.

= 1.3.12 =
* FIXED: The js was loaded everywhere in admin, now limited to the settings page

= 1.3.11 =
* ADDED: Address line 1 and 2 in WooCommerce API parameters.

= 1.3.10 =
* ADDED: Allow filters to modify all api keys.

= 1.3.9 =
* FIXED: addding upgrades process to preserve gateway keys

= 1.3.8 =
* ADDED: adding a new hook to process returned URL

= 1.3.7 =
* FIXED: renaming the wc_data filter hook.

= 1.3.5 =
* FIXED: add Time field in the form builder
= 1.3.4 =
* FIXED: remove unnecessary strings

= 1.3.3 =
* ADDED: localization support
* FIXED: WC 3.0 Support
= 1.3.2 =
* FIXED: Adding WPMU support.


= 1.3.1 =
* FIXED: incompatibility with Aryo Activity Log plugin

= 1.3.0 =
* ADDED: Add Order information to the API call
* FIXED: PHP compatiblity.

= 1.2.7 =
* FIXED: replacing CC validator algorithm

= 1.2.6 =
* ADDED: validation of credit card numbers.

= 1.2.5 =
* ADDED: delete link in order's page to remove payment info.
* FIXED: conflict with themes

= 1.2.4 =
* FIXED: fix order details email PHP warning

= 1.2.3 =
* FIXED: makes the CC form required.
* FIXED: CC Form empty values issue in WC 2.6+

= 1.2.2 =
* ADDED: WooCommerce 2.6+ compatibility.
* ADDED: A new option to add payment information to WooCommerce emails.
* FIXED: PHP warning messages.


= 1.2.1 =
FIXED: PHP warnings.

= 1.2.0 =
ADDED: Add unlimited number of custom gateways.

= 1.0.4 =

* FIXED: prevent the gateway to send customer note when empty.
* RENAMED: Gateway name to `Custom Payment Pro`

= 1.0.3 =
* ReBrand the plugin to WPRuby

= 1.0.2 =
* FIXED: Gateway icon aligned vertically at the middle.
* FIXED: Adding the customer message to the checkout page.
* FIXED: Making the Required option default value "No".
* FIXED: Making the select field with auto.

= 1.0.1 =
* Add i18n support.
* Add Croatian language translation (Thanks to Sanjin Barac)

= 1.0 =
* Initial release.

== Upgrade Notice ==
* Initial release.
