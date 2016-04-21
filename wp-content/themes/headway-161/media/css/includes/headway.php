/* Default Styles */
 
div#wrapper {
	background: #fff;
	border-color: #222;
	border-width: 3px; }
 
#header-container,#navigation-container,#breadcrumbs-container {
	background: #fff;
	font-size: 1.1em; }
 
div.header-link-text {
	margin: 20px 0 6px 15px;
	float: left; }
 
div.header-link-image { float: left; }
 
a.header-link-text-inside {
	color: #555;
	text-decoration: none;
	padding: 0 0 5px 0;
	border-bottom: 1px solid #ddd;
	margin: 0 0 10px; }
 
div.header-link-image a { border-bottom: none; }
  
h1#tagline {
	font-size: 2em;
	margin: 0 0 20px 15px;
	color: #777;
	float: none;
	clear: left; }
 
body.header-fluid div#wrapper { border-top: none !important; }

ul.navigation li.page_parent.hover a,ul.navigation li.page_parent:hover a {
	padding: 10px 10px 10px;
	z-index: 10001;
	position: relative;
	border-bottom: none; }
 
ul.navigation li.page_parent a { background: #fff; }
 
ul.navigation li.current_page_parent a, ul.navigation li.current_page_item a { background: #eee; }
 
ul.navigation li ul li.current_page_item a { text-decoration: underline; }
 
ul.navigation li ul {
	border-width: 1px;
	z-index: 10002;
	margin-top: 0;
	padding: 0 0 1px; }
 
ul.navigation li.page_parent ul li a,ul.navigation li.page_parent.hover ul li a, ul.navigation li.page_parent:hover ul li a {
	padding: 6px 10px 8px;
	border-bottom: none;
	border-right: none; }
	
<?php
$nav_item_normal = str_replace('px', '', headway_get_element_property('font', 'ul-period-navigation-space-li', 'line-height'));
$nav_item_current = str_replace('px', '', headway_get_element_property('font', 'ul-period-navigation-space-li-period-current_page_item-space-a', 'line-height'));

if($nav_item_normal > $nav_item_current){
	$navigation_height = $nav_item_normal + 20;
} else {
	$navigation_height = $nav_item_current + 20;
}
?>	
	
body.ie ul.navigation li ul { top: <?php echo $navigation_height ?>px; }
 
.headway-leaf { background: none; }
 
div.featured-post { background: none; }
 
.leaf-top {
	text-transform: uppercase;
	padding: 2px 4px;
	border-bottom: 1px solid #333;
	color: #333;
	margin: 0 0 5px 0; }
 
#footer {
	display: block;
	padding: 10px 0;
	border-top: 1px solid #999; }
 
#footer-container { border-top: 1px solid #999; }
 
div#footer * {
	padding: 0;
	margin: 0; }
 
div#footer .footer-left {
	margin-left: 10px;
	float: left; }
 
div#footer .footer-right {
	margin-right: 10px;
	float: right; }
 
div#footer a.no-underline { text-decoration: none; }
 
div#footer .copyright {
	clear: both;
	text-align: center;
	margin: 25px 0 0; }
 
div#footer a.no-underline:hover { text-decoration: underline; }
 
