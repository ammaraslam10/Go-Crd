<?php
define('PWV1_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../../configs/bootstrap.php");
include("../../includes/bootstrap.php");
//include(getLanguage($settings['url'],null,2));
$gateway = protect($_GET['gateway']);
if($gateway == "PayPal") {
	?>
	<div class="form-group">
		<label>Your PayPal account</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<?php
} elseif($gateway == "Skrill") {
	?>
	<div class="form-group">
		<label>Your Skrill account</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<div class="form-group">
		<label>Your Skrill secret key</label>
		<input type="text" class="form-control" name="a_field_2">
	</div>
	<?php
} elseif($gateway == "Payeer") {
	?>
	<div class="form-group">
		<label>Your Payeer account</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<div class="form-group">
		<label>Your Payeer secret key</label>
		<input type="text" class="form-control" name="a_field_2">
	</div>
	<?php
} elseif($gateway == "Stripe") {
	?>
	<div class="form-group">
		<label>Your Stripe Public Key</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<div class="form-group">
		<label>Your Stripe Secret Key</label>
		<input type="text" class="form-control" name="a_field_2">
	</div>
	<?php	
} elseif($gateway == "Paytm") {
	?>
	<div class="form-group">
		<label>Your Paytm Merchant key</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<div class="form-group">
		<label>Your Paytm Merchant ID</label>
		<input type="text" class="form-control" name="a_field_2">
	</div>
	<div class="form-group">
		<label>Your Paytm Website name</label>
		<input type="text" class="form-control" name="a_field_3">
	</div>
	<?php
}  elseif($gateway == "Perfect Money") {
	?>
	<div class="form-group">
		<label>Your Perfect Money account</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<div class="form-group">
		<label>Account ID or API NAME</label>
		<input type="text" class="form-control" name="a_field_3">
	</div>
	<div class="form-group">
		<label>Passpharse</label>
		<input type="text" class="form-control" name="a_field_2">
		<small>Alternate Passphrase you entered in your Perfect Money account.</small>
	</div>
	<?php
} elseif($gateway == "AdvCash") {
	?>
	<div class="form-group">
		<label>Your AdvCash account</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<?php
} elseif($gateway == "Bank Transfer") {
	?>
	<div class="row">
										<div class="col-md-12"><?php echo info("<b>Name of the field</b> is used to define the name of a field, and next to it you must enter the value of that field. Example: Field name: Bank name / Value: UNITED BANK. You can add up to 10 fields."); ?></div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 1</label>
												<input type="text" class="form-control" name="field_1">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 1</label>
												<input type="text" class="form-control" name="a_field_1">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 2</label>
												<input type="text" class="form-control" name="field_2">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 2</label>
												<input type="text" class="form-control" name="a_field_2">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 3</label>
												<input type="text" class="form-control" name="field_3">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 3</label>
												<input type="text" class="form-control" name="a_field_3">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 4</label>
												<input type="text" class="form-control" name="field_4">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 4</label>
												<input type="text" class="form-control" name="a_field_4">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 5</label>
												<input type="text" class="form-control" name="field_5">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 5</label>
												<input type="text" class="form-control" name="a_field_5">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 6</label>
												<input type="text" class="form-control" name="field_6">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 6</label>
												<input type="text" class="form-control" name="a_field_6">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 7</label>
												<input type="text" class="form-control" name="field_7">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 7</label>
												<input type="text" class="form-control" name="a_field_7">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 8</label>
												<input type="text" class="form-control" name="field_8">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 8</label>
												<input type="text" class="form-control" name="a_field_8">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 9</label>
												<input type="text" class="form-control" name="field_9">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 9</label>
												<input type="text" class="form-control" name="a_field_9">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Name of the Field 10</label>
												<input type="text" class="form-control" name="field_10">
											</div>
										</div>
										<div class="col-md-6 col-lg-6">
											<div class="form-group">
												<label>Value of the Field 10</label>
												<input type="text" class="form-control" name="a_field_10">
											</div>
										</div>
									</div>
	<?php
} elseif($gateway == "Western Union") {
	?>
	<div class="form-group">
		<label>Your name (For money receiving)</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<div class="form-group">
		<label>Your location (For money receiving)</label>
		<input type="text" class="form-control" name="a_field_2">
	</div>
	<?php
} elseif($gateway == "Moneygram") {
	?>
	<div class="form-group">
		<label>Your name (For money receiving)</label>
		<input type="text" class="form-control" name="a_field_1">
	</div>
	<div class="form-group">
		<label>Your location (For money receiving)</label>
		<input type="text" class="form-control" name="a_field_2">
	</div>
	<?php
} else {}
?>