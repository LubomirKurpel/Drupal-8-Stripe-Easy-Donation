<?php

namespace Drupal\stripe_donation\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase; 

class StripeDonationConfigForm extends ConfigFormBase {
    /**
     * @var string Name of our configuration
     */
    const CONFIG_NAME = 'stripe_donation.settings';

    /**
     * @var string Unique identifier for our form
     */
    const FORM_ID = 'stripe_donation_config';

    /**
     * Returns ConfigFactory object
     *
     * @return array, list of editable config names
     */
    protected function getEditableConfigNames(){
        return [
            self::CONFIG_NAME
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function getFormId(){
        return self::FORM_ID;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) { 
        $form = parent::buildForm($form, $form_state); 

        $config = $this->config(self::CONFIG_NAME); 

        $form['stripe_publishable_key'] = [ 
            '#type' => 'textfield',
            '#title' => $this->t('Publishable API Key'), 
            '#description' => $this->t('The publishable key we use to submit payments to Stripe'),
            '#default_value' => $config->get('stripe_publishable_key')
        ]; 
		
        $form['stripe_secret_key'] = [ 
            '#type' => 'textfield',
            '#title' => $this->t('Secret API Key'), 
            '#description' => $this->t('The secret key we use to submit payments to Stripe'),
            '#default_value' => $config->get('stripe_secret_key')
        ]; 

        $form['welcome_text'] = [ 
            '#type' => 'textarea',
            '#title' => $this->t('Welcome Text'), 
            '#description' => $this->t('This page will display on the initial donation form.'),
            '#default_value' => $config->get('welcome_text')
        ]; 

        return $form; 
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValues();
        $config = $this->config(self::CONFIG_NAME);

        foreach($values as $key => $value){
            $config->set($key, $values[$key])->save();
        }
		
		\Drupal::messenger()->addStatus('The configuration options have been saved.');

    }
}

?>
