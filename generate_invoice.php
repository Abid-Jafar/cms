<?php
// Establishing database connection and including necessary files
include "../DB_connection.php";
include "data/student.php"; // Assuming this file contains functions related to students

// Check if student ID is provided
if(isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetching student's information
    $student_query = "SELECT * FROM students WHERE student_id = :student_id";
    $stmt = $conn->prepare($student_query);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetching payment details for the student
    $payment_query = "SELECT * FROM payments WHERE student_id = :student_id";
    $stmt = $conn->prepare($payment_query);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Start HTML for invoice
    $html = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Invoice</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css'>
        <style>
            /* Custom styles */
            body {
                font-family: Arial, sans-serif;
            }
            .invoice-header {
                text-align: center;
                margin-bottom: 30px;
            }
            .invoice-details {
                margin-bottom: 20px;
            }
            .invoice-table {
                width: 100%;
                border-collapse: collapse;
            }
            .invoice-table th, .invoice-table td {
                padding: 8px;
                border-bottom: 1px solid #dee2e6;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='invoice-header'>
                <h1>Invoice</h1>
                <h3>{$student["fname"]} {$student["lname"]}</h3>
            </div>
            <div class='invoice-details'>
                <p><strong>Student ID:</strong> {$student['student_id']}</p>
                <p><strong>Email:</strong> {$student['email']}</p>
                <p><strong>Address:</strong> {$student['address']}</p>
            </div>
            <table class='table invoice-table'>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Amount Paid</th>
                        <th>Due Payment</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>";
    
    // Loop through payments and add to the invoice
    foreach($payments as $payment) {
        $html .= "<tr>
                    <td>{$payment['payment_id']}</td>
                    <td>{$payment['amount_paid']}</td>
                    <td>{$payment['due_payment']}</td>
                    <td>{$payment['payment_date']}</td>
                </tr>";
    }

    // End HTML for invoice
    $html .= "</tbody>
            </table>
        </div>
    </body>
    </html>";

    // Output HTML
    echo $html;
} else {
    echo "Student ID not provided.";
}
?>
