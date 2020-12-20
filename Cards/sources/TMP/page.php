<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$prefix = protect($_GET['prefix']);
$query = $db->query("SELECT * FROM pw_pages WHERE prefix='$prefix'");
if($query->num_rows==0) {
    $redirect = $settings['url'];
    header("Location: $redirect");
}
$row = $query->fetch_assoc();
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
  <title><?php echo $row['title']; ?> - <?php echo $settings['name']; ?></title>
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
                        <h3><?php echo $row['title']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- user-login-signup-section -->

    <div class="container">
        <div class="row">
            <div class="col-md-12 prowallet-content-page">
                <?php echo $row['content']; ?>
            </div>
        </div>
    </div>


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