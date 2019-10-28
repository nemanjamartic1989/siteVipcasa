<div id="navigacija" align="center">
<table width="900" height="40" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><a href="./index.php?LID=<?php echo $LID; ?>"><img src="images/home.png" border="0" /></a></td>
    <td align="center" valign="middle"><a href="./index.php?modul=templati&LID=<?php echo $LID; ?>">Templates</a></td>
    <td align="center" valign="middle"><a href="./index.php?modul=strane&LID=<?php echo $LID; ?>">Pages</a></td>
    <td align="center" valign="middle"><a href="./index.php?modul=sadrzaji&LID=<?php echo $LID; ?>">Content</a></td>
    <td align="center" valign="middle"><a href="./index.php?modul=navigation&LID=<?php echo $LID; ?>">Navigation</a></td>
    <td align="center" valign="middle"><a href="./index.php?modul=vrste&LID=<?php echo $LID; ?>">Lokacije</a></td> 
    <td align="center" valign="middle"><a href="./index.php?modul=vesti&LID=<?php echo $LID; ?>">News</a></td>  
    <!--<td align="center" valign="middle"><a href="./index.php?modul=galerija&LID=<?php echo $LID; ?>">Gallery</a></td>-->
  <!--<td align="center" valign="middle"><a href="./index.php?modul=promenaLozinke&LID=<?php echo $LID; ?>">lozinka</a></td>-->
    <?php
    if($A_NIVO==1){
?>
    <td align="center" valign="middle"><a href="./index.php?modul=korisnici&LID=<?php echo $LID; ?>">Options</a></td>
    <?php
    }else{
?>
<td align="center" valign="middle"></td>
<?php
    }
?>
    <td align="center" valign="middle"><a href="uklj/autentifikacija.php?akcija=logout&LID=<?php echo $LID; ?>">Logout</a></td>
  </tr>
</table>
</div>
