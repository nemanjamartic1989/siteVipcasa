<?php
header("Content-Type: text/html; charset=utf-8");

include("../uklj/baza_heder.php");// ukljucivanje php fajlova
include("../uklj/datum.php");// ukljucivanje php fajlova
include("../uklj/sesija.php"); // ukljucivanje php fajlova
include("../uklj/podesavanje.php");// ukljucivanje php fajlova

$debugMail = 0; //samo za test ako je 1, ne salje se stvarno mail

$folder = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); // basename - Returns trailing(zavrsni) name component of path.Given a string containing the path to a file or directory, this function will return the trailing name component.
$url_ovde = sprintf('http://%s%s', $_SERVER['SERVER_NAME'], $folder); // sprintf — vraca formatirani string.

$akcija = $_REQUEST['akcija'];
$LID = $_REQUEST['LID'];

//if($akcija!="proveriKorisnika"){echo "<h2>akcija:$akcija ; LID:$LID</h2>";}

if($LID){//produzavam sesiju:
 $rv = rand(1,2);
  if ($rv==2){
$sql2="UPDATE t_sesije_korisnici SET posl_vreme_pristupa = '".time()."' WHERE sesija = '".$LID."'"; //time — Return current Unix timestamp.Returns the current time measured in the number of seconds since the Unix Epoch (January 1 1970 00:00:00 GMT).
$rez2 = mysql_query($sql2); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
  }
}

$debug = 0;

if($akcija=='obrisi_korisnika'){
    $korisnik_id = $_REQUEST['korisnik_id'];
    $sql_unos_ranjivost = "DELETE FROM t_korisnici WHERE id_korisnika = '$korisnik_id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
        }  
        //echo "uspesno";
$akcija='lista_korisnika';
}



if($akcija=='obrisi_vrstu'){
    $id = $_REQUEST['id'];
    $sql_unos_ranjivost = "DELETE FROM vrsta WHERE id = '$id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
        }  
        //echo "uspesno";
$akcija='lista_vrsta';
}

if($akcija=='obrisi_tip'){
    $id = $_REQUEST['id'];
    $sql_unos_ranjivost = "DELETE FROM tip WHERE id = '$id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
        }  
        //echo "uspesno";
$akcija='lista_tipova';
}

if($akcija=='obrisi_lokaciju'){
    $id = $_REQUEST['id'];
    $sql_unos_ranjivost = "DELETE FROM lokacija WHERE id = '$id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
        }  
        //echo "uspesno";
$akcija='lista_lokacija';
}

if($akcija=='obrisi_stan'){
    $id = $_REQUEST['id'];
    $sql_unos_ranjivost = "DELETE FROM stan WHERE id = '$id' ";
    $rez_unos_ranjivost = mysql_query($sql_unos_ranjivost); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_ranjivost) {
            die('Greska: '.$sql_unos_ranjivost.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
        }  
        //echo "uspesno";
$akcija='lista_stanova';
}

