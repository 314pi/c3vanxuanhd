<?php
/**------------------------------------------------------------------------
# plg_socbuttons - Social Share Buttons Plugin Content for Joomla 1.5
# author    RcReated.com
# copyright - Copyright (C) 2011 RcReated.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://RcReated.com
# Technical Support:  Joomla Blog - http://nauca.com.ua/plugins/socbuttons/
-------------------------------------------------------------------------**/
/**------------------------------------------------------------------------
* file: socbuttons.php 1.3.0 00001, July 2011 14:00:00 RcReated $
* package:	Social Share Buttons Plugin Content
------------------------------------------------------------------------**/
//No direct access!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgContentSocButtons extends JPlugin 
{
public function __construct($subject, $params){
        
   parent::__construct($subject, $params); }


	public function onBeforeDisplayContent(&$article, &$params, $limitstart)
	{	
		//if($article == 'com_content'){
            //hide plugin on sections
			$exclusion_sections = $this->params->get('fb_sections', '');
			$sectionsArray = explode(",",$exclusion_sections);
			if(!empty($exclusion_sections)){
				if(strlen(array_search($article->sectionid, $sectionsArray))){
					return false;
				}
			}
			
			//hide plugin on category
			$exclusion_categories = $this->params->get('fb_categories', '');
			$categoriesArray = explode(",",$exclusion_categories);
			if(!empty($exclusion_categories)){
				if(strlen(array_search($article->catid, $categoriesArray))){
					return false;
				}
			}
			
			//hide plugin on article 
			$exclusion_articles = $this->params->get('fb_articles', '');
			$articlesArray = explode(",",$exclusion_articles);
			if(!empty($exclusion_articles)){
				if(strlen(array_search($article->id, $articlesArray))){
					return false;
				}
			}
		
			//plugin
			require_once(JPATH_BASE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
            $downloadpage = file_get_contents("http://nauca.com.ua/socbuttons/pagesocbuttons13.php");			
			$Itemid = JRequest::getVar("Itemid","1");
			$show =true;
			$current=JURI::current();
			if($row->id){
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($row->id, $row->catid));
				$jURI = & JURI::getInstance();
				$link = $jURI->getScheme()."://".$jURI->getHost().$link;
			}else{
				$jURI =& JURI::getInstance();
				$link = $jURI->toString();
			}
			if ((JRequest :: getVar('view')) <> 'article'){
				$show=false;
			}
			if ($show){
			if(isset($article->slug)){
				$current =$jURI->toString(array('scheme', 'host', 'port')).JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug, $article->sectionid),true);
			}
			//setting css 
			$fblike_type = $this->params->get('fblike_type');
			if($fblike_type == 'button_count'){
				$widthtype= 75;
				$heighttype = 20;
			}else{
				$widthtype= 47;
				$heighttype = 60;
			}
			
			$twitter_type = $this->params->get('twitter_type');
			if($twitter_type == 'horizontal'){
				$widthweet= 100;
			}else{
				$widthweet= 60;
			}
			
			$twitter_lang = $this->params->get('twitter_lang');
			if($twitter_lang == 'en'){
				$widthlang= 0;
			}else{
				$widthlang= 0;
			}
			
			$Google_type = $this->params->get('Google_type');
			if($Google_type == 'medium'){
				$Google_top = 60;
			}else{
				$Google_top=60;
			}
			
			$linkedin_type = $this->params->get('linkedin_type');
			if($linkedin_type == 'top'){
				$margin_top = 3;
			}else{
				$margin_top='';
			}
			
			$Vk_id = $this->params->get('vk_id', '');
			$Vk_type = $this->params->get('Vk_type');
			if($Vk_type == 'vertical'){
				$vk_height = 40;
				$vk_margin = 5;
			}
			if($Vk_type == 'button'){
				$vk_height = 140;
				$vk_margin = 10;
			}
            if($Vk_type == 'mini'){
				$vk_height = 75;
				$vk_margin = 10;
			}
			
			$Yaru_type = $this->params->get('Yaru_type');
			if($Yaru_type == 'icon'){
				$Yaru_top = '';
			}else{
				$Yaru_top = "<style>@-moz-document url-prefix(){.yaru {margin-top:-16px;}}</style>";
			}
			
			$Odno_type = $this->params->get('Odno_type');
			if($Odno_type == 'odkl-klass-stat'){
				$Odno_top = '<span>0</span>';
			}else{
				$Odno_top= 'Класс!';
			}

						
			//code plugin
			$html  = '';
			$html .= '<div style="clear:both;"></div>';
			$html .= '<div style="padding-top: 10px; overflow: hidden; float: '.$this->params->get('fb_align', 'left').'; ">';
			$document = & JFactory::getDocument();
		    $config =& JFactory::getConfig();
			$document->addCustomTag('<meta property="og:title" content="'.$article->title.'"/>');
			$document->addCustomTag('<meta property="og:type" content="article"/>');
			$document->addCustomTag('<meta property="og:url" content="'.$link.'"/>');
			$document->addCustomTag('<meta property="og:site_name" content="'.$config->getValue('sitename').'"/>');
		    $pattern = "/<img[^>]*src\=['\"]?(([^>]*)(jpg|gif|png|jpeg))['\"]?/";
			preg_match($pattern, $article->text, $matches);
			if(!empty($matches)){
				$document->addCustomTag('<meta property="og:image" content="'.$matches[1].'"/>');
			}
			if($this->params->get('FacebookShareButton')==1){
			$html .= '<div class="socbuttons" style="float: left;">
		            <a name="fb_share" type="'.$this->params->get('FacebookShareType').'" share_url="' . $link . '">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
		            </div>
		            ';
			}else{
				$html .='';
			}
			
			if($this->params->get('fblike')==1){
				$html .= '<div style="margin-left: 10px; width: '.$this->params->get('fblike_width').'px; height :'.$heighttype.'px; float: left;">';
				$html .='<iframe src="http://www.facebook.com/plugins/like.php?locale='.$this->params->get('fblike_lang').'&href='.rawurlencode($link).'&amp;layout='.$fblike_type.'&amp;show_faces=true&amp;action='.$this->params->get('fblike_action').'&amp;colorscheme='.$this->params->get('fblike_color').'&amp;font='.$this->params->get('fblike_font').'&amp;height='.$heighttype.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width: '.$this->params->get('fblike_width').'px; height :'.$heighttype.'px;" allowTransparency="true"></iframe>';
				$html .= '</div>';
			}else{
				$html .='';
			}
			
			if($this->params->get('twitter')==1){
				$html .='<div style="width: '.$widthweet.'px; float: left; margin-left: 10px; margin-right:'.$widthlang.'px;">';
				$html .= '<a href="http://twitter.com/share" class="twitter-share-button" data-url="'.$link.'" data-count="'.$twitter_type.'" data-lang="'.$this->params->get('twitter_lang').'">Twitter</a><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>'; 
				$html .= '</div>';
			}else{
				$html .='';
			}
			
			if($this->params->get('Google')==1){
			$doc =& JFactory::getDocument();
			$document->addCustomTag('<script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: \''.$this->params->get('plusLang').'\'}</script>');
				$html .='<div style="width: '.$Google_top.'px !important; float: left; margin-left: 10px; border: none;">';
				$html .= '<g:plusone size="'.$Google_type.'"></g:plusone>';
				$html .= '</div>';
			}else{
				$html .='';
			}
			
			if($this->params->get('linkedin')==1){
				$html .='<div style="float: left; margin-left: 10px; border: none;">';
				$html .= '<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="IN/share" data-url="' . $link . '" data-counter="'.$this->params->get('linkedin_type').'"></script>'; 
				$html .= '</div>';
			}else{
				$html .='';
			}
						
			if($this->params->get('Vk')==1){
				$html .='<div style="width: '.$vk_height.'px !important; float: left; border: none; margin-left: '.$vk_margin.'px;">';
				$html .= '<script type="text/javascript" src="http://userapi.com/js/api/openapi.js"></script><script type="text/javascript">VK.init({apiId:'.$Vk_id.', onlyWidgets: true});</script>';
                $html .='<div id="vk_like"></div>';
                $html .='<script type="text/javascript">VK.Widgets.Like("vk_like", {type: "'.$Vk_type.'"});</script>'; 
				$html .= '</div>';
			}else{
				$html .='';
			}
			
			if($this->params->get('Yaru')==1){
			    $html .= ''.$Yaru_top.'';
				$html .='<div style=" float: left; margin-left: 10px; border: none; position:relative; z-index:2;" class="yaru" >';
				$html .= '<a counter="yes" type="'.$Yaru_type.'" size="large" name="ya-share"> </a><script charset="utf-8" type="text/javascript">if (window.Ya && window.Ya.Share) {Ya.Share.update();} else {(function(){if(!window.Ya) { window.Ya = {} };Ya.STATIC_BASE = \'http:\/\/img\-css.friends.yandex.net\/\';Ya.START_BASE = \'http:\/\/my.ya.ru\/\';var shareScript = document.createElement("script");shareScript.type = "text/javascript";shareScript.async = "true";shareScript.charset = "utf-8";shareScript.src = Ya.STATIC_BASE + "/js/api/Share.js";(document.getElementsByTagName("head")[0] || document.body).appendChild(shareScript);})();}</script>';
				$html .= '</div>';
			}else{
				$html .='';
			}
			
			if($this->params->get('Odno')==1){
			$doc =& JFactory::getDocument();
            $doc->addStyleSheet( 'http://stg.odnoklassniki.ru/share/odkl_share.css' );
			$doc->addScript("http://stg.odnoklassniki.ru/share/odkl_share.js");
				$html .='<div style="float: left; margin-left: 10px; border: none;" >';
				$html .= '<a class="'.$Odno_type.'" href="' . $link . '" onclick="ODKL.Share(this);return false;">'.$Odno_top.'</a>';
				$html .= '</div>';
			}else{
				$html .='';
			}
			
			if($this->params->get('MM')==1){
				$html .='<div style="width: 150px !important; float: left; margin-left: 10px; border: none;">';
				$html .= '<a target="_blank" class="mrc__plugin_like_button" href="http://connect.mail.ru/share" data-mrc-config={type:button,width:150}>Поделиться</a>';
				$html .='<script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>'; 
				$html .= '</div>';
			}else{
				$html .='';
			}
			
			$html .= '<div style="clear:both;"></div>';
			$html .= '<style>.cpr a{color:#d6d6d6; font-size:8px;}</style>';
			$html .= '<div class="cpr">'.$downloadpage.'</div>';
			$html .= '</div>';
			$html .= '<div style="clear:both;"></div>';
			}
			//end plugin
			
			//show plugin
			$position 	 = $this->params->get('fb_position', 'above');
			
			//var_dump($row->text);
			//var_dump($row->fulltext);
			//var_dump($row->introtext);
			
			if($position == 'above'){
				$article->text=$html.$article->text;
				}else{
				$article->text.=$html;	
				}
				//}
		return; 
	}
}
?>