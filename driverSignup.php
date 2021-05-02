<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="c1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Driver Sign Up</title>
</head>
<body>

<!--data base-->   
<?php
 echo filter_input(INPUT_GET,'username', FILTER_SANITIZE_URL);

        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dataBase = "db4";
        session_start();
        $user = $_SESSION['username'];
        $err = "";
        $ssn  = $firstName = $lastName = $carColor = $plateNumber = $DateOfBirth = $coordinates = $region = $available = NULL;

        $conn = new mysqli($servername, $username, $password, $dataBase);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["submitInfo"])) {
            if (empty($_POST["ssn"]) || empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["carColor"])||empty($_POST["plateNumber"]) ||
            empty($_POST["DateOfBirth"]) || empty($_POST["coordinates"]) || empty($_POST["region"])) {
                $err = "all fields are required";
            } 
            else {

                $ssn = test_input($_POST["ssn"]);
                $firstName = test_input($_POST["firstName"]);
                $lastName = test_input($_POST["lastName"]);
                $carColor = test_input($_POST["carColor"]);
                $plateNumber = test_input($_POST["plateNumber"]);
                $DateOfBirth = $_POST["DateOfBirth"];
                $coordinates = test_input($_POST["coordinates"]);
                $region = test_input($_POST["region"]);
                $available = test_input($_POST["available"]);

                //echo $available;
                $sql = "INSERT INTO `driver` (`ssn`, `firstName`, `lastName`, `carColor`, `plateNumber`, `DateOfBirth`,
                 `coordinates`, `region`, `available`, `username`, `userType`) VALUES ($ssn, '$firstName', '$lastName', '$carColor', $plateNumber, '$DateOfBirth', $coordinates, '$region', $available, '$user', 'D')";
                 if ($conn->query($sql) === TRUE) {
                echo "registered successfully";
                session_start();
                $_SESSION['username'] = $user;
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
                    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
                        ssn: <input type="number" name="ssn">
                        <br><br>
                        firstName: <input type="text" name="firstName">
                        <br><br>
                        lastName: <input type="text" name="lastName">
                        <br><br>
                        carColor: <input type="text" name="carColor">
                        <br><br>
                        plateNumber: <input type="number" name="plateNumber">
                        <br><br>
                        DateOfBirth: <input type="date" name="DateOfBirth">
                        <br><br>
                        coordinates: <input type="number" name="coordinates">
                        <br><br>
                        region: <input type="text" name="region">
                        <br><br>
                        available:
                        <input type="radio" name="available" value="1">Yes
                        <input type="radio" name="available" value="0">No
                        <br><br>
                        <span class="error"><?php echo $err;?></span>
                        <br><br>
                        <input type="submit" name="submitInfo" value="Submit Information">  
                    </form>
                <?php


     
  
?>

</body>
</html>