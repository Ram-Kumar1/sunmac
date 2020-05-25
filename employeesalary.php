<?php
session_start();
include 'db_connect.php';
?>
<script type="text/javascript">
  var description_add = [];
</script> 
<?php

$sql = "SELECT * FROM `salary_description` where statuses = 'ADDITION' ";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  description_add.push('<?php echo $row['description']; ?>');
</script>
<?php 
}
?>
<script type="text/javascript">
  var description_rem = [];
</script> 
<?php

$sql = "SELECT * FROM `salary_description` where statuses = 'DETUCTION' ";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  description_rem.push('<?php echo $row['description']; ?>');
</script>
<?php 
}
?>

  <!DOCTYPE html>
  <head>
  <title>SUNMAC</title>
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
  
  </head>

<style type="text/css">
  .w-10 {
    min-width: 9em;
  }

  .w-5 {
    max-width: 5.5em;
  }

  .ml-1 {
    margin-left: 1em;
  }
</style>

  <body>

  <?php include 'header.php'; ?>

  <!-- sidebar menu end-->

  <script type="text/javascript">

var isDelete = "no";
var add_value = 0;
var remove_value = 0;

function checkForDuplicate(selectObj) {
  debugger;
  let id = $(selectObj)[0].id;
  let val = document.getElementById($(selectObj)[0].id).value;
  let selObjs = $('select[name="addSelect"]');
  for(let i=0; i<selObjs.length; i++) {
    let selId = $(selObjs)[i].id;
    if(id != selId) {
      let selObjVal = document.getElementById($(selObjs)[i].id).value;
      if(selObjVal == val) {
        alert('Value already choosen');
        document.getElementById($(selectObj)[0].id).value = "";
      }
    }
  }

}

function checkForDuplicate_rem(selectObj) {
  debugger;
  let id = $(selectObj)[0].id;
  let val = document.getElementById($(selectObj)[0].id).value;
  let selObjs = $('select[name="remSelect"]');
  for(let i=0; i<selObjs.length; i++) {
    let selId = $(selObjs)[i].id;
    if(id != selId) {
      let selObjVal = document.getElementById($(selObjs)[i].id).value;
      if(selObjVal == val) {
        alert('Value already choosen');
        document.getElementById($(selectObj)[0].id).value = "";
      }
    }
  }

}


  function dataChange(input, state) {
    debugger;
    let id = $(input)[0].id;
    if(id.includes("Rem")) {
      let res = id.split("-")[1];
      let selectVal = $('#desRem-'+res).val();
      if(selectVal == "None") {
        alert('Please select the description before entring the amount');
        input.value  = "";
        return false;
      }
    } else {
      let res = id.split("-")[1];
      let selectVal = $('#desAdd-'+res).val();
      if(selectVal == "None") {
        alert('Please select the description before entring the amount');
        input.value  = "";
        return false;
      }
    }

    let inputValue = 0;
    try {
      inputValue = parseInt(input.value);
    } catch(err) { console.log('Error While Parsing ', err); }
    
    try {
      if(state == 'add') {
        add_value += inputValue;
      } else {
        remove_value += inputValue;
      }
    } catch(err) {}
  }

 function getDaysInMonth(input) {
  $(input).attr("disabled", true);
  let val = input.value; 
  let emplId = document.getElementById("employeeNameSelect").value;
  let month = val.split("-")[1];
  let year = val.split("-")[0];
  let days = new Date(parseInt(year), parseInt(month), 0).getDate();
  $("#workingDays").val(days);

  let month_last = document.getElementById("month").value;

debugger;
   $.ajax({
       type: 'post',
       url: 'saveEmployeeSalary.php',
       data: {
          emplId:emplId,
          val: month_last,
       },
       success: function (response) {
        console.log(response);
        debugger;
        if(response == 'yes'){
        var r = confirm("Salary had been already registered for this Employee. Do you need to Re-insert it ?");
        if (r == true) {
          isDelete = "yes";
        } else {
          isDelete = "no";
          location.reload();
        }
        }
       }
    });

 }

