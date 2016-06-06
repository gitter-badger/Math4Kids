<?php
	session_name("mat4kid");
	session_start();
	header('x-xss-protection: 1; mode=block');
	header("Content-Security-Policy: frame-ancestors 'none'");
	define('mat4kid_usage', TRUE);
	$login_page = "/login/";
	$login = $loginbox = $meta = null;
	require_once "/inc/functions.inc.php";
	require_once "/inc/templates.inc.php";
	require_once "/inc/nette.phar";
	require_once "/inc/config.inc.php";
	global $mat4kid, $template;
	use Tracy\Debugger;
	Debugger::enable();
	if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['logout'] == "true" && isset($_SESSION['user']))
	{
		unset($_SESSION);
		session_destroy();
		session_regenerate_id(true);
		$login = $mat4kid->notification("Successfully logged out" ,"success center");
		$meta = "login";
		$loginbox = "hidden";
	}
	if(isset($_SESSION['user'])) 
	{
		$login = $mat4kid->notification("You are already logged in. You do not need to relogin now! If you want to login as a other person, click \"Logout\" button!", "danger center");
		$session_started = "disabled";
		$meta = "login";
		$loginbox = "hidden";
	}
	if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
	$pass = $_POST['pass'];
	$user = $_POST['user'];
	if (!$mat4kid->regex('username', $user)){
		$login = $mat4kid->notification("Username can contain: <b> letters, digits , -, _, .</b> and should have from 3 to 18 characters!", "danger center");
	}
	elseif (!$mat4kid->regex('password', $pass))
	{
		$login = $mat4kid->notification("Password can contain: <b> letters, digits, @, *, #, !, \, ., /, , ','</b> and should have from 6 to 28 characters!", "danger center");	
	}
	else 
	{
		$getdata = $mat4kid->dbq("SELECT * FROM `users` WHERE `nick`='$user'");
		$data = $getdata->fetch_assoc();
		if ($mat4kid->pass_verify($pass, $data['hash'], $data['salt']) === FALSE)
		{
			$login = $mat4kid->notification("Password or Username mismatch", "danger center");
		}
		else
		{
			session_set_cookie_params(21900, "/", "localhost", false, true);
			session_name("mat4kid");
			session_regenerate_id(true);
			$_SESSION['ip_address'] = md5($_SERVER['REMOTE_ADDR']);
			$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$login = $mat4kid->notification("Logged in successfully! Warping to dashboard!", "success center");
			$loginbox = "hidden";
			$_SESSION['user'] = $user;
			$_SESSION['gid'] = $data['gid'];
			$_SESSION['avatar'] = $data['avatar'];
			$_SESSION['completed'] = $data['completed'];
			$_SESSION['achievements'] = $data['achievements'];
			$_SESSION['class'] = $data['class'];
			$_SESSION['register'] = $data['time'];
			$meta = "login";
		}
	};
}
$template->render("header");
?>
</nav>
<div class="container">
		<div class="row">
		<div class="col-md-offset-4 col-md-4 center">
		<div class="loginbox  <?php if(isset($loginbox)){echo $loginbox;}?>">
		<form class="center" action="<?=$login_page?>" method="post" >
		<div class="input-group"><span class="input-group-addon typcn typcn-user"></span><input class="input form-control" type="text" name="user" id="user" placeholder="Nick"></div><br>
		<div class="input-group"><span class="input-group-addon typcn typcn-key"></span><input class="input form-control" type="password" name="pass" id="pass" placeholder="Password"><span class="input-group-addon typcn typcn-eye" id="show-pass"></span></div><br>
		<input type="submit" class="btn btn-block" value="Log In">
		<a href="/register/" class="btn btn-success btn-block">Sign In</a><br>
		</form>
		</div>
		</div>
		</div>
		<?php if(isset($login)){echo $login;}?>
		</div>
		</div>
		<?php $template->render("scripts");?>
		<script>
		var state = 0;
		$('#show-pass').click(function(){
			if (state == 0)
			{
				$(this).addClass("typcn-eye-outline").removeClass("typcn-eye");
				$('#pass').attr("type", "text");
				++state; 
			}
			else 
			{
				$(this).removeClass("typcn-eye-outline").addClass("typcn-eye");
				$('#pass').attr("type", "password");
				--state;
			}
		});
		</script>
	</body>
</html>
