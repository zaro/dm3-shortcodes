/**
 * Content box.
 *
 * @param {Object} options
 * @return {Object}
 */
function dm3ContentBox(options) {
	'use strict';
	
	// Defaults.
	options = jQuery.extend({
		title: null,
		content: null,
		width: null,
		height: null,
		onClose: null
	}, options);

	// Create box html.
	var box = jQuery('<div class="dm3-content-box"><div class="dm3-content-box-inner"></div></div>');
	var box_inner = box.find('.dm3-content-box-inner:first');

	if (options.title) {
		var title = jQuery('<div class="dm3-content-box-title">' + options.title + '</div>');
		box.prepend(title);
	}

	// Add close button.
	var close = jQuery('<a class="dm3-content-box-close" href="#"></a>').appendTo(box);
	close.on('click', function() {
		box.remove();
		jQuery('#dm3-content-box-overlay').remove();
		
		if (typeof options.onClose === 'function') {
			options.onClose();
		}

		box = null;
		options = null;
	});

	// Add content and append the box to the document body.
	box.find('.dm3-content-box-inner:first').append(options.content);
	box.appendTo('body');
	
	// Box dimensions.
	if (options.width && options.height) {
		box.css({
			width: options.width + 'px',
			height: options.height + 'px'
		});
	}

	var width = box.width();
	var height = box.height();

	// Show the box.
	jQuery('body').append('<div id="dm3-content-box-overlay"></div>');
	
	box_inner.css({
		width: width + 'px',
		height: (height - title.outerHeight(true)) + 'px'
	});

	box.css({
		marginLeft: '-' + (width / 2) + 'px',
		marginTop: '-' + (height / 2) + 'px',
		visibility: 'visible'
	});

	// Return box jQuery element.
	return box;
}