function calc(){
  let month = $("#month").val();
    if(month == "") {
      alert("'Enter Month' is mandatory!");
      return false;
    }
    let daysWorked = $("#daysWorked").val();
    if(daysWorked == "") {
      alert("'No Of Days Worked' is mandatory!");
      return false;
    }
    let addSalaryHiddenInput = $("#addSalaryHiddenInput").val();
    let removeSalaryHiddenInput = $("#removeSalaryHiddenInput").val();
    for(let i=1; i<=parseInt(addSalaryHiddenInput); i++) {
      let desc = $("#desAdd-"+i).val();
      if(desc != undefined && desc == "None") {
        alert("Kindly enter all the ADDITION description value!");
        return false;
      }
      let addVal = $("#salAdd-"+i).val();
      if(addVal != undefined && addVal == "") {
        alert("Kindly enter all the ADDITION value!");
        return false;
      }
    }

    for(let i=1; i<=parseInt(removeSalaryHiddenInput); i++) {
      let descRem = $("#desRem-"+i).val();
      if(descRem != undefined && descRem == "None") {
        alert("Kindly enter all the DETUCTION description value!");
        return false;
      }
      let remVal = $("#salRem-"+i).val();
      if(remVal != undefined && remVal == "") {
        alert("Kindly enter all the DETUCTION value!");
        return false;
      }
    }
    
    $("#addSalary :input").attr("disabled", true);
    $("#removeSalary :input").attr("disabled", true);
  $("#save").attr("disabled", true);
  $("#submit").attr("disabled", false);
  let totalSalaryInput = document.getElementById("totalSalary");
  totalSalaryInput.value = parseInt(totalSalaryInput.value) + (add_value - remove_value);

  add_value = 0;
  remove_value = 0;

}


  function createAddTextBox() {
     
    let hiddenValueInput = document.getElementById('addSalaryHiddenInput');
    let hiddenVal = 0;
    try {
      hiddenVal = parseInt(hiddenValueInput.value);
      hiddenVal++;
      hiddenValueInput.value = hiddenVal;

    } catch(err) { }

   var div = document.getElementById('addSalary');
  
   let colDiv = document.createElement('div');
   colDiv.className = 'col-sm-4';
   let formGroupDiv = document.createElement('div');
   formGroupDiv.className = 'form-group';
   let label = document.createElement('label');
   label.innerHTML = "&nbsp;";

    var option = "";
        option += "<option value='None'>Select None</option>";
    for(var val in description_add) {
        option += "<option>"+description_add[val]+"</option>";
    }

   let input = document.createElement('select');
   input.className = "form-control w-10"; 
   //input.className = "w-10";
   input.setAttribute("id", "desAdd-"+hiddenVal);
   input.setAttribute("name", "addSelect");
   input.setAttribute("onchange", "checkForDuplicate(this);");
   formGroupDiv.append(label);
   formGroupDiv.append(input);
   colDiv.append(formGroupDiv);

   
   let colDivSal = document.createElement('div');
   colDivSal.className = 'col-sm-4 ml-1';
   let formGroupDivSal = document.createElement('div');
   formGroupDivSal.className = 'form-group';
   let labelSal = document.createElement('label');
   labelSal.innerHTML = "&nbsp;";

   let inputSal = document.createElement('input');
   inputSal.type = "text";
   inputSal.className = "form-control w-5";
   //inputSal.className = "w-5";
   inputSal.placeholder = "AMOUNT";
   inputSal.setAttribute("id", "salAdd-"+hiddenVal);
   inputSal.setAttribute("onchange", "dataChange(this, 'add');");

   formGroupDivSal.append(labelSal);
   formGroupDivSal.append(inputSal);
   colDivSal.append(formGroupDivSal);


   let colDivBtn = document.createElement('div');
   colDivBtn.className = 'col-sm-2';
   let formGroupDivBtn = document.createElement('div');
   formGroupDivBtn.className = 'form-group';
   let labelBtn = document.createElement('label');
   labelBtn.innerHTML = "&nbsp;";
   
   let inputDelete = document.createElement('button');
   inputDelete.type = "submit";
   inputDelete.className = "btn btn-primary";
   inputDelete.setAttribute("id", "deleteAdd-"+hiddenVal);
   inputDelete.setAttribute("onclick", "deleteRow(this, 'add');"); 


   let input_i = document.createElement('i');
   input_i.className = "material-icons";
   input_i.innerHTML = "delete_forever";
   inputDelete.append(input_i);

   formGroupDivBtn.append(labelBtn);
   formGroupDivBtn.append(inputDelete);
   colDivBtn.append(formGroupDivBtn);

   div.append(colDiv);
   div.append(colDivSal);
   div.append(colDivBtn);
  
    $('#desAdd-'+hiddenVal).append(option);
  }



  function createRemoveTextBox() {
    let hiddenValueInput = document.getElementById('removeSalaryHiddenInput');
    let hiddenVal = 0;
    try {
      hiddenVal = parseInt(hiddenValueInput.value);
      hiddenVal++;
      hiddenValueInput.value = hiddenVal;

    } catch(err) { }

   var div = document.getElementById('removeSalary');
  
   let colDiv = document.createElement('div');
   colDiv.className = 'col-sm-4';
   let formGroupDiv = document.createElement('div');
   formGroupDiv.className = 'form-group';
   let label = document.createElement('label');
   label.innerHTML = "&nbsp;";


    var option = "";
        option += "<option value='None'>Select None</option>";
    for(var val in description_rem) {
        option += "<option>"+description_rem[val]+"</option>";
    }

   let input = document.createElement('select');
  
   input.className = "form-control w-10";
   //input.className = "w-10";
   input.setAttribute("id", "desRem-"+hiddenVal);
   input.setAttribute("name", "remSelect");
   input.setAttribute("onchange", "checkForDuplicate_rem(this);");

   formGroupDiv.append(label);
   formGroupDiv.append(input);
   colDiv.append(formGroupDiv);


   let colDivSal = document.createElement('div');
   colDivSal.className = 'col-sm-4 ml-1';
   let formGroupDivSal = document.createElement('div');
   formGroupDivSal.className = 'form-group';
   let labelSal = document.createElement('label');
   labelSal.innerHTML = "&nbsp;";

   let inputSal = document.createElement('input');
   inputSal.type = "text";
   inputSal.className = "form-control w-5";
   inputSal.placeholder = "AMOUNT";
   inputSal.setAttribute("id", "salRem-"+hiddenVal);
   inputSal.setAttribute("onchange", "dataChange(this, 'minus');");

  formGroupDivSal.append(labelSal);
   formGroupDivSal.append(inputSal);
   colDivSal.append(formGroupDivSal);



   let colDivBtn = document.createElement('div');
   colDivBtn.className = 'col-sm-2';
   let formGroupDivBtn = document.createElement('div');
   formGroupDivBtn.className = 'form-group';
   let labelBtn = document.createElement('label');
   labelBtn.innerHTML = "&nbsp;";
   
   let inputDelete = document.createElement('button');
   inputDelete.type = "submit";
   inputDelete.className = "btn btn-primary";
   inputDelete.setAttribute("id", "deleteRemove-"+hiddenVal);
   inputDelete.setAttribute("onclick", "deleteRow(this, 'minus');");


   let input_i = document.createElement('i');
   input_i.className = "material-icons";
   input_i.innerHTML = "delete_forever";
   inputDelete.append(input_i);


   formGroupDivBtn.append(labelBtn);
   formGroupDivBtn.append(inputDelete);
   colDivBtn.append(formGroupDivBtn);


   div.append(colDiv);
   div.append(colDivSal);
   div.append(colDivBtn);


    $('#desRem-'+hiddenVal).append(option);

}

