<?php
session_start();
include 'db_connect.php';
if(isset($_GET['EMPLOYEE_ID']) & !empty($_GET['EMPLOYEE_ID'])){
        
            $id3 = $_GET['EMPLOYEE_ID'];  

          
             $show=mysqli_query($conn,"select * from employee_details where EMPLOYEE_ID = '$id3' ");
                 $row=mysqli_fetch_array($show);
                 
           }
if(isset($_POST['submit'])){

        $EMPLOYEE_NAME=$_POST['EMPLOYEE_NAME'];
        $EMPLOYEE_MOBILE=$_POST['EMPLOYEE_MOBILE'];
        $EMPLOYEE_ALTERNATE_MOBILE=$_POST['EMPLOYEE_ALTERNATE_MOBILE'];
        $EMPLOYEE_BLOOD_GROUP=$_POST['EMPLOYEE_BLOOD_GROUP'];
        $EMPLOYEE_ADDRESS=$_POST['EMPLOYEE_ADDRESS'];
        $SALARY=$_POST['SALARY'];
        $LOGIN_TYPE=$_POST['LOGIN_TYPE'];
        $USER_NAME=$_POST['USER_NAME'];
        $PASSWORD=$_POST['PASSWORD'];
        $CITY=$_POST['CITY'];

           $update ="UPDATE `employee_details` SET `EMPLOYEE_NAME`='$EMPLOYEE_NAME',`EMPLOYEE_MOBILE`=$EMPLOYEE_MOBILE,`EMPLOYEE_ALTERNATE_MOBILE`=$EMPLOYEE_ALTERNATE_MOBILE,`EMPLOYEE_BLOOD_GROUP`='$EMPLOYEE_BLOOD_GROUP',`EMPLOYEE_ADDRESS`='$EMPLOYEE_ADDRESS',`SALARY`=$SALARY,`LOGIN_TYPE`='$LOGIN_TYPE',`USER_NAME`='$USER_NAME',`PASSWORD`='$PASSWORD',`CITY`='$CITY' WHERE EMPLOYEE_ID = $id3";
             if (mysqli_query($conn,$update)) {
                  ?>
          <script type="text/javascript">
          alert('Data Updated Successfully');
          window.location.href='employee_login_view.php';
          </script>
          
          <?php
              } else {
                 echo "Error: " . $update . "" . mysqli_error($conn);
              }
           }
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
                          EMPLOYEE UPDATE
                      </header>
                      <div class="panel-body">
                          <div class="position-center">


    
    <form action="" method="POST">
        <div class="form-group">
            <label for="emp_id">Employee Id</label>
            <input type="number" class="form-control" id="emp_id" placeholder="Enter empid" name="EMPLOYEE_ID" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_ID']?>" required disabled>
        </div>
        <div class="form-group">
            <label for="emp_name">Employee Name</label>
            <input type="text" class="form-control" id="emp_name" placeholder="Enter empname" name="EMPLOYEE_NAME" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_NAME']?>">
        </div>
        <div class="form-group">
            <label for="emp_mobile">Employee Mobile</label>
            <input type="number" class="form-control" id="emp_mobile" placeholder="Enter empmobilenumber" name="EMPLOYEE_MOBILE" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_MOBILE']?>">
        </div>
        <div class="form-group">
            <label for="emp_alternate_mobile">Employee Alternate Mobile</label>
            <input type="number" class="form-control" id="emp_alternate_mobile" placeholder="Enter empnumber" name="EMPLOYEE_ALTERNATE_MOBILE" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_ALTERNATE_MOBILE']?>">
        </div>
        <div class="form-group">
            <label for="emp_bloodgroup">Employee Blood Group</label>
            <input type="text" class="form-control" id="emp_blood_group" placeholder="Enter emp Blood Group" name="EMPLOYEE_BLOOD_GROUP" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_BLOOD_GROUP']?>">
        </div>
        <div class="form-group">
            <label for="emp_address">Employee Address</label>
            <input type="text" class="form-control" id="emp_address" placeholder="Enter empaddress" name="EMPLOYEE_ADDRESS" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_ADDRESS']?>">
        </div>
        <div class="form-group">
            <label for="emp_salary">Salary</label>
            <input type="number" class="form-control" id="emp_number" placeholder="Enter empnumber" name="SALARY" value="<?php echo $EMPLOYEE_ID = $row['SALARY']?>">
        </div>
        <div class="form-group">
            <label for="login type">Login Type</label>
            <input type="text" class="form-control" id="login_type" placeholder="Enter logintype" name="LOGIN_TYPE" value="<?php echo $EMPLOYEE_ID = $row['LOGIN_TYPE']?>">
        </div>
        <div class="form-group">
            <label for="username">User Name</label>
            <input type="text" class="form-control" id="user_name" placeholder="Enter username" name="USER_NAME" value="<?php echo $EMPLOYEE_ID = $row['USER_NAME']?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" id="password" placeholder="Enter pssword" name="PASSWORD" value="<?php echo $EMPLOYEE_ID = $row['PASSWORD']?>">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" placeholder="Enter city" name="CITY" value="<?php echo $EMPLOYEE_ID = $row['CITY']?>">
        </div>
        <br><br>
          <button type="submit" name="submit" class="btn btn-default">Update</button>  
    </form>
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

