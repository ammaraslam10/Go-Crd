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

$id = protect($_GET['txid']);
$CheckTx = $db->query("SELECT * FROM pw_transactions WHERE txid='$id' and sender='$_SESSION[pw_uid]'");
if($CheckTx->num_rows==0) {
    $redirect = $settings['url']."account/summary";
    header("Location: $redirect");
}
$row = $CheckTx->fetch_assoc();
?>
          <div class="col-md-12">
                    
                    <div class="user-wallet-wrap">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="user-connected-form-block">
                                        <h3><?php echo $lang['head_open_a_dispute']; ?></h3>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p><b>
                                                <?php
                                                if($_SESSION['pw_uid'] == $row['sender']) {
                                                    if(idinfo($row['recipient'],"account_type") == "1") { $name = idinfo($row['recipient'],"first_name")." ".idinfo($row['recipient'],"last_name"); } else { $name = idinfo($row['recipient'],"business_name"); } 
                                                    echo $lang[payment_sent_to].' '.$name;
                                                } else {
                                                    if(idinfo($row['sender'],"account_type") == "1") { $name = idinfo($row['sender'],"first_name")." ".idinfo($row['sender'],"last_name"); } else { $name = idinfo($row['sender'],"business_name"); } 
                                                    echo $lang[payment_received_from].' '.$name;    
                                                }
                                                ?>
                                                </b>    <span class="float-right"><?php echo $lang['gross_amount']; ?></span><p>
                                                <p><?php echo $lang['payment_status']; ?>: <?php echo PW_DecodeTXStatus($row['status']); ?> <span class="float-right"><span style="font-size:22px;"><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></span></span></p>
                                                <p><?php echo $lang['transaction_id']; ?>: <?php echo $row['txid']; ?></p>
                                                <p><?php echo $lang['payment_date']; ?>: <?php echo date("d M Y H:i",$row['created']); ?></p>
                                                <?php if($row['description']) { ?>
                                                <p><?php echo $lang['payment_description']; ?>: <?php echo $row['description']; ?>
                                                <?php } ?>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <hr/>
                                            </div>
                                            <div class="col-md-12">
                                                <?php
                                                $FormBTN = protect($_POST['pw_open']);
                                                if($FormBTN == "open") {
                                                    $comment = protect($_POST['comment']);
                                                    if(empty($comment)) {
                                                        echo error($lang['error_4']);
                                                    } else {
                                                        $time = time();
                                                        $hash = 'PW-'.strtoupper(randomHash(5)).'-'.strtoupper(randomHash(10)).'-'.strtoupper(randomHash(7));
                                                        $insert = $db->query("INSERT pw_disputes (hash,sender,recipient,txid,amount,currency,escalate_review,escalate_message,escalate_issued_by,created_by,created,updated,status) VALUES ('$hash','$row[sender]','$row[recipient]','$row[txid]','$row[amount]','$row[currency]','0','','0','$_SESSION[pw_uid]','$time','0','1')");
                                                        $GetDispute = $db->query("SELECT * FROM pw_disputes WHERE created_by='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 1");
                                                        $dispute = $GetDispute->fetch_assoc();
                                                        $insert = $db->query("INSERT pw_disputes_messages (uid,dispute_id,comment,attachment,time,is_admin,status) VALUES ('$_SESSION[pw_uid]','$dispute[id]','$comment','','$time','0','1')");
                                                        $update = $db->query("UPDATE pw_transactions SET status='4' WHERE txid='$row[txid]'");
                                                        $update = $db->query("UPDATE pw_activity SET status='4' WHERE txid='$row[txid]'");
                                                        $redirect = $settings['url']."account/dispute/".$hash;
                                                        PW_EmailSys_NewDisputeMessage(idinfo($row['recipient'],"email"),$hash);
                                                        header("Location: $redirect");
                                                    }
                                                }

                                                $CheckForDispute = $db->query("SELECT * FROM pw_disputes WHERE txid='$row[txid]'");
                                                if($CheckForDispute->num_rows>0) {
                                                    echo error($lang['error_5']);
                                                } else {
                                                ?>
                                                <form class="user-connected-from user-login-form" action="" method="POST">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['dear']; ?> <?php echo $name; ?></label>
                                                        <textarea class="form-control" name="comment" rows="7" placeholder="<?php echo $lang['placeholder_2']; ?>"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="pw_open" value="open"><?php echo $lang['btn_9']; ?></button>
                                                </form>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>  

                                    </div><!-- create-account-block -->
                                </div>
                            </div>
                        </div><!-- user-login-signup-form-wrap -->
            </div>