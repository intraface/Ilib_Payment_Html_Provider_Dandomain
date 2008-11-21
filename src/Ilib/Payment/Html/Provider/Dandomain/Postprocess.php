<?php
/**
 * Postprocess Dandomain <www.dandomain.dk> online payments with html template
 * 
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_Dandomain
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */
require_once 'Ilib/Payment/Html/Postprocess.php';

/**
 * Postprocess Dandomain <www.dandomain.dk> online payments with html template
 * 
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_Dandomain
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */
class Ilib_Payment_Html_Provider_Dandomain_Postprocess extends Ilib_Payment_Html_Postprocess
{
    /**
     * Contructor
     * 
     * @param string $merchant merchant number
     * @param string $language the language used in the payment
     * 
     * @return void
     */
    public function __construct($merchant, $verification_key, $session_id)
    {    
        parent::__construct($merchant, $verification_key, $session_id);
    }
    
    /**
     * Sets the payment response 
     * 
     * @param array $post           all POST params given in the response
     * @param array $get            all GET params given in the response
     * @param array $session        all session variables in the response.
     * @param array $payment_target the payment target, e.g. the order
     * 
     * @return boolean true on success.
     */
    public function setPaymentResponse($post, $get, $session, $payment_target) 
    {
        // @todo: We need some kind of validation check. This one is not really good!
        if ($get['OrderID'] != $payment_target['id']) {
            throw new Exception('The order id is not valid! ('.$get['OrderID'].', '.$payment_target['id'].')');
        }
        
        $this->amount = $payment_target['arrears'][$payment_target['default_currency']];
        $this->order_number = $get['OrderID'];
        /**
         * @todo currency is set from default currency in payment target. Not really good, as it is possible to make it so the user can change currency in payment...
         */
        $this->currency = $payment_target['default_currency'];
        
        if(!empty($get['errorcode'])) {
            $this->transaction_status = $get['errorcode'];
            $this->transaction_number = 0;
            if(!empty($get['ActionCode'])) {
                $this->pbs_status = $get['ActionCode'];
            }
            else {
                $this->pbs_status = '';
            }
        }
        else {
            $this->pbs_status = '000'; 
            $this->transaction_status = '-1';
            $this->transaction_number = $get['transact'];
        }
        return true;
    } 
}