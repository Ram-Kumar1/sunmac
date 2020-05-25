<?php
include "db_connect.php";
if(isset($_POST['employeeId']))
{
 $employeeId = $_POST['employeeId'];
 $find=mysqli_query($conn,"SELECT EMPLOYEE_MOBILE,SALARY FROM `employee_details` WHERE EMPLOYEE_ID=$employeeId");
  while($row=mysqli_fetch_array($find))
 {
  // echo "<option>".$row['EMPLOYEE_MOBILE']."</option>";
  // echo "<option>".$row['SALARY']."</option>";
 	$mobile = $row['EMPLOYEE_MOBILE'];
 	$salary = $row['SALARY'];
}
$res = array("mobile"=>$mobile, "salary"=>$salary);
print json_encode($res);
}
?>
