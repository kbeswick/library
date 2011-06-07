<?php
// Retrieve the JSON list of reserves
function retrieve_reserve_list($file_store)
{
  include('JSON.php');

  // First- create db connection and query, then execute
  $db_session = new PDO('sqlite:reserves.db');
  $query = "SELECT * from reserve";

  $set_count = 0;
  $object_set = '';

  foreach ($db_session->query($query) as $row) {
    //add to object set
    $object_set[$set_count] = $row;
    $set_count++;
  }

  $wrapper = array('identifier'=>'bookbag_id', 'label'=>'course_code', 'items'=>$object_set);
  $json = new Services_JSON();
  print $json->encode($wrapper);
}

//Handle calls to this script

if ($_GET['mode'] == 'get')
  retrieve_reserve_list($file_store);
?>
