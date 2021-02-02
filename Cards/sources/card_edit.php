<?php include('assets/inc/config.php'); ?>

<?php
if(!isset($_GET['b'])) {
	exit;
}
include('includes/default_array_lists.php');
$error = []; 

//$uid = 1;
//$is_admin = 0;

if($_SESSION['type']=="su"){
    $uid = -1; 
} 
else{
    $uid = $_SESSION['id'];
}
if($_SESSION['type']=="admin" || $_SESSION['type']=="su") {
    $is_admin = 1;
}
else{
    $is_admin = 0;
}


$id = clean($db, intval($_GET['b']));
$data = mysqli_fetch_array(mysqli_query($db, 'select * from card where id='.$id));
if(!isset($data['id'])) {
	exit;
}
if($data['creator'] != $uid) {
	header('Location: login');
}
if(isset($_POST['card_url'])) 
{
	$card_id = $id;
	$card_template = clean($db, $_POST['card_template']);
	$card_logo = clean($db, $_POST['card_logo']);
	$card_url = clean($db, $_POST['card_url']);
	$design = array();
	$design[0] = $card_color_background = clean($db, $_POST['card_color_background']);
	$design[1] = $card_color_main = clean($db, $_POST['card_color_main']);
	$design[2] = $card_color_action = clean($db, $_POST['card_color_action']);
	$design[3] = $card_font_heading = clean($db, $_POST['card_font_heading']);
	$design[4] = $card_color_heading = clean($db, $_POST['card_color_heading']);
	$design[5] = $card_font_other = clean($db, $_POST['card_font_other']);
	$design[6] = $card_color_other = clean($db, $_POST['card_color_other']);
	$card_design = implode(",", $design);
        if(isset($_POST['card_colors_default'])) {
                $_POST['card_color_background'] = $card_color_background = "";
		$card_color_main = "";
		$card_color_action = "";
		$card_font_heading = "";
		$card_color_heading = "";
		$card_font_other = "";
		$card_color_other = "";
		$card_design = "";
        }
	$card_company_name = clean($db, $_POST['card_company_name']);
	$card_company_whatsapp = clean($db, $_POST['card_company_whatsapp']);
	$card_company_country = clean($db, $_POST['card_company_country']);
	$card_company_address = clean($db, $_POST['card_company_address']);
	$card_company_email = clean($db, $_POST['card_company_email']);
	$card_company_tagline = clean($db, $_POST['card_company_tagline']);
	$card_company_person = clean($db, $_POST['card_company_person']);
	$card_company_person_designation = clean($db, $_POST['card_company_person_designation']);
	$card_company_phone = clean($db, $_POST['card_company_phone']);
	$card_company_phone_alt = clean($db, $_POST['card_company_phone_alt']);
	$card_company_website = clean($db, $_POST['card_company_website']);
	$card_company_google_location = clean($db, $_POST['card_company_google_location']);
	$card_company_about = $_POST['card_company_about'];
	$card_company_nature = clean($db, $_POST['card_company_nature']);
	$card_company_specialities = clean($db, $_POST['card_company_specialities']);
	$card_company_appointment = clean($db, $_POST['card_company_appointment']);
	$card_company_files = clean($db, $_POST['card_company_files']);
	$card_company_heading = clean($db, $_POST['card_company_heading']);
	if(isset($_POST['card_company_visibility'])) 
		$card_company_visibility = clean($db, $_POST['card_company_visibility']);
	else
		$card_company_visibility = 0;
	$card_social_facebook = clean($db, $_POST['card_social_facebook']);
	$card_social_twitter = clean($db, $_POST['card_social_twitter']);
	$card_social_instagram = clean($db, $_POST['card_social_instagram']);
	$card_social_linkedin = clean($db, $_POST['card_social_linkedin']);
	$card_social_pinterest = clean($db, $_POST['card_social_pinterest']);
	$card_social_youtube = clean($db, $_POST['card_social_youtube']);
	$card_other_links = array();
	$card_other_links_icon = array();
	for($i = 0; $i < count($_POST['card_other_links']); $i++) {
		if(empty($_POST['card_other_links'][$i]) || empty($_POST['card_other_links_icon'][$i]))
			continue;
		$card_other_links[] = clean($db, $_POST['card_other_links'][$i]);
		$card_other_links_icon[] = clean($db, $_POST['card_other_links_icon'][$i]);
	}
	$_POST['card_other_links'] = $card_other_links;
	$_POST['card_other_links_icon'] = $card_other_links_icon;
	$tmp2 = array();
	for($i = 0; $i < count($card_other_links); $i++) {
		$tmp = array();
		$tmp[0] = $card_other_links[$i];
		$tmp[1] = $card_other_links_icon[$i];
		$tmp2[] =  implode("|", $tmp);
	}
	$card_social_links = implode(",", $tmp2);
	$card_social_youtube_links = clean($db, $_POST['card_social_youtube_links']);
	$card_social_heading = clean($db, $_POST['card_social_heading']);
	if(isset($_POST['card_social_visibility'])) 
		$card_social_visibility = clean($db, $_POST['card_social_visibility']);
	else
		$card_social_visibility = 0;
	$card_payment_venmo = clean($db, $_POST['card_payment_venmo']);
	$card_payment_cashapp = clean($db, $_POST['card_payment_cashapp']);
	$card_payment_paypal = clean($db, $_POST['card_payment_paypal']);
	$card_payment_heading = clean($db, $_POST['card_payment_heading']);
	if(isset($_POST['card_payment_visibility'])) 
		$card_payment_visibility = clean($db, $_POST['card_payment_visibility']);
	else
		$card_payment_visibility = 0;
	$card_product_title = array(); $card_product_image = array(); $card_product_description = array(); 
	$card_product_button = array(); $card_product_button_link = array(); 
	$card_products = array();
	for($i = 0; $i < count($_POST['card_product_title']); $i++) {
		if(empty($_POST['card_product_title'][$i])) 
			continue;
		$card_product_title[] = clean($db, $_POST['card_product_title'][$i]);
		$card_product_image[] = clean($db, $_POST['card_product_image'][$i]);
		$card_product_description[] = str_replace("\r\n",'', $_POST['card_product_description'][$i]);
		$card_product_button[] = clean($db, $_POST['card_product_button'][$i]);
		$card_product_button_link[] = clean($db, $_POST['card_product_button_link'][$i]);

		$card_product_tmp = array();
		$card_product_tmp['title'] = clean($db, $_POST['card_product_title'][$i]);
		$card_product_tmp['image'] = clean($db, $_POST['card_product_image'][$i]);
		$card_product_tmp['description'] = str_replace("\r\n",'', $_POST['card_product_description'][$i]);
		$card_product_tmp['button'] = clean($db, $_POST['card_product_button'][$i]);
		$card_product_tmp['link'] = clean($db, $_POST['card_product_button_link'][$i]);

		$card_products[] = $card_product_tmp;
	}
	$card_products_heading = clean($db, $_POST['card_products_heading']);
	if(isset($_POST['card_products_visibility'])) 
		$card_products_visibility = clean($db, $_POST['card_products_visibility']);
	else
		$card_products_visibility = 0;
	$card_offer_title = array(); $card_offer_image = array(); $card_offer_description = array(); 
	$card_offer_button = array(); $card_offer_button_link = array(); 
	$card_offers = array();
	for($i = 0; $i < count($_POST['card_offer_title']); $i++) {
		if(empty($_POST['card_offer_title'][$i]))
			continue;
		$card_offer_title[] = clean($db, $_POST['card_offer_title'][$i]);
		$card_offer_image[] = clean($db, $_POST['card_offer_image'][$i]);
		$card_offer_description[] = str_replace("\r\n",'', $_POST['card_offer_description'][$i]);
		$card_offer_button[] = clean($db, $_POST['card_offer_button'][$i]);
		$card_offer_button_link[] = clean($db, $_POST['card_offer_button_link'][$i]);
		$card_offer_mrp[] = $_POST['card_offer_mrp'][$i];
		$card_offer_price[] = $_POST['card_offer_price'][$i];

		$card_offer_tmp = array();
		$card_offer_tmp['title'] = clean($db, $_POST['card_offer_title'][$i]);
		$card_offer_tmp['image'] = clean($db, $_POST['card_offer_image'][$i]);
		$card_offer_tmp['description'] = str_replace("\r\n",'', $_POST['card_offer_description'][$i]);
		$card_offer_tmp['button'] = clean($db, $_POST['card_offer_button'][$i]);
		$card_offer_tmp['link'] = clean($db, $_POST['card_offer_button_link'][$i]);
		$card_offer_tmp['MRP'] = $_POST['card_offer_mrp'][$i];
		$card_offer_tmp['offer_price'] = $_POST['card_offer_price'][$i];

		$card_offers[] = $card_offer_tmp;
	}
	$card_offers_heading = clean($db, $_POST['card_offers_heading']);
	if(isset($_POST['card_offers_visibility'])) 
		$card_offers_visibility = clean($db, $_POST['card_offers_visibility']);
	else
		$card_offers_visibility = 0;
	$card_gallery = array();
	foreach($_POST['card_gallery'] as $tmp) {
		if(empty($tmp))
			continue;
		$card_gallery[] = clean($db, $tmp);
	}
	$card_gallery_urls = implode(",", $card_gallery);
	$card_gallery_heading = clean($db, $_POST['card_gallery_heading']);
	if(isset($_POST['card_gallery_visibility'])) 
		$card_gallery_visibility = clean($db, $_POST['card_gallery_visibility']);
	else
		$card_gallery_visibility = 0;
	$card_additional_heading = array(); $card_additional_image = array(); $card_additional_text = array(); $card_additional_visibility = array();
	$card_additional = array();
	for($i = 0; $i < count($_POST['card_additional_heading']); $i++) {
		if(empty($_POST['card_additional_heading'][$i]))
			continue;
		$card_additional_heading[] = clean($db, $_POST['card_additional_heading'][$i]);
		$card_additional_image[] = clean($db, $_POST['card_additional_image'][$i]);
		$card_additional_text[] = clean($db, $_POST['card_additional_text'][$i]);
		$card_additional_visibility[] = clean($db, $_POST['card_additional_visibility'][$i]);

		$card_additional_tmp = array();
		$card_additional_tmp['heading'] = clean($db, $_POST['card_additional_heading'][$i]);
		$card_additional_tmp['image'] = clean($db, $_POST['card_additional_image'][$i]);
		$card_additional_tmp['text'] = clean($db, $_POST['card_additional_text'][$i]);
		$card_additional_tmp['visibility'] = clean($db, $_POST['card_additional_visibility'][$i]);

		$card_additional[] = $card_additional_tmp;
	}

	$card_feedback_heading = clean($db, $_POST['card_feedback_heading']);
	if(isset($_POST['card_feedback_visibility'])) 
		$card_feedback_visibility = clean($db, $_POST['card_feedback_visibility']);
	else
		$card_feedback_visibility = 0;

	$card_order = array();
	$card_order[] = $card_company_position = clean($db, $_POST['card_company_position']);
	$card_order[] = $card_social_position = clean($db, $_POST['card_social_position']);
	$card_order[] = $card_payment_position = clean($db, $_POST['card_payment_position']);
	$card_order[] = $card_products_position = clean($db, $_POST['card_products_position']);
	$card_order[] = $card_offers_position = clean($db, $_POST['card_offers_position']);
	$card_order[] = $card_gallery_position = clean($db, $_POST['card_gallery_position']);
	$card_order[] = $card_feedback_position = clean($db, $_POST['card_feedback_position']);
	$card_order[] = $card_additional_position = clean($db, $_POST['card_additional_position']);
	sort($card_order);
	for($i = 0; $i < count($card_order); $i++) {
		if($card_order[$i] == $card_company_position)
			$card_order[$i] = 'card_company_position';
		if($card_order[$i] == $card_social_position)
			$card_order[$i] = 'card_social_position';
		if($card_order[$i] == $card_payment_position)
			$card_order[$i] = 'card_payment_position';
		if($card_order[$i] == $card_products_position)
			$card_order[$i] = 'card_products_position';
		if($card_order[$i] == $card_offers_position)
			$card_order[$i] = 'card_offers_position';
		if($card_order[$i] == $card_gallery_position)
			$card_order[$i] = 'card_gallery_position';
		if($card_order[$i] == $card_feedback_position)
			$card_order[$i] = 'card_feedback_position';
		if($card_order[$i] == $card_additional_position)
			$card_order[$i] = 'card_additional_position';
	}

} else {
	include('card_get_db.php');
}
if(isset($_GET['preview'])) 
{
	$_GET['preview'] = true;
	include('card_view.php');
	exit;
} else if(isset($_POST['card_url'])) {
	if(!preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['card_company_email']))
	{
		$errors[] = "Invalid Email";
	}
	if(preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $card_url) === false) 
	{
		$errors[] = "Invalid URL";
	}
	$urls = mysqli_fetch_array(mysqli_query($db, 'select id from card where card_link="'.$card_url.'" and id!="'.$id.'"'));
	if(isset($urls['id']))
	{
		$errors[] = "Card URL already taken";
	}
	if($card_template == "" || $card_logo == "" || $card_company_name == "" ||
	$card_company_whatsapp == "" || $card_company_country == "" || $card_company_address == "" || $card_company_email == "") 
	{
		$errors[] = "Required fields have not been filled";
	}
	if(!in_array($card_company_country, $country_array))
	{
		$errors[] = "Invalid country";
	}
	if($card_template < 1 || $card_template > $card_templates_count)
	{
		$errors[] = "Invalid template";
	}
	if(empty($errors)) 
	{
		mysqli_query($db, 'update card set email="'.$card_company_email.'", company="'.$card_company_name.'", card_link="'.$card_url.'", template="'.$card_template.'", design="'.$card_design.'", creator="'.$uid.'", user_email="'.$card_company_email.'", is_admin="'.$is_admin.'" where id='.$id);
		mysqli_query($db, 'update card_company set name="'.$card_company_name.'", tagline="'.$card_company_tagline.'", person_name="'.$card_company_person.'", designation="'.$card_company_person_designation.'", phone="'.$card_company_phone.'", alternative_phone="'.$card_company_phone_alt.
				  '", whatsapp="'.$card_company_whatsapp.'", country="'.$card_company_country.'", address="'.$card_company_address.'" , email="'.$card_company_email.'", website="'.$card_company_website.'", google_location="'.$card_company_google_location.'", about="'.clean($db, $card_company_about).
				  '", nature="'.$card_company_nature.'", specialities="'.$card_company_specialities.'", appointment="'.$card_company_appointment.'", files="'.$card_company_files.'", is_visible="'.$card_company_visibility.'", section_title="'.$card_company_heading.'", section_position="'.$card_company_position.'" where card_id='.$id);
		mysqli_query($db, 'update card_social_media set facebook="'.$card_social_facebook.'", twitter="'.$card_social_twitter.'", instagram="'.$card_social_instagram.'", linkedin="'.$card_social_linkedin.'", pinterest="'.$card_social_pinterest.'", youtube="'.$card_social_youtube.
				  '", others="'.$card_social_links.'", youtube_videos="'.$card_social_youtube_links.'", is_visible="'.$card_social_visibility.'", section_title="'.$card_social_heading.'", section_position="'.$card_social_position.'" where card_id='.$id);
		mysqli_query($db, 'update card_payment set venmo="'.$card_payment_venmo.'", cashapp="'.$card_payment_cashapp.'", paypal="'.$card_payment_paypal.'", is_visible="'.$card_payment_visibility.'", section_title="'.$card_payment_heading.'", section_position="'.$card_payment_position.'" where card_id='.$id);
		mysqli_query($db, 'delete from card_product_information where title!="~locator" and card_id='.$id);
		mysqli_query($db, 'update card_product_information set is_visible="'.$card_products_visibility.'", section_title="'.$card_products_heading.'", section_position="'.$card_products_position.'" where title="~locator" and card_id='.$id);
		foreach($card_products as $product) {
			mysqli_query($db, 'insert into card_product_information (title, description, button, link, card_id) values ("'.$product['title'].'","'.clean($db, $product['description']).'","'.$product['button'].'","'.$product['link'].'", "'.$id.'")');
		}
		mysqli_query($db, 'delete from card_offers_section where title!="~locator" and card_id='.$id);
		mysqli_query($db, 'update card_offers_section set is_visible="'.$card_offers_visibility.'", section_title="'.$card_offers_heading.'", section_position="'.$card_offers_position.'" where title="~locator" and card_id='.$id);
		foreach($card_offers as $offer) {
			mysqli_query($db, 'insert into card_offers_section (title, description, MRP, offer_price, button, link, card_id) values ("'.$offer['title'].'","'.clean($db, $offer['description']).'","'.floatval($offer['MRP']).'","'.floatval($offer['offer_price']).'","'.$offer['button'].'","'.$offer['link'].'", "'.$id.'")');
		}
		mysqli_query($db, 'update card_gallery set url="'.$card_gallery_urls.'", is_visible="'.$card_gallery_visibility.'", section_title="'.$card_gallery_heading.'", section_position="'.$card_gallery_position.'" where card_id='.$id);
		mysqli_query($db, 'delete from card_additional where heading!="~locator" and card_id='.$id);
		mysqli_query($db, 'update card_additional set section_position="'.$card_additional_position.'" where title="~locator" and card_id='.$id);
		foreach($card_additional as $additional) {
			mysqli_query($db, 'insert into card_additional (heading, image, text, is_visible, card_id) values ("'.$additional['heading'].'","'.$additional['image'].'","'.$additional['text'].'", "'.$additional['visibility'].'", "'.$id.'")');
		}
		mysqli_query($db, 'update card_feedback set is_visible="'.$card_feedback_visibility.'",section_title="'.$card_feedback_heading.'",section_position="'.$card_feedback_position.'" where card_id='.$id);
		header("Refresh:0");
		exit;
	}
}
$template['header_link'] = 'Edit Card '.ucfirst($data['card_link']); 
include('includes/default_array_lists.php');
$error = []; 
// robocopy d:\Git\Go-Crd\Cards c:\Apache\htdocs\Cards /E /XC /XN /XO /MIR
?>
<?php include('assets/inc/template_start.php'); ?>
<?php
$primary_nav = array(
    array(
        'name'  => 'Dashboard',
        'url'   => '.',
        'icon'  => 'gi gi-compass',
    ),
    array(
        'url'   => 'separator',
    ),
    array(
        'name'  => 'Create New Card',
        'url'   => 'create-card',
        'icon'  => 'gi gi-compass',
        'active'=> true
    ),
    array(
        'name'  => 'My Cards',
        'icon'  => 'fa fa-rocket',
        'url'   => 'direct_user_card_information',
    ),
    array(
        'name'  => 'Card Messages',
        'icon'  => 'fa fa-rocket',
        'url'   => 'view-card-messages',
    ),
    array(
        'url'   => 'separator',
    ),
    array(
        'name'  => 'Edit Profile',
        'icon'  => 'fa fa-rocket',
        'url'   => 'edit_profile',
    ),
    
);
?>
<?php include('assets/inc/page_head.php'); ?>

