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
<script>
$(document).ready(function(){ 
$('#divLista').load('ajax/forme.php',{akcija: 'lista_formi',  LID:'<?php echo $LID; ?>',  A_NIVO:'<?php echo $A_NIVO; ?>'}).fadeIn('slow');
});
</script>
<script language="javascript" type="text/javascript"> 
/****************************************************
     Author: Eric King
     Url: http://redrival.com/eak/index.shtml
     This script is free to use as long as this info is left in
     Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
****************************************************/
var win=null;
function NewWindow(mypage,myname,w,h,scroll,pos){
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
win=window.open(mypage,myname,settings);}
</script> 
<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
        <li><a href="#" onClick="prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/forme.php',{akcija: 'lista_clanova', LID:'<?php echo $LID; ?>'}).fadeIn('slow');">List of members</a> 
        </li>
        <li><a href="#" onClick="prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/forme.php',{akcija: 'nov_clan', LID:'<?php echo $LID; ?>'}).fadeIn('slow');">New member</a> 
        </li>
        <li><a href="#" onClick="prikaziLoad_mali('divAddEdit'); $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/forme.php',{akcija: 'lista_formi', LID:'<?php echo $LID; ?>'}).fadeIn('slow');">List of submited forms</a> 
        </li>
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<div id="divAddEdit" name="AddEdit"></div>
<div id="divLista" name="divLista"></div>