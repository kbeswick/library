<?php include 'settings.php' ?>
<!doctype html>
<html>
  <head>
  <title><?php print $SETTINGS['title']; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.4/dijit/themes/tundra/tundra.css">
    <link rel="stylesheet" type="text/css" href="<?php print $SETTINGS['baseaddress']; ?>/style.css">
    <link rel="stylesheet" type="text/css" href="<?php print $SETTINGS['baseaddress']; ?>/js/dojox/grid/resources/Grid.css">
    <script type="text/javascript" src="<?php print $SETTINGS['baseaddress']; ?>/js/dojo/dojo.js"
      djConfig="isDebug: false, debugAtAllCosts: false, parseOnLoad: true"></script>
    <script type="text/javascript">
      // Must create a base url config setting in the JS
      var base_url = '<?php print $SETTINGS['baseaddress']; ?>';
    </script>
  </head>
  <body class="tundra">
    <div id="container">
      <div id="header">
        <img src="<?php print $SETTINGS['headerimage']; ?>">
        <h1><a href="<?php print $SETTINGS['baseaddress']; ?>"><?php print $SETTINGS['title']; ?></a></h1>
      </div>

