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
    
    // only allow post requests from self
    if ($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']){
       $this->output->set_status_header(400, 'No Remote Access Allowed');
       exit;
    }

    $collection = new Collection();
    $token = $collection->token();

    $collection->label->en[0] = addslashes($_POST['label']);
    $collection->summary->en[0] = addslashes($_POST['summary']);
    $collection->thumbnail[0]->id = $CONFIG['default_thumbnail'];
    
    $email = $_POST['email'];

    $collection->create($token, $email);
    // SEND AN EMAIL
    //$message = "Dear Mixtape user,\r\n\r\nYour IIIF collection is available for editing at: \r\n\r\n".$CONFIG['siteurl']."/{$token}/edit";
    //$collection->sendmail($email, $message, $token);

    header("Location:{$CONFIG['siteurl']}/{$token}/edit");
    die();
});

/***************************
* Save
***********************/
Flight::route('POST /save', function () {
    $token = $_POST['token'];
    $json = $_POST['json'];
    $x = json_decode($json);
    $collection = new Collection();
    $collection->save($token, $x);
});

/***************************
* View
***********************/
Flight::route('/@id:[0-9]+', function (string $id) {
    global $CONFIG;
    global $db;
    $collection = new Collection();
    $d = $collection->getById($id);
    $d['siteurl'] = $CONFIG['siteurl'];
    Flight::render('templates/view.php', $d);
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
* Add
***********************/
Flight::route('/new', function () {
    Flight::render('templates/new.php');
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

