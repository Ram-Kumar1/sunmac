<?php
session_start();
include 'db_connect.php';

if(isset($_POST['S_NO'])){

  $sNo= $_POST['S_NO'];

  echo $delete = "DELETE FROM `sales_customer` WHERE S_ID = $sNo";
  mysqli_query($conn,$delete);
  print json_encode("success");
}
?>