<?php

if (eregi("strane.php",$_SERVER['PHP_SELF'])) {

    @header("Refresh: 0; url=./");

    echo "<SCRIPT LANGUAGE='JavaScript'>";

    echo "document.location.href='./'";

    echo "</SCRIPT>";

    die();

    exit;

   }



//ovde posle ubaciti proveru nivoa:



$id_strane =  htmlspecialchars($_REQUEST['id_strane']);

$id_dela =  htmlspecialchars($_REQUEST['id_dela']);

$nadjiNaslov =  htmlspecialchars($_REQUEST['pretraziNaslov']);

$jezik = $_REQUEST['j'];





?>

<div id="navigacija_dole">

<div id="nav">

<ul id="navmenu-h"> 

<li><a href="./index.php?modul=<?php echo $modul;?>&LID=<?php echo $LID;?>">Page structure</a></li>

<li><a href="./index.php?modul=<?php echo $modul;?>&LID=<?php echo $LID;?>&akcija=novi&j=<?php echo $jezik; ?>">New page</a></li>

<li><a href="./index.php?modul=<?php echo $modul;?>&LID=<?php echo $LID; ?>&akcija=PretragaNaslova" />All pages list</a></li>

<li><form action="./index.php?modul=strane&akcija=PretragaNaslova&LID=<?php echo $LID;?>" method="post">&nbsp;&nbsp;<img src="./images/lupa.png" align="absmiddle" alt=""> &nbsp;&nbsp;<input type="text" name="pretraziNaslov" class="inpt_form" > &nbsp;<input type="submit" name="nadji" value="Find page" class="btn"></form></li>

</ul>

</div>

</div>

<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >

<br />

<?php

//./?modul=$modul&LID=$LID&akcija=izbaciDeo&id_dela=$id_dela&id_strane=$id_strane

if($akcija == "izbaciDeo" && $id_dela){

$sql = "DELETE FROM t_strana_delovi WHERE id_dela = '".$id_dela."'";

$rez = mysql_query($sql);

$akcija='novi';

}









//./?modul=$modul&LID=$LID&akcija=obrisi&id_strane=$id_strane

if($akcija == "obrisi"){

$sql = "DELETE FROM t_strana_delovi WHERE id_strane = '".$id_strane."'";

$rez = mysql_query($sql);

$sql = "DELETE FROM t_strane WHERE id_strane = '".$id_strane."'";

$rez = mysql_query($sql);

$akcija='';

}//obrisi













//./?modul=$modul&LID=$LID&akcija=dupliciraj&id_strane=$id_strane

if($akcija=="dupliciraj"){

$sql = "SELECT id_templata, naslov FROM t_strane WHERE id_strane = '".$id_strane."'";

$rez = mysql_query($sql);

if(mysql_num_rows($rez)>0){

list($id_templata, $naslov)=@mysql_fetch_row($rez);

} //mysql_num_rows



//otvaram novu stranu:

$sql = "INSERT INTO t_strane (id_templata, naslov, aktivna ) VALUES ('".$id_templata."', '".$naslov." (kopija)"."', '0')";

$rez = mysql_query($sql);

$id_nove_strane = mysql_insert_id($db);



//vadim staru stranu:

$sql = "SELECT id_dela,  id_elementa, id_sekcije, redosled FROM t_strana_delovi WHERE id_strane = '".$id_strane."'";

$rez = mysql_query($sql);

if(mysql_num_rows($rez)>0){

while (list($id_dela, $id_elementa, $id_sekcije,$redosled)=@mysql_fetch_row($rez)) {

$sql2 = "INSERT INTO t_strana_delovi (id_strane, id_elementa, id_sekcije, redosled ) VALUES ('".$id_nove_strane."', '".$id_elementa."', '".$id_sekcije."', '".$redosled."')";

$rez2 = mysql_query($sql2);

} //while

} //mysql_num_rows





//prikazujem novu stranu

$id_strane = $id_nove_strane;

$akcija = "novi";

}//dupliciraj























