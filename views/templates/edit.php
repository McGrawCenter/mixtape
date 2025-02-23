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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@hyperion-framework/vault@1.1.0/dist/index.umd.js"></script> 
    
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
    <!--<div><img src="<?= $siteurl ?>/views/assets/images/info-circle.svg"/></div>-->

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
  
  <div class="row">
    <div class="col-12">
    
  <label for="manifest">Add manifest:</label>
  <div style="position:relative">
  <input type="text" name="manifest" class="form-control" id="manifest" style="width: 100%;" placeholder="Manifest URL" value="">
  <input type="button" class="btn btn-primary" id="manifest-add" value="Add" style="position:absolute;right:0px;top:0px">
  </div>    
    
    </div>
  </div>
  
  
  
</div>





<div class="container-fluid" id="main">
  <div class="row">
    <div class='col-12'>
   

  <div class="card-drawer">
        <div class="card-gallery grid"></div>
  </div>
    
    
    </div>
  </div>
</div>


<script src="<?= $siteurl ?>/views/assets/js/script.js"></script>
<script src="<?= $siteurl ?>/views/assets/js/dropzone.js"></script>

<script>

var header_height = jQuery("#banner").height();
jQuery("#main").css('margin-top',(header_height + 40));

</script>

  
  </body>
</html>
