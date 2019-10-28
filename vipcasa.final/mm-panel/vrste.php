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

function listaslika_vrste(id){
                $('#thumbs-gallery').hide().load('ajax/utils.php',{akcija: 'listaslika_vrste', LID: '<?php echo $LID; ?>',  A_NIVO:'<?php echo $A_NIVO; ?>', id: id}).fadeIn('slow'); 
}

function brisanje_slike_vrste(id, imgfile){
        jConfirm('Delete Photo !?', 'VipCasa', function(r) { if(r==true){
            $('#thumbs-gallery').hide().load('ajax/utils.php',{akcija: 'brisanje_slike_vrste', LID: '<?php echo $LID; ?>',  A_NIVO:'<?php echo $A_NIVO; ?>',id: id, imgfile: imgfile}).fadeIn('slow'); 
        }
            })
        }
$(document).ready(function(){ 
$('#divLista').load('ajax/utils.php',{akcija: 'lista_vrsta',  LID:'<?php echo $LID; ?>',  A_NIVO:'<?php echo $A_NIVO; ?>'}).fadeIn('slow');
});
</script>

<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
    <?php
include("podnavigacija.php");
?>        

</ul>
        
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<div id="divAddEdit" name="AddEdit"></div>
<div id="divMiddle" name="divMiddle"></div>
<div id="divLista" name="divLista"></div>