<?php
if(!defined('mat4kid_usage')) {
   die('Hacking failed :)');
}

class mat4kid {
	/*
	 *	CONSTRUCT
	 *  
	 *	INCLUCE HERE CFG FILE ALSO!
	 *
	 */
	public function __construct() {
	}
	/**
	 *	DATABASE QUERY
	 *  
	 *	@param string
	 *
	 *	EXECUTE QUERY ENTERED IN @param  
	 *
	 */
	public function dbq($query) {
		$db = new mysqli("localhost", "root", "", "mat4kideu");
		if ($db->connect_error) 
		{
			die($this->error("Connect error: {$db->connect_error()}"));
		}
		else
		{
		$result = $db->query("$query");
		if (!$result === TRUE) {
			die($this->error("Query error: $db->error()"));
		}
		else
		{
		$db->close();
		}
		return $result;
		}
	}
	/**
	 *	DATABASE CONNECT
	 * 
	 *	CONNECT WITH DATABASE - TODO - DEPRECATED 
	 *
	 */
	public function db() {
		$db = new mysqli("****","****","****","****");
		if ($db->connect_error) 
		{
			die();
		}
		$db->close();
	}
	/**
	 *	GENERATE SALT
	 *  
	 *	@param string
	 *
	 *	SALT @param USING 'ADLER32' HASH 
	 *
	 */
	public function pass_salt($user) {
		// generate salt using adler32 hash f.e: (( user1_mat4kid )) salt it
		if (!empty($user))
		{
			$salt = hash("adler32",$user . "_mat4kid");
			return $salt;
		}
		else
		{
			die($this->error("Salt generator error. \$User not specified!"));
		}
	}
	/**
	 *	HASH PASSWORD
	 *  
	 *	@param string
	 *	@param string
	 *
	 *	HASH PASSWORD FROM @param WITH @param AS A SALT
	 *
	 */
	public function pass_hash($password, $salt) {
		// hash password using sha512 & salt
		if (!empty($password) || !empty($salt))
		{
			$password = hash("sha512", $salt . $password);
			return $password;
		}
		else
		{
			die($this->error("Password hasher error. \$Password/\$Salt not specified!"));
		}
	}
	/**
	 *	VERIFY PASSWORD
	 *  
	 *	@param string
	 *	@param string
	 *	@param string
	 *
	 *	VERIFY @param AND COMPARE IT WITH @param AND @param  
	 *
	 */
	public function pass_verify($password, $hash, $salt) {
		// verify password with input, hash & salt from database
		$rehash = hash("sha512",$salt . $password);
		if (!empty($password) || !empty($hash) || !empty($salt))
		{
			if (($hash === $rehash) === TRUE) 
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			die($this->error("Password verifier error. \$Password/\$Hash/\$Salt not specified!"));
		}
	}
	/**
	 *	SHOW NOTIFICATION
	 *  
	 *	@param string
	 *	@param string
	 *
	 *	SHOW NOTIFICATION  
	 *
	 */
	public function notification($text, $variant) {
		//shows notification like "Successfully logged out!"; "Username/Password does not match"
		$variants = array('success', 'danger', 'danger center', 'success center');
		if (!in_array($variant, $variants))
		{
			$go = "<div class=\"alert alert-danger\">" . "A variant of notification: <font color=yellow>" . $variant . "</font> not found! Available variants: <b>" . implode(", ", $variants) . "</b></div>";
		}
		else
		{
			$go = "<div class=\"alert alert-{$variant}\">" . $text . "</div>";
		}
		return $go;
	}
	/**
	 *	SHOW ERROR
	 *  
	 *	@param string
	 *
	 *	SHOW NOTIFICATION  
	 *
	 */
	public function error($text) {
		//displays an error (f.e in die())
		if (!empty($text))
		{
			$go = "<div style=\"color: red; background: black; padding:1em; border: 1px solid crimson; \">" . $text . "</div>";
		}
		else
		{
			$go = false;
		}
		return $go;
	}
	/**
	 *	REGULAR EXPRESSION CHECKER
	 *  
	 *	@param string
	 *	@param string
	 *
	 *	MATCH A STRING USING REGEX
	 *
	 */
	public function regex($type, $subject){
		// regex library
		$types = array(
			'username' => '/^(?=.{3,18}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/',
			'password' => '/^[0-9A-Za-z!@#$%*]{8,28}$/'
		);
		$pattern = $types[$type];
		if(preg_match($pattern, $subject))
		{
			return true;
		} 
		else
		{
			return false;
		}
	}
}
$mat4kid = new Mat4Kid;
global $mat4kid;
?>