if(!$akcija){

$jezik = $_REQUEST['j'];

if(isset($jezik)){

$jezik = $_REQUEST['j'];}else{

    $jezik=2;

}

if($jezik==1){$selected1 = "selected"; $jez=119;}else{$selected1=" ";}

if($jezik==2){$selected2 = "selected"; $jez=1;}else{$selected2=" ";}

if($jezik==3){$selected2 = "selected"; $jez=142;}else{$selected3=" ";}

if($jezik==4){$selected2 = "selected"; $jez=142;}else{$selected4=" ";}



echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0><tr>";

echo "<td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><div id=\"sidetreecontrol\"><table border=\"0\" width=\"880\" align=\"left\" cellspacing=0><tr><td width=\"150\"><strong>Pages structure:</strong></td><td align=\"left\"><!--<a class=\"meni\" href=\"?#\">Close all</a> | <a class=\"meni\" href=\"?#\">Opet all</a>--></td><td align=\"right\"> <form name=\"jezik\">Language : <select name=\"jezik\" onchange=\"window.location.href='./index.php?modul=strane&LID=$LID&j='+this.options[this.selectedIndex].value;\"><option value =\"1\" $selected1>Srpski</option><option value =\"2\" $selected2>English</option><option value =\"3\" $selected3>Ruski</option></select></form></td></tr></table></div></td></tr><tr>";    

echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";

    $sql = "SELECT s.id_strane, s.naslov, s.id_templata, t.naziv_templata, s.aktivna , s.par

FROM t_strane s 

LEFT JOIN t_templati t on t.id_templata = s.id_templata

WHERE s.par=$jez

GROUP BY s.id_strane ORDER BY s.naslov";

$rez = mysql_query($sql);



if(mysql_num_rows($rez)>0){

echo "<div id=\"sidetree\"><ul class=\"treeview\" id=\"tree\">";

if($jezik==1){

echo "<li><a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_strane=119\">Naslovna</a></li>";

}

if($jezik==2){

echo "<li><a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_strane=1\">Home page</a></li>";

}



    while (list($id_strane, $naslov, $id_templata, $naziv_templata, $aktivna, $parent)=@mysql_fetch_row($rez)) {

        ///provera da li ima dece

        $sql2 = "SELECT s.id_strane, s.naslov, s.id_templata, t.naziv_templata, s.aktivna , s.par

FROM t_strane s 

LEFT JOIN t_templati t on t.id_templata = s.id_templata

WHERE s.par=$id_strane

GROUP BY s.id_strane ORDER BY s.naslov";

    $rez2 = mysql_query($sql2);      

        

        ///provera kraj

        

        if(mysql_num_rows($rez2)>0){

        echo "<li class=\"expandable\"><div class=\"hitarea expandable-hitarea\"></div>";

        }else{

            echo "<li>";

        }

echo "<a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_strane=$id_strane\">".$naslov."</a>";

if($aktivna==0){echo " (neaktivna)";}

    //drugi nivo

 

    if(mysql_num_rows($rez2)>0){

 

        echo "<ul style=\"display: none;\">";

        while (list($id_strane2, $naslov2, $id_templata2, $naziv_templata2, $aktivna2, $parent2)=@mysql_fetch_row($rez2)) {

                      ///provera da li ima dece dece

                      $sql3 = "SELECT s.id_strane, s.naslov, s.id_templata, t.naziv_templata, s.aktivna , s.par

                                FROM t_strane s 

                                LEFT JOIN t_templati t on t.id_templata = s.id_templata

                                WHERE s.par=$id_strane2

                                GROUP BY s.id_strane ORDER BY s.naslov";

                        $rez3 = mysql_query($sql3);            

        ///provera dece dece kraj

                     if(mysql_num_rows($rez3)>0)

                     {

                        echo "<li class=\"expandable\"><div class=\"hitarea expandable-hitarea\"></div>";

                    }else

                    {

                        echo "<li>";

                    }

            

            echo "<a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_strane=$id_strane2\">".$naslov2."</a>";

            if($aktivna2==0){echo "(neaktivna)";}

                if(mysql_num_rows($rez3)>0){

 

        echo "<ul style=\"display: none;\">";

        while (list($id_strane3, $naslov3, $id_templata3, $naziv_templata3, $aktivna3, $parent3)=@mysql_fetch_row($rez3)) {

            ///provera da li ima dece dece dece

                      $sql4 = "SELECT s.id_strane, s.naslov, s.id_templata, t.naziv_templata, s.aktivna , s.par

                                FROM t_strane s 

                                LEFT JOIN t_templati t on t.id_templata = s.id_templata

                                WHERE s.par=$id_strane3

                                GROUP BY s.id_strane ORDER BY s.naslov";

                        $rez4 = mysql_query($sql4);            

        ///provera dece dece dece kraj 

             if(mysql_num_rows($rez4)>0)

                     {

                        echo "<li class=\"expandable\"><div class=\"hitarea expandable-hitarea\"></div>";

                    }else

                    {

                        echo "<li>";

                    }

             echo "<a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_strane=$id_strane3\">".$naslov3."</a>";

             if($aktivna3==0){echo "(neaktivna)";}

             if(mysql_num_rows($rez3)>0){

                 echo "<ul style=\"display: none;\">";

        while (list($id_strane4, $naslov4, $id_templata4, $naziv_templata4, $aktivna4, $parent4)=@mysql_fetch_row($rez4)) {

            echo "<li>";

             echo "<a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_strane=$id_strane4\">".$naslov4."</a>";

            echo "</li>";

        }

        echo "</ul>";

                 

             }

             echo "</li>";

        

        }

            echo "</ul>";

            echo "</li>";

        }

        

        }

        echo "</ul>";

    }

    //drugi nivo kraj

echo"</li>";

        

} 

echo "</ul></div>";

} else {echo "No pages in database";} //mysql_num_rows



echo "</td></tr></table>";

}//!$akcija



