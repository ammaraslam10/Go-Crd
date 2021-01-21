
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="shortcut icon" type="image/png" href="<?php echo $settings['url']; ?>homepage_assets/images/favicon.png">
    <title>Franchisee</title>
	<style>
		.login,
		.image {
		  min-height: 100vh;
		}

		.bg-image {
		 /** background-image: url('https://res.cloudinary.com/mhmd/image/upload/v1555917661/art-colorful-contemporary-2047905_dxtao7.jpg');**/
		  background-image: url('<?php echo $settings['url']; ?>homepage_assets/images/bg_admin_login.jpg');
		  background-size: cover;
		  background-position: center center;
		}
		.custom-size{
			font-size:16px;
		}
	</style>
  </head>
<body>
<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 d-none d-md-flex bg-image">
	<!--	<h3 class="display-4" style="font-size: 44px;color: white;text-align: center;padding: 180px 3px 4px 190px;"><img src="../franchisee-login/images/Logo.png" width="200" height="65" alt="image"></h3> -->
		</div>

        <!-- The content half -->
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center">
                <!-- Demo content-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 mx-auto">
                            <form action="" method="post" autocomplete="off" id="login">
								<h2 class="display-4" style="font-size:42px;">Franchisee Login</h2></br>
								<p>Use your registered email and password to access Franchisee Dashboard</p>
								<div class="form-group mb-3">
									<input type="text" name="f_user_id" placeholder="Enter Email id or Mobile Number" autocomplete="on" required class="form-control rounded-pill border-0 shadow-sm px-4">
								</div>
								<div class="form-group mb-3">
									<input type="password" name="f_user_password" placeholder="Password" autocomplete="off" required class="form-control rounded-pill border-0 shadow-sm px-4">
								</div>
								<input type="submit" name="login_user" value="Login" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">							
								</br>
							<!--	<a id="register_en" class="display-4 custom-size">New User? Register. </a>&nbsp;-->
								<a id="forgot_p" class="display-4 custom-size">Forgot Password?</a> &nbsp;&nbsp;
								<a href="../login" class="text-right">Login As Customer</a>
								<br>
							</form>
							
							<form action="" method="post" autocomplete="off" id="register" style="display:none;">
								<h2 class="display-4" style="font-size:42px;">Create An Account</h2></br>
								<p>Create an account with your email id and password to create your digital visiting card</p>
								<div class="form-group mb-3">
									<input type="text" name="f_user_name" placeholder="Enter Name" autocomplete="" class="form-control rounded-pill border-0 shadow-sm px-4" required>
								</div>
								<div class="form-group mb-3">
									<input type="email" name="f_user_email" placeholder="Enter Email" autocomplete="" class="form-control rounded-pill border-0 shadow-sm px-4" required>
								</div>
								<div class="form-group mb-3">
									<input type="text" name="f_user_contact" maxlength="10" min="4555555555" placeholder="Enter Mobile Number" autocomplete="off" class="form-control rounded-pill border-0 shadow-sm px-4" required>
								</div>
								<div class="form-group mb-3">
									<input type="password" name="f_user_password" placeholder="New Password" autocomplete="off" class="form-control rounded-pill border-0 shadow-sm px-4" required>
								</div>
								<input type="submit" name="register" value="Create Account" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">
								</br>
								<a id="login_en" class="display-4 custom-size">Existing User? Click to Login</a>&nbsp;&nbsp;
								<a id="forgot_p" class="display-4 custom-size">Forgot Password?</a>
								<br>
							</form>
							
							<form action="" method="post" autocomplete="off" id="forgot_pass" style="display:none;">
								
								<h2 class="display-4" style="font-size:42px;">Forgot Password?</h2></br>
								<p>Mention Email id, you will receive an email with password.</p>
								<div class="form-group mb-3">
									<input type="email" name="f_user_email" placeholder="Enter Email" autocomplete="on" class="form-control rounded-pill border-0 shadow-sm px-4" required>
								</div>
								<input type="submit" name="forgot_password" value="Send Password" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm" >
								</br>
								<a id="login_en" href="" class="display-4 custom-size">Go Back to Login</a>&nbsp;
								<a id="forgot_p" class="display-4 custom-size">Forgot Password?</a>
								<br>
							</form></br>
							<?php
								

								if(isset($_POST['login_user'])){
									//print_r($_POST);
									if($settings['su_email']==$_POST['f_user_id'] && $settings['su_password']==$_POST['f_user_password']){
										$_SESSION['type'] = "su";
										$_SESSION['email'] = $settings['su_email'];
										echo success('Login Success, Redirecting...');
												
										//print_r($_SESSION['f_user_email']);
										//print_r($row['f_user_email']);
										echo '<meta http-equiv="refresh" content="0;URL=../super_admin/">';
										exit();
									}
									global $db;
									$key = protect($_POST['f_user_id']);
									$password  = protect($_POST['f_user_password']);
									$loginQuery = $db->query("SELECT * FROM admin WHERE email='$key' or contact='$key'");
									
									if($loginQuery->num_rows>0){
										//login function
										$row = $loginQuery->fetch_assoc();
										
										if($row['password']==$password){
											
											// form display none
										
											if($row['is_active']=="1"){
												$_SESSION['id']=$row['id'];
												$_SESSION['type']=$row['admin'];
												echo success('Login Success, Redirecting...');
												
												
												echo '<meta http-equiv="refresh" content="0;URL=index.php">';
												exit();
											}
											else {
												echo error('<strong>Sorry!</strong> Your account is not Active/Verified. Please contact our Support for help.<br><a href="https://'.$settings['url'].'index.php#contact"><b>Click here </b></a>');
											}
										}else {
											echo error('Password Wrong! Try Again. If you forgot your password then <br><a href="'.$settings['url'].'index.php#contact"><b>Click here </b></a>');
										}
										
									}else {
										echo error('User Does Not Exists. Contact us on info@gocrd.in for new account request. <br><a href="'.$settings['url'].'index.php#contact"><b>Click here </b></a>');
									}
								}
	
								// register -----------------------------------------------------------------------------

								if(isset($_POST['register'])){
									$query=mysqli_query($connect,'SELECT * FROM franchisee_login WHERE f_user_email="'.$_POST['f_user_email'].'"  ');
									if(mysqli_num_rows($query)==0){
										

											$token=rand(100000000,99999999999);
												
											$insert=mysqli_query($connect,'INSERT INTO franchisee_login (f_user_name,f_user_email,f_user_password,f_user_contact,f_user_active,f_user_token) VALUES ("'.$_POST['f_user_name'].'","'.$_POST['f_user_email'].'","'.$_POST['f_user_password'].'","'.$_POST['f_user_contact'].'","NO","'.$token.'")');
											
											
											if($insert){
												
												// form display none
												echo '<style> form {display:none;} </style>';
												echo '<div style="font-size:13px;" class="alert alert-success">Verification Email has been sent to your email '.$_POST['f_user_email'].'. Please click on that and verify your email address. (Check your Junk/Spam folder if email does not show in Inbox)</div>';
												
												
												// email script				
										

													//$to = $_POST['f_user_email'];
													$to = 'qaisarhameed999@mail.com';
													$subject = "Email Varification Link";

													 $message = '
													Hi Dear,

													Please click on this link to verify your email on '.$_SERVER['HTTP_HOST'].' (Digital Visiting Card).<br><br><br>
													<a href="https://'.$_SERVER['HTTP_HOST'].'/panel/franchisee-login/verify.php?email='.$_POST['f_user_email'].'&token='.$token.'" style="background: #00a1ff;   color: white;   padding: 10px;">Click here to verify</a><br><br><br>
													Or click on this link to verify https://'.$_SERVER['HTTP_HOST'].'/panel/franchisee-login/verify.php?email='.$_POST['f_user_email'].'&token='.$token.'


													Thanks<br>
													'.$_SERVER['HTTP_HOST'].'

													';

														// Always set content-type when sending HTML email
														$headers = "MIME-Version: 1.0" . "\r\n";
														$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

														// More headers
														$headers .= 'From: <info@gocrd.in>' . "\r\n";
														
														if(mail($to,$subject,$message,$headers)){
															echo '<div style="font-size:13px;" class="alert alert-success" id="login_en">Verification Link sent to your email '.$_POST['f_user_email'].'. Click on that link to verify your account.</div>';
																			
																			
														}else {
															echo '<div style="font-size:13px;" class="alert alert-danger">Error Email! try again</div>';
														}
												// email script end 	
										
											}else {
													echo '<div class="alert danger">Failed! try again</div>';
												}
											
									}else {
										echo '<div style="font-size:13px;" class="alert alert-info" id="login_en">Account Already Created! Check your email if not verified or Login.</div>';
											
									}
								}
								// register end -------------------------------------------------------------

