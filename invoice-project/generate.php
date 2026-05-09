
<?php
session_start();
if (!isset($_SESSION['loggedin'])) { header("Location: login.php"); exit; }

// DB Connection - Matching your image database name: invoice_system
$conn = new mysqli("localhost", "root", "", "invoice_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $invoice_no = htmlspecialchars($_POST['invoice_no']);
    $products = $_POST['product'];
    $prices = $_POST['price'];
    $quantities = $_POST['quantity'];

    // Calculate Totals
    $subtotal = 0;
    for ($i = 0; $i < count($products); $i++) {
        $subtotal += ($prices[$i] * $quantities[$i]);
    }
    $gst = $subtotal * 0.18;
    $grand_total = $subtotal + $gst;

    // 1. Save to Invoices Table
    $sql = "INSERT INTO invoices (invoice_no, customer_name, subtotal, gst, total_amount) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssddd", $invoice_no, $name, $subtotal, $gst, $grand_total);
    $stmt->execute();
    
    // Capture the 'id' from the invoices table to use as 'invoice_id' in invoice_items
    $last_invoice_id = $stmt->insert_id;
    $stmt->close();

    // 2. Save Items to invoice_items Table
    $stmt_item = $conn->prepare("INSERT INTO invoice_items (invoice_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
    
    for ($i = 0; $i < count($products); $i++) {
        $p_name = htmlspecialchars($products[$i]);
        $p_price = $prices[$i];
        $p_qty = $quantities[$i];
        
        $stmt_item->bind_param("isdi", $last_invoice_id, $p_name, $p_price, $p_qty);
        $stmt_item->execute();
    }
    $stmt_item->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview Invoice | <?php echo $invoice_no; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 p-6 font-['Plus_Jakarta_Sans']">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <a href="index.php" class="text-indigo-600 font-bold flex items-center gap-2">← Edit Details</a>
            
            <div class="flex gap-3">
                <button onclick="window.print()" class="px-6 py-2 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Print Preview</button>
                
                <form action="download.php" method="POST">
                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                    <input type="hidden" name="invoice_no" value="<?php echo $invoice_no; ?>">
                    <?php foreach($products as $p) echo '<input type="hidden" name="product[]" value="'.htmlspecialchars($p).'">'; ?>
                    <?php foreach($prices as $p) echo '<input type="hidden" name="price[]" value="'.$p.'">'; ?>
                    <?php foreach($quantities as $q) echo '<input type="hidden" name="quantity[]" value="'.$q.'">'; ?>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition">Download PDF</button>
                </form>
            </div>
        </div>

        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-6 text-sm flex items-center gap-3 border border-emerald-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
            Invoice successfully saved to database!
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 p-10">
            <div class="flex justify-between border-b pb-8 mb-8">
                <div>
                    <h2 class="text-4xl font-extrabold text-slate-800 tracking-tight">INVOICE</h2>
                    <p class="text-slate-400 mt-1">#<?php echo $invoice_no; ?></p>
                </div>
                <div class="text-right">
                    <h3 class="text-slate-400 uppercase text-xs font-bold tracking-widest mb-1">Billing To</h3>
                    <p class="text-xl font-bold text-slate-800"><?php echo $name; ?></p>
                    <p class="text-slate-500"><?php echo date("F j, Y"); ?></p>
                </div>
            </div>

            <table class="w-full text-left mb-10">
                <thead>
                    <tr class="text-slate-400 text-xs uppercase tracking-wider">
                        <th class="pb-4 font-bold">Item Description</th>
                        <th class="pb-4 font-bold text-center">Qty</th>
                        <th class="pb-4 font-bold text-right">Price</th>
                        <th class="pb-4 font-bold text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    <?php for ($i = 0; $i < count($products); $i++): ?>
                    <tr class="border-b border-slate-50">
                        <td class="py-4 font-semibold"><?php echo htmlspecialchars($products[$i]); ?></td>
                        <td class="py-4 text-center"><?php echo $quantities[$i]; ?></td>
                        <td class="py-4 text-right">₹<?php echo number_format($prices[$i], 2); ?></td>
                        <td class="py-4 text-right font-bold text-slate-800">₹<?php echo number_format($prices[$i]*$quantities[$i], 2); ?></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-64 space-y-3">
                    <div class="flex justify-between text-slate-500"><span>Subtotal</span><span>₹<?php echo number_format($subtotal, 2); ?></span></div>
                    <div class="flex justify-between text-slate-500"><span>GST (18%)</span><span>₹<?php echo number_format($gst, 2); ?></span></div>
                    <div class="flex justify-between text-2xl font-bold text-indigo-600 pt-3 border-t"><span>Total</span><span>₹<?php echo number_format($grand_total, 2); ?></span></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>