<?php

/*
Plugin Name: WP-chgFontSize
Plugin URI: http://www.rodenas.org/blog/2007/03/08/wp-chgfontsize/
Description: Allows users to dynamically change the font size.
Version: 1.8
Author: Ferran Rodenas
Author URI: http://www.rodenas.org/blog/
*/

/*
 Copyright 2007 Ferran Rodenas (email: frodenas@gmail.com)

 This program is free software; you can redistribute it and/or modify it under the terms
 of the GNU General Public License as published by the Free Software Foundation; either
 version 2 of the License, or any later version.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 See the GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along with this program;
 if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,
 MA  02111-1307  USA
*/

/* Changelog:

* Version 1.0 - March 8 2007:
  - Initial release.
* Version 1.1 - August 1 2007:
  - Bug: use get_bloginfo(’wpurl’) instead of get_bloginfo(’url’).
  - New feature: option to restore default font size.
  - New feature: be able to specify min, max and interval values for the font size.
  - New feature: be able to use pixels, ems and percentages units for the font size.
* Version 1.2 - September 6 2007:
  - Bug: first click on + size, it jump to GIANT font size.
* Version 1.3 - October 21, 2007:
  - New feature: widgetized version.
* Version 1.4 - October 26, 2007:
  - Bug: change js function names to avoid name duplications.
* Version 1.5 - February 5, 2008:
  - Bug: allow class type div elements.
* Version 1.6 - April 23, 2008:
  - Bug: fix IE issues with class type elements.
* Version 1.7 - June 10, 2009:
  - Bug: Determine the correct wp-content directory.
* Version 1.8 - May 4, 2010:
  - New feature: add 'Steps' mode (Thanks to Leo Brown!).

*/

// Pre-2.6 compatibility
if (!defined('WP_CONTENT_URL'))
	define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if (!defined('WP_PLUGIN_URL'))
	define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

// Plugin functions
function chgfontsize_display_options() {
	// Get the options from the Database
	$chgfontsize_div_element = get_option('chgfontsize_div_element');
	$chgfontsize_min_font_size = get_option('chgfontsize_min_font_size');
	$chgfontsize_max_font_size = get_option('chgfontsize_max_font_size');
	$chgfontsize_interval_font_size = get_option('chgfontsize_interval_font_size');
	$chgfontsize_units_font_size = get_option('chgfontsize_units_font_size');
	$chgfontsize_default_font_size = get_option('chgfontsize_default_font_size');
	$chgfontsize_display_text = get_option('chgfontsize_display_text');
	$chgfontsize_display_image = get_option('chgfontsize_display_image');
	$chgfontsize_display_steps = get_option('chgfontsize_display_steps');
	$chgfontsize_display_restore = get_option('chgfontsize_display_restore');

	// Insert call to javascript function
	echo "\n<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "chgfontsize_element = '" . $chgfontsize_div_element . "';\n";
	echo "chgfontsize_min_font_size = " . $chgfontsize_min_font_size . ";\n";
	echo "chgfontsize_max_font_size = " . $chgfontsize_max_font_size . ";\n";
	echo "chgfontsize_interval_font_size = " . $chgfontsize_interval_font_size . ";\n";
	echo "chgfontsize_units_font_size = '" . $chgfontsize_units_font_size . "';\n";
	echo "chgfontsize_default_font_size = " . $chgfontsize_default_font_size . ";\n";
	echo "chgfontsize_units = chgFontSize_getCookie('wp-chgfontsize-units');\n";
	echo "if (chgfontsize_units != chgfontsize_units_font_size) {\n";
	echo "   chgfontsize_font_size = chgfontsize_default_font_size;\n";
	echo "} else {\n";
	echo "   chgfontsize_font_size = Number(chgFontSize_getCookie('wp-chgfontsize'));\n";
	echo "   if (chgfontsize_font_size == null) { chgfontsize_font_size = chgfontsize_default_font_size; }\n";
	echo "}\n";
	if ($chgfontsize_display_image == 'on') {
		echo "chgfontsize_imgdecact = new Image();\n";
		echo "chgfontsize_imgdecact.src = '" . WP_PLUGIN_URL . "/wp-chgfontsize/decrease_activated.gif';\n";
		echo "chgfontsize_imgdecdea = new Image();\n";
		echo "chgfontsize_imgdecdea.src = '" . WP_PLUGIN_URL . "/wp-chgfontsize/decrease_deactivated.gif';\n";
		echo "chgfontsize_imgincact = new Image();\n";
		echo "chgfontsize_imgincact.src = '" . WP_PLUGIN_URL . "/wp-chgfontsize/increase_activated.gif';\n";
		echo "chgfontsize_imgincdea = new Image();\n";
		echo "chgfontsize_imgincdea.src = '" . WP_PLUGIN_URL . "/wp-chgfontsize/increase_deactivated.gif';\n";
	}
	echo "chgFontSize_display('" . $chgfontsize_display_text . "', '" . $chgfontsize_display_image . "', '" . $chgfontsize_display_steps . "', '" . $chgfontsize_display_restore . "');\n";
	echo "chgFontSize();\n";
	echo "//-->\n";
	echo "</script>\n";
}

