<?php
// Admin Page for Social Lite Shortcode - 12-15-2012

function iire_admin_social_lite_shortcode() {
	global $wpdb;
	global $blog_id;
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";

	// UPDATE OPTIONS
	if (isset($_POST['sc_icon_theme'])){
		foreach($_POST as $k=>$v){
			if ($k != 'tab') {
				$fields .= $k."='".mysql_escape_string(trim($v))."', ";
				$value = mysql_escape_string(trim($v));		
				$wpdb->query("UPDATE ".$table_name." SET option_value = '$value' WHERE option_name = '$k'");
			}	
		}	
	}		
	
	// GET SETTINGS
	$settings = array();		
	$rs = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($rs as $row) {
		$settings[$row->option_name] = $row->option_value;
	}		


	// Shortcode Theme
	if ($settings['sc_icon_theme'] == '') {
		$th = 'default';
	} else {
		$th = $settings['sc_icon_theme'];
	}		

	// Shortcode Container Orientation
	if ($settings['sc_orientation'] == 'horizontal') { $ot = 'horizontal';	} else { $ot = 'vertical'; }	

	// Shortcode Icon Size
	if ($settings['sc_icon_size'] == '') {
		$iconsize = 'icon32';
		$sz = '32';
	} else {
		$iconsize = 'icon'.$settings['sc_icon_size'];
		$sz = $settings['sc_icon_size'];						
	}		

	// Shortcode Icon Spacing	
	for ( $x = 0; $x <= 25; $x++ ) {
		if ($settings['sc_icon_spacing'] == $x) { $sp = 'sp'.$x; }
	}		

	// Shortcode Icon Dropshadow	
	if ($settings['sc_dropshadow'] == '1') { 
		$ds = ' dropshadow';
	} else {
		$ds = '';
	}		
	$dshz = $settings['sc_dropshadow_horizontal_offset']; 		
	$dsvt = $settings['sc_dropshadow_vertical_offset']; 
	$dsblur = $settings['sc_dropshadow_blur']; 						
	$dscolor = $settings['sc_dropshadow_color']; 

	// Shortcode Icon Rounded Corners		
	if ($settings['sc_roundedcorners'] == '1') {
		$rc = ' roundedcorners';
		$rctl = $settings['sc_roundedcorners_topleft'];
		$rctr = $settings['sc_roundedcorners_topright']; 
		$rcbl = $settings['sc_roundedcorners_bottomleft']; 
		$rcbr = $settings['sc_roundedcorners_bottomright']; 		
	} else {
		$rc = '';	
	}

	// Shortcode Icon Opacity
	$opacity = $settings['sc_icon_opacity'];	
	if ($opacity >= 10 && $opacity < 100) { 
		$op = ' opacity';
		$opval = $opacity/100;
	} else {
		$op = '';
		$opval = "100";		
	}	
	
	// Shortcode Icon Background Colors
	if ($settings['sc_icon_bgcolor'] == '1') {	
		$bg = ' bgcolor';
		$bup = '#'.$settings['sc_icon_bgcolor_up'];
		$bov = '#'.$settings['sc_icon_bgcolor_hover']; 
	} else {
		$bg = '';
		$bup = 'none';
		$bov = 'none'; 			
	}		
		
	//Add Classes											
	$addclasses = $iconsize.' '.$th.' '.$ot.' '.$sp.$ds.$rc.$op.$bg;
?>	

<style>
	div#viewport { width:auto; min-width:680px; min-height:235px; height:auto; padding:10px; background-color:#EDEDED; position:relative; top:0px; left:0px; background-image: url('<?php echo IIRE_SOCIAL_LITE_URL ?>/includes/images/preview_shortcode.png'); background-repeat:no-repeat; background-position: top right;}

	<?php echo $settings['css']; ?>	
	
	.opacity { opacity:<?php echo $opval; ?>; }

	.roundedcorners { 
		border-top-left-radius:<?php echo $rctl; ?>px;
		border-top-right-radius:<?php echo $rctr; ?>px;
		border-bottom-left-radius:<?php echo $rcbl; ?>px;		
		border-bottom-right-radius:<?php echo $rcbr; ?>px;
		-moz-border-radius-topleft:<?php echo $rctl; ?>px;
		-moz-border-radius-topright:<?php echo $rctr; ?>px;
		-moz-border-radius-bottomleft:<?php echo $rcbl; ?>px;
		-moz-border-radius-bottomright:<?php echo $rcbr; ?>px;						
		-webkit-border-top-left-radius:<?php echo $rctl; ?>px;
		-webkit-border-top-right-radius:<?php echo $rctr; ?>px; 
		-webkit-border-bottom-left-radius:<?php echo $rcbl; ?>px; 
		-webkit-border-bottom-right-radius:<?php echo $rcbr; ?>px;						 
	}

	.dropshadow { -moz-box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; -webkit-box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; }	


	/* 24 x 24 Icons */
	.icon24.baseballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/baseballs/24_sprite.png); }
	.icon24.basketballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/basketballs/24_sprite.png); }
	.icon24.bling { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/bling/24_sprite.png); }
	.icon24.branded_leather { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/branded_leather/24_sprite.png); }		
	.icon24.caution_signs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/caution_signs/24_sprite.png); }
	.icon24.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/chrome_panels/24_sprite.png); }
	.icon24.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/circular_cutouts/24_sprite.png); }
	.icon24.computer_keys { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/computer_keys/24_sprite.png); }	
	.icon24.copper { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/copper/24_sprite.png); }	
	.icon24.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/default/24_sprite.png); }
	.icon24.diamond_plate { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/diamond_plate/24_sprite.png); }
	.icon24.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/eco_green/24_sprite.png); }
	.icon24.file_folders { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/file_folders/24_sprite.png); }		
	.icon24.footballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/footballs/24_sprite.png); }		
	.icon24.glossy_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_black/24_sprite.png); }
	.icon24.glossy_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_white/24_sprite.png); }
	.icon24.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/gold_bars/24_sprite.png); }
	.icon24.golf_balls { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/golf_balls/24_sprite.png); }
	.icon24.grass { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grass/24_sprite.png); }	
	.icon24.grunge_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_black/24_sprite.png); }	
	.icon24.grunge_colors { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_colors/24_sprite.png); }
	.icon24.half_tone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/half_tone/24_sprite.png); }
	.icon24.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/iphone/24_sprite.png); }
	.icon24.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/light_bulbs/24_sprite.png); }		
	.icon24.music_staff { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/music_staff/24_sprite.png); }
	.icon24.neon_blue { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_blue/24_sprite.png); }
	.icon24.neon_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_green/24_sprite.png); }
	.icon24.neon_pink { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_pink/24_sprite.png); }
	.icon24.octagons { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/octagons/24_sprite.png); }
	.icon24.on_sale_blue { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_blue/24_sprite.png); }
	.icon24.on_sale_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_green/24_sprite.png); }
	.icon24.on_sale_red { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_red/24_sprite.png); }
	.icon24.on_sale_yellow { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_yellow/24_sprite.png); }
	.icon24.orange_slices { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/orange_slices/24_sprite.png); }
	.icon24.paper_burnt { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_burnt/24_sprite.png); }
	.icon24.paper_ruled { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_ruled/24_sprite.png); }
	.icon24.poloroids { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/poloroids/24_sprite.png); }
	.icon24.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/post_it_notes/24_sprite.png); }	
	.icon24.postage_stamps { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/postage_stamps/24_sprite.png); }
	.icon24.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/punch_thru/24_sprite.png); }
	.icon24.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/red_alert/24_sprite.png); }	
	.icon24.shields { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/shields/24_sprite.png); }
	.icon24.stars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stars/24_sprite.png); }	
	.icon24.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stickers/24_sprite.png); }								
	.icon24.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_black/24_sprite.png); }
	.icon24.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_gray/24_sprite.png); }
	.icon24.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_white/24_sprite.png); }
	.icon24.water { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/water/24_sprite.png); }		
	.icon24.white_books { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/white_books/24_sprite.png); }
	.icon24.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/wood_crates/24_sprite.png); }

	.ui-sortable .iire-facebook24 { background-position: 0px 0px; }
	.ui-sortable .iire-twitter24 { background-position: -24px 0px; }
	.ui-sortable .iire-googleplus24 { background-position: -48px 0px; }
	.ui-sortable .iire-pinterest24 { background-position: -72px 0px; }
	.ui-sortable .iire-youtube24 { background-position: -96px 0px; }
	.ui-sortable .iire-rss24 { background-position: -120px 0px; }
	.ui-sortable .iire-favorite24 { background-position: -144px 0px; }
	.ui-sortable .iire-blank24 { background-position: -168px 0px; }	

	/* 32 x 32 Icons */
	.icon32.baseballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/baseballs/32_sprite.png); }
	.icon32.basketballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/basketballs/32_sprite.png); }
	.icon32.bling { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/bling/32_sprite.png); }
	.icon32.branded_leather { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/branded_leather/32_sprite.png); }		
	.icon32.caution_signs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/caution_signs/32_sprite.png); }
	.icon32.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/chrome_panels/32_sprite.png); }
	.icon32.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/circular_cutouts/32_sprite.png); }
	.icon32.computer_keys { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/computer_keys/32_sprite.png); }	
	.icon32.copper { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/copper/32_sprite.png); }	
	.icon32.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/default/32_sprite.png); }
	.icon32.diamond_plate { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/diamond_plate/32_sprite.png); }
	.icon32.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/eco_green/32_sprite.png); }
	.icon32.file_folders { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/file_folders/32_sprite.png); }		
	.icon32.footballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/footballs/32_sprite.png); }		
	.icon32.glossy_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_black/32_sprite.png); }
	.icon32.glossy_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_white/32_sprite.png); }
	.icon32.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/gold_bars/32_sprite.png); }
	.icon32.golf_balls { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/golf_balls/32_sprite.png); }
	.icon32.grass { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grass/32_sprite.png); }		
	.icon32.grunge_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_black/32_sprite.png); }	
	.icon32.grunge_colors { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_colors/32_sprite.png); }
	.icon32.half_tone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/half_tone/32_sprite.png); }
	.icon32.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/iphone/32_sprite.png); }
	.icon32.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/light_bulbs/32_sprite.png); }		
	.icon32.music_staff { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/music_staff/32_sprite.png); }
	.icon32.neon_blue { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_blue/32_sprite.png); }
	.icon32.neon_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_green/32_sprite.png); }
	.icon32.neon_pink { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_pink/32_sprite.png); }
	.icon32.octagons { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/octagons/32_sprite.png); }
	.icon32.on_sale_blue { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_blue/32_sprite.png); }
	.icon32.on_sale_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_green/32_sprite.png); }
	.icon32.on_sale_red { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_red/32_sprite.png); }
	.icon32.on_sale_yellow { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_yellow/32_sprite.png); }
	.icon32.orange_slices { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/orange_slices/32_sprite.png); }
	.icon32.paper_burnt { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_burnt/32_sprite.png); }
	.icon32.paper_ruled { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_ruled/32_sprite.png); }
	.icon32.poloroids { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/poloroids/32_sprite.png); }
	.icon32.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/post_it_notes/32_sprite.png); }	
	.icon32.postage_stamps { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/postage_stamps/32_sprite.png); }
	.icon32.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/punch_thru/32_sprite.png); }
	.icon32.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/red_alert/32_sprite.png); }	
	.icon32.shields { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/shields/32_sprite.png); }
	.icon32.stars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stars/32_sprite.png); }	
	.icon32.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stickers/32_sprite.png); }								
	.icon32.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_black/32_sprite.png); }
	.icon32.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_gray/32_sprite.png); }
	.icon32.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_white/32_sprite.png); }
	.icon32.water { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/water/32_sprite.png); }	
	.icon32.white_books { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/white_books/32_sprite.png); }
	.icon32.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/wood_crates/32_sprite.png); }


