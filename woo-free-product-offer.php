<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://justinestrada.com
 * @since             0.0.2
 * @package           Woo_Offer
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Offer
 * Plugin URI:        https://radicalskincare.com
 * Description:       Checks for an offer url query and adds that offer to the cart, requires woocommerce.
 * Version:           0.1.0
 * Author:            Justin Estrada
 * Author URI:        https://justinestrada.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-offer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'Woo_Offer_VERSION', '0.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-offer-activator.php
 */
function activate_Woo_Offer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-offer-activator.php';
	Woo_Offer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-offer-deactivator.php
 */
function deactivate_Woo_Offer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-offer-deactivator.php';
	Woo_Offer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Woo_Offer' );
register_deactivation_hook( __FILE__, 'deactivate_Woo_Offer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-offer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.2
 */
function run_Woo_Offer() {

	$plugin = new Woo_Offer();
	$plugin->run();

}
run_Woo_Offer();
