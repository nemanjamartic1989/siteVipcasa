<?php
 $Myqsl["Server"]="mysql"; 
 $Myqsl["User"]="tankmont_vipcasa";//MMSTUDIO
 $Myqsl["Pass"]="w,&,y9GLF~q4";
 $Myqsl["DB"]="tankmont_vipcasa";

$db = @mysql_connect($Myqsl["Server"], $Myqsl["User"], $Myqsl["Pass"]) OR DIE ("NEUSPELO POVEZIVANJE NA BAZU !");
@mysql_select_db($Myqsl["DB"],$db);

mysql_query("SET NAMES utf8");


//funkcije za transakcije InnoDB samo
function begin()
{
@mysql_query("SET AUTOCOMMIT=0");
@mysql_query("BEGIN");
}

function commit()
{
@mysql_query("COMMIT");
}

function rollback()
{
@mysql_query("ROLLBACK");
}


function sredi_upis($x12bg56y)
{
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $x12bg56y = stripslashes($x12bg56y);
   }
   // Sredi quote
   if (!is_numeric($x12bg56y)) {
       $x12bg56y = mysql_real_escape_string($x12bg56y);
   }
   return $x12bg56y;
} 








//////// funkcije za security code sliku: -----------------------------------------------

function ubaciSecuritySliku($inputname, $putanjaDoSkripte) {
   $refid = md5(mktime()*rand());
  // $insertstr = "<img src=\"mail/security_sweb/securityslika.php?refid=".$refid."\" alt=\"Beonet SecImg\">\n
   $insertstr = "<img src=\"$putanjaDoSkripte"."securityslika.php?refid=".$refid."\" alt=\"SW_secImg\">\n
   <input type=\"hidden\" name=\"".$inputname."\" value=\"".$refid."\">";
   echo($insertstr);
}


//Funkcija koja proverava tacnost unosa SWeb
function proveriSecuritySliku($referenceid, $enteredvalue) {
   $referenceid = mysql_escape_string($referenceid);
   $enteredvalue = mysql_escape_string($enteredvalue);
   $tempQuery = mysql_query("SELECT ID FROM security_images WHERE
   referenceid='".$referenceid."' AND hiddentext='".$enteredvalue."'");
   if (mysql_num_rows($tempQuery)!=0) {
      return true;
   } else {
      return false;
   }
}

//////// funkcije za security code sliku kraj-------------------------------------------




?>