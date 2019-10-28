<?php
/*   ova strana je procesor */
$VESTI_PO_STRANI = 5;

include("uklj/baza_heder.php");
//include "uklj/is_login.php";

$template = htmlspecialchars(addslashes($_REQUEST['tmp']));
$strana = htmlspecialchars(addslashes($_REQUEST['strana']));
$slug = htmlspecialchars(addslashes($_REQUEST['slug']));
$slug_red = explode("=",$slug);
$slug = trim($slug_red[0]);
$tabulator = trim($slug_red[1]);
$tabulator2 = trim($slug_red[2]);
if(!$tabulator){$tabulator=0;}
$nadr = htmlspecialchars(addslashes($_REQUEST['nadr']));
$nadr2 = htmlspecialchars(addslashes($_REQUEST['nadr2']));
$prikSamoSekcije = htmlspecialchars(addslashes($_REQUEST['prikSamoSekcije']));
//pretraga
$pretraga = htmlspecialchars(strip_tags($_REQUEST['pretraga']));
$sekcija = htmlspecialchars($_REQUEST['sekcija']);
$jezik = htmlspecialchars($_REQUEST['jezik']);
$pocetniBroj = htmlspecialchars($_REQUEST['pocetniBroj']);
$krajnjiBroj = htmlspecialchars($_REQUEST['krajnjiBroj']);
//--vesti ---
$idv = htmlspecialchars($_REQUEST['idv']); //id_speciifcne vesti
$vesti = htmlspecialchars($_REQUEST['vesti']);
$vst_str = htmlspecialchars($_REQUEST['vst_str']); //koja strana vesti
$kategorija_vesti = addslashes(htmlspecialchars($_REQUEST['katv']));
//------------



function pronadji_internu_komandu($string, $start, $end){
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
		return substr($string,$ini,$len)."|)(|". $pdeo."|)(|".$drugiDeo ;
}



function izvrsi_komandu($komanda){
$komNiz = explode("|",$komanda);

 if(substr($komanda,0,11)=="kratkeVesti"){
   //primer komande: [komanda]kratkeVesti|1|52|glavna|kategorija_vesti[/komanda]
   $jezik = $komNiz[1]; $str = $komNiz[2];  $naziv_sekcije = $komNiz[3]; $katv = $komNiz[4]; 
   return file_get_contents("http://".$_SERVER['HTTP_HOST']."/kratke_vesti.php?jezik=$jezik&str=$str&katv=$katv&naziv_sekcije=$naziv_sekcije");
 }//kratkeVesti
 
 
}//izvrsi_komandu



function highlight_search_criteria( $search_results, $search_criteria)
{
    if (@empty($search_criteria)) {
        return $search_results;
    } else {
        $start_tag = "<span style=\"font-weight: bold\" class=\"crveno\"> ";
        $end_tag = " </span>";

        $highlighted_results = $start_tag . $search_criteria . $end_tag;

        return @eregi_replace($search_criteria, $highlighted_results, $search_results);
    }
} 


function summarize_search_result($prva_rec, $result_text, $num_words=10) {
    $text_array = @explode(" ", $result_text);
	$r = 0; $poc = 0;
	
	$poc = @array_search($prva_rec, $text_array); 

	
	if($poc <= 20 || count($text_array)<=$num_words) {$poc = 0;} else {$poc = $poc - 10;}
    return @implode(" ", @array_slice($text_array, $poc, $num_words)). "... ";
} 




