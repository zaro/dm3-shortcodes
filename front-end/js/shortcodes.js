/**
 * dm3Tabs jQuery Plugin
 * version 2.0
 */
(function($) {

	'use strict';

	/**
	 * Constructor
	 *
	 * @param {object} el
	 * @param {object} options
	 */
	function Dm3Tabs( el, options ) {
		this.speed = options.speed;
		this.animating = false;
		this.container = $(el);
		this.wrapper = this.container.parent();
		this.tabsContainers = this.container.children('.dm3-tab');
		this.tabsNav = null;
		this.type = 'horizontal';
		this.afterTabChange = options.afterTabChange;
		this.autoscroll = options.autoscroll;
		this.ascTimeout = null;

		this.preloadImages(10);
	}

	/**
	 * Initialize.
	 */
	Dm3Tabs.prototype.init = function() {
		// Horizontal or vertical.
		if (this.wrapper.hasClass('dm3-tabs-vertical')) {
			this.type = 'vertical';
		}

		// Setup navigation.
		this.setupNav();

		// Just one tab.
		if (this.tabsNav.length < 2) {
			this.wrapper.addClass('dm3-tabs-single');
			return;
		}

		// Setup autoscroll.
		this.setupAutoscroll();

		var that = this;

		if (this.type === 'vertical') {
			var tabsNavHeight = this.tabsNav.eq(0).parent().height();
			var containerBorderWidth = parseInt(this.container.css('borderWidth'), 10);
			this.container.css('min-height', (tabsNavHeight - (containerBorderWidth * 2)) + 'px');
		}

		this.tabsContainers.each(function(i) {
			var tab = $(this);
			var tabCSS = {
				position: 'absolute',
				left: 0,
				width: '100%'
			};

			if (i !== that.getCurrentTab()) {
				tabCSS.display = 'none';
				tabCSS.opacity = 0;
			} else {
				tabCSS.display = 'block';
				tabCSS.opacity = 1;
			}

			tab.css(tabCSS);
		});

		var containerHeight = this.tabsContainers.eq(this.getCurrentTab()).outerHeight(true);
		this.container.css({height: containerHeight + 'px'});

		$(window).resize(function() {
			if (that.animating) {
				return;
			}

			that.container.css({
				height: that.tabsContainers.eq(that.getCurrentTab()).outerHeight(true) + 'px'
			});
		});	
	};

	/**
	 * Preload images for proper height calculation.
	 *
	 * @param {number} numTries
	 */
	Dm3Tabs.prototype.preloadImages = function(numTries) {
		var loaded = false,
			images = this.container.find('img'),
			that,
			img;

		if (images.length) {
			for (var i = 0; i < images.length; ++i) {
				img = images.eq(i).get(0);

				if (img.complete || img.readyState === 4 || img.readyState === 'complete') {
					loaded = true;
					break;
				}
			}
		} else {
			loaded = true;
		}

		if (loaded || numTries <= 0 ) {
			this.init();
		} else {
			that = this;

			setTimeout(function() {
				that.preloadImages(--numTries);
			}, 300);
		}
	};

	/**
	 * Get the current tab index.
	 *
	 * @return {number}
	 */
	Dm3Tabs.prototype.getCurrentTab = function() {
		return this.tabsNav.filter('.active').index();
	};

	/**
	 * Get the next tab index.
	 *
	 * @return {number}
	 */
	Dm3Tabs.prototype.getNextTab = function() {
		var next = this.getCurrentTab() + 1;

		if (next >= this.tabsContainers.length) {
			next = 0;
		}

		return next;
	};

	/**
	 * Setup navigation.
	 */
	Dm3Tabs.prototype.setupNav = function() {
		var that = this;
		var activeItem;

		if (this.container.data('navid')) {
			this.tabsNav = $('#' + this.container.data('navid')).children('li');
		} else {
			this.tabsNav = this.wrapper.find('> ul > li');
		}

		activeItem = this.tabsNav.filter('.active');

		if (!activeItem.length) {
			this.tabsNav.eq(0).addClass('active');
		}

		this.tabsNav.find('a').on( 'click', function(e) {
			e.preventDefault();
			that.changeTab($(this).parent().index());
		});
	};

	/**
	 * Setup autoscroll.
	 */
	Dm3Tabs.prototype.setupAutoscroll = function() {
		var that = this;
		var autoscroll = parseInt(this.wrapper.data('autoscroll'), 10);

		if (!isNaN(autoscroll)) this.autoscroll = autoscroll;

		if (this.autoscroll) {
			this.wrapper.hover(function() {
				clearTimeout(that.ascTimeout);
			}, function() {
				if (that.autoscroll) that.startAutoscroll();
			});

			that.startAutoscroll();
		}
	};

	/**
	 * Start autoscroll.
	 */
	Dm3Tabs.prototype.startAutoscroll = function() {
		var that = this;

		if ( this.ascTimeout ) {
			clearTimeout(this.ascTimeout);
			this.ascTimeout = null;
		}

		this.ascTimeout = setTimeout(function() {
			that.changeTab(that.getNextTab());
		}, this.autoscroll * 1000);
	};

	/**
	 * Change tab.
	 */
	Dm3Tabs.prototype.changeTab = function(idx) {
		if (this.animating || idx === this.getCurrentTab()) {
			return;
		}

		this.animating = true;

		var nextTab = this.tabsContainers.eq(idx);
		var currentTab = this.tabsContainers.eq(this.getCurrentTab());
		var that = this;
		var containerHeight = nextTab.outerHeight(true);

		// Update navigation.
		this.tabsNav.filter('.active').removeClass('active');
		this.tabsNav.eq(idx).addClass('active');

		// Hide current tab.
		currentTab.stop().animate({opacity: 0}, {duration: this.speed, complete: function() {
			$(this).css({display: 'none'});
		}});

		// Show next tab.
		nextTab.stop().css('display', 'block').animate({opacity: 1}, {duration: this.speed, complete: function() {
			if (that.afterTabChange) {
				that.afterTabChange(that.tabsContainers.eq(that.getCurrentTab()));
			}
		}});

		this.container.stop().animate({height: containerHeight + 'px'}, {duration: this.speed, complete: function() {
			that.animating = false;

			// Autoscroll.
			if (that.autoscroll) that.startAutoscroll();
		}});
	};

	$.fn.dm3Tabs = function(options) {
		options = $.extend({
			speed: 300,
			afterTabChange: null,
			autoscroll: 0 // in seconds
		}, options);

		return this.each(function() {
			var dm3Tabs = new Dm3Tabs( this, options );
		});
	};

}(jQuery));

