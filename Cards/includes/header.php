<!-- header -->
<?php
$result=$db->query("SELECT count(*) as total from pw_notifications where uid='$_SESSION[pw_uid]' and  is_read='0'");
$data=$result->fetch_assoc();
//print_r($data);
//echo 'abc';
//echo '<script>alert("'.$data['total'].'")</script>';

$now = time(); // Checking the time now when home page starts.
/*if ($now > $_SESSION['expire']) {
    session_destroy();
    $redirect = $settings['url'];
    header("Location: $redirect");
}*/
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > (60 * 30))) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    
    $redirect = $settings['url'];
    header("Location: $redirect");
}
echo '<script>
        setTimeout(function(){window.location.href="'.$settings['url'].'logout'.'"},1000 * 60 * 30);
    </script>';
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>
<style>

</style>
<div class="header">
    <div class="row no-gutters">
        <div class="col-auto">
            <div id="ham_open">
              <svg viewBox="0 0 800 600">
                <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                <path d="M300,320 L540,320" id="middle"></path>
                <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
              </svg>
            </div>
            <?php if($data['total'] > 0){
                echo '<span class="new-notification"></span>';
                $none='';
            }
            else{
                $none='_none';
            }
            ?>
            
        </div>
        <div class="col text-center"><img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo-header.png" alt="" class="header-logo"></div>
        <div class="col-auto">
            <a href="<?php echo $settings['url']; ?>account/notifications" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications<?php echo $none;?></i><span class="counts"><?php echo $data['total'];?></span></a>
        </div>
    </div>
</div>
<!-- header ends -->