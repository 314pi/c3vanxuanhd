<?php // no direct access

defined('_JEXEC') or die('Restricted access');

JHTML::script('scroller.js','modules/mod_filterednews/scripts/',false); ?>

<script type="text/javascript" language="javascript">
<!--
var FN_Pausecontent_<?php echo $filterednews_id; ?>=new Array();

<?php  $k=0;  foreach ($list as $item) : 
${'content'.$k} = $item->content;
${'content'.$k} = preg_replace( "/[\n\t\r]+/",' ',${'content'.$k} );
${'content'.$k} = str_replace( "'", "\\'",${'content'.$k} ); ?>
FN_Pausecontent_<?php echo $filterednews_id; ?>[<?php echo $k; ?>]='<?php echo ${'content'.$k}; ?>';
<?php  $k++;  endforeach; ?>

new FN_Pausescroller(FN_Pausecontent_<?php echo $filterednews_id; ?>, "fn_scroller_<?php echo $filterednews_id; ?>", "", <?php echo $params->get('delay', 3000) ?>);
-->
</script>
