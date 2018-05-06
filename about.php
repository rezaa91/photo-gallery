<?php
require('core/init.php');

//include header, view and footer
$css = '<link rel="stylesheet" href="src/css/about.css" />';//set individual stylesheet
$page_title = "About"; //set page title
include('includes/header.inc.php');
include('views/about.html');
include('includes/footer.inc.php');


?>