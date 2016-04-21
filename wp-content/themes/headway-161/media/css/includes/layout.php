div#wrapper {
	margin: <?php echo headway_get_skin_option('wrapper-margin')?>;
	width: <?php echo str_replace('px', '', headway_get_skin_option('wrapper-width'))?>px;
	clear: both;
	border: 1px solid #333; }
 
div#container { width: <?php echo str_replace('px', '', headway_get_skin_option('wrapper-width'))?>px; }
 
.header-outside div#wrapper {
	border-width: 0 1px 1px 1px;
	margin: 0 auto; }
 
#header-container {
	width: 100%;
	border-bottom: 1px solid #888;
	float: left; }
 
#header {
	margin: 0 auto;
	width: <?php echo str_replace('px', '', headway_get_skin_option('wrapper-width'))?>px;
	clear: both;
	float: left; }
 
.header-fixed #header { border-bottom: 1px solid #888; }
 
.header-fluid #header { float: none; }
 
div.header-link-top { margin: 10px 0 5px 10px; }
 
	a.header-link-text-inside { color: #333; }
 
div.header-link-image {
	margin:<?php echo (headway_get_skin_option('header-image-margin') || headway_get_skin_option('header-image-margin') == '0') ? headway_get_skin_option('header-image-margin'): '15px';
	?>; }
 
a.header-link-image-inside {
	float: left;
	margin: 0; }
 
	a.header-link-image-inside img { float: left; }
 
#navigation-container {
	border-bottom: 1px solid #888;
	width: 100%; }
 
#navigation {
	float: left;
	width: <?php echo str_replace('px', '', headway_get_skin_option('wrapper-width'))?>px;
	display: block;
	clear: both; }
 
.header-fixed #navigation { border-bottom: 1px solid #888; }
 
.header-fluid #navigation {
	float: none;
	margin: 0 auto; }
 
ul.navigation {
	margin: 0;
	padding: 0;
	list-style: none;
	float: left;
	position: relative;
	z-index: 100; }
 
ul.navigation-right { float: right; }
 
.header-outside ul.navigation {
	border-left: 1px solid #888;
	margin: 0 0 0 -1px;
	position: relative;
	z-index: 100; }
 
ul.navigation li {
	float: left;
	list-style: none;
	margin: 0;
	position: relative; }
 
	ul.navigation li a {
		padding: 10px;
		text-decoration: none;
		border-right: 1px solid #666;
		display: inline-block; }
 
	ul.navigation li a:hover { text-decoration: underline; }
 
	ul.navigation li.current_page_item a, ul.navigation li.current_page_parent a {
		text-decoration: none;
		background: #eee; }
 
	ul.navigation li.current_page_parent a:hover {
		background: #eee;
		text-decoration: none; }
 
	ul.navigation li ul {
		display: none;
		position: absolute;
		float: left;
		clear: left;
		background: #fff;
		padding: 0;
		border: 1px solid #888;
		border-width: 0 1px 1px 1px;
		z-index: 10000;
		margin: 0 0 0 -1px;
		width: 120px; }
 
	ul.navigation li.current_page_parent ul { background: #eee; }
 
	ul.navigation li ul, ul.navigation li.page_parent ul li a,ul.navigation li.page_parent.hover ul li a, ul.navigation li.page_parent:hover ul li a { width: <?php echo str_replace('px', '', headway_get_skin_option('sub-nav-width')) ?>px; }
 
	ul.navigation li.hover ul,
ul.navigation li:hover ul { display: block; }
 
	ul.navigation li.hover ul li ul,
ul.navigation li:hover ul li ul { display: none; }
 
	ul.navigation li ul li.hover ul,
ul.navigation li ul li:hover ul { display: block; }
 
	ul.navigation li ul li.hover ul li ul,
ul.navigation li ul li:hover ul li ul { display: none; }
 
	ul.navigation li ul li ul li.hover ul,
ul.navigation li ul li ul li:hover ul { display: block; }
 
	ul.navigation li ul li ul li.hover ul li ul,
ul.navigation li ul li ul li:hover ul li ul { display: none; }
 
	ul.navigation li ul li ul li ul li.hover ul,
ul.navigation li ul li ul li ul li:hover ul { display: block; }
 
	ul.navigation li ul li ul li ul li.hover ul li ul,
ul.navigation li ul li ul li ul li:hover ul li ul { display: none; }
 
	ul.navigation li ul li ul li ul li ul li.hover ul,
ul.navigation li ul li ul li ul li ul li:hover ul { display: block; }
 
ul.navigation .hide { display: none !important; }
 
ul.navigation .show { display: block !important; }
 
ul.navigation li ul li {
	margin: 0;
	list-style: none;
	float: none;
	position: relative; }
 
	ul.navigation li ul li a {
		padding: 6px 10px;
		border: none;
		width: auto; }
 
	ul.navigation li ul li.current_page_item a { text-decoration: underline; }
 
ul.navigation li.current_page_parent ul li a:hover { text-decoration: underline; }
 
ul.navigation li.current_page_item ul li a:hover { text-decoration: underline; }
 
ul.navigation li ul li ul {
	display: none;
	position: absolute;
	float: none;
	left: <?php echo str_replace('px', '', headway_get_skin_option('sub-nav-width'))+1?>px;
	clear: none;
	top: -1px; }
 
body.ie ul.navigation li ul li ul,
body.ie ul.navigation li ul li ul li ul,
body.ie ul.navigation li ul li ul li ul li ul,
body.ie ul.navigation li ul li ul li ul li ul li ul,
body.ie ul.navigation li ul li ul li ul li ul li ul li ul {
	position: absolute;
	margin-left: <?php echo str_replace('px', '', headway_get_skin_option('sub-nav-width'))?>px;
	float: right;
	left: 0;
	top: 0; }
 
#breadcrumbs-container {
	border-bottom: 1px solid #888;
	clear: both; }
 
#breadcrumbs {
	float: left;
	width: <?php echo str_replace('px', '', headway_get_skin_option('wrapper-width'))?>px;
	line-height: 25px; }
 
