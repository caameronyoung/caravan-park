<?php //must pass this test to access pages
    session_start();
    if (isset($_SESSION['usersLogin']))
    {
        echo 'you are logged in as:' . $_SESSION['usersLogin'];
        echo '<br>';
        echo '<br>';
    }
    else
    {
        die("please <a href='login.php'>login</a> to access this page.");
    }
?>