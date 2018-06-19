/**
 * jquery.stapel.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Codrops
 * http://www.codrops.com
 */
;( function( $, window, undefined ) {
	
	'use strict';

	/*
	* debouncedresize: special jQuery event that happens once after a window resize
	*
	* latest version and complete README available on Github:
	* https://github.com/louisremi/jquery-smartresize/blob/master/jquery.debouncedresize.js
	*
	* Copyright 2011 @louis_remi
	* Licensed under the MIT license.
	*/
	var $event = $.event,
	$special,
	resizeTimeout;

	$special = $event.special.debouncedresize = {
		setup: function() {
			$( this ).on( "resize", $special.handler );
		},
		teardown: function() {
			$( this ).off( "resize", $special.handler );
		},
		handler: function( event, execAsap ) {
			// Save the context
			var context = this,
				args = arguments,
				dispatch = function() {
					// set correct event type
					event.type = "debouncedresize";
					$event.dispatch.apply( context, args );
				};

			if ( resizeTimeout ) {
				clearTimeout( resizeTimeout );
			}

			execAsap ?
				dispatch() :
				resizeTimeout = setTimeout( dispatch, $special.threshold );
		},
		threshold: 150
	};

	// global
	var $window = $( window ),
		Modernizr = window.Modernizr;

	$.Stapel = function( options, element ) {
		
		this.el = $( element );
		this._init( options );
		
	};

	// the options
	$.Stapel.defaults = {
		// space between the items
		gutter : 40,
		// the rotations degree for the 2nd and 3rd item 
		// (to give a more realistic pile effect)
		pileAngles : 2,
		// animation settings for the clicked pile's items
		pileAnimation : { 
			openSpeed : 400,
			openEasing : 'ease-in-out', // try this :) 'cubic-bezier(.47,1.34,.9,1.03)',
			closeSpeed : 400,
			closeEasing : 'ease-in-out'
		},
		// animation settings for the other piles
		otherPileAnimation : { 
			openSpeed : 400,
			openEasing : 'ease-in-out',
			closeSpeed : 350,
			closeEasing : 'ease-in-out'
		},
		// delay for each item of the pile
		delay : 0,
		// random rotation for the items once opened
		randomAngle : false,
		onLoad : function() { return false; },
		onBeforeOpen : function( pileName ) { return false; },
		onAfterOpen : function( pileName, totalItems ) { return false; },
		onBeforeClose : function( pileName ) { return false; },
		onAfterClose : function( pileName, totalItems ) { return false; }
	};

	$.Stapel.prototype = {

		_init : function( options ) {
			
			// options
			this.options = $.extend( true, {}, $.Stapel.defaults, options );

			// cache some elements
			this._config();
			
			// preload images
			var self = this;
			this.el.imagesLoaded( function() {
				self.options.onLoad();
				self._layout();
				self._initEvents();
			} );

		},
		_config : function() {

			// css transitions support
			this.support = Modernizr.csstransitions;

			var transProperties = {
				'WebkitTransition' : { transitionEndEvent : 'webkitTransitionEnd', tranformName : '-webkit-transform', transition : '-webkit-transition' },
				'MozTransition' : { transitionEndEvent : 'transitionend', tranformName : '-moz-transform', transition : '-moz-transition' },
				'OTransition' : { transitionEndEvent : 'oTransitionEnd', tranformName : '-o-transform', transition : '-o-transition' },
				'msTransition' : { transitionEndEvent : 'MSTransitionEnd', tranformName : '-ms-transform', transition : '-ms-transition' },
				'transition' : { transitionEndEvent : 'transitionend', tranformName : 'transform', transition : 'transition' }
			};

			if( this.support ) {

				this.transEndEventName = transProperties[ Modernizr.prefixed( 'transition' ) ].transitionEndEvent + '.stapel';
				this.transformName = transProperties[ Modernizr.prefixed( 'transition' ) ].tranformName;
				this.transitionName = transProperties[ Modernizr.prefixed( 'transition' ) ].transition;

			}

			// true if one pile is opened
			this.spread = false;

			// the li's
			this.items = this.el.children( 'li' ).hide();
			
			// close pile
			this.close = $( '#tp-close' );

		},
		_getSize : function() {

			this.elWidth = this.el.outerWidth( true );

		},
		_initEvents : function() {

			var self = this;
			$window.on( 'debouncedresize.stapel', function() { self._resize(); } );
			this.items.on( 'click.stapel', function() {
				
				var $item = $( this );

				if( !self.spread && $item.data( 'isPile' ) ) {

					self.spread = true;
					self.pileName = $item.data( 'pileName' );
					self.options.onBeforeOpen( self.pileName );
					self._openPile();
					
					return false;

				}

			} );

		},
		_layout : function() {

			/*
			piles() : save the items info in a object with the following structure:

			this.piles = {
				
				pileName : {
					
					// elements of this pile (note that an element can be also in a different pile)
					// for each element, the finalPosition is the position of the element when the pile is opened
					elements : [
						{ el : HTMLELEMENT, finalPosition : { left : LEFT, top : TOP } },
						{},
						{},
						...
					],
					// this is the position of the pile (all elements of the pile) when the pile is closed
					position : { left : LEFT, top : TOP },
					index : INDEX
				},

				// more piles
				...

			}
			*/
			this._piles();

			// items width & height
			// assuming here that all items have the same width and height
			this.itemSize = { width : this.items.outerWidth( true ) , height : this.items.outerHeight( true ) };

			// remove original elements
			this.items.remove();

			// applies some initial style for the items
			this._setInitialStyle();

			this.el.css( 'min-width', this.itemSize.width + this.options.gutter );

			// gets the current ul size (needed for the calculation of each item's position)
			this._getSize();

			// calculate and set each Pile's elements position based on the current ul width
			// this function will also be called on window resize
			this._setItemsPosition();
			
			// new items
			this.items = this.el.children( 'li' ).show();
			// total items
			this.itemsCount	= this.items.length;

		},
		_piles : function() {

			this.piles = {};
			var pile, self = this, idx = 0;
			this.items.each( function() {
					
				var $item = $( this ),
					itemPile = $item.attr( 'data-pile' ) || 'nopile-' + $item.index(),
					attr = itemPile.split( ',' );

				for( var i = 0, total = attr.length; i < total; ++i ) {
					
					var pileName = $.trim( attr[i] );
					pile = self.piles[ pileName ];

					if( !pile ) {

						pile = self.piles[ pileName ] = {
							elements : [],
							position : { left : 0, top : 0 },
							index : idx
						};

						++idx;
				
					}
					
					var clone = $item.clone().get(0);
					pile.elements.push( { el : clone, finalPosition : { left : 0, top : 0 } } );
					$( clone ).appendTo( self.el );
				
				}
			
			} );

		},
		_setInitialStyle : function() {

			for( var pile in this.piles ) {

				var p = this.piles[pile];

				for( var i = 0, len = p.elements.length; i < len; ++i ) {

					var $el = $( p.elements[i].el ), styleCSS = {};
					
					styleCSS[this.transformName] = 'rotate(0deg)';

					this._applyInitialTransition( $el );
						
					if( i === len - 2 ) {
						styleCSS[this.transformName] = 'rotate(' + this.options.pileAngles + 'deg)';
					}
					else if( i === len - 3 ) {
						styleCSS[this.transformName] = 'rotate(-' + this.options.pileAngles + 'deg)';
					}
					else if( i !== len - 1 ) {
						var extraStyle = { visibility : 'hidden' };
						$el.css( extraStyle ).data( 'extraStyle', extraStyle );
					}
					else if( pile.substr( 0, 6 ) !== 'nopile' ) {
						$el.data( 'front', true ).append( '<div class="tp-title"><span>' + pile + '</span><span>' + len + '</span></div>' );
					}

					$el.css( styleCSS ).data( {
						initialStyle : styleCSS,
						pileName : pile,
						pileCount : len,
						shadow : $el.css( 'box-shadow' ),
						isPile : pile.substr( 0, 6 ) === 'nopile' ? false : true
					} );

				}

			}

		},
		_applyInitialTransition : function( $el ) {

			if( this.support ) {
				$el.css( this.transitionName, 'left 400ms ease-in-out, top 400ms ease-in-out' );
			}	

		},
		_setItemsPosition : function() {

			var accumL = 0, accumT = 0, 
				l, t, ml = 0,
				lastItemTop = 0;

			for( var pile in this.piles ) {

				var p = this.piles[pile],
					stepW = this.itemSize.width + this.options.gutter,

					accumIL = 0, accumIT = 0, il, it;

				if( accumL + stepW <= this.elWidth ) {

					l = accumL;
					t = accumT;
					accumL += stepW;

				}
				else {

					if( ml === 0 ) {
						ml = Math.ceil( ( this.elWidth - accumL + this.options.gutter ) / 2 );
					}

					accumT += this.itemSize.height + this.options.gutter;
					l = 0;
					t = accumT;
					accumL = stepW;

				}

				p.position.left = l;
				p.position.top = t;

				for( var i = 0, len = p.elements.length; i < len; ++i ) {

					var elem = p.elements[i],
						fp = elem.finalPosition;

					if( accumIL + stepW <= this.elWidth ) {

						il = accumIL;
						it = accumIT;
						accumIL += stepW;

					}
					else {

						accumIT += this.itemSize.height + this.options.gutter;
						il = 0;
						it = accumIT;
						accumIL = stepW;

					}

					fp.left = il;
					fp.top = it;

					var $el = $( elem.el );

					if( pile !== this.pileName ) {
						
						$el.css( { left : p.position.left, top : p.position.top } );

					}
					else {

						lastItemTop = elem.finalPosition.top;
						$el.css( { left : elem.finalPosition.left, top : lastItemTop } );

					}

				}

			}

			// the position of the items will influence the final margin left value and height for the ul
			// center the ul
			lastItemTop = this.spread ? lastItemTop : accumT;
			this.el.css( {
				marginLeft : ml,
				height : lastItemTop + this.itemSize.height
			} );

		},
		_openPile : function() {

			if( !this.spread ) {
				return false;
			}

			// final style
			var fs;
			for( var pile in this.piles ) {

				var p = this.piles[ pile ], cnt = 0;
				
				for( var i = 0, len = p.elements.length; i < len; ++i ) {

					var elem = p.elements[i],
						$item = $( elem.el ),
						$img = $item.find( 'img' ),
						styleCSS = pile === this.pileName ? {
							zIndex : 999,
							visibility : 'visible'
						} : {
							zIndex : 1
						};

					styleCSS[this.transitionName] = pile === this.pileName ?
						this.support ? 'left ' + this.options.pileAnimation.openSpeed + 'ms ' + ( ( len - i - 1 ) * this.options.delay ) + 'ms ' + this.options.pileAnimation.openEasing + ', top ' + this.options.pileAnimation.openSpeed + 'ms ' + ( ( len - i - 1 ) * this.options.delay ) + 'ms ' + this.options.pileAnimation.openEasing + ', ' + this.transformName + ' ' + this.options.pileAnimation.openSpeed + 'ms ' + ( ( len - i - 1 ) * this.options.delay ) + 'ms ' + this.options.pileAnimation.openEasing : 'none' :
						this.support ? 'opacity ' + this.options.otherPileAnimation.closeSpeed + 'ms ' + this.options.otherPileAnimation.closeEasing : 'none';


					if( pile === this.pileName ) {

						if( $item.data( 'front' ) ) {
							$item.find( 'div.tp-title' ).hide();
						}

						if( i < len - 1  ) {
							$img.css( 'visibility', 'visible' );
						}
						
						fs = elem.finalPosition;
						fs[this.transformName] = this.options.randomAngle && i !== p.index ? 'rotate(' + Math.floor( Math.random() * ( 5 + 5 + 1 ) - 5 ) + 'deg)' : 'none';

						//undefined?!?
						/*
						if( !this.support ) {
							$item.css( this.transformName, 'none' );
						}
						*/

						// hack: remove box-shadow while animating to prevent the shadow stack effect
						if( i < len - 3 ) {
							$item.css( 'box-shadow', 'none' );
						}

					}
					else if( i < len - 1  ) {
						$img.css( 'visibility', 'hidden' );
					}

					$item.css( styleCSS );

					var self = this;

					pile === this.pileName ?
						this._applyTransition( $item, fs, this.options.pileAnimation.openSpeed, function( evt ) {

							var target = this.target || this.nodeName;
							if( target !== 'LI' ) {
								return;
							}

							var $el = $( this );

							// hack: remove box-shadow while animating to prevent the shadow stack effect
							$el.css( 'box-shadow', $el.data( 'shadow' ) );

							if( self.support ) {
								$el.off( self.transEndEventName );
							}

							++cnt;
							
							if( cnt === $el.data( 'pileCount' ) ) {

								$( document ).one( 'mousemove.stapel', function() {
									self.el.addClass( 'tp-open' );
								} );
								self.options.onAfterOpen( self.pileName, cnt );

							}

						} ) :
						this._applyTransition( $item, { opacity : 0 }, this.options.otherPileAnimation.closeSpeed );

				}

			}

			this.el.css( 'height', fs.top + this.itemSize.height );	

		},
		_closePile : function() {

			var self = this;

			// close..
			if( this.spread ) {

				this.spread = false;

				this.options.onBeforeClose( this.pileName );

				this.el.removeClass( 'tp-open' );

				// final style
				var fs;
				for( var pile in this.piles ) {

					var p = this.piles[ pile ], cnt = 0;
					
					for( var i = 0, len = p.elements.length; i < len; ++i ) {

						var $item = $( p.elements[i].el ),
							styleCSS = {};

						styleCSS[this.transitionName] = pile === this.pileName ?
							this.support ? 'left ' + this.options.pileAnimation.closeSpeed + 'ms ' + this.options.pileAnimation.closeEasing + ', top ' + this.options.pileAnimation.closeSpeed + 'ms ' + this.options.pileAnimation.closeEasing + ', ' + this.transformName + ' ' + this.options.pileAnimation.closeSpeed + 'ms ' + this.options.pileAnimation.closeEasing : 'none' :
							this.support ? 'opacity ' + this.options.otherPileAnimation.openSpeed + 'ms ' + this.options.otherPileAnimation.openEasing : 'none';

						$item.css( styleCSS );
						
						fs = p.position;

						if( pile === this.pileName ) {

							$.extend( fs, $item.data( 'initialStyle' ) );

							// hack: remove box-shadow while animating to prevent the shadow stack effect
							if( i < len - 3 ) {
								$item.css( 'box-shadow', 'none' );
							}

						}

						pile === this.pileName ? this._applyTransition( $item, fs, this.options.pileAnimation.closeSpeed, function( evt ) {

							var target = this.target || this.nodeName;
							if( target !== 'LI' ) {
								return;
							}

							var $el = $( this ), extraStyle = $el.data( 'extraStyle' );

							// hack: remove box-shadow while animating to prevent the shadow stack effect
							$el.css( 'box-shadow', $el.data( 'shadow' ) );

							if( self.support ) {
								$el.off( self.transEndEventName );
								self._applyInitialTransition( $el );
							}
							else {
								$el.css( $el.data( 'initialStyle' ) );
							}

							if( extraStyle ) {
								$el.css( extraStyle );
							}

							++cnt;

							if( $el.data( 'front' ) ) {
								$el.find( 'div.tp-title' ).show();
							}

							if( cnt === $el.data( 'pileCount' ) ) {
								self.options.onAfterClose( $el.data( 'pileName' ), cnt );
							}

						} ) : this._applyTransition( $item, { opacity : 1 }, this.options.otherPileAnimation.openSpeed, function( evt ) {

							var target = this.target || this.nodeName;
							if( target !== 'LI' ) {
								return;
							}

							var $el = $( this );

							if( $el.index() < len - 1  ) {
								$el.find( 'img' ).css( 'visibility', 'visible' );
							}

							if( self.support ) {
								$el.off( self.transEndEventName );
								self._applyInitialTransition( $el );
							}

						} );

					}

				}

				// reset pile name
				this.pileName = '';

				// update ul height
				this.el.css( 'height', fs.top + this.itemSize.height );

			}
			
			return false;

		},
		_resize : function() {

			// get ul size again
			this._getSize();
			// reset items positions
			this._setItemsPosition();

		},
		_applyTransition : function( el, styleCSS, speed, fncomplete ) {

			$.fn.applyStyle = this.support ? $.fn.css : $.fn.animate;

			if( fncomplete && this.support ) {

				el.on( this.transEndEventName, fncomplete );

			}

			fncomplete = fncomplete || function() { return false; };

			el.stop().applyStyle( styleCSS, $.extend( true, [], { duration : speed + 'ms', complete : fncomplete } ) );

		},
		closePile : function() {

			this._closePile();

		}

	};
	
	var logError = function( message ) {

		if ( window.console ) {

			window.console.error( message );
		
		}

	};
	
	$.fn.stapel = function( options ) {

		var instance = $.data( this, 'stapel' );
		
		if ( typeof options === 'string' ) {
			
			var args = Array.prototype.slice.call( arguments, 1 );
			
			this.each(function() {
			
				if ( !instance ) {

					logError( "cannot call methods on stapel prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				
				}
				
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

					logError( "no such method '" + options + "' for stapel instance" );
					return;
				
				}
				
				instance[ options ].apply( instance, args );
			
			});
		
		} 
		else {
		
			this.each(function() {
				
				if ( instance ) {

					instance._init();
				
				}
				else {

					instance = $.data( this, 'stapel', new $.Stapel( options, this ) );
				
				}

			});
		
		}
		
		return instance;
		
	};
	
} )( jQuery, window );
