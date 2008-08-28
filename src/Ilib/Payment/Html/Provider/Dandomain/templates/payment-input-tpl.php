<?php
/**
 * HTML input page for payment
 * 
 * @author sune jensen <sj@sunet.dk>
 * @version 0.0.1
 * @package Payment_Html_Provider_Dandomain
 * @category Payment
 * @license http://www.gnu.org/licenses/lgpl.html LGPL
 */

// md5(OrderID & "+" & Amount & "+" & ChecksumSecretKey & "+" & CurrencyID)
$checksum = md5($request_get['OrderID'].'+'.$request_get['Amount'].'+'.$verification_key.'+'.$request_get['CurrencyID']);
?>
    <div id="payment-input">
        <form action="https://pay.dandomain.dk/securecapture.asp" method="post" autocomplete="off" id="payment_details">

            <input type="hidden" name="CurrencyID" title="CurrencyID" value="%%CurrencyID%%" />
            <input type="hidden" name="MerchantNumber" value="%%MerchantNumber%%" />
            <input type="hidden" name="OrderID" value="%%OrderID%%" />
            <input type="hidden" name="Amount" value="%%Amount%%" />
            <input type="hidden" name="SessionId" value="<?php echo session_id(); ?>" />
            <input type="hidden" name="Checksum" value="<?php echo $checksum; ?>" />
            <input type="hidden" name="OKURL" value="<?php echo $ok_url; ?>" />
            <input type="hidden" name="FAILURL" value="<?php echo $error_url; ?>" />
            <input type="hidden" name="OKStatusURL" value="<?php echo $postprocess_url; ?>" />
            
            
            <p><?php e(__('You are about to pay for your order')); ?></p> 
            <p>
                <?php
                $currencies = array(
                    '208' => 'DKK',
                    '978' => 'EUR',
                    '840' => 'USD');
                if(isset($currencies[$request_get['CurrencyID']])) {
                    echo $currencies[$request_get['CurrencyID']];
                }
                ?>
                <strong>%%Amount%%</strong> <?php e(__('will be withdrawed from your card.')); ?>
            </p>
            
            <div id="cards_container">
                <?php
                if(isset($creditcard_logos) && is_array($creditcard_logos)) {
                    foreach($creditcard_logos AS $logo) {
                        echo '<img src="'.$secure_tunnel_url.$logo['url'].'" class="creditcard-logo" width="'.$logo['width'].'" height="'.$logo['height'].'" style="margin: 4px;" />';
                    }
                }
                ?>
            </div>
            
            <div id="formrow">
                <label for="CardNumber"><?php e(__('Card number')); ?></label>
                <input type="text" maxlength="16" size="19" name="CardNumber" id="CardNumber" />
            </div>
            
            <div id="formrow">
                <label for="ExpireMonth"><?php e(__('Expiry date')); ?></label>
                <select name="ExpireMonth" id="ExpireMonth">
                    <?php 
                    $month_array = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                    foreach($month_array AS $month) {
                        echo '<option value="'.$month.'">'.$month.'</option>';
                    }
                    ?>
                </select> 
                /
                <select name="ExpireYear" id="ExpireYear">
                    <?php
                    $current_year = date('Y');
                    for($i = $current_year; $i < $current_year + 16; $i++) {
                        echo '<option value="'.substr($i, -2).'">'.substr($i, -2).'</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div id="formrow">
                <label for="CardCVC"><?php e(__('CVC')); ?></label>
                <input type="text" maxlength="3" size="3" name="CardCVC" id="CardCVC" />
            </div>

            <input name="submit" type="submit" value="<?php e(__('   PAY   ')); ?>">
        </form>
    </div>
