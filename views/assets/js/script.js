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
        e.preventDefault();
    });




    /*************************** FUNCTIONS *************************/


    function save() {

        json.label.en[0] = escapeString(jQuery("#collection-label").text());
        json.summary.en[0] = escapeString(jQuery("#collection-summary").text());
        

        var d = {
            'action': 'save',
            'token': token,
            'json': JSON.stringify(json)
        }
        jQuery.post('../save', d, function(response) {
            console.log(response);
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
        
        const vault = new IIIFVault.Vault();
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

        vault.loadManifest(url).then(async (m) => {

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
                    var p1 = vault.get(m.items[0]);
                    var p2 = vault.get(p1.items[0]);
                    var p3 = vault.get(p2.items[0]);
                    var p4 = vault.get(p3.body[0]);
                    var service = p4.service[0];
                    if (service.type == 'ImageService3') {
                        item.thumbnail[0].id = service.id + "/full/,600/0/default.jpg";
                    } else {
                        item.thumbnail[0].id = service['@id'] + "/full/,600/0/default.jpg";
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
                match = true;
            }
        });
        return match;
    }




    function cardTemplate(sort, o) {
        var rand = Math.floor(Math.random() * 10000);
        if (o.label.en[0].length > 80) {
            o.label.en[0] = o.label.en[0].substring(0, 80) + "...";
        }

        var html = "<div class='card' id='card" + rand + "' data-sort='"+sort+"' data-id='" + o.id + "'><a class='card-img-top-frame' href='https://mcgrawcenter.github.io/mirador/?manifest=" + o.id + "' target='_blank'><img class='card-img-top' src='" + o.thumbnail[0].id + "' alt='Card image cap'></a><div class='card-body'><p class='card-title'>" + o.label.en[0] + "</p></div><div class='card-footer'><div class='item-toolbar'><a href='https://mcgrawcenter.github.io/croppingtool/?manifest=" + o.id + "' target='_blank'><img src='" + siteurl + "/views/assets/images/crop.svg' class='icon'></a><a href='https://mcgrawcenter.github.io/mirador/?manifest=" + o.id + "' target='_blank'><img src='" + siteurl + "/views/assets/images/mirador_logo.png' class='icon'></a><a href='" + o.id + "' target='_blank'><img src='" + siteurl + "/views/assets/images/iiif_logo.png' class='icon'></a><a href='#' class='remove' rel='" + o.id + "'><img src='" + siteurl + "/views/assets/images/x.svg' class='icon'></a></div></div></div>";
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


});
