<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="c1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Charity</title>
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

        $conn = new mysqli($servername, $username, $password, $dataBase);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 


        //evaluation
        if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["evalution"])) {
            if (empty($_POST["eval"])) {
                $err = "all fields are required";
            } 
            else {

                $eval = test_input($_POST["eval"]);
  
                 $sql = "INSERT INTO Evaluation (ssn, firstName, lastName, carColor, plateNumber, DateOfBirth, coordinates,
                 region, available ,username, userType) VALUES ($ssn, '$firstName', '$lastName', '$carColor', $plateNumber, $DateOfBirth, $coordinates, '$region', $available, '$user', 'D')";
                 if ($conn->query($sql) === TRUE) {
                echo "registered successfully";
                } else {
                echo "Error: " . $conn->error;
                }
            }
                               
            }


            //food needs
            if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["foodNeeds"])) {
                if (empty($_POST["foodNum"])) {
                    $err = "all fields are required";
                } 
                else {
    
                    $foodNum = test_input($_POST["foodNum"]);
                    $sql = "UPDATE Charity SET charityNeeds=".$foodNum."WHERE username=".$user;
                     if ($conn->query($sql) === TRUE) {
                    echo "set successfully";
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
            
?>
                    <p><b>change food needs:</b></p>
                    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
                        food needs: <input type="number" name="foodNum">
                        <br><br>
                        <span class="error"><?php echo $err;?></span>
                        <br><br>
                        <input type="submit" name="foodNeeds" value="Submit Information">  
                    </form>
                    <br><br>
                    <br><br>
                    <p><b>evaluate driver:</b></p>
                    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
                        evaluation: <input type="number" name="eval">
                        <br><br>
                        <span class="error"><?php echo $err;?></span>
                        <br><br>
                        <input type="submit" name="evaluation" value="Submit Information">  
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
                        New Number Of Covered People:<input type="number" name="newPeople" id="">
                        <br><br>
                        <input type="submit" name="editAction" value="Edit info"/>            
                        </form>

                        <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["editAction"] ))
                        {
                          
                           if(!empty($_POST["newName"])){
                                $nName=$_POST["newName"];  
                                $sql = "UPDATE Charity SET charityName ='$nName' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Charity Name Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newPassword"])){
                                $nPass=$_POST["newPassword"];  
                                $sql = "UPDATE User SET pass ='$nPass' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Charity Password Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newCity"])){
                                $nCity=$_POST["newCity"];  
                                $sql = "UPDATE Charity SET city ='$nCity' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "City Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newRegion"])){
                                $nRegion=$_POST["newRegion"];  
                                $sql = "UPDATE Charity SET region ='$nRegion' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Region Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newStreet"])){
                                $nStreet=$_POST["newStreet"];  
                                $sql = "UPDATE Charity SET street ='$nStreet' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Street Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newNumber"])){
                                $nNum=$_POST["newNumber"];  
                                $sql = "UPDATE Charity SET num ='$nNum' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Number Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newCoordinate"])){
                                $nCoor=$_POST["newCoordinate"];  
                                $sql = "UPDATE Charity SET coordinates ='$nCoor' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Coordinates Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newPeople"])){
                                $nPeople=$_POST["newPeople"];  
                                $sql = "UPDATE Charity SET NumOfCoveredPeople ='$nPeople' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Number Of Covered People Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }
                        }
                                                           
                    ?>

</body>
</html>