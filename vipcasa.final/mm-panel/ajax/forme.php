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

if($akcija=='update_member_sql'){
    $forma_id = $_REQUEST['forma_id'];
    $form_membercode = $_REQUEST['form_membercode'];
    $form_imeprezime = $_REQUEST['form_imeprezime'];
    $form_brojlicnekarte = $_REQUEST['form_brojlicnekarte'];
    $form_email = $_REQUEST['form_email'];
    $form_telefon = $_REQUEST['form_telefon'];
    $form_opis = $_REQUEST['form_opis'];
    
    $datum_popunjavanja_mysql = date('Y-m-d H:i:s');
    
    $sql_proccess = "UPDATE members SET form_imeprezime='$form_imeprezime', form_brojlicnekarte='$form_brojlicnekarte', form_telefon='$form_telefon', form_email='$form_email', sifra='$form_membercode', form_opis='$form_opis' WHERE id='$forma_id' ";
    $rez_proccess = mysql_query($sql_proccess);
     if (!$rez_proccess) {
                    die('Error. Please try later.');
        }
$akcija='lista_clanova';     
}

if($akcija=='insert_member_sql'){
    
    $id_services = $_REQUEST['id_services'];
    $datum_pocetak = $_REQUEST['datepicker'];
    $datum_pocetak=strtotime($datum_pocetak);
    $datum_mysql_pocetak = date('Y-m-d',$datum_pocetak);
    $datum_kraj = $_REQUEST['datepicker2'];
    $datum_kraj=strtotime($datum_kraj);
    $datum_mysql_kraj = date('Y-m-d',$datum_kraj);
    
    $form_membercode = $_REQUEST['form_membercode'];
    $form_imeprezime = $_REQUEST['form_imeprezime'];
    $form_brojlicnekarte = $_REQUEST['form_brojlicnekarte'];
    $form_email = $_REQUEST['form_email'];
    $form_telefon = $_REQUEST['form_telefon'];
    $form_opis = $_REQUEST['form_opis'];
    
    $datum_popunjavanja_mysql = date('Y-m-d H:i:s');
    
    $sql_proccess = "INSERT INTO members (datum_prijave, form_imeprezime, form_brojlicnekarte, form_telefon, form_email, sifra, form_opis) VALUES ( '$datum_popunjavanja_mysql', '$form_imeprezime', '$form_brojlicnekarte', '$form_telefon', '$form_email', '$form_membercode', '$form_opis')";
    $rez_proccess = mysql_query($sql_proccess);
     if (!$rez_proccess) {
                    die('Error. Please try later.');
        }
     //kalendar upis
     $id_novog_clana = mysql_insert_id($db);
     $sql_proccess = "INSERT INTO calendar (id_c, id_s, od, do) VALUES ( '$id_novog_clana', '$id_services', '$datum_mysql_pocetak', '$datum_mysql_kraj')";
    $rez_proccess = mysql_query($sql_proccess);
     //kalendar upis kraj   
        
        
$akcija='lista_clanova';     
}
if($akcija=='odobri_registranta'){
    $forma_id = $_REQUEST['forma_id'];
    $sql_check = "SELECT potvrdjen FROM enquiry_forms WHERE id = '$forma_id' ";
    $rez_check = mysql_query($sql_check);
    list($dalijeodobreniline)=@mysql_fetch_row($rez_check);
    if($dalijeodobreniline==1){
        $sql_update = "UPDATE enquiry_forms SET potvrdjen=0 WHERE id = '$forma_id' ";
        $rez_update = mysql_query($sql_update);
        if (!$rez_update) {
            die('Greska: '.$sql_update.' '. mysql_error());
        }      
    }else{
        $sql_update = "UPDATE enquiry_forms SET potvrdjen=1 WHERE id = '$forma_id' ";
        $rez_update = mysql_query($sql_update);
        if (!$rez_update) {
            die('Greska: '.$sql_update.' '. mysql_error());
        }      
    }
    
        //echo "uspesno";
$akcija='lista_formi';
}


