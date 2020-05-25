<?php
session_start();
include 'db_connect.php';
if(isset($_POST['quotationId'])) {
    $sql = "UPDATE `quotation_followup` SET `SHOW_TO_ADMIN`=0 WHERE `QUOTATION_ID`= ".$_POST['quotationId'];
    mysqli_query($conn, $sql);
    echo json_encode("success");
} else if(isset($_POST['followupId'])) {
    $sql = "UPDATE `followup` SET `SHOW_TO_ADMIN`=0 WHERE `F_ID`= ".$_POST['followupId'];
    mysqli_query($conn, $sql);
    echo json_encode("success");
} else if(isset($_POST['followupIdForRemainder'])) {
    $sql = "UPDATE `remainder_followup` SET `SHOW_TO_ADMIN`=0 WHERE `F_ID`= ".$_POST['followupIdForRemainder'];
    mysqli_query($conn, $sql);
    echo json_encode("success");
} else if(isset($_POST['invoiceId'])) {
	$sql = "UPDATE `sample_pi` SET `SHOW_TO_ADMIN`=0 WHERE `SAMPLE_PI_ID`= ".$_POST['invoiceId'];
	mysqli_query($conn, $sql);
    echo json_encode("success");
} else if(isset($_POST['invoiceIdFromAccounts'])) {
	$sql = "UPDATE `transaction_balance` SET `SHOW_TO_ACCOUNTS`=0 WHERE `SAMPLE_PI_ID`= ".$_POST['invoiceIdFromAccounts'];
	mysqli_query($conn, $sql);
    echo json_encode("success");
} else if(isset($_POST['invoiceIdForAccountInIndex'])) {
	$sql = "UPDATE `transaction_balance` SET `SHOW_TO_ADMIN`=0 WHERE `SAMPLE_PI_ID`= ".$_POST['invoiceIdForAccountInIndex'];
	mysqli_query($conn, $sql);
    echo json_encode("success");
} 

?>