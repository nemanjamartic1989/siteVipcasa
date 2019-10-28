<?php
include("../uklj/baza_heder.php");
header("Content-Type: text/html; charset=utf-8");

$akcija = $_REQUEST['akcija'];

$debug = 0;

function YYYYMMDD($parametar)
{
// formatiranje datuma iz dd.mm.yyyy formata u "yyyy-mm-dd" radi upisa u bazu
$podelj = explode('.',$parametar);
$dpod=$podelj[0];$mpod=$podelj[1];$gpod=$podelj[2];
if (strlen($dpod) == 1) {$dpod = "0".$dpod;}
if (strlen($mpod) == 1) {$mpod = "0".$mpod;}
if (strlen($gpod) == 1) {$gpod = "200".$gpod;}
if (strlen($gpod) == 2) {if ($gpod > 35) {$gpod = "19".$gpod;} else {$gpod = "20".$gpod;}}
if (strlen($gpod) == 3) {if ($gpod > 935) {$gpod = "1".$gpod;} else {$gpod = "2".$gpod;}}
if (strlen($gpod) == 0) {$gpod = date('Y');}
if (@checkdate($mpod,$dpod,$gpod)){
$datumform = $gpod . "-" . $mpod . "-" . $dpod;
return $datumform; } else {return '-';}
}


if($akcija=='registracija_proces'){
    $contactname = $_REQUEST['contactname'];
    $contactlokacija = $_REQUEST['contactlokacija'];
    $contactemail = $_REQUEST['contactemail'];
    $contactno = $_REQUEST['contactno'];
    $contactmessage = $_REQUEST['contactmessage'];
    $contactlokacijanaziv = 'VipCasa Lokacija';
    $grad = 1;
    $sqlLok = "SELECT l.id, l.naziv, l.mesto, l.adresa, l.status, l.grad FROM lokacija l WHERE l.id='$contactlokacija' ORDER BY l.id ASC";
        $rezLok = mysql_query($sqlLok);
        if(mysql_num_rows($rezLok)>0){
            while (list($id_l, $nazivl, $mestol, $adresal, $statusl, $gradl)=@mysql_fetch_row($rezLok)) {
                $contactlokacijanaziv = $nazivl;
                $grad = $gradl;
            }
          }
     include_once('htmlMimeMail.php');
     $msg .="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><body>";
            $msg .='  <table border="0" cellspacing="3" cellpadding="4">
                  <tr>
                    <td align="center" valign="middle" colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:25px; color:#5D5D5D;">VipCasa - Kontakt sa sajta</td>
                    </tr>
                    <tr>
                    <td align="left" valign="middle" colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333;"><strong><br>Kontakt informacije:<br><hr></strong></td>
                    </tr>
                  <tr>
                    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333;"><strong>Upit za lokaciju</strong></td>
                    <td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#C9591C;"><strong>'.$contactlokacijanaziv.'</strong></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333;"><strong>Ime i prezime</strong></td>
                    <td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#C9591C;"><strong>'.$contactname.'</strong></td>
                  </tr>
                   <tr>
                    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333;"><strong>Email</strong></td>
                    <td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#C9591C;"><strong>'.$contactemail.'</strong></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333;"><strong>Kontakt telefon</strong></td>
                    <td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#C9591C;"><strong>'.$contactno.'</strong></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#333;"><strong>Kontakt poruka</strong></td>
                    <td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#C9591C;"><strong>'.$contactmessage.'</strong></td>
                  </tr>
                  </table>';
            
            $body = $msg;
            $mail = new htmlMimeMail();
            $mail->setHtml($body);
            $mail->setFrom("VipCasa Invest Website kontakt <noreply@vipcasa.rs>");  
                $mail->setSubject("VipCasa Kontakt sa sajta");
                $mail->setHeader('X-Mailer', 'HTML Mime mail class (http://www.phpguru.org)');
                $mail->setTextCharset('utf-8');
                $mail->setHtmlCharset('utf-8');
                $mail->setSMTPParams('mail.vipcasa.rs', 26, $hello, true, 'noreply@vipcasa.rs', 'Sifra2015');
                if($grad == 1){
                  $result = $mail->send(array("office@vipcasa.rs"));
                }elseif($grad == 2){
                  $result = $mail->send(array("proartuzice@gmail.com"));
                }else{
                  $result = $mail->send(array("munir.sarkar@mmstudio.rs"));
                }
                //
                //
                ?>
<script type="text/javascript">
$(function () {
  $('#processing').html('Uspešno ste poslali upit na email!');
    setTimeout(
  function() 
  {
    clear_data();
    $('#exampleModal').modal('toggle');
  }, 1500);
   
});
</script>
<?php
}


?>

