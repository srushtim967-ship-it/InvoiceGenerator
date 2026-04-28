<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $product = htmlspecialchars($_POST['product']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $total = $price * $quantity;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice - <?php echo $name; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="invoice-box">
    <div class="invoice-header">
        <div>
            <h1>INVOICE</h1>
            <p>Date: <?php echo date("d/m/Y"); ?></p>
        </div>
        <div style="text-align: right;">
            
            Location India
        </div>
    </div>

    <div class="invoice-details">
        <p><strong>Billed To:</strong></p>
        <p><?php echo $name; ?></p>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $product; ?></td>
                <td>₹<?php echo number_format($price, 2); ?></td>
                <td><?php echo $quantity; ?></td>
                <td>₹<?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <p>Grand Total: <span>₹<?php echo number_format($total, 2); ?></span></p>
    </div>
    
    <div style="margin-top: 40px; display: flex; gap: 10px;">
        <button onclick="window.print()" class="btn-generate btn-print" style="width: auto; padding: 10px 20px;">Print Invoice</button>
        <a href="index.html" class="btn-generate btn-print" style="width: auto; padding: 10px 20px; background: #64748b; text-decoration: none; text-align: center;">Go Back</a>
    </div>
</div>

</body>
</html>

<?php
}
?>