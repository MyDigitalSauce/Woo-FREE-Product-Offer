<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://justinestrada.com
 * @since      0.0.2
 *
 * @package    Woo_Offer
 * @subpackage Woo_Offer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.2
 * @package    Woo_Offer
 * @subpackage Woo_Offer/includes
 * @author     Justin Estrada <justin@justinestrada.com>
 */
class Woo_Offer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.0.2
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-offer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
