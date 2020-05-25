<?php
include "db_connect.php";
if(isset($_POST['sampleInvoiceId'])) {
    $sampleInvoiceId = $_POST['sampleInvoiceId'];
    $refrenceNo = $_POST['refrenceNo'];
    $count = $_POST['count'];
    $sizeArr = $_POST['sizeArr'];
    $typeArr = $_POST['typeArr'];
    $thicknessArr = $_POST['thicknessArr'];
    $productArr = $_POST['productArr'];
    $remainingArr = $_POST['remainingArr'];
    $remainingWeightArr = $_POST['remainingWeightArr'];

    $size = explode(',', $sizeArr);
    $type = explode(',', $typeArr);
    $thickness = explode(',', $thicknessArr);
    $product = explode(',', $productArr);
    $remaining = explode(',', $remainingArr);
    $remainingWeight = explode(',', $remainingWeightArr);

    for($i=0; $i<$count; $i++) {
        $productName = trim(strtolower($product[$i]));
        $sql = "update product_stock set STOCK_VALUE=$remaining[$i] where SIZE='$size[$i]' AND TYPE='$type[$i]' AND thickness='$thickness[$i]' AND PRODUCT_ID=
        (select product_id from category where lower(trim(PRODUCT_NAME)) = '$productName' )";
        mysqli_query($conn, $sql);

        $sql = "update product_stock_weight set STOCK_VALUE=$remainingWeight[$i] where SIZE='$size[$i]' AND TYPE='$type[$i]' AND thickness='$thickness[$i]' AND PRODUCT_ID=
        (select product_id from category where lower(trim(PRODUCT_NAME)) = '$productName' )";
        mysqli_query($conn, $sql);
    }

    date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date = date('Y-m-d', strtotime($date_1));
		
	$update = "update sample_pi set INVOICE_STATUS=4, DISPATCH_DATE='$date' where SAMPLE_PI_ID=".$sampleInvoiceId;
    mysqli_query($conn, $update);

    // $update = "DELETE FROM `quotation_details` WHERE `QUOTATION_ID` = (SELECT QUOTATION_ID FROM `quotation` WHERE `REFERENCE_NO` =  '$refrenceNo')";
    // mysqli_query($conn, $update);
    // $update = "DELETE FROM `quotation` WHERE `REFERENCE_NO` = '$refrenceNo'";
    // mysqli_query($conn, $update);

    print json_encode("success");
}

?>