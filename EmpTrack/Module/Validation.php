<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// require_once __DIR__ . '/connection.php';

$usernameErr = $EmpIDErr = "";
$emailErr = $mobileNumberErr = "";
$PasswordErr = "";

if (isset($_POST["submit"])) {
    //password patern
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{6,}$/';
//username
    if (empty($_POST["userName"])) {
        $usernameErr = "Please Enter Your Username";
    } elseif (!preg_match('/^[a-zA-Z]{3,}$/', $_POST["userName"])) {
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
        $emailErr = "Invalid Mobile Number";
    }
    //password
    if (empty($_POST["Password"])) {
        $PasswordErr = "Please Enter Password";
    }elseif (!preg_match($pattern , $_POST["Password"])) {
        $PasswordErr = "Password Must be 6 character long with mix of number , letter and special Character";
    }
}

if( 
    empty($usernameErr) &&
    empty($EmpIDErr) &&
    empty($emailErr) &&
    empty($mobileNumberErr) &&
    empty($PasswordErr)
){
//     $stmt = $conn->prepare("
//             INSERT INTO emp_table
//             (full_name, email, password, mobile, emp_id)
//             VALUES (?, ?, ?, ?, ?)
//         ");
//         $stmt->bind_param("sssss", $_POST['userName'], $_POST['email'], $_POST['Password'], $_POST['mobileNumber'], $_POST['EmpID']);

//          if ($stmt->execute()) {
//             echo "<script>alert('Data Submitted Successfully');</script>";
// }
//  else {
//             echo "Error : " . $stmt->error;
//         }

//         $stmt->close();

echo "fine";
}

?>