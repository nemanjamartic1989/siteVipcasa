<?php

session_start();
if(session_is_registered(snizeno_user_email) || isset($_COOKIE['snizeno_user_email'])){
$prijavljen = true;

if($_SESSION['snizeno_user_email'] != null)
    $email = $_SESSION['snizeno_user_email'];
else $email = $_COOKIE['snizeno_user_email'];

//mysql_query("SET NAMES utf8");
$query_user="SELECT * FROM t_komitenti WHERE e_mail = '$email'";
$result_user=mysql_query($query_user);
while ($redak_user=mysql_fetch_array($result_user))
{ 
$user_id = $redak_user['id_komitenta']; 
$user_ime = $redak_user['naziv']; 
$user_prezime = $redak_user['mesto']; 
$user_telefon = $redak_user['telefoni']; 
$user_email = $redak_user['e_mail']; 
$user_tip = $redak_user['tip']; 
}
}
else if(session_is_registered(snizeno_user_fb))
{
$prijavljen = true;

$id = $_SESSION['snizeno_user_fb'];

mysql_query("SET NAMES utf8");
$query_user="SELECT * FROM korisnik WHERE e_mail = '$id'";
$result_user=mysql_query($query_user);
while ($redak_user=mysql_fetch_array($result_user))
{ 
$user_id = $redak_user['id_komitenta']; 
$user_ime = $redak_user['naziv']; 
$user_prezime = $redak_user['mesto']; 
$user_telefon = $redak_user['telefoni']; 
$user_email = $redak_user['e_mail']; 
$user_tip = $redak_user['tip']; 
}
}
else { $prijavljen = false; }
?>