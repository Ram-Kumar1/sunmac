<?php
session_start();
include 'db_connect.php';

if(isset($_POST['S_ID'])){

  $S_ID= $_POST['S_ID'];

  $delete = "DELETE FROM `sales_customer` WHERE S_ID = '$S_ID'";
  mysqli_query($conn,$delete);
  print json_encode("success");
  ?>
  <script>
    alert("Data Deleted Successfully");
  </script>
<?php
}






if(isset($_POST['submit'])){

       $S_NAME= $_POST['S_NAME'];
       $S_MOBILE= $_POST['S_MOBILE'];
       $S_ALTERNATE_MOBILE= $_POST['S_ALTERNATE_MOBILE'];
       $S_MAIL= $_POST['S_MAIL'];
       $S_ADDRESS= $_POST['S_ADDRESS'];
       $S_CITY= $_POST['S_CITY'];
	   
	   date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$S_REGISTRATION_DATE = date('Y-m-d', strtotime($date_1));


    if(strlen($S_MOBILE)  == 10 && strlen($S_ALTERNATE_MOBILE)  == 10){
          
 $sql = "INSERT INTO sales_customer(S_NAME, S_MOBILE,S_ALTERNATE_MOBILE,S_MAIL,S_ADDRESS,S_CITY,S_NEED_TO_FOLLOWED,S_REGISTRATION_DATE) VALUES ('$S_NAME','$S_MOBILE','$S_ALTERNATE_MOBILE','$S_MAIL','$S_ADDRESS','$S_CITY','0', $S_REGISTRATION_DATE')";
if (mysqli_query($conn, $sql)) {
                ?>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }

       }   else{

 ?>
        <script type="text/javascript">
         alert("Phone number is invalid");
        document.form1.S_MOBILE.focus();
       </script>
        
        <?php


         }
       }

function startsWith ($string, $startString) 
                  { 
                      $len = strlen($startString); 
                      return (substr($string, 0, $len) === $startString); 
                  }



?>
<!DOCTYPE html>
<head>
<title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />

<?php
include 'demo.css';
?>
<?php
include 'demo.js';
?>

<style type="text/css">
  .filterable {
    margin-top: 15px;
}
.filterable .panel-heading .pull-right {
    margin-top: -20px;
}
.filterable .filters input[disabled] {
    background-color: transparent;
    border: none;
    cursor: auto;
    box-shadow: none;
    padding: 0;
    height: auto;
}
.filterable .filters input[disabled]::-webkit-input-placeholder {
    color: #333;
}
.filterable .filters input[disabled]::-moz-placeholder {
    color: #333;
}
.filterable .filters input[disabled]:-ms-input-placeholder {
    color: #333;
}

</style>

</head>

<body>
<?php include 'header.php'; ?>

<section id="main-content">
	<section class="wrapper">
       <div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Employee Salary View
                    </header>
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="S NO" disabled></th>
                        <th><input type="text" class="form-control" placeholder="EMPLOYEE NAME" disabled></th>
                        <th><input type="text" class="form-control" placeholder="EMPLOYEE NUMBER" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Salary Date" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Working days of month" disabled></th>
                        <th><input type="text" class="form-control" placeholder="No Of Days Worked" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Demo" disabled></th>
                      
                    </tr>
                </thead>
                <tbody>
       
       <?php 
       $i=1;

$sql = "SELECT s.SALARY_RECEIVED_DATE, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID ";
$result = mysqli_query($conn, $sql);
       while($row = mysqli_fetch_array($result)){
       ?>


<tr>
  <td style="color:#0c1211";><?php echo $i; ?></td> <?php $i=$i+1; ?>
  <td style="color:#0c1211";><?php echo $row['EMPLOYEE_NAME']; ?> </td>
  <td style="color:#0c1211";><?php echo $row['EMPLOYEE_MOBILE']; ?> </td>
  <td style="color:#0c1211";><?php echo $row['SALARY_RECEIVED_DATE']; ?> </td>
  <td style="color:#0c1211";><?php echo $row['NO_OF_DAYS_IN_MONTH']; ?> </td>
  <td style="color:#0c1211";><?php echo $row['NO_OF_DAYS_WORKED']; ?> </td>

  <td style="color:#0c1211";>

  <?php 
  echo $man = $row['ADDITIONAL_INFORMATION'];
  // echo gettype($man);
  $man =  str_replace('"',"", $man);
  $man =  str_replace('{',"", $man);
  $man =  str_replace('}',"", $man);
  $man = explode(',',$man); // 1,2,3
  echo"<br>".$size = sizeof($man);
  print_r($man);
  for ($x = 0; $x <= $size; $x++) {
  echo $man[$x];
  }
  ?>
  </td>  
</tr>

<?php
} 
?>
                </tbody>
            </table>
        </div>
               

</section>
</section>


</body>
</html>