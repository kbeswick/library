<?php

/*
 * Copyright (C) 2011 Laurentian University
 * Kevin Beswick <kx_beswick@laurentian.ca> 
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, 
 *    this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright 
 *    notice, this list of conditions and the following disclaimer in the 
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote 
 *    products derived from this software without specific prior 
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS 
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR 
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE 
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT 
 * OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF 
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT 
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
 * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF 
 * SUCH DAMAGE.
 */

require('loggedin.php');
require('../settings.php');

// Take in values from a form and make a reserve
function generate_reserve($bookbag_id, $course_code, $instructor)
{
  // Open sqlite db, then insert values
  $db_session = new PDO('sqlite:../' . $SETTINGS['dbfile']);
  $query = "SELECT count(*) from reserve where bookbag_id = ".$bookbag_id;
  $res = $db_session->Query($query);
  
  if ($res->fetchColumn() == 0) {
    $query = "INSERT into reserve (course_code, instructor, bookbag_id) values ('".$course_code."', '".$instructor."', ".$bookbag_id.")";
    $results = $db_session->Query($query);
    if (!$results)
      die('Query Failed... Please go back and retry');
    return true;
  }

  return false;
}

function delete_reserve($reserve_id)
{
  $db_session = new PDO('sqlite:../' . $SETTINGS['dbfile']);
  $query = "DELETE from reserve where id = " . $reserve_id;
  $db_session->exec($query) or die(print_r($db_session->errorInfo(), true));
  return true;
}

function edit_reserve($reserve_id, $bookbag_id, $instructor, $course_code)
{
  $db_session = new PDO('sqlite:../' . $SETTINGS['dbfile']);
  $query = "UPDATE reserve set instructor = \"" . $instructor . "\", course_code = \"" . $course_code . "\", bookbag_id = " . $bookbag_id . " where id = " . $reserve_id;
  $db_session->exec($query) or die(print_r($db_session->errorInfo(), true));
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
if ($_GET['mode'] == 'newpost')
{
  $course_code = $_POST['coursecode'];
  $instructor = $_POST['instructor'];
  $bookbag_id = $_POST['bookbagid'];
  generate_reserve($bookbag_id,$course_code,$instructor);
  echo "success";
}
else if ($_GET['mode'] == 'delete')
{
  $id = $_POST['reserve_id'];
  delete_reserve($id);
  header("Location: /admin/addreserves.php");
  die;
}
else if ($_GET['mode'] == 'edit')
{
  $id = $_POST['reserve_id'];
  $course_code = $_POST['coursecode'];
  $instructor = $_POST['instructor'];
  $bookbag_id = $_POST['bookbagid'];
  edit_reserve($id, $bookbag_id, $instructor, $course_code);
  header("Location: /admin/addreserves.php");
  die;
}
else if ($_GET['mode'] == 'check_links')
{
  check_links();
}

?>
