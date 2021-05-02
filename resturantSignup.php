<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="c1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resturant Sign Up</title>
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
        $err = '';
        $resturantName = $city = $region = $street = $number = $coordinates = NULL;

        $conn = new mysqli($servername, $username, $password, $dataBase);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["submitInfo"])) {
            if (empty($_POST["resturantName"]) || empty($_POST["region"]) || empty($_POST["city"]) || empty($_POST["street"])||empty($_POST["number"]) ||
            empty($_POST["coordinates"])) {
                $err = "all fields are required";
            } 
            else {
                $resturantName = test_input($_POST["resturantName"]);
                $city = test_input($_POST["city"]);
                $region = test_input($_POST["region"]);
                $street = test_input($_POST["street"]);
                $number = test_input($_POST["number"]);
                $coordinates = test_input($_POST["coordinates"]);
                $donations = 0;

                $sql = "INSERT INTO Resturant (restName, city, region, street, num, coordinates,
                donatedFood, username, userType) VALUES ('$resturantName', '$city', '$region', '$street', $number, $coordinates, $donations, '$user','R')";
                 if ($conn->query($sql) === TRUE) {
                echo "registered successfully";
                session_start();
                $_SESSION['username'] = $user;
                header("Location: resturant.php");
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
                        resturantName: <input type="text" name="resturantName">
                        <br><br>
                        city: <input type="text" name="city">
                        <br><br>
                        region: <input type="text" name="region">
                        <br><br>
                        street: <input type="text" name="street">
                        <br><br>
                        number: <input type="number" name="number">
                        <br><br>
                        coordinates: <input type="number" name="coordinates">
                        <br><br>
                        <span class="error"><?php echo $err;?></span>
                        <br><br>
                        <input type="submit" name="submitInfo" value="Submit Information">  
                    </form>
                <?php

   
?>

</body>
</html>

