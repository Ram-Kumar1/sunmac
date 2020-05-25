<?php
session_start();
include 'db_connect.php';

if(isset($_GET['to'])){
  $from = $_GET['from'];
  $to = $_GET['to'];
  $id = $_GET['machineId'];
  $type = $_GET['type'];
  $thickness = $_GET['thickness'];
  $size = $_GET['size'];

$queryName = 'SELECT `MACHINE_NAME` FROM `machine_details` WHERE `MACHINE_ID`='.$id;
$queryRuns = mysqli_query($conn,$queryName);
$rowsName = mysqli_fetch_array($queryRuns);
$productName =  $rowsName[0];

$resultQuery = "SELECT C.PRODUCT_NAME, R.`LAST_UPDATED_DATE`, R.`thickness`, R.`UP_INPUT`,R.`GIVEN_INPUT`,R.`TOTAL_INPUT`,R.`PROCESSED`,R.`OLD_STOCK`,R.`TOTAL_PROCESSED`,R.`TOTAL_STOCK`, R.`UNPROCESSED_OUTPUT` FROM `production_stock_report` R, `category` C WHERE R.`MACHINE_ID` = $id AND R.`TYPE` = '$type' AND R.`SIZE` = '$size' AND R.CATEGORY_ID = C.PRODUCT_ID AND R.LAST_UPDATED_DATE BETWEEN '$from' AND '$to'";
$resultQueryProcess = mysqli_query($conn,$resultQuery);

$resArr = array();
while ($row = mysqli_fetch_array($resultQueryProcess)) {
  $data = array();
  $data["DATE"] = $row['LAST_UPDATED_DATE'];
  $data["Product Name"] = $row["PRODUCT_NAME"];
  $data["Thickness"] = $row["thickness"];
  $data["UP"] = $row['UP_INPUT'];
  $data["T.I"] = $row['GIVEN_INPUT'];
  $data["TOT"] = $row['TOTAL_INPUT'];
  $data["PRO"] = $row['PROCESSED'];
  $data["O.S"] = $row['OLD_STOCK'];
  $data["T.P"] = $row['TOTAL_PROCESSED'];
  $data["T.S"] = $row['TOTAL_STOCK'];
  $data['U.P'] = $row['UNPROCESSED_OUTPUT'];
  array_push($resArr, $data); 
}


$resultQuery1 = "SELECT P.`LAST_UPDATED_DATE` AS DATES, C.`PRODUCT_NAME` AS PRODUCT_NAME, P.thickness, P.`UP_INPUT` AS UP,P.`GIVEN_INPUT` AS TI,P.`TOTAL_INPUT` AS TOT,P.`PROCESSED` AS PROCESSED, P.`OLD_STOCK` AS OLD_STOCK,P.`TOTAL_PROCESSED` AS TOTAL_PROCESSED,P.`TOTAL_STOCK` AS TODAY_STOCK, P.`UNPROCESSED_OUTPUT` AS UNPROCESSED FROM `production_stock_report` P, category C WHERE `MACHINE_ID` = $id AND LAST_UPDATED_DATE BETWEEN '$from' AND '$to' AND P.CATEGORY_ID = C.PRODUCT_ID ORDER BY LAST_UPDATED_DATE, thickness";
$resultQueryProcess1 = mysqli_query($conn,$resultQuery1);

$resArr1 = array();
while ($rows = mysqli_fetch_array($resultQueryProcess1)) {
  $data = array();
  $data["DATE"] = $rows['DATES'];
  $data["PRODUCT NAME"] = $rows['PRODUCT_NAME'];
  $data["Thickness"] = $rows['thickness'];
  $data["UP"] = $rows['UP'];
  $data["TI"] = $rows['TI'];
  $data["TOT"] = $rows['TOT'];
  $data["PROCESSED"] = $rows['PROCESSED'];
  $data["OLD STOCK"] = $rows['OLD_STOCK'];
  $data["TOT PROCESSED"] = $rows['TOTAL_PROCESSED'];
  $data["TODAY STOCK"] = $rows['TODAY_STOCK'];
  $data['UNPROCESSED'] = $rows['UNPROCESSED'];
  array_push($resArr1, $data); 
}


?>
<script type="text/javascript">
  var sizeArray = <?php echo json_encode($resArr); ?>;
  var sizeArray1 = <?php echo json_encode($resArr1); ?>;
  
  var result = {};

</script>
<?php
}




?>
<!DOCTYPE html>
<head>
<title>Machine Report</title>
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

<script src="jquery.table.marge.js"></script>
</head>

<style type="text/css">
  .top-25 {
    margin-top: 2em;
  }

  .row-border {
    border-bottom: 1px solid;
    border-bottom-color: #dca9ae;
  }

  .pr-4 {
    padding-right: 4em;
  }

  .pl-2 {
    padding-left: 2.5em;
  }

  .cs-label {
    margin-left: 1em;
    margin-top: 4px;
  }

  .mt-5 {
    margin-top: 5px;
  }

  .w-40 {
    width: 40%;
  }

  th {
    background-color: #5181ec;
    color: black !important;
  }

/*new*/


.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}

h3{
  margin: 50px;
}

/* FIXED HEADER FOR THE TABLE */
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

td {
  color: black !important;
}


</style>


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


<body>
<?php include 'header.php'; ?>

