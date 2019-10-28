<?php
//u promenljivoj $dodatneFunkcije definisati JavaScript funkcije koje idu u <head></head> dokumenta
$dodatneFunkcije .= "function prikaziLoad(id_diva){\r\n";
$dodatneFunkcije .= "document.getElementById(id_diva).innerHTML = '<img src=\"img/loading.gif\"><br><br>';\r\n"; 
$dodatneFunkcije .= "}\r\n";

// --------------------------------------------------------



if(!$modul){
echo "initSlideDownMenu();\r\n";
}





if ($modul == "kursna_lista") {
echo "$('#datum1ID').attachDatepicker();\r\n";
echo "$('#datum2ID').attachDatepicker();\r\n";
echo "initFormValidation();\r\n";
echo "initSlideDownMenu();\r\n";

if($akcija == "novi"){echo "$('#datumUnosID').attachDatepicker();\r\n";}

} // kursna lista 
 
 







if ($modul == "komitenti") {
 if(!$id_komitenta || $_REQUEST['id_komitenta']){$id_komitenta = $_REQUEST['id_komitenta'];}
 if(!$id_komitenta || $_REQUEST['komitent_pretraga_ID']){$id_komitenta = $_REQUEST['komitent_pretraga_ID'];}

 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "$('#komitent_pretraga').focus();\r\n";

 if(($akcija == "novi" && isset($id_komitenta)) || ($akcija == "dodaj" && isset($id_komitenta))) {
   echo "$('#komitentiTRDiv').load('ajax/ajax_komitenti.php',{akcija: 'prikaziTekuceRacune', id_komitenta: '$id_komitenta', korisnik:'$KORISNIK'}).fadeIn('slow');\r\n";
 
echo "$('#komitentiTELDiv').load('ajax/ajax_komitenti.php',{akcija: 'prikaziTelefone', id_komitenta: '$id_komitenta', korisnik:'$KORISNIK'}).fadeIn('slow');\r\n";

echo "$('#komitentiADRDiv').load('ajax/ajax_komitenti.php',{akcija: 'prikaziAdrese', id_komitenta: '$id_komitenta', korisnik:'$KORISNIK'}).fadeIn('slow');\r\n";

echo "$('#komitentiKONTDiv').load('ajax/ajax_komitenti.php',{akcija: 'prikaziKontakte', id_komitenta: '$id_komitenta', korisnik:'$KORISNIK'}).fadeIn('slow');\r\n";

/* primer ajax poziva sa izvrsavanjem funkcije kad se poziv zavrsi:
 $("#feeds").load("feeds.php", {limit: 25}, function(){
   alert("The last 25 entries in the feed have been loaded");
 });
*/
}//novi
}//komitenti
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
if ($modul == "artikli") {
if(!$id_artikla || $_REQUEST['id_artikla']){$id_artikla = $_REQUEST['id_artikla'];}
if(!$id_artikla || $_REQUEST['artikli_pretraga_ID']){$id_artikla = $_REQUEST['artikli_pretraga_ID'];}
echo "initFormValidation();\r\n";
echo "initSlideDownMenu();\r\n";
echo "document.getElementById('artikli_pretraga').focus();\r\n";

if($akcija == "novi" && isset($id_artikla)){//vadim da li je sklop pa ako jeste pozivam ajax
$sql = "SELECT da_li_je_sklop FROM t_artikli WHERE id_artikla = '".$id_artikla."'";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
list($da_li_je_sklop)=@mysql_fetch_row($rez);
} //mysql_num_rows
if($da_li_je_sklop){$zvatiAjax = 1;} else {$zvatiAjax = 0;}
}//novi & id_artikla


