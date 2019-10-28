<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MM STUDIO :: CMS :: Login</title>
<link href="uklj/login.css" media="all" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
function promeni(obj) {
    obj.bgColor = "#E7A1B0";
}

function promeni2(obj) {
   obj.bgColor = "#FFFFFF";
}
</script>
</head>

<body class="background" onload="document.form1.korisnik.focus();">
<div style="width:500px; margin:160px auto 0 auto;" class="kvadrat">
        <div style="padding:90px 20px 0 170px; width:330px; height:143px;">
        <table width="330" height="143" border="0"  >
        <tr>
          <td><FORM action="uklj/autentifikacija.php" method="post" name="form1" id="form1" target="_parent">
    <br><TABLE align=center cellSpacing=0 cellPadding=0 width=300 border=0><TBODY><TR>
    <td align=center width="50" style="padding-bottom:10px;">
    <span class="slova"><img src="images/cikice.png" /></span></td>
    <td width="250" style="padding-bottom:10px;"><input name="korisnik" type="text" size="15" maxlength="20" id="inpt"  style="text-align:center; width:164px;"></td></tr>
    <tr>
    <td align=center width="50">
    <span class="slova"><img src="images/kljucevi.png" /></span></td>
    <td><input name="lozinka"  type="password" size="15" maxlength="23" class="lozinka" id="inpt" style="text-align:center; width:164px;" >
    <input type="hidden" name="submitovano" /></td></tr>
    <tr height=14><td colspan=2 ></td></tr>
    <tr height=25 ><td align=right width="50" style="padding-top:10px">
    </td>
    <td align="left" valign=bottom ><INPUT name="submit" type="submit"  value="Login" class="btn" >
   <?php if(1==0){ ?>
     <input name="submit2" type="button" class="InputDugme" value=" Odustani " onclick="document.location='../';" style="width:80px;"/>
    <?php } ?></td></tr>
    </table></FORM></td>
        </tr>
      </table>
        
        </div>

</div>
</body>
</html>
