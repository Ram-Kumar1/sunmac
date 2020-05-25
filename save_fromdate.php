<?php
session_start();
include 'db_connect.php';
?>
<script type="text/javascript">
  var resObj = {};
  var resArr = [];
  var description = [];
  var name_emp1 = [];
  var empObj = {};
  var empArr = [];
  var addInfoObj = {};
  var descStr = null;
  var strArr = [];
</script> 
<?php
$sql = "SELECT * FROM `salary_description`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  description.push('<?php echo $row['description']; ?>');
</script>
<?php 
}
 

 if(isset($_POST['fromdate'])){  
         $month= $_POST['fromdate']; // 2019-02
         $month = $month . "-01";
         
$sql1 = "SELECT s.SALARY_RECEIVED_DATE, s.SALARY_GIVEN, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID and s.SALARY_RECEIVED_DATE = '$month'  ";

 }


 if(isset($_POST['name_emp'])){  
         $name= $_POST['name'];
$sql1 = "SELECT s.SALARY_RECEIVED_DATE, s.SALARY_GIVEN, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID and d.EMPLOYEE_NAME = '$name'  ";

 }
echo $sql1;
$result1 = mysqli_query($conn, $sql1);
while ($rows=mysqli_fetch_array($result1)) {
?>
<script type="text/javascript">
  debugger;
  empObj = {};
  empObj["empId"] = <?php echo $rows['EMPLOYEE_ID']; ?>;
  empObj["name"] = "<?php echo $rows['EMPLOYEE_NAME']; ?>";
  empObj["mobile"] = <?php echo $rows['EMPLOYEE_MOBILE']; ?>;
  empObj["salary"] = <?php echo $rows['SALARY']; ?>;
  empObj["salaryReceivedDate"] = <?php echo $rows['SALARY_RECEIVED_DATE']; ?>;
  empObj["noOfDaysInMonth"] = <?php echo $rows['NO_OF_DAYS_IN_MONTH']; ?>;
  empObj["noOfDaysWorked"] = <?php echo $rows['NO_OF_DAYS_WORKED']; ?>;
  empObj["addtionalInfo"] = '<?php echo $rows['ADDITIONAL_INFORMATION']; ?>';
  for(let i=0; i<description.length; i++) {
    empObj["ADDITIONAL_DESC_NAME_" + i] = description[i];
    empObj["ADDITIONAL_DESC_SALARY_" + i] = 0;
  }
  addInfoObj = JSON.parse(empObj["addtionalInfo"]);
  descStr = addInfoObj["additionalDesc"];
  salStr = addInfoObj["additionalSalary"];
  strArr = descStr.split(",");
  salArr = salStr.split(",");

  if(salArr.toString() != "") { //THE ADDITIONAL SALARY IS NOT GIVEN
    for(let j=0; j<strArr.length; j++) {
      let keyName = Object.keys(empObj).find(key => empObj[key] === strArr[j]);
      let lastIndex = keyName.lastIndexOf("_");
      let substring2 = keyName.substring(lastIndex+1, keyName.length);
      empObj["ADDITIONAL_DESC_SALARY_" + substring2] = salArr[j];
      console.log(keyName);
    }  
  }

  
  empArr.push(empObj);
              
   
</script>
<?php 


}
?>