if($akcija=='izmeni_korisnika_sql'){
     $korisnik_id =  $_REQUEST['korisnik_id']; 
     $korisnik_imePrezime =  $_REQUEST['korisnik_imePrezime']; 
     $username_korisnika =  $_REQUEST['username']; 
     $lozinka_korisnika =  $_REQUEST['lozinka']; 
     $lozinka_korisnika = md5($lozinka_korisnika);
     $email_korisnika =  $_REQUEST['email']; 
     $id_grupe_korisnika =  $_REQUEST['id_grupe']; 
     $sql_unos_korisnika = "UPDATE t_korisnici SET korisnik='$username_korisnika', lozinka='$lozinka_korisnika', ime_prezime='$korisnik_imePrezime', email='$email_korisnika', id_grupe='$id_grupe_korisnika', admin_nivo='$id_grupe_korisnika' WHERE id_korisnika='$korisnik_id' ";
     $rez_unos_korisnika = mysql_query($sql_unos_korisnika); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_korisnika) {
            die('Greska: '.$sql_unos_korisnika.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_korisnika';
}

if($akcija=='izmeni_vrstu_sql'){
     $id =  $_REQUEST['id']; 
     $naziv_vrste =  $_REQUEST['naziv']; 
     $status_vrste =  $_REQUEST['status']; 
     
     $sql_unos_vrsta = "UPDATE vrsta SET naziv='$naziv_vrste', status='$status_vrste' WHERE id='$id' ";
     $rez_unos_vrsta = mysql_query($sql_unos_vrsta); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_vrsta) {
            die('Greska: '.$sql_unos_vrsta.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_vrsta';
}

if($akcija=='izmeni_tip_sql'){
     $id =  $_REQUEST['id']; 
     $naziv_tipa =  $_REQUEST['naziv']; 
     
     
     $sql_unos_tipa = "UPDATE tip SET naziv='$naziv_tipa' WHERE id='$id' ";
     $rez_unos_tipa = mysql_query($sql_unos_tipa); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_tipa) {
            die('Greska: '.$sql_unos_tipa.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_tipova';
}

if($akcija=='izmeni_lokaciju_sql'){
     $id =  $_REQUEST['id']; 
     $naziv =  $_REQUEST['naziv'];
     $mesto =  $_REQUEST['mesto']; 
     $adresa =  $_REQUEST['adresa'];
     $status =  $_REQUEST['status']; 
     $sold =  $_REQUEST['sold']; 
     $broj_spratova =  $_REQUEST['broj_spratova']; 
     $podovi =  $_REQUEST['podovi']; 
     $zidovi =  $_REQUEST['zidovi']; 
     $plafon =  $_REQUEST['plafon']; 
     $prozori_vrata =  $_REQUEST['prozori_vrata']; 
     $bravarija =  $_REQUEST['bravarija'];
     $krov =  $_REQUEST['krov']; 
     $konstrukcija =  $_REQUEST['konstrukcija']; 
     $instalacija =  $_REQUEST['instalacija'];    
     $lat =  $_REQUEST['lat'];    
     $lon =  $_REQUEST['lon'];    
     
     
     $sql_unos_lokacija = "UPDATE lokacija SET naziv='$naziv', mesto='$mesto', adresa='$adresa', status='$status', sold='$sold', broj_spratova='$broj_spratova', podovi='$podovi', zidovi='$zidovi', plafon='$plafon', prozori_vrata='$prozori_vrata', bravarija='$bravarija', krov='$krov', konstrukcija='$konstrukcija', instalacija='$instalacija', lat='$lat', lon='$lon'  WHERE id='$id'
     ";
     $rez_unos_lokacija = mysql_query($sql_unos_lokacija); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_lokacija) {
            die('Greska: '.$sql_unos_lokacija.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_lokacija';
}

if($akcija=='izmeni_stan_sql'){
     $id =  $_REQUEST['id']; 
     $sprat =  $_REQUEST['sprat'];
     $opis=$_REQUEST['opis'];
     $status =  $_REQUEST['status'];
     $prodat = $_REQUEST['prodat'];
     $vrsta_id =  $_REQUEST['vrsta_id']; 
     $tip_id =  $_REQUEST['tip_id'];
     $lokacija_id =  $_REQUEST['lokacija_id']; 
     $sql_unos_stan = "UPDATE stan SET sprat='$sprat', opis='$opis', status='$status', prodat='$prodat', vrsta_id='$vrsta_id', tip_id='$tip_id', lokacija_id='$lokacija_id'  WHERE id='$id' ";
     $rez_unos_stan = mysql_query($sql_unos_stan); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_stan) {
            die('Greska: '.$sql_unos_stan.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_stanova';

}


if($akcija=='ubaci_korisnika'){
     $korisnik_imePrezime =  $_REQUEST['korisnik_imePrezime']; 
     $username_korisnika =  $_REQUEST['username']; 
     $lozinka_korisnika =  $_REQUEST['lozinka']; 
     $lozinka_korisnika = md5($lozinka_korisnika);
     $email_korisnika =  $_REQUEST['email']; 
     $id_grupe_korisnika =  $_REQUEST['id_grupe']; 
     $sql_unos_korisnika = "INSERT INTO t_korisnici (korisnik, lozinka, ime_prezime, email, id_grupe, admin_nivo) VALUES ('$username_korisnika', '$lozinka_korisnika', '$korisnik_imePrezime', '$email_korisnika', '$id_grupe_korisnika', '$id_grupe_korisnika')";
     $rez_unos_korisnika = mysql_query($sql_unos_korisnika); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_korisnika) {
            die('Greska: '.$sql_unos_korisnika.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_korisnika';
}



if($akcija=='ubaci_vrstu'){
     $status =  $_REQUEST['status']; 
     $naziv_vrste =  $_REQUEST['naziv_vrste']; 
     $sql_unos_korisnika = "INSERT INTO vrsta (status, naziv) VALUES ('$status', '$naziv_vrste')";
     $rez_unos_korisnika = mysql_query($sql_unos_korisnika); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_korisnika) {
            die('Greska: '.$sql_unos_korisnika.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_vrsta';
}

if($akcija=='ubaci_tip'){
     $naziv_tipa =  $_REQUEST['naziv_tipa']; 
     
     $sql_unos_tipa = "INSERT INTO tip (naziv) VALUES ('$naziv_tipa')";
     $rez_unos_tipa = mysql_query($sql_unos_tipa); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_tipa) {
            die('Greska: '.$sql_unos_tipa.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_tipova';
}

if($akcija=='ubaci_lokaciju'){
     $naziv =  $_REQUEST['naziv']; 
     $mesto =  $_REQUEST['mesto']; 
     $adresa =  $_REQUEST['adresa']; 
     $status =  $_REQUEST['status']; 
     $sold =  $_REQUEST['sold']; 
     $broj_spratova =  $_REQUEST['broj_spratova']; 
     $podovi =  $_REQUEST['podovi']; 
     $zidovi =  $_REQUEST['zidovi']; 
     $plafon =  $_REQUEST['plafon']; 
     $prozori_vrata =  $_REQUEST['prozori_vrata'];
     $bravarija =  $_REQUEST['bravarija']; 
     $krov =  $_REQUEST['krov']; 
     $konstrukcija =  $_REQUEST['konstrukcija']; 
     $instalacija =  $_REQUEST['instalacija'];  
     $lat =  $_REQUEST['lat'];  
     $lon =  $_REQUEST['lon'];  
     
     $sql_unos_lokacija = "INSERT INTO lokacija (naziv, mesto, adresa, status, sold, broj_spratova, podovi, zidovi, plafon, prozori_vrata, bravarija, krov, konstrukcija, instalacija, lat, lon) VALUES ('$naziv', '$mesto', '$adresa', '$status', '$sold',
      '$broj_spratova', '$podovi',  '$zidovi', '$plafon', '$prozori_vrata', '$bravarija', '$krov', '$konstrukcija', 
      '$instalacija', '$lat', '$lon')";
     $rez_unos_lokacija = mysql_query($sql_unos_lokacija); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_lokacija) {
            die('Greska: '.$sql_unos_lokacija.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_lokacija';
}

if($akcija=='ubaci_stan'){
     $sprat =  $_REQUEST['sprat'];
     $opis =  $_REQUEST['opis']; 
     $status =  $_REQUEST['status'];
     $prodat =  $_REQUEST['prodat'];
     $vrsta_id =  $_REQUEST['vrsta_id']; 
     $tip_id =  $_REQUEST['tip_id'];
     $lokacija_id =  $_REQUEST['lokacija_id'];  
  
     
     
     $sql_unos_stan = "INSERT INTO stan (sprat, opis, status, prodat, vrsta_id, tip_id, lokacija_id) VALUES ('$sprat', '$opis', '$status', '$prodat', '$vrsta_id', '$tip_id', '$lokacija_id')";
     $rez_unos_stan = mysql_query($sql_unos_stan); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
        if (!$rez_unos_stan) {
            die('Greska: '.$sql_unos_stan.' '. mysql_error()); // mysql_error — Returns the text of the error message from previous MySQL operation
                                 }   
   $akcija='lista_stanova';
}


if($akcija=='izmeni_korisnika'){
    $korisnik_id = $_REQUEST['korisnik_id'];
    $sqlR = "SELECT id_korisnika, korisnik, lozinka, ime_prezime, email, id_grupe FROM t_korisnici WHERE id_korisnika='$korisnik_id' ";
    $rezR = mysql_query($sqlR); // mysql_query — Send a MySQL query.mysql_query() sends a unique query (multiple queries are not supported) to the currently active database on the server that's associated with the specified link_identifier.
    if(mysql_num_rows($rezR)>0){ // mysql_num_rows — Get number of rows in result.Retrieves the number of rows from a result set. This command is only valid for statements like SELECT or SHOW that return an actual result set. To retrieve the number of rows affected by a INSERT, UPDATE, REPLACE or DELETE query, use mysql_affected_rows().
    list($id_korisnikaK, $korisnik_usernameK, $korisnik_lozinkaK, $korisnik_imeK, $korisnik_emailK, $korisnik_grupaK)=@mysql_fetch_row($rezR);
        }
 echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Edit user:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Group:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"id_grupe\">";
                     
                    $sqlRanjivost = "SELECT id_grupe, naziv, aktivan FROM t_grupe_korisnika ORDER BY id_grupe ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){ // mysql_num_rows — Get number of rows in result.Retrieves the number of rows from a result set. This command is only valid for statements like SELECT or SHOW that return an actual result set. To retrieve the number of rows affected by a INSERT, UPDATE, REPLACE or DELETE query, use mysql_affected_rows().
    while (list($id_grupe, $naziv_grupe, $aktivnost_grupe)=@mysql_fetch_row($rezRanjivost)) { //mysql_fetch_row — Get a result row as an enumerated array.
        if($korisnik_grupaK==$id_grupe){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Full name:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"korisnik_imePrezime\" id=\"korisnik_imePrezime\" value=\"$korisnik_imeK\" /></td>
    </tr>";  
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>username</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"username\" id=\"username\" value=\"$korisnik_usernameK\" /></td>
    </tr>";      
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>password</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"password\" size=\"50\" name=\"lozinka\" id=\"lozinka\" value=\"$korisnik_lozinkaK\" /></td>
    </tr>";
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>email</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"email\" id=\"email\" value=\"$korisnik_emailK\" /></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var email = \$('#email').val(); var lozinka = \$('#lozinka').val(); var username = \$('#username').val(); var korisnik_imePrezime = \$('#korisnik_imePrezime').val(); var id_grupe = \$('#id_grupe').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'izmeni_korisnika_sql',  LID:'".$LID."', id_grupe: id_grupe, korisnik_imePrezime: korisnik_imePrezime, username: username, lozinka: lozinka, email: email, korisnik_id: '".$korisnik_id."'}).fadeIn('slow');\" class=\"btn\" value=\"Edit\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

if($akcija=='izmeni_vrstu'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, naziv, status FROM vrsta WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){ // mysql_num_rows — Get number of rows in result.Retrieves the number of rows from a result set. This command is only valid for statements like SELECT or SHOW that return an actual result set. To retrieve the number of rows affected by a INSERT, UPDATE, REPLACE or DELETE query, use mysql_affected_rows().
    list($id, $naziv_vrste, $status_vrste)=@mysql_fetch_row($rezR);//mysql_fetch_row — Get a result row as an enumerated array.
        }
 echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Edit vrste:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Status:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"id_grupe\">";
                     
       echo "<option value=\"1\" $chk>aktivan</option>";  
       echo "<option value=\"0\" $chk>neaktivan</option>";
    echo "</select></td></tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"naziv_vrste\" id=\"naziv_vrste\" value=\"$naziv_vrste\" /></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var status = \$('#status_vrste').val(); var naziv = \$('#naziv_vrste').val();  prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'izmeni_vrstu_sql',  LID:'".$LID."', naziv: naziv, status: status, id: '".$id."'}).fadeIn('slow');\" class=\"btn\" value=\"Edit\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

/* Brisanje slike lokacije */
if($akcija=='brisanje_slike_lokacije'){
    $id = $_REQUEST['id']; 
    $imgfile = $_REQUEST['imgfile']; 
    $sqlQueryDeletePhotosGallery = "UPDATE lokacija SET img='' WHERE id='$id' ";    
    //$rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
    //if(mysql_num_rows($rezQueryDeletePhotosGallery)>0){
    if(1==1){
    $file_src = '../../pics/vipcasa/'.$imgfile;

    
    if (unlink($file_src)) {
        $rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
        ?>
    <script type="text/javascript">

        $(function(){
          listaslika_lokacije(<?php echo $id; ?>);  
            });
    </script>
    <?php
    }else{
        echo "Error Deleting. Try Again Later.";
        //echo $file_src;
        //echo $file_src_thumb;
    }
    }
}

/* Brisanje slike MAPE lokacije */
if($akcija=='brisanje_slike_lokacije_mapa'){
    $id = $_REQUEST['id']; 
    $imgfile = $_REQUEST['imgfile']; 
    $sqlQueryDeletePhotosGallery = "UPDATE lokacija SET img2='' WHERE id='$id' ";    
    //$rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
    //if(mysql_num_rows($rezQueryDeletePhotosGallery)>0){
    if(1==1){
    $file_src = '../../pics/vipcasa/'.$imgfile;

    
    if (unlink($file_src)) {
        $rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
        ?>
    <script type="text/javascript">

        $(function(){
          listaslika_lokacije_mapa(<?php echo $id; ?>);  
            });
    </script>
    <?php
    }else{
        echo "Error Deleting. Try Again Later.";
        //echo $file_src;
        //echo $file_src_thumb;
    }
    }
}

/* Brisanje slike lokacije slider*/
if($akcija=='brisanje_slike_lokacije_slider'){
    $id = $_REQUEST['id']; 
    $imgfile = $_REQUEST['imgfile']; 
    $sqlQueryDeletePhotosGallery = "DELETE FROM lokacija_slider WHERE id='$id' ";    
    //$rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
    //if(mysql_num_rows($rezQueryDeletePhotosGallery)>0){
    if(1==1){
    $file_src = '../../pics/vipcasa/'.$imgfile;

    
    if (unlink($file_src)) {
        $rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
        ?>
    <script type="text/javascript">

        $(function(){
          listaslika_lokacije_slider(<?php echo $id; ?>);  
            });
    </script>
    <?php
    }else{
        echo "Error Deleting. Try Again Later.";
        //echo $file_src;
        //echo $file_src_thumb;
    }
    }
}

/* Brisanje slike vrste */
if($akcija=='brisanje_slike_vrste'){
    $id = $_REQUEST['id']; 
    $imgfile = $_REQUEST['imgfile']; 
    $sqlQueryDeletePhotosGallery = "UPDATE vrsta SET img='' WHERE id='$id' ";    
    //$rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
    //if(mysql_num_rows($rezQueryDeletePhotosGallery)>0){
    if(1==1){
    $file_src = '../../pics/vipcasa/'.$imgfile;

    
    if (unlink($file_src)) {
        $rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
        ?>
    <script type="text/javascript">

        $(function(){
          listaslika_vrste(<?php echo $id; ?>);  
            });
    </script>
    <?php
    }else{
        echo "Error Deleting. Try Again Later.";
        //echo $file_src;
        //echo $file_src_thumb;
    }
    }
}

/* Brisanje slike stana 3d render */
if($akcija=='brisanje_slike_stana_3d'){
    $id = $_REQUEST['id']; 
    $imgfile = $_REQUEST['imgfile']; 
    $sqlQueryDeletePhotosGallery = "UPDATE stan SET img2='' WHERE id='$id' ";    
    //$rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
    //if(mysql_num_rows($rezQueryDeletePhotosGallery)>0){
    if(1==1){
    $file_src = '../../pics/vipcasa/'.$imgfile;

    
    if (unlink($file_src)) {
        $rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
        ?>
    <script type="text/javascript">

        $(function(){
          listaslika_stana_3d(<?php echo $id; ?>);  
            });
    </script>
    <?php
    }else{
        echo "Error Deleting. Try Again Later.";
        //echo $file_src;
        //echo $file_src_thumb;
    }
    }
}
/* Brisanje slike stana polozaj */
if($akcija=='brisanje_slike_stana_polozaj'){
    $id = $_REQUEST['id']; 
    $imgfile = $_REQUEST['imgfile']; 
    $sqlQueryDeletePhotosGallery = "UPDATE stan SET img3='' WHERE id='$id' ";    
    //$rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
    //if(mysql_num_rows($rezQueryDeletePhotosGallery)>0){
    if(1==1){
    $file_src = '../../pics/vipcasa/'.$imgfile;

    
    if (unlink($file_src)) {
        $rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
        ?>
    <script type="text/javascript">

        $(function(){
          listaslika_stana_polozaj(<?php echo $id; ?>);  
            });
    </script>
    <?php
    }else{
        echo "Error Deleting. Try Again Later.";
        //echo $file_src;
        //echo $file_src_thumb;
    }
    }
}
/* Brisanje slike stana osnove */
if($akcija=='brisanje_slike_stana_osnove'){
    $id = $_REQUEST['id']; 
    $imgfile = $_REQUEST['imgfile']; 
    $sqlQueryDeletePhotosGallery = "DATE stan SET img1='' WHERE id='$id' ";    
    //$rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
    //if(mysql_num_rows($rezQueryDeletePhotosGallery)>0){
    if(1==1){
    $file_src = '../../pics/vipcasa/'.$imgfile;

    
    if (unlink($file_src)) {
        $rezQueryDeletePhotosGallery = mysql_query($sqlQueryDeletePhotosGallery);
        ?>
    <script type="text/javascript">

        $(function(){
          listaslika_stana_osnove(<?php echo $id; ?>);  
            });
    </script>
    <?php
    }else{
        echo "Error Deleting. Try Again Later.";
        //echo $file_src;
        //echo $file_src_thumb;
    }
    }
}


/* Izlistaj slike lokacije */
if($akcija=='listaslika_lokacije'){
    $id = $_REQUEST['id'];
        ?>
    <script type="text/javascript">
    $(function(){
        $("#thumbs-gallery a[rel=example_group]").fancybox({
            'padding': 0,
            'transitionIn'    : 'elastic',
            'transitionOut'    : 'elastic',
            'easingIn'      : 'easeOutBack'
            });
    });
    </script>
    <?php
    $sqlQueryPhotosGallery = "SELECT id, img FROM lokacija WHERE id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) { //mysql_fetch_row — Get a result row as an enumerated array.
        if($img_image){
        echo '<div class="holder-image"><a rel="example_group" href="/pics/vipcasa/'.$img_image.'"><img width="160px" height="120px" src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></a>
        <input type="button" class="image-delete-button" onclick="brisanje_slike_lokacije('.$id.', \''.$img_image.'\');" name="button" value="X">
        </div>';
        }
    }
    }
}

/* Izlistaj slike MAPE lokacije */
if($akcija=='listaslika_lokacije_mapa'){
    $id = $_REQUEST['id'];
        ?>
    <script type="text/javascript">
    $(function(){
        $("#thumbs-gallery a[rel=example_group]").fancybox({
            'padding': 0,
            'transitionIn'    : 'elastic',
            'transitionOut'    : 'elastic',
            'easingIn'      : 'easeOutBack'
            });
    });
    </script>
    <?php
    $sqlQueryPhotosGallery = "SELECT id, img2 FROM lokacija WHERE id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) {//mysql_fetch_row — Get a result row as an enumerated array.
        if($img_image){
        echo '<div class="holder-image"><a rel="example_group" href="/pics/vipcasa/'.$img_image.'"><img width="160px" height="120px" src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></a>
        <input type="button" class="image-delete-button" onclick="brisanje_slike_lokacije_mapa('.$id.', \''.$img_image.'\');" name="button" value="X">
        </div>';
        }
    }
    }
}

/* Izlistaj slike lokacije slider */
if($akcija=='listaslika_lokacije_slider'){
    $id = $_REQUEST['id'];
        ?>
    <script type="text/javascript">
    $(function(){
        $("#thumbs-gallery a[rel=example_group]").fancybox({
            'padding': 0,
            'transitionIn'    : 'elastic',
            'transitionOut'    : 'elastic',
            'easingIn'      : 'easeOutBack'
            });
    });
    </script>
    <?php
    $sqlQueryPhotosGallery = "SELECT id, img FROM lokacija_slider WHERE lokacija_id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) {//mysql_fetch_row — Get a result row as an enumerated array.
        if($img_image){
        echo '<div class="holder-image"><a rel="example_group" href="/pics/vipcasa/'.$img_image.'"><img width="160px" height="120px" src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></a>
        <input type="button" class="image-delete-button" onclick="brisanje_slike_lokacije_slider('.$img_id.', \''.$img_image.'\');" name="button" value="X">
        </div>';
        }
    }
    }
}

/* Izlistaj slike vrste */
if($akcija=='listaslika_vrste'){
    $id = $_REQUEST['id'];
        ?>
    <script type="text/javascript">
    $(function(){
        $("#thumbs-gallery a[rel=example_group]").fancybox({
            'padding': 0,
            'transitionIn'    : 'elastic',
            'transitionOut'    : 'elastic',
            'easingIn'      : 'easeOutBack'
            });
    });
    </script>
    <?php
    $sqlQueryPhotosGallery = "SELECT id, img FROM vrsta WHERE id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) {//mysql_fetch_row — Get a result row as an enumerated array.
        if($img_image){
        echo '<div class="holder-image"><a rel="example_group" href="/pics/vipcasa/'.$img_image.'"><img width="160px" height="120px" src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></a>
        <input type="button" class="image-delete-button" onclick="brisanje_slike_vrste('.$id.', \''.$img_image.'\');" name="button" value="X">
        </div>';
        }
    }
    }
}

/* LISTANJE SLIKA STANA */

/* 1. IMG1 Izlistaj slike stana osnove */
if($akcija=='listaslika_stana_osnove'){
    $id = $_REQUEST['id'];
        ?>
    <script type="text/javascript">
    $(function(){
        $("#thumbs-gallery a[rel=example_group]").fancybox({
            'padding': 0,
            'transitionIn'    : 'elastic',
            'transitionOut'    : 'elastic',
            'easingIn'      : 'easeOutBack'
            });
    });
    </script>
    <?php
    $sqlQueryPhotosGallery = "SELECT id, img1 FROM stan WHERE id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) {//mysql_fetch_row — Get a result row as an enumerated array.
        if($img_image){
        echo '<div class="holder-image"><a rel="example_group" href="/pics/vipcasa/'.$img_image.'"><img width="160px" height="120px" src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></a>
        <input type="button" class="image-delete-button" onclick="brisanje_slike_stana_osnove('.$id.', \''.$img_image.'\');" name="button" value="X">
        </div>';
        }
    }
    }
}
/* 2. IMG2 Izlistaj slike stana osnove */
if($akcija=='listaslika_stana_3d'){
    $id = $_REQUEST['id'];
        ?>
    <script type="text/javascript">
    $(function(){
        $("#thumbs-gallery a[rel=example_group]").fancybox({
            'padding': 0,
            'transitionIn'    : 'elastic',
            'transitionOut'    : 'elastic',
            'easingIn'      : 'easeOutBack'
            });
    });
    </script>
    <?php
    $sqlQueryPhotosGallery = "SELECT id, img2 FROM stan WHERE id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) {//mysql_fetch_row — Get a result row as an enumerated array.
        if($img_image){
        echo '<div class="holder-image"><a rel="example_group" href="/pics/vipcasa/'.$img_image.'"><img width="160px" height="120px" src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></a>
        <input type="button" class="image-delete-button" onclick="brisanje_slike_stana_3d('.$id.', \''.$img_image.'\');" name="button" value="X">
        </div>';
        }
    }
    }
}
/* 3. IMG3 Izlistaj slike stana osnove */
if($akcija=='listaslika_stana_polozaj'){
    $id = $_REQUEST['id'];
        ?>
    <script type="text/javascript">
    $(function(){
        $("#thumbs-gallery a[rel=example_group]").fancybox({
            'padding': 0,
            'transitionIn'    : 'elastic',
            'transitionOut'    : 'elastic',
            'easingIn'      : 'easeOutBack'
            });
    });
    </script>
    <?php
    $sqlQueryPhotosGallery = "SELECT id, img3 FROM stan WHERE id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) {//mysql_fetch_row — Get a result row as an enumerated array.
        if($img_image){
        echo '<div class="holder-image"><a rel="example_group" href="/pics/vipcasa/'.$img_image.'"><img width="160px" height="120px" src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></a>
        <input type="button" class="image-delete-button" onclick="brisanje_slike_stana_polozaj('.$id.', \''.$img_image.'\');" name="button" value="X">
        </div>';
        }
    }
    }
}

