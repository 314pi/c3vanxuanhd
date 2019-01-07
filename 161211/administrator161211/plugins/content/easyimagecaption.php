<?php
/**
 * @package Joomla
 * @subpackage EasyImageCaption
 * @copyright 2009-2011 Thomas Römer
 * @author Thomas Römer <myjoomla@arcor.de>
 * This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2 (GPLv2) of the License, or (at your option) any later version.
 * This plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details <http://www.gnu.org/licenses/>.
 *
 * Uses "PHP Simple HTML DOM Parser" by S.C. Chen <me578022@gmail.com> <http://simplehtmldom.sourceforge.net/>, licensed under The MIT License
 * Contains code snippets from Joomla! plugin "mavikThumbnails" by Vitaliy Marenkov <admin@mavik.com.ua>, licensed under GPLv2
 */

//Joomla security
defined( '_JEXEC' ) or die( 'Restricted access' );

//This will become a Plugin
jimport( 'joomla.event.plugin' );

//Include parser
require_once 'easyimagecaption/simple_html_dom.php';

//Let's go!
class plgContentEasyImageCaption extends JPlugin {
	//Variables to store the parameter settings
	var $param_hide_captions;
	var $param_apply_to_articles;
	var $param_except_articles;
	var $param_except_categories;
	var $param_except_sections;
	var $param_apply_to_images;
	var $param_except_classes;
	var $param_except_ids;
	var $param_minimum_size;
	var $param_caption_tag;
	var $param_copy_img_classes;
	var $param_parse_tags;
	var $param_tags_classes;
	var $param_force_joomla_caption;
	var $param_handle_jce_caption;
	var $param_jce_tooltip_fix;
	var $param_caption_position;
	var $param_expand_width;
	var $param_internal_style_on;
	var $param_style_background;
	var $param_style_color;
	var $param_style_size;
	var $param_style_bold;
	var $param_style_italic;
	var $param_style_align;
	var $param_style_vpadding_text;
	var $param_style_hpadding_text;
	var $param_style_vpadding;
	var $param_style_hpadding;
	var $param_reset_image_margin;
	var $param_comp_joomplu_expand;

	//Even more variables
	var $replace_jce_caption;
	var $exception_found;
	var $html;
	var $caption_text;
	var $width;
	var $align;
	var $margins;
	var $comp;
	var $img_classes_set;
	var $internal_style_1;
	var $internal_style_2;
	var $classes = array();
	var $new_wrap_classes;

