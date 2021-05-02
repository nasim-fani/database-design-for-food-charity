<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="c1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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


            function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
            }
?>
                
<br><br><br><br>

<p><b>Charities number of covered people in each region:</b></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
            <input type="submit" name="region" value="Display"/>            
        </form>
        <br><br>
    <p><b>Drivers avg>4:</b></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
            <input type="submit" name="driverAvg" value="Display"/>            
        </form>
        <br><br>
    <p><b>Best and worst rate:</b></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
            <input type="submit" name="bRate" value="Display"/>            
        </form>
        <br><br>
    <p><b>sorted Resturant:</b></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
            <input type="submit" name="sr" value="Display"/>            
        </form>
        <br><br>
    <p><b>most changed driver:</b></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
            <input type="submit" name="most" value="Display"/>            
        </form>
        <br><br>
    <p><b>Most needed charity:</b></p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
            <input type="submit" name="mc" value="Display"/>            
        </form>


        <?php

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["region"] ))
{
    $sql = "SELECT region,avg(NumOfCoveredPeople) AS av FROM Charity group by region";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query to show fields from table failed");
    } 
    while($row = $result->fetch_assoc())
    {
        echo "<tr>";

        echo "<td>".$row['region']."</td>";
        echo "<td>".$row['av']."</td>";
     
        echo "</tr><br>";
    } 
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["driverAvg"] ))
{
   
    $sql = "SELECT AVG(rate) AS avrate,username FROM evaluation group by username having AVG(rate)>4 ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query to show fields from table failed");
    } 
    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>".$row['avrate']."</td>";
        echo "<td>".$row['username']."</td>";
        echo "</tr><br>";
    }   
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["bRate"] ))
{
   
    $sql = "SELECT Max(rate) As xRate,Min(rate) AS nRate FROM evaluation group by username";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query to show fields from table failed");
    } 
    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>".$row['xRate']."</td>";
        echo "<td>".$row['nRate']."</td>";
        echo "<td>".$row['username']."</td>";
        echo "</tr><br>";
    }   
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["sr"] ))
{
   
    $sql = "SELECT username FROM resturant order by donatedFood desc ";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query to show fields from table failed");
    } 
    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>".$row['username']."</td>";
        echo "</tr><br>";
    }   
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["most"] ))
{
   
    $sql = "SELECT username, max(countChange) AS mc FROM driver group by username";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query to show fields from table failed");
    } 
    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['mc']."</td>";
        echo "</tr><br>";
    }   
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["mc"] ))
{
    $sql = "SELECT cUsername,sum(donatedFood) AS do FROM Logs group by cUsername";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    {
        $unaame = $row['cUsername'];
        $usum= ['do'];
        $sql1 = "SELECT Count(rUsername) AS rCount FROM RC Where cUsername='".$unaame."'";
        $result2 = $conn->query($sql1);
        $row = $result->fetch_assoc();
        $rCount = $row['rCount'];
        $sql = "SELECT cUsername  FROM Charity,Logs,RC Where Max(Charity.NumOfCoveredPeople-('".$usum."'.'+'.'".$rCount."')";
        $result3 = $conn->query($sql);
        while($row2 = $result3->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>".$row2['cUsername']."</td>";
            echo "</tr><br>";
        } 
    } 
   
    
    $result = $conn->query($sql);
    if (!$result) {
        die("Query to show fields from table failed");
    } 
    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['mc']."</td>";
        echo "</tr><br>";
    }   
}
?>

</body>
</html>
