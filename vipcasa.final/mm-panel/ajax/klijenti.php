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

if($akcija=='obrisi_vlasmere'){
    $vlasnik_id = $_REQUEST['vlasnik_id'];
    $sql_unos_ranjivost = "DELETE FROM i_vlasmere WHERE id_v = '$vlasnik_id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost);
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error());
        }  
        //echo "uspesno";
$akcija='lista_tretmana';
}

if($akcija=='obrisi_vlasnika'){
    $vlasnik_id = $_REQUEST['vlasnik_id'];
    $sql_unos_ranjivost = "DELETE FROM i_vlasnik WHERE id_v = '$vlasnik_id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost);
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error());
        }  
        //echo "uspesno";
$akcija='lista_vlasnika';
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

if($akcija=='ubaci_vlasnika'){
     $vlasnik =  $_REQUEST['vlasnik_imePrezime']; 
       $sql_unos_ranjmere = "INSERT INTO i_vlasnik (imePrezime, aktivan) VALUES ('$vlasnik', '1')";
       $rez_unos_ranjmere = mysql_query($sql_unos_ranjmere);
        if (!$rez_unos_ranjmere) {
            die('Greska: '.$sql_unos_ranjmere.' '. mysql_error());
                                 }   
   $akcija='lista_vlasnika';
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

if($akcija=='izmeni_vlasmere'){
        ?>
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
    //echo "<br>";
    $vlasnik_id = $_REQUEST['vlasnik_id'];
    $sqlR = "SELECT id_v, imePrezime FROM i_vlasnik WHERE id_v='$vlasnik_id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id_vlasnikaR, $vlasnik_imePrezimeR)=@mysql_fetch_row($rezR);
        }
echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena mera za odredjenog vlasnika:</strong></td></tr>";
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\">Ime i prezime:</td>
    <td class=\"TD_EvenNew\" ><input type=\"text\" size=\"50\" name=\"vlasnik_imePrezime\" readonly value=\"$vlasnik_imePrezimeR\" id=\"vlasnik_imePrezime\" /></td></tr>";    
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
                                          <?php
                    $sqlMereOdabrano = "SELECT m.idi_m, m.sifra, m.naziv FROM i_mere m, i_vlasmere vm WHERE vm.id_v='$vlasnik_id' AND vm.id_mere=m.idi_m ";
    $rezMereOdabrano = mysql_query($sqlMereOdabrano);
    if(mysql_num_rows($rezMereOdabrano)>0){
    while (list($id_mereO, $sifraMereO, $naziv_mereO)=@mysql_fetch_row($rezMereOdabrano)) {
       echo "<option value=\"$id_mereO\">$sifraMereO $naziv_mereO</option>";
    }
    }      
?>
                     </select>
                     <a class="izaberi" href="#" id="remove">IZBACI</a>  
                     </div>
<?php
echo "</td></tr>";
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\"></td>
    <td class=\"TD_EvenNew\" ><input type=\"submit\" onClick=\"var items = []; $('#select2 option').each(function(){ items.push($(this).val()); }); var result = items.join(',');  var izbor = \$('#select2').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/tretman.php',{akcija: 'izmeni_vlasmere_sql',  LID:'".$LID."', vlasnik_id: '".$vlasnik_id."', izbor_g: result}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Izmeni\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"cetrnaest\" value=\"Odustani\" ></td>
  </tr>
</table>";
}

if($akcija=='izmeni_vlasnika'){
       
    
    $vlasnik_id = $_REQUEST['vlasnik_id'];
    $sqlR = "SELECT id_v, imePrezime FROM i_vlasnik WHERE id_v='$vlasnik_id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id_vlasnikaR, $vlasnik_imePrezimeR)=@mysql_fetch_row($rezR);
        }
echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena mera za odredjenog vlasnika:</strong></td></tr>";
echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\">Ime i prezime:</td>
    <td class=\"TD_EvenNew\" ><input type=\"text\" size=\"50\" name=\"vlasnik_imePrezime\" value=\"$vlasnik_imePrezimeR\" id=\"vlasnik_imePrezime\" /></td></tr>";    

echo "<tr><td class=\"TD_EvenNew\" width=\"100\" style=\"padding: 10px 5px 10px 10px\"></td>
    <td class=\"TD_EvenNew\" ><input type=\"submit\" onClick=\"var vlasnik_imePrezime = \$('#vlasnik_imePrezime').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/tretman.php',{akcija: 'izmeni_vlasnika_sql',  LID:'".$LID."', vlasnik_id: '".$vlasnik_id."', vlasnik_imePrezime: vlasnik_imePrezime}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Izmeni\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"cetrnaest\" value=\"Odustani\" ></td>
  </tr>
</table>";
}