//./?modul=strane&akcija=PretragaNaslova&LID=$LID

if($akcija == "PretragaNaslova"){

$sql = "SELECT s.id_strane, s.naslov, s.slug, s.id_templata, t.naziv_templata, s.aktivna , s.par, s.jezik 

FROM t_strane s 

LEFT JOIN t_templati t on t.id_templata = s.id_templata

WHERE s.naslov LIKE '%$nadjiNaslov%'

GROUP BY s.id_strane";

$rez = mysql_query($sql);

if(mysql_num_rows($rez)>0){

echo "<table cellpadding=2 cellspacing=1 class=\"okvirche2\" align=\"center\" width=\"900px\">";

echo "<thead><tr class=\"TD_OddRed\"><th class=\"klasicno\">ID</th><th class=\"klasicno\">Title</th><th class=\"klasicno\">Link</th><th class=\"klasicno\">Active</th><th class=\"klasicno\">Language</th><th class=\"klasicno\">Parent page</th></tr></thead><tbody>";

while (list($id_strane, $naslov, $slug, $id_templata, $naziv_templata, $aktivna, $parent, $jezik)=@mysql_fetch_row($rez)) {

    /*

    if($parent==1)

    {

        $prikaz_slug = "/".$slug;

    }else{

        $sql1 = "SELECT s.id_strane, s.naslov, s.slug FROM t_strane s WHERE s.id_strane='$parent' ";

        $rez1 = mysql_query($sql1);

        while (list($id_strane, $naslov, $slug)=@mysql_fetch_row($rez1)) {

            $prikaz_slug = $slug."/".$prikaz_slug;

        }

    }

    */

    echo "<tr class=\"TD_Even\"><td class=\"klasicno\">".$id_strane."</td><td class=\"klasicno\"><a class=\"meni\" href=\"./index.php?modul=$modul&LID=$LID&akcija=novi&id_strane=$id_strane\">".$naslov."</a></td><td class=\"klasicno\">";

    if($jezik==1){

        if($parent==0){

            $link = "/naslovna  (NASLOVNA SRPSKI)";

        }else{      

        if($parent==1){

        $link = "/".$slug;

        }else{

        $sql1 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$parent' ";

        $rez1 = mysql_query($sql1);

        while (list($id_strane2, $naslov2, $slug2, $par2)=@mysql_fetch_row($rez1)) {

            if($par2==1){

            $link = "/".$slug2."/".$slug;

            }else{

                $sql2 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par2' ";

                $rez2 = mysql_query($sql2);

                while (list($id_strane3, $naslov3, $slug3, $par3)=@mysql_fetch_row($rez2)) {

                    if($par3==1){

                    $link = "/".$slug3."/".$slug2."/".$slug;

                    }else{

                                $sql3 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par3' ";

                                $rez3 = mysql_query($sql3);

                                while (list($id_strane4, $naslov4, $slug4, $par4)=@mysql_fetch_row($rez3)) {

                                if($par4==1){

                                    $link = "/".$slug4."/".$slug3."/".$slug2."/".$slug;

                                    }

                                }

                        

                    }           

                }

            }

        }

    }

    }

        

    }else{

        if($parent==0){

            $link = "/eng  (NASLOVNA ENGLESKI)";

        }else{      

        if($parent==1){

        $link = "/".$slug;

        }else{

        $sql1 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$parent' ";

        $rez1 = mysql_query($sql1);

        while (list($id_strane2, $naslov2, $slug2, $par2)=@mysql_fetch_row($rez1)) {

            if($par2==1){

            $link = "/".$slug2."/".$slug;

            }else{

                $sql2 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par2' ";

                $rez2 = mysql_query($sql2);

                while (list($id_strane3, $naslov3, $slug3, $par3)=@mysql_fetch_row($rez2)) {

                    if($par3==1){

                    $link = "/".$slug3."/".$slug2."/".$slug;

                    }else{

                                $sql3 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par3' ";

                                $rez3 = mysql_query($sql3);

                                while (list($id_strane4, $naslov4, $slug4, $par4)=@mysql_fetch_row($rez3)) {

                                if($par4==1){

                                    $link = "/".$slug4."/".$slug3."/".$slug2."/".$slug;

                                    }

                                }

                        

                    }           

                }

            }

        }

    }

    }

        

    }

    

    

    echo $link;

    echo "</td><td class=\"klasicno\" align=\"center\">".$aktivna."</td>";

    if($jezik==0){

    echo "<td class=\"klasicno\" align=\"center\"><strong>Undefined</strong></td>";

    }

    if($jezik==1){

    echo "<td class=\"klasicno\" align=\"center\">Serbian</td>";

    }

    if($jezik==2){

    echo "<td class=\"klasicno\" align=\"center\">English</td>";

    }

    echo "<td class=\"klasicno\" align=\"center\">".$parent."</td></tr>";

} //while

echo "</tbody></table>";

} else {echo "No results. Please try again.";} //mysql_num_rows





}







