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
$('#divLista').load('ajax/utils.php',{akcija: 'lista_korisnika',  LID:'<?php echo $LID; ?>',  A_NIVO:'<?php echo $A_NIVO; ?>'}).fadeIn('slow');
});
</script>

<div id="navigacija_dole">
<div id="nav">
<ul id="navmenu-h"> 
                <li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divLista'); $('#divLista').load('ajax/utils.php',{akcija: 'lista_korisnika',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">Users list</a></li>
         <li><a href="#" onClick="$('#divMiddle').html(''); prikaziLoad_mali('divAddEdit'); $('#divAddEdit').load('ajax/utils.php',{akcija: 'nov_korisnik',  LID:'<?php echo $LID; ?>'}).fadeIn('slow');">New user</a></li>
</ul>
        
</div>
</div>
<div style="margin-left: auto; margin-right: auto; margin-top: 10px; width: 900px;" >
<br />
<div id="divAddEdit" name="AddEdit"></div>
<div id="divMiddle" name="divMiddle"></div>
<div id="divLista" name="divLista"></div>
<?php
    if(1==0){
?>
<table border="0" cellspacing="0" cellpadding="2" width="900" align="center" class="okvirchePodNavigacijaCelo">
  <tr>
    <td bgcolor="#919191" style="padding: 10px 5px 10px 30px"> 
<?php
echo "<a class=\"meni\" href=\"./index.php?modul=korisnici&stavka=4&LID=$LID\">Users list</a> &nbsp; | &nbsp; ";
        if($A_NIVO==1 || $A_NIVO==2){
echo "<a class=\"meni\" href=\"./index.php?modul=korisnici&stavka=1&LID=$LID\">New user</a> &nbsp; | &nbsp; ";
echo "<a class=\"meni\" href=\"./index.php?modul=korisnici&stavka=2&LID=$LID\">Edit user</a> &nbsp; | &nbsp; ";
if($A_NIVO==1){
echo "<a class=\"meni\" href=\"./index.php?modul=korisnici&stavka=3&LID=$LID\">Delete user</a> &nbsp; | &nbsp; ";
}
        }
//echo "<br>";
?>
</td><td bgcolor="#919191"  style="padding: 10px 5px 10px 30px" align="right"></td>
  </tr>
</table>
<?php
    }
?>
<?php
if(isset($_GET['stavka']))
{
$stavka = $_GET['stavka'];
if($stavka==1){ //Ubacivanje korisnika (Stavka br.1)
echo "<br>";
#./?modul=korisnici&ubaciK=1&LID=$LID\
echo "<form action=\"index.php?modul=korisnici&LID=$LID\" method=\"POST\">
<table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>
  <tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>New user form:</strong></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">Name and Surname:</td>
    <td class=\"TD_EvenNew\" width=\"250\"><input type=\"text\" name=\"imePrezime\" value=\"\" id=\"imePrezime\" /></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">username:</td>
    <td class=\"TD_EvenNew\"><input type=\"text\" name=\"username\" value=\"\" id=\"username\" /></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">password:</td>
    <td class=\"TD_EvenNew\"><input type=\"text\" name=\"sifra\" value=\"\" id=\"sifra\"/></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">email:</td>
    <td class=\"TD_EvenNew\"><input type=\"text\" name=\"email\" value=\"\" id=\"email\"/></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Privileges:</td>
    <td class=\"TD_EvenNew\"><select name=\"nivo\">
  <option class=\"klasicno\" value =\"1\">Administrator</option>
  <option class=\"klasicno\" value =\"2\">Editor</option>
  <option class=\"klasicno\" value =\"3\">Demo</option>
</select></td>
  </tr>
  <tr>
    <td class=\"TD_EvenNew\"></td>
    <td class=\"TD_EvenNew\"><input type=\"submit\" name=\"Submit\" value=\"Submit\" /></td>
  </tr>
</table>
</form>";
}
}
if($stavka==2)
{
    $query3 = "SELECT ime_prezime FROM t_korisnici";
    $result = mysql_query($query3) or die(mysql_error());;
    $options=" ";
    echo "<br>";
    echo "<table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>";
    echo "<tr>
    <td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Edit user form:</strong></td>
  </tr>";
    echo "<tr>";
    echo "<form action=\"index.php?modul=korisnici&stavka=2&LID=$LID\" method=\"POST\">";
    echo "<td width=\"180\" class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >";
    echo "<select name=\"korisniciE\">";
    while ($row=mysql_fetch_array($result)) 
    {
        $ime=$row["ime_prezime"];
        echo "<OPTION VALUE=\"$ime\">".$ime."</option>";
    }
    echo "</select></td>";
    echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" ><input style=\"height: 20px; width: 100px\" type=\"submit\" name=\"Edit\" value=\"Edit\"/></td>";
    echo "</form>";
    echo "</tr>";
    echo "</table>";
}

