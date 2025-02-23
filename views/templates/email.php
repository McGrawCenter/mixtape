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
    <style>
    .checkemail {
       font-size:1.2em;
       color:#333;
    }
    </style>   

  </head>
  <body>
  


<div class="container">
  <div class="row">
    <div class='col-12' style='display:flex;flex-direction:column;justify-content:center;'>
       <p class='text-center'><a href='<?= $siteurl ?>' alt='return to home page'><img src="<?= $siteurl ?>/views/assets/images/cassette.svg" style='height:80px;'/></a></p>
       <p class='text-center checkemail'>Check your email for a link to your new collection.</p>


    </div>
        
  </div>
</div>

<script>
 var h = jQuery(window).height();
 jQuery(".col-12").css('height',h);
</script>
  
  </body>
</html>
