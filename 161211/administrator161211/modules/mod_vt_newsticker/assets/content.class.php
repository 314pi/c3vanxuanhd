<?php
/*------------------------------------------------------------------------
 # Vt NewsTicker  - Version 1.0 - YouTech Club
 # ------------------------------------------------------------------------
 # Copyright (C) 2009-2010 YouTech Club. All Rights Reserved.
 # @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 # Author: Ytcvn.Com
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/
 

require_once (JPATH_SITE . '/components/com_content/helpers/route.php');

class Content {
	var $items = array();
	var $is_frontpage = 0;	// 0 - without frontpage, 1 - only frontpage - 2 both
	var $type = 0;
	var $cat_or_sec_ids = array();
	var $limit = 5;
	var $article_ids = array();
	var $is_cat_or_sec = 1;		
	var $sort_order_field = 'created';
	var $type_order = 'ASC';
	
	function Content() {
				
	}
		
	function getList() {
			global $mainframe;			
			
			$items = array();
			
			$db = & JFactory::getDBO ();
			$user = & JFactory::getUser ();
			$aid = $user->get ( 'aid', 0 );
			
			$contentConfig = &JComponentHelper::getParams ( 'com_content' );
			$noauth = ! $contentConfig->get ( 'shownoauth' );
			
			jimport ( 'joomla.utilities.date' );
			$date = new JDate ( );
			$now = $date->toMySQL ();
			
			$nullDate = $db->getNullDate ();
			
			$orderby = " ORDER BY {$this->sort_order_field} {$this->type_order}";
			$limit = " LIMIT {$this->limit}";
		
			// query to determine article count
			$query = 'SELECT a.*,u.name as creater,cc.description as catdesc, cc.title as cattitle,s.description as secdesc, s.title as sectitle,' . ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,' . ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,' . ' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as secslug' . ' FROM #__content AS a' . ' INNER JOIN #__categories AS cc ON cc.id = a.catid' . ' INNER JOIN #__sections AS s ON s.id = a.sectionid' . ' left JOIN #__users AS u ON a.created_by = u.id';
			$query .= ' WHERE a.state = 1 ' . ($noauth ? ' AND a.access <= ' . ( int ) $aid . ' AND cc.access <= ' . ( int ) $aid . ' AND s.access <= ' . ( int ) $aid : '') . ' AND (a.publish_up = ' . $db->Quote ( $nullDate ) . ' OR a.publish_up <= ' . $db->Quote ( $now ) . ' ) ' . ' AND (a.publish_down = ' . $db->Quote ( $nullDate ) . ' OR a.publish_down >= ' . $db->Quote ( $now ) . ' )' . (($this->is_cat_or_sec) ? "\n AND cc.id=" . ( int ) $this->cat_or_sec_ids : ' AND s.id=' . ( int ) $this->cat_or_sec_ids) . ' AND cc.section = s.id' . ' AND cc.published = 1' . ' AND s.published = 1';
			
			if ($this->is_frontpage == 0) {
				$query .= ' AND a.id not in (SELECT content_id FROM #__content_frontpage )';
			} else if ($this->is_frontpage == 1) {
				$query .= ' AND a.id in (SELECT content_id FROM #__content_frontpage )';
			}

			$query .= $orderby . $limit;
			
			$db->setQuery ( $query );
			
			//echo $db->getQuery();
			
			$rows = $db->loadObjectList ();
			
			global $mainframe;
			JPluginHelper::importPlugin ( 'content' );
			$dispatcher = & JDispatcher::getInstance ();
			$params = & $mainframe->getParams ( 'com_content' );
			
			$limitstart = $this->limit;
			
			for($i = 0; $i < count ( $rows ); $i ++) {
				$rows [$i]->text = $rows [$i]->introtext;
				$results = $dispatcher->trigger ( 'onPrepareContent', array (& $rows [$i], & $params, $limitstart ) );
				$rows [$i]->introtext = $rows [$i]->text;
				$items[$i]['id'] = $rows [$i]->id;
				$items[$i]['img'] = $this->getImage($rows [$i]->text);
				$items[$i]['title'] = $rows[$i]->title;
				$items[$i]['content'] = $this->removeImage($rows [$i]->text);
				
				$link   = JRoute::_(ContentHelperRoute::getArticleRoute($rows [$i]->slug, $rows [$i]->catslug, $rows [$i]->sectionid));				
				$items[$i]['link'] = $link;
			}
			return $items;
		}		
	
	
	function getImage($str){
			
    		$regex = "/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/";
    		$matches = array();
			preg_match ( $regex, $str , $matches );    
			$images = (count($matches)) ? $matches : array ();
			$image = count($images) > 1 ? $images[1] : '';
						
			return $image;
	}
	
	function getItemid($sectionid) {
		$contentConfig = &JComponentHelper::getParams ( 'com_content' );
		$noauth = ! $contentConfig->get ( 'shownoauth' );
		$user = & JFactory::getUser ();
		$aid = $user->get ( 'aid', 0 );
		$db = & JFactory::getDBO ();
		$query = "SELECT id FROM #__menu WHERE `link` like '%option=com_content%view=section%id=$sectionid%'" . ' AND published = 1' . ($noauth ? ' AND access <= ' . ( int ) $aid : '');
		
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function removeImage($str) {
		$regex1 = "/\<img[^\>]*>/";
		$str = preg_replace ( $regex1, '', $str );
		$regex1 = "/<div class=\"mosimage\".*<\/div>/";
		$str = preg_replace ( $regex1, '', $str );
		$str = trim ( $str );
		
		return $str;
	}
		
	
}
?>
