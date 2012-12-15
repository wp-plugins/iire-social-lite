<?php
// Updated - 12/15/2012

// DELETE TABLES ON DEACTIVATION
function iire_social_lite_deactivate() {
	global $wpdb;
	global $blog_id;
		
	delete_option("iire_social_lite_version");
	delete_option("iire_social_lite_data");			
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";
	$SQL = "DROP TABLE ".$table_name;		
	mysql_query($SQL) or die("An unexpected error occured.".mysql_error());	
}



// DELETE TABLES ON UNINSTALL
function iire_social_lite_uninstall() {
	global $iire_db_version;
	global $wpdb;
	global $blog_id;
		
	delete_option("iire_social_lite_version");
	delete_option("iire_social_lite_data");		
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social_lite";
	$SQL = "DROP TABLE ".$table_name;		
	mysql_query($SQL) or die("An unexpected error occured.".mysql_error());	
}
?>