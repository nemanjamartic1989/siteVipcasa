<?php
$LID = htmlspecialchars($_REQUEST['LID']);
$modul = htmlspecialchars($_REQUEST['modul']);
$akcija = htmlspecialchars($_REQUEST['akcija']);


$proveri_sesiju = 1;

if($proveri_sesiju){

$MAX_IDLE_VREME_SESIJE = 60; //minuta ako se nista ne radi, sesija se prekida

//echo $LID; exit;

if(!$LID) {
@header("location:login.php");
exit;
};



//vadim da li postoji sesija?
$mvreme = time() - ($MAX_IDLE_VREME_SESIJE * 60);

$sql = "SELECT id_korisnika, korisnik, admin_nivo, ime_prezime 
FROM t_sesije_korisnici
WHERE sesija = '".$LID."' and posl_vreme_pristupa > ".$mvreme;
$rez = mysql_query($sql);
//echo $sql; exit;
if(mysql_num_rows($rez)>0){
 list($ID_KORISNIKA, $KORISNIK, $A_NIVO, $IME_PREZIME)=@mysql_fetch_row($rez);
  //serijalizujem admin nivo u niz
  $ADMIN_NIVO = explode('-',$A_NIVO);
 //updatujem poslednju posetu
  $sql2="UPDATE t_sesije_korisnici SET posl_vreme_pristupa = '".time()."' WHERE sesija = '".$LID."'";
  $rez2 = mysql_query($sql2);
  
  //brisem stara vremena (garbage collection):
  $rv = rand(1,20);
  if ($rv==10){$r3 = mysql_query("DELETE FROM t_sesije_korisnici WHERE  posl_vreme_pristupa < ".$mvreme);}
  
 // if (mysql_affected_rows($db)>0){echo "OK, novo vreme: " . time();}else{echo "greska kod updatea:" . $sql2. "<br>";}
} else {
 @header("location:login.php");
 exit;
}//mysql_num_rows


if(!$ID_KORISNIKA) {
@header("location:login.php");
exit;
};



unset($MAX_IDLE_VREME_SESIJE, $mvreme, $sql, $rez, $sql2, $rez2, $rv); 
} //if($proveri_sesiju)
?>