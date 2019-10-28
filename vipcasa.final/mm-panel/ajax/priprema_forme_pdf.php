<?php
@include("../uklj/baza_heder.php");
@include("../uklj/podesavanje.php");
@include("../uklj/datum.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Spin Masters Beograd  teretana i fitness centar - PDF</title>
    <link href="izvestaj.css" media="all" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
</head>
<body>
<div align="center" style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 100%;" >
<img align="middle" src="/images/logo.png" alt="Spin Masters Beograd  teretana i fitness centar - Logo" class="">
<h2>Priprema za PDF izveštaj</h2>
<h2>Lista prijavljenih za popust</h2>
<?php
//$izvestaj_id = $_REQUEST['id_izvestaja'];
echo "<form action=\"./izvestaj_izvestaj_custom_pdf.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"formPDF\">";

    ?>
<h2>Period</h2><br><strong>Od:</strong>
     <script>
  $(document).ready(function() {
    $("#datepicker").datepicker();
    $("#datepicker2").datepicker();
  });
  </script>  
<input type="text" id="datepicker" name="datepicker" value="<?php echo $datum_poziva; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Do:</strong><input type="text" id="datepicker2"  name="datepicker2" value="<?php echo $datum_poziva; ?>"><br><br>
    <?php
    
//echo "<input name=\"datum\" size=\"50\" type=\"text\" value=\"".date('d.m.Y.')."\" >";

echo "<input type=\"submit\" name=\"button\" id=\"button\" value=\"Generisi PDF\" />
</form>";
?>
</div>
</body></html>