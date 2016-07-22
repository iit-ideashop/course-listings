<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = new dbConnection();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

?>

<html>
<head><title>IPRO Course Listings</title></head>
<body>
<img src='img/header.png'>
<h2>IPRO Course Listings</h2>
<h5>Content Management System Administration</h5>
<hr>
<h5>Search for Faculty</h5>

<form action='searchResults.php' method='get'>
<table width='80%'>
<tr><td>By First Name:</td><td><input type='text' size='20' name='fName'></td></tr>
<tr><td>By Last Name:</td><td><input type='text' size='20' name='lName'></td></tr>
<tr><td>By Email:</td><td><input type='text' size='20' name='email'></td></tr>
<tr><td>By Department:</td><td><input type='text' size='20' name='dept'></td></tr>
</table>
<input type='submit' name='submit' value='Search'>
</form>

</body>
</html>
