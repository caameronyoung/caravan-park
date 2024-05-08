<?php
    session_start();
    require('db.php');

    if (isset($_POST['username']) && isset($_POST['password']))
    {
        //verify if the password is correct compared to their details in the table
        $sql = "SELECT * FROM admins WHERE userName=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $_POST['username']); //injects the forms input in to the sql statement above where username = post

        $stmt->execute();


        //can remove these when done error trapping
        $result = $stmt->get_result(); //checks result for testing
        $user = $result->fetch_assoc(); //puts in array to display
        
        //now check if details are actually correct instead of assuming they will be
        if ($user)
        {
            if ($user['password'] == $_POST['password']) //if table's password == input
            {
                echo 'logged in successfully';
                //now use a session to remember they're logged in 
                $_SESSION['usersLogin'] = $_POST['username'];
                echo "<a href='adminMenu.php'><p>edit cabins</p></a>";
            }
            else
            {
                echo 'incorrect password';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <div class='notFooter'>
        <div class='contentContainer'>
            <div class='contentItem'>
                <h1>Employee Login Page</h1>
                <form method='post'> <!--sends form data to processslogin via post -->
                    <div class='contentItem'>Please enter your username: <input type='text' name='username'></div><br><br>
                    <div class='contentItem'>Please enter your password: <input type='password' name='password'></div><br><br>
                    <button type='submit'>submit</button>
                </form>
            </div>
        </div>
    </div>
    

</body>
</html>