/**
 * dm3Collapse
 * version 1.0
 */
(function($) {

	'use strict';

	/**
	 * Constructor.
	 */
	function Dm3Collapse(el, options) {
		var that = this;

		this.el = $(el);
		this.options = options;
		this.container = this.el.parent();
		this.transitioning = false;

		this.el.parent().find('.dm3-collapse-trigger > a').on('click', function(e) {
			e.preventDefault();
			if (that.el.hasClass('dm3-in')) {
				that.hide();
			} else {
				that.show();
			}
		});

		var container = this.el.parent();

		if (this.el.hasClass('dm3-in') && !container.hasClass('dm3-collapse-open')) {
			container.addClass('dm3-collapse-open');
			this.el.removeClass('dm3-collapse');
			this.el.height(this.el.find('> .dm3-collapse-inner').outerHeight());

			setTimeout(function() {
				that.el.addClass('dm3-collapse');
			}, 0);
		}
	}

	/**
	 * Check if browser supports transition end event.
	 *
	 * @return {string}
	 */
	Dm3Collapse.prototype.transitionEnd = function() {
		var el = document.createElement('dm3collapse');
		var transition_end = null;
		var trans_event_names = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd otransitionend',
			'transition': 'transitionend'
		};
		var name;

		for (name in trans_event_names) {
			if (el.style[name] !== undefined) {
				transition_end = trans_event_names[name];
				break;
			}
		}

		return transition_end;
	}();

	/**
	 * Get collapse siblings (for accordion feature).
	 *
	 * @return jQuery
	 */
	Dm3Collapse.prototype.getActives = function() {
		var actives = null;
		var parent = this.container.parent();

		if (parent.length && parent.hasClass('dm3-accordion')) {
			actives = parent.find('> .dm3-collapse-item > .dm3-in');
		}

		return actives;
	};

	/**
	 * Reset the height of the collapse element.
	 *
	 * @param {number} height
	 */
	Dm3Collapse.prototype.reset = function(height) {
		height = (height === null) ? 'auto' : height;
		this.el.removeClass('dm3-collapse');
		this.el.height(height)[0].innerWidth;
		this.el.addClass('dm3-collapse');
	};

	/**
	 * Expand collapsed element.
	 */
	Dm3Collapse.prototype.show = function() {
		if (this.transitioning) {
			return;
		}

		var that = this;
		var actives = this.getActives();
		var actives_data;

		if (actives) {
			actives_data = actives.data('dm3Collapse');
			if (actives_data && actives_data.transitioning) { return; }
			actives.dm3Collapse('hide');
		}

		this.transitioning = true;
		this.el.parent().addClass('dm3-collapse-open');

		var height = this.el.find('> .dm3-collapse-inner').outerHeight();
		var complete = function() {
			that.reset();
			that.transitioning = false;
		};

		this.el.addClass('dm3-in');
		this.el.height(0);

		if (this.transitionEnd) {
			this.el.one(this.transitionEnd, complete);
		} else {
			complete();
		}

		this.el.height(height);
	};

	/**
	 * Collapse the visible element.
	 */
	Dm3Collapse.prototype.hide = function() {
		if (this.transitioning) {
			return;
		}

		this.transitioning = true;

		this.el.parent().removeClass('dm3-collapse-open');
		
		var that = this;
		var height = this.el.find('> .dm3-collapse-inner').outerHeight();
		var complete = function() {
			that.transitioning = false;
		};
		
		this.reset(height);
		this.el.removeClass('dm3-in');
		
		if (this.transitionEnd) {
			this.el.one(this.transitionEnd, complete);
		} else {
			complete();
		}
		
		this.el.height(0);
	};

	/**
	 * jQuery plugin
	 */
	$.fn.dm3Collapse = function(input) {
		var options = $.extend({
		}, typeof input === 'object' && input);

		return this.each(function() {
			var $this = $(this);
			var dm3_collapse = $this.data('dm3Collapse');

			if (!dm3_collapse) {
				$this.data('dm3Collapse', (dm3_collapse = new Dm3Collapse(this, options)));
			}

			if (typeof input === 'string' && typeof dm3_collapse[input] === 'function') {
				dm3_collapse[input]();
			}
		});
	};

}(jQuery));

