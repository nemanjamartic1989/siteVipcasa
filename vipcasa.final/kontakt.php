<?php /*sprecavam da se pozove direktno ova strana */
  if (eregi("homepage_sr.php",$_SERVER['PHP_SELF'])) {
    @header("Refresh: 0; url=../");
    echo "<SCRIPT LANGUAGE='JavaScript'>";
    echo "document.location.href='../'";
    echo "</SCRIPT>";
    die();
    exit;
   }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $strana_TITLE; ?></title>
<meta name="description" content="<?php echo $strana_META_DISC; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Slabo+27px&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Advent+Pro:400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="/css/bootstrap-theme.css" rel="stylesheet" type="text/css" media="screen, projection" />
<style type="text/css">
  @import url('/assets/css/contact.css');
</style>
<link href="/css/normalize.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="/css/grid.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="/css/responsive-utilitis.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="css/jquery.bxslider.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet" type="text/css" media="screen, projection" />
<script type="text/javascript" src="/assets/js/js.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/js/script.js"></script>

</head>

<body>

<header class="container-fluid">
    
<div class="container-fluid cont-nav">
  <div class="container">
     <div class="row">

     <a class="logo pull-left" href="/"><img src="/images/logo2.png"></a>

    <nav id="nav" role="navigation" class="pull-right">
       <?php echo $NAVIGACIJA; ?>
    </nav>

     </div>
  </div>
</div>

</header>

<div class="clearfix"></div>
<div class="mapa-banner">
  <img class="img-responsive" src="/images/kontakt-slider.jpg">
</div>
<div class="clearfix"></div>

<?php
/* DUGME I FORMA ZA PRIJAVU */
//include("contactsmallform.php");
?>

<div class="main-tittle"><h1>vip casa, ustanička 128b, beograd</h1>
</div>

<div id="bottom">
 
  <div class="container contact-map">
    <div class="row">
      <?php echo $MAINCONTENT; ?>
      <div class="g-p-12 g-t-7 g-m-7 g-d-7 contact-form1">  
      <h1 class="f-38 curly-tittle"><img src="images/curly.png">KONTAKTIRAJTE NAS</h1>
      <div>
          <form method="post" action="/assets/php/send.php" id="contactForm">
                <div class="error" id="error">Greška. Poruka nije poslata.!</div>
                <div class="success" id="success">Email uspešno poslat!<br />Hvala na kontaktu.</div>

                    <span class="input">
                    <label for="name"><b>Ime i prezime:</b> </label>
                    <input  type="text" id="name" name="name" />
                    <div class="warning" id="nameError">Polje je obavezno.</div>
                    </span>

                    <span class="input">
                    <label for="email"><b>Email:</b> </label>
                    <input  type="text" id="email" name="email" />
                    <div class="warning" id="emailError">Unesite ispravnu email adresu!</div>
                    </span>

                    <span class="input">
                    <label for="phone"><b>Tel:</b> </label>
                    <input  type="text" id="phone" name="phone" />

                    </span>
                    <input type="hidden" id="sales" name="sales" value="Contact">

                    <span class="input">
                    <label for="message"><b>Poruka:</b> </label>
                    <textarea id="message" name="message">
                    </textarea>
                    <div class="warning" id="messageError">Polje je obavezno.</div>
                    </span>

                    <span class="input">
                    <label for="security_code"><b>Sigurnosni kod:</b> </label> 
                    <input class="noicon" type="text" id="security_code" name="security_code" style="width:200px" />
                    <img src="/assets/php/security/1/sec.php" style="vertical-align:middle;" />
                    <div class="warning" id="security_codeError">Uneli ste pogresan kod!</div>
                    </span>
                    <span id="submit" class="input">
                    <label for="submit"></label>
                    <p id="ajax_loader" style="text-align:center;"><img src="/assets/img/contact/ajax-loader.gif" /></p>
                    <input id="send" type="submit" value="Pošalji" />
                    </span>

                </form>
      </div>
      </div>
      <!-- MAPA VIPA CASA -->
      <div class="g-p-12 g-t-4 g-m-4 g-d-4 contact-form2"> 
        <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6735.076938268168!2d20.515428773677773!3d44.78588091449571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7098682abd37%3A0xd630f0804d414a6d!2sGusinjska%2C+Beograd!5e0!3m2!1sen!2srs!4v1442421545369" width="700" height="550" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
    </div>
  </div>

  <div class="clearfix"></div>

</div>

<footer>
<?php echo $FOOTER; ?>
</footer>

<script type="text/javascript">
$(document).ready(function(){
  $('#elem-kontakt-vipcasa').addClass('active-nav');
  $('.bxslider').bxSlider({
  auto: true,
  });
});   
</script>

</body>
</html>