/* Izmeni sliku VRSTE */
if($akcija=='izmeni_sliku_vrste'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, naziv, status FROM vrsta WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id, $naziv_vrste, $status_vrste)=@mysql_fetch_row($rezR);
        }
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena fotografije vrste:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
 ?>
<script type="text/javascript">

        $(function(){
        var btnUpload=$('#upload-thumb');
        var status=$('#status-thumb');
        new AjaxUpload(btnUpload, {
            action: 'ajax/upload_slika_vrste.php?id=<?php echo $id; ?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');

                listaslika_vrste(<?php echo $id; ?>);
                if(response){
                    //$('<li></li>').appendTo('#files').html(response);
                } else{
                    //$('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
        
        listaslika_vrste(<?php echo $id; ?>);
    
    });

    </script>
    <div id="mainbody" >
        <p>Dozvoljenjen format: JPG.</p>
        <p>Velicina: 700 px x 497 px .</p>
        <!-- Upload Button, use any id you wish-->
        <div id="upload-thumb" ><input class="btn-upload" type="button" value="Snimi sliku"></div><span id="status-thumb" ></span>
        <ul id="files" ></ul>
        <!--<ul id="files" ></ul>-->
        <div id="thumbs-gallery" class="container-image">
       
        </div>
        </div>
    <?php
    echo "</td>
    </tr></table>";  
}

/* Izmeni sliku STANA OSNOVE */
if($akcija=='izmeni_sliku_stana_osnove'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id FROM stan WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id)=@mysql_fetch_row($rezR);
        }
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena fotografije Osnove:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
 ?>
