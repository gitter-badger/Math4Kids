<?php
if(!defined('mat4kid_usage')) {
   die('Hacking failed :)');
}
$config = Array(
	// production DB -> "s3.atthost.pl","914_mat4kid","ULm3Gdvq4QRHWbfe5uJt6SEk","914_mat4kid"
	'db' => (object) Array(
		'host' => 'localhost',
		'user' => 'root',
		'pass' => '',
		'base' => 'mat4kideu'
		),
	'canonical' => 'https://localhost'
	);
global $config;
?>