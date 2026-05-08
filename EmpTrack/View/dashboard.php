<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "Dashboard reached";

require_once __DIR__ . '/../Module/connection.php';

$duration = "--:--:--";
$isLate = false;
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$query = "SELECT 
    A.full_name,
    A.emp_id,
    B.punch_in,
    B.punch_out
FROM emp_table AS A
LEFT JOIN attendance AS B
ON A.id = B.employee_id
AND B.attendance_date = CURRENT_DATE()
WHERE A.id = '$user_id'";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    print_r($row);
    // die();
    $punchIn = $row["punch_in"];
    $punchOut = $row["punch_out"];
    $dynamicName = $row['full_name'];
    $dynamicEmpID = $row['emp_id'];
}

$timex = $punchIn;
$timey = $punchOut;

date_default_timezone_set('Asia/Kolkata');


if (isset($_POST['punchIn'])) {

    $timeIn = date('H:i:s');



    $query = "INSERT INTO attendance 
    (employee_id, punch_in, attendance_date ,status)
    VALUES ('$user_id', '$timeIn', CURRENT_DATE(), 'present')";

    mysqli_query($conn, $query);

    echo "Punch In Success: " . $timeIn;

    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['punchOut'])) {

    $timeOut = date('H:i:s');

    $query = "UPDATE attendance 
    SET punch_out = '$timeOut'
    WHERE employee_id = '$user_id'
    AND attendance_date = CURRENT_DATE()
     AND punch_out IS NULL";

    mysqli_query($conn, $query);

    echo "Punch Out Success: " . $timeOut;

   

    header("Location: dashboard.php");
    exit();
}
$diffInSeconds = strtotime($timey) - strtotime($timex);



$hours = floor($diffInSeconds / 3600);
$minutes = floor(($diffInSeconds % 3600) / 60);
if(!empty($punchIn) && !empty($punchOut)){
$duration = "$hours hours and $minutes minutes";
}

if(strtotime($timex) > strtotime('09:30:00')){
    $isLate = true;
    $seconds = abs(strtotime($timex) - strtotime('09:30:00'));
    $late_time = gmdate('H:i:s', $seconds);
}
$eightHoursInSeconds = 8 * 3600;

if(($diffInSeconds - $eightHoursInSeconds) > 0){
  
    $overtime_seconds = $diffInSeconds - $eightHoursInSeconds;
    $overtime_hours = floor($overtime_seconds / 3600);
    
$query = "UPDATE attendance 
    SET overtime_hours = '$overtime_hours'
    WHERE employee_id = '$user_id'";

    mysqli_query($conn, $query);
    
}

if($isLate){

    $query = "UPDATE attendance 
    SET working_hours = '$duration', status = 'Late',
    late_time = '$late_time'
    WHERE employee_id = '$user_id'";

    mysqli_query($conn, $query);

}

if(!$punchIn){

    $query = "UPDATE attendance 
    SET working_hours = '$duration', status = 'Absent'
    WHERE employee_id = '$user_id'";

    mysqli_query($conn, $query);

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
                  <img
                        src="<?php echo $_SESSION['profile_img'] ?>"
                        alt="Profile Photo"
                        class="w-20 h-20 rounded-full object-cover border-4 border-blue-500">
                <form action="Logout.php" method="POST">
                    <button
                        class="bg-white/20 hover:bg-white/30 transition-colors px-4 py-1.5 rounded-md text-sm font-semibold border border-white/30">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="hero-main max-w-5xl w-full mx-auto p-8">
            <div class="greetings mb-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Welcome back,
                    <?php echo $dynamicName ?>!
                </h2>
                <p class="text-slate-500 mt-1">Here is your attendance overview for today.</p>
            </div>

            <div class="detail bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <!-- Card Header -->
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between">
                    <div class="name">
                    <h6 class="text-xs font-bold uppercase tracking-wider text-[#007bff]">Personal Information</h6>
                    <h4 class="text-xl font-bold text-slate-800"><?php echo $dynamicName ?></h4>
                    </div>
                    <form action="Details.php" method="GET">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold">
                            View Details
                        </button>
                    </form>
                </div>

                <!-- Stats Grid -->
                <div class="empData p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-sm text-slate-500">Employee ID</span>
                            <span class="font-semibold text-lg"><?php echo $dynamicEmpID ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="inline-flex w-fit px-3 py-1 rounded-full text-xs font-bold 
                                <?= !empty($punchIn) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                <?= !empty($punchIn) ? 'Present' : 'Absent' ?>
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4 border-l border-slate-100 pl-0 md:pl-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Punch-in Time</span>
                            <span class="font-mono font-medium text-slate-700"><?php echo $punchIn; ?></span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                            <span class="text-sm text-slate-500">Punch-out Time</span>
                            <span class="font-mono font-medium text-slate-700"><?php echo $punchOut; ?></span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-50 pt-4">
                            <span class="text-sm text-slate-500">Total Working Hour</span>
                            <span class="font-mono font-medium text-slate-700"><?php echo $duration; ?></span>
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
                                <span><button type="submit" name="punchIn" class=" bg-green-400 text-white
                                    font-semibold rounded-[4px] p-[8%_25%] w-max">Punch In</button></span>
                                <span><button type="submit" name="punchOut" class=" bg-red-400 text-white
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