<script type="text/javascript">

        $(function(){
        var btnUpload=$('#upload-thumb');
        var status=$('#status-thumb');
        new AjaxUpload(btnUpload, {
            action: 'ajax/upload_slika_stana_osnove.php?id=<?php echo $id; ?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');

                listaslika_stana_osnove(<?php echo $id; ?>);
                if(response){
                    //$('<li></li>').appendTo('#files').html(response);
                } else{
                    //$('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
        
        listaslika_stana_osnove(<?php echo $id; ?>);
    
    });

    </script>
    <div id="mainbody" >
        <p>Dozvoljenjen format: JPG.</p>
        <p>Velicina: 700 px x 497 px .</p>
        <!-- Upload Button, use any id you wish-->
        <div id="upload-thumb" ><input class="btn-upload" type="button" value="Snimi sliku"></div><span id="status-thumb" ></span>
        <ul id="files" ></ul>
        <!--<ul id="files" ></ul>-->
        <div id="thumbs-gallery" class="container-image">
       
        </div>
        </div>
    <?php
    echo "</td>
    </tr></table>";  
}

/* Izmeni sliku STANA 3D RENDER */
if($akcija=='izmeni_sliku_stana_3d'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id FROM stan WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id)=@mysql_fetch_row($rezR);//mysql_fetch_row — Get a result row as an enumerated array.
        }
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena fotografije 3D Render:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
 ?>
<script type="text/javascript">

        $(function(){
        var btnUpload=$('#upload-thumb');
        var status=$('#status-thumb');
        new AjaxUpload(btnUpload, {
            action: 'ajax/upload_slika_stana_3d.php?id=<?php echo $id; ?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');

                listaslika_stana_3d(<?php echo $id; ?>);
                if(response){
                    //$('<li></li>').appendTo('#files').html(response);
                } else{
                    //$('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
        
        listaslika_stana_3d(<?php echo $id; ?>);
    
    });

    </script>
    <div id="mainbody" >
        <p>Dozvoljenjen format: JPG.</p>
        <p>Velicina: 700 px x 497 px .</p>
        <!-- Upload Button, use any id you wish-->
        <div id="upload-thumb" ><input class="btn-upload" type="button" value="Snimi sliku"></div><span id="status-thumb" ></span>
        <ul id="files" ></ul>
        <!--<ul id="files" ></ul>-->
        <div id="thumbs-gallery" class="container-image">
       
        </div>
        </div>
    <?php
    echo "</td>
    </tr></table>";  
}

/* Izmeni sliku STANA POLOZAJ */
if($akcija=='izmeni_sliku_stana_polozaj'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id FROM stan WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id)=@mysql_fetch_row($rezR);//mysql_fetch_row — Get a result row as an enumerated array.
        }
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena fotografije Polozaj:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
 ?>
