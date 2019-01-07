<?php
/**
 * Plugin Helper File
 *
 * @package     Slider
 * @version     1.7.1
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

// Load common functions
require_once JPATH_PLUGINS.'/system/nnframework/helpers/functions.php';

/**
* Plugin that replaces stuff
*/
class plgSystemSliderHelper
{
	function __construct( &$params )
	{
		$this->params = $params;
		$this->params->hasitems = 0;

		$this->params->comment_start = '<!-- START: Slider -->';
		$this->params->comment_end = '<!-- END: Slider -->';

		$bts = '((?:<[a-zA-Z][^>]*>(?:\s|&nbsp;|&\#160;)*){0,5})'; // break tags start
		$bte = '((?:(?:\s|&nbsp;|&\#160;)*<(?:/[a-zA-Z]|br)[^>]*>){0,5})'; // break tags end

		$this->params->tag_open = preg_replace( '#[^a-z0-9-_]#si', '', $this->params->tag_open );
		$this->params->tag_close = preg_replace( '#[^a-z0-9-_]#si', '', $this->params->tag_close );
		$this->params->tag_link = preg_replace( '#[^a-z0-9-_]#si', '', $this->params->tag_slidelink );
		$this->params->tag_delimiter = ( $this->params->tag_delimiter == 'space' ) ? ' ' : '=';

		$this->params->regex = '#'
			.$bts
			.'\{('.preg_quote( $this->params->tag_open, '#' ).'s?((?:-[a-z0-9-_]*)?)'
				.preg_quote( $this->params->tag_delimiter, '#' )
				.'((?: |<|&nbsp;)?[^\}]*)|/'.preg_quote( $this->params->tag_close, '#' )
				 .'(?:-[a-z0-9-_]*)?)\}'
			.$bte
			.'#s';
		$this->params->regex_end = '#'
		   .$bts
		   .'\{/'.preg_quote( $this->params->tag_close, '#' )
				.'(?:-[a-z0-9-_]*)?\}'
		   .$bte
		   .'#s';
		$this->params->regex_link = '#'
			.'\{'.preg_quote( $this->params->tag_link, '#' )
				.'(?:-[a-z0-9-_]*)?'.preg_quote( $this->params->tag_delimiter, '#' )
				.'([^\}]*)\}'
			.'(.*?)'
			.'\{/'.preg_quote( $this->params->tag_link, '#' ).'\}'
			.'#s';

		$this->params->protect_s = array( '{'.$this->params->tag_open, '{/'.$this->params->tag_close, '{'.$this->params->tag_link );
		$this->params->protect_r = array( $this->protectStr( $this->params->protect_s['0'] ), $this->protectStr( $this->params->protect_s['1'] ), $this->protectStr( $this->params->protect_s['2'] ) ) ;

		$this->allitems = array();
		$this->setcount = 0;

		$url = JFactory::getURI();
		$this->params->cookie_name = 'slider_'.md5( $url->toString() );
	}

////////////////////////////////////////////////////////////////////
// onAfterDispatch
////////////////////////////////////////////////////////////////////
	function onAfterDispatch()
	{
		$document =& JFactory::getDocument();
		$docType = $document->getType();

		// PDF
		if ( $docType == 'pdf' ) {
			if ( isset( $document->_buffer ) ) {
				$this->replaceTags( $document->_buffer, 0 );
			}
			return;
		}

		// only in html
		if ( $docType !== 'html' && $docType !== 'feed' ) { return; }

		// do not load scripts/styles on print page
		if ( $docType !== 'feed' && !JRequest::getInt( 'print' ) ) {
			if ( $this->params->load_mootools ) {
				JHTML::_( 'behavior.mootools' );
			}

			$version = '';
			if ( $this->params->use_versioned_files ) {
				require_once JPATH_PLUGINS.'/system/nnframework/helpers/versions.php';
				$version = NoNumberVersions::getXMLVersion( 'slider', 'system', null, 1 );
			}
			$mtversion = NNFrameworkFunctions::getMooToolsVersion( $this->params->mootools_compatibility );

			$script = '
				var slider_mode = \''.$this->params->slider_mode.'\';
				var slider_speed = '.(int) $this->params->slider_slide_speed.';
				var slider_fade_in_speed = '.(int) $this->params->slider_fade_in_speed.';
				var slider_fade_out_speed = '.(int) $this->params->slider_fade_out_speed.';
				var slider_scroll = '.(int) $this->params->slider_scroll.';
				var slider_slidelinkscroll = '.(int) $this->params->slider_slidelinkscroll.';
				var slider_url = \'\';
				var slider_urlscroll = \'\';
				var slider_use_cookies = '.(int) $this->params->use_cookies.';
				var slider_set_cookies = '.(int) $this->params->set_cookies.';
				var slider_cookie_name = \''.$this->params->cookie_name.'\';
			';
			$document->addScriptDeclaration( preg_replace( '#\n\s*#s', ' ', $script ) );
			$document->addScript( JURI::root( true ).'/plugins/system/slider/js/script'.$mtversion.'.js'.$version );
			if ( $this->params->load_stylesheet ) {
				$document->addStyleSheet( JURI::root( true ).'/plugins/system/slider/css/style.css'.$version );
			}
			$style = '';
			if ( $this->params->rounded && $this->params->rounded_radius && (int) $this->params->rounded_radius != 10 ) {
				$r = (int) $this->params->rounded_radius;
				$style .= '
					div.slider_container.rounded div.slider_slide a,
					div.slider_container.rounded div.slider_slide a:hover {
						-webkit-border-radius: '.$r.'px;
						-moz-border-radius: '.$r.'px;
						border-radius: '.$r.'px;
					}
					div.slider_container.rounded div.slider_slide.active a,
					div.slider_container.rounded div.slider_slide.active a:hover {
						-webkit-border-radius: '.$r.'px '.$r.'px 0 0;
						-moz-border-radius: '.$r.'px '.$r.'px 0 0;
						border-radius: '.$r.'px '.$r.'px 0 0;
					}
					div.slider_container.rounded div.slider_content_wrapper div.slider_content {
						-webkit-border-radius: 0 0 '.$r.'px '.$r.'px;
						-moz-border-radius: 0 0 '.$r.'px '.$r.'px;
						border-radius: 0 0 '.$r.'px '.$r.'px;
					}
					div.slider_slide.indent,
					div.slider_slide.indenttitle {
						padding: 0 '.$r.'px;
					}
					div.slider_container.rounded div.slider_slide.indentcontent.active a,
					div.slider_container.rounded div.slider_slide.indentcontent.active a:hover {
						-webkit-border-radius: '.$r.'px;
						-moz-border-radius: '.$r.'px;
						border-radius: '.$r.'px;
					}
					div.slider_content_wrapper.indent,
					div.slider_content_wrapper.indentcontent{
						padding: 0 '.$r.'px;
					}
					div.slider_container.rounded div.slider_content_wrapper.indenttitle div.slider_content {
						-webkit-border-radius: '.$r.'px;
						-moz-border-radius: '.$r.'px;
						border-radius: '.$r.'px;
					}
				';
			}

			$this->params->line_color = ( $this->params->outline ? '#'.$this->params->line_color : 'transparent' );
			if ( $this->params->line_color != '#B4B4B4' ) {
				$style .= '
					div.slider_slide a,
					div.slider_slide a:hover,
					div.slider_content_wrapper div.slider_content {
						border-color: '.$this->params->line_color.';
					}
				';
			}
			if ( $style ) {
				$document->addStyleDeclaration( preg_replace( '#\n\s*#s', ' ', $style ) );
			}
		}

		$buffer = $document->getBuffer( 'component' );

		if ( !$buffer || strpos( $buffer, '{'.$this->params->tag_open ) === false ) { return; }

		$this->params->hasitems = 1;

		$this->protect( $buffer );
		$this->replaceTags( $buffer );
		$this->unprotect( $buffer );

		$document->setBuffer( $buffer, 'component' );
	}

////////////////////////////////////////////////////////////////////
// onAfterRender
////////////////////////////////////////////////////////////////////
	function onAfterRender()
	{
		$document =& JFactory::getDocument();
		$docType = $document->getType();

		// only in html and feeds
		if ( $docType !== 'html' && $docType !== 'feed' ) { return; }

		$html = JResponse::getBody();
		if ( $html == '' ) { return; }

		if ( strpos( $html, '{'.$this->params->tag_open ) === false ) {
			if ( !$this->params->hasitems ) {
				// remove style and script if no items are found
				$html = preg_replace( '#\s*<'.'link rel="stylesheet" href="[^"]*/plugins/system/slider/css/style\.css[^"]*" type="text/css" />#s', '', $html );
				$html = preg_replace( '#\s*<'.'script type="text/javascript" src="[^"]*/plugins/system/slider/js/script[^"]\.js[^"]*"></script>#s', '', $html );
			}
		} else {
			if ( !( strpos( $html, '<body' ) === false ) && !( strpos( $html, '</body>' ) === false ) ) {
				$html_split = explode( '<body', $html, 2 );
				$body_split = explode( '</body>', $html_split['1'], 2 );

				// only do stuff in body
				$this->protect( $body_split['0'] );
				$this->replaceTags( $body_split['0'] );
				$this->unprotect( $body_split['0'] );

				$html_split['1'] = implode( '</body>', $body_split );
				$html = implode( '<body', $html_split );
			} else {
				$this->protect( $html );
				$this->replaceTags( $html );
				$this->unprotect( $html );
			}
		}

		JResponse::setBody( $html );
	}

////////////////////////////////////////////////////////////////////
// FUNCTIONS
////////////////////////////////////////////////////////////////////
	function replaceTags( &$str, $shownav = 1 )
	{
		$shownav = $shownav ? ( !JRequest::getInt( 'print' ) ) : 0;

		if( !$shownav || ( strpos( $str, '{/'.$this->params->tag_close ) === false && strpos( $str, 'class="slider_container' ) === false ) ) {
			if ( preg_match_all( $this->params->regex, $str, $matches, PREG_SET_ORDER ) > 0 ) {
				foreach ( $matches as $match ) {
					$title = $match['4'];
					if ( !( strpos( $title, '|' ) === false ) ) {
						list( $title, $extra ) = explode( '|', $title, 2 );
					}
					$title = trim( $title );
					$name = trim( preg_replace( '#</?[a-z][^>]*>#usi', '', $title ) );
					$replace = '<a name="'.$name.'"></a><'.$this->params->title_tag.' class="slider_title">'.$title.'</'.$this->params->title_tag.'>';
					$str = str_replace( $match['0'], $replace, $str );
				}
			}
			if ( preg_match_all( $this->params->regex_end, $str, $matches, PREG_SET_ORDER ) > 0 ) {
				foreach ( $matches as $match ) {
					$str = str_replace( $match['0'], '', $str );
				}
			}
			if ( preg_match_all( $this->params->regex_link, $str, $matches, PREG_SET_ORDER ) > 0 ) {
				foreach ( $matches as $match ) {
					$link = '<a href="#'.$match['1'].'">'.$match['2'].'</a>';
					$str = str_replace( $match['0'], $link, $str );
				}
			}
			return;
		}

		$sets = array();
		$setids = array();

		if ( preg_match_all( $this->params->regex, $str, $matches, PREG_SET_ORDER ) > 0 ) {
			foreach ( $matches as $match ) {
				if ( $match['2']['0'] == '/' ) {
					array_pop( $setids );
					continue;
				}
				end( $setids );
				$item = new stdClass();
				$item->orig = $match['0'];
				$item->setid = trim( str_replace( '-', '_', $match['3'] ) );
				if ( empty( $setids ) || current( $setids ) != $item->setid ) {
					$this->setcount++;
					$setids[$this->setcount.'_'] = $item->setid;
				}
				$item->set = str_replace( '__', '_', array_search( $item->setid, array_reverse( $setids ) ).$item->setid );
				$item->title = trim( $match['4'] );
				$item->title_full = $item->title;
				list( $item->pre, $item->post ) = NNFrameworkFunctions::setSurroundingTags( $match['1'], $match['5'] );
				if ( !isset( $sets[$item->set] ) ) {
					$sets[$item->set] = array();
				}
				$sets[$item->set][] = $item;
			}
		}

		$urlitem = JRequest::getString( 'slide', '', 'default', 1 );
		$doscroll = $this->params->slider_urlscroll;
		if ( $doscroll ) {
			if ( substr( $urlitem, -1, 1 ) == '-' ) {
				$doscroll = 0;
				$urlitem = trim( substr( $urlitem, 0, strlen( $urlitem ) - 1 ) );
			}
		} else {
			if ( substr( $urlitem, -1, 1 ) == ' ' ) {
				$doscroll = 1;
			}
		}
		$urlitem = trim( $urlitem );
		if ( is_numeric( $urlitem ) ) {
			$urlitem = '1-'.$urlitem;
		}
		$urlscroll = '';
		$active_url = '';

		$cookies = '';
		if ( $this->params->use_cookies ) {
			$c = JRequest::getString( $this->params->cookie_name, null, 'COOKIE' );
			if ( $c ) {
				$c = explode( '___', $c );
				$cookies = array();
				foreach( $c as $cookie ) {
					$cookie = explode( '=', $cookie );
					if ( $cookie['0'] && isset( $cookie['1'] ) ) {
						$cookies[$cookie['0']] = (int) $cookie['1'];
					}
				}
			}
		}

		foreach ( $sets as $set_id => $items ) {
			$rand = '___'.rand( 100, 999 ).'___';
			$active_by_url = '';
			$active_by_cookie = '';
			$active = 0;
			foreach ( $items as $i => $item ) {
				$item->class = '';
				$item->active = 0;
				$item->title_full = trim( $item->title );
				if ( !( strpos( $item->title_full, '|' ) === false ) ) {
					list( $item->title_full, $extra ) = explode( '|', $item->title_full, 2 );
					$item->title_full = trim( $item->title_full );
					$extra = explode( '|', $extra );
					foreach ( $extra as $e ) {
						switch ( $e ) {
							case 'active':
							case 'opened':
							case 'open':
								$active = $i;
								break;
							case 'inactive':
							case 'closed':
							case 'close':
								if ( $active == $i ) {
									$active = '';
								}
								break;
							default:
								$item->class = trim( $item->class.' '.$e );
								break;
						}
					}
				}
				// remove tags
				$item->title = trim( preg_replace( '#</?[a-z][^>]*>#usi', '', $item->title_full ) );

				$item->set = $set_id.$rand;
				$item->setname = $set_id;
				$item->count = $i+1;
				$item->id = $item->set.'-'.$item->count;
				$item->haslink = preg_match( '#<a [^>]*>.*?</a>#usi', $item->title_full );

				if ( !empty( $cookies ) && isset( $cookies[$set_id] ) && ( $cookies[$set_id] == $item->count ) ) {
					$active_by_cookie = $i;
				}

				$match_titles = array();
				$match_titles[] = $item->title;
				$match_titles[] = utf8_encode( html_entity_decode( $match_titles['0'], ENT_COMPAT, 'UTF-8' ) );
				if ( extension_loaded('mbstring') ) {
					$match_titles[] = mb_convert_case( $match_titles['0'], MB_CASE_LOWER, 'UTF-8' );
					$match_titles[] = utf8_encode( html_entity_decode( $match_titles['2'], ENT_COMPAT, 'UTF-8' ) );
				}

				$item->matches = array();
				foreach ( $match_titles as $title ) {
					$item->matches[] = $title;
					$item->matches[] = str_replace( ' ', '', $title );
					$item->matches[] = urlencode( $title );
					$item->matches[] = utf8_decode( $title );
				}

				$alias = preg_replace( '#&([a-z])[a-z]*;#s', '\1', $match_titles['2'] );
				$alias = trim( preg_replace( '#[^a-z0-9]#s', '', $alias ) );
				if ( $alias ) {
					$item->matches[] = $alias;
				}
				$item->matches[] = ( $i+1 ).'';
				$item->matches[] = ( (int) $item->set ).'-'.( $i+1 );

				$item->matches = array_unique( $item->matches );

				if ( $urlitem != '' && ( in_array( $urlitem, $item->matches, 1 ) || in_array( strtolower( $urlitem ), $item->matches, 1 ) ) ) {
					if ( !$item->haslink ) {
						$active_by_url = $i;
						if ( $doscroll ) {
							$urlscroll = $item->id;
						}
					}
				}
				if ( $active == $i && $item->haslink ) {
					$active++;
				}

				$sets[$set_id][$i] = $item;
				$this->allitems[] = $item;
			}

			if ( $active_by_url !== '' && isset( $sets[$set_id][$active_by_url] ) ) {
				$sets[$set_id][$active_by_url]->active = 1;
				$active_url = $sets[$set_id][$active_by_url]->id;
			} else if ( $active_by_cookie !== '' && isset( $sets[$set_id][$active_by_cookie] ) ) {
				$sets[$set_id][$active_by_cookie]->active = 1;
			} else if ( $active !== '' && isset( $sets[$set_id][(int) $active] ) ) {
				$sets[$set_id][(int) $active]->active = 1;
			}
		}

		$script_set = 0;
		foreach ( $sets as $items ) {
			$first = key( $items );
			end( $items );
			$last = key( $items );
			foreach ( $items as $i => $item ) {
				$s = '#'.preg_quote( $item->orig, '#' ).'#';
				if ( @preg_match( $s.'u', $str ) ) {
					$s .= 'u';
				}
				if ( preg_match( $s, $str ) ) {
					$html = array();
					$html[] = $item->post;
					$html[] = $item->pre;
					if ( $item->active ) {
						$html[] = '<script type="text/javascript">document.write( '
								.'String.fromCharCode(60)+\'style type="text/css">'
									.'div#slider_slide_'.$item->id.' { display: block !important; }'
								.'\'+String.fromCharCode(60)+\'/style>'
							.'\' );</script>';
					}
					if ( $i == $first ) {
						if ( !$script_set ) {
							$html[] = '<script type="text/javascript">document.write( \''
									.'\'+String.fromCharCode(60)+\'style type="text/css">'
										.'div.slider_content_inactive { display: none; }'
										.'.slider_title { display: none !important; }'
									.'\'+String.fromCharCode(60)+\'/style>'
								.'\' );</script>';
							$script_set = 1;
						}
						$html[] = '<div class="'.trim( 'slider_container slider_container_'.$item->setname.' slider_noscript '.( ( $this->params->rounded && $this->params->rounded_radius ) ? 'rounded' : '' ) ).'" id="slider_container_'.$item->set.'">';
					} else {
						$html[] = '<div style="clear:both;"></div>';
						$html[] = '</div></div></div>';
					}

					$item->class = ( $item->active == 1 ? ' active' : '' ).' '.$item->class;
					if ( strpos( $item->class, 'indent' ) === false ) {
						$item->class .= ' '.$this->params->indent;
					}

					if ( $item->haslink && preg_match( '#(<a [^>]*>)(.*?)(</a>)#usi', $item->title_full, $match ) ) {
						$link = str_replace( $match['0'], $match['1'].'<span>'.$match['2'].'</span>'.$match['3'], $item->title_full );
						$item->class .= ' slide_noslide';
					} else {
						$link = '<a href="javascript:// '.$item->title.'"><span>'.$item->title_full.'</span></a>';
					}

					$html[] = '<div style="display:none;" class="'.trim( 'slider_slide slider_count_'.$item->count.' '.trim( $item->class ) ).'" id="slider_slide_'.$item->id.'">'.$link.'</div>';
					$html[] = '<div class="'.trim( 'slider_content_wrapper slider_count_'.$item->count.' '.trim( $item->class ) ).' slider_content_'.( $item->active ? '' : 'in' ).'active" id="slider_content_'.$item->id.'">';
					$html[] = '<div class="'.trim( 'slider_content '.trim( $item->class ) ).'">';
					$html[] = '<div class="slider_item" id="slider_item_'.$item->id.'">';
					$html[] = '<a name="'.$item->id.'"></a><'.$this->params->title_tag.' class="slider_title">'.$item->title_full.'</'.$this->params->title_tag.'>';

					if ( $i == $last ) {
						$html[] = '<script type="text/javascript">'
								."document.getElementById('slider_container_".$item->set."').setAttribute( 'class', document.getElementById('slider_container_".$item->set."').className.replace(/\bslider_noscript\b/,'') );"
							.'</script>';
					}

					$str = preg_replace( $s, implode( "\n", $html ), $str, 1 );
				}
			}
		}

		// closing html
		$html = array();
		$html[] = '<div style="clear:both;"></div>';
		$html[] = '</div></div></div>';
		$html[] = '<div style="height:1px;"></div>';
		$html[] = '</div>';
		if ( $active_url ) {
			$html[] = '<script type="text/javascript">';
			$html[] = 'slider_url = \''.$active_url.'\';';
			if ( $doscroll && $urlscroll ) {
				$html[] = 'slider_urlscroll = \''.$urlscroll.'\';';
			}
			$html[] = '</script>';
		}
		$html = implode( "\n", $html );

		if ( preg_match_all( $this->params->regex_end, $str, $matches, PREG_SET_ORDER ) > 0 ) {
			foreach ( $matches as $match ) {
				$m_html = $html;
				list( $pre, $post ) = NNFrameworkFunctions::setSurroundingTags( $match['1'], $match['2'] );
				$m_html = $pre.$m_html.$post;
				$str = str_replace( $match['0'], $m_html, $str );
			}
		}

		if ( preg_match_all( $this->params->regex_link, $str, $matches, PREG_SET_ORDER ) > 0 ) {
			foreach ( $matches as $match ) {
				$link = $match['2'];
				$linkitem = 0;
				$name = $match['1'];
				if ( is_numeric( $name ) ) {
					foreach ( $this->allitems as $item ) {
						if ( in_array( $name, $item->matches, 1 ) || in_array( (int) $name, $item->matches, 1 ) ) {
							$linkitem = $item;
							break;
						}
					}
				} else {
					foreach ( $this->allitems as $item ) {
						if ( in_array( $name, $item->matches, 1 ) || in_array( strtolower( $name ), $item->matches, 1 ) ) {
							$linkitem = $item;
							break;
						}
					}
				}
				if ( $linkitem ) {
					$link = '<a href="#'.$linkitem->id.'" class="slider_slidelink" rel="'.$linkitem->id.'">'.$link.'</a>';
				} else {
					$link = '<a href="#'.$name.'">'.$link.'</a>';
				}
				$str = str_replace( $match['0'], $link, $str );
			}
		}
	}

