<?php
session_start();
include 'db_connect.php';

if(isset($_POST['id'])) {
  $qtnId = $_POST['id'];
  // $isFromRemainderTable = $_POST['isFromRemainderTable'];
  // $query = "DELETE FROM followup WHERE F_ID = $followupId";
  $query = "DELETE FROM quotation_followup WHERE QUOTATION_ID = $qtnId";
  mysqli_query($conn, $query);
  // if($isFromRemainderTable == 1) {
  //   $query = "DELETE FROM remainder_followup WHERE F_ID = $followupId";
  //   mysqli_query($conn, $query);
  // }
  print_r(json_encode("success"));
}

?>