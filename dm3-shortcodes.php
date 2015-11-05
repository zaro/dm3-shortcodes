<?php
/*
Plugin Name: Dm3Shortcodes
Description: Adds a shortcodes generator to the post editor
Version: 2.2.1
Author: educatorteam
Author URI: http://educatorplugin.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dm3-shortcodes
*/

/*
Copyright (C) 2015 http://educatorplugin.com/ - contact@educatorplugin.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DM3SC_URL', plugins_url( '/', __FILE__ ) );
define( 'DM3SC_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Initialize.
 */
function dm3sc_init() {
	if ( is_admin() && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'dm3sc_mce_plugins' );
		add_filter( 'mce_buttons', 'dm3sc_mce_buttons' );
	}

	require_once DM3SC_PATH . 'front-end/shortcodes.php';
}
add_action( 'init', 'dm3sc_init' );

/**
 * Load text domain.
 */
function dm3sc_textdomain() {
	load_plugin_textdomain( 'dm3-shortcodes', false, 'dm3-shortcodes/languages' );
}
add_action( 'plugins_loaded', 'dm3sc_textdomain' );

/**
 * Enqueue icon font.
 */
function dm3sc_enqueue_icon_font() {
	// Enqueue icon font.
	$icon_font = apply_filters( 'dm3_shortcodes_icon_font', 'font-awesome-4.2' );

	switch ( $icon_font ) {
		case 'font-awesome-4.2':
			wp_enqueue_style( 'font-awesome', DM3SC_URL . 'front-end/font-awesome-4.2/css/font-awesome.min.css', array(), '4.2' );
			break;

		case 'font-awesome-3.2.1':
			wp_enqueue_style( 'font-awesome', DM3SC_URL . 'front-end/font-awesome-3.2.1/css/font-awesome.min.css', array(), '3.2.1' );
			break;
	}
}

/**
 * Enqueue scripts - front end.
 */
function dm3sc_enqueue_scripts() {
	// Styles.
	dm3sc_enqueue_icon_font();
	wp_enqueue_style( 'dm3-shortcodes-front', DM3SC_URL . 'front-end/css/shortcodes.css', array(), '2.0' );
	
	// Scripts.
	wp_enqueue_script( 'dm3-shortcodes-front', DM3SC_URL . 'front-end/js/shortcodes.js', array( 'jquery' ), '2.0' );
}
add_action( 'wp_enqueue_scripts', 'dm3sc_enqueue_scripts' );

/**
 * Enqueue scripts - admin panel.
 */
function dm3sc_admin_enqueue_scripts() {
	if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) ) {
		wp_enqueue_style( 'dm3-shortcodes', DM3SC_URL . 'css/dm3-shortcodes.css' );
		dm3sc_enqueue_icon_font();
		wp_enqueue_script( 'dm3-content-box', DM3SC_URL . 'js/dm3-content-box.js', array( 'jquery' ) );
		wp_enqueue_script( 'dm3-js-form', DM3SC_URL . 'js/dm3-js-form.js', array( 'jquery' ) );
		wp_localize_script( 'jquery', 'dm3scTr',
			array(
				'labelInsertButton' => __( 'Insert', 'dm3-shortcodes' ),
				'iconClass' => 'fa fa-',
			)
		);
		require DM3SC_PATH . 'front-end/config.php';
		// Apply filters, so other plugins and themes can add shortcodes to the menu.
		$shortcodes = apply_filters( 'dm3_shortcodes', $shortcodes );
		wp_localize_script( 'jquery', 'dm3sc', $shortcodes );
	}
}
add_action( 'admin_enqueue_scripts', 'dm3sc_admin_enqueue_scripts' );

/**
 * TinyMCE plugins.
 */
function dm3sc_mce_plugins( $plugins ) {
	$plugins['dm3Shortcodes'] = DM3SC_URL . 'js/dm3-shortcodes.js';
	return $plugins;
}

/**
 * TinyMCE buttons.
 */
function dm3sc_mce_buttons( $buttons ) {
	array_push( $buttons, 'separator', 'dm3Shortcodes' );
	return $buttons;
}

/**
 * Determine icon class based on the current icon font.
 *
 * @param string $icon
 * @return string
 */
function dm3sc_icon_class( $icon ) {
	switch ( apply_filters( 'dm3_shortcodes_icon_font', 'font-awesome-4.2' ) ) {
		case 'font-awesome-4.2':
			return 'fa fa-' . $icon;
			break;

		case 'font-awesome-3.2.1':
			return 'font-icon-' . $icon;
			break;
	}

	return $icon;
}
