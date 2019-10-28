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
  <div class="lok-bg">
    <div class="container lok">
<?php
    /* Upit koji vadi nazive gradova */
    $sql = "SELECT g.id, g.naziv FROM Grad g ORDER BY g.id ASC LIMIT 3";
    $rez = mysql_query($sql);
    if(mysql_num_rows($rez)>0){
      $i=0;
      while (list($id_grada, $naziv)=@mysql_fetch_row($rez)) {
         echo '<div class="row">
          <h1 class="f-38 curly-tittle"><img src="/images/curly.png">'.$naziv.'</h1>';
              /* Unutrasnji upit koji vadi lokacije za svaki izlistani grad */
              $sql2 = "SELECT l.id, l.naziv, l.mesto, l.adresa, l.status, l.sold, l.img FROM lokacija l WHERE l.grad=$id_grada ORDER BY l.ord ASC";
              $rez2 = mysql_query($sql2);
              if(mysql_num_rows($rez2)>0){
                while (list($id, $naziv_lokacije, $mesto, $adresa, $status, $sold, $img)=@mysql_fetch_row($rez2)) {
                  echo '<div class="g-p-12 g-t-4 g-m-4 g-d-4 thumb-a"><div class="thumb-inner">';
                  if($id == 5){
                    echo '<a href="javascript:void(0)">'; 
                  }else{
                    echo '<a href="/vipcasa-lokacija='.$id.'">'; 
                  }
                  if($sold==1){ echo '<div class="rasprodato"></div>';}  
                  echo'<img class="img-responsive"src="/pics/vipcasa/'.$img.'"><div class="title-stripe"><h2>'.$naziv_lokacije.'</h2></div></a></div></div>';                 
                }
              }
          echo '</div>';
          echo '<div class="clearfix"></div>';
      }      
    } 
?>   
    </div>
  </div>   
</div>

  <div class="container">
    <div class="row">
      <?php echo $ABOVE_FOOTER; ?>
    </div>
  </div>

  <div class="clearfix"></div>

</div>

<footer>
<?php echo $FOOTER; ?>
</footer>

<script type="text/javascript">
$(document).ready(function(){
  $('#elem-sr').addClass('active-nav');
  $('.bxslider').bxSlider({
  auto: true,
  });
});   
</script>

<script type="text/javascript">
 $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
})

 $('#myModal').modal();
</script>
</body>
</html>