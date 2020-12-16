<nav class="navbar main-nav navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?php echo $settings['url']; ?>">
                    <img class="navbar-logo" src="<?php echo $settings['url']; ?>assets/images/logo.png" alt="<?php echo $settings['name']; ?>"/>
                </a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/summary"><?php echo $lang['menu_summary']; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/balance"><?php echo $lang['menu_balance']; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/activity"><?php echo $lang['menu_activity']; ?></a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#"><?php echo $lang['menu_tools']; ?></a>
                            <ul class="dropdown-menu">
                            <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/money/send"><?php echo $lang['menu_send_money']; ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/money/request"><?php echo $lang['menu_request_money']; ?></a></li>
                            <?php if($settings['enable_curcnv'] == "1") { ?> 
                                <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/money/converter"><?php echo $lang['menu_currencyconverter']; ?></a></li>
                            <?php } ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/disputes"><?php echo $lang['menu_disputes']; ?></a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>knowledge"><?php echo $lang['menu_support']; ?></a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>account/settings"><i class="fa fa-cog"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $settings['url']; ?>logout"><i class="fa fa-sign-out-alt"></i></a></li>
                        <li class="nav-item dropdown language-option">
                            <a class="nav-link" href="#">
                                <i class="fas fa-globe"></i> <?php echo $_COOKIE['lang']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php echo getLanguage($settings['url'],null,1); ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal -->
        </nav><!-- main-nav-block -->