if($zvatiAjax) {
echo "$('#atrikliSklopDiv').load('ajax/ajax_artikli.php',{akcija: 'prikaziSklop', id_artikla: '$id_artikla', korisnik:'$KORISNIK'}).fadeIn('slow');\r\n"; 

$dodatneFunkcije .= "function osveziPrikazSklopa(){\r\n";
$dodatneFunkcije .= "$('#atrikliSklopDiv').load('ajax/ajax_artikli.php',{akcija: 'prikaziSklop', id_artikla: '$id_artikla', korisnik:'$KORISNIK'}).fadeIn('slow');\r\n"; 
$dodatneFunkcije .= "}\r\n";
 
 
/*echo "$('#atrikliIzborSklopDiv').load('ajax/ajax_artikli.php',{akcija: 'prikaziDetaljeArtikla', id_artikla: '1'}).fadeIn('slow');\r\n"; */
}//zvati ajax

} //modul == artikli
 
 
 
 
 
 
 
 
 
 
 
 if ($modul == "korisnici_sistema") {
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "document.getElementById('korisnici_pretraga').focus();\r\n";
 }
 
 
 
  if ($modul == "osnovni_podaci_o_firmi") {
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "document.getElementById('artikli_pretraga').focus();\r\n";
 }  
 
 
 
 if ($modul == "magacini") {
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "document.getElementById('magacini_pretraga').focus();\r\n";
 }
 
 
 
 
 
 
 
 
if ($modul == "prijem_robe") {
echo "$('#datum1ID').attachDatepicker();\r\n";
echo "$('#datum2ID').attachDatepicker();\r\n";
echo "initFormValidation();\r\n";
echo "initSlideDownMenu();\r\n";


if($akcija == 'pretraga'){
//echo "tablesortStyles($('#tabelaPretragaRezTi'));\r\n";
/*<script type="text/javascript" src="js/jquery.tablesort.stil.js"></script>*/
echo "$('#tabelaPretragaRezTi').tablesorter({widgets: ['zebra']});\r\n"; //

echo "$(\"#tabelaPretragaRezTi tbody tr\").hover(function(){\r\n";  
echo "$(this).addClass(\"tsorterover\");\r\n";  
echo "},function(){\r\n";   
echo "$(this).removeClass(\"tsorterover\"); \r\n";  
echo "});\r\n";

}//pretraga

if($akcija == "novi"){
echo "$('#datumPrijemniceID').attachDatepicker();\r\n";
echo "$('#datum_ulazne_faktureID').attachDatepicker();\r\n";

$id_prijemnice =  htmlspecialchars($_REQUEST['id_prijemnice']);
if($id_prijemnice){
echo "$('#podaciOKomitentuDiv').load('ajax/ajax_prijem_robe.php',{akcija: 'prikaziKomitenta', id_prijemnice: '".$id_prijemnice."', LID:'".$LID."'}).fadeIn('slow');\r\n";
echo "$('#prijemnicaMagPrijemaDiv').load('ajax/ajax_prijem_robe.php',{akcija: 'prikaziMagacin', id_prijemnice: '".$id_prijemnice."', LID:'".$LID."'}).fadeIn('slow');\r\n";

echo "$('#robaPrijemnicaDiv').load('ajax/ajax_prijem_robe.php',{akcija: 'prikaziRobuUPrijemnici', id_prijemnice: '".$id_prijemnice."', LID:'".$LID."'}, function(){tablesortStyles(\$('#robaPrijemnicaDiv'));}).fadeIn('slow'); ";



//sakrivam izbor komitenta i magacina:
echo "$('#divOdabirKomitentaID').hide();\r\n";
echo "$('#izborMagazinaPrijemaDiv').hide();\r\n";
}

}//novi

} // prijem_robe 











