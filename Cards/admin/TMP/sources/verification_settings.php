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
                        <h1>Verification Settings</h1>
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
		if(isset($_POST['btn_save'])) {
            if(isset($_POST['require_email_verify'])) { $require_email_verify = 1; } else { $require_email_verify = 0; }
            if(isset($_POST['require_phone_verify'])) { $require_phone_verify = 1; } else { $require_phone_verify = 0; }
            if(isset($_POST['require_document_verify'])) { $require_document_verify = 1; } else { $require_document_verify = 0; }
            $limit_maxamount_sent = protect($_POST['limit_maxamount_sent']);
            $limit_maxtxs_sent = protect($_POST['limit_maxtxs_sent']);
            $limit_maxamount_sent_v = protect($_POST['limit_maxamount_sent_v']);
            $limit_maxtxs_sent_v = protect($_POST['limit_maxtxs_sent_v']);
			$update = $db->query("UPDATE pw_settings SET require_phone_verify='$require_phone_verify',require_email_verify='$require_email_verify',require_document_verify='$require_document_verify',limit_maxamount_sent='$limit_maxamount_sent',limit_maxtxs_sent='$limit_maxtxs_sent',limit_maxamount_sent_v='$limit_maxamount_sent_v',limit_maxtxs_sent_v='$limit_maxtxs_sent_v'");
			$settingsQuery = $db->query("SELECT * FROM pw_settings ORDER BY id DESC LIMIT 1");
			$settings = $settingsQuery->fetch_assoc();
			echo success("Your changes was saved successfully.");
		}
		?>
		<form action="" method="POST">
            <div class="checkbox">
				<label>
				    <input type="checkbox" name="require_email_verify" value="yes" <?php if($settings['require_email_verify'] == "1") { echo 'checked'; }?>> Request e-mail verification from the user
				</label>
            </div>
            <hr/>
            <div class="checkbox">
				<label>
				    <input type="checkbox" name="require_phone_verify" value="yes" <?php if($settings['require_phone_verify'] == "1") { echo 'checked'; }?>> Request phone verification from the user
				</label>
            </div>
            <hr/>
            <div class="checkbox">
				<label>
				    <input type="checkbox" name="require_document_verify" value="yes" <?php if($settings['require_document_verify'] == "1") { echo 'checked'; }?>> Request document verification (KYC) from the user
				</label>
            </div>
            <div class="form-group">
                <label>Set a limit for the maximum amount that can be sent per day (NON-VERIFIED)</label>
                <input type="text" class="form-control" name="limit_maxamount_sent" value="<?php echo $settings['limit_maxamount_sent']; ?>">
                <small>Enter amount with numbers or <b>-1</b> to skip a limit.</small>
            </div>
            <div class="form-group">
                <label>Set a limit for the maximum transactions that can be sent per day (NON-VERIFIED)</label>
                <input type="text" class="form-control" name="limit_maxtxs_sent" value="<?php echo $settings['limit_maxtxs_sent']; ?>">
                <small>Enter with numbers or <b>-1</b> to skip a limit.</small>
            </div>
            <!--For Verified-->
            <div class="form-group">
                <label>Set a limit for the maximum amount that can be sent per day (VERIFIED)</label>
                <input type="text" class="form-control" name="limit_maxamount_sent_v" value="<?php echo $settings['limit_maxamount_sent_v']; ?>">
                <small>Enter amount with numbers or <b>-1</b> to skip a limit.</small>
            </div>
            <div class="form-group">
                <label>Set a limit for the maximum transactions that can be sent per day (VERIFIED)</label>
                <input type="text" class="form-control" name="limit_maxtxs_sent_v" value="<?php echo $settings['limit_maxtxs_sent_v']; ?>">
                <small>Enter with numbers or <b>-1</b> to skip a limit.</small>
            </div>
            <hr/>
			<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
		</form>
	</div>
</div>
</div>