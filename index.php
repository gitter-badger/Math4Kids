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
	require_once "/inc/config.inc.php";
	use Tracy\Debugger;
	Debugger::enable();
	$hijack = $template->static_render("hijack");
	$classes = Array(1,2,3);
	$tasks = Array(1,2,3);
	$class_task = $_GET['class'] . $_GET['task'];
	$template->render("header");
	$template->render("nav");

	if(!empty($_SESSION['user']))
	{
		if(isset($_GET['mat4kid']))
		{
			die($hijack);
		}
		else 
		{
			$user = $_SESSION['user'];
			$avatar_source = $_SESSION['avatar'];
			$progress = $_SESSION['progress'];
			$class = $_SESSION['class'];
		}
		if(isset($notif))
		{
			echo $notif;
		}
		if(isset($_GET) && in_array($_GET['class'], $classes) == TRUE && !isset($_GET['task']))
		{
			$template->render("class1");
		}
		else if(isset($_GET) && in_array($_GET['class'], $classes) == TRUE && in_array($_GET['task'], $tasks) == TRUE)
		{
			switch ($class_task) {
    			case 11:
    			case 12:
    			case 13:
    				$template->render("class1_task1");
					$script = "<!-- Task Scripts -->
					<script src=\"/inc/js/pl/tasks.js\"></script>";
					$loader = "set1";
					break;
    			default:
    			$template->render("notfound");
    			break;
			}
		}
		else if (!isset($_GET['class']) && !isset($_GET['task']))
		{
			$template->render("classes");
		}
	}
	else
	{
		$template->render("denied");
	}
	$template->render('scripts');
	if (isset($script)) {echo $script;}
?>
	</body>
</html>

