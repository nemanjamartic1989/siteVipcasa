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
$('#divLista').load('ajax/navigation.php',{akcija: 'navigation_list_eng',  LID:'<?php echo $LID; ?>',  A_NIVO:'<?php echo $A_NIVO; ?>'}).fadeIn('slow');
});
</script>
<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
                <li><a href="#" onClick=" $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/navigation.php',{akcija: 'navigation_list_eng',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">English Navigation list</a></li>
                <li><a href="#" onClick=" $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/navigation.php',{akcija: 'navigation_list_rus',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Russian Navigation list</a></li>
                 <li><a href="#" onClick=" $('#divAddEdit').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/navigation.php',{akcija: 'navigation_list',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Serbian Navigation list</a></li>
</ul>
        
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<div id="divAddEdit" name="AddEdit"></div>
<div id="divMiddle" name="divMiddle"></div>
<div id="divLista" name="divLista"></div>