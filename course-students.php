<?php
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
    if (isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];
        include "../DB_connection.php";
        include "data/student.php"; // Include the file where getStudentsByCourse() is defined
        
        // Retrieve students by course ID using the existing function
        $students = getStudentsByCourse($course_id, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Enrolled in Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Add your custom stylesheets here -->
</head>
<body>
    <div class="container">
        <h1>Students Enrolled in Course</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $index => $student): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $student['student_id'] ?></td>
                        <td><?= $student['first_name'] ?></td>
                        <td><?= $student['last_name'] ?></td>
                        <!-- Add more cells for additional student information -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
    } else {
        echo "Error: Course ID not provided.";
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
