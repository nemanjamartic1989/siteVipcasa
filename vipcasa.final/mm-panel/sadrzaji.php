<?php

if (eregi("sadrzaji.php",$_SERVER['PHP_SELF'])) {

    @header("Refresh: 0; url=./");

    echo "<SCRIPT LANGUAGE='JavaScript'>";

    echo "document.location.href='./'";

    echo "</SCRIPT>";

    die();

    exit;

   }

   

function izbaci_internu_komandu($string, $start, $end){

       // $string = " ".$string;

        $ini = strpos($string,$start);

        if ($ini == 0) return "";

        $pdeo = substr($string,0,$ini);

        $ini += strlen($start);   

        $len = strpos($string,$end,$ini) - $ini;

        $pocddela = strpos($string,$end) + strlen($end);

        $duzina = strlen($string);

        $duzinaDDela = $duzina - $pocddela;

        $drugiDeo = substr($string,$pocddela,$duzinaDDela);

        //return substr($string,$ini,$len)." pos1=".strpos($string,$start)." pos2=".strpos($string,$end,$ini)." | ".$string . " prvideo=".$pdeo . " drugiDeo=".$drugiDeo;

        return $pdeo . $drugiDeo ;

}   

   

   

   



//ovde posle ubaciti proveru nivoa:







$id_elementa =  htmlspecialchars($_REQUEST['id_elementa']);



/* pretraga */

$naslov_sadrzi = htmlspecialchars($_POST['naslov_sadrzi']);

$tekst_sadrzi = htmlspecialchars($_POST['tekst_sadrzi']);

$tip_elementaSadr = htmlspecialchars($_POST['tip_elementaSadr']);

$jezikSadr = htmlspecialchars($_POST['jezikSadr']);



?>

<div id="navigacija_dole">

<div id="nav">

<ul id="navmenu-h"> 

<li><img align="left" src="./images/list.png" alt=""><a href="./index.php?modul=<?php echo $modul;?>&LID=<?php echo $LID;?>&akcija=novi">New content</a></li>

</ul>

</div>

</div>

<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >

<br />

<?php

//./?modul=$modul&LID=$LID&akcija=obrisi&id_elementa=$id_elementa

if($akcija == "obrisi"){

$sql = "DELETE FROM t_elementi_strane WHERE id_elementa= '".$id_elementa."'";

$rez = mysql_query($sql);

$sql = "DELETE FROM t_strana_delovi WHERE id_elementa= '".$id_elementa."'";

$rez = mysql_query($sql);

$akcija ="";

}//obrisi









if ($akcija == "dodaj"){

$id_elementa = $_POST['id_elementa'];

$tip_elementa = $_POST['tip_elementa'];

$naziv_elementa = $_POST['naziv_elementa'];

$sadrzaj = $_POST['sadrzaj'];

$sadrzaj_nohtml = $sadrzaj;



//izbacujem [komande]

$rezultat = 1;

while ($rezultat){ 

$rezultat = izbaci_internu_komandu($sadrzaj_nohtml, "[komanda]", "[/komanda]");

  if($rezultat){

     $sadrzaj_nohtml =     $rezultat; 

  }//if($rezutat)

}





//izbacujem formatiranja, tabove, prelome, redove, visak spaceova i html kod i ostavljam samo suv tekst za pretragu

while ($sadrzaj_nohtml != strip_tags($sadrzaj_nohtml)) {

  $sadrzaj_nohtml = strip_tags($sadrzaj_nohtml);

}



$sadrzaj_nohtml = preg_replace("/(\r\n|\n|\r|&nbsp;|\t)/", " ", $sadrzaj_nohtml);



while($sadrzaj_nohtml != str_replace("  ", " ", $sadrzaj_nohtml)){

$sadrzaj_nohtml = str_replace("  ", " ", $sadrzaj_nohtml);

}



$pretrazivo = $_POST['pretrazivo']; if(!$pretrazivo){$pretrazivo='0';}

$vreme = time();

$datum = date('Y-m-d');

$jezik = $_POST['jezik'];





if($id_elementa){ //izmena

$sql = "UPDATE t_elementi_strane SET tip_elementa='".$tip_elementa."', naziv_elementa='".sredi_upis($naziv_elementa)."', sadrzaj='".sredi_upis($sadrzaj)."', pretrazivo='".$pretrazivo."', vreme='".$vreme."', datum='".$datum."', sadrzaj_nohtml='".sredi_upis($sadrzaj_nohtml)."', jezik='".$jezik."'  WHERE id_elementa= '".$id_elementa."'";

$rez = mysql_query($sql);

//echo "<hr> ". $sql . " <hr>"; exit;



} else {//dodavanje

$sql = "INSERT INTO t_elementi_strane (tip_elementa, naziv_elementa, sadrzaj, pretrazivo, vreme, datum, sadrzaj_nohtml, jezik ) VALUES ('".$tip_elementa."', '".sredi_upis($naziv_elementa)."', '".sredi_upis($sadrzaj)."', '".$pretrazivo."', '".$vreme."', '".$datum."', '".sredi_upis($sadrzaj_nohtml)."','".$jezik."')";

$rez = mysql_query($sql);

$id_elementa = mysql_insert_id($db);

}//if



$akcija = 'novi';





}//dodaj



