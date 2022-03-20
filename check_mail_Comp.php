<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


include("./db_files/connection.php");

//Check if mail is already in DB

$email = $_POST['email'];

// Using prepared statements almost eliminates the possibility of SQL Injection.
/*$preparedQuery = $mysqliConnection->prepare("SELECT * FROM $db_tab_company WHERE `email` = (?)");
$preparedQuery->bind_param("s", $email);
$preparedQuery->execute();

$result = $preparedQuery->get_result(); */

$result = $mysqliConnection->query("SELECT * FROM $db_tab_company WHERE `email` = '$email'");

/* Get the number of rows in the result set */
$row_cnt = $result->num_rows;

if($row_cnt > 0){
    echo ('match');
}
else if($row_cnt == 0){
    echo ('no match');
}
else{
    echo ('error');
}


?>