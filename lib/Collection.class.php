<?php

class Collection
{


    function __construct()
    {
        $this->{'@context'} = 'http://iiif.io/api/presentation/3/context.json';
        $this->id = '';
        $this->type = 'Collection';
        $this->label = (object) ['en' => ['']];
        $this->summary = (object) ['en' => ['']];
        //$this->metadata = array((object) ['label'=>(object)['en'=>['Description']], 'value'=>(object)['en'=>['This is the description']]]);
        //$this->thumbnail = array((object) ["id" => "", "type" => "Image", "format" => "image/jpeg", ]);
        $this->items = [];
    }




    function get($token)
    {
    	global $db;
        $sql = "SELECT * FROM collection WHERE token = '{$token}';";
        if ($result = $db->query($sql)->fetch_assoc()) {
            return $result;
        } else {
            return false;
        }
    }
    
    function save($token, $html, $jsonobj) {
	global $db;
	$label =   addslashes($jsonobj->label->en[0]);
	$summary = addslashes($jsonobj->summary->en[0]);
	$json = addslashes(json_encode($jsonobj));
	$html = addslashes($html);
	if(count($jsonobj->items) > 0) {
             $thumbnail = $jsonobj->items[0]->thumbnail[0]->id;
	}
        $sql = "UPDATE collection SET label = '{$label}',summary = '{$summary}', html = \"{$html}\", thumbnail = '', json = '{$json}' WHERE token = '{$token}'";
	try {
		$db->query($sql);
		$o = $this->get($token);
		$json = $o['json'];
		header('Content-Type: application/json');
		echo $json;
		die();    		
	} catch (Exception $ex) {
		die("could not update database record");
	}   
    }
    /*
    function collections()
    {
    	global $db;
        $sql = "SELECT * FROM collection;";
        if ($result = $db->fetchObj($sql)) {
            return $result;
        } else {
            return false;
        }
    }    
    */
    function getById($id, $exclude = null)
    {
    	global $db;
        $sql = "SELECT * FROM collection WHERE ID = '{$id}';";
        if ($result = $db->query($sql)->fetch_assoc()) {
            if(isset($exclude)) { 
              $e = explode(",",$exclude);
              $json = json_decode($result->json);
              foreach($json->items as $index=>$item) { 
                if(!in_array($index, $e)) { unset($json->items[$index]); }
               }
              $result->json = $json;
            }
            return $result;
        } else {
            return false;
        }
    }  
    
    function exclude($json, $include_only) {

      $o = json_decode($json);
      $included = explode(",",$include_only);
      $items = array();
      foreach($o->items as $index=>$item) { 
        if(in_array($index, $included)) { $items[] = $o->items[$index]; }
       }
      $o->items = $items;
      return json_encode($o);
    }





    function exists($token)
    {
    	global $db;
        $sql = "SELECT ID FROM collection WHERE token = '{$token}';";
        if($result = $db->query($sql)->fetch_assoc()) {
	    return true;
        } else {
            return false;
        }
    }

    function create($token, $email) {
    	global $db;  
    	
    	$json = addslashes(json_encode($this));
    	
        if (!$this->exists($token)) {
            $now = date("Y-m-d");
            $sql = "INSERT into collection (`label`,`summary`,`token`,`html`,`thumbnail`,`json`,`email`,`expire`,`status`) VALUES ('{$this->label->en[0]}','{$this->summary->en[0]}','{$token}','','','{$json}','{$email}', '{$now}', 0)";

            return $db->query($sql);
        }
    }


    function update($token)
    {
    	global $db;
        $json = addslashes(json_encode($this));
        $this->label->en[0] = addslashes($this->label->en[0]);
        $this->summary->en[0] = addslashes($this->summary->en[0]);
        $sql = "UPDATE collection SET label = '{$this->label->en[0]}',summary = '{$this->summary->en[0]}', thumbnail = '', json = '{$json}' WHERE token = '{$token}'";        
        return $db->query($sql);
    }
    
    
    

    function set($label, $summary, $token, $thumbnail, $json)
    {
    	global $db;
        $label = addslashes($label);
        $summary = addslashes($summary);
        $json = addslashes($json);
        if (!$this->get($token)) {
            $sql = "INSERT into collection (`label`,`summary`,`token`,`thumbnail`,`json`) VALUES ('{$label}','{$summary}','{$token}','{$thumbnail}',\"{$json}\")";
            $db->insert($sql);
        } else {
            $sql = "UPDATE collection SET label = '{$label}',summary = '{$summary}', thumbnail = '', json = '{$json}' WHERE token = '{$token}'";
            $db->query($sql);
        }
    }

    function token()
    {
        $length = 40;
        $pool = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $key = "";
        for ($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }
    

    
    
    function sendmail($email, $message) {
	// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70, "\r\n");

	// Send
	mail($email, 'Mixtape', $message);
    }


    function retrieve($siteurl, $email) {
    	global $db;  
        $sql = "SELECT * FROM collection WHERE email = '{$email}';";
        if ($result = $db->query($sql)->fetch_all(MYSQLI_ASSOC)) {
            $message = "";
            foreach($result as $re) {
              $message .= "{$re['label']}\r\n{$siteurl}/{$re['token']}/edit\r\n\r\n";
            }
            return $message;
        } else {
            return false;
        }

    }


    function cors()
    {
    
    	header("Access-Control-Allow-Origin: *");

/*
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
*/
    }
    
    
    
    
    
    function sanitizeInteger($str) {  
      return filter_var($str, FILTER_SANITIZE_NUMBER_INT);
    }

}