if($akcija=='obrisi_formu'){
    $forma_id = $_REQUEST['forma_id'];
    $sql_brisanje_akcije = "DELETE FROM enquiry_forms WHERE id='$forma_id' ";
           $rez_brisanje_akcije = mysql_query($sql_brisanje_akcije);
        if (!$rez_brisanje_akcije) {
            die('Greska: '.$sql_brisanje_akcije.' '. mysql_error());
        } 
    
$akcija='lista_formi';
}

if($akcija=='obrisi_clana'){
    $forma_id = $_REQUEST['forma_id'];
    $sql_brisanje_akcije = "DELETE FROM members WHERE id='$forma_id' ";
           $rez_brisanje_akcije = mysql_query($sql_brisanje_akcije);
        if (!$rez_brisanje_akcije) {
            die('Greska: '.$sql_brisanje_akcije.' '. mysql_error());
        } 
    
$akcija='lista_clanova';
}

if($akcija=='izmeni_clana'){
    ?> 
    <script>
  $(document).ready(function() {
    $("#datepicker").datepicker();
    $("#datepicker2").datepicker();
  });
  
  function form_check(){
            //jAlert('You have to fill your surname *', 'Form Alert Dialog');
            
            var datepicker = document.getElementById('datepicker');
            if(datepicker.value != ""){
            //return true
            }else{
            jAlert('You have to choose date from.', 'Spin Masters Alert Dialog');
            return false
            }
            
            var datepicker2 = document.getElementById('datepicker2');
            if(datepicker2.value != ""){
            //return true
            }else{
            jAlert('You have to choose date to.', 'Spin Masters Alert Dialog');
            return false
            }
            return true
     
           }
  </script>  
  <?php
    $forma_id = $_REQUEST['forma_id'];
    $sql_check = "SELECT id, datum_prijave, form_imeprezime, form_brojlicnekarte, form_telefon, form_email, sifra, form_opis FROM members WHERE id = '$forma_id' ";
    $rez_check = mysql_query($sql_check);
    list($id, $datum_prijave, $form_imeprezime, $form_brojlicnekarte, $form_telefon, $form_email, $form_sifra, $form_opis)=@mysql_fetch_row($rez_check);
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Edit member:</strong></td>
  </tr></table>";

echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";  
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><br><strong>MEMBER CODE:</strong></td>
    <td class=\"TD_EvenNew\"><br><input type=\"text\" size=\"50\" name=\"form_membercode\" id=\"form_membercode\" value=\"$form_sifra\" /></td>
    <td class=\"TD_EvenNew\" rowspan=\"8\" valign=\"top\" align=\"left\"><br>
    <table class=\"okvirche\" width=\"450\" border=\"0\" align=\"center\" cellspacing=0>
    <tr>
    <td class=\"TD_OddRed\" colspan=\"4\" align=\"center\" style=\"padding: 10px 5px 10px 10px\"><strong>List of services<strong></td>
  </tr>
    <tr>";
    echo "<td class=\"TD_EvenNew\" align=\"center\" style=\"padding: 10px 5px 10px 10px\">";
    echo "Select service:<br><select class=\"izaberi\" id=\"id_services\">";
                     
    $sql_query = "SELECT id, naziv, aktiv FROM services ORDER BY id ";
    $rez_query = mysql_query($sql_query);
    if(mysql_num_rows($rez_query)>0){
    while (list($id_item, $naziv_item, $aktiv_item)=@mysql_fetch_row($rez_query)) {
       echo "<option value=\"$id_item\">$naziv_item</option>";
    }
    }
    echo "</select>";
    echo "</td>";
    echo "<td class=\"TD_EvenNew\" align=\"center\" style=\"padding: 10px 5px 10px 10px\">
    Date from:<br> <input type=\"text\" id=\"datepicker\" name=\"datepicker\" size=\"10\">
    </td>";
    echo "<td class=\"TD_EvenNew\" align=\"center\" style=\"padding: 10px 5px 10px 10px\">
    Date to:<br> <input type=\"text\" id=\"datepicker2\" name=\"datepicker2\" size=\"10\">
    </td>";
    echo "<td class=\"TD_EvenNew\" align=\"center\" style=\"padding: 10px 5px 10px 10px\"><br>
    <input type=\"button\" class=\"btn\" id=\"ubaci_kalendar\" name=\"ubaci_kalendar\" onClick=\"provera = form_check(); if(provera){var id_services = \$('#id_services').val(); var datepicker = \$('#datepicker').val();  var datepicker2 = \$('#datepicker2').val(); prikaziLoad_mali('calendar_listing'); $('#calendar_listing').load('ajax/forme.php',{akcija: 'add_calendar',  LID:'".$LID."', id_c: '".$forma_id."', id_services: id_services, datepicker: datepicker, datepicker2: datepicker2}).fadeIn('slow');}\" value=\"Add\">
    </td>";
echo "</tr></table>";
  
echo "<table id=\"calendar_listing\" class=\"okvirche\" width=\"450\" border=\"0\" align=\"center\" cellspacing=0>";
 
 $sql_query = "SELECT c.id, s.naziv, c.od, c.do FROM calendar c, services s WHERE s.id = c.id_s AND  c.id_c = '$forma_id' ORDER BY c.do DESC, c.od DESC ";
    $rez_query = mysql_query($sql_query);
    if(mysql_num_rows($rez_query)>0){
    while (list($id_c, $naziv_s, $od_c, $do_c)=@mysql_fetch_row($rez_query)) {
        $od_c=strtotime($od_c);
        $do_c=strtotime($do_c);
        $od_c = date('d.m.Y.',$od_c);
        $do_c = date('d.m.Y.',$do_c);
       echo "<tr id=\"calendar_list_$id_c\">";
       echo "<td class=\"TD_EvenNew\" width=\"150\" align=\"center\" style=\"padding: 10px 5px 10px 10px; background: #D7F7A6;font-size: 14px\" \"><strong>$naziv_s</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\"><strong>$od_c</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\"><strong>$do_c</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\">";
       echo "<a href=\"#\" onClick=\"prikaziLoad_mali('calendar_list_$id_c'); $('#calendar_list_$id_c').load('ajax/forme.php',{akcija: 'izmeni_calendar',  LID:'".$LID."', forma_id: '".$forma_id."', calendar_list_edit: '".$id_c."'}).fadeIn('slow');\" ><img style=\"float:left\" src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
        
        
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('calendar_listing'); $('#calendar_listing').load('ajax/forme.php',{akcija: 'obrisi_calendar',  LID:'".$LID."', forma_id: '".$forma_id."', id_calendar: '".$id_c."'}).fadeIn('slow');}\" ><img src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
       echo "</td>";


        echo "</tr>";
    }
    }
  
 
 echo "</table>   
    
    
    </td>
    </tr>";  
   
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Full name:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_imeprezime\" id=\"form_imeprezime\" value=\"$form_imeprezime\" /></td>
    </tr>";  
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>ID card number</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_brojlicnekarte\" id=\"form_brojlicnekarte\" value=\"$form_brojlicnekarte\" /></td>
    </tr>";      
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Email</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_email\" id=\"form_email\" value=\"$form_email\" /></td>
    </tr>";
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Phone</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_telefon\" id=\"form_telefon\" value=\"$form_telefon\" /></td>
    </tr>";  
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Description</strong></td>
    <td class=\"TD_EvenNew\"><textarea cols=\"40\" rows=\"4\" name=\"form_opis\" id=\"form_opis\" >$form_opis</textarea></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><br><input type=\"submit\" onClick=\"var form_membercode = \$('#form_membercode').val(); var form_imeprezime = \$('#form_imeprezime').val(); var form_brojlicnekarte = \$('#form_brojlicnekarte').val(); var form_email = \$('#form_email').val(); var form_telefon = \$('#form_telefon').val(); var form_opis = \$('#form_opis').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/forme.php',{akcija: 'update_member_sql',  LID:'".$LID."',  forma_id:'".$forma_id."', form_membercode: form_membercode, form_imeprezime: form_imeprezime, form_brojlicnekarte: form_brojlicnekarte, form_email: form_email, form_telefon: form_telefon, form_opis: form_opis}).fadeIn('slow');\" class=\"btn\" value=\"Update\" >&nbsp;&nbsp;&nbsp;<input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ><br><br></td></tr></table>";
}

