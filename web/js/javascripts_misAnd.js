// -------------------------------------------   Start scripts function - Mission Andina  -----------------------------------------------

  // On load
  function onLoadData() {
    // Top button
    document.getElementById("button_to_top").className = "opacity0";
  }

  // Auto risize textareas
  $(function() {
    //  changes mouse cursor when highlighting loawer right of box
    $("textarea").mousemove(function(e) {
        var myPos = $(this).offset();
        myPos.bottom = $(this).offset().top + $(this).outerHeight();
        myPos.right = $(this).offset().left + $(this).outerWidth();
        
        if (myPos.bottom > e.pageY && e.pageY > myPos.bottom - 16 && myPos.right > e.pageX && e.pageX > myPos.right - 16) {
            $(this).css({ cursor: "nw-resize" });
        }
        else {
            $(this).css({ cursor: "" });
        }
    })
    //  the following simple make the textbox "Auto-Expand" as it is typed in
    .keyup(function(e) {
        //  the following will help the text expand as typing takes place
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+1);
        };
    });
  });





  //  BEGIN SMOOTH SCROLLING

  // Anchors
  var myAnchors = ['#accueil', '#assoc', '#ecoliers', '#etudiants', '#jeunesPro', '#actu', '#footer'];
  var myAnchorsLinksIds = ['#btn_section0', '#btn_section1', '#btn_section2', '#btn_section3', '#btn_section4', '#btn_section5', '#btn_section6'];
  var myAnchorsHeaderIds = ['btn_header0', 'btn_header1', 'btn_header2', 'btn_header2', 'btn_header2', 'btn_header5', 'btn_header6'];
  var side_buttons = ['btn_side_0', 'btn_side_1', 'btn_side_2', 'btn_side_3', 'btn_side_4', 'btn_side_5', 'btn_side_6'];
  var slider_containers = ['', '', '#slide_container_content_ecoliers', '#slide_container_content_etudiants', '#slide_container_content_jeunesPro', '', ''];
  var slider_pos = ['', '', 1, 1, 1, '', ''];
  var currentAnchor = 0;
  if (document.location.hash) {
    var the_hash = document.location.hash;
    // the_hash = the_hash.replace("#","");
    for (var i = 0; i < myAnchors.length; i++) {
      if (myAnchors[i] == the_hash) {
        currentAnchor = i;
        break;
      }
    }
  }
  changeActiveAnchor(currentAnchor);
  changeSideButton(currentAnchor);
  var currentPosition = $(window).scrollTop();


  /**
   * Get current anchor
   */
  function getCurrentAnchor() {
    // Get container scroll position
    var gap_point = window.innerHeight * 0.4;
    var currentPosition = $(window).scrollTop();
    // Get id of current scroll item
    for (var i = 0; i < myAnchors.length; i++) {
      if (Math.abs(currentPosition - $(myAnchors[i]).offset().top) < gap_point) {
        currentAnchor = i;
      }
    }
  }
  
  /**
   * Scrolling event
   */
  $(window).scroll(function(){
    // Get current Anchor
    getCurrentAnchor();
    changeActiveAnchor(currentAnchor);
    changeSideButton(currentAnchor);
    showMenuThenAnchor();
  });

  /**
   * Sliding with arrow keys, both, vertical and horizontal
   */
  $(document).keydown(function(e) {
    //preventing the scroll with arrow keys
    if(e.which == 40 || e.which == 38){
      e.preventDefault();
    }

    switch (e.which) {
      //up
      case 38:
      case 33:
        getCurrentAnchor();
        if (currentAnchor > 0) {
          currentAnchor --;
          var idAgoToAnchor = myAnchorsLinksIds[currentAnchor];
          // alert(idAgoToAnchor);
          $(idAgoToAnchor).trigger('click');
        }
        break;

      //down
      case 40:
      case 34:
        getCurrentAnchor();
        if (currentAnchor < myAnchors.length - 1) {
          currentAnchor ++;
          var idAgoToAnchor = myAnchorsLinksIds[currentAnchor];
          // alert(idAgoToAnchor);
          $(idAgoToAnchor).trigger('click');
        }
        break;

      //left
      case 37:
        getCurrentAnchor();
        if (currentAnchor == 2 || currentAnchor == 3 || currentAnchor == 4) {
          var slider_container = slider_containers[currentAnchor];
          var goToSlideInPos = slider_pos[currentAnchor];
          if (goToSlideInPos > 0) {
            goToSlideInPos --;
            slider_pos[currentAnchor] = goToSlideInPos;
          }
          // alert('left');
          slideToAnchor(slider_container, goToSlideInPos);
        }
        break;

      //right
      case 39:
        getCurrentAnchor();
        if (currentAnchor == 2 || currentAnchor == 3 || currentAnchor == 4) {
          var slider_container = slider_containers[currentAnchor];
          var goToSlideInPos = slider_pos[currentAnchor];
          if (goToSlideInPos < 2) {
            goToSlideInPos ++;
            slider_pos[currentAnchor] = goToSlideInPos;
          }
          // alert('right');
          slideToAnchor(slider_container, goToSlideInPos);
        }
        break;

      default:
        return; // exit this handler for other keys
    }

    changeActiveAnchor(currentAnchor);
    changeSideButton(currentAnchor);

  });

  
  /**
   * Soft scrolling on click
   */
  $(document).ready(function(){ 


    var window_height = window.innerHeight;
    var window_width = window.innerWidth;
    if (window_width > (window_height * 1.2)) {
      // Full page customized
      $('.section').css({'min-height':window_height+'px'});
    }

    var window_height_slide = window.innerHeight * 0.8;
    var window_width_slide = window.innerWidth;
    var window_width_slide_container = window_width_slide * 3.1;
    $('.slide').css({'height':window_height_slide+'px', 'width':window_width_slide+'px'});
    $('.slide_container').css({'height':window_height_slide+'px', 'width':window_width_slide+'px'});
    $('.slide_container_content').css({'height':window_height_slide+'px', 'width':window_width_slide_container+'px'});

    // Initiate the website in the middle
    for (var i = 2; i < 5; i++) {
      var slide_init = window.innerWidth + 4;
      $(slider_containers[i]).animate({
          scrollLeft: slider_pos[i] * slide_init
      }, 600);
    };

    // Modal height and scroll
    var window_height_modal = Math.round(window.innerHeight * 0.72);
    $(".modal-body").css({'max-height':window_height_modal+'px'});

    // alert(window_height+' and '+window_height_modal+' and '+$('.modal-body').css('max-height'));


    (function($) {
      $.fn.juizScrollTo = function( speed ) { 
        if ( !speed ) var speed = 'slow';  
        
        // coeur du plugin
        return this.each( function() {  
          $(this).click( function() {  
            var goscroll = false;  
            var the_hash = $(this).attr("href");  
            var regex = new RegExp("(.*)\#(.*)","gi");

            // Check no bootstrap tabs
            // if (the_hash.indexOf('tab') > -1) {
            //   return false;
            // }

            if ( the_hash.match("\#") ) {  
              the_hash = the_hash.replace(regex,"$2");
              if($("#"+the_hash).length>0) {  
                the_element = "#" + the_hash;  
                goscroll = true;  
              }  
              else if ( $("a[name=" + the_hash + "]").length>0 ) {  
                the_element = "a[name=" + the_hash + "]";  
                goscroll = true;  
              }  
              if ( goscroll ) {  
                var container = 'body';
                $(container).animate( {  
                  scrollTop: $(the_element).offset().top  
                }, speed, function() {
                  tab_n_focus(the_hash)
                  write_hash(the_hash);
                });  

                for (var i = 0; i < myAnchors.length; i++) {
                  if (myAnchors[i] == '#'+the_hash) {
                    currentAnchor = i;
                    break;
                  }
                }
                currentPosition = $(window).scrollTop();
                changeActiveAnchor(currentAnchor);
                changeSideButton(currentAnchor);
                return false;  
              }  
            }  
          });  
        });
        
        // fonctions
        
        // écriture du hash
        function write_hash( the_hash ) {
          document.location.hash =  the_hash;
        }
        
        // accessibilité au clavier
        function tab_n_focus( the_hash ) {  
          $(the_hash).attr('tabindex','0').focus().removeAttr('tabindex');  
        }

      };  
      
      // appel de la fonction sur toutes les ancres !
      $('a').juizScrollTo('slow');
      
      // fonction de slide au chargement
      function trigger_click_for_slide() {
        var the_hash = document.location.hash;
        if ( the_hash )
          $('a[href~="'+the_hash+'"]').trigger('click');
      }
      trigger_click_for_slide();

    })(jQuery)
  });

  
  /**
   * Acivate anchor link in menu
   */
  function changeActiveAnchor(current) {
    var goToAnchor = myAnchors[current];
    // Top button
    if (goToAnchor != '#accueil') {
      document.getElementById("button_to_top").className = "opacity1";
    }
    else {
      document.getElementById("button_to_top").className = "opacity0";
    }

    // For menu
    var anchorHeader = '';
    for (var i = 0; i < myAnchorsHeaderIds.length; i++) {
      if (myAnchorsHeaderIds[i] != anchorHeader) {
        anchorHeader = myAnchorsHeaderIds[i];
        document.getElementById(myAnchorsHeaderIds[i]).className = "border_right_li";
      }
      if (i == current) {
        document.getElementById(myAnchorsHeaderIds[i]).className = "border_right_li active";
      }
    }
  }

  /**
   * Side buttons
   */
  function changeSideButton(current) {
    for (var i = 0; i < side_buttons.length; i++) {
      if (i == current) {
        document.getElementById(side_buttons[i]).className = "btn-side btn-side-active";
      }
      else {
        document.getElementById(side_buttons[i]).className = "btn-side";
      }
    }
    // For white
    if (current == (side_buttons.length - 1) || current == 0) {
      for (var i = 0; i < side_buttons.length; i++) {
        document.getElementById(side_buttons[i]).className = "btn-side-invert";
        if (i == current) {
          document.getElementById(side_buttons[i]).className = "btn-side-invert btn-side-invert-active";
        }
      }
    }
  }

  /**
   * Show menu for the rest of the web site
   */
  function showMenuThenAnchor() {
    var window_height = window.innerHeight * 0.95;
    var top_offset = $(window).scrollTop();
    if (top_offset > window_height) {
      $('#header').fadeIn('normal');
    }
    else {
      $('#header').fadeOut('normal');
    }
    if (top_offset > 3) {
      $('#btn-accueil').fadeOut('fast');
    }
    else {
      $('#btn-accueil').fadeIn('fast');
    }
  }

  /**
   * Slide functions
   */
  function slideToAnchor(id_slider_content, toGoPos) {
    var widthToSlide = window.innerWidth + 4;
    var coef = eval(toGoPos);
    // alert('pos cur'+currentPos+ 'togopos ' + toGoPos+' move '+ widthToSlide * coef);
    $(id_slider_content).animate({
        scrollLeft: widthToSlide * coef
    }, 600);
  }

  // END SMOOTH SCROLLING