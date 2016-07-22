<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = dbConnect();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

if (isset($_POST['addFac'])) {
	foreach($_POST as $key => $val)
		$_POST[$key] = htmlspecialchars(stripslashes($val));
	$query = $db->prepare("INSERT INTO Staff (lName, fName, title, dept, building, room, oTel, rTel, email) VALUES (?,?,?,?,?,?,?,?,?)");
	$query = $db->bind_param("sssssssss",$_POST['lName'], $_POST['fName'], $_POST['title'], $_POST['dept'], $_POST['building'], $_POST['room'], $_POST['oTel'], $_POST['rTel'], $_POST['email']);
	if($query->execute()){
		$msg = "<font color='#00FF00'><b>Faculty Created</b></font>";
	} else {
		$msg = "<font color='#FF0000'><b>Error! Faculty NOT created.</b></font>";
	}
	$qres->close();
	$query->close();
}

if (isset($_POST['editFac'])) {
	$query = $db->prepare("SELECT * FROM Staff WHERE id=?");
	$query->bind_param("i",$_POST['facID']);
	$query->execute();
	$qres = $query->get_result();
	$editFac = $qres->fetch_array();
	$qres->close();
	$query->close();
}
else
	unset($editFac);

if (isset($_POST['editingFac'])) {

	foreach($_POST as $key => $val)
		$_POST[$key] = htmlspecialchars(stripslashes($val));
	$query = $db->prepare("UPDATE Staff SET lName=?, fName=?, title=?, dept=?, building=?, room=?, oTel=?, rTel=?, email=? WHERE id=?");
	$query = $db->bind_param("sssssssssi",$_POST['lName'], $_POST['fName'], $_POST['title'], $_POST['dept'], $_POST['building'], $_POST['room'], $_POST['oTel'], $_POST['rTel'], $_POST['email'], $_POST['facID']);
	if($query->execute()){
		$msg = "<font color='#00FF00'><b>Faculty edited successfully</b></font>";
	} else {
		$msg = "<font color='#FF0000'><b>Error! Faculty NOT edited!</b></font>";
	}
	$qres->close();
	$query->close();
}

if (isset($_POST['deleteFac'])) {
	$query = $db->prepare("DELETE FROM Staff WHERE id=?");
	$query->bind_param("i",$_POST['facID']);
	if($query->execute()){
		$msg = "<font color='#00FF00'><b>Faculty Deleted</b></font>";
	} else{
		$msg = "<font color='#FF0000'><b>Faculty Deleted</b></font>";
	}
	$query->close();
}

$query = $db->query("SELECT * FROM Staff ORDER BY lName");
$faculty = array();
while ($row = $query->fetch_array())
	$faculty[] = $row;

$query->close();
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
if(isset($msg)) 
print "$msg"; ?>
<p>Add, Edit and Remove Faculty from Listing</p>
<form action='faculty.php' method='post'>
<table width='100%'><tr>
<td><b>Edit Faculty</b><br><select name='facID' size='15'>
<?php 

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

}

else {

?>

<td valign='top'><b>Editing Faculty</b><br>
First Name:<br>
<input type='text' name='fName' value='<?php 
 print "{$editFac['fName']}"; ?>'><br><br>
Last Name:<br>
<input type='text' name='lName' value='<?php 
 print "{$editFac['lName']}"; ?>'><br><br>
Title:<br>
<input type='text' name='title' value='<?php 
 print "{$editFac['title']}"; ?>'><br><br>
<input type='submit' name='editingFac' value='Edit Faculty'>&nbsp;&nbsp;&nbsp;<input type='submit' name='deleteFac' value='Delete'></td>
<td valign='top'><br>
Department:<br>
<input type='text' name='dept' value='<?php 
 print "{$editFac['dept']}"; ?>'><br><br>
Building:<br>
<input type='text' name='building' value='<?php 
 print "{$editFac['building']}"; ?>'><br><br>
Room:<br>
<input type='text' name='room' value='<?php 
 print "{$editFac['room']}"; ?>'></td>
<td valign='top'><br>
Office Phone:<br>
<input type='text' name='oTel' value='<?php 
 print "{$editFac['oTel']}"; ?>'><br><br>
Other Phone:<br>
<input type='text' name='rTel' value='<?php 
 print "{$editFac['rTel']}"; ?>'><br><br>
Email:<br>
<input type='text' name='email' value='<?php 
 print "{$editFac['email']}"; ?>'>
<input type='hidden' name='facID' value='<?php 
 print "{$editFac['id']}"; ?>'>
</td></tr>

<?php 
}

?>
</table>
</form>

</body>
</html>
