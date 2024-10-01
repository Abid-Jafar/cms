<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    include "../DB_connection.php";

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $student_id = $_POST['student_id'];
        $payment_type = $_POST['payment_type'];
        $total_fee = $_POST['total_fee'];
        $amount_paid = $_POST['amount_paid'];
        $due_payment = $_POST['due_payment'];
        $installment_number = $_POST['installment_number'];
        $date_of_payment = $_POST['date_of_payment'];
        $next_payment_date = $_POST['next_payment_date'];
        $full_paid = ($_POST['full_paid'] == '1') ? true : false;
        $admin_id = $_SESSION['admin_id'];

        // Insert payment data into database
        $sql = "INSERT INTO payments (student_id, payment_type, total_fee, amount_paid, due_payment, installment_number, date_of_payment, next_payment_date, full_paid, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$student_id, $payment_type, $total_fee, $amount_paid, $due_payment, $installment_number, $date_of_payment, $next_payment_date, $full_paid, $admin_id]);

        // Redirect to payment page with success message
        header("Location: payment.php?success=Payment added successfully");
        exit;
    } else {
        // Redirect to payment page with error message
        header("Location: payment.php?error=Failed to add payment");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
