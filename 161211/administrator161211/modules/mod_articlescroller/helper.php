<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
class ModArticleScroller {
    
    public function getArticle($args){
      $db = &JFactory::getDBO();

      $article_id = $args['article_id'];

      $query  = "select ";
      $query .= "con.introtext ";
      $query .= "from #__content as con ";
      $query .= "where con.id = ".$article_id." ";
      $query .= "and con.state = 1 ";

      $db->setQuery($query);
      $items = ($items = $db->loadObjectList())?$items:array();
      return $items;
    }
}
