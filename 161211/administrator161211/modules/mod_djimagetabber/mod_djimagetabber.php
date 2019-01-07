<?php
/**
* @version 1.1.4 stable
* @package DJ Image Tabber
* @subpackage DJ Image Tabber Module
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Michal Olczyk - michal.olczyk@design-joomla.eu
*
*
* DJ Image Slider is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* DJ Image Slider is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with DJ Image Slider. If not, see <http://www.gnu.org/licenses/>.
*
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

jimport('joomla.application.component.helper');
if(!JComponentHelper::isEnabled('com_djimageslider', true)){
	$mainframe->enqueueMessage(JText::_('No component'),'error');
	return;
}
$slides = modDJImageTabberHelper::getImagesFromDJImageSlider($params);
if($slides==null) {
	$mainframe->enqueueMessage(JText::_('No category or items'),'error');
	return;
}

JHTML::_('behavior.mootools');
$document =& JFactory::getDocument();
$js = JURI::root().'modules/mod_djimagetabber/js/tabber.js';
$document->addScript($js);

if(!is_numeric($width = $params->get('image_width'))) $width = 240;
if(!is_numeric($height = $params->get('image_height'))) $height = 180;
if(!is_numeric($max = $params->get('max_images'))) $max = 20;
$mid = $module->id;

$animationOptions = modDJImageTabberHelper::getAnimationOptions($params);

$js = "window.addEvent('domready',function(){var Tabber$mid = new DJImageTabber('$mid',$animationOptions)});";
$document->addScriptDeclaration($js);

$css = JURI::root().'modules/mod_djimagetabber/tmpl/style.css';
$document->addStyleSheet($css);

$css = modDJImageTabberHelper::getStyleSheet($params,$mid);
$document->addStyleDeclaration($css);

require(JModuleHelper::getLayoutPath('mod_djimagetabber'));
