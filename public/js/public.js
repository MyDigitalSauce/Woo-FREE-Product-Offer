(function( $ ) {
'use strict';
console.log('WooOfferSettings', WooOfferSettings);
/*
 * Cookie
 * */
const Cookie = {
	read: function(name) {
		console.log('Cookie read'); // test
	    var nameEQ = name + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0;i < ca.length;i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1,c.length);
	        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	    }
	    return null;
	},
	create: function(name,value,days) {
	  if (days) {
	      var date = new Date();
	      date.setTime(date.getTime()+(days*24*60*60*1000));
	      var expires = "; expires="+date.toGMTString();
	  }
	  else var expires = "";
	  document.cookie = name+"="+value+expires+"; path=/";
	},
	erase: function(name) {
		createCookie(name,"",-1);
	}
}
/*
 * Woocommerce Offer
 * */
const Woo_Offer = {
    onLoad: function() {
    	const urlParams = new URLSearchParams(window.location.search);
    	const offer_slug = urlParams.get('offer');
    	// if offer url param exists
    	if (offer_slug) {
	    	// create Offer Cookie: cookie lasts 7 days
	    	Cookie.create('FreeProductOffer', offer_slug, 7);
	    	// show Offer Message
	    	Woo_Offer.showOfferMessage();
    	}
    	// if read OfferCookie not expired
    	if (Cookie.read('FreeProductOffer')) {
    		const offer = Woo_Offer.getOffer(offer_slug);
	    	// on Cart Change
	    	Woo_Offer.onListenCartTotalChanges(offer);    		
    	}
    },
    showOfferMessage: function() {
		const html = '<div class="woocommerce-message" role="alert">Receive a FREE Gift when your basket total is over $75!</div>'
		$('.xoo-wsc-notice-box .xoo-wsc-notice').html(html);
		$('.xoo-wsc-notice-box').fadeIn(1000);
		setTimeout(function() {
    		$('.xoo-wsc-notice-box').fadeOut(1000);
		}, 10000); // 10 sec
    },
    getOffer: function(offer_slug) {
    	const offers = [{
    		'name': 'FREE Eye Revive Creme 5ml',
    		'slug': 'free-eye-revive-creme-5ml',
    		'min': 75,
    		'type': 'percentage',
    		'discount': 100,
    		'product': { // FREE Eye Revive Creme 5ml: 4744
    			'id': WooOfferSettings.product.ID,
    			'title': WooOfferSettings.product.post_title,
    			// 'sku': '10776FG-1',
    		},
    	}];
    	// TODO: select offers from array by slug
    	return offers[0];
    },
    onListenCartTotalChanges: function(offer) {
		// console.log('onListenCartTotalChanges'); // test
		let total = jQuery('.xoo-wsc-total .amount').text();
		// listen to total amount change
		jQuery('body').on('DOMSubtreeModified', jQuery('.xoo-wsc-total .amount'), function() {
		    let newTotal = jQuery('.xoo-wsc-total .amount').text();
		    if ( total !== newTotal && newTotal ) {
		    	total = newTotal;
		    	// console.log('total updated', total)
				// wait 1 sec
				setTimeout(function() {
			    	Woo_Offer.onAddProductToCart(offer);
				}, 1000);
		    }
		});
    },
    isOfferCriteriaMet( offer ) {
		// console.log('offer criteria is met'); // test
		// if total >= offer min
		const total = $('.xoo-wsc-total .woocommerce-Price-amount').text().replace('$', '');
		return ( parseInt(Math.ceil(total)) >= offer.min );
    },
    onAddProductToCart: function(offer) {
    	// is NOT already in cart
		if ( Woo_Offer.isOfferCriteriaMet( offer ) && ! Woo_Offer.alreadyInCart(offer.product.title) ) {
	    	Woo_Offer.addProductToCart(offer);
    	} else {
		    Woo_Offer.setOfferProduct();
    	}
    },
    addProductToCart: function(offer) {
		// console.log('addProductToCart'); // test
    	const data = {
			"add-to-cart": offer.product.id,
			"action": "xoo_wsc_add_to_cart",
    	};
		$.ajax({
		  type: "POST",
		  url: themeScript.site_url + '/?wc-ajax=xoo_wsc_add_to_cart',
		  data: data,
		  dataType: "json",
		}).done(function(response) {
		  	console.log('success', response);
		  	Woo_Offer.appendProductToCart(response);
		}).fail(function(err) {
			console.error('failed', err);
		});
    },
    alreadyInCart: function(product_title) {
    	// console.log('product_title', product_title);
    	let return_this = false;
    	// loop over each product in cart
    	$('.xoo-wsc-product').each(function() {
    		// Eye Revive Creme
	    	let this_product_title = $(this).find('.xoo-wsc-sum-col:nth-child(2) a:nth-child(2)').text();
	    	// if product is offer product
	    	if (this_product_title === product_title) {
    			// then is already in cart
    			return_this = true;
	    	}
    	});
    	return return_this;
    },
    appendProductToCart: function(res) {
	  	// console.log('response', response);
	  	$('.xoo-wsc-notification-bar').replaceWith(res.fragments['div.xoo-wsc-notification-bar']);
	  	$('.xoo-wsc-body').replaceWith(res.fragments['div.xoo-wsc-body']);
	  	// remove quantity box of the offer product
	  	$('[data-xoo_wsc="' + res.cart_hash + '"] .xoo-wsc-qtybox').remove();
	  	$('.xoo-wsc-footer-content').replaceWith(res.fragments['div.xoo-wsc-footer-content']);
    	// if product price free 
    	Woo_Offer.setOfferProduct();
	  	$('.xoo-wsc-updating').hide();
	  	Woo_Offer.showCongratulationsPopup();
    },
    setOfferProduct: function() {
		console.log('setOfferProduct');
    	$('.xoo-wsc-product').each(function() {
    		let xoo_wsc = $(this).attr('data-xoo_wsc');
    		let this_product_amount = $(this).find('.amount');
    		let this_product_amount_text = this_product_amount.text();
    		if (this_product_amount_text === '$0.00') {
    			console.log('this_product_amount_text');
	    		this_product_amount.html('FREE');
	    		// remove quantity
	    		$(this).find('.xoo-wsc-qtybox').remove();
	    		// styling
	    		const body = $('body');
	    		if (! body.hasClass('offer-product-styled')) {
		    		body.prepend('<style>[data-xoo_wsc="' + xoo_wsc + '"] .xoo-wsc-qtybox {display: none;}</style>');
		    		body.addClass('offer-product-styled');
	    		}
	    		
    		}
    	});
    },
    showCongratulationsPopup: function() {
    	$('#offerSuccessModal').modal('show');
    	setTimeout(function() {
	    	$('#offerSuccessModal').modal('hide');
    	}, 10000); // 10 sec
    },
};
/*
 * Document ready
 * */
$(document).ready(function() {
    Woo_Offer.onLoad();
    // Set Offer Product amount to free and remove the quantity box
    setTimeout(function() {
	    Woo_Offer.setOfferProduct();
    }, 1500); // 1.5 sec
});
})( jQuery );
