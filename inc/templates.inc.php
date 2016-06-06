<?php
if (!defined("mat4kid_usage")) {
	die("Hacking failed!");
}
class Template 
{
	/**
	 *	RENDER TEMPLATE
	 *  
	 *	@param string
	 *
	 *	RENDERS TEMPLATE AS A REQUIRE_ONCE 
	 *
	 */
	public function render($tpl) 
	{
		if(preg_match("/[a-zA-z]/", $tpl) && file_exists("tpl/{$tpl}.m4k"))
		{
			eval("require_once \"tpl/$tpl.m4k\";");
		}
		else 
		{
			die("Fatal error occured!");
		}
	}
	/**
	 *	RENDER STATIC TEMPLATE
	 *  
	 *	@param string
	 *
	 *	RENDERS STATIC TEMPLATE AS A REQUIRE_ONCE 
	 *
	 */
	public function static_render($stpl)
	{
		if(preg_match("/[a-zA-z]/", $stpl) && file_exists("tpl/$stpl.s4k"))
		{
			$value = file_get_contents("tpl/$stpl.s4k");
			return $value;
		}
		else 
		{
			die("Fatal error occured!");
		}
	}
}
$template = new Template;
global $template;
?>