if($akcija=='izmeni_klijenta'){
    $klijent_id = $_REQUEST['klijent_id'];
    $sqlR = "SELECT naziv, e_mail FROM t_komitenti WHERE id_komitenta='$klijent_id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($naziv_klijenta, $email_klijenta)=@mysql_fetch_row($rezR);
        }
 echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmeni korisnika:</strong></td>
  </tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Ime i prezime:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"korisnik_imePrezime\" id=\"korisnik_imePrezime\" value=\"$naziv_klijenta\" /></td>
    </tr>";  

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>korisničko ime / email</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"email\" id=\"email\" value=\"$email_klijenta\" /></td>
    </tr>";  

      echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>nova lozinka</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"password\" size=\"50\" name=\"lozinka\" id=\"lozinka\" value=\"\" /></td>
    </tr>";
    
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var email = \$('#email').val(); var lozinka = \$('#lozinka').val(); var korisnik_imePrezime = \$('#korisnik_imePrezime').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/klijenti.php',{akcija: 'izmeni_klijenta_sql',  LID:'".$LID."', korisnik_imePrezime: korisnik_imePrezime, lozinka: lozinka, email: email, klijent_id: '".$klijent_id."'}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Izmeni\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"cetrnaest\" value=\"Odustani\" ></td></tr></table>";
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
      <input type=\"submit\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/klijenti.php',{akcija: 'backup_baze_sql',  LID:'".$LID."'}).fadeIn('slow');}\" name=\"button\" id=\"button\" value=\"Backup\" />
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
    echo "<select id=\"id_grupe\" name=\"id_grupe\" onChange=\"var izabrana_grupa=this.value; prikaziLoad_mali('divLista'); \$('#divLista').hide().load('ajax/klijenti.php',{akcija: 'lista_grupa_privilegija', LID:'$LID', izabrana_grupa:izabrana_grupa}).fadeIn('fast');\">";
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
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/klijenti.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'pregled'}).fadeIn('slow');\" $chk1></td>";
            if($unos==1){$chk2='checked';}else{$chk2='';}
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/klijenti.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'unos'}).fadeIn('slow');\" $chk2></td>";
            if($izmena==1){$chk3='checked';}else{$chk3='';}
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/klijenti.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'izmena'}).fadeIn('slow');\" $chk3></td>";
            if($brisanje==1){$chk4='checked';}else{$chk4='';}
            echo "<td align=\"center\"><input name=\"chkbox$id_modula\" id=\"chkbox$id_modula\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/klijenti.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'brisanje'}).fadeIn('slow');\" $chk4></td>";
            if($pregled==1 && $unos==1 && $izmena==1 && $brisanje==1){$chk5='checked';}else{$chk5='';}
            /*
            echo "<td align=\"center\"><input  class=\"checkall\" name=\"chkbox_sve\" type=\"checkbox\" value=\"1\" onClick=\"prikaziLoad_mali('divMiddle'); $('#divMiddle').load('ajax/klijenti.php',{akcija: 'primeni_klik',  LID:'".$LID."', izabrana_grupa: '".$izabrana_grupa."', id_modula:'".$id_modula."', set: 'sve'}).fadeIn('slow'); \" $chk5></td>";
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

if($akcija=='lista_klijenata'){
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
                    "aaSorting": [ [0,'asc'], [1,'asc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
</script>
    <?php
    $sql = "SELECT k.id_komitenta, k.naziv, k.e_mail FROM t_komitenti k ORDER BY k.naziv";
    $rez = mysql_query($sql);
    echo "<br />";
    /*
    if($A_NIVO==1 || $A_NIVO==2){
echo "<a href=\"\" onClick=\"pom = proveri(); if(pom){var items = []; $('input[name=chkboxIzabrano]:checked').each(function(){ items.push($(this).val()); }); var result = items.join(','); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/procena.php',{akcija: 'obrisi_procenu_resursa_sel',  LID:'".$LID."', izbor_g: result}).fadeIn('slow');}\" ><img src=\"../images/kanta_velika.png\" border=0 title=\"Obriši obeležene\"></a>";
    }
    */
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>ID</th>";
    echo "<th>Ime i Prezime</th>";
    echo "<th>email</th>";
    echo "<th>opcije</th>";
    
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id_komitenta, $ime_komitenta, $email_komitenta)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id_komitenta</td>";
            echo "<td>$ime_komitenta</td>";
            echo "<td align=\"left\">$email_komitenta</td>";
    
    echo "<td align='right'>";
    if($A_NIVO==1 || $A_NIVO==2){
   echo "<div id=\"brisanje$id_komitenta\" name=\"brisanje$id_komitenta\">
    <a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/klijenti.php',{akcija: 'izmeni_klijenta',  LID:'".$LID."', klijent_id: '".$id_komitenta."'}).fadeIn('slow');\"><img src=\"./images/izmeni_dugme.png\" border=0 title=\"Izmeni\"></a>";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/klijenti.php',{akcija: 'obrisi_klijenta',  LID:'".$LID."', klijent_id: '".$id_komitenta."'}).fadeIn('slow');}\" ><img  src=\"./images/obrisi_dugme.png\" border=0 title=\"Obriši\"></a>";
    }
    
    echo "</div>";
    }
    echo "</td>";
    
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>ID</th>";
    echo "<th>Ime i Prezime</th>";
    echo "<th>email</th>";
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
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var email = \$('#email').val(); var lozinka = \$('#lozinka').val(); var korisnik_imePrezime = \$('#korisnik_imePrezime').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/klijenti.php',{akcija: 'ubaci_klijenta',  LID:'".$LID."', korisnik_imePrezime: korisnik_imePrezime, lozinka: lozinka, email: email}).fadeIn('slow');\" class=\"cetrnaest\" value=\"Ubaci\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"cetrnaest\" value=\"Odustani\" ></td></tr></table>";
}

?>

