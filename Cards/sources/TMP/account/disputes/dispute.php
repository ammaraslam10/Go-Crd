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

$id = protect($_GET['id']);
$query = $db->query("SELECT * FROM pw_disputes WHERE hash='$id' and sender='$_SESSION[pw_uid]' or hash='$id' and recipient='$_SESSION[pw_uid]'");
if($query->num_rows==0) { 
    $redirect = $settings['url']."account/disputes";
    header("Location: $redirect");
}
$row = $query->fetch_assoc();
?>
            
                <div class="col-md-8">

                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            
                                            <?php
                                            if($row['escalate_review'] == "1") {
                                                $info_2 = str_ireplace("%name%",$settings['name'],$lang['info_2']);
                                                echo info($info_2);
                                            }

                                            $FormBTN = protect($_POST['pw_submit']);
                                            if($FormBTN == "message") {
                                                $message = protect($_POST['message']);
                                                $extensions = array('jpg','jpeg','png','pdf'); 
                                                $fileextension = end(explode('.',$_FILES['uploadFile']['name'])); 
                                                $fileextension = strtolower($fileextension); 
                                                if(empty($message)) { echo error($lang['error_2']); }
                                                elseif(!empty($_FILES['uploadFile']['name']) && !in_array($fileextension,$extensions)) { echo error($lang['error_1']); }
                                                else {
                                                    $time = time();
                                                    $path = '';
                                                    if($_FILES['uploadFile']['name']) {
                                                        $path = 'uploads/disputes/'.$row[hash].'_'.$_SESSION[pw_uid].'_'.time().'_attachment.'.$fileextension;
                                                        @move_uploaded_file($_FILES['uploadFile']['tmp_name'], $path); 
                                                    }
                                                    $insert = $db->query("INSERT pw_disputes_messages (dispute_id,uid,comment,attachment,time,status) VALUES ('$row[id]','$_SESSION[pw_uid]','$message','$path','$time','1')");
                                                    echo success($lang['success_2']);
                                                }
                                            }


                                            $GetMessages = $db->query("SELECT * FROM pw_disputes_messages WHERE dispute_id='$row[id]' ORDER BY id");
                                            if($GetMessages->num_rows>0) {
                                                while($get = $GetMessages->fetch_assoc()) {
                                                    ?>
                                                    <div id="message_<?php echo $get['id']; ?>">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <b><?php if($get['is_admin'] == "1") { echo $settings['name']; } else { if(idinfo($get['uid'],"account_type") == "1") { echo idinfo($get['uid'],"first_name")." ".idinfo($get['uid'],"last_name"); } else { echo idinfo($get['uid'],"business_name"); } } ?></b> <?php echo $lang['says']; ?>:
                                                                <span class="float-right"><small><?php echo timeago($get['time']); ?></small></span>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                    <?php echo nl2br($get['comment']); ?><br/>
                                                                    <?php
                                                                    $attachment = '';
                                                                    if(!empty($get['attachment'])) {
                                                                        $attachment = '<br/>
                                                                                                    <small>
                                                                                                        <a href="'.$settings[url].$get[attachment].'" target="_blank"><i class="fa fa-file"></i> '.basename($get['attachment']).'</a>
                                                                                                    </small>';
                                                                    }
                                                                    echo $attachment;
                                                                    ?>
                                                                    </div>
                                                                </div>	
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <?php
                                                }  
                                            }
                                            ?>
                                            
                                            <?php if($row['status'] == "1") { ?>
                                            <hr/>
                                            
                                            <div id="submit_message">
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label><?php echo $lang['field_1']; ?></label>
                                                        <textarea class="form-control" name="message" rows="3"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><?php echo $lang['field_2']; ?></label>
                                                        <input type="file" name="uploadFile">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" name="pw_submit" value="message"><?php echo $lang['btn_3']; ?></button>
                                                </form>
                                            </div>
                                            <br>
                                            <?php } ?>

                                            <?php if($row['status'] == "1") { ?>
                                            <a href="<?php echo $settings['url']; ?>account/escalate/dispute/<?php echo $row['hash']; ?>"><?php $btn_4 = str_ireplace("%name%",$settings['name'],$lang['btn_4']); echo $btn_4; ?></a><br/>
                                            <?php } ?>
                                            <?php if($_SESSION['pw_uid'] == $row['sender']) { ?>
                                            <a href="<?php echo $settings['url']; ?>account/close/dispute/<?php echo $row['hash']; ?>"><?php echo $lang['btn_5']; ?></a><br/>
                                            <?php } ?>
                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->
                </div>

                <div class="col-md-4">
                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            <b><?php echo $lang['dispute']; ?>:</b><br/>
                                            <?php echo $row['hash']; ?><br/><br/>
                                            <b><?php echo $lang['transaction']; ?>:</b><br/>
                                            <a href="<?php echo $settings['url']; ?>account/transaction/<?php echo $row['txid']; ?>"><?php echo $row['txid']; ?></a><br/><br/>
                                            <b><?php echo $lang['amount']; ?>:</b><br/>
                                            <?php echo $row['amount']; ?> <?php echo $row['currency']; ?><br/><br/>
                                            <b><?php echo $lang['created_on']; ?>:</b><br/>
                                            <?php echo date("d M Y H:i",$row['created']); ?><br/>
                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->

                </div>