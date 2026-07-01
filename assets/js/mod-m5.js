
(function( $ ){

     $(window).resize(function() {

        if ($('.mod-m5').length) {
            $('.mod-m5').each(function() {
                var m5_mod = $(this);
                m5_mod.find('.m5-expander').each(function() {
                    $(this).css('height', $(this).find('.m5-sizer').innerHeight());
                });

                m5_mod.find('.m5-section-hit').click(function(){
                    $(window).resize();
                    m5_mod.find('.m5-section').removeClass('active');
                    $(this).parent().addClass('active');
           
                });
            });
        }
    });

   $(window).resize();
 })(jQuery);