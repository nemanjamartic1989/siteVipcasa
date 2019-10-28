<?
header("Content-Type: text/html; charset=utf-8");

include("../uklj/baza_heder.php");
include("../uklj/datum.php");
include("../uklj/sesija.php"); 
include("../uklj/podesavanje.php");

$debugMail = 0; //samo za test ako je 1, ne salje se stvarno mail

$folder = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
$url_ovde = sprintf('http://%s%s', $_SERVER['SERVER_NAME'], $folder);

$akcija = $_REQUEST['akcija'];
$LID = $_REQUEST['LID'];

//if($akcija!="proveriKorisnika"){echo "<h2>akcija:$akcija ; LID:$LID</h2>";}

if($LID){//produzavam sesiju:
 $rv = rand(1,2);
  if ($rv==2){
$sql2="UPDATE t_sesije_korisnici SET posl_vreme_pristupa = '".time()."' WHERE sesija = '".$LID."'";
$rez2 = mysql_query($sql2);
  }
}

$debug = 0;



if($akcija=='izmeni_vlasmere_sql'){
    $vlasnik_id = $_REQUEST['vlasnik_id'];
        //anuliram
       $sql_anuliram = "UPDATE i_vlasmere SET locked=0 WHERE id_v=$vlasnik_id ";
       $rez_anuliram = mysql_query($sql_anuliram);
        if (!$rez_anuliram) {
            die('Greska: '.$sql_anuliram.' '. mysql_error());
                                 }
       //anuliram kraj
     $izbor_g =  $_REQUEST['izbor_g']; 
     $parcici = explode(",", $izbor_g);  
       for($i=0;$i<count($parcici);$i++) {
       $parcici[$i];
       $sql_proveri = "SELECT id_mere FROM i_vlasmere WHERE id_v=$vlasnik_id AND id_mere=$parcici[$i] ";
       $rez_proveri = mysql_query($sql_proveri);
        if(mysql_num_rows($rezListaj)>0){
            $sql_unos_ranjmere = "UPDATE i_vlasmere SET locked=1 WHERE id_v=$vlasnik_id AND id_mere=$parcici[$i])";
       $rez_unos_ranjmere = mysql_query($sql_unos_ranjmere);
        if (!$rez_unos_ranjmere) {
            die('Greska: '.$sql_unos_ranjmere.' '. mysql_error());
                                 }
        }else{
       $sql_unos_ranjmere = "INSERT INTO i_vlasmere (id_v,id_mere,locked) VALUES ('$vlasnik_id', '$parcici[$i]', 1)";
       $rez_unos_ranjmere = mysql_query($sql_unos_ranjmere);
        if (!$rez_unos_ranjmere) {
            die('Greska: '.$sql_unos_ranjmere.' '. mysql_error());
                                 }
       }                      
       }
       
       
       $sql_brisanje_ranjivosti = "DELETE FROM i_vlasmere WHERE id_v=$vlasnik_id AND locked=0 ";
       
        $rez_brisanje_ranjivosti = mysql_query($sql_brisanje_ranjivosti);
        if (!$rez_brisanje_ranjivosti) {
            die('Greska: '.$sql_brisanje_ranjivosti.' '. mysql_error());
                                 }
                                 
    ///izmena kraj    
        
$akcija='lista_tretmana';
}

if($akcija=='sacuvaj_stanje_sql'){
        $korisnik =  $_REQUEST['korisnik'];    
        $datum_za_bazu = date('Y-m-d H:i:s');
        
      $sqlListaj = "SELECT vm.id_vm, vm.id_v, vm.id_mere, vm.ocena, vm.komentar, vm.locked FROM i_vlasmere vm ORDER BY vm.id_vm";
            $rezListaj = mysql_query($sqlListaj);
        if(mysql_num_rows($rezListaj)>0){
             
        while (list($id_vm, $id_v, $id_mere, $ocena, $komentar, $locked)=@mysql_fetch_row($rezListaj)) {
            $sql_unos_vlasmere_log = "INSERT INTO i_vlasmere_log (id_v, id_mere, ocena, komentar,locked,datum,korisnik) VALUES ('$id_v', '$id_mere', '$ocena', '$komentar', '$locked', '$datum_za_bazu', '$korisnik')";
            $rez_unos_vlasmere_log = mysql_query($sql_unos_vlasmere_log);
        if (!$rez_unos_vlasmere_log) {
            die('Greska: '.$sql_unos_vlasmere_log.' '. mysql_error());
                                 }
        
        }}
       
    ///izmena kraj    
        echo "SACUVANO!!";
//$akcija='sacuvaj_stanje';
}

if($akcija=='izmeni_vlasnika_sql'){
    $vlasnik_id = $_REQUEST['vlasnik_id'];
    $vlasnik_imePrezime = $_REQUEST['vlasnik_imePrezime'];
        
       $sql_unos_ranjmere = "UPDATE i_vlasnik SET imePrezime = '".$vlasnik_imePrezime."' WHERE id_v = '$vlasnik_id' ";
       $rez_unos_ranjmere = mysql_query($sql_unos_ranjmere);
        if (!$rez_unos_ranjmere) {
            die('Greska: '.$sql_unos_ranjmere.' '. mysql_error());
                                 }   
       
    ///izmena kraj    
        
$akcija='lista_vlasnika';
}

if($akcija=='daj_ocenu'){
    $vlasnik_id = $_REQUEST['id_vlasnika'];
    $id_mere = $_REQUEST['id_mere'];
    $ocena_mere = $_REQUEST['ocena_mere'];
    $komentar = $_REQUEST['komentar'];
    $sql_unos_ranjivost = "UPDATE i_vlasmere SET ocena = '".$ocena_mere."', komentar = '".$komentar."' WHERE id_v = '$vlasnik_id' AND id_mere = '$id_mere' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost);
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error());
        }  
        //echo "uspesno";
//$akcija='lista_mera_za_vlasnika';
            $sqlListaj = "SELECT vm.id_mere, m.sifra, m.naziv, vm.ocena, vm.komentar FROM i_vlasmere vm, i_mere m WHERE vm.id_mere=m.idi_m AND vm.id_v=$vlasnik_id AND id_mere='$id_mere' GROUP BY vm.id_mere ORDER BY m.sifra";
            $rezListaj = mysql_query($sqlListaj);
        if(mysql_num_rows($rezListaj)>0){
             
        while (list($id_mere, $sifraMere, $nazivMere, $ocena, $komentar)=@mysql_fetch_row($rezListaj)) {
            echo "<div id=\"oceni_meru$vlasnik_id$id_mere\"><table width=\"100%\">";
            echo "<tr><td><strong>";
            echo $sifraMere." ".$nazivMere."</strong><br />";
             //NAPOMENA
           echo "<textarea cols=\"50\" rows=\"3\" id=\"komentar$vlasnik_id$id_mere\">$komentar</textarea>";
                   if($A_NIVO==1 || $A_NIVO==2){
           echo "<input type=\"submit\" onClick=\"var komentar = \$('#komentar$vlasnik_id$id_mere').val(); var ocena_mere=\$('#ocena_mere$vlasnik_id$id_mere').val(); \$('#oceni_meru$vlasnik_id$id_mere').hide().load('ajax/tretman.php',{akcija: 'daj_ocenu', LID:'$LID', ocena_mere:ocena_mere, id_mere:'$id_mere', id_vlasnika:'$vlasnik_id', komentar: komentar}).fadeIn('fast');\" value=\"Azuriraj napomenu\" >" ;
                   }
            //NAPOMENA KRAJ
            echo "</td><td align=\"right\">";
            echo " ( ocena: ";
            echo "<select id=\"ocena_mere$vlasnik_id$id_mere\" onChange=\"var komentar = \$('#komentar$vlasnik_id$id_mere').val(); var ocena_mere=this.value; \$('#oceni_meru$vlasnik_id$id_mere').hide().load('ajax/tretman.php',{akcija: 'daj_ocenu', LID:'$LID', ocena_mere:ocena_mere, id_mere:'$id_mere', id_vlasnika:'$vlasnik_id', komentar: komentar}).fadeIn('fast');\">";
    for($i=1;$i<=5;$i++) {
    if($ocena==$i){
            $chk4 = 'SELECTED';
        }else{
            $chk4 = '';
        }
        echo "<option value=\"$i\" $chk4>$i</option>";
    }
echo "</select>";
            
            echo ")</td></tr>";
            echo "</table></div>";
                                        }
        }
}

