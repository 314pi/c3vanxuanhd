<?php
/**
 * @package Xpert Tabs
 * @version 1.5.1
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

class modXpertTabsHelper{
    public static function getLists($params){
        global $mainframe;

        $db         =& JFactory::getDBO();
        $user       =& JFactory::getUser();
        $userId     =  (int) $user->get('id');
        $aid        =  $user->get('aid', 0);
        $nullDate   =  $db->getNullDate();
        $date       =& JFactory::getDate();
        $now        =  $date->toMySQL();
        $contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');
        
        $count		    = $params->get('tabs_count', 3);
        $content_source = $params->get('content_source','mods');
        $jcat_id		= trim( $params->get('joomla_cat_id') );
        $show_front	    = $params->get('show_front', 1);
        $jordering      = $params->get('item_ordering');
        $k2cat_id       = $params->get('k2_cat_id');
        $k2ordering     = $params->get('k2_item_ordering');
        $where          = '';

        // ensure should be published
		$where .= " AND ( a.publish_up = ".$db->Quote($nullDate)." OR a.publish_up <= ".$db->Quote($now)." )";
		$where .= " AND ( a.publish_down = ".$db->Quote($nullDate)." OR a.publish_down >= ".$db->Quote($now)." )";

        //joomla specific
        if($content_source == 'joomla')
        {
            require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
            // ordering
            switch ($jordering) {
                case 'date' :
                    $orderby = 'a.created ASC';
                    break;
                case 'rdate' :
                    $orderby = 'a.created DESC';
                    break;
                case 'alpha' :
                    $orderby = 'a.title';
                    break;
                case 'ralpha' :
                    $orderby = 'a.title DESC';
                    break;
                case 'order' :
                    $orderby = 'a.ordering';
                    break;
                default :
                    $orderby = 'a.id DESC';
                    break;
            }
            $cat_condition = '';
            if ($show_front != 2) {
        		if ($jcat_id)
        		{
        			$ids = explode( ',', $jcat_id );
        			JArrayHelper::toInteger( $ids );
        			$cat_condition = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
        		}
        	}
            // Content Items only
    		$query = 'SELECT a.*, ' .
    			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
    			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,'.
                ' CHAR_LENGTH( a.fulltext ) AS readmore ' .
    			' FROM #__content AS a' .
    			($show_front == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
    			($show_front == '2' ? ' INNER JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
    			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
    			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
    			' WHERE a.state = 1'. $where .' AND s.id > 0' .
    			($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
    			($jcat_id && $show_front != 2 ? $cat_condition : '').
    			($show_front == '0' ? ' AND f.content_id IS NULL ' : '').
    			' AND s.published = 1' .
    			' AND cc.published = 1' .
    			' ORDER BY '. $orderby;
    		// end Joomla specific

        }else if($content_source == 'k2'){
            // start K2 specific
		    require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');

            $query = "SELECT i.*, c.name AS categoryname,c.id AS categoryid, c.alias AS categoryalias, c.params AS categoryparams";

            if ($k2ordering == 'best') $query .= ", (r.rating_sum/r.rating_count) AS rating";

            if ($k2ordering == 'comments') $query .= ", COUNT(comments.id) AS numOfComments";

            $query .= " FROM #__k2_items as i LEFT JOIN #__k2_categories c ON c.id = i.catid";

            if ($k2ordering == 'best') $query .= " LEFT JOIN #__k2_rating r ON r.itemID = i.id";

            if ($k2ordering == 'comments') $query .= " LEFT JOIN #__k2_comments comments ON comments.itemID = i.id";

            $query .= " WHERE i.published = 1 AND i.access <= {$aid} AND i.trash = 0 AND c.published = 1 AND c.access <= {$aid} AND c.trash = 0";

            $query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )";
            $query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";

            if ($params->get('catfilter')) {
				if (!is_null($k2cat_id)) {
					if (is_array($k2cat_id)) {
						if ($params->get('get_children')) {
							require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'itemlist.php');
							$allChildren = array();
							foreach ($k2cat_id as $id) {
								$categories = K2ModelItemlist::getCategoryChilds($id, true);
								$categories[] = $id;
								$categories = @array_unique($categories);
								$allChildren = @array_merge($allChildren, $categories);
							}

							$allChildren = @array_unique($allChildren);
							JArrayHelper::toInteger($allChildren);
							$sql = @implode(',', $allChildren);
							$query .= " AND i.catid IN ({$sql})";

						} else {
							JArrayHelper::toInteger($k2cat_id);
							$query .= " AND i.catid IN(".implode(',', $k2cat_id).")";
						}

					} else {
						if ($params->get('get_children')) {
							require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'itemlist.php');
							$categories = K2ModelItemlist::getCategoryChilds($k2cat_id, true);
							$categories[] = $k2cat_id;
							$categories = @array_unique($categories);
							JArrayHelper::toInteger($categories);
							$sql = @implode(',', $categories);
							$query .= " AND i.catid IN ({$sql})";
						} else {
							$query .= " AND i.catid=".(int)$k2cat_id;
						}

					}
				}
			}

            if ($params->get('k2_featured_items') == '0') $query .= " AND i.featured != 1";

            if ($params->get('k2_featured_items') == '2') $query .= " AND i.featured = 1";

            if ($k2ordering == 'comments')
            $query .= " AND comments.published = 1";

            switch ($k2ordering) {
                case 'date':
                    $orderby = 'i.created ASC';
                    break;
                case 'rdate':
                    $orderby = 'i.created DESC';
                    break;
                case 'alpha':
                    $orderby = 'i.title';
                    break;
                case 'ralpha':
                    $orderby = 'i.title DESC';
                    break;
                case 'order':
                    if ($params->get('k2_featured_items') == '2')
                    $orderby = 'i.featured_ordering';
                    else
                    $orderby = 'i.ordering';
                    break;
                case 'rorder':
                    if ($params->get('k2_featured_items') == '2')
                    $orderby = 'i.featured_ordering DESC';
                    else
                    $orderby = 'i.ordering DESC';
                    break;
                case 'rand':
                    $orderby = 'RAND()';
                    break;
                case 'best':
                    $orderby = 'rating DESC';
                    break;
                case 'comments':
                    $query.=" GROUP BY i.id ";
                    $orderby = 'numOfComments DESC';
                    break;
                default:
                    $orderby = 'i.id DESC';
                    break;
            }
            $query .= " ORDER BY ".$orderby;
            
        }else{
            //module specific
            $mods = $params->get('modules');
            $options 	= array('style' => 'none');
            $lists = array();

            for ($i=0;$i<count($mods);$i++) {
                $lists[$i]->order 	= modXpertTabsHelper::getModule($mods[$i])->ordering;
                $lists[$i]->title 	= modXpertTabsHelper::getModule($mods[$i])->title;
                $lists[$i]->content = $lists[$i]->introtext = JModuleHelper::renderModule(  modXpertTabsHelper::getModule($mods[$i]), $options);
		    }

		    return $lists;


        }
        if($content_source == 'joomla' OR $content_source == 'k2'){
            $db->setQuery($query, 0, $count);
            $items = $db->loadObjectList();
            $lists = array();
            $lists = modXpertTabsHelper::buildLists($params, $items);
            return $lists;
        }

    }
    //fetch module by id
    public static function getModule( $id ){

		global $mainframe;
		$db		=& JFactory::getDBO();
		$where = ' AND ( m.id='.$id.' ) ';

		$query = 'SELECT *'.
			' FROM #__modules AS m'.
			' WHERE m.client_id = '.(int) $mainframe->getClientId().
			$where.
			' ORDER BY ordering'.
			' LIMIT 1';

		$db->setQuery( $query );
		$module = $db->loadObject();

		if (!$module) return null;

		$file				= $module->module;
		$custom				= substr($file, 0, 4) == 'mod_' ?  0 : 1;
		$module->user		= $custom;
		$module->name		= $custom ? $module->title : substr($file, 4);
		$module->style		= null;
		$module->position	= strtolower($module->position);
		$clean[$module->id]	= $module;

		return $module;
	}
    //function specific for Joomla and k2 content
    private static function buildLists($params, $items){
        $i = 0;
        $lists = array();
        $contentConfig = &JComponentHelper::getParams( 'com_content' );
        $content_source = $params->get('content_source','joomla');
        
        foreach($items as $row){
            $user		=& JFactory::getUser();
            $dispatcher   =& JDispatcher::getInstance();
            $results = @$dispatcher->trigger('onPrepareContent', array (& $row, & $params, 0));
            $text = JHTML::_('content.prepare',$row->introtext,$contentConfig);

            $lists[$i]->id = $row->id;
			$lists[$i]->created = $row->created;
			$lists[$i]->modified = $row->modified;
            $lists[$i]->title = htmlspecialchars( $row->title );
            
            if ($row->access >  $user->get('aid', 0)){
                $lists[$i]->link = JRoute::_("index.php?option=com_user&view=login");
                $lists[$i]->readmore_register = true;
            }
			else if ($content_source=='joomla') {
			    $lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
                $lists[$i]->readmore_register = false;
			} else {
			    $lists[$i]->link = JRoute::_(K2HelperRoute::getItemRoute($row->id.':'.$row->alias, $row->catid.':'.$row->categoryalias));
                $lists[$i]->image = modXpertTabsHelper::getK2Images($lists[$i]->id, $lists[$i]->title, $params->get('k2_img_size'));
                $lists[$i]->readmore_register = false;
			}

			$lists[$i]->introtext = $text;

            if ($params->get('show_readmore')){
                ob_start();
                ?>
                  <a href="<?php echo $lists[$i]->link; ?>" class="readon"><span>
                    <?php if ($lists[$i]->readmore_register) :
                      echo JText::_('Register to read more...');
                    elseif ($readmore = $params->get('readmore_text')) :
                      echo $readmore;
                    else :
                      echo JText::sprintf('Read more...');
                    endif; ?></span></a>
                <?php
                $readmore_html = ob_get_clean();

                $lists[$i]->introtext .= $readmore_html;
            }
            $i++;
        }
        return $lists;
        
    }

    public static function loadScripts($params, $module_id){
        $doc =& JFactory::getDocument();
        //load jquery first
        modXpertTabsHelper::loadJquery($params);
        
        $effect         = "'". $params->get('transition_type','default'). "'";
        $fadein_speed   = (int)$params->get('fadein_speed',500);
        $fadeout_speed  = (int)$params->get('fadeout_speed',0);
        $auto_play      = ( (int)$params->get('auto_play',0) ) ? 'true' : 'false';
        $auto_pause     = ( (int)$params->get('auto_pause',1) ) ? 'true' : 'false';
        $event          = "'". $params->get('tabs_interaction','click'). "'";

        //scrollable js settings.
        if($params->get('tabs_scrollable')){
            $scroll = ".slideshow({autoplay: {$auto_play},autopause: {$auto_pause}})";
        }else{
            $scroll = '';
        }
        if((int)$auto_play){
            $rotate = 'rotate: true,';
        }else{
            $rotate = '';
        }

        $js = "
            jQuery.noConflict();
            jQuery(document).ready(function(){
                jQuery('#{$module_id} .xt-nav ul').tabs('#{$module_id}-pans > .xt-pane',{
                    effect: {$effect},
                    fadeInSpeed: {$fadein_speed},
                    fadeOutSpeed: {$fadeout_speed},
                    {$rotate}
                    event: {$event}
                }){$scroll};
            });
        ";
        $doc->addScriptDeclaration($js);

        if(!defined('XPERT_TABS')){
            //add tab engine js file
            $doc->addScript(JURI::root(true).'/modules/mod_xperttabs/tmpl/xperttabs.js');
            define('XPERT_TABS',1);
        }
    }

    public static function loadJquery($params){
        $doc =& JFactory::getDocument();    //document object
        $app =& JFactory::getApplication(); //application object

        static $jqLoaded;

        if ($jqLoaded) {
            return;
        }

        if($params->get('load_jquery') AND !$app->get('jQuery')){
            //get the cdn
            $cdn = $params->get('jquery_source');
            switch ($cdn){
                case 'google_cdn':
                    $file = 'https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js';
                    break;
                case 'local':
                    $file = JURI::root(true).'/modules/mod_xperttabs/tmpl/jquery-1.6.1.min.js';
                    break;
            }
            $app->set('jQuery',1.6);
            $doc->addScript($file);
            //$doc->addScriptDeclaration("jQuery.noConflict();");
            $jqLoaded = TRUE;
        }

    }

    public static function loadStyles($params){
        $app        = &JApplication::getInstance('site', array(), 'J');
        $template   = $app->getTemplate();
        $doc        =& JFactory::getDocument();

        //Load stylesheets
        if($params->get('style') !== 'custom' )
        {
            $style_path = JURI::root(true).'/modules/mod_xperttabs/styles/';
            $style_selected = $params->get('style','style1');
            $style_file_name = $style_selected . '.css';

            $doc->addStyleSheet($style_path . $style_selected . '/' . $style_file_name);
        }else{
            if (file_exists(JPATH_SITE.DS.'templates'.DS.$template.'/css/xperttabs.css'))
            {
               $doc->addStyleSheet(JURI::root(true).'/templates/'.$template.'/css/xperttabs.css');
            }
        }
    }

    public static function generateTabs($tabs, $list, $params){
        $title_type = $params->get('tabs_title_type');
        $tab_scrollable = $params->get('tabs_scrollable');
        $position = $params->get('tabs_position','top');

        if($title_type == 'custom'){
            $titles = explode(",",$params->get('tabs_title_custom'));
        }

        if($tabs == 0 OR $tabs>count($list)) $tabs = count($list);

        $html  = "<div class='xt-nav $position'>";
        if($params->get('tabs_scrollable')) $html .= "<a class='backward'>backward</a>\n";
        $html .= "<ul>";

        for($i=0; $i<$tabs; $i++){
            $class = '';
            if($list[$i]->introtext != NULL){
                if(!$i) $class= 'first';
                if($i == $tabs - 1) $class= 'last';

                if($title_type == 'custom') $title = (isset($titles[$i])) ? $titles[$i] : '';
                else $title = $list[$i]->title;

                $html .= "<li class='$class' ><a href=\"#\"><span>$title</span></a></li>\n";

            }

        }
        $html .= "</ul>\n";
        if($params->get('tabs_scrollable')) $html .= "<a class='forward'>forward</a>\n";
        $html .= "<div class='clear'></div>";
        $html .= "</div> <!--xt-nav end-->\n";

        return $html;
        
    }

    public static function getK2Images($id, $title, $image_size){
        if (file_exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$id).'_'.$image_size.'.jpg')) {
            $image_path = 'media/k2/items/cache/'.md5("Image".$id).'_'.$image_size.'.jpg';
            $image_path = JURI::Root(true).'/'.$image_path;
            return $image_path;
        }
        else{
          echo "Image not found for article $title \n";
        }

    }
}