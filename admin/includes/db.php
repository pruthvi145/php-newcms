<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'newcms';

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if(!$connection){
    echo '<pre>';
    die('ERROR: Can\'t connect to the database!');
    echo '</pre>';
}


//echo ($connection) ? "Connected to the database!" : "ERROR: Can't connect to the database";