/**
 * Initialize shortcodes
 */
var dm3_shortcodes_init = (function($) {
	'use strict';

	var dm3GoogleMap = function(el) {
		var map = $(el);

		map.css({
			height: map.data('height') + 'px'
		});

		var latLng = new google.maps.LatLng(map.data('latitude'), map.data('longitude'));
		var google_map = new google.maps.Map(map.get(0), {
			zoom: parseInt(map.data('zoom'), 10),
			scrollwheel: false,
			mapTypeControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			navigationControl: true,
			navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
			center: latLng
		});

		new google.maps.Marker({
			position: latLng,
			map: google_map
		});
	};

	return function(context) {
		if (context == undefined) {
			context = null;
		}

		// Tabs.
		$('.dm3-tabs', context).dm3Tabs();

		// Collapse / Accordion.
		$('.dm3-collapse', context).dm3Collapse();

		// Alert boxes.
		$('.dm3-alert', context).each(function() {
			var div_alert = $(this);
			var btn_close = $('<a class="dm3-alert-close" href="#">&times;</a>');
			btn_close.on('click', function(e) {
				e.preventDefault();
				$(this).parent().hide();
			});
			div_alert.append(btn_close);
		});

		// Google maps.
		$('.dm3-google-map').each(function() {
			dm3GoogleMap(this);
		});
	};
}(jQuery));

/**
 * Run plugins
 */
(function($) {
	'use strict';

	$(document).ready(function() {
		dm3_shortcodes_init();
	});
}(jQuery));