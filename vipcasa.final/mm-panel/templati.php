<?php
if (eregi("templati.php",$_SERVER['PHP_SELF'])) {
    @header("Refresh: 0; url=./");
    echo "<SCRIPT LANGUAGE='JavaScript'>";
    echo "document.location.href='./'";
    echo "</SCRIPT>";
    die();
    exit;
   }

//ovde posle ubaciti proveru nivoa:

$id_templata =  htmlspecialchars($_REQUEST['id_templata']);

?>
<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
<li><img src="./images/list.png" alt=""><a href="./index.php?modul=<?php echo $modul;?>&LID=<?php echo $LID;?>&akcija=novi">New template</a></li>
</ul>
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<?php
if(!$akcija){
$sql = "SELECT id_templata, procesor_strana, naziv_templata FROM t_templati ORDER BY naziv_templata";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
echo "<table cellpadding=2 cellspacing=0  class=\"okvirche\" align=center width=980px >";
echo "<thead><tr class=\"TD_OddRed\"><th class=\"klasicno\">ID </th><th class=\"klasicno\">template title</th><th class=\"klasicno\">proccessing page</th></tr></thead><tbody>";
while (list($id_templata, $procesor_strana, $naziv_templata)=@mysql_fetch_row($rez)) {
echo "<tr class=\"TD_Even\"><td class=\"klasicno\">".$id_templata."</td><td class=\"klasicno\"><a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_templata=$id_templata\">".$naziv_templata."</a></td><td class=\"klasicno\">".$procesor_strana."</td></tr>";
} //while
echo "</tbody></table>";
} else {echo "Nema unetih templata u bazi";} //mysql_num_rows


}//!$akcija





if($akcija == 'obrisiSekciju'){
//./?LID=$LID&modul=$modul&id_templata=$id_templata&akcija=obrisiSekciju&id_sekcije=$id_sekcije
$id_s = $_REQUEST['id_sekcije'];
$sql =  "DELETE FROM t_templati_sekcije WHERE id_sekcije = '".$id_s."'";
$rez = mysql_query($sql);
$akcija = 'novi';
}//obrisiSekciju






if($akcija == "dodajSekciju"){
$id_sekcije = $_POST['id_sekcije'];
$id_templata = $_POST['id_templata'];
$naziv_sekcije = $_POST['naziv_sekcije'];

if($id_sekcije){
$sql = "UPDATE t_templati_sekcije SET naziv_sekcije='".sredi_upis($naziv_sekcije)."' WHERE id_sekcije= '".$id_sekcije."'";
$rez = mysql_query($sql);
} else {
$sql = "INSERT INTO t_templati_sekcije (id_templata, naziv_sekcije ) VALUES ('".$id_templata."', '".sredi_upis($naziv_sekcije)."')";
$rez = mysql_query($sql);
$id_sekcije = mysql_insert_id($db);
}

$akcija = "novi";
}//dodajSekciju










//./?LID=$LID&modul=$modul&id_templata=$id_templata&akcija=novaSekcija&id_sekcije=$id_sekcije
if($akcija == "novaSekcija"){
$id_sekcije = htmlspecialchars($_REQUEST['id_sekcije']);

if($id_sekcije){
$sql = "SELECT naziv_sekcije 
FROM t_templati_sekcije 
WHERE id_sekcije = '".$id_sekcije."'";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
list($naziv_sekcije)=@mysql_fetch_row($rez);
} //mysql_num_rows
}//if id_sekcije

echo "<form action=\"./index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" onSubmit=\"if(confirm('Prihvatiti?')){document.getElementById('submitDIV').innerHTML='Sacekajte...'; return true;} else {return false;}\">";
echo "<table cellpadding=2 cellspacing=0  class=\"okvirche\" align=center width=980px >";
echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";
echo "<input type=\"hidden\" value=\"".$id_sekcije."\" name=\"id_sekcije\" id=\"id_sekcijeID\"><input type=\"hidden\" value=\"".$id_templata."\" name=\"id_templata\" id=\"id_templataID\">
<input type=\"hidden\" value=\"dodajSekciju\" name=\"akcija\">
<input type=\"hidden\" value=\"".$LID."\" name=\"LID\">
<input type=\"hidden\" value=\"".$modul."\" name=\"modul\">";