if($akcija=='obrisi_porudzbinu'){
    $id_porudzbine = $_REQUEST['porudzbina_id'];
    $sql_unos_ranjivost = "DELETE FROM t_porudzbine WHERE id_p = '$id_porudzbine' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost);
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error());
        }  
        //echo "uspesno";
$akcija='lista_tretmana';
}

if($akcija=='obrisi_komentar'){
    $komentar_id = $_REQUEST['komentar_id'];
    $sql_unos_ranjivost = "DELETE FROM t_komentari WHERE id_k = '$komentar_id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost);
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error());
        }  
        //echo "uspesno";
$akcija='lista_komentara';
}

if($akcija=='odobri_komentar'){
    $komentar_id = $_REQUEST['komentar_id'];
    $sql_unos_ranjivost = "UPDATE t_komentari SET confirm=1 WHERE id_k = '$komentar_id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost);
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error());
        }  
        //echo "uspesno";
$akcija='lista_komentara';
}

if($akcija=='obrisi_klijenta'){
    $klijent_id = $_REQUEST['klijent_id'];
    $sql_unos_ranjivost = "DELETE FROM t_komitenti WHERE id_komitenta = '$klijent_id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost);
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error());
        }  
        //echo "uspesno";
$akcija='lista_klijenata';
}

if($akcija=='ubaci_vlasmeru'){
     $izbor_g =  $_REQUEST['izbor_g']; 
     $id_vlasnika =  $_REQUEST['id_vlasnika']; 
     $parcici = explode(",", $izbor_g);  
       for($i=0;$i<count($parcici);$i++) {
       $parcici[$i];
       $sql_unos_ranjmere = "INSERT INTO i_vlasmere (id_v,id_mere) VALUES ('$id_vlasnika', '$parcici[$i]')";
       $rez_unos_ranjmere = mysql_query($sql_unos_ranjmere);
        if (!$rez_unos_ranjmere) {
            die('Greska: '.$sql_unos_ranjmere.' '. mysql_error());
                                 }   
       
       
       }
    
    
   $akcija='lista_tretmana';
}

if($akcija=='odgovori_na_komentar_sql'){
     $komentar_id =  $_REQUEST['komentar_id']; 
     $odgovor =  $_REQUEST['odgovor']; 
       $sql_unos_ranjmere = "INSERT INTO t_odgovori (id_k, odgovor) VALUES ('$komentar_id', '$odgovor')";
       $rez_unos_ranjmere = mysql_query($sql_unos_ranjmere);
        if (!$rez_unos_ranjmere) {
            die('Greska: '.$sql_unos_ranjmere.' '. mysql_error());
                                 }   
   $akcija='lista_komentara';
}

if($akcija=='izmeni_klijenta_sql'){
     $klijent_id =  $_REQUEST['klijent_id']; 
     $korisnik_imePrezime =  $_REQUEST['korisnik_imePrezime']; 
     $lozinka_korisnika =  $_REQUEST['lozinka'];
     if($lozinka_korisnika){
         $lozinka = md5($lozinka_korisnika);   
     }
     $email_korisnika =  $_REQUEST['email']; 
     $sql_unos_korisnika = "UPDATE t_komitenti SET naziv='$korisnik_imePrezime', e_mail='$email_korisnika' ";
     if($lozinka_korisnika){
     $sql_unos_korisnika .= ", lozinka='$lozinka' ";
     }
     $sql_unos_korisnika .= " WHERE id_komitenta='$klijent_id' ";
     //echo $sql_unos_korisnika;
     $rez_unos_korisnika = mysql_query($sql_unos_korisnika);
        if (!$rez_unos_korisnika) {
            die('Greska: '.$sql_unos_korisnika.' '. mysql_error());
                                 }   
   $akcija='lista_klijenata';
}

if($akcija=='ubaci_klijenta'){
     $korisnik_imePrezime =  $_REQUEST['korisnik_imePrezime']; 
     $lozinka_korisnika =  $_REQUEST['lozinka']; 
     $lozinka = md5($lozinka_korisnika);   
     $email_korisnika =  $_REQUEST['email']; 
     $sql_unos_korisnika = "INSERT INTO t_komitenti (naziv, e_mail, lozinka, aktivan, tip) VALUES ('$korisnik_imePrezime', '$email_korisnika', '$lozinka', 1, 1)";
     $rez_unos_korisnika = mysql_query($sql_unos_korisnika);
        if (!$rez_unos_korisnika) {
            die('Greska: '.$sql_unos_korisnika.' '. mysql_error());
                                 }   
   $akcija='lista_klijenata';
}

