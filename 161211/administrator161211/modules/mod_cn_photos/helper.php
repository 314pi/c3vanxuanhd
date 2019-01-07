<?php

/**
 * @version		1.9
 * @package		mod_cn_photos
 * @author    	Caleb Nance
 * @copyright	Copyright (c) 2009 - 2011 demo.calebnance.com. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 *
 *				helper.php
 */

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class modCN_PhotosHelper
{	
	
	function reindex_array($src) 
	{
    	$new_order = array();
    	$count= count($src);
    	
		for($i=0; $i < $count; $i++){
			foreach($src as $key => $value) {
				if(!array_key_exists($i, $new_order) && !in_array($value, $new_order)):
					$new_order[$i] = $value;
				endif;
			}
	    }

    	return $new_order;
	}

	
	function getPhotos($params)
	{
		$path = $params->get('path', 'modules/mod_cn_photos/gallery');
		$imgdir = $path;
		$allowed_types = array('png','jpg','jpeg','gif');
		$dimg = opendir($imgdir);
		while($imgfile = readdir($dimg)){
			if(in_array(strtolower(substr($imgfile,-3)),$allowed_types)){
				$a_img[] = $imgfile;
			}
		}
		
		// Set the array sort by value name ASC
		asort($a_img);
		
		return $a_img;
		
	}
	
	function getHeader($params)
	{
		// Get Variables
		$modid 	= $params->get('modid', '1');
		$border = $params->get('border', '0');
		$width	= $params->get('width', '150');
		$height	= $params->get('height', '150');
		$color	= $params->get('bordercolor', 'EEEEEEE');
		$sfx	= $params->get('moduleclass_sfx');
		
		// Check if border is set
		if($border == '1'):
			//New Height
			$height = $height + 22;
			$width  = $width + 22;
			$css_code = '.cn_photos'.$sfx.', .slideshow'.$modid.', .slideshow'.$modid.' img { height: '.$height.'px !important; width:'.$width.'px !important; } .slideshow'.$modid.' img { display: none; } ';
			$css_code .= '.slideshow'.$modid.' img { padding: 10px; border: 1px solid #ccc; background-color: #'.$color.'; -moz-border-radius: 10px; -webkit-border-radius: 10px; }';
		else:
			$css_code = '.cn_photos'.$sfx.', .slideshow'.$modid.', .slideshow'.$modid.' img { height: '.$height.'px !important; width:'.$width.'px !important; } .slideshow'.$modid.' img { display: none; } ';
		endif;
		
		return $css_code;
	}
	
	function getShuffle($params)
	{
		// Set variables
		$shuffle_option = $params->get('shuffle', 'tr');
		$width			= $params->get('width', '150');
		$height			= $params->get('height', '150');
		$padding		= '50';
		$width 	+= $padding;
		$height	+= $padding;
		
		switch ($shuffle_option) {
    	
    	case 'tl':
        	return $shuffle = 'shuffle: { top:  -'.$height.', left:  -'.$width.' },';
        	break;
    	case 't':
        	return $shuffle = 'shuffle: { top:  -'.$height.', left:  0 },';
        	break;
    	case 'tr':
        	return $shuffle = 'shuffle: { top:  -'.$height.', left:  '.$width.' },';
        	break;
        case 'r':
        	return $shuffle = 'shuffle: { top:  0, left:  '.$width.' },';
        	break;
        case 'br':
        	return $shuffle = 'shuffle: { top:  '.$height.', left:  '.$width.' },';
        	break;
        case 'b':
        	return $shuffle = 'shuffle: { top:  '.$height.', left:  0 },';
        	break;
        case 'bl':
        	return $shuffle = 'shuffle: { top:  '.$height.', left: -'.$width.' },';
        	break;
        case 'l':
        	return $shuffle = 'shuffle: { top:  0, left: -'.$width.' },';
        	break;
        case 'opl':
        	return $shuffle = 'shuffle: { top:  0, left: -1000 },';
        	break;
        case 'opr':
        	return $shuffle = 'shuffle: { top:  0, left: 1000 },';
        	break;
		}
	}
	


}