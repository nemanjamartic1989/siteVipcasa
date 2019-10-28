<?php
exit;
//@include("uklj/expire.php"); //hederi
@include("uklj/baza_heder.php");
//@include("uklj/sesija.php"); 
//@include("uklj/podesavanje.php");
//@include("uklj/datum.php");



$sql = "CREATE TABLE security_images (
   ID int(11) NOT NULL auto_increment,
   insertdate datetime NOT NULL default '0000-00-00 00:00:00',
   referenceid varchar(100) NOT NULL default '',
   hiddentext varchar(100) NOT NULL default '',
   PRIMARY KEY (ID)
) ENGINE=MyISAM";
$rez = mysql_query($sql);


?>
