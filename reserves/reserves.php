<?php

// Configuration settings:

$file_store = 'reserves.txt'; //name of place to store info

// Take in values from a form and make a reserve
function generate_reserve($bookbag_id, $course_code, $instructor)
{
	
	//insert into db instead of flat file now
	$db_location = 'reserves.db';

	// Open sqlite db, then insert values
	//PHP5.2 way
	$db_session = new PDO('sqlite:' . $db_location);
	$query = "INSERT into reserve (course_code, instructor, bookbag_id) values ('".$course_code."', '".$instructor."', ".$bookbag_id.")";
	$results = $db_session->Query($query);
	if (!$results)
		die('Query Failed... Please go back and retry');
/*
	//PHP 5.3 way

	$db_session = new SQLite3($db_location);
	$query = "INSERT into reserve (course_code, instructor, bookbag_id) values ('".$course_code."', '".$instructor."', ".$bookbag_id.")";
	$db_session->exec("INSERT into reserve (course_code, instructor, bookbag_id) values ('".$course_code."', '".$instructor."', ".$bookbag_id.")") or die( $db_session->lastErrorMsg() );
	$db_session->close();
*/

	return true;
}


// Retrieve the JSON list of reserves
function retrieve_reserve_list($file_store)
{
	include('JSON.php');

	// First- create db connection and query, then execute
	//PHP5.2 way
	$db_session = new PDO('sqlite:reserves.db');
	$query = "SELECT * from reserve";

	$set_count = 0;
	$object_set = '';

	foreach ($db_session->query($query) as $row) {
	/*
	//PHP5.3 way

	$db_session = new SQLite3('reserves.db');
	$query = "SELECT * from reserve";
	$results = $db_session->query($query) or die( $db_session->lastErrorMsg() );
	
	$set_count = 0;
	$object_set = '';

	// Iterate over the results and do stuff with them
	while ($row = $results->fetchArray())
	{
*/
		//add to object set
		//$object_set[$set_count] = array ('bookbag_id'=>$row["bookbag_id"], 'course_code'=>$row["course_code"], 'instructor'=>$row["instructor"]);
		$object_set[$set_count] = $row;
		$set_count++;
		
	}
	
//	$db_session->close();
	
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

function test()
{
	echo "Going to test...";
	if (generate_reserve("106", "COSC 2006", "Barry Adams"))
	{
		echo 'Test success';
	}
	else
	{
		echo "generate reserve test failed";
	}
//	generate_reserve("236", "COSC 1046", "Abou Rabia", $file_store) or die("generate reserve test failed");
//	generate_reserve("145", "PSYC 2406", "Someone", $file_store) or die("generate reserve test failed");
//	generate_reserve("167", "MATH 1046", "Calculor", $file_store) or die("generate reserve test failed");
//	generate_reserve("436", "ENGL 1005", "English Prof", $file_store) or die("generate reserve test failed");
}

/*if (isset($_POST['coursecode'], $_POST['instructor'], $_POST['bookbagid']))
{
	$course_code = $_POST['coursecode'];
	$instructor = $_POST['instructor'];
	$bookbag_id = $_POST['bookbagid'];
	generate_reserve($bookbag_id,$course_code,$instructor,$file_store);
	echo "success";
}*/

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