echo "<strong>Name of the section:</strong></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";
echo "<input class=\"klasicno\" type=\"text\" value=\"".htmlspecialchars($naziv_sekcije)."\" name=\"naziv_sekcije\" id=\"naziv_sekcijeID\" size=70></td>";
echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><div id=\"submitDIV\"><input type=\"submit\" value=\"Accept\">";
if($id_sekcije){
echo "<input class=\"klasicno\" type=\"button\" value=\"Obriši\" onClick=\"if(confirm('Obrisati?')){window.location='./index.php?LID=$LID&modul=$modul&id_templata=$id_templata&akcija=obrisiSekciju&id_sekcije=$id_sekcije';}\">";
}//id_sekcije
echo "</div></td></tr></table>";
echo "</form>";




}//novaSekcija












if($akcija == "dodaj"){
$id_templata = htmlspecialchars($_POST['id_templata']);
$procesor_strana = htmlspecialchars($_POST['procesor_strana']);
$naziv_templata = $_POST['naziv_templata'];

if($id_templata){
$sql = "UPDATE t_templati SET procesor_strana='".$procesor_strana."', naziv_templata='".sredi_upis($naziv_templata)."' WHERE id_templata= '".$id_templata."'";
$rez = mysql_query($sql);
} else {
$sql = "INSERT INTO t_templati (procesor_strana, naziv_templata ) VALUES ('".$procesor_strana."', '".sredi_upis($naziv_templata)."')";
$rez = mysql_query($sql);
$id_templata = mysql_insert_id($db);
}//if id_templata


$akcija = "novi";
}//dodaj












if($akcija == "novi"){

if($id_templata){
$sql = "SELECT procesor_strana, naziv_templata 
FROM t_templati 
WHERE id_templata = '".$id_templata."'";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
list($procesor_strana, $naziv_templata)=@mysql_fetch_row($rez);
} //mysql_num_rows
}//if id_templata


echo "<form action=\"./index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" onSubmit=\"if(confirm('Prihvatiti?')){document.getElementById('submitDIV').innerHTML='Please wait...'; return true;} else {return false;}\">";
echo "<table cellpadding=2 cellspacing=0  class=\"okvirche\" align=center width=980px >";
if($id_templata) {echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">ID:<td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">".$id_templata."</td></tr>";}
echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";
echo "<input type=\"hidden\" value=\"".$id_templata."\" name=\"id_templata\" id=\"id_templataID\">
<input type=\"hidden\" value=\"dodaj\" name=\"akcija\">
<input type=\"hidden\" value=\"".$LID."\" name=\"LID\">
<input type=\"hidden\" value=\"".$modul."\" name=\"modul\">";
echo "<font class=\"slovau\">Name of the template: </font></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";
echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($naziv_templata)."\" name=\"naziv_templata\" id=\"naziv_templataID\" size=70></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Proccessing page: </font></td>";
echo "<td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><input class=\"input\" type=\"text\" value=\"".$procesor_strana."\" name=\"procesor_strana\" id=\"procesor_stranaID\" size=50></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><div id=\"submitDIV\"><input class=\"klasicno\" type=\"submit\" value=\"Accept\"></div></td></tr></table>";
echo "</form>";


if($id_templata){
echo "<table cellpadding=2 cellspacing=0  class=\"okvirche\" align=center width=980px >";
echo "<tr><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\" size=\"300\"><strong>Sections</strong></td><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"></td></tr>";
echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" ><font class=\"slovau\">Sections for this template: </td><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><a class=\"meni\" href=\"./index.php?LID=$LID&modul=$modul&id_templata=$id_templata&akcija=novaSekcija\">add new section</a></font></td></tr><tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"></td><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";

$sql = "SELECT id_sekcije, naziv_sekcije 
FROM t_templati_sekcije 
WHERE id_templata = '".$id_templata."'";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
while (list($id_sekcije, $naziv_sekcije)=@mysql_fetch_row($rez)) {
echo "<a class=\"meni\" href=\"./index.php?LID=$LID&modul=$modul&id_templata=$id_templata&akcija=novaSekcija&id_sekcije=$id_sekcije\">".$naziv_sekcije."</a><br>";
} //while
} //mysql_num_rows
echo "</td></tr></table>";
}//if id_templata


}//novi










?>       
            
            
