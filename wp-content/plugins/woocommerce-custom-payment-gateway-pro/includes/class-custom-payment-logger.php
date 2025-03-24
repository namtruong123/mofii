<?php

class Custom_Payment_Logger {

	public static $logger;

	const LOG_FILENAME = 'woocommerce-custom-payment-gateway';

	public static function log( $message )
	{
		if ( !class_exists( 'WC_Logger' )) {
			return;
		}

		$logger = wc_get_logger();

		$log_entry = sprintf('==== WC Custom Payment Start [%s] ====', date('d/m/Y H:i:s'));
		$log_entry .=  $message . "\n";
		$log_entry .= '====WC Custom Payment Log End====' . "\n\n";

		$logger->debug( $log_entry, [ 'source' => self::LOG_FILENAME ] );

	}
}
