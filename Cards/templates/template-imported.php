<?php
function company_links_ul() { 
	global $card_company_phone, $card_company_email, $card_company_website, $card_company_address, $card_company_google_location;
?>
					<ul>
						<?php if(!empty($card_company_phone)){ ?>
                                                <li>
							<div onclick="location.href='tel:+<?php echo $card_company_phone; ?>'"> <i class="fa fa-phone"></i></div>
						</li>
						<?php } if(!empty($card_company_email)){ ?>
						<li>
							<div onclick="location.href='Mailto:<?php echo $card_company_email; ?>'"><i class="fa fa-envelope"></i></div>
						</li>
						<?php } if(!empty($card_company_website)){ ?>
						<li>
							<div onclick="location.href='<?php echo $card_company_website; ?>'"><i class="fa fa-chrome"></i></div>
						</li>
						<?php } if(!empty($card_company_address)){ ?>
						<li>
							<div onclick="location.href='<?php if(isset($card_company_google_location)) echo $card_company_google_location; else echo $card_company_address; ?>'"><i class="fa fa-map-marker"></i></div>
						</li>
						<?php } ?>
					</ul>
<?php
}
function company_phone_ul() {
	global $card_company_phone, $card_company_phone_alt, $card_company_email, $card_company_website, $card_company_address;
?>
                                <ul>
					<?php if(!empty($card_company_phone)){ ?>
					<li class="number"><?php echo $card_company_phone; ?><br/>
						           <?php echo $card_company_phone_alt; ?>
                                        </li>
					<?php } if(!empty($card_company_email)){ ?>
					<li class="website"><?php echo $card_company_email; ?></li>
					<?php } if(!empty($card_company_website)){ ?>
					<li class="email"><?php echo $card_company_website; ?></li>
					<?php } if(!empty($card_company_address)){ ?>
					<li class="location"><?php echo $card_company_address; ?></li>
					<?php } ?>
				</ul>
<?php } 
function company_info_div() {
	global $card_company_name, $card_company_person, $card_company_person_designation;
?>
					<h4><b><?php echo $card_company_name; ?></b></h4>
					<div class="line"></div>
					<h5><?php echo $card_company_person; ?></h5>
					<p><?php echo $card_company_person_designation; ?></p>
<?php }
function company_contact_icons() {
	global $card_company_phone, $card_company_whatsapp, $card_company_google_location, $card_company_email, $card_company_website;
?>
                                                <a href="tel:<?php echo $card_company_phone; ?>" target="_blank"> <i class="fa fa-phone"></i></a> <a href="https://api.whatsapp.com/send?phone=<?php echo $card_company_whatsapp; ?>&text=Hi, <?php echo $card_company_name; ?>" target="_blank"><i class="fa fa-whatsapp"></i></a> <a href="<?php echo $card_company_google_location; ?>" target="_blank"> <i class="fa fa-map-o"></i></a> <a href="Mailto:<?php echo $card_company_email; ?>" target="_blank"> <i class="fa fa-envelope"></i></a> <a href="<?php echo $card_company_website; ?>" target="_blank"> <i class="fa fa-chrome"></i></a>
<?php }
?>
<!DOCTYPE html>

<head>
	<!-- HTML Meta Tags -->
	<title><?php echo $card_company_name; ?> || Digital Visiting Card </title>

	<!-- Facebook Meta Tags -->

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="?php echo $card_company_person; ?> (<?php echo $card_company_person; ?>) <?php echo htmlentities($card_company_about); ?>" />
	<link rel="canonical" href="<?php echo $settings['url'] . '/' . $card_company_name; ?>" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?php echo $card_company_name; ?> || Our Digital Visiting Card " />
	<meta property="og:description" content="?php echo $card_company_person; ?> (<?php echo $card_company_person; ?>) <?php echo htmlentities($card_company_about); ?>" />
	<meta property="og:url" content="<?php echo $settings['url'] . '/' . $card_company_name; ?>" />
	<meta property="og:site_name" content="Digital Visiting Card" />
	<!--<meta property="og:image" content="https://www.gocrd.in/panel/favicons/1611875706.jpg" />
	<meta property="og:image:secure_url" content="https://www.gocrd.in/panel/favicons/1611875706.jpg" />-->
	<meta property="og:image:width" content="500" />
	<meta property="og:image:height" content="500" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="<?php echo $card_company_person; ?> (<?php echo $card_company_person; ?>) <?php echo htmlentities($card_company_about); ?>" />
	<meta name="twitter:title" content="<?php echo $card_company_name; ?> || Our Digital Visiting Card " />
	<!--<meta name="twitter:image" content="https://www.gocrd.in/panel/favicons/1611875706.jpg" />-->


	<!--<link rel="icon" href="panel/favicons/1611875706.jpg" type="image/*" sizes="16x16" />-->
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<!--<link rel='stylesheet' href='<?php echo $settings["url_assets"]; ?>/template_assets/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>-->
	<link rel='stylesheet' href='<?php echo $settings["url_assets"]; ?>/template_assets/all.css'>

	<link rel="stylesheet" href="<?php echo $settings["url_assets"]; ?>/template_assets/awesome.min.css">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />

	<link rel="stylesheet" href="<?php echo $settings["url_assets"]; ?>/template_assets/css.css">
	<link rel="stylesheet" href="<?php echo $settings["url_assets"]; ?>/template_assets/mobile_css.css">
	<link rel="stylesheet" href="<?php echo $settings["url_assets"]; ?>/template_assets/gallery_slider.css">
	<script src="<?php echo $settings["url_assets"]; ?>/template_assets/master_js.js"></script>
	<script src="<?php echo $settings["url_assets"]; ?>/template_assets/productslider.js"></script>

	<script>
		function myopenModal() {
			document.getElementById("openmyModal").style.display = "block";
		}

		function mycloseModal() {
			document.getElementById("openmyModal").style.display = "none";
		}



		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
			showSlides(slideIndex += n);
		}

		function currentSlide(n) {
			showSlides(slideIndex = n);
		}

		function showSlides(n) {
			var i;
			var slides = document.getElementsByClassName("mySlides");
			if (n > slides.length) {
				slideIndex = 1
			}
			if (n < 1) {
				slideIndex = slides.length
			}
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";
			}

			slides[slideIndex - 1].style.display = "block";

		}
	</script>

	<script src="<?php echo $settings["url_assets"]; ?>/template_assets/galleryslider.js"></script>

        <link rel="stylesheet" href="<?php echo $settings["url_assets"]; ?>/template_assets/template-<?php echo $card_template; ?>.css">

        <style>
                .icons { font-family: Montserrat; }
		.card {
                    <?php if(isset($_GET['preview'])) echo "height: auto!important;"; ?>
                    <?php if(!empty($card_color_background))
                    echo "background: " . $card_color_background; ?>
                }
                .card2 h3, .color_pick, .color_pick_li li {
                    <?php if(!empty($card_color_main))
                    echo "background: " . $card_color_main; ?>
                }
                .icons i {
                    <?php if(!empty($card_color_action))
                    echo "background: " . $card_color_action; ?>
                }
                .card2 h3, .bussiness_details .company_info {
                    <?php if(!empty($card_color_heading))
                    echo "color: " . $card_color_heading . ";\n"; ?>
                    <?php if(!empty($card_font_heading))
                    echo "font-family: " . $card_font_heading; ?>
                }
                body {
                    <?php if(!empty($card_color_other))
                    echo "color: " . $card_color_other . ";\n"; ?>
                    <?php if(!empty($card_font_other))
                    echo "font-family: " . $card_font_other; ?>
                }
        </style>
