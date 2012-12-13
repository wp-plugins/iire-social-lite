<?php
// Admin Social Lite Hooks - 12-12-2012

function iire_social_lite_admin_pages() {
	add_menu_page('iiRe Social Lite', 'iiRe Social Lite ', 'administrator', 'iire_admin_social_lite_home', 'iire_admin_social_lite_home');
	add_submenu_page('iire_admin_social_lite_home', 'Widget Settings', 'Widget Settings', 10, 'iire_admin_social_lite_widget', 'iire_admin_social_lite_widget');
	add_submenu_page('iire_admin_social_lite_home', 'Shortcode Settings', 'Shortcode Settings', 10, 'iire_admin_social_lite_shortcode', 'iire_admin_social_lite_shortcode');			
}
add_action('admin_menu', 'iire_social_lite_admin_pages');


function iire_social_lite_admin_enable_js() {
    if (is_admin() && (($_GET['page'] == 'iire_admin_social_lite_widget') || ($_GET['page'] == 'iire_admin_social_lite_shortcode'))  ){
		wp_enqueue_script( 'color-picker', IIRE_SOCIAL_LITE_URL.'includes/admin_colorpicker.js');
		if( !wp_script_is('jquery-ui') ) { 		
			$x = explode('/',IIRE_SOCIAL_LITE_BASENAME);
			$d = "../".IIRE_SOCIAL_LITE_CONTENT_URL."/plugins/".$x[0]."/includes/jquery-ui.min.js";	
			//if (file_exists($d)) {
				wp_enqueue_script( 'jquery-ui', IIRE_SOCIAL_LITE_URL.'includes/jquery-ui.min.js');				
			//} else {
			//	wp_enqueue_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');						
			//}
		}	
    }
	
	 if (is_admin() && ($_GET['page'] == 'iire_admin_social_lite_widget')){
		wp_enqueue_script( 'social-widget', IIRE_SOCIAL_LITE_URL.'includes/admin_iire_social_lite_widget.js');
	}

	 if (is_admin() && ($_GET['page'] == 'iire_admin_social_lite_shortcode')){
		wp_enqueue_script( 'social-widget', IIRE_SOCIAL_LITE_URL.'includes/admin_iire_social_lite_shortcode.js');
	}		
}
add_action('admin_print_scripts', 'iire_social_lite_admin_enable_js');


function iire_social_lite_admin_enable_styles() {
    if ( is_admin() && (($_GET['page'] == 'iire_admin_social_lite_widget') || ($_GET['page'] == 'iire_admin_social_lite_shortcode')) ){
		if( !wp_script_is('jquery-ui_css') ) { 		
			$x = explode('/',IIRE_SOCIAL_LITE_BASENAME);
			$d = "../".IIRE_SOCIAL_LITE_CONTENT_URL."/plugins/".$x[0]."/includes/jquery-ui.css";	
			if (file_exists($d)) {
				wp_enqueue_style( 'jquery-ui_css', IIRE_SOCIAL_LITE_URL.'includes/jquery-ui.css');				
			//} else {
			//	wp_enqueue_style( 'jquery-ui_css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css');						
			//}
		}			
				
    }
}
add_action( 'admin_print_styles', 'iire_social_lite_admin_enable_styles' );


function iire_social_lite_admin_register_head() {
    if (is_admin() && (($_GET['page'] == 'iire_admin_social_lite_widget') || ($_GET['page'] == 'iire_admin_social_lite_shortcode') || ($_GET['page'] == 'iire_admin_social_lite_home'))){
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_LITE_URL.'includes/admin_iire_social_lite_styles.css" />';
	}

    if (is_admin() && (($_GET['page'] == 'iire_admin_social_lite_widget') || ($_GET['page'] == 'iire_admin_social_lite_shortcode'))){
    	echo '<link rel="stylesheet" type="text/css" href="'.IIRE_SOCIAL_LITE_URL.'includes/iire_social_lite_icons.css" />';
    }			
}
add_action('admin_head', 'iire_social_lite_admin_register_head');
?>