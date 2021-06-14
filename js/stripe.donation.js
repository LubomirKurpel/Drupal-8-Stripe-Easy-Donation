/**
 * This initializes everything necessary to set up our donation form.
 *
 * Code here was heavily borrowed from this thread: 
 *    https://stackoverflow.com/questions/55856608/search-for-php-example-new-stripe-checkout-integration-stripe-php
 * 
 * Please see the Stripe documentation for more information.
 */

/**
 * Alias jQuery
 */
 
var $ = jQuery;

$( document ).ready(function() {
    $('#stripe-donation-form #amount').once().after('<div class="donation_currency">€</div>');
});

document.addEventListener("DOMContentLoaded", function(event) {
	var stripe = Stripe(drupalSettings.stripe_donation.stripe_publishable_key); // test publishable API key
	var elements = stripe.elements();

	var card = elements.create('card');
	// Add an instance of the card UI component into the `card-element` <div>
	card.mount('#card-element');

	// Handle events and errors
	card.addEventListener('change', function(event) {
		var displayError = document.getElementById('card-errors');
		if (event.error) {
			displayError.textContent = event.error.message;
		} else {
			displayError.textContent = '';
		}
	});

	function stripeTokenHandler(token) {
		// Insert the token ID into the form so it gets submitted to the server
		var form = document.getElementById('stripe-donation-form');
		var hiddenInput = document.createElement('input');
		hiddenInput.setAttribute('type', 'hidden');
		hiddenInput.setAttribute('name', 'stripeToken');
		hiddenInput.setAttribute('value', token.id);
		form.appendChild(hiddenInput);
		  
		$('[name="token"]').val(token.id);

		// Submit the form
		form.submit();
	}

	function createToken() {
		stripe.createToken(card).then(function(result) {
			if (result.error) {
				// Inform the user if there was an error
				var errorElement = document.getElementById('card-errors');
				errorElement.textContent = result.error.message;
			} else {
				// Send the token to your server
				stripeTokenHandler(result.token);
			}
		});
	};

	// Create a token when the form is submitted.
	var form = document.getElementById('stripe-donation-form');
	form.addEventListener('submit', function(e) {
		e.preventDefault();
		createToken();
	});
});
