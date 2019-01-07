<?php
/**
 * @copyright Copyright (C) 2008 Tobias Gesellchen. All rights reserved.
 * @license   GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die('Direct Access to this location is not allowed.');

jimport( 'joomla.plugin.plugin' );

/**
 * TitleLink Content Plugin
 */
class plgContentLatex extends JPlugin
{
	/**
	 * see http://www.php.net/manual/en/reference.pcre.pattern.syntax.php
	 * for details: this special "character" is used as start/end tag
	 * for the preg_match functions.
	 */
	var $p_s_e = "\x01";


  /**
   * Constructor
   *
   * For php4 compatability we must not use the __constructor as a constructor for plugins
   * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
   * This causes problems with cross-referencing necessary for the observer design pattern.
   *
   * @param object $subject The object to observe
   * @param object $params  The object that holds the plugin parameters
   */
  function plgContentLatex( &$subject, $params )
  {
    parent::__construct( $subject, $params );
  }

	function doRep($pattern, $replacement, $subject)
	{
		return preg_replace($this->p_s_e.$pattern.$this->p_s_e, $replacement, $subject);
	}

	/**
	 * Replaces TeX tags with the appropriate html tags
	 *
	 * Method is called by the view
	 *
	 * @param   object    The article object.  Note $article->text is also available
	 * @param   object    The article params
	 * @param   int     The 'page' number
	 */
  function onPrepareContent( &$article, &$params, $limitstart )
  {
  	$result = '';
    $content = $article->text;
    $matches = array ();

    if (preg_match_all($this->p_s_e.'.+?\.tex'.$this->p_s_e, $content, $matches, PREG_PATTERN_ORDER))
    {
      foreach ($matches as $fmatch)
      {
        foreach ($fmatch as $match)
        {
          if ($match == "")
          {
            continue;
          }

          $match = html_entity_decode($match, ENT_QUOTES);
          
          $filename = JURI::base(false).$match;

          $lastindex = strrpos($match, "/");
          if ($lastindex !== false)
          {
            $foldername = JURI::root(true).'/'.substr($match, 0, $lastindex).'/';
          }
          
          //$result .= $filename.'<br />';
          $result .= $this->convertToHtml(file_get_contents($filename), $foldername).'<br />';
        }
      }
    }

    if ($result)
    {
    	//$article->text = '<p>'.$article->text.'</p>';
      //$article->readmore = 1;
      $article->text = $result;
    }

    return true;
  }
  
