<?php
// Check if payment_id is set in the URL
if (isset($_GET['payment_id'])) {
    // Include database connection
    include "../DB_connection.php";

    // Sanitize input
    $payment_id = filter_input(INPUT_GET, 'payment_id', FILTER_SANITIZE_NUMBER_INT);

    // Check if payment_id is valid
    if (!$payment_id) {
        echo "Error: Invalid payment ID.";
        exit();
    }

    try {
        // Delete payment record
        $query = "DELETE FROM payments WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':payment_id', $payment_id);
        $stmt->execute();

        // Redirect back to payment details page
        header("Location: payment.php");
        exit();
    } catch (PDOException $e) {
        // Display error message if there's a database error
        echo "Error: " . $e->getMessage();
    }

    // Close database connection
    $conn = null;
} else {
    // If payment_id is not set in the URL, redirect back to payment details page
    header("Location: payment.php");
    exit();
}
?>
