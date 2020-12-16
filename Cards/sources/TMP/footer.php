<footer class="footer">
        <div class="footer-upper-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="footer-logo">
                            <a href="#">
                                <img src="<?php echo $settings['url']; ?>assets/images/logo.png" alt="img" class="img-responsive"/>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="footer-info-list">
                            <h4><?php echo $lang['about_us']; ?></h4>
                            <ul>
                                <li><a href="<?php echo $settings['url']; ?>page/our_team"><?php echo $lang['our_team']; ?></a></li>
                                <li><a href="<?php echo $settings['url']; ?>page/our_company"><?php echo $lang['our_company']; ?></a></li>
                                <li><a href="<?php echo $settings['url']; ?>contacts"><?php echo $lang['contact_us']; ?></a></li>
                                <li><a href="<?php echo $settings['url']; ?>register"><?php echo $lang['join_us']; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="footer-info-list">
                            <h4><?php echo $lang['learn']; ?></h4>
                            <ul>
                                <li><a href="<?php echo $settings['url']; ?>page/legal"><?php echo $lang['legal']; ?></a></li>
                                <li><a href="<?php echo $settings['url']; ?>page/terms-of-use"><?php echo $lang['terms_of_use']; ?></a></li>
                                <li><a href="<?php echo $settings['url']; ?>page/privacy_policy"><?php echo $lang['privacy_policy']; ?></a></li>
                                <li><a href="<?php echo $settings['url']; ?>page/gdpr"><?php echo $lang['gdpr']; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <div class="footer-info-list">
                            <h4><?php echo $lang['help']; ?></h4>
                            <ul>
                                <li><a href="<?php echo $settings['url']; ?>knowledge"><?php echo $lang['support']; ?></a></li>
                                <li><a href="<?php echo $settings['url']; ?>merchant"><?php echo $lang['merchant_ipn']; ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="footer-info-list">
                            <h4><?php echo $lang['contact_us']; ?></h4>
                            <ul class="contact-info">
                                <li><?php echo $lang['footer_email']; ?>:  <span><?php echo $settings['supportemail']; ?></span></li>
                            </ul>
                            <ul class="social-style-two">
                                <li>
                                    <a href="<?php echo $social['facebook_profile']; ?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $social['twitter_profile']; ?>">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $social['googleplus_profile']; ?>">
                                        <i class="fab fa-google-plus-g"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $social['linkedin_profile']; ?>">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-wrap">
                    <div class="trade-volume-block">
                        <ul>
                            <li>
                                <span><?php echo $settings['name']; ?></span> is electronic online wallet.
                            </li>
                        </ul>
                    </div>
                    <div class="copyright-text">
                        © 2020 <a href="<?php echo $settings['url']; ?>"><?php echo $settings['name']; ?></a>. All Rights Reserved
                    </div>
                </div>
            </div>
        </div>
    </footer>