//./?modul=strane&akcija=izaberiIDodajSadrzaj&id_strane=$id_sekcije&id_sekcije=$id_sekcije&LID=$LID&id_elementa=$id_elementa



if($akcija == "izaberiIDodajSadrzaj"){

$id_sekcije = htmlspecialchars($_REQUEST['id_sekcije']);

$id_elementa = htmlspecialchars($_REQUEST['id_elementa']);



//vadim koji je poslednji redosled u datoj sekciji date strane (dodajem element na kraj):

$sql = "SELECT max(redosled) maxR FROM t_strana_delovi WHERE id_strane='".$id_strane."' and id_sekcije= '".$id_sekcije."'";

$rez = mysql_query($sql);

if(mysql_num_rows($rez)>0){list($redosled)=@mysql_fetch_row($rez); if (!$redosled){$redosled=1;} else {$redosled++;}} else {$redosled=1;}



$sql = "INSERT INTO t_strana_delovi (id_strane, id_elementa, id_sekcije, redosled ) VALUES ('".$id_strane."', '".$id_elementa."', '".$id_sekcije."', '".$redosled."')";

$rez = mysql_query($sql);



$akcija = 'novi';



}//izaberiIDodajSadrzaj



















if($akcija == "dodaj"){

$id_strane = $_POST['id_strane'];

$id_templata = $_POST['id_templata'];

$naslov = $_POST['naslov'];

$slug = $_POST['slug'];

$ndr = $_POST['nadr'];

$jezikStrane = $_POST['jezikStrane'];

$strana_TITLE = $_POST['strana_TITLE'];

$strana_META_DISC = $_POST['strana_META_DISC'];

$jezikStrane = $_POST['jezikStrane'];

$aktivna = $_POST['aktivna']; if(!$aktivna){$aktivna = '0';}



// za nadredjenu  , par=".$ndr."

if($id_strane ){

$sql = "UPDATE t_strane SET id_templata='".$id_templata."', naslov='".sredi_upis($naslov)."', aktivna='".$aktivna."', par=".$ndr.", jezik=".$jezikStrane.", slug='".$slug."', TITLE='".$strana_TITLE."', META_DISC='".$strana_META_DISC."' WHERE id_strane= '".$id_strane."'";

$rez = mysql_query($sql);

} else {

$sql = "INSERT INTO t_strane (id_templata, naslov, aktivna, par, jezik, slug, TITLE, META_DISC) VALUES ('".$id_templata."', '".sredi_upis($naslov)."', '".$aktivna."', '1','".$jezikStrane."','".$slug."','".$strana_TITLE."','".$strana_META_DISC."')";

$rez = mysql_query($sql);

$id_strane = mysql_insert_id($db);

}//$id_strane 



$akcija = 'novi';

}//dodaj



