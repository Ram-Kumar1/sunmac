<?php
session_start();
include 'db_connect.php';
 
 
 $name=@$_POST['emp_Roll'];
 $date=@$_POST['from_date'];


 $sql1 = "SELECT s.SALARY_RECEIVED_DATE,s.SALARY_GIVEN, s.salaryBasic,s.LEAVE_TAKEN, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY, d.EMP_IDENTIFY FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID order by s.SALARY_RECEIVED_DATE desc ";


 if(isset($_POST['from_to_date'])){  
         $month= $_POST['from_date']; // 2019-02 
         $_SESSION['from_to_date'] = $month; 
         $month = $month . "-01";   
         
          $explodedate= explode('-',$date);

         switch ($explodedate[1]) {
    case "01":
        $dataSwitch = "<b> Janury - ".$explodedate[0]."</b>" ;
        break;
    case "02":
        $dataSwitch = "<b> February - ".$explodedate[0]."</b>" ;
        break;
    case "03":
        $dataSwitch = "<b> March - ".$explodedate[0]."</b>" ;
        break;
    case "04":
        $dataSwitch = "<b> April - ".$explodedate[0]."</b>" ;
        break; 
    case "05":
        $dataSwitch = "<b> May - ".$explodedate[0]."</b>" ;
        break;
    case "06":
        $dataSwitch = "<b> June - ".$explodedate[0]."</b>" ;
        break;
    case "07":
        $dataSwitch = "<b> Jully - ".$explodedate[0]."</b>" ;
        break;  
     case "08":
        $dataSwitch = "<b> Augest - ".$explodedate[0]."</b>" ;
        break;
    case "09":
        $dataSwitch = "<b> Septemper - ".$explodedate[0]."</b>" ;
        break;
    case "10":
        $dataSwitch = "<b> October - ".$explodedate[0]."</b>" ;
        break;
    case "11":
        $dataSwitch = "<b> November - ".$explodedate[0]."</b>" ;
        break; 
    case "12":
        $dataSwitch = "<b> December"  .$explodedate[0]."</b>" ;
        break;                
    default:
        $dataSwitch = "Err";
}   

$sql1 = "SELECT s.SALARY_RECEIVED_DATE,s.MONTH_YEAR, s.SALARY_GIVEN,s.LEAVE_TAKEN, s.salaryBasic, s.SALARY_GIVEN, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY, d.EMP_IDENTIFY FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID and s.MONTH_YEAR = '$month' order by s.SALARY_RECEIVED_DATE desc ";

}


 if(isset($_POST['name_emp'])) { 
         $name= $_POST['name'];
                  $_SESSION['name_emp'] = $month; 
$sql1 = "SELECT s.SALARY_RECEIVED_DATE,s.SALARY_GIVEN, s.SALARY_GIVEN,s.LEAVE_TAKEN, s.salaryBasic, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY, d.EMP_IDENTIFY  FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID and d.EMPLOYEE_NAME = '$name' order by s.SALARY_RECEIVED_DATE desc  ";
?>
<?php
 }
 if(isset($_POST['emp_Roll1'])){  
         $emp_id= $_POST['emp_Roll'];
          $_SESSION['name_emp'] = $emp_id; 
$sql1 = "SELECT s.SALARY_RECEIVED_DATE,s.SALARY_GIVEN, s.SALARY_GIVEN,s.LEAVE_TAKEN, s.salaryBasic, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY , d.EMP_IDENTIFY FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID and d.EMP_IDENTIFY = '$emp_id' order by s.SALARY_RECEIVED_DATE desc ";

 }

?>

<script type="text/javascript">
  var createTable = function() {
    for(let i=0; i<empArr.length; i++) {
      resObj = {};
      resObj["S NO"] = i+1;
      resObj["EMPLOYEE ID"] = empArr[i]["empId"];
      resObj["SALARY DATE"] = empArr[i]["SALARY_RECEIVED_DATE"];
      resObj["NAME"] = empArr[i]["name"];
      resObj["BASIC PAY"] = empArr[i]["salary"];



      resObj["BASIC PAY"] = empArr[i]["salary"];
      resObj["LEAVE TAKEN"] = empArr[i]["LEAVE_TAKEN"];
      resObj["MONTHLY SALARY"] = empArr[i]["salaryBasic"];
      for(let j=0; j<description.length; j++) {
        resObj[empArr[i]["ADDITIONAL_DESC_NAME_"+j]] = empArr[i]["ADDITIONAL_DESC_SALARY_"+j];
      }
      for(let j=0; j<descriptionRemove.length; j++) {
        resObj[empArr[i]["REMOVE_DESC_NAME_"+j]] = empArr[i]["REMOVE_DESC_SALARY_"+j];
      }
      resObj["TOTAL SALARY"] = empArr[i]["Total_salary"];
      resArr.push(resObj);
    }
 

    var col = [];
        for (var i = 0; i < resArr.length; i++) {
            for (var key in resArr[i]) {
                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        // CREATE DYNAMIC TABLE.
        var table = document.getElementById("emp-salary-table");

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            th.style.color = "black";
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < resArr.length; i++) {

            tr = table.insertRow(-1);

            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                tabCell.innerHTML = resArr[i][col[j]];
            }
        }

        // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
        // var divContainer = document.getElementById("showData");
        // divContainer.innerHTML = "";
        // divContainer.appendChild(table);
    }
  var echo  ={};
  var resObj = {};
  var resArr = [];
  var description = [];
  var SALARY_RECEIVED_DATE = [];
  var descriptionRemove = [];
  var name_emp1 = [];
  var empObj = {};
  var empArr = [];
  var addInfoObj = {};
  var descStr = null;
  var strArr = [];
  var descRemStr = null;
  var strRemArr = [];
