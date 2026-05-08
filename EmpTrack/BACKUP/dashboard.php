<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "Dashboard reached";
  
require_once __DIR__ . '/../Module/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$query = "SELECT A.full_name , A.emp_id, B.punch_in, B.punch_out FROM emp_table as A LEFT JOIN attendance AS B ON A.id = B.employee_id WHERE A.id = '$user_id' OR B.attendance_date = CURRENT_DATE()";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    print_r($row);
    // die();
    $punchIn = $row["punch_in"];
    $punchOut = $row["punch_out"];
    $dynamicName = $row['full_name'];
    $dynamicEmpID = $row['emp_id'];
}

date_default_timezone_set('Asia/Kolkata');


if (isset($_POST['punchIn'])) {

    $time = date('H:i:s');

 

    $query = "INSERT INTO attendance 
    (employee_id, punch_in, attendance_date)
    VALUES ('$user_id', '$time', CURRENT_DATE())";

    mysqli_query($conn, $query);

    echo "Punch In Success: " . $time;
}

if (isset($_POST['punchOut'])) {

    $time = date('H:i:s');

    $query = "UPDATE attendance 
    SET punch_out = '$time'
    WHERE employee_id = '$user_id'
    AND attendance_date = CURRENT_DATE()";

    mysqli_query($conn, $query);

    echo "Punch Out Success: " . $time;
} else {
    header("Location: dashboard.php" . "?success=1");
    exit;
}

if (!isset($_POST['punchOut'])) {
    echo "Punch Out time saved: " . date('H:i:s');
    $punchOut = date('H:i:s');

    // header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
    // exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://googleapis.com" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Dashboard</title>
</head>

<body class="bg-gray-50 font-['Inter'] text-slate-800">
    <div class="main-dashboard min-h-screen flex flex-col">
        <!-- Navbar -->
        <div class="navbar flex items-center justify-between bg-[#007bff] px-8 py-4 shadow-lg text-white">
            <div class="nav-start px-4 py-1.5 rounded-lg text-[#007bff] font-bold text-xl bg-white shadow-sm">
                Dashboard
            </div>
            <div class="nav-end flex items-center gap-6">
                <div class="username font-medium">Hello, <span class="font-bold"><?php echo $dynamicName ?></span></div>
                <button
                    class="bg-white/20 hover:bg-white/30 transition-colors px-4 py-1.5 rounded-md text-sm font-semibold border border-white/30">
                    Logout
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="hero-main max-w-5xl w-full mx-auto p-8">
            <div class="greetings mb-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Welcome back,
                    <?php echo $dynamicName ?>!</h2>
                <p class="text-slate-500 mt-1">Here is your attendance overview for today.</p>
            </div>

            <div class="detail bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <!-- Card Header -->
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h6 class="text-xs font-bold uppercase tracking-wider text-[#007bff]">Personal Information</h6>
                    <h4 class="text-xl font-bold text-slate-800"><?php echo $dynamicName ?></h4>
                </div>

                <!-- Stats Grid -->
                <div class="empData p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-sm text-slate-500">Employee ID</span>
                            <span class="font-semibold text-lg"><?php echo $dynamicEmpID ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-slate-500">Attendance Status</span>
                            <span
                                class="inline-flex w-fit px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Present</span>
                        </div>
                    </div>

                    <div class="space-y-4 border-l border-slate-100 pl-0 md:pl-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Punch-in Time</span>
                            <span class="font-mono font-medium text-slate-700"><?php echo $punchIn; ?></span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                            <span class="text-sm text-slate-500">Punch-out Time</span>
                            <span class="font-mono font-medium text-slate-700">09:30:04 AM</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                            <span class="text-sm text-slate-500">Total Working Hour</span>
                            <span class="font-mono font-medium text-slate-700">8 Hour</span>
                        </div>
                    </div>
                </div>

                <!-- Card p-in-out -->
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h6 class="text-xs font-bold uppercase tracking-wider text-[#007bff]">Attendance System</h6>
                    <h6 class="text-md font-semibold py-3 text-slate-700">You can Punch in or Punch Out here</h6>

                </div>
                <!-- data card -->
                <div class="empData p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <form method="POST" action="">
                        <div class="flex justify-between">
                            <span><button type="submit" name="punchIn"
                                     class=" bg-green-400 text-white
                                    font-semibold rounded-[4px] p-[8%_25%] w-max">Punch In</button></span>
                            <span><button type="submit" name="punchOut"
                                    class=" bg-red-400 text-white
                                    font-semibold rounded-[4px] p-[8%_25%] w-max">Punch Out</button></span>
                                     <!-- onclick="this.disabled=true; this.form.submit(); -->
                        
                                </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="footer mt-auto py-6 text-center text-slate-400 text-sm">
                &copy; <?php echo date("Y"); ?> Dashboard Inc.
            </div>
        </div>
</body>

</html>