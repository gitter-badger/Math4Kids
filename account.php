<?php
	session_name("mat4kid");
	session_start();
	header('x-xss-protection: 1; mode=block');
	header("Content-Security-Policy: frame-ancestors 'none'");
	global $template, $mat4kid;
	$login_page = "login.php";
	$login = null;
	define('mat4kid_usage', TRUE);
	require_once "/inc/functions.inc.php";
	require_once "/inc/nette.phar";
	require_once "/inc/templates.inc.php";
	die($mat4kid->error("Database connection ened unexpectedly!"));
	use Tracy\Debugger;
	Debugger::enable();
	// TODO whole account page :)
	$template->render('header');
	$template->render('nav');
	$account = $_SESSION;
	echo $account['time'];
?>

