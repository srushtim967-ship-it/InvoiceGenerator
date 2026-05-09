
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Invoice System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="p-6 md:p-12">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-700 text-slate-800">Invoice <span class="text-indigo-600">Generator</span></h1>
                <p class="text-slate-500">Create professional invoices in seconds</p>
            </div>
            <div class="text-right">
                <span class="text-sm font-semibold text-slate-400 uppercase">Current Date</span>
                <p class="font-medium"><?php echo date("F j, Y"); ?></p>
            </div>
        </div>

        <form action="generate.php" method="POST" id="invoice-form" class="space-y-6">
            <!-- Client Section -->
            <div class="glass p-8 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-semibold mb-4 text-slate-700">Client Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase">Customer Name</label>
                        <input type="text" name="name" required placeholder="John Doe" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase">Invoice #</label>
                        <input type="text" name="invoice_no" value="INV-<?php echo rand(1000, 9999); ?>" readonly 
                            class="w-full px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-500">
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="glass p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-slate-700">Line Items</h3>
                    <button type="button" onclick="addItem()" class="text-sm bg-indigo-50 text-indigo-600 px-4 py-2 rounded-lg font-bold hover:bg-indigo-100 transition">
                        + Add Item
                    </button>
                </div>

                <div id="items-container" class="space-y-4">
                    <!-- Default Row -->
                    <div class="item-row grid grid-cols-12 gap-4 items-end bg-slate-50/50 p-4 rounded-xl border border-dashed border-slate-200">
                        <div class="col-span-12 md:col-span-6 space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Description</label>
                            <input type="text" name="product[]" required placeholder="Service/Product name" class="w-full px-4 py-2 rounded-lg border border-slate-200 outline-none focus:border-indigo-500">
                        </div>
                        <div class="col-span-5 md:col-span-3 space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Price (₹)</label>
                            <input type="number" name="price[]" step="0.01" required placeholder="0.00" class="w-full px-4 py-2 rounded-lg border border-slate-200 outline-none">
                        </div>
                        <div class="col-span-4 md:col-span-2 space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Qty</label>
                            <input type="number" name="quantity[]" value="1" min="1" class="w-full px-4 py-2 rounded-lg border border-slate-200 outline-none">
                        </div>
                        <div class="col-span-3 md:col-span-1 py-2 text-center">
                            <!-- Delete button hidden for first row -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <p class="text-slate-400 text-sm italic">* All amounts are in Indian Rupees (INR)</p>
                <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transform hover:-translate-y-1 transition duration-200">
                    Generate Professional Invoice
                </button>
            </div>
        </form>
    </div>

    <script>
        function addItem() {
            const container = document.getElementById('items-container');
            const div = document.createElement('div');
            div.className = "item-row grid grid-cols-12 gap-4 items-end bg-slate-50/50 p-4 rounded-xl border border-dashed border-slate-200 animate-in fade-in duration-300";
            div.innerHTML = `
                <div class="col-span-12 md:col-span-6 space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Description</label>
                    <input type="text" name="product[]" required placeholder="Service/Product name" class="w-full px-4 py-2 rounded-lg border border-slate-200 outline-none focus:border-indigo-500">
                </div>
                <div class="col-span-5 md:col-span-3 space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Price (₹)</label>
                    <input type="number" name="price[]" step="0.01" required placeholder="0.00" class="w-full px-4 py-2 rounded-lg border border-slate-200 outline-none">
                </div>
                <div class="col-span-4 md:col-span-2 space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase">Qty</label>
                    <input type="number" name="quantity[]" value="1" min="1" class="w-full px-4 py-2 rounded-lg border border-slate-200 outline-none">
                </div>
                <div class="col-span-3 md:col-span-1 py-2 flex justify-center">
                    <button type="button" onclick="this.closest('.item-row').remove()" class="text-red-400 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>