<script type="text/javascript">

        $(function(){
        var btnUpload=$('#upload-thumb');
        var status=$('#status-thumb');
        new AjaxUpload(btnUpload, {
            action: 'ajax/upload_slika_stana_polozaj.php?id=<?php echo $id; ?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');

                listaslika_stana_polozaj(<?php echo $id; ?>);
                if(response){
                    //$('<li></li>').appendTo('#files').html(response);
                } else{
                    //$('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
        
        listaslika_stana_polozaj(<?php echo $id; ?>);
    
    });

    </script>
    <div id="mainbody" >
        <p>Dozvoljenjen format: JPG.</p>
        <p>Velicina: 700 px x 497 px .</p>
        <!-- Upload Button, use any id you wish-->
        <div id="upload-thumb" ><input class="btn-upload" type="button" value="Snimi sliku"></div><span id="status-thumb" ></span>
        <ul id="files" ></ul>
        <!--<ul id="files" ></ul>-->
        <div id="thumbs-gallery" class="container-image">
       
        </div>
        </div>
    <?php
    echo "</td>
    </tr></table>";  
}

/* Izmeni sliku LOKACIJE */
if($akcija=='izmeni_sliku_lokacije'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, naziv, status FROM lokacija WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id, $naziv_lokacije, $status_lokacije)=@mysql_fetch_row($rezR);//mysql_fetch_row — Get a result row as an enumerated array.
        }
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena fotografije:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
 ?>
<script type="text/javascript">

        $(function(){
        var btnUpload=$('#upload-thumb');
        var status=$('#status-thumb');
        new AjaxUpload(btnUpload, {
            action: 'ajax/upload_slika_lokacije.php?id=<?php echo $id; ?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');

                listaslika_lokacije(<?php echo $id; ?>);
                if(response){
                    //$('<li></li>').appendTo('#files').html(response);
                } else{
                    //$('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
        
        listaslika_lokacije(<?php echo $id; ?>);
    
    });

    </script>
    <div id="mainbody" >
        <p>Dozvoljenjen format: JPG.</p>
        <p>Velicina: 700 px x 497 px .</p>
        <!-- Upload Button, use any id you wish-->
        <div id="upload-thumb" ><input class="btn-upload" type="button" value="Snimi sliku"></div><span id="status-thumb" ></span>
        <ul id="files" ></ul>
        <!--<ul id="files" ></ul>-->
        <div id="thumbs-gallery" class="container-image">
       
        </div>
        </div>
    <?php
    echo "</td>
    </tr></table>";  
}
/* Izmeni sliku LOKACIJE MAPA */
if($akcija=='izmeni_sliku_lokacije_mapa'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, naziv, status FROM lokacija WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id, $naziv_lokacije, $status_lokacije)=@mysql_fetch_row($rezR);//mysql_fetch_row — Get a result row as an enumerated array.
        }
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena mape:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
 ?>
<script type="text/javascript">

        $(function(){
        var btnUpload=$('#upload-thumb');
        var status=$('#status-thumb');
        new AjaxUpload(btnUpload, {
            action: 'ajax/upload_slika_lokacije_mapa.php?id=<?php echo $id; ?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');

                listaslika_lokacije_mapa(<?php echo $id; ?>);
                if(response){
                    //$('<li></li>').appendTo('#files').html(response);
                } else{
                    //$('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
        
        listaslika_lokacije_mapa(<?php echo $id; ?>);
    
    });

    </script>
    <div id="mainbody" >
        <p>Dozvoljenjen format: JPG.</p>
        <p>Velicina: 700 px x 497 px .</p>
        <!-- Upload Button, use any id you wish-->
        <div id="upload-thumb" ><input class="btn-upload" type="button" value="Snimi sliku"></div><span id="status-thumb" ></span>
        <ul id="files" ></ul>
        <!--<ul id="files" ></ul>-->
        <div id="thumbs-gallery" class="container-image">
       
        </div>
        </div>
    <?php
    echo "</td>
    </tr></table>";  
}

/* Izmeni sliku LOKACIJE SLIDER */
if($akcija=='izmeni_sliku_lokacije_slider'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, naziv, status FROM lokacija WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id, $naziv_lokacije, $status_lokacije)=@mysql_fetch_row($rezR);//mysql_fetch_row — Get a result row as an enumerated array.
        }
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Izmena fotografija (SLIDER):</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">";
 ?>
<script type="text/javascript">

        $(function(){
        var btnUpload=$('#upload-thumb');
        var status=$('#status-thumb');
        new AjaxUpload(btnUpload, {
            action: 'ajax/upload_slika_lokacije_slider.php?id=<?php echo $id; ?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                status.text('Uploading...');
            },
            onComplete: function(file, response){
                //On completion clear the status
                status.text('');

                listaslika_lokacije_slider(<?php echo $id; ?>);
                if(response){
                    //$('<li></li>').appendTo('#files').html(response);
                } else{
                    //$('<li></li>').appendTo('#files').text(file).addClass('error');
                }
            }
        });
        
        listaslika_lokacije_slider(<?php echo $id; ?>);
    
    });

    </script>
    <div id="mainbody" >
        <p>Dozvoljenjen format: JPG.</p>
        <p>Velicina: 1867 px x 762 px .</p>
        <!-- Upload Button, use any id you wish-->
        <div id="upload-thumb" ><input class="btn-upload" type="button" value="Snimi sliku"></div><span id="status-thumb" ></span>
        <ul id="files" ></ul>
        <!--<ul id="files" ></ul>-->
        <div id="thumbs-gallery" class="container-image">
       
        </div>
        </div>
    <?php
    echo "</td>
    </tr></table>";  
}

if($akcija=='izmeni_lokaciju'){
  ?>
<script type="text/javascript" charset="utf-8">
        $().ready(function() {
           var opts = {
                    absoluteURLs: false,
                    cssClass : 'el-rte',
                    lang     : 'en',
                    allowSource : 1,  // allow user to view source
                    height   : 200,   // height of text area
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
            $('#podovi').elrte(opts);
            $('#zidovi').elrte(opts);
            $('#plafon').elrte(opts);
            $('#prozori_vrata').elrte(opts);
            $('#bravarija').elrte(opts);
            $('#krov').elrte(opts);
            $('#konstrukcija').elrte(opts);
            $('#instalacija').elrte(opts);
            

          });
            </script>
  <?php
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, naziv, mesto, adresa, status, sold, broj_spratova, podovi, zidovi, plafon, prozori_vrata, bravarija, krov, konstrukcija, instalacija, lat, lon FROM lokacija WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id, $naziv, $mesto, $adresa, $status, $sold, $broj_spratova, $podovi, $zidovi, $plafon, $prozori_vrata, $bravarija, $krov, $konstrukcija, $instalacija, $lat, $lon)=@mysql_fetch_row($rezR);//mysql_fetch_row — Get a result row as an enumerated array.
        }
 echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Edit lokacije:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"naziv\" id=\"naziv\" value=\"$naziv\" /></td>
    </tr>";  
    echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Mesto:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"mesto\" id=\"mesto\" value=\"$mesto\" /></td>
    </tr>";
    echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Adresa:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"adresa\" id=\"adresa\" value=\"$adresa\" /></td>
    </tr>"; 
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Status:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"status\">";
                     
       echo "<option value=\"1\" $chk>aktivan</option>";  
       echo "<option value=\"0\" $chk>neaktivan</option>";
    echo "</select></td></tr>";

    echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Prodat:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"sold\">";
        if($sold==1){
            $soldDa = 'selected';
            $soldNe = '';
        }else{
            $soldDa ='';
            //$soldNe='';
        }
        if($sold==0){
            $soldDa  = '';
            $soldNe = 'selected';
        }else{
            //$soldDa ='';
            $soldNe='';
        }
        
       echo "<option value=\"1\" $soldDa>da</option>";  
       echo "<option value=\"0\" $soldNe>ne</option>";
    echo "</select></td></tr>";


  

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Broj spratova:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"broj_spratova\" id=\"broj_spratova\" value=\"$broj_spratova\" /></td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Podovi:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"podovi\" id=\"podovi\" value=\"$podovi\">$podovi</textarea></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Zidovi:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"zidovi\" id=\"zidovi\" value=\"$zidovi\" >$zidovi</textarea></td>
    </tr>";  
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Plafon:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"plafon\" id=\"plafon\" value=\"$plafon\" >$plafon</textarea></td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Prozori - vrata:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"prozori_vrata\" id=\"prozori_vrata\" value=\"$prozori_vrata\" >$prozori_vrata</textarea></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Bravarija:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"bravarija\" id=\"bravarija\" value=\"$bravarija\" >$bravarija</textarea></td>
    </tr>";     
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Krov:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"krov\" id=\"krov\" value=\"$krov\" >$krov</textarea></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Konstrukcija:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"konstrukcija\" id=\"konstrukcija\" value=\"$konstrukcija\" >$konstrukcija</textarea></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Instalacija:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"instalacija\" id=\"instalacija\" value=\"$instalacija\" >$instalacija</textarea></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Latituda:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"lat\" id=\"lat\" value=\"$lat\" /></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Longituda:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"lon\" id=\"lon\" value=\"$lon\" /></td>
    </tr>"; 
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var naziv = \$('#naziv').val();var mesto = \$('#mesto').val();var adresa = \$('#adresa').val();var status = \$('#status').val(); var sold = \$('#sold').val();var broj_spratova = \$('#broj_spratova').val();var podovi = \$('#podovi').elrte('val');var zidovi = \$('#zidovi').elrte('val');var plafon = \$('#plafon').elrte('val');var prozori_vrata = \$('#prozori_vrata').elrte('val');var bravarija = \$('#bravarija').elrte('val'); var krov = \$('#krov').elrte('val');var konstrukcija = \$('#konstrukcija').elrte('val');var instalacija = \$('#instalacija').elrte('val');var lat = \$('#lat').val();var lon = \$('#lon').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'izmeni_lokaciju_sql',  LID:'".$LID."', naziv: naziv, status: status, sold: sold, mesto: mesto, adresa: adresa, broj_spratova: broj_spratova, podovi: podovi, zidovi: zidovi, plafon: plafon, prozori_vrata: prozori_vrata, bravarija: bravarija, krov: krov, konstrukcija: konstrukcija, instalacija: instalacija, lat: lat, lon: lon, id: '".$id."'}).fadeIn('slow');\" class=\"btn\" value=\"Edit\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

