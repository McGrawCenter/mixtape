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
    <script src="https://unpkg.com/mirador@latest/dist/mirador.min.js"></script>  
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@iiif/vault@latest/dist/index.umd.js?ver=6.6.1" id="canvaspanel-js"></script> 

  </head>
  <body>
  

  

<form method='POST' action="./" onsubmit="return signupValidation()">
<div class="container" style='margin-top:2em;'>
  <div class="row">
    <div class='col-6'>
    
       <h2>Create a collection</h2>


	  <input type="hidden" name="action" value="create"/>
	  <input type="hidden" name="token" value=""/>

	  <p class="form-group">
	    <label for="label" id="label-label">Collection Title (required)</label>
	    <input type="text" class="form-control" id="label" name="label" placeholder="Enter a title">
	  </p>
	  <p class="form-group">
	    <label for="summary">Collection Description</label>
	    <textarea type="text" class="form-control" id="summary" name="summary" placeholder="Enter a description" rows='2'></textarea>
	  </p>
	  
	  <input type="text" class="form-control" id="name" name="name" aria-describedby="userName" placeholder="Enter Name">
	  
	  <p class="form-group">
	    <label for="email" id="email-label">Email address (required)</label>
	    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
	    <small id="emailHelp" class="form-text text-muted">An email address is required. We'll never share your email with anyone else.</small>
	  </p>	  
	  
	  <p class="mb-3 form-check">
	    <input type="checkbox" class="agree" id="agree" value="agree">
	    <label id="agree-label" for="agree">I agree to the terms and conditions. (required)</label>
	  </p>	  


     
     
    </div>
        <div class='col-6' style='position:relative'>
    
       <h3>Terms and conditions</h3>
    
       <ul>        
         <li>Mixtape is free to use and provided on an ‘as is’ basis.</li>
         <li>Future availability of the tool and/or collection manifests generated from it cannot be guaranteed.</li>
         <li>We reserve the right to restrict access and change our conditions of service at any time.</li>
         <li>Any images or content that we deem to be inappropriate (pornographic, abusive, racist, etc.) or that infringes third-party intellectual property rights may be removed without notice.</li>
         <li>The creators of Mixtape make no claim to the copyright of images displayed on this website.</li>
         <li>Manifest collections are limited to 100 items.</li>
         <li>Unused collections will be automatically removed after a period of three months.</li>
       </ul>
     

	<button type="submit" class="btn btn-primary" id="submit" style='position:absolute;bottom:0px;right:0px;'>Create collection</button>

    </div>
  </div>
</div>
</form>



<script src="views/assets/js/validate.js"></script>


  
  </body>
</html>