</script> 
<?php
$sql = "SELECT * FROM `salary_description`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
  if($row['statuses'] == "ADDITION") {
?>
<script type="text/javascript">
  description.push('<?php echo $row['description']; ?>');
</script>
<?php 
  } else {
    ?>
<script type="text/javascript">
  descriptionRemove.push('<?php echo $row['description']; ?>');
</script>
<?php 
  }
}
 
//$sql1;
$result1 = mysqli_query($conn, $sql1);
while ($rows=mysqli_fetch_array($result1)) {
?>
<script type="text/javascript">
 
  empObj = {};
  
  empObj["empId"] = "<?php echo $rows['EMP_IDENTIFY']; ?>";
  empObj["name"] = "<?php echo $rows['EMPLOYEE_NAME']; ?>";
  empObj["mobile"] = <?php echo $rows['EMPLOYEE_MOBILE']; ?>;

  empObj["SALARY_RECEIVED_DATE"] = "<?php $varDate =  $rows['SALARY_RECEIVED_DATE']; echo str_replace("-01","",$varDate); ?>";

  empObj["salary"] = <?php echo $rows['SALARY']; ?>;
  empObj["salaryBasic"] = <?php echo $rows['salaryBasic']; ?>;
  empObj["Total_salary"] = <?php echo $rows['SALARY_GIVEN']; ?>;
  empObj["LEAVE_TAKEN"] = <?php echo $rows['LEAVE_TAKEN']; ?>;
  empObj["noOfDaysWorked"] = <?php echo $rows['NO_OF_DAYS_WORKED']; ?>;
  empObj["addtionalInfo"] = '<?php echo $rows['ADDITIONAL_INFORMATION']; ?>';
  for(let i=0; i<description.length; i++) {
    empObj["ADDITIONAL_DESC_NAME_" + i] = description[i];
    empObj["ADDITIONAL_DESC_SALARY_" + i] = 0;
  }
  for(let i=0; i<descriptionRemove.length; i++) {
    empObj["REMOVE_DESC_NAME_" + i] = descriptionRemove[i];
    empObj["REMOVE_DESC_SALARY_" + i] = 0;
  }

  addInfoObj = JSON.parse(empObj["addtionalInfo"]);
  //FOR ADDTION SALARY
  descStr = addInfoObj["additionalDesc"];
  salStr = addInfoObj["additionalSalary"];
  strArr = descStr.split(",");
  salArr = salStr.split(",");
  //FOR DETUCTION IN SALARY
  descRemStr = addInfoObj["removeDesc"];
  salRemStr = addInfoObj["removeSalary"];
  strRemArr = descRemStr.split(",");
  salRemArr = salRemStr.split(",");

  if(salArr.toString() != "") { //THE ADDITIONAL SALARY IS NOT GIVEN
    for(let j=0; j<strArr.length; j++) {
      let keyName = Object.keys(empObj).find(key => empObj[key] === strArr[j]);
      if(keyName != undefined && keyName != null && keyName.includes("_")) {
        let lastIndex = keyName.lastIndexOf("_");
        let substring2 = keyName.substring(lastIndex+1, keyName.length);
        empObj["ADDITIONAL_DESC_SALARY_" + substring2] = salArr[j];
        console.log(keyName);
      }
      
    }
  }

  if(salRemArr.toString() != "") { //THE ADDITIONAL SALARY IS NOT GIVEN
    for(let j=0; j<strRemArr.length; j++) {
      let keyName = Object.keys(empObj).find(key => empObj[key] === strRemArr[j]);
      let lastIndex = keyName.lastIndexOf("_");
      let substring2 = keyName.substring(lastIndex+1, keyName.length);
      empObj["REMOVE_DESC_SALARY_" + substring2] = salRemArr[j];
      console.log(keyName);
    }  
  }
  empArr.push(empObj);
   
</script>
<?php 
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
<script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
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



#emp-salary-table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#emp-salary-table td, #emp-salary-table th {
  border: 1px solid black;
  padding: 8px;
  color: black;
}

