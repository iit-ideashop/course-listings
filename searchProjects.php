<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

if (!isset($_SESSION['admin']))
	die ("You do not have access to this page.");

$db = dbConnect();

if (isset($_GET['search'])) {
	$sql = $db->prepare("SELECT * FROM Projects WHERE Section IS NOT NULL AND Section LIKE ? AND Semester LIKE ? AND Year LIKE ? AND Title LIKE ? AND Faculty LIKE ? AND Description LIKE ? AND Disciplines LIKE ? ORDER BY Year DESC");
	if ($_GET['section'] == '')
		$_GET['section']="%";
	if ($_GET['term'] == '')
		$_GET['term']="%";
	if ($_GET['year'] == '')
		$_GET['year']="%";
	if ($_GET['title'] == '')
		$_GET['title']="%";
	if ($_GET['faculty'] == '')
		$_GET['faculty']="%";
	if ($_GET['description'] == '')
                $_GET['description']="%";
	if ($_GET['disciplines'] == '')
                $_GET['disciplines']="%";

	$sql->bind_param("sssssss",$_GET['section'],$_GET['term'],$_GET['year'],$_GET['title'],$_GET['faculty'],$_GET['description'],$_GET['disciplines']);
	$sql->execute();
	$qres = $sql->get_result();

	$resultSet = array();
	while ($result = $qres->fetch_assoc())
		$resultSet[] = $result;
	$qres->close();
	$sql->close();
	}
?>

<html>
<head><title>IPRO Course Listings</title></head>
<body>
<img src='img/header.png'>
<h2>IPRO Course Listings</h2>
<h5>Search for Projects</h5>

<?php 
require_once('globals.php');


if (count($resultSet) == 0) {
	print "Your search produced no results.";
	die();
}

else {

?>

<table width=100%  border=0 cellspacing="0" cellpadding="0" colspan=3 bgcolor="#F7FBFB">
<tr><td height="50" width="100%" colspan=3 align="left" bgcolor="#F7FBFB"><font size=4 face="Arial" ><b>Search for Projects</b></font></td></tr>

<?php 
require_once('globals.php');


foreach ($resultSet as $result) {
	$section = str_replace(' ', '+', $result['Section']);
	print "<tr><td width='50%'><a href='editProject.php?section=$section&term={$result['Semester']}&year={$result['Year']}'>Edit</a></td>";
	print "<td width=50><font size=2 face='Arial' color='#8C0A37'>Section: </font></td><td width=500><font size=2 face='Arial'>{$result['Section']}</td></tr>";
	print "<tr><td valign=top height='25' width=50 align='left' bgcolor='#F7FBFB'>&nbsp;</td><td valign=top width=50><font size=2 face='Arial' color='#8C0A37'>Semester: </font></td><td valign=top width=500><font size=2 face='Arial'>{$result['Semester']}</font></td></tr>";
	print "<tr><td valign=top height='25' width=50 align='left' bgcolor='#F7FBFB'>&nbsp;</td><td valign=top width=50><font size=2 face='Arial' color='#8C0A37'>Year: </font></td><td valign=top width=500><font size=2 face='Arial'>{$result['Year']}</font></td></tr>";
	print "<tr><td valign=top height='25' width=50 align='left' bgcolor='#F7FBFB'>&nbsp;</td><td valign=top width=50><font size=2 face='Arial' color='#8C0A37'>Title: </font></td><td valign=top width=500><font size=2 face='Arial'>{$result['Title']}</font></td></tr>";
	print "<tr><td valign=top height='25' width=50 align='left' bgcolor='#F7FBFB'>&nbsp;</td><td valign=top width=50><font size=2 face='Arial' color='#8C0A37'>Faculty: </font></td><td valign=top width=500><font size=2 face='Arial'>{$result['Faculty']}</font></td></tr>";
	print "<tr><td valign=top height='25' width=50 align='left' bgcolor='#F7FBFB'>&nbsp;</td><td valign=top width=50><font size=2 face='Arial' color='#8C0A37'>Sponsor: </font></td><td valign=top width=500><font size=2 face='Arial'>{$result['Sponsor']}</font></td></tr>";
	print "<tr><td valign=top height='25' width=50 align='left' bgcolor='#F7FBFB'>&nbsp;</td><td valign=top width=50><font size=2 face='Arial' color='#8C0A37'>Disciplines: </font></td><td valign=top width=500><font size=2 face='Arial'>{$result['Disciplines']}</font></td></tr>";
	print "<tr><td valign=top height='25' width=50 align='left' bgcolor='#F7FBFB'>&nbsp;</td><td valign=top
width=50><font size=2 face='Arial' color='#8C0A37'>Description: </font></td><td valign=top width=500><pre><font size=3
face='verdana, arial, sans-serif'>{$result['Description']}</font></pre></td></tr>";
	print "<tr><td valign=top width='100%' colspan=3>&nbsp;</td></tr>";
}
?>

</table>

<?php 
require_once('globals.php');


}

?>

</body>
</html>