function deleteRow(obj , choice){
  if(choice == 'add') {
    let id = obj.id;
    id = id.split("-")[1];
    let val = $("#salAdd-"+id).val();
    try {
      val = parseInt(val);
      val = isNaN(val) ? 0 : val;
      add_value = add_value - val;
    } catch(err) {
      console.log(err);
    }
    $("#salAdd-"+id).parent().parent().remove();
    $("#desAdd-"+id).parent().parent().remove();
    $(obj).parent().parent().remove();
  } else {
    let id = obj.id;
    id = id.split("-")[1];
    let val = $("#salRem-"+id).val();
    try {
      val = parseInt(val);
      val = isNaN(val) ? 0 : val;
      remove_value = remove_value - val;
    } catch(err) {
      console.log(err);
    }
    $("#salRem-"+id).parent().parent().remove();
    $("#desRem-"+id).parent().parent().remove();
    $(obj).parent().parent().remove();
  }
}

</script>
<section id="main-content">
  	<section class="wrapper">
         <div class="form-w3layouts">
          <!-- page start-->
          <!-- page start-->
          <div class="row">
              <div class="col-lg-12">
                  <section class="panel">
                      <header class="panel-heading">
                          EMPLOYEE SALARY
                          <A HREF="employeesalary.php"><button style="float: right;margin-top: 12px" type="button" class="btn btn-danger">Reload</button></A>
                      </header>
                      <div class="panel-body">
                          <div class="position-center">
                                  <div class="form-group">
                                      <label for="emp_name">Employee Name</label>
                                      <select class="form-control" id="employeeNameSelect" onchange="salry(this.value);" name="EMPLOYEE_ID">
                                     <option value="">-- SELECT EMPLOYEE --</option>
                              <?php
                                $sqlSelect = "SELECT EMPLOYEE_ID, EMP_IDENTIFY, EMPLOYEE_NAME FROM `employee_details` order by EMP_IDENTIFY ";
                                $result = mysqli_query($conn, $sqlSelect);
                                if(mysqli_num_rows($result) > 0){ 
                                 while($row = mysqli_fetch_array($result)) {
                              ?>
      
                              <option value="<?php echo $row['EMPLOYEE_ID']?>" ><?php echo $row['EMP_IDENTIFY']."-". $row['EMPLOYEE_NAME'] ?></option>
                              <?php
                                }
                                }
      
                                   ?>
                              </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="mob_no">Mobile</label>
                                      <input disabled type="text" class="form-control" id="mobileNumber">
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">Basic Salary:</label>
                                    <input disabled type="text" class="form-control" id="salary" name="SALARY">
                                  </div>

    <div class="form-group">
      <label for="pwd">Enter Month:</label>
      <input type="month" class="form-control" id="month" name="month" onchange="getDaysInMonth(this);">
    </div>

    <div class="form-group">
      <label for="pwd">Working days of month:</label>
      <input type="text" class="form-control" id="workingDays" name="NO_OF_DAYS_IN_MONTH" readonly="true" >
    </div>

    <div class="form-group">
      <label for="pwd">No Of Days Worked:</label>
      <input type="text" class="form-control" id="daysWorked" name="NO_OF_DAYS_WORKED" onchange="calculateTotalSalary()">
    </div>
    

    <div class="form-group">
      <label for="pwd">Leave Taken:</label>
        <input disabled type="text" class="form-control" id="leave" name="leave" value="0">
    </div>
    
    <div class="form-group">
      <label for="pwd">Per day salary:</label>
        <input disabled type="text" class="form-control" id="per_day" name="per_day" value="0">
    </div>

    <div class="form-group">
      <label for="pwd">Salary:</label>
        <input type="text" class="form-control" id="calcSalary" name="calcSalary" value="0" disabled="true">
    </div>

    <div class="form-group" id="myDIV" >
      <label for="pwd">Total Salary Given:</label>
        <input type="text" class="form-control" id="totalSalary" name="totalSalary" value="0" disabled="true">
    </div>
    <input type="hidden" class="form-control" id="addSalaryHiddenInput" value="0">
    <input type="hidden" class="form-control" id="removeSalaryHiddenInput" value="0">
    <div class="row">
      <div class = "col-sm-6">
          <div class="row" id="addSalary">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="pwd"></label>
                <button type="button" class="btn btn-info btn-sm" id="btn-create" onclick="createAddTextBox()" style="margin: 0 auto; display:block;" >
                  ADDITION
                </button>
              </div>
            </div>
        </div>
      </div>

      <div class = "col-sm-6">
        <div class="row" id="removeSalary">
            <div class="col-csm-12">
              <div class="form-group">
                <label for="pwd"></label>
                <button type="button" class="btn btn-info btn-sm" id="btn-create" onclick="createRemoveTextBox()" style="margin: 0 auto; display:block;" >
                  DETUCTION
                </button>
              </div>
            </div>
        </div>
    </div>

