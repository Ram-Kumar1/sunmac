<?php
session_start();
include 'db_connect.php';

if(isset($_POST['submit'])){

  $EMPLOYEE_ID= $_POST['EMPLOYEE_ID'];

  $delete = "DELETE FROM employee_details WHERE EMPLOYEE_ID = '$EMPLOYEE_ID'";
  mysqli_query($conn,$delete);
  ?>

  <script>
    alert("Data Deleted Successfully");
  </script>
<?php
}
?>
  <!DOCTYPE html>
  <head>
  <title>Employee Details</title>
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
  <style>
/* FOR TABLE FIXED HEADER */
.tableFixHead {
  overflow-y: auto;
  max-height: 400px;
}

.tableFixHead table {
  border-collapse: collapse;
  width: 100%;
}

.tableFixHead th,
.tableFixHead td {
  padding: 8px 16px;
}

.tableFixHead th {
  position: sticky;
  top: 0;
}
/* ENDS HERE */
</style>
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
                          EMPLOYEE DETAILS
                      </header>
                      <br>
                      
          
<?php
$sql = "SELECT * FROM employee_details";
$sno = 0;
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){ 
      
?>
  <div class="table-responsive" style="height:500px;overflow: scroll;">
        <table class="table tableFixHead">
    <thead>
      <tr>
        <th style="color:#0c1211";>S NO</th>
        <th style="color:#0c1211";>EMPLOYEE ID</th>
        <th style="color:#0c1211";>EMPLOYEE NAME </th>
        <th style="color:#0c1211";>EMPLOYEE MOBILE</th>
        <th style="color:#0c1211";>EMPLOYEE ALTERNATE_MOBILE</th>
        <th style="color:#0c1211";>EMPLOYEE Designation</th>
        <th style="color:#0c1211";>EMPLOYEE ADDRESS</th>
        <th style="color:#0c1211";>EMPLOYEE MAIL ID</th>
        <th style="color:#0c1211";>SALARY</th>
        <th style="color:#0c1211";>LOGIN TYPE</th>
        <th style="color:#0c1211";>USER NAME</th>
        <th style="color:#0c1211";>PASSWORD</th>
        <th style="color:#0c1211";>CITY</th>
        <th style="color:#0c1211";>UPDATE</th> 
        <th style="color:#0c1211";>DELETE</th> 
 
      </tr>
    </thead>
<?php 
while($row = mysqli_fetch_array($result)){
$sno++;
?>
    <tbody>
      <tr>

        <td style="color:#0c1211";><?php echo $sno; ?></td>
        <td style="color:#0c1211";><?php echo $row['EMP_IDENTIFY']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_NAME']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_MOBILE']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_ALTERNATE_MOBILE']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_BLOOD_GROUP']?></td>
        <td style="color:#0c1211";><?php echo $row['EMPLOYEE_ADDRESS']?></td>
        <td style="color:#0c1211";><?php echo $row['MAIL']?></td>
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






