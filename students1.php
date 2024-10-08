<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/class.php";
        include "data/batch.php";
        include "data/section.php";
        include "data/admin.php"; // Assuming this file contains relevant admin functions
        
        // Retrieve classes
        $classes = getAllClasses($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($classes) { // Check if classes are available
    ?>
    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-bordered mt-3 n-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Batch</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 0;
                    foreach ($classes as $class) { 
                        $batch = getBatchById($class['batch'], $conn); 
                        $section = getSectioById($class['section'], $conn);
                        $classIdentifier = $batch['batch_code'] . '-' . $batch['batch'] . $section['section'];
                        ?>
                        <tr>
                            <th scope="row"><?= ++$i ?></th>
                            <td>
                                <a href="students_of_class.php?class_id=<?= $class['class_id'] ?>">
                                    <?= $classIdentifier ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } else { ?>
        <div class="container mt-5">
            <div class="alert alert-info" role="alert">
                No classes found!
            </div>
        </div>
    <?php } ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>
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
