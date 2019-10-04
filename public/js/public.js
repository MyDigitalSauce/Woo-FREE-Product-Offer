(function( $ ) {
'use strict';
console.log('woo-offer public.js')
/*
 * Woocommerce Offer
 * */
const Woo_Offer = {
    onLoad: function() {
    	// if offer in url query
    	if ( window.location.search.indexOf('offer') !== -1 ) {
    		$('.xoo-wsc-notice-box .woocommerce-message').html('Offer!!')
    	}
    }
};
/*
 * Document ready
 * */
$(document).ready(function() {
    Woo_Offer.onLoad();
});
})( jQuery );
