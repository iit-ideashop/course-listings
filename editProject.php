<?php 
require_once('globals.php');


include_once('classes/db.php');
include_once('year_semester.php');

session_start();

$db = dbConnect();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

foreach($_GET as $key => $val)
	$_GET[$key] = htmlspecialchars($val);


if ($_GET['section'] != '' && $_GET['term'] != '' && $_GET['year'] != '') {
	$query = $db->prepare("SELECT * FROM Projects WHERE Section=? AND Semester=? AND Year=?");
	$query->bind_param("sss",$_GET['section'],$_GET['term'],$_GET['year']);
	$query->execute();
	$qres = $query->get_result();
	$project = $qres->fetch_array();
	$qres->close();
	$query->close();
}

if (isset($_POST['delete'])) {
	$query = $db->prepare("DELETE FROM Projects WHERE Section=? AND Semester=? AND Year=?");
	$query->bind_param("sss",$_GET['section'],$_GET['term'],$_GET['year']);
	$query->execute();
	$query->close();
	header("Location: admin.php");
}

if (isset($_POST['isSubmit'])) {
	foreach($_POST as $key => $val){
		$_POST['key'] = htmlspecialchars($val);
	}
	$qu = $db->prepare("UPDATE Projects SET Sponsor=?, Faculty=?, Disciplines=?, Description=?, Title=?, DateTime=?, Section=?, Year=?, Semester=?, VideoLink=? WHERE Section=? AND Semester=? AND Year=?");
	$qu->bind_param("sssssssssssss",$_POST['sponsor'],$_POST['faculty'],$_POST['disciplines'],$_POST['description'],$_POST['title'],$_POST['datetime'],$_POST['section'],$_POST['year'],$_POST['term'],$_POST['video'],$_POST['origSection'],$_POST['origTerm'],$_POST['origYear']);
	$qu->execute();
	$qu->close();
	header("Location: admin.php");
}

$query = $db->query("SELECT * FROM Disciplines ORDER BY Disciplines");
$disciplines = array();
while ($row = $query->fetch_row())
	$disciplines[] = $row[0];

?>

<html>
<head><title>IPRO Course Listings</title>
<script language='JavaScript'>

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
<body onLoad='init()'>
<img src='img/header.png'>
<h2>IPRO Course Listings</h2>
<h5>Content Management System Administration</h5>
<hr>
<a href='admin.php'>Manage Projects</a> | <a href='faculty.php'>Manage Faculty</a> | <a href='disciplines.php'>Manage Disciplines</a> | <a href='instructions.php'>Change Instructions</a>
<br><br>
<?php 
if(isset($msg))
 print "$msg"; ?>
<h5>Edit a Project</h5>
<form action='editProject.php' method='post'>
<table width='75%'>
<tr><td>Semester:</td><td><select name='term'>
<?php 

foreach ($terms as $term) {
if ($term == $project['Semester'])
	print "<option value='$term' selected>$term</option>";
else
	print "<option value='$term'>$term</option>";
}
?>

</select>&nbsp;<select name='year'>

<?php 


foreach ($years as $year) {
	if ($year == $project['Year'])
		print "<option value='$year' selected>$year</option>";
	else
		print "<option value='$year'>$year</option>";
}
?>
</select></td></tr>
<tr><td>Section:</td><td><input type='text' name='section' size='10' value="<?php 
 print "{$project['Section']}"; ?>"></td></tr>
<tr><td>Title:</td><td><input type='text' name='title' size='30' value='<?php 
 print "{$project['Title']}"; ?>'></td></tr>
<tr><td>Day/Time:</td><td><input type='text' name='datetime' size='30' value='<?php 
 print "{$project['DateTime']}"; ?>'></td></tr>
<tr><td>Sponsor:</td><td><input type='text' name='sponsor' size='35' value="<?php 
 print "{$project['Sponsor']}"; ?>"></td></tr>
<tr><td>Faculty:</td><td><input type='text' name='faculty' size='35'  value='<?php 
 print "{$project['Faculty']}"; ?>'>&nbsp;<a href="javascript:void(window.open('searchFaculty.php','','height=500,width=600,scrollbars,toolbar,top=50,left=50'));">Search for Faculty to Add</a></td></tr>
<tr><td>Video Link:</td><td><input type='text' name='video' size='50' value='<?php 
 print "{$project['VideoLink']}"; ?>'></td></tr>
<tr><td>Disciplines:</td><td><select name='select_dis' onChange="javascript:add_dis()">
<option value=''></option>";
<?php 

foreach ($disciplines as $disc)
	print "<option value='$disc'>$disc</option>";
?>
</select>&nbsp;Choose to add</td></tr>
<tr><td></td><td><textarea name='disciplines' cols='70' rows='4'><?php 
 print "{$project['Disciplines']}"; ?></textarea></td></tr>
<tr><td valign='top'>Description:</td><td><textarea name='description' cols='70' rows='15'><?php 
 print "{$project['Description']}"; ?></textarea></td></tr>

<tr><td colspan=2><center><input type="button" value="Edit Project" name="Submit" onClick="checkentry(this.form);">&nbsp;&nbsp;&nbsp;<input type='submit' name='delete' value='Delete Project'></center></td></tr>
</table>
<input type='hidden' name='isSubmit' value='true'>
<input type='hidden' name='origSection' value='<?php 
 print "{$_GET['section']}"; ?>'>
<input type='hidden' name='origTerm' value='<?php 
 print "{$_GET['term']}"; ?>'>
<input type='hidden' name='origYear' value='<?php 
 print "{$_GET['year']}"; ?>'>
</form>

</body>
</html>
