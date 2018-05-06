<?php
require('core/init.php');

//include header, view and footer
$css = '<link rel="stylesheet" href="src/css/index.css" />';//set individual stylesheet
$page_title = "Homepage"; //set page title
include('includes/header.inc.php');
include('views/index.html');
include('includes/footer.inc.php');


?>