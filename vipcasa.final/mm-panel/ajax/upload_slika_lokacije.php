<?php
include("../uklj/baza_heder.php");
$id = $_REQUEST['id'];
$uploadedfile = $_FILES['uploadfile']['tmp_name'];

$some_number = rand();
$new_photo_name = 'vipcasa'."-".$some_number.".jpg";    
$src_full = imagecreatefromjpeg($uploadedfile);

list($width,$height)=getimagesize($uploadedfile);

/* NOVA VELICINA SLIKE */
$widthNew = 700;
$heightNew = 490;

$tmp_full=imagecreatetruecolor($widthNew,$heightNew);

imagecopyresampled($tmp_full,$src_full,0,0,0,0,$widthNew,$heightNew,$width,$height);
    
    
    $filename_full = "../../pics/vipcasa/". $new_photo_name;
    
    
    imagejpeg($tmp_full,$filename_full,100);
    
    imagedestroy($src_full);
    imagedestroy($tmp_full);
    $sql_gallery = "UPDATE lokacija SET img='$new_photo_name' WHERE id='$id' ";    
    if($res_gallery = mysql_query($sql_gallery)){
    //echo "Success";
} else {
	echo "Error Uploading Photo. Please Try Again Later.";
}
?>