.ui-sortable .iire-facebook32 { background-position: 0px 0px; }
.ui-sortable .iire-twitter32 { background-position: -32px 0px; }
.ui-sortable .iire-googleplus32 { background-position: -64px 0px; }
.ui-sortable .iire-pinterest32 { background-position: -96px 0px; }
.ui-sortable .iire-youtube32 { background-position: -128px 0px; }
.ui-sortable .iire-rss32 { background-position: -160px 0px; }
.ui-sortable .iire-favorite32 { background-position: -192px 0px; }
.ui-sortable .iire-blank32 { background-position: -224px 0px; }

	/* 48 x 48 Icons */
	.icon48.baseballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/baseballs/48_sprite.png); }
	.icon48.basketballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/basketballs/48_sprite.png); }
	.icon48.bling { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/bling/48_sprite.png); }	
	.icon48.branded_leather { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/branded_leather/48_sprite.png); }	
	.icon48.caution_signs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/caution_signs/48_sprite.png); }
	.icon48.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/chrome_panels/48_sprite.png); }
	.icon48.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/circular_cutouts/48_sprite.png); }
	.icon48.computer_keys { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/computer_keys/48_sprite.png); }	
	.icon48.copper { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/copper/48_sprite.png); }		
	.icon48.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/default/48_sprite.png); }
	.icon48.diamond_plate { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/diamond_plate/48_sprite.png); }
	.icon48.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/eco_green/48_sprite.png); }
	.icon48.file_folders { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/file_folders/48_sprite.png); }		
	.icon48.footballs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/footballs/48_sprite.png); }		
	.icon48.glossy_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_black/48_sprite.png); }
	.icon48.glossy_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_white/48_sprite.png); }
	.icon48.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/gold_bars/48_sprite.png); }
	.icon48.golf_balls { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/golf_balls/48_sprite.png); }
	.icon48.grass { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grass/48_sprite.png); }		
	.icon48.grunge_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_black/48_sprite.png); }	
	.icon48.grunge_colors { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_colors/48_sprite.png); }
	.icon48.half_tone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/half_tone/48_sprite.png); }
	.icon48.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/iphone/48_sprite.png); }
	.icon48.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/light_bulbs/48_sprite.png); }		
	.icon48.music_staff { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/music_staff/48_sprite.png); }
	.icon48.neon_blue { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_blue/48_sprite.png); }
	.icon48.neon_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_green/48_sprite.png); }
	.icon48.neon_pink { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_pink/48_sprite.png); }
	.icon48.octagons { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/octagons/48_sprite.png); }
	.icon48.on_sale_blue { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_blue/48_sprite.png); }
	.icon48.on_sale_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_green/48_sprite.png); }
	.icon48.on_sale_red { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_red/48_sprite.png); }
	.icon48.on_sale_yellow { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_yellow/48_sprite.png); }
	.icon48.orange_slices { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/orange_slices/48_sprite.png); }
	.icon48.paper_burnt { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_burnt/48_sprite.png); }
	.icon48.paper_ruled { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_ruled/48_sprite.png); }
	.icon48.poloroids { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/poloroids/48_sprite.png); }
	.icon48.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/post_it_notes/48_sprite.png); }	
	.icon48.postage_stamps { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/postage_stamps/48_sprite.png); }
	.icon48.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/punch_thru/48_sprite.png); }
	.icon48.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/red_alert/48_sprite.png); }	
	.icon48.shields { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/shields/48_sprite.png); }
	.icon48.stars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stars/48_sprite.png); }	
	.icon48.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stickers/48_sprite.png); }								
	.icon48.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_black/48_sprite.png); }
	.icon48.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_gray/48_sprite.png); }
	.icon48.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_white/48_sprite.png); }
	.icon48.water { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/water/48_sprite.png); }	
	.icon48.white_books { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/white_books/48_sprite.png); }
	.icon48.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/wood_crates/48_sprite.png); }


