<?php
header("Content-Type: text/html; charset=utf-8");
include("../uklj/baza_heder.php");
include("../uklj/datum.php");
include("../uklj/podesavanje.php");

$akcija = $_REQUEST['akcija'];
$LID =  htmlspecialchars(addslashes($_REQUEST['LID']));



$debug = 0;

if($akcija=='izmeni_redosled_podstrane'){
   $id_strane = $_REQUEST['id_strane'];
   $novi_redosled = $_REQUEST['novi_redosled'];
   $sql_azuriraj = "UPDATE t_strane SET redosled='$novi_redosled' WHERE id_strane='".$id_strane."'";
   $rez_azuriraj = mysql_query($sql_azuriraj);
   
echo "redosled izmenjen";
}

if($akcija=='prikaziTemplate'){

$sql = "SELECT id_templata, naziv_templata FROM t_templati ORDER BY naziv_templata";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
echo "Choose template: <br><br>";
while (list($id_templata, $naziv_templata)=@mysql_fetch_row($rez)) {
echo "<a href=\"javascript:void(0);\" onClick=\"\$('#template_sel_div').load('ajax/strane_proc.php',{akcija: 'odaberiTemplate', id_templata:'".$id_templata."'}).fadeIn('slow');\">".$naziv_templata."</a> | ";
} //while
} else {echo "<a href=\"javascript:void(0);\" onClick=\"\$('#template_sel_div').load('ajax/strane_proc.php',{akcija: 'prikaziTemplate'}).fadeIn('slow');\">- click to choose template for this page -</a><br><br>Template list empty. Please create template first.<br>";
} //mysql_num_rows

}//prikaziTemplate 







if($akcija=='odaberiTemplate'){
$id_templata = $_REQUEST['id_templata'];
$sql = "SELECT naziv_templata FROM t_templati WHERE id_templata='".$id_templata."'";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
list($naziv_templata)=@mysql_fetch_row($rez);
}

echo "<a href=\"javascript:void(0);\" onClick=\"\$('#template_sel_div').load('ajax/strane_proc.php',{akcija: 'prikaziTemplate'}).fadeIn('slow');\">".
$naziv_templata . " 
</a>";
echo "<input type=\"hidden\" value=\"".$id_templata."\" name=\"id_templata\" id=\"id_templataID\">";
echo "<br><br>";

}//odaberiTemplate















//akcija: 'prikaziSadrzaje', id_sekcije:'".$id_sek."', id_strane:'".$id_strane."'
if($akcija=='prikaziSadrzaje'){

$id_sekcije = htmlspecialchars($_REQUEST['id_sekcije']);
$id_strane = htmlspecialchars($_REQUEST['id_strane']);
$naslovSadrzi = htmlspecialchars($_REQUEST['naslovSadrzi']);
$tekstSadrzi = htmlspecialchars($_REQUEST['tekstSadrzi']);
$tip_elementa = htmlspecialchars($_REQUEST['tip_elementa']);

echo "<input type=\"button\" class=\"btn\" value=\"back\" onclick=\"\$('#izbor_sadrzaja_div').load('ajax/strane_proc.php',{akcija: 'prikaziSadrzajePretraga', id_sekcije:'".$id_sekcije."', id_strane:'".$id_strane."', LID:'".$LID."'}).fadeIn('slow');\">";

echo "&nbsp; &nbsp; &nbsp; <input type=\"button\" class=\"btn\" value=\"cancel\" onClick=\"\$('#izbor_sadrzaja_div').hide(); \$('#sekcije_i_sadrzaji_div').fadeIn('slow');\"> ";


if($tip_elementa){$whereTE = " and tip_elementa = '".$tip_elementa."' ";}
if($naslovSadrzi){$whereNS = " and naziv_elementa LIKE '%".$naslovSadrzi."%' ";}
if($tekstSadrzi){$whereTS = " and sadrzaj LIKE '%".$tekstSadrzi."%' ";}


//vadim sadrzaje za odredjeni tip elementa:
$sql = "SELECT id_elementa, naziv_elementa, pretrazivo, vreme 
FROM t_elementi_strane 
WHERE id_elementa > 0  $whereTE $whereNS $whereTS 
ORDER BY vreme DESC";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){
echo "<table cellpadding=2 cellspacing=1 border=0 width=\"100%\" class=\"okvirce2\" style=\"margin-top:10px\">";
echo "<thead><tr class=\"TD_OddRed\"><th class=\"klasicno\">Id</th><th class=\"klasicno\">Conent title</th><th class=\"klasicno\">Searchable</th><th class=\"klasicno\">Last change</th><th class=\"klasicno\">Options</th></tr></thead><tbody>";
while (list($id_elementa, $naziv_elementa,  $pretrazivo, $vreme)=@mysql_fetch_row($rez)) {
if($pretrazivo){$pretrazivo="YES";} else {$pretrazivo="NO";}
echo "<tr class=\"TD_Even\"><td class=\"klasicno\">".$id_elementa."</td><td class=\"klasicno\">".$naziv_elementa."</td><td class=\"klasicno\">".$pretrazivo."</td><td class=\"klasicno\">".date('d.m.y (H:i:s)',$vreme)."</td>";

echo "<td class=\"klasicno\">
<a class=\"meni\" href=\"./index.php?modul=strane&akcija=izaberiIDodajSadrzaj&id_strane=$id_strane&id_sekcije=$id_sekcije&LID=$LID&id_elementa=$id_elementa\"><img src=\"images/add.png\">&nbsp;Choose</a>&nbsp;

<a class=\"meni\" href=\"./index.php?modul=sadrzaji&akcija=novi&id_elementa=$id_elementa&LID=$LID\" target=\"_blank\"><img src=\"images/change.png\">&nbsp;Edit</a>

</td>";



echo "</tr>";
} //while
echo "</tbody></table>";
} else {echo "<br><h2>- list empty -</h2> ";} //mysql_num_rows



}//prikaziSadrzaje














