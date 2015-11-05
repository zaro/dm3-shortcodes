<?php
/**
 * Shortcodes definitions.
 * 
 * @package Dm3Shortcodes
 * @since Dm3Shortcodes 1.0
 * @version 2.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Strips extra p tags from shortcode content.
 *
 * @param string $content
 * @return string
 */
function dm3sc_content( $content ) {
	$content = preg_replace( '#(^<\/p>|^<br\s?\/?>|<p>$)#', '', $content );
	return $content;
}

/**
 * Process shortcodes.
 *
 * @param string $content
 * @return string
 */
function dm3sc_do_shortcode( $content ) {
	return do_shortcode( shortcode_unautop( dm3sc_content( $content ) ) );
}

/**
 * Columns.
 */
if ( ! function_exists( 'dm3sc_shortcode_column' ) ) {
	function dm3sc_shortcode_column( $atts, $content = null, $tag = null ) {
		$output = '';
		$content = dm3sc_do_shortcode( $content );
		$custom_class = '';

		if ( is_array( $atts ) && isset( $atts['class'] ) ) {
			$custom_class = ' ' . esc_attr( $atts['class'] );
		}

		switch( $tag ) {
			case 'dm3_one_half':
				$output = '<div class="dm3-one-half' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_one_half_last':
				$output = '<div class="dm3-one-half dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_one_third':
				$output = '<div class="dm3-one-third' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_one_third_last':
				$output = '<div class="dm3-one-third dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_one_fourth':
				$output = '<div class="dm3-one-fourth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_one_fourth_last':
				$output = '<div class="dm3-one-fourth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_one_fifth':
				$output = '<div class="dm3-one-fifth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_one_fifth_last':
				$output = '<div class="dm3-one-fifth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_one_sixth':
				$output = '<div class="dm3-one-sixth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_one_sixth_last':
				$output = '<div class="dm3-one-sixth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_two_third':
				$output = '<div class="dm3-two-third' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_two_third_last':
				$output = '<div class="dm3-two-third dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_three_fourth':
				$output = '<div class="dm3-three-fourth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_three_fourth_last':
				$output = '<div class="dm3-three-fourth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_two_fifth':
				$output = '<div class="dm3-two-fifth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_two_fifth_last':
				$output = '<div class="dm3-two-fifth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_three_fifth':
				$output = '<div class="dm3-three-fifth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_three_fifth_last':
				$output = '<div class="dm3-three-fifth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_four_fifth':
				$output = '<div class="dm3-four-fifth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_four_fifth_last':
				$output = '<div class="dm3-four-fifth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;

			case 'dm3_five_sixth':
				$output = '<div class="dm3-five-sixth' . $custom_class . '">' . $content . '</div>';
				break;

			case 'dm3_five_sixth_last':
				$output = '<div class="dm3-five-sixth dm3-column-last' . $custom_class . '">' . $content . '</div><div class="clear"></div>';
				break;
		}

		return $output;
	}

	add_shortcode( 'dm3_one_half', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_half_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_third', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_third_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_fourth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_fourth_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_fifth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_fifth_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_sixth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_one_sixth_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_two_third', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_two_third_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_three_fourth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_three_fourth_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_two_fifth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_two_fifth_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_three_fifth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_three_fifth_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_four_fifth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_four_fifth_last', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_five_sixth', 'dm3sc_shortcode_column' );
	add_shortcode( 'dm3_five_sixth_last', 'dm3sc_shortcode_column' );
}

/**
 * Button.
 */
if ( ! function_exists( 'dm3sc_shortcode_button' ) ) {
	function dm3sc_shortcode_button( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'url' => '',
			'size' => 'medium',
			'target' => '_self',
			'color' => 'default'
		), $atts );

		$class = 'dm3-btn';

		if ( in_array( $atts['size'], array( 'small', 'medium', 'large' ) ) ) {
			$class .= ' dm3-btn-' . $atts['size'];
		}

		if ( in_array( $atts['color'], array( 'blue', 'light-blue', 'red', 'orange', 'gold', 'green', 'purple' ) ) ) {
			$class .= ' dm3-btn-' . $atts['color'];
		}

		$target = '';
		if ( in_array( $atts['target'], array( '_self', '_blank' ) ) ) {
			$target = ' target="' . esc_attr( $atts['target'] ) . '"';
		}

		$output = '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $atts['url'] ) . '"' . $target . '>' . esc_html( $content ) . '</a>';
		return $output;
	}

	add_shortcode( 'dm3_button', 'dm3sc_shortcode_button' );
}

/**
 * Tabs.
 */
