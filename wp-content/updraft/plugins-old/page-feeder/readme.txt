=== Plugin Name ===
Contributors: woodscreative
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&item_name=WCM-Page-Feeder&business=paul@woodscreativemedia.com&currency_code=GBP
Tags: rss, feed, pages, page, wcm, paul, woods
Requires at least: 2.8
Tested up to: 2.9.1
Stable tag: 1.3

WCM Page Feeder lets you easily create and customise an RSS feed for your pages. Customize your feed using the settings page or via URL parameters.

== Description ==

WCM Page Feeder lets you easily create and customise an RSS feed for your pages. Customize your feed using the settings page or via URL parameters. This plugin is great for those who use Wordpress as a CMS solution and want to pull content into their site other than using the Wordpress environment. The latest release now feeds single pages.

Customise the following options:

* Feed single pages
* Define the maximum number of pages to show in your feed
* Get child pages
* Get parent pages
* Order ascending/descending
* Sort by column page_title etc..
* Filter Authors

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in Wordpress
1. Configure the plugin through Settings -> Page Feeder

== Frequently Asked Questions ==

= What's changed? =

The 'showpages' URL parameter has been deprecated. Please use 'feedpages' and 'feedpage' to activate the feed.

= How do I retrieve an RSS feed for my pages? =

This is the default method for retrieving page feeds. The default settings can be changed in the 'Page Feeder' WP settings menu.
http://exampleblog.com/?feedpages

= Can I customize multiple feeds? =

Yes. You can also override the settings by customizing the URL:
http://exampleblog.com/?feedpages&max=5&child_of=12

= Can I feed single pages? =

Yes. Here's how. NOTE: Link structure will depend upon your permalinks setting in Wordpress:
http://exampleblog.com/company/about/?feedpage

== Screenshots ==

1. Page Feeder Settings

== Upgrade Notice ==

= 1.1 =
NOTE: If you upgrade this plugin you will need to change your feed URL's!


== Change Log ==

= 1.3 =
* Fixed a feed problem under certain themes spotted by Mike Perlman documented on the WP forums.

= 1.2 =
* Added pubDate
* Added apply_filter to page content

= 1.1 =
* Added single page feed functionality
* 'showpages' URL paramter has been deprecated

= 1.0 =
* Initial release