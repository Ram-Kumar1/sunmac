<?php
session_start();
include 'db_connect.php';
  ?>
  <!DOCTYPE html>
  <head>
  <title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
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
 
  </head>
  <body>
  <?php include 'header.php'; ?>
  <!-- sidebar menu end-->

  <section id="main-content">
    <section class="wrapper">
      <div class="form-w3layouts">
          <!-- page start-->
          <!-- page start-->
          <div class="row">
              <div class="col-lg-12">
                  <section class="panel">
                      <header class="panel-heading">
                          EMPLOYEE REGISTRATION
                      </header>
                      <br>
                      
          
<?php
$sql = "SELECT * FROM employee_details where USER_NAME!=''";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
?>

  <div class="table-responsive">
        <table class="table">
    <thead>
      <tr>
        <th style="color:#0c1211";>#</th>
        <th style="color:#0c1211";>EMP&nbsp;ID</th>
        <th style="color:#0c1211";>EMP NAME </th>
        <th style="color:#0c1211";>MOBILE</th>
        <th style="color:#0c1211";>ALTERNATE_MOBILE</th>
        <th style="color:#0c1211";>DESIGNATION</th>
        <th style="color:#0c1211";>ADDRESS</th>
        <th style="color:#0c1211";>SALARY</th>
        <th style="color:#0c1211";>LOGIN TYPE</th>
        <th style="color:#0c1211";>USER&nbsp;NAME</th>
        <th style="color:#0c1211";>PASSWORD</th>
        <th style="color:#0c1211";>LOCATION</th>
        <th style="color:#0c1211";>UPDATE</th> 
        <th style="color:#0c1211";>DELETE</th> 

      </tr>
    </thead>
<?php 
$aa= 1;
while($row = mysqli_fetch_array($result)){
?>
    <tbody>
      <tr>
        <td style="color:#0c1211";><?php echo $aa; $aa++;?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_ID']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_NAME']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_MOBILE']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_ALTERNATE_MOBILE']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_BLOOD_GROUP']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_ADDRESS']?></td>
        <td style="color:#0c1211";><?php echo $row['SALARY']?></td>
        <td style="color:#0c1211";><?php echo $row['LOGIN_TYPE']?></td>
        <td style="color:#0c1211";><?php echo $row['USER_NAME']?></td>
        <td style="color:#0c1211";><?php echo $row['PASSWORD']?></td>
        <td style="color:#0c1211";><?php echo $row['CITY']?></td>
        <td style="color:#0c1211"; style="color:#0c1211";><a href="employee_update.php?EMPLOYEE_ID=<?php echo $row['EMPLOYEE_ID']; ?>"><?php $row['EMPLOYEE_ID']?><button type="button" class="btn btn-primary">Update</button></a></td>
        <td class="contact-delete">
          <form action=" " method="post">
            <input type="hidden" name="EMPLOYEE_ID" value="<?php echo $row['EMPLOYEE_ID']; ?>">
            <input type="submit" name="submit" value="Delete" class="btn btn-primary">
          </form>
        </td>
      </tr>
    </tbody>
<?php

}
?>

  </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
}
?>
                      </div>
                    </div>
                  </section>
              </div>
          </div>
          </div>
    </section>
  </section>

  </body>
  </html>






