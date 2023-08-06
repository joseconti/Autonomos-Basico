<?php
/**
 * Class WC_Gateway_Redsys_Global
 *
 * @package Autonomos Lite
 * @author José Conti.
 * @link https://joseconti.com
 * @license GNU General Public License v3.0
 * @license URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) || exit;

use Automattic\WooCommerce\Utilities\OrderUtil;

/**
 * Autonomos Lite Global class
 */
class WC_Autonomos_Lite_Global {
	/**
	 * Update order meta.
	 *
	 * @param int    $post_id Post ID.
	 * @param array  $meta_key_array Meta keys array.
	 * @param string $meta_value Meta value.
	 *
	 * @return void
	 */
	public function update_order_meta( $post_id, $meta_key_array, $meta_value = false ) {
		if ( ! is_array( $meta_key_array ) ) {
			$meta_keys = array( $meta_key_array => $meta_value );
		} else {
			$meta_keys = $meta_key_array;
		}
		$order_id = $this->get_order_meta( $post_id, 'post_id', true );
		if ( $order_id ) {
			$post_id = $order_id;
			$order   = wc_get_order( $post_id );
		} else {
			$order = wc_get_order( $post_id );
		}
		foreach ( $meta_keys as $meta_key => $meta_value ) {
			$order->update_meta_data( $meta_key, $meta_value );
		}
		$order->save();
	}
	/**
	 * Get order meta.
	 *
	 * @param int    $order_id Order ID.
	 * @param string $key Meta key.
	 * @param bool   $single Single.
	 * @param string $context Context.
	 *
	 * @return mixed
	 */
	public function get_order_meta( $order_id, $key, $single = true, $context = false ) {
		$order = wc_get_order( $order_id );
		if ( $order ) {
			return $order->get_meta( $key, $single, $context );
		}
		return false;
	}
}
