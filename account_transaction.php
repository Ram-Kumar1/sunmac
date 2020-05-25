<?php 
session_start();
include 'db_connect.php';
if(isset($_POST['userid'])) {
    $id = $_POST['userid'];
    $resultArr = array();
    $finalArr = array();
    $sql = "SELECT `DATE`, `PAID_AMOUNT`, `BALANCE` FROM `transaction` WHERE `SAMPLE_PI_ID`= ".$id." ORDER BY 1";
    $result = mysqli_query($conn, $sql);

    $i = 0;
    while($row = mysqli_fetch_array($result)) {
        $res = array();
        $res['DATE'] = $row['DATE'];
        $res['PAID_AMOUNT'] = $row['PAID_AMOUNT'];
        $res['BALANCE'] = $row['BALANCE'];
        array_push($resultArr, $res); 
    }
    array_push($finalArr, $resultArr); 
    array_push($finalArr, $id);
    echo json_encode($finalArr); 

} else if(isset($_POST['samplePiId'])) {
    $samplePiId = $_POST['samplePiId'];
    $resultArr = array();
    $finalArr = array();
    $accountSql = "SELECT S.SAMPLE_PI_ID, S.REFERENCE_NO, S.CUSTOMER_NAME, S.MOBILE, S.DATE, (S.TOTAL_AMOUNT - S.GST_AMOUNT) AS PRODUCT_AMOUNT, S.TOTAL_AMOUNT, S.GST_AMOUNT, 
				(S.TOTAL_AMOUNT - TB.BALANCE) AS ADVANCE, TB.BALANCE, S.INVOICE_STATUS, T.TRANSACTION_ID 
				FROM sample_pi S, transaction T, transaction_balance TB WHERE 1=1 
				AND S.SAMPLE_PI_ID = T.SAMPLE_PI_ID 
				AND S.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
				AND T.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
				AND S.INVOICE_STATUS != 0 
                AND S.SAMPLE_PI_ID = ".$samplePiId;
    $accountSql = $accountSql." GROUP BY T.SAMPLE_PI_ID ";

    $result = mysqli_query($conn, $accountSql);
    while($row = mysqli_fetch_array($result)) {
        $res = array();
        $res['REFERENCE_NO'] = $row['REFERENCE_NO'];
        $res['CUSTOMER_NAME'] = $row['CUSTOMER_NAME'];
        $res['MOBILE'] = $row['MOBILE'];
        $res['DATE'] = $row['DATE'];
        $res['PRODUCT_AMOUNT'] = $row['PRODUCT_AMOUNT'];
        $res['TOTAL_AMOUNT'] = $row['TOTAL_AMOUNT'];
        $res['GST_AMOUNT'] = $row['GST_AMOUNT'];
        $res['ADVANCE'] = $row['ADVANCE'];
        $res['BALANCE'] = $row['BALANCE'];

        array_push($resultArr, $res); 
    }
    array_push($finalArr, $resultArr); 
    array_push($finalArr, $samplePiId);
    echo json_encode($finalArr); 
}

?>