sidebar_visibility = '';
checkfor_sidebar ='';



(function($) {


/* ----- Open the Sidbar panel on page load----*/
 const isEditorSidebarOpened = wp.data.select( 'core/edit-post' ).isEditorSidebarOpened();
  if ( ! isEditorSidebarOpened ) {
      wp.data.dispatch( 'core/edit-post' ).openGeneralSidebar('edit-post/document');
    }




/* ----- If plugin option is set, Sidebar draggable-----*/
checkfor_sidebar = function(){

  if($(".interface-interface-skeleton__sidebar.ui-draggable").length<1){
     if($("html.draggable-sidebar").length>0){
         $(".interface-interface-skeleton__sidebar").append('<div class="dragger"></div><div class="sizer"></div');
         $(".interface-interface-skeleton__sidebar").draggable({handle:".dragger"}).resizable({handles:{"sw:":".sizer"}});
         $(".interface-interface-skeleton__sidebar.ui-draggable").css({'height': '50vh','right': '30px','top': '30px','left': 'auto','width':'30vw'});     
         
       }
  }


   if($('.interface-pinned-items button[aria-controls*="edit-post"]').hasClass('is-pressed')){
      $('html:not(.show-block-panel').addClass('show-block-panel');
   }
   else{
    $('html.show-block-panel').removeClass('show-block-panel');
   }

if($(".admin-ui-navigable-region.edit-post-meta-boxes-main").length>0){

  $('.admin-ui-navigable-region.edit-post-meta-boxes-main').removeClass('admin-ui-navigable-region').removeClass('edit-post-meta-boxes-main');
  }
  
}


/* Disable Dragable Post Meta Boxes */



/* ----- Force the showing of the Block settings in the Sidebar whena  BLock is selected-----*/
var selectedblock;

$('#wpbody').click(function(){
  var focused = $(this).find('.is-selected');
  if($(focused).hasClass('wp-block')){

    if(selectedblock != $(focused).attr('id')){
      selectedblock = $(focused).attr('id');
      $('[aria-label=\"Switch to Preview\"]').click();
      
      /* Open Side bar */
      if ( ! isEditorSidebarOpened ) {
        wp.data.dispatch( 'core/edit-post' ).openGeneralSidebar('edit-post/block');
      }

    }
    else{
       selectedblock = $(focused).attr('id');

    }

  }

});




/* ----- Display Custom Block name in Editor-----*/
 let blockLoaded = false;

 let blockLoadedInterval = setInterval(function() {
      /* console.log('set block load interval') */

      var block = $('.block-editor-block-inspector');
      var acf_header = $(block).find('.block-editor-block-card__title');
     
      if($(block).find('.block-editor-block-card__description').length){
           var acf_descr = $(block).find('.block-editor-block-card__description').html();
           acf_descr =  acf_descr.replace('For ', '');
      }
     
          checkfor_sidebar ();


          $(block).find('.description').each(function(){
                var acf_cus_label ='';
                var acf_val = $(this).html();
             
                  if(acf_val == 'Customize this module\'s name'){
                        acf_cus_label_prepend = $(this).parent().parent().attr('data-name').split("_");
                        var acf_cus_label= $(this).parent().parent().find('.acf-input-wrap input').val();
                         var acf_cus_label_prepend= (acf_cus_label_prepend[0].toUpperCase())+': ';
                       
                          console.log('cusotmize name'+ acf_cus_label);
                          if(acf_cus_label!='' && acf_header.length>0){
                          
                              if(acf_header.find('.alttitle').length<1){
                                acf_header.append('<span class="alttitle"></span>');
                              }
                              $(acf_header).find('.alttitle').html(acf_cus_label_prepend+acf_cus_label);
                              
                           
                          }
                          else{
                              $(acf_header).find('.alttitle').remove();
                          }
                  }
                 
              })

  }, 1500);




})(jQuery);
