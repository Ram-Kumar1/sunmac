<?php
session_start();
include 'db_connect.php';
if(isset($_POST['S_ID'])) {
    $sId = $_POST['S_ID'];
    date_default_timezone_set('Asia/Kolkata');
    $date_1 =  date('d-m-Y H:i');
    $date = date('Y-m-d', strtotime($date_1));

    $sql = "INSERT INTO `followup`(`S_ID`,`CURRENT_FOLLOWUP_DATE`, `CUSTOMER_STATUS`) VALUES ($sId, '$date', 0)";
    mysqli_query($conn, $sql);
    echo json_encode("success");
}
?>