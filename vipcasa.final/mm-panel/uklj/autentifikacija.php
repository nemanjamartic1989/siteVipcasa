<?php
@include("expire.php"); //hederi
@include("baza_heder.php");


if($_REQUEST['akcija']=="logout" && $_REQUEST['LID']){
$r3 = mysql_query("DELETE FROM t_sesije_korisnici WHERE sesija = '".htmlspecialchars($_REQUEST['LID'])."'");
}

//proveravam korisnicko ime i lozinku:
$korisnik = trim(htmlspecialchars(addslashes($_POST["korisnik"])));
$lozinka = trim(htmlspecialchars(addslashes($_POST["lozinka"])));
$lozinka = md5($lozinka);
if(!$korisnik) {
@header("location:../login.php");
/*echo "<script language=\"Javascript\">window.location='login.html';</script>";*/
};

$rez = mysql_query("SELECT id_korisnika, korisnik, ime_prezime, admin_nivo FROM t_korisnici WHERE korisnik='".$korisnik."' AND lozinka = '".$lozinka."'");

if(@mysql_num_rows($rez)>0){
list($id_korisnika, $korisnik, $ime_prezime, $admin_nivo) = mysql_fetch_row($rez);

   $a[1]="a"; $a[2]="b"; $a[3]="c"; $a[4]="d"; $a[5]="e"; $a[6]="f"; $a[7]="g"; $a[8]="h"; $a[9]="i"; $a[10]="j"; $a[11]="k"; $a[12]="l"; $a[13]="m"; $a[14]="n"; $a[15]="o"; $a[16]="p"; $a[17]="q"; $a[18]="r"; $a[19]="s"; $a[20]="t"; $a[21]="u"; $a[22]="v"; $a[23]="w"; $a[24]="x"; $a[25]="y"; $a[26]="z"; $a[27]="0"; $a[28]="1"; $a[29]="2"; $a[30]="3"; $a[31]="4"; $a[32]="5"; $a[33]="6"; $a[34]="7"; $a[35]="8"; $a[36]="9"; 
   
   $LID = "";
   
   for($i=1; $i<=20 ; $i++){
   $LID .= $a[rand(1,35)];
   }
   
   //generisem LID
   unset($a);
   //zapisujem u bazu sesija:
   $sql2 = "INSERT INTO t_sesije_korisnici (id_korisnika, sesija, korisnik, ime_prezime, admin_nivo, posl_vreme_pristupa) VALUES (".$id_korisnika.", '".$LID."', '".$korisnik."', '".$ime_prezime."', '".$admin_nivo."', '".time()."')";
   $rez2 = @mysql_query($sql2);
   if(mysql_insert_id($db)>0){
     @header("location:../index.php?LID=".$LID);
   } else {
     @header("location:../login.php");
   }
   /*echo "<script language=\"Javascript\">window.location='../login.html';</script>";*/
   exit;
   
} else {

  @header("location:../login.php");
  exit;
  
}//num_rows


?>