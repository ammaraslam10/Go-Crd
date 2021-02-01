<?php 
include('includes/image_upload.php'); 
header("Content-Type: application/json; charset=UTF-8");
$json = new stdClass();
$uid = 1;

$card_id = clean($db, $_POST['card_id']);
$extra = intval(clean($db, $_POST['extra']));
$card = mysqli_fetch_array(mysqli_query($db, 'select * from card where creator="'.$uid.'" && id="'.$card_id.'"'));
if(!isset($card['id']) && $card_id != "temp") {
	$json->success = false;
	$json->message = "Invalid card";
	echo json_encode($json);
	exit;
}

// Ensure that the image being uploadeed is valid in nature
$target_dir = "";
$width = 300; 
$height = 300;

if($_POST['type'] == "card_logo") {
	$_POST['type'] = "logo";
} else if($_POST['type'] == "card_gallery") {
	$_POST['type'] = "gallery";
} else if($_POST['type'] == "card_offer") {
	$_POST['type'] = "offer";
} else if($_POST['type'] == "card_product") {
	$_POST['type'] = "product";
} else if($_POST['type'] == "card_additional") {
	$_POST['type'] = "additional";
} else if($_POST['type'] == "card_header") {
	$width = 800; 
	$height = 500;
	$_POST['type'] = "header";
} else if($_POST['type'] == "card_files") {
	$counter = 0;
	$card_old = explode(",", mysqli_fetch_array(mysqli_query($db, 'select files from card_company where card_id="'.$card_id.'"'))['files']);
	foreach($card_old as $file) {
		unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $settings['path'] . $file);
	}
	$success = true;
	$files = re_array_files($_FILES['image']);
	foreach($files as $file) {
		if($file["size"] > 5000000) {
			$success = false; $result = "Max 5MB";
                } 
		$imageFileType = pathinfo($file['name'], PATHINFO_EXTENSION);
		if(!($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" || $imageFileType == "pdf")) {
			$success = false; $result = implode(", ",$file)."Images or PDFs";
		}
	}
	if($success) {
		$result = array();
		foreach($files as $file) {
			$imageFileType = pathinfo($file['name'], PATHINFO_EXTENSION);
			$target_name = $uid . "_" . $_POST['card_id'] . "_file_" . $counter;
			if($imageFileType == "pdf") {
				if(move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $settings['upload_dir'] . $target_name . '.' . $imageFileType)) {
					$success = true; 
					$result[] = $target_name . '.' . $imageFileType;
				}
			} else {
				$reply = image_upload($file, $target_dir, $target_name, $width, $height, false);
				if($reply === true) {
					$result[] = $target_name . '.jpg';
				} else {
					$success = false;
					$result = $reply;
					foreach($result as $file) {
						unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $settings['path'] . $target_file);
					}
				}
			}
			$counter++;
		}
		if(is_array($result)) {
			if(!empty($result))
				$result = implode(",", $result);
			else $result = "Error uploading files";
		}
	}
	$json->success = $success;
	$json->message = $result;
	echo json_encode($json);
	exit;
} else
	$failure = true;

// Was the image type valid?
if(isset($failure)) {
	$json->success = false;
	$json->message = "Invalid Post Request".$_POST['type'];
	echo json_encode($json);
	exit;
}

$target_name = $uid . "_" . $_POST['card_id'] . "_" . $_POST['type'];
if(isset($_POST['extra'])) 
	$target_name = $target_name . "_" . $extra;

// Try to upload image
$result = image_upload($_FILES['image'], $target_dir, $target_name, $width, $height, false);

// Was the upload successful?
if($result === true) {
	$json->success = true;
	if($target_dir != "") $target_dir .= "/";
	$json->message = "/uploads/".$target_dir.$target_name.".jpg?t=".time();
} else {
	$json->success = false;
	$json->message = $result;
}

// Display success/failure message
echo json_encode($json);
?>
