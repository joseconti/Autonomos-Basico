<?php
/*
Plugin Name: Autonomos
Plugin URI: https://www.joseconti.com
Description: Plugins for Spanish Autonomos. Autonomos add tools to WooCommerce for Autonomos
Version: 2.0.0
Author: Jose Conti
Author URI: https://www.joseconti.com
Tested up to: 6.3
Text Domain: autonomos
Domain Path: /languages/
WC requires at least: 7.2
WC tested up to: 8.0
License: GPLv2 only
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
define( 'AUTONOMOS_VERSION', '2.0.0' );
define( 'AUTONOMOS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'AUTONOMOS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'autonomos_init', 11 );

add_action( 'before_woocommerce_init', function() {
	if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
	 \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
   } );

/**
 * Global functions WCAutoL
 */
function WCAutoL() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	require_once AUTONOMOS_PLUGIN_PATH . 'classes/class-wc-autonomos-lite-global.php'; // Global class for global functions.
	return new WC_Autonomos_Lite_Global();
}

function autonomos_init() {
	load_plugin_textdomain( 'autonomos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
		include_once AUTONOMOS_PLUGIN_PATH . 'core/loader-core.php';
	}
}
add_filter( 'woocommerce_get_settings_pages', 'autonomos_include_woocommerce_setting_file' );

function autonomos_include_woocommerce_setting_file( $settings ) {
	$settings[] = include AUTONOMOS_PLUGIN_PATH . 'core/woocommerce/class-wc-settings-autonomos.php';
	return $settings;
}
