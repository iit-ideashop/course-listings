<?php 
require_once('globals.php');


include_once('classes/db.php');
include_once('year_semester.php');

$db = new dbConnection();

$query = $db->dbQuery("SELECT * FROM Projects WHERE Year='{$_GET['year']}' AND Semester='{$_GET['term']}' AND Section='{$_GET['section']}'");
$projects = array();
while ($row = mysql_fetch_array($query))
	$projects[] = $row;
?>

<html>
<head><title>IPRO Course Listings</title>

<script language="JavaScript1.2">
function init() {
        if(window.print)
                window.print();
        else
                alert("Please select Print from the file menu");
}
</script>

</head>
<body onload="init()">

<?php 
require_once('globals.php');


foreach ($projects as $proj) {
	print "<table width='560' cellspacing='0' cellpadding='0' colspan=2 bgcolor='#FFFFFF'><tr><td height='14'  bgcolor='#FFFFFF'><font size='2' color='#cc0000'><b>Section: </b></font> <a name='{$proj['Semester']}{$proj['Year']}_{$proj['Section']}'><font face='Arial' size='2' color='#000000'>{$proj['Semester']}&nbsp;{$proj['Year']}&nbsp;-&nbsp;{$proj['Section']}</font></a> </td></tr>";
	print "<tr><td colspan='2' width='600' height='14' bgcolor='#FFFFFF'><span class='runningtext'><font color='#cc0000' size='2'><b>Title: </b></font></span> <font face='Arial' size='2' color='#000000'>{$proj['Title']}</font></td></tr>";
	print "<tr><td colspan='2' width='600' height='14' bgcolor='#FFFFFF'><font size='2' color='#cc0000'><b>Days/Time:
</b></font><font face='Arial' size='2' color='#000000'>{$proj['DateTime']}</font></td></tr>";
	print "<tr><td colspan='2' width='600' height='14'  bgcolor='#FFFFFF'><font size='2' color='#cc0000'><b>Sponsor: </b></font> <font face='Arial' size='2' color='#000000'>{$proj['Sponsor']}</font></td></tr>";
	print "<tr><td colspan='2' width='600'  bgcolor='#FFFFFF' height='14'><font size='2' color='#cc0000'><b>Faculty: </b></font> <font face='Arial' size='2' color='#000000'>{$proj['Faculty']}</font></td></tr>";
	print "<tr><td colspan='2' width='600'  bgcolor='#FFFFFF' height='14'><font size='2' color='#cc0000'><b>Appropriate Disciplines: </b></font> <font face='Arial' size='2' color='#000000'>{$proj['Disciplines']}</font></td></tr>";
	print "<tr><td colspan='2' width='600'  bgcolor='#FFFFFF' height='14'><font size='2' color='#cc0000'><b>Description: </b></font> <font face='Arial' size='2' color='#000000'>{$proj['Description']}</font></td></tr>";
	print "<tr><td colspan='2' width='600' height='14'>&nbsp;</td></tr>";
	print "</table>";
}

?>

</body>
</html>
