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
$c = protect($_GET['c']);
if($c=="change_password"){
    //echo 'in the change pw';
    include("settings/change-password.php");
}
else if($c=="profile"){
    //echo 'in the change pw';
    include("settings/profile.php");
}
else{
?>
<div class="col-md-4">
                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                        <div class="list-group settings_menu">
                                            <a href="<?php echo $settings['url']; ?>account/settings/profile" class="list-group-item list-group-item-action <?php if($c == "" or $c == "profile") { echo 'active'; } ?>"><?php echo $lang['settings_profile']; ?></a>
                                            <a href="<?php echo $settings['url']; ?>account/settings/change_password" class="list-group-item list-group-item-action <?php if($c == "change_password") { echo 'active'; } ?>"><?php echo $lang['settings_change_password']; ?></a>
                                            <a href="<?php echo $settings['url']; ?>account/settings/wallet_passphrase" class="list-group-item list-group-item-action <?php if($c == "wallet_passphrase") { echo 'active'; } ?>"><?php echo $lang['settings_wallet_passphrase']; ?></a>
                                            <a href="<?php echo $settings['url']; ?>account/settings/2fa" class="list-group-item list-group-item-action <?php if($c == "2fa") { echo 'active'; } ?>"><?php echo $lang['settings_2fa']; ?></a>
                                            <?php if($settings['require_document_verify'] == "1") { ?><a href="<?php echo $settings['url']; ?>account/settings/verification" class="list-group-item list-group-item-action <?php if($c == "verification") { echo 'active'; } ?>"><?php echo $lang['settings_verification']; ?></a><?php } ?>
                                            <?php if(idinfo($_SESSION['pw_uid'],"account_type") == "2") { ?><a href="<?php echo $settings['url']; ?>account/settings/api_key" class="list-group-item list-group-item-action <?php if($c == "api_key") { echo 'active'; } ?>"><?php echo $lang['settings_merchant_api_key']; ?></a><?php } ?>
                                            <a href="<?php echo $settings['url']; ?>account/settings/logs" class="list-group-item list-group-item-action <?php if($c == "logs") { echo 'active'; } ?>"><?php echo $lang['settings_account_logs']; ?></a>
                                            </div>    
                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->

                </div>
<div class="col-md-8">
                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            <?php
                                            $redirect_profile = $settings['url']."account/settings/profile";
                                            switch($c) {
                                                case "profile": include("settings/profile.php"); break;
                                                case "change_password": include("settings/change_password.php"); break;
                                                case "wallet_passphrase": include("settings/wallet_passphrase.php"); break;
                                                case "2fa": include("settings/2fa.php"); break;
                                                case "verification": include("settings/verification.php"); break;
                                                case "api_key": include("settings/api_key.php"); break;
                                                case "logs": include("settings/logs.php"); break;
                                                default: header("Location: $redirect_profile");
                                            }
                                            ?>
                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->
                </div>
<?php }?>