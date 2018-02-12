<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	if ( ! class_exists( 'WC_Settings_Autonomos' ) ) :
	/**
	 * Settings class
	 *
	 * @since 1.0.0
	 */
	class WC_Settings_Autonomos extends WC_Settings_Page {

	    /**
		 * Setup settings class
		 *
		 * @since  1.0
		 */
		public function __construct() {

		    $this->id    = 'autonomos';
		    $this->label = __( 'Autonomos', 'autonomos' );

		    add_filter( 'woocommerce_settings_tabs_array',        array( $this, 'add_settings_page' ), 20 );
		    add_action( 'woocommerce_settings_' . $this->id,      array( $this, 'output' ) );
		    add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
			//add_action( 'add_tax', array( $this, 'add_tax' ) );

		    // only add this if you need to add sections for your settings tab
		    add_action( 'woocommerce_sections_' . $this->id,      array( $this, 'output_sections' ) );
		}

		public function get_sections() {

	    $sections = array(
	        ''         => __( 'General', 'autonomos' ),
	        'equivalence_surcharge'   => __( 'Equivalence Surcharge', 'autonomos' )
	    );

	    return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
		}

		public function add_tax() {
			$tax_classes = WC_Tax::get_tax_classes();
			$tax = array();
			foreach ( $tax_classes as $class ) {
				$new[] = array(
						'title'			=> __( $class , 'autonomos' ),
						'type'			=> 'text',
						'css'			=> 'width:50px;',
						'desc'			=> __( '% Equivalence Surcharge', 'autonomos' ),
						'id'			=> 'autonomos_equivalence_surcharge_' . sanitize_title( $class ),
					);
			}
			return $new;
		}

		// Seting page

		public function get_settings( $current_section = '' ) {

			if ( 'equivalence_surcharge' == $current_section ) {

				/**
				 * Filter Plugin Section 2 Settings
				 *
				 * @since 1.0.0
				 * @param array $settings Array of the plugin settings
				 */
				$settings1 = apply_filters( 'autonomos_equivalence_surcharge_settings', array(

					array(
		                'name'     => __( 'Equivalence Surcharge', 'autonomos' ),
		                'type'     => 'title',
		                'desc'     => '',
		                'id'       => 'wc_settings_tab_autonomos_equivalence_surcharge_title'
		            ),
		            array(
						'title'			=> __( 'Activate Equivalence Surcharge', 'autonomos' ),
						'type'			=> 'checkbox',
						'label'			=> __( 'Activate Equivalence Surcharge.', 'autonomos' ),
						'default'		=> 'no',
						'desc'			=> __( 'Activate Equivalence Surcharge', 'autonomos' ),
						'id'			=> 'autonomos_equivalence_surcharge_is_active'
					),
				));

				$settings2 = apply_filters( 'autonomos_equivalence_surcharge_settings', $this->add_tax());
				$settings3 = apply_filters( 'autonomos_equivalence_surcharge_settings', array(
					array(
		                 'type' => 'sectionend',
		                 'id' => 'wc_settings_tab_autonomos_section_equivalence_surcharge_end'
					)));
				$settings = apply_filters( 'autonomos_equivalence_surcharge_settings', array_merge( $settings1, $settings2, $settings3 ));
			} else {

				/**
				 * Filter Plugin Section 1 Settings
				 *
				 * @since 1.0.0
				 * @param array $settings Array of the plugin settings
				 */
				$settings = apply_filters( 'autonomos_section1_settings', array(

					array(
		                'name'     => __( 'Autonomos', 'autonomos' ),
		                'type'     => 'title',
		                'desc'     => '',
		                'id'       => 'wc_settings_tab_autonomos_title'
		            ),
		            array(
						'title'			=> __( 'Activate Autonomos', 'autonomos' ),
						'type'			=> 'checkbox',
						'label'			=> __( 'Activate Autonomos.', 'autonomos' ),
						'default'		=> 'no',
						'desc'			=> __( 'Activate Autonomos', 'autonomos' ),
						'id'			=> 'autonomos_is_active'
					),
		            array(
		                'name' => __( '% IRPF', 'autonomos' ),
		                'type' => 'text',
		                'css'      => 'width:50px;',
		                'desc' => __( 'Add here the % retention, example 15', 'autonomos' ),
		                'id'   => 'autonomos_per_retention'
					),
					array(
						'title'			=> __( 'Redirect to checkout', 'autonomos' ),
						'type'			=> 'checkbox',
						'label'			=> __( 'Redirect to checkout.', 'autonomos' ),
						'default'		=> 'no',
						'desc'			=> __( 'Redirect directly to checkout when a user add a product', 'autonomos' ),
						'id'			=> 'autonomos_checkout_redirect'
					),
					array(
						'title'			=> __( 'Add quantity to shop page & archive', 'autonomos' ),
						'type'			=> 'checkbox',
						'label'			=> __( 'Add quantity to shop page & archive.', 'autonomos' ),
						'default'		=> 'no',
						'desc'			=> __( 'Add quantity to shop page & archive so buyers can add product quantity from Shop Page & Archive Page', 'autonomos' ),
						'id'			=> 'autonomos_add_button_quantity'
					),
					array(
		                 'type' => 'sectionend',
		                 'id' => 'wc_settings_tab_autonomos_section_end'
					)
				));

			}
			/**
			 * Filter MyPlugin Settings
			 *
			 * @since 1.0.0
			 * @param array $settings Array of the plugin settings
			 */
			return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );

		}
		// End Setting page

		public function output() {

		    global $current_section;

		    $settings = $this->get_settings( $current_section );
		    WC_Admin_Settings::output_fields( $settings );
		}

		/**
		 * Save settings
		 *
		 * @since 1.0
		 */
		public function save() {

		    global $current_section;

		    $settings = $this->get_settings( $current_section );
		    WC_Admin_Settings::save_fields( $settings );
		}
			// Closing tab
			}
	endif;

	return new WC_Settings_Autonomos();