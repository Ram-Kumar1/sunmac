<?php
session_start();
include 'db_connect.php';

if (isset($_POST['id'])) {
    $sql = "DELETE FROM `sample_po_details` WHERE `SAMPLE_PO_ID` = " . $_POST['id'];
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM `sample_po` WHERE `SAMPLE_PO_ID` = " . $_POST['id'];
    mysqli_query($conn, $sql);
}
?>