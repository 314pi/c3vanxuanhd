<?php
/* bot_joomLaTeX - A LaTeX plugin for Joomla using joomLaTeX
 * Copyright 2010 Arcadia Research Labs, Inc.
 *
 * This software is licensed under the GNU General Public License
 * located at <http://www.gnu.org/licenses/>.
 *
 * bot_joomLaTeX is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * bot_joomLaTeX is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

defined('_JEXEC') or die('Restricted access'); // disallow direct acccess

jimport( 'joomla.plugin.plugin' );

/*
 * bot_joomLaTeX - A LaTeX plugin for Joomla using joomLaTeX
 * This version has been rewritten and expanded by Alex Matulich
 * from the original version by Pham Minh Tri, which in turn derived
 * from the work of  Theodore Hildebrandt and Andrés Felipe Vargas.
 * Conversion to Joomla! 1.6 by Ian Holden.
 */

define('JOOMLA15', (substr(JVERSION,0,3)=='1.5')); // test for Joomla! 1.5


class plgContentJoomLaTeX extends JPlugin {

	function plgContentJoomLaTeX(&$subject, $params) {
		parent::__construct($subject, $params);
		if (JOOMLA15) {
			$this->_plugin =& JPluginHelper::getPlugin( 'content', 'joomlatex');
			$this->_params = new JParameter( $this->_plugin->params );
		}
	}

	/**
	 * v1.6 prepare content method
	 *
	 * Method is called by the view
	 *
	 * @param	string	Context of the content being passed to the plugin.
	 * @param	object	Content object.  $article->text is also available
	 * @param	object	Content params
	 * @param	int		'Page' number
	 * @since	1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $limitstart) {
		return $this->onPrepareContent( $article, $params, $limitstart);
	}

	function onPrepareContent( &$article, &$params, $page=0 ) {
		if (JOOMLA15) {
			$server =  $this->_params->get('server');
			$imgpath = $this->_params->get('imgpath');
			$use_curl = ($this->_params->get('use_curl') == '1');

		} else {
			$server =  $this->params->def( 'server', 'http://latex.codecogs.com/gif.latex');
			$imgpath = $this->params->def( 'imgpath', '/images/joomlatex');
			$use_curl = ($this->params->def( 'use_curl', '1') == '1');
		}
		$mos_tex_entrytext = $article->text;

		$mos_tex_matches = array();
		if (preg_match_all("/\{tex.+?\/tex\}/", $mos_tex_entrytext, $mos_tex_matches, PREG_PATTERN_ORDER) > 0) {
			foreach ($mos_tex_matches[0] as $mos_tex_match) {
				$showbottext = bot_joomlatex($mos_tex_match, $server, $imgpath, $use_curl);
				$mos_tex_entrytext = str_replace($mos_tex_match, $showbottext, $mos_tex_entrytext);
			}
			$article->text = $mos_tex_entrytext;
		}
		return true;
	}
}


// cURL replacement for file_get_contents()
// This is needed for hosting providers who have disabled
// fopen() when accessing remote files.
//
function curl_file_get_contents(&$url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CRLF, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


function bot_joomlatex($text, $server, $wwwimgpath, $use_curl) {
	// set cache directory path variables
	if ($wwwimgpath) {
		if ($wwwimgpath[0] != '/') $wwwimgpath = '/'.$wwwimgpath;
		$full_path_images= $_SERVER['DOCUMENT_ROOT'].$wwwimgpath;
		if (file_exists($full_path_images))
			$rel_path_images = substr($wwwimgpath, 1);
		else $rel_path_images = $full_path_images = '';
	} else $rel_path_images = $full_path_images = '';

	preg_match_all("#\{tex((\s[:\w]+)*?)\}(.*?)\{/tex\}#si",$text,$tex_matches);

	for ($i=0; $i < count($tex_matches[0]); $i++) {
		$img_relpath = $rel_path_images;
		$img_fullpath = $full_path_images;

		$nocache = $img_fullpath ? false : true;
		$lmargin=' margin-left: 1em;';
		$reflabel = '';

		$pos = strpos($text, $tex_matches[0][$i]);
		$latex_formula = $tex_matches[3][$i];

	// fix any special characters that crept in
		$latex_formula = str_replace('&gt;','>',$latex_formula);
		$latex_formula = str_replace('&#3E;','>',$latex_formula);
		$latex_formula = str_replace('&lt;','<',$latex_formula);
		$latex_formula = str_replace('&#3C;','<',$latex_formula);
		$latex_formula = str_replace('&nbsp;',' ',$latex_formula);
		$latex_formula = str_replace('&amp;','&',$latex_formula);
		$latex_formula = str_replace('<br />',"\n",$latex_formula);

	// compress white space and create formula for URL
		$url_formula = preg_replace("/\s+/", ' ', $latex_formula);
		$url = $server.'?'.rawurlencode($url_formula);

	// process parameters, if any
		$param = explode(' ', trim($tex_matches[1][$i]));
		$outfmt = 'gif';
		foreach ($param as $p) {
			if ($p == 'nocache')
				$nocache = true;
			elseif ($p == 'inline')
				$lmargin = '';
			elseif (!strncasecmp($p, 'label:', 6))
				$reflabel = substr($p, 6);
			elseif (!strncasecmp($p, 'output:', 7)) {
				$outfmt = substr($p, 7);
				switch($outfmt) {
					case 'png':
					//case 'svg': // svg doesn't seem to work in Joomla
						$url = str_replace('gif.latex', $outfmt.'.latex', $url);
						break;
					default: // do nothing, already gif.latex
						$outfmt = 'gif';
				}
			}
		}

	// cache image locally if image path exists
		if ($img_fullpath) {
			$filename = md5($url_formula).'.'.$outfmt;
			$full_path_filename = $img_fullpath.'/'.$filename;

			if (file_exists($full_path_filename)) { // use existing
				$url = $img_relpath.'/'.$filename;
				if ($nocache)
					unlink($full_path_filename);
				else
				// Update file date. If you see an image that
				// is really old, it is likely no longer being
				// used and can be deleted.
					touch($full_path_filename);
			}
			elseif ($nocache == false) { // get new image and save
				$img = $use_curl
					? curl_file_get_contents($url)
					: file_get_contents($url);
				if (file_put_contents($full_path_filename,$img) > 0)
					$url = $img_relpath.'/'.$filename;
			}
		}

	// format formula for img title and alt text
		$alt_formula = htmlentities($latex_formula, ENT_QUOTES);
		$alt_formula = str_replace("\r","&#13;",$alt_formula);
		$alt_formula = str_replace("\n","&#10;",$alt_formula);

	// replace original formula with image
		$text = substr_replace($text,
			'<img src="'.$url
			.'" title="'.$alt_formula.'" alt="'.$alt_formula
			.'" style="vertical-align: middle;'.$lmargin
			.'" />',
			$pos,strlen($tex_matches[0][$i]));

	// surround with label formating if label is defined
		if ($reflabel)
			$text = '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0;"><tr><td rowspan="2" style="padding-right: 1em;">'.$text
			.'</td><td style="width: 99%; border-bottom: 5px dotted #DFEFFF;">&nbsp;</td><td rowspan="2" style="vertical-align: middle; padding: 0 1em 0 1em;"><b>[<a name="#equation'
			.$reflabel.'" style="text-decoration: none;">'
			.$reflabel
			."</a>]</b></td></tr><tr><td>&nbsp;</td></tr></table>\n";
	}
	return $text;
}
?>
