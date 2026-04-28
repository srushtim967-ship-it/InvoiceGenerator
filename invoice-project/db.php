<?php
$conn = new mysqli("localhost", "root", "", "invoice_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>