<?php 
/**
 * Main template file used for Headway.
 *
 * @author Clay Griffiths
 * @package Headway
 **/


get_header() 
?>

	<div id="container" class="clearfix">

			<div id="site_tools">
			<ul id="email_page"><li><?php if(function_exists('wp_email')) { email_link(); } ?></li></ul>
			<ul id="print_page"><li><?php if(function_exists('wp_print')) { print_link(); } ?></li></ul>
			<ul id="font_tool">
			<li class="font_label">
			Text Size
			</li><?php if(function_exists('fontResizer_place')) { fontResizer_place(); } ?></ul>
			</div>

			<?php headway_build_leafs(); ?>

	</div><!-- #container -->


<?php get_footer() ?>