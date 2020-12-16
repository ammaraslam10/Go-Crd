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
                        <h1>Update logo</h1>
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
							if(isset($_POST['btn_upload'])) {
								$extensions = array('jpg','jpeg','png'); 
								$fileextension = end(explode('.',$_FILES['uploadFile']['name'])); 
								$fileextension = strtolower($fileextension); 
								if(empty($_FILES['uploadFile']['name'])) { echo error("Please select a file."); }
								elseif(!in_array($fileextension,$extensions)) { echo error("Allowed extensions: jpg and png."); }
								else {
									$filename = randomHash(10)."_".$_FILES['uploadFile']['name'];
									$sql_upload_path = 'assets/images/'.$filename;
									$upload_path = '../assets/images/'.$filename;
									@move_uploaded_file($_FILES['uploadFile']['tmp_name'],$upload_path);
									$update = $db->query("UPDATE pw_settings SET logo='$sql_upload_path'");
									$settingsQuery = $db->query("SELECT * FROM cdd_settings ORDER BY id DESC LIMIT 1");
									$settings = $settingsQuery->fetch_assoc();
									echo success("Your logo was updated successfully.");
								}
							}
							?>
							
							<div class="alert alert-primary">
								<b>Current logo:</b><br/><br/>
								<?php if($settings['logo']) { ?>
									<img src="<?php echo $settings['url'].$settings['logo']; ?>">
								<?php } else { ?>
									<img src="<?php echo $settings['url']; ?>assets/images/logo.png">
								<?php } ?>
							</div>
							
							<form action="" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label>Select logo</label>
									<input type="file" class="form-control" name="uploadFile">
								</div>
								<button type="submit" class="btn btn-primary" name="btn_upload"><i class="fa fa-upload"></i> Upload</button>
							</form>
	</div>
</div>
</div>