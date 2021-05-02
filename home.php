<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="c1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
<?php

$err = "";
$user = $pass = $userType = $color = $ftn = NULL;

$servername = "localhost";
$username = "username";
$password = "password";
$dataBase = "db4";
$err = "";
$ssn  = $firstName = $lastName = $carColor = $plateNumber = $DateOfBirth = $coordinates = $region = $available = NULL;

$conn = new mysqli($servername, $username, $password, $dataBase);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit'])) {
  if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["userType"])) {
    $err = "all fields are required";
  } 
  else if(empty($_POST["ftn"]) && empty($_POST["color"])){
    $err = "you should at least answer one of the password recovery questions";
  }
  else if(preg_match('/[A-Za-z]/', $_POST["password"]) && preg_match('/[0-9]/', $_POST["password"]) && strlen($_POST["password"])> 7)
   {
    $user = test_input($_POST["username"]);
    $pass = test_input($_POST["password"]);
    $userType = test_input($_POST["userType"]);
    $color = test_input($_POST["color"]);
    $ftn = test_input($_POST["ftn"]);

    $sql = "INSERT INTO User (username,pass,userType) VALUES ('$user','$pass','$userType')";
                $conn->query($sql);
                if(!empty($_POST["color"])) {
                $sql = "INSERT INTO QuestionsList (question,username,answer) VALUES ('color','$user','$color')";
                $conn->query($sql);
                }
                if(!empty($_POST["ftn"])) {
                $sql = "INSERT INTO QuestionsList (question,username,answer) VALUES ('faveTeacher','$user','$ftn')";
                $conn->query($sql);
                }
                session_start();
                $_SESSION['username'] = $user;
                if($userType=='D'){
                  header("Location: driverSignup.php?username=".$user);
                }
                if($userType=='R'){
                  header("Location: resturantSignup.php?username=".$user);
                }
                if($userType=='C'){
                  header("Location: charitySignup.php?username=".$user);
                }   
           
    }
    else{
      echo 'weak password!';
    }
 }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }


?>
<p><b>register new users:</b> </p>
    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
        Username: <input type="text" name="username">
        <br><br>
         Password: <input type="text" name="password">
        <br><br>
         UserType:
         <input type="radio" name="userType" value="R">Resturant
         <input type="radio" name="userType" value="C">Charity
         <input type="radio" name="userType" value="D">Driver
        <br><br>
        favourite color: <input type="text" name="color">
        <br><br>
         first teacher's name: <input type="text" name="ftn">
        <br><br>
        <input type="submit" name="submit" value="Submit">  
    </form>
    
    <br><br>
    <br><br>
    <br><br>

    <p><b>login users:</b> </p>
    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
        Username: <input type="text" name="loguser">
        <br><br>
         Password: <input type="text" name="logpass">
        <br><br>
         <input type="submit" name="login" value="login">  
    </form>
    
    <br><br>
    <br><br>
    <br><br>
    <p><b>Password Recovery:</b> </p>
    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
        Username: <input type="text" name="fUsername">
        <br><br>
        favourite color: <input type="text" name="fColor">
        <br><br>
        first teacher's name: <input type="text" name="fFtn">
        <br><br>
        new password: <input type="text" name="fPass">
        <br><br>
        <input type="submit" name="forgetPassword" value="forget Password">  
    </form>

    <br><br>
    <br><br>
    <br><br>
    
