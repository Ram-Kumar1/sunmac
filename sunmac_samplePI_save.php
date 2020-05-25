<?php                     
include "db_connect.php";

if(isset($_POST['customerName'])) {

    $quotationId = $_POST['quotationId'];
    $updateSQL = "UPDATE `quotation` SET `Q_STATUS`=0 WHERE `QUOTATION_ID`=".$quotationId;
    mysqli_query($conn, $updateSQL);

    $customerName = $_POST['customerName']; 
    $mobile = $_POST['mobile'];
    $refNo = $_POST['refNo'];
    $followedBy = $_POST['followedBy'];
    $address = $_POST['address'];
    $delivary = $_POST['delivary'];
    $count = $_POST['count'];
    $gst = $_POST['gst'];
    $totalAmount = $_POST['totalAmount'];
    $gstAmount = $_POST['gstAmount'];
    //JSON ARRAY
    $size = $_POST['size'];
    $finishing = $_POST['finishing'];
    $type = $_POST['type'];
    $thickness = $_POST['thickness'];
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $price = $_POST['price'];
    $note1 = $_POST['note1'];
    $note2 = $_POST['note2'];

    $sizeArray = explode(',', $size);
    $finishingArray = explode(',', $finishing);
    $typeArray = explode(',', $type);
    $thicknessArray = explode(',', $thickness);
    $productNameArray = explode(',', $productName);
    $quantityArray = explode(',', $quantity);
    $rateArray = explode(',', $rate);
    $priceArray = explode(',', $price);
    
	date_default_timezone_set('Asia/Kolkata');
    $date_1 =  date('d-m-Y H:i');
    $date = date('Y-m-d', strtotime($date_1)); 

    echo $sql = "INSERT INTO `sample_pi`(`CUSTOMER_NAME`, `MOBILE`, `TO_ADDRESS`, `DELIVERY_ADDRESS`, `TOTAL_AMOUNT`, `DATE`, `GST`, `GST_AMOUNT`, `INVOICE_STATUS`, `NOTE_1`, `NOTE_2`, `FOLLOWED_BY_PERSON`, `REFERENCE_NO`) VALUES ('$customerName', '$mobile', '$address', '$delivary', $totalAmount, '$date', $gst, $gstAmount, 0, '$note1', '$note2', '$followedBy', '$refNo')";
    mysqli_query($conn, $sql);
    echo "`sample_pi`: Inserted Successfully";

    for($i=0; $i<$count; $i++) {
        $insert = "INSERT INTO `sample_pi_details`(`SAMPLE_PI_ID`, `SIZE`, `FINISHING`, `TYPE`, `THICKNESS`, `PRODUCT`, `QUANTITY`, `RATE`, `PRICE`, `TOTAL_AMOUNT`) VALUES (
            (SELECT MAX(SAMPLE_PI_ID) FROM `sample_pi`),
            '$sizeArray[$i]',
            '$finishingArray[$i]',
            '$typeArray[$i]',
            '$thicknessArray[$i]',
            '$productNameArray[$i]',
            $quantityArray[$i],
            $rateArray[$i],
            $priceArray[$i],
            $totalAmount)";
        echo "`sample_pi_details`: Inserted Successfull";
        mysqli_query($conn, $insert);
    }

    //INSERT INTO BALANCE TABLE
    $insertBalance = "INSERT INTO `transaction_balance`(`SAMPLE_PI_ID`, `TOTAL AMOUNT`, `BALANCE`, `LAST_UPDATE_DATE`) VALUES (
        (SELECT MAX(SAMPLE_PI_ID) FROM `sample_pi`),
        $totalAmount,
        $totalAmount,
        $date)";
    //mysqli_query($conn, $insertBalance);
    //echo "`pi_balance_table`: Insert Successfull";

} //EOIf

?>