<?php
@include("uklj/expire.php"); //hederi
@include("uklj/baza_heder.php");
@include("uklj/sesija.php"); 
@include("uklj/podesavanje.php");
@include("uklj/datum.php");

if (!$modul){$modul = 'strane';}
if($modul){$aktivnaStavka[$modul] = " class=\"active\"";} //postavlja aktivnu u meniju

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>MM Studio :: Admin</title>
    <link href="uklj/administracija.css" media="all" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.tablednd.js"></script>

<script type="text/javascript">
function favBrowser()
{
var mylist=document.getElementById("myList");
document.getElementById("favorite").value=mylist.options[mylist.selectedIndex].text;
}
</script>
<link rel="stylesheet" href="nav/jquery.treeview.css" />


<!-- jQuery and jQuery UI -->
    
    <script src="js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" charset="utf-8">
    <script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
    <!-- elRTE -->
    <script src="js/elrte.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="css/elrte.min.css" type="text/css" media="screen" charset="utf-8">

    <!-- elFinder -->
        <link rel="stylesheet" href="css/elfinder.css" type="text/css" media="screen" charset="utf-8" /> 
        <script src="js/elfinder.full.js" type="text/javascript" charset="utf-8"></script> 
   <!--<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    -->
    <script src="/js/jquery.alerts.js" type="text/javascript"></script>
<link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/fancybox/source/jquery.fancybox.css" media="screen" />
<script src="nav/jquery.cookie.js" type="text/javascript"></script>
<script src="nav/jquery.treeview.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $("#tree").treeview({
            collapsed: true,
            animated: "medium",
            control:"#sidetreecontrol",
            prerendered: true,
            persist: "location"
        });
    })    
</script>
<script type="text/javascript">
<?php
$dodatneFunkcije .= "function prikaziLoad(id_diva){\r\n";
$dodatneFunkcije .= "document.getElementById(id_diva).innerHTML = '<img border=\"0\" hspace=\"0\" src=\"images/loading.gif\" alt=\"\" />';\r\n"; 
$dodatneFunkcije .= "}\r\n";

$dodatneFunkcije .= "function prikaziLoad_mali(id_diva){\r\n";
$dodatneFunkcije .= "document.getElementById(id_diva).innerHTML = '<img border=\"0\" hspace=\"0\" src=\"images/loading_mali.gif\" alt=\"\" />';\r\n"; 
$dodatneFunkcije .= "}\r\n";

$dodatneFunkcije .= "function ocistiPretrage(){\r\n";
$dodatneFunkcije .= "document.getElementById('pretrProizvoda').value='';  \r\n";
//$dodatneFunkcije .= "document.getElementById('detaljnaPretragaID').checked='';  \r\n";  //document.getElementById('pretrProizvodjaca').value='';
$dodatneFunkcije .= "}\r\n";

$dodatneFunkcije .= "function proveri(){\r\n";
$dodatneFunkcije .= "var agree=confirm(\"Are you sure?\"); if (agree) return true ; else return false ;\r\n"; 
$dodatneFunkcije .= "}\r\n";

echo $dodatneFunkcije; 
?>
</script>
    <style type="text/css" title="currentStyle">
            @import "css/page.css";
            @import "css/table.css";
</style>
<script src="/js/jquery.alerts.js" type="text/javascript"></script>
<link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="pozadina_header">
    
    <div id="header">
        <div id="box_user">
        <img src="./images/korisnik_dugme.png" alt="Korisnik" align="absmiddle"><span class="imeprezime">
        <?php echo $IME_PREZIME; ?></span>
        </div>
     </div>
</div>

<?php
include("navigacija.php");
?>
<?php
//ovde ide sadrzaj
if ($modul=="strane")    {include("strane.php");}  
if ($modul=="templati")  {include("templati.php");} 
if ($modul=="sadrzaji")  {include("sadrzaji.php");} 
if ($modul=="vesti")     {include("vesti.php");}
if ($modul=="forme")     {include("forme.php");}
if ($modul=="navigation")     {include("navigation.php");}
if ($modul=="galerija")  {include("galerija.php");}
if ($modul=="galerija_dog")  {include("galerija_dog.php");}
if ($modul=="korisnici") {include("korisnici.php");}
if ($modul=="vrste") {include("vrste.php");}
if ($modul=="tip") {include("tip.php");}
if ($modul=="lokacija") {include("lokacija.php");}
if ($modul=="stan") {include("stan.php");}
if ($modul=="klijenti") {include("klijenti.php");}
if ($modul=="komentari") {include("komentari.php");}
if ($modul=="promenaLozinke") {include("promenaLozinke.php");}     
?>
</div>
<br>
<table cellspacing="0" cellpadding="10" width="100%" align="center" border="0">
  <tbody>
    <tr>
      <td id="footer_pozadina">
          <div id="footer"><div id="left_footer"><img src="images/mm_logo.png" /></div>
                  <div id="right_footer">
                    <img align="absmiddle" src="./images/web.png" /> &nbsp; www.mmstudio.rs &nbsp;
                    <img  align="absmiddle" src="./images/koverta.png" /> &nbsp; office@mmstudio.rs &nbsp;
                    <img  align="absmiddle" src="./images/telefon.png" /> &nbsp; +381 69 222 62 00 &nbsp;
                    <img  align="absmiddle" src="./images/telefon.png" /> &nbsp; +381 63 570 403 &nbsp;<br /><br />
                       <p><span>&copy;</span> Copyright MM Studio 2013.<br /> All rights reserved.</p>    
               </div>
                    
        </div>
      </td>
    </tr>
  </tbody>
</table>
</body>
</html>
