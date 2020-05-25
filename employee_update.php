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
         $EMPLOYEE_MOBILE_A=$_POST['EMPLOYEE_MOBILE_A'];
         $EMPLOYEE_BLOOD_GROUP=$_POST['EMPLOYEE_BLOOD_GROUP'];
         $EMPLOYEE_ADDRESS=$_POST['EMPLOYEE_ADDRESS'];
         $EMPLOYEE_MAIL=$_POST['EMPLOYEE_MAIL'];

        $SALARY=$_POST['SALARY'];
        $LOGIN_TYPE=$_POST['LOGIN_TYPE'];
        $USER_NAME=$_POST['USER_NAME'];
        $PASSWORD=$_POST['PASSWORD'];
        $CITY=$_POST['CITY'];

$update ="UPDATE `employee_details` SET `EMPLOYEE_NAME`='$EMPLOYEE_NAME',`MAIL`='$EMPLOYEE_MAIL',`EMPLOYEE_MOBILE`='$EMPLOYEE_MOBILE',`EMPLOYEE_ALTERNATE_MOBILE` = '$EMPLOYEE_MOBILE_A', `EMPLOYEE_BLOOD_GROUP`='$EMPLOYEE_BLOOD_GROUP',`EMPLOYEE_ADDRESS`='$EMPLOYEE_ADDRESS',`SALARY`=$SALARY,`LOGIN_TYPE`='$LOGIN_TYPE',`USER_NAME`='$USER_NAME',`PASSWORD`='$PASSWORD',`CITY`='$CITY' WHERE EMPLOYEE_ID = $id3";
             if (mysqli_query($conn,$update)) {
                  ?>
          <script type="text/javascript">
          alert('Data Updated Successfully');
           window.location.href='employee_view.php';
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


    
    <form action="" method="POST" onsubmit="return validate(this)">
        <div class="form-group">
            <label for="emp_id">Employee Id</label>
            <input type="text" class="form-control" id="empId" placeholder="Enter empid" name="EMPLOYEEID" value="<?php echo $EMPLOYEEID = $row['EMP_IDENTIFY']?>" disabled>
        </div>
        <div class="form-group">
            <label for="emp_id">Refrence Id</label>
            <input type="number" class="form-control" id="emp_id" placeholder="Enter empid" name="EMPLOYEE_ID" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_ID']?>" required disabled>
        </div>
        <div class="form-group">
            <label for="emp_name">Employee Name *</label>
            <input type="text" class="form-control" id="emp_name" placeholder="Enter empname" name="EMPLOYEE_NAME" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_NAME']?>">
        </div>
        <div class="form-group">
            <label for="emp_mobile">Employee Mobile *</label>
            <input type="text" class="form-control" id="mob_no" placeholder="Enter empmobilenumber" name="EMPLOYEE_MOBILE" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_MOBILE']?>">
        </div>
        <div class="form-group">
            <label for="emp_alternate_mobile">Employee Alternate Mobile</label>
            <input type="text" class="form-control" id="alternate_mob_no" placeholder="Enter empnumber" name="EMPLOYEE_MOBILE_A" value="<?php echo $EMPLOYEE_ID = $row['EMPLOYEE_ALTERNATE_MOBILE']?>">
        </div>

        <div class="form-group">
            <label for="emp_name">Employee Mail *</label>
            <input type="text" class="form-control" id="mail" placeholder="Enter Mail" name="EMPLOYEE_MAIL" value="<?php echo $EMPLOYEE_ID = $row['MAIL']?>">
        </div>
  

        <div class="form-group">
            <label for="emp_bloodgroup">Employee Designation * (<?php echo $designations = $row['EMPLOYEE_BLOOD_GROUP']?>)</label>
            <select type="text" class="form-control" id="emp_blood_group"  name="EMPLOYEE_BLOOD_GROUP">
             <option value="">-- SELECT Designation --</option>
            <?php
            $selectCity = "SELECT DISTINCT designation FROM `employee_designation`";
              if($result = mysqli_query($conn, $selectCity)){
                if(mysqli_num_rows($result) > 0){ 
                  while($rows = mysqli_fetch_array($result)) {
            ?>
                    <option value="<?php echo $rows['designation']?>" ><?php echo $rows['designation'] ?></option>
            <?php
                  }
                }
              }
            ?>
          </select>

        </div>

        <div class="form-group">
            <label for="emp_address">Employee Address *</label>
            <input type="text" class="form-control" id="address" placeholder="Enter empaddress" name="EMPLOYEE_ADDRESS" value="<?php echo $row['EMPLOYEE_ADDRESS']?>" >
        </div>

        <div class="form-group">
            <label for="emp_salary">Salary *</label>
            <input type="number" class="form-control" id="salary" placeholder="Enter empnumber" name="SALARY" value="<?php echo $row['SALARY']?>">
        </div>
        <div class="form-group">
          <label for="sel1">Login Type (<?php echo $loginType = $row['LOGIN_TYPE']?>)</label>
          <select class="form-control" id="loginType" name="LOGIN_TYPE">
          <option value="">-- SELECT LOGIN TYPE --</option>
          <option value="admin">Admin</option>
          <option value="generalManager">General Manager</option>
          <option value="HR">HR</option>
          <option value="followUp">Follow up</option>
          <option value="salesManager">Sales</option>
          <option value="accountsManager">Accounts</option>
          <option value="purchaseManager">Purchase</option>
          <option value="productionManager">Production</option>
          <option value="marketingManager">Marketing</option>
          <option value="employee">Employee</option>
          </select>
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
            <label for="city">Location * ( <?php echo $citys = $row['CITY']?> )</label>
            <select type="text" class="form-control" id="city" name="CITY">
              <option value="">-- SELECT Location --</option>
              <?php
                  $selectCity = "SELECT DISTINCT CITY_NAME FROM `city`";
                if($result = mysqli_query($conn, $selectCity)){
                  if(mysqli_num_rows($result) > 0){ 
                    while($row = mysqli_fetch_array($result)) {
              ?>
                      <option value="<?php echo $row['CITY_NAME']?>" ><?php echo $row['CITY_NAME'] ?></option>
              <?php
                    }
                  }
                }
              ?>
            </select>
        </div>
        <br><br>
          <button type="submit" name="submit" class="btn btn-default" onClick="return validate();">Update</button>  
    </form>
                        </div>
                      </div>

  
                  </section>
              </div>
          </div>
          </div>
    </section>
  </section>

<script type="text/javascript">

$(document).ready(function() {
    document.getElementById('loginType').value = "<?php echo $loginType ?>";
    document.getElementById('city').value = "<?php echo $citys ?>";
    document.getElementById('emp_blood_group').value = "<?php echo $designations; ?>";
});

  function validate() {
    debugger;
    let employeeName = document.getElementById('emp_name').value;
    let employeeAddress = document.getElementById('address').value;
    let employeeMobile = document.getElementById('mob_no').value;
    let alternateMobile = document.getElementById('alternate_mob_no').value;
    let mail = document.getElementById('mail').value;
    let booodGroup = document.getElementById('emp_blood_group').value;
    let city = document.getElementById('city').value;
    let salary = document.getElementById('salary').value;
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(mail) == false) 
        {
            alert('Invalid Email Address');
            return false;
        }

    if(employeeName == "") {
      alert('Name is mandatory. Please fill it');
      return false;
    } else if(employeeAddress == "") {
      alert('Address is mandatory. Please fill it');
      return false;
    } else if(employeeMobile == "") {
      alert('Mobile Number is mandatory. Please fill it');
      return false;
    } else if(city == "") {
      alert('City is mandatory. Please fill it');
      return false;
    } else if(salary == "") {
      alert('Salary is mandatory. Please fill it');
      return false;
    }  else if(mail == "") {
      alert('Mail is mandatory. Please fill it');
      return false;
    } else if(alternateMobile != "") {
      if(alternateMobile.length != 11) {
        alert('11 numbers must be there for Alternate Mobile Number');
        return false;
      }
    } else if(employeeMobile.length !=11) {
      alert('11 numbers must be there for Mobile Number');
        return false;
    }
    return true;
  }
</script>

  </body>
  </html>

