<?php
/**
 * Plugin Helper File
 *
 * @package     Timed Styles
 * @version     1.4.1
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

/**
* Plugin that loads stylesheets based on time settings
*/
class plgSystemTimedStylesHelper
{
	function __construct( &$params )
	{
		$this->params = $params;

		require_once JPATH_PLUGINS.'/system/nnframework/helpers/assignments.php';
		$this->assignments = new NNFrameworkAssignmentsHelper;
	}

	function placeStyles()
	{
		$document	=& JFactory::getDocument();
		$docType = $document->getType();

		// only in html
		if ( $docType != 'html' ) { return; }

		$html = JResponse::getBody();
		if ( $html == '' ) { return; }

		$css_html = '';
		$styles = array();
		$total = 12;
		for ( $i=1; $i <= $total; $i++ ) {
			$s = 'style'.$i;
			list( $files, $css ) = $this->passStyle( $s );
			if ( !empty( $files ) ) {
				$styles = array_merge( $styles, $files );
			}

			$css_html = trim( $css_html."\n".$css );
		}

		if ( empty( $styles ) && !$css_html ) { return; }

		$styles = array_unique( $styles );

		if ( $css_html ) {
			$css_html = "\n".'<style type="text/css">'."\n".$css_html."\n".'</style>';
		}
		$css_html = implode( "\n", $styles ).$css_html;

		$html = str_replace( '</head>', $css_html."\n</head>", $html );
		JResponse::setBody( $html );
	}

	function passStyle( $s )
	{
		$ret = array( array(), '' );

		if ( !isset( $this->params->{$s.'_enable'} ) || !$this->params->{$s.'_enable'} || ( !$this->params->{$s.'_file'} && !$this->params->{$s.'_css'} ) ) {
			return $ret;
		}

		jimport( 'joomla.filesystem.file' );

		$files = $this->params->{$s.'_file'};
		$css = trim( $this->params->{$s.'_css'} );

		if ( !$files ) {
			$files = array();
		} else {
			$files = explode( '\n', $files );
			foreach ( $files as $i => $file ) {
				if( !$file ) {
					unset( $files[$i] );
				} else if ( strpos( $file, 'http' ) === false ) {
					$file = str_replace( '//', '/', $file );
					$path = JPATH_SITE.str_replace( '\\', '/', '/'.$file );
					if ( !$file || !JFile::exists( $path ) ) {
						unset( $files[$i] );
						$files[$i] = '<!-- '.html_entity_decode( JText::sprintf( 'TS_STYLESHEET_DOES_NOT_EXIST', JURI::root().$file ), ENT_COMPAT, 'UTF-8' ).' -->';
					} else {
						$files[$i] = '<link rel="stylesheet" href="'.JURI::root( true ).'/'.$file.'" type="text/css" />';
					}
				} else {
					$files[$i] = '<link rel="stylesheet" href="'.$file.'" type="text/css" />';
				}
			}
		}

		if ( empty( $files ) && !$css ) {
			return $ret;
		}

		$params = array();
		if ( $this->params->{$s.'_date'} ) {
			$params['Date'] = new stdClass();
			$params['Date']->assignment = $this->params->{$s.'_date'};
			$params['Date']->params = new stdClass();
			$params['Date']->params->publish_up = $this->params->{$s.'_date_publish_up'};
			$params['Date']->params->publish_down = $this->params->{$s.'_date_publish_down'};
		}
		if ( $this->params->{$s.'_seasons'} ) {
			$params['Seasons'] = new stdClass();
			$params['Seasons']->assignment = $this->params->{$s.'_seasons'};
			$params['Seasons']->selection = $this->params->{$s.'_seasons_selection'};
			$params['Seasons']->params = new stdClass();
			$params['Seasons']->params->hemisphere = $this->params->{$s.'_seasons_hemisphere'};
		}
		if ( $this->params->{$s.'_months'} ) {
			$params['Months'] = new stdClass();
			$params['Months']->assignment = $this->params->{$s.'_months'};
			$params['Months']->selection = $this->params->{$s.'_months_selection'};
		}
		if ( $this->params->{$s.'_days'} ) {
			$params['Days'] = new stdClass();
			$params['Days']->assignment = $this->params->{$s.'_days'};
			$params['Days']->selection = $this->params->{$s.'_days_selection'};
		}
		if ( $this->params->{$s.'_time'} ) {
			$params['Time'] = new stdClass();
			$params['Time']->assignment = $this->params->{$s.'_time'};
			$params['Time']->params = new stdClass();
			$params['Time']->params->publish_up = $this->params->{$s.'_time_publish_up'};
			$params['Time']->params->publish_down = $this->params->{$s.'_time_publish_down'};
		}

		return ( $this->assignments->passAll( $params ) ? array( $files, $css ) : $ret );
	}
}