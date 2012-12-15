<?php
// Admin Social Lite Hooks - 12-15-2012

function iire_social_lite_admin_pages() {
	add_menu_page('iiRe Social Lite', 'iiRe Social Lite ', 'administrator', 'iire_admin_social_lite_home', 'iire_admin_social_lite_home');
	add_submenu_page('iire_admin_social_lite_home', 'Widget Settings', 'Widget Settings', 10, 'iire_admin_social_lite_widget', 'iire_admin_social_lite_widget');
	add_submenu_page('iire_admin_social_lite_home', 'Shortcode Settings', 'Shortcode Settings', 10, 'iire_admin_social_lite_shortcode', 'iire_admin_social_lite_shortcode');			
}
add_action('admin_menu', 'iire_social_lite_admin_pages');


function iire_social_lite_admin_enable_js() {
    if (is_admin() && (($_GET['page'] == 'iire_admin_social_lite_widget') || ($_GET['page'] == 'iire_admin_social_lite_shortcode'))  ){
		wp_enqueue_script( 'color-picker', IIRE_SOCIAL_LITE_URL.'includes/admin_colorpicker.js');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-mouse');	
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-resizable');	
		wp_enqueue_script('jquery-ui-selectable');
		wp_enqueue_script('jquery-ui-sortable');	
		wp_enqueue_script('jquery-ui-effect');	
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('jquery-ui-button');				
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_script('jquery-ui-position');		
		wp_enqueue_script('jquery-ui-slider');		
		wp_enqueue_script('jquery-ui-tabs');				
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
			}
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