//prikaziSadrzajePretraga', id_sekcije:'".$id_sek."', id_strane:'".$id_strane."', LID:'".$LID."
if($akcija=='prikaziSadrzajePretraga'){
$id_sekcije = htmlspecialchars($_REQUEST['id_sekcije']);
$id_strane = htmlspecialchars($_REQUEST['id_strane']);



echo "<h2>Content search</h2>";
echo "<form action=\"./\" method=\"post\" enctype=\"multipart/form-data\" name=\"formapret\">";

echo "type of content:<br>";
$i=0;
echo "<select name=\"tip_elementaSadr\" id=\"tipElementaSadrID\">";
echo "<option value=\"0\">- any -</option>";
foreach($TIP_ELEMENTA as $tipEl) {
if ($i>0){
if($tip_elementaSadr == $i){$sel = "selected";} else {$sel = "";}
echo "<option value=\"".$i."\" ".$sel.">".$tipEl."</option>";
}
$i++;
}
echo "</select>";
echo "<br><br>";

echo "where :<br>";
echo "<input type=\"text\" value=\"\" id=\"naslovSadrziID\" size=\"40\"><br><br>";

echo "where title contain:<br>";
echo "<input type=\"text\" value=\"\" id=\"tekstSadrziID\" size=\"40\"><br><br>";

echo "<input type=\"button\" class=\"btn\" value=\"Search\" name=\"submitPrik\" onClick=\"\$('#izbor_sadrzaja_div').load('ajax/strane_proc.php',{akcija: 'prikaziSadrzaje', id_sekcije:'".$id_sekcije."', id_strane:'".$id_strane."', LID:'".$LID."', tip_elementa:\$('#tipElementaSadrID').val(), naslovSadrzi:\$('#naslovSadrziID').val(), tekstSadrzi:\$('#tekstSadrziID').val()}).fadeIn('slow');\"><br><br>";

echo "<input type=\"button\" class=\"btn\" value=\"cancel\" onClick=\"\$('#izbor_sadrzaja_div').hide(); \$('#sekcije_i_sadrzaji_div').fadeIn('slow');\">  <br>";


echo "</form>";

}//prikaziSadrzajePretraga

















if($akcija=='izmeniRedosled'){
$id_sek = $_REQUEST['id_sek'];
$data = $_POST['data'];
$nazivTabele = "tab".$id_sek;

//echo "sekcija: $id_sek, podaci: $data";

$dataex = explode('*',$data);
//echo "Novi redosled za sekciju $id_sek :";
$i=0;
foreach($dataex as $noviRed){$i++;
          //menjam redosled u bazi:
          //echo "d: " . $noviRed.'='.$i . "; ";
          
//menjam u bazi:
$sql = "UPDATE t_strana_delovi SET redosled = '".$i."' WHERE id_dela = '".$noviRed."'";    
$rez = mysql_query($sql);
  

}//foreach
echo "Order changed... ";    

}



?>

