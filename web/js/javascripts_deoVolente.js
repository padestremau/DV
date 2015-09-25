// -------------------------------------------   Start scripts function - Deo Volente  -----------------------------------------------
  
  $(document).ready(function(){ 

    // Initiate page size
    var header_height = $("#header").height();
    var header_footer = $("#footer").height();
    var window_height = window.innerHeight - header_height - header_footer;
    
    // Full page customized
    $('#page_content').css({'height':window_height+'px'});
    $('.txt_sobre_img').css({'height':window_height+'px'});

  });
