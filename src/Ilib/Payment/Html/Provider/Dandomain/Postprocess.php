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

class Ilib_Payment_Html_Provider_Dandomain_Postprocess extends Ilib_Payment_Html_Postprocess
{
    
    /**
     * Contructor
     * 
     * @param string $merchant merchant number
     * @param string $language the language used in the payment
     */
    public function __construct($merchant, $verification_key, $session_id)
    {    
        parent::__construct($merchant, $verification_key, $session_id);
    }
    
    public function setPaymentResponse($post, $get, $session, $payment_target) {
        
        
        /**
         * @todo: We need some kind of validation check.
         * This one is not really good!
         */
        
        if($get['OrderID'] != $payment_target['id']) {
            throw new Exception('The order id is not valid! ('.$get['OrderID'].', '.$payment_target['id'].')');
        }
        
        $this->amount = $payment_target['arrears'];
        $this->order_number = $get['OrderID'];
        $this->pbs_status = '000'; /* On dandomain the call is only made on success */
        $this->transaction_number = $get['transact'];
        $this->transaction_status = '-1'; /* On dandomain the call is only made on success */
        
        return true;
    } 
}


?>