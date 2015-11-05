/**
 * TinyMCE plugin to output shortcodes and shortcode options.
 * Adds the shortcodes list to the editor's menu.
 *
 * @version 1.2
 */
(function($) {

	'use strict';

	var formOptions = {
		rowClass: 'dm3sc-form-element',
		rowActionClass: 'dm3sc-form-action',
		rowBoxesClass: 'dm3sc-form-boxes',
		fieldClass: 'dm3sc-form-field',
		boxClass: 'dm3sc-settings-box',
		boxActiveClass: 'dm3sc-settings-box-active',
		boxesContainerClass: 'dm3sc-settings-boxes dm3sc-form-field'
	};

	function INBShortcodeOptions(shortcode) {
		this.shortcode = $.extend({
			max: 15
		}, shortcode);
		this.forms = [];
		this.contentBox = null;
	}

	INBShortcodeOptions.prototype.display = function() {
		if (this.shortcode.child_shortcode) {
			this.displayMultiple();
		} else {
			this.displaySimple();
		}
	};

	INBShortcodeOptions.prototype.getForm = function(type) {
		var form = getDm3JsForm(formOptions);
		var options = (type === 'parent') ? this.shortcode.options : this.shortcode.child_shortcode.options;
		var option;

		// Add options to the form.
		for (option in options) {
			if (options.hasOwnProperty(option)) {
				this.addOptionToForm(option, options[option], form);
			}
		}

		return form;
	};

	/**
	 * Add option to form.
	 *
	 * @param {String} name
	 * @param {String} option
	 * @param {Dm3JsForm} form
	 */
	INBShortcodeOptions.prototype.addOptionToForm = function(name, option, form) {
		switch(option.type) {
			case 'text':
				form.addTextInput({
					name: name,
					label: option.label,
					description: option.description || null
				});
				break;

			case 'textarea':
				form.addTextArea({
					name: name,
					label: option.label,
					rows: 3
				});
				break;

			case 'select':
				form.addSelect({
					name: name,
					label: option.label,
					multiple: false,
					options: option.options
				});
				break;

			case 'optionspopup':
				form.addOptionsPopup({
					name: name,
					label: option.label,
					options: option.options,
					rowClass: 'dm3sc-select-icon',
					icons: option.icons,
					iconClass: option.iconClass
				});
				break;

			case 'image':
				form.addImage({
					name: name,
					label: option.label
				});
				break;
		}
	};

	/**
	 * Generate shortcode tag from the form.
	 * 
	 * @param {String} name
	 * @return {String}
	 */
	INBShortcodeOptions.prototype.getShortcodeTag = function(shortcode, form) {
		var prop = null;
		
		for (prop in form.fields) {
			if (form.fields.hasOwnProperty(prop)) {
				shortcode = shortcode.replace(new RegExp('@' + prop, 'g'), form.fields[prop].field.val());
			}
		}
		
		return shortcode;
	};

	/**
	 * Display simple shortcode options in a content box.
	 */
	INBShortcodeOptions.prototype.displaySimple = function() {
		var that = this;
		this.forms[0] = this.getForm('parent');

		// Add shortcode to TinyMCE.
		this.forms[0].addButton({
			label: dm3scTr.labelInsertButton,
			class: 'button button-primary',
			callback: function() {
				that.addSimpleToEditor();
			}
		});

		// Open content box popup to display the options.
		this.contentBox = dm3ContentBox({
			width: 505,
			height: 571,
			title: this.shortcode.label,
			content: this.forms[0].getForm(),
			onClose: function() {
				that.destroyForms();
			}
		});

		$('body').trigger('dm3-shortcodes-open');
	};

	INBShortcodeOptions.prototype.addMultipleToEditor = function() {
		var tag = '',
			childShortcode = null,
			tmpShortcodeStr = '',
			childShortcodeStr = '',
			childShortcodes = this.contentBox.find('div.dm3sc-child-shortcodes > div'),
			options = this.shortcode.child_shortcode.options,
			option = null,
			value = null,
			fieldSelector = '',
			i = 0;

		for (i = 0; i < childShortcodes.length; ++i) {
			childShortcode = childShortcodes.eq(i);
			tmpShortcodeStr = this.shortcode.child_shortcode.shortcode;

			// Replace placeholders with values.
			for (option in options) {
				if (options.hasOwnProperty(option)) {
					switch (options[option].type) {
						case 'image':
						case 'text':
							fieldSelector = 'input';
							break;

						case 'textarea':
							fieldSelector = 'textarea';
							break;

						case 'select':
							fieldSelector = 'select';
							break;
					}

					value = childShortcode.find(fieldSelector + '[name="' + option + '"]').val();
					tmpShortcodeStr = tmpShortcodeStr.replace(new RegExp('@' + option, 'g'), value);
				}
			}

			childShortcodeStr += '<p>' + tmpShortcodeStr + '</p>';
		}

		tag = this.getShortcodeTag(this.shortcode.shortcode, this.forms[0]);
		tag = tag.replace('@child_shortcode', childShortcodeStr);

		// Insert shortcode into the post editor.
		tinymce.activeEditor.execCommand('mceInsertContent', false, tag);
		this.contentBox.find('.dm3-content-box-close:first').trigger('click');
	};

	INBShortcodeOptions.prototype.addSimpleToEditor = function(shortcodeType) {
		var tag = this.getShortcodeTag(this.shortcode.shortcode, this.forms[0]);
		tinymce.activeEditor.execCommand('mceInsertContent', false, tag);
		this.contentBox.find('.dm3-content-box-close:first').trigger('click');
	};

	INBShortcodeOptions.prototype.addChildShortcode = function() {
		var shortcodesContainer = this.contentBox.find('div.dm3sc-child-shortcodes:first');

		if (shortcodesContainer.children().length >= this.shortcode.max) {
			return;
		}

		var that = this;
		var form = this.getForm('child');
		var formElement = form.getForm();

		this.forms.push(form);
		var formIndex = this.forms.length - 1;

		formElement.append('<a class="dm3sc-remove-shortcode" data-form="' + formIndex + '" href="#">&times;</a>');
		formElement.on('click', '.dm3sc-remove-shortcode', function(e) {
			var formIndex = parseInt(this.getAttribute('data-form'), 10);
			that.forms[formIndex].destroy();
			that.forms[formIndex] = null;
		});

		shortcodesContainer.append(formElement);
	};

	/**
	 * Display options for shortcode with child shortcodes.
	 */
	INBShortcodeOptions.prototype.displayMultiple = function() {
		var child_shortcode = this.shortcode.child_shortcode,
			options = child_shortcode.options,
			option = null,
			that = this;

		// Parent shortcode options.
		this.forms[0] = this.getForm('parent');

		// First child shortcode options.
		this.forms[1] = this.getForm('child');

		// Create html for child shortcodes.
		var shortcodes_html = $('<div></div>');
		var child_shortcodes = $('<div class="dm3sc-child-shortcodes"></div>');

		// Add the first shortcode options.
		child_shortcodes.append(this.forms[1].getForm());
		shortcodes_html.append(this.forms[0].getForm());
		shortcodes_html.append(child_shortcodes);

		// Open content box.
		this.contentBox = dm3ContentBox({
			width: 505,
			height: 571,
			title: this.shortcode.label,
			content: shortcodes_html,
			onClose: function() {
				that.destroyForms();
			}
		});

		// Make child shortcodes sortable.
		child_shortcodes.sortable({
			placeholder: 'dm3sc-placeholder',
			start: function(e, ui) {
				ui.placeholder.height(ui.helper.height());
			}
		});

		// "Insert" button.
		var insert_button = $('<a class="button button-primary" href="#">' + dm3scTr.labelInsertButton + '</a>');

		insert_button.on('click', function(e) {
			e.preventDefault();
			that.addMultipleToEditor();
		});

		// "Add child shortcode" button.
		var add_button = $('<a class="button" href="#">' + child_shortcode.addButtonLabel + '</a>');

		add_button.on('click', function(e) {
			e.preventDefault();
			that.addChildShortcode();
		});

		$('<div class="dm3sc-form-action"></div>')
			.append(add_button)
			.append(insert_button)
			.appendTo(this.contentBox.find('.dm3-content-box-inner:first'));

		$('body').trigger('dm3-shortcodes-open');
	};

	/**
	 * Delete references to forms.
	 */
	INBShortcodeOptions.prototype.destroyForms = function() {
		for (var i = 0; i < this.forms.length; ++i) {
			if (this.forms[i]) {
				this.forms[i].destroy();
				this.forms[i] = null;
			}
		}

		this.forms = [];
	};

	// Add tinymce plugin.
	tinymce.PluginManager.add('dm3Shortcodes', function(editor, url) {
		var shortcodesMenu = [];
		var subMenu = null;
		var i = null;
		var subscname = null;
		var subsc = null;

		// Iterate through each shortcode or shortcodes category.
		for (i in dm3sc) {
			if (dm3sc.hasOwnProperty(i)) {
				if (!dm3sc[i].shortcodes) {
					// Single shorcode, not a category.
					shortcodesMenu.push({
						text: dm3sc[i].label,
						onclick: (function(shortcode) {
							return function() {
								var options = new INBShortcodeOptions(shortcode);
								options.display();
							};
						})(dm3sc[i])
					});
				} else {
					// Category of shortcodes.
					subMenu = [];

					for (subscname in dm3sc[i].shortcodes) {
						if (dm3sc[i].shortcodes.hasOwnProperty(subscname)) {
							subsc = dm3sc[i].shortcodes[subscname];
							subMenu.push({
								text: subsc.label,
								onclick: (function(shortcode) {
									return function() {
										var options = new INBShortcodeOptions(shortcode);
										options.display();
									};
								})(subsc)
							});
						}
					}

					shortcodesMenu.push({
						text: dm3sc[i].label,
						menu: subMenu
					});
				}
			}
		}

		editor.addButton('dm3Shortcodes', {
			type: 'menubutton',
			text: 'Shortcodes',
			menu: shortcodesMenu
		});
	});
})(jQuery);