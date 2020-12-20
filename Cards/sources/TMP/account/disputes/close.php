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
$query = $db->query("SELECT * FROM pw_disputes WHERE hash='$id' and sender='$_SESSION[pw_uid]' and status='1'");
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
                            <h3><?php echo $lang['head_close_dispute']; ?></h2>
                            <hr/>
                            <?php
                            $hide_form=0;
                            $FormBTN = protect($_POST['pw_close']);
                            if($FormBTN == "yes") {
                                $update = $db->query("UPDATE pw_disputes SET status='4' WHERE id='$row[id]'");
                                $update = $db->query("UPDATE pw_transactions SET status='1' WHERE txid='$row[txid]'");
                                $update = $db->query("UPDATE pw_activity SET status='1' WHERE txid='$row[txid]'");
                                $hide_form=1;
                                $success_1 = str_ireplace("%hash%",$row['hash'],$lang_success_1);
                                echo success($success_1);
                                PW_EmailSys_DisputeClosed(idinfo($row['recipient'],"email"),$row['hash'],"");
                            }

                            if($hide_form==0) {
                            ?>
                            
                            <form class="user-connected-from user-login-form" action="" method="POST">
                                <div class="alert alert-info">
                                    <?php echo $lang['info_1']; ?> <b><?php echo $row['hash']; ?></b>?
                                </div>
                                <button type="submit" name="pw_close" value="yes" class="btn btn-success"><?php echo $lang['btn_1']; ?></button> <a href="<?php echo $settings['url']; ?>account/dispute/<?php echo $row['hash']; ?>" class="btn btn-danger"><?php echo $lang['btn_2']; ?></a>
                            </form>
                            <?php
                            }
                            ?>
                        </div><!-- create-account-block -->
                    </div>
                </div>
            </div><!-- user-login-signup-form-wrap -->
</div>