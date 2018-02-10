<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	/**
	 * Settings class
	 *
	 * @since 1.0.0
	 */

	class WC_Settings_Autonomos {

    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_autonomos', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_autonomos', __CLASS__ . '::update_settings' );
    }


    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_autonomos'] = __( 'Autonomos', 'autonomos' );
        return $settings_tabs;
    }


    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {

        $settings = array(
             'title' => array(
                'name'     => __( 'Autonomos', 'autonomos' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_autonomos_title'
            ),
            'autonomos_is_active'=> array(
				'title'			=> __( 'Activate Autonomos', 'autonomos' ),
				'type'			=> 'checkbox',
				'label'			=> __( 'Activate Autonomos.', 'autonomos' ),
				'default'		=> 'no',
				'desc'			=> sprintf( __( 'Activate Autonomos', 'autonomos' ) ),
				'id'			=> 'autonomos_is_active'
									),
            'irpf_value' => array(
                'name' => __( '% IRPF', 'autonomos' ),
                'type' => 'text',
                'desc' => __( 'Add here the % retention, example 15', 'autonomos' ),
                'id'   => 'autonomos_per_retention'
									),
			'autonomos_checkout_redirect'=> array(
				'title'			=> __( 'Redirect to checkout', 'autonomos' ),
				'type'			=> 'checkbox',
				'label'			=> __( 'Redirect to checkout.', 'autonomos' ),
				'default'		=> 'no',
				'desc'			=> sprintf( __( 'Redirect directly to checkout when a user add a product', 'autonomos' ) ),
				'id'			=> 'autonomos_checkout_redirect'
									),
			'autonomos_add_button_quantity'=> array(
				'title'			=> __( 'Add quantity to shop page & archive', 'autonomos' ),
				'type'			=> 'checkbox',
				'label'			=> __( 'Add quantity to shop page & archive.', 'autonomos' ),
				'default'		=> 'no',
				'desc'			=> sprintf( __( 'Add quantity to shop page & archive so buyers can add product quantity from Shop Page & Archive Page', 'autonomos' ) ),
				'id'			=> 'autonomos_add_button_quantity'
									),
			'autonomos_section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_autonomos_section_end'
				 					)
        );

        return apply_filters( 'wc_settings_tab_autonomos_settings', $settings );
    }

}

	WC_Settings_Autonomos::init();