<?php
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dataBase = "db4";

        $conn = new mysqli($servername, $username, $password, $dataBase);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
    
        //$sql = "CREATE DATABASE mydb";

        
        $sql = "CREATE TABLE IF NOT EXISTS User (
             username VARCHAR(30) NOT NULL UNIQUE,
             pass VARCHAR(50) NOT NULL,
             userType CHAR(1) NOT NULL,
             PRIMARY KEY(username,userType),
             CHECK (userType IN ('R', 'C', 'D'))
             
        )";
        if ($conn->query($sql) === TRUE) {
          // echo "Table created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS Resturant ( 
          restName VARCHAR(30) NOT NULL PRIMARY KEY,
          city VARCHAR(50) NOT NULL,
          region VARCHAR(50) NOT NULL,
          street VARCHAR(50) NOT NULL,
          num INT(5) NOT NULL,
          coordinates INT(5) NOT NULL,
          donatedFood INT(5) DEFAULT 0,
          username VARCHAR(30) NOT NULL,
          userType CHAR(1) NOT NULL,
          FOREIGN KEY (username,userType)
            REFERENCES User (username,userType)
          ON DELETE CASCADE
          ON UPDATE CASCADE

        )";
        if ($conn->query($sql) === TRUE) {
          // echo "Table created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS Driver (
          ssn INT(30) NOT NULL PRIMARY KEY,
          firstName VARCHAR(50) NOT NULL,
          lastName VARCHAR(50) NOT NULL,
          carColor VARCHAR(50) NOT NULL,
          plateNumber INT(5) NOT NULL,
          DateOfBirth DATE NOT NULL,
          coordinates INT(5) NOT NULL,
          region VARCHAR(50) NOT NULL,
          available BOOLEAN NOT NULL,
          username VARCHAR(30) NOT NULL,
          userType CHAR(1) NOT NULL,
          countChange INT(10) DEFAULT 0,
          FOREIGN KEY (username,userType)
            REFERENCES User (username,userType)
          ON DELETE CASCADE
          ON UPDATE CASCADE
             
        )";
        if ($conn->query($sql) === TRUE) {
          // echo "Table created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS Charity (
          charityName VARCHAR(50) NOT NULL PRIMARY KEY,
          city VARCHAR(50) NOT NULL,
          region VARCHAR(50) NOT NULL,
          street VARCHAR(50) NOT NULL,
          num INT(5) NOT NULL,
          coordinates INT(5) NOT NULL,
          NumOfCoveredPeople INT(5) ,
          charityNeeds INT(5) default NumOfCoveredPeople,
          username VARCHAR(30) NOT NULL,
          userType CHAR(1) NOT NULL,      
          FOREIGN KEY (username,userType)
            REFERENCES User (username,userType)
          ON DELETE CASCADE
          ON UPDATE CASCADE
        )";
        if ($conn->query($sql) === TRUE) {
          // echo "Table created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS Evaluation (
          ssn INT(5) NOT NULL ,
          charityName VARCHAR(50) NOT NULL ,
          rate INT(5) NOT NULL,
          evalDate TIMESTAMP DEFAULT DATE(yyyy/mm/dd),
          CONSTRAINT CheckRate CHECK (rate BETWEEN 1 and 5),
          FOREIGN KEY ( charityName )
            REFERENCES Charity(charityName) , 
          FOREIGN KEY (ssn)
            REFERENCES Driver(ssn)  
          ON DELETE CASCADE
          ON UPDATE CASCADE              
        )";

        if ($conn->query($sql) === TRUE) {
          // echo "Table created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }

        $sql = "CREATE TABLE IF NOT EXISTS QuestionsList (
          question VARCHAR(30) NOT NULL, 
          username VARCHAR(30) NOT NULL,
          answer VARCHAR(30) NOT NULL,
          FOREIGN KEY ( username )
            REFERENCES User(username)
          ON DELETE CASCADE
          ON UPDATE CASCADE
        )";

        if ($conn->query($sql) === TRUE) {
          // echo "Table created successfully";
        } else {
          echo "Error creating table: " . $conn->error;
        }

      $sql = "CREATE TABLE IF NOT EXISTS RC (
        rUsername VARCHAR(30) NOT NULL, 
        cUsername VARCHAR(30) NOT NULL,
        FOREIGN KEY ( rUsername )
          REFERENCES User(username),
        FOREIGN KEY ( cUsername )
          REFERENCES User(username)
        ON DELETE CASCADE
        ON UPDATE CASCADE
     
      )";

      if ($conn->query($sql) === TRUE) {
        // echo "Table created successfully";
      } else {
        echo "Error creating table: " . $conn->error;
      }
      
    
      $sql = "CREATE TABLE IF NOT EXISTS Logs (
        rUsername VARCHAR(30) NOT NULL, 
        cUsername VARCHAR(30) NOT NULL,
        dUsername VARCHAR(30) NOT NULL,
        donatedFood INT(5) NOT NULL,
        dateLog TIMESTAMP DEFAULT DATE(yyyy/mm/dd),
        FOREIGN KEY ( rUsername )
          REFERENCES User(username),
        FOREIGN KEY ( cUsername )
          REFERENCES User(username),
          FOREIGN KEY ( dUsername )
          REFERENCES User(username)    
      )";

      if ($conn->query($sql) === TRUE) {
        // echo "Table created successfully";
      } else {
        echo "Error creating table: " . $conn->error;
      }




      

      $sql = "CREATE TRIGGER IF NOT EXISTS trigger7
      AFTER UPDATE ON User
      FOR EACH ROW
      begin 
      if old.username = 'c2' then
      INSERT INTO rc(rUsername,cUsername) SELECT d.username,d.username from user as d where d.username=old.username;
      end if;
      end";

      if ($conn->query($sql) === TRUE) {
        // echo "Table created successfully";
      } else {
        echo "Error creating table: " . $conn->error;
      }


        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['login']))
      {
        if (empty($_POST["loguser"]) || empty($_POST["logpass"])) {
          echo "all fields are required";
        }
        else{
          $loguser = test_input($_POST["loguser"]);
          $logpass = test_input($_POST["logpass"]);

          $sql = "SELECT * FROM User WHERE username ='".$loguser."'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          $rightPass = $row['pass'];
          $loginType = $row['userType'];
         
          if($rightPass == $logpass) {
            session_start();
            $_SESSION['username'] = $loguser;
            echo "registered successfully";
            if($loginType=='D'){
              header("Location: driver.php?username=".$loguser);
            }
            if($loginType=='R'){
              header("Location: resturant.php?username=".$loguser);
            }
            if($loginType=='C'){
               header("Location: charity.php?username=".$loguser);
            }
                      
          }
          else{
            echo "wrong password!";
          }
        }
  
      }



      if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['forgetPassword']))
      {
        if (empty($_POST["fUsername"]) || empty($_POST["fPass"])|| (empty($_POST["fFtn"]) && empty($_POST["fColor"]))){
          echo "fill in the fields!";
        }
        else{
          $fUsername = test_input($_POST["fUsername"]);
          $fPass = $_POST["fPass"];

          if(!empty($_POST["fFtn"])){
            $fFtn = $_POST["fFtn"];
            $sql = "SELECT * FROM questionslist WHERE username ='".$fUsername."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $rightAnswer = $row['answer'];
            if($fFtn == $rightAnswer){
              $sql = "UPDATE User SET pass ='$fPass' WHERE username='$fUsername'";
              $result = mysqli_query($conn, $sql);
              echo "password changed";
            }
          }

          else if(!empty($_POST["fColor"])){
            $fColor = $_POST["fColor"];
            $sql = "SELECT * FROM questionslist WHERE username ='".$fUsername."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $rightAnswer = $row['answer'];
            if($fColor == $rightAnswer){
              $sql = "UPDATE User SET pass ='$fPass' WHERE username='$fUsername'";
              $result = mysqli_query($conn, $sql);
              echo "password changed";
            }
          }

          
        }
  
      }


