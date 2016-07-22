<?php 
require_once('globals.php');


//populate array of years to use in menus, determine current term
//$years[] = array of years
//$terms[] = Summer, Spring, Fall
//$currentYear = 2007
//$currentTerm = Summer

require_once("classes/db.php");

$db = dbConnect();

$query = $db->query("SELECT DISTINCT Year FROM Projects ORDER BY Year");
$years = array();
while ($row = $query->fetch_row()) {
	$years[] = $row[0];
}
$index = count($years) - 1;
$years[] = $years[$index] + 1;

$terms = array();
$terms[] = "Spring";
$terms[] = "Summer";
$terms[] = "Fall";

$currentYear = date('Y');

$month = date('m');
if ($month < 11 && $month >= 7) {
	$currentTerm = 'Fall';
	$nextTerm = 'Spring';
	$nextYear = $currentYear + 1;
	$oldTerm1 = 'Summer';
	$oldYear1 = $currentYear;
	$oldTerm2 = 'Spring';
	$oldYear2 = $currentYear;
}
else if ($month >= 4 && $month < 7) {
	$currentTerm = 'Summer';
	$nextTerm = 'Fall';
	$nextYear = $currentYear;
	$oldTerm1 = 'Spring';
	$oldYear1 = $currentYear;
	$oldTerm2 = 'Fall';
	$oldYear2 = $currentYear - 1;
}
else if ( $month == 11 || $month == 12 ) {
	$currentTerm = 'Spring';
	$currentYear = $currentYear + 1;
	$nextTerm = 'Summer';
	$nextYear = $currentYear;
	$oldTerm1 = 'Fall';
	$oldYear1 = $currentYear - 1;
	$oldTerm2 = 'Summer';
	$oldYear2 = $currentYear - 1;
}
else {
	$currentTerm = 'Spring';
        $nextTerm = 'Summer';
        $nextYear = $currentYear;
        $oldTerm1 = 'Fall';
        $oldYear1 = $currentYear - 1;
        $oldTerm2 = 'Summer';
        $oldYear2 = $currentYear - 1;
}

?>
