(function( $ ){
  $(window).on("load", function() {
    const $window = $(window);
    
    /* Select all images with data-parallax="1" */
    const $parallaxImages = $('[data-parallax]');
    
    $parallaxImages.each(function() {
        $(this).attr('width', $(this).width());
        $(this).attr('height', $(this).height());


    });
  

/* ------ Function to update parallax effect for images in a container or a site background image ----- */
    function updateParallax() {

        $parallaxImages.each(function() {
  
   /* ---------- Gather the dimensional properties of the image, image contianer, and browser ---------- */ 
                    const $image = $(this);
                    const $img_ratio = $(this).attr('height') / $(this).attr('width')
                    const $win_ratio = $window.height() / $window.width();
                    const $container_ratio = $(this).parent().height() / $(this).parent().width();
                    $image.parent().css('background','black');

                    $image.parent().attr('data-ratio', $win_ratio);
                    $image.attr('data-ratio', $img_ratio);
                      
                    const $parent = $image.closest('.mod');
                    
                    // Get parent and image dimensions
                    const parentTop = $parent.offset().top;
                    const containerHeight = $parent.outerHeight(); // Renamed to avoid conflict
                    const windowHeight = $window.height();
                    const scrollTop = $window.scrollTop();
                    


                        // Check if element is in viewport
                      

                        if($image.attr('data-parallax')=='img'){

/* ---------- if dimension ratio of the browser is larger than the image do parallax ---------- */
                             if($container_ratio<$img_ratio){
                                $image.css({'position':'absolute','height':'auto','left':'0px'});
                                if (scrollTop + windowHeight > parentTop && scrollTop < parentTop + containerHeight) {
                                        /* Calculate  percentage scrolled of window scrolled to the top of the image container */
                                        const scrollPercentage = (scrollTop + windowHeight - parentTop) / (windowHeight + containerHeight);
                                     
                                        const imageHeight = $image.height();

                                        /* Offset image height to not scroll out of view */
                                        const maxOffset = imageHeight - containerHeight;
                                        
                                        /* Calculate new position */
                                        const offset = -(maxOffset * scrollPercentage)
                                        
                                        /* Apply transform for smooth parallax effect */
                                        $image.css('transform', 'translateY('+offset+'px)');
                                }
                            }
                            else{
                                 /* if dimension ratio of the browser is less than the image size the image to the window */
                                $image.css({'position':'absolute','width':'100%', 'height':'100%', 'left':'0px'});
                                const $imgh = parseInt($image.parent().css('padding-top')) +parseInt($image.parent().css('padding-bottom')) + parseInt($image.parent().height());
                                $image.css('height',$imgh+'px');
                                $image.css('transform', 'translateY(0px)');


                            }
                         }

/* ------------ if Parallax Image is a full size page background ----------*/
                        if($image.attr('data-parallax')=='bg'){
                            /* if dimension ratio of the browser is larger than the image do parallax */
                             if($win_ratio<$img_ratio){
                                $image.css({'position':'absolute','height':'auto','width':'100%','left':'0px'});
                                 if($window.height()<$image.height()){
                                    /* Calculate  percentage scrolled of window*/
                                    const wintop = $window.scrollTop(), docheight = $(document).height(), winheight = $window.height();
                                    const scrollperc = (wintop*100 / (docheight-winheight));
                                    
                                     /* Negatively position the top of the image, the same amount of the browser 
                                     is scrolled (minus the height of the browser so the image doesn't scroll above browser bottom)*/
                                    const $imgtop = (($(this).height() - winheight) * scrollperc) / 100;
                                    $image.css('transform', 'translateY(-'+$imgtop+'px)');

                                 }
                            }

                            else{
                                /* if dimension ratio of the browser is less than the image size the image to the window */
                                $image.css({'position':'absolute','width':'100%', 'height':'100%', 'left':'0px'});
                                $image.css('object-fit','cover');
                                $image.css('object-position','center center');
                                $image.css('transform', 'translateY(0px)');


                            }
                               

                        }
                        



            
        });
    }
    // Initial call to set positions
    updateParallax();
    
    // Update on scroll and window resize
    $window.on('scroll resize', updateParallax);
    $(window).scroll();
});
})(jQuery);