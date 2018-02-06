<?php
/*
Plugin Name: Autonomos
Plugin URI: https://www.joseconti.com
Description: Plugins for spaniards "Autonomos"
Version: 1.1.0.2
Author: j.conti
Author URI: https://www.joseconti.com
Tested up to: 4.9.3
Text Domain: autonomos
Domain Path: /languages/
License: GPLv2 only
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
	
define( 'AUTONOMOS_VERSION',    	'1.1.0.2'                 	);
define( 'AUTONOMOS_PLUGIN_PATH',	plugin_dir_path( __FILE__ )	);
define( 'AUTONOMOS_PLUGIN_URL',		plugin_dir_url( __FILE__ )	);

require_once( AUTONOMOS_PLUGIN_PATH . 'core/loader-core.php' );

function autonomos_init() {
    load_plugin_textdomain( 'autonomos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('init', 'autonomos_init');