<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Generator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="form-header">
        <h2>Invoice Generator</h2>
        <!--<p>Enter details below to create a professional invoice.</p>-->
    </div>

    <form action="generate.php" method="POST">
        <div class="input-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="e.g. Rahul Sharma" required>
        </div>

        <div class="input-group">
            <label>Product Name</label>
            <input type="text" name="product" placeholder="e.g.Book" required>
        </div>

        <div class="row">
            <div class="input-group">
                <label>Price (₹)</label>
                <input type="number" name="price" placeholder="0.00"  required>
            </div>
            <div class="input-group">
                <label>Quantity</label>
                <input type="number" name="quantity" placeholder="1" required>
            </div>
        </div>

        <button type="submit" class="btn-generate">Generate Invoice</button>
    </form>
</div>

</body>
</html>