.header-fixed #breadcrumbs { border-bottom: 1px solid #888; }
 
.header-fluid #breadcrumbs {
	float: none;
	margin: 0 auto; }
 
#breadcrumbs p {
	padding: 0;
	margin: 0 10px;
	display: block;
	width: <?php echo str_replace('px', '', headway_get_skin_option('wrapper-width'))-20?>px;
	overflow: hidden; }
 
#container { margin: 10px 0; }
 
.headway-leaf {
	float: left;
	width: 250px;
	margin: 5px;
	padding: 10px 10px 0;
	overflow: hidden;
	min-height: 110px; }
 
.headway-leaf-right { float: right; }
 
.featured-image-left { float: left; }
 
.featured-image-right { float: right; }
 
div.leaf-content div.featured-post-container,
div.featured-leaf-content {
	float: left;
	display: block;
	width: 100%; }
 
div.featured-entry-content {
	float: left;
	display: block;
	width: 100%;
	margin: -5px 0 5px; }
 
div.leaf-content .entry-meta {
	display: block;
	clear: both; }
 
.fluid-height { height: auto !important; overflow: visible; }
 
#footer-container {
	width: 100%;
	border-top: 1px solid #888; }
 
#footer {
	margin: 0 auto;
	width: <?php echo str_replace('px', '', headway_get_skin_option('wrapper-width'))?>px;
	clear: both;
	border-top: 1px solid #888;
	min-height: 17px; }
 
.footer-fixed #footer {
	border-top: 1px solid #888;
	margin: 5px 0 0; }
 
.footer-fluid #footer {
	float: none;
	border-top: none; }
 
.align-left,.alignleft {
	float: left;
	margin: 0 7px 0 0; }
 
.align-right,.alignright {
	float: right;
	margin: 0 0 0 7px; }
 
.aligncenter {
	display: block;
	margin-left: auto;
	margin-right: auto;
	clear: both; }
 
.widget-title {
	margin: 0 0 10px;
	display: block; }
 
li.widget { margin: 0 0 25px; }
 
label { display: block; }
 
input,textarea,label { clear: both; }
 
input,textarea { margin: 0 0 10px; }
 
div.post { display: block; }
 
.entry-meta .left { float: left; }
 
.entry-meta .right { float: right; }
 
.meta-below-content .left,
.meta-below-content .right,
.meta-above-title .left,
.meta-above-title .right { margin: 0; }
 
div.nav-below { margin: 10px 0; }
 
div.gallery div.leaf-content div { display: block; }
 
div.content-slider div.leaf-content div { display: block; }
 
div.feed div.leaf-content div { display: block; }
 
div.content-slider-controller { margin: -20px 0 0 0; }
 
.featured-image-left { float: left; }
 
.featured-image-right { float: right; }
 
div.horizontal-sidebar ul li.widget {
	float: left;
	margin: 0 15px 0 15px;
	width: 20%; }
 
.content .post, .content .page { width: 100%; }
.small-excerpts-row .post { width: 46%; }