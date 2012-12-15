<?php
/*
Plugin Name: iiRe Social Lite 
Plugin URI: http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-lite/
Description: Add basic social media icons and links to your site with a customizable user interface. Facebook, Twitter, Google+, Pinterest, You Tube, RSS, Add to Favorites are supported.
Author: iiRe Productions
Author URI: http://iireproductions.com/
Version: 0.22
Tags: Social Media, Icons, Facebook, Twitter, Google+, Pinterest, YouTube, RSS, Favorites
Copyright (C) 2012 iiRe Productions
*/
	
// ASSIGN VERSION
global $wpdb, $iire_social_lite_version;
$iire_version = "0.22";
$last_modified = "12-15-2012";
	
define ('IIRE_SOCIAL_LITE_FILE', __FILE__);
define ('IIRE_SOCIAL_LITE_BASENAME', plugin_basename(__FILE__));
define ('IIRE_SOCIAL_LITE_PATH', trailingslashit(dirname(__FILE__)));
define ('IIRE_SOCIAL_LITE_URL', trailingslashit(WP_PLUGIN_URL) . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)));
if ( !defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

$c = substr(str_replace(get_option('siteurl'), "",  content_url()), 1);
if ($c != 'wp-content') {
	$contenturl = $c;
} else {
	$contenturl = 'wp-content';			
}
define ('IIRE_SOCIAL_LITE_CONTENT_URL', $contenturl);


// INSTALL / UPGRADE
require_once("iire_social_lite_install.php");
register_activation_hook(__FILE__,'iire_social_lite_install');

// DEACTIVATE
require_once("uninstall.php");
if ( function_exists('iire_social_lite_deactivate') )
register_deactivation_hook( __FILE__, 'iire_social_lite_deactivate' );

// UNINSTALL
if ( function_exists('iire_social_lite_uninstall') )
register_uninstall_hook(__FILE__,'iire_social_lite_uninstall');

// INCLUDES
require_once("includes/iire_social_lite_widget.php");

// ADMIN
require_once("includes/admin_iire_social_lite_hooks.php");
require_once("includes/admin_iire_social_lite_home.php");
require_once("includes/admin_iire_social_lite_widget.php");
require_once("includes/admin_iire_social_lite_shortcode.php");

// HEADER
function iire_social_lite_head() {
	if (! is_admin()) {
	
		global $wpdb;
		global $blog_id;

		$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";

		// GET SETTINGS
		$settings = array();		
		$rs = $wpdb->get_results("SELECT * FROM $table_name");
		foreach ($rs as $row) {
			$settings[$row->option_name] = $row->option_value;
		}

		// Widget Cache
		$cache = $settings['css_cache'];
	
		// Widget Container Width
		$wid = $settings['widget_width'];

		// Widget Container Height 
		$hgt = $settings['widget_height'];		
	
		// Widget Container Orientation
		$ot = $settings['widget_orientation'];

		// Widget Container Orientation
		$align = $settings['widget_align'];		

		// Widget Container Padding
		if ($settings['widget_pad_top'] != '0' || $settings['widget_pad_right'] != '0' || $settings['widget_pad_bottom'] != '0' || $settings['widget_pad_left'] != '0') {		
			$pad = $settings['widget_pad_top'].','.$settings['widget_pad_right'].','.$settings['widget_pad_bottom'].','.$settings['widget_pad_left'];
		} else {
			$pad = '';			
		}	
		
		// Widget Container Margin
		if ($settings['widget_margin_top'] != '0' || $settings['widget_margin_right'] != '0' || $settings['widget_margin_bottom'] != '0' || $settings['widget_margin_left'] != '0') {			
			$mar = $settings['widget_margin_top'].','.$settings['widget_margin_right'].','.$settings['widget_margin_bottom'].','.$settings['widget_margin_left'];
		} else {
			$mar = '';			
		}	

		// Add Widget Background?
		$wbk = $settings['widget_background'];
			
		// Widget Container Background Color
		if ( $settings['widget_bg_color'] == '') {		
			$wbgc = '';
		} else {
			$wbgc= $settings['widget_bg_color'];			
		}	

		// Widget Container Border		
		if ( $settings['widget_border_size'] != '0') {
			$wbrc = $settings['widget_border_color'];
			$wbrs = $settings['widget_border_size'];		
		} else {
			$wbrc = '';
			$wbrs = '';					
		}		

		// Widget Icon Theme
		$th = $settings['widget_icon_theme'];

		// Widget Icon Size
		$sz = $settings['widget_icon_size'];

		// Widget Icon Spacing	
		$sp = $settings['widget_icon_spacing'];

		// Widget Icon Dropshadow	
		$ds = $settings['widget_dropshadow'];
	
		$dshz = $settings['widget_dropshadow_horizontal_offset']; 		
		$dsvt = $settings['widget_dropshadow_vertical_offset']; 
		$dsblur = $settings['widget_dropshadow_blur']; 						
		$dscolor = $settings['widget_dropshadow_color']; 

		// Widget Icon Rounded Corners		
		$rc = $settings['widget_roundedcorners'];
		$rctl = $settings['widget_roundedcorners_topleft'];
		$rctr = $settings['widget_roundedcorners_topright']; 
		$rcbl = $settings['widget_roundedcorners_bottomleft']; 
		$rcbr = $settings['widget_roundedcorners_bottomright']; 		

		// Widget Icon Opacity
		$op = $settings['widget_icon_opacity'];	

		// Widget Icon Background Colors
		$bgc = $settings['widget_icon_bgcolor'];
		$bup = $settings['widget_icon_bgcolor_up'];
		$bov = $settings['widget_icon_bgcolor_hover']; 
	
		$w_styles = 'cache='.$cache.'&w='.$wid.'&h='.$hgt.'&a='.$align.'&o='.$ot.'&p='.$pad.'&m='.$mar.'&wbk='.$wbk.'&wbgc='.$wbgc.'&wbrc='.$wbrc.'&wbrs='.$wbrs.'&theme='.$th.'&sz='.$sz.'&sp='.$sp.'&ds='.$ds.'&dshz='.$dshz.'&dsvt='.$dsvt.'&dsblur='.$dsblur.'&dscolor='.$dscolor.'&rc='.$rc.'&rctl='.$rctl.'&rctr='.$rctr.'&rcbl='.$rcbl.'&rcbr='.$rcbr.'&op='.$op.'&bgc='.$bgc.'&bup='.$bup.'&bov='.$bov.'&pluginurl='.IIRE_SOCIAL_LITE_URL;
		//echo $w_styles;


		// Shortcode Container Width
		$s_wid = $settings['sc_width'];

		// Shortcode Container Height 
		$s_hgt = $settings['sc_height'];		
	
		// Shortcode Container Orientation
		$s_ot = $settings['sc_orientation'];

		// Shortcode Container Orientation
		$s_align = $settings['sc_align'];		

		// Shortcode Container Padding
		if ($settings['sc_pad_top'] != '0' || $settings['sc_pad_right'] != '0' || $settings['sc_pad_bottom'] != '0' || $settings['sc_pad_left'] != '0') {		
			$s_pad = $settings['sc_pad_top'].','.$settings['sc_pad_right'].','.$settings['sc_pad_bottom'].','.$settings['sc_pad_left'];
		} else {
			$s_pad = '';			
		}	
		
		// Shortcode Container Margin
		if ($settings['sc_margin_top'] != '0' || $settings['sc_margin_right'] != '0' || $settings['sc_margin_bottom'] != '0' || $settings['sc_margin_left'] != '0') {			
			$s_mar = $settings['sc_margin_top'].','.$settings['sc_margin_right'].','.$settings['sc_margin_bottom'].','.$settings['sc_margin_left'];
		} else {
			$s_mar = '';			
		}	

		// Add Shortcode Background?
		$s_wbk = $settings['sc_background'];
			
		// Shortcode Container Background Color
		if ( $settings['sc_bg_color'] == '') {		
			$s_wbgc = '';
		} else {
			$s_wbgc= $settings['sc_bg_color'];			
		}	

		// Shortcode Container Border		
		if ( $settings['sc_border_size'] != '0') {
			$s_wbrc = $settings['sc_border_color'];
			$s_wbrs = $settings['sc_border_size'];		
		} else {
			$s_wbrc = '';
			$s_wbrs = '';					
		}		

		// Shortcode Icon Theme
		$s_th = $settings['sc_icon_theme'];

		// Shortcode Icon Size
		$s_sz = $settings['sc_icon_size'];

		// Shortcode Icon Spacing	
		$s_sp = $settings['sc_icon_spacing'];

		// Shortcode Icon Dropshadow	
		$s_ds = $settings['sc_dropshadow'];
	
		$s_dshz = $settings['sc_dropshadow_horizontal_offset']; 		
		$s_dsvt = $settings['sc_dropshadow_vertical_offset']; 
		$s_dsblur = $settings['sc_dropshadow_blur']; 						
		$s_dscolor = $settings['sc_dropshadow_color']; 

		// Shortcode Icon Rounded Corners		
		$s_rc = $settings['sc_roundedcorners'];
		$s_rctl = $settings['sc_roundedcorners_topleft'];
		$s_rctr = $settings['sc_roundedcorners_topright']; 
		$s_rcbl = $settings['sc_roundedcorners_bottomleft']; 
		$s_rcbr = $settings['sc_roundedcorners_bottomright']; 		

		// Shortcode Icon Opacity
		$s_op = $settings['sc_icon_opacity'];	

		// Shortcode Icon Background Colors
		$s_bgc = $settings['sc_icon_bgcolor'];
		$s_bup = $settings['sc_icon_bgcolor_up'];
		$s_bov = $settings['sc_icon_bgcolor_hover']; 	
	
	
		$s_styles = 'cache='.$cache.'&w='.$s_wid.'&h='.$s_hgt.'&a='.$s_align.'&o='.$s_ot.'&p='.$s_pad.'&m='.$s_mar.'&wbk='.$s_wbk.'&wbgc='.$s_wbgc.'&wbrc='.$s_wbrc.'&wbrs='.$s_wbrs.'&theme='.$s_th.'&sz='.$s_sz.'&sp='.$s_sp.'&ds='.$s_ds.'&dshz='.$s_dshz.'&dsvt='.$s_dsvt.'&dsblur='.$s_dsblur.'&dscolor='.$s_dscolor.'&rc='.$s_rc.'&rctl='.$s_rctl.'&rctr='.$s_rctr.'&rcbl='.$s_rcbl.'&rcbr='.$s_rcbr.'&op='.$s_op.'&bgc='.$s_bgc.'&bup='.$s_bup.'&bov='.$s_bov.'&pluginurl='.IIRE_SOCIAL_LITE_URL;
		
		// Live Site		
		wp_enqueue_script( 'social-lite-function', IIRE_SOCIAL_LITE_URL.'includes/iire_social_lite_functions.js');
		wp_enqueue_style( 'iire-social-lite-widget-styles', IIRE_SOCIAL_LITE_URL.'includes/iire_social_lite_widget_styles.php?'.$w_styles);
		wp_enqueue_style( 'iire-social-lite-shortcode-styles', IIRE_SOCIAL_LITE_URL.'includes/iire_social_lite_shortcode_styles.php?'.$s_styles);
		wp_enqueue_style( 'iire-social-lite-widget-sizes', IIRE_SOCIAL_LITE_URL.'includes/iire_social_lite_icons.css');					
	}		
}
add_action('wp_head', 'iire_social_lite_head');


// SHORTCODE 
function iire_social_lite() {
	global $wpdb;
	global $blog_id;

	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";
	
	// GET SETTINGS
	$settings = array();		
	$rs = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($rs as $row) {
		$settings[$row->option_name] = $row->option_value;
	}	

	$sc = '<div id="iire_social_lite_shortcode" class="iire_social_lite_shortcode">';		
	$sc .= stripslashes($settings['sc_output']);
	$sc .= '</div>';		
	return $sc;	
}
add_shortcode('iire_social_lite', 'iire_social_lite');


// SHORTCODE FOR THEME 
function iire_social_lite_theme() {
	global $wpdb;
	global $blog_id;

	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";
	
	// GET SETTINGS
	$settings = array();		
	$rs = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($rs as $row) {
		$settings[$row->option_name] = $row->option_value;
	}	

	echo '<div id="iire_social_lite_shortcode" class="iire_social_lite_shortcode">';		
	echo stripslashes($settings['sc_output']);
	echo '</div>';		
	return;	
}
?>