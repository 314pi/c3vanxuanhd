<?php
/**
* @version		$Id: mod_jDMTree1.5.5
* @package		DOCMan jDMTree Module for Joomla 1.5
* @copyright	Copyright (C) 2008-2010 youthpole.com. All rights reserved.
* @author     Josh Prakash
* @license		GNU/GPL, see LICENSE.php
* This module is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* * Revisions
* Nov-01-2008 - Security implementation compatible to docman component
* May-13-2009 - SEO url compatability/icons invisible, fixes - jdmtree 1.5.2
* Jul-21-2009 - Category exclusion/inclusion by id options enhancement -jdmtree1.5.3
* Nov-03-2009 - Docman groups (user defined) handling upgrade - jdmtree 1.5.4 
* Feb-26-2010 - Two additional parameter options - 1. Show/Hide View Category Link 2. Folder Link behavior selection - jdmtree 1.5.5
*
* Dec-20-2010 Adapted and modified for jDownloads by Arno Betz
* Version 1.0
*
*/

// no direct access
    defined('_JEXEC') or die('Restricted access');

    require_once(JPATH_SITE.DS.'modules'.DS.'mod_jdownloads_tree' .DS.'jDtree'.DS.'jdownloadstree.php');

    global $Itemid;
    $lang = &JFactory::getLanguage();
    $lang->load('com_jdownloads');    
    
	$user = & JFactory::getUser();
	$db	  =& JFactory::getDBO();
    $menu = &JSite::getMenu();
    $acl  = &JFactory::getACL();

    // get all published single category menu links
    $db->setQuery("SELECT id, link from #__menu WHERE link LIKE 'index.php?option=com_jdownloads&view=viewcategory&catid%' AND published = 1");
    $cat_link_itemids = $db->loadAssocList();
    if ($cat_link_itemids){
        for ($i=0; $i < count($cat_link_itemids); $i++){
             $cat_link_itemids[$i][catid] = substr( strrchr ( $cat_link_itemids[$i][link], '=' ), 1);
        }    
    }
    // search for root menu item to use
    $sql = 'SELECT id FROM #__menu WHERE link = ' . $db->Quote("index.php?option=com_jdownloads&view=viewcategories"). 'AND published = 1' ;
    $db->setQuery($sql);
    if ($results = $db->loadResult()){
        $root_itemid = $results;
    } else {
        $root_itemid = $Itemid;
    }    
    
    $home_url = JRoute::_('index.php?option=com_jdownloads&amp;view=viewcategories&amp;Itemid='.$root_itemid);
    $home_link = '<a href="'.$home_url.'">'.JText::_('JLIST_FRONTEND_HOME_LINKTEXT').'</a>';

    $lengthc    = intval( $params->get( 'lengthc', 20 ) );	 // Max length of category before truncation
    $baseGif = "modules/mod_jdownloads_tree/jDtree/images/base.gif";
    $nodeId = 0;
    $counter = 0;
    $catlink = "";
    $curcat = 0;
    $precat = -1;

    $moduleclass_sfx = ($params->get( 'moduleclass_sfx' ) );
    
    // Category display decisions
 	$catid		= trim( $params->get('catid') );
 	$catoption	= intval( $params->get('catoption', 1 ) );
	
	if ($catid)	{
		$catCondition = ' cat_id '.($catoption ? ' in ':' not in ') .' (' . $catid . ') AND ';
	}

    $access = '';
    if ($user->aid == 0) $access = '01';
    if ($user->aid == 1) $access = '11';
    if ($user->aid == 2) $access = '22';
    if ($user->usertype == 'Super Administrator' || $user->usertype == 'Administrator'){
        $access = '99';
    }
    
    $groups_exists = false;
    $prefix = $db->_table_prefix;
    $tables = array( $prefix.'jdownloads_cats' );
    $result = $db->getTableFields( $tables );
    if ($result[$prefix.'jdownloads_cats']['cat_group_access']) $groups_exists = true;    
    
    // get cat access groups
    if ($user->id){
        $db->setQuery("SELECT id FROM #__jdownloads_groups WHERE FIND_IN_SET($user->id, groups_members)");
        $in_groups = implode(',', $db->loadResultArray());           
    } 
    if (!$in_groups) $in_groups = 999999;


    // Query to retrieve all categories that are published. 
	if ($groups_exists){
        $queryc = "SELECT * FROM #__jdownloads_cats WHERE ".($catid ? $catCondition : '')." published = 1 AND (cat_access <= '$access' OR cat_group_access IN ($in_groups)) ORDER BY parent_id, ordering";
	} else {
        $queryc = "SELECT * FROM #__jdownloads_cats WHERE ".($catid ? $catCondition : '')." published = 1 AND cat_access <= '$access' ORDER BY parent_id, ordering";
    }    
    
    $db->setQuery($queryc);
	$rows = $db->loadObjectList();
		
    $tree = new jdownloadstree();	// Creating new tree object

	   foreach ( $rows as $row ) { // let's append categories & sub categories to the tree
           if(strlen($row->cat_title) > $lengthc){
              $row->cat_title  = substr($row->cat_title,0,($lengthc - 3));
              $row->cat_title .= "...";
              }                                      
        
             if ($cat_link_itemids){  
                 $cat_itemid = '';
                 for ($i2=0; $i2 < count($cat_link_itemids); $i2++) {
                      if ($cat_link_itemids[$i2][catid] == $row->cat_id){
                          $cat_itemid = $cat_link_itemids[$i2][id];
                      }     
                 }
             }   
             if (!$cat_itemid){
                // use global itemid when no single link exists
                $cat_itemid = $Itemid;
             }
             
             $catlink = JRoute::_('index.php?option=com_jdownloads&amp;view=viewcategory&amp;catid='. $row->cat_id .'&amp;Itemid='. $cat_itemid.'');
             $tree->addToArray($row->cat_id,$row->cat_title,$row->parent_id,$catlink,"");
 
             if($row->cat_id > $nodeId){$nodeId=$row->cat_id;} // get max id
       }
       $nodeId++;
         
      // draw the tree
      $livesite= JURI::root();
      $tree->writeJavascript($livesite);
      $tree->drawTree($home_link);
      $tree->applyStyle();
?>