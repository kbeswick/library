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

/*
 * settings.php - Global configuration settings to be used across the
 *                reserves application
 */


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
