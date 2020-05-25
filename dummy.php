<?php
session_start();
include 'db_connect.php';

$firstDay = date('m-01-Y'); // hard-coded '01' for first day
$lastDay = date('m-t-Y');
$isCurrentDateInsertedSql = "select count(*) as CNT from followup where CURRENT_FOLLOWUP_DATE=CURDATE()";
$isCurrentDateInserted = 0;
if($result = mysqli_query($conn, $isCurrentDateInsertedSql)) {
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $isCurrentDateInserted = $row['CNT'];
        }
    }
} 
$isCurrentDateInserted;
if($isCurrentDateInserted == 0) {
  $follwedCustomerIdSql = "SELECT COUNT(*) AS CNT FROM SALES_CUSTOMER C WHERE 1=1 AND S_ID NOT IN (SELECT DISTINCT S_ID FROM FOLLOWUP WHERE CURRENT_FOLLOWUP_DATE BETWEEN '$firstDay' AND '$lastDay')"; 
  $remaingFollowUp = 0;
  if($result = mysqli_query($conn, $follwedCustomerIdSql)) {
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $remaingFollowUp = $row['CNT'];
        }
    }
  }
  if($remaingFollowUp > 0) {
    $today = new DateTime();
	
	date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date = date('Y-m-d', strtotime($date_1));
	
    $lastDayOfThisMonth = new DateTime('last day of this month');
    $nbOfDaysRemainingThisMonth = $lastDayOfThisMonth->diff($today)->format('%a days');
    $totalCntPerDay = ceil((int) $remaingFollowUp / (int) $nbOfDaysRemainingThisMonth);
    $insertQuery = 
        "INSERT INTO FOLLOWUP (S_ID, CURRENT_FOLLOWUP_DATE, CUSTOMER_STATUS)  
            (SELECT S_ID, $date, 0 FROM SALES_CUSTOMER WHERE S_ID NOT IN (SELECT DISTINCT S_ID FROM FOLLOWUP WHERE CURRENT_FOLLOWUP_DATE BETWEEN '$firstDay' AND '$lastDay') LIMIT $totalCntPerDay)";
    mysqli_query($conn, $insertQuery);
}

}

?>