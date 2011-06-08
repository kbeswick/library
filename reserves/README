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
