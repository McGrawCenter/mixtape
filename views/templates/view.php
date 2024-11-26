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

    
    <link rel="stylesheet" href="<?= $siteurl ?>/views/assets/css/style.css">
    

    <!-- import Mirador  -->
    <!-- <script src="https://unpkg.com/mirador@latest/dist/mirador.min.js"></script>   -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@iiif/vault@latest/dist/index.umd.js?ver=6.6.1" id="canvaspanel-js"></script> 
    
    <script>
	var manifest = "<?= $siteurl ?>/<?= $ID ?>/manifest";
	var siteurl = "<?= $siteurl ?>";
	var json = <?= $json ?>	
    </script> 
  </head>
  <body>
  


  
<script src="https://unpkg.com/mirador@latest/dist/mirador.min.js"></script>
<div class="container-fluid" style='margin-top:2%;margin-bottom:3%;'>
  <div class="row">
  
    <div class='col-9'>
    
    <h2 id='collection-label'></h2>
    <h5 id='collection-summary'></h5>
   

    </div>
    <div class='col-3' style='text-align:right;'>



  <div class='header-toolbar'>
<a href="#" data-target="https://mcgrawcenter.github.io/mirador/?manifest=<?= $siteurl ?>/<?= $ID ?>/manifest" id="mirador_link" class="openModal"><img src="<?= $siteurl ?>/views/assets/images/mirador_logo.png" class="icon-lg"></a>
<a href="#" data-target="https://etcpanel.princeton.edu/IIIF/mixtape/33/manifest" id="manifest_link" class='openModal'><img src="<?= $siteurl ?>/views/assets/images/iiif_logo.png" class="icon-lg"></a>
<a href="#" data-target="https://mcgrawcenter.github.io/croppingtool/?manifest=<?= $siteurl ?>/<?= $ID ?>/views//manifest" class='openModal'><img src="<?= $siteurl ?>/views/assets/images/crop.svg" class="icon-lg"></a>
  </div>



    </div>

  </div>
</div>





<div class="container-fluid">
  <div class="row">
    <div class='col-12'>
    
  <div class="card-drawer">
        <div class="card-gallery grid"></div>
  </div>
    
    
    </div>
  </div>
</div>



<!-- Cropping Tool Modal -->
<div class="modal modal-xl fade" id="croppingToolModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <iframe id="modal-body-iframe" src="https://mcgrawcenter.github.io/croppingtool/?manifest=<?= $siteurl ?>/<?= $ID ?>/manifest" width="100%" height="600"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Cropping Tool Modal -->
<div class="modal modal-xl fade" id="externalModal" tabindex="-1" aria-labelledby="externalModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="external-modal-body" style="padding:1.5em;">
         <div class="form-group" style='margin-bottom:1em;'>
            <label for="external-modal-body-text">Manifest URL</label>
            <div style='position:relative;'>
            <input type='text' class='form-control' id='external-modal-body-text' value=''/>
            <button class='btn btn-primary' style='position:absolute;right:0;top:0'  onClick="javascript:copytext();return false;">Copy</button>
            </div>
         </div>
         <div class="form-group">
            <label for="external-modal-body-textarea">Contents</label>
            <textarea id="external-modal-body-textarea" class='external-modal-body-textarea form-control' style='width:100%;height:200px;'></textarea>
         </div>
         
      </div>
    </div>
  </div>
</div>

<script src="<?= $siteurl ?>/views/assets/js/gallery.js"></script>
<script>
function copytext() {
  var copytext = document.getElementById("external-modal-body-text");
  copytext.select();
  copytext.setSelectionRange(0, 99999); // For mobile devices
  navigator.clipboard.writeText(copytext.value);
}
</script>

  </body>
</html>