<div class = "col-sm-12">
  <center>
  <button type="submit" class="btn btn-info" id="save" onclick="calc()" >Save</button>
<br><br>
  <button type="submit" class="btn btn-info"  onclick="saveData()" name="submit" id="submit" disabled="true">Submit</button>
  </center>
</div>

</div>
</div>
<script type="text/javascript">

$('#save').on("click",function(){
      $(window).scrollTop(30);
});



  function saveData() {
     
    let employeeId = document.getElementById("employeeNameSelect").value;
    let workingDays = document.getElementById("workingDays").value;
    let daysWorked = document.getElementById("daysWorked").value;
    let salary = document.getElementById("salary").value;
    let salaryGiven = document.getElementById("totalSalary").value;
    let leave = document.getElementById("leave").value;
    let month = document.getElementById("month").value;
    let salaryBasic = document.getElementById("calcSalary").value;
    

    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];;
    var date = new Date();

    let monthYear = months[date.getMonth()] + ' ' + date.getFullYear();
    let salaryReceivedDate = new Date().toISOString().slice(0, 10); // YYYY-MM-DD

    let additionalSalary = [];
    let additionalDesc = [];
    let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
    let removeSalary = [];
    let removeDesc = [];
    let removeSalaryHiddenInput = parseInt(document.getElementById("removeSalaryHiddenInput").value);
    if(addSalaryHiddenInput > 0){
      let inc = 0;
      for(i=0; i<addSalaryHiddenInput; i++) {
        let val = $("#salAdd-"+(i+1)).val();
        if(val) {
          additionalSalary[inc] = val;
          additionalDesc[inc] = document.getElementById("desAdd-"+(i+1)).value;
          inc = inc + 1;
        }
      }
    }
    
    if(removeSalaryHiddenInput > 0){
      let dec = 0;
       for(i=0; i<removeSalaryHiddenInput; i++) {
        let val = $("#salRem-"+(i+1)).val();
        if(val) {
          removeSalary[dec] = val;
          removeDesc[dec] = document.getElementById("desRem-"+(i+1)).value;
          dec = dec + 1; 
        }
      } 
    }


    $.ajax({
       type: 'post',
       url: 'saveEmployeeSalary.php',
       
       data: {
          employeeId:employeeId,
          workingDays: workingDays,
          daysWorked: daysWorked,
          salary:salary,
          salaryBasic:salaryBasic,
          salaryGiven:salaryGiven,
          leave:leave,
          month:month,
          monthYear:monthYear,
          salaryReceivedDate: salaryReceivedDate,
          additionalSalary:additionalSalary.toString(),
          additionalDesc:additionalDesc.toString(),
          removeSalary:removeSalary.toString(),
          removeDesc:removeDesc.toString(),
          isDelete: isDelete

       },
       success: function (response) {
        console.log(response);
        
        response = JSON.parse(response);
        alert("Salary Inserted Successfully");
        window.location = "employeesalary.php";
       }
    });

  }

  function salry(val) {
    $("#employeeNameSelect").attr("disabled", true);
    $.ajax({
       type: 'post',
       url: 'salary.php',
       data: {
       employeeId:val
       },
       success: function (response) {
        console.log(response);
        response = JSON.parse(response);
        document.getElementById("mobileNumber").value = response.mobile ? response.mobile : "";
        document.getElementById("salary").value = response.salary ? response.salary : "";
       }
    });
  }

  function calculateTotalSalary() {
 debugger;

    try {
      let salary = parseInt(document.getElementById("salary").value);
      let totalWorkingDays = parseInt(document.getElementById("workingDays").value);
      let daysWorked = parseFloat(document.getElementById("daysWorked").value);
      if(totalWorkingDays < daysWorked){
        alert("No Of Days Worked is high");
        return false;
      }

      let salaryPerDay = salary / totalWorkingDays;

      let totalSalary =  parseInt(salaryPerDay * daysWorked);
      document.getElementById("calcSalary").value = totalSalary;
      document.getElementById("per_day").value = parseInt(salaryPerDay) == NaN ? 0 : parseInt(salaryPerDay);
      document.getElementById("totalSalary").value = totalSalary;
      document.getElementById("leave").value = totalWorkingDays - daysWorked;
    } catch(err) { console.log(err)}
    
  }
</script>
  
</section>
</html>
</body>






