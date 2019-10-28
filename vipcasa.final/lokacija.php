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
<script src="/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/js/script.js"></script>
<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>
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
<?php
    $sql = "SELECT l.id, l.naziv, l.podovi, l.zidovi, l.plafon, l.prozori_vrata, l.instalacija, l.krov, l.konstrukcija, l.img2, l.lat, l.lon FROM lokacija l WHERE l.id=$tabulator ORDER BY l.id";
    $rez = mysql_query($sql);
        if(mysql_num_rows($rez)>0){
        $i=0;
        list($id, $naziv, $podovi, $zidovi, $plafon, $prozori_vrata, $instalacija, $krov, $konstrukcija, $img2, $lat, $lon)=@mysql_fetch_row($rez);
        
      
    } 

 
?>
<div class="clearfix"></div>
<!-- SLIDER LOKACIJE POCETAK -->
<ul class="bxslider">
<?php
$sqlQueryPhotosGallery = "SELECT id, img FROM lokacija_slider WHERE lokacija_id='$id' ORDER BY id DESC ";    
    $rezQueryPhotosGallery = mysql_query($sqlQueryPhotosGallery);
    if(mysql_num_rows($rezQueryPhotosGallery)>0){
        $numero=1;
    while (list($img_id, $img_image)=@mysql_fetch_row($rezQueryPhotosGallery)) {
        if($img_image){
        echo '<li><img src="/pics/vipcasa/'.$img_image.'" alt="'.$img_id.'"></li>';
        }else{
          echo '<li><img src="images/home-slider.jpg" /></li>';
        }
    }
    }else{
          echo '<li><img src="images/home-slider.jpg" /></li>';
    }
?>
</ul>
<!-- SLIDER LOKACIJE KRAJ -->

<div class="clearfix"></div>

<?php
/* DUGME I FORMA ZA PRIJAVU */
include("contactsmallform.php");
?>


<div class="main-tittle"><h1><?php echo $naziv;?></h1>
</div>

<div id="bottom">
<div class="lok-bg">
<div class="container lok stanovi">
  
    <div class="row">
      <h1 class="f-38 curly-tittle"><img src="images/curly.png">STANOVI</h1>
      <?php
   $sql1 = "SELECT s.id, v.naziv, v.img, v.id AS vrstaid, s.lokacija_id AS stanlokacija FROM stan s, vrsta v WHERE s.vrsta_id=v.id AND s.status=1 AND s.lokacija_id=$tabulator GROUP BY v.id";
$rez1 = mysql_query($sql1);
        if(mysql_num_rows($rez1)>0){
        $i=0;
        while (list($id_stana, $naziv_vrste, $img, $vrstaid, $stanlokacija)=@mysql_fetch_row($rez1)){
          echo '<div class="g-p-12 g-t-4 g-m-4 g-d-4 thumb-a">
      <div class="thumb-inner">';
     
      

      echo '<a href="/vipcasa-stan='.$id_stana.'">';

       $sqlCheck = "SELECT COUNT( st.id ) , SUM( st.prodat ) 
                FROM sprat sp, stan st
                WHERE sp.id_sprata = st.sprat
                AND st.vrsta_id =  '$vrstaid'
                AND st.lokacija_id =  '$id'
                AND st.status =1
                GROUP BY st.sprat
                ORDER BY sp.id_sprata";
      $rezCheck = mysql_query($sqlCheck);
        if(mysql_num_rows($rezCheck)>0){
            list($countStan, $sumStan)=@mysql_fetch_row($rezCheck);
            if($countStan==$sumStan){
              echo '<div class="rasprodato"></div>';
            }
        }

      if($vrstaid==4 && $stanlokacija==1){
      echo '<img class="img-responsive"src="/pics/vipcasa/vipcasa-264733402.jpg">';
      }else{
      echo '<img class="img-responsive"src="/pics/vipcasa/'.$img.'">';
      }
      echo '<div class="title-stripe"><h2>'.$naziv_vrste.'</h2></div></a></div>
      
    </div>';  
        }
        
        }
        ?>    
  </div>
  
    <div class="clearfix"></div>
  </div>
</div>


<!-- MAPS -->

<div class="container">

  <div class="row">
    <h1 class="f-38 curly-tittle"><img src="images/curly.png">LOKACIJA NA MAPI</h1>

    <div class="g-p-12 g-t-6 g-m-6 g-d-6 map">
      <div id="vipmap" style="width: 100%;min-height: 280px;"></div>
    </div>
    <?php if($img2){ ?>
    <div class="g-p-12 g-t-6 g-m-6 g-d-6 map">
      <div class="map2" style="background-image: url(../pics/vipcasa/<?php echo $img2 ?>);">
      </div>
    </div>
    <?php } ?>
  </div>

</div>
<div class="clearfix"></div>

<div class="container">

  <div class="row">

    <h1 class="f-38 curly-tittle"><img src="images/curly.png">OPŠTE KARAKTERISTIKE</h1>



<div id="tabs">

  
    <ul>
      <li><a class="f-20" href="#tabs-1">podovi</a></li>
      <li><a class="f-20" href="#tabs-2">zidovi</a></li>
      <li><a class="f-20" href="#tabs-3">plafon</a></li>
      <li><a class="f-20" href="#tabs-4">prozori i vrata</a></li>
      <li><a class="f-20" href="#tabs-5">instalacije</a></li>
      <li><a class="f-20" href="#tabs-6">spoljna obrada</a></li>
      <li><a class="f-20" href="#tabs-7">konstrukcija</a></li>
      
    </ul>
    

  <div class="g-p-12 g-t-12 g-m-offset-2 g-m-8 g-d-offset-2 g-d-8 tabs-container">
  <div class="f-16" id="tabs-1">
    <p>
  <?php echo $podovi;?>
</p>
  </div>
  <div class="f-16" id="tabs-2">
    <p>
  <?php echo $zidovi;?>
  </p>
  </div>
  <div class="f-16" id="tabs-3">
    <p>
  <?php echo $plafon;?>
  </p>
  </div>

  <div class="f-16" id="tabs-4">
    <p>
  <?php echo $prozori_vrata;?>
  </p>
  </div>

   <div class="f-16" id="tabs-5">
    <p>
  <?php echo $instalacija;?>
  </p>
  </div>

   <div class="f-16" id="tabs-6">
    <p>
  <?php echo $krov;?>
  </p>
  </div>

  <div class="f-16" id="tabs-7">
    <p>
  <?php echo $konstrukcija;?>
  </p>
      </div>
  </div>
  </div>
</div>

</div>  

<div class="clearfix"></div>


<footer>
<?php echo $FOOTER; ?>
</footer>
<script type="text/javascript">
$(document).ready(function(){
  $('#elem-spisak-lokacija').addClass('active-nav');
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
  var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
})

 $('#myModal').modal()
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
var map;
function initialize() {
  var ponsLatlng = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>);
  var ponsLatlngCenter = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lon; ?>);
  var mapOptions = {
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL,
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    mapTypeControl: true,
    scaleControl: false,
    streetViewControl: false,
    zoom: 15,
    center: ponsLatlngCenter
  };
  map = new google.maps.Map(document.getElementById('vipmap'),
      mapOptions);

  var marker = new google.maps.Marker({
      position: ponsLatlng,
      map: map,
      title: 'VIP CASA INVEST!'
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
</body>
</html>