# Drupal 8 Easy Stripe Donation

## What does this module do?
This is a simple module that adds the ability to accept donations
using the Stripe Javascript Check Out API.  The end result is a new 
main menu item "Donate".  This leads users to a page where they can 
specify exactly how much they would like to donate. Afterwards, payment
infomation are being collected and sent off to Stripe.

This module uses Stripe API V3.

## Requirements
- Stripe account and API tokens
- Drupal 8 / 9 (not tested in 9 but it should work)

## Installation
To install this module you will want to put the source in the 
[appropriate directory](https://www.drupal.org/docs/8/extending-drupal-8/installing-modules#mod_location).
After you have placed the module there, simply enable it as you would
any other module.

## Configuring
To use this module, you will need a Stripe account.  Specifically, you will
need a "Publishable" key, and a "Secret" key. Both keys needs to be put in a 
configuration page. We strongly recommend testing your installation with test
keys first before proceeding to using the live keys.

## Special thanks
This module was initially written by someone on github, but I was not able
to find the author. Repo was probably deleted. The module before used
now already deprecated stripe API. I re-wrote the module to use the newer
version.