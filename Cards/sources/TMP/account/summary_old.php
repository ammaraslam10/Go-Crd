<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

if(!checkSession()) {
    $redirect = $settings['url']."login";
    header("Location: $redirect");
}
?>
            <div class="col-md-4">
                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            <h3><?php echo $lang['head_balance']; ?> <span class="float-right"><small><a href="<?php echo $settings['url']; ?>account/money/deposit" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> <?php echo $lang['btn_10']; ?></a></small></span></h3>
                                            <hr/>
                                            <span class="text text-muted"><?php echo $lang['available']; ?></span>
                                            <?php
                                            $balance = get_user_balance($_SESSION['pw_uid']);
                                            ?>
                                            <h2 class="text text-<?php echo $balance['class']; ?>"><?php echo $balance['balance']; ?></h2>
                                            <div class="currencies_balance">
                                                <table class="table">
                                                    <tbody>
                                                        <?php
                                                        $GetUserWallets = $db->query("SELECT * FROM pw_users_wallets WHERE uid='$_SESSION[pw_uid]' and amount>0 and currency != '$settings[default_currency]' or uid='$_SESSION[pw_uid]' and amount<0 and currency != '$settings[default_currency]' ORDER BY id");
                                                        if($GetUserWallets->num_rows>0) {
                                                            while($guw = $GetUserWallets->fetch_assoc()) {
                                                                echo '<tr>
                                                                        <td>'.$guw[currency].'</td>
                                                                        <td><span class="float-right">'.get_wallet_balance($_SESSION[pw_uid],$guw[currency]).' '.$guw[currency].'</span></td>
                                                                    </tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <a href="<?php echo $settings['url']; ?>account/money/withdrawal" class="btn btn-primary btn-block"><?php echo $lang['btn_24']; ?></a>
                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->

                </div>
                <div class="col-md-8">
                    <?php
                    $GetUserRequests = $db->query("SELECT * FROM pw_requests WHERE uid='$_SESSION[pw_uid]' and status='1'");
                    if($GetUserRequests->num_rows>0) {
                        ?>
                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            <h3><?php echo $lang['head_requests']; ?></h3>
                                            <hr/>
                                            <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                <?php while($gur = $GetUserRequests->fetch_assoc()) { ?>
                                                <tr>
                                                        <td><?php if(idinfo($gur['fromu'],"account_type") == "1") { echo idinfo($gur['fromu'],"first_name")." ".idinfo($gur['fromu'],"last_name"); } else { echo idinfo($gur['fromu'],"business_name"); } ?> request <?php echo $gur['amount']." ".$gur['currency']; ?> from you.<br/>Description: <?php echo $gur['description']; ?></td>
                                                        <td>
                                                            <a href="<?php echo $settings['url']; ?>account/money/request/pay/<?php echo $gur['id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Pay</a> 
                                                            <a href="<?php echo $settings['url']; ?>account/money/request/cancel/<?php echo $gur['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Cancel</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                                    </div>
                                        </div>
                                    </div>
                                </div>               
                        </div>
                        
                        <br>
                        <?php
                    }
                    ?>

                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            <h3><?php echo $lang['head_recent_activity']; ?></h3>
                                            <hr/>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tbody>
                                                    <?php
                                                    $GetUserActivity = $db->query("SELECT * FROM pw_activity WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 15");
                                                    if($GetUserActivity->num_rows>0) {
                                                        while($gua = $GetUserActivity->fetch_assoc()) {
                                                            $amount = $gua['amount'];
                                                            if($gua['type'] == "2" or $gua['type'] == "4" or $gua['type'] == "6" or $gua['type'] == "7" or $gua['type'] == "8") {
                                                                $amount = '-'.$amount;
                                                            } else {
                                                                $amount = '+'.$amount;
                                                            }
                                                            echo '<tr>
                                                                    <td>'.PW_ActivityDate($gua[created]).'</td>
                                                                    <td><a href="'.$settings[url].'account/transaction/'.$gua[txid].'">'.PW_DecodeUserActivity($gua[id]).'</a><br/>'.PW_DecodeTXStatus($gua[status]).'</td>
                                                                    <td align="right"><span class="float-right">'.$amount.' '.$gua[currency].'</span></td>
                                                                </tr>';
                                                        }
                                                    } else { 
                                                        echo '<tr>
                                                            <td>'.$lang[info_8].'</td>
                                                        </tr>';
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                                
                                                <?php if($GetUserActivity->num_rows>14) { ?>
                                                <center>
                                                    <a href="<?php echo $settings['url']; ?>account/activity" class="btn btn-primary"><?php echo $lang['btn_25']; ?></a>
                                                </center>
                                                <?php } ?>

                                            </div>
                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->
                </div>