if ($akcija == "pretraga"){



if($naslov_sadrzi){$where .= " and naziv_elementa LIKE '%".$naslov_sadrzi."%' ";}

if($tekst_sadrzi){$where .= " and sadrzaj LIKE '%".$tekst_sadrzi."%' ";}

if($tip_elementaSadr){$where .= " and tip_elementa = '".$tip_elementaSadr."' ";}

if($jezikSadr){$where .= " and jezik = '".$jezikSadr."' ";}



$sql = "SELECT id_elementa, tip_elementa, naziv_elementa, pretrazivo, vreme 

FROM t_elementi_strane 

WHERE id_elementa > 0 ". $where ."  

";

$rez = mysql_query($sql);

if(mysql_num_rows($rez)>0){

echo "<table cellpadding=2 cellspacing=1 border=0 class=\"okvirche2\" align=center width=980px >";

echo "<thead><tr class=\"TD_OddRed\"><th class=\"klasicno\">ID</th><th class=\"klasicno\">Type</th><th class=\"klasicno\">Content title</th><th class=\"klasicno\">Searchable</th><th class=\"klasicno\">Last change</th><th class=\"klasicno\">Settings</th></tr></thead><tbody>";

while (list($id_elementa, $tip_elementa, $naziv_elementa, $pretrazivo, $vreme)=@mysql_fetch_row($rez)) {

if($pretrazivo){$pretrazivo="YES";} else {$pretrazivo="NO";}

echo "<tr class=\"TD_Even\"><td class=\"klasicno\">".$id_elementa."</td><td class=\"klasicno\" align=\"center\">".$TIP_ELEMENTA[$tip_elementa]."</td><td class=\"klasicno\">".$naziv_elementa."</td><td class=\"klasicno\" align=\"center\">".$pretrazivo."</td><td class=\"klasicno\" align=\"center\">".date('d.m.y (H:i:s)',$vreme)."</td>";



echo "<td class=\"klasicno\"><a class=\"meni\" href=\"./index.php?modul=sadrzaji&akcija=novi&id_elementa=$id_elementa&LID=$LID\"><img src=\"images/change.png\"> change</a></td>";



//echo "<td>[pregled/izmena]</td>";



echo "</tr>";

}//while

echo "</table><br>";

} else { echo "<div style=\"color:#FF0000; text-align:center;\"><b><font class=\"slovau\">- no result. please try again. - </font></b></div><br><br>"; $akcija = "";}//num_rows





}//pretraga



if(!$akcija){ //ako nema akcije, prikazujem formu za pretragu sadrzaja:

echo "<br>";

echo "<form action=\"./index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"formapret\">";

echo "<table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>

  <tr>";

echo "<td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Content search:</strong></td></tr>";



echo "<tr>

    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><input type=\"hidden\" value=\"pretraga\" name=\"akcija\">

<input type=\"hidden\" value=\"".$LID."\" name=\"LID\">

<input type=\"hidden\" value=\"".$modul."\" name=\"modul\">";





echo "<font class=\"slovau\">Content type:</font></td>";

$i=0;

echo "<td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><select class=\"select\" name=\"tip_elementaSadr\">";

echo "<option value=\"0\">- any -</option>";

foreach($TIP_ELEMENTA as $tipEl) {

if ($i>0){

if($tip_elementaSadr == $i){$sel = "selected";} else {$sel = "";}

echo "<option value=\"".$i."\" ".$sel.">".$tipEl."</option>";

}

$i++;

}

echo "</select></td></tr>";

//echo "<br><br>";



echo "<tr>

    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Language:</font></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";

$i=0;

echo "<select class=\"select\" name=\"jezikSadr\">";

echo "<option value=\"0\">- any -</option>";

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

    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">where title contains:</font></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";

echo "<input class=\"input\" type=\"text\" value=\"".$naslov_sadrzi."\" name=\"naslov_sadrzi\" size=\"40\"></td></tr>";



echo "<tr>

    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">where content text contains:</font></td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">";

echo "<input class=\"input\" type=\"text\" value=\"".$tekst_sadrzi."\" name=\"tekst_sadrzi\" size=\"40\"></td></tr>";



echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"></td>

    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\"><input class=\"btn\" type=\"submit\" value=\"Search\" name=\"submitPrik\" size=\"40\"></td></tr>";



echo "</table>";

echo "</form>";

echo "<br>";

}//!$akcija