<link href="<?php echo $settings['url_assets']; ?>libs/bootstrap-tagsinput.css" rel="stylesheet">
<link href="<?php echo $settings['url_assets']; ?>css/additional-css.css" rel="stylesheet">

<!-- Page content -->
<div id="page-content">
    <!-- Wizard Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1><?php echo $template['header_link']; ?></h1>
                </div>
            </div>
            <!--<div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>User Interface</li>
                        <li>Forms</li>
                        <li><a href="">Wizard</a></li>
                    </ul>
                </div>
            </div>-->
        </div>
    </div>
    <!-- END Wizard Header -->

    <?php 
    // We display a message if necessary
    if(!empty($errors))
    {
         echo '<div class="col-sm-12 alert alert-danger"><h4>Error</h4><ul>';
	 foreach($errors as $error) { echo "<li>". $error . "</li>"; }
	 echo '</ul></div>';
    }
    // robocopy d:\Git\Go-Crd\Cards c:\Apache\htdocs\Cards /E /XC /XN /XO /MIR
    ?>

    <!-- Wizards Content -->
    <!-- Form Wizards are initialized in js/pages/formsWizard.js -->
    <div class="row">
        <div class="col-sm-10 col-md-8 col-lg-8">
            <!-- Progress Bar Wizard Block -->
            <div class="block">
                <!-- Progress Bars Wizard Title -->
                <div class="block-title">
                    <!--<div class="block-options pull-right">
                        <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="Settings"><i class="fa fa-cog"></i></a>
                    </div>-->
                    <h2><?php echo $template['header_link']; ?></h2>
                </div>
                <!-- END Progress Bar Wizard Title -->

                <!-- Progress Wizard Content -->
                <form class="ImageUploadAJAX" id="imup1" method="post" enctype="multipart/form-data" action="../image-upload">
                     <input type="hidden" name="type" value="card_logo" />
                     <input type="hidden" name="card_id" value="<?php echo $id; ?>" />
                </form>
                <form class="ImageUploadAJAX" id="imup2" method="post" enctype="multipart/form-data" action="../image-upload">
                     <input type="hidden" name="type" value="card_header" />
                     <input type="hidden" name="card_id" value="<?php echo $id; ?>" />
                </form>
                <form class="ImageUploadAJAX" id="imup3" method="post" enctype="multipart/form-data" action="../image-upload">
                     <input type="hidden" name="type" value="card_product" />
                     <input type="hidden" name="card_id" value="<?php echo $id; ?>" />
                     <input type="hidden" name="extra" value="" class="extra" />
                </form>
                <form class="ImageUploadAJAX" id="imup4" method="post" enctype="multipart/form-data" action="../image-upload">
                     <input type="hidden" name="type" value="card_offer" />
                     <input type="hidden" name="card_id" value="<?php echo $id; ?>" />
                     <input type="hidden" name="extra" value="" class="extra" />
                </form>
                <form class="ImageUploadAJAX" id="imup5" method="post" enctype="multipart/form-data" action="../image-upload">
                     <input type="hidden" name="type" value="card_gallery" />
                     <input type="hidden" name="card_id" value="<?php echo $id; ?>" />
                     <input type="hidden" name="extra" value="" class="extra" />
                </form>
                <form class="ImageUploadAJAX" id="imup6" method="post" enctype="multipart/form-data" action="../image-upload">
                     <input type="hidden" name="type" value="card_additional" />
                     <input type="hidden" name="card_id" value="<?php echo $id; ?>" />
                     <input type="hidden" name="extra" value="" class="extra" />
                </form>
                <form class="ImageUploadAJAX" id="fileup1" method="post" enctype="multipart/form-data" action="../image-upload">
                     <input type="hidden" name="type" value="card_files" />
                     <input type="hidden" name="card_id" value="<?php echo $id; ?>" />
                </form>
                <form id="progress-wizard-card" method="post" class="form-horizontal form-bordered" name="card_form">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="progress progress-mini remove-margin">
                                <div id="progress-bar-wizard-card" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
                            </div>
                        </div>
                    </div>
                    <!-- END Progress Bar -->

                    <!-- First Step -->
                    <div id="progress-first" class="step">
                        <div class="row text-center"><h4><strong>Template</strong></h4><br></div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_url">URL <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="card_url" name="card_url" class="form-control" placeholder="http://gocrdz.com/URL" required <?php echo form_update_value('card_url'); ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Select a Template <span class="text-danger">*</span></label>
                            <div class="col-md-6 template-labels">
				<?php for($i = 1; $i < $card_templates_count + 1; $i++){ ?>
                                <input type="radio" id="template-<?php echo $i; ?>" name="card_template" class="hidden" <?php if($i == 1 && form_update_value_checked('card_template', $i) == "") echo "checked"; echo form_update_value_checked('card_template', $i); ?> value="<?php echo $i; ?>" required />
                                <label class="col-md-4 control-label" for="template-<?php echo $i; ?>">
                                    <img id="template-<?php echo $i; ?>-image" src="<?php echo $settings['url_assets'] ?>img/card_mobile_template-<?php echo $i; ?>.png" class="template-image img-fluid img-thumbnail <?php if(form_update_value_selected('card_template', $i) != "" || ($i == 1 && !isset($_POST['card_template']))) echo "focus"; ?>" />
                                </label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_colors_default">Default Template Colours</label>
                            <div class="col-md-6">
                                <input type="checkbox" style="vertical-align:bottom;" onchange="if(this.checked) document.getElementById('template_colors').style.display='none'; else document.getElementById('template_colors').style.display='block';" name="card_colors_default" id="card_colors_default" <?php if(form_update_raw('card_color_background') == "") echo "checked"; ?> />
                            </div>
                        </div>
                        <div id="template_colors">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_color_background">Select Background Colour</label>
                            <div class="col-md-6">
                                <input type="color" id="card_color_background" name="card_color_background" <?php echo form_update_value('card_color_background'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_color_main">Select Main Colour</label>
                            <div class="col-md-6">
                                <input type="color" id="card_color_main" name="card_color_main" <?php echo form_update_value('card_color_main'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_color_action">Select Call to Action Colour</label>
                            <div class="col-md-6">
                                <input type="color" id="card_color_action" name="card_color_action" <?php echo form_update_value('card_color_action'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_font_heading">Heading Font</label>
                            <div class="col-md-6">
                                <select id="card_font_heading" name="card_font_heading" class="form-control" placeholder="Choose a Heading Font">
                                    <option value="Montserrat" <?php echo form_update_value_selected('card_font_heading', 'Montserrat'); ?>>Montserrat</option>
                                    <option value="arial" <?php echo form_update_value_selected('card_font_heading', 'arial'); ?>>Arial</option>
                                    <option value="verdana" <?php echo form_update_value_selected('card_font_heading', 'verdana'); ?>>Verdana</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_color_heading">Select Heading Colour</label>
                            <div class="col-md-6">
                                <input type="color" id="card_color_heading" name="card_color_heading" <?php echo form_update_value('card_color_heading'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_font_other">Other Text Font</label>
                            <div class="col-md-6">
                                <select id="card_font_other" name="card_font_other" class="form-control" placeholder="Choose a Other Text Font" required>
                                    <option value="Montserrat" <?php echo form_update_value_selected('card_font_other', 'Montserrat'); ?>>Montserrat</option>
                                    <option value="arial" <?php echo form_update_value_selected('card_font_other', 'arial'); ?>>Arial</option>
                                    <option value="verdana" <?php echo form_update_value_selected('card_font_other', 'verdana'); ?>>Verdana</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_color_other">Select Other Text Colour</label>
                            <div class="col-md-6">
                                <input type="color" id="card_color_other" name="card_color_other" <?php echo form_update_value('card_color_other'); ?>/>
                            </div>
                        </div>
                        </div>
                        <script> if(document.getElementById('card_colors_default').checked) document.getElementById('template_colors').style.display = 'none'; </script>
                    </div>
                    <!-- END First Step -->

                    <!-- Second Step -->
                    <div id="progress-second" class="step">
                        <div class="form-group">
			    <div class="row text-center"><h4><strong>Company Details</strong></h4><br></div>
                            <label class="col-md-4 control-label" for="card_logo">Card Logo <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="file" id="card_logo" class="ImageBrowse" data-form="imup1" />
                                <input type="hidden" name="card_logo" id="card_logo_inp" class="ImageReturn" <?php echo form_update_value('card_logo'); ?> required />
				<img class="ImageDisplay img-fluid img-thumbnail" <?php if(form_update_raw('card_logo') != "") echo 'src="'.$settings['url'].form_update_raw('card_logo').'"'; ?> />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_header">Card Header</label>
                            <div class="col-md-6">
                                <input type="file" id="card_header" class="ImageBrowse" data-form="imup2" />
                                <input type="hidden" name="card_header" id="card_header_inp" class="ImageReturn" <?php echo form_update_value('card_header'); ?> />
				<img class="ImageDisplay img-fluid img-thumbnail" <?php if(file_exists(form_update_value('card_header')) && form_update_value('card_header') != "") echo 'src="'.$settings['url'].form_update_raw('card_header').'"'; ?> />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_name">Company Name <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_name" name="card_company_name" class="form-control" required <?php echo form_update_value('card_company_name'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_tagline">Company Tagline</label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_tagline" name="card_company_tagline" class="form-control" <?php echo form_update_value('card_company_tagline'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_person">Contact Person Name</label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_person" name="card_company_person" class="form-control" <?php echo form_update_value('card_company_person'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_person_designation">Contact Person Designation</label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_person_designation" name="card_company_person_designation" class="form-control" <?php echo form_update_value('card_company_person_designation'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_phone">Phone Number</label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_phone" name="card_company_phone" class="form-control" <?php echo form_update_value('card_company_phone'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_phone_alt">Alternative Phone Number</label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_phone_alt" name="card_company_phone_alt" class="form-control" <?php echo form_update_value('card_company_phone_alt'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_whatsapp">Whatsapp Phone Number <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_whatsapp" name="card_company_whatsapp" class="form-control" <?php echo form_update_value('card_company_whatsapp'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_country">Country <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select id="card_company_country" name="card_company_country" class="form-control" required>
					<option value="">Select</option>
					<?php for($i = 0; $i < sizeof($country_array); $i++){ ?>
					<option <?php echo form_update_value_selected('card_company_country', $country_array[$i]); ?> value="<?php echo $country_array[$i]; ?>">
						<?php echo $country_array[$i]; ?>
					</option>
					<?php } ?>
				</select>
                            </div>
                        </div>
                    </div>
                    <!-- END Second Step -->

                    <!-- Third Step -->
                    <div id="progress-third" class="step">
                        <div class="row text-center"><h4><strong>Company Details</strong></h4><br></div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_address">Address <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" id="card_company_address" name="card_company_address" class="form-control" <?php echo form_update_value('card_company_address'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_email">Email <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" id="card_company_email" name="card_company_email" class="form-control" <?php echo form_update_value('card_company_email'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_website">Website</label>
                            <div class="col-md-12">
                                <input type="text" id="card_company_website" name="card_company_website" class="form-control" <?php echo form_update_value('card_company_website'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_comapny_google_location">Google Location</label>
                            <div class="col-md-12">
                                <input type="text" id="card_company_google_location" name="card_company_google_location" class="form-control" <?php echo form_update_value('card_company_google_location'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_about">About</label>
                            <div class="col-md-12">
                                <textarea id="card_company_about" name="card_company_about" class="ckeditor"><?php echo form_update_raw('card_company_about'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_nature">Nature of Business</label>
                            <div class="col-md-12">
                                <input data-role="tagsinput" id="card_company_nature" name="card_company_nature" class="form-control" <?php echo form_update_value('card_company_nature'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_specialities">Specialities</label>
                            <div class="col-md-12">
                                <input data-role="tagsinput" id="card_company_specialities" name="card_company_specialities" class="form-control" <?php echo form_update_value('card_company_specialities'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_appointment">Appointment Booking Link</label>
                            <div class="col-md-12">
                                <input type="text" id="card_company_appointment" name="card_company_appointment" class="form-control" <?php echo form_update_value('card_company_appointment'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_files">Extra Files</span></label>
                            <div class="col-md-12">
				<style>.bootstrap-tagsinput input.mf { display: none; }</style>
                                <input type="file" class="ImageBrowse Multiple" data-form="fileup1" multiple />
                                <input type="hidden" onchange="$('.multifileres').html('Uploaded: ' + this.value)" name="card_company_files" id="card_company_files" class="ImageReturn" <?php echo form_update_value('card_company_files'); ?> /><br>
				<img class="ImageDisplay img-fluid img-thumbnail" style="display:none" />
                                <div class="multifileres"><?php echo form_update_raw('card_company_files'); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_company_heading">Section Heading</label>
                            <div class="col-md-10">
                                <input type="text" id="card_company_heading" name="card_company_heading" class="form-control" placeholder="default" <?php echo form_update_value('card_company_heading'); ?>>
                            </div>
                            <div class="col-md-2 control-label no-lpad">
                                <input type="checkbox" name="card_company_visibility" value="1" <?php if(form_update_value('card_company_visibility') != "") echo "checked"; ?> class="form-check-input"> Visibility
                            </div>
                        </div>
                    </div>
                    <!-- END Third Step -->

                    <!-- Fourth Step -->
                    <div id="progress-fourth" class="step">
                        <div class="row text-center"><h4><strong>Social Media Information</strong></h4><br></div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_facebook">Facebook Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_social_facebook" name="card_social_facebook" class="form-control" <?php echo form_update_value('card_social_facebook'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_twitter">Twitter Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_social_twitter" name="card_social_twitter" class="form-control" <?php echo form_update_value('card_social_twitter'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_instagram">Instagram Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_social_instagram" name="card_social_instagram" class="form-control" <?php echo form_update_value('card_social_instagram'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_linkedin">LinkedIn Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_social_linkedin" name="card_social_linkedin" class="form-control" <?php echo form_update_value('card_social_linkedin'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_pinterest">Pinterest Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_social_pinterest" name="card_social_pinterest" class="form-control" <?php echo form_update_value('card_social_pinterest'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_youtube">YouTube Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_social_youtube" name="card_social_youtube" class="form-control" <?php echo form_update_value('card_social_youtube'); ?>/>
                            </div>
                        </div>
                        <div class="form-group" id="other_links">
                            <label class="col-md-4 control-label">Other Links</label>
                            <div class="col-md-6">
                                <div id="other_links_div">
                                    <?php 
				    if(isset($_POST)) {
					   $method = $_POST;
				    } else {
					   $method = $GLOBALS;
				    }
				    for($i = 0; isset($method['card_other_links_icon']) && $i < count($method['card_other_links_icon']); $i++) { ?>
                                    <select class="fa form-control" name="card_other_links_icon[]">
                                        <option value="">Select</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-soundcloud") echo "selected"; ?> value="fa-soundcloud">&#xf1be</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-whatsapp") echo "selected"; ?> value="fa-whatsapp">&#xf232</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-weixin") echo "selected"; ?> value="fa-weixin">&#xf1d7</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-tumblr") echo "selected"; ?> value="fa-tumblr">&#xf173</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-quora") echo "selected"; ?> value="fa-quora">&#xf2c4</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-pinterest") echo "selected"; ?> value="fa-pinterest">&#xf0d2</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-linkedin") echo "selected"; ?> value="fa-linkedin">&#xf0e1</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-github") echo "selected"; ?> value="fa-github">&#xf09b</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-faceook") echo "selected"; ?> value="fa-facebook">&#xf09a</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-paypal") echo "selected"; ?> value="fa-paypal">&#xf1f4</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-skype") echo "selected"; ?> value="fa-skype">&#xf17e</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-snapchat") echo "selected"; ?> value="fa-snapchat">&#xf2ab</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-stumbleupon") echo "selected"; ?> value="fa-stumbleupon">&#xf1a4</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-twitch") echo "selected"; ?> value="fa-twitch">&#xf1e8</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-twitter") echo "selected"; ?> value="fa-twitter">&#xf099</option>
                                        <option class="fa" <?php if($method['card_other_links_icon'][$i] == "fa-youtube-play") echo "selected"; ?> value="fa-youtube-play">&#xf16a</option>
                                    </select>
                                    <input type="text" name="card_other_links[]" class="form-control" value="<?php echo $method['card_other_links'][$i]; ?>" />
				    <?php } ?>
                                </div>
                                <div id="other_links_dup" style="display:none">
                                    <select class="fa form-control" name="card_other_links_icon[]">
                                        <option value="">Select</option>
                                        <option class="fa" value="fa-soundcloud">&#xf1be</option>
                                        <option class="fa" value="fa-whatsapp">&#xf232</option>
                                        <option class="fa" value="fa-weixin">&#xf1d7</option>
                                        <option class="fa" value="fa-tumblr">&#xf173</option>
                                        <option class="fa" value="fa-quora">&#xf2c4</option>
                                        <option class="fa" value="fa-pinterest">&#xf0d2</option>
                                        <option class="fa" value="fa-linkedin">&#xf0e1</option>
                                        <option class="fa" value="fa-github">&#xf09b</option>
                                        <option class="fa" value="fa-facebook">&#xf09a</option>
                                        <option class="fa" value="fa-paypal">&#xf1f4</option>
                                        <option class="fa" value="fa-skype">&#xf17e</option>
                                        <option class="fa" value="fa-snapchat">&#xf2ab</option>
                                        <option class="fa" value="fa-stumbleupon">&#xf1a4</option>
                                        <option class="fa" value="fa-twitch">&#xf1e8</option>
                                        <option class="fa" value="fa-twitter">&#xf099</option>
                                        <option class="fa" value="fa-youtube-play">&#xf16a</option>
                                    </select>
                                    <input type="text" name="card_other_links[]" class="form-control" />
                                </div>
				<script>document.getElementById('other_links_div').innerHTML += document.getElementById('other_links_dup').innerHTML;</script>
                                <button class="btn btn-primary" id="other_links_ins" onclick="$(this).unbind('click');$('#other_links_div').append($('#other_links_dup').html());event.preventDefault();">Add More</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_youtube_links">Additional YouTube Links</label>
                            <div class="col-md-6">
                                <input data-role="tagsinput" id="card_social_youtube_links" name="card_social_youtube_links" class="form-control" <?php echo form_update_value('card_social_youtube_links'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_social_heading">Section Heading</label>
                            <div class="col-md-4">
                                <input type="text" id="card_social_heading" name="card_social_heading" class="form-control" placeholder="default" <?php echo form_update_value('card_social_heading'); ?>>
                            </div>
                            <div class="col-md-2 control-label no-lpad">
                                <input type="checkbox" name="card_social_visibility" value="1" <?php if(form_update_value('card_social_visibility') != "") echo "checked"; ?> class="form-check-input"> Visibility
                            </div>
                        </div>
                    </div>
                    <!-- END Fourth Step -->

                    <!-- Fifth Step -->
                    <div id="progress-fifth" class="step">
                        <div class="row text-center"><h4><strong>Payment Information</strong></h4><br></div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_payment_venmo">Venmo Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_payment_venmo" name="card_payment_venmo" class="form-control" <?php echo form_update_value('card_payment_venmo'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_payment_cashapp">Cashapp Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_payment_cashapp" name="card_payment_cashapp" class="form-control" <?php echo form_update_value('card_payment_cashapp'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_payment_paypal">Paypal Link</label>
                            <div class="col-md-6">
                                <input type="text" id="card_payment_paypal" name="card_payment_paypal" class="form-control" <?php echo form_update_value('card_payment_paypal'); ?>/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_payment_heading">Section Heading</label>
                            <div class="col-md-4">
                                <input type="text" id="card_payment_heading" name="card_payment_heading" class="form-control" placeholder="default" <?php echo form_update_value('card_payment_heading'); ?>>
                            </div>
                            <div class="col-md-2 control-label no-lpad">
                                <input type="checkbox" name="card_payment_visibility" value="1" <?php if(form_update_value('card_payment_visibility') != "") echo "checked"; ?> class="form-check-input"> Visibility
                            </div>
                        </div>
                    </div>
                    <!-- Fifth Step -->

                    <!-- Sixth Step -->
                    <div id="progress-sixth" class="step">
                        <div class="row text-center"><h4><strong>Product and Service Information</strong></h4><br></div>
                        <div id="card_products">
                        <?php 
			for($i = 0; isset($card_product_title) && $i < count($card_product_title); $i++) { ?>
                            <div class="form-group">                                
                                <label class="col-md-12"><h3><strong>#<?php echo ($i+1); ?></strong></h3></label>
                                <label class="col-md-12">Product Title</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_product_title[]" class="form-control" value="<?php echo $card_product_title[$i]; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Product Image</label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup3" data-extra="<?php echo $i ?>" />
                                    <input type="hidden" name="card_product_image[]" class="ImageReturn" value="<?php echo $card_product_image[$i]; ?>" />
				    <img class="ImageDisplay img-fluid img-thumbnail" <?php echo 'src="'.$settings['url'].$card_product_image[$i].'"'; ?> />
                                </div>
                            </div>
                            <!-- pls dont change order of above two -->
                            <div class="form-group">
                                <label class="col-md-12">Product Description</label>
                                <div class="col-md-12">
                                    <textarea name="card_product_description[]" class="ckeditor"><?php echo $card_product_description[$i]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_product_button[]" class="form-control" value="<?php echo $card_product_button[$i]; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Link</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_product_button_link[]" class="form-control" value="<?php echo $card_product_button_link[$i]; ?>" />
                                </div>
                            </div>
			<?php } ?>
                        </div>
                        <div id="card_products_dup" style="display:none">
                            <div><div class="form-group">
                                <label class="col-md-12"><h3><strong>#</strong></h3></label>
                                <label class="col-md-12">Product Title</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_product_title[]" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Product Image</label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup3" data-extra="" />
                                    <input type="hidden" name="card_product_image[]" class="ImageReturn" />
				    <img class="ImageDisplay img-fluid img-thumbnail" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Product Description</label>
                                <div class="col-md-12">
                                    <textarea name="card_product_description[]" class="ckeditor"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_product_button[]" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Link</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_product_button_link[]" class="form-control" />
                                </div>
                            </div></div>
                        </div>
			<script>
                            var product_count = <?php if(isset($card_product_title)) echo (count($card_product_title)); else echo "0"; ?>;
                            document.getElementById('card_products').innerHTML += document.getElementById('card_products_dup').innerHTML;
                            function fix_last() {
                                var last = document.getElementById("card_products").lastElementChild;
                                last.getElementsByTagName('div')[2].getElementsByTagName('input')[0].setAttribute('data-extra', product_count);
                                product_count++;
                                last.firstElementChild.firstElementChild.firstElementChild.firstElementChild.innerHTML = "#" + product_count;
                            }
                            fix_last();
                        </script>
                        <div class="form-group">
                            <label class="col-md-12">
                                <button class="btn btn-primary" onclick="$(this).unbind('click');$('#card_products').append($('#card_products_dup').html());fix_last();event.preventDefault();">Add More</button>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_products_heading">Section Heading</label>
                            <div class="col-md-10">
                                <input type="text" id="card_products_heading" name="card_products_heading" class="form-control" placeholder="default" <?php echo form_update_value('card_products_heading'); ?>>
                            </div>
                            <div class="col-md-2 control-label no-lpad">
                                <input type="checkbox" name="card_products_visibility" value="1" <?php if(form_update_value('card_products_visibility') != "") echo "checked"; ?> class="form-check-input"> Visibility
                            </div>
                        </div>
                    </div>
                    <!-- Sixth Step -->

                    <!-- Seventh Step -->
                    <div id="progress-seventh" class="step">
                        <div class="row text-center"><h4><strong>Offers Information</strong></h4><br></div>
                        <div id="card_offers">
                        <?php 
			for($i = 0; isset($card_offer_title) && $i < count($card_offer_title); $i++) { ?>
                            <div class="form-group">                                
                                <label class="col-md-12"><h3><strong>#<?php echo ($i+1); ?></strong></h3></label>
                                <label class="col-md-12">Offer Title</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_title[]" class="form-control" value="<?php echo $card_offer_title[$i]; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Offer Image</label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup4" data-extra="<?php echo $i ?>" />
                                    <input type="hidden" name="card_offer_image[]" class="ImageReturn" value="<?php echo $card_offer_image[$i]; ?>" />
				    <img class="ImageDisplay img-fluid img-thumbnail" <?php echo 'src="'.$settings['url'].$card_offer_image[$i].'"'; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Offer Description</label>
                                <div class="col-md-12">
                                    <textarea name="card_offer_description[]" class="ckeditor"><?php echo $card_offer_description[$i]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">MRP</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_mrp[]" class="form-control" value="<?php echo $card_offer_mrp[$i]; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Offer Price</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_price[]" class="form-control" value="<?php echo $card_offer_price[$i]; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_button[]" class="form-control" value="<?php echo $card_offer_button[$i]; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Link</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_button_link[]" class="form-control" value="<?php echo $card_offer_button_link[$i]; ?>" />
                                </div>
                            </div>
			<?php } ?>
                        </div>
                        <div id="card_offers_dup" style="display:none">
                            <div><div class="form-group">                                
                                <label class="col-md-12"><h3><strong>#</strong></h3></label>
                                <label class="col-md-12">Offer Title</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_title[]" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Offer Image</label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup4" data-extra="" />
                                    <input type="hidden" name="card_offer_image[]" class="ImageReturn" />
				    <img class="ImageDisplay img-fluid img-thumbnail" />
                                </div>
                            </div>
                            <!-- pls dont change order of above two -->
                            <div class="form-group">
                                <label class="col-md-12">Offer Description</label>
                                <div class="col-md-12">
                                    <textarea name="card_offer_description[]" class="ckeditor"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">MRP</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_mrp[]" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Offer Price</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_price[]" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_button[]" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Button Link</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_offer_button_link[]" class="form-control" />
                                </div>
                            </div></div>
                        </div>
			<script>
                            var offer_count = <?php if(isset($card_offer_title)) echo count($card_offer_title); else echo "0"; ?>;
                            document.getElementById('card_offers').innerHTML += document.getElementById('card_offers_dup').innerHTML;
                            function fix_last_offer() {
                                var last = document.getElementById("card_offers").lastElementChild;
                                last.getElementsByTagName('div')[2].getElementsByTagName('input')[0].setAttribute('data-extra', offer_count);
                                offer_count++;
                                last.firstElementChild.firstElementChild.firstElementChild.firstElementChild.innerHTML = "#" + offer_count;
                            }
                            fix_last_offer();
                        </script>
                        <div class="form-group">
                            <label class="col-md-12">
                                <button class="btn btn-primary" onclick="$(this).unbind('click');$('#card_offers').append($('#card_offers_dup').html());fix_last_offer();event.preventDefault();">Add More</button>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_offers_heading">Section Heading</label>
                            <div class="col-md-10">
                                <input type="text" id="card_offers_heading" name="card_offers_heading" class="form-control" placeholder="default" <?php echo form_update_value('card_offers_heading'); ?>>
                            </div>
                            <div class="col-md-2 control-label no-lpad">
                                <input type="checkbox" name="card_offers_visibility" value="1" <?php if(form_update_value('card_offers_visibility') != "") echo "checked"; ?> class="form-check-input"> Visibility
                            </div>
                        </div>
                    </div>
                    <!-- Seventh Step -->

                    <!-- Eighth Step -->
                    <div id="progress-eighth" class="step">
                        <div class="row text-center"><h4><strong>Gallery</strong></h4><br></div>
                        <div id="card_gallery">
                        <?php 
			for($i = 0; isset($card_gallery) && $i < count($card_gallery); $i++) { ?>
                            <div class="form-group">                                
                                <label class="col-md-12"><h3><strong>#<?php echo ($i+1); ?></strong></h3></label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup5" data-extra="<?php echo $i ?>" />
                                    <input type="hidden" name="card_gallery[]" class="ImageReturn" value="<?php echo $card_gallery[$i]; ?>" />
				    <img class="ImageDisplay img-fluid img-thumbnail" <?php if($card_gallery[$i] != "") echo 'src="'.$settings['url'].$card_gallery[$i].'"'; ?> />
                                </div>
                            </div>
			<?php } ?>
                        </div>
                        <div id="card_gallery_dup" style="display:none">
                            <div><div class="form-group">                                
                                <label class="col-md-12"><h3><strong>#</strong></h3></label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup5" data-extra="" />
                                    <input type="hidden" name="card_gallery[]" class="ImageReturn" />
				    <img class="ImageDisplay img-fluid img-thumbnail" />
                                </div>
                            </div></div>
                            <!-- pls dont change order of above two -->
                        </div>
			<script>
                            var gallery_count = <?php if(isset($card_gallery)) echo count($card_gallery); else echo "0"; ?>;
                            document.getElementById('card_gallery').innerHTML += document.getElementById('card_gallery_dup').innerHTML;
                            function fix_last_gallery() {
                                var last = document.getElementById("card_gallery").lastElementChild;
                                last.firstElementChild.getElementsByTagName('input')[0].setAttribute('data-extra', gallery_count);
                                gallery_count++;
                                last.firstElementChild.firstElementChild.firstElementChild.firstElementChild.innerHTML = "#" + gallery_count;
                            }
                            fix_last_gallery();
                        </script>
                        <div class="form-group">
                            <label class="col-md-12">
                                <button class="btn btn-primary" onclick="$(this).unbind('click');$('#card_gallery').append($('#card_gallery_dup').html());fix_last_gallery();event.preventDefault();">Add More</button>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_gallery_heading">Section Heading</label>
                            <div class="col-md-10">
                                <input type="text" id="card_gallery_heading" name="card_gallery_heading" class="form-control" placeholder="default" <?php echo form_update_value('card_gallery_heading'); ?>>
                            </div>
                            <div class="col-md-2 control-label no-lpad">
                                <input type="checkbox" name="card_gallery_visibility" value="1" <?php if(form_update_value('card_gallery_visibility') != "") echo "checked"; ?> class="form-check-input"> Visibility
                            </div>
                        </div>
                    </div>
                    <!-- Eighth Step -->

                    <!-- Ninth Step -->
                    <div id="progress-ninth" class="step">
                        <div class="row text-center"><h4><strong>Additional Sections</strong></h4><br></div>
                        <div id="card_additional">
                        <?php 
			for($i = 0; isset($card_additional_heading) && $i < count($card_additional_heading); $i++) { ?>
                            <div class="form-group">
                                <label class="col-md-12"><h3><strong>#<?php echo ($i+1); ?></strong></h3></label>
                                <label class="col-md-12">Text</label>
                                <div class="col-md-12">
                                    <textarea name="card_additional_text[]" class="form-control"><?php echo $card_additional_text[$i]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Image</label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup6" data-extra="<?php echo $i ?>" />
                                    <input type="hidden" name="card_additional_image[]" class="ImageReturn" value="<?php echo $card_additional_image[$i]; ?>" />
				    <img class="ImageDisplay img-fluid img-thumbnail" <?php if(!empty($card_additional_image[$i])) echo 'src="'.$settings['url'].$card_additional_image[$i].'"'; ?> />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Section Heading</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_additional_heading[]" class="form-control" value="<?php echo $card_additional_heading[$i]; ?>">
                                </div>
                                <div class="col-md-12">
                                    <select name="card_additional_visibility[]" class="form-control">
                                        <option value="1">Visible</option>
                                        <option value="0" <?php if($card_additional_visibility[$i] == 0) echo "selected"; ?>>Not Visible</option>
                                    </select>
                                </div>
                            </div>
			<?php } ?>
                        </div>
                        <div id="card_additional_dup" style="display:none">
                            <div><div class="form-group">                                
                                <label class="col-md-12"><h3><strong>#</strong></h3></label>
                                <label class="col-md-12">Text</label>
                                <div class="col-md-12">
                                    <textarea name="card_additional_text[]" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Image</label>
                                <div class="col-md-12">
                                    <input type="file" class="ImageBrowse" data-form="imup6" data-extra="" />
                                    <input type="hidden" name="card_additional_image[]" class="ImageReturn" />
				    <img class="ImageDisplay img-fluid img-thumbnail" />
                                </div>
                            </div>
                            <!-- pls dont change order of above two -->
                            <div class="form-group">
                                <label class="col-md-12">Section Heading</label>
                                <div class="col-md-12">
                                    <input type="text" name="card_additional_heading[]" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <select name="card_additional_visibility[]" class="form-control">
                                        <option value="1">Visible</option>
                                        <option value="0">Not Visible</option>
                                    </select>
                                </div>
                            </div></div>
                        </div>
			<script>
                            var additional_count = <?php if(isset($card_additional_heading)) echo count($card_additional_heading); else echo "0"; ?>;
                            document.getElementById('card_additional').innerHTML += document.getElementById('card_additional_dup').innerHTML;
                            function fix_last_additional() {
                                var last = document.getElementById("card_additional").lastElementChild;
                                last.getElementsByTagName('div')[2].getElementsByTagName('input')[0].setAttribute('data-extra', additional_count);
                                additional_count++;
                                last.firstElementChild.firstElementChild.firstElementChild.firstElementChild.innerHTML = "#" + additional_count;
                            }
                            fix_last_additional();
                        </script>
                        <div class="form-group">
                            <label class="col-md-12">
                                <button class="btn btn-primary" onclick="$(this).unbind('click');$('#card_additional').append($('#card_additional_dup').html());fix_last_additional();event.preventDefault();">Add More</button>
                            </label>
                        </div>
                    </div>
                    <!-- Ninth Step -->

                    <!-- Tenth Step -->
                    <div id="progress-tenth" class="step">
                        <div class="row text-center"><h4><strong>Feedback Section</strong></h4><br></div>
                        <div class="form-group">
                            <label class="col-md-12" for="card_feedback_heading">Section Heading</label>
                            <div class="col-md-10">
                                <input type="text" id="card_feedback_heading" name="card_feedback_heading" class="form-control" placeholder="default" <?php echo form_update_value('card_feedback_heading'); ?>>
                            </div>
                            <div class="col-md-2 control-label no-lpad">
                                <input type="checkbox" name="card_feedback_visibility" value="1" <?php if(form_update_value('card_feedback_visibility') != "") echo "checked"; ?> class="form-check-input"> Visibility
                            </div>
                        </div>
                    </div>
                    <!-- Tenth Step -->

                    <!-- Eleventh Step -->
                    <div id="progress-eleventh" class="step">
                        <div class="row text-center"><h4><strong>Order of Sections</strong></h4><br></div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <ul id="sortable">
                                <?php foreach($card_order as $o) { ?>
                                    <li class="ui-state-default"><span>&#x21C5;</span><input type="hidden" name="<?php echo $o; ?>"/><?php echo ucwords(str_replace('_', ' ', $o)); ?></li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- END Eleventh Step -->

                    <!-- Form Buttons -->
                    <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="reset" class="btn btn-effect-ripple btn-danger" id="back">Back</button>
                            <button type="submit" class="btn btn-effect-ripple btn-primary" id="next">Next</button>
                        </div>
                    </div>
                    <!-- END Form Buttons -->
                </form>
                <!-- END Progress Bar Wizard Content -->
            </div>
            <!-- END Progress Bar Wizard Block -->
        </div>

        <div class="col-sm-10 col-md-4 col-lg-4">
            <div class="mobileframe">
                <iframe name="update_frame" width="100%" height="500" style="border:none" src="?preview" loading="lazy"></iframe>
            </div>
	</div>
    </div>
</div>
<!-- END Page Content -->

<?php include('assets\inc\page_footer.php'); ?>
<?php include('assets\inc\template_scripts.php'); ?>

<!-- Load and execute javascript code used only in this page -->
<script src="<?php echo $settings['url_assets']; ?>libs/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo $settings['url_assets']; ?>libs/typeahead.js"></script>
<script src="<?php echo $settings['url_assets']; ?>js/plugins/ckeditor/ckeditor.js"></script>
<script>var url = '<?php echo $settings['url']; ?>';</script>
<script src="<?php echo $settings['url_assets']; ?>js/image-upload.js"></script>

<script>
var FormsWizard = function() {

    return {
        init: function() {
            $('#progress-wizard-card').formwizard({
                disableUIStyles: true,
                validationEnabled: true,
                focusFirstInput: true,
                validationOptions: {
                    errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                    errorElement: 'span',
                    errorPlacement: function(error, e) {
                        e.parents('.form-group > div').append(error);
                    },
                    highlight: function(e) {
                        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.help-block').remove();
                    },
                    success: function(e) {
                        // You can use the following if you would like to highlight with green color the input after successful validation!
                        e.closest('.form-group').removeClass('has-success has-error'); // e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                        e.closest('.help-block').remove();
                    },
                    rules: {
                        'card_template_1': {
                            required: true
                        },
                    },
                    messages: {
                        'card_template_1': {
                            required: 'Please select a templte'
                        },
                    }
                },
                inDuration: 0,
                outDuration: 0
            });

            // Get the progress bar and change its width when a step is shown
            var progressBar = $('#progress-bar-wizard-card');
            progressBar
                .css('width', '1%')
                .attr('aria-valuenow', '1');

            $("#progress-wizard-card").bind('step_shown', function(event, data){
                if (data.currentStep === 'progress-first') {
                    progressBar
                        .css('width', '1%')
                        .attr('aria-valuenow', '1')
                        .removeClass('progress-bar-info progress-bar-success')
                        .addClass('progress-bar-danger');
                }
                else if (data.currentStep === 'progress-second') {
                    progressBar
                        .css('width', '10%')
                        .attr('aria-valuenow', '10')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-third') {
                    if(document.getElementById('card_logo_inp').value == "") {
                        $('#progress-wizard-card').formwizard("back");
                        alert('Image is required!');
                    }
                    progressBar
                        .css('width', '20%')
                        .attr('aria-valuenow', '20')
                        .removeClass('progress-bar-danger progress-bar-info')
                        .addClass('progress-bar-success');
                }
                else if (data.currentStep === 'progress-fourth') {
                    progressBar
                        .css('width', '30%')
                        .attr('aria-valuenow', '30')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-fifth') {
                    progressBar
                        .css('width', '40%')
                        .attr('aria-valuenow', '40')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-sixth') {
                    progressBar
                        .css('width', '50%')
                        .attr('aria-valuenow', '50')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-seventh') {
                    progressBar
                        .css('width', '60%')
                        .attr('aria-valuenow', '60')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-eighth') {
                    progressBar
                        .css('width', '70%')
                        .attr('aria-valuenow', '70')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-ninth') {
                    progressBar
                        .css('width', '80%')
                        .attr('aria-valuenow', '80')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-tenth') {
                    progressBar
                        .css('width', '90%')
                        .attr('aria-valuenow', '90')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-eleventh') {
                    progressBar
                        .css('width', '95%')
                        .attr('aria-valuenow', '95')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
            });
        }
    };
}();
$(function(){ 
        FormsWizard.init(); 
});
</script>
<script>
// INPUT CHECK

$(document).ready(function() {
    $("body").on("change", "input, select, textarea", function() {
        $("input, select, textarea").attr('disabled', false);
        var f = $('#progress-wizard-card');
	var tgt = f.attr('target'), act = f.attr('action');
        f.attr('target',"update_frame");
        f.attr('action',"?preview");
        document.getElementById(f.attr('id')).submit();
        f.attr('target', '');
        f.attr('action', '');
    });
    $($("input")[0]).change();
});

// TEMPLATE SELECTION

$(document).ready(function() {
    $(".template-labels input:radio").change(function() {
        $(".template-image").removeClass("focus");
        $("#"+$(this).attr('id')+"-image").addClass("focus");
    });
});

// MULTIPLE TAG SELECTION SUGGESTIONS
var citynames = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: {
    url: '../assets/js/citynames.json?=1',
    filter: function(list) {
      return $.map(list, function(cityname) {
        return { name: cityname }; });
    }
  }
});
citynames.initialize();

$('#card_company_specialities').tagsinput({
  typeaheadjs: {
    name: 'citynames',
    displayKey: 'name',
    valueKey: 'name',
    source: citynames.ttAdapter()
  }
});

// MULTIPLE TAG SELECTION SUGGESTIONS NATURE
var natures = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: {
    url: '../assets/js/nature.json?=1',
    filter: function(list) {
      return $.map(list, function(nature) {
        return { name: nature }; });
    }
  }
});
natures.initialize();

$('#card_company_nature').tagsinput({
  typeaheadjs: {
    name: 'nature',
    displayKey: 'name',
    valueKey: 'name',
    source: natures.ttAdapter()
  }
});


// SORTING SECTIONS
sort_ul = $('#sortable');
itemsCount = $('#sortable li').length;

function updateIndexes(){
    $('li input').each(function(i){
              $(this).val(i+1);
          });
    $($("input")[0]).change();
}

updateIndexes();
         
sort_ul.sortable({handle:'span',
                  stop:function(event,ui){ updateIndexes(); }
});

$('li input').keyup(function(event) {
  if(event.keyCode == '13'){      
    event.preventDefault();
      
    order = parseInt($(this).val());
      
    li = $(this).parent();
    if(order>=1 && order <= itemsCount){      
        
        li.effect('drop', function(){
            li.detach();
                
            if(order == itemsCount)
                sort_ul.append(li);
            else
                li.insertBefore($('#sortable li:eq('+(order-1)+')'));
            
            updateIndexes();
            li.effect('slide');
        });
    }else{
        li.effect('highlight');
    }
  }    
});

var fixmeTop = $('.mobileframe').offset().top;       // get initial position of the element

$(window).scroll(function() {                  // assign scroll event listener
    var viewportWidth = $(window).width();
    if (viewportWidth < 768) {
         return;
    }
    var currentScroll = $(window).scrollTop(); // get current position

    if (currentScroll >= fixmeTop) {           // apply position: fixed if you
        $('.mobileframe').css({                      // scroll to that element or below it
            position: 'fixed',
            top: '0',
            right: 'calc(16.665% - 200px)'
        });
    } else {                                   // apply position: static
        $('.mobileframe').css({                      // if you scroll above it
            position: 'static'
        });
    }

});

</script>

<?php include('assets\inc\template_end.php'); ?>