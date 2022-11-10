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

document.addEventListener("DOMContentLoaded", function(event) {
  var stripe = Stripe(drupalSettings.stripe_donation.stripe_publishable_key); // test publishable API key
  var hidePostalCode = drupalSettings.stripe_donation.stripe_hide_postalcode || 0 ;
  var stripeDefaultCurrency = drupalSettings.stripe_donation.stripe_default_currency || 'EUR';
  var elements = stripe.elements();
  var currency_list = {
    "ALL": "Lek", 
    "DZD": "دج", 
    "AOA": "Kz", 
    "ARS": "$", 
    "AMD": "֏", 
    "AWG": "ƒ", 
    "AUD": "$", 
    "AZN": "m", 
    "BSD": "B$", 
    "BDT": "৳", 
    "BBD": "Bds$", 
    "BZD": "$", 
    "BMD": "$", 
    "BOB": "Bs.", 
    "BAM": "KM", 
    "BWP": "P", 
    "BRL": "R$", 
    "GBP": "£", 
    "BND": "B$", 
    "BGN": "Лв.", 
    "BIF": "FBu", 
    "KHR": "KHR", 
    "CAD": "$", 
    "CVE": "$", 
    "KYD": "$", 
    "XOF": "CFA", 
    "XAF": "FCFA", 
    "XPF": "₣", 
    "CLP": "$", 
    "CNY": "¥", 
    "COP": "$", 
    "KMF": "CF", 
    "CDF": "FC", 
    "CRC": "₡", 
    "HRK": "kn", 
    "CUC": "$, CUC",
    "CZK": "Kč", 
    "DKK": "Kr.", 
    "DJF": "Fdj", 
    "DOP": "$", 
    "XCD": "$", 
    "EGP": "ج.م", 
    "ETB": "Nkf", 
    "EUR": "€", 
    "FKP": "£", 
    "FJD": "FJ$", 
    "GMD": "D", 
    "GEL": "ლ", 
    "GIP": "£", 
    "GTQ": "Q", 
    "GNF": "FG", 
    "GYD": "$", 
    "HTG": "G", 
    "HNL": "L", 
    "HKD": "$", 
    "HUF": "Ft", 
    "ISK": "kr", 
    "INR": "₹", 
    "IDR": "Rp", 
    "IRR": "﷼", 
    "ILS": "₪", 
    "ITL": "L,£", 
    "JMD": "J$", 
    "JPY": "¥", 
    "KZT": "лв", 
    "KES": "KSh", 
    "KGS": "лв", 
    "LAK": "₭", 
    "LBP": "£", 
    "LSL": "L", 
    "LRD": "$", 
    "MOP": "$", 
    "MKD": "ден", 
    "MGA": "Ar", 
    "MWK": "MK", 
    "MYR": "RM", 
    "MVR": "Rf", 
    "MRO": "MRU", 
    "MUR": "₨", 
    "MXN": "$", 
    "MDL": "L", 
    "MNT": "₮", 
    "MAD": "MAD", 
    "MMK": "K", 
    "NAD": "$", 
    "NPR": "₨", 
    "ANG": "ƒ", 
    "TWD": "$", 
    "NZD": "$", 
    "NIO": "C$", 
    "NGN": "₦", 
    "NOK": "kr", 
    "PKR": "₨", 
    "PAB": "B/.", 
    "PGK": "K", 
    "PYG": "₲", 
    "PEN": "S/.", 
    "PHP": "₱", 
    "PLN": "zł", 
    "QAR": "ق.ر", 
    "RON": "lei", 
    "RUB": "₽", 
    "RWF": "FRw", 
    "WST": "SAT", 
    "SAR": "﷼", 
    "RSD": "din", 
    "SCR": "SRe", 
    "SLL": "Le", 
    "SGD": "$", 
    "SBD": "Si$", 
    "SOS": "Sh.so.", 
    "ZAR": "R", 
    "KRW": "₩", 
    "LKR": "Rs", 
    "SHP": "£", 
    "SDG": ".س.ج",
    "SRD": "$", 
    "SZL": "E", 
    "SEK": "kr", 
    "CHF": "CHF", 
    "STD": "Db", 
    "TJS": "SM", 
    "TZS": "TSh", 
    "THB": "฿", 
    "TOP": "$", 
    "TTD": "$", 
    "TRY": "₺", 
    "UGX": "USh", 
    "UAH": "₴", 
    "AED": "إ.د", 
    "UYU": "$", 
    "USD": "$", 
    "UZS": "лв", 
    "VUV": "VT", 
    "VND": "₫", 
    "YER": "﷼",
  };
    var options = {
      iconStyle: 'solid'
    };


  if (hidePostalCode == 1) {
    options.hidePostalCode = true;
  }
  var card = elements.create('card', options);
  // Add an instance of the card UI component into the `card-element` <div>
  card.mount('#card-element');

  $( "#amount" ).after( '<span> ' +  currency_list[stripeDefaultCurrency] + '</span>');

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
