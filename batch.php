<?php 
// All Batches
function getAllBatches($conn){
   $sql = "SELECT * FROM grades";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $batches = $stmt->fetchAll();
     return $batches;
   } else {
    return 0;
   }
}

// Get Batch by ID
function getBatchById($batch_id, $conn){
   $sql = "SELECT * FROM batches
           WHERE batch_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$batch_id]);

   if ($stmt->rowCount() == 1) {
     $batch = $stmt->fetch();
     return $batch;
   } else {
    return 0;
   }
}

// DELETE
function removeBatch($id, $conn){
   $sql  = "DELETE FROM batches
           WHERE batch_id=?";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$id]);
   if ($re) {
     return 1;
   } else {
    return 0;
   }
}
?>
