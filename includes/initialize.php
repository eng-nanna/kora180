<?php
/**
 * Created by PhpStorm.
 * User: eng-nanna
 * Date: 2/26/2018
 * Time: 8:35 PM
 */
ob_start();

session_start();

define('DB_SERVER', 'localhost');
define('DB_USER', 'football');
define('DB_PASS', 'football');
define('DB_NAME', 'football');

date_default_timezone_set('Asia/Kuwait');

$db = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(mysqli_connect_errno()){
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_errno();
    $msg .= " (" .mysqli_connect_errno().")";
    echo $msg;
}

mysqli_query($db,"SET NAMES 'utf8'");

function db_escape($connection,$string){
    return mysqli_real_escape_string($connection,$string);
}

function confirm_result_set($result_set){
    if(!$result_set){
        exit('Database query failed!');
    }
}

function db_disconnect($connection){
    if (isset($connection)){
        mysqli_close($connection);
    }
}

require_once ('functions.php');
require_once ('query_function.php');

global $db;
$errors = [];