	//Standard plugin function
	function plgContentEasyImageCaption( &$subject, $config ) {
		parent::__construct( $subject, $config );
		
		//Parameter variable: hide captions (0) never, (1) on frontpage, (2) in blog view, (3) on both
		$this->param_hide_captions = $this->params->def('hide_captions', 0);
		
		//Parameter variable: apply plugin to introtext (0) no, (1) yes
		$this->param_apply_to_intro = $this->params->def('apply_to_intro', 0);
		
		//Parameter variable: apply plugin to all articles (1) or none (0)
		$this->param_apply_to_articles = $this->params->def('apply_to_articles', 1);
		
		//Parameter variable: except articles with certain ids
		$this->param_except_articles = array_map('trim', preg_split("/[\s,;]+/", $this->params->def('except_articles'))); 
		
		//Parameter variable: except categories with certain ids
		$this->param_except_categories = array_map('trim', preg_split("/[\s,;]+/", $this->params->def('except_categories'))); 
		
		//Parameter variable: except sections with certain ids
		$this->param_except_sections = array_map('trim', preg_split("/[\s,;]+/", $this->params->def('except_sections'))); 

		//Parameter variable: apply plugin to all images (1) or none (0)
		$this->param_apply_to_images = $this->params->def('apply_to_images', 1);
		
		//Parameter variable: except images with specified classes
		$this->param_except_classes = array_map('trim', preg_split("/[\s,;]+/", $this->params->def('except_classes'))); 

		//Parameter variable: except images with specified ids
		$this->param_except_ids = array_map('trim', preg_split("/[\s,;]+/", $this->params->def('except_ids'))); 

		//Parameter variable: Minimum size of "captionized" images
		$this->param_minimum_size = trim($this->params->def('minimum_size'));
		$this->param_minimum_size = abs(intval($this->param_minimum_size)); //integer, no negatives
		
		//Parameter variable: use ALT tag (0) or TITLE tag (1)
		$this->param_caption_tag = $this->params->def('caption_tag', 0);
		
		//Parameter variable: copy image's CSS classes to new wrap
		$this->param_copy_img_classes = $this->params->def('copy_img_classes');
		
		//Parameter variable: parse formatting tags never (0), always (1) or only for certain images (3)
		$this->param_parse_tags = $this->params->def('parse_tags', 0);
		
		//Parameter variable: Formatting tags will be parsed, if the image has one of these classes set
		$this->param_tags_classes = array_map('trim', preg_split("/[\s,;]+/", $this->params->def('tags_classes'))); 
		
		//Parameter variable: Force standard Joomla! caption even if ALT tag is usually used (kind of compatibility option,
		//but get rid of 'caption.js' in your 'index.php' when using it!)
		$this->param_force_joomla_caption = $this->params->def('force_joomla_caption', 0);
		
		//Parameter variable: Handle captions built with JCE caption plugin
		//(another compatibility option: replace DIVs created by the JCE caption plugin or ignore them)
		$this->param_handle_jce_caption = $this->params->def('handle_jce_caption', 0);
		
		//Parameter variable: Delete JCE's tooltip "control characters" (double colon)
		$this->param_jce_tooltip_fix = $this->params->def('jce_tooltip_fix', 1);
		
		//Parameter variable: put caption below (0) or above the image (1)
		$this->param_caption_position = $this->params->def('caption_position', 0);
		
		//Parameter variable: Expand width of new image container
		$this->param_expand_width = trim($this->params->def('expand_width'));
		$this->param_expand_width = abs(intval($this->param_expand_width)); //integer, no negatives
		
		//Parameter variable: Turn on/off internal style
		$this->param_internal_style_on = $this->params->def('use_internal_style', 1);
		
		//Parameter variables: style parameters
		$this->param_style_background = $this->getColorHex($this->params->def('style_background', 'F2F2F2'));
		$this->param_style_color = $this->getColorHex($this->params->def('style_color', '000000'));
		$this->param_style_size = $this->params->def('style_size', 8);
		$this->param_style_size = abs(intval($this->param_style_size)); //integer, no negatives
		$this->param_style_bold = 'normal';
		if($this->params->def('style_bold', 0) == 1) {
			$this->param_style_bold = 'bold';
		}
		$this->param_style_italic = 'normal';
		if($this->params->def('style_italic', 0) == 1) {
			$this->param_style_italic = 'italic';
		}
		$this->param_style_align = 'left';
		if($this->params->def('style_align', 0) == 1) {
			$this->param_style_align = 'center';
		}
		elseif($this->params->def('style_align', 0) == 2) {
			$this->param_style_align = 'right';
		}
		$this->param_style_vpadding_text = $this->params->def('style_vpadding_text', 4);
		$this->param_style_vpadding_text = abs(intval($this->param_style_vpadding_text)); //integer, no negatives
		$this->param_style_hpadding_text = $this->params->def('style_hpadding_text', 8);
		$this->param_style_hpadding_text = abs(intval($this->param_style_hpadding_text)); //integer, no negatives

		$this->param_style_vpadding = $this->params->def('style_vpadding', 0);
		$this->param_style_vpadding = abs(intval($this->param_style_vpadding)); //integer, no negatives
		$this->param_style_hpadding = $this->params->def('style_hpadding', 0);
		$this->param_style_hpadding = abs(intval($this->param_style_hpadding)); //integer, no negatives
		
		$this->param_reset_image_margin = $this->params->def('reset_image_margin', 1);
		
		//Parameter variables: Extension compatibility
		//JoomlaGallery's JoomPlu plugin: Expand width of new image container
		$this->param_comp_joomplu_expand = trim($this->params->def('comp_joomplu_expand'));
		$this->param_comp_joomplu_expand = abs(intval($this->param_comp_joomplu_expand)); //integer, no negatives
	}
	
