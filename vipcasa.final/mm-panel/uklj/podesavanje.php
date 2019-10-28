<?php
////////////////////////// parametri podesavanja /////////////

$TIP_ELEMENTA = array("","PAGE (CONTENT)", "BOX", "BANNER", "MENU", "HEADER", "FOOTER");
$JEZICI = array("","Serbian", "English", "Russian");

$KATEGORIJE_VESTI = array("","News", "Breaking news");
$KATEGORIJE_AKCIJA = array("","News 3");

$PUTANJA_DO_WYSIWYG_EDITORA = "/mm-panel/fckeditor/";







//////////////////////// opste funkcije /////////////////
function U_VALUTU($broj){
return number_format($broj,2,',','.');
}

function U_KOLICINU($broj){
return number_format($broj,2,',','');
}

function U_VALUTU_STAMPA($broj){
return number_format($broj,2,',','.');
}

function U_KOLICINU_STAMPA($broj){
return number_format($broj,2,',','');
}


function mysql_prep($value)
    {
        $magic_quotes_active = get_magic_quotes_gpc();
        $new_enough_php = function_exists("mysql_real_escape_string");
        
        if($new_enough_php)
        {
            if($magic_quotes_active)
            {
                $value = mysql_real_escape_string($value);
            }
        }
        else
        {
            if(!$magic_quotes_active)
            {
                $value = addslashes($value);
            }
        }
        return $value;
    }


?>