.ui-sortable .iire-facebook48 { background-position: 0px 0px; }
.ui-sortable .iire-twitter48 { background-position: -48px 0px; }
.ui-sortable .iire-googleplus48 { background-position: -96px 0px; }	
.ui-sortable .iire-pinterest48 { background-position: -144px 0px; }
.ui-sortable .iire-youtube48 { background-position: -192px 0px; }
.ui-sortable .iire-rss48 { background-position: -240px 0px; }
.ui-sortable .iire-favorite48 { background-position: -288px 0px; }
.ui-sortable .iire-blank48 { background-position: -336px 0px; }

		
	/* Icon Hover Colors */
	.icon<?php echo $sz; ?>.baseballs:hover, 
	.icon<?php echo $sz; ?>.basketballs:hover,
	.icon<?php echo $sz; ?>.bling:hover, 
	.icon<?php echo $sz; ?>.branded_leather:hover,		 
	.icon<?php echo $sz; ?>.caution_signs:hover, 
	.icon<?php echo $sz; ?>.chrome_panels:hover, 	
	.icon<?php echo $sz; ?>.circular_cutouts:hover,  
	.icon<?php echo $sz; ?>.computer_keys:hover,
	.icon<?php echo $sz; ?>.copper:hover, 	  		
	.icon<?php echo $sz; ?>.default:hover, 
	.icon<?php echo $sz; ?>.diamond_plate:hover, 	
	.icon<?php echo $sz; ?>.eco_green:hover, 
	.icon<?php echo $sz; ?>.file_folders:hover, 	
	.icon<?php echo $sz; ?>.footballs:hover, 	
	.icon<?php echo $sz; ?>.glossy_black:hover, 
	.icon<?php echo $sz; ?>.glossy_white:hover, 
	.icon<?php echo $sz; ?>.gold_bars:hover, 	 
	.icon<?php echo $sz; ?>.golf_balls:hover, 
	.icon<?php echo $sz; ?>.grass:hover, 	
	.icon<?php echo $sz; ?>.grunge_black:hover, 
	.icon<?php echo $sz; ?>.grunge_colors:hover, 
	.icon<?php echo $sz; ?>.half_tone:hover, 
	.icon<?php echo $sz; ?>.iphone:hover, 	
	.icon<?php echo $sz; ?>.light_bulbs:hover, 
	.icon<?php echo $sz; ?>.music_staff:hover, 
	.icon<?php echo $sz; ?>.neon_blue:hover, 
	.icon<?php echo $sz; ?>.neon_green:hover,
	.icon<?php echo $sz; ?>.neon_pink:hover, 
	.icon<?php echo $sz; ?>.octagons:hover, 
	.icon<?php echo $sz; ?>.on_sale_blue:hover, 
	.icon<?php echo $sz; ?>.on_sale_green:hover, 
	.icon<?php echo $sz; ?>.on_sale_red:hover, 	
	.icon<?php echo $sz; ?>.on_sale_yellow:hover, 
	.icon<?php echo $sz; ?>.orange_slices:hover,			
	.icon<?php echo $sz; ?>.paper_burnt:hover, 
	.icon<?php echo $sz; ?>.paper_ruled:hover,
	.icon<?php echo $sz; ?>.post_it_notes:hover, 	 
	.icon<?php echo $sz; ?>.postage_stamps:hover, 
	.icon<?php echo $sz; ?>.punch_thru:hover, 
	.icon<?php echo $sz; ?>.red_alert:hover, 
	.icon<?php echo $sz; ?>.shields:hover, 
	.icon<?php echo $sz; ?>.stars:hover, 	
	.icon<?php echo $sz; ?>.stickers:hover, 
	.icon<?php echo $sz; ?>.symbols_black, 
	.icon<?php echo $sz; ?>.symbols_gray, 
	.icon<?php echo $sz; ?>.symbols_white,
	.icon<?php echo $sz; ?>.water,	
	.icon<?php echo $sz; ?>.white_books:hover, 	
	.icon<?php echo $sz; ?>.wood_crates:hover { background-color: <?php echo $bov; ?>; }


	/* CHOOSE ICONS */
	li.choose { width:24px; height:24px; margin:0px; padding:0px; display: inline-table; cursor:pointer; }
	li.choose.baseballs { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/baseballs/24_sprite.png); }		
	li.choose.basketballs { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/basketballs/24_sprite.png); }
	li.choose.bling { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/bling/24_sprite.png); }
	li.choose.branded_leather { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/branded_leather/24_sprite.png); }					
	li.choose.caution_signs { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/caution_signs/24_sprite.png); }	
	li.choose.chrome_panels { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/chrome_panels/24_sprite.png); }
	li.choose.circular_cutouts { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/circular_cutouts/24_sprite.png); }
	li.choose.computer_keys { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/computer_keys/24_sprite.png); }
	li.choose.copper { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/copper/24_sprite.png); }		
	li.choose.default { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/default/24_sprite.png); }	
	li.choose.diamond_plate { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/diamond_plate/24_sprite.png); }
	li.choose.eco_green { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/eco_green/24_sprite.png); }
	li.choose.file_folders { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/file_folders/24_sprite.png); }
	li.choose.footballs { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/footballs/24_sprite.png); }
	li.choose.glossy_black { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_black/24_sprite.png); }	
	li.choose.glossy_white { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/glossy_white/24_sprite.png); }
	li.choose.gold_bars { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/gold_bars/24_sprite.png); }
	li.choose.golf_balls { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/golf_balls/24_sprite.png); }
	li.choose.grass { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grass/24_sprite.png); }	
	li.choose.grunge_black { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_black/24_sprite.png); }
	li.choose.grunge_colors { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/grunge_colors/24_sprite.png); }		
	li.choose.half_tone { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/half_tone/24_sprite.png); }
	li.choose.iphone { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/iphone/24_sprite.png); }
	li.choose.light_bulbs { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/light_bulbs/24_sprite.png); }	
	li.choose.music_staff { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/music_staff/24_sprite.png); }
	li.choose.neon_blue { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_blue/24_sprite.png); }
	li.choose.neon_green { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_green/24_sprite.png); }	
	li.choose.neon_pink { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/neon_pink/24_sprite.png); }
	li.choose.octagons { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/octagons/24_sprite.png); }
	li.choose.on_sale_blue { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_blue/24_sprite.png); }
	li.choose.on_sale_green { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_green/24_sprite.png); }	
	li.choose.on_sale_red { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_red/24_sprite.png); }
	li.choose.on_sale_yellow { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/on_sale_yellow/24_sprite.png); }		
	li.choose.orange_slices { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/orange_slices/24_sprite.png); }	
	li.choose.paper_burnt { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_burnt/24_sprite.png); }
	li.choose.paper_ruled { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/paper_ruled/24_sprite.png); }
	li.choose.poloroids { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/poloroids/24_sprite.png); }
	li.choose.post_it_notes { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/post_it_notes/24_sprite.png); }
	li.choose.postage_stamps { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/postage_stamps/24_sprite.png); }		
	li.choose.punch_thru { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/punch_thru/24_sprite.png); }
	li.choose.red_alert { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/red_alert/24_sprite.png); }	
	li.choose.shields { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/shields/24_sprite.png); }	
	li.choose.stars { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stars/24_sprite.png); }	
	li.choose.stickers { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/stickers/24_sprite.png); }						
	li.choose.symbols_black { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_black/24_sprite.png); }
	li.choose.symbols_gray { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_gray/24_sprite.png); }
	li.choose.symbols_white { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/symbols_white/24_sprite.png); }
	li.choose.water { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/water/24_sprite.png); }	
	li.choose.white_books { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/white_books/24_sprite.png); }	
	li.choose.wood_crates { background-image: url(<?php echo IIRE_SOCIAL_LITE_URL ?>themes/wood_crates/24_sprite.png); }

	div#iire_social_sc div.move:hover { background-color: <?php echo $bov; ?>; }