	//This is where it all happens - manipulating the content before it is displayed
	function onPrepareContent( &$article, &$params, $limitstart ) {
		//Don't "captionize" in certain views
		$view = JRequest::getCmd('view');
		$layout = JRequest::getCmd('layout');
		switch($this->param_hide_captions) {
			case 1:
				if($view == 'frontpage') return;
				break;
			case 2:
				if($layout == 'blog') return;
				break;
			case 3:
				if($view == 'frontpage' OR $layout == 'blog') return;
				break;
		}
		
		//Ignore certain articles, depending on parameter settings (except articles, except categories, except sections)
		$show_article = false;
		switch($this->param_apply_to_articles) {
			case 0:
				if($article->sectionid <> '' AND in_array($article->sectionid, $this->param_except_sections)) {
					$show_article = true;
				}
				if($article->catid <> '' AND in_array($article->catid, $this->param_except_categories)) {
					$show_article = true;
				}
				if($article->id <> '' AND in_array($article->id, $this->param_except_articles)) {
					$show_article = true;
				}
				
				if($show_article == false) return;
				break;
			default:
				if($article->id <> '' AND in_array($article->id, $this->param_except_articles)) return;
				if($article->catid <> '' AND in_array($article->catid, $this->param_except_categories)) return;
				if($article->sectionid <> '' AND in_array($article->sectionid, $this->param_except_sections)) return;
				break;
		}
		
		//Building internal style string
		$this->getInternalStyle();

		//Article text consists of three different strings:
		//	- introtext	= intro part of article only
		//	- fulltext	= the "rest" of the article (i.e. article without the intro part)
		//	- text		= complete article
		for($t = 0; $t <= 2; $t++) {
		
			//Parse the content, generate captions, put back the html
			switch($t) {
				case 0:
					if($this->param_apply_to_intro) {
						$this->html = str_get_html($article->introtext);
						$this->generateCaptions();
						$article->introtext = $this->html->save();
					}
					break;
				case 1:
					$this->html = str_get_html($article->fulltext);
					$this->generateCaptions();
					$article->fulltext = $this->html->save();
					break;
				case 2:
					$this->html = str_get_html($article->text);
					$this->generateCaptions();
					$article->text = $this->html->save();
					break;
			}

			//Delete the parsed HTML
			unset($this->html);
		}
		//print_r($article);
		return '';
	}

	
	
	
	//FUNCTION: Finds all <img> elements and add captions
	function generateCaptions() {
		foreach($this->html->find('img') as $e) {
			//Check exception classes and ids;
			//AND Getting image classes
			$this->checkHTML($e);

			if($this->param_apply_to_images != $this->exception_found) {
				//Preserve hyperlink (<a> tag) wrapping the <img> element
				$e_complete = $this->checkHyperlink($e);
				
				//Check if there is already a image caption div, created by the JCE caption plugin; the next steps are obsolete, if there is one
				if(!$this->checkJCECaption($e_complete)) {
					//Define the tag to take the caption from: usual parameter setting can be overridden by 'Force Joomla! caption' parameter
					if($this->param_caption_tag == 1 OR ($this->param_force_joomla_caption == 1 AND in_array('caption', $this->classes))) {
						$this->caption_text = $this->JCEToolTipFix($e->title);
					}
					else {
						$this->caption_text = $e->alt;
					}
					
					//Compatibility: JoomGallery's JoomPlu plugin
					if(in_array("jg_photo", $this->classes)) {
						$this->comp = 'joomplu';
					}
				}
				else {
					//Get caption text from the JCE div
					$this->caption_text = $this->JCEToolTipFix($e_complete->parent()->last_child()->innertext);
				}
			}
			
			//Start generating caption only if there is text at all and the image is not to be ignored
			if($this->caption_text AND ($this->param_apply_to_images != $this->exception_found)) {
				//Replace special EasyImageCaption control characters (formatting tags) in the text
				$this->replControlChars($e);
			
				//Extract properties from <img> or <div> elements
				//Exit the function if the image is too small
				if($this->getWidth($e) >= $this->param_minimum_size) {
					$this->getAlign($e);
					$this->getMargins($e);
					
					//Delete <style> tag from <img> element if all styles have been deleted in the above function calls
					if(trim($e->style) == '') {
						$e->style = null;
					}

					//Build the wrap's CSS class string
					$this->new_wrap_classes = "easy_img_caption";
					if($this->param_copy_img_classes == 1 AND count($this->classes) > 0) {
						$this->new_wrap_classes .= " " . implode(" ", $this->classes);
					}
					
					//Wrap the new image caption <span> around the <img> element and store the whole thing in a string variable;
					//Put the caption above or below the image
					if($this->param_caption_position == 0) {
						$image_w_caption = '<span class="' . $this->new_wrap_classes . '" style="' . $this->internal_style_1 . 'width:' . $this->width . ';' . $this->align . $this->margins . '">' . $e_complete->outertext . $this->fixJoomslideCaption($e_complete) . '<span class="easy_img_caption_inner" style="' . $this->internal_style_2 . '">' . $this->caption_text . '</span></span>';
					}
					else {
						$image_w_caption = '<span class="' . $this->new_wrap_classes . '" style="' . $this->internal_style_1 . 'width:' . $this->width . ';' . $this->align . $this->margins . $this->fixJoomslideCaption($e_complete) . '"><span class="easy_img_caption_inner" style="' . $this->internal_style_2 . '">' . $this->caption_text . '</span>' . $e_complete->outertext . '</span>';
					}
					
					//Write caption into HTML
					if(!$this->replace_jce_caption) {
						$e_complete->outertext = $image_w_caption;
					}
					else {
						//Simply replace the JCE caption div with the new one
						$e_complete->parent()->outertext = $image_w_caption;
					}
				}
			}
			//Reset some variables for the next run
			$this->classes = array();
			$this->replace_jce_caption = false;
			$this->img_classes_set = false;
			$this->comp = '';
		}
	}
	
