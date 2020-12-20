<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/slick.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/responsive.css">
  <title><?php echo $lang['title_contacts']; ?> - <?php echo $settings['name']; ?></title>
  <meta name="description" content="<?php echo $settings['description']; ?>">
  <meta name="keywords" content="<?php echo $settings['keywords']; ?>">
  <meta name="author" content="CryptoExchanger">
</head>
<body>
    <div class="subheader">
        <?php 
        if(checkSession()) {
            include("menu_logged.php"); 
        } else {
            include("menu_notlogged.php");
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="subheader-wrapper">
                        <h3><?php echo $lang['head_contacts']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- user-login-signup-section -->

    <div class="contact-form-section">
        <div class="container">
            <div class="row">
                <div class="offset-lg-3 col-lg-6 offset-md-1 col-md-9">
                    <div class="contact-form-wrap">
                        <?php
                        $FormBTN = protect($_POST['pw_send']);
                        if($FormBTN == "message") {
                            $name = protect($_POST['name']);
                            $email = protect($_POST['email']);
                            $subject = protect($_POST['subject']);
                            $message = protect($_POST['message']);
                            if(empty($name) or empty($email) or empty($subject) or empty($message)) {
                                echo error($lang['error_20']);
                            } elseif(!isValidEmail($email)) {
                                echo error($lang['error_34']);
                            } else {
                                $mail = new PHPMailer;
                                $mail->isSMTP();
                                $mail->SMTPDebug = 0;
                                $mail->Host = $smtpconf["host"];
                                $mail->Port = $smtpconf["port"];
                                $mail->SMTPAuth = $smtpconf['SMTPAuth'];
                                $mail->Username = $smtpconf["user"];
                                $mail->Password = $smtpconf["pass"];
                                $mail->setFrom($email, $name);
                                $mail->addAddress($settings['supportemail'], $settings['supportemail']);
                                //Set the subject line
                                $lang = array();
                                $mail->Subject = $subject;
                                $mail->msgHTML($message);
                                //Replace the plain text body with one created manually
                                $mail->AltBody = $message;
                                //Attach an image file
                                //send the message, check for errors
                                $send = $mail->send();
                                if($send) { 
                                    echo success($lang['success_17']);
                                } else {
                                    echo error($lang['error_35']);
                                }
                            }
                        }
                        ?>
                        <form class="contact-form" action="" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" id="" name="name" placeholder="<?php echo $lang['placeholder_7']; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" id="" name="email" placeholder="<?php echo $lang['placeholder_8']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" placeholder="<?php echo $lang['placeholder_9']; ?>">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" name="message" id="comment" placeholder="<?php echo $lang['placeholder_10']; ?>"></textarea>
                            </div>
                            <button type="submit" name="pw_send" value="message" class="btn btn-default"><?php echo $lang['btn_26']; ?></button>
                        </form>
                    </div>
                </div>
            </div>
    </div>  
    </div><!-- contact-section -->


    <?php include("footer.php"); ?>

    <script src="<?php echo $settings['url']; ?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/slick.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/jquery.peity.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/custom.js"></script>
</body>
</html>