.feed-entry-date { color: #888; }
 
.featured-image {
	border: 2px solid #ddd;
	padding: 1px;
	margin: 5px 10px; }
 
.featured-entry-date {
	color: #888;
	float: left; }
 
.featured-entry-content {
	clear: both;
	margin: 5px 0;
	float: left; }
 
.featured-entry-title { font-size: 2em; }
 
	.featured-entry-title a { text-decoration: none; }
 
		.featured-entry-title a:hover { text-decoration: underline; }
 
.featured-post { margin: 10px 0; }
 
.featured-entry-comments { float: right; }
 
.featured_prev { float: left; }
 
.featured_next { float: right; }
 
.featured_outside_prev,
.featured_outside_next {
	margin: 30px 0 0 0;
	z-index: 8000;
	position: relative; }
 
div.leaf-content div.rotator-images {
	display: inline-block;
	top: -5px;
	position: relative; }
 
	div.leaf-content div.rotator-images img { border: 1px solid #fff; }
 
.align-left { margin: 0 7px 0 0; }
 
.align-right { margin: 0 0 0 7px; }
 
.about-image {
	padding: 1px;
	border: 1px solid #ccc; }
 
.about-read-more {
	clear: both;
	float: left;
	margin: 3px 0 0; }
 
div.nav-previous {
	float: left;
	margin: 10px 0; }
 
	div.nav-previous a,
div.nav-next a {
		padding: 5px;
		font-size: 1.1em;
		color: #222;
		background: #ccc;
		text-decoration: none;
		display: block; }
 
	div.nav-previous a:hover,
div.nav-next a:hover { text-decoration: underline; }
 
div.nav-next {
	float: right;
	margin: 10px 0; }
 
ul.sidebar {
	margin: 0;
	padding: 0; }
 
	ul.sidebar li { list-style: none; }
 
		ul.sidebar li ul {
			margin: 0 0 10px 10px;
			padding: 0;
			list-style: none; }
 
			ul.sidebar li ul li {
				list-style: disc;
				margin: 0 0 7px;
				list-style: none; }
 
				ul.sidebar li ul li ul {
					padding: 0 0 0 25px;
					margin: 7px 0 7px; }
 
span.widget-title {
	padding: 2px 4px;
	border-bottom: 1px solid #fff; }
 
li.widget_socialwidget { text-align: center; }
 
	li.widget_socialwidget span.widget-title { text-align: left; }
 
.entry-title { clear: both; }
 
	.entry-title a,.entry-title a:visited { text-decoration: none; }
 
	.entry-title a:hover { color: #666; }
 
.archives-title { color: #7a7a7a; }
 
.page-title { margin: 0 0 20px; }
 
div.post,div.page { display: block; }
 
.entry-meta {
	color: #7a7a7a;
	display: block;
	margin: 3px 0 0 0;
	clear: both; }
 
	.entry-meta a { color: #7a7a7a; }
 
		.entry-meta a:hover { text-decoration: none; }
 
.meta-above-title .left,.meta-above-title .right { margin: 0 0 5px; }
 
.entry-content { clear: both; }
 
	.entry-content h2,.entry-content h3,.entry-content h4 { margin: 10px 0; }
 
img.border {
	padding: 1px;
	border: 1px solid #ddd; }
 
img.no-border {
	padding: 0;
	border: none; }
 
a.more-link {
	background: #ccc;
	padding: 2px 4px;
	text-decoration: none;
	margin: 10px 0 20px;
	float: left;
	color: #333;
	clear: both; }
 
a.more-link:hover { text-decoration: underline; }
 
div.post,div.small-post {
	margin: 0 0 20px;
	padding: 0 0 20px;
	border-bottom: 1px solid #ccc; }
 
.post-thumbnail {
	border: 1px solid #eaeaea;
	padding: 2px; }
  
.post-image {
	border: 3px double #eaeaea;
	padding: 1px; }
 
.post-thumbnail-left {
	float: left;
	margin: 0 7px 7px 0;
	width: 48px; }
 
.post-thumbnail-right {
	float: right;
	margin: 0 0 7px 7px;
	height: 48px; }
 
.post-image-left {
	float: left;
	margin: 0 10px 10px 0; }
 
.post-image-right {
	float: right;
	margin: 0 0 10px 10px; }
 
	.post-image-right img,.post-thumbnail-right img { float: right; }
 
.post-image-left img,.post-thumbnail-left img { float: left; }
 
div.feed-post {
	margin: 5px 0;
	padding: 10px 0; }
 
body.single div.post { border-bottom: none; }
 
div.small-post { font-size: 90%; }
 
input.text,textarea.text {
	border-top: 1px solid #aaa;
	border-right: 1px solid #e1e1e1;
	border-bottom: 1px solid #e1e1e1;
	border-left: 1px solid #aaa;
	background: #fff;
	font-size: 1.1em;
	padding: 3px;
	color: #4c4c4c; }
 
.text:focus {
	background: #f3f3f3;
	color: #111; }
 
input.text { width: 50%; }
 
textarea.text {
	width: 70%;
	line-height: 1.4em; }
 
input.submit {
	border-top: 1px solid #efefef;
	border-right: 1px solid #777;
	border-bottom: 1px solid #777;
	border-left: 1px solid #efefef;
	background: #eee;
	color: #444;
	font-size: 1.1em;
	padding: 3px 5px; }
 
h2.border-top,h3.border-top,h4.border-top,p.border-top {
	padding-top: 10px;
	border-top: 1px solid #ddd; }
 
.entry-content .grey { color: #999; }
 
ol.commentlist,ol.pinglist {
	margin: 10px 0;
	padding: 0;
	border-bottom: 1px solid #ddd; }
 
ol.commentlist { list-style: none; }
 
	ol.commentlist li {
		border: 1px solid #ddd;
		border-width: 1px 0 0;
		list-style: none;
		padding: 10px;
		margin: 0; }
 
		ol.commentlist li ul.children {
			border-bottom: 1px solid #ddd;
			margin-right: -10px; }
 
			ol.commentlist li ul.children li { margin: 10px 0; }
 
li.thread-odd { background: #fbfbfb; }
 
img.avatar {
	float: right;
	margin: 0 0 2px 5px;
	padding: 1px;
	border: 1px solid #eee; }
 
span.comment-author {
	font-size: 1.2em;
	color: #222; }
 
	span.comment-author a {
		color: #222;
		text-decoration: none; }
 
		span.comment-author a:hover { text-decoration: underline; }
 
div.comment-date { color: #666; }
 
span.heading {
	font-size: 1.6em;
	color: #444;
	clear: both;
	display: block;
	margin-top: 15px; }
 
p.nocomments {
	border-top: 1px solid #ddd;
	font-size: 1.2em;
	margin: 10px 0 0;
	padding: 10px 0;
	color: #666;
	clear: both; }
 
.comment-info-box {
	background: #f9f9f9;
	border: 1px solid #ddd;
	padding: 7px;
	width: 70%; }
 
.comment-body {
	line-height: 1.5em;
	color: #333; }
 
div.comments-navigation {
	margin: 15px 0;
	float: left; }
 
div#trackback-box { float: left; }
 
	div#trackback-box span#trackback {
		margin: 0;
		font-size: 1.2em;
		color: #333;
		float: left; }
 
	div#trackback-box span#trackback-url {
		margin: 5px 0 0;
		font-size: 0.9em;
		color: #666;
		clear: left;
		float: left; }
 
ol.commentlist div#respond {
	margin: 10px -10px 0 15px;
	border: 1px solid #ddd;
	border-width: 1px 0;
	padding: 10px 0 0; }
 
div#respond label {
	font-size: 1.2em;
	color: #555; }
 
ul.subscribe { padding: 0 0 0 15px; }
 
	ul.subscribe li {
		list-style: none;
		padding: 2px 0 2px 22px; }
 
		ul.subscribe li.rss { background: url(<?php bloginfo('template_directory') ?>/media/images/rss.gif) no-repeat; }
 
		ul.subscribe li.email { background: url(<?php bloginfo('template_directory') ?>/media/images/email.gif) no-repeat; }
 
input#s {
	width: 96.5%;
	background: #f6f6f6;
	border: 1px solid #ccc;
	color: #666;
	font-size: 1em;
	padding: 4px 5px; }
 
	input#s:focus {
		background: #fff;
		border: 1px solid #888;
		color: #222; }
 
ul.twitter-updates,ul.sidebar li ul.twitter-updates {
	list-style: none;
	margin: 10px 0 0 10px;
	padding: 0; }
 
.headway-leaf ul.twitter-updates { margin-left: 0; }
 
ul.twitter-updates li,ul.sidebar li ul.twitter-updates li {
	clear: both;
	margin: 0 0 5px;
	padding: 0 0 5px;
	border-bottom: 1px solid #ddd;
	list-style: none; }
 
ul.twitter-updates li span {
	color: #888;
	margin: 0 0 0 6px; }
	
img.wp-smiley { border: none; }
 
.wp-caption {
	padding: 5px;
	border: 1px solid #eee;
	background: #fcfcfc;
	margin-top: 15px;
	margin-bottom: 15px; }
 
	.wp-caption img {
		border: 1px solid #ddd;
		margin: 0 auto;
		display: block;
		padding: 0; }
		
	.wp-caption img.wp-smiley { border: none; }
 
	.wp-caption p {
		text-align: center;
		color: #555;
		margin: 5px 0 0;
		font-style: italic; }
 
div.small-excerpts-row {
	border-bottom: 1px solid #ccc;
	margin: 0 0 30px;
	padding: 0 0 30px; }
 
div.small-excerpts-post {
	width: 46%;
	font-size: 0.9em;
	float: left;
	border-bottom: none;
	margin: 0;
	padding: 0 2%; }
 
	div.small-excerpts-post h2 a { font-size: 80%; }
 
	div.small-excerpts-post .entry-content p { font-size: 90%; }
 
/* Prettify Subscribe to Comments checkbox - Thanks to http://headwayhq.com */
#commentform p.subscribe-to-comments input#subscribe {
	display: inline;
	vertical-align: text-top; }
 
#commentform p.subscribe-to-comments label { display: inline; }
 
/* End comments checkbox */
div.entry-content ul {
	list-style: disc;
	padding: 0 0 0 35px; }
 
	div.entry-content ul li ul { margin: 5px 0; }
 
		div.entry-content ul li ul li { list-style: circle; }
 
			div.entry-content ul li ul li ul li { list-style: square; }
 
div.entry-content ol {
	list-style: decimal;
	padding: 0 0 0 35px; }
 
	div.entry-content ol li ol { margin: 5px 0; }
 
		div.entry-content ol li ol li { list-style: upper-alpha; }
 
			div.entry-content ol li ol li ol li { list-style: lower-roman; }

div.entry-content ul li {
	list-style: disc;
	margin: 0 0 5px; }
 
div.entry-content ol li {
	list-style: decimal;
	margin: 0 0 5px; }
 
blockquote {
	color: #666;
	font-style: italic;
	padding: 5px 0 5px 26px;
	background: url(../images/blockquote.jpg) no-repeat 0 15px;
	border: 1px dotted #999;
	border-width: 1px 0;
	margin: 10px 0; }
 
em,i { font-style: italic; }
 
.notice {
	background: #FFFFE0;
	border: 1px solid #E6DB55;
	margin: 10px 0;
	padding: 10px; }
 
.drop-cap {
	font-size: 310%;
	line-height: 120%;
	margin-bottom: -0.25em;
	color: #888;
	float: left;
	padding: 0 6px 0 0; }
 
code {
	background: #EAEAEA;
	font-family: Consolas,Monaco,Courier,monospace;
	font-size: 0.9em;
	margin: 0 1px;
	padding: 1px 3px; }
 
.code {
	display: block;
	background: #eee;
	border: 1px solid #ddd;
	color: #555;
	font-family: Consolas,Monaco,Courier,monospace;
	padding: 10px; }
 
.required,.unapproved { color: #aa0000; }
 
div.entry-content ul,div.entry-content ol { margin: 20px 0; }
 
div.entry-content ul ul,
div.entry-content ol ol { margin: 5px 0; }
 
div#nav-below-single { width: 100%; }
 
div#greet_block,div#greet_block div { display: block; }

div.gallery div.content{display:none;float:right;}
div.gallery div.content a, div.gallery div.navigation a{text-decoration:none;color:#777;}
div.gallery div.content a:focus, div.gallery div.content a:hover, div.gallery div.content a:active{text-decoration:underline;}
div.gallery div.controls{margin-top:5px;height:23px;}
div.gallery div.controls a{padding:5px;}
div.gallery div.ss-controls{float:left;}
div.gallery div.nav-controls{float:right;}
div.gallery div.loader{background-image:url('../../images/loading.gif');background-repeat:no-repeat;background-position:center;}
div.gallery div.slideshow{clear:both;}
div.gallery div.slideshow span.image-wrapper{float:left;padding-bottom:12px;}
div.gallery div.slideshow a.advance-link{padding:2px;display:block;border:1px solid #ccc;}
div.gallery div.slideshow img{border:none;display:block;}
div.gallery div.download{float:right;}
div.gallery div.caption{clear:both;border:1px solid #ccc;background-color:#eee;padding:9px;}
div.gallery div.caption p { margin: 5px 0; }
div.gallery ul.thumbs{clear:both;margin:0;padding:0;}
div.gallery ul.thumbs li{float:left;padding:0;margin:5px 10px 5px 0;list-style:none;}
	.thumbnails-right ul.thumbs li{ margin: 5px 0 5px 10px; float: right; }
	div.gallery .navigation { float: left; }
	.thumbnails-left .navigation, .thumbnails-right .content, .thumbnails-left .pagination { float: left; }
	.thumbnails-right .navigation, .thumbnails-left .content, .thumbnails-right .pagination { float: right; }
	.thumbnails-top .navigation { margin: -10px 0 15px; }
	.thumbnails-bottom .navigation { margin: 10px 0 0; }

div.gallery a.thumb{padding:2px;display:block;border:1px solid #ccc;}
div.gallery ul.thumbs li.selected a.thumb{background:#333;}
div.gallery a.thumb:focus{outline:none;}
div.gallery ul.thumbs img{border:none;display:block;}
div.gallery div.pagination{clear:both;}
div.gallery div.navigation div.top{margin-bottom:12px;height:11px;}
div.gallery div.navigation div.bottom{margin-top:12px;}
div.gallery div.pagination a,div.pagination span.current{display:block;float:left;margin-right:2px;padding:4px 7px 2px 7px;border:1px solid #ccc;}
div.gallery div.pagination a:hover{background-color:#eee;text-decoration:none;}
div.gallery div.pagination span.current{font-weight:bold;background-color:#000;border-color:#000;color:#fff;}

.thumbs-min ul.thumbs li{float:none;padding:0;margin:0;list-style:none;}
.thumbs-min a.thumb{padding:0px;display:inline;border:none;}
.thumbs-min ul.thumbs li.selected a.thumb{background:inherit;color:#111;font-weight:bold;}