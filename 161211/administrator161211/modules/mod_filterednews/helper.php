<?php
/**
* @version		$Id: helper.php 2009 vargas $
* @package		Joomla
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modFilteredNewsHelper
{

    function getFN_Img( &$params, $link, $img ) {
	
	$align 	    = $params->get( 'item_img_align', 'left' );
	$margin 	= $params->get( 'item_img_margin', '3px' );
	$width 		= (int)$params->get( 'item_img_width', '' );
	$height 	= (int)$params->get( 'item_img_height', '' );
	$border		= $params->get( 'item_img_border', '0' );
	
	$style = 'margin:'.$margin.';border:'.$border.';';
	
	if ( $align == 'left' )  :
		   $style .= 'float:left;';
	endif;
	
	if ( $align == 'right' )  :
		   $style .= 'float:right;';
	endif;
	
	$attribs = array ('style' => $style);
		
	if ( $height )  :
		   $attribs = array('height' => $height, $attribs);
	endif;
	
	if ( $width )  :
		   $attribs = array('width' => $width,  $attribs );
	endif;
			   		
    return ( $link ? '<a href="'.$link.'">' : '' )
		  .JHTML::_('image', $img, '', $attribs)
		  .( $link ? '</a>' : '' );
    }
	
	function getFN_List(&$params)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$userId		= (int) $user->get('id');
		$option		= JRequest::getCmd('option');
		$view		= JRequest::getCmd('view');
		
		$temp		= JRequest::getString('id');
		$temp		= explode(':', $temp);
		$id			= $temp[0];

		$count		= (int) $params->get('count', 5);
		$cat		= $params->get('cat', 1);
		$sec		= $params->get('sec', 1);
		$only		= $params->get('only', 0);
		$current    = $params->get('current', 0);
		$catlist	= trim( $params->get('catids', '') );
		$seclist    = trim( $params->get('secids', '') );
		$catexc		= trim( $params->get( 'catexc', '' ) );
		$secexc		= trim( $params->get( 'secexc', '' ) );
		$user_id    = $params->get('user_id', 0);
		$layout 	= $params->get('layout', 'default');
		$html       = $params->get('html');
		$show_front	= $params->get('show_front', 1);
		$aid		= $user->get('aid', 0);
		$catlink    = $params->get('cat_link');
		$seclink    = $params->get('sec_link');

		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');
		
		$concats = ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,' .
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug';
			
		if ( $catlink ) :
			$concats .= ', CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug';
		endif;

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();
		
		$where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
			;
			
		if ( $recent = $params->get('recent') ) :
			$where .= ' AND DATEDIFF('.$db->Quote($now).', a.created) < ' . $recent;
		endif;

		if ( $user_id > 1 && $userId ) {
			switch ($user_id)
			{
				case '2':
					$where .= ' AND (created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
					break;
				case '3':
					$where .= ' AND (created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
					break;
			}
		}

		switch ($params->get( 'ordering' ))
		{
			case 'random':
				$ordering		= ' ORDER BY rand()';
				break;
			case 'h_asc':
				$ordering		= ' ORDER BY a.hits ASC';
				break;
			case 'h_dsc':
				$ordering		= ' ORDER BY a.hits DESC';
				break;
			case 'm_dsc':
				$ordering		= ' ORDER BY a.modified DESC, a.created DESC';
				break;
			case 'order':
				$ordering		= ' ORDER BY a.ordering ASC';
				break;
			case 'c_dsc':
			default:
				$ordering		= ' ORDER BY a.created DESC';
				break;
		}
		
		$joins = ' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
				 ' INNER JOIN #__sections AS s ON s.id = a.sectionid';
				 
		switch ( $show_front )
		{
			case 1:
				$joins .= ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id';
				$where .= ' AND f.content_id IS NULL';
				break;
			case 2:
				$joins .= ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id';
				$where .= ' AND f.content_id = a.id';
				break;
		}
		
        $catCondition = $secCondition = $the_id = '';
		
		if ( $only == 0 ) {
        	if ( $option == 'com_content' && $view == 'section' && $sec == 1 ) {
	        	$secCondition .= ' AND s.id='. $id;
        	}
        	if ( $option == 'com_content' && $view == 'category' ) {
				if ( $cat == 1 ) {
	            	$catCondition .= ' AND cc.id='. $id;
				} elseif ( $sec == 1 ) {
					$query = 'select section from #__categories where id='. $id;
					$db->setQuery($query);
					$secCondition .= ' AND s.id='. $db->loadResult();
				}
        	}
		}
				   
        if ( $option == 'com_content' && $view == 'article' && $id ) {

                $the_id = $id;
				
				$article =& JTable::getInstance('content');
				$article->load( $id );
   
                if ($current == 0) {
                    $where .= ' AND a.id!='.$the_id;
                }
                if ( $cat==1 || $sec==1 ) {
                    if ( $cat == 1 ){
	                	$catCondition .= ' AND cc.id='. $article->catid;
                    } else {
                    	$secCondition .= ' AND s.id='. $article->sectionid;
	                }
                }
                if ($user_id == 1)
		            $where .= ' AND created_by = ' . $article->created_by;
                if ( $params->get( 'key', 0 ) == 1 ) {
                     if ($metakey = trim($article->metakey)) {
		                 $keys = explode(',', $metakey);
	                     $likes = array ();
		                 foreach ($keys as $key) {
		                       $key = trim($key);
				               if ($key) {
			                       $likes[] = $db->getEscaped($key);
		                       }
		                 }
                         if (count($likes)) {
		                     $where .= ' AND ( a.metakey LIKE "%'.implode('%" OR a.metakey LIKE "%', $likes).'%" )';
		                 }
                  }	
             }
        }
        if ( $catlist != '' ) {
				$catids     = explode( ',', $catlist );
                $catCondition .= ' AND ( cc.id=' . implode( ' OR cc.id!=', $catids ) . ')';
        }

        if ( $seclist != '' ) {
				$secids     = explode( ',', $seclist );
                $secCondition .= ' AND ( s.id=' . implode( ' OR s.id!=', $secids ) . ')';
        }


        if ( $catexc != '' ) {
				$catexcs    = explode( ',', $catexc );
                $catCondition .= ' AND ( cc.id!=' . implode( ' AND cc.id!=', $catexcs ) . ')';
        }

        if ( $secexc != '' ) {
				$secexcs    = explode( ',', $secexc );
                $secCondition .= ' AND ( s.id!=' . implode( ' AND s.id!=', $secexcs ) . ')';
        }

		$query = 'SELECT a.*, cc.title AS catname, s.title AS secname, s.id AS section,' .
			$concats  .
			' FROM #__content AS a' .
			$joins  .
			' WHERE '. $where .' AND s.id > 0' .
			($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '') .
			($catCondition!='' ? $catCondition : '') .
			($secCondition!='' ? $secCondition : '') .
			' AND s.published = 1' .
			' AND cc.published = 1' .
			$ordering;
			
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();

		$i		= 0;
		$lists	= array();
		foreach ( $rows as $row ) {
		
		    $link = '';
		    $lists[$i]->title = htmlspecialchars( $row->title );
		
            if ( $the_id != $row->id or $current != 2 ) {
		         $link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
				 if ( $params->get('link_title', 1) ) {
		         	$lists[$i]->title = '<a href="'.$link.'">'.htmlspecialchars( $row->title ).'</a>'; 
				}
			}
						
	        if ( $layout ) :
			
				$fn_image    = '';
				$fn_title    = '';
				$fn_created  = '';
				$fn_author   = '';
				$fn_text     = '';
				$fn_readmore = '';
				$fn_comments = '';
				$rm          = 0;
				
				$fn_category = $row->catname;
				$fn_section  = $row->secname;
				
				if ( $catlink ) {
					 $cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute( $row->catslug, $row->section ));
					 $fn_category = '<a href="'.$cat_link.'">'.htmlspecialchars( $fn_category  ).'</a>'; 
				}
				
				if ( $seclink ) {
					 $sec_link = JRoute::_(ContentHelperRoute::getSectionRoute( $row->section ));
					 $fn_section = '<a href="'.$sec_link.'">'.htmlspecialchars( $fn_section ).'</a>'; 
				}
			
				if ( preg_match("/FN_title/", $html) ) {
		        	$fn_title = $lists[$i]->title;
					$fn_title = preg_replace('/\$/','$-',$fn_title);
			    }
			
		        if ( preg_match("/FN_date/", $html) ) {
	      	    	$fn_created = JHTML::_('date',  ($params->get( 'date' ) == 'created' ? $row->created : $row->modified ),  $params->get('date_format', '' ) );
			    }
				
		        if ( preg_match("/FN_author/", $html) ) {
					$author = $params->get( 'author' );
					if ( $author != 'alias' ) {
						$query = "SELECT " . $author . " FROM #__users WHERE id = " . $row->created_by;
						$db->setQuery($query);
						$fn_author = $db->loadResult();
						if ( $params->get('cb_link')) {
							$menu 		= &JSite::getMenu();
							$CB_Items	= $menu->getItems('link', 'index.php?option=com_comprofiler');
							$CB_Itemid  = '';
							if (isset($CB_Items[0]->id))
								$CB_Itemid .= '&amp;Itemid='.$CB_Items[0]->id;
							$fn_author = '<a href=' . JRoute::_('index.php?option=com_comprofiler&task=userProfile&user=' . $row->created_by . $CB_Itemid) . ' title= ' . $fn_author . '>' . $fn_author . '</a>';
						}
					} else {
						$fn_author = $row->created_by_alias;
					}
			    }
				 
		        if ( preg_match("/FN_image/", $html) ) {
					$regex   = "/<img[^>]+src\s*=\s*[\"']\/?([^\"']+)[\"'][^>]*\>/";
					$search  = $row->introtext . $row->fulltext;
					preg_match ($regex, $search, $matches);
					$images = (count($matches)) ? $matches : array();
					if ( count($images) ) {
					   $fn_image  = modFilteredNewsHelper::getFN_Img ($params, $link, $images[1]);
					}
		        }
						
		        if ( preg_match("/FN_text/", $html) ) {
					$text    = $params->get( 'text', 0 );
					$limit   = trim( $params->get('limittext', '150') );
					if ($text < 2) { 
					  $fn_text = $row->introtext;
					  if ( $text == 1 )
					    $fn_text .= '&nbsp;' . $row->fulltext;
					}
					if ( $text == 2 )
					  $fn_text = $row->fulltext;
					if ( $params->get('striptext', '1'))
					  $fn_text = trim( strip_tags(  $fn_text, $params->get('allowedtags', '') ) );
					$pattern = array("/[\n\t\r]+/",'/{(\w+)[^}]*}.*{\/\1}|{(\w+)[^}]*}/Us', '/\$/');
					$replace = array(' ', '', '$-');
					$fn_text = preg_replace( $pattern, $replace, $fn_text );
					if ( $limit && strlen( $fn_text ) > $limit ) {
					   $fn_text = substr( $fn_text, 0, $limit );
					   $space   = strrpos( $fn_text, ' ' );
					   $fn_text = substr( $fn_text, 0, $space ). '...';
					   $rm = 1;
					} elseif ( $text == 0 && $row->fulltext ) {
					   $rm = 1;
					}
			    }
				 
		        if ( preg_match("/FN_comments/", $html) ) {
					$query = 'SELECT count(id) FROM ' . $params->get( 'comments_table' ) . ' WHERE ' . $params->get( 'article_column' ) . ' = ' . $row->id;
					$db->setQuery($query);
					if (($number = $db->loadResult()) !== NULL) {
						if ( $link ) {
							$fn_comments = '<a href="'. $link .'">';
						}
						if ( $number == 1 ) {
							$fn_comments .= $number . '&nbsp;' . JText::_('Comment');
						} else {
							$fn_comments .= $number . '&nbsp;' . JText::_('Comments');
						}
						if ( $link ) {
							$fn_comments .= '</a>';
						}
					}
			    }
				 
	 			if ( preg_match("/FN_readmore/", $html) && $link && $rm ) {
		            $fn_readmore  = JHTML::_('link', $link, JText::_('Read More...'));
	            }
				 
				$code = array("/FN_image/", "/FN_title/", "/FN_date/", "/FN_author/", "/FN_text/", "/FN_category/", "/FN_section/", "/FN_readmore/", "/FN_comments/","/FN_break/","/FN_space/");
				$rplc = array( $fn_image, $fn_title, $fn_created, $fn_author, $fn_text, $fn_category, $fn_section, $fn_readmore, $fn_comments, "<br />", "&nbsp;");
				 
				$lists[$i]->content = preg_replace($code, $rplc, $html);
				$lists[$i]->content = preg_replace('/\$-/','$',$lists[$i]->content);
							 
            endif;
			
			$i++;
		}
		
		return $lists;
	}
	
	function addFN_CSS(&$params,$layout,$filterednews_id) {
	
		 $doc =& JFactory::getDocument();
		 
		 $style = ' border:'.$params->get('border', '1px solid #EFEFEF').';'
				 .' padding:'.$params->get('padding', '5px').';'
				 .' width:'.$params->get('width', 'auto').';'
				 .' height:'.$params->get('height', '125px').';'
				 .' background-color:'.$params->get('color', '#FFFFFF').';'
				 .' overflow:hidden;';
						
		 switch ( $layout ) {
	
			  case 'static' :
				   $css = ".fn_static_".$filterednews_id."{"
						   .$style
						   ." margin-bottom:2px;"
						   ." }";
					  
				   break;
			  case 'slider' :
				   $css = ".fn_slider_".$filterednews_id." {"
						   .$style
						   ." border-bottom:none;"
						   ." }\n"
						   .".fn_slider_".$filterednews_id." .opacitylayer{"
						   ." width:100%;"
						   ." height:100%;"
						   ." filter:progid:DXImageTransform.Microsoft.alpha(opacity=100);"
						   ." -moz-opacity:1;"
						   ." opacity:1;"
						   ." }\n"
						   .".fn_slider_".$filterednews_id." .contentdiv{"
						   ." display: none;"
						   ." }\n"
						   .".fn_pagination_".$filterednews_id." {"
						   ." width:".$params->get('width', 'auto').";"
						   ." border:".$params->get('border', '1px solid #EFEFEF').";"
						   ." border-top:none;"
						   ." padding:2px ".$params->get('padding', '5px').";"
						   ." text-align:right;"
						   ." background-color:".$params->get('color', '#FFFFFF').";"
						   ." }\n"
						   .".fn_pagination_".$filterednews_id." a:link{"
						   ." font-weight:bold;"
						   ." padding:0 2px"
						   ." }\n"
						   .".fn_pagination_".$filterednews_id." a:hover,"
						   ." .fn_pagination_".$filterednews_id." a.selected {"
						   ." color:#000;"
						   ." }";
				   break;
			  case 'browser' :
				   $css = "#fn_container_".$filterednews_id." {"
						   .$style
						   ." position: relative;"
						   ." }";
				   break;
			  case 'scroller' :
				   $css = "#fn_scroller_".$filterednews_id." {"
						   .$style
						   ." }";
				   break;
		 }
		
		 return $doc->addStyleDeclaration($css);		 
	}
}
