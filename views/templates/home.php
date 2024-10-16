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
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@iiif/vault@latest/dist/index.umd.js?ver=6.6.1" id="canvaspanel-js"></script> 
    <script>
    var siteurl = "<?= $siteurl ?>";
    </script> 
  </head>
  <body>
  


  
<div class='col-4-m' style='margin-top:20em;margin-bottom:20em;'>

      <div class="py-4 bg-light">
        <div class="container">

          <div class="row">
	     <div class="col-6" style="text-align:right">
		<img src="views/assets/images/cassette.svg" style='height:120px;'/>
	    </div>
	     <div class="col-6" style="display: flex;flex-direction: column;justify-content: center;">
		<a href="new"><button class="btn btn-primary">New Collection</button></a>
	    </div>
		
          </div>
          
          
        </div>
      </div>


</div>




  
  </body>
</html>
