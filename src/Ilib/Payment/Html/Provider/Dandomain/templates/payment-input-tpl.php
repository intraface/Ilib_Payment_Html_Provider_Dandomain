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
        <form action="https://pay.dandomain.dk/securecapture.asp" method="post" autocomplete="off" id="payment_details">
            <input type="hidden" name="CurrencyID" title="CurrencyID" value="%%CurrencyID%%" />
            <input type="hidden" name="MerchantNumber" value="%%MerchantNumber%%" />
            <input type="hidden" name="OrderID" value="%%OrderID%%" />
            <input type="hidden" name="Amount" value="%%Amount%%" />
            <input type="hidden" name="SessionId" value="<?php e(session_id()); ?>" />
            <input type="hidden" name="Checksum" value="<?php e($checksum); ?>" />
            <input type="hidden" name="OKURL" value="<?php e($ok_url); ?>" />
            <input type="hidden" name="FAILURL" value="<?php e($error_url); ?>" />
            <input type="hidden" name="OKStatusURL" value="<?php e($postprocess_url); ?>" />
            <input type="hidden" name="FAILStatusURL" value="<?php e($postprocess_url); ?>" />


            <div class="s4top">
            <fieldset class="clearfix">
            <legend><span><?php e(__('Card information')); ?></span></legend>
            <div class="s4-inner">
                <div class="stop">
                    <label for="cardnum"><?php e(__('Card number')); ?></label>
                    <input type="text" maxlength="16" size="19" name="CardNumber" id="cardnum" />
                </div>
                <div>
                    <label for="month"><?php e(__('Expire date')); ?></label>
                    <span>
                <select name="ExpireMonth" class="s4-select" id="month">
                    <?php
                    $month_array = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                    foreach($month_array as $month) {
                        echo '<option value="'.$month.'">'.$month.'</option>';
                    }
                    ?>
                </select>
                <strong class="slash">/</strong>
                <select name="ExpireYear" class="s4-select" id="year">
                    <?php
                    $current_year = date('Y');
                    for($i = $current_year; $i < $current_year + 16; $i++) {
                        echo '<option value="'.substr($i, -2).'">'.substr($i, -2).'</option>';
                    }
                    ?>
                </select>
                    </span>
                </div>
                <div>
                    <label for="cvd"><?php e(__('Security no.')); ?></label>
                    <input type="text" maxlength="3" size="3" name="CardCVC" id="cvd" />
                </div>
                <div>
                    <input class="godkend" name="submit" type="submit" id="submit" value="<?php e(__('Pay')); ?>" />
                </div>
            </div>
            </fieldset>
        </div>
        <div class="s4top s4toplast">
            <fieldset class="clearfix">



            <legend><span><?php e(__('Company')); ?></span></legend>
            <div class="s4-inner">
                <p class="stop"><strong><span><?php e(__('Total amount')); ?></span></strong>
                <?php
                $currencies = array(
                    '208' => 'DKK',
                    '978' => 'EUR',
                    '840' => 'USD');
                if(isset($currencies[$request_get['CurrencyID']])) {
                    echo $currencies[$request_get['CurrencyID']];
                }
                ?> %%Amount%%</p>
                <!--
                <p><strong><span><?php e(__('Order')); ?></span>xxx</strong></p>
                -->
                <p><span><?php e(__('Company')); ?></span> <b><?php e($this->getCompanyName()); ?><br />
                    <?php e($this->getCompanyAddress()); ?><br />
                    <?php e($this->getCompanyZip()); ?></b></p>
                <p><span><?php e(__('Vat no.')); ?></span><?php e($this->getCompanyVatNumber()); ?></p>
            </div>
            </fieldset>
        </div>
       </form>
        <div class="s4base">
            <fieldset class="clearfix">
            <legend><span><?php e(__('Available cards')); ?></span></legend>
                <?php
                if(isset($creditcard_logos) && is_array($creditcard_logos)) {
                    foreach($creditcard_logos as $logo) {
                        echo '<img src="'.$secure_tunnel_url.$logo['url'].'" class="creditcard-logo" width="'.$logo['width'].'" height="'.$logo['height'].'" style="margin: 4px;" />';
                    }
                }
                ?>
            </fieldset>
        </div>
<br>
