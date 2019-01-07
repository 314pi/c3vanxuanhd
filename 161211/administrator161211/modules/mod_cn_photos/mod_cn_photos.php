<?php

/**
 * @version		1.9
 * @package		mod_cn_photos
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2011 demo.calebnance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 *
 *				mod_cn_photos.php
 */
 	defined('_JEXEC') or die('Direct Access to this location is not allowed.');
	 
	require_once (dirname(__FILE__).DS.'helper.php');
					
	// Set document
	$document = JFactory::getDocument();
	$document->addStylesheet('modules/mod_cn_photos/css/cn_photos.css');
	$document->addScript('modules/mod_cn_photos/js/jquery-1.6.4.min.js');
	$document->addScript('modules/mod_cn_photos/js/jquery.cycle.all.js');
	
	// Set variables
	$width		= $params->get('width', '150');
	$height		= $params->get('height', '150');
	$path 		= $params->get('path', 'modules/mod_cn_photos/gallery');
	$fx 		= $params->get('fx', 'fade');
	$pause 		= $params->get('pause', '0');
	$next 		= $params->get('next', '0');
	$timeout	= $params->get('timeout', '3000');
	$speed		= $params->get('speed', '1000');
	$modid		= $params->get('modid', '1');
	$random		= $params->get('random', '0');
	$sfx		= $params->get('moduleclass_sfx');
	$base 		= JURI::base();
	
	// Get photos
	$photos = modCN_PhotosHelper::getPhotos($params);
	// Reindex photos in order
	$photos = modCN_PhotosHelper::reindex_array($photos);
	
	// Set total of photos
	$total	= count($photos);
	
	// Set random start image for nth-child() jQuery
	$random_start = rand(1, $total);
	
	// Check if shuffle is selected for FX
	if($fx == 'shuffle'){ 
		$shuffle = modCN_PhotosHelper::getShuffle($params);
	}
	
	// Set slideshow cycle
	$js_code = "var cnphotos_".$modid." = jQuery.noConflict(); ";
	
	$js_code .= " cnphotos_".$modid."(function() { ";
	$js_code .= " cnphotos_".$modid."('.slideshow".$modid." img').css({ opacity: 0 }); ";
	$js_code .= " setTimeout(function() { ";
	$js_code .= " cnphotos_".$modid."('.slideshow".$modid."')";
	$js_code .= ".cycle({ ";
	
	// Random has to be set first
	if($random == '1'):
		$js_code .= " random:   1, startingSlide: ".$random_start.", ";
	else:
		// Setting this to the last, so it fades in on the first..
		// work around.. I don't like it that much but it works :)
		$starting_slide = $total - 1;
		$js_code .= " startingSlide: ".$starting_slide.", ";
	endif;
	
	// Set FX, speed, & delay
	$js_code .= "fx:    '".$fx."', speed: ".$speed.", delay: -".$timeout.",";

	// If shuffle
	if($fx == 'shuffle'):
		$js_code .= $shuffle;
	endif;
	
	// Check for next on click
	if($next == '1'):
		$js_code .= " next:   '.slideshow".$modid."', ";
	endif;
	
	// Check for pause on hover
	if($pause == '1'):
		$js_code .= " pause: 1, ";
	endif;
	
	// Set timeout (no comma at the end - safe guard)
	$js_code .= " timeout: ".$timeout."});";
	$js_code .= " cnphotos_".$modid."('.slideshow".$modid." img').css({ opacity: 0 }); }, 1000); });";
    
    // Check if none is selected for FX
    if($fx == 'none'):
    
    	// Reset cycle for no effect
    	$js_code = "var cnphotos_".$modid." = jQuery.noConflict(); ";
    	$js_code .= " cnphotos_".$modid."(document).ready(function() { ";
    	$js_code .= " cnphotos_".$modid."('.slideshow".$modid."')";
    	$js_code .= ".cycle({ ";
    	$js_code .= " fx: 'none', ";
    	
    	// Random has to be set first
		if($random == '1'):
			$js_code .= " random:   1, startingSlide: ".$random_start.", ";
		else:
			// Setting this to the last, so it fades in on the first..
			// work around.. I don't like it that much but it works :)
			$starting_slide = $total - 1;
			$js_code .= " startingSlide: ".$starting_slide.", ";
		endif;
		
		// Set speed & delay
		$js_code .= " speed: ".$speed.", delay: -".$timeout.",";
		
    	// Check for next on click
		if($next == '1'):
			$js_code .= " next:   '.slideshow".$modid."', ";
		endif;
		
		// Check for pause on hover
		if($pause == '1'):
			$js_code .= " pause: 1, ";
		endif;
    	$js_code .= " }); });";
    endif;
	$document->addScriptDeclaration($js_code);
	
	// Get CSS
	$css_code = modCN_PhotosHelper::getHeader($params);
	$document->addStyleDeclaration($css_code);
	
	// Get the view
	$mod_view = $params->get('mod_view', 'default');
	
	// Layout of the view
	$module_layout = 'default';
	
	// Checks if photos are empty
	if(empty($photos)) {
		echo '<p>The folder path <br />'. $base . $path .'<br /> is empty.</p><p>Please make sure that there is at least 1 image that is of png, jpg, jpeg, or gif format in the folder listed above.</p><p>If the problem persists, please let me know.</p><p><a href="http://demo.calebnance.com/Contact/Caleb-Nance.html" target="_blank" >Contact Me</a></p>';
		return;
	}
	
	require(JModuleHelper::getLayoutPath('mod_cn_photos', $layout = $module_layout));
	
?>