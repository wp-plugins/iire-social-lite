<?php
// Social Lite Installation - 12-15-2012

global $iire_social_lite_version;
$iire_social_lite_version = "0.22";

// INSTALL/CREATE TABLES
function iire_social_lite_install() {
	global $wpdb;
	global $iire_social_lite_version;

	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";

	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
	option_id INT(11) NOT NULL AUTO_INCREMENT,
	option_name VARCHAR(255) NOT NULL,
	option_value VARCHAR(4096) NOT NULL,
	PRIMARY KEY  (option_id)	
	);";
	
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');		
	dbDelta($sql);	
	
	$wpdb->print_error();		

	add_option("iire_social_lite_version", $iire_social_lite_version);
	add_option("iire_social_lite_data", '0');	


   //Check for update
   $installed_lite_ver = get_option( "iire_social_lite_version" );
   if( $installed_lite_ver != $iire_social_lite_version ) {
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
		option_id INT(11) NOT NULL AUTO_INCREMENT,
		option_name VARCHAR(255) NOT NULL,
		option_value VARCHAR(4096) NOT NULL,/
		PRIMARY KEY  (option_id)
		);";

		require_once(ABSPATH . 'wp-admin/upgrade-functions.php');		
		dbDelta($sql);
		update_option( "iire_social_lite_version", $iire_social_lite_version ); // Updates WP Options table
	}   
}

function iire_update_social_lite_check() {
    global $wpdb;
	global $iire_social_lite_version;
	global $current_blog;
		
    if (get_site_option('iire_social_lite_version') != $iire_social_lite_version) {
        iire_social_lite_install();
    }
	
	$table = $wpdb->prefix."iire_social_lite";
							
    if (get_site_option('iire_social_lite_data') == '0') {
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('1', 'link_target', '_blank')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('2', 'link_title', '1')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('3', 'link_nofollow', '1')");

		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('4', 'themes', 'baseballs; bling; branded_leather; basketballs; caution_signs; chrome_panels; circle_cutouts; copper; default; diamond_plate; eco_green; file_folders; footballs; glossy_black; glossy_white; gold_bars; golf_balls; grass; grunge_black; grunge_colors; half_tone; iphone; light_bulbs; music_staff; neon_blue; neon_green; neon_pink; octagons; on_sale_blue; on_sale_green; on_sale_red; on_sale_yellow; orange_slices; paper_burnt; paper_ruled; poloroids; post_it_notes; postage_stamps; punch_thru; red_alert; shields; stars; stickers; symbols_black; symbols_gray; symbols_white; water; white_books; wood_crates;')");
	
		// WIDGET	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('5', 'widget_icon_theme', 'default')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('6', 'widget_icon_size', '48')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('7', 'widget_icon_spacing', '10')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('8', 'widget_icon_opacity', '100')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('9', 'widget_icon_bgcolor', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('10', 'widget_icon_bgcolor_up', 'AAFF00')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('11', 'widget_icon_bgcolor_hover', '00AAFF')");			
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('12', 'widget_dropshadow', '1')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('13', 'widget_dropshadow_color', 'AAAAAA')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('14', 'widget_dropshadow_horizontal_offset', '3')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('15', 'widget_dropshadow_vertical_offset', '3')");		
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('16', 'widget_dropshadow_blur', '8')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('17', 'widget_roundedcorners', '1')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('18', 'widget_roundedcorners_topleft', '6')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('19', 'widget_roundedcorners_topright', '6')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('20', 'widget_roundedcorners_bottomleft', '6')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('21', 'widget_roundedcorners_bottomright', '6')");					
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('22', 'widget_orientation', 'horizontal')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('23', 'widget_align', 'left')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('24', 'widget_width', '225')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('25', 'widget_height', '170')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('26', 'widget_pad_top', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('27', 'widget_pad_left', '0')");	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('28', 'widget_pad_bottom', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('29', 'widget_pad_right', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('30', 'widget_margin_top', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('31', 'widget_margin_left', '0')");	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('32', 'widget_margin_bottom', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('33', 'widget_margin_right', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('34', 'widget_background', '0')");					
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('35', 'widget_bg_color', 'FFFFFF')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('36', 'widget_border_color', 'DDDDDD')");		
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('37', 'widget_border_size', '0')");		
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('38', 'widget_css', '')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('39', 'widget_addclasses', 'default horizontal sp10 dropshadow roundedcorners opacity icon48')");	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('40', 'widget_icons', '')");				
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('41', 'widget_output', '')");
	
		// SHORTCODE
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('63', 'sc_icon_theme', 'default')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('64', 'sc_icon_size', '48')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('65', 'sc_icon_spacing', '10')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('66', 'sc_icon_opacity', '100')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('67', 'sc_icon_bgcolor', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('68', 'sc_icon_bgcolor_up', 'AAFF00')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('69', 'sc_icon_bgcolor_hover', '00AAFF')");			
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('70', 'sc_dropshadow', '1')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('71', 'sc_dropshadow_color', 'AAAAAA')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('72', 'sc_dropshadow_horizontal_offset', '3')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('73', 'sc_dropshadow_vertical_offset', '3')");		
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('74', 'sc_dropshadow_blur', '8')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('75', 'sc_roundedcorners', '1')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('76', 'sc_roundedcorners_topleft', '6')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('77', 'sc_roundedcorners_topright', '6')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('78', 'sc_roundedcorners_bottomleft', '6')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('79', 'sc_roundedcorners_bottomright', '6')");					
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('80', 'sc_orientation', 'horizontal')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('81', 'sc_align', 'left')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('82', 'sc_width', '480')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('83', 'sc_height', '56')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('84', 'sc_pad_top', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('85', 'sc_pad_left', '0')");	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('86', 'sc_pad_bottom', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('87', 'sc_pad_right', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('88', 'sc_margin_top', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('89', 'sc_margin_left', '0')");	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('90', 'sc_margin_bottom', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('91', 'sc_margin_right', '0')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('92', 'sc_background', '0')");					
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('93', 'sc_bg_color', 'FFFFFF')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('94', 'sc_border_color', 'DDDDDD')");		
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('95', 'sc_border_size', '0')");	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('96', 'sc_css', '')");
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('97', 'sc_addclasses', 'default horizontal sp10 dropshadow roundedcorners opacity icon48')");	
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('98', 'sc_icons', '')");				
		$wpdb->query("INSERT INTO $table (option_id, option_name, option_value) VALUES ('99', 'sc_output', '')");
		
		add_option("iire_social_lite_data", '1');		
	}			
}
add_action('plugins_loaded', 'iire_update_social_lite_check');
?>