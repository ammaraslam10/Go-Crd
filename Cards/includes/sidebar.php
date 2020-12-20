<style>
        svg {
          width: 54px;
          height: 54px;
          cursor: pointer;
          -webkit-transform: translate3d(0, 0, 0);
          -moz-transform: translate3d(0, 0, 0);
          -o-transform: translate3d(0, 0, 0);
          -ms-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
        }
        path {
          fill: none;
          -webkit-transition: stroke-dashoffset 1s cubic-bezier(0.25, -0.25, 0.75, 1.25), stroke-dasharray 1s cubic-bezier(0.25, -0.25, 0.75, 1.25);
          -moz-transition: stroke-dashoffset 1s cubic-bezier(0.25, -0.25, 0.75, 1.25), stroke-dasharray 1s cubic-bezier(0.25, -0.25, 0.75, 1.25);
          -o-transition: stroke-dashoffset 1s cubic-bezier(0.25, -0.25, 0.75, 1.25), stroke-dasharray 1s cubic-bezier(0.25, -0.25, 0.75, 1.25);
          -ms-transition: stroke-dashoffset 1s cubic-bezier(0.25, -0.25, 0.75, 1.25), stroke-dasharray 1s cubic-bezier(0.25, -0.25, 0.75, 1.25);
          transition: stroke-dashoffset 1s cubic-bezier(0.25, -0.25, 0.75, 1.25), stroke-dasharray 1s cubic-bezier(0.25, -0.25, 0.75, 1.25);
          stroke-width: 40px;
          stroke-linecap: round;
          stroke: #a06ba5;
          stroke-dashoffset: 0px;
        }
        path#top,
        path#bottom {
          stroke-dasharray: 240px 950px;
        }
        path#middle {
          stroke-dasharray: 240px 240px;
        }
        .cross path#top,
        .cross path#bottom {
          stroke-dashoffset: -650px;
          stroke-dashoffset: -650px;
        }
        .cross path#middle {
          stroke-dashoffset: -115px;
          stroke-dasharray: 1px 220px;
        }
        
        #ham_close{
            margin-top: 0%;
            margin-left: -1.2%;
            width: fit-content;
        }
    
        @media (max-width:576px){
            #ham_close{
                margin-top: 0%;
                margin-left: -4%;
                margin-left: -25%;
            }
        }
        .rotate{
            -moz-transition: all 0.5s linear;
            -webkit-transition: all 0.5s linear;
            transition: all 0.5s linear;
        }
        
        .rotate.down{
            -moz-transform:rotate(90deg);
            -webkit-transform:rotate(90deg);
            transform:rotate(90deg);
        }
        .avatar img {
            width: 100%;
            vertical-align: middle;
            position: relative;
            z-index: 1;
            height: -webkit-fill-available;
        }
        textarea.form-control {
            height:50px;
        }
        </style>
        <div class="col-auto" id="close_col" style="display:none;z-index:12;width: fit-content;">
            <!--<button class="btn  btn-link text-light rotate" id="close_button">
                <i class="material-icons">menu</i>
            </button>-->
            <div id="ham_close">
              <svg viewBox="0 0 800 600">
                <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                <path d="M300,320 L540,320" id="middle"></path>
                <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
              </svg>
            </div>
        </div>
        <div class="sidebar">
            <div class="mt-4 mb-3">
                <div class="row">
                    <div class="col-auto">
                        <?php
                        clearstatcache();
                        $target_dir = "uploads/";
                        $target_file = $target_dir.$_SESSION['pw_uid'];
                        $found_image = false;
                        //echo "targer is:".$target_file;
                        if (file_exists($target_file.".jpg")) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.jpg';
                          $file= $target_file.".jpg";
                          $jpg_time = filemtime($target_file.".jpg");
                          $found_image = true;
                          //echo "han jpg h";
                        }
                        if (file_exists($target_file.".png") && (filemtime($target_file.".png") > $jpg_time)) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.png';
                          $png_time = filemtime($target_file.".png");
                          $file= $target_file.".png";
                          $found_image = true;
                           //echo "han jpg2 h";
                        }
                        if (file_exists($target_file.".jpeg") && (filemtime($target_file.".jpeg") > $jpg_time) && (filemtime($target_file.".jpeg") > $png_time)) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.jpeg';
                          $file= $target_file.".jpeg";
                          $found_image = true;
                           //echo "han jpg3 h";
                        }
                        else if(!$found_image)
                        {
                            $img_url = $settings['url'].'uploads/default.jpg';
                        }
                        $img_url= $img_url."?t=".time();
                        ?>
                        <a href="<?php echo $settings['url'].'account/settings/profile'; ?>"><figure class="avatar avatar-60 border-0"><img src="<?php echo $img_url; ?>" alt=""></figure></a>
                    </div>
                    <div class="col pl-0 align-self-center">
                        <a href="<?php echo $settings['url'].'account/settings/profile'; ?>" style="color:white;"><h5 class="mb-1"><?php echo idinfo($_SESSION['pw_uid'],"first_name"); ?> <?php echo idinfo($_SESSION['pw_uid'],"last_name"); ?></h5></a>
                        <p class="text-mute small"><?php echo idinfo($_SESSION['pw_uid'],"city"); ?>, <?php echo idinfo($_SESSION['pw_uid'],"country"); ?></p>
                    </div>
                </div>
            </div>
            <div class="row"> 
                    <div class="swiper-container icon-slide mb-4">
                        <div class="swiper-wrapper">
                            <a href="<?php echo $settings['url']; ?>account/money/send" class="swiper-slide text-center">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons text-template">send</i>
                                </div>
                                <p class="small mt-2" style="color:white;">Send</p>
                            </a>
                            <a href="<?php echo $settings['url']; ?>account/money/withdrawal" class="swiper-slide text-center">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons text-template">remove</i>
                                </div>
                                <p class="small mt-2" style="color:white;">Withdraw</p>
                            </a>
                            <a href="<?php echo $settings['url']; ?>account/money/deposit" class="swiper-slide text-center">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons text-template">add</i>
                                </div>
                                <p class="small mt-2" style="color:white;">Deposit</p>
                            </a>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            <div class="row">
                <div class="col">
                    <div class="list-group main-menu">						
                        <a href="<?php echo $settings['url']; ?>" class="list-group-item list-group-item-action active"><i class="material-icons icons-raised">home</i>Summary</a>
						<a href="<?php echo $settings['url']; ?>account/notifications" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">notifications</i>Notifications</a>
                        <a href="<?php echo $settings['url']; ?>account/activity" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">find_in_page</i>Activity</a>
                        <!--<a href="<?php /*echo $settings['url'];*/ ?>" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">view_quilt<span class="new-notification"></span></i>Currency Converter</a>-->
                        <a href="<?php echo $settings['url']; ?>account/balance" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">local_atm</i>Currency Wallets</a>
                        <a href="<?php echo $settings['url']; ?>account/settings" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">important_devices</i>Settings</a>
                        <a href="<?php echo $settings['url']; ?>knowledge" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">view_quilt</i>Support</a>
                        <!--<a href="javascript:void(0)" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#colorscheme"><i class="material-icons icons-raised">color_lens</i>Color scheme</a>-->
                        <a href="<?php echo $settings['url']; ?>logout" class="list-group-item list-group-item-action"><i class="material-icons icons-raised bg-danger">power_settings_new</i>Logout</a>
                    </div>
                </div>
            </div>
        </div>