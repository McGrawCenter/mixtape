MANIFEST,LABEL,THUMBNAIL
<?php
 foreach($items as $item) {
  echo "\"".$item->id."\",";
  echo "\"".$item->label->en[0]."\",";
  echo "\"".$item->thumbnail[0]->id."\",";
  echo "\n";
}
?>