if($akcija=='izmeni_stan'){
  ?>
<script type="text/javascript" charset="utf-8">
        $().ready(function() {
           var opts = {
                    absoluteURLs: false,
                    cssClass : 'el-rte',
                    lang     : 'en',
                    allowSource : 1,  // allow user to view source
                    height   : 200,   // height of text area
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
            $('#opis').elrte(opts);
            

          });
            </script>
  <?php
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, sprat, opis, status, prodat, vrsta_id, tip_id, lokacija_id FROM stan WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id, $sprat, $opis, $status, $prodat, $vrsta_id, $tip_id, $lokacija_id)=@mysql_fetch_row($rezR);
        }
 echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Edit stana:</strong></td>
  </tr>";
 echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Status:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"status\">";
                     
       echo "<option value=\"1\" $chk>aktivan</option>";  
       echo "<option value=\"0\" $chk>neaktivan</option>";
    echo "</select></td></tr>";

     echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Prodat:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"prodat\">";
        if($prodat==1){
            $prodatDa = 'selected';
            $prodatNe = '';
        }else{
            $prodatDa='';
            $prodatNe='';
        }
        if($prodat==0){
            $prodatDa = '';
            $prodatNe = 'selected';
        }else{
            $prodatDa='';
            $prodatNe='';
        }
        
       echo "<option value=\"1\" $prodatDa>da</option>";  
       echo "<option value=\"0\" $prodatNe>ne</option>";
    echo "</select></td></tr>";

    echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Sprat:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"sprat\" id=\"sprat\" value=\"$sprat\" /></td>
    </tr>";  
    echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Opis:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"opis\" id=\"opis\">$opis</textarea></td>
    </tr>";  
   echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Vrsta:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"vrsta_id\">";
                     
                    $sqlRanjivost = "SELECT id, naziv FROM vrsta ORDER BY id ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_vrste, $naziv_vrste)=@mysql_fetch_row($rezRanjivost)) {
      if ($vrsta_id == $id_vrste) {
        $selected = 'selected';
      }else {
        $selected = '';
      }
       echo "<option value=\"$id_vrste\"  $selected>$naziv_vrste</option>";
    
    }
    }
    echo "</select></td></tr>";

   
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Tip:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"tip_id\">";
                     
                    $sqlRanjivost = "SELECT id, naziv FROM tip ORDER BY id ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_tipa, $naziv_tipa)=@mysql_fetch_row($rezRanjivost)) {
      if ($tip_id == $id_tipa) {
        $selected = 'selected';
      } else {
        $selected='';
      }
       echo "<option value=\"$id_tipa\" $selected>$naziv_tipa</option>";
      }
    }
    
    echo "</select></td></tr>";

 
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Lokacija:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"lokacija_id\">";
                     
                    $sqlRanjivost = "SELECT id, naziv FROM lokacija ORDER BY id ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_lokacije, $naziv_lokacije, $mesto_lokacije, $adresa_lokacije)=@mysql_fetch_row($rezRanjivost)) {
      if ($lokacija_id == $id_lokacije) {
        $selected = 'selected';
      } else {
        $selected='';
      }
      echo "<option value=\"$id_lokacije\" $selected>$naziv_lokacije</option>";
      



    }
    }
    echo "</select></td></tr>";



  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var sprat = \$('#sprat').val(); var opis = \$('#opis').elrte('val'); var status = \$('#status').val(); var prodat = \$('#prodat').val(); var vrsta_id = \$('#vrsta_id').val();var tip_id = \$('#tip_id').val();var lokacija_id = \$('#lokacija_id').val();  prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'izmeni_stan_sql',  LID:'".$LID."', sprat: sprat, opis: opis, status: status, prodat: prodat,
   vrsta_id: vrsta_id, tip_id: tip_id, lokacija_id: lokacija_id, id: '".$id."'}).fadeIn('slow');\" class=\"btn\" value=\"Edit\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

if($akcija=='izaberite_grupu'){
    $sqlNadgrupa = "SELECT id_grupe, naziv, aktivan FROM t_grupe_korisnika WHERE id_grupe<>1 ORDER BY id_grupe ";
    $rezNadgrupa = mysql_query($sqlNadgrupa);
    if(mysql_num_rows($rezNadgrupa)>0){
    echo "<h2>Izaberite grupu korisnika</h2>";
    echo "<select id=\"id_grupe\" name=\"id_grupe\" onChange=\"var izabrana_grupa=this.value; prikaziLoad_mali('divLista'); \$('#divLista').hide().load('ajax/utils.php',{akcija: 'lista_grupa_privilegija', LID:'$LID', izabrana_grupa:izabrana_grupa}).fadeIn('fast');\">";
    echo "<option value=\"-\">Izaberite</option>";
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rezNadgrupa)) {
        
        echo "<option value=\"$id_grupe\">".$naziv_grupe."</option>";
    
    }
    }
    echo "</select> ";
}


if($akcija=='lista_korisnika'){
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
    $sql = "SELECT k.id_korisnika, k.korisnik, k.ime_prezime, k.email, g.naziv FROM t_korisnici k, t_grupe_korisnika g WHERE k.id_grupe=g.id_grupe";
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
    echo "<th>Full name</th>";
    echo "<th>username</th>";
    echo "<th>email</th>";
    echo "<th>group</th>";
    echo "<th>options</th>";
    
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id_korisnika, $username_korisnika, $imePrezime, $email_korisnika, $grupa)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id_korisnika</td>";
            echo "<td>$imePrezime</td>";
            echo "<td align=\"left\">$username_korisnika</td>";
            echo "<td align=\"left\">$email_korisnika</td>";
            echo "<td align=\"left\">$grupa</td>";
    
    echo "<td align='right'>";
    if($A_NIVO==1 || $A_NIVO==2){
   echo "<div id=\"brisanje$id_procene\" name=\"brisanje$id_procene\">
    <a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_korisnika',  LID:'".$LID."', korisnik_id: '".$id_korisnika."'}).fadeIn('slow');\"><img src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'obrisi_korisnika',  LID:'".$LID."', korisnik_id: '".$id_korisnika."'}).fadeIn('slow');}\" ><img  src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
    }
    
    echo "</div>";
    }
    echo "</td>";
    
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>ID</th>";
    echo "<th>Full name</th>";
    echo "<th>username</th>";
    echo "<th>email</th>";
    echo "<th>group</th>";
    echo "<th>options</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
    /*
    if($A_NIVO==1 || $A_NIVO==2){
echo "<a href=\"\" onClick=\"pom = proveri(); if(pom){var items = []; $('input[name=chkboxIzabrano]:checked').each(function(){ items.push($(this).val()); }); var result = items.join(','); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/procena.php',{akcija: 'obrisi_procenu_resursa_sel',  LID:'".$LID."', izbor_g: result}).fadeIn('slow');}\" ><img src=\"../images/kanta_velika.png\" border=0 title=\"Obriši obeležene\"></a>";
    }
    */
}


