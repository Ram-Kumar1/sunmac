<?php                     
include "db_connect.php";

if(isset($_POST['customerId']))
{
 $customerId = $_POST['customerId'];
 $weight = $_POST['weight'];
 $billNumber = $_POST['billNumber'];
 $purchasedDate = $_POST['purchasedDate'];
//  $totalAmount = $_POST['totalAmount'];
//  $productCount = $_POST['productCount'];
 $type = $_POST['type'];
 $productIdStrArray = $_POST['productIdArray'];
 $productNameStrArray = $_POST['productNameArray'];
 $paymentOption = $_POST['paymentOption'];
 $remainingAmount = $_POST['remainingAmount'];
//  $productQtyStrArray = $_POST['productQtyArray'];
//  $productAmountStrArray = $_POST['productAmountArray'];
 //$entryDoneBy = $_SESSION["userName"];
$entryDoneBy = "";
 $productIdArray = explode(',', $productIdStrArray);
 $productNameArray = explode(',', $productNameStrArray);
//  $productQtyArray = explode(',', $productQtyStrArray);
//  $productAmountArray = explode(',', $productAmountStrArray);

 $count = 0;
 $selectSql = "SELECT COUNT(*) AS CNT FROM available_weight WHERE type='$type'";
 $selectSqlRes = mysqli_query($conn, $selectSql);
 while($row=mysqli_fetch_array($selectSqlRes)) {
 	$count = $row['CNT'];
 }
 if($count == 0) {
	$insertSql = "INSERT INTO `available_weight` (type, total) VALUES ('$type', $weight)";
	mysqli_query($conn, $insertSql);
 } else {
	$updateWeight = "UPDATE `available_weight` SET `total`= total + $weight WHERE TYPE='$type'";
	mysqli_query($conn, $updateWeight);
 }


echo $purchaseProductBillInsert = "INSERT INTO `purchase_details_bill`(`PURCHASE_BILL_NUMBER`, `PURCHASED_DATE`, `PURCHASE_ENTRY_DONE_BY`, `CUSTOMER_ID`, `CUSTOMER_NAME`, `TYPE`, `WEIGHT`, `PAYMENT_OPTION`, `REMAINING_AMOUNT`) VALUES ('$billNumber','$purchasedDate','$entryDoneBy',$customerId,(SELECT P_COMPANY_NAME FROM `purchase_customer` WHERE P_ID=$customerId), '$type', $weight, '$paymentOption', $remainingAmount)";
 $insert = mysqli_query($conn, $purchaseProductBillInsert);
echo "purchaseProductBillInsert inserted";

 $purchaseDetailsBillId = mysqli_query($conn, "SELECT MAX(PURCHASE_DETAILS_BILL_ID) AS BILL_ID FROM purchase_details_bill");
 while($row=mysqli_fetch_array($purchaseDetailsBillId)) {
 	$purchaseDetailsBillId1 = $row['BILL_ID'];
 }

 for($i=0; $i<1; $i++) {
 	$purchaseDetailsInsert = "INSERT INTO `purchase_details` (`PURCHASE_DETAILS_BILL_ID`, `PURCHASED_PRODUCT_NAME`) VALUES (
 	 		$purchaseDetailsBillId1,
 			'$productNameArray[$i]'
 			)";
 $insert = mysqli_query($conn, $purchaseDetailsInsert);
        echo "purchaseDetailsInsert inserted";


//CHECK PRODUCT ID PRESENT IN STOCK TABLE
 /*	echo $selectStock = "SELECT COUNT(*) AS TOTAL_COUNT, STOCK FROM `stock_details` WHERE `PRODUCT_ID` = $productIdArray[$i]";
 	$totalStock = mysqli_query($conn, $selectStock);
 	$row = mysqli_fetch_array($totalStock);
 	if($row['TOTAL_COUNT'] > 0) {
 		//Updade
 	    $totalStockCount = $row['STOCK'];
 		$updatedStock = $productQtyArray[$i] +$totalStockCount;
 		$updateQuery = "UPDATE `stock_details` SET `STOCK`=$updatedStock WHERE `PRODUCT_ID`=$productIdArray[$i]";
 		mysqli_query($conn, $updateQuery);
 	} else {
 		//Insert
 		echo $insert = "INSERT INTO `stock_details`(PRODUCT_ID, STOCK) VALUES ($productIdArray[$i],$productQtyArray[$i])";
 		mysqli_query($conn, $insert);
 		echo "stock details insert ";
 		    }*/
}
}
?> 





















<!-- //CHECK PRODUCT ID PRESENT IN STOCK TABLE
 	$selectStock = "SELECT COUNT(*) AS TOTAL_COUNT, STOCK FROM `stock_details` WHERE `PRODUCT_ID` = $productIdArray[$i]";
 	$totalStock = mysqli_query($conn, $selectStock);
 	$row = mysqli_fetch_array($totalStock);
 	if($row['TOTAL_COUNT'] > 0) {
 		//Updade
 		$updatedStock = $productQtyArray[$i] + $totalStock;
 		$updateQuery = "UPDATE `stock_details` SET `STOCK`=$updatedStock WHERE `PRODUCT_ID`=$productIdArray[$i]";
 		mysqli_query($conn, $updateQuery);
 	} else {
 		//Insert
 		$insert = "INSERT INTO `stock_details`(PRODUCT_ID, STOCK) VALUES ($productIdArray[$i],$productQtyArray[$i])";
 		mysqli_query($conn, $insert);
 	}


 	echo "purchaseDetailsInsert inserted";

 }
}
?>
 -->

<!-- //CHECK PRODUCT ID PRESENT IN STOCK TABLE

    $selectStock = "SELECT COUNT(*) AS TOTAL_COUNT FROM `stock_details` WHERE `PRODUCT_ID` = $productIdArray[$i]";

 	$totalStock = mysqli_query($conn, $selectStock);
	 
	 while($row=mysqli_fetch_assoc($totalStock)) {
	 	$totalStock = $row['TOTAL_COUNT'];
	 }
 	if($row['TOTAL_COUNT'] > 0) {
 		//Updade
 		$updatedStock = $productQtyArray[$i] + $totalStock;
 		$updateQuery = "UPDATE `stock_details` SET `STOCK`=$updatedStock WHERE `PRODUCT_ID`=$productIdArray[$i]";
 		mysqli_query($conn, $updateQuery);
 	} else {
 		//Insert
 		$insert = "INSERT INTO `stock_details`(PRODUCT_ID, STOCK) VALUES ($productIdArray,$productQtyArray[$i])";
 		mysqli_query($conn, $insert);
 	}


 	echo "stock_details insert successfully";

 }
}
?>
 -->