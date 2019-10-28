<?php
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

if($akcija=='activate_nav_id'){
    $navigation_id = $_REQUEST['navigation_id'];
    $sql_modify = "SELECT active FROM navigation WHERE id = '$navigation_id' ";
    $rez_modify = mysql_query($sql_modify);
    if(mysql_num_rows($rez_modify)>0){
        list($id_nav)=@mysql_fetch_row($rez_modify);
        if($id_nav==1){
            $sql_modify = "UPDATE navigation SET active=0 WHERE id = '$navigation_id' ";
            $rez_modify = mysql_query($sql_modify);
        }else{
            $sql_modify = "UPDATE navigation SET active=1 WHERE id = '$navigation_id' ";
            $rez_modify = mysql_query($sql_modify);
        }
    }
}

if($akcija=='activate_nav_id_eng'){
    $navigation_id = $_REQUEST['navigation_id'];
    $sql_modify = "SELECT active FROM navigation_eng WHERE id = '$navigation_id' ";
    $rez_modify = mysql_query($sql_modify);
    if(mysql_num_rows($rez_modify)>0){
        list($id_nav)=@mysql_fetch_row($rez_modify);
        if($id_nav==1){
            $sql_modify = "UPDATE navigation_eng SET active=0 WHERE id = '$navigation_id' ";
            $rez_modify = mysql_query($sql_modify);
        }else{
            $sql_modify = "UPDATE navigation_eng SET active=1 WHERE id = '$navigation_id' ";
            $rez_modify = mysql_query($sql_modify);
        }
    }
}
if($akcija=='delete_first_level_item'){
    $first_level_item_id = $_REQUEST['first_level_item_id'];
    $sql_modify = "DELETE FROM navigation WHERE id = '$first_level_item_id' ";
    $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
        }  
$akcija='first_level_list';
}

if($akcija=='delete_first_level_item_eng'){
    $first_level_item_id = $_REQUEST['first_level_item_id'];
    $sql_modify = "DELETE FROM navigation_eng WHERE id = '$first_level_item_id' ";
    $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
        }  
$akcija='first_level_list_eng';
}

if($akcija=='delete_second_level_item'){
    $first_level_item_id = $_REQUEST['first_level_item_id'];
    $id_par = $_REQUEST['id_par'];
    $sql_modify = "DELETE FROM navigation WHERE id = '$first_level_item_id' ";
    $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
        }  
?>
   <script>