?>



<?php

if(isset($_POST['forgot_password'])){
	$query=mysqli_query($connect,'SELECT * FROM franchisee_login WHERE f_user_email="'.$_POST['f_user_email'].'" ');
	$row=mysqli_fetch_array($query);
		if(mysqli_num_rows($query)>>0){
			
			// email script				

				$to = $_POST['f_user_email'];
$subject = $_SERVER['HTTP_HOST']." Password ";

 $message = '
Hi Dear,

Your Password is: '.$row['f_user_password'].'
to login on '.$_SERVER['HTTP_HOST'].'/panel/franchisee-login/login.php

Thanks
'.$_SERVER['HTTP_HOST'].'

';

						$headers= 'From: <info@gocrd.in>';
						if(mail($to,$subject,$message,$headers)){
							echo '<div style="font-size:13px;" class="alert alert-success" id="login_en">Password is sent to your email '.$_POST['f_user_email'].'. Check Junk or Spam folder also if not available in Inbox.</div>';
											
											
						}else {
							echo '<div class="alert alert-danger">Error Email! try again</div>';
						}
			
		}else {echo '<div style="font-size:13px;" class="alert alert-danger" id="login_en">Account Does Not Exists! Please check email or Create new account.</div>';}
}

?>

                        </div>
						
                    </div>
                </div><!-- End -->

            </div>
			
        </div><!-- End -->

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

	$( document ).ready(function() {
		//$('#register').hide();
		//$('#forgot_pass').hide();
	});
	$('#register_en').on('click',function(){
		$('#login').hide();
		$('#register').show();
		$('#forgot_pass').hide();
		
	})
	$('#login_en').on('click',function(){
		$('#register').hide();
		$('#forgot_pass').hide();
		$('#login').show();
	})
	$('#forgot_p').on('click',function(){
		$('#forgot_pass').show(); 
		$('#register').hide();
		$('#login').hide();
		
	})
	

</script>

<!-- Material form subscription -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>