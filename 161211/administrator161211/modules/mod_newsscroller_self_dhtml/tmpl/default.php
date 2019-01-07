<!-- Newsscroller Self DHTML J1.5 by Kubik-Rubik.de - Version 1.5-3-2 -->
<?php
// "Newsscroller Self DHTML for Joomla 1.5"
// Author: Viktor Vogel
// URL: http://joomla-extensions.kubik-rubik.de/
// version 1.5-3-2 (for more details see http://joomla-extensions.kubik-rubik.de/ns-newsscroller-self-dhtml)
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div id="marqueecontainer" onmouseover="copyspeed=pausespeed" onmouseout="copyspeed=marqueespeed">
<div id="vmarquee" class="vmarquee">
<?php echo $html_content; ?>
</div>
</div>
<?php if ($copy) : ?>
	<br />
	<div id="vmarqueesmall">
		NS-DHTML by <a title="NS-DHTML - Joomla Erweiterung by Kubik-Rubik.de - Viktor Vogel" target="_blank" href="http://joomla-extensions.kubik-rubik.de/">Kubik-Rubik.de</a>
	</div>
<?php endif; ?>