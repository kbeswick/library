Reserves List Application
====================================

Introduction
------------

This reserves list application is used to maintain a list of items on reserve at
a library. It is used in conjunction with the Evergreen ILS, namely the bookbag
functionality. Its basic use case at the moment is: you create a bookbag in
Evergreen that holds all of the items on reserve for a particular course, and
then add that bookbag to this list using its ID, along with the course name and
professor name.

Please Note
-----------

This application was intended to be very temporarily used for our library. That being
said, some things will need to be changed before using it yourself. Here are
some examples of those things: header logo, catalogue URL in reserves.js.

Requirements
-------------

*    PHP 5.2+
*    SQLite3
*    Dojo JS framework (included)

Architecture
-------------

The list is constructed using the Dojo JS framework. The items are retreived
from the SQLite database using PHP, and sent as JSON to the browser. The items
are stored in a Dojo AndOrStore (which enables us to run queries on the data
that use AND and OR operators). A Dojo grid is constructed using the data from this data store.

As for the admin section: the login is a simple php based login system.
Usernames and passwords are stored in a php file. The form to add entries to the
list sends the request to PHP via AJAX, and PHP handles adding the entry to the
SQLite database.

Setup
----------

You need to create an SQLite3 database called reserves.db, and a table
inside of it called reserve:

  CREATE TABLE reserve (id INTEGER PRIMARY KEY, course_code TEXT, instructor TEXT, bookbag_id INTEGER);

Also, you need to define the username(s) / password(s) that are able to
administer the list. These are stored in admin/users.php in a hash containing
"username" => "md5password"

After this, the reserve application should work right away.

Usage
-----------

To add reserve items to the list: 
1.    Naviagate to http://reserve_app_path/admin/
2.    Login with a username/password that you set during setup.
3.    Enter the Course Code, Instructor Name, and the ID of the corresponding
      bookbag you created in Evergreen that contains the reserve items for that
      class
4.    Click submit, and you are done

To view the reserve items in the list:
*    Navigate to http://reserve_app_path/
*    You are able to filter or organize the results in various ways
*    When you click on an entry, it will bring up a catalogue view of the books
     on reserve for that course

To delete items from the list:
*    The best way to do this currently is to delete the bookbag from evergreen
     first, and then run the check_links() function in admin/addreserves.php,
     which batch deletes entries whose links do not resolve anymore.

TODO
----------

Since this application turned out to be a little more than temporary, there are a few
planned improvements:

*    Automatically pull in the names of all bookbags by a certain user from
     Evergreen, parse their title to figure out course code, instructor, and 
     automatically add to reserve list.
*    Make the code a little more generic (remove Laurentian references, make
     more configurable)
*    Installation script

License
--------

Copyright (C) 2011 Laurentian University
Kevin Beswick <kx_beswick@laurentian.ca> 

Redistribution and use in source and binary forms, with or without 
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, 
   this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright 
   notice, this list of conditions and the following disclaimer in the 
   documentation and/or other materials provided with the distribution.
3. The name of the author may not be used to endorse or promote 
   products derived from this software without specific prior 
   written permission.

THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS 
OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR 
PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE 
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT 
OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF 
LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT 
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF 
SUCH DAMAGE.

