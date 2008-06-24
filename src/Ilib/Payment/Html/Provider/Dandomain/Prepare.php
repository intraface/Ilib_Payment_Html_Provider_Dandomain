<?php
/**
 * Prepares Dandomain <www.dandomain.dk> online payments with html template
 * 
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_Dandomain
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */

require_once 'Ilib/Payment/Html/Prepare.php';

class Ilib_Payment_Html_Provider_Dandomain_Prepare extends Ilib_Payment_Html_Prepare
{
    
    /**
     * Contructor
     * 
     * @param string $merchant merchant number
     * @param string $language the language used in the payment
     */
    public function __construct($merchant, $verificaton_key, $session_id)
    {
        parent::__construct($merchant, $verificaton_key, $session_id);
        $this->post_destination = 'https://pay.dandomain.dk/securetunnel.asp?AddFormPostVars=1';
    }
    
    /**
     * prepares the payment values into the fields
     *  
     * @return string post fields
     */
    public function getPostFields() 
    {
        $this->payment_values['amount'] = number_format($this->payment_values['amount'], 2, ',', '');
        
        $currency = array('DKK' => '208',
            'EUR' => 978,
            'USD' => 840);
        
        if(empty($currency[$this->payment_values['currency']])) {
            throw new Exception('Unknown currency "'.$this->payment_values['currency'].'"');
        }
        $this->payment_values['currency'] = $currency[$this->payment_values['currency']];
        
        $fields = '<input type="hidden" name="MerchantNumber" value="'.$this->safeToHtml($this->merchant).'" />'.
           '<input type="hidden" name="SessionID" value="0" />'.
           '<input type="hidden" name="OrderID" value="'.$this->safeToHtml($this->payment_values['order_number']).'" />'.
           '<input type="hidden" name="Amount" value="'.$this->safeToHtml($this->payment_values['amount']).'" />'.
           '<input type="hidden" name="CurrencyID" value="'.$this->safeToHtml($this->payment_values['currency']).'" />'.
           '<input type="hidden" name="TunnelURL" value="'.$this->safeToHtml($this->payment_values['inputpage']).'" />';
        
        return $fields;
    }
    
    /**
     * Returns the name of the provider. Needs to be overridden in extends.
     * 
     * @return string name of provider
     */
    public function getProviderName()
    {
        return 'Dandomain';
    }
}


?>