	//FUNCTION: Checks the parent elements recursively to find HTML elements with classes or ids that are excepted
	//AND gets the image classes
	function checkHTML($image) {
		$this->exception_found = 0;
	
		//Exit if exception is found
		if(isset($image->class) AND trim($image->class) != '') {
			if(!$this->img_classes_set) {
				$this->classes = explode(' ', $image->class);
				$this->img_classes_set = true;
			}
			
			if(count(array_intersect(explode(' ', $image->class), $this->param_except_classes)) > 0) {
				$this->exception_found = 1;
				return;
			}
		}
		
		if(isset($image->id) AND trim($image->id) != '') {
			if(in_array($image->id, $this->param_except_ids)) {
				$this->exception_found = 1;
				return;
			}
		}
		
		if($image->parent()->tag != 'root') {
			$image = $this->checkHTML($image->parent());
		}
		else {
			return;
		}
	}
	
	//FUNCTION: Determines whether there already is a JCE caption div wrapped around the image; returns true if so
	function checkJCECaption($image) {
		if ($image->parent()->tag == 'div') {
			$wrap = $image->parent();
			if(isset($wrap->class) AND trim($wrap->class) != '') {
				$wrap_classes = explode(' ', $wrap->class);
				if(in_array('jce_caption', $wrap_classes)) {
					if($this->param_handle_jce_caption == 0) {
						$this->replace_jce_caption = true;
					}
					else {
						$this->exception_found = true;
					}
					
					return true;
				}
			}
		}
	}
	
