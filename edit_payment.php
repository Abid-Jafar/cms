<?php
// Check if payment_id is provided in the URL
if(isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // Include database connection
    include "../DB_connection.php";

    // Fetch payment details based on payment_id
    $query = "SELECT * FROM payments WHERE payment_id = :payment_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':payment_id', $payment_id);
    $stmt->execute();
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if payment exists
    if($payment) {
        // Payment found, display form to edit payment
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Payment</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/style.css"> <!-- Adjust path if necessary -->
            <link rel="icon" href="../logo.png"> <!-- Adjust path if necessary -->
        </head>
        <body>
            <div class="container">
                <h1 class="mb-4">Edit Payment</h1>
                <form action="update_payment.php" method="post">
                    <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
                    <div class="mb-3">
                        <label for="amount_paid" class="form-label">Amount Paid</label>
                        <input type="number" class="form-control" id="amount_paid" name="amount_paid" value="<?php echo $payment['amount_paid']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="due_payment" class="form-label">Due Payment</label>
                        <input type="number" class="form-control" id="due_payment" name="due_payment" value="<?php echo $payment['due_payment']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Payment</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Payment not found, display error message
        echo "Payment not found.";
    }

    // Close database connection
    $conn = null;
} else {
    // Redirect to payment details page if payment_id is not provided
    header("Location: payment.php");
    exit();
}
?>
