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
?>
<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
<li><a href="./index.php?modul=galerija_dog&stavka=4&LID=<?php echo $LID; ?>">Lista slika</a></li>
<li><a href="./index.php?modul=galerija_dog&stavka=1&LID=<?php echo $LID; ?>">Ubaci sliku</a></li>
</ul>
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<?php
if(isset($_GET['stavka']))
{
$stavka = $_GET['stavka'];
if($stavka==1){ //Ubacivanje korisnika (Stavka br.1)


    $upit_akcija = "SELECT id_vesti, naslov FROM t_vesti";
    $result_akcija = mysql_query($upit_akcija) or die(mysql_error());;
    
echo "<br>";
//#./?modul=korisnici&ubaciK=1&LID=$LID\
echo "<form action=\"index.php?modul=galerija_dog&LID=$LID\" enctype=\"multipart/form-data\" method=\"POST\">";
echo "<table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Ubacivanje slike:</strong></td>
  </tr>
    <tr>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">Dogadjaj:</td>
    <td class=\"TD_EvenNew\" width=\"250\">";

   echo "<select name=\"akcija\">";
   echo "<OPTION VALUE=0>Izaberi...</option>";
    while ($row=mysql_fetch_array($result_akcija)) 
    {
        $id_a=$row["id_vesti"];
        $naziv=$row["naslov"];
        echo "<OPTION VALUE=\"$id_a\">".$naziv."</option>";
    }
    echo "</select></td></tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Datum:</td>
    <td class=\"TD_EvenNew\"><input class=\"input\" type=\"text\" value=\"".date('d.m.Y')."\" name=\"datum\" size=\"40\"></td>
  </tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Naziv slike:</td>
    <td class=\"TD_EvenNew\"><input class=\"input\" type=\"text\" value=\"\" name=\"nazivSlike\" size=\"40\"></td>
  </tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Opis slike:</td>
    <td class=\"TD_EvenNew\"><input class=\"input\" type=\"text\" value=\"\" name=\"opisSlike\" size=\"40\"></td>
  </tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Izaberite fajl (jpg):</td>
    <td class=\"TD_EvenNew\"><input name=\"uploaded\" type=\"file\" /></td>
  </tr>";

echo "  <tr>
    <td class=\"TD_EvenNew\"></td>
    <td class=\"TD_EvenNew\"><input type=\"submit\" name=\"Submit\" value=\"Sačuvaj\" /></td>
  </tr></table></form>";
}
}




//Ubacivanje slike
if(isset($_POST['Submit']))
{
    $akcija = $_POST['akcija'];
    $datum = $_POST['datum'];
    $nazivSlike = $_POST['nazivSlike'];
    $opisSlike = $_POST['opisSlike'];
    //$kategorija = $_POST['kategorija'];
    $uploadedfile = $_FILES['uploaded']['tmp_name'];
    $nazivIMG = $_FILES['uploaded']['name']; 
     
    //echo "<br>";
    $datum_mysql = YYYYMMDD($datum); 
    
    $neki_broj = rand();
    $novi_naziv_fajla = $akcija."-".$neki_broj;
    
    $sqlSLIKE = "INSERT INTO galerija_dog (akcija, datum, title, opis, thumb, img) VALUES ('".$akcija."', '".$datum_mysql."', '".$nazivSlike."', '".$opisSlike."', 'thumb_".$novi_naziv_fajla."', '".$novi_naziv_fajla."')";
//$rez = mysql_query($sqlSLIKE);
    
    if($rez = mysql_query($sqlSLIKE))
    {
    echo "<br><br><table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Uspesno ubacene informacije o slici u bazu podataka.</strong></td>
  </tr></table>";
    }else
    {
        echo "<table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>!!!!Greska u ubacivanju,proverite unos!!!!</strong></td>
  </tr></table>";
    }
    
    
    //////////SLIKAAAA POCETAK
    $uploadedfile = $_FILES['uploaded']['tmp_name'];
    $nazivSlike = $_FILES['uploaded']['name'];

    $src = imagecreatefromjpeg($uploadedfile);
    $src_full = imagecreatefromjpeg($uploadedfile);

    list($width,$height)=getimagesize($uploadedfile);

    
    $newwidth=50;
    
    $newheight=50;
    
    //$newheight=98;
    $tmp=imagecreatetruecolor($newwidth,$newheight);
    
    $tmp_full=imagecreatetruecolor($width,$height);

    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
    
    imagecopyresampled($tmp_full,$src_full,0,0,0,0,$width,$height,$width,$height);

    $filename = "../events/thumbs/thumb_". $novi_naziv_fajla.".jpg";
    
    $filename_full = "../events/". $novi_naziv_fajla.".jpg";
    
    imagejpeg($tmp,$filename,100);
    
    imagejpeg($tmp_full,$filename_full,100);

    imagedestroy($src);
    imagedestroy($tmp);
    
    imagedestroy($src_full);
    imagedestroy($tmp_full);
    echo "<br><br><table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Slika snimljena na server.</strong></td>
  </tr></table>";
////////SLIKA KRAJ
}
echo "<p align=\"center\"><font><strong>".$problem."</strong></font></p>";


