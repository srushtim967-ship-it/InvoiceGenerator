<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Make sure you have downloaded the dompdf folder!
require_once 'dompdf/autoload.inc.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true); 
    // This allows dompdf to use the fonts it has in its folder
    $options->set('defaultFont', 'DejaVu Sans');

    $dompdf = new Dompdf($options);

    // Capture the data from your form
    $name = htmlspecialchars($_POST['name']);
    $invoice_no = htmlspecialchars($_POST['invoice_no']);
    $products = $_POST['product'];
    $prices = $_POST['price'];
    $quantities = $_POST['quantity'];

    // Professional HTML Template (Purely for the PDF)
    ob_start(); ?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /* DejaVu Sans is critical for showing the Rupee symbol correctly */
            body { 
                font-family: 'DejaVu Sans', sans-serif; 
                color: #334155; 
                margin: 0; 
                padding: 0; 
                font-size: 10pt;
            }
            .header { background: #4f46e5; color: white; padding: 40px; }
            .content { padding: 40px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th { text-align: left; color: #64748b; border-bottom: 2px solid #f1f5f9; padding: 10px; text-transform: uppercase; font-size: 8pt; }
            td { padding: 12px 10px; border-bottom: 1px solid #f1f5f9; }
            .total-table { width: 250px; margin-left: auto; margin-top: 30px; }
            .grand-total { color: #4f46e5; font-weight: bold; font-size: 14pt; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1 style="margin:0;">INVOICE</h1>
            <p style="margin:5px 0 0 0; opacity:0.8;">#<?php echo $invoice_no; ?></p>
        </div>
        <div class="content">
            <div style="margin-bottom: 30px;">
                <p style="color:#94a3b8; font-weight:bold; margin-bottom:5px;">BILL TO</p>
                <p style="font-size:16pt; font-weight:bold; margin:0;"><?php echo $name; ?></p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th style="text-align:right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $subtotal = 0;
                    for ($i = 0; $i < count($products); $i++): 
                        $amt = $prices[$i] * $quantities[$i];
                        $subtotal += $amt;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($products[$i]); ?></td>
                        <td><?php echo $quantities[$i]; ?></td>
                        <td>&#8377;<?php echo number_format($prices[$i], 2); ?></td>
                        <td style="text-align:right;">&#8377;<?php echo number_format($amt, 2); ?></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <table class="total-table">
                <tr>
                    <td>Subtotal</td>
                    <td style="text-align:right;">&#8377;<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <tr>
                    <td>GST (18%)</td>
                    <td style="text-align:right;">&#8377;<?php echo number_format($subtotal * 0.18, 2); ?></td>
                </tr>
                <tr class="grand-total">
                    <td>Total</td>
                    <td style="text-align:right;">&#8377;<?php echo number_format($subtotal * 1.18, 2); ?></td>
                </tr>
            </table>
        </div>
    </body>
    </html>
    <?php
    $html = ob_get_clean();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("Invoice_{$invoice_no}.pdf", ["Attachment" => true]);
    exit();
}
?>