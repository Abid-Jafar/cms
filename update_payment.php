<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include "../DB_connection.php";

    // Get form data
    $payment_id = $_POST['payment_id'];
    $amount_paid = $_POST['amount_paid'];
    $due_payment = $_POST['due_payment'];

    // Prepare SQL statement to update payment record
    $query = "UPDATE payments SET amount_paid = :amount_paid, due_payment = :due_payment WHERE payment_id = :payment_id";

    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':payment_id', $payment_id);
    $stmt->bindParam(':amount_paid', $amount_paid);
    $stmt->bindParam(':due_payment', $due_payment);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to payment details page
        header("Location: payment.php");
        exit();
    } else {
        // Display error message if execution fails
        echo "Error: " . $stmt->errorInfo()[2];
    }

    // Close statement and database connection
    $stmt = null;
    $conn = null;
} else {
    // If form is not submitted, redirect back to payment details page
    header("Location: payment.php");
    exit();
}
?>
