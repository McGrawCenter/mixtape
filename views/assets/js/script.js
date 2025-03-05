jQuery(document).ready(function() {




    load();


    /***************************
     * if label or summary changes, update json
     *******************/
    jQuery("#collection-label").keyup(function() {
        json.label.en[0] = jQuery(this).val();
    });
    jQuery("#collection-summary").keyup(function() {
        json.summary.en[0] = jQuery(this).val();
    });
    /***************************
     * if label or summary is clicked, make editable
     *******************/
    jQuery('#collection-label').click(function(e) {
        jQuery(this).attr('contenteditable', "true");
    });
    jQuery('#collection-summary').click(function(e) {
        jQuery(this).attr('contenteditable', "true");
    });
    /***************************
     * if label or summary loses focus, save
     *******************/
    jQuery("#collection-label").blur(function() {
        save();
    });
    jQuery("#collection-summary").blur(function() {
        save();
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
    


    /***************************
     * if tiles are dragged, update json
     *******************/
    jQuery(".card-gallery").sortable({
        "update": function() {
            updateItems();
        }
    });


    /***************************
     * add manifest click
     *******************/
    jQuery("#manifest-add").click(function(e) {
        var url = jQuery("#manifest").val();
        // if the url has a ?manifest= parameter, get rid of it
        if(url.indexOf('manifest=') > 0) { url = getQueryVariable(url);  }        
        if (url !== "") {
            // check if manifest is already in manifest
            exists(url);
            // if not:
            if (!exists(url)) {
                parse(url);
            } else {
                jQuery("#message").text("manifest already exists in list");
            }
        }
        e.preventDefault();
    });


    /***************************
     * save button click
     *******************/
    jQuery(".save").click(function(e) {
        save();
        e.preventDefault();
    });



    /***************************
     * delete tile
     *******************/
    jQuery(document).on("click",".remove",function(e) {
        var id = jQuery(this).attr('rel');
        console.log(id);
        var index = null;
        jQuery.each(json.items, function(i, v) {
            
            if (v.id == id) {
                console.log('removing '+i);
                index = i;
            }

        });
        if (index !== null) {
            json.items.splice(index, 1);
            console.log(json);
            load();
        }
        load();
        save();
        e.preventDefault();
    });

    /***************************
     * click on collection summary, allow for larger rich text editor
     *******************/
/*
    jQuery("#infoicon").click(function(){
      if(!jQuery("#infoeditor").hasClass('shown')) {  jQuery("#infoeditor").addClass('shown'); }
      else { jQuery("#infoeditor").removeClass('shown') }
    });  
 */   
    jQuery('#editor').blur(function() {
       save();
    });
    jQuery("#editor").focusout(function(){
       save();
    });
    
 


    /*************************** FUNCTIONS *************************/


    function save() {

        json.label.en[0] = escapeString(jQuery("#collection-label").text());
        json.summary.en[0] = escapeString(jQuery("#collection-summary").text());
        
        var html = quill.root.innerHTML;

        var d = {
            'action': 'save',
            'token': token,
            'html': html,
            'json': JSON.stringify(json)
        }
        jQuery.post('../save', d, function(response) {
            console.log("saved",response);
        });

        var src = jQuery(".save img").attr('src').replace('save', 'save-green');
        jQuery(".save img").attr('src', src);
        const myTimeout = setTimeout(function() {
            var src = jQuery(".save img").attr('src').replace('save-green', 'save');
            jQuery(".save img").attr('src', src);
        }, 3000);
    }





    function load() {
        var label = json.label.en[0];
        var summary = json.summary.en[0];
        jQuery(".card-gallery").empty();
        jQuery("#collection-label").html(label);
        jQuery("#collection-summary").html(summary);
        jQuery.each(json.items, function(i, item) {
            jQuery(".card-gallery").append(cardTemplate(i,item));
        });
        if(json.items.length == 0) { console.log('This is your first import'); }
    }


    // save re-sequenced items
    function updateItems() {
        var items = jQuery('.card');
        var newarr = [];
        jQuery.each(items, function(i, v) {
            jQuery.each(json.items, function(j, k) {
                if (jQuery(v).attr('data-id') == k.id) {
                    newarr.push(k);
                }
            });
        });
        json.items = newarr;
        save();
    }




    function parse(url) {

        url = getQueryVariable(url);
        
        // if this is an Internet Archive URL
        // convert it to a manifest
        if(url.indexOf("archive.org") > 0 && url.indexOf("details") > 0) { 
           url = internetArchive2Manifest(url);
        }    

        // if this is a Wikimedia Commons URL
        // convert it to a manifest
        if(url.indexOf("commons.wikimedia.org") > 0 && url.indexOf("File:") > 0) {
           url = wikimediaCommons2Manifest(url);
        } 
        
        
        const vault = HyperionVault.globalVault();
        
        
        var item = {
            'id': '',
            'type': 'Manifest',
            'label': {
                'en': ['']
            },
            'thumbnail': [{
                'id': '',
                'type': 'Image',
                'format': 'image/jpeg'
            }]
        }

        vault.loadManifest(url).then((m) => {

            var type = m.type;


            switch (type) {
                case 'Collection':

		    // if this is a collection manifest
		    // and there are no existing items in this collection,
		    // also import the label and summary from the collection manifest
		    if(json.items.length < 1) {
		       json.label.en[0] = getFirstValue(m.label);
		    }
		    if(m.items.length > 50) {
		      alert("The collection import is limited to 50 items");
		      m.items = m.items.slice(0, 49);
		    }
		    
                    m.items.forEach((item) => {
                        parse(item.id);
                    });
                    break;

                default:

                    var item = {}

                    item.id = url;
                    item.type = 'Manifest';
                    item.label = {}
                    item.label.en = []
                    item.label.en.push(getFirstValue(m.label));
                    item.thumbnail = [{
                        'id': '',
                        'type': 'Image',
                        'format': 'image/jpeg'
                    }]
                    
      console.log(m);
      var w = vault.fromRef(m.items[0]);
      console.log(w);
      var x = vault.fromRef(w.items[0]);
      console.log(x);
      var y = vault.fromRef(x.items[0]);
      console.log(y); 
      var z = vault.fromRef(y.body[0]);
      console.log(z.service[0]);
                      /*    
                    var p1 = vault.get(m.items[0]);
                    var p2 = vault.get(p1.items[0]);
                    var p3 = vault.get(p2.items[0]);
                    var p4 = vault.get(p3.body[0]);
			*/

                    if(Object.prototype.toString.call(z.service) == '[object Array]') {
                      if(Object.hasOwn(z.service[0], 'id'))  { item.thumbnail[0].id = z.service[0].id + "/full/,300/0/default.jpg"; }
                      if(Object.hasOwn(z.service[0], '@id')) { item.thumbnail[0].id = z.service[0]['@id'] + "/full/,300/0/default.jpg"; }
		     }
                    else {
                      if(Object.hasOwn(z.service, 'id'))  { console.log('1');item.thumbnail[0].id = z.service.id + "/full/,300/0/default.jpg"; }
                      if(Object.hasOwn(z.service, '@id')) { console.log('2');item.thumbnail[0].id = z.service['@id'] + "/full/,300/0/default.jpg"; }
                    }

                   

                    json.items.push(item);

                    jQuery(".card-gallery").append(cardTemplate(0, item));
                    jQuery("#manifest").val("");
                    save();

                    break;
            }
        });
    }




    /*************************** DRAG AND DROP *************************/



    $("html").on("dragover", function(event) {
        event.preventDefault();
        event.stopPropagation();
        $("#dropzone").addClass('open');
    });

    $("html").on("dragleave", function(event) {
        event.preventDefault();
        event.stopPropagation();
        $("#dropzone").removeClass('open');
    });

    $("html").on("drop", function(event) {
        event.preventDefault();
        event.stopPropagation();
        var d = event.originalEvent.dataTransfer;
        var url = d.getData("text");
        // if the url has a ?manifest= parameter, get rid of it
        if(url.indexOf('manifest=') > 0) { url = getQueryVariable(url);  }
        jQuery("#manifest").val(url);
        $("#dropzone").removeClass('open');
        if (url !== "") {
            // check if manifest is already in manifest
            exists(url);
            // if not:
            if (!exists(url)) {
                parse(url);
            } else {
                jQuery("#message").text("manifest already exists in list");
            }
        }
    });


    function exists(id) {
        var match = false;
        jQuery.each(json.items, function(i, v) {
            if (v.id == id) {
                console.log('manifest already exists in collection');
                match = true;
            }
        });
        return match;
    }




    function cardTemplate(sort, o) {
        var rand = Math.floor(Math.random() * 10000);
        var label = o.label.en[0];
        var displaylabel = o.label.en[0];
        //if (o.label.en[0].length > 24) {
        //    displaylabel = o.label.en[0].substring(0, 24) + "...";
        //}

        var html = "<div class='card' id='card" + rand + "' data-sort='"+sort+"' data-id='" + o.id + "' style='position:relative'><div class='card-img'><img class='card-img-top' src='" + o.thumbnail[0].id + "' alt='" + label + "' title='" + label + "'></div><div class='card-body'><p class='card-title'>" + o.label.en[0] + "</p></div><div class='card-footer'><div class='item-toolbar'><a href='https://mcgrawcenter.github.io/mirador/?manifest=" + o.id + "' target='_blank'><img src='" + siteurl + "/views/assets/images/mirador_logo.png' class='icon'></a><a href='" + o.id + "' target='_blank'><img src='" + siteurl + "/views/assets/images/iiif_logo.png' class='icon'></a><a href='https://mcgrawcenter.github.io/croppingtool/?manifest=" + o.id + "' target='_blank'><img src='" + siteurl + "/views/assets/images/crop.svg' class='icon'></a><a href='#' class='remove' rel='" + o.id + "'><img src='" + siteurl + "/views/assets/images/x.svg' class='icon'></a></div></div></div>";
        return html;
    }




    /************************************
     * this is used to get metadata regardless of whether the
     * metadata is stored in objects, arrays, or strings
     ************************************/
    function getFirstValue(o) {
        if (typeof o === "object") {
            var x = Object.values(o)[0];
            if (typeof x == 'object') {
                var str = Object.values(x)[0].replace(/(\r\n|\n|\r)/gm, "").replace(/'/g, "&#39;");
                return str;
            } else {
                return x;
            }
        } else if (typeof o === "array") {
            var str = o.label[0].replace(/(\r\n|\n|\r)/gm, "").replace(/'/g, "&#39;");
            str.replace(/'/g, "\\'");
            return str;
        } else if (typeof o === "string") {
            var str = o.replace(/(\r\n|\n|\r)/gm, "").replace(/'/g, "&#39;");
            str.replace(/'/g, "\\'");
            return str;
        } else {
            return "";
        }
    }

    /************************************
     * manifest is contained in url string as 
     * a query var. We need to extract it
     ************************************/

    function getQueryVariable(urlstr) {
    
        var parts = urlstr.split('?');
        if (parts.length > 1) {
            var vars = parts[1].split('&');

            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split('=');
                if (decodeURIComponent(pair[0]) == 'manifest') {
                    return decodeURIComponent(pair[1]);
                }
                return urlstr;
            }
        } else {
            return urlstr;
        }
        return 'manifest not found';
    }
    
    
    function escapeString(str) {
      //str = str.replace("<","&lt;");
      //str = str.replace(">","&gt;");
      str = str.replace(/"/g,'\"');
      //str = str.replace("&","&amp;");
      str = str.replace(/'/g,"\'");
      return str;
    }


  /************************************
  * 
  *************************************/
  function internetArchive2Manifest (url) {
     var parts = url.split("/");
     for(var x=0;x<=parts.length;x++) { 
       if(parts[x] == 'details') { 
         var ia_id = parts[x+1];
         return "https://iiif.archive.org/iiif/"+ia_id+"/manifest.json";
       }
     }     
  }

  /************************************
  * 
  *************************************/
  function wikimediaCommons2Manifest (url) {  
    var parts = url.split("File:");
    return "https://iiif.juncture-digital.org/wc:"+parts[1]+"/manifest.json";  
  }


});
