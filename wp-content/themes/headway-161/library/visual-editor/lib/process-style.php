<?php
$handle = fopen($_GET['path'], "rb");
$contents = fread($handle, filesize($_GET['path']));

echo $contents;

fclose($handle);
@unlink($_GET['path']);