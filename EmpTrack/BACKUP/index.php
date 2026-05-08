<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Module/connection.php';

$usernameErr = $EmpIDErr = "";
$emailErr = $mobileNumberErr = "";
$PasswordErr = "";

if (isset($_POST["submit"])) {
    //password patern
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{6,}$/';
//username
    if (empty($_POST["userName"])) {
        $usernameErr = "Please Enter Your Username";
    } elseif (!preg_match('/^[a-zA-Z ]{3,}$/', $_POST["userName"])) {
        $usernameErr = "Name Must be Letters And atLeast Have 2 Character";
    }
    //empID
    if (empty($_POST["EmpID"])) {
        $EmpIDErr = "Please Enter Your EmployeeID";
    } elseif (!preg_match('/^[a-zA-Z0-9]{3,}$/', $_POST["EmpID"])) {
        $EmpIDErr = "Enter Valid Employee ID";
    }
    //email
    if (empty($_POST["email"])) {
        $emailErr = "Please Enter Your Email";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid Email Format";
    }
    //Mobile Number
    if (empty($_POST["mobileNumber"])) {
        $mobileNumberErr = "Please Enter Your Mobile Number";
    }elseif (!preg_match('/^[0-9]{1,10}$/', $_POST["mobileNumber"])) {
        $mobileNumberErr = "Invalid Mobile Number";
    }
    //password
    if (empty($_POST["Password"])) {
        $PasswordErr = "Please Enter Password";
    }elseif (!preg_match($pattern , $_POST["Password"])) {
        $PasswordErr = "Password Must be 6 character long with mix of number , letter and special Character";
    }


if( 
    empty($usernameErr) &&
    empty($EmpIDErr) &&
    empty($emailErr) &&
    empty($mobileNumberErr) &&
    empty($PasswordErr)
){
    $stmt = $conn->prepare("
            INSERT INTO emp_table
            (full_name, email, password, mobile, emp_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssss", $_POST['userName'], $_POST['email'], $_POST['Password'], $_POST['mobileNumber'], $_POST['EmpID']);

         if ($stmt->execute()) {
            echo "<script>alert('Data Submitted Successfully');</script>";
}
 else {
            echo "Error : " . $stmt->error;
        }

        $stmt->close();

echo "fine";
}
header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Register</title>
</head>
<body>

<div class="main-register flex flex-col">
    <h2 class="flex justify-center py-10">Register</h2>
    <div class="form flex justify-center ">
        <form method="POST" action="">
          <!-- <form method="POST" action=""> -->

  <div class="form-group">
    <label for="userName">Full Name</label>
    <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter your name">
    <p class="text-red-500 text-[sm]"><?php echo $usernameErr ?></p>
  </div>
  <div class="form-group">
  <label for="empID">Employee ID</label>
  <input type="text" class="form-control" id="EmpID" name="EmpID" placeholder="e.g. 00123 or EMP-456" inputmode="numeric">
  <p class="text-red-500 text-[sm]"><?php echo $EmpIDErr ?></p>
</div>      
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text" class="form-control" name="email" id="email1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    <p class="text-red-500 text-[sm]"><?php echo $emailErr ?></p>
  </div>
    <label for="mobileNumber">Mobile Number</label>
  <input type="text" class="form-control" id="mobileNumber" name="mobileNumber" placeholder="Enter mobile number" >
  <small id="mobileHelp" class="form-text text-muted">Please enter your 10-digit mobile number.</small>
  <p class="text-red-500 text-[sm]"><?php echo $mobileNumberErr ?></p>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
    <p class="text-red-500 text-[sm]"><?php echo $PasswordErr ?></p>
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
</form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
</body>
</html>