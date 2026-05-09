<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center font-['Plus_Jakarta_Sans']">
    <div class="text-center">
        <div class="bg-white p-10 rounded-3xl shadow-xl max-w-sm mx-auto">
            <div class="text-indigo-600 mb-4 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Signed Out</h2>
            <p class="text-slate-500 mb-6">You have been securely logged out of the system.</p>
            <a href="login.php" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                Log Back In
            </a>
        </div>
    </div>
</body>
</html>