if ( ! function_exists( 'dm3sc_shortcode_tabs' ) ) {
	function dm3sc_shortcode_tabs( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'type' => 'horizontal',
		), $atts );

		preg_match_all( '/label="([^"]+)"/i', $content, $matches );

		$nav = '<ul class="dm3-tabs-nav">';
		if ( is_array( $matches ) && isset( $matches[1] ) ) {
			$num_tabs = count( $matches[1] );

			for ( $i = 0; $i < $num_tabs; ++$i ) {
				$active = ( $i == 0 ) ? ' class="active"' : '';
				$nav .= '<li' . $active . '><a href="#">' . esc_html( $matches[1][ $i ] ) . '</a></li>';
			}
		}
		$nav .= '</ul>';

		if ( $atts['type'] == 'vertical_left' ) {
			$tabs_class = 'dm3-tabs-vertical';
		} else if ( $atts['type'] == 'vertical_right' ) {
			$tabs_class = 'dm3-tabs-vertical dm3-tabs-vertical-right';
		} else {
			$tabs_class = 'dm3-tabs-default';
		}

		return '<div class="dm3-tabs-container ' . esc_attr( $tabs_class ) . '">' . $nav . '<div class="dm3-tabs">' . dm3sc_do_shortcode( $content ) . '</div></div>';
	}

	add_shortcode( 'dm3_tabs', 'dm3sc_shortcode_tabs' );
}

if ( ! function_exists( 'dm3sc_shortcode_tab' ) ) {
	function dm3sc_shortcode_tab( $atts, $content = null ) {
		return '<div class="dm3-tab"><div class="dm3-tab-inner">' . dm3sc_do_shortcode( $content ) . '</div></div>';
	}

	add_shortcode( 'dm3_tab', 'dm3sc_shortcode_tab' );
}

/**
 * Accordion.
 */
if ( ! function_exists( 'dm3sc_shortcode_accordion' ) ) {
	function dm3sc_shortcode_accordion( $atts, $content = null ) {
		return '<div class="dm3-accordion">' . dm3sc_do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'dm3_accordion', 'dm3sc_shortcode_accordion' );
}

if ( ! function_exists( 'dm3sc_shortcode_collapse' ) ) {
	function dm3sc_shortcode_collapse( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'label' => '',
			'state' => 'closed'
		), $atts );

		$output = '<div class="dm3-collapse-item' . ( $atts['state'] == 'open' ? ' dm3-collapse-open' : '' ) . '">
			<div class="dm3-collapse-trigger"><a href="#">' . esc_html( $atts['label'] ) . '</a></div>
			<div class="dm3-collapse-body dm3-collapse' . ( $atts['state'] == 'open' ? ' dm3-in' : '' ) . '">
				<div class="dm3-collapse-inner">' . dm3sc_do_shortcode( $content ) . '</div>
			</div>
		</div>';

		return $output;
	}

	add_shortcode( 'dm3_collapse', 'dm3sc_shortcode_collapse' );
}

/**
 * Alerts.
 */
if ( ! function_exists( 'dm3sc_shortcode_alert' ) ) {
	function dm3sc_shortcode_alert( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'type' => 'warning'
		), $atts );

		$class = 'dm3-alert';

		if ( in_array( $atts['type'], array( 'warning', 'info', 'success', 'error' ) ) ) {
			$class .= ' dm3-alert-' . $atts['type'];
		}

		$output = '<div class="' . esc_attr( $class ) . '">' . $content . '</div>';
		return $output;
	}

	add_shortcode( 'dm3_alert', 'dm3sc_shortcode_alert' );
}

/**
 * Divider.
 */
if ( ! function_exists( 'dm3sc_shortcode_divider' ) ) {
	function dm3sc_shortcode_divider( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'style' => ''
		), $atts );

		$class = 'dm3-divider';

		if ( in_array( $atts['style'], array( 'normal', 'dotted', 'space' ) ) ) {
			$class .= '-' . $atts['style'];
		}

		return '<div class="' . $class . '"></div>';
	}

	add_shortcode( 'dm3_divider', 'dm3sc_shortcode_divider' );
}

/**
 * Inline icon.
 */
if ( ! function_exists( 'dm3sc_shortcode_icon' ) ) {
	function dm3sc_shortcode_icon( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'icon' => '',
		), $atts );

		$class = '';

		if ( $atts['icon'] ) {
			$class .= dm3sc_icon_class( $atts['icon'] );
		}

		return '<span class="' . esc_attr( $class ) . '"></span>';
	}

	add_shortcode( 'dm3_icon', 'dm3sc_shortcode_icon' );
}

