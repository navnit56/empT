<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
require_once __DIR__ . '/../Module/connection.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if(isset($_POST["update"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $profile_img = $_FILES["photo"]["name"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_img);

    $query = "UPDATE emp_table SET full_name='$name', email='$email', mobile='$mobile', profile_img='$profile_img' WHERE id='$_SESSION[user_id]'";

    if(mysqli_query($conn, $query)) {
        $_SESSION['username'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['mobile'] = $mobile;
        header("Location: Details.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Edit Profile</title>
</head>
<body>
        <!-- NavBar -->
<div class="navbar flex items-center justify-between bg-[#007bff] px-8 py-4 shadow-lg text-white">
            <div class="nav-start px-4 py-1.5 rounded-lg text-[#007bff] font-bold text-xl bg-white shadow-sm">
                Dashboard
            </div>
            <div class="nav-end flex items-center gap-6">
                <div class="username font-medium">Hello, <span class="font-bold"><?php echo $_SESSION['username'] ?></span></div>
                <form action="Logout.php" method="POST">
                    <button
                        class="bg-white/20 hover:bg-white/30 transition-colors px-4 py-1.5 rounded-md text-sm font-semibold border border-white/30">
                     <a href="Logout.php">  Log Out</a>
                    </button>
                </form>
            </div>
        </div>

       <div class="main max-w-5xl w-full mx-auto p-8">

   
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">
            Edit Profile
        </h1>

        <p class="text-slate-500 mt-1">
            Update your personal information
        </p>
    </div>

  
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

      
        <div class="bg-slate-50 border-b border-slate-200 p-6 flex items-center gap-6">

         
            <div class="relative">

                <img
                    src="<?php echo $_SESSION['profile_img'] ?>"
                    alt="Profile"
                    class="w-24 h-24 rounded-full object-cover border-4 border-blue-500">

            </div>

         
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    <?php echo $_SESSION['username'] ?>
                </h2>

                <p class="text-slate-500">
                    <?php echo $_SESSION['role'] ?>
                </p>
            </div>

        </div>

        <form action="" method="POST" enctype="multipart/form-data">

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

              
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-600">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="<?php echo $_SESSION['username'] ?>"
                        class="border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

               
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-600">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?php echo $_SESSION['email'] ?>"
                        class="border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

            
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-600">
                        Mobile Number
                    </label>

                    <input
                        type="text"
                        name="mobile"
                        value="<?php echo $_SESSION['mobile'] ?>"
                        class="border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-semibold text-slate-600">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter new password"
                        class="border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

             
                <div class="md:col-span-2 flex flex-col gap-2">

                    <label class="text-sm font-semibold text-slate-600">
                        Profile Image
                    </label>

                    <input
                        type="file"
                        name="photo"
                        class="border border-slate-300 rounded-xl px-4 py-3 bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-500 file:text-white file:rounded-lg hover:file:bg-blue-600">
                </div>

            </div>

          
            <div class="bg-slate-50 border-t border-slate-200 px-8 py-5 flex justify-end gap-4">

                <button
                    type="reset"
                    class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 transition">
                   <a href="Details.php"> Cancel</a>
                </button>

                <button
                    type="submit"
                    name="update"
                    class="px-6 py-2.5 rounded-xl bg-blue-500 hover:bg-blue-600 text-white font-semibold shadow-md transition">
                    
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

    
</body>
</html>