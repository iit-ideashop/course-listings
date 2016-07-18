<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = new dbConnection();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

if (isset($_POST['submit'])) {
	$db->dbQuery("DELETE FROM Instructions");
	$query = $db->dbQuery('INSERT INTO Instructions VALUES ("' . mysql_real_escape_string(stripslashes($_POST['inst'])) . '")');
	$msg = "<font color='#00FF00'><b>Instructions changed</b></font><br>";
}

$query = $db->dbQuery("SELECT Instructions from Instructions");
$row = mysql_fetch_row($query);
$curInst = $row[0];

?>

<html>
<head><title>IPRO Course Listings</title></head>
<body>
<img src='img/header.png'>
<h2>IPRO Course Listings</h2>
<h5>Content Management System Administration</h5>
<hr>
<a href='admin.php'>Manage Projects</a> | <a href='faculty.php'>Manage Faculty</a> | <a href='disciplines.php'>Manage Disciplines</a> | <a href='instructions.php'>Change Instructions</a>
<br><br>
<h5>Registration Instructions</h5>
<?php 
require_once('globals.php');
 print "$msg"; ?>
<p>Add or change the registration instructions that are displayed to visitors.</p>
<form action='instructions.php' method='post'>
<textarea name='inst' cols='75' rows='20'><?php 
require_once('globals.php');
 print "$curInst"; ?></textarea><br>
<input type='submit' name='submit' value='Submit'>
</form>

</body>
</html>
