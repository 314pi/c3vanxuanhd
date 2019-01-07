<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgContentBadWordFilter extends JPlugin {

  function plgContentBadWordFilter( &$subject, $config ) {
    parent::__construct( $subject, $config );
  }

  function onPrepareContent(&$row, &$params, $page=0) {
    if (is_object($row)) {
        $text = &$row->text;
    }
    else {
      $text = &$row;
    }
    global $mainframe;

    $plugin = & JPluginHelper::getPlugin('content', 'badwordfilter');
    $pluginParams = new JParameter($plugin->params);

    $allow_exceptions = $pluginParams->def('allow_exceptions', '1');

    if ($allow_exceptions == '1') {
      if (JString::strpos($text, '{no_badwordfilter}') !== false) {
        return true;
      }
    }

    $badwords = $pluginParams->def('bad_words', 'porn, sex');
    $html_out = $pluginParams->def('html_out', '<s>BAD WORD</s>');


    $badwords_array = explode(',', $badwords);

    foreach($badwords_array as $badword) {
      $text = JString::str_ireplace($badword, $html_out, $text);
    }

    return true;
  }

}