	/*
	 * Protect admin form
	 */
	function protect( &$string )
	{
		if (	in_array( JRequest::getCmd( 'task' ), array( 'edit' ) )
			||	in_array( JRequest::getCmd( 'view' ), array( 'edit', 'form' ) )
			||	in_array( JRequest::getCmd( 'layout' ), array( 'edit', 'form', 'write' ) )
			||	in_array( JRequest::getCmd( 'option' ), array( 'com_contentsubmit', 'com_cckjseblod' ) )
		) {
			// Protect complete adminForm (to prevent articles from being created when editing articles and such)
			$unprotected = $this->params->protect_s;
			$protected = $this->params->protect_r;
			$string = preg_replace( '#(<'.'form [^>]*(id|name)="adminForm")#si', '<!-- TMP_START_EDITOR -->\1', $string );
			$string = explode( '<!-- TMP_START_EDITOR -->', $string );
			foreach ( $string as $i => $str ) {
				if ( !empty( $str ) != '' && fmod( $i, 2 ) ) {
					if ( !( strpos( $str, $unprotected['0'] ) === false ) || !( strpos( $str, $unprotected['1'] ) === false ) || !( strpos( $str, $unprotected['2'] ) === false ) ) {
						$str = explode( '</form>', $str, 2 );
						$str['0'] = str_replace( $unprotected, $protected, $str['0'] );
						$string[$i] = implode( '</form>', $str );
					}
				}
			}
			$string = implode( '', $string );
		}
	}

	function unprotect( &$str )
	{
		$str = str_replace( $this->params->protect_r, $this->params->protect_s, $str );
	}

	function protectStr( $str )
	{
		return base64_encode( $str );
	}
}