if($akcija=='lista_vrsta'){
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
    $sql = "SELECT v.id, v.naziv, v.status FROM vrsta v ORDER BY v.id ASC";
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
    echo "<th>Naziv</th>";
    echo "<th>Status`</th>";
    echo "<th>options</th>";
    
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id_vrste, $naziv_vrste, $status_vrste)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id_vrste</td>";
            echo "<td>$naziv_vrste</td>";
            echo "<td align=\"left\">$status_vrste</td>";    
    echo "<td align='right'>";
   echo "<div id=\"brisanje$id_procene\" name=\"brisanje$id_procene\">";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_sliku_vrste',  LID:'".$LID."', id: '".$id_vrste."'}).fadeIn('slow');\"><img style=\"width:23px;height:22px;\" src=\"./images/izmeni_sliku.png\" border=0 title=\"Edit\"></a>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_vrstu',  LID:'".$LID."', id: '".$id_vrste."'}).fadeIn('slow');\"><img src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'obrisi_vrstu',  LID:'".$LID."', id: '".$id_vrste."'}).fadeIn('slow');}\" ><img  src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
    }
    
    echo "</div>";
    
    echo "</td>";
    
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>ID</th>";
    echo "<th>Naziv</th>";
    echo "<th>Status`</th>";
    echo "<th>options</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
    /*
    if($A_NIVO==1 || $A_NIVO==2){
echo "<a href=\"\" onClick=\"pom = proveri(); if(pom){var items = []; $('input[name=chkboxIzabrano]:checked').each(function(){ items.push($(this).val()); }); var result = items.join(','); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/procena.php',{akcija: 'obrisi_procenu_resursa_sel',  LID:'".$LID."', izbor_g: result}).fadeIn('slow');}\" ><img src=\"../images/kanta_velika.png\" border=0 title=\"Obriši obeležene\"></a>";
    }
    */
}


if($akcija=='nov_korisnik'){
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>New user:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Group:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"id_grupe\">";
                     
                    $sqlRanjivost = "SELECT id_grupe, naziv, aktivan FROM t_grupe_korisnika ORDER BY id_grupe ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_grupe, $naziv_grupe, $aktivnost_grupe)=@mysql_fetch_row($rezRanjivost)) {
       echo "<option value=\"$id_grupe\">$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Full name:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"korisnik_imePrezime\" id=\"korisnik_imePrezime\" /></td>
    </tr>";  
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>username</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"username\" id=\"username\" /></td>
    </tr>";      
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>password</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"password\" size=\"50\" name=\"lozinka\" id=\"lozinka\" /></td>
    </tr>";
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>email</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"email\" id=\"email\" /></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var email = \$('#email').val(); var lozinka = \$('#lozinka').val(); var username = \$('#username').val(); var korisnik_imePrezime = \$('#korisnik_imePrezime').val(); var id_grupe = \$('#id_grupe').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'ubaci_korisnika',  LID:'".$LID."', id_grupe: id_grupe, korisnik_imePrezime: korisnik_imePrezime, username: username, lozinka: lozinka, email: email}).fadeIn('slow');\" class=\"btn\" value=\"Insert\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

if($akcija=='nova_vrsta'){
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Nova vrsta:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Status:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"status\">";
       echo "<option value=\"1\">aktivan</option>";
       echo "<option value=\"0\">neaktivan</option>";
    echo "</select></td></tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"naziv_vrste\" id=\"naziv_vrste\" /></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var status = \$('#status').val(); var naziv_vrste = \$('#naziv_vrste').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'ubaci_vrstu',  LID:'".$LID."', status: status, naziv_vrste: naziv_vrste}).fadeIn('slow');\" class=\"btn\" value=\"Insert\" >

  <input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}



if($akcija=='novi_tip'){
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Novi tip:</strong></td>
  </tr>";
 

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"naziv_tipa\" id=\"naziv_tipa\" /></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var naziv_tipa = \$('#naziv_tipa').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'ubaci_tip',  LID:'".$LID."',naziv_tipa: naziv_tipa}).fadeIn('slow');\" class=\"btn\" value=\"Insert\" >

  <input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

if($akcija=='izmeni_tip'){
    $id = $_REQUEST['id'];
    $sqlR = "SELECT id, naziv FROM tip WHERE id='$id' ";
    $rezR = mysql_query($sqlR);
    if(mysql_num_rows($rezR)>0){
    list($id, $naziv_tipa)=@mysql_fetch_row($rezR);
        }
 echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Edit tip:</strong></td>
  </tr>";


echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"naziv_tipa\" id=\"naziv_tipa\" value=\"$naziv_tipa\" /></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" onClick=\"var naziv = \$('#naziv_tipa').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'izmeni_tip_sql',  LID:'".$LID."', naziv: naziv, id: '".$id."'}).fadeIn('slow');\" class=\"btn\" value=\"Edit\" ><input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

if($akcija=='lista_tipova'){
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
    $sql = "SELECT t.id, t.naziv FROM tip t ORDER BY t.id ASC";
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
    echo "<th>Naziv</th>";
    echo "<th>options</th>";
    
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id, $naziv_tipa)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id</td>";
            echo "<td>$naziv_tipa</td>";
                
    echo "<td align='right'>";
    if($A_NIVO==1 || $A_NIVO==2){
   echo "<div id=\"brisanje$id_procene\" name=\"brisanje$id_procene\">
    <a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_tip',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\"><img src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'obrisi_tip',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');}\" ><img  src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
    }
    
    echo "</div>";
    }
    echo "</td>";
    
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>ID</th>";
    echo "<th>Naziv</th>";
    echo "<th>options</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}

if($akcija=='lista_lokacija'){
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
    $sql = "SELECT l.id, l.naziv, l.mesto, l.adresa, l.status FROM lokacija l ORDER BY l.id ASC";
    $rez = mysql_query($sql);
    echo "<br />";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>ID</th>";
    echo "<th>Naziv</th>";
    echo "<th>Mesto</th>";
    echo "<th>Adresa</th>";
    echo "<th>Status</th>";
    echo "<th>Prodat</th>";
    echo "<th>Broj spratova</th>";
    
    echo "<th>options</th>";
    
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id, $naziv, $mesto, $adresa, $status, $sold, $broj_spratova)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id</td>";
            echo "<td>$naziv</td>";
            echo "<td>$mesto</td>";
            echo "<td>$adresa</td>";
            echo "<td>$status</td>";
            echo "<td>$sold</td>";
            echo "<td>$broj_spratova</td>";
            
                
    echo "<td align='right'>";
    echo "<div id=\"brisanje$id_procene\" name=\"brisanje$id_procene\">";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_sliku_lokacije_slider',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\"><img style=\"width:23px;height:22px;\" src=\"./images/izmeni_sliku_slider.png\" border=0 title=\"Lokacija Slider\"></a>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_sliku_lokacije',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\"><img style=\"width:23px;height:22px;\" src=\"./images/izmeni_sliku.png\" border=0 title=\"Slika lokacije\"></a>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_sliku_lokacije_mapa',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\"><img style=\"width:23px;height:22px;\" src=\"./images/izmeni_sliku_mapa.png\" border=0 title=\"Mapa lokacije\"></a>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
   
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_lokaciju',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\"><img src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'obrisi_lokaciju',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');}\" ><img  src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
    }
    
    echo "</div>";
    
    echo "</td>";
    
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>ID</th>";
    echo "<th>Naziv</th>";
    echo "<th>Mesto</th>";
    echo "<th>Adresa</th>";
    echo "<th>Status</th>";
    echo "<th>Prodat</th>";
    echo "<th>Broj spratova</th>";
    echo "<th>options</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}

