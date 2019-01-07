/**
 * Main JavaScript file (MooTools 1.11 compatible)
 *
 * @package     Tabber
 * @version     1.7.1
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

window.addEvent( 'domready', function() {
	// Only do stuff if tabber_nav is found
	if ( document.getElements( 'div.tabber_nav' ).length && document.getElements( 'div.tabber_content' ).length ) {
		(function() { Tabber = new Tabber(); }).delay( 100 );
	} else {
		// Try again 2 seconds later, because IE sometimes can't see object immediately
		(function() {
			if ( document.getElements( 'div.tabber_nav' ).length && document.getElements( 'div.tabber_content' ).length ) {
				Tabber = new Tabber();
			}
		}).delay( 2000 );
	}
});

var Tabber = new Class({
	initialize: function()
	{
		var self = this;
		this.docScroll = new Fx.Scroll( window );
		this.containers = new Array();

		document.getElements( 'div.tabber_container' ).each( function( container ) {
			if ( typeof( container ) != "undefined" ) {
				container.removeClass( 'tabber_noscript' );

				var c_id = container.id.replace( 'tabber_container_', '' );
				var active = 0;

				container.getElements( 'div.tabber_content' ).each( function( el ) {
					if ( typeof( el ) != "undefined" ) {
						var set_id = el.id.replace( 'tabber_content_', '' );
						if ( set_id == c_id ) {
							el.fx = new Fx.Style( el, 'height', { 'duration' : tabber_slide_speed, onComplete: function() { self.autoHeight( el ); } } );
						}
					}
				});

				// add events on tabs
				var first = 1;
				container.getElements( 'li.tabber_tab' ).each( function( el ) {
					if ( typeof( el ) != "undefined" && !el.hasClass( 'tabber_notab' ) ) {
						var id = el.id.replace( 'tabber_tab_', '' );
						var set_id = id.slice( 0, id.indexOf( '-' ) );
						if ( set_id == c_id ) {
							self.containers[id] = c_id;

							// set first tab as active or active tab
							if ( ( first && !el.hasClass( 'inactive' ) ) || el.hasClass( 'active' ) ) {
								active = id;
							}

							el.addEvent( tabber_mode, function() { self.showTab( id, c_id ); } );
							first = 0;
						}
						el.setStyle( 'display', 'block' );
					}
				});

				if ( tabber_use_cookies && active !== tabber_url ) {
					active_cookie = self.getByCookie( c_id );
					if ( active_cookie ) {
						active = active_cookie;
					}
				}

				// add fx
				container.getElements( 'div.tabber_item' ).each( function( el ) {
					if ( typeof( el ) != "undefined" ) {
						var id = el.id.replace( 'tabber_item_', '' );
						var set_id = id.slice( 0, id.indexOf( '-' ) );
						if ( set_id == c_id ) {
							el.setStyle( 'display', 'block' );
							el.fade_in = new Fx.Styles( el, { 'duration' : tabber_fade_in_speed } );
							el.fx = new Fx.Slide( el, { 'duration' : 0, onComplete: function() { self.autoHeight( el.getParent() ); } } ).hide();
						}
					}
				});

				// hide content titles
				container.getElements( '.tabber_title' ).each( function( el ) {
					if ( typeof( el ) != "undefined" ) {
						el.setStyle( 'display', 'none' );
					}
				});

				// show only active tab
				self.showTab( active, c_id, 1, ( active === tabber_urlscroll ) );

				// show tabs list
				container.getElements( 'div.tabber_nav' ).each( function( el ) {
					if ( typeof( el ) != "undefined" ) {
						el.setStyle( 'display', 'block' );
					}
				});
			}
		});

		// add onclick events on tab links {tablink=...}
		document.getElements( 'a.tabber_tablink' ).each( function( el ) {
			if ( typeof( el ) != "undefined" && el.rel && typeof( self.containers[el.rel] ) != "undefined" ) {
				el.addEvent( 'click', function() {
					self.showTab( el.rel, self.containers[el.rel], 0, tabber_tablinkscroll );
					if ( tabber_tablinkscroll ) {
						self.docScroll.stop().toElement( $( 'tabber_tab_'+el.rel ) );
					}
				} );
				el.href = 'javascript://';
			}
		});
	},

	showTab: function( id, c_id, first, scroll )
	{
		var container = $( 'tabber_container_'+c_id );
		var item = $( 'tabber_tab_'+id );
		var isactive = ( typeof( item ) != "undefined" && item && item.hasClass( 'active' ) );
		var content = null;

		// remove all active classes
		container.getElements( 'li.tabber_tab' ).each( function( el ) {
			if ( typeof( el ) != "undefined" && el && el.hasClass( 'active' ) ) {
				var el_id = el.id.replace( 'tabber_tab_', '' );
				var set_id = el_id.slice( 0, el_id.indexOf( '-' ) );
				if ( set_id == c_id ) {
					el.removeClass( 'active' );
					content = $( 'tabber_item_'+el_id );
					if ( content ) {
						content.getParent().getParent().setStyle( 'height', parseInt( content.getStyle( 'height' ) ) );
					}
				}
			}
		});

		if ( typeof( item ) != "undefined" && item ) {
			item.addClass( 'active' );
		}

		var el = $( 'tabber_item_'+id );

		// show active content block
		if ( typeof( el ) != "undefined" && el && typeof( el.fx ) != "undefined" ) {
			el.removeClass( 'tabber_item_inactive' );
			content = el.getParent().getParent();
			content.className = ( 'tabber_content '+( el.className.replace( 'tabber_item', '' ) ) ).trim();
			el.fx.stop();

			// show active content block
			if ( first ) {
				el.fx.show();
				this.autoHeight( el.getParent(), 1 );
				this.autoHeight( content, 1 );
			} else if ( !isactive ) {
				el.fade_in.stop();
				el.setStyle( 'opacity', 0 );
				el.fx.show();
				this.autoHeight( el.getParent() );
				el.fade_in.start( { 'opacity' : 1 } );
				content.fx.stop().start( parseInt( el.getStyle( 'height' ) ) );
			}
			if ( scroll || item.hasClass( 'scroll' ) || ( tabber_scroll && !first && !item.hasClass( 'noscroll' ) ) ) {
				if ( typeof( container ) != "undefined" && container ) {
					this.docScroll.stop().toElement( container );
				}
			}

			if ( tabber_use_cookies || tabber_set_cookies ) {
				this.setCookie( id, c_id, 1 );
			}
		}

		// hide all content block
		container.getElements( 'div.tabber_item' ).each( function( el ) {
			if ( id && typeof( el ) != "undefined" && el && el.id && el.id != 'tabber_item_'+id && typeof( el.fx ) != "undefined" ) {
				var el_id = el.id.replace( 'tabber_item_', '' );
				var set_id = el_id.slice( 0, el_id.indexOf( '-' ) );
				if ( set_id == c_id ) {
					el.fx.hide();
				}
			}
		});
	},

	autoHeight: function( el, force )
	{
		if ( typeof( el ) != "undefined" && el && el.getStyle( 'height' ) && ( force || parseInt( el.getStyle( 'height' ) ) > 0 ) ) {
			el.setStyle( 'height', 'auto' );
		}
	},

	setCookie: function ( id, c_id, add )
	{
		var set = c_id.slice( 0, c_id.indexOf( '___' ) );
		var obj = new Object();
		var cookies = Cookie.get( tabber_cookie_name );
		if ( cookies ) {
			cookies = cookies.split( '___' );
			for( i = 0; i < cookies.length; i++ ) {
				var keyval = cookies[i].split( '=' );
				if ( keyval.length > 1 && keyval[0] != set ) {
					obj[keyval[0]] = keyval[1];
				}
			}
		}
		if ( add ) {
			obj[set] = id.slice( id.indexOf( '-' )+1 );
		}

		var arr = new Array();
		for( var i in obj ) {
			if ( i && obj[i] ) {
				arr[arr.length] = i+'='+obj[i];
			}
		}

		Cookie.set( tabber_cookie_name, arr.join( '___' ) );
	},

	getByCookie: function ( c_id )
	{
		var set = c_id.slice( 0, c_id.indexOf( '___' ) );
		var cookies = Cookie.get( tabber_cookie_name );
		if ( cookies ) {
			cookies = cookies.split( '___' );
			for( i = 0; i < cookies.length; i++ ) {
				if ( cookies[i] && cookies[i].slice( 0, cookies[i].indexOf( '=' ) ) == set ) {
					return c_id+'-'+cookies[i].slice( cookies[i].indexOf( '=' )+1 );
				}
			}
		}
		return 0;
	}
});