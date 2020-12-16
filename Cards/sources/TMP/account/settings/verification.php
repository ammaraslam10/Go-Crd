<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

if(!checkSession()) {
    $redirect = $settings['url']."login";
    header("Location: $redirect");
}   

if($settings['require_document_verify'] !== "1") {
    $redirect = $settings['url']."account/summary";
    header("Location: $redirect");
}
?>
<!doctype html>
<html lang="en" class="deeppurple-theme">


<!--Crypto Wallet -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="icrypto">

    <title>Settings</title>

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
        #choose_button{
             position: absolute;
             top: 46%;
             left: 37%;
             height: 15%;
             width: 26%;
             display: block;
             z-index: 1;
             opacity: 0;
             border: 0px solid;
             border-radius: 100%;
             cursor: pointer;
        }
        @media(max-width:425px){
            #choose_button{
                left: 24%;
                width: 52%;
                z-index: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div class="row no-gutters vh-100 loader-screen">
        <div class="col align-self-center text-white text-center">
            <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo.png" alt="logo">
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
    
    <!-- sidebar -->
    <?php include('includes/sidebar.php'); ?>
    <!-- sidebar ends -->
    
    <div class="wrapper">
        <!-- header -->
        <?php include('includes/header.php'); ?>
        <!-- header ends -->
        
        <div class="container">            
            <div class="row mt-3">
                <div class="col text-center">
                    <h3><?php echo $lang['head_verification']; ?></h3>
                    <hr/>
                    <?php 
                    if(idinfo($_SESSION['pw_uid'],"document_verified") == "1") {
                        echo success("Your account is verified");
                    } else {
                        echo error($lang['error_22']);
                    }
                    ?>
                    <p><?php echo $lang['head_verification_info']; ?></p>
                    <br>
                    <div class="card">
                        <div class="card-body">
                            <h4><?php echo $lang['upload_document']; ?></h4>
                            <?php
                            $FormBTN = protect($_POST['pw_upload']);
                            if($FormBTN == "upload") {
                                $document_type = protect($_POST['document_type']);
                                $document_number = protect($_POST['document_number']);
                                $extensions = array('jpg','jpeg','png'); 
                                $fileextension = end(explode('.',$_FILES['uploadFile']['name'])); 
                                $fileextension = strtolower($fileextension); 
                                $maxfilesize = '5242880'; // 5MB
                                if(empty($document_type)) {
                                    echo error($lang['error_23']);
                                } elseif(empty($document_number)) {
                                    echo error($lang['error_24']);
                                } elseif(empty($_FILES['uploadFile']['name'])) {
                                    echo error($lang['error_25']);
                                } elseif(!in_array($fileextension,$extensions)) { 
                                    echo error($lang['error_26']); 
                                } elseif($_FILES['uploadFile']['size'] > $maxfilesize)  {
                                    echo error($lang['error_27']);
                                } else {
                                    $secure_directory = PW_secure_directory();
                                    if(!is_dir("./".$secure_directory)) {
                                        mkdir("./".$secure_directory,0777);
                                        $file_htaccess = 'order deny,allow,deny from all,allow from 127.0.0.1';
                                        file_put_contents("./".$secure_directory."/.htaccess",$file_htaccess);
                                    }
                                    $upload_file = $secure_directory.'/'.$_SESSION[pw_uid];
                                    if(!is_dir($upload_file)) {
                                        mkdir("./".$upload_file,0777);
                                    }
                                    $upload_file = $upload_file.'/'.randomHash(20).'.'.$fileextension;
                                    @move_uploaded_file($_FILES['uploadFile']['tmp_name'],$upload_file);
                                    $time = time();
                                    $insert = $db->query("INSERT pw_users_documents (uid,document_type,document_path,uploaded,status,u_field_1) VALUES ('$_SESSION[pw_uid]','$document_type','$upload_file','$time','1','$document_number')");
                                    $msg = success($lang['success_12']);
                                    //$msg = $msg;
                                    //$qs = success('Would you like to upload another document?<br>');
                                    
                                    //send notification to admin
                                    $to = $settings['infoemail'];
                                    $subject = "A user submitted documents in ".$settings['name'];
                                    $text = 'The user '.idinfo($_SESSION[pw_uid],"email").' submitted a new document.';
                                    $link = $settings['url'].'admin/?a=users&b=edit&id='.$_SESSION[pw_uid];
                                    PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                                    
                                    $prompt = PW_GetDocumentPrompt();
                                    $_SESSION['msg'] = $msg.'<b>Would you like to submit another document?</b>'.$prompt;
                                    $_SESSION['msg_type'] = "Upload Documents";
                                    $redirect = $settings['url']."account/summary";
                                    $_SESSION['limit_reached']=true;
                                    header("Location: $redirect");
                                }
                            }
                            ?>
                            <form class="user-connected-from user-signup-form" action="" method="POST" enctype="multipart/form-data">
                                <div class="row form-group">
                                    <div class="col">
                                        <label><?php echo $lang['field_18']; ?></label>
                                        <select class="form-control form-control-lg" name="document_type">
                                            <option></option>
                                            <option value="1"><?php echo $lang['doc_type_1']; ?></option>
                                            <option value="2"><?php echo $lang['doc_type_2']; ?></option>
                                            <option value="3"><?php echo $lang['doc_type_3']; ?></option>
                                            <option value="4"><?php echo $lang['doc_type_4']; ?></option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label><?php echo $lang['field_19']; ?></label>
                                        <input type="text" class="form-control" name="document_number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="attach_file"><?php echo $lang['field_20']; ?></label><br>
                                    <div class="btn btn-dark text-white btn btn-default btn-lg btn-rounded shadow">
                                        <i class="material-icons">cloud_upload</i>Choose File
                                    <input type="file" class="float-file" onchange="file_changed()" id="choose_button" name="uploadFile"></div><br><br>
                                    <small><?php echo $lang['field_20_info']; ?></small>
                                </div>
                                <!--<div class="form-group">
                                    <label><?php echo $lang['field_20']; ?></label>
                                    <input type="file" class="form-control" name="uploadFile">
                                    <small><?php echo $lang['field_20_info']; ?></small>
                                </div>-->
                                <button type="submit" name="pw_upload" value="upload" class="btn btn-default btn-lg btn-rounded shadow btn-block" style="padding:12px;"><?php echo $lang['btn_19']; ?></button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td width="25%"><?php echo $lang['date']; ?></td>
                                    <td width="25%"><?php echo $lang['document_number']; ?></td>
                                    <td width="25%"><?php echo $lang['status']; ?></td>
                                    <td width="25%"><?php echo $lang['comment']; ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $GetDocuments = $db->query("SELECT * FROM pw_users_documents WHERE uid='$_SESSION[pw_uid]' ORDER BY id");
                                if($GetDocuments->num_rows>0) {
                                    while($get = $GetDocuments->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo date("d M Y H:i",$get['uploaded']); ?></td>
                                            <td><?php echo $get['u_field_1']; ?><br/>(<?php if($get['document_type'] == "1") { echo $lang['doc_type_1']; } elseif($get['document_type'] == "2") { echo $lang['doc_type_2']; } elseif($get['document_type'] == "3") { echo $lang['doc_type_3']; } elseif($get['document_type'] == "4") { echo $lang['doc_type_4']; } else { echo 'Unknown'; } ?>)</td>
                                            <td>
                                                <?php
                                                if($get['status'] == "1") { echo '<span class="badge badge-warning">'.$lang[status_doc_1].'</span>'; }
                                                elseif($get['status'] == "2") { echo '<span class="badge badge-danger">'.$lang[status_doc_2].'</span>'; } 
                                                elseif($get['status'] == "3") { echo '<span class="badge badge-success">'.$lang[status_doc_3].'</span>'; }
                                                else {
                                                    echo '<span class="badge badge-default">'.$lang[status_unknown].'</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php if($get['u_field_5']) { echo $get['u_field_5']; } ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="4">'.$lang[info_5].'</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
            </div>
                </div>
            </div>
        </div>
        <!-- footer-->
        <?php include('includes/footer.php'); ?>
        <!-- footer ends-->
    </div>

    
    
    <!-- color chooser menu start -->
    <div class="modal fade " id="colorscheme" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header theme-header border-0">
                    <h6 class="">Color Picker</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center theme-color">
                        <button class="m-1 btn red-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="red-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn blue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="blue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn yellow-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="yellow-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn green-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="green-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn pink-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="pink-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn orange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="orange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn purple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="purple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeppurple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeppurple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lightblue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lightblue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn teal-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="teal-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lime-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lime-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeporange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeporange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn gray-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="gray-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn black-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="black-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-6 text-left">
                        <div class="row">
                            <div class="col-auto text-right align-self-center"><i class="material-icons text-warning vm">wb_sunny</i></div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="themelayout" class="custom-control-input" id="theme-dark">
                                    <label class="custom-control-label" for="theme-dark"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center"><i class="material-icons text-dark vm">brightness_2</i></div>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="row">
                            <div class="col-auto text-right align-self-center">LTR</div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="rtllayout" class="custom-control-input" id="theme-rtl">
                                    <label class="custom-control-label" for="theme-rtl"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center">RTL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- color chooser menu ends -->


    <!-- jquery, popper and bootstrap js -->
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
        function file_changed(){
              /*var selectedFile = document.getElementById('changeimage_input').files[0];
              var img = document.getElementById('dp')
              var reader = new FileReader();
              reader.onload = function(){
                 img.src = this.result
              }
              reader.readAsDataURL(selectedFile);*/
              document.getElementById("attach_file").innerHTML = "File Attached";
            }

    </script>
</body>


<!--Crypto Wallet -->
</html>