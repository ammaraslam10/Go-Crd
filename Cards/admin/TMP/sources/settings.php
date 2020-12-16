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
                        <h1>Web Settings</h1>
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
			$title = protect($_POST['title']);
			$description = protect($_POST['description']);
			$keywords = protect($_POST['keywords']);
			$name = protect($_POST['name']);
			$url = protect($_POST['url']);
			$infoemail = protect($_POST['infoemail']);
			$supportemail = protect($_POST['supportemail']);
			$default_language = protect($_POST['default_language']);
			$default_currency = protect($_POST['default_currency']);
			$payfee_percentage = protect($_POST['payfee_percentage']);
			if(empty($title) or empty($description) or empty($keywords) or empty($default_language) or empty($default_currency) or empty($name) or empty($url) or empty($infoemail) or empty($supportemail)) {
				echo error("All fields are required."); 
			} elseif(!isValidURL($url)) { 
				echo error("Please enter valid site url address.");
			} elseif(!isValidEmail($infoemail)) { 
				echo error("Please enter valid info email address.");
			} elseif(!isValidEmail($supportemail)) { 
				echo error("Please enter valid support email address.");
			} elseif(!is_numeric($payfee_percentage)) {
				echo error("Please enter transaction fee with numbers.");
			} else {
				$update = $db->query("UPDATE pw_settings SET payfee_percentage='$payfee_percentage',title='$title',description='$description',keywords='$keywords',default_language='$default_language',default_currency='$default_currency',name='$name',url='$url',infoemail='$infoemail',supportemail='$supportemail'");
				$settingsQuery = $db->query("SELECT * FROM pw_settings ORDER BY id DESC LIMIT 1");
				$settings = $settingsQuery->fetch_assoc();
				echo success("Your changes was saved successfully.");
			}
		}
		?>
		<form action="" method="POST">
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control" name="title" value="<?php echo $settings['title']; ?>">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control" name="description" rows="2"><?php echo $settings['description']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Keywords</label>
				<textarea class="form-control" name="keywords" rows="2"><?php echo $settings['keywords']; ?></textarea>
			</div>
			<div class="form-group">
				<label>Site name</label>
				<input type="text" class="form-control" name="name" value="<?php echo $settings['name']; ?>">
			</div>
			<div class="form-group">
				<label>Site url address</label>
				<input type="text" class="form-control" name="url" value="<?php echo $settings['url']; ?>">
			</div>
			<div class="form-group">
				<label>Info email address</label>
				<input type="text" class="form-control" name="infoemail" value="<?php echo $settings['infoemail']; ?>">
			</div>
			<div class="form-group">
				<label>Support email address</label>
				<input type="text" class="form-control" name="supportemail" value="<?php echo $settings['supportemail']; ?>">
			</div>
										<div class="form-group">
											<label>Default language</label>
											<select class="form-control" name="default_language">
											<?php
											if ($handle = opendir('../languages')) {
												while (false !== ($file = readdir($handle)))
												{
													if ($file != "." && $file != ".." && $file != "index.php" && strtolower(substr($file, strrpos($file, '.') + 1)) == 'php')
													{
														$lang = str_ireplace(".php","",$file);
														if($settings['default_language'] == $lang) { $sel ='selected'; } else { $sel = ''; }
														echo '<option value="'.$lang.'" '.$sel.'>'.$lang.'</option>';
													}
												}
												closedir($handle);
											}
											?>
											</select>
										</div>
			<div class="form-group">
				<label>Default wallet currency</label>
				<select class="form-control" name="default_currency">
				<?php
                                                        $currencies = getFiatCurrencies();
                                                        foreach($currencies as $code=>$name) {
																if($settings['default_currency'] == $code) { $sel = 'selected'; } else { $sel = ''; }
                                                            echo '<option value="'.$code.'" '.$sel.'>'.$name.'</option>';
                                                        }
                                                        ?>
										</select>
			</div>
			<div class="form-group">
				<label>Transaction Fee</label>
				<input type="text" class="form-control" name="payfee_percentage" value="<?php echo $settings['payfee_percentage']; ?>">
				<small>Enter transaction fee in percentage without %. This transaction fee will be charged from recipient of amount. Example: 3.4</small>
			</div>
			<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
		</form>
	</div>
</div>
</div>