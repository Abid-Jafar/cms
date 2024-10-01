<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include "../DB_connection.php";

    // Get form data
    $student_id = $_POST['student_id'];
    $payment_amount = $_POST['payment_amount'];

    // Manually specify the due payment based on your input or business logic
    $due_payment = $_POST['due_payment'];

    // Prepare SQL statement to insert payment record
    $query = "INSERT INTO payments (student_id, amount_paid, due_payment, payment_date) VALUES (:student_id, :payment_amount, :due_payment, NOW())";

    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':payment_amount', $payment_amount);
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
