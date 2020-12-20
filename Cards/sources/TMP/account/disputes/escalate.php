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
$query = $db->query("SELECT * FROM pw_disputes WHERE hash='$id' and sender='$_SESSION[pw_uid]' and status='1' or hash='$id' and recipient='$_SESSION[pw_uid]' and status='1'");
if($query->num_rows==0) { 
    $redirect = $settings['url']."account/disputes";
    header("Location: $redirect");
}
$row = $query->fetch_assoc();
?>

<div class="col-md-12">
<div class="user-login-signup-form-wrap">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="user-connected-form-block">
                            <h3><?php $head_escalate = str_ireplace("%name%",$settings['name'],$lang['head_escalate']); echo $head_escalate; ?></h2>
                            <hr/>
                            <?php
                            $hide_form=0;
                            $FormBTN = protect($_POST['pw_submit']);
                            if($FormBTN == "submit") {
                                $comment = protect($_POST['comment']);
                                if(empty($comment)) {
                                    echo error($lang['error_3']);
                                } else {
                                    $update = $db->query("UPDATE pw_disputes SET status='2',escalate_review='1',escalate_message='$comment',escalate_issued_by='$_SESSION[pw_uid]' WHERE id='$row[id]'");
                                     $hide_form=1;
                                     $success_3 = str_ireplace("%hash%",$row['hash'],$lang['success_3']);
                                     $success_3 = str_ireplace("%name%",$settings['name'],$success_3);
                                     echo success($success_3);
                                }
                            }

                            if($hide_form==0) {
                            ?>
                            <form class="user-connected-from user-login-form" action="" method="POST">
                                <div class="form-group">
                                    <label><?php echo $lang['dear']; ?> <?php echo $settings['name']; ?></label>
                                    <textarea class="form-control" name="comment" rows="4" placeholder="<?php $placeholder_1 = str_ireplace("%name%",$settings['name'],$lang['placeholder_1']); echo $placeholder_1; ?>"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" name="pw_submit" value="submit"><?php echo $lang['btn_8']; ?></button>
                            </form>
                            <?php
                            }
                            ?>
                        </div><!-- create-account-block -->
                    </div>
                </div>
            </div><!-- user-login-signup-form-wrap -->
</div>