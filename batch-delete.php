<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && isset($_GET['batch_id'])) {

    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/batch.php"; // Update to the correct file name

        $id = $_GET['batch_id']; // Update variable name
        if (removeBatch($id, $conn)) { // Update function name
            $sm = "Successfully deleted!";
            header("Location: batch.php?success=$sm"); // Update redirection URL
            exit;
        } else {
            $em = "Unknown error occurred";
            header("Location: batch.php?error=$em"); // Update redirection URL
            exit;
        }
    } else {
        header("Location: batch.php"); // Update redirection URL
        exit;
    } 
} else {
    header("Location: batch.php"); // Update redirection URL
    exit;
}
?>
