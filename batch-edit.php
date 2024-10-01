<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role']) && isset($_GET['batch_id'])) {

    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/batch.php"; // Update to the correct file name

        $batch_id = $_GET['batch_id']; // Update variable name
        $batch = getBatchById($batch_id, $conn); // Update function name
        if ($batch == 0) {
            header("Location: batch.php"); // Update redirection URL
            exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Batch</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
    ?>
    <div class="container mt-5">
        <a href="batch.php" class="btn btn-dark">Go Back</a>

        <form method="post" class="shadow p-3 mt-5 form-w" action="req/batch-edit.php">
            <h3>Edit Batch</h3><hr>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_GET['error'] ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label class="form-label">Batch Code</label>
                <input type="text" class="form-control" value="<?= $batch['batch_code'] ?>" name="batch_code">
            </div>
            <div class="mb-3">
                <label class="form-label">Batch</label>
                <input type="text" class="form-control" value="<?= $batch['batch'] ?>" name="batch">
            </div>
            <input type="text" class="form-control" value="<?= $batch['batch_id'] ?>" name="batch_id" hidden>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(4) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 
    } else {
        header("Location: batch.php");
        exit;
    } 
} else {
    header("Location: batch.php");
    exit;
}
?>
