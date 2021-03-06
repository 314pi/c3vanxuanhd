<?php
/**
 * @version 	$Id: mod_jdowloadsfilelist.php v1.0 28-01-2011 Tux Merl�n$
 * @package     Joomla
 * @copyright   Copyright (C) 2011 Miguel Tuyar�. All rights reserved.
 * @contact		http://www.tuxmerlin.com.ar - developer@tuxmerlin.com.ar
 * @license     GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * IMPORTANT!
 * Terms of Use: 
 * If you want to remove the link below it, make a donation at http://www.tuxMerlin.com.ar
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class modjdowloadsfilelistHelper{
	
	
	// Category data
	function getCategoryData($catid){
		// Sanitize
		$catid = (int) $catid;
		$db =& JFactory::getDBO();
		if ($catid == 0){ 
			$query = "SELECT * FROM #__jdownloads_cats WHERE published=1" ;
		} else {
			$query = "SELECT * FROM #__jdownloads_cats WHERE cat_id = ".$catid." AND published=1";
		}	
		$db->setQuery($query);
		$catlist = $db->loadObject();
		return $catlist;
	}
	
	
	// Category files
	function getCategoryFiles($catid){
		// Sanitize
		$catid = (int) $catid;
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM #__jdownloads_files WHERE cat_id = ".$catid." AND published=1";		
		$db->setQuery($query);	
		$filelist = $db->loadObjectList();
		return $filelist;
	}
	
	// Calculate ItemID of jDownloads-component
	function CalcItemid(){
		$db = $db =& JFactory::getDBO();
		$query= "SELECT id from #__menu WHERE link like '%index.php?option=com_jdownloads%' and published = 1";
		$db->setQuery($query);	
		$itemid = $db->loadObject();
		($itemid) ? $itemid = $itemid->id : $itemid = 0;
		return $itemid;	
	}
	
	// Create header scripts and css
	function createHeader($params){
		global $mainframe;
		$back1	 = $params->get('backg1');	
		$back2	 = $params->get('backg2');		
		$backtit = $params->get('backgtitle');
		$coltit  = $params->get('colortitle');
		
		// Load Mootools Accordion
		$header ="<!-- JDownloads Categories File List Module -->"  
				."<script type='text/javascript' >"
				."window.addEvent('domready', function( ){ "
				."   var myAccordion = new Accordion($('tuxaccordion'), 'h3.titletoggler', 'div.elementcontent', { "
				."   opacity: false, "
				."   onActive: function(toggler, element){ "
				." toggler.setStyle('color', '#".$back1."'); "
				."},"
				." onBackground: function(toggler, element){ "
				." toggler.setStyle('color', '#".$back2."');"
				."}"
				."});"
				."});"
				."</script>";
				$mainframe->addCustomHeadTag($header);
    
		// Load CSS
		$css  = '<!-- JDownloads Categories File List Module -->
			<style type="text/css">
			#tuxaccordion {
				margin:0px 0px;
			}
			h3.titletoggler {
				cursor: pointer;
				border: 1px solid #bbb;
				border-right-color: #ddd;
				border-bottom-color: #ddd;
				font-family: "Andale Mono", sans-serif;
				font-size: 12px; ';
	
		(strlen($backtit)==6) ? $css .= 'background: #'.$backtit.'; ' : $css .='';
		(strlen($coltit)==6) ? $css .= 'color: #'.$coltit.'; ' : $css .='color: #000000; ';
	
		$css .='	margin: 0 0 4px 0;
				padding: 3px 5px 1px;
				}
				div.elementcontent p, div.elementcontent h4 {
					margin:0px;
					padding:4px !important;
				}
				.elementcontent{
					padding:5px;
				}
				</style>';
		$mainframe->addCustomHeadTag($css);
	}
	
	// Create output
	function createHTML (&$catlist, &$filelist, $params, &$itemid) {
		// Commons styles	
		$pborder = $params->get('pborderstyle','none');
		$pbckg 	 = $params->get('pbackground','none');
		$psepa	 = $params->get('pmargin','10');	
		$countd	 = $params->get('countdown');	
		$tittext = $params->get('titletext');
		$pag 	 = $params->get('pagination');
		$imgbull = JURI::Base().'images/M_images/arrow.png';
	
		// See is jDownloads is installed!!!
		if (!empty($itemid)){
			// General styles	
			$tsize	= $params->get('titlesize','12');	
			$tback	= $params->get('titleback','none');	
			$tborder = $params->get('titleborderstyle','none');		
			$talign = $params->get('titlealign','left');	
			$ltype = $params->get('listtype','inherit');
			$limg = $params->get('listimage','images/M_images/arrow.png');
			$lmar = $params->get('marginlist','0 0 0 15px');
			$llist = $params->get('linelist','0');	
			$slinks = $params->get('stylelinks','');	
	
			// Intro category description
			$intro = $params->get('showintrotext','0');	
			$introtit = $params->get('introtit','');	
			$introdesc = $params->get('introdesc','');	
			$introsize = $params->get('introsize','10');	
			$introback = $params->get('introback','none');	
			$introborder= $params->get('introborder','none');	
		
			// Category style
			$cdesc	= $params->get('cdescription','0');
			$cimg	= $params->get('cimage','0');		
			$cback  = $params->get('cbackdesc','none');
			$cbord  = $params->get('cborddesc','none');
			$cfsiz  = $params->get('cdescfontsize','10');
			$cfcol  = $params->get('cdescfontcolor','000000');	
			$cfsty1	= $params->get('cdescfontstyle1','none');
			$cfsty2	= $params->get('cdescfontstyle2','none');
			$ccode	= $params->get('ccleancode','0');
			$cword	= (int)$params->get('cworddesc');
			if ($cimg == '1'){ $imgz=getimagesize(JURI::base().'images/jdownloads/catimages/'.$catlist->cat_pic); $heigmin=$imgz[1]+4;}		
		
			// Files links style
			$fdesc	= $params->get('fdescription','0');
			$fback  = $params->get('fbackdesc','none');
			$fbord  = $params->get('fborddesc','none');
			$ffsiz  = $params->get('fdescfontsize','10');
			$ffcol  = $params->get('fdescfontcolor','000000');	
			$ffsty1	= $params->get('fdescfontstyle1','none');
			$ffsty2	= $params->get('fdescfontstyle2','none');
			$fcode	= $params->get('fcleancode','0');	
	
			$html   = '<div class="jdfilelist" style="border: '.$pborder.';background: #'.$pbckg.';padding: '.$psepa.'px;">';		
			if ($intro == '1'){
				$html  .= '<div class="jdfileheader"><h3>'.$introtit.'</h3></div>';
				$html  .= '<div style="font-size:'.$introsize.'px; background: #'.$introback.'; border: '.$introborder.';padding:4px">'.$introdesc.'</div>';
				$html  .= '<h3 style="text-align: '.$talign.'; font-size: '.$tsize.'px; border: '.$tborder.';background: #'.$tback.';">'.$catlist->cat_title.'</h3>';
			}
			if ($cdesc == '1'){		
				$html .='<div style="background: #'.$cback.';padding:4px; font-size: '.$cfsiz.'px;color: #'.$cfcol.';text-transform: '.$cfsty1.';font-style: '.$cfsty2.';border: '.$cbord.';min-height:'.$heigmin.'px">';
				if ($cimg == '1'){
					$html .='<div style=";float:left;padding:2px;margin-right: 5px;border:1px solid #CCC;"><img src="'.JURI::base().'images/jdownloads/catimages/'.$catlist->cat_pic.'" alt="'.$catlist->cat_title.'" title="'.$catlist->cat_title.'"/></div>';
				}
				if ($cword != 0) {
					$html .= modjdowloadsfilelistHelper::cutWord(strip_tags($catlist->cat_description),$cword,$linkcat);
				} else {				
					($ccode == '1') ? $html .= strip_tags($catlist->cat_description) : $html .= $catlist->cat_description ;
				}
				$html .='</div>';
			}	
		
			if ($pag == '1'){
				// With Pagination
				$x = 0;
				$pag=1;
				$html .= "<div id='tuxaccordion'>"; 		
				$html .= '<h3 class="titletoggler"><img src="'.$imgbull.'" alt=" "/> '.$tittext.': '.$pag.'</h3>'
					. '<div class="elementcontent">';
				foreach ($filelist as $file){			
					if($x == $countd){
						$pag=$pag+1;
						$html .='</ul>';		
						$html .= '</div>';
						$html .= '<h3 class="titletoggler"><img src="'.$imgbull.'" alt=" "/> '.$tittext.': '.$pag.'</h3>'
							  . '<div class="elementcontent">';
						$x = 0;
					}
					if ($x == 0){
						if ($ltype == 'img'){
							$html  .= '<ul style="list-style-image: url('.JURI::base(true).'/'.$limg.'); padding: '.$lmar.'">';
						} else {
							$html  .= '<ul style="list-style-type: '.$ltype.'; padding: '.$lmar.'">';						
						}
					}
					$html .= '<li style="line-height: '.$llist.'"><span style="'.$slinks.'"><a href="'.JRoute::_('index.php?option=com_jdownloads&Itemid='.$itemid.'&view=view.download&catid='.$file->cat_id.'&cid='.$file->file_id).'">'.$file->file_title.'</a></span></li>';
					if ($fdesc == '1'){				
						$html .='<div style="background: #'.$fback.';padding:4px; font-size: '.$ffsiz.'px;color: #'.$ffcol.';text-transform: '.$ffsty1.';font-style: '.$ffsty2.';border: '.$fbord.'">';
						($fcode == '1') ? $html .= strip_tags($file->description) : $html .= $file->description ;				
					}			
					$html .= '</div>';
					$x++;
				}
				$html .='</div>';
				$html .='</div>';
			} else {
				// Without pagination
				if ($ltype == 'img'){
					$html  .= '<ul style="list-style-image: url('.JURI::base(true).'/'.$limg.'); padding: '.$lmar.'">';
				} else {
					$html  .= '<ul style="list-style-type: '.$ltype.'; padding: '.$lmar.'">';
				}
				foreach ($filelist as $file){	
					$html .= '<li style="line-height: '.$llist.'"><span style="'.$slinks.'"><a href="'.JRoute::_('index.php?option=com_jdownloads&Itemid='.$itemid.'&view=view.download&catid='.$file->cat_id.'&cid='.$file->file_id).'">'.$file->file_title.'</a></span></li>';
					if ($fdesc == '1'){
						$html .='<div style="background: #'.$fback.';padding:4px; font-size: '.$ffsiz.'px;color: #'.$ffcol.';text-transform: '.$ffsty1.';font-style: '.$ffsty2.';border: '.$fbord.'">';
						($fcode == '1') ? $html .= strip_tags($file->description) : $html .= $file->description ;
						$html .='</div>';
					}
				}
				$html  .= '</ul>';
			}	
			// If you remove this line, you must make a donation
			$html .= base64_decode('PGRpdiBzdHlsZT0iZmxvYXQ6cmlnaHQ7Y29sb3I6I0NDQ0NDQztmb250LXNpemU6ODUlIj48YSBocmVmPSJodHRwOi8vd3d3LnR1eG1lcmxpbi5jb20uYXIiIHRpdGxlPSJUdXggTWVybCYjMjM3O24gRXh0ZW5zaW9ucyIgdGFyZ2V0PSJfYmxhbmsiPiBQb3dlcmVkIGJ5IFR1eCBNZXJsw61uIEV4dGVuc2lvbnM8L2E+PC9kaXY+');
		} else {
			$html   = '<div class="jdfilelist" style="border: '.$pborder.';padding: '.$psepa.'px;">';
			$html  .= '<p><span style="color:#FF0000">WARNING!! - NO EXIST JDOWNLOADS COMPONENT</span></p><p>jDownloads File List Plugins not work</p>';
		}		
		$html .= '</div><br />';			
		return $html;  
	}
	
	
	// Cutting text description
	function cutWord($words,$length,$linkcat) {
		if (strlen($words) > $length) {
			$words = substr($words, 0, $length);
			$last_space = strrpos($words, " ");         
			$words = substr($words, 0, $last_space);
			$words .= "...(".JText::_('VIEW MORE IN SECTION').')'; 
		}
		return $words;
	}
	
}