if($akcija=='nova_lokacija'){
  ?>
<script type="text/javascript" charset="utf-8">
        $().ready(function() {
           var opts = {
                    absoluteURLs: false,
                    cssClass : 'el-rte',
                    lang     : 'en',
                    allowSource : 1,  // allow user to view source
                    height   : 200,   // height of text area
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
            $('#podovi').elrte(opts);
            $('#zidovi').elrte(opts);
            $('#plafon').elrte(opts);
            $('#prozori_vrata').elrte(opts);
            $('#bravarija').elrte(opts);
            $('#krov').elrte(opts);
            $('#konstrukcija').elrte(opts);
            $('#instalacija').elrte(opts);

          });
            </script>
  <?php
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Nova lokacija:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Naziv:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"naziv\" id=\"naziv\" /></td>
    </tr>";  
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Mesto:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"mesto\" id=\"mesto\" /></td>
    </tr>"; 
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Adresa:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"adresa\" id=\"adresa\" /></td>
    </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Status:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"status\">";
       echo "<option value=\"1\">aktivan</option>";
       echo "<option value=\"0\">neaktivan</option>";
    echo "</select></td></tr>";

 echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Prodat:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"sold\">";
        if($sold==1){
            $soldDa = 'selected';
            $soldNe = '';
        }else{
            $soldDa ='';
            $soldNe='';
        }
        if($sold==0){
            $soldDa  = '';
            $soldNe = 'selected';
        }else{
            $soldDa ='';
            $soldNe='';
        }
        
       echo "<option value=\"1\" $soldDa>da</option>";  
       echo "<option value=\"0\" $soldNe>ne</option>";
    echo "</select></td></tr>";

  
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Broj spratova:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"broj_spratova\" id=\"broj_spratova\" /></td>
    </tr>"; 

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Podovi:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"podovi\" id=\"podovi\" /></textarea> </td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Zidovi:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"zidovi\" id=\"zidovi\" /></textarea></td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Plafon:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"plafon\" id=\"plafon\" /></textarea></td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Prozori-vrata:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"prozori_vrata\" id=\"prozori_vrata\" /></textarea></td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Bravarija:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"bravarija\" id=\"bravarija\" /></textarea></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Krov:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"krov\" id=\"krov\" /></textarea></td>
    </tr>";
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Konstrukcija:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"konstrukcija\" id=\"konstrukcija\" /></textarea></td>
    </tr>";  
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Instalacija:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"instalacija\" id=\"instalacija\" /></textarea></td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Latituda:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"lat\" id=\"lat\" /></td>
    </tr>"; 
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Longituda:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"lon\" id=\"lon\" /></td>
    </tr>";


echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" 
onClick=\"var naziv = \$('#naziv').val();var mesto = \$('#mesto').val();var adresa = \$('#adresa').val();var status = \$('#status').val(); var sold = \$('#sold').val();var broj_spratova = \$('#broj_spratova').val();var podovi = \$('#podovi').elrte('val'); var zidovi = \$('#zidovi').elrte('val');var plafon = \$('#plafon').elrte('val'); var prozori_vrata = \$('#prozori_vrata').elrte('val');var bravarija = \$('#bravarija').elrte('val'); var krov = \$('#krov').elrte('val');var konstrukcija = \$('#konstrukcija').elrte('val');var instalacija = \$('#instalacija').elrte('val');var lat = \$('#lat').val();var lon = \$('#lon').val();prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'ubaci_lokaciju',  LID:'".$LID."', naziv: naziv, mesto: mesto, adresa: adresa, status: status, sold: sold, broj_spratova: broj_spratova, podovi: podovi, zidovi: zidovi, plafon: plafon, prozori_vrata: prozori_vrata, bravarija: bravarija, krov: krov, konstrukcija: konstrukcija, instalacija: instalacija, lat: lat, lon: lon}).fadeIn('slow');\" class=\"btn\" value=\"Insert\" >

  <input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";
}

if($akcija=='lista_stanova'){
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
    $sql = "SELECT s.id, s.sprat, s.opis, s.status, v.naziv AS naziv_vrste, t.naziv AS naziv_tipa, l.naziv AS naziv_lokacije FROM stan s, vrsta v, tip t, lokacija l WHERE s.vrsta_id=v.id AND s.tip_id=t.id AND s.lokacija_id=l.id ORDER BY s.id ASC;";
    $rez = mysql_query($sql);
    echo "<br />";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>ID</th>";
    echo "<th>Sprat</th>";
    echo "<th>Opis</th>";
    echo "<th>Status</th>";
    echo "<th>naziv_vrste</th>";
    echo "<th>naziv_tipa</th>";
    echo "<th>naziv_lokacije</th>";
    
    echo "<th>options</th>";
    
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
            while (list($id, $sprat, $opis, $status, $vrsta_id, $tip_id, $lokacija_id)=@mysql_fetch_row($rez)) {
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$id</td>";
            echo "<td>$sprat</td>";
            echo "<td>$opis</td>";
            echo "<td>$status</td>";
            echo "<th>$vrsta_id</th>";
            echo "<th>$tip_id</th>";
            echo "<th>$lokacija_id</th>";
            
                
    echo "<td align='right'>";
    echo "<div id=\"brisanje$id_procene\" name=\"brisanje$id_procene\">";
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_sliku_stana_osnove',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\">OSNOVA</a><br>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_sliku_stana_3d',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\">3D_RENDER</a><br>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_sliku_stana_polozaj',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\">POLOŽAJ</a><br>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
   echo "<div id=\"brisanje$id_procene\" name=\"brisanje$id_procene\">
    <a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'izmeni_stan',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');\"><img src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
    }
    if($A_NIVO==1 || $A_NIVO==2){
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'obrisi_stan',  LID:'".$LID."', id: '".$id."'}).fadeIn('slow');}\" ><img  src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
    }
    
    echo "</div>";
    
    echo "</td>";
    
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>ID</th>";
    echo "<th>Sprat</th>";
    echo "<th>Opis</th>";
    echo "<th>Status</th>";
    echo "<th>naziv_vrste</th>";
    echo "<th>naziv_tipa</th>";
    echo "<th>naziv_lokacije</th>";
    echo "<th>options</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}

if($akcija=='novi_stan'){
  ?>
<script type="text/javascript" charset="utf-8">
        $().ready(function() {
           var opts = {
                    absoluteURLs: false,
                    cssClass : 'el-rte',
                    lang     : 'en',
                    allowSource : 1,  // allow user to view source
                    height   : 200,   // height of text area
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
            $('#opis').elrte(opts);
           

          });
            </script>
  <?php
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Novi stan:</strong></td>
  </tr>";
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Vrsta:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"vrsta_id\">";
                     
                    $sqlRanjivost = "SELECT id, naziv FROM vrsta ORDER BY id ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_vrste, $naziv_vrste)=@mysql_fetch_row($rezRanjivost)) {
       echo "<option value=\"$id_vrste\">$naziv_vrste</option>";
    }
    }
    echo "</select></td></tr>";

   
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Tip:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"tip_id\">";
                     
                    $sqlRanjivost = "SELECT id, naziv FROM tip ORDER BY id ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_tipa, $naziv_tipa)=@mysql_fetch_row($rezRanjivost)) {
       echo "<option value=\"$id_tipa\">$naziv_tipa</option>";
    }
    }
    echo "</select></td></tr>";

 
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Lokacija:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "<select class=\"izaberi\" id=\"lokacija_id\">";
                     
                    $sqlRanjivost = "SELECT id, naziv FROM lokacija ORDER BY id ";
    $rezRanjivost = mysql_query($sqlRanjivost);
    if(mysql_num_rows($rezRanjivost)>0){
    while (list($id_lokacije, $naziv_lokacije, $mesto_lokacije, $adresa_lokacije)=@mysql_fetch_row($rezRanjivost)) {
      echo "<option value=\"$id_lokacije\">$naziv_lokacije</option>";
      



    }
    }
    echo "</select></td></tr>";

echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Sprat:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"sprat\" id=\"sprat\" /></td>
    </tr>";
    echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Opis:</strong></td>
    <td class=\"TD_EvenNew\"><textarea rows=\"4\" cols=\"49\" name=\"opis\" id=\"opis\" ></textarea></td>
    </tr>";  

    echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Status:</strong></td>
    <td class=\"TD_EvenNew\">"; 

echo "<select class=\"izaberi\" id=\"status\">";
       echo "<option value=\"1\">aktivan</option>";
       echo "<option value=\"0\">neaktivan</option>";
    echo "</select></td></tr>";

     echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Prodat:</strong></td>
    <td class=\"TD_EvenNew\">"; 

echo "<select class=\"izaberi\" id=\"prodat\">";
       echo "<option value=\"1\">da</option>";
       echo "<option value=\"0\">ne</option>";
    echo "</select></td></tr>";


  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><input type=\"submit\" 
onClick=\"var sprat = \$('#sprat').val(); var opis = \$('#opis').elrte('val'); var status = \$('#status').val(); var prodat = \$('#prodat').val();var vrsta_id = \$('#vrsta_id').val();var tip_id = \$('#tip_id').val();var lokacija_id = \$('#lokacija_id').val();prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'ubaci_stan',  LID:'".$LID."', sprat: sprat, opis: opis, status: status, prodat: prodat, vrsta_id: vrsta_id, tip_id: tip_id, lokacija_id: lokacija_id}).fadeIn('slow');\" class=\"btn\" value=\"Insert\" >

  <input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ></td></tr></table>";

}
?>
