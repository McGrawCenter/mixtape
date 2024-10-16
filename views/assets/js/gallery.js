

     fetch(manifest)
      .then(response => response.json())
      .then(data =>{
      
      console.log(data.label);
        jQuery("h2").text(data.label.en[0]);
        jQuery("h5").text(data.summary.en[0]);
      
	 data.items.forEach((item) => {
	    //
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

      
    function cardTemplate(o) {
        var rand = Math.floor(Math.random() * 10000);
        if (o.label.en[0].length > 80) {
            o.label.en[0] = o.label.en[0].substring(0, 80) + "...";
        }

        var html = "<div class='card' id='card" + rand + "' data-id='" + o.id + "'><a class='card-img-top-frame' href='https://mcgrawcenter.github.io/mirador/?manifest=" + o.id + "'><img class='card-img-top' src='" + o.thumbnail[0].id + "' alt='Card image cap'></a><div class='card-body'><p class='card-title'>" + o.label.en[0] + "</p></div><div class='card-footer'><div class='item-toolbar'><a href='#' class='openModal' data-target='https://mcgrawcenter.github.io/croppingtool/?manifest=" + o.id + "'><img src='" + siteurl + "/views/assets/images/crop.svg' class='icon'></a><a href='#' class='openModal' data-target='https://mcgrawcenter.github.io/mirador/?manifest=" + o.id + "'><img src='" + siteurl + "/views/assets/images/mirador_logo.png' class='icon'></a><a href='#' class='openModalExternal' data-target='" + o.id + "'><img src='" + siteurl + "/views/assets/images/iiif_logo.png' class='icon'></a></div></div></div>";
        return html;
     
    }
    
    
    jQuery(document).on("click",'.openModal',function(e){
      e.preventDefault();
      var target = jQuery(this).attr('data-target');
      console.log(target);
      jQuery("#modal-body-iframe").attr("src",target);
      var galleryModal = new bootstrap.Modal(document.getElementById('croppingToolModal'), { keyboard: false });
      galleryModal.show();
    });
    
    jQuery(document).on("click",'.openModalExternal',function(e){
      e.preventDefault();
      var target = jQuery(this).attr('data-target');
      jQuery.get(target, function(data){
        jQuery("#external-modal-body-text").val(target);
        jQuery(".external-modal-body-textarea").text(JSON.stringify(data));
      });
      var galleryModal = new bootstrap.Modal(document.getElementById('externalModal'), { keyboard: false });
      galleryModal.show();
    });
    
    /***************************
     * select gallery view
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
