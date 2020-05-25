<?php
session_start();
include 'db_connect.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    echo $update = "UPDATE `sample_pi` SET `INVOICE_STATUS`= 2 WHERE `SAMPLE_PI_ID` = ".$id;
    mysqli_query($conn,$update);
    print_r("success");

} else if(isset($_POST['quotationId'])) {
    $id = $_POST['quotationId'];
    echo $update = "UPDATE `sample_pi` SET `INVOICE_STATUS`= 3 WHERE `SAMPLE_PI_ID` = ".$id;
    mysqli_query($conn,$update);
    print_r("success");
} else if(isset($_POST['invoiceId'])) {
    $id = $_POST['quotationId'];
    echo $update = "UPDATE `sample_pi` SET `INVOICE_STATUS`= 4 WHERE `SAMPLE_PI_ID` = ".$id;
    mysqli_query($conn,$update);
    print_r("success");
}

?>