if($akcija=='lista_tretmana'){
        //$A_NIVO = $_REQUEST['A_NIVO'];
      ?>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            /* Define two custom functions (asc and desc) for string sorting */
            jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            
            jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
                return ((x < y) ?  1 : ((x > y) ? -1 : 0));
            };
            
            $(document).ready(function() {
                /* Build the DataTable with third column using our custom sort functions */
                $('#example').dataTable( {
                    "aaSorting": [ [0,'asc'], [1,'asc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
</script>
    <?php
    $query3 = "SELECT vm.id_vm, vm.id_v, v.imePrezime, vm.id_mere FROM i_vlasmere vm, i_vlasnik v WHERE vm.id_v=v.id_v GROUP BY vm.id_v";
    $result = mysql_query($query3) or die(mysql_error());;
    $options=" ";
    echo "<br>";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>Vlasnik</th>";
    echo "<th>mere i ocena</th>";
    echo "<th></th>";
    echo "</tr></thead>";
    echo "<tbody>";
    
    while ($row=mysql_fetch_array($result)) 
    {
        $id_vlasnika=$row['id_v'];
        $vlasnik_imePrezime=$row['imePrezime'];
        
      echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td><a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/tretman.php',{akcija: 'izmeni_vlasmere',  LID:'".$LID."', vlasnik_id: '".$id_vlasnika."'}).fadeIn('slow');\" >$vlasnik_imePrezime</a></td>";
            
            echo "<td>";
            $sqlListaj = "SELECT vm.id_mere, m.sifra, m.naziv, vm.ocena, vm.komentar FROM i_vlasmere vm, i_mere m WHERE vm.id_mere=m.idi_m AND vm.id_v=$id_vlasnika GROUP BY vm.id_mere ORDER BY m.sifra ";
            $rezListaj = mysql_query($sqlListaj);
        if(mysql_num_rows($rezListaj)>0){
            
        while (list($id_mere, $sifraMere, $nazivMere, $ocena, $komentar)=@mysql_fetch_row($rezListaj)) {
            echo "<div id=\"oceni_meru$vlasnik_id$id_mere\"><table width=\"100%\">";
            echo "<tr><td>";
            echo "<a href=\"#\" name=\"./mere/mera_opis.php?id_mere=$id_mere\" onClick=\"NewWindow(this.name,'vreme','700','800','yes');return false\" ><img src=\"../images/info.png\" border=0 title=\"Implementacija mere\"></a>";
            echo "  <strong>".$sifraMere." ".$nazivMere."</strong><br>";
            //NAPOMENA
           echo "<textarea cols=\"50\" rows=\"3\" id=\"komentar$vlasnik_id$id_mere\" name=\"komentar$vlasnik_id$id_mere\">$komentar</textarea>";
                   if($A_NIVO==1 || $A_NIVO==2){
           echo "<input type=\"submit\" onClick=\"var komentar = \$('#komentar$vlasnik_id$id_mere').val(); var ocena_mere = \$('#ocena_mere$vlasnik_id$id_mere').val(); \$('#oceni_meru$vlasnik_id$id_mere').hide().load('ajax/tretman.php',{akcija: 'daj_ocenu', LID:'$LID', ocena_mere:ocena_mere, id_mere:'$id_mere', id_vlasnika:'$id_vlasnika', komentar: komentar}).fadeIn('fast');\" value=\"Azuriraj napomenu\" >" ;
                   }
            //NAPOMENA KRAJ
            
            echo "</td><td align=\"right\">";
            echo " ( ocena: ";
            echo "<select id=\"ocena_mere$vlasnik_id$id_mere\" onChange=\"var komentar = \$('#komentar$vlasnik_id$id_mere').val(); var ocena_mere=this.value; \$('#oceni_meru$vlasnik_id$id_mere').hide().load('ajax/tretman.php',{akcija: 'daj_ocenu', LID:'$LID', ocena_mere:ocena_mere, id_mere:'$id_mere', id_vlasnika:'$id_vlasnika', komentar: komentar}).fadeIn('fast');\">";
    for($i=1;$i<=5;$i++) {
    if($ocena==$i){
            $chk4 = 'SELECTED';
        }else{
            $chk4 = '';
        }
        echo "<option value=\"$i\" $chk4>$i</option>";
    }
echo "</select>";
            
            echo ")</td></tr>";
            echo "</table></div>";
                                        }

        }
            echo "</td>";
  
      echo "<td align='right'>";
      /*
              if($A_NIVO==1 || $A_NIVO==2){
      echo "<input type=\"submit\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/tretman.php',{akcija: 'izmeni_vlasmere',  LID:'".$LID."', vlasnik_id: '".$id_vlasnika."'}).fadeIn('slow');\" value=\"Izmeni\" >";
    if($A_NIVO==1){
    echo "<input type=\"submit\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/tretman.php',{akcija: 'obrisi_vlasmere',  LID:'".$LID."', vlasnik_id: '".$id_vlasnika."'}).fadeIn('slow');}\" value=\"Obrisi\" >";
    }
              }
              */
    echo "</td>";
    
    echo "</tr>";
    
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>Vlasnik</th>";
    echo "<th>mere i ocena</th>";
    echo "<th></th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}

if($akcija=='lista_tretmana_log'){
        $id_datum = $_REQUEST['id_datum'];
      ?>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            /* Define two custom functions (asc and desc) for string sorting */
            jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            
            jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
                return ((x < y) ?  1 : ((x > y) ? -1 : 0));
            };
            
            $(document).ready(function() {
                /* Build the DataTable with third column using our custom sort functions */
                $('#example').dataTable( {
                    "aaSorting": [ [0,'asc'], [1,'asc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
</script>
    <?php
    $query3 = "SELECT vm.id_vm, vm.id_v, v.imePrezime, vm.id_mere FROM i_vlasmere_log vm, i_vlasnik v WHERE vm.id_v=v.id_v AND vm.datum='$id_datum' GROUP BY vm.id_v";
    $result = mysql_query($query3) or die('Greska: '.$query3.' '.mysql_error());;
    $options=" ";
    echo "<br>";
    echo "Izveštaj <a href=\"#\" name=\"./procena/priprema_tretman_mere.php?id_datum=$id_datum\" onClick=\"NewWindow(this.name,'vreme','700','800','yes');return false\" style=\"padding-right:5px\;\"><img src=\"../images/pdf_dugme.png\" border=0 title=\"PDF\"></a>";
    echo "<br>";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>Vlasnik</th>";
    echo "<th>mere i ocena</th>";
    echo "<th></th>";
    echo "</tr></thead>";
    echo "<tbody>";
    
    while ($row=mysql_fetch_array($result)) 
    {
        $id_vlasnika=$row['id_v'];
        $vlasnik_imePrezime=$row['imePrezime'];
        
      echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$vlasnik_imePrezime</td>";
            
            echo "<td>";
            $sqlListaj = "SELECT vm.id_mere, m.sifra, m.naziv, vm.ocena, vm.komentar FROM i_vlasmere vm, i_mere m WHERE vm.id_mere=m.idi_m AND vm.id_v=$id_vlasnika GROUP BY vm.id_mere ORDER BY m.sifra ";
            $rezListaj = mysql_query($sqlListaj);
        if(mysql_num_rows($rezListaj)>0){
            
        while (list($id_mere, $sifraMere, $nazivMere, $ocena, $komentar)=@mysql_fetch_row($rezListaj)) {
            echo "<div id=\"oceni_meru$vlasnik_id$id_mere\"><table width=\"100%\">";
            echo "<tr><td><strong>";
            echo $sifraMere." ".$nazivMere."</strong><br>";
            //NAPOMENA
           echo "<textarea cols=\"50\" rows=\"3\" id=\"komentar$vlasnik_id$id_mere\" name=\"komentar$vlasnik_id$id_mere\" readonly=\"readonly\">$komentar</textarea>";
            //NAPOMENA KRAJ
            
            echo "</td><td align=\"right\">";
            echo " ( ocena: ";
            echo $ocena;
            
            echo ")</td></tr>";
            echo "</table></div>";
                                        }

        }
            echo "</td>";
  
      echo "<td align='right'>";
    echo "</td>";
    
    echo "</tr>";
    
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>Vlasnik</th>";
    echo "<th>mere i ocena</th>";
    echo "<th></th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}

if($akcija=='lista_vlasnika'){
     //   $A_NIVO = $_REQUEST['A_NIVO'];
      ?>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            /* Define two custom functions (asc and desc) for string sorting */
            jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            
            jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
                return ((x < y) ?  1 : ((x > y) ? -1 : 0));
            };
            
            $(document).ready(function() {
                /* Build the DataTable with third column using our custom sort functions */
                $('#example').dataTable( {
                    "aaSorting": [ [0,'asc'], [1,'asc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
</script>
    <?php
    $query3 = "SELECT v.id_v, v.imePrezime, v.aktivan FROM i_vlasnik v ORDER BY v.imePrezime";
    $result = mysql_query($query3) or die(mysql_error());;
    $options=" ";
    echo "<br>";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>ID</th>";
    echo "<th>Vlasnik</th>";
    echo "<th>opcije</th>";
    echo "</tr></thead>";
    echo "<tbody>";
    
    while ($row=mysql_fetch_array($result)) 
    {
        $id_vlasnika=$row['id_v'];
        $vlasnik_imePrezime=$row['imePrezime'];
        
      echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id_vlasnika</td>";
            echo "<td>$vlasnik_imePrezime</td>";
           
  
      echo "<td align='center'>";
                    if($A_NIVO==1 || $A_NIVO==2){
      echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/tretman.php',{akcija: 'izmeni_vlasnika',  LID:'".$LID."', vlasnik_id: '".$id_vlasnika."'}).fadeIn('slow');\"><img  src=\"../images/izmeni_dugme.png\" border=0 title=\"Izmeni\"></a>";
    if($A_NIVO==1){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/tretman.php',{akcija: 'obrisi_vlasnika',  LID:'".$LID."', vlasnik_id: '".$id_vlasnika."'}).fadeIn('slow');}\"><img  src=\"../images/obrisi_dugme.png\" border=0 title=\"Obriši\"></a>";
    }
                    }
    echo "</td>";
    echo "</tr>";
    
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>ID</th>";
    echo "<th>Vlasnik</th>";
    echo "<th>opcije</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}

if($akcija=='odgovori_na_komentar'){       
    //echo "<br>";
    $komentar_id = $_REQUEST['komentar_id'];
    $sqlR = "SELECT id_k, ime, komentar FROM t_komentari WHERE id_k='$komentar_id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id_k, $ime, $komentar)=@mysql_fetch_row($rezR);
        }
echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Odgovor na komentar:</strong></td></tr>";
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\">Komentar:</td>
    <td class=\"TD_EvenNew\" >$ime : $komentar</td></tr>";    
  
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\">Odgovor:</td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" ><textarea id=\"odgovor\"></textarea>";
echo "</td></tr>";
    
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\"></td>
    <td class=\"TD_EvenNew\" ><input type=\"submit\" onClick=\"var odgovor = \$('#odgovor').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/komentari.php',{akcija: 'odgovori_na_komentar_sql',  LID:'".$LID."', komentar_id: '".$komentar_id."', odgovor: odgovor}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Odgovori\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"cetrnaest\" value=\"Odustani\" ></td>
  </tr>
</table>";
}




if($akcija=='nov_tretman'){
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Dodeljivanje mera odredjenom vlasniku:</strong></td>
  </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Vlasnik:</strong></td>
    <td class=\"TD_EvenNew\">";
?>
 <select class="izaberi" id="id_vlasnika">
                     <?php
                    $sqlRanjivost = "SELECT id_v, imePrezime, aktivan FROM i_vlasnik ORDER BY imePrezime ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_vlasnika, $vlasnik_imePrezime)=@mysql_fetch_row($rezRanjivost)) {
       echo "<option value=\"$id_vlasnika\">$vlasnik_imePrezime</option>";
    }
    }      
?>
                     </select>
<script>
$(document).ready(function(){

//JT_init();
//initDhtmlGoodiesMenu();
   $('#add').click(function() {  
     return !$('#select1 option:selected').remove().appendTo('#select2');  
    });  
   $('#remove').click(function() {  
     return !$('#select2 option:selected').remove().appendTo('#select1');  
    });
    
  $('forma').submit(function() {  
  $('#select2 option').each(function(i) {  
   $(this).attr("selected", "selected");  
  });  
 }); 
});
</script>
                     <?php    
echo "</td></tr>";  
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Nagrupa mera</td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" align=\"left\">";
    $sqlNadgrupa = "SELECT idi_mng, sifra, naziv FROM i_mere_nadgrupa ORDER BY sifra ";
    $rezNadgrupa = mysql_query($sqlNadgrupa);
    if(mysql_num_rows($rezNadgrupa)>0){
    echo "<select id=\"id_nadgrupa\" name=\"id_nadgrupa\" onChange=\"var id_nadgrupe=this.value; \$('#id_grupe').hide().load('ajax/procena.php',{akcija: 'daj_grupu_mera', LID:'$LID', id_nadgrupe:id_nadgrupe}).fadeIn('fast');\">";
    echo "<option value=\"-\">Izaberite</option>";
    while (list($id_nadgrupa, $sifra_nadgrupa, $naziv_nadgrupa)=@mysql_fetch_row($rezNadgrupa)) {
        
        echo "<option value=\"$id_nadgrupa\">".$sifra_nadgrupa." ".$naziv_nadgrupa."</option>";
    
    }
    }
    echo "</select> ";
        
echo "</td>
  </tr>";
  
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\">Grupa mera:</td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >";
echo "<select id=\"id_grupe\" name=\"id_grupe\" onChange=\"var id_grupe=this.value; \$('#select1').hide().load('ajax/procena.php',{akcija: 'daj_meru', LID:'$LID', id_grupe:id_grupe}).fadeIn('fast');\">";
    echo "<option value=\"-\">Izaberite grupu mera</option>";
    echo "</select>";
echo "</td></tr>";
    
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\">Mere:</td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >";
  ?>
     <div class="izaberi">  
                     <select style="width: 450px;" class="izaberi" multiple id="select1">  
                    </select>  
                     <a class="izaberi" href="#" id="add">UBACI</a>  
                     </div>  
<?php
echo "</td></tr>";

echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\">Izabrane mere:</td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >";
  ?>
                     <div class="izaberi">  
                     <select style="width: 450px;" class="izaberi" multiple id="select2">
                     </select>
                     <a class="izaberi" href="#" id="remove">IZBACI</a>  
                     </div>
<?php
echo "</td></tr>";
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var id_vlasnika = \$('#id_vlasnika').val(); var items = []; $('#select2 option').each(function(){ items.push($(this).val()); }); var result = items.join(',');  prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/tretman.php',{akcija: 'ubaci_vlasmeru',  LID:'".$LID."', id_vlasnika: id_vlasnika, izbor_g: result}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Ubaci\" ></td></tr></table>";
}

if($akcija=='nov_vlasnik'){
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Nov Vlasnik:</strong></td>
  </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Vlasnik:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"vlasnik_imePrezime\" id=\"vlasnik_imePrezime\" /></td></tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var vlasnik_imePrezime = \$('#vlasnik_imePrezime').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/tretman.php',{akcija: 'ubaci_vlasnika',  LID:'".$LID."', vlasnik_imePrezime: vlasnik_imePrezime}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Ubaci\" ></td></tr></table>";
}



if($akcija=='uvoz_vlasnika'){
    $LID = $_REQUEST['LID'];
    echo "<br>";

echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Uvoz vlasnika:</strong></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\"></td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >";
    echo "<form action=\"./index.php?modul=uvoz_vlasnika&LID=$LID\" method=\"post\" enctype=\"multipart/form-data\" name=\"formPretr\">
<input name=\"akcija\" type=\"hidden\" value=\"uvezi\">

<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
  <tr>
    <td><label>Fajl:</label></td>
    <td ><input type=\"file\" name=\"userfile\" id=\"fajlID\" size=\"60\"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td ><label>
      <input type=\"submit\" name=\"button\" id=\"button\" value=\"Uvezi fajl\" />
    Fajl mora biti sa ekstenzijom XML!<br />
    </label></td>
  </tr>
</table>
</form>";
    echo "</td></tr></table>";
   
}

if($akcija=='backup_baze_forma'){
    $LID = $_REQUEST['LID'];
    echo "<br>";

echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Backup svih tabela:</strong></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\"></td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >
<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\"><tr>
    <td>&nbsp;</td>
    <td ><label>
      <input type=\"submit\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/porudzbine.php',{akcija: 'backup_baze_sql',  LID:'".$LID."'}).fadeIn('slow');}\" name=\"button\" id=\"button\" value=\"Backup\" />
    <br />
    </label></td>
  </tr>
</table>
</td></tr></table>";
   
}


if($akcija=='backup_baze_sql'){
     error_reporting(E_ALL);
     ini_set('display_errors','On');   
 /*
    function backup_tables($host,$user,$pass,$name,$tables = '*')
{
  
  $link = mysql_connect($host,$user,$pass);
  mysql_select_db($name,$link);
  
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  //cycle through
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    
    //$return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = ereg_replace("\n","\\n",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
  }
  
  //save file
  $handle = fopen('../backup/ismsapp-backup-'.time().'.sql','w+');
  fwrite($handle,$return);
  fclose($handle);
    
  $file = '../backup/ismsapp-backup-'.time().'.sql';
  $gzfile = '../backup/ismsapp-backup-'.time().'.gz';
  $fp = gzopen ($gzfile, 'w9');
  gzwrite ($fp, file_get_contents($file));
  gzclose($fp);
  
}
backup_tables('localhost','beonetusr_isousr','xidzXgme','beonetusr_iso');   
*/
$backupFile = 'ismsapp_backup_' . date("Y-m-d-H-i-s") . '.gz';
$command = "mysqldump --opt -h localhost -u beonetusr_isousr -p xidzXgme beonetusr_iso | gzip > $backupFile";
system($command);


 echo "<br>";

echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Backup svih tabela:</strong></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\"></td>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >
<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\"><tr>
    <td>&nbsp;</td>
    <td ><label>
      Backup baze je uspesno izvršen. Fajl je sačuvan u dir (/backup).
    <br />
    </label></td>
  </tr>
</table>
</td></tr></table>";    
    
}
if($akcija=='sacuvaj_stanje'){
    echo "<input type=\"submit\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/tretman.php',{akcija: 'sacuvaj_stanje_sql',  LID:'".$LID."',  korisnik:'".$ID_KORISNIKA."'}).fadeIn('slow');}\" value=\"Sacuvaj stanje\">";
}



if($akcija=='izaberite_grupu'){
    $sqlNadgrupa = "SELECT id_grupe, naziv, aktivan FROM t_grupe_korisnika WHERE id_grupe<>1 ORDER BY id_grupe ";
    $rezNadgrupa = mysql_query($sqlNadgrupa);
    if(mysql_num_rows($rezNadgrupa)>0){
    echo "<h2>Izaberite grupu korisnika</h2>";
    echo "<select id=\"id_grupe\" name=\"id_grupe\" onChange=\"var izabrana_grupa=this.value; prikaziLoad_mali('divLista'); \$('#divLista').hide().load('ajax/porudzbine.php',{akcija: 'lista_grupa_privilegija', LID:'$LID', izabrana_grupa:izabrana_grupa}).fadeIn('fast');\">";
    echo "<option value=\"-\">Izaberite</option>";
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rezNadgrupa)) {
        
        echo "<option value=\"$id_grupe\">".$naziv_grupe."</option>";
    
    }
    }
    echo "</select> ";
}


if($akcija=='lista_grupa_privilegija'){
   $izabrana_grupa = $_REQUEST['izabrana_grupa'];
     ?>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            /* Define two custom functions (asc and desc) for string sorting */
            jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            
            jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
                return ((x < y) ?  1 : ((x > y) ? -1 : 0));
            };
            
            $(document).ready(function() {
                /* Build the DataTable with third column using our custom sort functions */
                $('#example').dataTable( {
                    "aaSorting": [ [0,'asc'], [1,'asc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
            
            $(function () { // this line makes sure this code runs on page load
            $('.checkall').click(function () {
            $(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
            });
            
            function toggleChecked(status) {
$("#checkboxes input").each( function() {
$(this).attr("checked",status);
})}
});
</script>

    <?php
    $sql = "SELECT id_gp, id_grupe, modul, pregled, unos, izmena, brisanje FROM t_grupe_privilegije WHERE id_grupe=$izabrana_grupa ORDER BY id_gp";
    $rez = mysql_query($sql);
    echo "<br />";
   /*
    if($A_NIVO==1 || $A_NIVO==2){
echo "<a href=\"\" onClick=\"pom = proveri(); if(pom){var items = []; $('input[name=chkboxIzabrano]:checked').each(function(){ items.push($(this).val()); }); var result = items.join(','); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/procena.php',{akcija: 'obrisi_procenu_resursa_sel',  LID:'".$LID."', izbor_g: result}).fadeIn('slow');}\" ><img src=\"../images/kanta_velika.png\" border=0 title=\"Obriši obeležene\"></a>";
    }
    */
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
 //   echo "<th></th>";
    echo "<th>Modul</th>";
    echo "<th>Pregled</th>";
    echo "<th>Unos</th>";
    echo "<th>Izmena</th>";
    echo "<th>Obriši</th>";
    echo "<th>Sve</th>";
  //  echo "<th>opcije</th>";
    
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id_modula, $id_grupe, $naziv_modula, $pregled, $unos, $izmena, $brisanje)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
    //        echo "<td>$id_grupe</td>";
            echo "<div id=\"checkboxes\">";
            echo "<td>$naziv_modula</td>";
            if($pregled==1){$chk1='checked';}else{$chk1='';}
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/porudzbine.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'pregled'}).fadeIn('slow');\" $chk1></td>";
            if($unos==1){$chk2='checked';}else{$chk2='';}
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/porudzbine.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'unos'}).fadeIn('slow');\" $chk2></td>";
            if($izmena==1){$chk3='checked';}else{$chk3='';}
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/porudzbine.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'izmena'}).fadeIn('slow');\" $chk3></td>";
            if($brisanje==1){$chk4='checked';}else{$chk4='';}
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/porudzbine.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'brisanje'}).fadeIn('slow');\" $chk4></td>";
            if($pregled==1 && $unos==1 && $izmena==1 && $brisanje==1){$chk5='checked';}else{$chk5='';}
            /*
            echo "<td align=\"center\"><input  class=\"checkall\" name=\"chkbox_sve\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/porudzbine.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'sve'}).fadeIn('slow'); \" $chk5></td>";
            */
            echo "<td align=\"center\"><input  class=\"checkall\" name=\"chkbox_sve\" type=\"checkbox\" value=\"1\" onClick=\"\" $chk5></td>";
            echo "</div>";
    /*
    echo "<td align='right'>";
    if($A_NIVO==1 || $A_NIVO==2){
   echo "<div id=\"brisanje$id_procene\" name=\"brisanje$id_procene\">
    <a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/procena.php',{akcija: 'izmeni_procenu_resursa',  LID:'".$LID."', resurs_id: '".$resurs_idP."', ranjivost_id: '".$ranjivostP."', pretnja_id: '".$pretnjaP."', intenzitetP: '".$intenzitetP."', intenzitetR_pre: '".$intenzitetR_pre."', intenzitetR_posle: '".$intenzitetR_posle."'}).fadeIn('slow');\"><img src=\"../images/izmeni_dugme.png\" border=0 title=\"Izmeni\"></a>";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('brisanje$id_procene'); $('#brisanje$id_procene').load('ajax/procena.php',{akcija: 'obrisi_procenu_resursa',  LID:'".$LID."', resurs_id: '".$resurs_idP."', ranjivost_id: '".$ranjivostP."', pretnja_id: '".$pretnjaP."', intenzitetP: '".$intenzitetP."', intenzitetR_pre: '".$intenzitetR_pre."', intenzitetR_posle: '".$intenzitetR_posle."'}).fadeIn('slow');}\" ><img  src=\"../images/obrisi_dugme.png\" border=0 title=\"Obriši\"></a>";
    }
    
    echo "</div>";
    }
    echo "</td>";
    */
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
  //  echo "<th></th>";
    echo "<th>Modul</th>";
    echo "<th>Unos</th>";
    echo "<th>Dodaj</th>";
    echo "<th>Izmena</th>";
    echo "<th>Obriši</th>";
    echo "<th>Sve</th>";
   // echo "<th>opcije</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
    /*
    if($A_NIVO==1 || $A_NIVO==2){
echo "<a href=\"\" onClick=\"pom = proveri(); if(pom){var items = []; $('input[name=chkboxIzabrano]:checked').each(function(){ items.push($(this).val()); }); var result = items.join(','); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/procena.php',{akcija: 'obrisi_procenu_resursa_sel',  LID:'".$LID."', izbor_g: result}).fadeIn('slow');}\" ><img src=\"../images/kanta_velika.png\" border=0 title=\"Obriši obeležene\"></a>";
    }
    */
}

if($akcija=='posalji_vaucer_sql'){
    $id_porudzbine = $_REQUEST['porudzbina_id'];
    $sql = "SELECT p.id_p, p.id_komitenta, k.naziv, k.e_mail, p.id_akcije, a.naslov, p.datum, p.broj, p.sifra,a.popust, a.usteda, k.adresa, k.mesto, k.ptt, k.telefoni,DATE_ADD(a.datum, INTERVAL a.trajanje DAY) kraj, a.adresa, a.telefon FROM t_porudzbine p, t_komitenti k, t_akcije a WHERE p.id_komitenta=k.id_komitenta AND a.id_vesti=p.id_akcije AND p.id_p=$id_porudzbine ORDER BY p.id_p";
    $rez = mysql_query($sql);
     if(mysql_num_rows($rez)>0){
     list($id_porudzbine, $id_komitenta, $naziv_komitenta, $email_komitenta, $id_akcije, $naslov_akcije, $datum, $kolicina, $sifra_porudzbine, $popust_akcije, $usteda_akcije, $adresa_komitenta, $grad_komitenta, $postanski_broj_komitenta, $telefon_komitenta, $kraj_akcije, $adresa_akcije, $telefon_akcije)=@mysql_fetch_row($rez);        $kraj_akcije=strtotime($kraj_akcije);
     $kraj_akcije=date('d.m.Y.',$kraj_akcije);
     
///SLANJE EMAILA 
  if($id_akcije && $id_komitenta){
         
     //Podaci o akciji
     $sql_akcija = "SELECT naslov, teaser_txt, cena FROM t_akcije WHERE id_vesti=$id_akcije ";
     $rez_akcija = mysql_query($sql_akcija);
     list($naslov_akcije, $opis_akcije, $cena_akcije)=@mysql_fetch_row($rez_akcija);
     //podaci o akciji KRAJ
     $cena_akcije = $cena_akcije*$kolicina;
     //proveri i ubaci podatke o porudzbini
     $sql_proveri_porudzbinu = "SELECT id_porudzbine FROM t_vaucer WHERE id_porudzbine = '".$id_komitenta."' ";
     $rez_proveri_porudzbinu = mysql_query($sql_proveri_porudzbinu);
     if(mysql_num_rows($rez_proveri_porudzbinu)<1){

     $datum_slanja_vaucera = date('Y-m-d H:i:s');
        
     $sql_unos_slanja_vaucera = "INSERT INTO t_vaucer (id_porudzbine, datum) VALUES ('$id_porudzbine','$datum_slanja_vaucera') ";
     $rez_unos_slanja_vaucera = mysql_query($sql_unos_slanja_vaucera);
     if (!$rez_unos_slanja_vaucera) {
          die('Greska: '.$sql_unos_slanja_vaucera.' '. mysql_error());
                                 }   
     }
                                 
     //posalji email
               include_once('../../mail/htmlMimeMail.php');

            $msg="";

            $msg="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
            <style type=\"text/css\">
            #vrednost{
    font-family:Calibri,arial,helvetica;
    font-size:18px;
    color:#454849;
}

#vrednost span{
    font-family:Calibri,arial,helvetica;
    font-size:18px;
    color:#89b556;
}

p{
    font-family:Calibri,arial,helvetica;
    font-size:15px;
    color:#454849;
    text-align:justify;
    padding:10px;
    width:410px;    
}

#broj{
    font-family:Calibri,arial,helvetica;
    font-size:26px;
    color:#454849;
    border:1px #89b556 solid;
    width:300px;
    height:32px;
}

#podaci{
    font-family:Calibri,arial,helvetica;
    font-size:15px;
    color:#454849;
    padding:10px;
    width:300px;
}

#podaci span{
    font-family:Calibri,arial,helvetica;
    font-size:24px;
    color:#d63221;
}

.vaucer{
    font-family:Calibri,arial,helvetica;
    font-size:33px;
    font-weight:bold;
    color:#454849;
    padding-left:25px;
    text-transform:uppercase;
}

#ikonica_desno{
    background:url(../../images/favicon.png) no-repeat right;
    height:57px;
}
#container {
    width: 600px;
    height: 250px;
    position: relative;
}

#navi, 
#infoi {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
}

#navi {
    z-index: 5;
}


#infoi {
    z-index: 10;
}
            </style></head><body>";
            
            

            $msg.='
            <table width="700" border="0" cellspacing="0" cellpadding="0" style="border:1px #454849  dotted; padding-bottom:10px;">
  <tr>
    <td colspan="2" width="350" align="center" valign="bottom"><img src="http://www.snizeno.rs/images/logo_vaucer.png" style="margin:10px;" /><br />
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="vaucer">Akcija</td>
    
  </tr>
  <tr>
    <td valign="top" style="padding-top:10px;">
            <table width="350" border="0" cellspacing="0" cellpadding="0" id="vrednost">
                         <tr>
                           <td id="podaci" colspan="2" align="left" style="padding-left:30px;"><span>Podaci o korisniku:</span></td>
                         </tr>
                          <tr>
                            <td width="100" style="padding-left:30px;">Ime i prezime:</td>
                            <td width="135"><span>'.$naziv_komitenta.'</span></td>
                           </tr>
                          <tr>
                            <td width="100" style="padding-left:30px;">Adresa:</td>
                            <td width="135"><span>'.$adresa_komitenta.'</span></td>
                            </tr>
                          <tr>
                            <td width="100" style="padding-left:30px;">Grad:</td>
                            <td width="135"><span>'.$grad_komitenta.'</span></td>
                         </tr>
                          <tr>
                            <td width="100" style="padding-left:30px;">Poštanski broj:</td>
                            <td width="135"><span>'.$postanski_broj_komitenta.'</span></td>
                         </tr>
                          <tr>
                            <td width="100" style="padding-left:30px;">Telefon:</td>
                            <td width="135"><span>'.$telefon_komitenta.'</span></td>
                         </tr>
                          <tr>
                            <td width="100" style="padding-left:30px;">email:</td>
                            <td width="135"><span>'.$email_komitenta.'</span></td>
                         </tr>
                         <tr>
                            <td colspan="2" align="left" style="padding-left:30px;">&nbsp;</td>
                         </tr>
      </table>
    
   </td>
    <td valign="top" style="padding-top:10px;"><table width="350" border="0" cellspacing="0" cellpadding="0" id="vrednost">
      <tr>
        <td id="podaci" colspan="2" align="left" style="padding-left:30px;"><span>Podaci o akciji:</span></td>
      </tr>
      <tr>
        <td width="70" style="padding-left:30px;">Naziv:</td>
        <td width="230"><span>'.$naslov_akcije.'</span></td>
      </tr>
       <tr>
        <td width="70" style="padding-left:30px;"><b>CENA:</b></td>
        <td width="230"><span>'.$cena_akcije.' din</span></td>
      </tr>
      <tr>
        <td width="70" style="padding-left:30px;">Opis:</td>
        <td width="230"><span>'.$opis_akcije.'</span></td>
      </tr>
     
    </table></td>
  </tr>
  <tr>
    <td id="podaci" align="center" width="700" colspan="2" style="padding-left:40px;"><span>Vaučer je u atačmentu (pdf)</span>';
    
    $msg_email = '<div width="600px" id="tabela"><table width="600px" cellspacing="5" cellpadding="0">
  <tr>
    <td width="270px" align="center" valign="bottom"><img src="../../images/logo_vaucer.png" style="margin:10px;" /><br />
                    
    </td>
    <td colspan="3"><p style="font-family:Calibri,arial,helvetica; font-size:15px; color:#454849; text-align:justify; padding:10px; width:410px;" >'.$opis_akcije.'</p></td>
  </tr>
  <tr>
    <td align="center" id="vaucer">VAUČER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../images/vaucer_logo.png" /></td>
    
    <td width="330px" height="30px" align="center" id="okvir" ><div id="broj" width="290px">'.$sifra_porudzbine.'</div></td>
    
  </tr>
  <tr>
    <td style="padding-top:10px;">
<table width="270px" border="0" cellspacing="0" cellpadding="0" id="vrednost" style="font-family:Calibri,arial,helvetica; font-size:18px; color:#454849;">
                          <tr>
                            <td width="135px" style="padding-left:30px;">Vrednost:</td>
                            <td width="135px"><span style="font-family:Calibri,arial,helvetica; font-size:18px; color:#89b556;">'.$cena_akcije.'</span></td>
                           </tr>
                          <tr>
                            <td width="135px" style="padding-left:30px;">Popust:</td>
                            <td width="135px"><span style="font-family:Calibri,arial,helvetica; font-size:18px; color:#89b556;">'.$popust_akcije.'%</span></td>
                            </tr>
                          <tr>
                            <td width="135px" style="padding-left:30px;">Ušteda:</td>
                            <td width="135px"><span style="font-family:Calibri,arial,helvetica; font-size:18px; color:#89b556;">'.$usteda_akcije.' din</span></td>
                         </tr>
                         <tr>
                            <td width="135px" style="padding-left:30px;">Važi do:</td>
                            <td width="135px"><span style="font-family:Calibri,arial,helvetica; font-size:18px; color:#89b556;">'.$kraj_akcije.'</span></td>
                         </tr>
      </table>
    
   </td>
    <td id="podaci">
            Ovaj vaučer se može iskoristiti jedino u<br />
            <span id="naslov">'.$naslov_akcije.'</span><br />
            '.$adresa_akcije.'<br />
            Tel: '.$telefon_akcije.'
    </td>
  </tr>
</table></div>';

//$msg .= $msg_email;

$msg .='
    </td></tr>
    <tr>
      <td valign="top" id="podaci" align="left" width="350" style="padding-left:30px;"><b>Srdačno vaš Sniženo.rs</b><br />
    BIOČANIN DOO<br />
    Ranka Miljića 81<br />
                  11211 Borča, Beograd.<br />
                  Tel: +381 65 351 1 153<br />
                  <a href=\"mailto:office@snizeno.rs\">office@sniženo.rs</a><br>
                  <a href=\"http://www.snizeno.rs\" target=\"new\">www.snizeno.rs</a></td>
    <td valign="top" align="right" width="350" id="podaci"><b>Pratite nas:</b><br />
<a href="http://www.facebook.com/#!/pages/Snizenors/192861774112078"><img src="http://www.snizeno.rs/images/facebook_veliki.png" style="margin:10px;" /></a><a href="http://twitter.com/#!/snizeno"><img src="http://www.snizeno.rs/images/twitter_veliki.png" style="margin:10px;" /></a></td>
    </tr>
    </table>
            ';

                 $body = $msg;

               //$msg_email = 'test';
                
                ///PDF
                 define('_MPDF_PATH','../../MPDF52/');

                  include("../../MPDF52/mpdf.php");
                $mpdf = new mPDF('utf-8');
                $mpdf->debug = true;
                $mpdf->SetDisplayMode('fullpage');
                $mpdf->SetHeader("Snizeno.rs||Vaučer");
                $mpdf->SetFooter("Snizeno.rs||{PAGENO}/{nb}");
                $stylesheet = file_get_contents('pdf.css');
                $mpdf->WriteHTML($stylesheet,1);
                $mpdf->shrink_tables_to_fit=1;
                $mpdf->WriteHTML($msg_email); 
                $vreme = time();
                $mpdf->Output("../../2226200/vaucer_$sifra_porudzbine.pdf",'F');
                //PDF KRAJ

                //EMAIL     
                 $mail = new htmlMimeMail();
                $mail->setHtml($body);
                
                
                
            //    $mail->setFrom($email);
                $mail->setFrom("email@snizeno.rs");
                $mail->setBcc("munir.sarkar@mmstudio.rs");
                $mail->setSubject("Snizeno.rs - Vaucer za akciju ");
                $mail->setHeader('X-Mailer', 'HTML Mime mail class (http://www.phpguru.org)');
                $mail->setTextCharset('utf-8');
                
                $attachment = $mail->getFile("../../2226200/vaucer_$sifra_porudzbine.pdf");
                $mail->addAttachment($attachment,"vaucer_$sifra_porudzbine.pdf");

                $mail->setHtmlCharset('utf-8');              
                
              $mail->setSMTPParams('mail.snizeno.rs', 26, $hello, true, 'email@snizeno.rs', 'Password2011');
                $result = $mail->send(array($email_komitenta), 'smtp');           
                //EMAIL KRAJ
                
                
     //email kraj
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Vaučer je uspešno poslat na $email_komitenta.</strong></td></tr></table>";
     }
///SLANJE EMAILA     
     }

    
            
     
}


if($akcija=='priprema_vaucer'){
    $id_porudzbine = $_REQUEST['porudzbina_id'];
    $sql = "SELECT p.id_p, p.id_komitenta, k.naziv, k.e_mail, p.id_akcije, a.naslov, p.datum, p.broj, p.sifra FROM t_porudzbine p, t_komitenti k, t_akcije a WHERE p.id_komitenta=k.id_komitenta AND a.id_vesti=p.id_akcije AND p.id_p=$id_porudzbine ORDER BY p.id_p";
    $rez = mysql_query($sql);
     if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id_porudzbine, $id_komitenta, $naziv_komitenta, $email_komitenta, $id_akcije, $naslov_akcije, $datum, $kolicina, $sifra_porudzbine)=@mysql_fetch_row($rez)) {
 echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Priprema za slanje vaučera:</strong></td>
  </tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Ime i prezime:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"korisnik_imePrezime\" id=\"korisnik_imePrezime\" value=\"$naziv_komitenta\" readonly=\"readonly\" /></td>
    </tr>";  

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>korisničko ime / email</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"email\" id=\"email\" value=\"$email_komitenta\" readonly=\"readonly\" /></td>
    </tr>";  

      echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Šifra porudžbine</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"sifra\" id=\"sifra\" value=\"$sifra_porudzbine\" readonly=\"readonly\" /></td>
    </tr>";
    
        echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv akcije</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"akcija\" id=\"akcija\" value=\"$naslov_akcije\" readonly=\"readonly\" /></td>
    </tr>";
    
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/porudzbine.php',{akcija: 'posalji_vaucer_sql',  LID:'".$LID."', porudzbina_id: '".$id_porudzbine."'}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Pošalji vaučer\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"cetrnaest\" value=\"Odustani\" ></td></tr></table>";
            }
     }
            
}