<section id="main-content">
  <section class="wrapper">
       <div class="form-w3layouts">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                      Report - <?php echo $productName; ?>
                      <button type="button" class="btn btn-primary pull-left"
                          onclick="location.href = 'production_flow_report.php';" style="margin: 0.5em;">
                        <i class="fas fa-chevron-circle-left"></i>
                        Back
                      </button>
                      <button type="button" class="btn btn-success pull-right"
                          id="excelBtn" style="margin: 0.5em;">
                          <i class="far fa-file-excel"></i>
                          EXPORT
                      </button>
                    </header>

                    <div class="panel-body">
                       <div>
           
<center>
  <h3>Records Entered On Machine <b> <?php echo $productName; ?> </b>
  
    (Type - <?php echo $type; ?>,
    Size - <?php echo $size; ?> )
  </h3>
</center>

<div class="row tableFixHead" style="width: 100%;">
  <table class="table table-striped" id='report-table-all'>

  </table>
</div>
<!-- <center><h3>Total Processed By Product Wise </h3></center>
<div class="row" style="width: 100%;">
  <table class="table" id='report-table-product'>

  </table>
</div>                         -->
                    </div>
                </section>
            </div>
        </div>                      
    </div>
   
         
</section>

<!--main content end-->
</section>


<script type="text/javascript">
   
var buildTable = function(arr, divId) {
        var columns = addAllColumnHeaders(arr, divId);
    
        for (var i = 0 ; i < arr.length ; i++) {
            var row$ = $('<tr/>');
            for (var colIndex = 0 ; colIndex < columns.length ; colIndex++) {
                var cellValue = arr[i][columns[colIndex]];
    
                if (cellValue == null) { cellValue = ""; }
    
                row$.append($('<td/>').html(cellValue));
            }
            $("#"+divId).append(row$);
        }
    }
 
    // Adds a header row to the table and returns the set of columns.
    // Need to do union of keys from all records as some records may not contain
    // all records
    var addAllColumnHeaders = function(arr, divId) {
        var columnSet = [];
        var headerTr$ = $('<tr/>');
    
        // for (var i = 0 ; i < sizeArray.length ; i++) {
        //     var rowHash = Object.keys(sizeArray[i]);
        //     rowHash.sort();
        //     for (var key in rowHash) {
        //         columnSet.push(rowHash[key]);
        //         headerTr$.append($('<th/>').html(rowHash[key]));
        //     }
        // }
        
        for (var i = 0 ; i < arr.length ; i++) {
            var rowHash = arr[i];
            for (var key in rowHash) {
                if ($.inArray(key, columnSet) == -1){
                    columnSet.push(key);
                    headerTr$.append($('<th/>').html(key));
                }
            }
        }
        
        $("#"+divId).append(headerTr$);
    
        return columnSet;
    }


    var merge = function(divId) {
        $('#'+divId).margetable({
            type: 2,
            colindex: [0, 1, 2]
        });
    };

    $('#excelBtn').click(function () {
      productArrTableIds = [];
      let fileName = <?php echo '"'.$productName.'_Report"'; ?> + ").xls";
      // tablesToExcel(["report-table-all"], "Sheet1", fileName, 'Excel');
    });

  //   var tablesToExcel = (function() {
  //     var uri = 'data:application/vnd.ms-excel;base64,'
  //     , tmplWorkbookXML = <?php echo'<?xml version="1.0" encoding="utf-8" ?> <?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';?>
  //       + '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>'
  //       + '<Styles>'
  //       + '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
  //       + '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
  //       + '</Styles>' 
  //       + '{worksheets}</Workbook>'
  //     , tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>'
  //     , tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>'
  //     , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
  //     , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  //     return function(tables, wsnames, wbname, appname) {
  //       var ctx = "";
  //       var workbookXML = "";
  //       var worksheetsXML = "";
  //       var rowsXML = "";

  //       for (var i = 0; i < tables.length; i++) {
  //         if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
  //         for (var j = 0; j < tables[i].rows.length; j++) {
  //           rowsXML += '<Row>'
  //           for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
  //             var style = tables[i].rows[j].cells[k].getAttribute("style");
  //             var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
  //             var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
  //             var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
  //             dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
  //             dataValue = style == "display: none;" ? " " : dataValue;
  //             var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
  //             dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
  //             ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date')?' ss:StyleID="'+dataStyle+'"':''
  //                   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
  //                   , data: (dataFormula)?'':dataValue
  //                   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
  //                   };
  //             rowsXML += format(tmplCellXML, ctx);
  //           }
  //           rowsXML += '</Row>'
  //         }
  //         ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
  //         worksheetsXML += format(tmplWorksheetXML, ctx);
  //         rowsXML = "";
  //       }

  //       ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
  //       workbookXML = format(tmplWorkbookXML, ctx);

  // console.log(workbookXML);

  //       var link = document.createElement("A");
  //       link.href = uri + base64(workbookXML);
  //       link.download = wbname || 'Workbook.xls';
  //       link.target = '_blank';
  //       document.body.appendChild(link);
  //       link.click();
  //       document.body.removeChild(link);
  //     }
  //   })();


    $(document).ready(function(){
      $.when(buildTable(sizeArray, 'report-table-all')).then(function() {
         merge('report-table-all');
      });

      // $.when(buildTable(sizeArray1, 'report-table-product')).then(function() {
      //   merge('report-table-product');
      // });
      
    });




</script>
</body>
</html>
