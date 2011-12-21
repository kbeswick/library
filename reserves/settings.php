<?php

/*
 * baseaddress: The address the reserve list currently resides
 *              * Do not include trailing slash
 *
 * example: http://biblio.laurentian.ca/reserves
 *
 */

$SETTINGS['baseaddress'] = 'http://localhost';

/*
 * title: The title of the site. Appears at top of page, as well as as in title 
 * bar.
 *
 * example: Laurentian University Reserves List
 */

$SETTINGS['title'] = 'Reserves List / Liste De Réserves';

/*
 * headerimage: The URL of a header image that will appear alongside of the 
 * title on the front page.
 *
 * example: http://www.mywebsite.com/logo.jpg
 */

$SETTINGS['headerimage'] = $SETTINGS['baseaddress'] . '/laurentian.jpg';

/*
 * dbfile: The location of the Sqlite database file.
 *
 * example: reserves.db
 */

$SETTINGS['dbfile'] = 'reserves.db';

?>