<script>
	$(document).ready(function() {
		$('.mobile_home').on('click', function() {
			$('#header').toggleClass('add_height');

		})
	})
</script>

<!--<meta https-equiv="refresh" content="100;URL=../index.php">-->

<script>
	$(document).ready(function() {
		$('.wtsp_share_btn').on('click', function() {
			$('#wtsp_form').submit();
		})

	})

	function writeCode(code) {

		$('#phone').val('+' + code);
	}
</script>



<body>
<?php if($card_template == 1 || $card_template == 2) { ?>
		<body>
			<div class="card color_pick">
				<div class="section bussiness_details bussiness_details_color_pick">
					<div class="company_logo color_pick_logo_border_n">
						<img <?php if(!empty($card_logo)) echo 'src="'.$settings['url'].$card_logo.'"'; ?>>
					</div>
					<div class="company_info">
						<?php company_info_div(); ?>
					</div>

				</div>


				<div class="section icons color_pick_icon">
					<div class="icons_list">
						<?php company_contact_icons(); ?>
					</div>
				</div>

				<div class="section contact_details">
					<div class="contact_bg">
						<div class="left_col_demo_2">
							<?php company_links_ul(); ?>
						</div>

						<div class="right_col_demo_2">
							<?php company_phone_ul(); ?>
						</div>
					</div>
				</div>
<?php } else if($card_template == 3 || $card_template == 4) { ?>
	<div class="card">
		<div class="bussiness_details color_pick">
			<div class="col-1-logo">
				<div class="company_logo">
					<img <?php if(!empty($card_logo)) echo 'src="'.$settings['url'].$card_logo.'"'; ?>>
				</div>
			</div>
			<div class="col-2-info">
				<div class="company_info">
                                        <?php company_info_div(); ?>
				</div>
			</div>
		</div>
		<div class="side_bar">
			<div class="contact_details">
				<div class="left_col_demo_2 color_pick_li">
                                    <?php company_links_ul(); ?>
				</div>

			</div>

		</div>


		<div class="right_section">

			<div class="icons">
				<div class="icons_list">
					<?php company_contact_icons(); ?>
				</div>
			</div>

			<div class="right_col_demo_2">
				<?php company_phone_ul(); ?>
			</div>
<?php } else if($card_template == 5 || $card_template == 6) { ?>
		<body>
			<div class="card">
				<div class="section header color_pick">
				</div>
				<div class="section bussiness_details color_pick">
					<div class="company_logo">
						<img <?php if(!empty($card_logo)) echo 'src="'.$settings['url'].$card_logo.'"'; ?>>
					</div>
					<div class="company_info">
						<?php company_info_div(); ?>
					</div>

				</div>
				<div class="section icons ">
					<div class="icons_list">
						<?php company_contact_icons(); ?>
                                        </div>
				</div>

				<div class="section contact_details">

					<div class="left_col_demo_2">
						<?php company_links_ul(); ?>
					</div>

					<div class="right_col_demo_2">
						<?php company_phone_ul(); ?>
					</div>

				</div>
<?php } else if($card_template == 7 || $card_template == 8) { ?>
<body>
	<div class="card">
		<div class="header">
			<div class="company_logo">
				<img <?php if(!empty($card_logo)) echo 'src="'.$settings['url'].$card_logo.'"'; ?>>
			</div>
		</div>
		<div class="card_inner color_picker_inner">
			<div class="section bussiness_details">
				<div class="company_info">
					<?php company_info_div(); ?>
				</div>
			</div>
			<div class="section icons">
				<div class="icons_list">
					<?php company_contact_icons(); ?>
                                </div>
			</div>

			<div class="section contact_details">


				<div class="left_col_demo_2">
					<?php echo company_links_ul(); ?>
				</div>

				<div class="right_col_demo_2">
					<ul>
						<?php if(!empty($card_company_phone)){ ?>
						<li class="number"><?php echo $card_company_phone; ?></br>
							<?php echo $card_company_phone_alt; ?></li>
						<?php } if(!empty($card_company_email)){ ?>
						<li class="website"><?php echo $card_company_email; ?></li>
						<?php } if(!empty($card_company_website)){ ?>
						<li class="email"><?php echo $card_company_website; ?></li>
						<?php } if(!empty($card_company_address)){ ?>
						<li class="location"><?php echo $card_company_address; ?></li>
						<?php } ?>
					</ul>
				</div>

			</div>
<?php } ?>

			<div class="section form">
				<form action="https://api.whatsapp.com/send" id="wtsp_form" target="_blank">
					<div class="section form">
						<div class="row">
							<div class="select_country">
								<select name="countrycode" id="countrycode" onchange="writeCode(this.value)">
									<option value="93">AF</option>
									<option value="355">AL</option>
									<option value="213">DZ</option>
									<option value="1684">AS</option>
									<option value="376">AD</option>
									<option value="244">AO</option>
									<option value="1264">AI</option>
									<option value="672">AQ</option>
									<option value="1268">AG</option>
									<option value="54">AR</option>
									<option value="374">AM</option>
									<option value="297">AW</option>
									<option value="61">AU</option>
									<option value="43">AT</option>
									<option value="994">AZ</option>
									<option value="1242">BS</option>
									<option value="973">BH</option>
									<option value="880">BD</option>
									<option value="1246">BB</option>
									<option value="375">BY</option>
									<option value="32">BE</option>
									<option value="501">BZ</option>
									<option value="229">BJ</option>
									<option value="1441">BM</option>
									<option value="975">BT</option>
									<option value="591">BO</option>
									<option value="387">BA</option>
									<option value="267">BW</option>
									<option value="55">BV</option>
									<option value="55">BR</option>
									<option value="246">IO</option>
									<option value="673">BN</option>
									<option value="359">BG</option>
									<option value="226">BF</option>
									<option value="257">BI</option>
									<option value="855">KH</option>
									<option value="237">CM</option>
									<option value="1">CA</option>
									<option value="238">CV</option>
									<option value="1345">KY</option>
									<option value="236">CF</option>
									<option value="235">TD</option>
									<option value="56">CL</option>
									<option value="86">CN</option>
									<option value="61">CX</option>
									<option value="672">CC</option>
									<option value="57">CO</option>
									<option value="269">KM</option>
									<option value="242">CG</option>
									<option value="242">CD</option>
									<option value="682">CK</option>
									<option value="506">CR</option>
									<option value="225">CI</option>
									<option value="385">HR</option>
									<option value="53">CU</option>
									<option value="357">CY</option>
									<option value="420">CZ</option>
									<option value="45">DK</option>
									<option value="253">DJ</option>
									<option value="1767">DM</option>
									<option value="1809">DO</option>
									<option value="593">EC</option>
									<option value="20">EG</option>
									<option value="503">SV</option>
									<option value="240">GQ</option>
									<option value="291">ER</option>
									<option value="372">EE</option>
									<option value="251">ET</option>
									<option value="500">FK</option>
									<option value="298">FO</option>
									<option value="679">FJ</option>
									<option value="358">FI</option>
									<option value="33">FR</option>
									<option value="594">GF</option>
									<option value="689">PF</option>
									<option value="0">TF</option>
									<option value="241">GA</option>
									<option value="220">GM</option>
									<option value="995">GE</option>
									<option value="49">DE</option>
									<option value="233">GH</option>
									<option value="350">GI</option>
									<option value="30">GR</option>
									<option value="299">GL</option>
									<option value="1473">GD</option>
									<option value="590">GP</option>
									<option value="1671">GU</option>
									<option value="502">GT</option>
									<option value="224">GN</option>
									<option value="245">GW</option>
									<option value="592">GY</option>
									<option value="509">HT</option>
									<option value="0">HM</option>
									<option value="39">VA</option>
									<option value="504">HN</option>
									<option value="852">HK</option>
									<option value="36">HU</option>
									<option value="354">IS</option>
									<option value="91">IN</option>
									<option value="62">ID</option>
									<option value="98">IR</option>
									<option value="964">IQ</option>
									<option value="353">IE</option>
									<option value="972">IL</option>
									<option value="39">IT</option>
									<option value="1876">JM</option>
									<option value="81">JP</option>
									<option value="962">JO</option>
									<option value="7">KZ</option>
									<option value="254">KE</option>
									<option value="686">KI</option>
									<option value="850">KP</option>
									<option value="82">KR</option>
									<option value="965">KW</option>
									<option value="996">KG</option>
									<option value="856">LA</option>
									<option value="371">LV</option>
									<option value="961">LB</option>
									<option value="266">LS</option>
									<option value="231">LR</option>
									<option value="218">LY</option>
									<option value="423">LI</option>
									<option value="370">LT</option>
									<option value="352">LU</option>
									<option value="853">MO</option>
									<option value="389">MK</option>
									<option value="261">MG</option>
									<option value="265">MW</option>
									<option value="60">MY</option>
									<option value="960">MV</option>
									<option value="223">ML</option>
									<option value="356">MT</option>
									<option value="692">MH</option>
									<option value="596">MQ</option>
									<option value="222">MR</option>
									<option value="230">MU</option>
									<option value="269">YT</option>
									<option value="52">MX</option>
									<option value="691">FM</option>
									<option value="373">MD</option>
									<option value="377">MC</option>
									<option value="976">MN</option>
									<option value="1664">MS</option>
									<option value="212">MA</option>
									<option value="258">MZ</option>
									<option value="95">MM</option>
									<option value="264">NA</option>
									<option value="674">NR</option>
									<option value="977">NP</option>
									<option value="31">NL</option>
									<option value="599">AN</option>
									<option value="687">NC</option>
									<option value="64">NZ</option>
									<option value="505">NI</option>
									<option value="227">NE</option>
									<option value="234">NG</option>
									<option value="683">NU</option>
									<option value="672">NF</option>
									<option value="1670">MP</option>
									<option value="47">NO</option>
									<option value="968">OM</option>
									<option value="92">PK</option>
									<option value="680">PW</option>
									<option value="970">PS</option>
									<option value="507">PA</option>
									<option value="675">PG</option>
									<option value="595">PY</option>
									<option value="51">PE</option>
									<option value="63">PH</option>
									<option value="0">PN</option>
									<option value="48">PL</option>
									<option value="351">PT</option>
									<option value="1787">PR</option>
									<option value="974">QA</option>
									<option value="262">RE</option>
									<option value="40">RO</option>
									<option value="70">RU</option>
									<option value="250">RW</option>
									<option value="290">SH</option>
									<option value="1869">KN</option>
									<option value="1758">LC</option>
									<option value="508">PM</option>
									<option value="1784">VC</option>
									<option value="684">WS</option>
									<option value="378">SM</option>
									<option value="239">ST</option>
									<option value="966">SA</option>
									<option value="221">SN</option>
									<option value="381">CS</option>
									<option value="248">SC</option>
									<option value="232">SL</option>
									<option value="65">SG</option>
									<option value="421">SK</option>
									<option value="386">SI</option>
									<option value="677">SB</option>
									<option value="252">SO</option>
									<option value="27">ZA</option>
									<option value="0">GS</option>
									<option value="34">ES</option>
									<option value="94">LK</option>
									<option value="249">SD</option>
									<option value="597">SR</option>
									<option value="47">SJ</option>
									<option value="268">SZ</option>
									<option value="46">SE</option>
									<option value="41">CH</option>
									<option value="963">SY</option>
									<option value="886">TW</option>
									<option value="992">TJ</option>
									<option value="255">TZ</option>
									<option value="66">TH</option>
									<option value="670">TL</option>
									<option value="228">TG</option>
									<option value="690">TK</option>
									<option value="676">TO</option>
									<option value="1868">TT</option>
									<option value="216">TN</option>
									<option value="90">TR</option>
									<option value="7370">TM</option>
									<option value="1649">TC</option>
									<option value="688">TV</option>
									<option value="256">UG</option>
									<option value="380">UA</option>
									<option value="971">AE</option>
									<option value="44">GB</option>
									<option value="1">US</option>
									<option value="598">UY</option>
									<option value="998">UZ</option>
									<option value="678">VU</option>
									<option value="58">VE</option>
									<option value="84">VN</option>
									<option value="1284">VG</option>
									<option value="1340">VI</option>
									<option value="681">WF</option>
									<option value="212">EH</option>
									<option value="967">YE</option>
									<option value="260">ZM</option>
									<option value="263">ZW</option>
								</select>
								<input type="text" id="phone" name="phone" placeholder="WhatsApp Number with Country code" oninput="this.value=this.value.replace(/[^0-9]/g,'');" value="+">
								<input type="hidden" name="text" value="<?php echo $settings["url"] . '/' . $card_url; ?>">
							</div>
							<div class="whatsapp_btn">
								<button class="Button" onclick="subForm()"><i class="fa fa-whatsapp"></i> Share</button>
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="section shadow-buttons">
				<a class="shadow-button btn_1" download href="contact_download.php?id=51"><i class="fa fa-download shadow-button-icon"></i>Add to Phone Book</a> <a class="shadow-button btn_2" id="share_box_pop"><i class="fa fa-share-alt shadow-button-icon"></i>Share</a>
			</div>

		</div>

		<div class="section footer_bottom">

			<div class="section footer color_pick">
				<div class="footer_icon">
					<?php if (!empty($card_social_facebook)) { ?><a href="<?php echo $card_social_facebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a><?php } ?>
					<?php if (!empty($card_social_youtube)) { ?><a href="<?php echo $card_social_youtube; ?>" target="_blank"><i class="fa fa-youtube"></i></a><?php } ?>
					<?php if (!empty($card_social_twitter)) { ?><a href="<?php echo $card_social_twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a><?php } ?>
					<?php if (!empty($card_social_instagram)) { ?><a href="<?php echo $card_social_instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a><?php } ?>
					<?php if (!empty($card_social_linkedin)) { ?><a href="<?php echo $card_social_linkedin; ?>" target="_blank"><i class="fa fa-linkedin"></i></a><?php } ?>
					<?php if (!empty($card_social_pinterest)) { ?><a href="<?php echo $card_social_pinterest; ?>" target="_blank"><i class="fa fa-pinterest"></i></a><?php } ?>
					<?php for ($i = 0; isset($card_other_links) && $i < count($card_other_links); $i++) { ?>
					<a href="<?php echo $card_other_links[$i]; ?>" target="_blank"><i class="fa <?php echo $card_other_links_icon[$i]; ?>"></i></a>
					<?php } ?>
					<?php if(!empty($card_appointment_link)) { ?><a id="link-appointment" target="_blank" href="<?php echo $card_appointment_link; ?>"><i class="fa fa-calendar-alt"></i></a><?php } else
					      if(!empty($card_company_whatsapp)) { ?><a id="link-appointment" target="_blank" href="<?php echo $card_company_whatsapp; ?>"><i class="fa fa-calendar-alt"></i></a><?php } ?>
				</div>
			</div>

		</div>

	</div>

</body>
<div class="share_box">
	<div class="close" id="close_sharer">&times;</div>
	<p>Share My Digital Card </p>
	<br>
	<a href="https://api.whatsapp.com/send?text=<?php echo $settings["url"] . '/' . $card_url; ?>">
		<div class="shar_btns"><i class="fa fa-whatsapp" id="" target="_blank"></i>
			<p>WhatsApp</p>
		</div>
	</a>
	<a href="sms:?body=<?php echo $settings["url"] . $card_url; ?>" target="_blank">
		<div class="shar_btns"><i class="fa fa-comments-o"></i>
			<p>SMS</p>
		</div>
	</a>
	<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $settings["url"] . '/' . $card_url; ?>" target="_blank">
		<div class="shar_btns"><i class="fa fa-facebook"></i>
			<p>Facebook</p>
		</div>
	</a>
	<a href="https://twitter.com/intent/tweet?text=<?php echo $settings["url"] . '/' . $card_url; ?>" target="_blank">
		<div class="shar_btns"><i class="fa fa-twitter"></i>
			<p>Twitter</p>
		</div>
	</a>
	<a href="" target="_blank">
		<div class="shar_btns"><i class="fa fa-instagram"></i>
			<p>Instagram</p>
		</div>
	</a>
	<a href="<?php echo $settings["url"] . '/' . $card_url; ?>" target="_blank">
		<div class="shar_btns"><i class="fa fa-linkedin"></i>
			<p>Linkedin</p>
		</div>
	</a>
</div>
<script>
	$(document).ready(function() {
		$('#close_sharer,#share_box_pop').on('click', function() {
			$('.share_box').slideToggle();
		});
	})

	function close_appoint() {
		var modal = document.getElementById("myModal");
		modal.style.display = "none";
	}
</script>

<?php 
	foreach($card_order as $card_ord) {
		if($card_ord == 'card_company_position')
			company();
		if($card_ord == 'card_social_position')
			youtube();
		if($card_ord == 'card_payment_position')
			payment();
		if($card_ord == 'card_products_position')
			products();
		if($card_ord == 'card_offers_position')
			offers();
		if($card_ord == 'card_gallery_position')
			gallery();
		if($card_ord == 'card_feedback_position')
			feedback();
		if($card_ord == 'card_additional_position')
			additional();
	}
?>

<?php 
function company() {
global $card_company_visibility, $card_company_heading, $card_company_name,
	$card_company_nature, $card_company_specialities, $card_company_about,
	$card_company_files;
if(isset($card_company_visibility) && $card_company_visibility == 1) { ?>
<!--------------about us --------------------------->
<div class="card2" id="about_us">
	<h3><?php echo $card_company_heading; ?></h3>
	<table class="about-us-table">
		<tbody>
			<tr>
				<td class="table-row-label">
					<h4 class="table-row-label-text">Company Name</h4><b class="table-row-label-separator">:</b>
				</td>
				<td></td>
				<td class="table-row-value">
					<?php echo $card_company_name; ?> </td>
				<td></td>
			</tr>
			<?php if(!empty($card_company_nature)) { ?>
			<tr>
                                <td class="table-row-label">
					<h4 class="table-row-label-text">Nature Of Business</h4><b class="table-row-label-separator">:</b>
				</td>
				<td></td>
				<td class="table-row-value">
					<?php echo $card_company_nature; ?> </td>
				<td></td>
			</tr>
                        <?php } ?>
		</tbody>
	</table>
	<?php if(!empty($card_company_specialities)) { ?>
	<br>
	<h4 class="Specialities">Our Specialities</h4>
	<ul class="special_list">
		<?php
                      $sp = explode(",", $card_company_specialities);
                      foreach ($sp as $s) { ?>

		<li><?php echo $s; ?></li>

		<?php } ?>
	</ul>
        <?php } ?>

	<?php if(!empty($card_company_about)) { ?>
	<p>
		<p><?php echo $card_company_about; ?></p>
	</p>
        <?php } ?>

	<?php if(!empty($card_company_files)) { ?>
	<h4 class="document">Documents</h4>
	<?php
                 $fl = explode(",", $card_company_files);
                 foreach ($fl as $f) { 
        ?>
	<a class="document-wrapper" href="<?php echo $f; ?>" download>
		<div class="pdf-icon"><i class="fa fa-file-pdf"></i></div>
		<div class="pdf-number"><?php echo $f; ?></div>
		<div class="download-icon"><i class="fa fa-download"></i></div>
	</a>
        <?php } ?>

	<?php } ?>
</div>
<?php }
}
?>

<?php 
function offers() {
global $card_offers_visibility, $card_offers_heading, $card_offers, $settings;
if(isset($card_offers_visibility) && $card_offers_visibility == 1 && count($card_offers) > 0) { ?>
<!------------shopping online-------------------------->
<div class="card2" id="shop_online">
	<h3><?php echo $card_offers_heading; ?></h3>
        <h3></h3>

	<?php 
        $i = 1;
        foreach ($card_offers as $offer) { ?>
	<div class="order_box">
		<div class="image_box">
			<img onclick="myopenModal(); currentSlide(<?php echo $i; ?>)" <?php if($offer["image"] != "") echo 'src="' . $settings["url"] . $offer["image"] . '"'; ?> alt="Product">
                </div>
		<h2><?php echo $offer["title"]; ?></h2>
		<h4><span style="text-decoration: line-through;"><?php echo $offer["MRP"]; ?></span> <i class=""><?php echo $offer["offer_price"]; ?></i></h4>
		<a href="<?php echo $offer["link"]; ?>" target='_blank'>
			<div class='btn_buy'><?php echo $offer["button"]; ?></div>
		</a>
	</div>
	<?php 
            $i++;
        } 
        ?>

	<div id="openmyModal" class="modal">
		<span class="close cursor" onclick="mycloseModal()">&times;</span>
		<div class="modal-content">
                        <?php foreach ($card_offers as $offer) { ?>
			<a class="prev" onclick="plusSlides(-1)">&#10094;</a><a class="next" onclick="plusSlides(1)">&#10095;</a>
			<div class="mySlides"><img style="width:100%" src="<?php echo $settings["url"] . $offer["image"]; ?>" alt="Product"></div>
                        <?php } ?>
		</div>
	</div>

</div>
<?php }
} 
?>


<?php 
function youtube() {
global $card_social_visibility, $card_social_youtube_links, $card_social_heading;
if(isset($card_social_visibility) && $card_social_visibility == 1) { 
$yt = explode(",", $card_social_youtube_links);
if(count($yt) > 0) {
?>
<!--------------youtube videos--------------------------->
<div class="card2" id="youtube_video">
	<h3><?php echo $card_social_heading; ?></h3>

	<?php
                  foreach ($yt as $v) {
                  preg_match("/[\\?\\&]v=([^\\?\\&]+)/", $v, $matches); 
        ?>

	<iframe src="https://www.youtube.com/embed/<?php echo $matches[1]; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

	<?php } ?>
</div>
<?php }
  } 
}
?>

<?php 
function products() {
global $card_products_visibility, $card_products_heading, $card_products, $settings;
if(isset($card_products_visibility) && $card_products_visibility == 1) { ?>
<!----------product and services ----------------------->
<div class="card2" id="product_services">
	<h3><?php echo $card_products_heading; ?></h3>
	<?php 
        $i = 1;
        foreach ($card_products as $product) { ?>
	<div class="product_s">
		<p><?php echo $product["title"]; ?></p>
		<img onclick="productopenmodal(); productcurrentSlide(<?php echo $i; ?>)" src="<?php echo $settings["url"] . $product["image"]; ?>" alt="Logo">
		<p><?php echo $product["description"]; ?></p><br>
		<a href="<?php echo $product["link"]; ?>" target='_blank'>
			<div class='btn_buy'><?php echo $product["button"]; ?></div>
		</a>
	</div>
	<?php
	    $i++; 
	} 
	?>
	<div id="productmodal" class="modal">
		<span class="close cursor" onclick="productclosemodal()">&times;</span>
		<div class="modal-content">
                        <?php foreach ($card_products as $product) { ?>
			<a class="prev" onclick="nextSlides(-1)">&#10094;</a><a class="next" onclick="nextSlides(1)">&#10095;</a>
			<div class="mySlidesproducts"><img style="width:100%" src="<?php echo $settings["url"] . $product["image"]; ?>" alt="Logo"></div>
                        <?php } ?>
		</div>
	</div>
</div>
<?php }
} 
?>


<?php 
function gallery() {
global $card_gallery_visibility, $card_gallery_heading, $card_gallery_urls, $settings;
if(isset($card_gallery_visibility) && $card_gallery_visibility == 1 && !empty($card_gallery_urls)) { ?>
<!----------image gallery----------------------->
<div class="card2" id="gallery">

	<h3><?php echo $card_gallery_heading; ?></h3>
	<div id="gallery_new">

	        <?php 
                $i = 1;
                $gal = explode(",", $card_gallery_urls);
                foreach ($gal as $g) { ?>
		<div class="img_gall order_box"><img onclick="galleryopenmodal(); gallerycurrentslider(<?php echo $i; ?>)" src="<?php echo $settings["url"] . $g; ?>" alt="Gallery Image"></div>
                <?php 
                    $i++;
                } 
                ?>
		<div id="gallerymodal" class="modal">
			<span class="close cursor" onclick="galleryclosemodal()">&times;</span>
			<div class="modal-content">
                                <?php foreach ($gal as $g) { ?>
				<a class="prev" onclick="nextslides(-1)">&#10094;</a><a class="next" onclick="nextslides(1)">&#10095;</a>
				<div class="galleryslide"><img style="width:100%" src="<?php echo $settings["url"] . $g; ?>" alt="Gallery Image"></div>
                                <?php } ?>
			</div>
		</div>

        </div>

</div>
<?php }
} 
?>


<?php 
function payment() {
global $card_payment_visibility, $card_payment_heading, $card_payment_venmo,
	$card_payment_cashapp, $card_payment_paypal;
if(isset($card_payment_visibility) && $card_payment_visibility == 1) { ?>
<!----------payment info----------------------->
<div class="card2" id="payment">

	<h3><?php echo $card_payment_heading; ?></h3>

        <?php if(!empty($card_payment_venmo)) { ?>
	<h2>Venmo</h2>
	<p><?php echo $card_payment_venmo; ?></p>
        <?php } ?>
        <?php if(!empty($card_payment_cashapp)) { ?>
	<h2>Cashapp</h2>
	<p><?php echo $card_payment_cashapp; ?></p>
        <?php } ?>
        <?php if(!empty($card_payment_paypal)) { ?>
	<h2>Paypal</h2>
	<p><?php echo $card_payment_paypal; ?></p>
        <?php } ?>

</div>
<?php } 
}
?>

<?php 
function additional() {
global $card_additional, $settings;
?>
<!----------custom sections----------------------->
<div id="additional">
<?php 
if(isset($card_additional)) {
foreach ($card_additional as $add) { 
    if($add['visibility'] == 0)
        continue;
?>

<div class="card2">

	<h3><?php echo $add["heading"]; ?></h3>
	<?php echo $add["text"]; ?><br>
	<?php if(!empty($add["image"])) { ?><img src="<?php echo $settings["url"] . $add["image"]; ?>" alt="<?php echo $add["heading"]; ?> Image"><?php } ?>
</div>

<?php } 
   }
}
?>
</div>


<style>
	.rating {
		display: flex;
		flex-direction: row-reverse;
		justify-content: center;
		font-size: 14px;
		border-radius: 0px;
		padding: 10px;
		border: 1px solid #ff572200;
		border-bottom: 2px solid #ff5722;
		margin: 4px 26px;
		resize: vertical;
		background: #00000005;
	}

	.rating > input {
		display: none
	}

	.rating > label {
		position: relative;
		width: 15%;
		font-size: 2.5vw;
		color: #FFD600;
		cursor: pointer
	}

	@media screen and (max-width: 700px) {
		.rating > label {
			font-size: 7vw;
		}
	}

	.rating > label::before {
		content: "\2605";
		position: absolute;
		opacity: 0
	}

	.rating > label:hover:before,
	.rating > label:hover ~ label:before {
		opacity: 1 !important
	}

	.rating > input:checked ~ label:before {
		opacity: 1
	}

	.rating:hover > input:checked ~ label:before {
		opacity: 0.4
	}
</style>


<?php 
function feedback() {
global $card_feedback_visibility, $card_feedback_heading, $card_feedback_entries;
if(isset($card_feedback_visibility) && $card_feedback_visibility == 1) { ?>
<div class="card2" id="feedback">
	<h3><?php echo $card_feedback_heading; ?></h3>
	<div class="feedback_list">
                    <?php 
                    if(isset($card_feedback_entries)) {
                        for($i = 0; $i < count($card_feedback_entries); $i++) {
                    ?>
		<h5><?php echo $card_feedback_entries[$i]['name']; ?></h5>
		<?php for($j = 0; $j < $card_feedback_entries[$i]['rating']; $j++) { ?>
		<i class="fa fa-star" aria-hidden="true"></i>
                    <?php } ?>
		<p><?php echo $card_feedback_entries[$i]['description']; ?></p>
		<h6><?php echo $card_feedback_entries[$i]['date']; ?></h6>
		<hr>
                    <?php
                        }
                    }
                    ?>
	</div>

	<form action="" method="post">

		<br>
		<h4 style="padding-left:15px">Give Feedback</h4>
		<div class="rating">
			<input type="radio" name="rating" value="5" id="1"><label for="1" title="Excellent">☆</label>
			<input type="radio" name="rating" value="4" id="2"><label for="2" title="Very Good">☆</label>
			<input type="radio" name="rating" value="3" id="3"><label for="3" title="Average">☆</label>
			<input type="radio" name="rating" value="2" id="4"><label for="4" title="Poor">☆</label>
			<input type="radio" name="rating" value="1" id="5"><label for="5" title="Terrible">☆</label>
		</div>
		<input type="text" name="name" placeholder="Enter Your Full Name" required>
		<textarea name="message" placeholder="Enter Your Feedback" required></textarea>
		<input type="submit" Value="Give Feedback " name="feedback">
	</form>
	<br>

</div>
<?php } 
}
?>

<!----------email to  info----------------------->
<div class="card2" id="enquery">

	<form method="post">
		<h3>Contact Us</h3>

		<input type="" name="name" placeholder="Enter Your Name" required>
		<input type="" name="contact" maxlength="13" placeholder="Enter Your Mobile No" required>
		<input type="email" name="email" placeholder="Enter Your Email Address">
		<textarea name="message" placeholder="Enter your Message or Query" required></textarea>
		<input type="submit" Value="Send " name="contact">

	</form>
	<!--QR Code snippet-->
	<div style="text-align: center;  padding-top: 10px;">
		<img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo $settings["url"] . '/' . $card_url; ?>" alt="QR-code">

	</div>
	<!--QR Code snippet ends-->




	<style>
		@media screen and (max-width: 700px) {
			.modal-content {

				width: 85% !important;
			}

		}

		/* The Modal (background) */
		.modal {
			display: none;
			/* Hidden by default */
			position: fixed;
			/* Stay in place */
			z-index: 1;
			/* Sit on top */
			padding-top: 20px;
			/* Location of the box */
			left: 0;
			top: 0;
			width: 100%;
			/* Full width */
			height: 100%;
			/* Full height */
			overflow: auto;
			/* Enable scroll if needed */
			background-color: rgb(0, 0, 0);
			/* Fallback color */
			background-color: rgba(0, 0, 0, 0.4);
			/* Black w/ opacity */
		}

		/* Modal Content */
		.modal-content {
			background-color: #fefefe;
			margin: auto;
			padding: 20px;
			border: 1px solid #888;
			width: 35%;
		}

		/* The Close Button */
		.close {
			color: #aaaaaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.close:hover,
		.close:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
		}
	</style>


	<!--<a class="link-appointment" id="link-appointment">Book Your Appointment</a>-->
	<div id="myModal" class="modal">
		<div class="modal-content">

			<form method="post" action="">
				<button type="button" class="close" id="close_appoint" onclick="close_appoint()">&times;</button>
				<p>Book Appointment</p>

				<input type="text" name="cust_name" placeholder="Enter Your Name" required>
				<input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="app_cust_mobile" placeholder="Enter Phone Number" required>
				<input type="date" name="app_date" id="app_date" placeholder="Datee" min="2021-01-29" required>
				<input type="time" name="app_start_time" id="app_start_time" placeholder="From Time" onchange="checkAppointment()" required>
				<input type="time" name="app_end_time" id="app_end_time" placeholder="To Time" required>
				<textarea name="app_description" placeholder="Description" required></textarea>
				<input type="submit" name="appointment" value="Book">

			</form>
			<ul style="list-style-type:none;margin-top: 10px; font-weight: 500;line-height:1.5;">

			</ul>
		</div>
	</div>
	<a class="list-app" id="list-app" style="display:none;">More..</a>
	<script>
		function checkAppointment() {
			var id = 51;
			var date = $('#app_date').val();
			var timestart = $('#app_start_time').val();
			var timeend = $('#app_end_time').val();
			var check = true;
			if (date != '') {
				$.ajax({
					type: "POST",
					url: "checkAppointment.php",
					dataType: "html",
					data: {
						'date': date,
						'timestart': timestart,
						'timeend': timeend,
						'check': check,
						id: id
					},
					success: function(data) {
						$('#useless-data').html(data);
						var val = $('#chk-vlu-app').html();
						if (val == 1) {
							$('#useless-data').html('');
						}
						if (val == 0) {
							alert('Booked Please select other date and time');
							$('#useless-data').html('');
							$('#app_start_time').val('');
						}


					}
				});
			} else {
				alert('Please Select Date');
				$('#app_start_time').val('');
			}
		}
	</script>



	<div id="myModal2" class="modal">
		<div class="modal-content">

			<button type="button" class="close" id="close2">&times;</button>
			<p>Booked Appointment List</p>
			<ul style="list-style-type:none; margin-top:10px;line-height:1.5;">

			</ul>

		</div>

	</div>


	<script>
		// Get the modal

		var modal = document.getElementById("myModal");
		var modal2 = document.getElementById("myModal2");

		// Get the button that opens the modal
		var btn = document.getElementById("link-appointment");


		// Get the <span> element that closes the modal
		var span = document.getElementById("close_appoint");
		var button = document.getElementById("close2");

		// When the user clicks the button, open the modal 
		btn.onclick = function() {
			modal.style.display = "block";
		}
		var btn2 = document.getElementById("list-app");
		btn2.onclick = function() {
			modal2.style.display = "block";
		}

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}
		button.onclick = function() {
			modal2.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
		window.onclick = function(event) {
			if (event.target == modal2) {
				modal2.style.display = "none";
			}
		}
	</script>


	<br>


	<a href="index.php">
		<div class="create_card_btn"> Create Your Card @ <?php echo $settings['url']; ?></div>
	</a>
</div>



<style>
	.create_card_btn {
		background: linear-gradient(45deg, black, black);
		color: white;
		width: auto;
		padding: 20px;
		border-radius: 2px;
		line-height: 0.8;
		margin: 11px auto;
		font-size: 9px;
		text-align: center;
	}

	#svg_down {
		position: fixed;
		bottom: 0;
		z-index: -1;
		left: 0;
	}
</style>
<br>
<br>
<br>
<br>
<div class="menu_bottom color_pick">
	<div class="menu_container">
		<div class="menu_item" onclick="location.href='#home'"><i class="fa fa-home"></i> Home</div>
<?php
	for($i = 0; $i < count($card_order); $i++) {
		if($card_order[$i] == 'card_company_position' && !empty($card_company_visibility)) { ?>

		<div class="menu_item" onclick="location.href='#about_us'"><i class="fa fa-briefcase"></i><?php if(!empty($card_company_heading)) echo $card_company_heading; else echo "Company"; ?></div>
<?php			
		} if($card_order[$i] == 'card_social_position' && !empty($card_social_visibility)) { ?>

		<div class="menu_item" onclick="location.href='#youtube_video'"><i class="fa fa-video-camera"></i><?php if(!empty($card_social_heading)) echo $card_social_heading; else echo "Youtube Links"; ?></div>
<?php			
		} if($card_order[$i] == 'card_payment_position' && !empty($card_payment_visibility)) { ?>

		<div class="menu_item" onclick="location.href='#payment'"><i class="fa fa-money"></i><?php if(!empty($card_payment_heading)) echo $card_payment_heading; else echo "Payment"; ?></div>
<?php			
		} if($card_order[$i] == 'card_products_position' && !empty($card_products_visibility)) { ?>

		<div class="menu_item" onclick="location.href='#product_services'"><i class="fa fa-ticket"></i><?php if(!empty($card_products_heading)) echo $card_products_heading; else echo "Products"; ?></div>
<?php			
		} if($card_order[$i] == 'card_offers_position' && !empty($card_offers_visibility)) { ?>

		<div class="menu_item" onclick="location.href='#shop_online'"><i class="fa fa-archive"></i><?php if(!empty($card_offers_heading)) echo $card_offers_heading; else echo "Offers"; ?></div>
<?php			
		} if($card_order[$i] == 'card_gallery_position' && !empty($card_gallery_visibility)) { ?>

		<div class="menu_item" onclick="location.href='#gallery'"><i class="fa fa-image"></i><?php if(!empty($card_gallery_heading)) echo $card_gallery_heading; else echo "Gallery"; ?></div>
<?php			
		} if($card_order[$i] == 'card_feedback_position' && !empty($card_feedback_visibility)) { ?>

		<div class="menu_item" onclick="location.href='#feedback'"><i class="fa fa-comments-o"></i><?php if(!empty($card_gallery_heading)) echo $card_feedback_heading; else echo "Feedback"; ?></div>
<?php			
		} if($card_order[$i] == 'card_additional_position') { ?>

		<div class="menu_item" onclick="location.href='#additional'"><i class="fa fa-briefcase"></i>More</div>
<?php			
		}
	}
?>
		<div class="menu_item" onclick="location.href='#enquery'"><i class="fa fa-comment"></i>Contact Us</div>
	</div>
</div>

<div style="display:none! important;" id="useless-data"></div>