<?php
	session_name("mat4kid");
	session_start();
	$register_page = "/register/";
	$register = null;
	header('x-xss-protection: 1; mode=block');
	header("Content-Security-Policy: frame-ancestors 'none'");
	define('mat4kid_usage', TRUE);
	require_once "/inc/functions.inc.php";
	require_once "/inc/nette.phar";
	require_once "/inc/templates.inc.php";
	require_once "/inc/config.inc.php";
	use Tracy\Debugger;
	Debugger::enable();
	function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = '';
 
    return $ipaddress;
}
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
/*	    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
        //your site secret key
        $secret = '6LfMgh8TAAAAAHuQ4P9z0-akQsnZ-VEnAv2HdoFf';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if ($responseData->success) { */
	$mat4kid = new mat4kid;
	$pass = $_POST['pass'];
	$user = $_POST['user'];
	$v_pass = $_POST['v_pass'];
	$bot_detector = $_POST['e-mail'];
	$avatar_val = htmlspecialchars($_POST['avatar_url']);
	$ip = get_client_ip_server(); 
		if (!empty($bot_detector))
	{
		file_put_contents(".htaccess", "\nDeny from {$ip}", FILE_APPEND);
		file_put_contents("logs/banned.log", "\n". date("[H:i:s Y-m-d]", time()) . "| IP: {$ip} | Reason: Used a 'e-mail' fake field. | Nick: {$user} | Password: {$pass} | E-mail: {$bot_detector} | Avatar: {$avatar_val} | reCAPTCHA ok? : {$responseData->success}", FILE_APPEND);
		die($mat4kid->error("Sorry, bots not allowed also here! You are banned! IP: {$ip}. Please contact with support in 48 hours if you think it's a mistake!"));
	}
	if (!$mat4kid->regex('username', $user)){
		$login = $mat4kid->notification("Username can contain: <b> letters, digits , -, _, .</b> and should have from 3 to 18 characters!", "danger center");
	}
	elseif (!$mat4kid->regex('password', $pass) || !$mat4kid->regex('password', $v_pass))
	{
		$login = $mat4kid->notification("Password can contain: <b> letters, digits, @, *, #, !, \, ., /, , ','</b> and should have from 6 to 28 characters!", "danger center");	
	}
	else {
		$usernamefree = $mat4kid->dbq("SELECT `nick` FROM `users` WHERE `nick`='$user'");
		$user_free = $usernamefree->fetch_assoc();
		if ($user_free['nick'] !== NULL || $user_free['nick'] != ""){
			$login = $mat4kid->notification("Username already taken!", "danger center");
		} else {
		if (($pass == $v_pass) === FALSE){
			$login = $mat4kid->notification("Passwords are different!", "danger center");
		} else {
			$avatar_url = "/inc/res/avatars/".$avatar_val.".png";
			$salt = $mat4kid->pass_salt($user);
			$hash = $mat4kid->pass_hash($pass, $salt);
			$mat4kid->dbq("INSERT INTO `users` (nick, hash, salt, avatar, gid, class, progress, money, achievements) VALUES ('$user', '$hash', '$salt', '$avatar_url', '1', '0', '0', '10', 'a')"); // "a" achivement - 1st, for registering in mat4kid :)
			$login = $mat4kid->notification("Account sucessfully created:<br><b>Username:</b> $user<br><b>Password:</b> $pass", "success center");
			$login .= $mat4kid->notification("Please note that your account can't be recovered if you lose your password!", "danger center");
			}
		}
	}
}
/*else
{
	$login = $mat4kid->notification("reCAPTCHA challenge failed! Please re-do it!", "danger center");	
}
}
else
{
	$login = $mat4kid->notification("Please do reCAPTCHA challenge first!", "danger center");
} */

$template->render("header");
?>
		</nav>
		<div class="container">
		<div class="row">
		<div class="col-md-offset-4 col-md-4">
		<div class="registerbox">
		<form action="<?=$register_page?>" method="post">
		<div class="input-group hide"><span class="input-group-addon typcn typcn-eye"></span><input class="input form-control" type="text" name="e-mail" id="e-mail" placeholder="Your e-mail"></div>
		<div class="input-group"><span class="input-group-addon typcn typcn-user"></span><input class="input form-control" type="text" name="user" id="user" placeholder="Nick"></div><br>
        <div class="input-group"><span class="input-group-addon typcn typcn-key"></span><input class="input form-control" type="password" name="pass" id="pass" placeholder="Password"></span></div><br>
		<div class="input-group" id="v_password"><span class="input-group-addon typcn typcn-key-outline"></span><input class="input form-control" type="password" name="v_pass" id="pass" placeholder="Retype password from field above" minlength="6" maxlength="32"></div><br>
		<div class="input-group"><span class="input-group-addon">Avatar</span>
		<select id="avatarselect" name="avatar_url">
        <option value="default" data-imagesrc="/inc/res/avatars/default.png"></option>
        <option value="girl" data-imagesrc="/inc/res/avatars/girl.png"></option>
        <option value="panda" data-imagesrc="/inc/res/avatars/panda.png"></option>
    	</select>
    	</div> 
    	<br>
      	<div class="g-recaptcha" data-sitekey="6LfMgh8TAAAAAJgF0CnJWPNNKRNH_8kZs0MqpCBh"></div>
      	<br>
		<input type="submit"  class="btn btn-block" value="Sign In">
		<a href="/login/" class="btn btn-success btn-block">Log In</a><br>
		</form>
		</div>
		</div>
		</div>
		<?php if(isset($login)){echo "<br>\n" . $login;}?>
		</div>
		<?php $template->render("scripts");?>
		<script>
		$('#avatarselect').ddslick({
		selectText: "Choose avatar",
		width: "100%"
    	});
		</script>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</html>