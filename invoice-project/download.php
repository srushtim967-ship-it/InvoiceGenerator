<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

ob_start();
include 'invoice_template.php';
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("invoice.pdf", ["Attachment" => true]);
?>