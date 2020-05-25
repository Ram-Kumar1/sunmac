<?php
session_start();
include 'db_connect.php';

$userName = $_SESSION['userName'];
$loginType = $_SESSION['admin'];
$sql1 = "SELECT s.SALARY_RECEIVED_DATE,s.SALARY_GIVEN, s.salaryBasic,s.LEAVE_TAKEN, s.NO_OF_DAYS_IN_MONTH, s.NO_OF_DAYS_WORKED, s.ADDITIONAL_INFORMATION, s.EMPLOYEE_ID, d.EMPLOYEE_NAME, d.EMPLOYEE_MOBILE, d.SALARY, d.EMP_IDENTIFY FROM employee_details d , employee_salary_details s WHERE d.EMPLOYEE_ID = s.EMPLOYEE_ID AND d.USER_NAME = '$userName' AND d.LOGIN_TYPE = '$loginType' order by s.SALARY_RECEIVED_DATE desc ";

?>

<script type="text/javascript">
    var createTable = function() {
        for (let i = 0; i < empArr.length; i++) {
            resObj = {};
            resObj["S NO"] = i + 1;
            resObj["EMPLOYEE ID"] = empArr[i]["empId"];
            resObj["SALARY DATE"] = empArr[i]["SALARY_RECEIVED_DATE"];
            resObj["NAME"] = empArr[i]["name"];
            resObj["BASIC PAY"] = empArr[i]["salary"];
            resObj["LEAVE TAKEN"] = empArr[i]["LEAVE_TAKEN"];
            resObj["MONTHLY SALARY"] = empArr[i]["salaryBasic"];
            for (let j = 0; j < description.length; j++) {
                resObj[empArr[i]["ADDITIONAL_DESC_NAME_" + j]] = empArr[i]["ADDITIONAL_DESC_SALARY_" + j];
            }
            for (let j = 0; j < descriptionRemove.length; j++) {
                resObj[empArr[i]["REMOVE_DESC_NAME_" + j]] = empArr[i]["REMOVE_DESC_SALARY_" + j];
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
        var thead = table.createTHead(); // TABLE ROW.
        var tr = thead.insertRow(0);
        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th"); // TABLE HEADER.
            if(i==2) {
                th.innerHTML = '<input type="text" class="form-control col-sm-1" placeholder="Salary Date" disabled>';
                th.style.color = "#0c1211";
                th.style.background = "#428bca";
            } else {
                th.innerHTML = col[i];
                th.style.color = "black";
            }
            tr.classList.add("filters");
            tr.appendChild(th);
        }
        var tbody = table.createTBody();
        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < resArr.length; i++) {
            tr = tbody.insertRow(-1);
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
    var echo = {};
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
while ($row = mysqli_fetch_array($result)) {
    if ($row['statuses'] == "ADDITION") {
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
while ($rows = mysqli_fetch_array($result1)) {
    ?>
    <script type="text/javascript">
        empObj = {};
        empObj["empId"] = "<?php echo $rows['EMP_IDENTIFY']; ?>";
        empObj["name"] = "<?php echo $rows['EMPLOYEE_NAME']; ?>";
        empObj["mobile"] = <?php echo $rows['EMPLOYEE_MOBILE']; ?>;
        empObj["SALARY_RECEIVED_DATE"] = "<?php $varDate =  $rows['SALARY_RECEIVED_DATE']; echo str_replace("-01", "", $varDate); ?>";
        empObj["salary"] = <?php echo $rows['SALARY']; ?>;
        empObj["salaryBasic"] = <?php echo $rows['salaryBasic']; ?>;
        empObj["Total_salary"] = <?php echo $rows['SALARY_GIVEN']; ?>;
        empObj["LEAVE_TAKEN"] = <?php echo $rows['LEAVE_TAKEN']; ?>;
        empObj["noOfDaysWorked"] = <?php echo $rows['NO_OF_DAYS_WORKED']; ?>;
        empObj["addtionalInfo"] = '<?php echo $rows['ADDITIONAL_INFORMATION']; ?>';
        for (let i = 0; i < description.length; i++) {
            empObj["ADDITIONAL_DESC_NAME_" + i] = description[i];
            empObj["ADDITIONAL_DESC_SALARY_" + i] = 0;
        }
        for (let i = 0; i < descriptionRemove.length; i++) {
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

        if (salArr.toString() != "") { //THE ADDITIONAL SALARY IS NOT GIVEN
            for (let j = 0; j < strArr.length; j++) {
                let keyName = Object.keys(empObj).find(key => empObj[key] === strArr[j]);
                if (keyName != undefined && keyName != null && keyName.includes("_")) {
                    let lastIndex = keyName.lastIndexOf("_");
                    let substring2 = keyName.substring(lastIndex + 1, keyName.length);
                    empObj["ADDITIONAL_DESC_SALARY_" + substring2] = salArr[j];
                    console.log(keyName);
                }

            }
        }

        if (salRemArr.toString() != "") { //THE ADDITIONAL SALARY IS NOT GIVEN
            for (let j = 0; j < strRemArr.length; j++) {
                let keyName = Object.keys(empObj).find(key => empObj[key] === strRemArr[j]);
                let lastIndex = keyName.lastIndexOf("_");
                let substring2 = keyName.substring(lastIndex + 1, keyName.length);
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
    <title>Employee View</title>
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
        .m-1 {
            margin-top: 1em;
        }

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

        #emp-salary-table td,
        #emp-salary-table th {
            border: 1px solid black;
            padding: 8px;
            color: black;
        }

        #emp-salary-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #emp-salary-table tr:hover {
            background-color: #ddd;
        }

        #emp-salary-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #428bca;
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
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Employee View
                            </header>
                            <div class="table-responsive filterable" style="height:500px;overflow: scroll;">
                            <div class="pull-right">
                                <button class="btn btn-default btn-xs btn-filter"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
                            </div>
                                <table class="table tableFixHead table-bordered" id="emp-salary-table" cellspacing="0" cellpadding="0">

                                </table>
                            </div>
                            <center>
                                <input type="button" class="btn btn-success" id="btnExport" value="Export" onclick="Export()" />
                            </center>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        function Export() {
            html2canvas(document.getElementById('emp-salary-table'), {
                onrendered: function(canvas) {
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


        $(document).ready(function() {
            // var result = ['', '', '', '', '', '', '', '', '', '', '', '','Total Salary Paid'];
            /*debugger;
            var result = ['', '', '', '<b>Total Salary Paid</b>'];

            var sumOfSalary = 0;

            for (let i = 4; i < 15; i++) {

                $('table tr').each(function() {
                    $('td', this).each(function(index, val) {
                        if (index == i) {
                            sumOfSalary += parseInt(val.innerText);
                        }
                    });
                });
                result.push(sumOfSalary);
                sumOfSalary = 0;
            }



            console.log('sumOfSalary ', sumOfSalary);
            $('table').append('<tr></tr>');
            $(result).each(function() {
                $('table tr').last().append('<td>' + this + '</td>')
            });*/
        });
    </script>

</body>

</html>

<script type="text/javascript">
    createTable();
</script>