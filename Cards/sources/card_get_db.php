<?php
	if(!isset($id) && !isset($card_id)) {
		if(isset($_GET['b'])) {
			$card_id = clean($db, intval($_GET['b']));
		} else {
			exit;
		}
	}
	if(!isset($id)) {
		$id = $card_id; 
	}
	if(!isset($card_id)) {
		$card_id = $id; 
	}
	if(!isset($data)) {
		$data = mysqli_fetch_array(mysqli_query($db, 'select * from card where id='.$card_id));
		if(!isset($data['id'])) {
			exit;
		}
	}
	$card_template = clean($db, $data['template']);
	$card_logo = '/uploads/' . $data['creator'] . '_' . $id . '_logo.jpg';
	$card_url = clean($db, $data['card_link']);
	$design = explode(",", $data['design']);
	if(count($design) < 5) {
                $card_color_background = "";
		$card_color_main = "";
		$card_color_action = "";
		$card_font_heading = "";
		$card_color_heading = "";
		$card_font_other = "";
		$card_color_other = "";
	} else {
		$card_color_background = clean($db, $design[0]);
		$card_color_main = clean($db, $design[1]);
		$card_color_action = clean($db, $design[2]);
		$card_font_heading = clean($db, $design[3]);
		$card_color_heading = clean($db, $design[4]);
		$card_font_other = clean($db, $design[5]);
		$card_color_other = clean($db, $design[6]);
        }
	$card_design = $data['design'];
	$card_header = '/uploads/' . $data['creator'] . '_' . $id . '_header.jpg';

	$company = mysqli_fetch_array(mysqli_query($db, 'select * from card_company where card_id='.$id));
	$card_company_name = clean($db, $company['name']);
	$card_company_whatsapp = clean($db, $company['whatsapp']);
	$card_company_country = clean($db, $company['country']);
	$card_company_address = clean($db, $company['address']);
	$card_company_email = clean($db, $company['email']);
	$card_company_tagline = clean($db, $company['tagline']);
	$card_company_person = clean($db, $company['person_name']);
	$card_company_person_designation = clean($db, $company['designation']);
	$card_company_phone = clean($db, $company['phone']);
	$card_company_phone_alt = clean($db, $company['alternative_phone']);
	$card_company_website = clean($db, $company['website']);
	$card_company_google_location = clean($db, $company['google_location']);
	$card_company_about = $company['about'];
	$card_company_nature = clean($db, $company['nature']);
	$card_company_specialities = clean($db, $company['specialities']);
	$card_company_appointment = clean($db, $company['appointment']);
	$card_company_files = clean($db, $company['files']);
	$card_company_heading = clean($db, $company['section_title']);
	$card_company_position = clean($db, $company['section_position']);
	$card_company_visibility = clean($db, $company['is_visible']);

	$social = mysqli_fetch_array(mysqli_query($db, 'select * from card_social_media where card_id='.$id));
	$card_social_facebook = clean($db, $social['facebook']);
	$card_social_twitter = clean($db, $social['twitter']);
	$card_social_instagram = clean($db, $social['instagram']);
	$card_social_linkedin = clean($db, $social['linkedin']);
	$card_social_pinterest = clean($db, $social['pinterest']);
	$card_social_youtube = clean($db, $social['youtube']);
	$card_other_links = array();
	$card_other_links_icon = array();
	$links = explode(",", clean($db, $social['others']));
	foreach($links as $tmp) {
		$tmp2 = explode("|", $tmp);
		if(count($tmp2) >= 2) {
			$card_other_links[] = $tmp2[0];
			$card_other_links_icon[] = $tmp2[1];
		}
	}
	$card_social_links = $social['others'];
	$card_social_youtube_links = clean($db, $social['youtube_videos']);
	$card_social_heading = clean($db, $social['section_title']);
	$card_social_position = clean($db, $social['section_position']);
	$card_social_visibility = clean($db, $social['is_visible']);

	$payment = mysqli_fetch_array(mysqli_query($db, 'select * from card_payment where card_id='.$id));
	$card_payment_venmo = clean($db, $payment['venmo']);
	$card_payment_cashapp = clean($db, $payment['cashapp']);
	$card_payment_paypal = clean($db, $payment['paypal']);
	$card_payment_heading = clean($db, $payment['section_title']);
	$card_payment_position = clean($db, $payment['section_position']);
	$card_payment_visibility = clean($db, $payment['is_visible']);

	$products = mysqli_query($db, 'select * from card_product_information where card_id='.$id);
	$product_info = mysqli_fetch_array($products);
	$card_products = array();
	$card_product_title = array(); $card_product_image = array(); $card_product_description = array(); 
	$card_product_button = array(); $card_product_button_link = array(); 
	$count = 0;
	while($product = mysqli_fetch_array($products)) {
		$card_product_title[] = clean($db, $product['title']);
		$card_product_image[] = "/uploads/".$data['creator']."_".$data['id']."_product_".$count.".jpg";
		$card_product_description[] = $product['description'];
		$card_product_button[] = clean($db, $product['button']);
		$card_product_button_link[] = clean($db, $product['link']);

		$card_product_tmp = array();
		$card_product_tmp['title'] = clean($db, $product['title']);
		$card_product_tmp['image'] = "/uploads/".$data['creator']."_".$data['id']."_product_".$count.".jpg";
		$card_product_tmp['description'] = $product['description'];
		$card_product_tmp['button'] = clean($db, $product['button']);
		$card_product_tmp['link'] = clean($db, $product['link']);

		$card_products[] = $card_product_tmp;
		$count++;
	}
	$card_products_heading = clean($db, $product_info['section_title']);
	$card_products_position = clean($db, $product_info['section_position']);
	$card_products_visibility = clean($db, $product_info['is_visible']);

	$offers = mysqli_query($db, 'select * from card_offers_section where card_id='.$id);
	$offer_info = mysqli_fetch_array($offers);
	$card_offers = array();
	$card_offer_title = array(); $card_offer_image = array(); $card_offer_description = array(); 
	$card_offer_button = array(); $card_offer_button_link = array(); 
	$count = 0;
	while($offer = mysqli_fetch_array($offers)) {
		$card_offer_title[] = clean($db, $offer['title']);
		$card_offer_image[] = "/uploads/".$data['creator']."_".$data['id']."_offer_".$count.".jpg";
		$card_offer_description[] = $offer['description'];
		$card_offer_button[] = clean($db, $offer['button']);
		$card_offer_button_link[] = clean($db, $offer['link']);
		$card_offer_mrp[] = $offer['MRP'];
		$card_offer_price[] = $offer['offer_price'];

		$card_offer_tmp = array();
		$card_offer_tmp['title'] = clean($db, $offer['title']);
		$card_offer_tmp['image'] = "/uploads/".$data['creator']."_".$data['id']."_offer_".$count.".jpg";
		$card_offer_tmp['description'] = $offer['description'];
		$card_offer_tmp['button'] = clean($db, $offer['button']);
		$card_offer_tmp['link'] = clean($db, $offer['link']);
		$card_offer_tmp['MRP'] = $offer['MRP'];
		$card_offer_tmp['offer_price'] = $offer['offer_price'];

		$card_offers[] = $card_offer_tmp;
		$count++;
	}
	$card_offers_heading = clean($db, $offer_info['section_title']);
	$card_offers_position = clean($db, $offer_info['section_position']);
	$card_offers_visibility = clean($db, $offer_info['is_visible']);

	$gallery_info = mysqli_fetch_array(mysqli_query($db, 'select * from card_gallery where card_id='.$id));
	$card_gallery = explode(",", $gallery_info['url']);
	$card_gallery_urls = clean($db, $gallery_info['url']);
	$card_gallery_heading = clean($db, $gallery_info['section_title']);
	$card_gallery_position = clean($db, $gallery_info['section_position']);
	$card_gallery_visibility = clean($db, $gallery_info['is_visible']);

	$additional = mysqli_query($db, 'select * from card_additional where card_id='.$id);
	$additional_info = mysqli_fetch_array($additional);
	$card_additional_position = clean($db, $additional_info['section_position']);
	$card_additional = array();
	$card_additional_heading = array(); $card_additional_image = array(); $card_additional_text = array(); $card_additional_visibility = array();
	$count = 0;
	while($addit = mysqli_fetch_array($additional)) {
		$card_additional_heading[] = clean($db, $addit['heading']);
		$card_additional_image[] = clean($db, $addit['image']);
		$card_additional_text[] = clean($db, $addit['text']);
		$card_additional_visibility[] = clean($db, $addit['is_visible']);

		$card_additional_tmp = array();
		$card_additional_tmp['heading'] = clean($db, $addit['heading']);
		$card_additional_tmp['image'] = clean($db, $addit['image']);
		$card_additional_tmp['text'] = clean($db, $addit['text']);
		$card_additional_tmp['visibility'] = clean($db, $addit['is_visible']);

		$card_additional[] = $card_additional_tmp;
		$count++;
	}

	$feedback_info = mysqli_fetch_array(mysqli_query($db, 'select * from card_feedback where card_id='.$id));
	$card_feedback_visibility = $feedback_info['is_visible'];
	$card_feedback_heading = $feedback_info['section_title'];
	$card_feedback_position = $feedback_info['section_position'];
	$feedback = mysqli_query($db, 'select * from card_feedback_entries where card_id='.$id.' order by date desc');
	$card_feedback_entries = array();
	while($feed = mysqli_fetch_array($feedback)) {
		$card_additional_tmp = array();
		$card_additional_tmp['name'] = clean($db, $feed['name']);
		$card_additional_tmp['description'] = clean($db, $feed['description']);
		$card_additional_tmp['rating'] = clean($db, $feed['rating']);
		$card_additional_tmp['date'] = clean($db, $feed['date']);

		$card_feedback_entries[] = $card_additional_tmp;
	}

	$card_order = array();
	$card_order[] = $card_company_position;
	$card_order[] = $card_social_position;
	$card_order[] = $card_payment_position;
	$card_order[] = $card_products_position;
	$card_order[] = $card_offers_position;
	$card_order[] = $card_gallery_position;
	$card_order[] = $card_feedback_position;
	$card_order[] = $card_additional_position;
	sort($card_order);
	for($i = 0; $i < count($card_order); $i++) {
		if($card_order[$i] == $card_company_position)
			$card_order[$i] = 'card_company_position';
		if($card_order[$i] == $card_social_position)
			$card_order[$i] = 'card_social_position';
		if($card_order[$i] == $card_payment_position)
			$card_order[$i] = 'card_payment_position';
		if($card_order[$i] == $card_products_position)
			$card_order[$i] = 'card_products_position';
		if($card_order[$i] == $card_offers_position)
			$card_order[$i] = 'card_offers_position';
		if($card_order[$i] == $card_gallery_position)
			$card_order[$i] = 'card_gallery_position';
		if($card_order[$i] == $card_feedback_position)
			$card_order[$i] = 'card_feedback_position';
		if($card_order[$i] == $card_additional_position)
			$card_order[$i] = 'card_additional_position';
	}
?>