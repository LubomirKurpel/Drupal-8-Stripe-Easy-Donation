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


        $currency = [
            'USD' => 'United States dollar',
            'AED' => 'United Arab Emirates dirham',
            'ALL' => 'Albanian lek',
            'AMD' => 'Armenian dram',
            'ANG' => 'Netherlands Antillean guilder',
            'AOA' => 'Angolan kwanza',
            'ARS' => 'Argentine peso',
            'AUD' => 'Australian dollar',
            'AWG' => 'Aruban florin',
            'AZN' => 'Azerbaijani manat',
            'BAM' => 'Bosnia and Herzegovina convertible mark',
            'BBD' => 'Barbados dollar',
            'BDT' => 'Bangladeshi taka',
            'BGN' => 'Bulgarian lev',
            'BIF' => 'Burundian franc',
            'BMD' => 'Bermudian dollar',
            'BND' => 'Brunei dollar',
            'BOB' => 'Boliviano',
            'BRL' => 'Brazilian real',
            'BSD' => 'Bahamian dollar',
            'BWP' => 'Botswana pula',
            'BZD' => 'Belize dollar',
            'CAD' => 'Canadian dollar',
            'CDF' => 'Congolese franc',
            'CHF' => 'Swiss franc',
            'CLP' => 'Chilean peso',
            'CNY' => 'Renminbi|Chinese yuan',
            'COP' => 'Colombian peso',
            'CRC' => 'Costa Rican colon',
            'CVE' => 'Cape Verde escudo',
            'CZK' => 'Czech koruna',
            'DJF' => 'Djiboutian franc',
            'DKK' => 'Danish krone',
            'DOP' => 'Dominican peso',
            'DZD' => 'Algerian dinar',
            'EGP' => 'Egyptian pound',
            'ETB' => 'Ethiopian birr',
            'EUR' => 'Euro',
            'FJD' => 'Fiji dollar',
            'FKP' => 'Falkland Islands pound',
            'GBP' => 'Pound sterling',
            'GEL' => 'Georgian lari',
            'GIP' => 'Gibraltar pound',
            'GMD' => 'Gambian dalasi',
            'GNF' => 'Guinean franc',
            'GTQ' => 'Guatemalan quetzal',
            'GYD' => 'Guyanese dollar',
            'HKD' => 'Hong Kong dollar',
            'HNL' => 'Honduran lempira',
            'HRK' => 'Croatian kuna',
            'HTG' => 'Haitian gourde',
            'HUF' => 'Hungarian forint',
            'IDR' => 'Indonesian rupiah',
            'ILS' => 'Israeli new shekel',
            'INR' => 'Indian rupee',
            'ISK' => 'Icelandic króna',
            'JMD' => 'Jamaican dollar',
            'JPY' => 'Japanese yen',
            'KES' => 'Kenyan shilling',
            'KGS' => 'Kyrgyzstani som',
            'KHR' => 'Cambodian riel',
            'KMF' => 'Comoro franc',
            'KRW' => 'South Korean won',
            'KYD' => 'Cayman Islands dollar',
            'KZT' => 'Kazakhstani tenge',
            'LAK' => 'Lao kip',
            'LBP' => 'Lebanese pound',
            'LKR' => 'Sri Lankan rupee',
            'LRD' => 'Liberian dollar',
            'LSL' => 'Lesotho loti',
            'MAD' => 'Moroccan dirham',
            'MDL' => 'Moldovan leu',
            'MGA' => 'Malagasy ariary',
            'MKD' => 'Macedonian denar',
            'MMK' => 'Myanmar kyat',
            'MNT' => 'Mongolian tögrög',
            'MOP' => 'Macanese pataca',
            'MRO' => 'Mauritanian ouguiya',
            'MUR' => 'Mauritian rupee',
            'MVR' => 'Maldivian rufiyaa',
            'MWK' => 'Malawian kwacha',
            'MXN' => 'Mexican peso',
            'MYR' => 'Malaysian ringgit',
            'NAD' => 'Canadian dollar',
            'NGN' => 'Nigerian naira',
            'NIO' => 'Nicaraguan córdoba',
            'NOK' => 'Norwegian krone',
            'NPR' => 'Nepalese rupee',
            'NZD' => 'New Zealand dollar',
            'PAB' => 'Panamanian balboa',
            'PEN' => 'Peruvian Sol',
            'PGK' => 'Papua New Guinean kina',
            'PHP' => 'Philippine peso',
            'PKR' => 'Pakistani rupee',
            'PLN' => 'Polish złoty',
            'PYG' => 'Paraguayan guaraní',
            'QAR' => 'Qatari riyal',
            'RON' => 'krone',
            'RSD' => 'Serbian dinar',
            'RUB' => 'Aruban florin',
            'RWF' => 'Rwandan franc',
            'SAR' => 'Saudi riyal',
            'SBD' => 'Solomon Islands dollar',
            'SCR' => 'Seychelles rupee',
            'SEK' => 'Swedish krona',
            'SGD' => 'Singapore dollar',
            'SHP' => 'Saint Helena pound',
            'SLL' => 'Sierra Leonean leone',
            'SOS' => 'Somali shilling',
            'SRD' => 'Surinamese dollar',
            'STD' => 'São Tomé and Príncipe dobra',
            'SZL' => 'Swazi lilangeni',
            'THB' => 'Thai baht',
            'TJS' => 'Tajikistani somoni',
            'TOP' => 'Tongan paʻanga',
            'TRY' => 'Turkish lira',
            'TTD' => 'Trinidad and Tobago dollar',
            'TWD' => 'New Taiwan dollar',
            'TZS' => 'Tanzanian shilling',
            'UAH' => 'Ukrainian hryvnia',
            'UGX' => 'Ugandan shilling',
            'UYU' => 'Uruguayan peso',
            'UZS' => 'Uzbekistan som',
            'VND' => 'Vietnamese đồng',
            'VUV' => 'Vanuatu vatu',
            'WST' => 'Samoan tala',
            'XAF' => 'Central African CFA franc',
            'XCD' => 'East Caribbean dollar',
            'XOF' => 'West African CFA franc',
            'XPF' => 'CFP franc',
            'YER' => 'Yemeni rial',
            'ZAR' => 'South African rand',
        ];

        asort($currency);

        $form['stripe_hide_postalcode'] = array(
            '#type' => 'radios',
            '#title' => $this->t('Hide Postal Code'),
            '#default_value' => 1,
            '#options' => array(
                0 => $this->t('No'),
                1 => $this->t('Yes'),
            ),
            '#default_value' => $config->get('stripe_hide_postalcode') ?: 0 ,
        );
        
        $form['stripe_default_currency'] = [ 
            '#type' => 'select',
            '#title' => $this->t('Default currency'),
            '#options' => $currency,
            '#description' => $this->t('Set the default currency to submit payments to Stripe'),
            '#default_value' => $config->get('stripe_default_currency') ?: 'EUR' 
        ]; 

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
