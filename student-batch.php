<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        // Include necessary data files
        include "data/student.php";
        include "data/batch.php";
        include "data/payment.php"; // Include payment.php file

        // Check if student ID is provided in the URL
        if (!isset($_GET['student_id'])) {
            header("Location: students.php");
            exit;
        }
        
        $student_id = $_GET['student_id'];
        // Retrieve student information from the database
        $student = getStudentById($student_id, $conn);
        // If student not found, redirect to students page
        if (!$student) {
            header("Location: students.php");
            exit;
        }
        
        // Get batch information for the student
        $batch = getBatchById($student['batch'], $conn);

        // Get payments information for the student
        $payments = getPaymentsByStudentId($student_id, $conn);

        // Display the student's batch and payment information
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Batch Information</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .student-info p {
            margin: 5px 0;
        }
        .payment-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .payment-info th, .payment-info td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .payment-info th {
            background-color: #f2f2f2;
        }
        .icon {
            font-size: 20px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="icon fa fa-user"></i>Student Batch Information</h1>
        <div class="student-info">
            <!-- Display student information -->
            <p><strong><i class="icon fa fa-id-card"></i>Student ID:</strong> <?=$student['student_id']?></p>
            <p><strong><i class="icon fa fa-user"></i>Student Name:</strong> <?=$student['fname']?> <?=$student['lname']?></p>
            <p><strong><i class="icon fa fa-graduation-cap"></i>Batch:</strong> <?=$batch['batch_code']?> - <?=$batch['batch']?></p>
        </div>
        <div class="payment-info">
            <!-- Display payment information -->
            <h2><i class="icon fa fa-money"></i>Payment Details</h2>
            <table>
                <thead>
                    <tr>
                        <th><i class="icon fa fa-id-badge"></i>Payment ID</th>
                        <th><i class="icon fa fa-money"></i>Amount Paid</th>
                        <th><i class="icon fa fa-calendar"></i>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment) { ?>
                        <tr>
                            <td><?=$payment['payment_id']?></td>
                            <td><?=$payment['amount_paid']?></td>
                            <td><?=$payment['payment_date']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container mt-5">
        <a href="students1.php"
           class="btn btn-dark">Go Back</a>
     </div>
</body>
</html>
<?php
    } else {
        header("Location: ../login.php");
        exit;
    } 
} else {
    header("Location: ../login.php");
    exit;
} 
?>
