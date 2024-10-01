<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Adjust path if necessary -->
    <link rel="icon" href="../logo.png"> <!-- Adjust path if necessary -->
    <style>
        /* Custom styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #343a40;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-action {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Payment Details</h1>
        <a href="index.php" class="btn btn-secondary mt-3">Go Back</a>
        <?php
        // Establishing database connection and including necessary files
        include "../DB_connection.php";
        include "data/student.php"; // Assuming this file contains functions related to students

        // Fetching payments data from the database
        $query = "SELECT p.payment_id, CONCAT(s.fname, ' ', s.lname) AS student_name, p.amount_paid, p.due_payment, p.payment_date 
                    FROM payments p 
                    JOIN students s ON p.student_id = s.student_id";
        $result = $conn->query($query);

        // Checking if query execution was successful
        if ($result) {
            // Displaying payments data in a table
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped'>";
            echo "<thead class='bg-dark text-white'><tr><th>Payment ID</th><th>Student Name</th><th>Amount Paid</th><th>Due Payment</th><th>Payment Date</th><th>Action</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>".$row['payment_id']."</td>";
                echo "<td>".$row['student_name']."</td>";
                echo "<td>".$row['amount_paid']."</td>";
                echo "<td>".$row['due_payment']."</td>";
                echo "<td>".$row['payment_date']."</td>";
                echo "<td>";
                // Action buttons for editing and deleting
                echo "<a href='edit_payment.php?payment_id=".$row['payment_id']."' class='btn btn-primary btn-action'>Edit</a>";
                echo "<a href='delete_payment.php?payment_id=".$row['payment_id']."' class='btn btn-danger btn-action'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            // Displaying an error message if query execution failed
            echo "<div class='alert alert-danger' role='alert'>Error: ".$conn->errorInfo()[2]."</div>";
        }
        ?>
        <h2 class="mt-4">Add New Payment</h2>
        <form action="add_payment.php" method="post">
            <div class="mb-3">
                <label for="student_id" class="form-label">Student ID</label>
                <select class="form-select" id="student_id" name="student_id" required>
                    <option value="" selected>Select Student ID</option>
                    <?php
                    // Fetching students data from the database for dropdown
                    $query_students = "SELECT student_id, CONCAT(fname, ' ', lname) AS student_name FROM students";
                    $result_students = $conn->query($query_students);
                    while ($row_student = $result_students->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='".$row_student['student_id']."'>".$row_student['student_name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="payment_amount" class="form-label">Amount Paid</label>
                <input type="number" class="form-control" id="payment_amount" name="payment_amount" placeholder="Enter payment amount" required>
            </div>
            <div class="mb-3">
                <label for="due_payment" class="form-label">Due Payment</label>
                <input type="number" class="form-control" id="due_payment" name="due_payment" placeholder="Enter due payment">
            </div>
            <button type="submit" class="btn btn-primary">Add Payment</button>
            
        </form>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
