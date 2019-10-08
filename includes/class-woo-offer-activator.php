<?php

/**
 * Fired during plugin activation
 *
 * @link       https://justinestrada.com
 * @since      0.0.2
 *
 * @package    Woo_Offer
 * @subpackage Woo_Offer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.2
 * @package    Woo_Offer
 * @subpackage Woo_Offer/includes
 * @author     Justin Estrada <justin@justinestrada.com>
 */
class Woo_Offer_Activator {

	public static function activate() {
		// TODO:
		// plugin requires WooCommerce & Woocommerce sidebar cart
		// if not activated
		// fail to activate

		$init = get_option( 'wfpo_init' );
		if ( ! empty( $init ) ) {
			return;
		}

		$settings = array(
			'enable_offer' => false,
			'product_id' => null,
		);
		update_option( 'wfpo_settings', json_encode( $settings ) );

		update_option( 'wfpo_init', true );
	}

}