//////////////NADREDJENA STRANICA//////////////////////////

/*

$query9 = "SELECT id_strane,naslov,par FROM t_strane order by naslov";

$query10 = "SELECT par FROM t_strane WHERE id_strane=$id_strane";

$rezultat = mysql_query($query9) or die(mysql_error());;

$rezultat10 = mysql_query($query10) or die(mysql_error());;

$options=" ";



    while ($row=mysql_fetch_array($rezultat10)) 

    {

        $nadredjena=$row["par"];

    }

*/

//////////////////////////////////////////////////////////////////









if($akcija == "novi"){



if($id_strane){

$query9 = "SELECT id_strane,naslov,slug,par FROM t_strane order by naslov";

$query10 = "SELECT par FROM t_strane WHERE id_strane=$id_strane";

$rezultat = mysql_query($query9) or die(mysql_error());;

$rezultat10 = mysql_query($query10) or die(mysql_error());;

$options=" ";



    while ($row=mysql_fetch_array($rezultat10)) 

    {

        $nadredjena=$row["par"];

    }

$sql = "SELECT s.naslov, s.slug, s.id_templata, t.naziv_templata, s.aktivna, s.jezik, s.TITLE, s.META_DISC, s.par 

FROM t_strane s 

LEFT JOIN t_templati t on t.id_templata = s.id_templata

WHERE s.id_strane = '".$id_strane."' 

GROUP BY s.id_strane ";

$rez = mysql_query($sql);

if(mysql_num_rows($rez)>0){

list($naslov, $slug, $id_templata, $naziv_templata, $aktivna, $jezik, $strana_TITLE, $strana_META_DISC, $roditelj_strana)=@mysql_fetch_row($rez);

} //mysql_num_rows

}//if id_strane

if($jezik==1){$selected1 = "selected";}else{$selected1=" ";}

if($jezik==2){$selected2 = "selected";}else{$selected2=" ";}

if($jezik==3){$selected3 = "selected";}else{$selected3=" ";}

if($jezik==4){$selected4 = "selected";}else{$selected4=" ";}

echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0><tr>";

echo "<td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>New page form:</strong></td></tr><tr>";

echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";

if(!$naziv_templata){$naziv_templata = "<a href=\"javascript:void(0);\" onClick=\"\$('#template_sel_div').load('ajax/strane_proc.php',{akcija: 'prikaziTemplate'}).fadeIn('slow');\">- click to choose template for this page -</a>";}



echo "<form action=\"./index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\" onSubmit=\"if(confirm('Accept changes?')){document.getElementById('submitDIV').innerHTML='Please wait...'; return true;} else {return false;}\">";

if($id_strane) {echo "<font class=\"slovau\">ID:".$id_strane."</font><br>";}

echo "<input type=\"hidden\" value=\"".$id_strane."\" name=\"id_strane\" id=\"id_straneID\">

<input type=\"hidden\" value=\"dodaj\" name=\"akcija\">

<input type=\"hidden\" value=\"".$LID."\" name=\"LID\">

<input type=\"hidden\" value=\"".$modul."\" name=\"modul\"><br>";

echo "<font class=\"slovau\">template:</font><div id=\"template_sel_div\" style=\"border:1px solid #cccccc; padding:3px;\">";

echo "<input class=\"input\" type=\"hidden\" value=\"".$id_templata."\" name=\"id_templata\" id=\"id_templataID\">

<font class=\"slovau\">".$naziv_templata. "

</font></div><td></tr><tr>";

echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Language:</font><br>";

echo "<select name=\"jezikStrane\"><option value=\"1\" $selected1 >Serbian</option><option value=\"2\" $selected2>English</option><option value =\"3\" $selected3>Ruski</option><option value =\"4\" $selected4>Slovenacki</option></select></td></tr><tr>";

echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Parent page:</font><br>";

echo "<select name=\"nadr\">";

echo "<OPTION VALUE=\"0\" >---This is homepage---</option>";

echo "<OPTION VALUE=\"0\" >---This is homepage (ENG)---</option>";

    while ($row=mysql_fetch_array($rezultat)) 

    {

        $ime1=$row["naslov"];

        $br1=$row["id_strane"];

        $mun=$row["par"];

        echo "<OPTION VALUE=\"$br1\" ";

        if($br1 == $nadredjena)

        {

        echo " selected";

        }

        echo ">".$ime1." | ".$br1." | ".$mun."</option>";

    }

    echo "</select></td></tr>";

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Page title:</font><br>";

echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($naslov)."\" name=\"naslov\" id=\"naslovID\" size=70></td></tr>";

//novo slug

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">Page link: (example: page-title)</font><br>";

echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($slug)."\" name=\"slug\" id=\"slugID\" size=70></td></tr>";

//slug kraj

//novo TITLE

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">TITLE (SEO)</font><br>";

echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($strana_TITLE)."\" name=\"strana_TITLE\" id=\"strana_TITLE\" size=70></td></tr>";

//TITLE kraj

//novo slug

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\">META DESCRIPTION (SEO)</font><br>";

echo "<input class=\"input\" type=\"text\" value=\"".htmlspecialchars($strana_META_DISC)."\" name=\"strana_META_DISC\" id=\"strana_META_DISC\" size=70></td></tr>";

//REDOSLED POD STRANA ZA LEVI MENI

/*

if($roditelj_strana==1){

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><font class=\"slovau\"><strong>SUBSIDIARY PAGE ORDER FOR LEFT MENU</strong></font><br>";

$sql_podstranice = "SELECT s.id_strane, s.naslov, s.redosled, s.par FROM t_strane s WHERE s.par = '".$id_strane."' ORDER BY s.redosled ";

$rez_podstranice = mysql_query($sql_podstranice);

if(mysql_num_rows($rez_podstranice)>0){

    $broj_podstrana=1;

while(list($id_podstrane, $naslov_podstrane, $redosled_podstranice, $roditelj)=@mysql_fetch_row($rez_podstranice)){

    $podstrane[$broj_podstrana]=$broj_podstrana;

    

    echo "<select name=\"redosled$id_podstrane\" >";

    for($i=1; $i<=8; $i++) {

        if($i==$redosled_podstranice){$selected_redosled_novo="selected=\"selected\"";}else{$selected_redosled_novo="";}

    echo "<option value=\"$i\" $selected_redosled_novo onClick=\"var novi_redosled=this.value; \$('#izmeni_redosled').load('ajax/strane_proc.php',{akcija: 'izmeni_redosled_podstrane', novi_redosled: novi_redosled, id_strane: '$id_podstrane', LID: '$LID'}).fadeIn('slow');\">$i</option>";

    }

    echo "</select>&nbsp;&nbsp;";

    

    echo $naslov_podstrane;

    echo "<br />";

    $broj_podstrana++;

    

}

} //mysql_num_rows

echo "<div id=\"izmeni_redosled\" style=\"color:red;\"></div>";

echo "</td></tr>";

}

*/

//REDOSLED KRAJ



//slug kraj

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><label><font class=\"slovau\">Active</font> ";

if($aktivna){$chk = "checked";} else {$chk = "";}

echo "<input class=\"input\" type=\"checkbox\" value=\"1\" name=\"aktivna\" id=\"aktivnaID\" $chk></label></td></tr><tr>";

echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><div id=\"submitDIV\"><input type=\"submit\" value=\"Accept\" class=\"btn\">";

if($id_strane) {

echo " &nbsp; &nbsp; &nbsp;";

echo " <input class=\"btn\" type=\"button\" value=\"Page preview\" onClick=\"window.open('../index.php?strana=".$id_strane."');\">";

echo " &nbsp; &nbsp; &nbsp;";

echo " <input class=\"btn\" type=\"button\" value=\"Sections preview\" onClick=\"window.open('../index.php?strana=".$id_strane."&prikSamoSekcije=1');\">";

echo " &nbsp; &nbsp; &nbsp;";

echo " <input class=\"btn\" type=\"button\" value=\"Duplicate this page\" onClick=\"if(confirm('Duplicate this page?')){window.location='./index.php?modul=$modul&LID=$LID&akcija=dupliciraj&id_strane=$id_strane';}\">";

echo " &nbsp; &nbsp; &nbsp;";

echo " <input class=\"btn\" type=\"button\" value=\"Delete page\" onClick=\"if(confirm('Delete?')){window.location='./index.php?modul=$modul&LID=$LID&akcija=obrisi&id_strane=$id_strane';}\">";

}

echo "</td></tr></table>";

echo "</form><br>";





if($id_strane){
$sql_subsidiary = "SELECT id_strane, naslov, redosled FROM t_strane WHERE par = '".$id_strane."' ORDER BY redosled, naslov";

$rez_subsidiary = mysql_query($sql_subsidiary);

if(mysql_num_rows($rez_subsidiary)>0){
    ?>
    <script type="text/javascript" src="reorder/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="reorder/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&page=<?php echo $id_strane; ?>'; 
            $.post("reorder/updateDB_subsidiary_reorder.php", order, function(theResponse){
                //$("#contentRight").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
    <?php
echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";    
echo "<tr><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>SUBSIDIARY PAGES (REORDER)</strong></td></tr>";
echo "<tr><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\">";
echo "<div id=\"contentLeft\">";
echo "<ul style=\"padding-left: 20px;\">";
while (list($id_sub_strane, $naziv_sub_strane)=@mysql_fetch_row($rez_subsidiary)) {
echo "<li style=\"cursor:pointer;\"  id=\"recordsArray_$id_sub_strane\">$naziv_sub_strane</li>";
}
echo "</ul>";
echo "</div>";
echo "</td></tr>";
echo "</table>";
echo "<br />";
}

echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0><tr>";    

//echo "<td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><div style=\"background-color:#f4f4f4;  padding:10px;\" id=\"sekcije_i_sadrzaji_div\">";

//echo "<div style=\"text-align:center;\"><b><font class=\"sekcije\">PAGE SECTIONS AND SECTIONS CONTENT</font></b></div></td></tr>";

//vadim sve sekcije u datom templatu:

$sqlT = "SELECT id_sekcije, naziv_sekcije FROM t_templati_sekcije WHERE id_templata = '".$id_templata."'";

$rezT = mysql_query($sqlT);

if(mysql_num_rows($rezT)>0){

while (list($id_sek, $naziv_sek)=@mysql_fetch_row($rezT)) {

echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><table cellpadding=2 cellspacing=0 class=\"okvirche\" align=center width=\"880\"><tr><td class=\"klasicno-sekcija\"><b>$naziv_sek</b></td><td class=\"klasicno-sekcija\" align=\"right\" style=\"padding-right:20px\" valign=\"middle\"><img  src=\"images/dodaj-novi.png\"> <a class=\"meni-sekcija\" href=\"javascript:void(0);\" onClick=\"\$('#sekcije_i_sadrzaji_div').hide(); \$('#izbor_sadrzaja_div').load('ajax/strane_proc.php',{akcija: 'prikaziSadrzajePretraga', id_sekcije:'".$id_sek."', id_strane:'".$id_strane."', LID:'".$LID."'}).fadeIn('slow');\">Choose and add content for this section</a></td></tr></table><br>";

//redjam elemente po redu sekcija

$sqlE = "SELECT e.tip_elementa, e.naziv_elementa, sd.id_elementa,

 sd.id_dela, sd.redosled 

FROM t_strana_delovi sd

LEFT JOIN t_elementi_strane e on e.id_elementa = sd.id_elementa

WHERE sd.id_sekcije = $id_sek and sd.id_strane = $id_strane

GROUP BY sd.id_dela

ORDER BY sd.redosled";

$rezE = mysql_query($sqlE);

if(mysql_num_rows($rezE)>0){

echo "<table cellpadding=2 cellspacing=2 border=0 id=\"tab".$id_sek."\">";

echo "<thead><tr><th class=\"klasicno\">content type</th><th class=\"klasicno\">name</th><th class=\"klasicno\">order</th><th class=\"klasicno\">options</th></tr></thead><tbody>";

while (list($tip_elementa, $naziv_elementa, $id_elementa, $id_dela, $redosled)=@mysql_fetch_row($rezE)) {

  echo "<tr  class=\"klasicno\" id=\"".$id_dela."\"><td class=\"klasicno\">".$tip_elementa."</td><td class=\"klasicno\">".$naziv_elementa."</td><td class=\"klasicno\">".$redosled."</td><td class=\"klasicno\"><a class=\"meni\" href=\"javascript:void(0);\" onClick=\"if(confirm('Remove content from the section?')){window.location='./index.php?modul=$modul&LID=$LID&akcija=izbaciDeo&id_dela=$id_dela&id_strane=$id_strane';}\"><img src=\"images/remove.png\">&nbsp; remove from section</a> &nbsp; <a class=\"meni\" href=\"./index.php?modul=sadrzaji&LID=$LID&id_elementa=$id_elementa&akcija=novi\" target=\"_blank\"><img src=\"images/change.png\">&nbsp; edit</a></td></tr>";

}//whileE

echo "</tbody></table>";



/*echo "<script>\$('#tab".$id_sek."').tableDnD({onDrop: function(table, row) {var e= \$.tableDnD.serialize();   \$.ajax({type: \"POST\", url: \"ajax/strane_proc.php?akcija=izmeniRedosled&id_sek=$id_sek\", data: e, success: function(msg){alert( 'Data Saved: ' + msg ); }}); }}); </script>";



\$.post('ajax/strane_proc.php?akcija=izmeniRedosled', function(data){alert('Vratilo se: ' + data);});

*/



echo "<script>\$('#tab".$id_sek."').tableDnD({onDrop: function(table, row) {var e= \$.tableDnD.serialize();  \$('#ajax_odgovor').load('ajax/strane_proc.php?akcija=izmeniRedosled&id_sek=$id_sek',{data:e});}}); </script>";



//$('#ajax_odgovor').load('serialize.php?'+e);



} else {echo "- no content - ";}//num_rowsE

echo "</td></tr>";

} //while

echo "</table>";



} //mysql_num_rows



echo "</div>";



echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0><tr><td>"; 

echo "<div style=\"background-color:#f4f4f4;  padding:10px; display:none;margin: 0px auto; width: 880px; \" id=\"izbor_sadrzaja_div\"></div></td></tr></table>";

}//$id_strane







}//novi





















?>       

<div id="ajax_odgovor"></div>

