<?php
require('core/init.php');

//include header, view and footer
$css = '<link rel="stylesheet" href="src/css/contact.css" />';//set individual stylesheet
$page_title = "Contact"; //set page title
include('includes/header.inc.php');
include('views/contact.html');
include('includes/footer.inc.php');


?>