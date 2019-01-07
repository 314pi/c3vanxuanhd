<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$article =& JTable::getInstance("content");
$artid		= trim( $params->get('artid') );
$article->load( $artid );
?>
<marquee onmouseover="this.stop();" onmouseout="this.start();" scrollAmount=<?php echo trim( $params->get( 'amount' ) ); ?> scrollDelay=<?php  echo trim( $params->get( 'delay' ) ); ?> direction="left"> <p> Trường trung học phổ thông Hoài Đức A - </p>  
<a href="<?php echo $item->link; ?>" class="latestnews<?php echo $params->get('moduleclass_sfx'); ?>">
<?php echo $article->get("title") ; echo $item; ?>
</marquee>
