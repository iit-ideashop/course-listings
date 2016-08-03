<?php 
require_once('globals.php');


include_once('classes/db.php');
include_once('year_semester.php');

session_start();

$db = dbConnect();

if (!isset($_SESSION['admin']))
die ("You are not logged in.");

if (isset($_POST['isSubmit'])) {
	foreach($_POST as $key => $val){
		$_POST['key'] = htmlspecialchars($val);
	}
	//$sponsor = str_replace("'", "\'", $_POST['sponsor']);
	//$description = str_replace("'", "\'", $_POST['description']);
	//$description = str_replace('"', '\"', $description);
	$query = $db->prepare("INSERT INTO Projects VALUES (?,?,?,?,?,?,?,?,?,?)");
	$query->bind_param("ssssssssss",$_POST['section'], $_POST['term'], $_POST['year'], $_POST['title'],$_POST['disciplines'], $_POST['description'], $_POST['sponsor'], $_POST['faculty'], $_POST['datetime'], $_POST['video']);
	$qres = $query->execute();
	if ($qres)
		$msg = "<p style=\"color: #00FF00; font-weight: bold\">Project Created</p>";
	else 
		$msg = "<p style=\"color: #FF0000; font-weight: bold\">ERROR: Could not create project</p>";
}

$qres = $db->query("SELECT * FROM Disciplines ORDER BY Disciplines");
$disciplines = array();
while ($row = $qres->fetch_row())
	$disciplines[] = $row[0];

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<title>IPRO Course Listings</title>
	<script type="text/javascript">

	function checkentry(form) {
		if (form.section.value == "" ){
			alert('Please enter Section');
			form.section.focus();}
		else if (form.title.value == ""){
			alert('Please enter Title');
			form.title.focus();}	
		else {
			if (form.disciplines.value == ""){
				form.disciplines.value = " ";}
			if (form.description.value == ""){
				form.description.value = " ";}
			form.submit();	
		}
	}

var mainform;
function init() {
	mainform = document.forms[0];
}

function add_faculty(name, email, phone) {

	var temp = mainform['faculty'].value

		if (mainform['faculty'].value.length > 0) {
			temp = temp + ", " 
		}
	mainform['faculty'].value = temp + name + " (" + email + " or " + phone + ")"
}

function add_dis() {

	var temp = mainform['disciplines'].value

		if (mainform['disciplines'].value.length > 0) {
			temp = temp + ", " 
		}
	mainform['disciplines'].value = temp + mainform['select_dis'][mainform['select_dis'].selectedIndex].value
}

</script>
</head>
<body onLoad="init()">
<div><img src="img/header.png" alt="IPRO"></div>
<h2>IPRO Course Listings</h2>
<h5>Content Management System Administration</h5>
<hr>
<p><a href="admin.php">Manage Projects</a> | <a href="faculty.php">Manage Faculty</a> | <a href="disciplines.php">Manage Disciplines</a> | <a href="instructions.php">Change Instructions</a></p>
<?php 
require_once('globals.php');
if(isset($msg))
	print "$msg"; 
	?>
	<form action="addProject.php" method="post" name="addForm"><fieldset><legend>Add New Project</legend>
	<table width="75%">
	<tr><td><label for="term">Semester:</label></td><td><select name="term" id="term">
	<?php 
	require_once('globals.php');

	foreach ($terms as $term) {
		if ($term == $currentTerm)
			print "<option value=\"$term\" selected>$term</option>";
		else
			print "<option value=\"$term\">$term</option>";
	}
?>

</select>&nbsp;<select name="year">

<?php 
require_once('globals.php');


foreach ($years as $year) {
	if ($year == $currentYear)
		print "<option value=\"$year\" selected>$year</option>";
	else
		print "<option value=\"$year\">$year</option>";
}
?>
</select></td></tr>
<tr><td><label for="section">Section:</label></td><td><input type="text" name="section" id="section" size="10"></td></tr>
<tr><td><label for="title">Title:</label></td><td><input type="text" name="title" id="title" size="30"></td></tr>
<tr><td><label for="sponsor">Sponsor:</label></td><td><input type="text" name="sponsor" id="sponsor" size="35"></td></tr>
<tr><td><label for="faculty">Faculty:</label></td><td><input type="text" name="faculty" id="faculty" size="35">&nbsp;<a href="javascript:void(window.open('searchFaculty.php','','height=500,width=600,scrollbars,toolbar,top=50,left=50'));">Search for Faculty to Add</a></td></tr>
<tr><td><label for="datetime">Days/Time:</label></td><td><input type="text" name="datetime" id="datetime" size="35"></td></tr>
<tr><td><label for="video">Video Link:</label></td><td><input type="text" name="video" id="video" size="50"></td></tr>
<tr><td><label for="select_dis">Disciplines:</label></td><td><select name="select_dis" id="select_dis" onChange="javascript:add_dis()">
<option value=""></option>
<?php 
require_once('globals.php');

foreach ($disciplines as $disc)
	print "<option value=\"$disc\">$disc</option>";
	?>
	</select>&nbsp;Choose to add</td></tr>
	<tr><td></td><td><textarea name="disciplines" cols="70" rows="4"></textarea></td></tr>
	<tr><td valign="top"><label for="description">Description:</label></td><td><textarea name="description" id="description" cols="70" rows="15"></textarea></td></tr>

	<tr><td colspan="2" style="text-align: center"><input type="button" value="Add Project" name="Submit" onClick="checkentry(this.form);"></td></tr>
	</table>
	<input type="hidden" name="isSubmit" value="true">
	</fieldset></form>

	</body>
	</html>