/**
 * Box icon.
 */
if ( ! function_exists( 'dm3sc_shortcode_box_icon' ) ) {
	function dm3sc_shortcode_box_icon( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'icon' => '',
			'style' => 'center',
		), $atts );

		$class = '';
		$icon_class = '';

		if ( $atts['icon'] ) {
			$icon_class .= dm3sc_icon_class( $atts['icon'] );
		}

		if ( $atts['style'] == 'center' ) {
			$class .= ' dm3-box-icon-center';
		} else {
			$class .= ' dm3-box-icon-left';
		}

		return '<div class="dm3-box-icon' . esc_attr( $class ) . '"><div class="dm3-box-icon-icon"><span class="' . esc_attr( $icon_class ) . '"></span></div><div class="dm3-box-icon-content">' . dm3sc_do_shortcode( $content ) . '</div></div>';
	}

	add_shortcode( 'dm3_box_icon', 'dm3sc_shortcode_box_icon' );
}

/**
 * Testimonials.
 */
if ( ! function_exists( 'dm3sc_shortcode_testimonials' ) ) {
	function dm3sc_shortcode_testimonials( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'autoscroll' => 0,
		), $atts );

		preg_match_all( '/\[dm3_testimonial/i', $content, $matches );

		$nav = '<ul class="dm3-tabs-nav">';

		if ( is_array( $matches ) && isset( $matches[0] ) ) {
			$i = 1;

			foreach( $matches[0] as $nav_item ) {
				$nav .= '<li><a href="#">' . $i++ . '</a></li>';
			}
		}
		
		$nav .= '</ul>';

		return '<div class="dm3-tabs-testimonials" data-autoscroll="' . absint( $atts['autoscroll'] )
			 . '"><div class="dm3-tabs">' . dm3sc_do_shortcode( $content ) . '</div>' . $nav . '</div>';
	}

	add_shortcode( 'dm3_testimonials', 'dm3sc_shortcode_testimonials' );
}

if ( ! function_exists( 'dm3sc_shortcode_testimonial' ) ) {
	function dm3sc_shortcode_testimonial( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'authorname' => '',
			'authordescription' => '',
			'authorwebsite' => '',
			'photo' => '',
		), $atts );

		$output = '<div class="dm3-tab"><div class="dm3-tab-inner">';
		$output .= '<blockquote>' . $content . '</blockquote>';

		if ( $atts['photo'] ) {
			$output .= '<div class="dm3-testimonial-photo"><img src="' . esc_url( $atts['photo'] ) . '" alt=""></div>';
		}

		if ( $atts['authorname'] ) {
			$output .= '<div class="dm3-testimonial-name">';

			if ( $atts['authorwebsite'] ) {
				$output .= '<a href="' . esc_url( $atts['authorwebsite'] ) . '" target="_blank">' . esc_html( $atts['authorname'] ) . '</a>';
			} else {
				$output .= esc_html( $atts['authorname'] );
			}

			$output .= '</div>';
		}

		if ( $atts['authordescription'] ) {
			$output .= '<div class="dm3-testimonial-description">' . esc_html( $atts['authordescription'] ) . '</div>';
		}

		$output .= '</div></div>';

		return $output;
	}

	add_shortcode( 'dm3_testimonial', 'dm3sc_shortcode_testimonial' );
}

/**
 * GOOGLE MAP.
 */
if ( ! function_exists( 'dm3sc_shortcode_google_map' ) ) {
	function dm3sc_shortcode_google_map( $atts, $content = null ) {
		static $map_id = 0;

		$map_id += 1;

		$atts = shortcode_atts( array(
			'latitude'  => '',
			'longitude' => '',
			'height'    => '',
			'zoom'      => 12,
		), $atts );

		if ( ! $atts['height'] ) {
			$atts['height'] = 300;
		}

		$output = '<div id="dm3-google-map-' . $map_id . '" class="dm3-google-map" data-height="'
				. intval( $atts['height'] ) . '" data-zoom="' . absint( $atts['zoom'] ) . '" data-latitude="' . esc_attr( $atts['latitude'] )
				. '" data-longitude="' . esc_attr( $atts['longitude'] ) . '"></div>';
		$output .= '<script>if (!window.google || !window.google.maps) {document.write(\'<\' + \'script src="//maps.google.com/maps/api/js?sensor=false"\' + \' type="text/javascript"><\' + \'/script>\');}</script>';

		return $output;
	}

	add_shortcode( 'dm3_google_map', 'dm3sc_shortcode_google_map' );
}