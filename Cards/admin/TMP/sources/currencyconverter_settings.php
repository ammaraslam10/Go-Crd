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
                        <h1>Currency Converter Settings</h1>
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
                            if(isset($_POST['enable_curcnv'])) { $enable_curcnv = 1; } else { $enable_curcnv = '0'; }
                            $curcnv_api = protect($_POST['curcnv_api']);
                            $curcnv_fee_percentage = protect($_POST['curcnv_fee_percentage']);
                            if($enable_curcnv == "1" && empty($curcnv_api)) {
                                echo error("Please enter a Currency Converter API Key.");
                            } elseif($enable_curcnv == "1" && empty($curcnv_fee_percentage)) {
                                echo error("Please enter a Currency Converter Fee.");
                            } else {
                                $update = $db->query("UPDATE pw_settings SET enable_curcnv='$enable_curcnv',curcnv_api='$curcnv_api',curcnv_fee_percentage='$curcnv_fee_percentage'");
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
                                        <input type="checkbox" id="checkbox1" name="enable_curcnv" <?php if($settings['enable_curcnv'] == "1") { echo 'checked'; } ?> value="1" class="form-check-input"> Enable Currency Converter
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Currency Converter API Key</label>
                                <input type="text" class="form-control" name="curcnv_api" value="<?php echo $settings['curcnv_api']; ?>">
                                <small>To use currency converter from USD to EUR and etc. You must enter here your API Key provided by <a href="https://currencyconverterapi.com">currencyconverterapi.com</a>. How to get API Key: Open <a href="https://currencyconverterapi.com">https://currencyconverterapi.com</a> and click on "Pricing", choose plan "PREMIUM" and follow steps.</small>
                            </div>
                            <div class="form-group">
                                <label>Convert Fee</label>
                                <input type="text" class="form-control" name="curcnv_fee_percentage" value="<?php echo $settings['curcnv_fee_percentage']; ?>">
                                <small>Enter convert fee in percentage without %. This fee will be charged from customer when convert their funds from one currency to another.</small>
                            </div>
                            <button type="submit" class="btn btn-primary" name="ce_btn" value="save"><i class="fa fa-check"></i> Save Changes</button>
                        </form>
	</div>
</div>
</div>