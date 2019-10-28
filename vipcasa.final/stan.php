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
<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css" type="text/css" media="screen"/>
<link href="/css/style.css" rel="stylesheet" type="text/css" media="screen, projection" />
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js"></script>
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

<div class="clearfix"></div>
<!-- SLIDER POCETAK -->
<!-- SLIDER KRAJ -->
<div class="clearfix"></div>
<div class="stan-banner">
  <div class="tip-stana-tabs">

<?php
    $sql1 = "SELECT s.id, s.sprat, s.opis, s.img1, s.img2, s.img3, s.vrsta_id, s.tip_id, s.lokacija_id FROM stan s WHERE s.id='$tabulator' AND s.status=1  ORDER BY s.id";
    $rez1 = mysql_query($sql1);
        if(mysql_num_rows($rez1)>0){
        $i=0;
        list($id, $sprat, $opis, $img1, $img2, $img3, $vrsta_id, $tip_id, $lokacija_id)=@mysql_fetch_row($rez1);
  
    } 
?>
<ul>
<?php
 $sql2 = "SELECT s.id, s.tip_id FROM stan s WHERE s.vrsta_id=$vrsta_id AND s.lokacija_id=$lokacija_id AND s.status=1 GROUP BY s.tip_id";
    $rez2 = mysql_query($sql2);
        if(mysql_num_rows($rez2)>0){
        $i=1;
        while(list($id_stana, $tip_id_stana)=@mysql_fetch_row($rez2)){
            if($tabulator==$id_stana){$tekucistan = 'active-tip-stana';}else{$tekucistan = '';}
            echo '<li><a class="f-22 '.$tekucistan.'" href="/vipcasa-stan='.$id_stana.'">Tip '.$i.'</a></li>';
            $i++;
        }
  
    } 
//echo $sql2;
?>  
</ul>    
      
      
    
  </div>

</div>
<div class="clearfix"></div>

<?php
/* DUGME I FORMA ZA PRIJAVU */
include("contactsmallform.php");
?>
<div class="main-tittle"><h1>STAN </h1>

</div>

<div id="bottom">
<div class="lok-bg">
<div class="container lok stan">
  
    <div class="row">
      
     <div class="g-p-12 g-t-4 g-m-4 g-d-4 thumb-a">
        <h1 class="f-25 curly-tittle"><img src="images/curly.png">Osnova stana</h1>
        <a class="fancybox thumb-stan" rel="group" href="/pics/vipcasa/<?php echo $img1;?>"><div class="plus">+</div><img src="/pics/vipcasa/<?php echo $img1;?>" alt=""/></a> 
    </div>

    <div class="g-p-12 g-t-4 g-m-4 g-d-4 thumb-a">
        <h1 class="f-25 curly-tittle"><img src="images/curly.png">Prikaz Stana</h1>
        <a class="fancybox thumb-stan" rel="group" href="/pics/vipcasa/<?php echo $img2;?>"><div class="plus">+</div><img src="/pics/vipcasa/<?php echo $img2;?>" alt=""/></a> 
    </div>

    <div class="g-p-12 g-t-4 g-m-4 g-d-4 thumb-a">
        <h1 class="f-25 curly-tittle"><img src="images/curly.png">Položaj u zgradi</h1>
        <a class="fancybox thumb-stan" rel="group" href="/pics/vipcasa/<?php echo $img3;?>"><div class="plus">+</div><img src="/pics/vipcasa/<?php echo $img3;?>" alt=""/></a> 
    </div>
    
  </div>
  
    <div class="clearfix"></div>
  </div>
</div>


<!-- TABELE -->

<div class="container">

  <div class="row">
    <div class="g-p-12 g-t-6 g-m-6 g-d-6 povrsine">
      <div class="povr-inner">
      <h1 class="f-30 curly-tittle"><img src="images/curly.png">PROSTORIJE I KVADRATURA</h1>
      <?php echo $opis;?>
        </div>
    </div>

    <div class="g-p-12 g-t-6 g-m-6 g-d-6 povrsine">
      <div class="povr-inner">
      <h1 class="f-30 curly-tittle"><img src="images/curly.png">DOSTUPNOST PO SPRATOVIMA</h1>
      <table class="f-20 dostupnost-tabela">
      <?php
$sql3 = "SELECT st.id, sp.id_sprata, sp.naziv_sprata, st.vrsta_id, st.sprat, st.prodat
FROM  sprat sp ,  stan st 
WHERE sp.id_sprata = st.sprat AND st.vrsta_id =  '$vrsta_id' AND st.tip_id =  '$tip_id' AND st.lokacija_id='$lokacija_id' AND st.status=1
GROUP BY st.sprat
ORDER BY sp.id_sprata;";
    $rez3 = mysql_query($sql3);
    //echo $sql3;
        if(mysql_num_rows($rez3)>0){
        $i=0;
        while(list($stan_id, $id_sprata, $naziv_sprata, $vrsta_id, $sprat, $prodat)=@mysql_fetch_row($rez3)) {
          echo '<tr>
            <td class="tab-main">'.$naziv_sprata.'</td>';
            if($prodat==0){
            echo '<td class="tab-green"></td>
                  <td></td>';
            }elseif($prodat==1){
            echo '<td></td>
                  <td class="tab-red"></td>';
            }else{
              echo '<td></td>
                    <td></td>';
            }
          echo '</tr>';
        }
  
  
    } 
?>                 
          
           
        </table>

        <table class="f-20 dostupnost-tabela legenda-dostupnost">
          <h2 class="f-20 legenda-h2">Legenda</h2>
          <tr>
            <td class="tab-main tab-legenda">Stan dostupan u prodaji</td>
            <td></td>
            <td class="tab-green"></td>
            <td></td>
          </tr>

            <tr>
            <td class="tab-main tab-legenda">Stan prodat</td>
            <td></td>
            <td class="tab-red"></td>
            <td></td>
          </tr>

        </table>
        
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
  $('.bxslider').bxSlider();
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

<script type="text/javascript">
  $(document).ready(function() {
    $(".fancybox").fancybox();
  })
</script>

</body>
</html>