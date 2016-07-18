<?php 
require_once('globals.php');


include_once('classes/db.php');

session_start();

$db = new dbConnection();

if (!isset($_SESSION['admin']))
	die ("You are not logged in.");

if (isset($_GET['submit'])) {
	$sql = "SELECT fName, lName, email, oTel FROM Staff WHERE fName IS NOT NULL AND lName IS NOT NULL";
	if ($_GET['fName'] != '')
		$sql .= " AND fName LIKE '{$_GET['fName']}%'";
	if ($_GET['lName'] != '')
		$sql .= " AND lName LIKE '{$_GET['lName']}%'";
	if ($_GET['email'] != '')
		$sql .= " AND email LIKE '{$_GET['email']}%'";
	if ($_GET['dept'] != '')
		$sql .= " AND dept LIKE '{$_GET['dept']}%'";
	$query = $db->dbQuery($sql);
	$resultSet = array();
	while ($result = mysql_fetch_array($query))
		$resultSet[] = $result;
}

?>

<html>
<head><title>IPRO Course Listings</title>
<script language="JavaScript1.2">
		function add_person(name, email, phone) {
			window.opener.add_faculty(name, email, phone);
			window.close();
		}
</script>
</head>
<body>
<img src='img/header.png'>
<h2>IPRO Course Listings</h2>
<h5>Content Management System Administration</h5>
<hr>
<h5>Search for Faculty</h5>

<table>

<?php 
require_once('globals.php');


foreach ($resultSet as $result) {
	print "<tr><td colspan='3'><a href=" . '"javascript:add_person('. "'{$result['fName']} {$result['lName']}','{$result['email']}','{$result['oTel']}'" .');"' . "><font size=2 face='Arial' color='#8C0A37'>{$result['fName']}&nbsp;{$result['lName']}</font></a></td></tr>";
	print "<tr><td valign='top' height='25' width='10' align='left' bgcolor='#F7FBFB'>&nbsp;</td>";
	print "<td valign='top' height='25' width='100' align='left' bgcolor='#F7FBFB'><font size='2' face='Arial' color='#8C0A37'>Department: </font></td>";
	print "<td valign='top' height='25' width='150' align='left' bgcolor='#F7FBFB'><font size='2' face='Arial'>{$result['dept']}</font></td></tr>";
	print "<tr><td valign='top' height='25' width='10' align='left' bgcolor='#F7FBFB'>&nbsp;</td>";
        print "<td valign='top' height='25' width='100' align='left' bgcolor='#F7FBFB'><font size='2' face='Arial' color='#8C0A37'>Email: </font></td>";
        print "<td valign='top' height='25' width='150' align='left' bgcolor='#F7FBFB'><font size='2' face='Arial'>{$result['email']}</font></td></tr>";
	print "<tr><td valign='top' height='25' width='10' align='left' bgcolor='#F7FBFB'>&nbsp;</td>";
        print "<td valign='top' height='25' width='100' align='left' bgcolor='#F7FBFB'><font size='2' face='Arial' color='#8C0A37'>Phone: </font></td>";
        print "<td valign='top' height='25' width='150' align='left' bgcolor='#F7FBFB'><font size='2' face='Arial'>{$result['oTel']}</font></td></tr>";
	print "<tr><td height='25' colspan=3 width=10 align='left' bgcolor='#F7FBFB'>&nbsp;</td></tr>";
}

?>

</table>

</body>
</html>