if($akcija=='lista_komentara'){
  // $izabrana_vrsta = $_REQUEST['izabrana_vrsta'];
     ?>
     
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            /* Define two custom functions (asc and desc) for string sorting */
            jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            
            jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
                return ((x < y) ?  1 : ((x > y) ? -1 : 0));
            };
            
            $(document).ready(function() {
                /* Build the DataTable with third column using our custom sort functions */
                $('#example').dataTable( {
                    "aaSorting": [ [0,'desc'], [1,'desc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
</script>
    <?php
    $sql = "SELECT k.id_k, a.naziv, k.ime, k.komentar, k.confirm, k.datum  FROM t_komentari k, t_smestaj a WHERE k.id_akcije=a.id ORDER BY datum DESC";
    $rez = mysql_query($sql);
    echo "<br />";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>ID</th>";
    echo "<th>Akcija</th>";
    echo "<th>Ime i Prezime</th>";
    echo "<th>Komentar</th>";
    echo "<th>Odobren</th>";
    echo "<th>Datum</th>";
    echo "<th>opcije</th>";
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id_komentara, $kom_akcija, $kom_ime, $kom_komentar, $kom_confirm, $kom_datum)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id_komentara</td>";
            echo "<td>$kom_akcija</td>";
            echo "<td>$kom_ime</td>";
            echo "<td>$kom_komentar</td>";
            echo "<td>";
            if($kom_confirm==1){
                echo "<img src=\"./images/confirm_icon.jpg\" border=0 title=\"Odobren\">";
            }
            echo "</td>";
            echo "<td>$kom_datum</td>";
            
    
    echo "<td align='right'>";
    if($A_NIVO==1 || $A_NIVO==2){
   echo "<div id=\"brisanje$id_komitenta\" name=\"brisanje$id_komitenta\">
    <a href=\"#\" onClick=\"prikaziLoad_mali('divLista'); $('#divLista').load('ajax/komentari.php',{akcija: 'odobri_komentar',  LID:'".$LID."', komentar_id: '".$id_komentara."'}).fadeIn('slow');\"><img src=\"./images/confirm_icon.jpg\" border=0 title=\"Odobri\"></a>";
    echo "<div id=\"brisanje$id_komitenta\" name=\"brisanje$id_komitenta\">
    <a href=\"#\" onClick=\"prikaziLoad_mali('divLista'); $('#divLista').load('ajax/komentari.php',{akcija: 'odgovori_na_komentar',  LID:'".$LID."', komentar_id: '".$id_komentara."'}).fadeIn('slow');\"><img src=\"./images/komentar.jpg\" border=0 title=\"Odgovori\"></a>";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/komentari.php',{akcija: 'obrisi_komentar',  LID:'".$LID."', komentar_id: '".$id_komentara."'}).fadeIn('slow');}\" ><img  src=\"./images/obrisi_dugme.png\" border=0 title=\"Obriši komentar\"></a>";
    }
    
    echo "</div>";
    }
    echo "</td>";
    
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
   echo "<th>ID</th>";
    echo "<th>Akcija</th>";
    echo "<th>Ime i Prezime</th>";
    echo "<th>Komentar</th>";
    echo "<th>Odobren</th>";
    echo "<th>Datum</th>";
    echo "<th>opcije</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
    /*
    if($A_NIVO==1 || $A_NIVO==2){
echo "<a href=\"\" onClick=\"pom = proveri(); if(pom){var items = []; $('input[name=chkboxIzabrano]:checked').each(function(){ items.push($(this).val()); }); var result = items.join(','); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/procena.php',{akcija: 'obrisi_procenu_resursa_sel',  LID:'".$LID."', izbor_g: result}).fadeIn('slow');}\" ><img src=\"../images/kanta_velika.png\" border=0 title=\"Obriši obeležene\"></a>";
    }
    */
}

if($akcija=='primeni_klik'){
       $izabrana_grupa = $_REQUEST['izabrana_grupa'];
       $id_modula = $_REQUEST['id_modula'];
       $setovanje = $_REQUEST['set'];
       $sqlRanjivost = "SELECT pregled, unos, izmena, brisanje FROM t_grupe_privilegije WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";
       
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    list($pregled, $unos, $izmena, $brisanje)=@mysql_fetch_row($rezRanjivost);
    
    if($setovanje=='pregled'){
        if($pregled==1){
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET pregled=0 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }else{
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET pregled=1 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }
    }
    
    if($setovanje=='unos'){
        if($unos==1){
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET unos=0 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }else{
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET unos=1 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }
    }
    
    if($setovanje=='izmena'){
        if($izmena==1){
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET izmena=0 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }else{
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET izmena=1 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }
    }
    
    if($setovanje=='brisanje'){
        if($brisanje==1){
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET brisanje=0 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }else{
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET brisanje=1 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
        }
    } 
    
    if($setovanje=='sve'){
            if($brisanje==1){
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET pregled=0, unos=0, izmena=0, brisanje=0 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
            }else{
            $primeni_setovanje = "UPDATE t_grupe_privilegije SET pregled=1, unos=1, izmena=1, brisanje=1 WHERE id_gp=$id_modula AND id_grupe=$izabrana_grupa ";    
            $rez_primeni_setovanje = mysql_query($primeni_setovanje);
            }
        
    }
    
    }
       
    echo "Uspešno primenjena privilegija za zadatu grupu korisnika";
}
if($akcija=='nov_klijent'){
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Nov korisnik:</strong></td>
  </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Ime i prezime:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"korisnik_imePrezime\" id=\"korisnik_imePrezime\" /></td>
    </tr>";  
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>korisničko ime / email</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"email\" id=\"email\" /></td>
    </tr>";  
  
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>lozinka</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"password\" size=\"50\" name=\"lozinka\" id=\"lozinka\" /></td>
    </tr>";
      
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var email = \$('#email').val(); var lozinka = \$('#lozinka').val(); var korisnik_imePrezime = \$('#korisnik_imePrezime').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/porudzbine.php',{akcija: 'ubaci_klijenta',  LID:'".$LID."', korisnik_imePrezime: korisnik_imePrezime, lozinka: lozinka, email: email}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Ubaci\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"cetrnaest\" value=\"Odustani\" ></td></tr></table>";
}

?>

