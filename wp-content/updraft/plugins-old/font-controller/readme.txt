=== Plugin Name ===
Contributors: yettti
Donate link: http://bjetdesign.com/blog/
Tags: font-controller, size, font, font size, accessibility
Requires at least: 2.0.0
Tested up to: 2.8.5
Stable tag: 3.0.0

Allows placement of a font size controller within your blog. By default its placed in your sidebar and footer

== Description ==

Font-Controller allows you to place a font-controller inside your blog, it has three options, increase, decrease and reset.
You can add the tags into your template, post ect.
By default it places the widget into the footer and the sidebar
It is based on the Font-Controller jQuery plugin.

== Installation ==

To install all you need to do is press the activate button.
After that you can include it in a post by using [fontcontroller] or [fontcontroller=small]
Alternatively you can include it in your templates by using <?php fontController_place('smooth'); ?> or a safer way <?php if (function_exists('fontController_place')) : fontController_place('smooth'); ?>

== Frequently Asked Questions ==

= How to I include it in a post? =

By placing [fontcontroller] or by using [fontcontroller=small]
(for large or small)
This shortcode is also searched for in the footer.php and header.php template files

= How can I include it in a template? =

By putting in <?php if (function_exists('fontController_place')) : fontController_place('smooth'); ?>
(this will check if the function exists or not first as well)

= Does it load jQuery? =

Yes, but there is no worry, performance wise jQuery is almost always loaded anyway so you shouldn't see any performance changes.


== Screenshots ==

1. No screenshots

== Changelog ==

= 3.0.0 =
* Added widget support
* Added admin menu for placement control
= 2.0.0 =
* Improved placement support
* Added shortcode's
= 1.4.0 =
* Custom placement support
= 1.3.0 =
* Added controller icons into widgets column
* Changed icon style
* Added tool-tips on icons
* Modified javascript libraries
= 1.2.3 =
* Added cursor change over the icons
= 1.2.2 =
* Fixed problem with the jQuery plug-in
= 1.2.1 =
* Fixed missing files
= 1.2.0 =
* Major bug fix
= 1.0.1 =
* Very minor changes.
= 1.0 =
* First stable release.