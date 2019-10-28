<?php
if (eregi("sadrzaji.php",$_SERVER['PHP_SELF'])) {
    @header("Refresh: 0; url=./");
    echo "<SCRIPT LANGUAGE='JavaScript'>";
    echo "document.location.href='./'";
    echo "</SCRIPT>";
    die();
    exit;
   }
?>
<script>
$(document).ready(function(){ 
$('#divLista').load('ajax/utils.php',{akcija: 'lista_stanova',  LID:'<?php echo $LID; ?>',  A_NIVO:'<?php echo $A_NIVO; ?>'}).fadeIn('slow');
});
</script>

<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
        <li><a href="./index.php?modul=vrste&LID=<?php echo $LID; ?>">Lista Vrsta</a></li>
        <li><a href="./index.php?modul=galerija&LID=<?php echo $LID; ?>">Galerija tipova</a></li>
        <li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'nova_vrsta',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Nova vrsta</a></li>
        <li><a href="./index.php?modul=tip&LID=<?php echo $LID; ?>">Lista tipova</a></li>
        <li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'novi_tip',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Novi tip</a></li>
        <li><a href="./index.php?modul=lokacija&LID=<?php echo $LID; ?>">Lista lokacija</a></li>
        <li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'nova_lokacija',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Nova lokacija</a></li>
        <li><a href="./index.php?modul=stan&LID=<?php echo $LID; ?>">Lista stanova</a></li>
        <li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'novi_stan',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Novi stan</a></li>
        
</ul>
        
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<div id="divAddEdit" name="AddEdit"></div>
<div id="divMiddle" name="divMiddle"></div>
<div id="divLista" name="divLista"></div>