///////GENERISANJE XML FAJLA
$stavka = $_GET['stavka'];



////////////BRISANJE SLIKE
if($stavka==4){ //BRISANJE SLIKE
$brisanjeS = "SELECT g.id_g, g.datum, g.title, g.opis, g.thumb, g.img, a.naslov
                FROM galerija_dog g, t_vesti a
                WHERE g.akcija = a.id_vesti
                ORDER BY g.akcija";
    $rezultat = mysql_query($brisanjeS) or die(mysql_error());;     

    echo "<table class=\"okvirche\" width=\"980\" border=\"0\" align=\"center\" cellspacing=0>";
    echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>ID</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Datum</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Opis</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Fajl</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Smestaj</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Brisanje</strong></td>
    
  </tr>";
while ($red=mysql_fetch_array($rezultat)) 
    {
        $datum=$red["datum"];
        $naslov=$red["title"];
        $id=$red["id_g"];
        
        $opis=$red["opis"];
        $thumb=$red["thumb"];
        $img=$red["img"];
        
        $akcija_naziv=$red["naslov"];
        
        $broj = 1;
        echo"<tr>";
    echo "<td class=\"TD_EvenNew\">$id</td>
    <td class=\"TD_EvenNew\">$datum</td>
    <td class=\"TD_EvenNew\">$naslov</td>
    <td class=\"TD_EvenNew\">$opis</td>
    <td class=\"TD_EvenNew\"><img  hspace=\"0\" border=\"0\" src=\"../events/thumbs/$thumb.jpg\" alt=\"\" /></td>
    <td class=\"TD_EvenNew\">$akcija_naziv</td>
    <td class=\"TD_EvenNew\"><a class=\"meni\" href=\"./index.php?modul=galerija_dog&stavka=5&c=$id&LID=$LID\">Obrisi</a></td>
  </tr>";
        
    }
    echo "</table>";
}

if($stavka==5){ //BRISANJE SLIKE
$brojche = $_GET['c'];

$brisanjeSL = "DELETE FROM galerija_dog WHERE id_g= '".$brojche."'";
    
    if($rezSL = mysql_query($brisanjeSL))
    {
    $brisanjeS = "SELECT g.id_g, g.datum, g.title, g.opis, g.thumb, g.img, a.naslov
                FROM galerija_dog g, t_vesti a
                WHERE g.akcija = a.id_vesti
                ORDER BY g.akcija";
    $rezultat = mysql_query($brisanjeS) or die(mysql_error());;     

    echo "<table class=\"okvirche\" width=\"980\" border=\"0\" align=\"center\" cellspacing=0>";
    echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>ID</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Datum</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Opis</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Fajl</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Smestaj</strong></td>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Brisanje</strong></td>
    
  </tr>";
while ($red=mysql_fetch_array($rezultat)) 
    {
        $datum=$red["datum"];
        $naslov=$red["title"];
        $id=$red["id_g"];
        
        $opis=$red["opis"];
        $thumb=$red["thumb"];
        $img=$red["img"];
        
        $akcija_naziv=$red["naslov"];
        
        $broj = 1;
        echo"<tr>";
    echo "<td class=\"TD_EvenNew\">$id</td>
    <td class=\"TD_EvenNew\">$datum</td>
    <td class=\"TD_EvenNew\">$naslov</td>
    <td class=\"TD_EvenNew\">$opis</td>
    <td class=\"TD_EvenNew\"><img hspace=\"0\" border=\"0\" src=\"/events/thumbs/$thumb.jpg\" alt=\"\" /></td>
    <td class=\"TD_EvenNew\">$akcija_naziv</td>
    <td class=\"TD_EvenNew\"><a class=\"meni\" href=\"./index.php?modul=galerija_dog&stavka=5&c=$id&LID=$LID\">Obrisi</a></td>
  </tr>";
        
    }
    echo "</table>";
    }else
    {
        echo "Greska u brisanju!<br>";
    }
}
//////////BRISANJE SLIKE KRAJ
?>
