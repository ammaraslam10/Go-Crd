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
            <div class="col-md-12">
                    
                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            <h3><?php echo $lang['head_transaction_details']; ?></h3>
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
                                                    <hr/>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4><?php echo $lang['sender']; ?></h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <?php if(idinfo($row['sender'],"account_type") == "1") { echo idinfo($row['sender'],"first_name")." ".idinfo($row['sender'],"last_name"); } else { echo idinfo($row['sender'],"business_name"); } ?> - <?php if(idinfo($row['sender'],"document_verified") == "1") { echo 'Verified'; } else { echo 'Not Verified'; } ?><br/>
                                                            <?php echo idinfo($row['sender'],"email"); ?><br/>
                                                            <?php echo idinfo($row['sender'],"country"); ?>, <?php echo idinfo($row['sender'],"city"); ?>, <?php echo idinfo($row['sender'],"zip_code"); ?>, <?php echo idinfo($row['sender'],"address"); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4><?php echo $lang['recipient']; ?></h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                        <?php if(idinfo($row['recipient'],"account_type") == "1") { echo idinfo($row['recipient'],"first_name")." ".idinfo($row['recipient'],"last_name"); } else { echo idinfo($row['recipient'],"business_name"); } ?> - <?php if(idinfo($row['sender'],"document_verified") == "1") { echo 'Verified'; } else { echo 'Not Verified'; } ?><br/>
                                                            <?php echo idinfo($row['recipient'],"email"); ?><br/>
                                                            <?php echo idinfo($row['recipient'],"country"); ?>, <?php echo idinfo($row['recipient'],"city"); ?>, <?php echo idinfo($row['recipient'],"zip_code"); ?>, <?php echo idinfo($row['recipient'],"address"); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($row['item_id']) { ?>
                                                    <div class="col-md-12">
                                                        <br>
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td><?php echo $lang['item_number']; ?></td>
                                                            <td><?php echo $lang['item_name']; ?></td>
                                                            <td><?php echo $lang['amount']; ?></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo $row['item_id']; ?></td>
                                                            <td><?php echo $row['item_name']; ?></td>
                                                            <td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table></div>
                                                <?php } ?>
                                                <div class="col-md-12">
                                                    <hr/>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4><?php echo $lang['payment_details']; ?></h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <table class="table table-striped">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><?php echo $lang['gross_amount']; ?>: <span class="float-right"><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?php echo $settings['name']; ?> <?php echo $lang['transaction_fee']; ?>: <span class="float-right"><?php echo $row['fee']; ?> <?php echo $row['currency']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?php echo $lang['net_amount']; ?>: <span class="float-right"><?php echo $row['amount']-$row['fee']; ?> <?php echo $row['currency']; ?></td>
                                                                    </tr>
                                                                    <?php if($row['sent_via']!='' && $row['sender']==$_SESSION['pw_uid']) { ?>
                                                                    <tr>
                                                                        <td>Source of funds: <span class="float-right"><?php echo gatewayinfo($row['sent_via'],"name"); ?></td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if($_SESSION['pw_uid'] == $row['sender']) {
                                                ?>
                                                <div class="col-md-12">
                                                    <hr/>
                                                </div>
                                                <div class="col-md-12">
                                                    <?php echo $lang['info_6']; ?><br/><a href="<?php echo $settings['url']; ?>account/open/dispute/<?php echo $row['txid']; ?>" class="btn btn-primary"><?php echo $lang['open_a_dispute']; ?></a>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div>  

                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->
                </div>