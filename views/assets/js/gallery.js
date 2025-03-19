




     fetch(manifest)
      .then(response => response.json())
      .then(data =>{
        jQuery("#collection-label").text(data.label.en[0]);
        jQuery("#collection-summary").text(data.summary.en[0]);
      
	 data.items.forEach((item, index) => {
	    item.counter = index + 1;
	    jQuery(".card-gallery").append(cardTemplate(item)); 
	 });
        })
      .catch((err) => { console.error(err); });
      


/*
var mirador = Mirador.viewer({
	id: "my-mirador",
	windows: [{ manifestId: manifest }],
	workspace: { showZoomControls: true },
	workspaceControlPanel: { enabled: false  }
});

*/

	/****************************
	* close the flyout
	*****************************/
	
	  jQuery(document).on('click','.sidebar-close',function(e) {
	    jQuery('#sidebar').removeClass('shown');
	    e.preventDefault();
	  });   

      
    function cardTemplate(o) {
        var rand = Math.floor(Math.random() * 10000);
        var label = o.label.en[0];
        var displaylabel = o.label.en[0];
        //if (o.label.en[0].length > 24) {
        //    displaylabel = o.label.en[0].substring(0, 24) + "...";
        //}

        var html = "<div class='card' id='card" + rand + "' data-id='" + o.id + "' style='position:relative'><div class='card-counter'>"+ o.counter +"</div><div class='card-img'><img class='card-img-top' src='" + o.thumbnail[0].id + "' alt='" + label + "' title='" + label + "'></div><div class='card-body'><p class='card-title'>" + displaylabel +"</p></div><div class='card-footer'><div class='item-toolbar'><a href='#' class='openModal' data-target='https://mcgrawcenter.github.io/mirador/?manifest=" + o.id + "'><img src='" + siteurl + "/views/assets/images/mirador_logo.png' class='icon'></a><a href='#' class='openModalExternal' data-target='" + o.id + "'><img src='" + siteurl + "/views/assets/images/iiif_logo.png' class='icon'></a><a href='#' class='openModal' data-target='https://mcgrawcenter.github.io/croppingtool/?manifest=" + o.id + "'><img src='" + siteurl + "/views/assets/images/crop.svg' class='icon'></a><input type='checkbox' class='sel' name='sel'/></div></div></div>";
        return html;
     
    }
    
    /**********************************
    * This is for the mirador and cropping tool icons
    *****************************/
    jQuery(document).on("click",'.openModal',function(e){
      e.preventDefault();
      var target = jQuery(this).attr('data-target');
      if (e.ctrlKey) {
        window.open(target, '_blank');
      }
      else {
        jQuery("#modal-body-iframe").attr("src",target);
        jQuery("#external_link").attr("href",target);
        var galleryModal = new bootstrap.Modal(document.getElementById('croppingToolModal'), { keyboard: false });
        galleryModal.show();
      }
    });
    
    /************************************
    * this is for the IIIF icon
    ********************************/
    jQuery(document).on("click",'.openModalExternal',function(e){
      e.preventDefault();
      var target = jQuery(this).attr('data-target');
      if (e.ctrlKey) {
        window.open(target, '_blank'); 
      }
      else {      
        jQuery.get(target, function(data){
          jQuery("#external-modal-body-text").val(target);
          jQuery(".external-modal-body-textarea").text(JSON.stringify(data, null, 2));
        });
        var galleryModal = new bootstrap.Modal(document.getElementById('externalModal'), { keyboard: false });
        galleryModal.show();
      }
    });
    
    /***************************
     * select gallery view - currently unused
     *******************/
    jQuery(".view").click(function(e){
      if(jQuery(this).hasClass('grid')) { 
        jQuery(".card-gallery").addClass('grid');
      }
      else { 
        jQuery(".card-gallery").removeClass('grid');
      }
      e.preventDefault();
    });  
    
    /***************************
     * select individual cards
     *******************/
     
    jQuery(document).on("click",".sel",function(e){

      if(jQuery(this).hasClass('selected')) {
        jQuery(this).removeClass('selected');
        jQuery(this).closest('.card').removeClass('selected');
      }
      else {
        jQuery(this).addClass('selected');
        jQuery(this).closest('.card').addClass('selected');
      }
      
      selected = [];
      jQuery('.sel').each(function(i,v){
        if(jQuery(v).hasClass('selected')) { 
        selected.push(i);
        }
      });

      if(selected.length > 0) { 
        jQuery("#mirador_link").attr('data-target',"https://mcgrawcenter.github.io/mirador/?manifest="+siteurl+"/"+id+"/manifest/"+selected.join(','));
        jQuery("#croppingtool_link").attr('data-target',"https://mcgrawcenter.github.io/croppingtool/?manifest="+siteurl+"/"+id+"/manifest/"+selected.join(','));
        jQuery("#manifest_link").attr('data-target',siteurl+"/"+id+"/manifest/"+selected.join(','));
      }
      else {
        jQuery("#mirador_link").attr('data-target',"https://mcgrawcenter.github.io/mirador/?manifest="+siteurl+"/"+id+"/manifest");
        jQuery("#croppingtool_link").attr('data-target',"https://mcgrawcenter.github.io/croppingtool/?manifest="+siteurl+"/"+id+"/manifest");
        jQuery("#manifest_link").attr('data-target',siteurl+"/"+id+"/manifest");
      }

    });       
     
     /*
    jQuery(document).on("click",".card",function(e){
      if(jQuery(this).hasClass('selected')) {
        jQuery(this).removeClass('selected');
      }
      else {
        jQuery(this).addClass('selected');
      }
      
      selected = [];
      jQuery('.card').each(function(i,v){
        if(jQuery(v).hasClass('selected')) { 
        selected.push(i);
        }
      });

      if(selected.length > 0) { 
        jQuery("#mirador_link").attr('data-target',"https://mcgrawcenter.github.io/mirador/?manifest="+siteurl+"/"+id+"/manifest/"+selected.join(','));
        jQuery("#croppingtool_link").attr('data-target',"https://mcgrawcenter.github.io/croppingtool/?manifest="+siteurl+"/"+id+"/manifest/"+selected.join(','));
        jQuery("#manifest_link").attr('data-target',siteurl+"/"+id+"/manifest/"+selected.join(','));
      }
      else {
        jQuery("#mirador_link").attr('data-target',"https://mcgrawcenter.github.io/mirador/?manifest="+siteurl+"/"+id+"/manifest");
        jQuery("#croppingtool_link").attr('data-target',"https://mcgrawcenter.github.io/croppingtool/?manifest="+siteurl+"/"+id+"/manifest");
        jQuery("#manifest_link").attr('data-target',siteurl+"/"+id+"/manifest");
      }


      e.preventDefault();
    });  
    */
    
    
      
