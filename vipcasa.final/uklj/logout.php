<?php
$email = $_GET['logout']; 
$email = stripslashes($email);
/*
if($email){
           echo setcookie("PHPSESSID", "", time() + 3600);
           session_destroy("user_email");
           echo "kuki je:".$_COOKIE["PHPSESSID"];
           print_r($_COOKIE);
            //echo "<script>window.location = 'http://mljacmljac.hr/$grad/'</script>";
            //echo "<script>window.location = '/index.php'</script>";
            //echo "USPEO";

        }
        else {
            //echo "<script>window.location = '../../../html/admin/login_n.php'</script>";
            echo "<script>window.location = '/index.php'</script>";
        }
*/
session_start();
session_destroy();
echo "<script>window.location = 'http://www.snizeno.rs/index.php'</script>";

?>