  function convertToHtml($result, $foldername)
  {
  	$result = $this->doRep('(%.+?\n)', '', $result);

		$result = $this->doRep('\\\\label\{(.+?)\}', '<a name="$1"></a>', $result);
		$result = $this->doRep('~', '&nbsp;', $result);
		$result = $this->doRep('\\\\hrulefill', '<hr />', $result);
		$result = $this->doRep('\\\\_', '_', $result);

		$result = $this->doRep('\\\\url\{(.+?)\}', '<a href="$1">$1</a>', $result);
		$result = $this->doRep('\\\\emph\{(.+?)\}', '<em>$1</em>', $result);
		$result = $this->doRep('\\\\normalsize\{(.+?)\}', '$1', $result);
		$result = $this->doRep('\\\\vspace\*?\{(.+?)\}', '<br /><br />', $result);
		
		$result = $this->doRep('\\\\begin\{itemize\}', '<ul>', $result);
		$result = $this->doRep('\\\\end\{itemize\}', '</ul>', $result);
		$result = $this->doRep('\\\\begin\{enumerate\}', '<ol>', $result);
		$result = $this->doRep('\\\\end\{enumerate\}', '</ol>', $result);
		$result = $this->doRep('\\\\begin\{description\}', '<dl>', $result);
		$result = $this->doRep('\\\\end\{description\}', '</dl>', $result);
		$result = $this->doRep('\\\\item (.+?\n)', '<li>$1</li>', $result);
		$result = $this->doRep('\\\\item\[(.+?)]( .+?\n)', '<dt>$1</dt><dd>$2</dd>', $result);

		$result = $this->doRep('\\\\begin\{(wrap)?figure\}', '<img', $result);
		$result = $this->doRep('\\\\end\{(wrap)?figure\}', ' />', $result);
		// TODO
		$result = $this->doRep('<img(\s|.)+?(\\\\pdfimage(.+?)( ((width)|(height)) (.+) )?(.+?) \{(.+?)\})+?(\s|.)+? />', '<p align="center"><img style="$9" src='.'"'.$foldername.'$10'.'"'.' /></p>', $result);
		$result = $this->doRep('<img style="((width)|(height)) (.+)" src=', '<img style="$1 : $4" src=', $result);
		$result = $this->doRep('<img style="width : \\\\patternwidth"', '<img style="width : 100%"', $result);
		$result = $this->doRep('<img style="width : \\\\examplewidth"', '<img style="width : 100%"', $result);
		$result = $this->doRep('<img style="width : \\\\textwidth"', '<img style="width : 100%"', $result);

		// TODO
		$result = $this->doRep('\\\\begin\{tabular\}\{(.+?)\}', '<table>', $result);
		$result = $this->doRep('\\\\end\{tabular\}', '</table>', $result);
		//$result = $this->doRep('<img(\s|.)+?(\\\\pdfimage (.+?) \{(.+?)\})+?(\s|.)+? />', '<p align="center"><img src="$4" /></p>', $result);

		// TODO
		$result = $this->doRep('\\\\begin\{table\}\[(.+?)\]', '<table>', $result);
		$result = $this->doRep('\\\\end\{table\}', '</table>', $result);
		//$result = $this->doRep('<img(\s|.)+?(\\\\pdfimage (.+?) \{(.+?)\})+?(\s|.)+? />', '<p align="center"><img src="$4" /></p>', $result);
		
		$result = $this->doRep('\\\\chapter\{(.+?)\}', '<h1>$1</h1>', $result);
		$result = $this->doRep('\\\\section\{(.+?)\}', '<h2>$1</h2>', $result);
		$result = $this->doRep('\\\\section\[(.+?)\]?\{(.+?)\}', '<h2>$1</h2>', $result);
		$result = $this->doRep('\\\\subsection\{(.+?)\}', '<h3>$1</h3>', $result);
		
		$result = $this->doRep('\\\\begin\{center\}', '<div align="center">', $result);
		$result = $this->doRep('\\\\end\{center\}', '</div>', $result);
		
		$result = $this->doRep('\\\\texttt\{(((\r\n)|(\n\r)|\n|\r|.)+?)\}', '<code>$1</code>', $result);
		$result = $this->doRep('\§(((\r\n)|(\n\r)|\n|\r|.)+?)\§', '<code>$1</code>', $result);
		
		$result = $this->doRep('\\\\begin\{titlepage\}', '', $result);
		$result = $this->doRep('\\\\end\{titlepage\}', '', $result);
		$result = $this->doRep('\\\\normalsize', '', $result);
		$result = $this->doRep('\\\\thispagestyle\{empty\}', '', $result);
		$result = $this->doRep('\\\\-', '', $result);
		$result = $this->doRep('\$\\\\hookrightarrow\$', '', $result);
		$result = $this->doRep('\\\\\&', '&', $result);
		$result = $this->doRep('\\\\\$', '$', $result);
		$result = $this->doRep('\"\`', '&quot;', $result);
		$result = $this->doRep('\"\'', '&quot;', $result);
		$result = $this->doRep('ß', '&szlig;', $result);
		$result = $this->doRep('ä', '&auml;', $result);
		$result = $this->doRep('ö', '&ouml;', $result);
		$result = $this->doRep('ü', '&uuml;', $result);
		$result = $this->doRep('Ä', '&Auml;', $result);
		$result = $this->doRep('Ö', '&Ouml;', $result);
		$result = $this->doRep('Ü', '&Uuml;', $result);
		$result = $this->doRep('\\\\\\\\((\r\n)|(\n\r)|\n|\r| )', '<br />', $result);
		
		return $result;
  }
}
?>