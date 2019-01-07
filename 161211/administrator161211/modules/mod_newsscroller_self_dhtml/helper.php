<?php
// "Newsscroller Self DHTML for Joomla 1.5"
// Author: Viktor Vogel
// URL: http://joomla-extensions.kubik-rubik.de/
// version 1.5-3 (for more details see http://joomla-extensions.kubik-rubik.de/ns-newsscroller-self-dhtml)
// no direct access
defined('_JEXEC') or die('Restricted access');

class mod_newsscroller_self_dhtmlHelper
{
	function srcollcontent(&$params)
	{
		$linenews1 			= $params->def('linenews1', 0);
		$linenews1status	= $params->def('linenews1status', 1);
		$news1 				= $params->def('news1', 0);
		$urlnews1status 	= $params->def('urlnews1status', 1);
		$urlnews1 			= $params->def('urlnews1', 1);
		$urlnews1newwindow 	= $params->def('urlnews1newwindow', 1);
		$urlnews1name 		= $params->def('urlnews1name', 1);
		$linenews2 			= $params->def('linenews2', 0);
		$linenews2status 	= $params->def('linenews2status', 1);
		$news2 				= $params->def('news2', 0);
		$urlnews2status 	= $params->def('urlnews2status', 1);
		$urlnews2 			= $params->def('urlnews2', 1);
		$urlnews2newwindow 	= $params->def('urlnews2newwindow', 1);
		$urlnews2name 		= $params->def('urlnews2name', 1);
		$linenews3 			= $params->def('linenews3', 0);
		$linenews3status 	= $params->def('linenews3status', 1);
		$news3 				= $params->def('news3', 0);
		$urlnews3status 	= $params->def('urlnews3status', 1);
		$urlnews3 			= $params->def('urlnews3', 1);
		$urlnews3newwindow 	= $params->def('urlnews3newwindow', 1);
		$urlnews3name 		= $params->def('urlnews3name', 1);
		$linenews4 			= $params->def('linenews4', 0);
		$linenews4status 	= $params->def('linenews4status', 1);
		$news4 				= $params->def('news4', 0);
		$urlnews4status 	= $params->def('urlnews4status', 1);
		$urlnews4 			= $params->def('urlnews4', 1);
		$urlnews4newwindow 	= $params->def('urlnews4newwindow', 1);
		$urlnews4name 		= $params->def('urlnews4name', 1);
		$linenews5 			= $params->def('linenews5', 0);
		$linenews5status 	= $params->def('linenews5status', 1);
		$news5 				= $params->def('news5', 0);
		$urlnews5status 	= $params->def('urlnews5status', 1);
		$urlnews5 			= $params->def('urlnews5', 1);
		$urlnews5newwindow 	= $params->def('urlnews5newwindow', 1);
		$urlnews5name 		= $params->def('urlnews5name', 1);
		$nonews 			= $params->def('nonews', 1);
		$hor 				= $params->def('hor', 1);
		$sort 				= $params->def('sort', 0);
		$consecutive 		= $params->def('consecutive');
		$manualsorting 		= $params->def('manualsorting');
		
		$content = array();
		
		if ($news1 != '0')
		{
			$content[0] = array('number' => 1, 'news' => $news1, 'linenewsstatus' => $linenews1status, 'linenews' => $linenews1, 'urlnewsstatus' => $urlnews1status, 'urlnews' => $urlnews1, 'urlnewsnewwindow' => $urlnews1newwindow, 'urlnewsname' => $urlnews1name);
		}
		if ($news2 != '0')
		{
			$content[1] = array('number' => 2, 'news' => $news2, 'linenewsstatus' => $linenews2status, 'linenews' => $linenews2, 'urlnewsstatus' => $urlnews2status, 'urlnews' => $urlnews2, 'urlnewsnewwindow' => $urlnews2newwindow, 'urlnewsname' => $urlnews2name);
		}
		if ($news3 != '0')
		{
			$content[2] = array('number' => 3, 'news' => $news3, 'linenewsstatus' => $linenews3status, 'linenews' => $linenews3, 'urlnewsstatus' => $urlnews3status, 'urlnews' => $urlnews3, 'urlnewsnewwindow' => $urlnews3newwindow, 'urlnewsname' => $urlnews3name);
		}
		if ($news4 != '0')
		{
			$content[3] = array('number' => 4, 'news' => $news4, 'linenewsstatus' => $linenews4status, 'linenews' => $linenews4, 'urlnewsstatus' => $urlnews4status, 'urlnews' => $urlnews4, 'urlnewsnewwindow' => $urlnews4newwindow, 'urlnewsname' => $urlnews4name);
		}
		if ($news5 != '0')
		{
			$content[4] = array('number' => 5, 'news' => $news5, 'linenewsstatus' => $linenews5status, 'linenews' => $linenews5, 'urlnewsstatus' => $urlnews5status, 'urlnews' => $urlnews5, 'urlnewsnewwindow' => $urlnews5newwindow, 'urlnewsname' => $urlnews5name);
		}
		
		if ($sort == 0)
		{
			sort($content);
		} 
		elseif ($sort == 1)
		{
			rsort($content);
		}
		elseif ($sort == 2)
		{
			shuffle($content);
		}
		elseif ($sort == 3)
		{
			if ($manualsorting != '')
			{
				$manualsortingarray = explode(",", $manualsorting);
				$manualsortingcontent = array();
				
				foreach ($manualsortingarray as $match)
				{
					$match = $match - 1;
					if (isset($content[$match]) AND $content[$match] != '')
					{
						$manualsortingcontent[] = $content[$match];
					}
				}
				
				$content = $manualsortingcontent;		
			}
		}
		
		$html_content = '';
		
		if (empty($content))
		{
			$html_content .= $nonews;
		}
		else
		{
			foreach ($content as $match) 
			{
				if ($match['linenewsstatus'] == "yes") 
				{
					$html_content .= '<h3>'.$match['linenews'].'</h3>';	
				}
				$html_content .= '<p>'.nl2br($match['news']).'</p>';
				if ($match['urlnewsstatus'] == "yes") 
				{
					$html_content .= '<p><a rel="nofollow" target="'.$match['urlnewsnewwindow'].'"  title="'.$match['urlnewsname'].'" href="'.$match['urlnews'].'">'.$match['urlnewsname'].'</a></p>';
				}
				
				if ($hor == 1) 
				{
					$html_content .= "<hr />"; 
				}
				elseif ($hor == 2) 
				{
					$html_content .= "<br /><br />"; 
				}
			}
			
			if ($consecutive == 1)
			{
				for ($a = 0; $a < 4; $a++)
				{
					$html_content .= $html_content;
				}
			}	
		}
		return $html_content;
	}
	
	
	function javascript(&$params)
	{
		$scrolldelay	= $params->get('scrolldelay', 2);
		$marqueespeed	= $params->get('marqueespeed');
		$pauseit		= $params->get('pauseit');
		
		?><script type="text/javascript">// <![CDATA[
			/**
			 * Cross browser Marquee II- Dynamic Drive (www.dynamicdrive.com)
			*/
			var delayb4scroll="<?php echo $scrolldelay."000" ?>"
			var marqueespeed="<?php echo $marqueespeed ?>"
			var pauseit="<?php echo $pauseit ?>"
			var copyspeed=marqueespeed
			var pausespeed=(pauseit==0)?copyspeed:0
			var actualheight=''
			function scrollmarquee(){if(parseInt(cross_marquee.style.top)>(actualheight*(-1)+8))
			cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px"
			else
			cross_marquee.style.top=parseInt(marqueeheight)+8+"px"}
			function initializemarquee(){cross_marquee=document.getElementById("vmarquee")
			cross_marquee.style.top=0
			marqueeheight=document.getElementById("marqueecontainer").offsetHeight
			actualheight=cross_marquee.offsetHeight
			if(window.opera||navigator.userAgent.indexOf("Netscape/7")!=-1){cross_marquee.style.height=marqueeheight+"px"
			cross_marquee.style.overflow="scroll"
			return}
			setTimeout('lefttime=setInterval("scrollmarquee()",60)',delayb4scroll)}
			if(window.addEventListener)
			window.addEventListener("load",initializemarquee,false)
			else if(window.attachEvent)
			window.attachEvent("onload",initializemarquee)
			else if(document.getElementById)
			window.onload=initializemarquee
			// ]]></script>
	<?php }
}
