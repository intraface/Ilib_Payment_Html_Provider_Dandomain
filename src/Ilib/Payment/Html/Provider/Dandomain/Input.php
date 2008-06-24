<?php
/**
 * To control Dandomain <www.dandomain.dk> input page for online payments
 * 
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_Dandomain
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */

class Ilib_Payment_Html_Provider_Dandomain_Input extends Ilib_Payment_Html_Input
{
    
    
    /**
     * Constructor
     * 
     * @param string $merchant merchant number
     * @param string $verification_key verification key
     * @param string $session_id session id
     */
    public function __construct($merchant, $verification_key, $session_id)
    {
        parent::__construct($merchant, $verification_key, $session_id);
    }
    
    /**
     * Returns a path to a input template matching the provider.
     * 
     * @return string template path
     */
    public function getInputTemplatePath() 
    {
        return 'Ilib/Payment/Html/Provider/Dandomain/templates/payment-input-tpl.php';
    }
}


?>