if($akcija == 'novi'){

?>

 <script type="text/javascript" charset="utf-8">

        $().ready(function() {

           var opts = {

                    absoluteURLs: false,

                    cssClass : 'el-rte',

                    lang     : 'en',

                    allowSource : 1,  // allow user to view source

                    height   : 450,   // height of text area

                    toolbar  : 'complete',   // Your options here are 'tiny', 'compact', 'normal', 'complete', 'maxi', or 'custom'

                    cssfiles : ['./css/elrte-inner.css'],

                    // elFinder

                    fmAllow  : 1,

                    fmOpen : function(callback) {

                        $('<div id="myelfinder" />').elfinder({

                            url : './connectors/php/connector.php', // elFinder configuration file.

                            lang : 'en',

                            dialog : { width : 900, modal : true, title : 'Files' }, // Open in dialog window

                            closeOnEditorCallback : true, // Close after file select

                            editorCallback : callback     // Pass callback to file manager

                        })

                    }

                    //end of elFinder

                }

            $('#sadrzaj').elrte(opts);

<?php

if($id_elementa){

$sql = "SELECT  tip_elementa, naziv_elementa, sadrzaj, pretrazivo, vreme, jezik  

FROM t_elementi_strane 

WHERE id_elementa = '".$id_elementa."'";

$rez = mysql_query($sql);

if(mysql_num_rows($rez)>0){

list($tip_elementa, $naziv_elementa, $sadrzaj, $pretrazivo, $vreme, $jezik)=@mysql_fetch_row($rez);



} //mysql_num_rows

}//id_elementa

?>

})

    </script>

<?php

echo "<br>";

echo "<form action=\"./index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" onSubmit=\"if(\$('#naziv_elementaID').val()!=''){if(confirm('Accept?')){document.getElementById('submitDIV').innerHTML='Please wait...'; return true;} else {return false;}} else {alert('Please enter content title'); return false;}\">";

echo "<table class=\"okvirche\" width=\"980\" border=\"0\" align=\"center\" cellspacing=0><tr>";

echo "<td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Content form:</strong></td></tr><tr>";

echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><input type=\"hidden\" value=\"".$id_elementa."\" name=\"id_elementa\" id=\"id_elementaID\">

<input type=\"hidden\" value=\"dodaj\" name=\"akcija\">

<input type=\"hidden\" value=\"".$LID."\" name=\"LID\">

<input type=\"hidden\" value=\"".$modul."\" name=\"modul\">";



echo "<font class=\"slovau\">Type:</font></td></tr>";

$i=0;

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><select class=\"select\" name=\"tip_elementa\">";

foreach($TIP_ELEMENTA as $tipEl) {

if ($i>0){

if($tip_elementa == $i){$sel = "selected";} else {$sel = "";}

echo "<option value=\"".$i."\" ".$sel.">".$tipEl."</option>";

}

$i++;

}

echo "</select>";

echo "</td></tr>";



echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">language:</font></td></tr>";

$i=0;

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><select class=\"select\" name=\"jezik\">";

foreach($JEZICI as $tipEl) {

if ($i>0){

if($jezik == $i){$sel = "selected";} else {$sel = "";}

echo "<option value=\"".$i."\" ".$sel.">".$tipEl."</option>";

}

$i++;

}

echo "</select>";

echo "</td></tr>";



echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Content title:</font></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><input class=\"input\" type=\"text\" value=\"".htmlspecialchars($naziv_elementa)."\" name=\"naziv_elementa\" id=\"naziv_elementaID\" size=\"70\"></td></tr>";



echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">TEXT:</font></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";

echo "<textarea name=\"sadrzaj\" id=\"sadrzaj\" rows=\"8\" cols=\"80\">$sadrzaj</textarea>";

echo "</td></tr>";



echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><label><font class=\"slovau\">Searchable </font>";

if($pretrazivo){$chk="checked";} else {$chk="";}

echo "<input type=\"checkbox\" value=\"1\" name=\"pretrazivo\" id=\"pretrazivoID\" ".$chk."></label></td></tr>";



if($id_elementa && $vreme){

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">last change: ". date('d.m.y (H:i:s)',$vreme) ."</td></tr>";

}





echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><div id=\"submitDIV\"><input type=\"submit\" class=\"btn\" value=\"Accept changes\"> ";

if($id_elementa){echo " &nbsp; &nbsp; &nbsp; &nbsp;<input type=\"button\" class=\"btn\" value=\"Delete content\" onclick=\"if(confirm('Upozorenje!!\\nDelete?')){window.location='./index.php?modul=$modul&LID=$LID&akcija=obrisi&id_elementa=$id_elementa';}\">";}

echo "</div></td></tr></table>";

echo "</form>";





}//novi





?>