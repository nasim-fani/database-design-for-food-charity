<!DOCTYPE html>
    <html lang="en">
        <head>
            <link rel="stylesheet" type="text/css" href="c1.css">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Driver</title>
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
                                            
                        
            if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["update"])) {
                if (!empty($_POST["uRegion"])) {
                    $uRegion=$_POST["uRegion"];  
                    $sql = "UPDATE Driver SET region ='$uRegion' WHERE username='$user'";
                  if ($conn->query($sql) === TRUE) {
                     echo "Record updated successfully <br>";
                  } else {
                     echo "Error updating record <br>";
                  }

                  $sql = "UPDATE Driver SET countChange = countChange+1 WHERE username='$user'";
                  if ($conn->query($sql) === TRUE) {
                    
                  } else {
                     echo "Error updating record <br>";
                  }
                } 

                if (!empty($_POST["uAvailable"])) {
                    $uAvailable=$_POST["uAvailable"];  
                    $sql = "UPDATE Driver SET available ='$uAvailable' WHERE username='$user'";
                  if ($conn->query($sql) === TRUE) {
                     echo "Record updated successfully <br>";
                  } else {
                     echo "Error updating record <br>";
                  }

                  $sql = "UPDATE Driver SET countChange = countChange+1 WHERE username='$user'";
                  if ($conn->query($sql) === TRUE) {
                    
                  } else {
                     echo "Error updating record <br>";
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
           <p><b>change region & availability:</b></p>
            <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
                region: <input type="text" name="uRegion">
                <br><br>
                available:
                    <input type="radio" name="uAvailable" value="1">Yes
                    <input type="radio" name="uAvailable" value="0">No
                <br><br>
                <input type="submit" name="update" value="Submit Information">  
            </form>
            <br><br>
            <br><br>
                                            
                                            
          <p><b>edit information:</b></p>
                        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
                        New Password:<input type="text" name="newPassword" id=""> 
                        <br><br>
                        New First Name:<input type="text" name="newFirstName" id=""> 
                        <br><br>
                        New Last Name:<input type="text" name="newLastName" id="">
                        <br><br>
                        New Car Color:<input type="text" name="newCarColor" id="">
                        <br><br>
                        New plate Number :<input type="number" name="newPlate" id="">
                        <br><br>
                        New Coordinate:<input type="number" name="newCoordinate" id="">
                        <br><br>
                        <input type="submit" name="editAction" value="Edit info"/>            
                        </form>

                        <?php
                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["editAction"] ))
                        {
                          
                           if(!empty($_POST["newFirstName"])){
                                $nName=$_POST["newFirstName"];  
                                $sql = "UPDATE Driver SET firstName ='$nName' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Driver First Name Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newLastName"])){
                                $nlastName=$_POST["newLastName"];  
                                $sql = "UPDATE Driver SET lastName ='$nlastName' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Driver Last Name Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newPassword"])){
                                $nPass=$_POST["newPassword"];  
                                $sql = "UPDATE User SET pass ='$nPass' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Driver Password Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newCarColor"])){
                                $nCarColor=$_POST["newCarColor"];  
                                $sql = "UPDATE Driver SET carColor ='$nCarColor' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Car Color Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newPlate"])){
                                $nPlate=$_POST["newPlate"];  
                                $sql = "UPDATE Driver SET plateNumber ='$nPlate' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "plate Number Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                            if(!empty($_POST["newCoordinate"])){
                                $nCoordinate=$_POST["newCoordinate"];  
                                $sql = "UPDATE Driver SET coordinates ='$nCoordinate' WHERE username='$user'";
                              if ($conn->query($sql) === TRUE) {
                                 echo "Coordinates Record updated successfully <br>";
                              } else {
                                 echo "Error updating record <br>";
                              }                      
                            }

                        }
                                                                                   
       ?>


<br><br><br><br>

                        <p><b>drivers in each region:</b></p>
                                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
                                    <input type="submit" name="showDriver" value="Display"/>            
                                </form>
                                <br><br>
                            <p><b>resturant:</b></p>
                                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
                                    <input type="submit" name="showResturant" value="Display"/>            
                                </form>


                                <?php

                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["showDriver"] ))
                        {
                            $sql = "SELECT username FROM Driver WHERE available=1 group by region";
                            $result = $conn->query($sql);
                            if (!$result) {
                                die("Query to show fields from table failed");
                            } 
                            while($row = $result->fetch_assoc())
                            {
                                echo "<tr>";

                                echo "<td>".$row['username']."</td>";
                             
                                echo "</tr><br  >";
                            } 
                        }

                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["showResturant"] ))
                        {
                           
                            $sql = "SELECT rUsername,Count(rUsername) FROM logs WHERE dUsername='".$user."' order by Count(rUsername) ";
                            $result = $conn->query($sql);
                            if (!$result) {
                                die("Query to show fields from table failed");
                            } 
                            while($row = $result->fetch_assoc())
                            {
                                echo "<tr>";

                                echo "<td>".$row['rUsername']."</td>";
                             
                                echo "</tr><br>";
                            }   
                        }
                        ?>
                        </body>
                        </html>


                                                           
                  