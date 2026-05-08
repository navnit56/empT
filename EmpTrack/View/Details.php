<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once __DIR__ . '/../Module/connection.php';

// $query = "SELECT * FROM emp_table WHERE id = " . $_SESSION['user_id'];
// $query = "SELECT 
//     A.full_name,
//     A.emp_id,
//     A.email,
//     A.mobile,
//     A.role,
//     A.status,
//     A.created_at,
//     A.photo,
//     b.status
// FROM emp_table AS A
// LEFT JOIN attendance AS b ON A.id = b.emp_id
// WHERE A.id = " . $_SESSION['user_id'];

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// $result = mysqli_query($conn, $query);
// $employee = mysqli_fetch_assoc($result);

// $dynamicName = $employee['full_name'];
// $dynamicEmpID = $employee['emp_id'];
// $dynamicEmail = $employee['email'];
// $dynamicMobile = $employee['mobile'];
// $dynamicRole = $employee['role'];
// $dynamicStatus = $employee['status'];   
// $dynamicCreatedAt = date("F j, Y", strtotime($employee['created_at'])); 
// $dynamicPhoto = $employee['photo']; 
$user_id = $_SESSION['user_id'];

$query = "SELECT A.full_name, A.emp_id, A.email, A.mobile, A.role, A.status, A.created_at, A.profile_img, b.status 
          FROM emp_table AS A 
          LEFT JOIN attendance AS b ON A.id = b.employee_id 
          WHERE A.id = '$user_id'";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $employee = mysqli_fetch_assoc($result);


    $_SESSION['username'] = $employee['full_name'];
    $_SESSION['emp_id'] = $employee['emp_id'];
    $_SESSION['email'] = $employee['email'];
    $_SESSION['mobile'] = $employee['mobile'];
    $_SESSION['role'] = $employee['role'];
    $_SESSION['status'] = $employee['status'];
    $_SESSION['profile_img'] = $employee['profile_img'];
    $_SESSION['created_at'] = date("F j, Y", strtotime($employee['created_at']));
   $_SESSION['Status'] = $employee['status'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <title>Personal Details</title>
</head>

<body class="bg-slate-100 min-h-screen">

    <div class="navbar flex items-center justify-between bg-[#007bff] px-8 py-4 shadow-lg text-white">

        <div class="nav-start px-4 py-1.5 rounded-lg text-[#007bff] font-bold text-xl bg-white shadow-sm">
            User Details
        </div>

        <div class="nav-end flex items-center gap-6">

            <div class="username font-medium">
                Hello,
                <span class="font-bold">
                    <?php echo $_SESSION['username'] ?>
                </span>
            </div>

            <form action="Logout.php" method="POST">
                <button
                    class="bg-white/20 hover:bg-white/30 transition-colors px-4 py-1.5 rounded-md text-sm font-semibold border border-white/30">
                    Log Out
                </button>
            </form>

        </div>
    </div>

   
    <div class="main flex justify-center mt-10 px-4">

      
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-lg overflow-hidden border border-slate-200">

         
            <div class="flex items-center justify-between p-6 border-b border-slate-200 bg-slate-50">

                <div class="flex items-center gap-5">

                   
                    <img
                        src="<?php echo $_SESSION['profile_img'] ?>"
                        alt="Profile Photo"
                        class="w-20 h-20 rounded-full object-cover border-4 border-blue-500">

             
                    <div>

                        <h6 class="text-xs font-bold uppercase tracking-wider text-[#007bff]">
                          Profile Information
                        </h6>

                        <h4 class="text-2xl font-bold text-slate-800">
                            <?php echo $_SESSION['username'] ?>
                        </h4>

                        <p class="text-sm text-slate-500">
                            <?php echo $_SESSION['role'] ?>
                        </p>

                    </div>

                </div>

                <form action="edit.php">
                <button
                    class="bg-blue-500 hover:bg-blue-600 transition text-white px-5 py-2 rounded-lg text-sm font-semibold shadow">
                    Edit Profile
                </button>
                </form>

            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

            
                <div class="space-y-5">

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500">Employee ID</span>

                        <span class="font-semibold text-lg text-slate-800">
                            <?php echo $_SESSION['emp_id'] ?>
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500">Mobile Number</span>

                        <span class="font-semibold text-slate-800">
                            <?php echo $_SESSION['mobile'] ?>
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500">Email Address</span>

                        <span class="font-semibold text-slate-800 break-all">
                            <?php echo $_SESSION['email'] ?>
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500">Password</span>

                        <span class="font-semibold text-slate-800">
                            ********
                        </span>
                    </div>

                </div>

             
                <div class="space-y-5">

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500">Role</span>

                        <span class="font-semibold text-slate-800">
                            <?php echo $_SESSION['role'] ?>
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500 mb-2">Status</span>

                        <span class="inline-flex w-fit px-3 py-1 rounded-full text-xs font-bold
                            <?= $_SESSION['Status'] == 'Present'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' ?>">

                            <?php echo $_SESSION['Status'] ?>

                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-500">Joined On</span>

                        <span class="font-semibold text-slate-800">
                            <?php echo $_SESSION['created_at'] ?>
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>