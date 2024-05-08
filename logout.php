<?php
    session_start();

    $_SESSION['usersLogin'] = NULL;

    header('location: allCabins.php');

?>