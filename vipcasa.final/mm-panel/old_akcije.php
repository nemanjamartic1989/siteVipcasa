<?php
if (eregi("vesti.php",$_SERVER['PHP_SELF'])) {
    @header("Refresh: 0; url=./");
    echo "<SCRIPT LANGUAGE='JavaScript'>";
    echo "document.location.href='./'";
    echo "</SCRIPT>";
    die();
    exit;
   }

//ovde posle ubaciti proveru nivoa:

$id_vesti =  htmlspecialchars($_REQUEST['id_vesti']);

/* pretraga */
$naslov_sadrzi = htmlspecialchars($_POST['naslov_sadrzi']);
$tekst_sadrzi = htmlspecialchars($_POST['tekst_sadrzi']);
//$tip_elementaSadr = htmlspecialchars($_POST['tip_elementaSadr']);
$jezikSadr = htmlspecialchars($_POST['jezikSadr']);

?>
<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
<li><img align="left" src="../images/list.png" alt=""><a href="./index.php?modul=<?php echo $modul;?>&LID=<?php echo $LID;?>&akcija=novi">Nova akcija</a></li>
</ul>
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<?php
//./?modul=$modul&LID=$LID&akcija=obrisi&id_vesti=$id_vesti
if($akcija == "obrisi" && $id_vesti){
$sql = "DELETE FROM t_akcije WHERE id_vesti= '".$id_vesti."'";
$rez = mysql_query($sql);
$akcija ="";
}//obrisi














if ($akcija == "dodaj"){
$id_vesti = $_POST['id_vesti'];
$datum = $_POST['datum'];
$datum_mysql = YYYYMMDD($datum);
if(!$datum_mysql || $datum_mysql=="-"){$datum_mysql = date('Y-m-d');}
$naslov = $_POST['naslov'];
$teaser = $_POST['teaser'];
$vest_html = $_POST['vest_html'];
$sadrzaj_nohtml = $vest_html;
$kategorija_vesti = $_POST['katv']; if(!$kategorija_vesti){$kategorija_vesti=1;}
//akcije podaci
$cena_akcije = $_POST['cena'];
$vrednost_akcije = $_POST['vrednost'];
$popust_akcije = $_POST['popust'];
$usteda_akcije = $_POST['usteda'];
$trajanje_akcije = $_POST['trajanje'];

//izbacujem formatiranja, tabove, prelome, redove, visak spaceova i html kod i ostavljam samo suv tekst za pretragu
while ($sadrzaj_nohtml != strip_tags($sadrzaj_nohtml)) {
  $sadrzaj_nohtml = strip_tags($sadrzaj_nohtml);
}

$sadrzaj_nohtml = preg_replace("/(\r\n|\n|\r|&nbsp;|\t)/", " ", $sadrzaj_nohtml);

while($sadrzaj_nohtml != str_replace("  ", " ", $sadrzaj_nohtml)){
$sadrzaj_nohtml = str_replace("  ", " ", $sadrzaj_nohtml);
}

$vest_txt = $sadrzaj_nohtml;

$pretrazivo = $_POST['pretrazivo']; if(!$pretrazivo){$pretrazivo='0';}
$aktivna = $_POST['aktivna']; if(!$aktivna){$aktivna='0';}
$vreme_izmene = time();
$jezik = $_POST['jezik'];

//sredi_upis(

if($id_vesti){ //izmena
$sql = "UPDATE t_akcije SET vreme_izmene='".$vreme_izmene."', datum='".$datum_mysql."', naslov='".sredi_upis($naslov)."', teaser='".sredi_upis($teaser)."', vest_html='".sredi_upis($vest_html)."', vest_txt='".sredi_upis($vest_txt)."', jezik='".$jezik."', pretrazivo='".$pretrazivo."', aktivna='".$aktivna."', kategorija='".$kategorija_vesti."', cena='".$cena_akcije."', vrednost='".$vrednost_akcije."', popust='".$popust_akcije."', usteda='".$usteda_akcije."', trajanje='".$trajanje_akcije."'  WHERE id_vesti= '".$id_vesti."'";
$rez = mysql_query($sql);
//echo "<hr> ". $sql . " <hr>"; exit;

} else {//dodavanje
$sql = "INSERT INTO t_akcije (vreme_izmene, datum, naslov, teaser, vest_html, vest_txt, jezik, pretrazivo, aktivna, kategorija, cena, vrednost, popust, usteda, trajanje) VALUES ('".$vreme_izmene."', '".$datum_mysql."', '".sredi_upis($naslov)."', '".sredi_upis($teaser)."', '".sredi_upis($vest_html)."', '".sredi_upis($vest_txt)."', '".$jezik."', '".$pretrazivo."', '".$aktivna."', '".$kategorija_vesti."', '".$cena_akcije."', '".$vrednost_akcije."', '".$popust_akcije."', '".$usteda_akcije."', '".$trajanje_akcije."')";
$rez = mysql_query($sql);

$id_vesti = mysql_insert_id($db);
}//if

$akcija = 'novi';


}//dodaj













