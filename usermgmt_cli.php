<?php
if(php_sapi_name() != 'cli') {
  die("This tool may only be run via the command line");
}

function usage(){
	global $argv;
	echo("User management usage: ".$argv[0]." useradd|userdel|userlist <username>");
}
if($argc < 2){
	usage();
}
require('classes/db.php');
require('password_compat.php');
$db = dbConnect();
switch($argv[1]){
	case "useradd":
		if($argc != 3)
			usage();
		$pass = readline("Enter password for new user: ");
		$stmt = $db->prepare("INSERT INTO Login VALUES (?, ?, 'Administrator')");
		$stmt->bind_param("ss",$argv[2],password_hash($pass,PASSWORD_DEFAULT));
		if($stmt->execute()){
			echo("User added successfully");
		} else {
			echo("User add failed!");
		}
	break;
	case "userdel":
		if($argc != 3)
			usage();
		$stmt = $db->prepare("DELETE FROM Login WHERE Username=?");
		$stmt->bind_param("s",$argv[2]);
		if($stmt->execute()){
			echo("User removed successfully");
		} else {
			echo("User removal failed!");
		}
	break;
	case "userlist":
		$stmt = $db->query("SELECT Username FROM Login");
		print_r($stmt->fetch_all(MYSQLI_ASSOC));
	break;
	default:
		usage();
}
echo("\n");
?>