// Header functions
function add_chgfontsize_js() {
	echo "\n<script src=\"" . WP_PLUGIN_URL . "/wp-chgfontsize/wp-chgfontsize.js\" type=\"text/javascript\"></script>\n";
}

add_action('wp_head', 'add_chgfontsize_js');

// Plugin options functions
function add_chgfontsize_options_page() {
	if (function_exists('add_options_page')) {
		add_options_page('Font Size Options', 'Font Size', 8, basename(__FILE__), 'add_chgfontsize_options_panel');
	}
}

function add_chgfontsize_options_panel() {
	if (isset($_POST['info_update'])) {
		$msg_desc = "";
		// DOM Base Element option
		if (empty($_POST['chgfontsize_div_element'])) {
			$chgfontsize_div_element = '';
			delete_option('chgfontsize_div_element');
		} else {
			$chgfontsize_div_element = $_POST['chgfontsize_div_element'];
			update_option('chgfontsize_div_element', $chgfontsize_div_element);
		}
		// Min Font Size option
		if (empty($_POST['chgfontsize_min_font_size'])) {
			$chgfontsize_min_font_size = '';
			delete_option('chgfontsize_min_font_size');
		} else {
			$chgfontsize_min_font_size = $_POST['chgfontsize_min_font_size'];
			if (is_numeric($chgfontsize_min_font_size)) {
				update_option('chgfontsize_min_font_size', $chgfontsize_min_font_size);
			} else {
				$msg_desc .= "Incorrect Min Font Size: Value must be numeric.<br />";
			}
		}
		// Max Font Size option
		if (empty($_POST['chgfontsize_max_font_size'])) {
			$chgfontsize_max_font_size = '';
			delete_option('chgfontsize_max_font_size');
		} else {
			$chgfontsize_max_font_size = $_POST['chgfontsize_max_font_size'];
			if (is_numeric($chgfontsize_max_font_size)) {
				if ($chgfontsize_max_font_size < $chgfontsize_min_font_size) {
					$msg_desc .= "Incorrect Max Font Size: Value must be greater than Min Font Size.<br />";
				} else {
					update_option('chgfontsize_max_font_size', $chgfontsize_max_font_size);
				}
			} else {
				$msg_desc .= "Incorrect Max Font Size: Value must be numeric.<br />";
			}
		}
		// Interval Font Size option
		if (empty($_POST['chgfontsize_interval_font_size'])) {
			$chgfontsize_interval_font_size = '';
			delete_option('chgfontsize_interval_font_size');
		} else {
			$chgfontsize_interval_font_size = $_POST['chgfontsize_interval_font_size'];
			if (is_numeric($chgfontsize_interval_font_size)) {
				update_option('chgfontsize_interval_font_size', $chgfontsize_interval_font_size);
			} else {
				$msg_desc .= "Incorrect Interval Font Size: Value must be numeric.<br />";
			}
		}
		// Units Font Size option
		if (empty($_POST['chgfontsize_units_font_size'])) {
			$chgfontsize_units_font_size = '';
			delete_option('chgfontsize_units_font_size');
		} else {
			$chgfontsize_units_font_size = $_POST['chgfontsize_units_font_size'];
			update_option('chgfontsize_units_font_size', $chgfontsize_units_font_size);
		}
		// Default Font size option
		if (empty($_POST['chgfontsize_default_font_size'])) {
			$chgfontsize_default_font_size = '';
			delete_option('chgfontsize_default_font_size');
		} else {
			$chgfontsize_default_font_size = $_POST['chgfontsize_default_font_size'];
			if (is_numeric($chgfontsize_default_font_size)) {
				if ($chgfontsize_default_font_size < $chgfontsize_min_font_size || $chgfontsize_default_font_size > $chgfontsize_max_font_size) {
					$msg_desc .= "Incorrect Default Font Size: Value must be between Min and Max Font Size.<br />";
				} else {
					update_option('chgfontsize_default_font_size', $chgfontsize_default_font_size);
				}
			} else {
				$msg_desc .= "Incorrect Default Font Size: Value must be numeric.<br />";
			}
		}
		// Display Text option
		if (empty($_POST['chgfontsize_display_text'])) {
			$chgfontsize_display_text = '';
			delete_option('chgfontsize_display_text');
		} else {
			$chgfontsize_display_text = 'on';
			update_option('chgfontsize_display_text', $chgfontsize_display_text);
		}
		// Display Image option
		if (empty($_POST['chgfontsize_display_image'])) {
			$chgfontsize_display_image = '';
			delete_option('chgfontsize_display_image');
		} else {
			$chgfontsize_display_image = 'on';
			update_option('chgfontsize_display_image', $chgfontsize_display_image);
		}
		// Display Steps option
		if (empty($_POST['chgfontsize_display_steps'])) {
			$chgfontsize_display_steps = '';
			delete_option('chgfontsize_display_steps');
		} else {
			$chgfontsize_display_steps = 'on';
			update_option('chgfontsize_display_steps', $chgfontsize_display_steps);
		}
		// Display Restore Default Font Size option
		if (empty($_POST['chgfontsize_display_restore'])) {
			$chgfontsize_display_restore = '';
			delete_option('chgfontsize_display_restore');
		} else {
			$chgfontsize_display_restore = 'on';
			update_option('chgfontsize_display_restore', $chgfontsize_display_restore);
		}
		if ($msg_desc != '') {
			echo '<div id="message" class="updated fade"><p>' . $msg_desc . '</p></div>';
		} else {
			echo '<div id="message" class="updated fade"><p>Your settings have been saved.</p></div>';
		}
	} else {
		$chgfontsize_div_element = get_option('chgfontsize_div_element');
		$chgfontsize_min_font_size = get_option('chgfontsize_min_font_size');
		$chgfontsize_max_font_size = get_option('chgfontsize_max_font_size');
		$chgfontsize_interval_font_size = get_option('chgfontsize_interval_font_size');
		$chgfontsize_units_font_size = get_option('chgfontsize_units_font_size');
		$chgfontsize_default_font_size = get_option('chgfontsize_default_font_size');
		$chgfontsize_display_text = get_option('chgfontsize_display_text');
		$chgfontsize_display_image = get_option('chgfontsize_display_image');
		$chgfontsize_display_steps = get_option('chgfontsize_display_steps');
		$chgfontsize_display_restore = get_option('chgfontsize_display_restore');
	}

	echo '<div class="wrap">';
	echo '<h2>Font Size options</h2>';
	echo '<p>Use this page to configure the default values:</p>';
	echo '<form name="formchgfontsize" method="post" action="' . $_SERVER['REQUEST_URI'] . '">';
	echo '<fieldset class="options">';
        echo '<table>';
	echo '<tr>';
	echo '<th align="right"><label for="chgfontsize_div_element">DIV Base Element:</label></th>';
	echo '<td><input type="text" name="chgfontsize_div_element" value="' . $chgfontsize_div_element . '" /> (e.g. content)</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<th align="right"><label for="chgfontsize_interval_font_size">Font Size:</label></th>';
	echo '<td>Min <input type="text" size="3" name="chgfontsize_min_font_size" value="' . $chgfontsize_min_font_size . '" />   Max <input type="text" size="3" name="chgfontsize_max_font_size" value="' . $chgfontsize_max_font_size . '" />   Interval <input type="text" size="3" name="chgfontsize_interval_font_size" value="' . $chgfontsize_interval_font_size . '" /></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<th align="right"><label for="chgfontsize_units_font_size">Units:</label></th>';
	$chgfontsize_units_em_checked = '';
	$chgfontsize_units_pc_checked = '';
	$chgfontsize_units_px_checked = '';
	if ($chgfontsize_units_font_size == 'em') { 
		$chgfontsize_units_em_checked = 'checked="checked"';
	} elseif ($chgfontsize_units_font_size == '%') {
		$chgfontsize_units_pc_checked = 'checked="checked"';
	} else {
		$chgfontsize_units_px_checked = 'checked="checked"';
	}
	echo '<td><input type="radio" name="chgfontsize_units_font_size" value="em" ' . $chgfontsize_units_em_checked . ' /> ems <br /><input type="radio" name="chgfontsize_units_font_size" value="%" ' . $chgfontsize_units_pc_checked . ' /> % <br /><input type="radio" name="chgfontsize_units_font_size" value="px" ' . $chgfontsize_units_px_checked . ' /> pixels </td>';
	echo '</tr>';
	echo '<tr>';
	echo '<th align="right"><label for="chgfontsize_default_font_size">Default Font Size:</label></th>';
	echo '<td><input type="text" size="3" name="chgfontsize_default_font_size" value="' . $chgfontsize_default_font_size . '" /></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<th align="right"><label for="chgfontsize_display">Display Font Size Values as:</label></th>';
        if ($chgfontsize_display_text == 'on') { 
		$chgfontsize_display_text_checked = 'checked="checked"';
	} else {
		$chgfontsize_display_text_checked = '';
	}
        if ($chgfontsize_display_image == 'on') { 
		$chgfontsize_display_image_checked = 'checked="checked"';
	} else {
		$chgfontsize_display_image_checked = '';
	}
        if ($chgfontsize_display_steps == 'on') { 
		$chgfontsize_display_steps_checked = 'checked="checked"';
	} else {
		$chgfontsize_display_steps_checked = '';
	}
	echo '<td><input type="checkbox" name="chgfontsize_display_text" ' . $chgfontsize_display_text_checked . ' /> Text <br /><input type="checkbox" name="chgfontsize_display_image" ' . $chgfontsize_display_image_checked . ' /> Image <br /><input type="checkbox" name="chgfontsize_display_steps" ' . $chgfontsize_display_steps_checked . ' /> Steps </td>';
	echo '</tr>';
	echo '<tr>';
	echo '<th align="right"><label for="chgfontsize_display_restore">Display Restore Default Font Size:</label></th>';
        if ($chgfontsize_display_restore == 'on') { 
		$chgfontsize_display_restore_checked = 'checked="checked"';
	} else {
		$chgfontsize_display_restore_checked = '';
	}
	echo '<td><input type="checkbox" name="chgfontsize_display_restore" ' . $chgfontsize_display_restore_checked . ' /></td>';
	echo '</tr>';
	echo '</table>';
	echo '</fieldset>';
	echo '<p class="submit"><input type="submit" name="info_update" value="Update Options &raquo;" /></p>';
	echo '<p><strong>Info</strong>: This plugin stores the options in the WordPress database. By leaving the above fields empty and hitting the &quot;<em>Update Options</em>&quot;';
	echo '	button, the options are removed from the WordPress database. Although it is not necessary, you should consider doing this before uninstalling the plugin, so no trace is left behind.</p>';
	echo '</form>';
	echo '</div>';
}