?>

<br>
<br>
<p><b>Enter your username and password to delete your account</b> </p>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
    UserName: <input type="text" name="deleteUser" id="">
    Password: <input type="password" name="deletePass" id=""> <br>
    <br>
    <input type="submit" name="delete" value="Load users data" />
    <br>
    <br>
    </form>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['delete'])) {
      if (empty($_POST["deleteUser"]) || empty($_POST["deletePass"])) {
        $err = "all fields are required";
      } 
      else {
        $deleteUser = test_input($_POST["deleteUser"]);
        $deletePass = test_input($_POST["deletePass"]);
            
        $sql = "SELECT pass FROM User WHERE username ='".$deleteUser."'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $rightPass = $row['pass'];
          if ($rightPass==$deletePass) {
            $sql ="DELETE FROM User WHERE username ='".$deleteUser."'";
            $result = mysqli_query($conn, $sql);
            if($result === true){
              echo "deleted successfully";
            }
            else{
              echo "Error deleting user: " . $conn->error;
            }
          } else {
              echo "Error: Wrong info" ;
            }
          }
    }

 ?>

 
<br>
<br>
<p><b>Enter ADMIN password </b> </p>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
    Password: <input type="password" name="adminPass" id=""> <br>
    <br>
    <input type="submit" name="admin" value="submit" />
    <br>
    <br>
    </form>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['admin']))
    {

      if ($_POST["adminPass"]=="adminadmin") {
        header("Location: admin.php");
      }
      else{
        echo "access denied!";
      }
    }
   
 ?>

</body>
</html>