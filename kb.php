<?php
require_once 'tpl/header.m4k';
require "inc/parsedown.inc.php";
$pd = new Parsedown();
	if ($_GET['art'] == "cookies")
	{
		$file = file_get_contents("kb_files/cookies.md");
   		echo $pd->text($file);
	}
	else
	{
		$file = file_get_contents("kb_files/index.md");
   		echo $pd->text($file);	
	}
?>