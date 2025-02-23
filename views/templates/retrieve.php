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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@hyperion-framework/vault@1.1.0/dist/index.umd.js"></script> 

  </head>
  <body>
  


  
<div class='col-4-m' style='margin-top:20em;margin-bottom:20em;'>

      <div class="py-4 bg-light">
        <div class="container">

          <div class="row">
	     <div class="col-6">
		<h2>Forgotten the addresses or your collections?</h2>Get a list sent to your email address.
	    </div>
	     <div class="col-6" style='display:flex;flex-direction:column;justify-content:center;'>
		<form method="POST" action="<?= $siteurl; ?>/retrieve" style="display:flex;">
		  <input type="text" name="email" placeholder="myname@email.com" class="form-control" style='width:220px;margin-right:0.5em;'/> <input type="submit" value='Send' class='btn btn-primary'/> 
		</form>
	    </div>
		
          </div>
          
          
        </div>
      </div>


</div>




  
  </body>
</html>
