<?php
/**
 * Created by PhpStorm.
 * User: hy
 * Date: 2014/10/30
 * Time: 21:42
 */
$db = mysqli_connect('localhost', 'usr_2014_79', 'phone:2836231', 'db_2014_79');

if ($db->connect_errno)
{
    echo json_encode(array(
        'success' => false,
        'message' => "Error occurred while processing your request: $db->connect_error. Please contact me to do me a favor~"
    ));
    exit;
}