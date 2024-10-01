<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $payment_id = $_POST['payment_id'];
        $total_fee = $_POST['total_fee'];
        $amount_paid = $_POST['amount_paid'];
        $due_payment = $_POST['due_payment'];
        $installment_number = $_POST['installment_number'];
        $date_of_payment = $_POST['date_of_payment'];
        $next_payment_date = $_POST['next_payment_date'];
        $full_paid = ($_POST['full_paid'] == '1') ? true : false;

        // Update payment data in database
        $sql = "UPDATE payments SET total_fee=?, amount_paid=?, due_payment=?, installment_number=?, date_of_payment=?, next_payment_date=?, full_paid=? WHERE payment_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$total_fee, $amount_paid, $due_payment, $installment_number, $date_of_payment, $next_payment_date, $full_paid, $payment_id]);

        // Redirect to payment page with success message
        header("Location: payment.php?success=Payment updated successfully");
        exit;
    } else {
        // Redirect to payment page with error message
        header("Location: payment.php?error=Failed to update payment");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
