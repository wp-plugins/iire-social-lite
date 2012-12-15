<?php 
header('Content-type: text/css');   

	// Shortcode Width/Height
	$wid = 'width: '.$_GET['w'].'px; '; 
	$hgt = 'height: '.$_GET['h'].'px; ';
	
	// Shortcode Vertical
	if ($_GET['o'] == 'vertical') {
		$sz = $_GET['sz'];		
		$sp = $_GET['sp'];
		if ($_GET['ds'] == '1') { 		
			$vw = $sz + $sp;
		} else {
			$vw = $sz;		
		}	
		$vh = ($sz * 7) + ($sp * 7);
		$wid = 'width: '.$vw.'px; '; 
		$hgt = 'height: '.$vh.'px; ';							
	}	

	// Shortcode Padding
	if ($_GET['p'] != '') {		
		$p = explode(',',$_GET['p']);
		$pt = $p[0];
		$pr = $p[1];
		$pb = $p[2];
		$pl = $p[3];						
		$pad = 'padding: '.$p[0].'px '.$p[1].'px '.$p[2].'px '.$p[3].'px; ';
	} else {
		$pad = '';	
	}

	// Shortcode Margin		
	if ($_GET['m'] != '') {		
		$m = explode(',',$_GET['m']);
		$mt = $m[0];
		$mr = $m[1];
		$mb = $m[2];
		$ml = $m[3];						
		$mar = 'margin: '.$m[0].'px '.$m[1].'px '.$m[2].'px '.$m[3].'px; ';
	} else {
		$mar = '';	
	}				

	// Shortcode Background Color?
	if ( $_GET['wbk'] == '1' ) {		
		$wbgc = 'background-color:#'.$_GET['wbgc'].'; ';	
	} else {
		$wbgc = '';	
	}		

	// Shortcode Border Width/Color
	if ( $_GET['wbrs'] != '0' ) {		
		$bor = 'border:#'. $_GET['wbrc'].' '. $_GET['wbrs'].'px solid;';
	} else {
		$bor = '';		
	}	
		
	echo 'div.iire_social_lite_shortcode { position:relative; '.$wid.$hgt.$pad.$mar.$wbgc.$bor.' }';			


	// Shortcode Orientation
	if ($_GET['o'] == 'horizontal') {
		if ($_GET['a'] == 'left') {
			echo 'div.iire_social_lite_shortcode .horizontal { float:left; text-align:left; }';	
		} else {	
			echo 'div.iire_social_lite_shortcode .horizontal { float:right; text-align:right; }';
		}		
	} else {	
		echo 'div.iire_social_lite_shortcode .vertical { float:none; }';
	}	


	$theme = $_GET['theme'];
	$sz = $_GET['sz'];


	// Shortcode Icons & Background Colors
	if ($_GET['bgc'] == '1') {	
		$bg = ' bgcolor';
		$bup = '#'.$_GET['bup'];
		$bov = '#'.$_GET['bov']; 
		echo 'div.iire_social_lite_shortcode .icon'.$sz.'.'.$theme.' { background-color: '.$bup.'; background-image: url('.$_GET['pluginurl'].'themes/'.$theme.'/'.$sz.'_sprite.png); }';
		echo 'div.iire_social_lite_shortcode .icon'.$sz.'.'.$theme.':hover { background-color:'.$bov.'; }';			
	} else {
		$bg = '';
		echo 'div.iire_social_lite_shortcode .icon'.$sz.'.'.$theme.' { background-color: none; background-image: url('.$_GET['pluginurl'].'themes/'.$theme.'/'.$sz.'_sprite.png); }';
		echo 'div.iire_social_lite_shortcode .icon'.$sz.'.'.$theme.':hover { background-color: none; }';			 			
	}		
		


	// Shortcode Icon Spacing			
	echo 'div.iire_social_lite_shortcode .sp'.$_GET['sp'].' { margin:0px '.$_GET['sp'].'px '.$_GET['sp'].'px 0px; }';
	
	
	// Shortcode Icon Dropshadow	
	if ($_GET['ds'] == '1') { 
		$dshz = $_GET['dshz']; 		
		$dsvt = $_GET['dsvt']; 
		$dsblur = $_GET['dsblur']; 						
		$dscolor = $_GET['dscolor']; 
		echo'div.iire_social_lite_shortcode .dropshadow { -moz-box-shadow: '.$dshz.'px '.$dsvt.'px '.$dsblur.'px #'.$dscolor.'; -webkit-box-shadow: '.$dshz.'px '.$dsvt.'px '.$dsblur.'px #'.$dscolor.'; box-shadow: '.$dshz.'px '.$dsvt.'px '.$dsblur.'px #'.$dscolor.'; }';
	}		
	

	// Shortcode Icon Rounded Corners		
	if ($_GET['rc'] == '1') {
		$rc = 'div.iire_social_lite_shortcode roundedcorners';
		$rctl = $_GET['rctl'];
		$rctr = $_GET['rctr']; 
		$rcbl = $_GET['rcbl']; 
		$rcbr = $_GET['rcbr'];  		

		echo 'div.iire_social_lite_shortcode .roundedcorners { 
			border-top-left-radius: '.$rctl.'px;
			border-top-right-radius: '.$rctr.'px;
			border-bottom-left-radius: '.$rcbl.'px;		
			border-bottom-right-radius: '.$rcbr.'px;
			-moz-border-radius-topleft: '.$rctl.'px;
			-moz-border-radius-topright: '.$rctr.'px;
			-moz-border-radius-bottomleft: '.$rcbl.'px;
			-moz-border-radius-bottomright: '.$rcbr.'px;						
			-webkit-border-top-left-radius: '.$rctl.'px;
			-webkit-border-top-right-radius: '.$rctr.'px; 
			-webkit-border-bottom-left-radius: '.$rcbl.'px; 
			-webkit-border-bottom-right-radius: '.$rcbr.'px;						 
		}';
	}
	
	// Shortcode Icon Opacity
	$opacity = $_GET['op'];	
	if ($opacity >= 10 && $opacity < 100) { 
		$opval = $opacity/100;
		echo'div.iire_social_lite_shortcode .opacity { opacity:'.$opval.'; }';			
	}		
?>	