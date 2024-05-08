<?php
    //connect to my dbase
    //establish dummy variables until i make the admin page login details
    $username = 'root';
    $database =  'sunnyspot';
    $password = '';
    $conn = new mysqli('localhost', $username, $password, $database);
    if (mysqli_connect_errno()) //from w3schools to check if connection is working;
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    $result = $conn->query('SELECT * FROM cabins'); //choose the image path from cabin table
    $data = $result->fetch_all(MYSQLI_ASSOC); //get all the result variables and put in an assoc. array

    foreach ($data as $row):
    

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
    <!----need description, ppn, ppw, photo--->
    <div class='notFooter'>
        <div class='contentContainer'>
            <div class='contentItem'><h3>Cabin:</h3><p><?php echo $row['cabinType']?></p></div>
            <div class='contentItem'><h4>Cabin ID:</h4><p><?php echo $row['cabinID']?></p></div>
            <div class='contentItem'><h4>Description of Cabin:</h4><p><?php echo $row['cabDesc']?></p></div>
            <div class='contentItem'><h4>Price per Night:</h4><p>$<?php echo $row['priceNight']?></p></div>
            <div class='contentItem'><h4>Price per Week:</h4><p>$<?php echo $row['priceWeek']?></p></div>
            <div class='contentItem'><div class='contentItem'><div class='contentImage'><img src="<?php echo $row['photo']?>"></div></div></div>
        </div>
    </div>
    <?php
    endforeach; ?>
    <div class='footer'><a href='login.php'><h1>log in</h1></a></footer>
</body>
</html>