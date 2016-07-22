<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Interprofessional Projects Program - IIT IPRO</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!--header-->
      <span><img display="inline" src="img/newlogo3.gif" border="0" style="max-height='60';">
            <img display="inline" src="img/header.png" border="0" style="max-height='60';"></span>
<div class="regularText">
<?php 
require_once('globals.php');


include_once('classes/db.php');
include_once('display_year_semester.php');

$db = dbConnect();

$query = $db->prepare("SELECT * FROM Projects WHERE Year=? AND Semester=? ORDER BY Section");
$query->bind_param("ss",$currentYear,$currentTerm);
$query->execute();
$qres = $query->get_result();

$projects = array();
while ($row = $qres->fetch_assoc())
	$projects[] = $row;
?>

<table  width="70%" height="100" cellspacing="0" cellpadding="0" colspan=2 bgcolor="#FFFFFF"> 
      	<tr><td><h3>Instructions for Enrollment</h3></td></tr>
		<tr><td>
		<?php 
require_once('globals.php');

        $query = $db->query("SELECT * FROM Instructions");
        $inst = $query->fetch_row();
        print "<a name='instructions'></a><p>{$inst[0]}</pZ><br><br>";
		?>
		</td></tr>

	<tr bgcolor="#FFFFFF" valign="top"> 
        <td width="560" height="29" align="left" colspan="2" bgcolor="#FFFFFF"> 
          <h2>IPRO Current Listings for <?php 
require_once('globals.php');
 print "$currentTerm $currentYear"; ?></h2></td>
        <br>

      </tr>
      <td width="560"> 
        
      <tr bgcolor="#FFFFFF" valign="top"> 
        <td width=600 bgcolor="#FFFFFF" colspan=2> 

	<table width=560 bgcolor="#FFFFFF">

<?php 
require_once('globals.php');


foreach ($projects as $proj) {
	print "<tr><span class='runningtext'><td width='10' valign='top' height='14' bgcolor='#FFFFFF'><font  size='2' 
color='#000000'>{$proj['Semester']}&nbsp;{$proj['Year']}&nbsp;-</font></td><td width='120' valign='top' height='14'  
bgcolor='#FFFFFF'><a href='#{$proj['Semester']}{$proj['Year']}_{$proj['Section']}'>{$proj['Section']}</a></td><td width='470' 
valign='top' height='14' bgcolor='#FFFFFF'><font face='Arial' size='2' color='#000000'>{$proj['Title']}</font></td></tr>";
}

?>
</table>
<br><br>
<?php 
require_once('globals.php');

foreach ($projects as $proj) {
	$section = str_replace(' ', '+', $proj['Section']);
	print "<table width='100%' cellspacing='0' cellpadding='0' colspan=2 bgcolor='#FFFFFF'><tr><td height='14'  
bgcolor='#FFFFFF'><font size='2' color='#cc0000'><b>Section: </b></font> <a 
name='{$proj['Semester']}{$proj['Year']}_{$proj['Section']}'><font face='Arial' size='2' 
color='#000000'>{$proj['Semester']}&nbsp;{$proj['Year']}&nbsp;-&nbsp;{$proj['Section']}</font></a> </td><td align='right'> <a 
href='javascript:void(window.open(\"printDisplay.php?section=$section&term={$proj['Semester']}&year={$proj['Year']}\"))'><font 
face='Arial' size='2' color='#cc0000'>print</font></a>&nbsp;|&nbsp;<a href='#top'><font face='Arial' size='2' color='#cc0000'>return 
to top</font></a> </td></tr>";
	print "<tr><td colspan='2' height='14' bgcolor='#FFFFFF'><span class='runningtext'><font color='#cc0000' 
size='2'><b>Title: </b></font></span> <font face='Arial' size='2' color='#000000'>{$proj['Title']}</font></td></tr>";
	print "<tr><td colspan='2' height='14'  bgcolor='#FFFFFF'><font size='2' color='#cc0000'><b>Meeting Days/Time:
</b></font><font face='Arial' size='2' color='#000000'>{$proj['DateTime']}</font></td></tr>";
	print "<tr><td colspan='2' height='14'  bgcolor='#FFFFFF'><font size='2' color='#cc0000'><b>Sponsor: </b></font> 
<font face='Arial' size='2' color='#000000'>{$proj['Sponsor']}</font></td></tr>";
	print "<tr><td colspan='2' bgcolor='#FFFFFF' height='14'><font size='2' color='#cc0000'><b>Faculty: </b></font> 
<font face='Arial' size='2' color='#000000'>{$proj['Faculty']}</font></td></tr>";
	print "<tr><td colspan='2' bgcolor='#FFFFFF' height='14'><font size='2' color='#cc0000'><b>Appropriate 
Disciplines: </b></font> <font face='Arial' size='2' color='#000000'>{$proj['Disciplines']}</font></td></tr>";
	if ($proj['VideoLink'])
	print "<tr><td colspan='2' bgcolor='#FFFFFF' height='14'><font size='2' color='#cc0000'><b>Presentation
Video: </b></font> <font face='Arial' size='2' color='#000000'><a href='{$proj['VideoLink']}'>Click to View</a></font></td></tr>";
	print "<tr><td colspan='2' bgcolor='#FFFFFF' height='14'><font size='2' color='#cc0000'><b>Description: 
</b></font>{$proj['Description']}</td></tr>";
	print "<tr><td colspan='2' height='14'>&nbsp;</td></tr>";
	print "</table>";
}

?>
</div><!--MENUCONTENT--> </td>
    </tr>
  </tbody>
</table>

<!--footer begin-->
<br>
<hr>
<div align="center" class=paddedFooter"><font face="arial" size="1">&copy; 2016</font><font
 face="Arial, Helvetica, sans-serif" size="2"> Illinois Institute of
Technology 3300 South Federal Street, Chicago, IL 60616-3793 Tel 312
567-3000<br><a href="login.php">Login</a></font></div>
    <!--footer end-->
</body>
</html>