$(document).ready(function(){ 
$('#second_level_list').load('ajax/navigation.php',{akcija: 'second_level_list',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}

if($akcija=='delete_second_level_item_eng'){
    $first_level_item_id = $_REQUEST['first_level_item_id'];
    $id_par = $_REQUEST['id_par'];
    $sql_modify = "DELETE FROM navigation_eng WHERE id = '$first_level_item_id' ";
    $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
        }  
?>
   <script>
$(document).ready(function(){ 
$('#second_level_list').load('ajax/navigation.php',{akcija: 'second_level_list_eng',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}
if($akcija=='delete_third_level_item'){
    $first_level_item_id = $_REQUEST['first_level_item_id'];
    $id_par = $_REQUEST['id_par'];
    $sql_modify = "DELETE FROM navigation WHERE id = '$first_level_item_id' ";
    $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
        }  
?>
   <script>
$(document).ready(function(){ 
$('#third_level_list').load('ajax/navigation.php',{akcija: 'second_level_list',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}
if($akcija=='delete_third_level_item_eng'){
    $first_level_item_id = $_REQUEST['first_level_item_id'];
    $id_par = $_REQUEST['id_par'];
    $sql_modify = "DELETE FROM navigation_eng WHERE id = '$first_level_item_id' ";
    $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
        }  
?>
   <script>
$(document).ready(function(){ 
$('#third_level_list').load('ajax/navigation.php',{akcija: 'third_level_list_eng',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}
if($akcija=='insert_first_level_item'){
   $new_first_level_item_val = $_REQUEST['new_first_level_item_val'];
   $sql_modify = "INSERT INTO navigation (par, title, ord, active) VALUES ('0', '$new_first_level_item_val', '1', 0)";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
   $akcija='first_level_list';
}

if($akcija=='insert_first_level_item_eng'){
   $new_first_level_item_val = $_REQUEST['new_first_level_item_val'];
   $sql_modify = "INSERT INTO navigation_eng (par, title, ord, active) VALUES ('0', '$new_first_level_item_val', '1', 0)";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
   $akcija='first_level_list_eng';
}

if($akcija=='insert_second_level_item'){
   $new_second_level_item_val = $_REQUEST['new_second_level_item_val'];
   $id_par = $_REQUEST['id_par'];
   $sql_modify = "INSERT INTO navigation (par, title, ord, active) VALUES ('$id_par', '$new_second_level_item_val', '1', 0)";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
   ?>
   <script>
$(document).ready(function(){ 
$('#second_level_list').load('ajax/navigation.php',{akcija: 'second_level_list',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}

if($akcija=='insert_second_level_item_eng'){
   $new_second_level_item_val = $_REQUEST['new_second_level_item_val'];
   $id_par = $_REQUEST['id_par'];
   $sql_modify = "INSERT INTO navigation_eng (par, title, ord, active) VALUES ('$id_par', '$new_second_level_item_val', '1', 0)";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
   ?>
   <script>
$(document).ready(function(){ 
$('#second_level_list').load('ajax/navigation.php',{akcija: 'second_level_list_eng',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}
if($akcija=='insert_third_level_item'){
   $new_third_level_item_val = $_REQUEST['new_third_level_item_val'];
   $id_par = $_REQUEST['id_par'];
   $sql_modify = "INSERT INTO navigation (par, title, ord, active) VALUES ('$id_par', '$new_third_level_item_val', '1', 0)";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
   ?>
   <script>
$(document).ready(function(){ 
$('#third_level_list').load('ajax/navigation.php',{akcija: 'third_level_list',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}

if($akcija=='insert_third_level_item_eng'){
   $new_third_level_item_val = $_REQUEST['new_third_level_item_val'];
   $id_par = $_REQUEST['id_par'];
   $sql_modify = "INSERT INTO navigation_eng (par, title, ord, active) VALUES ('$id_par', '$new_third_level_item_val', '1', 0)";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
   ?>
   <script>
$(document).ready(function(){ 
$('#third_level_list').load('ajax/navigation.php',{akcija: 'third_level_list_eng',  LID:'<?php echo $LID; ?>',  navigation_id:'<?php echo $id_par; ?>'}).fadeIn('slow');
});
</script>
   <?php
}

if($akcija=='third_level_list'){
    $navigation_parent = $_REQUEST['navigation_id'];
    echo '<div class="mmpanel-third-level-header">3rd level</div>';
    //1st level listing
    $sql_level = "SELECT n.id, n.par, n.title, n.ord, n.link, n.active FROM navigation n WHERE n.par=$navigation_parent ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
     ?>
        <script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#third_level_group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent=<?php echo $navigation_parent; ?>'; 
            $.post("reorder/updateDB_nav3.php", order, function(theResponse){
                //$("#first_level_group_result").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
        <?php
        //echo '<div id="first_level_group_result"></div>';
        echo '<div id="third_level_group">';
        echo '<ul>';
        $i=0;
            while (list($navigation_id, $navigation_par, $navigation_title, $navigation_ord, $navigation_link, $navigation_active)=@mysql_fetch_row($rez_level)) {
                if($navigation_active==1){
            $active_state = 'checked="yes"';    
        }else{
            $active_state = ' ';    
        }
        
                 ?>
   <script>
$(function(){ 
$( "#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" ).dialog({
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            buttons: {
                "Izmeni": function() {
                    var item_level_val = $('#item_level_val<?php echo $navigation_id; ?>').val();
                    $('#first_level_list').load('ajax/navigation.php',{akcija: 'update_item_link',  LID:'<?php echo $LID; ?>',  id_item:'<?php echo $navigation_id; ?>', item_level_val: item_level_val}).fadeIn('slow');
                    $(this).dialog("close");
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
                });
$("#item-link<?php echo $navigation_id; ?>").click(function() {
               $("#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>").dialog("open");
            });


});
</script>
   <div id="mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" title="Modifikacija linka strane.">
    <p>Izaberite stranicu</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_strane\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";
?>
<p>ili Izaberite aranzman</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_aranzman\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select>";
?>
<p>Link:</p>
<input id="item_level_val<?php echo $navigation_id; ?>" style="width: 270px;" type="text" value="<?php echo $navigation_link; ?>">
</div>
<?php
                    echo '<li id="mmpanel-third-level-items_'.$navigation_id.'" class="mmpanel-third-level-items"><div class="item-title" id="navigation_firstitem_title_val'.$navigation_id.'"><input type="checkbox" '.$active_state.' name="active_'.$navigation_id.'" onclick="$(\'#divAddEdit\').load(\'ajax/navigation.php\',{akcija: \'activate_nav_id\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');" value="1" />&nbsp;&nbsp;<a href="#" title="'.$navigation_title.'" onclick="prikaziLoad_mali(\'third_level_list\'); $(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'third_level_list\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');">'.$navigation_title.'</a></div><div class="item-modify-icons"><a href="#" id="item-link'.$navigation_id.'" title="Link Item"><img src="images/link_nav.png" border=0></a>
<a href="#" title="Rename Item" onclick="$(\'#navigation_firstitem_title_val'.$navigation_id.'\').load(\'ajax/navigation.php\',{akcija: \'rename_first_level_item\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');"><img src="images/rename_nav.png" border=0></a><a href="#" title="Delete Item" onclick="pom = proveri(); if(pom){$(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'delete_third_level_item\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\',  id_par:\''.$navigation_parent.'\'}).fadeIn(\'slow\');}"><img src="images/close_nav.png" border=0></a></div></li>';

            }
            echo '</ul>';
            echo '</div>';
    }else{
        echo '<div class="mmpanel-first-level-items">Empty</div>';
    }    
    
    echo '<div class="mmpanel-third-level-items-new"><input type="text" id="new_third_level_item_val" class="mmpanel_inpt_form"><input type="button" onclick="var new_third_level_item_val = $(\'#new_third_level_item_val\').val(); $(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'insert_third_level_item\',  LID:\''.$LID.'\',  id_par:\''.$navigation_parent.'\', new_third_level_item_val: new_third_level_item_val}).fadeIn(\'slow\');" name="btn_insert_new_firstlevel_item" value="Dodaj" class="btn"></div>';
}
if($akcija=='third_level_list_eng'){
    $navigation_parent = $_REQUEST['navigation_id'];
    echo '<div class="mmpanel-third-level-header">3rd level</div>';
    //1st level listing
    $sql_level = "SELECT n.id, n.par, n.title, n.ord, n.link, n.active FROM navigation_eng n WHERE n.par=$navigation_parent ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
     ?>
        <script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#third_level_group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent=<?php echo $navigation_parent; ?>'; 
            $.post("reorder/updateDB_nav3_eng.php", order, function(theResponse){
                //$("#first_level_group_result").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
        <?php
        //echo '<div id="first_level_group_result"></div>';
        echo '<div id="third_level_group">';
        echo '<ul>';
        $i=0;
            while (list($navigation_id, $navigation_par, $navigation_title, $navigation_ord, $navigation_link, $navigation_active)=@mysql_fetch_row($rez_level)) {
                if($navigation_active==1){
            $active_state = 'checked="yes"';    
        }else{
            $active_state = ' ';    
        }
        
                 ?>
   <script>
$(function(){ 
$( "#mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>" ).dialog({
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            buttons: {
                "Izmeni": function() {
                    var item_level_val = $('#item_level_val_eng<?php echo $navigation_id; ?>').val();
                    $('#first_level_list').load('ajax/navigation.php',{akcija: 'update_item_link_eng',  LID:'<?php echo $LID; ?>',  id_item:'<?php echo $navigation_id; ?>', item_level_val: item_level_val}).fadeIn('slow');
                    $(this).dialog("close");
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
                });
$("#item-link_eng<?php echo $navigation_id; ?>").click(function() {
               $("#mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>").dialog("open");
            });


});
</script>
   <div id="mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>" title="Modifikacija linka strane.">
    <p>Izaberite stranicu</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_strane\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";
?>
<p>ili Izaberite aranzman</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_aranzman\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select>";
?>
<p>Link:</p>
<input id="item_level_val_eng<?php echo $navigation_id; ?>" style="width: 270px;" type="text" value="<?php echo $navigation_link; ?>">
</div>
<?php
                    echo '<li id="mmpanel-third-level-items_'.$navigation_id.'" class="mmpanel-third-level-items"><div class="item-title" id="navigation_firstitem_title_val'.$navigation_id.'"><input type="checkbox" '.$active_state.' name="active_'.$navigation_id.'" onclick="$(\'#divAddEdit\').load(\'ajax/navigation.php\',{akcija: \'activate_nav_id_eng\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');" value="1" />&nbsp;&nbsp;<a href="#" title="'.$navigation_title.'" onclick="prikaziLoad_mali(\'third_level_list\'); $(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'third_level_list\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');">'.$navigation_title.'</a></div><div class="item-modify-icons"><a href="#" id="item-link_eng'.$navigation_id.'" title="Link Item"><img src="images/link_nav.png" border=0></a>
<a href="#" title="Rename Item" onclick="$(\'#navigation_firstitem_title_val'.$navigation_id.'\').load(\'ajax/navigation.php\',{akcija: \'rename_first_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');"><img src="images/rename_nav.png" border=0></a><a href="#" title="Delete Item" onclick="pom = proveri(); if(pom){$(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'delete_third_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\',  id_par:\''.$navigation_parent.'\'}).fadeIn(\'slow\');}"><img src="images/close_nav.png" border=0></a></div></li>';

            }
            echo '</ul>';
            echo '</div>';
    }else{
        echo '<div class="mmpanel-first-level-items">Empty</div>';
    }    
    
    echo '<div class="mmpanel-third-level-items-new"><input type="text" id="new_third_level_item_val" class="mmpanel_inpt_form"><input type="button" onclick="var new_third_level_item_val = $(\'#new_third_level_item_val\').val(); $(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'insert_third_level_item_eng\',  LID:\''.$LID.'\',  id_par:\''.$navigation_parent.'\', new_third_level_item_val: new_third_level_item_val}).fadeIn(\'slow\');" name="btn_insert_new_firstlevel_item" value="Dodaj" class="btn"></div>';
}
if($akcija=='second_level_list'){
    $navigation_parent = $_REQUEST['navigation_id'];
    echo '<div class="mmpanel-second-level-header">2nd level</div>';
    //2st level listing
    $sql_level = "SELECT n.id, n.par, n.title, n.ord, n.link, n.active FROM navigation n WHERE n.par=$navigation_parent ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
    ?>
        <script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#second_level_group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent=<?php echo $navigation_parent; ?>'; 
            $.post("reorder/updateDB_nav2.php", order, function(theResponse){
                //$("#first_level_group_result").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
        <?php
        //echo '<div id="first_level_group_result"></div>';
        echo '<div id="second_level_group">';
        echo '<ul>';
        $i=0;
            while (list($navigation_id, $navigation_par, $navigation_title, $navigation_ord, $navigation_link, $navigation_active)=@mysql_fetch_row($rez_level)) {
                if($navigation_active==1){
            $active_state = 'checked="yes"';    
        }else{
            $active_state = ' ';    
        }
        
                 ?>
   <script>
$(function(){ 
$( "#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" ).dialog({
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            buttons: {
                "Izmeni": function() {
                    var item_level_val = $('#item_level_val<?php echo $navigation_id; ?>').val();
                    $('#first_level_list').load('ajax/navigation.php',{akcija: 'update_item_link',  LID:'<?php echo $LID; ?>',  id_item:'<?php echo $navigation_id; ?>', item_level_val: item_level_val}).fadeIn('slow');
                    $(this).dialog("close");
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
                });
$("#item-link<?php echo $navigation_id; ?>").click(function() {
               $("#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>").dialog("open");
            });


});
</script>
   <div id="mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" title="Modifikacija linka strane.">
    <p>Izaberite stranicu</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_strane\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";
?>
<p>ili Izaberite aranzman</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_aranzman\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select>";
?>
<p>Link:</p>
<input id="item_level_val<?php echo $navigation_id; ?>" style="width: 270px;" type="text" value="<?php echo $navigation_link; ?>">
</div>
<?php
                    echo '<li id="mmpanel-second-level-items-id_'.$navigation_id.'" class="mmpanel-second-level-items"><div class="item-title" id="navigation_firstitem_title_val'.$navigation_id.'"><input type="checkbox" '.$active_state.' name="active_'.$navigation_id.'" onclick="$(\'#divAddEdit\').load(\'ajax/navigation.php\',{akcija: \'activate_nav_id\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');" value="1" />&nbsp;&nbsp;<a href="#" title="'.$navigation_title.'" onclick=" $(\'.mmpanel-second-level-items\').removeClass(\'mmpanel-second-level-items-active\').addClass(\'mmpanel-second-level-items\'); $(\'#mmpanel-second-level-items-id_'.$navigation_id.'\').addClass(\'mmpanel-second-level-items-active\');prikaziLoad_mali(\'third_level_list\'); $(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'third_level_list\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');">'.$navigation_title.'</a></div><div class="item-modify-icons"><a href="#" id="item-link'.$navigation_id.'" title="Link Item"><img src="images/link_nav.png" border=0></a>
<a href="#" title="Rename Item" onclick="$(\'#navigation_firstitem_title_val'.$navigation_id.'\').load(\'ajax/navigation.php\',{akcija: \'rename_first_level_item\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');"><img src="images/rename_nav.png" border=0></a><a href="#" title="Delete Item" onclick="pom = proveri(); if(pom){$(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'delete_second_level_item\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\',  id_par:\''.$navigation_parent.'\'}).fadeIn(\'slow\');}"><img src="images/close_nav.png" border=0></a></div></li>';

            }
            echo '</ul>';
            echo '</div>';
    }else{
        echo '<div class="mmpanel-second-level-items">Empty</div>';
    }    
    
    echo '<div class="mmpanel-second-level-items-new"><input type="text" id="new_second_level_item_val" class="mmpanel_inpt_form"><input type="button" onclick="var new_second_level_item_val = $(\'#new_second_level_item_val\').val(); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'insert_second_level_item\',  LID:\''.$LID.'\',  id_par:\''.$navigation_parent.'\', new_second_level_item_val: new_second_level_item_val}).fadeIn(\'slow\');" name="btn_insert_new_firstlevel_item" value="Dodaj" class="btn"></div>';
}

if($akcija=='second_level_list_eng'){
    $navigation_parent = $_REQUEST['navigation_id'];
    echo '<div class="mmpanel-second-level-header">2nd level</div>';
    //2st level listing
    $sql_level = "SELECT n.id, n.par, n.title, n.ord, n.link, n.active FROM navigation_eng n WHERE n.par=$navigation_parent ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
    ?>
        <script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#second_level_group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent=<?php echo $navigation_parent; ?>'; 
            $.post("reorder/updateDB_nav2_eng.php", order, function(theResponse){
                //$("#first_level_group_result").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
        <?php
        //echo '<div id="first_level_group_result"></div>';
        echo '<div id="second_level_group">';
        echo '<ul>';
        $i=0;
            while (list($navigation_id, $navigation_par, $navigation_title, $navigation_ord, $navigation_link, $navigation_active)=@mysql_fetch_row($rez_level)) {
                if($navigation_active==1){
            $active_state = 'checked="yes"';    
        }else{
            $active_state = ' ';    
        }
        
                 ?>
   <script>
$(function(){ 
$( "#mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>" ).dialog({
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            buttons: {
                "Izmeni": function() {
                    var item_level_val = $('#item_level_val_eng<?php echo $navigation_id; ?>').val();
                    $('#first_level_list').load('ajax/navigation.php',{akcija: 'update_item_link_eng',  LID:'<?php echo $LID; ?>',  id_item:'<?php echo $navigation_id; ?>', item_level_val: item_level_val}).fadeIn('slow');
                    $(this).dialog("close");
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
                });
$("#item-link_eng<?php echo $navigation_id; ?>").click(function() {
               $("#mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>").dialog("open");
            });


});
</script>
   <div id="mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>" title="Modifikacija linka strane.">
    <p>Izaberite stranicu</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_strane\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";
?>
<p>ili Izaberite aranzman</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_aranzman\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select>";
?>
<p>Link:</p>
<input id="item_level_val_eng<?php echo $navigation_id; ?>" style="width: 270px;" type="text" value="<?php echo $navigation_link; ?>">
</div>
<?php
                    echo '<li id="mmpanel-second-level-items-id_'.$navigation_id.'" class="mmpanel-second-level-items"><div class="item-title" id="navigation_firstitem_title_val'.$navigation_id.'"><input type="checkbox" '.$active_state.' name="active_'.$navigation_id.'" onclick="$(\'#divAddEdit\').load(\'ajax/navigation.php\',{akcija: \'activate_nav_id_eng\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');" value="1" />&nbsp;&nbsp;<a href="#" title="'.$navigation_title.'" onclick=" $(\'.mmpanel-second-level-items\').removeClass(\'mmpanel-second-level-items-active\').addClass(\'mmpanel-second-level-items\'); $(\'#mmpanel-second-level-items-id_'.$navigation_id.'\').addClass(\'mmpanel-second-level-items-active\');prikaziLoad_mali(\'third_level_list\'); $(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'third_level_list_eng\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');">'.$navigation_title.'</a></div><div class="item-modify-icons"><a href="#" id="item-link_eng'.$navigation_id.'" title="Link Item"><img src="images/link_nav.png" border=0></a>
<a href="#" title="Rename Item" onclick="$(\'#navigation_firstitem_title_val'.$navigation_id.'\').load(\'ajax/navigation.php\',{akcija: \'rename_first_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');"><img src="images/rename_nav.png" border=0></a><a href="#" title="Delete Item" onclick="pom = proveri(); if(pom){$(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'delete_second_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\',  id_par:\''.$navigation_parent.'\'}).fadeIn(\'slow\');}"><img src="images/close_nav.png" border=0></a></div></li>';

            }
            echo '</ul>';
            echo '</div>';
    }else{
        echo '<div class="mmpanel-second-level-items">Empty</div>';
    }    
    
    echo '<div class="mmpanel-second-level-items-new"><input type="text" id="new_second_level_item_val" class="mmpanel_inpt_form"><input type="button" onclick="var new_second_level_item_val = $(\'#new_second_level_item_val\').val(); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'insert_second_level_item_eng\',  LID:\''.$LID.'\',  id_par:\''.$navigation_parent.'\', new_second_level_item_val: new_second_level_item_val}).fadeIn(\'slow\');" name="btn_insert_new_firstlevel_item" value="Dodaj" class="btn"></div>';
}
if($akcija=='update_rename_item_eng1'){
    $navigation_parent = $_REQUEST['navigation_id'];
    echo '<div class="mmpanel-second-level-header">2nd level</div>';
    //2st level listing
    $sql_level = "SELECT n.id, n.par, n.title, n.ord, n.link, n.active FROM navigation_eng n WHERE n.par=$navigation_parent ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
    ?>
        <script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#second_level_group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent=<?php echo $navigation_parent; ?>'; 
            $.post("reorder/updateDB_nav2.php", order, function(theResponse){
                //$("#first_level_group_result").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
        <?php
        //echo '<div id="first_level_group_result"></div>';
        echo '<div id="second_level_group">';
        echo '<ul>';
        $i=0;
            while (list($navigation_id, $navigation_par, $navigation_title, $navigation_ord, $navigation_link, $navigation_active)=@mysql_fetch_row($rez_level)) {
                if($navigation_active==1){
            $active_state = 'checked="yes"';    
        }else{
            $active_state = ' ';    
        }
        
                 ?>
   <script>
$(function(){ 
$( "#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" ).dialog({
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            buttons: {
                "Izmeni": function() {
                    var item_level_val = $('#item_level_val<?php echo $navigation_id; ?>').val();
                    $('#first_level_list').load('ajax/navigation.php',{akcija: 'update_item_link_eng',  LID:'<?php echo $LID; ?>',  id_item:'<?php echo $navigation_id; ?>', item_level_val: item_level_val}).fadeIn('slow');
                    $(this).dialog("close");
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
                });
$("#item-link<?php echo $navigation_id; ?>").click(function() {
               $("#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>").dialog("open");
            });


});
</script>
   <div id="mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" title="Modifikacija linka strane.">
    <p>Izaberite stranicu</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_strane\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";
?>
<p>ili Izaberite aranzman</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_aranzman\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select>";
?>
<p>Link:</p>
<input id="item_level_val<?php echo $navigation_id; ?>" style="width: 270px;" type="text" value="<?php echo $navigation_link; ?>">
</div>
<?php
                    echo '<li id="mmpanel-second-level-items-id_'.$navigation_id.'" class="mmpanel-second-level-items"><div class="item-title" id="navigation_firstitem_title_val'.$navigation_id.'"><input type="checkbox" '.$active_state.' name="active_'.$navigation_id.'" onclick="$(\'#divAddEdit\').load(\'ajax/navigation.php\',{akcija: \'activate_nav_id_eng\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');" value="1" />&nbsp;&nbsp;<a href="#" title="'.$navigation_title.'" onclick=" $(\'.mmpanel-second-level-items\').removeClass(\'mmpanel-second-level-items-active\').addClass(\'mmpanel-second-level-items\'); $(\'#mmpanel-second-level-items-id_'.$navigation_id.'\').addClass(\'mmpanel-second-level-items-active\');prikaziLoad_mali(\'third_level_list\'); $(\'#third_level_list\').load(\'ajax/navigation.php\',{akcija: \'third_level_list_eng\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');">'.$navigation_title.'</a></div><div class="item-modify-icons"><a href="#" id="item-link'.$navigation_id.'" title="Link Item"><img src="images/link_nav.png" border=0></a>
<a href="#" title="Rename Item" onclick="$(\'#navigation_firstitem_title_val'.$navigation_id.'\').load(\'ajax/navigation.php\',{akcija: \'rename_first_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');"><img src="images/rename_nav.png" border=0></a><a href="#" title="Delete Item" onclick="pom = proveri(); if(pom){$(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'delete_second_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\',  id_par:\''.$navigation_parent.'\'}).fadeIn(\'slow\');}"><img src="images/close_nav.png" border=0></a></div></li>';

            }
            echo '</ul>';
            echo '</div>';
    }else{
        echo '<div class="mmpanel-second-level-items">Empty</div>';
    }    
    
    echo '<div class="mmpanel-second-level-items-new"><input type="text" id="new_second_level_item_val" class="mmpanel_inpt_form"><input type="button" onclick="var new_second_level_item_val = $(\'#new_second_level_item_val\').val(); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'insert_second_level_item\',  LID:\''.$LID.'\',  id_par:\''.$navigation_parent.'\', new_second_level_item_val: new_second_level_item_val}).fadeIn(\'slow\');" name="btn_insert_new_firstlevel_item" value="Dodaj" class="btn"></div>';
}

if($akcija=='update_item_link'){
   $item_level_val = $_REQUEST['item_level_val'];
   $id_item = $_REQUEST['id_item'];
   $sql_modify = "UPDATE navigation SET link='$item_level_val' WHERE id='$id_item' ";
   $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }    
$akcija='first_level_list';
}

if($akcija=='update_item_link_eng'){
   $item_level_val = $_REQUEST['item_level_val'];
   $id_item = $_REQUEST['id_item'];
   $sql_modify = "UPDATE navigation_eng SET link='$item_level_val' WHERE id='$id_item' ";
   $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }    
$akcija='first_level_list_eng';
}

if($akcija=='rename_first_level_item'){
   
   $first_level_item_id = $_REQUEST['first_level_item_id'];
    ?>
    <script type="text/javascript">
                        $(document).ready(function(){
                           var  text_rename_item = $('#rename_item_val');
                            var code =null;
                            text_rename_item.keypress(function(e)
                            {
                                code= (e.keyCode ? e.keyCode : e.which);
                                if (code == 13)
                                {
                                        var text_rename_item = $('#rename_item_val').val();
                                        var id_item = '<?php echo $first_level_item_id; ?>';
                                        $('#navigation_firstitem_title_val<?php echo $first_level_item_id; ?>').load('ajax/navigation.php',{akcija: 'update_rename_item',  LID:'<?php echo $LID; ?>',  text_rename_item: text_rename_item,  id_item: id_item}).fadeIn('slow');
                                }else{
                                    
                                }
                               // e.preventDefault();
                            });

                        });
    </script>
    <?php
    $sql_level = "SELECT n.title FROM navigation n WHERE n.id=$first_level_item_id ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
            list($navigation_title)=@mysql_fetch_row($rez_level);
    echo '<input type="text" id="rename_item_val" class="mmpanel_inpt_form" value="'.$navigation_title.'">';
    }    

}
if($akcija=='rename_first_level_item_eng'){
   
   $first_level_item_id = $_REQUEST['first_level_item_id'];
    ?>
    <script type="text/javascript">
                        $(document).ready(function(){
                           var  text_rename_item = $('#rename_item_val');
                            var code =null;
                            text_rename_item.keypress(function(e)
                            {
                                code= (e.keyCode ? e.keyCode : e.which);
                                if (code == 13)
                                {
                                        var text_rename_item = $('#rename_item_val').val();
                                        var id_item = '<?php echo $first_level_item_id; ?>';
                                        $('#navigation_firstitem_title_val<?php echo $first_level_item_id; ?>').load('ajax/navigation.php',{akcija: 'update_rename_item_eng',  LID:'<?php echo $LID; ?>',  text_rename_item: text_rename_item,  id_item: id_item}).fadeIn('slow');
                                }else{
                                    
                                }
                               // e.preventDefault();
                            });

                        });
    </script>
    <?php
    $sql_level = "SELECT n.title FROM navigation_eng n WHERE n.id=$first_level_item_id ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
            list($navigation_title)=@mysql_fetch_row($rez_level);
    echo '<input type="text" id="rename_item_val" class="mmpanel_inpt_form" value="'.$navigation_title.'">';
    }    

}

if($akcija=='update_rename_item'){
    $text_rename_item = $_REQUEST['text_rename_item'];
    $id_item = $_REQUEST['id_item'];
    $sql_modify = "UPDATE navigation SET title='$text_rename_item' WHERE id='$id_item' ";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
    echo '<a href="#" title="'.$navigation_title.'" onclick="prikaziLoad_mali(\'second_level_list\'); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'second_level_list\',  LID:\''.$LID.'\', navigation_id:\''.$id_item.'\'}).fadeIn(\'slow\');">'.$text_rename_item.'</a>';
}

if($akcija=='update_rename_item_eng'){
    $text_rename_item = $_REQUEST['text_rename_item'];
    $id_item = $_REQUEST['id_item'];
    $sql_modify = "UPDATE navigation_eng SET title='$text_rename_item' WHERE id='$id_item' ";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
    echo '<a href="#" title="'.$navigation_title.'" onclick="prikaziLoad_mali(\'second_level_list\'); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'second_level_list_eng\',  LID:\''.$LID.'\', navigation_id:\''.$id_item.'\'}).fadeIn(\'slow\');">'.$text_rename_item.'</a>';
}

if($akcija=='rename_first_level_item_eng'){
    $text_rename_item = $_REQUEST['text_rename_item'];
    $id_item = $_REQUEST['id_item'];
    $sql_modify = "UPDATE navigation_eng SET title='$text_rename_item' WHERE id='$id_item' ";
     $rez_modify = mysql_query($sql_modify);
        if (!$rez_modify) {
            die('Greska: '.$sql_modify.' '. mysql_error());
                                 }   
    echo '<a href="#" title="'.$navigation_title.'" onclick="prikaziLoad_mali(\'second_level_list\'); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'second_level_list_eng\',  LID:\''.$LID.'\', navigation_id:\''.$id_item.'\'}).fadeIn(\'slow\');">'.$text_rename_item.'</a>';
}
if($akcija=='first_level_list'){
    echo '<div class="mmpanel-first-level-header">1st level</div>';
    //1st level listing
    $sql_level = "SELECT n.id, n.par, n.title, n.link, n.ord, n.active FROM navigation n WHERE n.par=0 ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
        ?>
        <script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#first_level_group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent=0'; 
            $.post("reorder/updateDB_nav.php", order, function(theResponse){
                //$("#first_level_group_result").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
        <?php
        //echo '<div id="first_level_group_result"></div>';
        echo '<div id="first_level_group">';
        echo '<ul>';
        $i=0;
    while (list($navigation_id, $navigation_par, $navigation_title, $navigation_link, $navigation_ord, $navigation_active)=@mysql_fetch_row($rez_level)) { 
        if($navigation_active==1){
            $active_state = 'checked="yes"';    
        }else{
            $active_state = ' ';    
        }
        
                ?>
   <script>
$(function(){ 
$( "#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" ).dialog({
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            buttons: {
                "Izmeni": function() {
                    var item_level_val = $('#item_level_val<?php echo $navigation_id; ?>').val();
                    $('#first_level_list').load('ajax/navigation.php',{akcija: 'update_item_link',  LID:'<?php echo $LID; ?>',  id_item:'<?php echo $navigation_id; ?>', item_level_val: item_level_val}).fadeIn('slow');
                    $(this).dialog("close");
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
                });
$("#item-link<?php echo $navigation_id; ?>").click(function() {
               $("#mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>").dialog("open");
            });


});
</script>
   <div id="mmpanel-link-dialog-confirm<?php echo $navigation_id; ?>" title="Modifikacija linka strane.">
    <p>Izaberite stranicu</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_strane\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";
?>
<p>ili Izaberite aranzman</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_aranzman\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select>";
?>
<p>Link:</p>
<input id="item_level_val<?php echo $navigation_id; ?>" style="width: 270px;" type="text" value="<?php echo $navigation_link; ?>">
</div>
<?php
                    echo '<li id="mmpanel-first-level-items-id_'.$navigation_id.'" class="mmpanel-first-level-items"><div class="item-title" id="navigation_firstitem_title_val'.$navigation_id.'"><input type="checkbox" '.$active_state.' name="active_'.$navigation_id.'" onclick="$(\'#divAddEdit\').load(\'ajax/navigation.php\',{akcija: \'activate_nav_id\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');" value="1" />&nbsp;&nbsp;<a href="#" title="'.$navigation_title.'" onclick=" $(\'.mmpanel-first-level-items\').removeClass(\'mmpanel-first-level-items-active\').addClass(\'mmpanel-first-level-items\'); $(\'#mmpanel-first-level-items-id_'.$navigation_id.'\').addClass(\'mmpanel-first-level-items-active\'); prikaziLoad_mali(\'second_level_list\'); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'second_level_list\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');">'.$navigation_title.'</a></div><div class="item-modify-icons"><a href="#" id="item-link'.$navigation_id.'" title="Link Item"><img src="images/link_nav.png" border=0></a>
<a href="#" title="Rename Item" onclick="$(\'#navigation_firstitem_title_val'.$navigation_id.'\').load(\'ajax/navigation.php\',{akcija: \'rename_first_level_item\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');"><img src="images/rename_nav.png" border=0></a><a href="#" title="Delete Item" onclick="pom = proveri(); if(pom){$(\'#first_level_list\').load(\'ajax/navigation.php\',{akcija: \'delete_first_level_item\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');}"><img src="images/close_nav.png" border=0></a></div></li>';

            }
            echo '</ul>';
            echo '</div>';
    }else{
        echo '<div class="mmpanel-first-level-items">Empty</div>';
    }    
    
    echo '<div class="mmpanel-first-level-items-new"><input type="text" id="new_first_level_item_val" class="mmpanel_inpt_form"><input type="button" onclick="var new_first_level_item_val = $(\'#new_first_level_item_val\').val(); $(\'#first_level_list\').load(\'ajax/navigation.php\',{akcija: \'insert_first_level_item\',  LID:\''.$LID.'\', new_first_level_item_val: new_first_level_item_val}).fadeIn(\'slow\');" name="btn_insert_new_firstlevel_item" value="Dodaj" class="btn"></div>';
}

if($akcija=='first_level_list_eng'){
    echo '<div class="mmpanel-first-level-header">1st level</div>';
    //1st level listing
    $sql_level = "SELECT n.id, n.par, n.title, n.link, n.ord, n.active FROM navigation_eng n WHERE n.par=0 ORDER BY n.ord";
    $rez_level = mysql_query($sql_level);
    if(mysql_num_rows($rez_level)>0){
        ?>
        <script type="text/javascript">
$(document).ready(function(){ 
                           
    $(function() {
        $("#first_level_group ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize") + '&action=updateRecordsListings&parent=0'; 
            $.post("reorder/updateDB_nav_eng.php", order, function(theResponse){
                //$("#first_level_group_result").html(theResponse);
            });                                                              
        }                                  
        });
    });

});    
</script>
        <?php
        //echo '<div id="first_level_group_result"></div>';
        echo '<div id="first_level_group">';
        echo '<ul>';
        $i=0;
    while (list($navigation_id, $navigation_par, $navigation_title, $navigation_link, $navigation_ord, $navigation_active)=@mysql_fetch_row($rez_level)) { 
        if($navigation_active==1){
            $active_state = 'checked="yes"';    
        }else{
            $active_state = ' ';    
        }
        
                ?>
   <script>
$(function(){ 
$( "#mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>" ).dialog({
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            buttons: {
                "Izmeni": function() {
                    var item_level_val = $('#item_level_val_eng<?php echo $navigation_id; ?>').val();
                    $('#first_level_list').load('ajax/navigation.php',{akcija: 'update_item_link_eng',  LID:'<?php echo $LID; ?>',  id_item:'<?php echo $navigation_id; ?>', item_level_val: item_level_val}).fadeIn('slow');
                    $(this).dialog("close");
                },
                "Odustani": function() {
                    $( this ).dialog( "close" );
                }
            }
                });
$("#item-link_eng<?php echo $navigation_id; ?>").click(function() {
               $("#mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>").dialog("open");
            });


});
</script>
   <div id="mmpanel-link-dialog-confirm_eng<?php echo $navigation_id; ?>" title="Modifikacija linka strane.">
    <p>Izaberite stranicu</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_strane\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select></td></tr>";
?>
<p>ili Izaberite aranzman</p>
<?php
    echo "<select class=\"izaberi\" id=\"id_aranzman\">";
                     
    $sql_generate = "SELECT id_strane, naslov FROM t_strane WHERE id_templata=2 ORDER BY naslov ASC";
    $rez_generate = mysql_query($sql_generate);
    if(mysql_num_rows($rez_generate)>0){
    while (list($id_grupe, $naziv_grupe)=@mysql_fetch_row($rez_generate)) {
        if($id_grupe==$aranzman_kategorija){$chk='selected';}else{$chk='';}
       echo "<option value=\"$id_grupe\" $chk>$naziv_grupe</option>";
    }
    }
    echo "</select>";
?>
<p>Link:</p>
<input id="item_level_val_eng<?php echo $navigation_id; ?>" style="width: 270px;" type="text" value="<?php echo $navigation_link; ?>">
</div>
<?php
                    echo '<li id="mmpanel-first-level-items-id_'.$navigation_id.'" class="mmpanel-first-level-items"><div class="item-title" id="navigation_firstitem_title_val'.$navigation_id.'"><input type="checkbox" '.$active_state.' name="active_'.$navigation_id.'" onclick="$(\'#divAddEdit\').load(\'ajax/navigation.php\',{akcija: \'activate_nav_id_eng\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');" value="1" />&nbsp;&nbsp;<a href="#" title="'.$navigation_title.'" onclick=" $(\'.mmpanel-first-level-items\').removeClass(\'mmpanel-first-level-items-active\').addClass(\'mmpanel-first-level-items\'); $(\'#mmpanel-first-level-items-id_'.$navigation_id.'\').addClass(\'mmpanel-first-level-items-active\'); prikaziLoad_mali(\'second_level_list\'); $(\'#second_level_list\').load(\'ajax/navigation.php\',{akcija: \'second_level_list_eng\',  LID:\''.$LID.'\', navigation_id:\''.$navigation_id.'\'}).fadeIn(\'slow\');">'.$navigation_title.'</a></div><div class="item-modify-icons"><a href="#" id="item-link_eng'.$navigation_id.'" title="Link Item"><img src="images/link_nav.png" border=0></a>
<a href="#" title="Rename Item" onclick="$(\'#navigation_firstitem_title_val'.$navigation_id.'\').load(\'ajax/navigation.php\',{akcija: \'rename_first_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');"><img src="images/rename_nav.png" border=0></a><a href="#" title="Delete Item" onclick="pom = proveri(); if(pom){$(\'#first_level_list\').load(\'ajax/navigation.php\',{akcija: \'delete_first_level_item_eng\',  LID:\''.$LID.'\', first_level_item_id: \''.$navigation_id.'\'}).fadeIn(\'slow\');}"><img src="images/close_nav.png" border=0></a></div></li>';

            }
            echo '</ul>';
            echo '</div>';
    }else{
        echo '<div class="mmpanel-first-level-items">Empty</div>';
    }    
    
    echo '<div class="mmpanel-first-level-items-new"><input type="text" id="new_first_level_item_val" class="mmpanel_inpt_form"><input type="button" onclick="var new_first_level_item_val = $(\'#new_first_level_item_val\').val(); $(\'#first_level_list\').load(\'ajax/navigation.php\',{akcija: \'insert_first_level_item_eng\',  LID:\''.$LID.'\', new_first_level_item_val: new_first_level_item_val}).fadeIn(\'slow\');" name="btn_insert_new_firstlevel_item" value="Dodaj" class="btn"></div>';
}

if($akcija=='navigation_list'){
    echo '<script>prikaziLoad_mali(\'first_level_list\'); $(\'#first_level_list\').load(\'ajax/navigation.php\',{akcija: \'first_level_list\',  LID:\''.$LID.'\'}).fadeIn(\'slow\');</script>';
    echo '<div class="mmpanel-navigation-list">';
    
    //1st level
    echo '<div id="first_level_list" class="mmpanel-navigation-first-level">';  
    
    
    echo '</div>';
    
    //2nd level
    echo '<div id="second_level_list" class="mmpanel-navigation-second-level">';
    
    
 //   echo '<div class="mmpanel-second-level-header">2nd level</div>';
    //echo '<div class="mmpanel-second-level-items">stavka 1</div>';
    
    echo '</div>';
    
    //3rd level
    echo '<div id="third_level_list" class="mmpanel-navigation-third-level">';
    
    
 //   echo '<div class="mmpanel-third-level-header">3rd level</div>';
    //echo '<div class="mmpanel-third-level-items">stavka 1</div>';
    //echo '<div>stavka 2</div>';
    
    echo '</div>';
    
    echo '</div>';
}
if($akcija=='navigation_list_eng'){
    echo '<script>prikaziLoad_mali(\'first_level_list\'); $(\'#first_level_list\').load(\'ajax/navigation.php\',{akcija: \'first_level_list_eng\',  LID:\''.$LID.'\'}).fadeIn(\'slow\');</script>';
    echo '<div class="mmpanel-navigation-list">';
    
    //1st level
    echo '<div id="first_level_list" class="mmpanel-navigation-first-level">';  
    
    
    echo '</div>';
    
    //2nd level
    echo '<div id="second_level_list" class="mmpanel-navigation-second-level">';
    
    
 //   echo '<div class="mmpanel-second-level-header">2nd level</div>';
    //echo '<div class="mmpanel-second-level-items">stavka 1</div>';
    
    echo '</div>';
    
    //3rd level
    echo '<div id="third_level_list" class="mmpanel-navigation-third-level">';
    
    
 //   echo '<div class="mmpanel-third-level-header">3rd level</div>';
    //echo '<div class="mmpanel-third-level-items">stavka 1</div>';
    //echo '<div>stavka 2</div>';
    
    echo '</div>';
    
    echo '</div>';
}

?>

