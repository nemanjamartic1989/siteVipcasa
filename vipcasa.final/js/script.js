
$(document).ready( function() {


 
var targetOffset = $("#bottom").offset().top;

var $w = $(window).scroll(function(){
    if ( $w.scrollTop() > targetOffset && $(window).width() >= 767) {   
        $('.cont-nav').css({"height":"70px", "margin-top":"0", "background":"rgba(168, 150, 114, 1)","border-bottom": "7px solid #2c3257", "z-index":"20000" });
        $('#nav ul li').css({"height":"70px", "line-height":"70px"});
        $('#nav .active-nav').css({"height":"100px", "line-height":"100px"});
        $('#nav .active-nav a').css({"line-height":"100px"});
        $('.logo img').css({"height":"110px"});
        
    }

     else if ($w.scrollTop() < targetOffset && $(window).width() >= 1169) {

      $('.cont-nav').css({"height":"80px", "margin-top":"40px", "background":"rgba(168, 150, 114, .6)", "border-bottom": "7px solid #a89672"});
      $('#nav ul li').css({"height":"80px", "line-height":"80px"});
      $('#nav .active-nav').css({"height":"115px"});
      $('#nav .active-nav a').css({"line-height":"115px"});
      $('.logo img').css({"height":"130px"});   

    }

    else if ( $w.scrollTop() < targetOffset && $(window).width() >= 767){
      $('.cont-nav').css({"height":"70px", "margin-top":"25px", "background":"rgba(168, 150, 114, .6)", "border-bottom": "7px solid #a89672"});
      $('#nav ul li').css({"height":"70px", "line-height":"70px"});
      $('#nav .active-nav').css({"height":"100px"});
      $('#nav .active-nav a').css({"line-height":"100px"});
      $('.logo img').css({"height":"110px"});
    }


});


});