</style>



<div class="wrap" style="min-width:680px;">

<div id="icon_iire"><br></div>	
<h2>iiRe Social Lite - Shortcode Settings</h2>
<input type="hidden" id="plugin_path" name="plugin_path" value="<?php echo IIRE_SOCIAL_LITE_URL; ?>" class="w400">

<form id="settings" method="POST">

<div id="iire_social_panel_tab"><span>&raquo;</span></div>	<!-- RIGHT PANEL TAB-->

<div id="iire_social_panel_right">	<!-- START RIGHT PANEL -->

	<p id="btnholder" style="text-align:center; padding:0px; margin:20px 0px 20px 0px;"> <input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"> <a id="reset" class="reset button-secondary">Reset</a> <a id="preview" href="<?php echo get_option('siteurl'); ?>" target="_blank" class="preview button-secondary" title="Preview will launch in new tab/window!">Preview</a></p>

	<div id="right_panel">	<!-- Start Right Panel Container -->
	
		<!-- Start Theme-->
		<h3 id="icon_theme"><a href="#">Icon Theme</a></h3>
		<div>
			<p><select id="sc_icon_theme" name="sc_icon_theme" class="w185">
				<?php
				$x = explode('/',IIRE_SOCIAL_LITE_BASENAME);
				$d = "../".IIRE_SOCIAL_LITE_CONTENT_URL."/plugins/".$x[0]."/themes/";		
				$subd = glob($d . "*");
				foreach($subd as $f) {
					if(is_dir($f)) {
						$theme = str_replace($d,'',$f);
						$theme_name = ucwords(str_replace('_',' ',$theme));
						echo '<option value="'.$theme.'" ';
						if ($settings['sc_icon_theme'] == $theme ) { echo 'selected'; } 
						echo '>'.$theme_name.'</option>';
 					}
				}
				?>																
			</select></p>
			
			<p><img class="icon_theme" src="<?php echo IIRE_SOCIAL_LITE_URL; ?>themes/<?php echo $settings['sc_icon_theme']; ?>/screenshot.png" width="185" border="0" /></p>
		</div>
	
		
		<!-- Start Icon Sizes -->
		<h3 id="icon_size"><a href="#">Icon Size &amp; Spacing</a></h3>
		<div>

 			<!-- Size -->
			<p><label>Icon Size:</label>			
			<select id="sc_icon_size" name="sc_icon_size" class="w50">
				<option value="24" <?php if ($settings['sc_icon_size'] =='24') { echo 'selected'; } ?>>24</option>
				<option value="32" <?php if ($settings['sc_icon_size'] =='32') { echo 'selected'; } ?>>32</option>
				<option value="48" <?php if ($settings['sc_icon_size'] =='48') { echo 'selected'; } ?>>48</option>
			</select> px
			</p>
			<div id="sc_size" class="slider"></div>
			
			<p>&nbsp;</p>
 			
			<!-- Spacing -->
			<p><label>Icon Spacing:</label>			
			<select id="sc_icon_spacing" name="sc_icon_spacing" class="w50">
				<?php
				for ( $x = 0; $x <= 25; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_icon_spacing'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			<div id="sc_spacing" class="slider"></div>
			
		</div>
 		<!-- End Icon Sizing -->


		<!-- Start Icon Styling -->
		<h3 id="icon_styling"><a href="#">Icon Styling</a></h3>
		<div>

 			<!-- Dropshadow -->
			<p><label>Drop Shadow?</label>		
			<select id="sc_dropshadow" name="sc_dropshadow" class="w70">
				<option value="0" <?php if ($settings['sc_dropshadow'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_dropshadow'] =='1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Shadow Color:</label>	
			<input type="text" id="sc_dropshadow_color" name="sc_dropshadow_color" value="<?php echo $settings['sc_dropshadow_color']; ?>" class="w70 color ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">
			</p>

			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Horizontal Offset:</label>
			<select id="sc_dropshadow_horizontal_offset" name="sc_dropshadow_horizontal_offset" class="w50 ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = -10; $x <= 10; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_dropshadow_horizontal_offset'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>

			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Vertical Offset:</label>
			<select id="sc_dropshadow_vertical_offset" name="sc_dropshadow_vertical_offset" class="w50 ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = -10; $x <= 10; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_dropshadow_vertical_offset'] == $x) { 
						echo 'selected';
					}
					if ($x == 0) {
						echo '>None</option>';
					} else {	
						echo '>'.$x.'</option>';
					}	
				}
				?>												
			</select> px
			</p>
			
			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Blur:</label>
			<select id="sc_dropshadow_blur" name="sc_dropshadow_blur" class="w50 ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 20; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_dropshadow_blur'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>							

			<p class="ds <?php if ($settings['sc_dropshadow'] == '0') { echo 'hidden'; } ?>"><br /><br /></p>
			<p>&nbsp;</p>			

	
 			<!-- Rounded Corners -->
			<p><label>Rounded Corners?</label>			
			<select id="sc_roundedcorners" name="sc_roundedcorners" class="w70">
				<option value="0" <?php if ($settings['sc_roundedcorners'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_roundedcorners'] == '1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Top Left:</label>
			<select id="sc_roundedcorners_topleft" name="sc_roundedcorners_topleft" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_topleft'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>				

			<p class="rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Top Right:</label>
			<select id="sc_roundedcorners_topright" name="sc_roundedcorners_topright" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_topright'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Bottom Left:</label>
			<select id="sc_roundedcorners_bottomleft" name="sc_roundedcorners_bottomleft" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_bottomleft'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] == '0') { echo 'hidden'; } ?>"><label>Bottom Right:</label>
			<select id="sc_roundedcorners_bottomright" name="sc_roundedcorners_bottomright" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_bottomright'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] == '0') { echo 'hidden'; } ?>"><br /><br /></p>			
			<p>&nbsp;</p>
			
			<p><label>Background Color?</label>			
			<select id="sc_icon_bgcolor" name="sc_icon_bgcolor" class="w70">
				<option value="0" <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_icon_bgcolor'] == '1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
	
 			<!-- Background Color -->
			<p class="bg <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"><label>Up State:</label>	
			<input type="text" id="sc_icon_bgcolor_up" name="sc_icon_bgcolor_up" value="<?php echo $settings['sc_icon_bgcolor_up']; ?>" class="w70 bg color <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"></p>

			<p class="bg <?php if ($settings['sc_icon_bgcolor'] =='0') { echo 'hidden'; } ?>"><label>Hover State:</label>	
			<input type="text" id="sc_icon_bgcolor_hover" name="sc_icon_bgcolor_hover" value="<?php echo $settings['sc_icon_bgcolor_hover']; ?>" class="w70 bg color <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"></p>
			
			<p class="bg <?php if ($settings['sc_icon_bgcolor'] =='0') { echo 'hidden'; } ?>"><br />Background colors are best used with the "Symbol" themes.</p>		

			<p>&nbsp;</p>

 			<!-- Opacity -->				
			<p><label>Icon Opacity:</label>	
			<input type="text" id="op" name="sc_icon_opacity" value="<?php echo $settings['sc_icon_opacity']; ?>" class="w50"> %</p>
			<div id="sc_opacity" class="slider"></div>					
			
							
		</div> 
		<!-- End Icons Styling -->
	

		 <!-- Start Icon Links -->
		<h3 id="icon_links"><a href="#">Icon Links</a></h3>
		<div>
 			<!-- Show Title? -->
			<p><label>Show Alt/Title?</label>			
			<select id="link_title" name="link_title" class="w70">
				<option value="0" <?php if ($settings['link_title'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['link_title'] =='1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>

			<p>&nbsp;</p>
			
 			<!-- New Window? -->
			<p><label>Open in New Window?</label>			
			<select id="link_target" name="link_target" class="w70">
				<option value="_self" <?php if ($settings['link_target'] =='_self') { echo 'selected'; } ?>>No</option>
				<option value="_blank" <?php if ($settings['link_target'] =='_blank') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p>&nbsp;</p>
			
 			<!-- No Follow? -->
			<p><label>No Follow?</label>			
			<select id="link_nofollow" name="link_nofollow" class="w70">
				<option value="0" <?php if ($settings['link_nofollow'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['link_nofollow'] =='1') { echo 'selected'; } ?>>Yes</option>			
			</select>
			</p>			
		</div> 
		<!-- End Icon Links -->
	
		
		<!-- Start Icon Container -->	
		<h3 id="sc_container"><a href="#">Shortcode Container</a></h3>
		<div>
			<p><label class="w80">Type:</label>
			<select id="sc_orientation" name="sc_orientation" class="w100">
				<option value="horizontal" <?php if ($settings['sc_orientation'] =='horizontal') { echo 'selected'; } ?>>Horizontal</option>
				<option value="vertical" <?php if ($settings['sc_orientation'] =='vertical') { echo 'selected'; } ?>>Vertical</option>				
			</select>
			</p>
			
			<p>&nbsp;</p>
			
			<p><label>Alignment:</label>
			<select id="sc_align" name="sc_align" class="w70">
				<option value="left" <?php if ($settings['sc_align'] =='left') { echo 'selected'; } ?>>Left</option>
				<option value="right" <?php if ($settings['sc_align'] =='right') { echo 'selected'; } ?>>Right</option>	
			</select>
			</p>

			<p>&nbsp;</p>
									
			<p><label>Width:</label>
			<input type="text" id="ww" name="sc_width" value="<?php echo $settings['sc_width']; ?>" class="w50"> px</p>			
			<div id="sc_width" class="slider"></div>
			
			<p>&nbsp;</p>

			<p><label>Height:</label>
			<input type="text" id="wh" name="sc_height" value="<?php echo $settings['sc_height']; ?>" class="w50"> px</p>			
			<div id="sc_height" class="slider"></div>
			
			<p>&nbsp;</p>				
			
			<p><label>Padding Top:</label><input type="text" id="sc_pad_top" name="sc_pad_top" value="<?php echo $settings['sc_pad_top']; ?>" class="w35 inline"> px</p>
			<p><label>Padding Left:</label><input type="text" id="sc_pad_left" name="sc_pad_left" value="<?php echo $settings['sc_pad_left']; ?>" class="w35 inline"> px</p>
			<p><label>Padding Bottom:</label><input type="text" id="sc_pad_bottom" name="sc_pad_bottom" value="<?php echo $settings['sc_pad_bottom']; ?>" class="w35 inline"> px</p>		
			<p><label>Padding Right:</label><input type="text" id="sc_pad_right" name="sc_pad_right" value="<?php echo $settings['sc_pad_right']; ?>" class="w35 inline"> px</p>

			<p>&nbsp;</p>
			
			<p><label>Margin Top:</label><input type="text" id="sc_margin_top" name="sc_margin_top" value="<?php echo $settings['sc_margin_top']; ?>" class="w35 inline"> px</p>
			<p><label>Margin Left:</label><input type="text" id="sc_margin_left" name="sc_margin_left" value="<?php echo $settings['sc_margin_left']; ?>" class="w35 inline"> px</p>
			<p><label>Margin Bottom:</label><input type="text" id="sc_margin_bottom" name="sc_margin_bottom" value="<?php echo $settings['sc_margin_bottom']; ?>" class="w35 inline"> px</p>			
			<p><label>Margin Right:</label><input type="text" id="sc_margin_right" name="sc_margin_right" value="<?php echo $settings['sc_margin_right']; ?>" class="w35 inline"> px</p>
		</div>
		<!-- End Icon Container -->



		<!-- Start Shortcode Container -->
		<h3 id="sc_styling"><a href="#">Shortcode Container Styling</a></h3>
		<div>
			<!-- Add Background Color -->
			<p><label>Add Background?</label>
			<select id="sc_background" name="sc_background" class="w70">
				<option value="0" <?php if ($settings['sc_background'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_background'] == '1') { echo 'selected'; } ?>>Yes</option>			
			</select>
			</p>

			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>">&nbsp;</p>
		
		
			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>"><label>Background Color:</label>	
			<input type="text" id="sc_bg_color" name="sc_bg_color" value="<?php echo $settings['sc_bg_color']; ?>" class="w70 color"></p>

			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>">&nbsp;</p>

			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>"><label>Border Size:</label>
			<select id="sc_border_size" name="sc_border_size" class="w50">
				<option value="0" <?php if ($settings['sc_border_size'] == '0') { echo 'selected'; } ?>>0</option>
				<option value="1" <?php if ($settings['sc_border_size'] == '1') { echo 'selected'; } ?>>1</option>
				<option value="2" <?php if ($settings['sc_border_size'] == '2') { echo 'selected'; } ?>>2</option>
				<option value="3" <?php if ($settings['sc_border_size'] == '3') { echo 'selected'; } ?>>3</option>
				<option value="4" <?php if ($settings['sc_border_size'] == '4') { echo 'selected'; } ?>>4</option>	
				<option value="5" <?php if ($settings['sc_border_size'] == '5') { echo 'selected'; } ?>>5</option>
				<option value="6" <?php if ($settings['sc_border_size'] == '6') { echo 'selected'; } ?>>6</option>
				<option value="7" <?php if ($settings['sc_border_size'] == '7') { echo 'selected'; } ?>>7</option>
				<option value="8" <?php if ($settings['sc_border_size'] == '8') { echo 'selected'; } ?>>8</option>
				<option value="9" <?php if ($settings['sc_border_size'] == '9') { echo 'selected'; } ?>>9</option>
				<option value="10" <?php if ($settings['sc_border_size'] == '10') { echo 'selected'; } ?>>10</option>																																																
			</select> px
			</p>			

			<p class="addbg wbs <?php if ($settings['sc_background'] == '0' || $settings['sc_border_size'] == '0' ) { echo 'hidden'; } ?>"><label>Border Color:</label>	
			<input type="text" id="sc_border_color" name="sc_border_color" value="<?php echo $settings['sc_border_color']; ?>" class="w70 color"></p>


			<p>&nbsp;</p>
			
			<p>Custom CSS:</p>				
			<textarea id="sc_css" name="sc_css" cols="20" rows="3" class="w100p h120"><?php echo $settings['sc_css']; ?></textarea>	
		</div>
		<!-- End Shortcode Container -->		


	</div><!-- End Right Panel Container -->

</div>	<!-- END RIGHT PANEL -->






	<h3>Shortcode Designer <span class="instructions">(Double-click icon to edit link and title... Drag icon to change position... Drag to Trash to remove.)</span></h3>

	<div id="viewport">
		<?php
		$wid = 'width:'.$settings['sc_width'].'px; '; 
		$hgt = 'height:'.$settings['sc_height'].'px; ';
		
		if ($settings['sc_pad_top'] != '0' || $settings['sc_pad_right'] != '0' || $settings['sc_pad_bottom'] != '0' || $settings['sc_pad_left'] != '0') {		
			$pad = 'padding: '.$settings['sc_pad_top'].'px '.$settings['sc_pad_right'].'px '.$settings['sc_pad_bottom'].'px '.$settings['sc_pad_left'].'px; ';
		} else {
			$pad = '';			
		}	
		
		if ($settings['sc_margin_top'] != '0' || $settings['sc_margin_right'] != '0' || $settings['sc_margin_bottom'] != '0' || $settings['sc_margin_left'] != '0') {			
			$mar = 'margin: '.$settings['sc_margin_top'].'px '.$settings['sc_margin_right'].'px '.$settings['sc_margin_bottom'].'px '.$settings['sc_margin_left'].'px; ';
		} else {
			$mar = '';			
		}	
		
		if ($settings['sc_background'] == '0') {		
			$bdg = 'background: none; ';
		} else {
			$bdg = 'background-color:#'.$settings['sc_bg_color'].'; ';			
		}	
		
		if ( $settings['sc_border_size'] != '0') {
			$bor = 'border:#'.$settings['sc_border_color'].' '.$settings['sc_border_size'].'px solid;';
		} else {
			$bor = '';			
		}						
		
		echo '<div id="iire_social_shortcode" class="iire_social_shortcode" style="'.$wid.$hgt.$pad.$mar.$bdg.$bor.'">'; 
		echo stripslashes($settings['sc_icons']);		
		echo '</div>';		
		?>
		<div id="trash" title="Drop Icon to Remove"></div>
	</div> <!-- End Viewport -->

	<h3>Icons <span class="instructions">(Click an icon below to add it to the Shortcode Designer.)</span></h3>

	<div id="chooseicons">
		<ul id="chooseicons">
			<li class="choose <?php echo $th; ?>" id="iire-facebook" alt="http://facebook.com" title="Facebook" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-twitter" alt="http://twitter.com" title="Twitter" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-googleplus" alt="https://plus.google.com/u/0/110362418117155780512/posts" title="Google +" lang=""></li>				
			<li class="choose <?php echo $th; ?>" id="iire-pinterest" alt="http://pinterest.com" title="Pinterst" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-youtube" alt="http://youtube.com" title="You Tube" lang=""></li>									
			<li class="choose <?php echo $th; ?>" id="iire-rss" alt="<?php echo get_option('siteurl'); ?>/feed.rss" title="RSS Feed" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-favorite" alt="" title="Add to Favorites" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-blank" alt="http://" title="Blank" lang=""></li>										
		</ul>

		<input type="hidden" id="sc_addclasses" name="sc_addclasses" value="<?php echo $addclasses; ?>" class="w400">
	</div>

<p class="submit" align="left"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes">&nbsp;&nbsp;&nbsp;<a id="reset" class="reset button-secondary">Reset</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo get_option('siteurl'); ?>" target="_blank" class="preview button-secondary" title="Preview will launch in new tab/window!">Preview</a></p>

<h3>[iire_social_lite] <span class="instructions">(Add this shortcode to any post or page to include these icons.)</span></h3>


<h3>Quick Start</h3>
<ol>
<li>Add this shortcode [iire_social_lite] to any post or page.</li>
<li>Go to "iiRe Social Icons", "Shortcode Settings".</li>
<li>In the Icons section, click an icon to add it to the Shortcode Designer.</li>
<li>Repeat the previous step to add additional icons.</li>
<li>Double-click each icon in the Shortcode Designer to edit the link and title.</li>
<li>Click "Icon Theme" in the side panel, choose a theme i.e. "Circular Cutouts" or use the "Default" theme.</li>
<li>Click "Save Changes".</li>
<li>Click "Preview" to view the output in the section where you placed the widget!</li>
<li>To quickly reset all the settings, click "Start Over". This will reload all the default values.</li>
</ol>

<p>&nbsp;</p>

<h3>Notes</h3>
<p>The Shortcode Designer works independently!!  You can create vastly different settings for the shortcode (which is best used is a page or post) or the widget (which is best used as a sidebar widget).</p>

<p>Aligning the Shortcode Container to the right will order the icons in reverse. Drag and drop the icons to the desired order.</p>

<p>To include the shortcode in a template, copy this code into the desired location in your template.</p>
<code>
&lt;?php if(function_exists('iire_social_lite_theme')) { iire_social_lite_theme(); } ?&gt;
</code> 


<textarea id="sc_icons" name="sc_icons" cols="20" rows="3" class="h150" style="width:100%; visibility: hidden;"><?php echo stripslashes($settings['sc_icons']); ?></textarea>
<textarea id="sc_output" name="sc_output" cols="20" rows="3" class="h150" style="width:100%;  visibility: hidden;"><?php echo stripslashes($settings['sc_output']); ?></textarea>


<!-- EDIT ICON SETTINGS -->
<div id="editdialog" title="Edit Icon Settings" style="display:none;">
	<p>Enter your site link and a title.</p>
	<p align="left">Link:&nbsp;&nbsp;<input type="text" id="choose_url" value="" class="choose_url" style="display:inline; width:250px"></p>
	<p align="left">Title: <input type="text" id="choose_title" value="" class="choose_title" style="display:inline; width:250px"></p>
	<p align="left"><span id="instructions"></span></p>
	<input type="hidden" value="" class="choose_id">
	<p align="right"><a id="edit_close" class="button-secondary">Close</a></p>			
</div>


</form>

<div id="codepreview" style="visibility: hidden;"><?php echo stripslashes($settings['sc_output']); ?></div>

</div><!-- End Settings -->

</div> <!-- End Wrap -->

<?php
}
?>