	//FUNCTION: Build the internal style string
	function getInternalStyle() {
		$this->internal_style_1 = 'display:inline-block;line-height:0.5;vertical-align:top;';
		$this->internal_style_2 = 'display:inline-block;line-height:normal;';
	
		if($this->param_internal_style_on) {
			$this->internal_style_1 .= 'background-color:' . $this->param_style_background .
				';text-align:' . $this->param_style_align . ';';
			$this->internal_style_2 .= 'color:' . $this->param_style_color .
				';font-size:' . $this->param_style_size . 'pt' .
				';font-weight:' . $this->param_style_bold .
				';font-style:' . $this->param_style_italic .
				';padding:' . $this->param_style_vpadding_text . "px " . $this->param_style_hpadding_text . "px" .
				';margin:0px;';
			
		}
	}
	
	//Replaces special EasyImageCaption control characters (formatting tags) in the caption text
	function replControlChars($image) {
		if($this->param_parse_tags == 1 OR ($this->param_parse_tags == 2 AND count(array_intersect($this->param_tags_classes, $this->classes)) > 0)) {
			if(substr($image->outertext, -2, 1) == "/") {
				$lb = "<br />";
			}
			else {
				$lb = "<br>";
			}

			$search = array('#\[url]([a-z]+?://){1}(.*?)\[/url]#',
							'#\[url](.*?)\[/url\]#',
							'#\[url=([a-z]+?://){1}(.*?)\](.*?)\[/url]#',
							'#\[url=(.*?)\](.*?)\[/url]#',
							'#\[b](.*?)\[/b\]#',
							'#\[i](.*?)\[/i\]#',
							'#\<u>(.*?)\[/u\]#',
							'#\[br]#'
							) ;
			
			$replace = array('<a href="\1\2">\1\2</a>',
							'<a href="http://\1">\1</a>',
							'<a href="\1\2">\3</a>',
							'<a href="http://\1">\2</a>',
							'<b>\1</b>',
							'<i>\1</i>',
							'<u>\1</u>',
							$lb
							) ;

			$this->caption_text = preg_replace($search, $replace, $this->caption_text);
		}
	}
	
	//FUNCTION: Define the width of the new image caption container, checking (1) the <width> tag of the <img> element,
	//  (2) a width property within a <style> tag and (3) the real image dimensions; adds the 'Expand width' parameter
	//AND return the width of the pure image
	function _getWidth($image) {
		$temp_width = 0;
		$temp_unit = 'px';
		
		preg_match('/\b(\d+)(px|%)?/i', $image->width, $matches);
		if(@$matches[1]) {
			$temp_width = $matches[1];
		}
		if(@$matches[2]) {
			$temp_unit = $matches[2];
		}
		if($temp_unit == '%') $image->width = '100%';

		if(isset($image->style)) {
			preg_match('/\b[^\-]width\s*:\s*(\d+)(px|%)?/i', $image->style, $matches);
			if(@$matches[1]) {
				$temp_width = $matches[1];
			}
			if(@$matches[2]) {
				$temp_unit = $matches[2];
			}

			if($temp_unit == '%') {
				$image->width = '100%';
				$image->style = preg_replace('/\b[^\-]width\s*:\s*(\d+)(px|%)?;?/i', '', $image->style);
			}
		}
		
		$temp_width = abs(intval($temp_width)); //integer, no negatives

		if($temp_width == 0) {
			if(in_array('juimage', $this->classes)) {
				//Compatibility: JUMultithumb generates thumbnails "on the fly" -> path to image may not be altered
				$image_url = $image->src;
			}
			else {
				$image_url = $this->urlToFile($image->src);
			}
			
			$image_params = @getimagesize($image_url);
			if(isset($image->height) AND $image_params[1] != $image->height) {
				//If image is scaled, but only height is specified (rare problem, but happens)
				settype($image->height, "integer");
				$temp_width = round($image_params[0] * $image->height / $image_params[1]);
			}
			else {
				$temp_width = $image_params[0];
			}
		}
		
		//if image width is given in %, it is not possible to add pixels defined in the parameters
		if($temp_unit == 'px') {
			if($this->comp == 'joomplu') {
				//Compatibility: JoomlaGallery's JoomPlu plugin
				$this->width = $temp_width + $this->param_comp_joomplu_expand;
			}
			else {
				$this->width = $temp_width + $this->param_expand_width;
			}
		}
		else {
			$this->width = $temp_width;
			//if image width is given in %, the minimum size parameter has to be ignored, sorry
			$temp_width = $this->param_minimum_size;
		}
		$this->width .= $temp_unit;
		
		return $temp_width;
	}
	
