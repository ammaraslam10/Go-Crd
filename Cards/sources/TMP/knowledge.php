<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);
if($b == "articles") {
$id = protect($_GET['id']);
$Check = $db->query("SELECT * FROM pw_knowledge_categories WHERE id='$id'");
if($Check->num_rows==0) {
    $redirect = $settings['url']."knowledge";
    header("Location: $redirect");
}
$c = $Check->fetch_assoc();
?>
<!DOCTYPE html>
<html  lang="en" class="deeppurple-theme" style="cursor: url(&quot;img/logo-cursor.png&quot;), auto;">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title>Support</title>

        <!-- Material design icons CSS -->
        <link rel="stylesheet" href="<?php echo $settings['url']; ?>icrypto_assets/vendor/materializeicon/material-icons.css">

        <!-- Roboto fonts CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

        <!-- Bootstrap core CSS -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">

        <!-- Swiper CSS -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/vendor/swiper/css/swiper.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/css/style.css" rel="stylesheet">
        <style>
        .modal-backdrop {
            z-index:0;
        }
        </style>
    </head>
<body>
<!-- Loader -->
        <div class="row no-gutters vh-100 loader-screen" style="display: none;">
            <div class="col align-self-center text-white text-center">
                <img src="img/logo.png" alt="logo">
                <h1 class="mt-3"><span class="font-weight-light ">Crypto</span>Wallet</h1>
                <p class="text-mute text-uppercase small">Mobile Template</p>
                <div class="laoderhorizontal">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <!-- Loader ends -->

        <?php include('includes/sidebar.php');?>
<div class="wrapper">
<?php include('includes/header.php'); ?>
    <div class="container">
        <div class="col align-self-center px-3 text-center">
                    <br><br>
                    <h3>Support</h3>
                    <br><br>    
                </div>
    <div class="support-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="support-details-tab-nav">
                        <h4><?php echo $c['name']; ?></h4>
                        <nav class="support-list">
                            <ul class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <?php 
                                $query = $db->query("SELECT * FROM pw_knowledge_articles WHERE category_id='$id' ORDER BY id");
                                if($query->num_rows>0) {
                                    $r=1;
                                    while($row = $query->fetch_assoc()) {
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php if($r==1) { echo 'active'; } ?>" href="#article_<?php echo $row['id']; ?>" role="tab" data-toggle="tab">
                                                <?php echo $row['title']; ?>
                                            </a>
                                        </li>
                                        <?php
                                        $r++;
                                    }
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="offset-lg-1 col-lg-8 col-md-8">
                    <div class="tab-content support-details-tab-content-wrap">
                        <?php
                         $query = $db->query("SELECT * FROM pw_knowledge_articles WHERE category_id='$id' ORDER BY id");
                                
                        if($query->num_rows>0) {
                            $i=1;
                            while($row = $query->fetch_assoc()) {
                            ?>
                            <div role="tabpanel" class="tab-pane fade show active <?php if($i==1) { echo 'show active'; } ?>" id="article_<?php echo $row['id']; ?>">
                                <div class="support-details-content">
                                    <h4 class="sp-title"><?php echo $row['title']; ?></h4>
                                    
                                    <div class="support-entry-block">
                                        <?php echo $row['content']; ?>
                                    </div>
                                    
                                </div><!-- support-details-content -->
                            </div>
                            <?php
                            $i++;
                            }
                        }
                        ?>
                    </div><!-- support-details-tab-content-wrap -->
                
                </div>
                <div class="offset-lg-4 col-lg-5 offset-md-2 col-md-8">
                    <div class="qs-answer-section">
                        <h4>Don’t get Answer?</h4>
                        <span>We have a record of answering everything in 3 hours of less.</span>
                            <a href="<?php echo $settings['url']; ?>contacts" class="btn btn-primary btn-lg">E-mail Us</a>
                            
                    </div><!-- qs-answer-section -->
                </div>
            </div>
        </div>
    </div><!-- support-details-section -->


    <?php include("includes/footer.php"); ?>
</div>
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/popper.min.js"></script>
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    <!-- swiper js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/swiper/js/swiper.min.js"></script>

    <!-- cookie js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/cookie/jquery.cookie.js"></script>


    <!-- template custom js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/main.js"></script>

    <!-- page level script -->
    <script>
        $(window).on('load', function() {

        });

    </script>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="en" class="deeppurple-theme" style="cursor: url(&quot;img/logo-cursor.png&quot;), auto;">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title>Support</title>

        <!-- Material design icons CSS -->
        <link rel="stylesheet" href="<?php echo $settings['url']; ?>icrypto_assets/vendor/materializeicon/material-icons.css">

        <!-- Roboto fonts CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

        <!-- Bootstrap core CSS -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">

        <!-- Swiper CSS -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/vendor/swiper/css/swiper.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/css/style.css" rel="stylesheet">
        <style>
        .modal-backdrop {
            z-index:0;
        }
        </style>
    </head>
<body>
    <!-- Loader -->
        <div class="row no-gutters vh-100 loader-screen" style="display: none;">
            <div class="col align-self-center text-white text-center">
                <img src="img/logo.png" alt="logo">
                <h1 class="mt-3"><span class="font-weight-light ">Crypto</span>Wallet</h1>
                <p class="text-mute text-uppercase small">Mobile Template</p>
                <div class="laoderhorizontal">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <!-- Loader ends -->

        <?php include('includes/sidebar.php');?>
<div class="wrapper">
<?php include('includes/header.php'); ?>
    <div class="container">
        <div class="col align-self-center px-3 text-center">
                    <br><br>
                    <h3>Support</h3>
                    <br><br>    
                </div>
        <div class="support-list-section">
                <?php
                $GetKnowledge = $db->query("SELECT * FROM pw_knowledge_categories ORDER BY id");
                if($GetKnowledge->num_rows>0) {
                    while($getk = $GetKnowledge->fetch_assoc()) {
                        ?>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                            <div class="support-list-block">
                                <h5><?php echo $getk['name']; ?></h5>
                                <ul class="support-list">
                                    <?php
                                    $GetArticles = $db->query("SELECT * FROM pw_knowledge_articles WHERE category_id='$getk[id]' ORDER BY Id");
                                    if($GetArticles->num_rows>0) {
                                        while($geta = $GetArticles->fetch_assoc()) {
                                            ?>
                                            <li><a href="<?php echo $settings['url']; ?>knowledge/articles/<?php echo $getk['id']; ?>#article_<?php echo $geta['id']; ?>"><?php echo $geta['title']; ?></a></lI>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <br><br>
                        </div>
                        </div>
                        <?php
                    }
                }
                ?>
                
            
        </div>
    </div>


    <?php include("includes/footer.php"); ?>
    
</div>

    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/popper.min.js"></script>
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    <!-- swiper js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/swiper/js/swiper.min.js"></script>

    <!-- cookie js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/cookie/jquery.cookie.js"></script>


    <!-- template custom js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/main.js"></script>

    <!-- page level script -->
    <script>
        $(window).on('load', function() {

        });

    </script>
</body>
</html>
<?php } ?>