if ($modul == "izdavanje_robe") {
echo "$('#datum1ID').attachDatepicker();\r\n";
echo "$('#datum2ID').attachDatepicker();\r\n";
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
// echo "document.getElementById('artikli_pretraga').focus();\r\n";
 
 
 if($akcija == "novi" || $akcija == "dodaj"){
 echo "$('#datum_prometaID').attachDatepicker();\r\n";
 echo "$('#datum_valuteID').attachDatepicker();\r\n";
 echo "$('#datumFaktureID').attachDatepicker();\r\n";
 }//novi
 
 if($akcija == "pretraga" || $akcija == "dodaj"){
echo "$('#tabelaPretragaRezTi').tablesorter({widgets: ['zebra']});\r\n"; //
echo "$(\"#tabelaPretragaRezTi tbody tr\").hover(function(){\r\n";  
echo "$(this).addClass(\"tsorterover\");\r\n";  
echo "},function(){\r\n";   
echo "$(this).removeClass(\"tsorterover\"); \r\n";  
echo "});\r\n";
 }//pretraga
 
 
$id_fakture =  htmlspecialchars($_REQUEST['id_fakture']);
if($id_fakture){
echo "$('#podaciOKomitentuDiv').load('ajax/ajax_izdavanje_robe.php',{akcija: 'prikaziKomitenta', id_fakture: '".$id_fakture."', LID:'".$LID."'}).fadeIn('slow');\r\n";

echo "$('#fakturaMagIzdavanjaDiv').load('ajax/ajax_izdavanje_robe.php',{akcija: 'prikaziMagacin', id_fakture: '".$id_fakture."', LID:'".$LID."'}).fadeIn('slow');\r\n";

echo "$('#robaFakturaDiv').load('ajax/ajax_izdavanje_robe.php',{akcija: 'prikaziRobuUFakturi', id_fakture: '".$id_fakture."', LID:'".$LID."'}, function(){tablesortStyles(\$('#robaFakturaDiv'));}).fadeIn('slow'); ";



//sakrivam izbor komitenta i magacina:
echo "$('#divOdabirKomitentaID').hide();\r\n";
echo "$('#izborMagazinaPrijemaDiv').hide();\r\n";
}


} //izdavanje_robe









if ($modul == "lager") {
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "document.getElementById('artikli_pretraga').focus();\r\n";
 
if(!$akcija || $akcija == "pretraga" || $akcija =="detaljiArtikla"){
echo "$('#tabelaPretragaRezTi').tablesorter({widgets: ['zebra']});\r\n"; //

echo "$(\"#tabelaPretragaRezTi tbody tr\").hover(function(){\r\n";  
echo "$(this).addClass(\"tsorterover\");\r\n";  
echo "},function(){\r\n";   
echo "$(this).removeClass(\"tsorterover\"); \r\n";  
echo "});\r\n";
} //akcija
 
}//lager
 
 
 
 
 
 
 
 
if ($modul == "finansijska_kartica") {
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "document.getElementById('komitent_pretraga').focus();\r\n";
 
 if(!$akcija || $akcija == "pretraga" || $akcija =="detaljiArtikla"){
echo "$('#tabelaPretragaRezTi').tablesorter({widgets: ['zebra']});\r\n"; //

echo "$(\"#tabelaPretragaRezTi tbody tr\").hover(function(){\r\n";  
echo "$(this).addClass(\"tsorterover\");\r\n";  
echo "},function(){\r\n";   
echo "$(this).removeClass(\"tsorterover\"); \r\n";  
echo "});\r\n";
} //akcija
 
}//finansijska kartica 







if ($modul == "unos_zaduzenja") {
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "document.getElementById('komitent_pretraga').focus();\r\n";
 
if(!$akcija || $akcija == "pretraga"){
echo "$('#tabelaPretragaRezTi').tablesorter({widgets: ['zebra']});\r\n"; //

echo "$(\"#tabelaPretragaRezTi tbody tr\").hover(function(){\r\n";  
echo "$(this).addClass(\"tsorterover\");\r\n";  
echo "},function(){\r\n";   
echo "$(this).removeClass(\"tsorterover\"); \r\n";  
echo "});\r\n";
} //akcija
 
if($akcija == "novi"){
echo "$('#datum_zadID').attachDatepicker();\r\n";
echo "$('#datum_valuteID').attachDatepicker();\r\n";
} 
 
}//unos_zaduzenja 
 









if ($modul == "unos_razduzenja") {
 echo "initFormValidation();\r\n";
 echo "initSlideDownMenu();\r\n";
 echo "document.getElementById('komitent_pretraga').focus();\r\n";
 
if(!$akcija || $akcija == "pretraga"){
echo "$('#tabelaPretragaRezTi').tablesorter({widgets: ['zebra']});\r\n"; //

echo "$(\"#tabelaPretragaRezTi tbody tr\").hover(function(){\r\n";  
echo "$(this).addClass(\"tsorterover\");\r\n";  
echo "},function(){\r\n";   
echo "$(this).removeClass(\"tsorterover\"); \r\n";  
echo "});\r\n";
} //akcija
 
if($akcija == "novi"){
echo "$('#datum_zadID').attachDatepicker();\r\n";
echo "$('#datum_val_zadID').attachDatepicker();\r\n";
} 
 
}//unos_zaduzenja 

 
 
?>