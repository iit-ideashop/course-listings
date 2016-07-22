<?php 
require_once('globals.php');


session_start();
//TODO populate credentials
$db = mysql_connect('', '', '')
     or die('Could not connect to db');
mysql_select_db('proposals', $db); 

if (isset($_POST['import'])) {
	for($i=0; $i<count($_POST['proposalID']); $i++) {
	$pID = $_POST['proposalID'][$i];
	$sect = $_POST["$pID"];
	if ($sect == '')
		$msg = "ERROR: You did not specify a section name.";
	if ($pID == '')
		$msg = "ERROR: You did not specify a proposal.";
	if (!isset($msg)) {
		mysql_select_db('proposals', $db);
		$query = mysql_query("SELECT * FROM proposals p, semesters s WHERE p.semester = s.id AND p.id={$pID}");
		$proposal = mysql_fetch_array($query);
		$query = mysql_query("SELECT * FROM disciplines WHERE id={$pID}");
		$disc = mysql_fetch_array($query);
		$discs = '';
		if ($disc['Any'] == 1)
			$discs .= 'Students of all disciplines are welcome, ';
		if ($disc['ARCH'] == 1)
			$discs .= 'architecture, ';
		if ($disc['BUS'] == 1)
                        $discs .= 'business, ';
		if ($disc['DES'] == 1)
                        $discs .= 'design, ';
		if ($disc['E'] == 1)
                        $discs .= 'engineering, ';
		if ($disc['AE'] == 1)
                        $discs .= 'aerospace engineering, ';
		if ($disc['ARCHE'] == 1)
                        $discs .= 'architectural engineering, ';
		if ($disc['BE'] == 1)
                        $discs .= 'biomedical engineering, ';
		if ($disc['CHE'] == 1)
                        $discs .= 'chemical engineering, ';
		if ($disc['CIVE'] == 1)
                        $discs .= 'civil engineering, ';
		if ($disc['CE'] == 1)
                        $discs .= 'computer engineering, ';
		if ($disc['EE'] == 1)
                        $discs .= 'electrical engineering, ';
		if ($disc['EM'] == 1)
                        $discs .= 'engineering management, ';
		if ($disc['MSE'] == 1)
                        $discs .= 'material science/engineering, ';
		if ($disc['ME'] == 1)
                        $discs .= 'mechanical engineering, ';
		if ($disc['LAW'] == 1)
                        $discs .= 'law, ';
		if ($disc['PD'] == 1)
                        $discs .= 'professional development, ';
		if ($disc['MT'] == 1)
                        $discs .= 'manufacturing technology, ';
		if ($disc['IT'] == 1)
                        $discs .= 'information technology, ';
		if ($disc['PSYC'] == 1)
                        $discs .= 'psychology, ';
		if ($disc['SCI'] == 1)
                        $discs .= 'science, ';
		if ($disc['AM'] == 1)
                        $discs .= 'applied mathematics, ';
		if ($disc['BIO'] == 1)
                        $discs .= 'biology, ';
		if ($disc['CHEM'] == 1)
                        $discs .= 'chemistry, ';
		if ($disc['CS'] == 1)
                        $discs .= 'computer science, ';
		if ($disc['CIS'] == 1)
                        $discs .= 'computer information systems, ';
		if ($disc['IC'] == 1)
                        $discs .= 'internet communication, ';
		if ($disc['JOUR'] == 1)
                        $discs .= 'journalism, ';
		if ($disc['MATHE'] == 1)
                        $discs .= 'mathematics education, ';
		if ($disc['MB'] == 1)
                        $discs .= 'molecular biochemistry/biophysics, ';
		if ($disc['PHYS'] == 1)
                        $discs .= 'physics, ';
		if ($disc['PS'] == 1)
                        $discs .= 'political science, ';
		if ($disc['COM'] == 1)
                        $discs .= 'professional/technical communication, ';
		if ($disc['PA'] == 1)
                        $discs .= 'public administration, ';
		if ($disc['SE'] == 1)
                        $discs .= 'science education, ';
		$discs = substr($discs, 0, strlen($discs)-2);
		//$description = str_replace('"', '\"', $proposal['description']);
		//$description = str_replace("'", "\'", $description);
		$description = mysql_real_escape_string(stripslashes($proposal['description']));
		$semester = explode(' ', $proposal['name']);
		$term = $semester[0];
		$year = $semester[1];
		$faculty = $proposal['lead_fac'];
		if ($proposal['oth_fac1'] != 'N/A')
			$faculty .= ', ' . $proposal['oth_fac1'];
		if ($proposal['oth_fac2'] != 'N/A')
			$faculty .= ', ' . $proposal['oth_fac2'];
		mysql_select_db('course_listings', $db);
		mysql_query("INSERT INTO Projects VALUES ('{$sect}', '$term', '$year', '{$proposal['title']}',
'$discs', '$description', '{$proposal['sponsor']}', '$faculty', '{$proposal['days']}', null)");
	}
		header("Location: admin.php");
	}
}
else
	$msg = "ERROR: You cannot access this page directly.";

?>

