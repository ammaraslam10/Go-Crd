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
                        
                        <li class="nav-item dropdown language-option">
                            <a class="nav-link" href="#">
                                <i class="fas fa-globe"></i> <?php echo $_COOKIE['lang']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php echo getLanguage($settings['url'],null,1); ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="btn nav-link" href="<?php echo $settings['url']; ?>login"><?php echo $lang['menu_login']; ?></a>
                        </li>
                        <li class="nav-item active">
                            <a class="btn nav-link" href="<?php echo $settings['url']; ?>register"><?php echo $lang['menu_register']; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Modal -->
        </nav><!-- main-nav-block -->