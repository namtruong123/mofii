<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;



final class Custom_Payment_Block extends AbstractPaymentMethodType {

    private $gateway;
    /**
     * Payment method name defined by payment methods extending this class.
     *
     * @var string
     */
    protected $name = 'custom_payment';

    public function __construct( $name = 'custom_payment' ) {
        $this->name = $name;
    }

    /**
     * Initializes the payment method type.
     */
    public function initialize() {
        $this->settings = get_option( "woocommerce_{$this->name}_settings", [] );

    }

    /**
     * Returns if this payment method should be active. If false, the scripts will not be enqueued.
     *
     * @return boolean
     */
    public function is_active() {
        return ! empty( $this->settings[ 'enabled' ] ) && 'yes' === $this->settings[ 'enabled' ];
    }


    public function get_payment_method_script_handles() {

        $asset_path   = plugin_dir_path( __DIR__ ) . 'blocks/build/index.asset.php';
        $version      = null;
        $dependencies = array();
        if( file_exists( $asset_path ) ) {
            $asset        = require $asset_path;
            $version      = isset( $asset[ 'version' ] ) ? $asset[ 'version' ] : $version;
            $dependencies = isset( $asset[ 'dependencies' ] ) ? $asset[ 'dependencies' ] : $dependencies;
        }

        wp_register_script(
            'wc-custom-payment-integration-' . $this->name,
            plugin_dir_url( __DIR__ ) . 'blocks/build/index.js?for=' . $this->name ,
            $dependencies,
            $version,
            true
        );
        wp_localize_script(  'wc-custom-payment-integration-' . $this->name, 'custom_payment_blocks_params', ['gateway_id' => $this->name]);

        return array(  'wc-custom-payment-integration-' . $this->name );

    }


    /**
     * Returns an array of key=>value pairs of data made available to the payment methods script.
     *
     * @return array
     */
    public function get_payment_method_data() {
        return [
            'title'       => $this->get_setting( 'title' ),
            'description' => $this->get_setting( 'description' ),
            'customized_form' => $this->get_setting( 'customized_form' ),
            'supports'    => $this->get_supported_features(),
            'currency_symbol' => html_entity_decode(get_woocommerce_currency_symbol()),
        ];
    }
}
