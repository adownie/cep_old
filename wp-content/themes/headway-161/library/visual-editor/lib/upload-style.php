<?php
if (!empty($_FILES)) {
	
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = str_replace(strstr(realpath(__FILE__), 'wp-content'), '', realpath(__FILE__)).'/wp-content/uploads/';
	
	$fileName = md5(uniqid(rand(), true)).'.hwstyle';
	
	$targetFile = str_replace('//','/',$targetPath) . $fileName;
	
	move_uploaded_file($tempFile,$targetFile);
	echo $targetFile;

}
else {
	echo $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
}