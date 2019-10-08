<?php
/**
 * Provide a admin area view for the plugin
 *
 */

$success_msg = "";
if (  isset($_POST['action']) && $_POST['action'] === 'update_settings'  ) {
	$settings = array(
	    'enable_offer' => ( isset($_POST['enable_offer']) ) ? true : false,
	    'product_id' => $_POST['product_id'],
	);
	update_option( 'wfpo_settings', json_encode( $settings ) );
	$success_msg = __( 'Settings Updated.' );
}

if ( ! empty( $success_msg ) ) { ?>
	<div class="notice notice-success is-dismissible">
		<p><?php echo $success_msg; ?></p>
	</div>
<?php }

$settings = json_decode( get_option( 'wfpo_settings' ) ); ?>

<div class="wrap">

	<h1>Woo FREE Product Offer</h1>
	<p>Checks for an offer url query and adds that offer to the cart, requires woocommerce.</p>

	<form method="post" action="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=woo-free-product-offer" >

		<table class="form-table">
			<tbody>

				<tr>
					<th>
						<label for="enable_offer" >Enable</label>
					</th>
					<td>
						<input type="checkbox" id="enable_offer" name="enable_offer" value="1" <?php echo ( $settings->enable_offer ) ? 'checked': ''; ?> /> Enable Offer.
					</td>
				</tr>
				<tr>
					<th>
						<label for="product_id" >Product ID</label>
					</th>
					<td>
						<input type="text" id="product_id" name="product_id" class="regular-text" value="<?php echo stripslashes($settings->product_id); ?>" />
					</td>
				</tr>
			</tbody>
		</table>

		<button type="submit" name="action" value="update_settings" class="button button-primary" >Save Changes</button>

	</form>

</div>