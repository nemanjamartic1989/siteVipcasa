<?php 
require("db.php");

$action 				= mysql_real_escape_string($_POST['action']); 
$page                 = mysql_real_escape_string($_POST['page']); 
$updateRecordsArray 	= $_POST['recordsArray'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE t_strane SET redosled = " . $listingCounter . " WHERE par=".$page." AND id_strane = " . $recordIDValue;
		mysql_query($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;	
	}
	
	//echo '<pre>';
	//print_r($updateRecordsArray);
	//echo '</pre>';
	//echo 'Ovo je kod koji mene cini srecnim jer sam smislio algoritam za proracun.';
}
?>