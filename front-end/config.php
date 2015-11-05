<?php
/**
 * Shortcodes configuration.
 * 
 * @package Dm3Shortcodes
 * @since Dm3Shortcodes 1.0
 * @version 2.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$icon_font = apply_filters( 'dm3_shortcodes_icon_font', 'font-awesome-4.2' );
$icon_class = '';

switch ( $icon_font ) {
	case 'font-awesome-4.2':
		include 'font-awesome-4.2/config.php';
		$icon_class = 'fa fa-';
		break;

	case 'font-awesome-3.2.1':
		include 'font-awesome-3.2.1/config.php';
		$icon_class = 'font-icon-';
		break;
}

// Register shortcodes.
$shortcodes = array(
	// COLUMNS.
	array(
		'label' => __( 'Columns', 'dm3-shortcodes' ),
		'child_shortcode' => array(
			'options' => array(
				'size' => array(
					'type' => 'select',
					'label' => __( 'Size', 'dm3-shortcodes' ),
					'options' => array(
						array( 'label' => __( '1/2', 'dm3-shortcodes' ), 'value' => 'one_half' ),
						array( 'label' => __( '1/2 last', 'dm3-shortcodes' ), 'value' => 'one_half_last' ),
						array( 'label' => __( '1/3', 'dm3-shortcodes' ), 'value' => 'one_third' ),
						array( 'label' => __( '1/3 last', 'dm3-shortcodes' ), 'value' => 'one_third_last' ),
						array( 'label' => __( '1/4', 'dm3-shortcodes' ), 'value' => 'one_fourth' ),
						array( 'label' => __( '1/4 last', 'dm3-shortcodes' ), 'value' => 'one_fourth_last' ),
						array( 'label' => __( '1/5', 'dm3-shortcodes' ), 'value' => 'one_fifth' ),
						array( 'label' => __( '1/5 last', 'dm3-shortcodes' ), 'value' => 'one_fifth_last' ),
						array( 'label' => __( '1/6', 'dm3-shortcodes' ), 'value' => 'one_sixth' ),
						array( 'label' => __( '1/6 last', 'dm3-shortcodes' ), 'value' => 'one_sixth_last' ),
						array( 'label' => __( '2/3', 'dm3-shortcodes' ), 'value' => 'two_third' ),
						array( 'label' => __( '2/3 last', 'dm3-shortcodes' ), 'value' => 'two_third_last' ),
						array( 'label' => __( '3/4', 'dm3-shortcodes' ), 'value' => 'three_fourth' ),
						array( 'label' => __( '3/4 last', 'dm3-shortcodes' ), 'value' => 'three_fourth_last' ),
						array( 'label' => __( '2/5', 'dm3-shortcodes' ), 'value' => 'two_fifth' ),
						array( 'label' => __( '2/5 last', 'dm3-shortcodes' ), 'value' => 'two_fifth_last' ),
						array( 'label' => __( '3/5', 'dm3-shortcodes' ), 'value' => 'three_fifth' ),
						array( 'label' => __( '3/5 last', 'dm3-shortcodes' ), 'value' => 'three_fifth_last' ),
						array( 'label' => __( '4/5', 'dm3-shortcodes' ), 'value' => 'four_fifth' ),
						array( 'label' => __( '4/5 last', 'dm3-shortcodes' ), 'value' => 'four_fifth_last' ),
						array( 'label' => __( '5/6', 'dm3-shortcodes' ), 'value' => 'five_sixth' ),
						array( 'label' => __( '5/6 last', 'dm3-shortcodes' ), 'value' => 'five_sixth_last' )
					)
				),
				'content' => array(
					'type' => 'textarea',
					'label' => __( 'Content', 'dm3-shortcodes' )
				)
			),
			'shortcode' => '[dm3_@size]@content[/dm3_@size]',
			'addButtonLabel' => __( 'Add another column', 'dm3-shortcodes' )
		),
		'shortcode' => '@child_shortcode'
	),

	// BUTTON.
	array(
		'label' => __( 'Button', 'dm3-shortcodes' ),
		'options' => array(
			'url' => array(
				'type' => 'text',
				'label' => __( 'URL', 'dm3-shortcodes' )
			),
			'label' => array(
				'type' => 'text',
				'label' => __( 'Label', 'dm3-shortcodes' )
			),
			'size' => array(
				'type' => 'select',
				'label' => __( 'Size', 'dm3-shortcodes' ),
				'options' => array(
					array( 'label' => __( 'Small', 'dm3-shortcodes' ), 'value' => 'small' ),
					array( 'label' => __( 'Medium', 'dm3-shortcodes' ), 'value' => 'medium', 'selected' => true ),
					array( 'label' => __( 'Large', 'dm3-shortcodes' ), 'value' => 'large' )
				)
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Target', 'dm3-shortcodes' ),
				'options' => array(
					array( 'label' => __( '_self', 'dm3-shortcodes' ), 'value' => '_self' ),
					array( 'label' => __( '_blank', 'dm3-shortcodes' ), 'value' => '_blank' )
				)
			),
			'color' => array(
				'type' => 'select',
				'label' => __( 'Color', 'dm3-shortcodes' ),
				'options' => array(
					array( 'label' => __( 'Default', 'dm3-shortcodes' ), 'value' => 'default' ),
					array( 'label' => __( 'Blue', 'dm3-shortcodes' ), 'value' => 'blue' ),
					array( 'label' => __( 'Light blue', 'dm3-shortcodes' ), 'value' => 'light-blue' ),
					array( 'label' => __( 'Red', 'dm3-shortcodes' ), 'value' => 'red' ),
					array( 'label' => __( 'Orange', 'dm3-shortcodes' ), 'value' => 'orange' ),
					array( 'label' => __( 'Gold', 'dm3-shortcodes' ), 'value' => 'gold' ),
					array( 'label' => __( 'Purple', 'dm3-shortcodes' ), 'value' => 'purple' )
				)
			)
		),
		'shortcode' => '[dm3_button url="@url" color="@color" size="@size" target="@target"]@label[/dm3_button]'
	),

	// TABS.
	array(
		'label' => __( 'Tabs', 'dm3-shortcodes' ),
		'options' => array(
			'type' => array(
				'type' => 'select',
				'label' => __( 'Type', 'dm3-shortcodes' ),
				'options' => array(
					array( 'label' => __( 'Horizontal', 'dm3-shortcodes' ), 'value' => 'horizontal' ),
					array( 'label' => __( 'Vertical (nav left)', 'dm3-shortcodes' ), 'value' => 'vertical_left' ),
					array( 'label' => __( 'Vertical (nav right)', 'dm3-shortcodes' ), 'value' => 'vertical_right' )
				)
			)
		),
		'child_shortcode' => array(
			'options' => array(
				'label' => array(
					'type' => 'text',
					'label' => __( 'Label', 'dm3-shortcodes' )
				),
				'content' => array(
					'type' => 'textarea',
					'label' => __( 'Content', 'dm3-shortcodes' )
				)
			),
			'shortcode' => '[dm3_tab label="@label"]@content[/dm3_tab]',
			'addButtonLabel' => __( 'Add another tab', 'dm3-shortcodes' )
		),
		'shortcode' => '[dm3_tabs type="@type"]@child_shortcode[/dm3_tabs]'
	),

	// TOGGLE.
	array(
		'label' => __( 'Toggle', 'dm3-shortcodes' ),
		'options' => array(
			'label' => array(
				'type' => 'text',
				'label' => __( 'Label', 'dm3-shortcodes' )
			),
			'content' => array(
				'type' => 'textarea',
				'label' => __( 'Content', 'dm3-shortcodes' )
			),
			'state' => array(
				'type' => 'select',
				'label' => __( 'State', 'dm3-shortcodes' ),
				'options' => array(
					array( 'label' => __( 'Closed', 'dm3-shortcodes' ), 'value' => 'closed' ),
					array( 'label' => __( 'Open', 'dm3-shortcodes' ), 'value' => 'open' )
				)
			)
		),
		'shortcode' => '[dm3_collapse label="@label" state="@state"]@content[/dm3_collapse]'
	),

	// ACCORDION.
	array(
		'label' => __( 'Accordion', 'dm3-shortcodes' ),
		'child_shortcode' => array(
			'options' => array(
				'label' => array(
					'type' => 'text',
					'label' => __( 'Label', 'dm3-shortcodes' )
				),
				'content' => array(
					'type' => 'textarea',
					'label' => __( 'Content', 'dm3-shortcodes' )
				),
				'state' => array(
					'type' => 'select',
					'label' => __( 'State', 'dm3-shortcodes' ),
					'options' => array(
						array( 'label' => __( 'Closed', 'dm3-shortcodes' ), 'value' => 'closed' ),
						array( 'label' => __( 'Open', 'dm3-shortcodes' ), 'value' => 'open' )
					)
				)
			),
			'shortcode' => '[dm3_collapse label="@label" state="@state"]@content[/dm3_collapse]',
			'addButtonLabel' => __( 'Add another item', 'dm3-shortcodes' )
		),
		'shortcode' => '[dm3_accordion]@child_shortcode[/dm3_accordion]'
	),

	// ALERTS.
	array(
		'label' => __( 'Alert box', 'dm3-shortcodes' ),
		'options' => array(
			'type' => array(
				'type' => 'select',
				'label' => __( 'Type', 'dm3-shortcodes' ),
				'options' => array(
					array( 'label' => __( 'Warning', 'dm3-shortcodes' ), 'value' => 'warning' ),
					array( 'label' => __( 'Info', 'dm3-shortcodes' ), 'value' => 'info' ),
					array( 'label' => __( 'Success', 'dm3-shortcodes' ), 'value' => 'success' ),
					array( 'label' => __( 'Error', 'dm3-shortcodes' ), 'value' => 'error' )
				)
			),
			'content' => array(
				'type' => 'textarea',
				'label' => __( 'Content', 'dm3-shortcodes' )
			)
		),
		'shortcode' => '[dm3_alert type="@type"]@content[/dm3_alert]'
	),

	// DIVIDER.
	array(
		'label' => __( 'Divider', 'dm3-shortcodes' ),
		'options' => array(
			'style' => array(
				'type' => 'select',
				'label' => __( 'Style', 'dm3-shortcodes' ),
				'options' => array(
					array( 'label' => __( 'Normal', 'dm3-shortcodes' ), 'value' => 'normal' ),
					array( 'label' => __( 'Dotted', 'dm3-shortcodes' ), 'value' => 'dotted' ),
					array( 'label' => __( 'Space', 'dm3-shortcodes' ), 'value' => 'space' )
				)
			)
		),
		'shortcode' => '[dm3_divider style="@style"/]'
	),

	// ICONS.
	array(
		'label' => __( 'Icons', 'dm3-shortcodes' ),
		'shortcodes' => array(
			// Inline icon.
			array(
				'label' => __( 'Inline icon', 'dm3-shortcodes' ),
				'options' => array(
					'icon' => array(
						'type' => 'optionspopup',
						'label' => __( 'Icon', 'dm3-shortcodes' ),
						'options' => $font_icons,
						'icons' => 1,
						'iconClass' => $icon_class,
					)
				),
				'shortcode' => '[dm3_icon icon="@icon"/]'
			),
			// Box icon.
			array(
				'label' => __( 'Box icon', 'dm3-shortcodes' ),
				'options' => array(
					'icon' => array(
						'type' => 'optionspopup',
						'label' => __( 'Icon', 'dm3-shortcodes' ),
						'options' => $font_icons,
						'icons' => 1,
						'iconClass' => $icon_class,
					),
					'style' => array(
						'type' => 'select',
						'label' => __( 'Style', 'dm3-shortcodes' ),
						'options' => array(
							array( 'label' => __( 'Center', 'dm3-shortcodes' ), 'value' => 'center' ),
							array( 'label' => __( 'Left', 'dm3-shortcodes' ), 'value' => 'left' )
						)
					),
					'content' => array(
						'type' => 'textarea',
						'label' => __( 'Content', 'dm3-shortcodes' )
					),
				),
				'shortcode' => '[dm3_box_icon icon="@icon" style="@style"]@content[/dm3_box_icon]'
			)
		)
	),

	// TESTIMONIALS.
	array(
		'label' => __( 'Testimonials', 'dm3-shortcodes' ),
		'options' => array(
			'autoscroll' => array(
				'type' => 'text',
				'label' => __( 'Autoscroll in seconds', 'dm3-shortcodes' ),
				'value' => 0
			)
		),
		'child_shortcode' => array(
			'options' => array(
				'testimonial' => array(
					'type' => 'textarea',
					'label' => __( 'Testimonial', 'dm3-shortcodes' )
				),
				'photo' => array(
					'type' => 'image',
					'label' => __( 'Photo', 'dm3-shortcodes' )
				),
				'authorname' => array(
					'type' => 'text',
					'label' => __( 'Author name', 'dm3-shortcodes' )
				),
				'authordescription' => array(
					'type' => 'text',
					'label' => __( 'Author description', 'dm3-shortcodes' )
				),
				'authorwebsite' => array(
					'type' => 'text',
					'label' => __( 'Author website', 'dm3-shortcodes' )
				)
			),
			'shortcode' => '[dm3_testimonial authorname="@authorname" authordescription="@authordescription" photo="@photo" authorwebsite="@authorwebsite"]@testimonial[/dm3_testimonial]',
			'addButtonLabel' => __( 'Add another testimonial', 'dm3-shortcodes' )
		),
		'shortcode' => '[dm3_testimonials autoscroll="@autoscroll"]@child_shortcode[/dm3_testimonials]'
	),

	// GOOGLE MAP.
	array(
		'label' => __( 'Google map', 'dm3-shortcodes' ),
		'options' => array(
			'latitude' => array(
				'type'        => 'text',
				'label'       => __( 'Latitude', 'dm3-shortcodes' ),
				'description' => __( 'Example: 42.365141', 'dm3-shortcodes' ),
			),
			'longitude' => array(
				'type'        => 'text',
				'label'       => __( 'Longitude', 'dm3-shortcodes' ),
				'description' => __( 'Example: -71.061691', 'dm3-shortcodes' ),
			),
			'zoom' => array(
				'type'  => 'text',
				'label' => __( 'Zoom', 'dm3-shortcodes' )
			),
			'height' => array(
				'type'  => 'text',
				'label' => __( 'Height (in pixels)', 'dm3-shortcodes' )
			),
		),
		'shortcode' => '[dm3_google_map latitude="@latitude" longitude="@longitude" height="@height" /]'
	),
);