	//FUNCTION: Define the alignment of the new image caption container, checking (1) the <align> tag of the <img> element and
	//  (2) a 'float' property within a <style> tag; the image's <align> tag resp. 'float' property is deleted
	//If there is a JCE caption to be replaced, the alignment will be extracted from the <style> tag of the surrounding div
	function getAlign($image) {
		if($this->comp == 'joomplu') {
			//Compatibility: JoomlaGallery's JoomPlu plugin
			if(in_array("jg_floatleft", $this->classes)) {
				$this->align = "float:left;";
			}
			elseif(in_array("jg_floatright", $this->classes)) {
				$this->align = "float:right;";
			}
			else {
				$this->align = '';
				return;
			}

			$image->class = implode(' ', array_diff($this->classes, array("jg_floatleft", "jg_floatright")));
		}
		else {
			if(!$this->replace_jce_caption) {
				$this->align = $image->align;
				$image->align = null;
			}
			
			//Even if the 'float' property in the images <style> tag is not needed when dealing with JCE caption replacement,
			//this part is necessary, because it deletes the 'float' property from the image
			if(isset($image->style)) {
				preg_match('/\b(float\s*:\s*(left|right);*)/i', $image->style, $matches);
				if(@$matches[2]) {
					$this->align = $matches[2];
					$image->style = str_replace($matches[1], '', $image->style);
				}
			}

			if($this->replace_jce_caption) {
				$this->align = '';
			
				$image = $this->checkHyperlink($image)->parent();
				
				if(isset($image->style)) {
					preg_match('/\b(float\s*:\s*(left|right);*)/i', $image->style, $matches);
					if(@$matches[2]) {
						$this->align = $matches[2];
					}
				}
			}
			
			if($this->align == 'right' OR $this->align == 'left') {
				$this->align = 'float:' . $this->align . ';';
			}
			else {
				$this->align = '';
			}
		}
	}
	
	//FUNCTION: Define the margins of the new image caption container, checking (1) the <hspace>, <vspace> tags of the <img> element and
	//  (2) 'margin' properties within a <style> tag; the image's margins are deleted
	//If there is a JCE caption to be replaced, the margins will be extracted from the <style> tag of the surrounding div
	//If the internal styling is turned on, the margins will be taken from the parameters as long as there are no margins declared in the <img> element
	function getMargins($pimage) {
		$image = $pimage;
		$margin_is_set = false;
	
		if(!$this->replace_jce_caption) {
			if(isset($image->vspace)) {
				$v = $image->vspace;
			}
			else {
				$v = 0;
			}
			if(isset($image->hspace)) {
				$h = $image->hspace;
			}
			else {
				$h = 0;
			}
			
			if(!($v == 0 AND $h == 0)) {
				$this->margins = 'margin:' . $v . 'px ' . $h . 'px;';
				$margin_is_set = true;
			}
			
			$image->vspace = null;
			$image->hspace = null;
		}
		else {
			$image = $this->checkHyperlink($image)->parent();
		}
		
		if(isset($image->style)) {
			preg_match_all('/\b(margin(\-top|\-right|\-bottom|\-left|)\s*:\s*(\d+[a-zA-Z]*\s*)+;*)/i', $image->style, $matches);
			if(@$matches[1]) {
				$this->margins = '';
				foreach($matches[1] as $match) {
					$image->style = str_replace($match, '', $image->style);
					if(substr($match, -1, 1) == ';') {
						$match = substr($match, 0, -1);
					}
					$this->margins .= $match . ';';
				}
				$margin_is_set = true;
			}
		}
		
		if($this->param_internal_style_on) {
			if($margin_is_set == false) {
				$this->margins = 'margin:' . $this->param_style_vpadding . "px " . $this->param_style_hpadding . "px;";
			}
			
			if($this->param_reset_image_margin) {
				if(trim($image->style) != "" AND substr($image->style, -1, 1) != ';') {
					$image->style .= ";";
				}
				
				$image->style .= "margin:0;";
			}
			elseif($this->param_expand_width > 0) {
				if(trim($image->style) != "" AND substr($image->style, -1, 1) != ';') {
					$image->style .= ";";
				}
			
				$image->style .= 'margin-left:' . floor($this->param_expand_width / 2) . 'px;';
			}
			
		}
	}
	
