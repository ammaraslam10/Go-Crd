<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?>

<div class="col-md-12">
<div class="user-login-signup-form-wrap">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="user-connected-form-block">
                            <h3><?php echo $lang['menu_currencyconverter']; ?></h2>
                            <hr/>
                            <?php
                            $FormBTN = protect($_POST['pw_convert']);
                            if($FormBTN == "convert") {
                               $wallet_id = protect($_POST['wallet_id']);
                               $from_currency = $wallet_id;
                               $to_currency = protect($_POST['to_currency']);
                               $amount = protect($_POST['amount']);
                               $CheckWallet = $db->query("SELECT * FROM pw_users_wallets WHERE currency='$wallet_id' and uid='$_SESSION[pw_uid]'");
                                if($CheckWallet->num_rows>0) {
                                    $wb = $CheckWallet->fetch_assoc();
                                }
                                if(empty($wallet_id) or empty($to_currency) or empty($amount)) {
                                    echo error($lang['error_20']);
                                } elseif(!is_numeric($amount)) {
                                    echo error($lang['error_7']);
                                } elseif($amount>$wb['amount']) {
                                    echo error("$lang[error_53] $from_currency.");
                                } else {
                                    $rates = PW_GetRates($from_currency,$to_currency);
                                    if($rates['status'] == "success") { 
                                        if($rates['rate_from'] < 1) { 
                                            $receive = $amount / $rates['rate_from'];
                                        } else { 
                                            $receive = $amount * $rates['rate_to'];
                                        }
                                        $admin_fee = $rates['fee'] * $receive;
                                        $fee = number_format($admin_fee, 2, '.', '');
                                        PW_UpdateAdminWallet($fee,$to_currency);
                                        PW_UpdateUserWallet($_SESSION['pw_uid'],$amount,$from_currency,2);
                                        PW_UpdateUserWallet($_SESSION['pw_uid'],$receive,$to_currency,1);
                                        $txid = strtoupper(randomHash(30));
                                        $time = time();
                                        $reference_number = $currency.strtoupper(randomHash(10)); 
                                        $insert_convert = $db->query("INSERT pw_users_converts (uid,from_wallet,to_wallet,from_amount,from_currency,to_amount,to_currency,from_rate,to_rate,fee,created,updated) VALUES ('$_SESSION[pw_uid]','$wb[id]','0','$amount','$from_currency','$receive','$to_currency','$rates[rate_from]','$rates[rate_to]','$fee','$time','0')");
                                        $QueryConvert = $db->query("SELECT * FROM pw_users_converts WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 1");
                                        $cnv = $QueryConvert->fetch_assoc();
                                        $create_transaction = $db->query("INSERT pw_transactions (txid,type,sender,recipient,description,deposit_via,amount,currency,fee,status,created) VALUES ('$txid','8','$_SESSION[pw_uid]','$cnv[id]','','','$amount','$from_currency','','1','$time')");
                                        $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created) VALUES ('$txid','8','$_SESSION[pw_uid]','$cnv[id]','$amount','$from_currency','1','$time')");
                                        $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created) VALUES ('$txid','9','$_SESSION[pw_uid]','$cnv[id]','$receive','$to_currency','1','$time')");
                                        $success_25 = str_ireplace("%from_amount%",$amount." ".$from_currency,$lang['success_25']);
                                        $success_25 = str_ireplace("%to_amount%",$receive." ".$to_currency,$success_25);
                                        echo success($success_25);
                                    } else {
                                        echo error($lang['error_54']);
                                    }
                                }
                            }
                            ?>
                            <form class="user-connected-from user-login-form" action="" method="POST">
                            <div class="row form-group">
                                    <div class="col">
                                        <label><?php echo $lang['field_32']; ?></label>
                                        <select class="form-control" name="wallet_id" id="from_currency">
                                            <?php
                                            $GetUserWallets = $db->query("SELECT * FROM pw_users_wallets WHERE uid='$_SESSION[pw_uid]'");
                                            if($GetUserWallets->num_rows>0) {
                                                while($getu = $GetUserWallets->fetch_assoc()) {
                                                    echo '<option value="'.$getu[currency].'">'.get_wallet_balance($_SESSION[pw_uid],$getu[currency]).' '.$getu[currency].'</option>';
                                                }
                                            } 
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label><?php echo $lang['field_33']; ?></label>
                                        <select class="form-control" name="to_currency" id="to_currency">
                                            <?php
                                            $currencies = getFiatCurrencies();
                                            foreach($currencies as $code=>$name) {
                                                echo '<option value="'.$code.'" '.$sel.'>'.$code.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label><?php echo $lang['field_6']; ?></label>
                                    <input type="text" class="form-control" name="amount" id="cnv_amount">
                                </div>

                                <div id="cnv_fields" style="display:none;">
                                <div class="form-group">
                                    <label><?php echo $lang['field_34']; ?></label>
                                    <div class="input-group mb-3">
                                    <input type="text" class="form-control" disabled value="" id="cnv_receive">     
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="cnv_to_curr"></span>
                                    </div>
                                    </div>
                                    <small><?php echo $lang['rate']; ?>: <span id="cnv_rate"></span></small>
                                </div>
                                </div>
                                <input type="hidden" id="rate_from">
                                <input type="hidden" id="rate_to">
                                <button type="submit" name="pw_convert" value="convert" class="btn btn-default"><?php echo $lang['btn_31']; ?></button>
                            </form>
                        </div><!-- create-account-block -->
                    </div>
                </div>
            </div><!-- user-login-signup-form-wrap -->
</div>

<input type="hidden" id="url" value="<?php echo $settings['url']; ?>">