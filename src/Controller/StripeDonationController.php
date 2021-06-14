<?php

namespace Drupal\stripe_donation\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller class for rendering our donation form
 */
class StripeDonationController extends ControllerBase 
{
    const CONFIG_NAME = 'stripe_donation.settings';

    /**
     * Render the content for the user facing donation page. This is where
     * we gather relevant site settings and attach the javascript we use
     * for the donation form. 
     * 
     * @return array
     */
    public function content() {
        $config = \Drupal::config('stripe_donation.settings');
        $site_config =\Drupal::config('system.site');
        $form = \Drupal::formBuilder()->getForm(
            'Drupal\stripe_donation\Form\StripeDonationForm'
        );

        return [
            '#theme' => 'stripe_donation',
            '#stripe_publishable_key' => $stripe_publishable_key,
            '#welcome_text' => $this->t($config->get('welcome_text')),
            '#attached' => [
                'library' => [
                    'stripe_donation/stripe_donation'
                ],
                // Javascript variables passed
                'drupalSettings' => [
                    'site' => [
                        'name' => $site_config->get('name')
                    ],
                    'stripe_donation' => [
                        'stripe_publishable_key' => $config->get('stripe_publishable_key'),
                        'form_id' => $form['#id']
                    ]
                ]
            ],
            '#form' => $form
        ];
    }
}
