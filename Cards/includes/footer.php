<!-- footer-->
<div class="footer">
    <div class="no-gutters">
        <div class="col-auto mx-auto">
            <div class="row no-gutters justify-content-center">
                <div class="col-auto">
                                        <?php  
                        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                             $url = "https://";   
                        else  
                             $url = "http://";   
                        // Append the host(domain name, ip) to the URL.   
                        $url.= $_SERVER['HTTP_HOST'];   
                        
                        // Append the requested resource location to the URL   
                        $url.= $_SERVER['REQUEST_URI'];
                      ?> 
                    <a href="<?php echo $settings['url']; ?>" class="btn btn-link-default <?php if($settings['url'].'account/summary'==$url){echo "active";}?>">
                        <i class="material-icons">home</i>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="<?php echo $settings['url']; ?>account/activity" class="btn btn-link-default <?php if($settings['url'].'account/activity'==$url){echo "active";}?>">
                        <i class="material-icons">insert_chart_outline</i>
                    </a>
                </div>
                <!--<div class="col-auto">
                    <a href="wallet.html" class="btn btn-link-default">
                        <i class="material-icons">account_balance_wallet</i>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="transactions.html" class="btn btn-link-default">
                        <i class="material-icons">widgets</i>
                    </a>
                </div>-->
                <div class="col-auto">
                    <a href="<?php echo $settings['url']; ?>account/settings/" class="btn btn-link-default <?php if($settings['url'].'account/settings/'==$url){echo "active";}?>">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer ends-->