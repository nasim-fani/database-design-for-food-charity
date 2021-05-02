<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="c1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resturant</title>
</head>
<body>

<!--data base-->   
<?php


        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dataBase = "db4";
        session_start();
        $user = $_SESSION['username'];
        $err = "";
        $charity  = $driver = $foodNum = NULL;

        $conn = new mysqli($servername, $username, $password, $dataBase);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

       

        if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["submitInfo"])) {
            if (empty($_POST["foodNum"]) || empty($_POST["driver"]) || empty($_POST["charity"])) {
                $err = "all fields are required";
            } 
            else {

                $fdriver = test_input($_POST["foodNum"]);
                $driver = test_input($_POST["driver"]);
                $charity = test_input($_POST["charity"]);

                $sql = "UPDATE Resturant SET donatedFood = donatedFood +".$foodNum."WHERE username=".$user;
                $conn->query($sql);
                $sql = "UPDATE Charity SET charityNeeds = charityNeeds -".$foodNum."WHERE username=".$charity;
                $conn->query($sql);
                $date = $conn->query("SELECT CURRENT_DATE()");
                $sql = "INSERT INTO Logs (rUsername, cUsername, dUsername, donatedFood, dateLog) VALUES ('$user', '$charity', '$driver', $fdriver, DATE($date))";
                 if ($conn->query($sql) === TRUE) {
                echo "Food donated successfully";
                } else {
                echo "Error: " . $conn->error;
                }
            }
                               
            }

            function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
            }
            if(true){
                echo $user;
            $sql3 = "SELECT * FROM Resturant WHERE username= '".$user."'";
            $result3 = mysqli_query($conn, $sql3);//resturant region
            if ($conn->query($sql3) === TRUE) {
                echo "Food donated successfully";
                } else {
                echo "Error:" . $conn->error;
                }
            }
            $row3 = mysqli_fetch_assoc($result3);
            $region = $row3['region'];
           echo $region;

            $sql = "SELECT cUsername FROM RC WHERE rUsername='".$user."'";
            $result = mysqli_query($conn, $sql);//charities
            
            
            $sql2 = "SELECT username FROM Driver WHERE region='".$region."'";//add availability 
            $result2 = mysqli_query($conn, $sql2);//drivers
            if ($conn->query($sql3) === TRUE) {
                echo "Food donated successfully";
                } else {
                echo "Error:" . $conn->error;
                }
            
            
           

?>
                <p><b>donate food:</b></p>
                    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
                        food number: <input type="number" name="foodNum">
                        <br><br>
                        <?php
                        echo 'driver:';
                        echo '<select name="driver">'; 
                        
                        if (mysqli_num_rows($result2) > 0) {
                            while($row = mysqli_fetch_assoc($result2)) {
                                echo '<option name = driver value="'.$row['username'].'">'.$row['username'].'</option>';
                            }
                        }
                        echo '</select>';
                        echo '<br><br>';
                        echo 'charity:';
                        echo '<select name="charity">'; 
                        
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<option name=charity value="'.$row['cUsername'].'">'.$row['cUsername'].'</option>';
                            }
                        }
                        echo '</select>';
                        ?>
                        <span class="error"><?php echo $err;?></span>
                        <br><br>
                        <input type="submit" name="submitInfo" value="Donate">  
                    </form>



                <?php
                 if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["addCharity"])) {
                    if (empty($_POST["newCharity"])) {
                        $err = "all fields are required";
                    } 
                    else {
        
                        $newCharity = test_input($_POST["newCharity"]);
                        
                        
                         $sql = "INSERT INTO RC (rUsername,cUsername) VALUES ('$user', '$newCharity')";
                         if ($conn->query($sql) === TRUE) {
                        echo "added successfully";
                        } else {
                        echo "Error: " . $conn->error;
                        }
                    }
                                       
                    }
  
?>

<br><br><br><br>
           <p><b>add charity to your list:</b></p>
                <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
                     charity username: <input type="text" name="newCharity">
                    <br>
                    <span class="error"><?php echo $err;?></span>
                    <br>
                    <input type="submit" name="addCharity" value="Add">  
                </form>
                <br><br><br><br>

                <p><b>edit information:</b></p>
                        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
                        New Password:<input type="text" name="newPassword" id=""> 
                        <br><br>
                        New Name:<input type="text" name="newName" id=""> 
                        <br><br>
                        New City:<input type="text" name="newCity" id="">
                        <br><br>
                        New Region:<input type="text" name="newRegion" id="">
                        <br><br>
                        New Street:<input type="text" name="newStreet" id="">
                        <br><br>
                        New Number:<input type="number" name="newNumber" id="">
                        <br><br>
                        New Coordinate:<input type="number" name="newCoordinate" id="">
                        <br><br>
                        <input type="submit" name="editAction" value="Edit info"/>            
                        </form>

                        <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["editAction"] ))
                        {
                          
                           if(!empty($_POST["newName"])){
                                $nName=$_POST["newName"];  
                                $sql = "UPDATE Resturant SET restName ='$nName' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Resturant Name Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newPassword"])){
                                $nPass=$_POST["newPassword"];  
                                $sql = "UPDATE User SET pass ='$nPass' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Resturant Password Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newCity"])){
                                $nCity=$_POST["newCity"];  
                                $sql = "UPDATE Resturant SET city ='$nCity' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "City Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newRegion"])){
                                $nRegion=$_POST["newRegion"];  
                                $sql = "UPDATE Resturant SET region ='$nRegion' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Region Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newStreet"])){
                                $nStreet=$_POST["newStreet"];  
                                $sql = "UPDATE Resturant SET street ='$nStreet' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Street Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newNumber"])){
                                $nNum=$_POST["newNumber"];  
                                $sql = "UPDATE Resturant SET num ='$nNum' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Number Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newCoordinate"])){
                                $nCoor=$_POST["newCoordinate"];  
                                $sql = "UPDATE Resturant SET coordinates ='$nCoor' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Coordinates Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                        }
                        ?>

                        <br><br><br><br>

                        <p><b>Resturants has Contract with charity:</b></p>
                                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
                                    <input type="submit" name="showCharities" value="Display"/>            
                                </form>
                                <br><br>
                            <p><b>Least Donation Charity</b></p>
                                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
                                    <input type="submit" name="LeastDonation" value="Display"/>            
                                </form>


                                <?php

                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["showCharities"] ))
                        {
                            $sql = "SELECT DISTINCT * FROM RC WHERE cUsername in(
                            SELECT DISTINCT cUsername FROM RC WHERE rUsername='".$user."')";
                            $result = mysqli_query($conn, $sql);//charities  
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    if($row['rUsername'] != $user){
                                        echo $row['rUsername'];
                                        echo '<br>';
                                    }
                                    
                                }
                            }
                        }

                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["LeastDonation"] ))
                        {
                        //  $sql = "SELECT cUsername FROM Logs WHERE (rUsername ='".$user."' and cUsername in min(
                        //         SELECT count(cUasername) FROM Logs WHERE rUsername='".$user."'))";
                                $sql ="SELECT COUNT(cUsername) AS co,cUsername FROM Logs WHERE rUsername ='".$user."'group by cUsername order by co";

                                $result = mysqli_query($conn, $sql);//charities 
                                
                                if (mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result) ;
                                        
                                            echo $row['cUsername'];
                                            echo $row['co'];
                                            echo '<br>';
                                        
                                        
                                    
                                } 
                        }

                        ?>
</body>
</html>