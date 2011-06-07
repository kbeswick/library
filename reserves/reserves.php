<?php

// Take in values from a form and make a reserve
function generate_reserve($bookbag_id, $course_code, $instructor)
{
	//use an sqlite db to store values
	$db_location = 'reserves.db';

	// Open sqlite db, then insert values
	$db_session = new PDO('sqlite:' . $db_location);
	$query = "INSERT into reserve (course_code, instructor, bookbag_id) values ('".$course_code."', '".$instructor."', ".$bookbag_id.")";
	$results = $db_session->Query($query);
	if (!$results)
		die('Query Failed... Please go back and retry');

	return true;
}


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

function delete_reserve($reserve_id)
{
	$db_session = new SQLite3('reserves.db');
	$query = "DELETE from reserve where id = " . $reserve_id;
	$db_session->exec($query) or die ( $db_session->lastErrorMsg() );
	$db_session->close();
	return true;
}

function edit_reserve($reserve_id, $bookbag_id, $instructor, $course_code)
{
	$db_session = new SQLite3('reserves.db');
	$query = "UPDATE reserve set instructor = \"" . $instructor . "\", course_code = \"" . $course_code . "\", bookbag_id = " . $bookbag_id . " where id = " . $reserve_id;
	$db_session->exec($query) or die( $db_session->lastErrorMsg() );
	$db_session->close();
	return true;
}

function check_links()
{
	//Before checking anything, check if laurentian.concat.ca is resolving.
	$catalogue_link = fopen("http://laurentian.concat.ca/", "r");
	if (!$catalogue_link){
		die("There may be a problem with laurentian.concat.ca so this process is going to halt. If this persists, contact Kevin Beswick");
	}
	fclose($catalogue_link);

	//Check all links from database, if active, leave alone, if not active, delete them.
	$db_session = new SQLite3('reserves.db');
	$query = "SELECT bookbag_id from reserve";
	$results = $db_session->query($query) or die( $db_session->lastErrorMsg() );

	$begin_link = "http://laurentian.concat.ca/opac/extras/feed/bookbag/opac/";
	$end_link = "?skin=lul";
	$count = 0;

	while ($row = $results->fetchArray())
        {
		$file = fopen($begin_link . $row["bookbag_id"] . $end_link, "r");
		if (!$file){
			//remove from list
			$query = "DELETE from reserve where bookbag_id = " . $row["bookbag_id"];
			$db_session->exec($query) or die ("not working... " . $db_session->lastErrorMsg() );
			$count++;
		}
		fclose($file);
	}
	echo "Done removing dead links... " . $count . " were removed.";
}

//Handle calls to this script

if ($_GET['mode'] == 'get')
	retrieve_reserve_list($file_store);
else if ($_GET['mode'] == 'newpost')
{
	$course_code = $_POST['coursecode'];
	$instructor = $_POST['instructor'];
	$bookbag_id = $_POST['bookbagid'];
	generate_reserve($bookbag_id,$course_code,$instructor);
	echo "success";
}	
else if ($_GET['mode'] == 'test')
{
	test();
}
else if ($_GET['mode'] == 'check_links')
{
	check_links();
}
	
?>
