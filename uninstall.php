<?php
//if uninstall not called from WordPress exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) || ! current_user_can( 'activate_plugins' ) ) {
	exit();
}

// remove options added by Autonomos Plugin

$options = array(
	'wc_settings_tab_autonomos_title',
	'autonomos_is_active',
	'autonomos_per_retention',
	'autonomos_checkout_redirect',
	'autonomos_add_button_quantity',
);
foreach ( $options as $option ) {
	delete_option( $option );
}
