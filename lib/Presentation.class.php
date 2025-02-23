<?php

class Presentation
{


    function __construct()
    {
        $this->{'@context'} = 'http://iiif.io/api/presentation/3/context.json';
        $this->id = '';
        $this->type = 'Manifest';
        $this->label = (object) ['en' => ['']];
        $this->summary = (object) ['en' => ['']];
        $this->items = [];
        $this->structures = [];
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
    

    function getById($id)
    {
    	global $db;
        $sql = "SELECT * FROM collection WHERE ID = '{$id}';";
        if ($result = $db->query($sql)->fetch_assoc()) {
            $jsonobj = json_decode($result['json']);
            foreach($jsonobj->items as $item) {
              $this->itemize($item->id);
            }
        } else {
            return false;
        }
    } 
    
    function itemize($url) {
      if($data = json_decode(file_get_contents($url))) {
        if(isset($data->{'@type'}) && $data->{'@type'} == "sc:Manifest") {
          foreach($data->sequences[0]->canvases as $canvas) { 
            $this->items[] = $this->v2Tov3($canvas);
            //$this->items[] = $canvas->images[0]->resource->service->{'@id'};
          }
        }
        else {
          foreach($data->items[0]->items as $item) { $this->items[] = $item; }
        }
      }
    } 
    
    function v2Tov3($canvas) {
      $itemobj = new StdClass();
      $itemobj->id = $canvas->{'@id'};
      $itemobj->type = "Canvas";
      $itemobj->label = array("en"=>array("The title"));
      $itemobj->thumbnail = "";
      $itemobj->items = [];
      
      $i = array(
        "id"=>"",
        "type"=>"",
        "motivation"=>"painting",
        "target"=>"",
        "body"=> new StdClass()
      );
      $i['body']->id = "";
      $i['body']->type = "";
      $i['body']->format = "";
      $i['body']->height = "";
      $i['body']->width = "";
      $i['body']->service = array("@id"=>"","@type"=>"","profile"=>"");
      
      $itemobj->items[] = $i;
      
      return $itemobj;
    }
    
    function fieldval($o) {
      if(is_array($o) && isset($o[0])) { return $o[0]; }
      elseif(is_object($o)) { die("field is an object"); }
      elseif(is_string($o)) { return $o; }
      else { return "N/A"; }
    }    

}
