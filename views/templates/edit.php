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
    
    <!--<script src="https://unpkg.com/@hyperion-framework/vault@1.0.1/dist/index.umd.js"></script>-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@iiif/vault@latest/dist/index.umd.js?ver=6.6.1" id="canvaspanel-js"></script> 
    
    <script>
	var siteurl = "<?= $siteurl ?>";
	var token = "<?= $token ?>";
	var json = <?= $json ?>
    </script> 
  </head>
  <body>
  


  
<div id="dropzone">Drop IIIF manifest here</div>

<div class="container-fluid fixed-top" id="banner">
  <div class="row">
  
    <div class='col-9'>
    
    <h2 id='collection-label' contenteditable="true"><?= $label ?></h2>
    <h5 id='collection-summary' contenteditable="true"><?= $summary ?></h5>
    <div><img src="<?= $siteurl ?>/views/assets/images/info-circle.svg" id='infoicon' data-bs-toggle="modal" data-bs-target="#infoModal"/></div>

    </div>
    <div class='col-3' style='text-align:right;'>



  <div class='header-toolbar'>
<a href="<?= $siteurl ?>/<?= $ID ?>" target="_blank" alt="Share" title="Share"><img src="<?= $siteurl ?>/views/assets/images/cassette-fill.svg" class="icon-35"></a>
<a href="https://mcgrawcenter.github.io/mirador/?manifest=<?php echo $siteurl; ?>/<?php echo $ID; ?>/manifest" id="mirador_link" target="_blank" alt="Open collection in Mirador" title="Open collection in Mirador"><img src="<?= $siteurl ?>/views/assets/images/mirador_logo.png" class="icon-lg"></a>

<a href="<?php echo $siteurl; ?>/<?php echo $ID; ?>/manifest" id="manifest_link" target="_blank" alt="Open collection manifest" title="Open collection manifest"><img src="<?= $siteurl ?>/views/assets/images/iiif_logo.png" class="icon-lg"></a>
<a href="https://mcgrawcenter.github.io/croppingtool/?manifest=<?php echo $siteurl; ?>/<?php echo $ID; ?>/manifest" target="_blank" alt="Open collection in cropping tool" title="Open collection in cropping tool"><img src="<?= $siteurl ?>/views/assets/images/crop.svg" class="icon-lg"></a>

<a href="#" alt='Save collection' class='save' alt="Save collection" title="Save collection"><img src="<?= $siteurl ?>/views/assets/images/save.svg" class='icon-lg' title='Save collection'/></a>  
  </div>





    </div>

  </div>
  
  
  

  
  
  
  
  <div class="row" style="margin-top:2em;">
    <div class="col-12">
    
  <label for="manifest">Add manifest:</label>
  <div style="position:relative">
  <input type="text" name="manifest" class="form-control" id="manifest" style="width: 100%;" placeholder="Manifest URL" value="">
  <input type="button" class="btn btn-primary" id="manifest-add" value="Add" style="position:absolute;right:0px;top:0px">
  </div>    
    
    </div>
  </div>
  
  
  
</div>





<div class="container-fluid" id="main" style="margin-top:2em;">
  <div class="row">
    <div class='col-12'>
   

  <div class="card-drawer">
        <div class="card-gallery grid"></div>
  </div>
    
    
    </div>
  </div>
</div>



<!-- Info Modal -->
<div class="modal modal-xl fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="margin-top:0px;padding-top:2px;padding-bottom:1.6em">

	  <div class="row" id="infoeditor">
	    <div class='col-12' style='padding:1em 1em 1em'>
	    
	   <div id="editor" class='form-control' style='margin-bottom:1em;height:600px;'><?= $html ?></div>  
	    
	    </div>
	  </div>  

      </div>
    </div>
  </div>
</div>




<!-- Include Quill stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>


<script src="<?= $siteurl ?>/views/assets/js/script.js?v=0.0.1"></script>
<script src="<?= $siteurl ?>/views/assets/js/dropzone.js?v=0.0.1"></script>

<script>


var header_height = jQuery("#banner").height();
jQuery("#main").css('margin-top',(header_height + 40));

  const quill = new Quill('#editor', {
    modules: {
      toolbar: [
        [{ header: [1, 2, false] }],
        ['bold', 'italic', 'underline','link', { 'list': 'ordered'}, { 'list': 'bullet' }]
      ],
    },
    theme: 'snow'
  });

</script>

  
  </body>
</html>
