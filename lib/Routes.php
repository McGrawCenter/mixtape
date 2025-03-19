<?php
$db = Flight::db();


/***************************
* Home
***********************/
Flight::route('GET /', function () {
    global $CONFIG;
    $data = array('siteurl' => $CONFIG['siteurl']);
    Flight::render('templates/home.php', $data);
});

/***************************
* Create
***********************/
Flight::route('POST /', function () {

    global $CONFIG;
    global $db;
    
    if($_POST['name'] == "") {
    $collection = new Collection();
    $token = $collection->token();
    $collection->label->en[0] = addslashes($_POST['label']);
    $collection->summary->en[0] = addslashes($_POST['summary']);
    //$collection->thumbnail[0]->id = $CONFIG['default_thumbnail'];

    $email = $_POST['email'];

    $collection->create($token, $email);
    // SEND AN EMAIL
    $message = "Dear Mixtape user,\r\n\r\nYour IIIF collection, \"{$_POST['label']}\" is available for editing at: \r\n\r\n".$CONFIG['siteurl']."/{$token}/edit\r\n\r\nBe sure to save this URL so that you can return to edit your collection.";
    $collection->sendmail($email, $message);

    header("Location:{$CONFIG['siteurl']}/welcome");
    }
    die();
});

/***************************
* Save
***********************/
Flight::route('POST /retrieve', function () {
    global $CONFIG;
    if(isset($_POST['email']) && $_POST['email'] != "") {
      $collection = new Collection();
      $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
      if($email) {
         $html = $collection->retrieve($CONFIG['siteurl'], $email);

         // SEND AN EMAIL
         $collection->sendmail($email, $html);
         $data = array('siteurl' => $CONFIG['siteurl'],'message'=>"Check your email for a list of collections associated with your email.");
         Flight::render('templates/message.php', $data);
         die();
      }
    }
});

/***************************
* Save
***********************/
Flight::route('POST /save', function () {
    $token = $_POST['token'];
    if(isset($_POST['html'])) { $html = $_POST['html']; }
    else { $html = ""; }
    $json = $_POST['json'];
    $x = json_decode($json);
    $collection = new Collection();
    //$collection->save($token, $info, $x);
    $collection->save($token, $html, $x);
});



/***************************
* View
***********************/
Flight::route('/@id:[0-9]+', function (string $id) {
    global $CONFIG;
    global $db;
    $collection = new Collection();
    $d = $collection->getById($id);
    //$d['html'] = "<div class='htmldisplay'>{$d['html']}</div>";
    $d['siteurl'] = $CONFIG['siteurl'];
    $d['id'] = $id;
    Flight::render('templates/view.php', $d);
});



/***************************
* View - CSV
***********************/
Flight::route('/@id:[0-9]+/csv', function (string $id) {
    global $CONFIG;
    global $db;
    $collection = new Collection();
    $d = $collection->getById($id);
    $d['siteurl'] = $CONFIG['siteurl'];
    $d['id'] = $id;
    $json = json_decode($d['json']);
    $d['items'] = $json->items;
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"collection.csv\";" );
    header("Content-Transfer-Encoding: binary");     
    Flight::render('templates/csv.php', $d);
});

/***************************
* View - Carousel
***********************/
Flight::route('/@id:[0-9]+/carousel', function (string $id) {
    global $CONFIG;
    global $db;
    $collection = new Collection();
    $d = $collection->getById($id);
    $d['siteurl'] = $CONFIG['siteurl'];
    $d['id'] = $id;
    $json = json_decode($d['json']);
    $d['items'] = $json->items;   
    Flight::render('templates/carousel.php', $d);
});

/***************************
* View - Carousel
***********************/
Flight::route('/@id:[0-9]+/art', function (string $id) {
    global $CONFIG;
    global $db;
    $presentation = new Presentation();
    $d = $presentation->getById($id);
    $d['siteurl'] = $CONFIG['siteurl'];
    $d['id'] = $id;

    print_r($presentation);die();
});


/***************************
* Collection Manifest
***********************/
Flight::route('/@id:[0-9]+/manifest', function (string $id) {
    $collection = new Collection();
    $d = $collection->getById($id);
    $json = $d['json'];
    $collection->cors();
    header('Content-Type: application/json');
    echo $json;
    die();   
});


/***************************
* Collection Manifest
***********************/
Flight::route('/@id:[0-9]+/manifest/@canvases', function (string $id, string $canvases) {
    $collection = new Collection();
    $d = $collection->getById($id);
    $json = $d['json'];
    if(isset($canvases)) {
      $json = $collection->exclude($json, $canvases);
    }
    $collection->cors();
    header('Content-Type: application/json');
    echo $json;
    die();   
});



/***************************
* Add
***********************/
Flight::route('/new', function () {
    global $CONFIG;
    $data = array("siteurl"=>$CONFIG['siteurl']);
    Flight::render('templates/new.php', $data);
});

/***************************
* Add
***********************/
Flight::route('/welcome', function () {
    global $CONFIG;
    $data = array("siteurl"=>$CONFIG['siteurl']);
    Flight::render('templates/email.php', $data);
});

/***************************
* Retrieve
***********************/
Flight::route('/retrieve', function () {
    global $CONFIG;
    $data = array("siteurl"=>$CONFIG['siteurl']);
    Flight::render('templates/retrieve.php', $data);
});


/***************************
* Edit
***********************/
Flight::route('/@token/edit', function (string $token) {
    global $CONFIG;
    global $db;
    $collection = new Collection();
    $d = $collection->get($token);
    $d['siteurl'] = $CONFIG['siteurl'];
    $d['token'] = $token;

    Flight::render('templates/edit.php', $d);
});

