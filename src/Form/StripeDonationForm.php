<?php

namespace Drupal\stripe_donation\Form;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 * This is a user facing form for collecting donations with Stripe
 * @see \Drupal\Core\Form\FormBase
 */
class StripeDonationForm extends FormBase 
{
    /**
     * Build our Stripe donation form. This is the end user facing form
     *
     * @param array $form
     *   Default form array structure.
     * @param FormStateInterface $form_state
     *   Object containing current form state.
     *
     * @return array
     *   The render array defining the elements of the form.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['amount'] = [
            '#id' => 'amount',
            '#type' => 'number',
            '#title' => $this->t('Donation Amount'),
            '#description' => $this->t('Please tell us the amount you would like to donate.'),
            '#required' => TRUE,
        ];
		
        $form['token'] = [
            '#type' => 'hidden'
        ];
		
        $form['card-element'] = [
            '#type' => 'markup',
			'#markup' => '<div id="card-element"><!-- Your form goes here --></div>',
        ];
		
        $form['card-errors'] = [
            '#type' => 'markup',
			'#markup' => '<div id="card-errors" role="alert"></div>',
        ];

        $form['actions'] = [
            '#type' => 'actions',
        ];

        $form['actions']['submit'] = [
            '#id' => 'donate',
            '#type' => 'submit',
            '#value' => $this->t('Donate'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'stripe_donation_form';
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // TODO: Log the purchase amount along with any other information that
        // would be useful to store about the transaction.
        $amount = $form_state->getValue('amount');
		
		$stripe_secret_key = \Drupal::config('stripe_donation.settings')->get('stripe_secret_key');
		
		\Stripe\Stripe::setApiKey($stripe_secret_key);
		try {
			$intent = \Stripe\PaymentIntent::create([
				'payment_method_data' => [
					'type' => 'card',
					'card' => ['token' => $form_state->getValue('token')],
				],
				'amount' => $amount * 100,
				'currency' => 'eur',
				'confirmation_method' => 'manual',
				'confirm' => true,
			]);
			
			\Drupal::messenger()->addStatus('Donation was successfully sent. Thank you for your support.');

		}
		catch(Exception $e)
		{
			
		   // something went wrong
		   \Drupal::messenger()->addStatus('Donation have failed. Please try later.');
		   
		}
		
    }
}
