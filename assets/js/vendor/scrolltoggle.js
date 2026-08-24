function scrolltoggle(elem) {

    if( elem.length == 0 ) {
        return;
    }


    var $window = jQuery(window);
    var viewport_top = $window.scrollTop();
    var viewport_height = $window.height();
    var viewport_bottom = viewport_top + viewport_height;
    var $elem = jQuery(elem);
    var top = $elem.offset().top;
    var height = $elem.height();
    var bottom = top + height;

   /*
    return (top >= viewport_top && top < viewport_bottom) ||
    (bottom > viewport_top && bottom <= viewport_bottom) ||
    (height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
    */

    return (top <= viewport_bottom);

}


  (function( $ ){

    window.addEventListener('scroll', function(e) {

         $('[data-fx]').each(function(){
                if( scrolltoggle( jQuery( $(this) ) ) ) { /* Pass element id/class you want to check */
                    $(this).attr('data-scrollview','1');
                } 
                else{
                    $(this).attr('data-scrollview','0');
                }  
        });
    });
 
    $(window).scrollTop($(window).scrollTop()+1);
  })(jQuery);