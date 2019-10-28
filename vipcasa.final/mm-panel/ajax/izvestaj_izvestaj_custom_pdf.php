<?php
@include("../uklj/baza_heder.php");
@include("../uklj/podesavanje.php");
@include("../uklj/datum.php");

    //$izvestaj_datum = $_REQUEST['datum'];
    $izvestaj_datum = date('d.m.Y.');
    $datum_pocetak = $_REQUEST['datepicker'];
    $datum_pocetak=strtotime($datum_pocetak);
    $datum_mysql_pocetak = date('Y-m-d',$datum_pocetak);
    $datum_pocetak_prikaz = date('d.m.Y.',$datum_pocetak);


    $datum_kraj = $_REQUEST['datepicker2'];
    $datum_kraj=strtotime($datum_kraj);
    $datum_mysql_kraj = date('Y-m-d',$datum_kraj);
    $datum_kraj_prikaz = date('d.m.Y.',$datum_kraj);

  
    
    
  
       
     define('_MPDF_PATH','../MPDF52/');

  include("../MPDF52/mpdf.php");
//$mpdf=new mPDF('c'); 
$mpdf = new mPDF('utf-8');
//$mpdf->debug = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetHeader("Spin Masters Beograd||PDF Izvestaj");
//$mpdf->SetFooter("$izvestaj_datum||{PAGENO}/{nb}");
$mpdf->SetFooter("Spin Masters Beograd|tel. +381 11 24 56 074|info@spinmasters.rs, www.spinmasters.rs");
// LOAD a stylesheet
$stylesheet = file_get_contents('izvestaj.css');

$mpdf->WriteHTML($stylesheet,1);    // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->shrink_tables_to_fit=1;
  
  ///NASLOVNA STRANA
  
  $html2 = '<table  style="width:650px; height:1000px; " border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top"><img src="/images/logo.png" width="300" height="138" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table  style="width:650px;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="Naslov" style="font-size: 36px;">Izveštaj</td>
  </tr>
</table>

';
    
    
 

$html2 .= '<table width="900" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td bgcolor="#f8f7ef" style="font-size:16px;">Lista prijavljenih za popust</td>
  </tr>
</table>';

    $podaci_o_izvestajima = "SELECT id, DATE_FORMAT(datum_prijave,'%H:%i %d.%m.%Y.')  datum_poziva, form_imeprezime, form_brojlicnekarte, form_telefon, form_email, sifra, potvrdjen FROM enquiry_forms WHERE datum_prijave between '$datum_mysql_pocetak' AND '$datum_mysql_kraj' ";
    
    $rez_podaci_o_izvestajima = mysql_query($podaci_o_izvestajima) or die(mysql_error());;
  
  $i=1;
  $html2 .= "<div style=\"padding-left:15px\"><table>";
        $html2 .= '<tr>
          <td class="TD_Odd podvuceno">Code</td>
          <td class="TD_Odd podvuceno">Datum prijave</td>
          <td class="TD_Odd podvuceno">Ime i prezime</td>
          <td class="TD_Odd podvuceno">Broj lične karte</td>
          <td class="TD_Odd podvuceno">Telefon</td>
          <td class="TD_Odd podvuceno">Email</td>
          <td class="TD_Odd podvuceno">Potvrdjen</td>
        </tr>';
    while (list($id, $datum_prijave, $form_imeprezime, $form_brojlicnekarte, $form_telefon, $form_telefon, $form_email, $form_sifra, $form_potvrdjen)=@mysql_fetch_row($rez_podaci_o_izvestajima)){
        if($form_potvrdjen==1){
            $form_potvrdjen = 'DA';
        }else{
            $form_potvrdjen = 'NE';
        }
        
         $html2 .= "<tr><td style=\"border-style:solid; border-right:1px #c8c8c8;\">$form_sifra<br>$podaci_administrator</td>";
        $html2 .= "<td style=\"border-style:solid; border-right:1px #c8c8c8;\">$datum_prijave</td>";
        $html2 .= "<td style=\"border-style:solid; border-right:1px #c8c8c8;\">$form_imeprezime</td>";
        $html2 .= "<td style=\"border-style:solid; border-right:1px #c8c8c8;\">$form_brojlicnekarte</td>";
        $html2 .= "<td style=\"border-style:solid; border-right:1px #c8c8c8;\">$form_telefon</td>";
        $html2 .= "<td style=\"border-style:solid; border-right:1px #c8c8c8;\">$form_email</td>";
        
        $html2 .= "<td align=\"center\" style=\"border-style:solid; border-right:1px #c8c8c8;\">$form_potvrdjen</td></tr>";
        //$html2 .= "</table>";
    $i++;
    }
          $html2 .= "</table></div>";



        
  
  
$mpdf->WriteHTML($html2);
//$mpdf->shrink_tables_to_fit=1;
//$mpdf->Output();
$vreme = time();
$mpdf->Output("pdf/SpinMasters_listaprijavljenih_"."$vreme.pdf",'F');
//echo "PDF <a href=\"pdf/izvestaj_vrste.pdf\" >download</a>";
//echo $html;
header("Location: ./pdf/SpinMasters_listaprijavljenih_"."$vreme.pdf");
exit;  
    ?>