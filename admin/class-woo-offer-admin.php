<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://justinestrada.com
 * @since      0.0.2
 *
 * @package    Woo_Offer
 * @subpackage Woo_Offer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Offer
 * @subpackage Woo_Offer/admin
 * @author     Justin Estrada <justin@justinestrada.com>
 */
class Woo_Offer_Admin {

	private $plugin_name;
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.2
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// Not needed 
		// $this->admin_ajax();

		add_action( 'admin_menu', array($this, 'create_admin_menu') );

	}

	/*
	public function admin_ajax() {

        require plugin_dir_path( __FILE__ ) . 'partials/admin-ajax.php';

	}
	*/


	public function create_admin_menu() {
		$hook = add_submenu_page(
			'options-general.php',
			'Woo FREE Product Offer - Settings',
			'Woo FREE Product Offer',
			'manage_options',
			'woo-free-product-offer',
			array($this, 'create_admin_page')
		);
	}

	public function create_admin_page() {
		
		require plugin_dir_path( __FILE__ ) . 'partials/admin-settings-page.php';

	}

}
