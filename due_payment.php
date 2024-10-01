<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Due Payment</title>
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
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Update Due Payment</h1>
        <form method="post">
            <div class="mb-3">
                <label for="payment_id" class="form-label">Payment ID:</label>
                <input type="text" class="form-control" id="payment_id" name="payment_id" required>
            </div>
            <div class="mb-3">
                <label for="due_payment" class="form-label">Due Payment:</label>
                <input type="text" class="form-control" id="due_payment" name="due_payment" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Due Payment</button>
        </form>
        <?php
        // Include your database connection file
        include "../DB_connection.php";

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate and sanitize input
            $payment_id = $_POST["payment_id"];
            $due_payment = $_POST["due_payment"];

            // Update the due_payment column in the payments table
            $query = "UPDATE payments SET due_payment = :due_payment WHERE payment_id = :payment_id";

            try {
                // Prepare the SQL statement
                $stmt = $conn->prepare($query);

                // Bind parameters
                $stmt->bindParam(":due_payment", $due_payment);
                $stmt->bindParam(":payment_id", $payment_id);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success' role='alert'>Due payment updated successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error updating due payment.</div>";
                }
            } catch (PDOException $e) {
                // Handle database errors
                echo "<div class='alert alert-danger' role='alert'>Error: " . $e->getMessage() . "</div>";
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
