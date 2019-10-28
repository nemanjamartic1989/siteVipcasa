<?php
$db = @mysql_connect("localhost", "root", "gudex") OR DIE ("NEUSPELO POVEZIVANJE NA BAZU !");
@mysql_select_db("proba",$db);

$akcija=$_REQUEST['akcija'];
include ("fckeditor.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FckProba</title>
</head>

<body>
<?php

$pretraga=$_REQUEST['pretraga'];
//key polje
$id_vesti=$_REQUEST['id_vesti'];



// --------------------pretraga----------------------------
?>
<form name="formPretr" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input name="akcija" type="hidden" value="trazi">
<input name="pretraga" type="text" size="30" value="<?php echo $_REQUEST['pretraga']; ?>">
<input name="PretagaDugme" type="submit" value="Pretraga">
</form>
<?php
//------------------------pretraga kraj----------------------------



//----------------------------------------------------
if($akcija=="obrisi"){//brisanje
if($id_vesti){
$sql="DELETE FROM vesti WHERE id_vesti = '".$_REQUEST['id_vesti']."'";
$rez = @mysql_query($sql);
}//if id_vesti
$akcija="";
$id_vesti='';
}//$akcija=obrisi
//----------------------------------------------------



//-------------------------dodaj------------------------------
if($akcija=="dodaj"){//dodaj
if($id_vesti){//izmena
$sql="UPDATE vesti SET vest='" . sredi_upis($_POST['vest']) . "' WHERE id_vesti = '".$_REQUEST['id_vesti']."'";
$rez = @mysql_query($sql);
$id_vesti = $_REQUEST['id_vesti'];
} else {//dodavanje
$sql="INSERT INTO vesti (vest) VALUES  ('" . sredi_upis($_POST['vest']) . "' )";
$rez = @mysql_query($sql);
$id_vesti = @mysql_insert_id($db);
}//if $id_vesti



$akcija="trazi";  $traziPoId=1;
echo "<h2>Podatak je dodat / izmenjen....</h2>";
}//$akcija=dodaj
//-------------------------dodaj-kraj--------------------------



//-------------------------novi------------------------------
if($akcija=="novi"){//novi
$oFCKeditor = new FCKeditor('vest') ;
$oFCKeditor->BasePath = '/mm-panel/fckeditor/' ;
$id_vesti=$_REQUEST['id_vesti'];
if($id_vesti){//izmena
$sql="SELECT id_vesti, vest FROM vesti WHERE id_vesti='$id_vesti'";
$rez = @mysql_query($sql);
if(@mysql_num_rows($rez)>0){
list($id_vesti, $vest)= @mysql_fetch_row($rez);
$oFCKeditor->Value = $vest ;
}//num_rows
} else {$oFCKeditor->Value = '' ;} //if $id_vesti

$oFCKeditor->ToolbarSet        = 'Default' ;
$oFCKeditor->Height        = 400 ;


echo "<form name=\"form1\" method=\"post\" enctype=\"multipart/form-data\" action=\"".$_SERVER['PHP_SELF']."\" onSubmit=\"if(confirm('Prihvatiti?')){document.getElementById('submitDiv').innerHTML = ' <h2>Sacekajte, upload je u toku...</h2>'; return true;} else {return false;}\">";
echo "<input type=\"hidden\" name=\"akcija\" value=\"dodaj\">";
echo "<input type=\"hidden\" name=\"id_vesti\" value=\"$id_vesti\">";
echo "vest:<br>";
$oFCKeditor->Create() ;
echo "<br><br><input type=\"submit\" name=\"sub\" value=\"Prihvati\">";
echo " &nbsp; <input type=\"button\" name=\"odst\" value=\"Odustani\" onclick=\"document.location='".$_SERVER['PHP_SELF']."';\">";
echo "</form>";
$id_vesti='';
}//$akcija=novi
//-------------------------novi-kraj--------------------------



//------------------------------------------------------
if($akcija == "trazi"){//prikazuje rezultate
echo "<input type=\"button\" value=\"Novi\" onClick=\"document.location='".$_SERVER[PHP_SELF]."?akcija=novi';\"><br>";

if(!$traziPoId){
$sql="SELECT id_vesti, vest FROM vesti WHERE vest LIKE '%".$pretraga."%'";
} else {$sql="SELECT id_vesti, vest FROM vesti WHERE id_vesti ='".$id_vesti."'";}
$rez = @mysql_query($sql);
if(@mysql_num_rows($rez)>0){
echo "<table cellpadding=2 cellspacing=0 border=1>";
echo "<tr><th>id_vesti</th><th>vest</th></tr>";
while(list($id_vesti, $vest)= @mysql_fetch_row($rez)){
echo "<tr><td>$id_vesti</td><td>".$vest."</td>";
echo "<td><input type=\"button\" value=\"Izmeni\" onClick=\"document.location='".$_SERVER[PHP_SELF]."?akcija=novi&id_vesti=$id_vesti';\"></td>";
echo "<td><input type=\"button\" value=\"Obrisi\" onClick=\"if(confirm('Obrisati?')){document.location='".$_SERVER[PHP_SELF]."?akcija=obrisi&id_vesti=$id_vesti';}\"></td>";
echo "</tr>";
}//while
echo "</table>";
} else {echo "<h2>Nema rezultata za '$pretraga'</h2>";}//num_rows
}//!$akcija
//------------------------------------------------------


?>
</body>
</html>
