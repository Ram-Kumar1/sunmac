<?php
session_start();
include 'db_connect.php';

if(isset($_GET['to'])){
  $from = $_GET['from'];
  $to = $_GET['to'];
  $id = $_GET['id'];
  $type = $_GET['type'];
  $thickness = $_GET['thickness'];
  // 1. FIND THE ASSOCIATED SIZE FROM SIZE table
  // 2. FIND THE LAST MACHINE ID FROM CATEGORY_MACHINES
  // 3. EXCEUTE THE FINAL QUERY

 


$queryName = 'SELECT `PRODUCT_NAME` FROM `category` WHERE `PRODUCT_ID`='.$id;
$queryRuns = mysqli_query($conn,$queryName);
$rowsName = mysqli_fetch_array($queryRuns);
$productName =  $rowsName[0];


$query = 'SELECT `MACHINE_ALLOCATION` FROM `category_machine` WHERE `CATEGORY_ID`='.$id;
$queryRun = mysqli_query($conn,$query);
$rowss = mysqli_fetch_array($queryRun);
$machineArray =  explode(",", $rowss[0]);
$lastMachine = end($machineArray);

$sizeQry = "SELECT DISTINCT SIZE FROM production_stock_report WHERE CATEGORY_ID=".$id;
$queryRun1 = mysqli_query($conn,$sizeQry);
$sizeString = "'";  
while ($rowsss = mysqli_fetch_array($queryRun1)) {
  $sizeString = $sizeString.$rowsss[0]."','";
}
$sizeString = substr($sizeString, 0, -2);

// $resultQuery = "SELECT `LAST_UPDATED_DATE`,`SIZE`, SUM(`TOTAL_PROCESSED`) AS TOTAL_PROCESSED from production_stock_report where 1=1 AND `CATEGORY_ID` = '$id' AND TYPE LIKE '$type' AND thickness = '$thickness' AND `MACHINE_ID` = $lastMachine AND `SIZE`IN ( $sizeString ) AND `LAST_UPDATED_DATE` between '$from' AND '$to' GROUP BY SIZE, LAST_UPDATED_DATE";
$resultQuery = "SELECT `LAST_UPDATED_DATE`,`SIZE`, SUM(`TOTAL_PROCESSED`) AS TOTAL_PROCESSED from production_stock_report where 1=1 AND `CATEGORY_ID` = '$id' AND TYPE LIKE '$type' AND `MACHINE_ID` = $lastMachine AND `SIZE`IN ( $sizeString ) AND `LAST_UPDATED_DATE` between '$from' AND '$to' ";
if($thickness != null && $thickness != "") {
      $resultQuery = $resultQuery . " AND thickness = '$thickness' " . " GROUP BY SIZE, LAST_UPDATED_DATE";
    } else {
      $resultQuery = $resultQuery . " GROUP BY SIZE, LAST_UPDATED_DATE";  
    }
$resultQueryProcess = mysqli_query($conn,$resultQuery);

$resArr = array();
while ($row = mysqli_fetch_array($resultQueryProcess)) {
  $data = array();
  $data["DATE"] = $row['LAST_UPDATED_DATE'];
  $data[$row['SIZE']] = $row['TOTAL_PROCESSED'];
  //$data["TOTAL_PROCESSED"] = $row['TOTAL_PROCESSED'];

  array_push($resArr, $data); 
}

?>
<script type="text/javascript">
  var sizeArrBkp = undefined;
  var sizeArray = <?php echo json_encode($resArr); ?>;
  var array = [];
  var resArr = [];
  sizeArray.forEach(rec => {
    array.indexOf(rec.DATE) === -1 ? array.push(rec.DATE) : console.log("");
  });

  for(let i=0; i<array.length; i++) {
    let resObj = {};
    let dateArr = sizeArray.filter((record) => record.DATE == array[i]);
    for(let j=0; j<dateArr.length; j++) {
      let obj = Object.keys(dateArr[j]);
      for(let k=0; k<obj.length; k++) {
        resObj["DATE"] = dateArr[j]["DATE"];
        if(dateArr[j][obj[k]] != "DATE") {
          resObj[obj[k]] = dateArr[j][obj[k]];
        }
      } 
    }
    resArr.push(resObj);
  }
  
</script>
<?php
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

/* FIXED HEADER FOR THE TABLE */
.tableFixHead {
  overflow-y: auto;
  height: 500px;
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

td.total-cell {
    /* color: aqua; */
    background: #eee;
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
                      Report - <?php echo $productName . " (".$type.", ".$thickness.")"; ?>
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
           

<div class="row tableFixHead" style="width: 100%;">
  <table class="table table-striped" id='report-table'>

  </table>
</div>                        
                    </div>
                </section>
            </div>
        </div>                      
    </div>
   
         
</section>

<!--main content end-->
</section>

<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script type="text/javascript">
var columns = [];
var buildTable = function() {
        columns = addAllColumnHeaders(sizeArray);
    
        for (var i = 0 ; i < sizeArray.length ; i++) {
            var row$ = $('<tr/>');
            for (var colIndex = 0 ; colIndex < columns.length ; colIndex++) {
                var cellValue = sizeArray[i][columns[colIndex]];
    
                if (cellValue == null) { cellValue = ""; }
    
                row$.append($('<td/>').html(cellValue));
            }
            $("#report-table").append(row$);
        }

    }

  var calculateTotal = function() {
    $('#report-table').find('tr').each(function() { 
      $(this).find('th').eq(-1).after('<th>TOTAL</th>'); 
      $(this).find('td').eq(-1).after('<td class="total-cell"></td>'); 
    });

    $('#report-table').find('tr').each(function (index) {
      console.log("index: ", index);
        //the value of sum needs to be reset for each row, so it has to be set inside the row loop
        var sum = 0
        $(this).find('td').each(function () {
            
            var combat = $(this).text();
            if (!isNaN(combat) && combat.length !== 0) {
                sum += parseFloat(combat);
            }
        });
        
        $('.total-cell', this).html(sum);
    });

    /*  TO CALCULATE THE TOTAL OF ALL COLUMNS  */
    var result = [];
    $('#report-table tr').each(function(){
      $('td', this).each(function(index, val) {
          if(index == 0) { // 0'TH INDEX IS DATE WE NEED TO TO CALCULATE THE TOTAL FOR THIS COLUMN 
            result[index] = '';
          } else {
            if(!result[index]) {
              result[index] = 0;
            }
            result[index] += parseInt($(val).text());
            }
      });
    });

    $('#report-table').append('<tr></tr>');
    $(result).each(function(){
      $('table tr').last().append('<td class="total-cell">'+this+'</td>')
    });
    /*  ADD COLUMN TOTAL ENDS HERE */
  };
 
    // Adds a header row to the table and returns the set of columns.
    // Need to do union of keys from all records as some records may not contain
    // all records
    var addAllColumnHeaders = function(sizeArray) {
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
        
        for (var i = 0 ; i < sizeArray.length ; i++) {
            var rowHash = sizeArray[i];
            for (var key in rowHash) {
                if ($.inArray(key, columnSet) == -1){
                    columnSet.push(key);
                    headerTr$.append($('<th/>').html(key));
                }
            }
        }
        
        $("#report-table").append(headerTr$);
    
        return columnSet;
    }


    jQuery.moveColumn = function (table, from, to) {
        var rows = jQuery('tr', table);
        var cols;
        rows.each(function() {
            cols = jQuery(this).children('th, td');
            cols.eq(from).detach().insertBefore(cols.eq(to));
        });
    }

    var sortTabel = function(table, order) {
        jQuery.each($("table tr"), function() { 
            $(this).children(":eq(0)").after($(this).children(":eq(1)"));
        });
    };

    $("#excelBtn").click(function(e){
          var table = $("#report-table");
          let php = <?php echo "'".$productName . " (".$type.")'"; ?>;
          let fileName = php + ".xls";
            
          // tablesToExcel(["report-table"], [php], fileName, 'Excel');

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
  //             var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
  //             var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
  //             var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
  //             dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
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
      sizeArrBkp = sizeArray;
      sizeArray = resArr;
      $.when(buildTable()).then(function() {
        let tbl = jQuery('#report-table');
        let dateCol = columns.indexOf("DATE");
        jQuery.moveColumn(tbl, dateCol, 0);
        setTimeout(() => {
          calculateTotal();
        }, 1000);
      });
            
    });

</script>
</body>
</html>