if($akcija=='add_calendar'){
        $id_c = $_REQUEST['id_c'];
        $id_services = $_REQUEST['id_services'];
        $datum_pocetak = $_REQUEST['datepicker'];
        $datum_pocetak=strtotime($datum_pocetak);
        $datum_mysql_pocetak = date('Y-m-d',$datum_pocetak);
        $datum_kraj = $_REQUEST['datepicker2'];
        $datum_kraj=strtotime($datum_kraj);
        $datum_mysql_kraj = date('Y-m-d',$datum_kraj);
        
        //kalendar upis
        $sql_proccess = "INSERT INTO calendar (id_c, id_s, od, do) VALUES ( '$id_c', '$id_services', '$datum_mysql_pocetak', '$datum_mysql_kraj')";
        $rez_proccess = mysql_query($sql_proccess);
         //kalendar upis kraj   
    
     $sql_query = "SELECT c.id, s.naziv, c.od, c.do FROM calendar c, services s WHERE s.id = c.id_s AND  c.id_c = '$id_c' ORDER BY c.do DESC, c.od DESC ";
    $rez_query = mysql_query($sql_query);
    if(mysql_num_rows($rez_query)>0){
    while (list($id_c, $naziv_s, $od_c, $do_c)=@mysql_fetch_row($rez_query)) {
        $od_c=strtotime($od_c);
        $do_c=strtotime($do_c);
        $od_c = date('d.m.Y.',$od_c);
        $do_c = date('d.m.Y.',$do_c);
       echo "<tr>";
       echo "<td class=\"TD_EvenNew\" width=\"150\" align=\"center\" style=\"padding: 10px 5px 10px 10px; background: #D7F7A6;font-size: 14px\" \"><strong>$naziv_s</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\"><strong>$od_c</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\"><strong>$do_c</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\">";
       echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/forme.php',{akcija: 'izmeni_clana',  LID:'".$LID."', forma_id: '".$id_f."'}).fadeIn('slow');\" ><img style=\"float:left\" src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
        
        
     echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('calendar_listing'); $('#calendar_listing').load('ajax/forme.php',{akcija: 'obrisi_calendar',  LID:'".$LID."', forma_id: '".$forma_id."', id_calendar: '".$id_c."'}).fadeIn('slow');}\" ><img src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
       echo "</td>";


        echo "</tr>";
    }
    }
}
if($akcija=='obrisi_calendar'){
        $id_calendar = $_REQUEST['id_calendar'];
        $forma_id = $_REQUEST['forma_id'];
        
        //kalendar birsanje
        $sql_proccess = "DELETE FROM calendar WHERE id='$id_calendar' ";
        $rez_proccess = mysql_query($sql_proccess);
         //kalendar birsanje   
    
     $sql_query = "SELECT c.id, s.naziv, c.od, c.do FROM calendar c, services s WHERE s.id = c.id_s AND  c.id_c = '$forma_id' ORDER BY c.do DESC, c.od DESC ";
    $rez_query = mysql_query($sql_query);
    if(mysql_num_rows($rez_query)>0){
    while (list($id_c, $naziv_s, $od_c, $do_c)=@mysql_fetch_row($rez_query)) {
        $od_c=strtotime($od_c);
        $do_c=strtotime($do_c);
        $od_c = date('d.m.Y.',$od_c);
        $do_c = date('d.m.Y.',$do_c);
       echo "<tr>";
       echo "<td class=\"TD_EvenNew\" width=\"150\" align=\"center\" style=\"padding: 10px 5px 10px 10px; background: #D7F7A6;font-size: 14px\" \"><strong>$naziv_s</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\"><strong>$od_c</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\"><strong>$do_c</strong></td>";
       echo "<td class=\"TD_EvenNew\" style=\"background: #D7F7A6;\">";
       echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/forme.php',{akcija: 'izmeni_clana',  LID:'".$LID."', forma_id: '".$id_f."'}).fadeIn('slow');\" ><img style=\"float:left\" src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
        
        
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('calendar_listing'); $('#calendar_listing').load('ajax/forme.php',{akcija: 'obrisi_calendar',  LID:'".$LID."', forma_id: '".$forma_id."', id_calendar: '".$id_c."'}).fadeIn('slow');}\" ><img src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";
       echo "</td>";


        echo "</tr>";
    }
    }
}