if($stavka==3)
{    
    $query3 = "SELECT ime_prezime FROM t_korisnici";
    $result = mysql_query($query3) or die(mysql_error());;
    $options=" ";
    echo "<br>";
    echo "<table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>";
    echo "<tr>";
    echo "<td class=\"TD_OddRed\" colspan=\"2\" style=\"padding: 10px 5px 10px 10px\"><strong>Delete user:</strong></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<form action=\"index.php?modul=korisnici&LID=$LID\" method=\"POST\">";
    echo "<td width=\"180\" class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" >";
    echo "<select name=\"korisnici\">";
    while ($row=mysql_fetch_array($result)) 
    {
        $ime=$row["ime_prezime"];
        echo "<OPTION VALUE=\"$ime\">".$ime."</option>";
    }
    echo "</select></td>";
    echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\" ><input style=\"height: 20px; width: 100px\" class=\"input\" type=\"submit\" name=\"Obrisi\" value=\"Delete\"/></td>";
    echo "</form>";
    echo "</tr>";
    echo "</table>";
}

if($stavka==4)
{
    $query3 = "SELECT * FROM t_korisnici";
    $result = mysql_query($query3) or die(mysql_error());;
    $options=" ";
    echo "<br>";
    echo "<table class=\"okvirche\" width=\"900\" border=\"0\" align=\"center\" cellspacing=0><tr>
    <td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>ID:</strong></td><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>Name and Surname:</strong></td><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>username:</strong></td><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>e-mail:</strong></td><td class=\"TD_OddRed\" style=\"padding: 10px 5px 10px 10px\"><strong>level:</strong></td></tr>";
    
    while ($row=mysql_fetch_array($result)) 
    {
        $id=$row['id_korisnika'];
        $ime_prezime=$row['ime_prezime'];
        $korisnik=$row['korisnik'];
        //$lozinka=$row['lozinka'];
        $email=$row['email'];
        $nivo=$row['admin_nivo'];
       echo "<tr><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">$id</td>
    <td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">$ime_prezime</td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">$korisnik</td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">$email</td><td class=\"TD_EvenNew\" width=\"250\" style=\"padding: 10px 5px 10px 10px\">$nivo</td></tr>";
    
    }
    echo "</table>";
}
//Ubacivanje korisnika
if(isset($_POST['Submit']))
{
    $ImePrezime = $_POST['imePrezime'];
    $username = $_POST['username'];
    $password = $_POST['sifra'];
    $email = $_POST['email'];
    $adminNivo = $_POST['nivo'];
    echo "<br>";
    if(empty($ImePrezime))
    {
        $problem = "Please enter first name and surname.";
    }elseif(empty($username))
    {
        $problem = "Please enter username";
    }elseif(empty($password))
    {
        $problem = "Please enter password";
    }else
    {
    $insert = "INSERT INTO t_korisnici (korisnik,lozinka,ime_prezime,email,admin_nivo) VALUES ('".$username."', '".$password."', '".$ImePrezime."','".$email."', '".$adminNivo."')";
    $izvrsavanje = mysql_query($insert);
    echo "<p align=\"center\"><font class=\"slovau\">New user created</font></p>";
    }

}
echo "<p><font class=\"slovau\">".$problem."</font></p>";

