/**
 * Dm3JsForm.
 * @version 1.2.1
 * Dynamically generates HTML forms.
 */
(function($) {
	
	'use strict';
	
	/**
	 * Constructor.
	 *
	 * @param {Object} options
	 */
	function Dm3JsForm(options) {
		this.el = $('<div></div>');
		this.fields = {};
		this.uploader = null;
		this.uploaderInput = null;
		this.options = $.extend({
			rowClass: 'js-settings-field',
			rowActionClass: 'js-settings-action',
			rowBoxesClass: 'js-settings-boxes',
			fieldClass: 'js-settings-control',
			boxClass: 'js-settings-box',
			boxActiveClass: 'js-settings-box-active',
			boxesContainerClass: 'js-settings-boxes'
		}, options);
	}
	
	/**
	 * Add text input.
	 * 
	 * @param {Object} opt
	 */
	Dm3JsForm.prototype.addTextInput = function(opt) {
		opt = $.extend({
			name: '',
			label: '',
			value: '',
			description: null
		}, opt);
		
		var field = $('<div class="' + this.options.rowClass + '"></div>');
		var input = $('<input type="text" name="' + opt.name + '">');

		if (opt.label) {
			field.append('<label>' + opt.label + '</label>');
		}
		
		if (opt.value) {
			input.val(opt.value);
		}
		
		field.append($('<div class="' + this.options.fieldClass + '"></div>').append(input));

		if (opt.description) {
			field.append('<div class="description">' + opt.description + '</div>');
		}

		this.el.append(field);
		
		this.fields[opt.name] = {
			type: 'text',
			options: opt,
			field: input
		};
	};
	
	/**
	 * Add textarea.
	 * 
	 * @param {Object} opt
	 */
	Dm3JsForm.prototype.addTextArea = function(opt) {
		opt = $.extend({
			name: '',
			label: '',
			value: '',
			rows: null,
			cols: null
		}, opt);
		
		var field = $('<div class="' + this.options.rowClass + '"></div>');
		var textarea = $('<textarea name="' + opt.name + '" />');

		if (opt.rows) {
			textarea.attr('rows', opt.rows);
		}

		if (opt.cols) {
			textarea.attr('cols', opt.cols);
		}
		
		if (opt.label) {
			field.append('<label>' + opt.label + '</label>');
		}
		
		if (opt.value) {
			textarea.val(opt.value);
		}
		
		field.append($('<div class="' + this.options.fieldClass + '"></div>').append(textarea));
		this.el.append(field);
		
		this.fields[opt.name] = {
			type: 'textarea',
			options: opt,
			field: textarea
		};
	};
	
	/**
	 * Add select field.
	 * 
	 * @param {Object} opt
	 */
	Dm3JsForm.prototype.addSelect = function(opt) {
		opt = $.extend({
			name: '',
			label: '',
			multiple: false,
			options: [],
			description: ''
		}, opt);
		
		var field = $('<div class="' + this.options.rowClass + '"></div>');
		var select = $('<select name="' + opt.name + '"></select>');
		var option;
		var i;
		
		for (i = 0; i < opt.options.length; i++) {
			option = $('<option value="' + opt.options[i].value + '">' + opt.options[i].label + '</option>');
			
			if (opt.options[i].selected) {
				option.attr('selected', 'selected');
			}
			
			select.append(option);
		}
		
		if (opt.label) {
			field.append('<label>' + opt.label + '</label>');
		}
		
		if (opt.multiple) {
			select.attr('multiple', 'multiple');
		}
		
		field.append($('<div class="' + this.options.fieldClass + '"></div>').append(select));

		if ( opt.description ) {
			field.append($('<div class="description">' + opt.description + '</div>'));
		}

		this.el.append(field);
		
		this.fields[opt.name] = {
			type: 'select',
			options: opt,
			field: select
		};
	};

	/**
	 * Add options popup.
	 * Needs custom styling; use "rowClass" option.
	 *
	 * @param {Object} opt
	 */
	Dm3JsForm.prototype.addOptionsPopup = function(opt) {
		opt = $.extend({
			name: '',
			label: '',
			options: [],
			rowClass: '',
			icons: false,
			iconClass: 'fa fa-'
		}, opt);

		var row_class = opt.rowClass.length ? ' ' + opt.rowClass : '';
		var row = $('<div class="' + this.options.rowClass + row_class + '"></div>');
		var field = $('<input type="hidden" name="' + opt.name + '" />');
		var value = $('<div class="value"></div>');
		var options_list = $('<ul></ul>').css('display', 'none');

		field.on('dm3jsformchange', function() {
			value.html(options_list.find('> li > a[data-value="' + field.val() + '"]').html());
		});

		value.on('click', function(e) {
			if (options_list.is(':hidden')) {
				options_list.css('display', 'block');
			} else {
				options_list.css('display', 'none');
			}
		});
		
		for (var i = 0; i < opt.options.length; i++) {
			if (opt.icons) {
				options_list.append('<li><a href="#" data-value="' + opt.options[i] + '"><span class="' + opt.iconClass + opt.options[i] + '"></span></a></li>');
			} else {
				options_list.append('<li><a href="#" data-value="' + opt.options[i].value + '">' + opt.options[i].label + '</a></li>');
			}
		}

		options_list.on('click', 'a', function(e) {
			var option = $(this);
			value.html(option.html());
			field.val(option.data('value'));
			options_list.css('display', 'none');
			e.preventDefault();
		});

		if (opt.label) {
			row.append('<label>' + opt.label + '</label>');
		}

		row.append(field);
		row.append($('<div class="' + this.options.fieldClass + '"></div>').append(value));
		row.find('.' + this.options.fieldClass).append(options_list);
		this.el.append(row);

		this.fields[opt.name] = {
			type: 'optionspopup',
			name: opt.name,
			options: opt,
			field: field
		};
	};

	/**
	 * Display WordPress media uploader.
	 */
	Dm3JsForm.prototype.wpUploader = function() {
		var that = this;

		if (!this.uploader) {
			if (wp.media.frames.inbShortcodes !== undefined) {
				this.uploader = wp.media.frames.inbShortcodes;
			} else {
				this.uploader = wp.media.frames.inbShortcodes = wp.media({
					frame: 'post',
					state: 'insert',
					multiple: false
				});
			}

			this.uploader.off('insert');
			this.uploader.on('insert', function() {
				var json = that.uploader.state().get('selection').first().toJSON();
				that.uploaderInput.val(json.url);
			});
		}

		this.uploader.open();
	};

	/**
	 * Add image field.
	 * Uses WordPress media uploader.
	 *
	 * @param {Object} opt
	 */
	Dm3JsForm.prototype.addImage = function(opt) {
		opt = $.extend({
			name: '',
			label: '',
			value: ''
		}, opt);
		
		var field = $('<div class="' + this.options.rowClass + '"></div>');
		var input = $('<input type="text" name="' + opt.name + '">');

		if (opt.label) {
			field.append('<label>' + opt.label + '</label>');
		}
		
		if (opt.value) {
			input.val(opt.value);
		}
		
		var button = $('<button class="button">+</button>');
		var that = this;

		button.on('click', function(e) {
			e.preventDefault();
			that.uploaderInput = $(this).prev('input');
			that.wpUploader();
		});

		field.append($('<div class="' + this.options.fieldClass + '"></div>').append(input).append(button));
		this.el.append(field);
		
		this.fields[opt.name] = {
			type: 'image',
			options: opt,
			field: input
		};
	};
	
	/**
	 * Add button.
	 * 
	 * @param {object} opt
	 */
	Dm3JsForm.prototype.addButton = function(opt) {
		opt = $.extend({
			label: '',
			class: '',
			callback: null
		}, opt);
		
		var field = $('<div class="' + this.options.rowActionClass + '"></div>');
		var button = $('<button>' + opt.label + '</button>');
		
		if (opt.class) {
			button.addClass(opt.class);
		}

		button.on('click', function(e) {
			if (typeof opt.callback === 'function') {
				opt.callback.call(button, e);
			}
		});
		
		field.append(button);
		this.el.append(field);
	};
	
	/**
	 * Serialize.
	 * 
	 * @return {Object}
	 */
	Dm3JsForm.prototype.serialize = function() {
		var data = {};
		var prop;
		
		for (prop in this.fields) {
			if (this.fields.hasOwnProperty(prop)) {
				data[prop] = this.fields[prop].field.val();
			}
		}
		
		return data;
	};
	
	/**
	 * Get form html element.
	 * 
	 * @return {Object}
	 */
	Dm3JsForm.prototype.getForm = function() {
		return this.el;
	};

	Dm3JsForm.prototype.destroy = function() {
		this.fields = null;
		
		if (this.uploader) {
			this.uploader.off('insert')
			this.uploader = null;
		}

		this.uploaderInput = null;
		this.el.remove();
		this.el = null;
		this.options = null;
	};

	/**
	 * Instantiate the Dm3JsForm object and return it
	 *
	 * @param {String} options
	 * @return {Object}
	 */
	window.getDm3JsForm = function(options) {
		return new Dm3JsForm(options);
	}
	
})(jQuery);