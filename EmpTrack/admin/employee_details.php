<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../Module/connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: aLogin.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Employee Details</title>
</head>

<body>
    <div class="main">
        <div class="navbar flex items-center justify-between bg-[#007bff] px-8 py-4 shadow-lg text-white">
            <div class="nav-start px-4 py-1.5 rounded-lg text-[#007bff] font-bold text-xl bg-white shadow-sm">
                Admin Dashboard
            </div>
            <div class="nav-end flex items-center gap-6">
                <div class="username font-medium">Hello, <span class="font-bold"><?php echo $_SESSION['aName'] ?></span>
                </div>
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
                <p class="text-slate-500 mt-1">Here is Employee Details.</p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100 w-fit px-4 mx-auto">

             <table class="min-w-full text-sm text-left">

            <table class="min-w-full text-sm text-left">


                <thead class="bg-slate-100 text-slate-600 uppercase text-xs tracking-wider">

                    <tr>

                        <th class="py-4 px-6 font-bold">
                            Name
                        </th>

                        <th class="py-4 px-6 font-bold">
                            Employee ID
                        </th>

                        <th class="py-4 px-6 font-bold">
                            Email
                        </th>

                        

                        <th class="py-4 px-6 font-bold">
                            Mobile
                        </th>

                        <th class="py-4 px-6 font-bold">
                            Profile Image
                        </th>

                        <th class="py-4 px-6 text-center font-bold">
                            Created at
                        </th>

                    </tr>

                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM emp_table";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='py-4 px-6'>" . $row['full_name'] . "</td>";
                            echo "<td class='py-4 px-6'>" . $row['emp_id'] . "</td>";
                            echo "<td class='py-4 px-6'>" . $row['email'] . "</td>";
                            
                            echo "<td class='py-4 px-6'>" . $row['mobile'] . "</td>";
                            echo "<td class='py-4 px-6'><img src='" . $row['profile_img'] . "' alt='Profile Image' class='w-16 h-16 rounded-full object-cover'></td>";
                            echo "<td class='py-4 px-6 text-center'>" . date('Y-m-d H:i:s', strtotime($row['created_at'])) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='py-4 px-6 text-center'>No employees found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

</body>

</html>