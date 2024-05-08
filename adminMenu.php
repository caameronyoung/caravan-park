<?php
    session_start();
    require('processLogin.php');
    $username = 'root';
    $database =  'cyoung_sunnyspot';
    $password = '';
    $conn = new mysqli('localhost', $username, $password, $database);
    if (mysqli_connect_errno()) //from w3schools to check if connection is working;
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    if (isset($_POST['submitA'])) //only uploads when submit is pressed
    {
        $uploadable = TRUE; 
        $destination = 'images/' . $_FILES['image']['name']; //the final destination for the image (works)
        $tmp_location = $_FILES['image']['tmp_name']; // found the location of the image when uploaded from a var dump
        $imageFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION)); //i think this is meant to edit the file name when finished but i dont think this line works at all? 
        $default = 'images/stCabin.jpg'; //no image uploaded -> default placeholder image will be the standard cabin 
        
        if ($tmp_location == NULL)
        {
            $uploadable = TRUE;
            if ($uploadable)
            {   
                $stmt = $conn->prepare("INSERT INTO cabins(cabinType, cabDesc, priceNight, priceWeek, photo) VALUES (?,?,?,?,?)");   
                $stmt->bind_param('ssiis', $cabinTypeAdd, $cabDescAdd, $priceNightAdd, $priceWeekAdd, $photoAdd);
                if ($_POST['priceNightA'] <= 0)
                {
                    print 'please enter a value more than 0';
                    exit;
                }
                else
                {
                    $priceNightAdd = $_POST['priceNightA'];
                }
                
                $photoAdd = $default;  //use the default image
                $cabinTypeAdd = $_POST['cabinTypeA'];
                $cabDescAdd = $_POST['cabDescA'];             
                $priceWeekAdd = 5*$priceNightAdd;  
                $stmt->execute();
                echo 'cabin added successfully';
            }
            
        }
        else if ($tmp_location != NULL)
        {
            $check = getimagesize($tmp_location);
            if ($check === false) //this works i tested with other file types
            {
                echo "File is not an image.";
                $uploadable = FALSE;
            }
            else //if they have an image to use 
            {
                $uploadable = TRUE;
            }
            if ($uploadable)
            {      
                $stmt = $conn->prepare("INSERT INTO cabins(cabinType, cabDesc, priceNight, priceWeek, photo) VALUES (?,?,?,?,?)");
                $stmt->bind_param('ssiis', $cabinTypeAdd, $cabDescAdd, $priceNightAdd, $priceWeekAdd, $photoAdd);
                if ($_POST['priceNightA'] <= 0)
                {
                    print 'please enter a value more than 0';
                    exit;
                }
                else
                {
                    $priceNightAdd = $_POST['priceNightA'];
                }
                move_uploaded_file($tmp_location, $destination); //take from files temp location and put it in the images folder
                $imageFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));
                $photoAdd = 'images/' . basename($_FILES["image"]["name"]);  //basename is just the image's name after it was moved, so normally upload.jpg .. concatenate images/ in front so it can be displayed on the server 
                $cabinTypeAdd = $_POST['cabinTypeA'];
                $cabDescAdd = $_POST['cabDescA'];             
                $priceWeekAdd = 5*$priceNightAdd;  
                $stmt->execute();
                echo 'cabin added successfully';
            }
        }
    }

    if (isset($_POST['submitU']))
    {
        $uploadable = FALSE;
        // now check if an image was added
        
        $tmp_location = $_FILES['image']['tmp_name']; // found the location of the image when uploaded from a var dump
        if (empty($tmp_location)) //update without an image
        {
            $uploadable = TRUE;
            if ($uploadable)
            {
                //notice this sql statement doesnt update the photo whereas the next one will with a diff sql statement
                $stmt = $conn->PREPARE('UPDATE cabins SET cabinType = ?, cabDesc = ?, priceNight = ?, priceWeek = ? WHERE cabinID = ?');
                $stmt->bind_param('ssiii', $cabTypeUpdate, $cabDescUpdate, $pnU, $pwU, $cabIDU);

                $cabIDU = $_POST['cabinIDUpdate'];

                if ($_POST['priceNightU'] <= 0) //first error trapping for the price
                {
                    print 'please enter a value more than 0';
                    exit;
                }
                else
                {
                    $pnU = $_POST['priceNightU'];
                    $pwU = 5*$pnU;
                }
                if (!empty($_POST['cabinTypeU']))
                {
                    $cabTypeUpdate = $_POST['cabinTypeU'];
                }

                if (!empty($_POST['cabDescU']))
                {
                    $cabDescUpdate = $_POST['cabDescU'];
                }
                $stmt->execute();
                echo 'cabin updated successfully';
            }
        }

        else if ($tmp_location != NULL)//if theres an image to update as well
        {
            $check = getimagesize($tmp_location);
            if ($check === false) //this works i tested with other file types
            {
                echo "File is not an image.";
                $uploadable = FALSE;
            }
            else //if they have an image to use 
            {
                $uploadable = TRUE;
            }
            if ($uploadable)
            {   
                //this sql statement will edit the photo too
                //if i used the same sql statement the updated image would be empty if i didnt add one 
                $stmt = $conn->PREPARE('UPDATE cabins SET cabinType = ?, cabDesc = ?, priceNight = ?, priceWeek = ?, photo = ?  WHERE cabinID = ?');
                $stmt->bind_param('ssiisi', $cabTypeUpdate, $cabDescUpdate, $pnU, $pwU, $photoU, $cabIDU);

                $cabIDU = $_POST['cabinIDUpdate'];

                if ($_POST['priceNightU'] <= 0) //first error trapping for the price
                {
                    print 'please enter a value more than 0';
                    exit;
                }
                else
                {
                    $pnU = $_POST['priceNightU'];
                    $pwU = 5*$pnU;
                }
                if (!empty($_POST['cabinTypeU']))
                {
                    $cabTypeUpdate = $_POST['cabinTypeU'];
                }

                if (!empty($_POST['cabDescU']))
                {
                    $cabDescUpdate = $_POST['cabDescU'];
                }
                $destination = 'images/' . $_FILES['image']['name']; //the final destination for the image (works)
                $imageFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));
                move_uploaded_file($tmp_location, $destination); //take from files temp location and put it in the images folder
                $imageFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));
                $photoU = 'images/' . basename($_FILES["image"]["name"]); 

                $stmt->execute();
                echo 'cabin updated successfully';
            }
        }


    }
        
        
    
        
    if (isset($_POST['submitD']))
    {
        //prepare the deleting statement
        $delStmt = $conn->prepare("DELETE FROM cabins WHERE cabinID=?");
        if (!$delStmt)
        {
            echo 'error binding';
        }
        else
        {
            $delStmt->bind_param('i', $delCabin);
            $delCabin = $_POST['cabinIDDel'];
            $delStmt->execute();
            echo 'cabin successfully deleted';
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
    <div class='contentContainer'>
        <h1>Add a new cabin:</h1>
        <form method='post' name='add' id='add' enctype="multipart/form-data">
            Cabin Name: <input type='text' name='cabinTypeA'><br>
            Cabin Description:<br> <textarea id='cabDescA' name='cabDescA' rows='5' cols='50' style='resize: none'></textarea><br>
            Price per Night: <input type='number' name='priceNightA' id='priceNightA'><br>
            Photo: <input type='file' name='image' id='image'><br>
            <input type='submit' name="submitA">
        </form>
    </div>
    


    <div class='contentContainer'>
        <h1>Update an existing cabin</h1>
        <form method='post' name='update' id='update' enctype="multipart/form-data">
            Cabin ID: <input type='number' name='cabinIDUpdate'><br>
            Cabin Name: <input type='text' name='cabinTypeU'><br>
            Cabin Description:<br> <textarea id='cabDescU' name='cabDescU' rows='5' cols='50' style='resize: none'></textarea><br>
            Price per Night: <input type='number' name='priceNightU' id='priceNightU'><br>
            Photo: <input type='file' name='image' id='image'><br>
            <input type='submit' name="submitU">
        </form>    
    </div>

    <div class='contentContainer'>
        <h1>Delete an existing cabin</h1>
        <form method='post' name='delete' id='delete' enctype="multipart/form-data">
            Which number cabin would you like to delete?<br><input type='number' name='cabinIDDel'><br>
            <input type='submit' name="submitD">
        </form>
    </div>  


    



    <a href='logout.php'>logout</a>
</body>
</html>