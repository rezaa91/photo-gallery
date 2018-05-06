<?php
require('core/init.php');

//include header, view and footer
$css = '<link rel="stylesheet" href="src/css/gallery.css" />';//set individual stylesheet
$page_title = "Gallery"; //set page title
include('includes/header.inc.php');
include('views/gallery.html');
include('includes/footer.inc.php');


?>