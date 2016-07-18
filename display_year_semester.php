<?php 
require_once('globals.php');


//this file is like year_semester.php, except now current year and term is designated by IIT's academic year calendar. This file 
//should be used when determining what to display on the IPRO website.
//$years[] = array of years
//$terms[] = Summer, Spring, Fall
//$currentYear = 2007
//$currentTerm = Summer

require_once("classes/db.php");

$db = new dbConnection();

$query = $db->dbQuery("SELECT DISTINCT Year FROM Projects ORDER BY Year");
$years = array();
while ($row = mysql_fetch_row($query)) {
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
$day = date('d');
if ($month <= 12 && $month >= 7) {
if ($month == 12 && $day > 19) {
	$currentTerm = 'Spring';
	$currentYear = date('Y')+1;
        $nextTerm = 'Summer';
        $nextYear = $currentYear;
        $oldTerm1 = 'Fall';
        $oldYear1 = $currentYear - 2;
        $oldTerm2 = 'Summer';
        $oldYear2 = $currentYear - 2;
}
else if ($month == 7 && $day < 31) {
	$currentTerm = 'Summer';
        $nextTerm = 'Fall';
        $nextYear = $currentYear;
        $oldTerm1 = 'Spring';
        $oldYear1 = $currentYear;
        $oldTerm2 = 'Fall';
        $oldYear2 = $currentYear - 1;
}
else {
	$currentTerm = 'Fall';
	$nextTerm = 'Spring';
	$nextYear = $currentYear + 1;
	$oldTerm1 = 'Summer';
	$oldYear1 = $currentYear;
	$oldTerm2 = 'Spring';
	$oldYear2 = $currentYear;
}
}
else if ($month >= 5 && $month <= 7) {
if ($month == 5 && $day < 20) {
	$currentTerm = 'Spring';
        $nextTerm = 'Summer';
        $nextYear = $currentYear;
        $oldTerm1 = 'Fall';
        $oldYear1 = $currentYear - 1;
        $oldTerm2 = 'Summer';
        $oldYear2 = $currentYear - 1;
}
else {
	$currentTerm = 'Summer';
	$nextTerm = 'Fall';
	$nextYear = $currentYear;
	$oldTerm1 = 'Spring';
	$oldYear1 = $currentYear;
	$oldTerm2 = 'Fall';
	$oldYear2 = $currentYear - 1;
}
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
