<?php
/**
 * Created by PhpStorm.
 * User: hy
 * Date: 2014/10/30
 * Time: 21:15
 */
    require_once 'database.php';
    $host = $_POST['host'];
    $location = $_POST['location'];
    $time = $_POST['time'];
    if (!$host || !$location || !$time)
    {
        echo json_encode(array(
            'success' => false,
            'message' => 'Please fill in the form completely.'
        ));
        return;
    }
    $statement = $db->prepare(<<<QUERY
INSERT INTO `parties` (`host`, `location`, `time`) VALUES (?, ?, ?)
QUERY
    );
    $host = htmlspecialchars($host);
    $location = htmlspecialchars($location);
    $statement->bind_param("sss", $host, $location, $time);
    if (!$statement->execute())
        echo json_encode(array(
            'success' => false,
            'message' => 'Submission failed: '.$statement->error
        ));
    else
        echo json_encode(array(
            'success' => true
        ));