	//FUNCTION: Checks whether the image element is surrounded by a hyperlink <a> element; returns the image element
	//  (together with the <a> element if present)
	function checkHyperlink($image) {
		if ($image->parent()->tag == 'a') {
			return $image->parent();
		}
		else {
			return $image;
		}
	}
	
	//FUNCTION: Build the hexadecimal notation of a color
	function getColorHex($hex) {
		if(substr($hex, 0, 1) != '#') {
			$hex = '#' . $hex;
		}
		$hex = substr($hex, 0, 7);
		
		return $hex;
	}
	
	//FUNCTION: Build the image path
	function urlToFile($url) {
		$siteUri = JFactory::getURI();
		$imgUri = JURI::getInstance($url);
		
		$siteHost = $siteUri->getHost();
		$imgHost = $imgUri->getHost();
		
		$siteHost = preg_replace('/^www\./', '', $siteHost);
		$imgHost = preg_replace('/^www\./', '', $imgHost);
		if (empty($imgHost) || $imgHost == $siteHost) {
			$imgPath = $imgUri->getPath(); 
			
			if ($imgPath[0] == '/')	{
				$siteBase = $siteUri->base();
				$dirSite = substr($siteBase, strpos($siteBase, $siteHost) + strlen($siteHost));
				$url = substr($imgPath, strlen($dirSite));
			}
			$url = urldecode(str_replace('/', DS, $url));
		}
		return $url;
	}

	//JCE tooltip compatibility: Deletes a double colon :: at the end of the caption string (only TITLE) and returns the string;
	//Expl: JCE adds these colons as control characters when using its tooltip function
	function JCEToolTipFix($caption) {
		if($caption >= 2 AND $this->param_jce_tooltip_fix) {
			if(substr($caption, -2) == '::') {
				$caption = substr($caption, 0, -2);
			}
		}
		return $caption;
	}
	
