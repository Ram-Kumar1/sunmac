<?php

include "db_connect.php";

if(isset($_POST['employeeId']))
{
	$employeeId = $_POST['employeeId'];
	$salaryBasic = $_POST['salaryBasic'];
	$workingDays = $_POST['workingDays'];
	$daysWorked = $_POST['daysWorked'];
	$salary = $_POST['salary'];
	$salaryGiven = $_POST['salaryGiven'];
	$leave = $_POST['leave'];
	$month = $_POST['month'];
	$month = $month . "-01";
	$monthYear = $_POST['monthYear'];

	$salaryReceivedDate = $_POST['salaryReceivedDate'];
	$additionalSalary = $_POST['additionalSalary'];
	$additionalDesc = $_POST['additionalDesc'];
	$removeSalary = $_POST['removeSalary'];
	$removeDesc = $_POST['removeDesc'];
	$isDelete = $_POST['isDelete'];

if($isDelete == 'yes') {
$deleteQuery = "DELETE FROM `employee_salary_details` WHERE `EMPLOYEE_ID` = $employeeId AND `MONTH_YEAR`= '$month' ";
mysqli_query($conn,$deleteQuery);
}

	print  json_encode($additionalSalary);
	$additionDesc = array("additionalSalary"=>$additionalSalary, "additionalDesc"=>$additionalDesc, "removeSalary"=>$removeSalary, "removeDesc"=>$removeDesc);
	$additionalInfomation = json_encode($additionDesc);

	$insertQuery = "INSERT INTO `employee_salary_details`(`EMPLOYEE_ID`, `MONTH_YEAR`, `NO_OF_DAYS_IN_MONTH`, `NO_OF_DAYS_WORKED`, `SALARY`, `SALARY_GIVEN`, `LEAVE_TAKEN`, `SALARY_RECEIVED_DATE`, `ADDITIONAL_INFORMATION`, `salaryBasic`) VALUES ($employeeId,'$month',$workingDays, $daysWorked, $salary, $salaryGiven, $leave, '$month','$additionalInfomation','$salaryBasic')";
	$insert = mysqli_query($conn, $insertQuery);
}


if(isset($_POST['val'])){

$employeeId = $_POST['emplId'];
$val_date = $_POST['val'];
$val_date = $val_date . "-01";

$query1= "SELECT * FROM `employee_salary_details` WHERE EMPLOYEE_ID = $employeeId AND MONTH_YEAR = '$val_date'  ";
$result1 = mysqli_query($conn, $query1);
$count = mysqli_num_rows ( $result1 );
if (mysqli_num_rows ( $result1 ) == 0 )
{
	echo 'no';
}else{
	echo 'yes';
}

}

?>