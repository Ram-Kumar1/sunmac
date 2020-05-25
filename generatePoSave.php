<?php
include "db_connect.php";

if (isset($_POST['customerName'])) {

    $customerName = $_POST['customerName'];
    $mobile = $_POST['mobile'];
    $refNo = $_POST['refNo'];
    $address = $_POST['address'];
    $count = $_POST['count'];
    $gst = $_POST['gst'];
    $totalAmount = $_POST['totalAmount'];
    $gstAmount = $_POST['gstAmount'];
    $refrenceNo = $_POST['refrenceNo'];
    //JSON ARRAY
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $price = $_POST['price'];

    $productNameArray = explode(',', $productName);
    $quantityArray = explode(',', $quantity);
    $rateArray = explode(',', $rate);
    $priceArray = explode(',', $price);

    date_default_timezone_set('Asia/Kolkata');
    $date_1 =  date('d-m-Y H:i');
    $date = date('Y-m-d', strtotime($date_1));

    echo $sql = "INSERT INTO `sample_po`(`CUSTOMER_NAME`, `MOBILE`, `ADDRESS`, `TOTAL_AMOUNT`, `DATE`, `GST`, `GST_AMOUNT`, `REFERENCE_NO`) VALUES ('$customerName', '$mobile', '$address', $totalAmount, '$date', $gst, $gstAmount, '$refNo')";
    mysqli_query($conn, $sql);
    echo "`sample_pi`: Inserted Successfully";

    for ($i = 0; $i < $count; $i++) {
        $insert = "INSERT INTO `sample_po_details`(`SAMPLE_PO_ID`, `PRODUCT`, `QUANTITY`, `RATE`, `PRICE`, `TOTAL_AMOUNT`) VALUES (
            (SELECT MAX(SAMPLE_PO_ID) FROM `sample_po`),
            '$productNameArray[$i]',
            $quantityArray[$i],
            $rateArray[$i],
            $priceArray[$i],
            $totalAmount)";
        echo "`sample_pi_details`: Inserted Successfull";
        mysqli_query($conn, $insert);
    }

    if ($refrenceNo == 1) {
        $updateSQL = "INSERT INTO `refrence_po`(`DATE`, `INC_NO`) VALUES ('$date',$refrenceNo)";
    } else {
        $updateSQL = "UPDATE `refrence_po` SET `INC_NO`=$refrenceNo WHERE `DATE`='$date'";
    }
    mysqli_query($conn, $updateSQL);
} //EOIf