add_action('admin_menu', 'add_chgfontsize_options_page');

// Widget options functions
function widget_wpchgfontsize_init() {
 
	if (!function_exists('register_sidebar_widget') || !function_exists('register_widget_control'))
		return; 

	function widget_wpchgfontsize_control() {
		if (isset($_POST['wpchgfontsize-submit'])) {
			// Widget Title
			if (empty($_POST['wpchgfontsize_widget_title'])) {
				$wpchgfontsize_widget_title = '';
				delete_option('wpchgfontsize_widget_title');
			} else {
				$wpchgfontsize_widget_title = strip_tags(stripslashes($_POST['wpchgfontsize_widget_title']));
				update_option('wpchgfontsize_widget_title', $wpchgfontsize_widget_title);
			}
		} else { 
			$wpchgfontsize_widget_title = wp_specialchars(get_option('wpchgfontsize_widget_title'));
		}

		echo '<div style="text-align:right">';
		echo '<label for="wpchgfontsize_widget_title" style="line-height:35px;display:block;">Widget title: <input type="text" id="wpchgfontsize_widget_title" name="wpchgfontsize_widget_title" value="' . $wpchgfontsize_widget_title . '" /></label>';
		echo '<input type="hidden" name="wpchgfontsize-submit" id="wpchgfontsize-submit" value="1" />';
		echo '</div>';
	}

	function widget_wpchgfontsize($args) {
		extract($args);
		$wpchgfontsize_widget_title = wp_specialchars(get_option('wpchgfontsize_widget_title'));

		echo $before_widget;
		echo '<div class="wpchgfontsize">';
	        if (!empty($wpchgfontsize_widget_title)) {
			echo $before_title . $wpchgfontsize_widget_title . $after_title;
		}
		chgfontsize_display_options();
		echo '</div>';
		echo $after_widget;
	}

	register_sidebar_widget('WP-chgFontSize', 'widget_wpchgfontsize');
	register_widget_control('WP-chgFontSize', 'widget_wpchgfontsize_control'); 
}

add_action('plugins_loaded', 'widget_wpchgfontsize_init');

?>