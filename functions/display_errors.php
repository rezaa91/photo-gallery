<?php


//function which displays error page - pass in the error
function display_errors_page($e){
    $page_title = "Error!";
    include('../includes/header.inc.php');
    include('../views/error.html');
    include('../includes/footer.inc.php');
}

?>