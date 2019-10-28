<?php

ob_start();

include "./baza_heder.php";


$email = htmlspecialchars(strip_tags($_POST['e_mail']));    


if($email){

    $naziv = htmlspecialchars(strip_tags($_POST['naziv']));    
    $lozinka = htmlspecialchars(strip_tags($_POST['lozinka']));    
    $lozinka_cista = $lozinka;
    $lozinka = md5($lozinka); 
    $email = htmlspecialchars(strip_tags($_POST['e_mail']));    
    $telefoni = htmlspecialchars(strip_tags($_POST['telefoni']));            
    $newsletter = htmlspecialchars(strip_tags($_POST['newsletter']));            
    
    //NEWSLETTER
     if($newsletter==1){
        $sql_email = "SELECT email FROM t_newsletter WHERE email = '".$email."' ";
    $rez_email = mysql_query($sql_email);
    if(mysql_num_rows($rez_email)<1){
        
         $sql_akcija = "INSERT INTO t_newsletter (email, aktivan) VALUES ('".$email."', 1) ";
         $rez_akcija = mysql_query($sql_akcija);}
      }        
      
    //NEWSLETTER KRAJ
    
    //UBACIVANJE U BAZU
    //generisem sifru komitenta:
    $sifra = "";
//echo "<br> $sql2 <br>";

   $a[1]="a"; $a[2]="b"; $a[3]="c"; $a[4]="d"; $a[5]="e"; $a[6]="f"; $a[7]="g"; $a[8]="h"; $a[9]="i"; $a[10]="j"; $a[11]="k"; $a[12]="l"; $a[13]="m"; $a[14]="n"; $a[15]="o"; $a[16]="p"; $a[17]="q"; $a[18]="r"; $a[19]="s"; $a[20]="t"; $a[21]="u"; $a[22]="v"; $a[23]="w"; $a[24]="x"; $a[25]="y"; $a[26]="z"; $a[27]="0"; $a[28]="1"; $a[29]="2"; $a[30]="3"; $a[31]="4"; $a[32]="5"; $a[33]="6"; $a[34]="7"; $a[35]="8"; $a[36]="9"; 
   
   $sifra = date('ymdhis'); //timestamp
   
   for($i=1; $i<=3 ; $i++){
   $sifra .= $a[rand(1,35)];
   }
   
   //unosim tog komitenta u t_komitenti
   $sqlIn = "INSERT INTO t_komitenti (sifra_komitenta, naziv, lozinka, e_mail, telefoni, vreme_izmene, aktivan, tip ) VALUES ('".$sifra."', '".$naziv."', '".$lozinka."', '".$email."', '".$telefoni."', '".time()."', '1', 1)";
   $rezIn = mysql_query($sqlIn);
   $id_komitenta = mysql_insert_id($db);
    
    //UBACIVANJE KRAJ
    
    // Register $myusername, $mypassword and redirect to file "pocetna.php"
    session_register("snizeno_user_email");
    session_register("id_komitenta");
    //session_register("password"); 
    $_SESSION['snizeno_user_email']=$email;
    $_SESSION['id_komitenta']=$id_komitenta;
    
    
    setcookie("snizeno_user_email", $email, time()+604800);
    setcookie("id_komitenta", $id_komitenta, time()+604800);
    //ob_end_flush();
            
            
            //echo "<script>window.location = 'http://mljacmljac.hr/$grad/'</script>";
            echo "<script>window.location = '/index.php'</script>";
            //echo "USPEO";

        }
        else {
            //echo "<script>window.location = '../../../html/admin/login_n.php'</script>";
            echo "<script>alert(\"Dogodila se greska prilikom registracije.Proverite unos i pokusajte ponovo!\");</script>";
            echo "<script>window.location = '/index.php?poruka=error1'</script>";
        }

    

ob_end_flush();

?>