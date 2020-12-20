<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?><br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>reCaptcha Settings</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
                        <?php
                          $CEAction = protect($_POST['ce_btn']);
                          if(isset($CEAction) && $CEAction == "save") {
                            if(isset($_POST['enable_recaptcha'])) { $enable_recaptcha = 1; } else { $enable_recaptcha = '0'; }
                            $recaptcha_publickey = protect($_POST['recaptcha_publickey']);
                            $recaptcha_privatekey = protect($_POST['recaptcha_privatekey']);
                            if($enable_recaptcha == "1" && empty($recaptcha_publickey)) {
                                echo error("Please enter a reCaptcha public key.");
                            } elseif($enable_recaptcha == "1" && empty($recaptcha_privatekey)) {
                                echo error("Please enter a reCaptcha private key.");
                            } else {
                                $update = $db->query("UPDATE pw_settings SET enable_recaptcha='$enable_recaptcha',recaptcha_publickey='$recaptcha_publickey',recaptcha_privatekey='$recaptcha_privatekey'");
                                $settingsQuery = $db->query("SELECT * FROM pw_settings ORDER BY id DESC LIMIT 1");
                                $settings = $settingsQuery->fetch_assoc();
                                echo success("Your changes was saved successfully.");
                            }
                          }
                          ?>
                          <form action="" method="POST">
                            <div class="form-check">
                                <div class="checkbox">
                                    <label for="checkbox1" class="form-check-label ">
                                        <input type="checkbox" id="checkbox1" name="enable_recaptcha" <?php if($settings['enable_recaptcha'] == "1") { echo 'checked'; } ?> value="1" class="form-check-input"> Enable Google reCaptcha
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>reCaptcha Public Key</label>
                                <input type="text" class="form-control" name="recaptcha_publickey" value="<?php echo $settings['recaptcha_publickey']; ?>">
                            </div>
                            <div class="form-group">
                                <label>reCaptcha Private Key</label>
                                <input type="text" class="form-control" name="recaptcha_privatekey" value="<?php echo $settings['recaptcha_privatekey']; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                        </form>
	</div>
</div>
</div>