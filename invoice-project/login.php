<?php
session_start();
if (isset($_POST['login'])) {
    // Hardcoded for project; replace with DB query if needed
    if ($_POST['username'] === "admin" && $_POST['password'] === "12345") {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = "Admin User";
        header("Location: dashboard.php");
        exit;
    } else { $error = "Invalid username or password"; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Smart Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-indigo-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white/80 backdrop-blur-lg p-10 rounded-3xl shadow-2xl border border-white/20">
        <div class="text-center mb-10">
            <div class="bg-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Welcome Back</h2>
            <p class="text-slate-500">Sign in to manage your invoices</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm font-medium border border-red-100 italic">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Username</label>
                <input type="text" name="username" required class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Password</label>
                <input type="password" name="password" required class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>
            <button type="submit" name="login" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition transform hover:-translate-y-0.5">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>