if($akcija=='nov_clan'){
    ?> 
    <script>
  $(document).ready(function() {
    $("#datepicker").datepicker();
    $("#datepicker2").datepicker();
  });
  </script>  
  <?php
    echo "<br>";
 echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";
  echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>New member:</strong></td>
  </tr></table>";
  
echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0>";  
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><br><strong>MEMBER CODE:</strong></td>
    <td class=\"TD_EvenNew\"><br><input type=\"text\" size=\"50\" name=\"form_membercode\" id=\"form_membercode\" /></td>
    </tr>";  
   
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Full name:</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_imeprezime\" id=\"form_imeprezime\" /></td>
    </tr>";  
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>ID card number</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_brojlicnekarte\" id=\"form_brojlicnekarte\" /></td>
    </tr>";      
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Email</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_email\" id=\"form_email\" /></td>
    </tr>";
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Phone</strong></td>
    <td class=\"TD_EvenNew\"><input type=\"text\" size=\"50\" name=\"form_telefon\" id=\"form_telefon\" /></td>
    </tr>";  
    
  echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Service:</strong></td>
    <td class=\"TD_EvenNew\">";

echo "Select service:<br><select class=\"izaberi\" id=\"id_services\">";
                     
    $sql_query = "SELECT id, naziv, aktiv FROM services ORDER BY id ";
    $rez_query = mysql_query($sql_query);
    if(mysql_num_rows($rez_query)>0){
    while (list($id_item, $naziv_item, $aktiv_item)=@mysql_fetch_row($rez_query)) {
       echo "<option value=\"$id_item\">$naziv_item</option>";
    }
    }
    echo "</select><br><br>
    Date from:<br> <input type=\"text\" id=\"datepicker\" name=\"datepicker\"><br><br>
    Date to:<br> <input type=\"text\" id=\"datepicker2\" name=\"datepicker2\"><br><br>
    </td></tr>";
    
echo "<tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><strong>Description</strong></td>
    <td class=\"TD_EvenNew\"><textarea cols=\"40\" rows=\"4\" name=\"form_opis\" id=\"form_opis\"></textarea></td>
    </tr>";  
  
echo "<tr><td class=\"TD_EvenNew\"></td>
  <td class=\"TD_EvenNew\"><br><input type=\"submit\" onClick=\"var datepicker = \$('#datepicker').val(); var datepicker2 = \$('#datepicker2').val(); var id_services = \$('#id_services').val(); var form_membercode = \$('#form_membercode').val(); var form_imeprezime = \$('#form_imeprezime').val(); var form_brojlicnekarte = \$('#form_brojlicnekarte').val(); var form_email = \$('#form_email').val(); var form_telefon = \$('#form_telefon').val(); var form_opis = \$('#form_opis').val(); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/forme.php',{akcija: 'insert_member_sql',  LID:'".$LID."', datepicker: datepicker, datepicker2: datepicker2, id_services: id_services, form_membercode: form_membercode, form_imeprezime: form_imeprezime, form_brojlicnekarte: form_brojlicnekarte, form_email: form_email, form_telefon: form_telefon, form_opis: form_opis}).fadeIn('slow');\" class=\"btn\" value=\"Insert\" >&nbsp;&nbsp;&nbsp;<input type=\"submit\" onClick=\"$('#divAddEdit').html('');\" class=\"btn\" value=\"Cancel\" ><br><br></td></tr></table>";
}

