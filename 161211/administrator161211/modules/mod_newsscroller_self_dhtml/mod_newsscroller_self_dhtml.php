<?php
// "Newsscroller Self DHTML for Joomla 1.5"
// Author: Viktor Vogel
// URL: http://joomla-extensions.kubik-rubik.de/
// version 1.5-3-2 (for more details see http://joomla-extensions.kubik-rubik.de/ns-newsscroller-self-dhtml)
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'helper.php');

$bgcolor = $params->def('bgcolor', 1);
$color = $params->def('color');
$colortext = $params->def('colortext');
$colorlink = $params->def('colorlink');
$height = $params->def ('height', 1);
$textalign = $params->def ('textalign', 1);
$width = $params->def('width', 1);
$textsize = $params->def('textsize', 1);
$textweight = $params->def('textweight', 1);
$fontstyle = $params->def('fontstyle', 1);
$copy = $params->def('copy', 1);
$moduleclass_sfx = $params->get('moduleclass_sfx', '');

$html_content = mod_newsscroller_self_dhtmlHelper::srcollcontent($params);

// JS- und CSS Dateien im Head-Bereich einleisen
$document =& JFactory::getDocument();

$css = '#marqueecontainer {position: relative;width:'.$width.'%;height:'.$height.'px;overflow: hidden;padding: 2px;padding-left: 4px;background-color:'.$bgcolor.';}'."\n";
$css .= '#vmarquee {position: absolute; width: 95%; font-size:'.$textsize.'px;}'."\n";
$css .= '#vmarquee h3 {text-align: center; color:'.$color.'; font-size:110%; font-style:'.$fontstyle.'; font-weight:700;padding-top:6px;}'."\n";
$css .= '#vmarquee p {color:'.$colortext.'; font-weight:'.$textweight.';font-style:'.$fontstyle.';text-align:'.$textalign.';}'."\n";
$css .= '#vmarquee p a {color:'.$colorlink.';}'."\n";
$css .= '#vmarqueesmall {text-align: center;color:#666666;font-size:85%;}';

$document->addStyleDeclaration($css);

$path = JModuleHelper::getLayoutPath('mod_newsscroller_self_dhtml', 'default');
if (file_exists($path)) 
{
	require($path);
}

mod_newsscroller_self_dhtmlHelper::javascript($params);