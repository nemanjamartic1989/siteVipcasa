<?php

ob_start();

include "./baza_heder.php";


// Define $myusername and $mypassword 
$email=$_POST['email']; 
$password=$_POST['password'];

// To protect MySQL injection (more detail about MySQL injection)
 $email = stripslashes($email);
//$password = stripslashes($password);
//echo $email = mysql_real_escape_string($email);
//$password = mysql_real_escape_string($password);

$sql="SELECT id_komitenta, lozinka FROM t_komitenti WHERE e_mail='$email' AND tip=1 AND aktivan=1";

$result=mysql_query($sql);
if (!$result) {
            die('Greska: '.$sql.' '. mysql_error());
        }  
// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){

    while ($redak=mysql_fetch_array($result))
    {
    $pass_db = $redak['lozinka'];
    $id_komitenta = $redak['id_komitenta'];
    $password = md5($password); 
        
        if ($password == $pass_db) {
               
             // Register $myusername, $mypassword and redirect to file "pocetna.php"
             session_register("snizeno_user_email");
             session_register("id_komitenta");
             //session_register("password"); 
             $_SESSION['snizeno_user_email']=$email;
             $_SESSION['id_komitenta']=$id_komitenta;
            
            
            
                setcookie("snizeno_user_email", $email, time()+604800);
            
            
            //echo "<script>window.location = 'http://mljacmljac.hr/$grad/'</script>";
            echo "<script>window.location = '/index.php'</script>";
            //echo "USPEO";

        }
        else {
            //echo "<script>window.location = '../../../html/admin/login_n.php'</script>";
            echo "<script>alert(\"Pogresna kombinacija email/lozinka.Proverite unos i pokusajte ponovo!\");</script>";
            echo "<script>window.location = '/index.php?poruka=error1'</script>";
        }

    }

}else {
    //header('Refresh:2 ; URL=../admin/index.html');
    echo "<script>alert(\"Pogresna kombinacija email/lozinka.Proverite unos i pokusajte ponovo!\");</script>";
    echo "<script>window.location = '/index.php?poruka=error2'</script>";

}

//ob_end_flush();

?>