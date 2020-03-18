<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://justinestrada.com
 * @since      0.0.2
 *
 * @package    Woo_Offer
 * @subpackage Woo_Offer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Offer
 * @subpackage Woo_Offer/public
 * @author     Justin Estrada <justin@justinestrada.com>
 */
class Woo_Offer_Public {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version, $settings ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $settings;

		$this->is_checkout = (strpos($_SERVER['REQUEST_URI'], 'checkout') !== false);

		if ( $this->settings->enable_offer && ! $this->is_checkout ) {
		    add_action( 'wp_footer', array($this, 'offer_success_modal') );
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.2
	 */
	public function enqueue_styles() {
		if ( $this->settings->enable_offer && ! $this->is_checkout ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.2
	 */
	public function enqueue_scripts() {
		if ( $this->settings->enable_offer && ! $this->is_checkout ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );
			$data = array(
				'product' => get_post($this->settings->product_id),
			);
			wp_localize_script( $this->plugin_name, 'WooOfferSettings', $data );
		}
	}

	public function offer_success_modal() { 
		?>
		<style>
		#offerSuccessModal {
			z-index: 999999;
		}
		#offerSuccessModal .modal-content {
			background-color: transparent !important;
			box-shadow: none;
			background-size: contain;
			background-repeat: repeat;				
		}
		</style>
		<div class="modal fade" id="offerSuccessModal" tabindex="-1" role="dialog" aria-labelledby="offerSuccessModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		    <div class="modal-content" >
		      <div class="modal-body" style="background-image: url('<?php echo plugin_dir_url( __FILE__ ); ?>/img/celebration.gif');" >
		      	<div class="text-center my-5 py-5" >
		      		<h3 class="text-white">Congratulations!</h3>
		      		<h6 class="text-white" style="font-size: 22px;">A <strong>FREE</strong> gift has been added to your basket<br>for achieving a basket total over $75.</h6>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>	
		<?php
	}

}
