<?php 
/**
* @version		$Id: mod_j7TitleScroller
* @package		j7TitleScroller Module
* @purpose    set the page title scroll
* @author     Josh Prakash, Nov 2008
* @copyright	Copyright (c) youthpole.com. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* This module is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/


defined('_JEXEC') or die('Restricted access'); 

?>
<script type="text/javascript">
		/*
		(c) j7TitleScroller 1.5 for Joomla 1.5 - Page Title Scroller Module, Josh Prakash, http://www.youthpole.com - 2008
		*/		

<!--
var r=<?php echo $scrollchoice; ?>; 
var t=document.title+" ";
var l=t.length;
var s=0;
var c=<?php echo $scrollcount; ?>;
function j7titlescroller() {
  title=t.substring(s, l) + t.substring(0, s);
  document.title=title;
  s++;
  if (s==l+1) {
    s=0;
    if (r==-1 && c>0) c=c-1;
    if ((r==0) ||( r==-1 && c==0)) return;
     }
  setTimeout("j7titlescroller()", <?php echo $scrollspeed; ?> );
}
if (document.title)
j7titlescroller();
//--> 
</script>
<?php
?>