if ($akcija == "pretraga"){
$kategorija_vesti = $_POST['katv'];

if($naslov_sadrzi){$where .= " and naslov LIKE '%".$naslov_sadrzi."%' ";}
if($tekst_sadrzi){$where .= " and vest_txt LIKE '%".$tekst_sadrzi."%' ";}
if($kategorija_vesti){$where .= " and kategorija = '".$kategorija_vesti."' ";}
//if($tip_elementaSadr){$where .= " and tip_elementa = '".$tip_elementaSadr."' ";}
if($jezikSadr){$where .= " and jezik = '".$jezikSadr."' ";}

$sql = "SELECT id_vesti, DATE_FORMAT(datum,'%d.%m.%y') datumvesti, naslov, aktivna, pretrazivo, vreme_izmene, kategorija  
FROM t_akcije  
WHERE id_vesti > 0 ". $where ."  
ORDER BY datum DESC, vreme_izmene DESC";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
echo "<table cellpadding=2 cellspacing=0 border=0 class=\"okvirche\" align=center width=980px >";
echo "<thead><tr class=\"TD_OddRed\"><th class=\"klasicno\">ID</th><th class=\"klasicno\">datum</th><th class=\"klasicno\">naslov</th><th class=\"klasicno\">kategorija</th><th class=\"klasicno\">aktivna</th><th class=\"klasicno\">pretraživo</th><th class=\"klasicno\">vreme posl. izmene</th><th class=\"klasicno\">&nbsp;</th></tr></thead><tbody>";
while (list($id_vesti, $datumvesti, $naslov, $aktivna, $pretrazivo, $vreme_izmene, $katv)=@mysql_fetch_row($rez)) {
if($pretrazivo){$pretrazivo="DA";} else {$pretrazivo="NE";}
if($aktivna){$aktivnaD="DA";} else {$aktivnaD="NE";}
echo "<tr class=\"TD_Even\"><td class=\"klasicno\">".$id_vesti."</td><td class=\"klasicno\"align=\"center\">".$datumvesti."</td><td class=\"klasicno\">".$naslov."</td><td class=\"klasicno\">".$KATEGORIJE_AKCIJA[$katv]."</td><td class=\"klasicno\">".$aktivnaD."</td><td class=\"klasicno\">".$pretrazivo."</td><td class=\"klasicno\">".date('d.m.y (H:i:s)',$vreme_izmene)."</td>";

echo "<td class=\"klasicno\"><a class=\"meni\" href=\"./index.php?modul=akcije&akcija=novi&id_vesti=$id_vesti&LID=$LID\">[pregled/izmena]</a></td>";

//echo "<td>[pregled/izmena]</td>";

echo "</tr>";
}//while
echo "</table>";
echo "<br>";
} else { echo "<div style=\"color:#FF0000; text-align:center;\"><b>- ne postoje unete vesti koji zadovoljavaju kriterijum pretrage - </b></div><br><br>"; $akcija = "";}//num_rows


}//pretraga


















