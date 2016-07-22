<?php 
require_once('globals.php');

include_once('classes/db.php');
include_once('year_semester.php');

session_start();

$db = dbConnect();

/*
   Unused as of October 2015

   $db2 = mysql_connect('localhost', $proposals_db_user, $proposals_db_pass)
   or die('Could not connect to db');
   mysql_select_db($proposals_db_name, $db2);
 */
if (!isset($_SESSION['admin']))
die ("You are not logged in.");

if (isset($_GET['carryover'])) {
	$query = $db->prepare("SELECT * FROM Projects WHERE Semester=? AND Year=?");
	$query->bind_param("ss",$currentTerm,$currentYear);
	$query->execute();
	$qres = $query->get_result();
	if($qres){
		$query2 = $db->prepare("INSERT INTO Projects VALUES (?,?,?,?,?,?,?,?,?");
		while ($proj = $qres->fetch_assoc()) {
			$query2->bind_param("ssssssssss",$proj['Section'], $nextTerm, $nextYear, $proj['title'],$proj['disciplines'], $proj['Description'], $proj['Sponsor'], $proj['Faculty'], $proj['DateTime'], $proj['VideoLink']);
			$query2->execute();
		}
	$qres->close();
	}
	$query->close();
	header('Location: admin.php');

}

$qres = $db->query("SELECT * FROM semesters ORDER BY id DESC");

$propSemesters = array();
if($qres){
	while ($row = $qres->fetch_assoc()){
		$propSemesters[] = $row;
	}
}
/* Unused, fix SQLI vuln here before using!!!
   if (isset($_GET['selectSemester'])) {
   $proposals = array();
   $query = mysql_query("SELECT * FROM proposals WHERE (status=4 OR status=2) AND semester={$_GET['semesterID']}");
   while ($row = mysql_fetch_array($query))
   $proposals[] = $row;
   }
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>IPRO Course Listings</title>
<script type="text/javascript">
<!--
function confirmCarry() {
	var answer=confirm("Confirming this action will carry over all projects from <?php 
			require_once('globals.php');
			print "$currentTerm $currentYear"; ?> to <?php 
			require_once('globals.php');
			print "$nextTerm $nextYear"; ?>. Are you sure you want to do this?")
		if (answer== true){
			window.location = "admin.php?carryover=true";
		}
		else{
			window.location = "admin.php";
		}
}
//-->
</script>
</head>
<body>
<div><img src="img/header.png" alt="IPRO"></div>
<h2>IPRO Course Listings</h2>
<h5>Content Management System Administration</h5>
<h5>Logged in as user: <?php print $_SESSION['username']; ?></h5>
<p><a href="admin.php#manage">Manage Projects</a> | <a href="faculty.php">Manage Faculty</a> | <a href="disciplines.php">Manage Disciplines</a> | <a href="instructions.php">Change Instructions</a> | <a href="logout.php">Log Out</a></p>
<hr>
<form action="searchProjects.php" method="get"><fieldset><legend>Search for Projects</legend>
<table width="40%">
<tr><td><label for="section">By Section:</label></td><td><input type="text" name="section" id="section"></td></tr>
<tr><td><label for="term">By Semester:</label></td><td><input type="text" name="term" id="term"></td></tr>
<tr><td><label for="year">By Year:</label></td><td><input type="text" name="year" id="year"></td></tr>
<tr><td><label for="title">By Title:</label></td><td><input type="text" name="title" id="title"></td></tr>
<tr><td colspan="2"><input type="submit" name="search" value="Search"></td></tr>
</table></fieldset>
</form>
<hr>
<h4><a name="manage">Manage Projects</a></h4>
<p><a href="addProject.php">Add New Project</a>&nbsp;
<input type="button" value="Carry Over Projects" onClick="confirmCarry()"></p>
<form action="admin.php" method="get"><fieldset><legend>Import Project from Proposal System</legend>
<select name="semesterID">
<?php 
require_once('globals.php');

foreach($propSemesters as $sem)
	print "<option value=\"{$sem['id']}\">{$sem['name']}</option>";
	?>
	</select>
	<input type="submit" name="selectSemester" value="Select"></fieldset>
	</form>
	<?php 
	require_once('globals.php');

	if (isset($_GET['selectSemester'])) {
		if (count($proposals) == 0)
			print "<p>No proposals for that semester</p>";
		else {
			print "<form action=\"sendToCMS.php\" method=\"post\"><fieldset>";
			print "<p>You MUST assign a section number to each project</p>";

			/*
			   print "<select name=\"proposalID\">";
			   foreach ($proposals as $proposal) {
			   print "<option value=\"{$proposal['id']}\">{$proposal['title']}</option>";
			   }
			   print "</select>&nbsp;&nbsp;<b>Assign Section: </b><input type=\"text\" size=\"2\" name=\"section\">&nbsp;";
			 */
			$i = 1;
			foreach ($proposals as $proposal) {
				print "<label>Add? <input type=\"checkbox\" name=\"proposalID[]\" value=\"{$proposal['id']}\"></label> <label>Section? <input type=\"text\" name=\"{$proposal['id']}\" size=\"2\" value=\"{$proposal['section']}\"></label>&nbsp;{$proposal['title']}<br>";
			}
			print "<input type=\"hidden\" name=\"semesterID\" value=\"{$_GET['semesterID']}\">";
			print "<input type=\"submit\" name=\"import\" value=\"Import Projects\"></fieldset></form>";
		}
	}
