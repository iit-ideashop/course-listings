<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = new dbConnection();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

if (isset($_POST['addFac'])) {
	foreach($_POST as $key => $val)
		$_POST[$key] = mysql_real_escape_string(stripslashes($val));
	$db->dbQuery("INSERT INTO Staff (lName, fName, title, dept, building, room, oTel, rTel, email) VALUES ('{$_POST['lName']}', '{$_POST['fName']}', '{$_POST['title']}', '{$_POST['dept']}', '{$_POST['building']}', '{$_POST['room']}', '{$_POST['oTel']}', '{$_POST['rTel']}', '{$_POST['email']}')");
	$msg = "<font color='#00FF00'><b>Faculty Created</b></font>";
}

if (isset($_POST['editFac'])) {
	$query = $db->dbQuery("SELECT * FROM Staff WHERE id={$_POST['facID']}");
	$editFac = mysql_fetch_array($query);
}
else
	unset($editFac);

if (isset($_POST['editingFac'])) {
	foreach($_POST as $key => $val)
		$_POST[$key] = mysql_real_escape_string(stripslashes($val));
	$db->dbQuery("UPDATE Staff SET fName='{$_POST['fName']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET lName='{$_POST['lName']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET title='{$_POST['title']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET dept='{$_POST['dept']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET building='{$_POST['building']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET room='{$_POST['room']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET oTel='{$_POST['oTel']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET rTel='{$_POST['rTel']}' WHERE id={$_POST['facID']}");
	$db->dbQuery("UPDATE Staff SET email='{$_POST['email']}' WHERE id={$_POST['facID']}");
	$msg = "<font color='#00FF00'><b>Faculty Changed</b></font>";
}

if (isset($_POST['deleteFac'])) {
	$db->dbQuery("DELETE FROM Staff WHERE id={$_POST['facID']}");
	$msg = "<font color='#00FF00'><b>Faculty Deleted</b></font>";
}

$query = $db->dbQuery("SELECT * FROM Staff ORDER BY lName");
$faculty = array();
while ($row = mysql_fetch_array($query))
	$faculty[] = $row;

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
<h5>Manage Faculty</h5>
<?php 
require_once('globals.php');
 print "$msg"; ?>
<p>Add, Edit and Remove Faculty from Listing</p>
<form action='faculty.php' method='post'>
<table width='100%'><tr>
<td><b>Edit Faculty</b><br><select name='facID' size='15'>
<?php 
require_once('globals.php');

foreach ($faculty as $entry)
	print "<option value='{$entry['id']}'>{$entry['lName']}, {$entry['fName']}</option>";
?>
</select><br><input type='submit' name='editFac' value='Edit'></td></form>
<form action='faculty.php' method='post'>
<?php 
require_once('globals.php');
 

if (!isset($editFac)) {

?>

<td valign='top'><b>Add New Faculty</b><br>
First Name:<br>
<input type='text' name='fName'><br><br>
Last Name:<br>
<input type='text' name='lName'><br><br>
Title:<br>
<input type='text' name='title'><br><br>
<input type='submit' name='addFac' value='Add Faculty'></td>
<td valign='top'><br>
Department:<br>
<input type='text' name='dept'><br><br>
Building:<br>
<input type='text' name='building'><br><br>
Room:<br>
<input type='text' name='room'></td>
<td valign='top'><br>
Office Phone:<br>
<input type='text' name='oTel'><br><br>
Other Phone:<br>
<input type='text' name='rTel'><br><br>
Email:<br>
<input type='text' name='email'>
</td></tr>

<?php 
require_once('globals.php');

}

else {

?>

<td valign='top'><b>Editing Faculty</b><br>
First Name:<br>
<input type='text' name='fName' value='<?php 
require_once('globals.php');
 print "{$editFac['fName']}"; ?>'><br><br>
Last Name:<br>
<input type='text' name='lName' value='<?php 
require_once('globals.php');
 print "{$editFac['lName']}"; ?>'><br><br>
Title:<br>
<input type='text' name='title' value='<?php 
require_once('globals.php');
 print "{$editFac['title']}"; ?>'><br><br>
<input type='submit' name='editingFac' value='Edit Faculty'>&nbsp;&nbsp;&nbsp;<input type='submit' name='deleteFac' value='Delete'></td>
<td valign='top'><br>
Department:<br>
<input type='text' name='dept' value='<?php 
require_once('globals.php');
 print "{$editFac['dept']}"; ?>'><br><br>
Building:<br>
<input type='text' name='building' value='<?php 
require_once('globals.php');
 print "{$editFac['building']}"; ?>'><br><br>
Room:<br>
<input type='text' name='room' value='<?php 
require_once('globals.php');
 print "{$editFac['room']}"; ?>'></td>
<td valign='top'><br>
Office Phone:<br>
<input type='text' name='oTel' value='<?php 
require_once('globals.php');
 print "{$editFac['oTel']}"; ?>'><br><br>
Other Phone:<br>
<input type='text' name='rTel' value='<?php 
require_once('globals.php');
 print "{$editFac['rTel']}"; ?>'><br><br>
Email:<br>
<input type='text' name='email' value='<?php 
require_once('globals.php');
 print "{$editFac['email']}"; ?>'>
<input type='hidden' name='facID' value='<?php 
require_once('globals.php');
 print "{$editFac['id']}"; ?>'>
</td></tr>

<?php 
require_once('globals.php');
 

}

?>
</table>
</form>

</body>
</html>
