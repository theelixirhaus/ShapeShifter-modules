(function( $ ){
    if($('.bg-video').length){
        /* console.log($('.videos > div > .vid-pos').length); */
        $.each($('.bg-video'),function(){
            var thisv = $(this);

            var zoom =1;

            $(window).resize(function(){
                $(thisv).css('height',$(thisv).height());
                
                $(thisv).find('video').css('height','100%').css('width','100%');
                console.log('this is '+ $(thisv).attr('class'));
                console.log('this is '+ $(thisv).attr('data-img-height'));
                var origH=$(thisv).attr('data-img-height');
                var origW= $(thisv).attr('data-img-width');

                var ratio = (origH*100)/origW;


                 if($(thisv).attr('data-zoom')){
                    zoom = $(thisv).attr('data-zoom');
                 }

                var mw = $(thisv).width() * zoom;
                var mh = $(thisv).height() * zoom;

          
                var newW = (mw*100)/origW;
                var newH = (mh*100)/origH;
                

                /*
                console.log('This mod '+$(thisv).width());

                 console.log('p Width'+$(thisv).width());
                console.log('p Height'+$(thisv).height());

                 console.log('New Width '+newW);
                 console.log('New Height'+newH);
                 console.log('Orig Width'+origW);
                 console.log('Orig Height'+origH);
                 console.log('Slide Width'+mw);
                 console.log('Slide Height'+mh);
                 console.log('Ratio '+ratio);

                 */

                hoffset = 0;
                woffset = 0;

                if(origW>=origH){
                    if($(thisv).width()>$(thisv).height()){
                        $(thisv).find('.vid-pos').css('width',mw).css('height',(mw*(ratio/100)));
                        console.log('hieight '+(mw*(ratio/100)));
                        var woffset = ($(thisv).height() - mh)/2;
                    }
                    else{
                        $(thisv).find('.vid-pos').css('height',mh).css('width',(mw*(ratio/100)));
                         console.log('hieight2 '+(mw*(ratio/100)));
                        var hoffset = ($(thisv).width() - mw/2);
                    }

                }

                $(thisv).find('.vid-pos').css('top',0 - hoffset);
                $(thisv).find('.vid-pos').css('left', 0 - woffset);


                $(window).scroll();
                
            });
        });

        $(window).resize();

    }

})(jQuery);
