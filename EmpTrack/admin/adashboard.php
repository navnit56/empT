<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "Dashboard reached";

require_once __DIR__ . '/../Module/connection.php';
$selectedDate = isset($_GET['date']) ? $_GET['date'] : null;

if (!isset($_SESSION['admin_id'])) {
    header("Location: aLogin.php");
    exit();
}
$admin_id = $_SESSION["admin_id"];
$query = "SELECT full_name
FROM emp_table 
WHERE id = '$admin_id'";


$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    print_r($row);
    // die();

    $_SESSION['aName'] = $row['full_name'];

    

}

$query = "SELECT e.full_name, e.email, a.id, e.password, e.mobile, e.profile_img, e.role, e.created_at, a.attendance_date, a.punch_in, e.emp_id, a.punch_out, a.working_hours, a.late_time, a.overtime_hours, a.status, a.created_at as attendance_created_at FROM attendance a JOIN emp_table e ON a.employee_id = e.id";


if($selectedDate){

    $query .= " WHERE a.attendance_date = '$selectedDate'";

} else {

    $query .= " WHERE a.attendance_date = CURRENT_DATE()";

}

$tableDynamic = mysqli_query($conn, $query);


if ($row = mysqli_fetch_assoc($tableDynamic)) {

    $_SESSION['full_name'] = $row['full_name'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['mobile'] = $row['mobile'];
    $_SESSION['profile_img'] = $row['profile_img'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['created_at'] = $row['created_at'];

    $_SESSION['attendance_date'] = $row['attendance_date'];
    $_SESSION['punch_in'] = $row['punch_in'];
    $_SESSION['emp_id'] = $row['emp_id'];
    $_SESSION['punch_out'] = $row['punch_out'];
    $_SESSION['working_hours'] = $row['working_hours'];
    $_SESSION['late_time'] = $row['late_time'];
    $_SESSION['overtime_hours'] = $row['overtime_hours'];
    $_SESSION['status'] = $row['status'];
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['attendance_created_at'] = $row['attendance_created_at'];
}


if(isset($_POST['delete_btn'])){
    $queryDelete = "DELETE FROM attendance WHERE id = '$_SESSION[user_id]' AND attendance_date = '$_SESSION[attendance_date]'";
    if (mysqli_query($conn, $queryDelete)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="main">
        <div class="navbar flex items-center justify-between bg-[#007bff] px-8 py-4 shadow-lg text-white">
            <div class="nav-start px-4 py-1.5 rounded-lg text-[#007bff] font-bold text-xl bg-white shadow-sm">
                Admin Dashboard
            </div>
            <div class="nav-end flex items-center gap-6">
                <div class="username font-medium">Hello, <span class="font-bold"><?php echo $_SESSION['aName'] ?></span></div>
                <form action="aLogout.php" method="POST">
                    <button
                        class="bg-white/20 hover:bg-white/30 transition-colors px-4 py-1.5 rounded-md text-sm font-semibold border border-white/30">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
        <div class="main hero-main max-w-5xl w-full mx-auto p-8">
            <div class="greetings mb-8">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Welcome back,
                    <?php echo $_SESSION['aName'] ?>!
                </h2>
                <p class="text-slate-500 mt-1">Here is Employee attendance overview for today.</p>
            </div>
            <form action="employee_details.php" method="GET">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold">
                    See Employee Details
                </button>
            </form>
        </div>

        <div class="attendanceRec bg-white rounded-3xl shadow-sm border border-slate-200 p-8 mt-8">

           
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-3xl font-extrabold text-slate-800">
                        Attendance Records
                    </h2>

                    <p class="text-slate-500 mt-1 text-sm">
                        Manage and monitor employee attendance activity.
                    </p>
                </div>

                <div class="filter background-white rounded-lg shadow-sm border border-slate-200 px-4 py-2 flex items-center gap-3 bg-[#007bff] text-white font-medium">
                    <form action="" method="GET">
                        <label for="start">Select date:</label>
                        <input type="date" name="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>"
           onchange="this.form.submit()"  class="border border-slate-300 rounded-md px-3 py-1 bg-white text-sm text-slate-800 font-medium">
                    </form>
                </div>

                

            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-100">

                <table class="min-w-full text-sm text-left">

                   
                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">

                        <tr>

                            <th class="py-4 px-6 font-bold">
                                Employee
                            </th>

                            <th class="py-4 px-6 font-bold">
                                Date
                            </th>

                            <th class="py-4 px-6 font-bold">
                                Punch In
                            </th>

                            <th class="py-4 px-6 font-bold">
                                Punch Out
                            </th>

                            <th class="py-4 px-6 font-bold">
                                Status
                            </th>

                            <th class="py-4 px-6 text-center font-bold">
                                Actions
                            </th>

                        </tr>

                    </thead>

                   
                    <tbody class="divide-y divide-slate-100">

                   <?php while ($user = mysqli_fetch_assoc($tableDynamic)): ?>
                        <tr class="hover:bg-slate-50 transition-all duration-200">

                            <td class="py-5 px-6">

                                <div>
                                    <h4 class="font-semibold text-slate-800">
                                     <?php echo  $user['full_name'] ?>
                                    </h4>

                                    <p class="text-xs text-slate-400 mt-1">
                                       <?php echo  $user['emp_id'] ?>
                                    </p>
                                </div>

                            </td>

                            <td class="py-5 px-6 text-slate-600">
                                <?php echo  $user['attendance_date'] ?>
                            </td>

                            <td class="py-5 px-6 font-medium text-slate-700">
                                <?php echo  $user['punch_in'] ?>
                            </td>

                            <td class="py-5 px-6 font-medium text-slate-700">
                                <?php echo  $user['punch_out'] ?>
                            </td>

                            <td class="py-5 px-6">
                                <?php echo  $user['status'] == 'Present' ? '<span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">' . $user['status'] . '</span>' : '<span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">Absent</span>' ?>
                            </td>

                            <td class="py-5 px-6">

                                <div class="flex justify-center gap-3">

                        
                                <form action="" method="POST">
                                    <button  name="delete_btn" type="submit" class="bg-red-500 hover:bg-red-600 transition-all text-white px-4 py-2 rounded-lg text-xs font-semibold">
                                        Delete
                                    </button>
                                </form>
                                </div>

                            </td>

                        </tr>

                    <?php endwhile; ?>
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</body>

</html>