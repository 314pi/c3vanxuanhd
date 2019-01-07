<?php
/**
 * Copyright (C) 2010  freakedout (www.freakedout.de)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Set flag that this is a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

$param		= new JParameter( $plugin->params );
$backend	= $param->get('backend', '1');

//execute plugin only in frontend
$app =& JFactory::getApplication();
if ( $app->getClientId() === 0 || $backend ) {

$LiveSite = JURI::root();

$use_bg                 = $param->get('use_bg', '1');
$bg_image_select        = $param->get('bg_image', '');
$bg_color               = $param->get('bg_color', 'transparent');
$use_bg_hover           = $param->get('use_bg_hover', '1');
$bg_image_select_hover  = $param->get('bg_image_hover', '');
$bg_color_hover         = $param->get('bg_color_hover', 'transparent');
$width              = $param->get('width', '95px');
$height             = $param->get('height', '30px');
$pad_top            = $param->get('pad_top', '7px');
$pad_right          = $param->get('pad_right', '0');
$pad_bottom         = $param->get('pad_bottom', '0');
$pad_left           = $param->get('pad_left', '7px');
$left_right         = $param->get('left_right', '2');
$left               = $param->get('left', '3px');
$right              = $param->get('right', '3px');
$bottom             = $param->get('bottom', '3px');
$duration           = $param->get('duration', '250');
$show_pos           = $param->get('show_pos', '200');
$transp             = $param->get('transp', '1');
$font_color         = $param->get('font_color', '#676767');
$font_color_hover   = $param->get('font_color_hover', '#4D87C7');
$font_size          = $param->get('font_size', '14px');

if ($use_bg){
	if ($bg_image_select=='-1'){
		$bg_image = '';
	} else if ($bg_image_select==''){
		$bg_image = 'background: url('.$LiveSite.'plugins/system/J2top/arrow.gif) no-repeat scroll 0px 0px;';
	} else {
		$bg_image = 'background: url('.$LiveSite.'images/'.$bg_image_select.') no-repeat scroll 0px 0px;';
	}
} else {$bg_image = '';}
if ($use_bg_hover){
	if ($bg_image_select_hover=='-1'){
		$bg_image_hover = '';
	} else if ($bg_image_select_hover==''){
		$bg_image_hover = 'background: url('.$LiveSite.'plugins/system/J2top/arrow_active.gif) no-repeat scroll 0px 0px;';
	} else {
		$bg_image_hover = 'background: url('.$LiveSite.'images/'.$bg_image_select_hover.') no-repeat scroll 0px 0px;';
	}
} else { $bg_image_hover = ''; }

if ($left_right == 1 ) {
	$left_right = ' left: '.$left;
} else {
	$left_right = ' right: '.$right;
}

// Only render for HTML output
$document = & JFactory::getDocument();
$doctype  = $document->getType();
if ( $doctype !== 'html' ) { return; }

class plgSystemJ2top extends JPlugin
{
	function onAfterRender()
	{
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'J2top' );
		$plugin->params = new JParameter( $this->_plugin->params );

		$lang =& JFactory::getLanguage();
		$lang->load('plg_system_J2top', JURI::root().'administrator');
		
		//text now contains texts for various languages
		$textAll  = trim($plugin->params->get('text', 'Top of page'));
		if( preg_match('!>>!', $textAll)) {
			$aTextT = explode("\n", $textAll);
			$aTextLang = array();
			foreach ($aTextT as &$aaaa) {
				$bbbb = explode(">>", $aaaa);
				if(isset($bbbb[1])){
					$aTextLang[$bbbb[0]] = JText::_($bbbb[1]);
				}
			}
			//get the language and try to find appropriate text
			$langTag = $lang->get('tag');
			if( isset($aTextLang[$langTag])){
				$text = $aTextLang[$langTag];
			} else {
				$text = JText::_('Top of page');
			}
		} else {
			$text  = JText::_($textAll);
		}
		//-------------end language parsing

		//  $text  = JText::_($plugin->params->get('text', 'Top of page'));
		//  $text  = JText::_($text);
			$LiveSite = JURI::root();
			$use_bg = $plugin->params->get('use_bg', '1');
			$bg_image_select = $plugin->params->get('bg_image', '');
			$use_bg_hover = $plugin->params->get('use_bg_hover', '0');
			$bg_image_select_hover = $plugin->params->get('bg_image_hover', '');
		if ($use_bg){
			if ($bg_image_select=='-1'){$bg_image_pre = '';
			}elseif ($bg_image_select==''){$bg_image_pre = '<img src="'.$LiveSite.'plugins/system/J2top/arrow.gif" alt="gototop"/>';
			}else {$bg_image_pre = '<img src="'.$LiveSite.'images/'.$bg_image_select.'" alt="gototop"/>';
			}
		} else {$bg_image_pre = '';}
		if ($use_bg_hover){
			if ($bg_image_select_hover=='-1'){$bg_image_hover_pre = '';
			}elseif ($bg_image_select_hover==''){$bg_image_hover_pre = '<img src="'.$LiveSite.'plugins/system/J2top/arrow_active.gif" alt="gototop"/>';
			}else {$bg_image_hover_pre = '<img src="'.$LiveSite.'images/'.$bg_image_select_hover.'" alt="gototop"/>';
			}
		} else {$bg_image_hover_pre = '';}

		$pageURL = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
 
		// reset $pageURL if sh404SEF is installed and enabled
		jimport('joomla.filesystem.file');
		if (JFile::exists( 'administrator/components/com_sh404sef/config/config.sef.php' )) {
		$sefConfig = & shRouter::shGetConfig();
		if ( $sefConfig->Enabled == 1 ){
			$pageURL = '';
		}
		}
		// retrieve the page HTML
		$_body = JResponse::getBody();
		// get the body tag '<body id="..." class="..." >
		$regex = '(<body[^>]*>)';
		preg_match($regex, $_body, $body_tag);
		// inject the scrollto anchor right behind the body tag
		$_s = $body_tag[0];
		$_r = $body_tag[0].'<a id="top"></a>
			<div class="preload">'.$bg_image_pre.$bg_image_hover_pre.'
			</div>
			<div id="gototop" style="display:none"><a id="gototop_link" href="'.$pageURL.'#top" title="'.$text.'"><span id="gototop_button">'.$text.'</span></a></div>';
		$_body = str_replace( $_s, $_r, $_body );
		JResponse::setBody( $_body );

	}
}

$document->addCustomTag('<!--[if lte IE 6]><script src="plugins/system/J2top/fixed.js" type="text/javascript"></script><![endif]-->');
$document->addCustomTag("<script type=\"text/javascript\">if( MooTools.version >= '1.2' ) { 
	window.addEvent('domready',function() {
	new SmoothScroll({ duration: ".$duration." }, window); 
	var gototop = $('gototop');
	gototop.setStyle('opacity','0').setStyle('display','block');
	});
	window.addEvent('scroll',function(e) {
		var gototop = $('gototop');
		if(Browser.Engine.trident4) {
			gototop.setStyles({
				'position': 'absolute',
				'bottom': window.getPosition().y + 10,
				'width': 100
			});
		}
		gototop.fade((window.getScroll().y > ".$show_pos.") ? 'in' : 'out')
	});
} else {
	window.addEvent('domready',function() {
	$('gototop').setStyle('opacity','0');
	new SmoothScroll();
	var Change = new Fx.Style('gototop', 'opacity', {duration:".$duration."});
	var scroll = window.getScrollTop();
	if (scroll > ".$show_pos."){
		if ($('gototop').getStyle('opacity','0') == 0){Change.start(".$transp.");$('gototop').setStyle('display','');}
	}
	});
	window.addEvent('scroll',function(e) {
	var scroll = window.getScrollTop();
	var Change = new Fx.Style('gototop', 'opacity', {duration:".$duration."});
	function Show(){ $('gototop').setStyle('display','');}
	function Hide(){ setTimeout(\"$('gototop').setStyle('display','none')\",".$duration.");}
	if (scroll > ".$show_pos."){
		if ($('gototop').getStyle('opacity','0') == 0){Show();Change.start(".$transp.");}
	} else {
		if ($('gototop').getStyle('opacity','1') == ".$transp."){Change.start(0);Hide();}
	}
	});
}
</script>");

$document->addCustomTag('<style type="text/css">
.preload {display:none;}
#gototop{

width: '.$width.';
height: '.$height.';

position: fixed;
'.$left_right.';
bottom:'.$bottom.';
z-index:1000000;
}
#gototop_link {
text-decoration:none;
border: 0 none;
outline-width:0;
}
#gototop_button{
cursor: pointer;
'.$bg_image.'
background-color: '.$bg_color.';
color: '.$font_color.';
font-size: '.$font_size.';
height: '.$height.';
padding-top: '.$pad_top.';
padding-right: '.$pad_right.';
padding-bottom:'.$pad_bottom.';
padding-left: '.$pad_left.';
text-align: center;
width: '.$width.';
display: block;
}
#gototop_button:hover,#gototop_button:focus,#gototop_button:active, a:hover #gototop_button{
color: '.$font_color_hover.';
'.$bg_image_hover.'
background-color: '.$bg_color_hover.';
}
</style>');
}
