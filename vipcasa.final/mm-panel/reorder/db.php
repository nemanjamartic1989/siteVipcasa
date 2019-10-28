<?php
$dbhost							= "mysql";
$dbuser							= "europlan_usr";
$dbpass							= "Qq]7EfS~e1Ip";
$dbname							= "europlan_db";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to mysql");
mysql_select_db($dbname);
?>