<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Mixtape</title>
    <meta name="description" content="">
    <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> 
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/openseadragon/5.0.1/openseadragon.min.js" integrity="sha512-gPZzE+sKmE0kvcjMxW431ef5b5T5QOADV9Gij0isPw2oLATd1IZW7dmDmKh7F2e5BfwjQyAfFp3/OF0fVMOF7Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  

    
    <link rel="stylesheet" href="<?= $siteurl ?>/views/assets/css/style.css">
    <style>
    .p-3 {  padding: 0rem !important; }
    .carousel-item {
    height: 800px;
  background: #DDD;
  text-align: center;
    }
    .carousel-item img {
    max-height:100%;
    }    
    </style>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@iiif/vault@latest/dist/index.umd.js?ver=6.6.1" id="canvaspanel-js"></script>
    
    <script>
	var json = <?= $json; ?>
	
    </script> 
  </head>
  <body>
  

<div class="container-fluid" id="main" style="margin:0px;">
  <div class="row">
    <div class='col-12'>
    
    <div id="carouselExample" class="carousel slide">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div id="openseadragon1" style="height: 100%; margin: 0 auto;"></div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    
    
    </div>
  </div>
</div>




<script type="text/javascript">



     var images = [];
     var h = window.innerHeight;
     var elem = document.getElementsByClassName('carousel-item');

     for (var i = 0; i < elem.length; i++) {
       elem[i].style.height = h+'px';
     }
     
     jQuery.each(json.items, function(i,v){

			    const vault = new IIIFVault.Vault();
			    vault.loadManifest(v.id).then(async (manifest) => {

			       //var items = vault.get(items);

			       manifest.items.forEach((it) => {
			            var canvas = it.id;
			            var label = getFirstValue(it.label);
			            var service = "error";
			            var z = vault.get(it);

			            if(z.items[0]) {
			              var i = vault.get(z.items[0]);
			              if(i.items[0]) {
			                var j = vault.get(i.items[0]);
			                if(j.body[0]) {
			                  var k = vault.get(j.body[0]);
			                  if(k.service != undefined) {
			                     service = k.service[0]['@id'];
			                     if(!service) {
			                         service = k.service[0]['id'];
			                     }
			                  }
			                }
			              }
			            }
			            // remove trailing slash from service url if necessary
			            service = service.replace(/\/$/, "");
			            var x = {'service':service, 'manifest':v.id , 'canvas': canvas, 'label': label}
			            
			            
			            
			            
			            
			            var item = "<div class='carousel-item'>\
			  	      <img src='"+x.service+"/full/600,/0/default.jpg'/>\
				      </div>";
				    console.log(item);
			            jQuery(".carousel-inner").append(item);
			       });


				     
	

			    });
			    
			    
	/*		    
			      images.forEach((image) => {
			         console.log(image.service);
			         var item = "<div class='carousel-item'>\
			  	  <img src='"+image.service+"/full/600,/0/default.jpg'/>\
				</div>";
			         jQuery(".carousel-inner").append(item);			         
			      });
       */
     });
     
 
var osds = [];

console.log(images);

    var viewer = OpenSeadragon({
        id: "openseadragon1",
        prefixUrl: "https://cdnjs.cloudflare.com/ajax/libs/openseadragon/5.0.1/images/",
        tileSources: [
        "https://libimages1.princeton.edu/loris/pudl0001%2F4609321%2Fs42%2F00000001.jp2/info.json",
        "https://libimages1.princeton.edu/loris/pudl0001%2F4609321%2Fs42%2F00000002.jp2/info.json",
        "https://libimages1.princeton.edu/loris/pudl0001%2F4609321%2Fs42%2F00000003.jp2/info.json",
        "https://libimages1.princeton.edu/loris/pudl0001%2F4609321%2Fs42%2F00000004.jp2/info.json",
        "https://libimages1.princeton.edu/loris/pudl0001%2F4609321%2Fs42%2F00000005.jp2/info.json",
        "https://libimages1.princeton.edu/loris/pudl0001%2F4609321%2Fs42%2F00000006.jp2/info.json",
        "https://libimages1.princeton.edu/loris/pudl0001%2F4609321%2Fs42%2F00000007.jp2/info.json"
    ]
    }); 
 
     
     
  function getFirstValue(o) {
    if(typeof o === "object") { 
       var x = Object.values(o)[0];
       if(typeof x == 'object') { return Object.values(x)[0]; }
       else{ return x; }
    }
    else if(typeof o === "array") { return o.label[0]; }
    else if(typeof o === "string") { return o; }
    else { return ""; }
  }     
    </script>

  </body>
</html>
