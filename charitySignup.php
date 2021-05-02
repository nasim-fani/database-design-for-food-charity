<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="c1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Charity Sign Up</title>
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
        $charityName = $city = $region = $street = $num = $coordinates = $NumOfCoveredPeople = $charityNeeds = NULL;

        $conn = new mysqli($servername, $username, $password, $dataBase);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["submitInfo"])) {
            if (empty($_POST["charityName"]) || empty($_POST["city"]) || empty($_POST["region"]) || empty($_POST["street"])||empty($_POST["number"]) ||
            empty($_POST["coordinates"]) || empty($_POST["NumOfCoveredPeople"]) || empty($_POST["charityNeeds"])) {
                $err = "all fields are required";
            } 
            else {

                $charityName = test_input($_POST["charityName"]);
                $city = test_input($_POST["city"]);
                $region = test_input($_POST["region"]);
                $street = test_input($_POST["street"]);
                $num = test_input($_POST["number"]);
                $NumOfCoveredPeople = test_input($_POST["NumOfCoveredPeople"]);
                $coordinates = test_input($_POST["coordinates"]);
                $charityNeeds = test_input($_POST["charityNeeds"]);
                
                $sql = "INSERT INTO Charity (charityName, city, region, street, num, NumOfCoveredPeople, coordinates,
                charityNeeds, username, userType) VALUES ('$charityName', '$city', '$region', '$street', $num, $NumOfCoveredPeople, $coordinates, $charityNeeds, '$user', 'C')";
                if ($conn->query($sql) === TRUE) {
               echo "registered successfully";
               session_start();
               $_SESSION['username'] = $user;
               header("Location: charity.php");
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
                        charityName: <input type="text" name="charityName">
                        <br><br>
                        city: <input type="text" name="city">
                        <br><br>
                        region: <input type="text" name="region">
                        <br><br>
                        street: <input type="text" name="street">
                        <br><br>
                        number: <input type="number" name="number">
                        <br><br>
                        NumOfCoveredPeople: <input type="number" name="NumOfCoveredPeople">
                        <br><br>
                        coordinates: <input type="number" name="coordinates">
                        <br><br>
                        charityNeeds: <input type="number" name="charityNeeds"> 
                        <span class="error"><?php echo $err;?></span>
                        <br><br>
                        <input type="submit" name="submitInfo" value="Submit Information">  
                    </form>
                <?php


     
  
?>

</body>
</html>


<!-- INSERT INTO Charity (charityName, city, region, street, num, NumOfCoveredPeople, coordinates,
                charityNeeds, username, userType) VALUES ('angels', 'mashhad', 'khayyam', 'khayyam', 2, 25, 1111, 15, 'c1', 'C') -->