<?php
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=".str_replace(' ', '_', get_bloginfo('name')).".hwstyle");
header("content-type: text/plain");
header("Content-Transfer-Encoding: binary");

$element_styling = headway_get_element_styles();

echo headway_json_encode($element_styling);