if(!$akcija){ //ako nema akcije, prikazujem formu za pretragu sadrzaja:
echo "<br>";
echo "<form action=\"./index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"formapret\">";

echo "<table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>";
echo "<td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Pretraga sadržaja:</strong></td></tr>";  

echo "<tr>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><input type=\"hidden\" value=\"pretraga\" name=\"akcija\">
<input type=\"hidden\" value=\"".$LID."\" name=\"LID\">
<input type=\"hidden\" value=\"".$modul."\" name=\"modul\">";

echo "<font class=\"slovau\">Kategorija akcije:</font></td>";
$i=0;
echo "<td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><select class=\"select\" name=\"katv\">";
echo "<option value=\"0\">- bilo koji -</option>";
foreach($KATEGORIJE_AKCIJA as $kvesti) {
if ($i>0){
if($kategorija == $i){$sel = "selected";} else {$sel = "";}
echo "<option value=\"".$i."\" ".$sel.">".$i.") ".$KATEGORIJE_AKCIJA[$i]."</option>";
}
$i++;
}
echo "</select></td></tr>";
//echo "<br><br>";

echo "<tr>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Jezik:</font></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";
$i=0;
echo "<select class=\"select\" name=\"jezikSadr\">";
echo "<option value=\"0\">- bilo koji -</option>";
foreach($JEZICI as $tipEl) {
if ($i>0){
if($jezikSadr == $i){$sel = "selected";} else {$sel = "";}
echo "<option value=\"".$i."\" ".$sel.">".$tipEl."</option>";
}
$i++;
}
echo "</select></td></tr>";
//echo "<br><br>";

echo "<tr>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">gde naslov sadrži:</font></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";
echo "<input class=\"input\" type=\"text\" value=\"".$naslov_sadrzi."\" name=\"naslov_sadrzi\" size=\"40\"></td></tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">gde tekst sadrži:</font></td>
<td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";
echo "<input class=\"input\" type=\"text\" value=\"".$tekst_sadrzi."\" name=\"tekst_sadrzi\" size=\"40\"></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"></td>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><input class=\"input\" type=\"submit\" value=\"Prikaži\" name=\"submitPrik\" size=\"40\"></td></tr>";

echo "</table>";
echo "</form>";
echo "<br>";


}//!$akcija




















if($akcija == 'novi'){
include ("fckeditor/fckeditor.php");

$FCK_vest_html = new FCKeditor('vest_html') ;
$FCK_akcija_opis_html = new FCKeditor('teaser') ;
$FCK_vest_html->BasePath = $PUTANJA_DO_WYSIWYG_EDITORA ;
$FCK_akcija_opis_html->BasePath = $PUTANJA_DO_WYSIWYG_EDITORA ;


$FCK_vest_html->Height = 400 ;
$FCK_akcija_opis_html->Height = 300;

if($id_vesti){
$sql = "SELECT datum, naslov, vest_html, pretrazivo, vreme_izmene, aktivna, jezik, teaser, kategorija, cena, vrednost, popust, usteda, trajanje      
FROM t_akcije 
WHERE id_vesti = '".$id_vesti."'";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
list($datum, $naslov, $vest_html, $pretrazivo, $vreme_izmene, $aktivna, $jezik, $teaser, $kategorija, $cena_akcije, $vrednost_akcije, $popust_akcije, $usteda_akcije, $trajanje_akcije)=@mysql_fetch_row($rez);
$datum = DDMMYYYY($datum);
$FCK_vest_html->Value = $vest_html;
$FCK_akcija_opis_html->Value = $teaser;
} //mysql_num_rows
}//id_vesti

