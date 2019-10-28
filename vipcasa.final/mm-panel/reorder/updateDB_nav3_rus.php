<?php 
require("db.php");

$action                 = mysql_real_escape_string($_POST['action']); 
$parent 				= mysql_real_escape_string($_POST['parent']); 
$updateRecordsArray 	= $_POST['mmpanel-third-level-items'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
	$query = "UPDATE navigation_rus SET ord = " . $listingCounter . " WHERE par=".$parent." AND id = " . $recordIDValue;
		mysql_query($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;	
	}
	
	echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
}
?>