

jQuery(document).ready(function(){


  jQuery(document).on("click",".tile-image",function(e){
    jQuery(this).addClass('active');
    var checkbox = jQuery(this).find('.selected');
    if(checkbox.attr('checked') == 'checked') {  checkbox.attr('checked', false); }
    else { checkbox.attr('checked', true); }
    e.preventDefault();
  });
  
  
  
  

  jQuery('.makeCollection').click(function(e){
    jQuery(".tile-image.active").each(function(i,v){
      console.log(jQuery(v).attr('data-manifest'));
    });
    e.preventDefault();
  });
  

});
