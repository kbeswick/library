<!doctype html>
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


include('loggedin.php');
include('../header.php');
?>
    <script type="text/javascript" src="reservesadmin.js"></script>
    <script type="text/javascript">
      //includes
      dojo.require("dijit.form.Form");
      dojo.require("dijit.form.TextBox");
      dojo.require("dijit.form.Button");

      //function which submits the form data to the server
      function submitStuff() {
        // the form
        var form = dijit.byId("addreserves");
        // connect the submission of the form to a function which submits the data
        dojo.connect(dijit.byId("addreserves"), "onSubmit", function(e) {
          e.preventDefault(); //do not let the form do its default action
          // arguments for a POST request
          var xhrArgs = {
            url: "admin.php?mode=newpost",
            form: 'addreserves',
            load: function(responseObject){
              // update our page to reflect the success
              dojo.byId("statuses").innerHTML = '<font color="#339900">Reserve added</font>';
              form.reset(); // reset the form
            },
            error: function(error){
              // update our page to reflect our failure
              dojo.byId("statuses").innerHTML = '<font color="#FF0000">Error: ' + error + '</font>';
              console.error("Error: " + error); // log the error in the console
            }
          };
          dojo.xhrPost(xhrArgs); //make request
          dojo.byId("statuses").innerHTML = 'Adding...';	//update status on page
        });
      }
      dojo.addOnLoad(submitStuff); // execute this function when dojo has loaded
    </script>
      <div id="usermenu">
        <h4>Logged in... (<a href="logout.php">Logout</a>)</h4>
      </div>
      <div id="admin_instructions" class="light">
        <h2>To Add Reserves:</h2>
        <p>Fill out the form below with the course code, instructor, and bookbag ID to have it added to the reserve list.
        </p>
        <h2>To Modify/Delete Reserves:</h2>
        <p>Click on the entry you wish to modify or delete from the list of reserves below. A window will appear where you
           can modify the reserve information and click on "Save" or simply click on "Delete This Reserve" to delete the reserve.
        </p>
      </div>
      <div id="add_reserve_form" class="light">
        <!-- Create form. Also create inputs and buttons in the form. Similar to normal HTML form creation -->
        <h2>Add Reserve</h2>
        <form dojoType="dijit.form.Form" id="addreserves" jsId="addreserves" encType="multipart/form-data" action="" method="post">
          <table>
          <tr>
            <td><label for="coursecode">Course Code: </label></td>
            <td><input type="text" name="coursecode" value="" dojoType="dijit.form.TextBox" trim="true"></td>
          </tr>

          <tr>
            <td><label for="instructor">Instructor: </label></td>
            <td><input type="text" name="instructor" value="" dojoType="dijit.form.TextBox" trim="false"></td>
          </tr>

          <tr>
            <td><label for="bookbagid">Bookbag ID: </label></td>
            <td><input type="text" name="bookbagid" value="" dojoType="dijit.form.TextBox" trim="true"></td>
          </tr>
        </table>
          <div id="statuses">
          </div>
          <div id="add_reserve_buttons">
            <button dojoType="dijit.form.Button" type="submit" name="submitButton" value="Submit">
              Submit
            </button>
            <button dojoType="dijit.form.Button" type="reset">
              Clear
            </button>
          </div>
        </form>
      </div>
      <div id="grid_div" class="light">
        <h2>Edit/Delete Reserves</h2>
        <div id="grid" jsId="grid" id="grid" dojoType="dojox.grid.DataGrid" store="reservesStore" structure="layout" 
          query="{ course_code:'*' }" autoHeight="true"></div>
      </div>
    </div>
    <div id="editDeleteReserveBox" dojoType="dijit.Dialog" title="Edit / Delete Reserve">
      <div id="editReserveForm" dojoType="dijit.form.Form" action="admin.php?mode=edit" method="post">
        <h3>Edit Reserve</h3>
          <input type="hidden" id="edit_reserve_id" value="" name="reserve_id">
          <table>
          <tr>
            <td><label for="coursecode">Course Code</label></td>
            <td><input type="text" id="edit_coursecode" name="coursecode" value="" dojoType="dijit.form.TextBox" trim="true"></td>
          </tr>

          <tr>
            <td><label for="instructor">Instructor</label></td>
            <td><input type="text" id="edit_instructor" name="instructor" value="" dojoType="dijit.form.TextBox" trim="false"></td>
          </tr>

          <tr>
            <td><label for="bookbagid">Bookbag ID</label></td>
            <td><input type="text" id="edit_bookbagid" name="bookbagid" value="" dojoType="dijit.form.TextBox" trim="true"></td>
          </tr>
        </table>
        <button dojoType="dijit.form.Button" type="submit" name="submitButton" value="Save">
          Save
        </button>
        <button dojoType="dijit.form.Button" onClick="dijit.byId('editDeleteReserveBox').hide();">
          Cancel
        </button>
      </div>
      <div id="deleteReserveForm" dojoType="dijit.form.Form" action="admin.php?mode=delete" method="post">
        <h3>Delete Reserve</h3>
          <input type="hidden" id="delete_reserve_id" value="" name="reserve_id">
          <button dojoType="dijit.form.Button" type="submit" name="submitButton" value="Delete This Reserve">
            Delete This Reserve
          </button>
      </div>
<?php include('../footer.php'); ?>
