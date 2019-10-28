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
<link href="/css/normalize.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="/css/grid.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="/css/responsive-utilitis.css" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="css/jquery.bxslider.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet" type="text/css" media="screen, projection" />
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
<!-- SLIDER POCETAK -->
<?php include("pageslider.php");?>
<!-- SLIDER KRAJ -->
<div class="clearfix"></div>


<?php
/* DUGME I FORMA ZA PRIJAVU */
include("contactsmallform.php");
?>

<div id="bottom">
 
  <div class="container">
    <div class="row">
      <?php echo $MAINCONTENT; ?>
    </div>
  </div>

  <div class="clearfix"></div>

</div>

<footer>
<?php echo $FOOTER; ?>
</footer>

// <script type="text/javascript">
//        $(document).ready(function(){
//   $('.bxslider').bxSlider();
// });  
// </script>

<script type="text/javascript">
$(document).ready(function(){
  $('#elem-o-nama').addClass('active-nav');
  $('.bxslider').bxSlider({
  auto: true,
  });
});   
</script>

</body>
</html>