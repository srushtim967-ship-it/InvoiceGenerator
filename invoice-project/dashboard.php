
<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header("Location: login.php"); exit; }

// DB Connection
$conn = new mysqli("localhost", "root", "", "invoice_system");

// Fetch Stats
$stats = $conn->query("SELECT COUNT(*) as total_inv, SUM(total_amount) as total_rev FROM invoices")->fetch_assoc();
$recent = $conn->query("SELECT * FROM invoices ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Smart Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Plus_Jakarta_Sans']">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white h-screen border-r border-slate-200 p-6 flex flex-col">
            <h1 class="text-xl font-bold text-indigo-600 mb-10">Smart Invoice</h1>
            <nav class="space-y-2 flex-1">
                <a href="dashboard.php" class="block p-3 bg-indigo-50 text-indigo-600 rounded-xl font-semibold">Dashboard</a>
                <a href="index.php" class="block p-3 text-slate-500 hover:bg-slate-50 rounded-xl transition">Create Invoice</a>
                <a href="logout.php" class="block p-3 text-red-500 hover:bg-red-50 rounded-xl transition">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10">
            <header class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-bold text-slate-800">Business Overview</h2>
                <div class="text-slate-500">Welcome, <?php echo $_SESSION['user']; ?></div>
            </header>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-slate-400 font-bold uppercase text-xs tracking-wider mb-2">Total Revenue</p>
                    <h3 class="text-4xl font-extrabold text-slate-800">₹<?php echo number_format($stats['total_rev'] ?? 0, 2); ?></h3>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-slate-400 font-bold uppercase text-xs tracking-wider mb-2">Invoices Generated</p>
                    <h3 class="text-4xl font-extrabold text-slate-800"><?php echo $stats['total_inv']; ?></h3>
                </div>
            </div>

            <!-- Recent Invoices Table -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg">Recent Invoices</h3>
                    <a href="index.php" class="text-indigo-600 font-bold text-sm">+ New Invoice</a>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 text-slate-400 text-xs uppercase font-bold">
                        <tr>
                            <th class="p-6">Invoice No</th>
                            <th class="p-6">Customer</th>
                            <th class="p-6">Date</th>
                            <th class="p-6 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-600">
                        <?php while($row = $recent->fetch_assoc()): ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-6 font-semibold text-slate-800"><?php echo $row['invoice_no']; ?></td>
                            <td class="p-6"><?php echo $row['customer_name']; ?></td>
                            <td class="p-6 text-sm"><?php echo date("M d, Y", strtotime($row['created_at'])); ?></td>
                            <td class="p-6 text-right font-bold text-indigo-600">₹<?php echo number_format($row['total_amount'], 2); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>