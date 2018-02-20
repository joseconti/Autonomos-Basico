<?php
/*
Plugin Name: Autonomos
Plugin URI: https://www.joseconti.com
Description: Plugins for Spanish Autonomos. Autonomos add tools to WooCommerce for Autonomos
Version: 1.3.0
Author: Jose Conti
Author URI: https://www.joseconti.com
Tested up to: 4.9.3
Text Domain: autonomos
Domain Path: /languages/
License: GPLv2 only
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

	define( 'AUTONOMOS_VERSION', '1.3.0' );
	define( 'AUTONOMOS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	define( 'AUTONOMOS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

	add_action( 'plugins_loaded', 'autonomos_init', 11 );


	function autonomos_init() {
	    load_plugin_textdomain( 'autonomos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	        include_once( AUTONOMOS_PLUGIN_PATH . 'core/loader-core.php' );
	    }
	}

	add_filter( 'woocommerce_get_settings_pages', 'autonomos_include_woocommerce_setting_file' );
	function autonomos_include_woocommerce_setting_file( $settings ) {

	    $settings[] = include( AUTONOMOS_PLUGIN_PATH . 'core/woocommerce/woo-functions.php' );

	    return $settings;

	}