///ODREDJIVANJE FRIENDLY URL POCETAK
if(!$strana){
if($slug && !$nadr){
    //vadim koja je strana sa zadatim slug-om
$sqlSlug = "SELECT s.id_strane, s.naslov 
FROM t_strane s 
WHERE s.slug LIKE '$slug' and s.aktivna = 1";
        
$sqlSlug .= " and s.par=1";    
    

$rezSlug = mysql_query($sqlSlug);
if(mysql_num_rows($rezSlug)>0){
list($id_strane_slug, $naslov_slug)=@mysql_fetch_row($rezSlug);
$strana = $id_strane_slug;
} else {
 //  echo $sqlSlug;
    $strana = 1;
    //include("greska/greska404.html");

}//mysql_num_rows
    
}else{
    $strana = 1;
}

if($slug && $nadr){
    //vadim koja je strana sa zadatim slug-om
$sqlSlug = "select t.id_strane,t.slug from t_strane t inner join t_strane d on t.par = d.id_strane where  d.slug = '$nadr' and t.slug = '$slug' and t.aktivna = 1 ";
$rezSlug = mysql_query($sqlSlug);
if(mysql_num_rows($rezSlug)>0){
list($id_strane_slug, $naslov_slug, $slug_slug, $nadr_slug)=@mysql_fetch_row($rezSlug);
$strana = $id_strane_slug;
} else {
   // echo $sqlSlug;
 //   echo "2<br />";
    //include("greska/greska404.html");
    $strana=1;

}//mysql_num_rows
    
}

if($slug && $nadr && $nadr2){
    //vadim koja je strana sa zadatim slug-om
$sqlSlug = "select t.id_strane,t.slug from t_strane t inner join t_strane d on t.par = d.id_strane inner join t_strane p on d.par = p.id_strane where p.slug = '$nadr2' and d.slug = '$nadr' and t.slug = '$slug' and t.aktivna = 1 ";
$rezSlug = mysql_query($sqlSlug);
//echo $sqlSlug2;
if(mysql_num_rows($rezSlug)>0){
list($id_strane_slug, $slug_slug)=@mysql_fetch_row($rezSlug);
$strana = $id_strane_slug;
} else {
   // echo $sqlSlug;
//    echo "3<br />";
    //include("greska/greska404.html");
    $strana=1;

}//mysql_num_rows
    
}



}
///ODREDJIVANJE FRIENDLY URL KRAJ

//vadim koji je template i koja strana procesira ovaj ID strane:
$sqlG = "SELECT s.id_templata, t.procesor_strana, s.naslov, s.TITLE, s.META_DISC, s.jezik 
FROM t_strane s 
LEFT JOIN t_templati t on t.id_templata = s.id_templata 
WHERE s.id_strane = '".$strana."' and s.aktivna = 1";
$rezG = mysql_query($sqlG);
if(mysql_num_rows($rezG)>0){
list($id_templata, $procesor_strana, $strana_NAZIV, $strana_TITLE, $strana_META_DISC, $strana_JEZIK)=@mysql_fetch_row($rezG);
} else {
    echo "Strana: ".$strana;
include("greska/greska404.html");

}//mysql_num_rows

//vadim delove strane:
$sql = "SELECT ts.naziv_sekcije, tes.sadrzaj  
FROM t_strana_delovi s 
LEFT JOIN t_templati_sekcije ts on ts.id_sekcije = s.id_sekcije 
LEFT JOIN t_elementi_strane tes on tes.id_elementa = s.id_elementa
WHERE s.id_strane = '".$strana."' 
GROUP BY s.id_dela
ORDER BY s.id_sekcije, s.redosled
";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){ $i=0;
while (list($naziv_sekcije, $sadrzaj)=@mysql_fetch_row($rez)) {
$i++;
//echo "$naziv_sekcije , id_strane= $strana, ";
if ($i==1){$$naziv_sekcije = "";}

//proveravam interne komande
$rezultat = 1;
while ($rezultat){ 
$rezultat = pronadji_internu_komandu($sadrzaj, "[komanda]", "[/komanda]");
  if($rezultat){
     $komandniNiz = explode("|)(|",$rezultat);
     $komanda = $komandniNiz[0];
	 $prviDeo = $komandniNiz[1];
	 $drugiDeo = $komandniNiz[2];
     $sadrzaj = $prviDeo .  izvrsi_komandu($komanda) .  $drugiDeo;	 
  }//if($rezutat)
}

//kreiram promenljivu koja se zove kao naziv sekcije
if(!$prikSamoSekcije && $naziv_sekcije != $sekcija){$$naziv_sekcije .= $sadrzaj;} else if($naziv_sekcije != $sekcija) {$$naziv_sekcije = "<h1 align=\"center\">".$naziv_sekcije."</h1>";}
} //while
} //mysql_num_rows












