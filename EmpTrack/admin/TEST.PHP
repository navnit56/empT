<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-100 font-sans text-slate-800">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-72 bg-[#007bff] text-white flex flex-col shadow-2xl">

            <div class="p-6 border-b border-white/20">
                <h1 class="text-3xl font-extrabold tracking-wide">Admin Panel</h1>
                <p class="text-sm text-white/70 mt-1">Attendance Management</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-3">

                <a href="#" class="block bg-white text-[#007bff] font-semibold px-4 py-3 rounded-xl shadow">
                    Dashboard
                </a>

                <a href="#" class="block hover:bg-white/10 transition-all px-4 py-3 rounded-xl font-medium">
                    View Employees
                </a>

                <a href="#" class="block hover:bg-white/10 transition-all px-4 py-3 rounded-xl font-medium">
                    Daily Attendance
                </a>

                <a href="#" class="block hover:bg-white/10 transition-all px-4 py-3 rounded-xl font-medium">
                    Search Records
                </a>

                <a href="#" class="block hover:bg-white/10 transition-all px-4 py-3 rounded-xl font-medium">
                    Reports
                </a>

            </nav>

            <div class="p-4 border-t border-white/20">
                <button class="w-full bg-white/20 hover:bg-white/30 transition-all py-3 rounded-xl font-semibold">
                    Logout
                </button>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">

            <!-- Top Navbar -->
            <div class="flex justify-between items-center mb-8">

                <div>
                    <h2 class="text-4xl font-extrabold text-slate-900">
                        Welcome Admin 👋
                    </h2>
                    <p class="text-slate-500 mt-1">
                        Manage employee attendance records efficiently.
                    </p>
                </div>

                <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-200">
                    <p class="text-sm text-slate-500">Today</p>
                    <h4 class="font-bold text-lg">08 May 2026</h4>
                </div>

            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <p class="text-slate-500 text-sm">Total Employees</p>
                    <h3 class="text-4xl font-extrabold mt-2">120</h3>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <p class="text-slate-500 text-sm">Present Today</p>
                    <h3 class="text-4xl font-extrabold mt-2 text-green-500">98</h3>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <p class="text-slate-500 text-sm">Absent Today</p>
                    <h3 class="text-4xl font-extrabold mt-2 text-red-500">22</h3>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <p class="text-slate-500 text-sm">Late Punch-ins</p>
                    <h3 class="text-4xl font-extrabold mt-2 text-yellow-500">7</h3>
                </div>

            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">

                <div class="flex flex-col lg:flex-row gap-4">

                    <input type="text" placeholder="Search by Employee Name..."
                        class="flex-1 border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-[#007bff]" />

                    <input type="date"
                        class="border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-[#007bff]" />

                    <button
                        class="bg-[#007bff] hover:bg-blue-700 transition-all text-white font-semibold px-6 py-3 rounded-xl">
                        Search
                    </button>

                </div>

            </div>

            <!-- Attendance Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <!-- Table Header -->
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">

                    <div>
                        <h3 class="text-2xl font-bold">Attendance Records</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Manage employee attendance details.
                        </p>
                    </div>

                    <button
                        class="bg-[#007bff] hover:bg-blue-700 transition-all text-white px-5 py-2 rounded-xl font-semibold">
                        Export Report
                    </button>

                </div>

                <!-- Table -->
                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-slate-100 text-slate-600 text-sm uppercase">

                            <tr>
                                <th class="px-6 py-4">Employee</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Punch In</th>
                                <th class="px-6 py-4">Punch Out</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            <tr class="hover:bg-slate-50 transition-all">

                                <td class="px-6 py-5">
                                    <div>
                                        <h4 class="font-semibold">Navnit Kaklotar</h4>
                                        <p class="text-sm text-slate-500">EMP001</p>
                                    </div>
                                </td>

                                <td class="px-6 py-5">08 May 2026</td>

                                <td class="px-6 py-5 font-medium">
                                    09:15 AM
                                </td>

                                <td class="px-6 py-5 font-medium">
                                    06:20 PM
                                </td>

                                <td class="px-6 py-5">
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                                        Present
                                    </span>
                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex justify-center gap-3">

                                        <button
                                            class="bg-yellow-400 hover:bg-yellow-500 transition-all text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                            Edit
                                        </button>

                                        <button
                                            class="bg-red-500 hover:bg-red-600 transition-all text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                            Delete
                                        </button>

                                    </div>

                                </td>

                            </tr>

                            <tr class="hover:bg-slate-50 transition-all">

                                <td class="px-6 py-5">
                                    <div>
                                        <h4 class="font-semibold">Raj Patel</h4>
                                        <p class="text-sm text-slate-500">EMP002</p>
                                    </div>
                                </td>

                                <td class="px-6 py-5">08 May 2026</td>

                                <td class="px-6 py-5 font-medium">
                                    10:05 AM
                                </td>

                                <td class="px-6 py-5 font-medium">
                                    --
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full">
                                        Working
                                    </span>
                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex justify-center gap-3">

                                        <button
                                            class="bg-yellow-400 hover:bg-yellow-500 transition-all text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                            Edit
                                        </button>

                                        <button
                                            class="bg-red-500 hover:bg-red-600 transition-all text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                            Delete
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

</body>

</html>