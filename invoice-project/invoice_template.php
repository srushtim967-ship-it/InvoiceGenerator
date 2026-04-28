<?php
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM invoices WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="invoice-box">
    <h2>Invoice</h2>

    <div class="invoice-details">
        <p><b>Customer:</b> <?= $row['customer_name'] ?></p>
        <p><b>Product:</b> <?= $row['product'] ?></p>
        <p><b>Price:</b> ₹<?= $row['price'] ?></p>
        <p><b>Quantity:</b> <?= $row['quantity'] ?></p>
    </div>

    <div class="total">
        Total: ₹<?= $row['total'] ?>
    </div>
</div>

</body>
</html>