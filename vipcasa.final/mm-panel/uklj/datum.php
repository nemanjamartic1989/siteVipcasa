<?php
$DATUM_CLASS = 1;

function mesecURec($br){
//pretvara broj meseca u srpski naziv
$meseciNiz[1]="Januar";$meseciNiz[2]="Februar";$meseciNiz[3]="Mart";$meseciNiz[4]="April";$meseciNiz[5]="Maj";$meseciNiz[6]="Jun";
$meseciNiz[7]="Jul";$meseciNiz[8]="Avgust";$meseciNiz[9]="Septembar";$meseciNiz[10]="Oktobar";$meseciNiz[11]="Novembar";$meseciNiz[12]="Decembar";

return $meseciNiz[$br];

}

function kreirajSelectDatum ($dSel, $mSel, $gSel, $rb, $pocGod, $class, $atributi){

if($class){$class = " class=\"".$class."\"";}
$NP = "";

$NP .= "<select name=\"dan".$rb."\" id=\"danID".$rb."\" ".$class." " .$atributi." >";
for ($i=1 ; $i<=31 ; $i++) {
 if($i == $dSel){$sel="selected";} else {$sel="";}
 if($i < 10){$dSr = '0'.$i;} else {$dSr = $i;}
$NP .= "<option value=\"".$dSr."\" ".$sel.">".$dSr."</option>";
}
$NP .= "</select>";



$NP .= "<select name=\"mesec".$rb."\"  id=\"mesecID".$rb."\" ".$class." " .$atributi."  >";
for ($i=1 ; $i<=12 ; $i++) {
 if($i == $mSel){$sel="selected";} else {$sel="";}
 if($i < 10){$mSr = '0'.$i;} else {$mSr = $i;}
$NP .= "<option value=\"".$mSr."\" ".$sel.">".mesecURec($i)."</option>";
}
$NP .= "</select>";

if(!$pocGod){$pocGod = date('Y');}
$krajGod = date('Y');
$NP .= "<select name=\"godina".$rb."\" id=\"godinaID".$rb."\" ".$class." " .$atributi."  >";
for ($i=$pocGod ; $i<=$krajGod ; $i++) {
 if($i == $gSel){$sel="selected";} else {$sel="";}
$NP .= "<option value=\"".$i."\" ".$sel.">".$i."</option>";
}
$NP .= "</select>";

return $NP;
}



function godinaOdMysql($mySqlDatum){
$podelj = explode('-',$mySqlDatum);
return $podelj[0];
}



function DDMMYYYY($parametar)
{
// formatiranje datuma iz "yyyy-mm-dd" formata u "dd.mm.yyyy"
$podelj = explode('-',$parametar);
$gpod=$podelj[0];$mpod=$podelj[1];$dpod=$podelj[2];
if (strlen($dpod) == 1) {$dpod = "0".$dpod;}
if (strlen($mpod) == 1) {$mpod = "0".$mpod;}
if (strlen($gpod) == 1) {$gpod = "200".$gpod;}
if (strlen($gpod) == 2) {if ($gpod > 35) {$gpod = "19".$gpod;} else {$gpod = "20".$gpod;}}
if (strlen($gpod) == 3) {if ($gpod > 935) {$gpod = "1".$gpod;} else {$gpod = "2".$gpod;}}
if (strlen($gpod) == 0) {$gpod = date('Y');}
if (@checkdate($mpod,$dpod,$gpod)){
$datumform = $dpod . "." . $mpod . "." . $gpod;
return $datumform;} else {return '-';}
}


function YYYYMMDD($parametar)
{
// formatiranje datuma iz dd.mm.yyyy formata u "yyyy-mm-dd" radi upisa u bazu
$podelj = explode('.',$parametar);
$dpod=$podelj[0];$mpod=$podelj[1];$gpod=$podelj[2];
if (strlen($dpod) == 1) {$dpod = "0".$dpod;}
if (strlen($mpod) == 1) {$mpod = "0".$mpod;}
if (strlen($gpod) == 1) {$gpod = "200".$gpod;}
if (strlen($gpod) == 2) {if ($gpod > 35) {$gpod = "19".$gpod;} else {$gpod = "20".$gpod;}}
if (strlen($gpod) == 3) {if ($gpod > 935) {$gpod = "1".$gpod;} else {$gpod = "2".$gpod;}}
if (strlen($gpod) == 0) {$gpod = date('Y');}
if (@checkdate($mpod,$dpod,$gpod)){
$datumform = $gpod . "-" . $mpod . "-" . $dpod;
return $datumform; } else {return '-';}
}


function u_stamp($ul_parametar)
{ //mysql datum u stamp
$podelj = explode('-',$ul_parametar);
$dpod=$podelj[2];$mpod=$podelj[1];$gpod=$podelj[0];
$rezxxyat= mktime(0,0,0,$mpod,$dpod,$gpod);
return $rezxxyat;
}

function u_stamp_plus1($ul_parametar)
{ //mysql datum u stamp
$podelj = explode('-',$ul_parametar);
$dpod=$podelj[2] + 1;$mpod=$podelj[1];$gpod=$podelj[0];
$rezxxyat= mktime(0,0,0,$mpod,$dpod,$gpod);
return $rezxxyat;
}

?>