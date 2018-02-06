<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    $autonomos_is_active = get_option( 'autonomos_is_active', 1 );

    function autonomos_add_user_type_select() {
        if ( is_checkout() ) {
        ?>
        <script type="text/javascript">

        jQuery(document).ready(function($) {
            $('.user-type-2').select2();
        });
        </script>
        <?php
        }
    }

    // Our hooked in function - $fields is passed via the filter!
    function autonomos_override_checkout_fields( $show_fields ) {


        $show_fields['billing']['billing_user_type'] = array(
        'label'       => __('You are?', 'autonomos'),
        'placeholder' => _x('', 'placeholder', 'autonomos'),
        'required'    => false,
        'class'       => array( 'update_totals_on_change', 'user-type' ),
        'input_class' => array( 'user-type-2' ),
        'clear'       => false,
        'type'        => 'select',
        'options'     => array(
              'private_user'    => __( 'Private User', 'autonomos' ),
              'business'        => __( 'Business', 'autonomos' ),
              'self-employed'   => __( 'Self Employed', 'autonomos' )
            )
        );

        $show_fields['billing']['billing_user_dni'] = array(
        'label'       => __( 'CIF / NIF / NIE', 'autonomos' ),
        'placeholder' => _x( '', 'placeholder', 'autonomos' ),
        'required'    => false,
        'clear'       => false,
        'type'        => 'text'
        );

		return $show_fields;
    }

	function autonomos_custom_admin_billing_fields( $profileFieldArray ) {

        $show_user_type = array(
					'label'			=> __( 'User Type', 'autonomos' ),
					'description'	=> '',
					'type'        => 'select',
			        'options'     => array(
			              'private_user'    => __( 'Private User', 'autonomos' ),
			              'business'        => __( 'Business', 'autonomos' ),
			              'self-employed'   => __( 'Self Employed', 'autonomos' )
			            )
					);

		$show_dni = array(
					'label'			=> __( 'CIF / NIF / NIE', 'autonomos' ),
					'description'	=> '',
					);

		$profileFieldArray['billing']['fields']['billing_user_type'] = $show_user_type;
		$profileFieldArray['billing']['fields']['billing_user_dni'] = $show_dni;


		return $profileFieldArray;

	}

    function autonomos_custom_surcharge( $total, $cart ) {
        global $woocommerce;


        $amount_to_discount = $cart->cart_contents_total + $cart->shipping_total;
        $percentage         = get_option( 'autonomos_per_retention', 1 );
        $discounted_amount  = $amount_to_discount * $percentage / 100;



        if ( is_admin() && ! defined( 'DOING_AJAX' ) )
            return;

        $country    = array('ES');

        if ( isset( $_POST['post_data'] ) ) {
            parse_str( $_POST['post_data'], $post_data );
        } else {
            $post_data = $_POST; // fallback for final checkout (non-ajax)
        }

        if ( ( in_array( WC()->customer->get_billing_country(), $country ) ) && ( isset( $post_data['billing_user_type'] ) && ( $post_data['billing_user_type'] == 'business' || $post_data['billing_user_type'] == 'self-employed' ) ) ) {

            $new_total = $total - $discounted_amount;
            return round( $new_total, $cart->dp );
            } else {
                return round( $total, $cart->dp );
            }

    }

    function autonomos_show_irpf_checkout(){
        global $woocommerce;

        $autonomos_retention = get_option( 'autonomos_per_retention', 1 );
        $percentage          = -1*( intval( $autonomos_retention )/100 );

        if ( is_admin() && ! defined( 'DOING_AJAX' ) )
            return;

        $country    = array('ES');
        $surcharge  = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percentage;

        if ( isset( $_POST['post_data'] ) ) {
            parse_str( $_POST['post_data'], $post_data );
        } else {
            $post_data = $_POST; // fallback for final checkout (non-ajax)
        }
        if ( ( in_array( WC()->customer->get_billing_country(), $country ) ) && ( isset( $post_data['billing_user_type'] ) && ( $post_data['billing_user_type'] == 'business' || $post_data['billing_user_type'] == 'self-employed' ) ) ) { ?>
        <tr class="tax-rate tax-rate-es-iva-1">
                        <th><?php echo $autonomos_retention; ?>% IRPF</th>
                        <td><span class="woocommerce-Price-amount amount"><?php echo number_format( round( $surcharge, 2 ), 2 ); ?><span class="woocommerce-Price-currencySymbol">€</span></span></td>
                    </tr>
         <?php }
    }

    /**
     * Update the order meta with field value Add the IRPF
     */

    function autonomos_custom_checkout_irpf_field_update_order_meta( $order_id ) {

        $country             = get_post_meta( $order_id, '_billing_country', true   );
        $user_type           = get_post_meta( $order_id, '_billing_user_type', true );

        if ( $country == 'ES' && ( $user_type == 'business' || $user_type == 'self-employed' ) ) {

            $shipping_cost       = get_post_meta( $order_id, '_order_shipping', true );
            $autonomos_retention = get_option( 'autonomos_per_retention', 1 );
            $percentage          = -1*( intval( $autonomos_retention )/100 );
            $order               = wc_get_order( $order_id );
            $order_subtotal      = $order->get_subtotal();
            $surcharge           = ( $order_subtotal + $shipping_cost ) * $percentage;

            update_post_meta( $order_id, '_billing_order_irpf', number_format(round( $surcharge, 2 ), 2 ) );
        }

    }

    function autonomos_custom_checkout_field_display_admin_order_meta( $order ){

	    $user_type = get_post_meta( $order->get_id(), '_billing_user_type', true );

	    if ( $user_type == private_user ) {
		    $user_type = __( 'Private User', 'autonomos');
	    } elseif ( $user_type == business ) {
		    $user_type = __( 'Business', 'autonomos');
	    } else {
		    $user_type = __( 'Self Employed', 'autonomos');
	    }

        echo '<p><strong>' . __( 'User Type', 'autonomos') . ':</strong> ' . $user_type . '</p>';
    }

    function autonomos_display_admin_order_irpf( $order_id ){

        $irpf_order          = get_post_meta( $order_id, '_billing_order_irpf', true );
        $autonomos_retention = get_option( 'autonomos_per_retention', 1 );
        if ( empty( $irpf_order ) ) return;
    ?>

        <tr class="irpf" data-order_item_id="500">
            <td class="thumb"></td>

            <td class="name">
                <div class="view">
                    <?php echo $autonomos_retention; ?>% IRPF
                </div>
                <div class="edit" style="display: none;">
                    <input type="text" placeholder="Nombre de la cuota" name="order_item_name[2]" value="-15% IRPF">
                    <input type="hidden" class="order_item_id" name="order_item_id[]" value="2">
                    <input type="hidden" name="order_item_tax_class[2]" value="">
                </div>
            </td>


            <td class="item_cost" width="1%">&nbsp;</td>
            <td class="quantity" width="1%">&nbsp;</td>

            <td class="line_cost" width="1%">
                <div class="view">
                    <span class="woocommerce-Price-amount amount"><?php echo $irpf_order; ?><span class="woocommerce-Price-currencySymbol">€</span></span>
                </div>
                <div class="edit" style="display: none;">
                    <input type="text" name="line_total[2]" placeholder="0" value="-3" class="line_total wc_input_price">
                </div>
                <div class="refund" style="display: none;">
                    <input type="text" name="refund_line_total[2]" placeholder="0" class="refund_line_total wc_input_price">
                </div>
            </td>

            <td class="line_tax" width="1%">
                <div class="view"> - </div>
                <div class="edit" style="display: none;">
                    <input type="text" name="line_tax[2][1]" placeholder="0" value="" class="line_tax wc_input_price">
                </div>
                <div class="refund" style="display: none;">
                    <input type="text" name="refund_line_tax[2][1]" placeholder="0" class="refund_line_tax wc_input_price" data-tax_id="1">
                </div>
            </td>

            <td class="wc-order-edit-line-item">
            </td>
        </tr>

    <?php }

    function autonomos_checkout_priority_fields( $fields ) {

        $fields['billing']['billing_user_type']['priority'] = 1;
        $fields['billing']['billing_user_dni']['priority']  = 30;

        return $fields;
    }

    function autonomos_woocommerce_get_order_item_totals( $totals, $order ) {

        $irpf_order = get_post_meta( $order->id, '_billing_order_irpf', true );

        if ( empty( $irpf_order ) ) return $totals;

        $autonomos_retention = get_option( 'autonomos_per_retention', 1 );

        $order_total = $totals['order_total'];
        $payment_method = $totals['payment_method'];
        unset($totals['order_total']);
        unset($totals['payment_method']);

        $totals['irpfmail'] = array(
            'label' => $autonomos_retention . '% IRPF:',
            'value' => $irpf_order . '€',
        );
        $totals['payment_method'] = $payment_method;
        $totals['order_total']    = $order_total;

        return $totals;
    }

    if ( $autonomos_is_active == 'yes'  ) {

		add_filter( 'woocommerce_customer_meta_fields',                   'autonomos_custom_admin_billing_fields'                             );
		add_filter( 'woocommerce_get_order_item_totals', 				  'autonomos_woocommerce_get_order_item_totals',				10, 2 );
        add_action( 'woocommerce_checkout_update_order_meta', 			  'autonomos_custom_checkout_irpf_field_update_order_meta' 			  );
        add_action( 'wp_footer', 										  'autonomos_add_user_type_select' 									  );
        add_action( 'woocommerce_review_order_before_order_total', 		  'autonomos_show_irpf_checkout' 									  );
        add_filter( 'woocommerce_checkout_fields' , 					  'autonomos_override_checkout_fields' 								  );
        add_filter( 'woocommerce_checkout_fields', 						  'autonomos_checkout_priority_fields'								  );
        add_filter( 'woocommerce_calculated_total', 					  'autonomos_custom_surcharge', 							  1001, 2 );
        add_action( 'woocommerce_admin_order_data_after_billing_address', 'autonomos_custom_checkout_field_display_admin_order_meta',	10, 1 );
        add_action( 'woocommerce_admin_order_items_after_shipping', 	  'autonomos_display_admin_order_irpf', 						10, 1 );

    }