if(isset($_POST['Obrisi']))
{
    $korisnik = $_POST['korisnici'];
    $delete = "DELETE FROM t_korisnici WHERE ime_prezime='".$korisnik."'";
    $izvrsavanje = mysql_query($delete);
    //echo $korisnik;
    echo "<p align=\"center\"><font class=\"slovau\">User deleted.</font></p>";
}

if(isset($_POST['Edit']))
{
    $korisnik = $_POST['korisniciE'];
    
    //echo $korisnik;
    //echo "<font class=\"slovau\">EDITOVANJE</font>";
    echo "<form action=\"index.php?modul=korisnici&LID=$LID\" method=\"POST\">
          <table class=\"okvirche\" width=\"500\" border=\"0\" align=\"center\" cellspacing=0>";
    $upitKorisnika = "SELECT * FROM t_korisnici WHERE ime_prezime='{$korisnik}'";
    $ispisKorisnika = mysql_query($upitKorisnika);
    if($ispisKorisnika)
    {
    while ($kor = mysql_fetch_array($ispisKorisnika)) 
    {
        echo "<tr>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">User:</td>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">
                                    <input type=\"hidden\" value=\"".$kor['id_korisnika']."\" name=\"idKorisnika\">
                                    <input type=\"text\" name=\"korisnik\" value=\"{$kor['korisnik']}\" id=\"korisnik\"/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Password:</td>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><input type=\"password\" name=\"lozinka\" value=\"{$kor['lozinka']}\" id=\"lozinka\"/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Name and surname:</td>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><input type=\"text\" name=\"imePrezime\" value=\"{$kor['ime_prezime']}\" id=\"imePrezime\"/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">E-mail:</td>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><input type=\"text\" name=\"email\" value=\"{$kor['email']}\" id=\"email\"/></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Privileges:</td>";
        $nivo = $kor['admin_nivo'];
        if($nivo==1){$chk1='SELECTED'; $chk2=''; $chk3='';}
        if($nivo==2){$chk1=''; $chk2='SELECTED'; $chk3='';}
        if($nivo==3){$chk1=''; $chk2=''; $chk3='SELECTED';}
        echo "<td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><select name=\"nivo\">
                                        <option class=\"klasicno\" value =\"1\" $chk1 >Administrator</option>
                                        <option class=\"klasicno\" value =\"2\" $chk2 >Editor</option>
                                        <option class=\"klasicno\" value =\"3\" $chk3 >Demo</option>
                                     </select>";
        echo "</td>";
        echo "</tr>";
    }
    }else
    {
        echo "<tr><td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\">Error!!</td></tr>";
    }
    echo "<tr>
            <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"></td>
            <td class=\"TD_EvenNew\" style=\"padding: 10px 5px 10px 10px\"><input style=\"height: 20px; width: 100px\" type=\"submit\" name=\"Izmeni\" value=\"Edit\" /></td>
          </tr>";
    echo "</table></form>";
}
if(isset($_POST['Izmeni']))
{
    $korisnikPromenaIme = $_POST['korisnik'];
    $korisnikID = $_POST['idKorisnika'];
    $korisnikPromenaLozinka = $_POST['lozinka'];
    $korisnikPromenaImePrezime = $_POST['imePrezime'];
    $korisnikPromenaEmail = $_POST['email'];
    $korisnikPromenaNivo = $_POST['nivo'];
    
    $update  = "UPDATE t_korisnici 
                SET korisnik = '{$korisnikPromenaIme}' , 
                lozinka = '{$korisnikPromenaLozinka}' , 
                ime_prezime = '{$korisnikPromenaImePrezime}' , 
                email = '{$korisnikPromenaEmail}' , 
                admin_nivo = '{$korisnikPromenaNivo}' 
                WHERE id_korisnika = {$korisnikID}";
    $izvrsiUpdate = mysql_query($update);
    echo "<br>";
    echo "<p align=\"center\"><font class=\"slovau\">User edited.</font></p>";
}
?>