#emp-salary-table tr:nth-child(even){background-color: #f2f2f2;}

#emp-salary-table tr:hover {background-color: #ddd;}

#emp-salary-table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color:#428bca;
  color: black;
}


.btn-search {
  min-width: 10em;
}

.input-search {
  min-width: 15em;
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
                        <A HREF="employee_salary_view.php"><button style="float: right;margin-top: 12px" type="button" class="btn btn-danger">Reload</button></A>
                    </header>
                       <br>
                        <div class="position-center">
                            <form method="post" class="form-inline" role="form">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label class="sr-only" for="exampleInputEmail2">From Date</label>
                                          <input type="month" class="form-control input-search" name="from_date" id="getdate" onchange="dataChange(this)">
                                          <center>

                                          </center>
                                      </div>
                                  </div>

                                  <div class="col-sm-6">
                                    <input type="submit" onclick="empdate(this)" class="btn btn-success btn-search" name="from_to_date" value="Search by date">
                                  </div>
                              </div>
                            
                           </form>

                        

                        <!-- search by ID -->
                        <form method="post" class="form-inline" role="form">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="sr-only" for="exampleInputEmail2">Employee ID</label>
                
                                   <select id="city" name="emp_Roll" class="form-control input-search" onchange="dataChange(this)">
                                        <option value="0"> Select Id </option>
                                                <?php
                                        $query ="SELECT `EMP_IDENTIFY`,`EMPLOYEE_NAME` FROM `employee_details` WHERE 1";
                                        $result= mysqli_query($conn, $query);

                                        while($row=mysqli_fetch_array($result))
                                        {                                         
                                        ?>
                                        <li><a href="#">
              <option value="<?php echo $row['EMP_IDENTIFY']?>"><?php echo $row['EMP_IDENTIFY']."-".$row['EMPLOYEE_NAME'] ?></option>
                                        </a>
                                        </li>
                                        <?php 
                                         }
                                      ?>
                                  </select>
                                  <span id="empId"> </span>
                                  <table style="margin-top: 50px">
                                    <tr>
                                      
                                      <td>
                                         <div style="height:10;width:200;margin-top: 30px  ">
                                         <?php
                                 if($date==true){
                                  echo  $dataSwitch;
                                }else{
                                  echo "<B></B>";
                                }
                                  ?>
                                </div>
                                      </td>                                      
                                      <td>
                                         <div style="height:10;width:200;margin-left: 250px;margin-top: 30px ">
                                         <?php
                                         $jan = "jan";
                                  if($name==true){

                                  echo "<B> </B>".$name;
                                }else{

                                  echo "<B> </B>";
                                }
                                  ?>
                                      </td>
                                    </tr>
                                    </div>



                                  </table>
                              </div>
                            </div>

                            <div class="col-sm-6">
                              <input type="submit" class="btn btn-success btn-search" name="emp_Roll1" value="Search by Id">
                            </div>

                          </div>

                        </form>
                        </div>
                    <br>



        <div class="table-responsive" style="height:500px;overflow: scroll;" >
            <table class="table table-bordered" id="emp-salary-table" cellspacing="0" cellpadding="0">
                
            </table>
        </div>

<center>
<input type="button" class="btn btn-success" id="btnExport" value="Export" onclick="Export()" />
</center>

</section>
</section>

<?php
$sql = "SELECT `EMPLOYEE_NAME` FROM `employee_details` WHERE 1";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  name_emp1.push('<?php echo $row['EMPLOYEE_NAME']; ?>');
</script>
<?php 
}
?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
      var dataChange = function(input) {
        let id = $(input).attr("id");
        if(id == "getdate") {
          $("#city").attr("disabled", true);
          $("input[name='emp_Roll1']").attr("disabled", true);
        } else {
          $("#getdate").attr("disabled", true);
          $("input[name='from_to_date']").attr("disabled", true);
        }
      };

        function Export() {
            html2canvas(document.getElementById('emp-salary-table'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        }


$(document).ready(function(){
// var result = ['', '', '', '', '', '', '', '', '', '', '', '','Total Salary Paid'];
debugger;
var result = ['', '','','<b>Total Salary Paid</b>'];

var sumOfSalary = 0;

var colCount = document.getElementById('emp-salary-table').rows[0].cells.length;
for(let i = 4; i<colCount;i++){

    $('table tr').each(function(){
    $('td', this).each(function(index, val){
      if(index == i) {
        sumOfSalary += parseInt(val.innerText);
      }  
    });
  });
  result.push(sumOfSalary);
  sumOfSalary = 0 ;
}



  console.log('sumOfSalary ', sumOfSalary);
  $('table').append('<tr></tr>');
  $(result).each(function(){
    $('table tr').last().append('<td>'+this+'</td>')
  });
});




 </script>




</body>

</html>

<script type="text/javascript">
  createTable();
</script>