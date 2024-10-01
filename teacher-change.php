<?php 
session_start();

if (isset($_SESSION['teacher_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Teacher') {
    if (isset($_POST['old_pass']) && isset($_POST['new_pass']) && isset($_POST['c_new_pass'])) {
        include '../../DB_connection.php';
        include "../data/teacher.php";

        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $c_new_pass = $_POST['c_new_pass'];

        $teacher_id = $_SESSION['teacher_id'];
        
        if (empty($old_pass) || empty($new_pass) || empty($c_new_pass)) {
            $em = "All fields are required.";
            header("Location: ../pass.php?perror=$em");
            exit;
        } elseif ($new_pass !== $c_new_pass) {
            $em = "New password and confirm password do not match.";
            header("Location: ../pass.php?perror=$em");
            exit;
        } else {
            // Verify old password
            $teacher = getTeacherById($teacher_id, $conn);
            if (!$teacher || !password_verify($old_pass, $teacher['password'])) {
                $em = "Incorrect old password.";
                header("Location: ../pass.php?perror=$em");
                exit;
            }

            // Hash the new password
            $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

            // Update the password in the database
            $sql = "UPDATE teachers SET password = ? WHERE teacher_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$hashed_password, $teacher_id]);

            $sm = "Password changed successfully!";
            header("Location: ../pass.php?psuccess=$sm");
            exit;
        }
    } else {
        $em = "An error occurred.";
        header("Location: ../pass.php?perror=$em");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
?>