//************************************  PRETRAGA *******************************
if($pretraga && $sekcija){

/*$sql = "SELECT s.id_strane, s.naslov, es.sadrzaj
FROM t_strane s
LEFT JOIN t_strana_delovi sd on sd.id_strane = s.id_strane
LEFT JOIN t_elementi_strane es on es.id_elementa = sd.id_elementa
WHERE s.aktivna = 1 and es.pretrazivo = 1 and sadrzaj LIKE '%".$pretraga."%'
GROUP BY s.id_strane";*/

$sql = "SELECT s.id_strane, s.slug, s.naslov, es.sadrzaj_nohtml, MATCH(es.sadrzaj_nohtml) AGAINST('".$pretraga."') as relevance, s.par, s.jezik 
FROM t_strane s
LEFT JOIN t_strana_delovi sd on sd.id_strane = s.id_strane
LEFT JOIN t_elementi_strane es on es.id_elementa = sd.id_elementa
WHERE s.aktivna = 1 and es.pretrazivo = 1 and es.jezik='".$jezik."' and (MATCH(es.sadrzaj_nohtml) AGAINST('".$pretraga."' IN BOOLEAN MODE) or s.naslov like '%".$pretraga."%')
GROUP BY s.id_strane 
ORDER BY relevance DESC LIMIT ".$pocetniBroj.",".$krajnjiBroj."";

$ukupanSQL = "SELECT s.id_strane, s.naslov, es.sadrzaj_nohtml, MATCH(es.sadrzaj_nohtml) AGAINST('".$pretraga."') as relevance 
FROM t_strane s
LEFT JOIN t_strana_delovi sd on sd.id_strane = s.id_strane
LEFT JOIN t_elementi_strane es on es.id_elementa = sd.id_elementa
WHERE s.aktivna = 1 and es.pretrazivo = 1 and es.jezik='".$jezik."' and (MATCH(es.sadrzaj_nohtml) AGAINST('".$pretraga."' IN BOOLEAN MODE) or s.naslov like '%".$pretraga."%')
GROUP BY s.id_strane 
ORDER BY relevance DESC";

$sledeciPocetniBroj = $pocetniBroj + 10;
$sledeciKrajnjiBroj = $krajnjiBroj + 10;

$prethodniPocetniBroj = $pocetniBroj - 10;
$prethodniKrajnjiBroj = $krajnjiBroj - 10;

$rez = mysql_query($sql);

$rezultatUkupan = mysql_query($ukupanSQL);

$brojUkupan = mysql_num_rows($rezultatUkupan);



if ($jezik==1){
$pretragaNaslov = "Pretraga";
$RezultatiPretrage = "Rezultati pretrage";
$NemaRezultata = "Za zadati kriterijum nisu nadjeni rezultati";
} elseif ($jezik==2) {
$pretragaNaslov = "Search";
$RezultatiPretrage = "Search results";
$NemaRezultata = "The search resulted in no hits";
}


if(mysql_num_rows($rez)>0){ $$sekcija = "";
while (list($id_strane, $s_slug, $naslov, $sadrzaj, $relevance, $parent, $jez)=@mysql_fetch_row($rez)) {

/////

    if($jez==1){
        if($parent==0){
            $link = "/naslovna  (NASLOVNA SRPSKI)";
        }else{      
        if($parent==1){
        $link = "/".$s_slug;
        }else{
        $sql1 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$parent' ";
        $rez1 = mysql_query($sql1);
        while (list($id_strane2, $naslov2, $slug2, $par2)=@mysql_fetch_row($rez1)) {
            if($par2==1){
            $link = "/".$slug2."/".$s_slug;
            }else{
                $sql2 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par2' ";
                $rez2 = mysql_query($sql2);
                while (list($id_strane3, $naslov3, $slug3, $par3)=@mysql_fetch_row($rez2)) {
                    if($par3==1){
                    $link = "/".$slug3."/".$slug2."/".$s_slug;
                    }else{
                                $sql3 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par3' ";
                                $rez3 = mysql_query($sql3);
                                while (list($id_strane4, $naslov4, $slug4, $par4)=@mysql_fetch_row($rez3)) {
                                if($par4==1){
                                    $link = "/".$slug4."/".$slug3."/".$slug2."/".$s_slug;
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
            $link = "/homepage  (NASLOVNA ENGLESKI)";
        }else{      
        if($parent==142){
        $link = "/".$s_slug;
        }else{
        $sql1 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$parent' ";
        $rez1 = mysql_query($sql1);
        while (list($id_strane2, $naslov2, $slug2, $par2)=@mysql_fetch_row($rez1)) {
            if($par2==142){
            $link = "/".$slug2."/".$s_slug;
            }else{
                $sql2 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par2' ";
                $rez2 = mysql_query($sql2);
                while (list($id_strane3, $naslov3, $slug3, $par3)=@mysql_fetch_row($rez2)) {
                    if($par3==142){
                    $link = "/".$slug3."/".$slug2."/".$s_slug;
                    }else{
                                $sql3 = "SELECT s.id_strane, s.naslov, s.slug, s.par FROM t_strane s WHERE s.id_strane='$par3' ";
                                $rez3 = mysql_query($sql3);
                                while (list($id_strane4, $naslov4, $slug4, $par4)=@mysql_fetch_row($rez3)) {
                                if($par4==142){
                                    $link = "/".$slug4."/".$slug3."/".$slug2."/".$s_slug;
                                    }
                                }
                        
                    }           
                }
            }
        }
    }
    }
        
    }

/////  
//vadim poziciju trazenog stringa u textu sadrzaja:
$duzina = strlen($sadrzaj);

$xx = explode(" ",$pretraga);
$sadrzaj = summarize_search_result($xx[0], $sadrzaj, 45); 

$prvi = explode("//stripstart", $sadrzaj);
$drugi = explode("//stripend", $prvi[1]);

$sadrzaj = $prvi[0].$drugi[1];

foreach ($xx as $x){
$sadrzaj = highlight_search_criteria($sadrzaj, $x);
}


$$sekcija .= "<p><b><a href=\"$link\">".$naslov."</a></b><br>".$sadrzaj."</p> ";   
} //while
if($pocetniBroj <= $brojUkupan && $brojUkupan <= $krajnjiBroj)
{

	//$$sekcija .= "<p align=\"center\">Nema više rezultata</p><br>";
		if($brojUkupan<10)
		{
			//echo "<p align=\"center\">_______________</p>";
		}else{
		$$sekcija .= "<form id=\"sledecaS\" action=\"/index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"sledecaS\">
		<input type=\"hidden\" name=\"strana\" value=\"";
		if($jezik==1){
		$$sekcija .= "5";}else{
		$$sekcija .= "232";}
		$$sekcija .= "\" />
		<input type=\"hidden\" name=\"sekcija\" value=\"glavna\" /> 
		<input type=\"hidden\" name=\"jezik\" value=\"".$jezik."\" /> 
		<input type=\"hidden\" name=\"pretraga\" value=\"".$pretraga."\"/>
		<input type=\"hidden\" name=\"pocetniBroj\" value=\"".$prethodniPocetniBroj."\"/>
		<input type=\"hidden\" name=\"krajnjiBroj\" value=\"".$prethodniKrajnjiBroj."\"/>
		<p align=\"center\"><a href=\"javascript:document.sledecaS.submit();\">";
		if($jezik==1){
		$$sekcija .= "<< Prethodna strana";}else{
		$$sekcija .= "<< Previous page";}
		$$sekcija .= "</a></p></form>";
		}

}else{
		if($pocetniBroj>=10)
		{
			$$sekcija .= "<table width=\"300\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
			$$sekcija .= "<tr><td>";
			$$sekcija .= "<form id=\"prethodna\" action=\"/index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"prethodna\">
			<input type=\"hidden\" name=\"strana\" value=\"";
			if($jezik==1){
			$$sekcija .= "5";}else{
			$$sekcija .= "232";}
			$$sekcija .= "\" />
			<input type=\"hidden\" name=\"sekcija\" value=\"glavna\" /> 
			<input type=\"hidden\" name=\"jezik\" value=\"".$jezik."\" /> 
			<input type=\"hidden\" name=\"pretraga\" value=\"".$pretraga."\"/>
			<input type=\"hidden\" name=\"pocetniBroj\" value=\"".$prethodniPocetniBroj."\"/>
			<input type=\"hidden\" name=\"krajnjiBroj\" value=\"".$prethodniKrajnjiBroj."\"/>
			<a href=\"javascript:document.prethodna.submit();\">";
			if($jezik==1){
			$$sekcija .= "<< Prethodna strana";}else{
			$$sekcija .= "<< Previous page";}
			$$sekcija .= "</a></form></td>";
			
			$$sekcija .= "<td><form id=\"sledecaS\" action=\"/index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"sledecaS\">
			<input type=\"hidden\" name=\"strana\" value=\"";
			if($jezik==1){
			$$sekcija .= "5";}else{
			$$sekcija .= "232";}
			$$sekcija .= "\" />
			<input type=\"hidden\" name=\"sekcija\" value=\"glavna\" /> 
			<input type=\"hidden\" name=\"jezik\" value=\"".$jezik."\" /> 
			<input type=\"hidden\" name=\"pretraga\" value=\"".$pretraga."\"/>
			<input type=\"hidden\" name=\"pocetniBroj\" value=\"".$sledeciPocetniBroj."\"/>
			<input type=\"hidden\" name=\"krajnjiBroj\" value=\"".$sledeciKrajnjiBroj."\"/>
			<a href=\"javascript:document.sledecaS.submit();\">";
			if($jezik==1){
			$$sekcija .= "Seledeća strana >>";}else{
			$$sekcija .= "Next Page >>";}
			$$sekcija .= "</a></form></td>";
			$$sekcija .= "</tr></table>";			
		}else
		{
		$$sekcija .= "<form id=\"sledecaS\" action=\"/index.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"sledecaS\">
		<input type=\"hidden\" name=\"strana\" value=\"";
		if($jezik==1){
		$$sekcija .= "5";}else{
		$$sekcija .= "232";}
		$$sekcija .= "\" />
		<input type=\"hidden\" name=\"sekcija\" value=\"glavna\" /> 
		<input type=\"hidden\" name=\"jezik\" value=\"".$jezik."\" /> 
		<input type=\"hidden\" name=\"pretraga\" value=\"".$pretraga."\"/>
		<input type=\"hidden\" name=\"pocetniBroj\" value=\"".$sledeciPocetniBroj."\"/>
		<input type=\"hidden\" name=\"krajnjiBroj\" value=\"".$sledeciKrajnjiBroj."\"/>
		<p align=\"center\"><a href=\"javascript:document.sledecaS.submit();\">";
		if($jezik==1){
		$$sekcija .= "Seledeća strana >>";}else{
		$$sekcija .= "Next Page >>";}
		$$sekcija .= "</a></p></form>";
		}
}
$$sekcija = " <p class=\"velikinaslov\">".$pretragaNaslov."</p><p><strong>".$RezultatiPretrage."</strong></p>".$$sekcija." ";
} else {$$sekcija = "<p class=\"velikinaslov\">".$pretragaNaslov."</p><p>".$NemaRezultata."</p>";}//mysql_num_rows

}//pretraga
//************************************  PRETRAGA KRAJ *******************************










//******************************************* VESTI *********************************

if($vesti && $sekcija){
//$idv = htmlspecialchars($_REQUEST['idv']); //id_speciifcne vesti
//$vesti = htmlspecialchars($_REQUEST['vesti']);
//$vst_str = htmlspecialchars($_REQUEST['vst_str']); //koja strana vesti
if(!$vst_str) $vst_str = 1;
$limitMin = $vst_str - 1; if($limitMin < 0 || !$limitMin) {$limitMin = 0;}
$limitMin = $limitMin * $VESTI_PO_STRANI;
$krlimit = $VESTI_PO_STRANI+1;
$sledstr = $vst_str + 1; $predstr = $vst_str - 1;


$sql = "SELECT id_vesti, DATE_FORMAT(datum,'%d.%m.%y') datumvesti, naslov, vest_html 
FROM t_vesti 
WHERE jezik = '".$jezik."' and aktivna=1  and kategorija = '".$kategorija_vesti."' 
ORDER BY datum DESC, vreme_izmene DESC LIMIT $limitMin, $krlimit";
$rez = mysql_query($sql);
if(mysql_num_rows($rez)>0){$i=0;
$$sekcija .= "<table width=\"540\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-image:url(/images/";
if ($kategorija_vesti==1){$$sekcija .= "pozadina_vesti";} elseif ($kategorija_vesti==2) {$$sekcija .= "pozadina_podrska";}
$$sekcija .= ".jpg); background-repeat:no-repeat\"><tr>
<td align=\"left\" valign=\"top\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td align=\"left\" valign=\"top\"></td><td align=\"left\" valign=\"top\" class=\"NaslStraniceOpste\">";

if ($jezik==1){
$naslovvesti = "<div id=\"naslov_stranice\"><span class=\"velikinaslov\">Novosti</span></div>";
} elseif ($jezik==2) {
$naslovvesti = "<div id=\"naslov_stranice\"><span class=\"velikinaslov\">News</span></div>";
}



if ($kategorija_vesti==1) {
$$sekcija .= $naslovvesti ;
} else {
//$$sekcija .= "Network status";
}

$$sekcija .= "</td></tr></table></td></tr><tr><td align=\"left\" valign=\"top\" class=\"prored\" style=\"padding-left: 20px; padding-right: 20px;\">";
while (list($id_vesti, $datum, $naslov, $vest_html)=@mysql_fetch_row($rez)) {
$i++;
if($i<$krlimit){
$$sekcija .= "<p><a name=\"$id_vesti\" id=\"$id_vesti\"></a><a name=\"vst".$id_vesti."\"></a><span  class=\"sivo\">".$datum."</span><br /><span  class=\"naslov\">".$naslov ."</span></p><p class=\"prored\">".$vest_html."</p><hr>";
$imaSledeca=0;  
} else {$imaSledeca=1;}
} //while
$$sekcija .= "</td></tr></table>";
if($vst_str>1){$linkPrethodni .= "<a href=\"/vesti-1-1.html\">|<< </a>&nbsp;<a href=\"/index.php?strana=$strana&sekcija=$sekcija&vesti=1&katv=$kategorija_vesti&vst_str=$predstr&jezik=$jezik\">&#139; ";
				if($jezik==1)
				{
					$linkPrethodni .= "prethodnih $VESTI_PO_STRANI vesti</a> ";
				}elseif($jezik==2)
				{
					$linkPrethodni .= "previous $VESTI_PO_STRANI news</a> ";
				}		
				}
if($imaSledeca){$linkSledeci .= " <a href=\"/index.php?strana=$strana&sekcija=$sekcija&vesti=1&katv=$kategorija_vesti&vst_str=$sledstr&jezik=$jezik\">";
				if($jezik==1)
				{
					$linkSledeci .= " sledećih $VESTI_PO_STRANI vesti &#155;</a>&nbsp;<a href=\"/index.php?strana=$strana&sekcija=$sekcija&vesti=1&katv=$kategorija_vesti&vst_str=$krlimit&jezik=$jezik\"> >>|</a>";
				}elseif($jezik==2)
				{
					$linkSledeci .= " next $VESTI_PO_STRANI news &#155;</a>&nbsp;<a href=\"/index.php?strana=$strana&sekcija=$sekcija&vesti=1&katv=$kategorija_vesti&vst_str=$krlimit&jezik=$jezik\"> >>|</a>";
				}
}
if($linkPrethodni || $linkSledeci){
//ovde je prikaz sledece / prethodne vesti
$$sekcija .= "<div align=\"center\">".$linkPrethodni." &nbsp; ".$linkSledeci."</div>";
}
} else {
$$sekcija = "<br> <div style=\"padding:5px;\"><h3>NEMA REZULTATA KOJI ODGOVARAJU KRITERIJUMIMA PRETRAGE...</h3></div>";
}//mysql_num_rows

}//vesti
//******************************************* VESTI KRAJ *********************************



include($procesor_strana);



/*
echo $_SERVER['HTTP_HOST'];
echo "<br> " . $_SERVER['DOCUMENT_ROOT'];
echo "<br> " . $_SERVER['PHP_SELF'];
*/


?>
