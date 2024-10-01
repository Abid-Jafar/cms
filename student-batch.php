<?php 
session_start();
if (isset($_SESSION['teacher_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Teacher') {
        include "../DB_connection.php";
        // Include necessary data files
        include "data/student.php";
        include "data/batch.php"; 

        // Check if student ID is provided in the URL
        if (!isset($_GET['student_id'])) {
            header("Location: students.php");
            exit;
        }
        
        $student_id = $_GET['student_id'];
        // Retrieve student information from the database
        $student = getStudentById($student_id, $conn);
        // If student not found, redirect to students page
        if (!$student) {
            header("Location: students.php");
            exit;
        }
        
        // Get batch information for the student
        $batch = getBatchById($student['batch'], $conn);

        // Display the student's batch information
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Batch Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .student-info {
            display: flex;
            align-items: center;
        }
        .student-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .student-details {
            flex: 1;
        }
        p {
            margin-bottom: 10px;
            color: #666;
        }
        strong {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Batch Information</h1>
        <div class="student-info">
            <img src="..\img\student-Male.png" alt="Student Image">
            <div class="student-details">
                <p><strong>Student ID:</strong> <?=$student['student_id']?></p>
                <p><strong>Student Name:</strong> <?=$student['fname']?> <?=$student['lname']?></p>
                <p><strong>Batch:</strong> <?=$batch['batch_code']?> - <?=$batch['batch']?></p>
                
            </div>
        </div>
    </div>
</body>
</html>


<?php
    } else {
        header("Location: ../login.php");
        exit;
    } 
} else {
    header("Location: ../login.php");
    exit;
} 
?>
