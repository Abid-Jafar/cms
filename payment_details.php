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
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Payment Details</h1>
        <?php
        // Establishing database connection and including necessary files
        include "../DB_connection.php";
        include "data/student.php"; // Assuming this file contains functions related to students

        // Fetching payments data from the database
        $query = "SELECT p.payment_id, CONCAT(s.fname, ' ', s.lname) AS student_name, p.amount_paid, p.payment_date FROM payments p JOIN students s ON p.student_id = s.student_id";
        $result = $conn->query($query);

        // Checking if query execution was successful
        if ($result) {
            // Displaying payments data in a table
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped'>";
            echo "<thead class='bg-dark text-white'><tr><th>Payment ID</th><th>Student Name</th><th>Amount Paid</th><th>Payment Date</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>".$row['payment_id']."</td>";
                echo "<td>".$row['student_name']."</td>";
                echo "<td>".$row['amount_paid']."</td>";
                echo "<td>".$row['payment_date']."</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            // Displaying an error message if query execution failed
            echo "<div class='alert alert-danger' role='alert'>Error: ".$conn->errorInfo()[2]."</div>";
        }

        // Closing the database connection
        $conn = null;
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
