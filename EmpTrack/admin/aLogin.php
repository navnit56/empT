<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../Module/connection.php';

$emailErr = $PasswordErr ="";
$loginErr = "";

// $password = password_hash("123456", PASSWORD_DEFAULT);

// echo $password;

if (isset($_POST["submit"])) {

$_SESSION['aemail'] = $_POST["aemail"];
$_SESSION['aPassword'] = $_POST["aPassword"];
//email
    if (empty($_POST["aemail"])) {
        $emailErr = "Please Enter Your Email";
    } elseif (!filter_var($_POST["aemail"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid Email Format";
    }
//password
    if (empty($_POST["aPassword"])) {
        $PasswordErr = "Please Enter Password";
    }

    if(empty($emailErr) && empty($PasswordErr)){
        $stmt = $conn->prepare("SELECT id, password FROM emp_table WHERE email = ? AND role = 'admin'");
        $stmt->bind_param("s", $_SESSION['aemail']);
            $stmt->execute();

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $password = $user['password'];

            var_dump($_SESSION['aPassword']); 
var_dump($user['password']);
var_dump(password_verify($_POST["aPassword"], $password));

         if($user && password_verify($_POST["aPassword"], $password)) {
        $_SESSION['admin_id'] = $user['id'];
     header("Location: /EmpTrack/admin/adashboard.php");
        exit();
         } else{
            $loginErr = "Invalid email and password";
            // header("Location: ");
            // exit();
         } 
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>

<div class="main-register flex flex-col">
    <h2 class="flex justify-center py-10"> Admin Login</h2>
    <div class="form flex justify-center ">
        <form method="POST" action="">
          <!-- <form method="POST" action=""> -->
  <div class="form-group">
    <label for="exampleInputEmail1"> Admin Email address</label>
    <input type="text" class="form-control" name="aemail" id="aemail1" aria-describedby="emailHelp" placeholder="Enter admin email">
    <p class="text-red-500 text-[sm] text-wrap"><?php echo $emailErr ?></p>
  </div>
   
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="aPassword" name="aPassword" placeholder="Password">
    <p class="text-red-500 text-[sm] text-wrap"><?php echo $PasswordErr ?></p>
  </div>
 
  <button type="submit" name="submit" id="submit" class="btn btn-primary">Login</button>
  <p class="text-red-500 text-[sm] text-wrap"><?php echo $loginErr ?></p>

  
</form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
</body>
</html>