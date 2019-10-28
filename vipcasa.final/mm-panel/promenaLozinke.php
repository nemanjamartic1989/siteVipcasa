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
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br>
<?php
echo "<br><br>";
echo "<form action=\"index.php?modul=promenaLozinke&LID=$LID\" method=\"POST\">
<table cellspacing=0 align=\"center\" class=\"okvirche\" width=\"500\" border=\"0\">
  <tr>
    <td class=\"TD_EvenNew\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\">Unesite novu lozinku:</td>
    <td class=\"TD_EvenNew\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><input type=\"password\" name=\"novaLozinka\" value=\"\" id=\"novaLozinka\" /></td>
	<td class=\"TD_EvenNew\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><input type=\"submit\" name=\"Promeni\" value=\"Promeni\"/></td>
  </tr>
</table></form>";
?>

<?php
if(isset($_POST['Promeni']))
{
	$novaLozinka = $_POST['novaLozinka'];
	$izmena  = "UPDATE t_korisnici ";
	$izmena .= "SET lozinka = '{$novaLozinka}' ";
	$izmena .= "WHERE ime_prezime= '{$IME_PREZIME}'";
	$izvrsavanje = mysql_query($izmena);
	echo "<br>";
	echo "<font class=\"slovau\">Uspesno promenjena lozinka.</font>";

}
?>