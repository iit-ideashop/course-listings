<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = new dbConnection();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

if (isset($_POST['deleteDisc'])) {
	$db->dbQuery("DELETE FROM Disciplines WHERE Disciplines='".mysql_real_escape_string(stripslashes($_POST['delete']))."'");
	$msg = "<font color='#00FF00'><b>Item removed</font>";
}

if (isset($_POST['add'])) {
	$db->dbQuery("INSERT INTO Disciplines VALUES (".mysql_real_escape_string(stripslashes($_POST['discName']))."')");
	$msg = "<font color='#00FF00'><b>Item added</font>";
}

$query = $db->dbQuery("SELECT * FROM Disciplines ORDER BY Disciplines");
$disc = array();
while($row = mysql_fetch_row($query))
	$disc[] = $row[0];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>IPRO Course Listings</title></head>
<body>
<div><img src="img/header.png" alt="IPRO"></div>
<h2>IPRO Course Listings</h2>
<h5>Content Management System Administration</h5>
<hr>
<p><a href="admin.php">Manage Projects</a> | <a href="faculty.php">Manage Faculty</a> | <a href="disciplines.php">Manage Disciplines</a> | <a href="instructions.php">Change Instructions</a></p>
<h5>Manage Disciplines</h5>
<?php 
require_once('globals.php');
 echo $msg; ?>
<p>Add and Remove Items from Discipline Listing</p>
<form action="disciplines.php" method="post"><fieldset><legend>Manage Disciplines</legend>
<table width="60%"><tr>
<td><label><b>Remove Discipline</b><br><select name="delete" size="12">
<?php 
require_once('globals.php');

foreach ($disc as $entry)
	print "<option value=\"$entry\">$entry</option>";
?>
</select></label><br><input type="submit" name="deleteDisc" value="Remove"></td>
<td valign="top"><label><b>Add New Discipline</b><br><input type="text" name="discName"></label>&nbsp;&nbsp;&nbsp;<input type="submit" name="add" value="Add Discipline"></td></tr>
</table></fieldset>
</form>

</body>
</html>
