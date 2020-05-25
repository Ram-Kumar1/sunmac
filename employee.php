  
<?php
session_start();
include 'db_connect.php';
 ?>
  <!DOCTYPE html>
  <head>
  <title>Add Employee</title>
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style type="text/css">
    
ul.ks-cboxtags {
    list-style: none;
    padding: 20px;
}
ul.ks-cboxtags li{
  display: inline;
}
ul.ks-cboxtags li label{
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid #262424;
    color: #262424;
    border-radius: 25px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

ul.ks-cboxtags li label {
    padding: 8px 12px;
    cursor: pointer;
}

ul.ks-cboxtags li label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: "\f067";
    transition: transform .3s ease-in-out;
}

ul.ks-cboxtags li input[type="checkbox"]:checked + label::before {
    content: "\f00c";
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

ul.ks-cboxtags li input[type="checkbox"]:checked + label {
    border: 2px solid #1bdbf8;
    background-color: #12bbd4;
    color: #fff;
    transition: all .2s;
}

ul.ks-cboxtags li input[type="checkbox"] {
  display: absolute;
}
ul.ks-cboxtags li input[type="checkbox"] {
  position: absolute;
  opacity: 0;
}
ul.ks-cboxtags li input[type="checkbox"]:focus + label {
  border: 2px solid #e9a1ff;
}
  </style>
  </head>

<script type="text/javascript">
  function validate() {
    debugger;
    let employeeName = document.getElementById('emp_name').value;
    let employeeAddress = document.getElementById('address').value;
    let employeeMobile = document.getElementById('mob_no').value;
    let alternateMobile = document.getElementById('alternate_mob_no').value;
    let mail = document.getElementById('mail').value;
    let city = document.getElementById('sel1').value;
    let salary = document.getElementById('salary').value;
    let loginSelectDiv = document.getElementById('loginSelect').value;
    let userNameDiv = document.getElementById('User_name').value;
    let passwordDiv = document.getElementById('Password').value;
    let emp_blood_group = document.getElementById('emp_blood_group').value;
    
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
    } else if(emp_blood_group == "") {
      alert('Designation is mandatory. Please fill it');
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

    //To check the login status
    if($("#checkboxOne").is(':checked')) {
      let loginSelect = $("#loginSelect").val();
      let userName = $("#User_name").val();
      let password = $("#Password").val();
      if(loginSelect == "" || userName == "" || password == "") {
        alert("Login Credentials are mandatory. \nKindly fill them!");
        return false;
      }
    }
     
$.ajax({
       type: 'post',
       url: 'employee_insert.php',
       data: {
          EMPLOYEE_NAME:employeeName,
          EMPLOYEE_MOBILE:employeeMobile,
          EMPLOYEE_ALTERNATE_MOBILE:alternateMobile,
          EMPLOYEE_BLOOD_GROUP:emp_blood_group,
          EMPLOYEE_MAIL:mail,
          EMPLOYEE_ADDRESS:employeeAddress,
          SALARY:salary,
          LOGIN_TYPE:loginSelectDiv,
          USER_NAME:userNameDiv,
          PASSWORD:passwordDiv,
          CITY:city,
       },
       success: function (response) {
       //window.location.reload();
       alert(response);
       if(response == "Data Are Inserted Successfully") {
          window.location.reload();
       }
       }
    });
debugger;
}

</script>
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
                          ADD EMPLOYEE DETAILS
                      </header>
                      <div class="panel-body">
                          <div class="position-center">
 
                                  <div class="form-group">
                                      <label for="emp_name">Employee Name *</label>
                                      <input type="text" class="form-control" id="emp_name" placeholder="Enter empname" name="EMPLOYEE_NAME">
                                  </div>
                                  <div class="form-group">
                                      <label for="mob_no">Employee Mobile *</label>
                                      <input type="number" class="form-control" id="mob_no" placeholder="Enter mobile number" name="EMPLOYEE_MOBILE">
                                  </div>
                                  <div class="form-group">
                                      <label for="employee alternat mobile">Employee Alternate Mobile</label>
                                      <input type="number" class="form-control" id="alternate_mob_no" placeholder="Enter mobile number" name="EMPLOYEE_ALTERNATE_MOBILE">
                                  </div>

                                <div class="form-group">
                                    <label for="employee blood group">Employee Designation *</label>
                                      <select type="text" class="form-control" id="emp_blood_group" name="EMPLOYEE_BLOOD_GROUP">
                                    <option value="">-- SELECT Designation --</option>
                                    <?php
                                    $selectCity = "SELECT DISTINCT designation FROM `employee_designation`";
                                      if($result = mysqli_query($conn, $selectCity)){
                                        if(mysqli_num_rows($result) > 0){ 
                                          while($row = mysqli_fetch_array($result)) {
                                    ?>
                                            <option value="<?php echo $row['designation']?>" ><?php echo $row['designation'] ?></option>
                                    <?php
                                          }
                                        }
                                      }
                                    ?>
                                  </select>
                                </div>

                                    <div class="form-group">
                                      <label for="mail">Employee Mail Id * </label>
                                      <input type="text" class="form-control" id="mail" placeholder="Enter Mail Id" name="EMPLOYEE_MAIL">
                                  </div>

                                    <div class="form-group">
                                      <label for="address">Employee Address *</label>
                                      <input type="text" class="form-control" id="address" placeholder="Enter Address" name="EMPLOYEE_ADDRESS">
                                  </div>
                                  <?php
                                  $selectCity = "SELECT DISTINCT CITY_NAME FROM `city`";
                                  ?>
                                  <div class="form-group">
                                    <label for="sel1">Location *</label>
                                    <select type="text" class="form-control" id="sel1" name="CITY">
                                      <option value="">-- SELECT Location --</option>
                                      <?php
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
                                  <div class="form-group">  
                                      <label for="salary">Salary *</label>
                                      <input type="number" class="form-control" id="salary" placeholder="Enter Salary" name="SALARY">
                                  </div>
                                  <div class="checkbox"  style="display: none;">
                                      <label>
                                        
<ul class="ks-cboxtags">
<li><input type="checkbox" checked id="checkboxOne" value="Rainbow Dash" onclick="addBox();"><label for="checkboxOne">Employee Login</label></li>
</ul>
                                      </label>
                                  </div>
                               
                                  <div class="form-group" id="loginSelectDiv">
                                    <label for="sel1">Login Type</label>
                                    <select class="form-control" id="loginSelect" name="LOGIN_TYPE">
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
                                  <div class="form-group" id="userNameDiv">
                                      <label for="username">User name</label>
                                      <input type="text" class="form-control" id="User_name" placeholder="Enter User name" name="USER_NAME">
                                  </div>
                                  <div class="form-group" id="passwordDiv">
                                      <label for="password">Password</label>
                                      <input type="password" class="form-control" id="Password" placeholder="Enter Password" name="PASSWORD">
                                  </div>
                                
                                <script>
                                  function addBox() {
                                      if (document.getElementById('checkboxOne').checked) {
                                          document.getElementById('userNameDiv').style.display = 'block';
                                          document.getElementById('passwordDiv').style.display = 'block';
                                          document.getElementById('loginSelectDiv').style.display = 'block';
                                      } else {
                                          document.getElementById('userNameDiv').style.display = 'none';
                                          document.getElementById('passwordDiv').style.display = 'none';
                                          document.getElementById('loginSelectDiv').style.display = 'none';
                                      }
                                  }

                                </script>
                          <button type="submit" class="btn btn-info" name="submit" onClick="return validate();">Submit</button>
                            
                          </div>
                        </div>
  
       




  <script type="text/javascript">
  function state(val)
  {
   $.ajax({
   type: 'post',
   url: 'fetch_data.php',
   data: {
    state:val
   },
   success: function (response) {
    document.getElementById("city").innerHTML=response; 
   }
   });
  }
  </script>

  <script type="text/javascript">
   $(document).ready(function(){
      $('.filterable .btn-filter').click(function(){
          var $panel = $(this).parents('.filterable'),
          $filters = $panel.find('.filters input'),
          $tbody = $panel.find('.table tbody');
          if ($filters.prop('disabled') == true) {
              $filters.prop('disabled', false);
              $filters.first().focus();
          } else {
              $filters.val('').prop('disabled', true);
              $tbody.find('.no-result').remove();
              $tbody.find('tr').show();
          }
      });

      $('.filterable .filters input').keyup(function(e){
          /* Ignore tab key */
          var code = e.keyCode || e.which;
          if (code == '9') return;
          /* Useful DOM data and selectors */
          var $input = $(this),
          inputContent = $input.val().toLowerCase(),
          $panel = $input.parents('.filterable'),
          column = $panel.find('.filters th').index($input.parents('th')),
          $table = $panel.find('.table'),
          $rows = $table.find('tbody tr');
          /* Dirtiest filter function ever ;) */
          var $filteredRows = $rows.filter(function(){
              var value = $(this).find('td').eq(column).text().toLowerCase();
              return value.indexOf(inputContent) === -1;
          });
          /* Clean previous no-result if exist */
          $table.find('tbody .no-result').remove();
          /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
          $rows.show();
          $filteredRows.hide();
          /* Prepend no-result row if all rows are filtered */
          if ($filteredRows.length === $rows.length) {
              $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
          }
      });
  });
  </script>
  </section>
</section>
</section>

  </body>
  </html>






