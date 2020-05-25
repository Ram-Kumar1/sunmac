<?php
session_start();
include 'db_connect.php';

if(isset($_POST['samplePiId']))  {
	$samplePiId = $_POST['samplePiId'];
	$refrenceNo = $_POST['refrenceNo'];
	$custName = $_POST['custName'];
	$invoiceStatus = $_POST['invoiceStatus'];

	$sql = "SELECT count(S_NAME) as ct,S_ID  FROM sales_customer WHERE S_NAME='$custName'";
	$result = mysqli_query($conn,$sql);
	$ct = 0;
	while($row = mysqli_fetch_array($result)){
		$ct = $row['ct'];
		$S_ID = $row['S_ID'];
		
		date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date = date('Y-m-d', strtotime($date_1));
	}

	if($ct > 0) {
		$count = 1;
		$isDeletedFromSampleInvoice = 0;
		
		if($count > 0) {
			echo "\n";
			echo $sql = "DELETE FROM sample_pi WHERE REFERENCE_NO='$refrenceNo' AND SAMPLE_PI_ID=$samplePiId";
			mysqli_query($conn,$sql);
			$isDeletedFromSampleInvoice = 1;

			if($invoiceStatus > 0) {
				// Delet from transaction and transaction_balance table
				$deleteSql = "DELETE FROM `transaction` WHERE `SAMPLE_PI_ID` = $samplePiId";
				mysqli_query($conn,$deleteSql);
				$deleteSql = "DELETE FROM `transaction_balance` WHERE `SAMPLE_PI_ID` = $samplePiId";
				mysqli_query($conn, $deleteSql);
			}
		}
		if($isDeletedFromSampleInvoice == 1) {
			echo $sql = "DELETE FROM quotation WHERE REFERENCE_NO='$refrenceNo'";
			mysqli_query($conn,$sql);
			echo $sql = "INSERT INTO `quotation_followup`(`CUSTOMER_ID`, `Q_STATUS`, `Q_DATE`, `SHOW_TO_ADMIN`) VALUES ($S_ID,0,'$date',1)";
			mysqli_query($conn,$sql);
		}
	} else {
		$sql = "DELETE FROM sample_pi WHERE REFERENCE_NO='$refrenceNo' AND SAMPLE_PI_ID=$samplePiId";
		mysqli_query($conn,$sql);
		
		// Delet from transaction and transaction_balance table
		$deleteSql = "DELETE FROM `transaction` WHERE `SAMPLE_PI_ID` = $samplePiId";
		mysqli_query($conn,$deleteSql);
		$deleteSql = "DELETE FROM `transaction_balance` WHERE `SAMPLE_PI_ID` = $samplePiId";
		mysqli_query($conn, $deleteSql);
		
		$sql = "DELETE FROM quotation WHERE REFERENCE_NO='$refrenceNo'";
		mysqli_query($conn,$sql);
		
	}

}

?>