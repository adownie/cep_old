<?php

function valid ($email)
{
    return (bool) preg_match('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD', (string) $email);
}

if ($_POST)
{
	require_once('MCAPI.class.php');
	$api = new MCAPI('dcb20422e161c66f88f4372312198aee-us1');
	
	$list_id = "8ee3f893c7";
    
    
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $email = $_POST['your-email'];
    }
    
    if (isset($_POST['author'])) {
        $name = $_POST['author'];
    } else if (isset($_POST['your-name'])) {
        $name = $_POST['your-name'];
    }
    
    $fname = '';
    $lname = '';
    
    if (isset($name)) {
        list($fname, $lname) = explode(' ', $name, 2);
    }
    
    $merge_vars = array('FNAME' => $fname, 'LNAME'=> $lname);

	if ($api->listSubscribe($list_id, $email, $merge_vars) === true) {
        $json['success'] = true;  
	} else {
	    echo 'Error: ' . $api->errorMessage;
        $json['error'] = true;
	}
	
    echo json_encode($json);
} 

