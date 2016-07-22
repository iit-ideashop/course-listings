<?php 
require_once('globals.php');
require_once('password_compat.php');
require_once("classes/db.php");

session_start();

$db = dbConnect();

if (isset($_POST['login'])) {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$stmt = $db->prepare("SELECT Password FROM Login WHERE Username=?");
		$stmt->bind_param("s",$_POST['username']);
		$stmt->execute();
		$res = $stmt->get_result();
		$hash = $res->fetch_row();
		if (isset($hash[0])) {
			if (password_verify($_POST['password'], $hash[0])) {
				//grant access
				$_SESSION['admin'] = true;
				$_SESSION['username'] = $_POST['username'];
				header("Location: admin.php");
			} else {
				error_log("LOGINFAIL: Invalid password for user ".$_POST['username']);
				$error = "Access Denied";
			}
		}
		else{
			error_log("LOGINFAIL: No such user ".$_POST['username']);
			$error = "Access Denied";
		}
	}
	else
		$error = "You did not specify a username and/or password";
} else if(isset($_GET['logout'])){
	$error = "Logout successful";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>IPRO Course Listings CMS</title></head>
<body>
<div><img src='img/header.png' alt='IPRO'></div>
<h2>IPRO Course Listings</h2>
<h5>Content Management System</h5>
<hr>
<form action='login.php' method='post'><fieldset><legend>Login</legend>
<?php if(isset($error)) { echo "<p style=\"font-weight: bold; color: red\">$error</p>"; } ?>
<label for='username'>Login:</label><input name='username' id='username' type='text' size='20'><br>
<label for='password'>Password:</label><input name='password' id='password' type='password' size='20'><br>
<input type='submit' name='login' value='Login'>
</fieldset></form>
</body>
</html>
