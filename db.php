<?php
    $conn = new mysqli('localhost', 'root', '', 'sunnyspot');
    if ($conn->error) //from w3schools to check if connection is working;
    {
        die('error conencting to db' . $conn->error);
    }
?>