echo "<form action=\"./index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" onSubmit=\"if(\$('#naziv_elementaID').val()!=''){if(confirm('Prihvatiti?')){document.getElementById('submitDIV').innerHTML='Sacekajte...'; return true;} else {return false;}} else {alert('Upisite nsalov vesti'); return false;}\">";
echo "<table class=\"okvirche\" width=\"980\" border=\"0\" align=\"center\" cellspacing=0><tr>";
echo "<td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Unos nove akcije:</strong></td></tr><tr>";
echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
echo "<input type=\"hidden\" value=\"".$id_vesti."\" name=\"id_vesti\" id=\"id_vestiID\">
<input type=\"hidden\" value=\"dodaj\" name=\"akcija\">
<input type=\"hidden\" value=\"".$LID."\" name=\"LID\">
<input type=\"hidden\" value=\"".$modul."\" name=\"modul\"><br>";

echo "<font class=\"slovau\">Kategorija akcije:</font><br>";
$i=0;
echo "<select     class=\"select\" name=\"katv\">";
//echo "<option value=\"0\">- bilo koji -</option>";
foreach($KATEGORIJE_AKCIJA as $kvesti) {
if ($i>0){
if($kategorija == $i){$sel = "selected";} else {$sel = "";}
echo "<option value=\"".$i."\" ".$sel.">".$i.") ".$KATEGORIJE_AKCIJA[$i]."</option>";
}
$i++;
}
echo "</select>";
echo "</td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Jezik:</font><br>";
$i=0;
echo "<select class=\"select\" name=\"jezik\">";
foreach($JEZICI as $tipEl) {
if ($i>0){
if($jezik == $i){$sel = "selected";} else {$sel = "";}
echo "<option value=\"".$i."\" ".$sel.">".$tipEl."</option>";
}
$i++;
}
echo "</select>";
echo "</td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Datum akcije:</font><br>";
if(!$datum){$datum = date('d.m.Y');}
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($datum)."\" name=\"datum\" id=\"datumID\" size=\"10\"></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Naslov akcije:</font><br>";
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($naslov)."\" name=\"naslov\" id=\"naslovID\" size=\"70\"></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Cena:</font><br>";
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($cena_akcije)."\" name=\"cena\" id=\"cenaID\" size=\"40\"></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Vrednost:</font><br>";
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($vrednost_akcije)."\" name=\"vrednost\" id=\"vrednostID\" size=\"30\"></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Popust:</font><br>";
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($popust_akcije)."\" name=\"popust\" id=\"popustID\" size=\"20\"></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Ušteda:</font><br>";
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($usteda_akcije)."\" name=\"usteda\" id=\"ustedaID\" size=\"20\"></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Trajanje akcije:</font><br>";
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($trajanje_akcije)."\" name=\"trajanje\" id=\"trajanjeID\" size=\"20\">dana</td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Kratak opis:</font><br>";
$FCK_akcija_opis_html->Create();
//echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($teaser)."\" name=\"teaser\" id=\"teaserID\" size=\"70\">";
echo "</td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Detaljan opis:</font><br>";
$FCK_vest_html->Create();
echo "</td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><label>tražiti po ovom sadržaju ";
if($pretrazivo){$chk="checked";} else {$chk="";}
echo "<input type=\"checkbox\" value=\"1\" name=\"pretrazivo\" id=\"pretrazivoID\" ".$chk."></label></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><label>aktivna ";
if($aktivna){$chk="checked";} else {$chk="";}
echo "<input class=\"input\" type=\"checkbox\" value=\"1\" name=\"aktivna\" id=\"aktivnaID\" ".$chk."></label></td></tr>";

if($id_vesti && $vreme_izmene){
echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Poslednje vreme izmene: ". date('d.m.y (H:i:s)',$vreme_izmene);
echo "</font></td></tr>";
}


echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><div id=\"submitDIV\"><input class=\"input\" type=\"submit\" value=\"Prihvati izmene\"> ";
if($id_vesti){echo " &nbsp; &nbsp; &nbsp; &nbsp;<input class=\"input\" type=\"button\" value=\"Obriši vest\" onclick=\"if(confirm('Upozorenje!!\\nObrisati vest?')){window.location='./index.php?modul=$modul&LID=$LID&akcija=obrisi&id_vesti=$id_vesti';}\">";}

echo "</div></td></tr></table>";
echo "</form>";


}//novi


?>