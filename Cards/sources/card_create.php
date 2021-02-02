<?php include('assets/inc/config.php'); $template['header_link'] = 'Create a Card'; ?>

<?php
include('includes/default_array_lists.php');
$error = []; 
if(isset($_POST['card_url']))
{
	$card_order = ['card_company_position','card_social_position',
	'card_payment_position','card_products_position','card_offers_position',
	'card_gallery_position','card_feedback_position','card_additional_position'];
	$card_template = clean($db, $_POST['card_template']);
	$card_logo = clean($db, $_POST['card_logo']);
	$card_url = clean($db, $_POST['card_url']);
	$card_company_name = clean($db, $_POST['card_company_name']);
	$card_company_whatsapp = clean($db, $_POST['card_company_whatsapp']);
	$card_company_country = clean($db, $_POST['card_company_country']);
	$card_company_address = clean($db, $_POST['card_company_address']);
	$card_company_email = clean($db, $_POST['card_company_email']);
	if(isset($_GET['preview'])) 
	{
		$_GET['preview'] = true;
		include('card_view.php');
		exit;
	}

	if(!preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['card_company_email']))
	{
		$errors[] = "Invalid Email";
	}
	if(preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $card_url) === false) 
	{
		$errors[] = "Invalid URL";
	}
	$urls = mysqli_fetch_array(mysqli_query($db, 'select id from card where card_link="'.$card_url.'"'));
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
        //if$uid = $_SESSION['id']; //$_SESSION['uid'] //if is admin =1, then uid = admin id;

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
        
		if(mysqli_query($db, 'insert into card (email, company, card_link, template, design, creator, user_email, is_admin) values ("'.$card_email.'", "'.$card_company_name.'","'.$card_url.'","'.$card_template.'","","'.$uid.'","'.$card_company_email.'","'.$is_admin.'")')) {
			$id = mysqli_insert_id($db);
			$card_logo = strtok($_SERVER['DOCUMENT_ROOT'] . '/' . $settings['path'] . $card_logo, '?');
			$card_logo_new = $_SERVER['DOCUMENT_ROOT'] . $settings['upload_dir'] . $uid . '_' . $id . '_logo.jpg';
			rename($card_logo, $card_logo_new);
			mysqli_query($db, 'insert into card_company (card_id, name, whatsapp, address, email, country) values ("'.$id.'", "'.$card_company_name.'", "'.$card_company_whatsapp.'","'.$card_company_address.'","'.$card_company_email.'", "'.$card_company_country.'")');
			mysqli_query($db, 'insert into card_feedback (card_id) values ("'.$id.'")');
			mysqli_query($db, 'insert into card_gallery (card_id,url) values ("'.$id.'","")');
			mysqli_query($db, 'insert into card_payment (card_id) values ("'.$id.'")');
			mysqli_query($db, 'insert into card_social_media (card_id) values ("'.$id.'")');
			mysqli_query($db, 'insert into card_offers_section (card_id, title) values ("'.$id.'", "~locator")');
			mysqli_query($db, 'insert into card_product_information (card_id, title) values ("'.$id.'", "~locator")');
			mysqli_query($db, 'insert into card_additional (card_id,heading) values ("'.$id.'", "~locator")');
			header('Location: edit-card/'.$id);
		} else {
			$errors[] = "Database error, contact Admin.".mysqli_error($db);
		}
	}
} else if(isset($_GET['preview'])) {
	echo "Preview will appear here";
	exit;
}
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
                <form class="ImageUploadAJAX" id="imup1" method="post" enctype="multipart/form-data" action="image-upload">
                     <input type="hidden" name="type" value="card_logo" />
                     <input type="hidden" name="card_id" value="temp" />
                </form>
                <div id="update_form_div"style="display:none;"></div>
                <form id="progress-wizard-card" method="post" class="form-horizontal form-bordered">
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
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_url">URL <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="card_url" name="card_url" class="form-control" placeholder="http://gocrdz.com/URL" <?php echo form_post_value('card_url'); ?> required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Select a Template <span class="text-danger">*</span></label>
                            <div class="col-md-6 template-labels">
				<?php for($i = 1; $i < $card_templates_count + 1; $i++){ ?>
                                <input type="radio" id="template-<?php echo $i; ?>" name="card_template" class="hidden" <?php if($i == 1 && !isset($_POST['card_template'])) echo "checked"; echo form_post_value_checked('card_template', $i); ?> value="<?php echo $i; ?>" required />
                                <label class="col-md-4 control-label" for="template-<?php echo $i; ?>">
                                    <img id="template-<?php echo $i; ?>-image" src="<?php echo $settings['url_assets'] ?>img/card_mobile_template-<?php echo $i; ?>.png" class="template-image img-fluid img-thumbnail <?php if(form_post_value_selected('card_template', $i) != "" || ($i == 1 && !isset($_POST['card_template']))) echo "focus"; ?>" />
                                </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- END First Step -->

                    <!-- Second Step -->
                    <div id="progress-second" class="step">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_logo">Card Logo <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="file" id="card_logo" class="ImageBrowse" data-form="imup1" />
                                <input type="hidden" name="card_logo" id="card_logo_inp" class="ImageReturn" <?php echo form_post_value('card_logo'); ?> required />
				<img class="ImageDisplay img-fluid img-thumbnail" <?php if(form_post_value('card_logo') != "") echo 'src="'.$settings['url'].$_POST['card_logo'].'"'; ?> />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_name">Company Name <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_name" name="card_company_name" class="form-control" <?php echo form_post_value('card_company_name'); ?> required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_whatsapp">Whatsapp Phone Number <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_whatsapp" name="card_company_whatsapp" class="form-control" <?php echo form_post_value('card_company_whatsapp'); ?> required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_country">Country <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select id="card_company_country" name="card_company_country" class="form-control" required>
					<option value="">Select</option>
					<?php for($i = 0; $i < sizeof($country_array); $i++){ ?>
					<option <?php echo form_post_value_selected('card_company_country', $country_array[$i]); ?> value="<?php echo $country_array[$i]; ?>">
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
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_address">Address <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" id="card_company_address" name="card_company_address" class="form-control" <?php echo form_post_value('card_company_address'); ?> />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="card_company_email">Email <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="email" id="card_company_email" name="card_company_email" class="form-control" <?php echo form_post_value('card_company_email'); ?>/>
                            </div>
                        </div>
                    </div>
                    <!-- END Third Step -->

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
    <!-- END Wizards Content -->
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
                            required: 'Please select a template'
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
                        .css('width', '33%')
                        .attr('aria-valuenow', '33')
                        .removeClass('progress-bar-danger progress-bar-success')
                        .addClass('progress-bar-info');
                }
                else if (data.currentStep === 'progress-third') {
                    if(document.getElementById('card_logo_inp').value == "") {
                        $('#progress-wizard-card').formwizard("back");
                        alert('Image is required!');
                    }
                    progressBar
                        .css('width', '66%')
                        .attr('aria-valuenow', '66')
                        .removeClass('progress-bar-danger progress-bar-info')
                        .addClass('progress-bar-success');
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
    $("input, select, textarea").change(function() {
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
    url: 'assets/js/citynames.json',
    filter: function(list) {
      return $.map(list, function(cityname) {
        return { name: cityname }; });
    }
  }
});
citynames.initialize();

$('#card_specialities').tagsinput({
  typeaheadjs: {
    name: 'citynames',
    displayKey: 'name',
    valueKey: 'name',
    source: citynames.ttAdapter()
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