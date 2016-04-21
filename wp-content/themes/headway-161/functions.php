<?php
/**
 * Defines all of the Headway paths and loads all necessary files.
 *
 * @package Headway
 * @author Clay Griffiths
 */

define('THEME_FRAMEWORK', 'headway');
define('HEADWAYVERSION', '1.6.1');
define('HEADWAYROOT', TEMPLATEPATH);
define('HEADWAYLIBRARY', HEADWAYROOT.'/library');
define('HEADWAYADMIN', HEADWAYLIBRARY.'/admin');
define('HEADWAYCORE', HEADWAYLIBRARY.'/core');
define('HEADWAYLEAFS', HEADWAYLIBRARY.'/leafs');
define('HEADWAYWIDGETS', HEADWAYLIBRARY.'/widgets');
define('HEADWAYCUSTOM', HEADWAYROOT.'/custom');
define('HEADWAYEDITOR', HEADWAYLIBRARY.'/visual-editor');
define('HEADWAYMEDIA', HEADWAYROOT.'/media');
define('HEADWAYCACHE', HEADWAYMEDIA.'/cache');
define('HEADWAYFOLDER', basename(get_bloginfo('template_url')));
define('HEADWAYURL', get_bloginfo('template_url'));

require_once HEADWAYCORE.'/core-data-handling.php';
require_once HEADWAYCORE.'/core-extend.php';
require_once HEADWAYCORE.'/core-functions.php';
require_once HEADWAYCORE.'/core-leafs.php';
require_once HEADWAYCORE.'/core-generator.php';
require_once HEADWAYCORE.'/core-triggers.php';


require_once HEADWAYCORE.'/core-installation.php';

require_once HEADWAYCORE.'/core-elements.php';

require_once HEADWAYCORE.'/core-upgrade.php';


if(!is_admin()){
	require_once HEADWAYEDITOR.'/visual-editor.php';
} else {
	require_once HEADWAYADMIN.'/admin.php';
}


require_once HEADWAYCORE.'/core-navigation.php';
require_once HEADWAYCORE.'/core-posts.php';
require_once HEADWAYCORE.'/core-filters-actions.php';
require_once HEADWAYCORE.'/core-layout.php';
require_once HEADWAYCORE.'/core-head.php';
require_once HEADWAYCORE.'/core-css-classes.php';
require_once HEADWAYCORE.'/core-comments.php';
require_once HEADWAYCORE.'/core-twitter.php';


require_once HEADWAYWIDGETS.'/functions.php';

function navigation_start() {
    return '<h3 class="toc_header"><a href="/articles/estate-planning-101">Lessons in Estate Planning 101:</a></h3><ol class="toc_links">';
}

function navigation_end() {
    return '</ol>';
}

function navigation_layout($selected, $page_url, $page_name) {
global $nav_counter;
    $nav_counter++;

    if ($nav_counter == 1) return;
    return '<li '.(($selected)?'class="selected"':'').'><a href="'.$page_url.'">'.$page_name.'</a></li>';
}

function naivgation_prev($page_url, $page_name) {

    if (!$page_name) return;
    return '<li class="navigation-left"><a href="'.$page_url.'">  '.$page_name.'</a></li>';
}

function naivgation_next($page_url, $page_name) {
    if (!$page_name) return;
    return '<li class="navigation-right"><a href="'.$page_url.'">  '.$page_name.'</a></li>';
}

function navigation_controls($controls) {
    return '<ul class="top-nav">'.$controls.'</ul><div style="padding: 20px"></div>';
}

function get_navigation() {
    global $post;
    global $nav_counter;
    $nav_counter = 0;
    $current_post = $post;
  //  if ($post->ID != 75) return;
   // echo $post->ID;
    $args = array('child_of' => $post->ID, 'sort_order' => 'ASC', 'sort_column' => 'menu_order');
    if (count($post->ancestors) == 2) {
        $args = array('child_of' => $post->ancestors[0], 'sort_order' => 'ASC', 'sort_column' => 'menu_order');
        $post = get_post($post->ancestors[0]);
    }
    $p = get_pages( $args );
    if (!$p) return;
    $buffer = navigation_start();
    $buffer .= navigation_layout(($post->ID == $current_post->ID), get_permalink($post), $post->post_title);
    if ($post->ID == $current_post->ID) {
        $navi_next = naivgation_next(get_permalink($p[0]), $p[0]->post_title);
    }
    $i = 0;
    foreach ($p as $page) {
        if (($page->ID == $current_post->ID)) {
            if (!$navi_prev) {
                if ($i == 0) $navi_prev = naivgation_prev(get_permalink($post), $post->post_title); else
                $navi_prev = naivgation_prev(get_permalink($p[$i-1]), $p[$i-1]->post_title);
            }
            if (!$navi_next) $navi_next = naivgation_next(get_permalink($p[$i+1]), $p[$i+1]->post_title);
        }
        $buffer .= navigation_layout(($page->ID == $current_post->ID), get_permalink($page), $page->post_title);
        $i++;
    }
    $buffer .= navigation_end();
    if ($navi_next || $navi_prev) {
        $buffer = navigation_controls($navi_prev.$navi_next).$buffer;
    }
    
    
    echo $buffer;
}