if($akcija=='lista_formi'){
   // $A_NIVO = $_REQUEST['A_NIVO'];
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
                    "aaSorting": [ [0,'desc'], [1,'asc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
</script>
    <?php
    $sql = "SELECT id, DATE_FORMAT(datum_prijave,'%d.%m.%Y. | %H:%i:%S') datumvesti, form_imeprezime, form_brojlicnekarte, form_telefon, form_email, sifra, potvrdjen FROM enquiry_forms ORDER BY datum_prijave DESC ";
    $rez = mysql_query($sql);
    echo "<div align=\"center\" style=\"margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;\" >
    <a href=\"#\" name=\"./ajax/priprema_forme_pdf.php\" onClick=\"NewWindow(this.name,'vreme','800','800','yes');return false\" style=\"padding-right:5px\;\"><img src=\"./images/pdf_dugme.png\" border=0 title=\"PDF\"><br>PDFListing</a></div>";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>Time and Date:</th>";
    echo "<th>Name</th>";
    echo "<th>ID card</th>";
    echo "<th>Phone</th>";
    echo "<th>Email</th>";
    echo "<th>CODE</th>";
    echo "<th>Approved</th>";
    echo "<th>options</th>";
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
        while (list($id_f, $datum_popunjavanja_mysql, $form_imeoprezime, $form_brojlicnekarte, $form_telefon, $form_email, $form_sifra, $form_potvrdjen)=@mysql_fetch_row($rez)) {
            if($form_potvrdjen==1){
                $form_potvrdjen = '<strong>YES<strong>';
            }else{
                $form_potvrdjen = '<strong>NO<strong>';
            }
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$datum_popunjavanja_mysql</td>";
            echo "<td>$form_imeoprezime</td>";
            echo "<td>$form_brojlicnekarte</td>";
            echo "<td>$form_telefon</td>";
            echo "<td>$form_email</td>";
            echo "<td>$form_sifra</td>";  
            echo "<td>$form_potvrdjen</td>";  
            echo "<td align=\"center\">";
                 
            //echo "<a href=\"#\" name=\"../forme/priprema_forme_pdf.php?id_f=$id_f\" onClick=\"NewWindow(this.name,'vreme','800','800','yes');return false\" style=\"padding-right:5px\;\"><img style=\"float:left\" src=\"./images/pdf_dugme.png\" border=0 title=\"PDF\"></a>";
                       
            echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divLista'); $('#divLista').load('ajax/forme.php',{akcija: 'odobri_registranta',  LID:'".$LID."', forma_id: '".$id_f."'}).fadeIn('slow');\" ><img style=\"float:left\" src=\"./images/confirm_icon.jpg\" border=0 title=\"Approve\"></a>";
        
        
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/forme.php',{akcija: 'obrisi_formu',  LID:'".$LID."', forma_id: '".$id_f."'}).fadeIn('slow');}\" ><img src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";

    echo "</td>";
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>Time and Date:</th>";
    echo "<th>Name</th>";
    echo "<th>ID card</th>";
    echo "<th>Phone</th>";
    echo "<th>Email</th>";
    echo "<th>CODE</th>";
    echo "<th>Approved</th>";
    echo "<th>options</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}

if($akcija=='lista_clanova'){
   // $A_NIVO = $_REQUEST['A_NIVO'];
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
                    "aaSorting": [ [0,'desc'], [1,'asc'] ],
                    "aoColumnDefs": [
                        { "sType": 'string-case', "aTargets": [ 2 ] }
                    ]
                } );
            } );
</script>
    <?php
    $sql = "SELECT id, DATE_FORMAT(datum_prijave,'%d.%m.%Y. | %H:%i:%S') datumvesti, form_imeprezime, form_brojlicnekarte, form_telefon, form_email, sifra, potvrdjen FROM members ORDER BY datum_prijave DESC ";
    $rez = mysql_query($sql);
    echo "<div align=\"center\" style=\"margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;\" >
    <a href=\"#\" name=\"./ajax/priprema_forme_pdf.php\" onClick=\"NewWindow(this.name,'vreme','800','800','yes');return false\" style=\"padding-right:5px\;\"><img src=\"./images/pdf_dugme.png\" border=0 title=\"PDF\"><br>PDFListing</a></div>";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\">";
    echo "<thead><tr>";
    echo "<th>Member ID</th>";
    echo "<th>Date created:</th>";
    echo "<th>Name</th>";
    echo "<th>ID card</th>";
    echo "<th>Phone</th>";
    echo "<th>Email</th>";
    echo "<th>options</th>";
    echo "</tr></thead>";
    echo "<tbody>";
    if(mysql_num_rows($rez)>0){
    
        $i=0;
        while (list($id_f, $datum_popunjavanja_mysql, $form_imeoprezime, $form_brojlicnekarte, $form_telefon, $form_email, $form_sifra, $form_potvrdjen)=@mysql_fetch_row($rez)) {
            if($form_potvrdjen==1){
                $form_potvrdjen = '<strong>YES<strong>';
            }else{
                $form_potvrdjen = '<strong>NO<strong>';
            }
            echo "<tr height=\"40px\" class=\"gradeC\">";
            echo "<td>$form_sifra</td>"; 
            echo "<td>$datum_popunjavanja_mysql</td>";
            echo "<td>$form_imeoprezime</td>";
            echo "<td>$form_brojlicnekarte</td>";
            echo "<td>$form_telefon</td>";
            echo "<td>$form_email</td>"; 
            echo "<td align=\"center\">";
                 
            //echo "<a href=\"#\" name=\"../forme/priprema_forme_pdf.php?id_f=$id_f\" onClick=\"NewWindow(this.name,'vreme','800','800','yes');return false\" style=\"padding-right:5px\;\"><img style=\"float:left\" src=\"./images/pdf_dugme.png\" border=0 title=\"PDF\"></a>";
                       
            echo "<a href=\"#\" onClick=\"prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/forme.php',{akcija: 'izmeni_clana',  LID:'".$LID."', forma_id: '".$id_f."'}).fadeIn('slow');\" ><img style=\"float:left\" src=\"./images/izmeni_dugme.png\" border=0 title=\"Edit\"></a>";
        
        
    echo "<a href=\"#\" onClick=\"pom = proveri(); if(pom){prikaziLoad_mali('divLista'); $('#divLista').load('ajax/forme.php',{akcija: 'obrisi_clana',  LID:'".$LID."', forma_id: '".$id_f."'}).fadeIn('slow');}\" ><img src=\"./images/obrisi_dugme.png\" border=0 title=\"Delete\"></a>";

    echo "</td>";
    echo "</tr>";
        }
        
    }
    echo "</tbody><tfoot><tr>";
    echo "<th>Member ID</th>";
    echo "<th>Date created:</th>";
    echo "<th>Name</th>";
    echo "<th>ID card</th>";
    echo "<th>Phone</th>";
    echo "<th>Email</th>";
    echo "<th>options</th>";
    echo "</tr></tfoot></table>";
    echo "<br />";
}



if($akcija=='home_page'){
    
   echo "<table class=\"okvirche\" width=\"900px\" height=\"500px\" border=\"0\" align=\"center\" cellspacing=0><tr>
     <td class=\"TD_OddRed\" align=\"center\" style=\"font-family: Arial, Helvetica, sans-serif;
font-size:32px; padding: 10px 5px 10px 10px; color: #494949;\">Dobrodošli u SNIZENO</td></tr>";
   echo "</table>";
}

?>

