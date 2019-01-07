<?php
/**
* @version		1.0.0
* @package		jDownloads Categories File List
* @copyright	Copyright (C) 2010 Miguel Tuyaré. All rights reserved.
* @devoloper	Tux Merlín - http://www.tuxmerlin.com.ar
* @license		GNU/GPL 3.0
* jDownloads Categories File List Module is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* More information at http://www.gnu.org/copyleft/gpl.html 
*/
defined('_JEXEC') or die();

class JElementCategories extends JElement {

  var   $_name = 'Categories';

  function fetchElement($name, $value, &$node, $control_name)
  {
    
	$db = &JFactory::getDBO();

    $article  = $node->attributes('article');
    $class    = $node->attributes('class');
    if (!$class) {
      $class = "inputbox";
    }

    if (!isset ($article)) {
      // alias for section
      $article = $node->attributes('title');
      if (!isset ($article)) {
        $article = 'content';
      }
    }

    if ($article == 'content') {
     $query = 'SELECT a.*, u.name AS author, u.usertype, cc.title AS category, s.title AS section,' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.			
			' FROM #__content AS a' .
			' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
			' LEFT JOIN #__sections AS s ON s.id = cc.section AND s.scope = "content"' .
			' LEFT JOIN #__users AS u ON u.id = a.created_by' .		
			' WHERE a.state = 1' .			
			' ORDER BY a.title';
	 			
	$db->setQuery($query);
	$options = $db->loadAssocList();	
	}
	
	$listart = array();
	$listart[] = JHTML::_('select.option',  0, JText::_('SELECT ARTICLE') );
	foreach ($options as $option){
		$listart[] = JHTML::_('select.option',  $option['slug'], $option['title'] );
	}
		
	return JHTML::_('select.genericlist',  $listart, ''.$control_name.'['.$name.'][]', 
      'class="inputbox" style="width:250px;" ',
      'value', 'text', $value, $control_name.$name);
  
  }
}
?>