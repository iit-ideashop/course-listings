<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = dbConnect();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

if (isset($_POST['submit'])) {
	$db->query("DELETE FROM Instructions");
	$query = $db->prepare('INSERT INTO Instructions VALUES (?)');
	$query->bind_param("s",$_POST['inst']);
	if($query->execute()){
	$msg = "<font color='#00FF00'><b>Instructions changed</b></font><br>";
	} else {	
	$msg = "<font color='#FF0000'><b>Error! Instructions NOT changed.</b></font><br>";
	}
	$query->close();
}

$query = $db->query("SELECT Instructions from Instructions");
$row = $query->fetch_row();
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
if(isset($msg)) 
print "$msg"; ?>
<p>Add or change the registration instructions that are displayed to visitors.</p>
<form action='instructions.php' method='post'>
<textarea name='inst' cols='75' rows='20'><?php 
 print "$curInst"; ?></textarea><br>
<input type='submit' name='submit' value='Submit'>
</form>

</body>
</html>
