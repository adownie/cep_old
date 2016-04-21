=== Plugin Name ===
Contributors: frodenas
Tags: font size, layout, style, sidebar, widget
Requires at least: 1.5 or higher
Tested up to: 3.0.1
Stable tag: 1.8

Allows users to dynamically change the font size.

== Description ==

Although users can change the font size of a web page [through standard browser settings](http://www.w3.org/WAI/changedesign),
few people knows or remembers how to do it.

WP-chgFontSize is a [WordPress](http://wordpress.org/) plugin that allows users to change dynamically the font size by adding
a text or image selection on your blog. It also stores the user selection on a user's browser cookie.

It can be used as a widget or directly as a PHP call in the theme.

== Installation ==

1. Download WP-chgFontSize.
2. Decompress and upload the contents of the archive into /wp-content/plugins/.
3. Activate the plugin on your WP Admin > Plugins page by clicking 'Activate' at the end of the 'WP-chgFontSize' row.
4. Configure the plugin on your WP Admin > Options > Font Size page.
5. To use it, there are two possibilities:
* If your theme supports widgets, and you have installed the [widget plugin](http://wordpress.org/extend/plugins/widgets/) or you are using Wordpress 2.2 or higher, add the 'WP-chgFontSize' widget on your WP Admin > Presentation > Widgets page.
* Add `<?php chgfontsize_display_options(); ?>` at the place in the theme's file where you want the font size selection appear.

== Changelog ==

= Version 1.0 - March 8 2007: =
* Initial release.

= Version 1.1 - August 1 2007: =
* Bug: use get_bloginfo(’wpurl’) instead of get_bloginfo(’url’).
* New feature: option to restore default font size.
* New feature: be able to specify min, max and interval values for the font size.
* New feature: be able to use pixels, ems and percentages units for the font size.

= Version 1.2 - September 6 2007: =
* Bug: first click on + size, it jump to GIANT font size.

= Version 1.3 - October 21, 2007: =
* New feature: widgetized version.

= Version 1.4 - October 26, 2007: =
* Bug: change js function names to avoid name duplications.

= Version 1.5 - February 5, 2008: =
* Bug: allow class type div elements.

= Version 1.6 - April 23, 2008: =
* Bug: fix IE issues with class type elements.

= Version 1.7 - June 10, 2009: =
* Bug: Determine the correct wp-content directory.

= Version 1.8 - May 4, 2010: =
* New feature: add 'Steps' mode (Thanks to Leo Brown!).

== Screenshots ==

1. Font Size Options Panel
2. Widget activation
