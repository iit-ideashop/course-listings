<?php
require_once('config.php');
function dbConnect() {
	global $db_name, $db_user, $db_pass;
	$dbConn = new mysqli("localhost", $db_user, $db_pass, $db_name);
	if ($dbConn->connect_errno) {
		echo "Failed to connect to MySQL: (" . $dbConn->connect_errno . ") " . $dbConn->connect_error;
	}
	return $dbConn;
}
?>