?>

<h5>Upcoming Projects - <?php 
require_once('globals.php');
print "$currentTerm $currentYear"; ?></h5>
<table width="100%" border="1">
<tr><th>Course Number</th><th>Course Title</th></tr>
<?php 
require_once('globals.php');

$query = $db->prepare("SELECT * FROM Projects WHERE Semester=? AND Year=? ORDER BY Section");
$query->bind_param("ss",$currentTerm,$currentYear);
$query->execute();
$qres = $query->get_result();
while ($proj = $qres->fetch_assoc()) {
	$section = str_replace(' ', '+', $proj['Section']);
	print "<tr><td><a href=\"editProject.php?section=$section&amp;term={$proj['Semester']}&amp;year={$proj['Year']}\">{$proj['Section']}</a></td><td>{$proj['Title']}</td></tr>";
}
$qres->close();
$query->close();
?>
</table>

<h5>Past Projects</h5>

<table width="100%" border="1">
<tr><th>Term</th><th>Course Number</th><th>Course Title</th></tr>
<?php 
require_once('globals.php');


$query = $db->prepare("SELECT * FROM Projects WHERE Semester=? AND Year=?");
$query->bind_param('ss',$oldTerm1,$oldYear1);
$query->execute();
$qres = $query->get_result();
while ($proj = $qres->fetch_assoc()) {
	foreach($proj as $key => $val)
		$proj[$key] = str_replace('&', '&amp;', $val);
	$section = str_replace(' ', '+', $proj['Section']);
	print "<tr><td>$oldTerm1 $oldYear1</td><td><a href=\"editProject.php?section=$section&amp;term={$proj['Semester']}&amp;year={$proj['Year']}\">{$proj['Section']}</a></td><td>{$proj['Title']}</td></tr>";
}
$qres->close();

$query->bind_param('ss',$oldTerm2,$oldYear2);
$query->execute();
$qres = $query->get_result();
while ($proj = $qres->fetch_assoc()) {
	$section = str_replace(' ', '+', $proj['Section']);
	foreach($proj as $key => $val)
		$proj[$key] = str_replace('&', '&amp;', $val);
	print "<tr><td>$oldTerm2 $oldYear2</td><td><a href=\"editProject.php?section=$section&amp;term={$proj['Semester']}&amp;year={$proj['Year']}\">{$proj['Section']}</a></td><td>{$proj['Title']}</td></tr>";
}
$qres->close();
$query->close();
?>
</table>
</body>
</html>
