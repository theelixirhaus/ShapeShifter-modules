(function( $ ){
	$('.m3-rows .bleed').each(function(){

	var bleeder=$(this);

	bleeder.closest('.mod-m3').addClass('has-bleed');

	var bleederbox = bleeder.closest('.mod-m3');
	bleeder.find('.mod-contain').css('max-width',(bleeder.width()+ parseInt(bleeder.find('.mod-contain').css('padding-left'))));


	/* $(this).addClass(evenodd); */

	var maxw = parseFloat(bleederbox.find('.dp-contain').css('max-width'));

	if(maxw!== undefined){
		maxw = $(window).width();
	}

	/* ------------------------- 
	 Difficulties in determining sizing put this on hold 
	 ---------------------------*/


		/* Determin if column is left or right  side of page */
		/*if(evenodd == 'even'){
			$(window).resize(function(){
					if($(window).width()>768){
				
						bleeder.find('.mod').width($(window).width() - bleeder.offset().left);
							}
					else{
						bleeder.find('.mod').width('auto');
					}
					
				});

				bleeder.find('.mod').find('.mod-txt').css('max-width', bleeder.width());	
				

		}

		else{
			   $(window).resize(function(){
		
					if($(window).width()>768){
						bleeder.find('.mod').width(bleeder.parent().find('>div:not(.bleed)').offset().left);
							
						
					}
					else{
						bleeder.find('.mod').width('auto');
					}
					
				});

			   bleeder.find('.mod').find('.mod-txt').css('max-width', bleeder.width());
					


		}*/


		
	});

	$('.mod-m3 .expand-more').each(function(){
		$(this).click(function(){
			$(this).toggleClass('expanded');
			if($(this).hasClass('expanded')){
			$(this).find('.expander').css('height',$(this).find('.sizer').height());

			}
			else{
				$(this).find('.expander').css('height','1px');
			}
		});

	});


	$(window).resize();
})(jQuery);