	//JoomSlide plugin compatibility (may work for other plugins using highslide as well);
	//extracts and returns the (hidden) caption span generated by Joomslide to put it inside EasyImageCaptions outer span, so that the caption
	//is shown inside the highslide popup; it gets lost otherwise; the span is deleted at its original position
	function fixJoomslideCaption($e) {
		if(!is_null($e->next_sibling()) AND $e->next_sibling()->tag == 'span') {
			if(isset($e->next_sibling()->class) AND trim($e->next_sibling()->class) == 'highslide-caption') {
				$elmnt = $e->next_sibling()->outertext;
				$e->next_sibling()->outertext = "";
				return $elmnt;
			}
			
			return "";
		}
	}
	
	
	
	
	
	
	
	
	
	
	//FUNCTION: Define the width of the new image caption container, checking (1) the <width> tag of the <img> element,
	//  (2) a width property within a <style> tag and (3) the real image dimensions; checks image borders and padding as well
	//  and adds these pixels if needed; also adds the 'Expand width' parameter
	//AND return the width of the pure image
	//ONLY px IS SUPPORTED; IMAGES WITH % WIDTHS MAY CAUSE PROBLEMS, AS WELL AS BORDER-WIDTHS LIKE "thin" OR "thick"
	function getWidth($image) {
		$temp_width = 0;
		
		//<width> tag
		preg_match('/\b(\d+)(px)?/i', $image->width, $matches);
		if(@$matches[1]) {
			$temp_width = $matches[1];
		}

		//<style> tag: CSS width property
		if(isset($image->style)) {
			preg_match('/\b[^\-]width\s*:\s*(\d+)(px)?/i', $image->style, $matches);
			if(@$matches[1]) {
				$temp_width = $matches[1];
			}
		}
		
		$temp_width = abs(intval($temp_width)); //integer, no negatives

		//get image dimensions
		if($temp_width == 0) {
			if(in_array('juimage', $this->classes)) {
				//Compatibility: JUMultithumb generates thumbnails "on the fly" -> path to image may not be altered
				$image_url = $image->src;
			}
			else {
				$image_url = $this->urlToFile($image->src);
			}
			
			$image_params = @getimagesize($image_url);
			if(isset($image->height) AND $image_params[1] != $image->height) {
				//If image is scaled, but only height is specified (rare problem, but happens)
				$temp_width = round($image_params[0] * intval($image->height) / $image_params[1]);
			}
			else {
				$temp_width = $image_params[0];
			}
		}
		
		//checking, if image border is defined
		if(isset($image->style)) {
			$rb = $lb = 0;
			
			preg_match('/\bborder\s*:\s*(\d+)(px)?/i', $image->style, $matches);
			if(@$matches[1]) {
				$rb = $lb = $matches[1];
			}
			
			preg_match('/\bborder\-right(\-width)?\s*:\s*(\d+)(px)?/i', $image->style, $matches);
			if(@$matches[2]) {
				$rb = $matches[2];
			}
			
			preg_match('/\bborder\-left(\-width)?\s*:\s*(\d+)(px)?/i', $image->style, $matches);
			if(@$matches[2]) {
				$lb = $matches[2];
			}
			
			preg_match('/\bborder\-width\s*:\s*(\d+)(px)?(\s+(\d+)(px)?)?(\s+(\d+)(px)?)?(\s+(\d+)(px)?)?/i', $image->style, $matches);
			if(@$matches[10]) {
				$rb = $matches[4];
				$lb = $matches[10];
			}
			//elseif(@$matches[7]) {
			//	$rb = $lb = $matches[4];
			//}
			elseif(@$matches[4]) {
				$rb = $lb = $matches[4];
			}
			elseif(@$matches[1]) {
				$rb = $lb = $matches[1];
			}
			
			$temp_width = $temp_width + $rb + $lb;
		}
		
		//checking, if image padding is defined
		if(isset($image->style)) {
			$rp = $lp = 0;

			preg_match('/\bpadding\-right(\-width)?\s*:\s*(\d+)(px)?/i', $image->style, $matches);
			if(@$matches[2]) {
				$rp = $matches[2];
			}
			
			preg_match('/\bpadding\-left(\-width)?\s*:\s*(\d+)(px)?/i', $image->style, $matches);
			if(@$matches[2]) {
				$lp = $matches[2];
			}
			
			preg_match('/\bpadding\s*:\s*(\d+)(px)?(\s+(\d+)(px)?)?(\s+(\d+)(px)?)?(\s+(\d+)(px)?)?/i', $image->style, $matches);
			if(@$matches[10]) {
				$rp = $matches[4];
				$lp = $matches[10];
			}
			//elseif(@$matches[7]) {
			//	$rp = $lp = $matches[4];
			//}
			elseif(@$matches[4]) {
				$rp = $lp = $matches[4];
			}
			elseif(@$matches[1]) {
				$rp = $lp = $matches[1];
			}
			
			$temp_width = $temp_width + $rp + $lp;
		}
		
		
		
		
		
		
		if($this->comp == 'joomplu') {
			//Compatibility: JoomlaGallery's JoomPlu plugin
			$this->width = $temp_width + $this->param_comp_joomplu_expand;
		}
		else {
			$this->width = $temp_width + $this->param_expand_width;
		}
		
		$this->width .= "px";
		
		return $temp_width;
	}
	
	
	
	
	
	
	
	
	
}
?>