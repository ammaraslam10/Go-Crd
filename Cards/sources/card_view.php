<?php
if(!isset($_GET['preview']))
{	
	$card_url = clean($db, $_GET['a']);
	$data = mysqli_fetch_array(mysqli_query($db, 'select * from card where card_link="'.$card_url.'"'));
	if(!isset($data['id'])) {
		exit;
	}
	$card_id = $data['id'];
	$id = $data['id'];
	include('card_get_db.php');

	if(isset($_POST['contact'])) {
		$name = clean($db, $_POST['name']);
		$contact = clean($db, $_POST['contact']);
		$email = clean($db, $_POST['email']);
		$message = clean($db, $_POST['message']);
		mysqli_query($db, 'insert into card_messages (card_id, name, mobile, email, message) values ("'.$card_id.'","'.$name.'","'.$contact.'","'.$email.'", "'.$message.'")');
	}
	if(isset($_POST['feedback'])) {
		$name = clean($db, $_POST['name']);
		$rating = clean($db, $_POST['rating']);
		$message = clean($db, $_POST['message']);
		mysqli_query($db, 'insert into card_feedback_entries (card_id, name, description, rating, date) values ("'.$card_id.'","'.$name.'","'.$message.'","'.$rating.'", "'.date('Y-m-d H:i:s',time()).'")');
		header("Refresh:0");
		exit;
	}
}

if($card_template < 18)
	$card_template_php = 'template-imported';
else
	$card_template_php = 'template-'.$card_template;

include('templates/' . $card_template_php . '.php');
?>
