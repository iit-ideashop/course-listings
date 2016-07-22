<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = dbConnect();

if (!isset($_SESSION['admin']))
die ("You are not logged in.");

if (isset($_POST['deleteDisc'])){ 

	$query = $db->prepare("DELETE FROM Disciplines WHERE Disciplines=?");
	$query->bind_param("s",$_POST['delete']);
	if($query->execute()){
		$msg = "<font color='#00FF00'><b>Item removed</font>";
	} else{	
		$msg = "<font color='#FF0000'><b>Item removal failed!</font>";
	}
	$query->close();
}

if (isset($_POST['add'])) {
	$q = $db->prepare("INSERT INTO Disciplines VALUES (?)");
	$q->bind_param("s",htmlspecialchars(stripslashes($_POST['discName'])));
	if($q->execute()){
	$msg = "<font color='#00FF00'><b>Item added</font>";
	} else {
	$msg = "<font color='#00FF00'><b>Item add failed</font>";
	}
	$q->close();	
}

$query = $db->query("SELECT * FROM Disciplines ORDER BY Disciplines");
$disc = array();
while($row = $query->fetch_row())
	$disc[] = $row[0];
$query->close();
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
	if(isset($msg))
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
