<?php
session_start();
include 'db_connect.php';

if(isset($_GET['to'])){
  $from = $_GET['from'];
  $to = $_GET['to'];
  $machineId = $_GET['id'];
  
    $machineNameQuery = "SELECT `MACHINE_NAME` FROM `machine_details` WHERE `MACHINE_ID` = $machineId";
    $queryRs = mysqli_query($conn,$machineNameQuery);
    $rowQueryRs = mysqli_fetch_array($queryRs);
    $machineName = $rowQueryRs['MACHINE_NAME'];

$queryName = "SELECT `TYPE`, `LAST_UPDATED_DATE`, SUM(`SIZE`), SUM(`TOTAL_INPUT`), SUM(`PROCESSED`), SUM(`UNPROCESSED_OUTPUT`) FROM `production_stock_report` WHERE `MACHINE_ID`= $machineId AND `LAST_UPDATED_DATE` BETWEEN '$from' AND '$to' AND `SIZE` NOT LIKE 'J-%'  GROUP BY `TYPE`, `LAST_UPDATED_DATE`";
$queryRuns = mysqli_query($conn,$queryName);

$resArr = array();
$typeArr = [];
$dateArray = [];
$data = array();
$resObj = array();
$totalInput = 0;
$totalProcessed = 0;
$totalUnprocessed = 0;
$i = 0;
while ($row = mysqli_fetch_array($queryRuns)) {
  $data = [];
  $size =  $row['SUM(`SIZE`)'];
  $type =  $row['TYPE'];
  $typeArr[$i] = $type;
  $dateArray[$i] = $row['LAST_UPDATED_DATE'];
  $data["TYPE"] =  $row['TYPE'];
  $data["DATE"] =  $row['LAST_UPDATED_DATE'];
  $data["INPUT"] = $row['SUM(`TOTAL_INPUT`)'];
  $data["PROCESSED"] = $row['SUM(`PROCESSED`)'];
  $data["UNPROCESSED"] = $row['SUM(`UNPROCESSED_OUTPUT`)'];
  // array_push($resObj, $data);
  // $resArr[$type] = array();
  // array_push($resArr[$type], $resObj);
  array_push($resArr, $data);
  $i = $i + 1;
}

?>
<script type="text/javascript">
  var sizeArray1 = <?php echo json_encode($resArr); ?>;
  var sizeArray = [];
  var dateArray = <?php echo json_encode($dateArray); ?>;
  dateArray = [...new Set(dateArray)];
  var typeArray = <?php echo json_encode($typeArr); ?>;
  typeArray = [...new Set(typeArray)]; //REMOVED THE DUPLICATE ELEMENTS IN THE TYPE ARRAY
  for(let i=0; i<typeArray.length; i++) {
    let productArray = sizeArray1.filter(records => records.TYPE == typeArray[i]);
    sizeArray[typeArray[i]] = productArray;
  }
  var result = {};
  sizeArray["TOTAL"] = [];
  /* FORM THE TOATL INPUTS */
  // var productArr = typeArray;
  var productArr = dateArray;
  productArr.unshift("TOTAL");
  for(let i=0; i<productArr.length; i++) {
    if(productArr[i] != "TOTAL") {
      let productNameArray = typeArray;
      // let productDetails = sizeArray[productArr[i]];
      let productDetails = [];
      for(let j=0; j<productNameArray.length; j++) {
        let date = productArr[i];
        let arr = sizeArray[productNameArray[j]].filter(rec => rec.DATE == date);
        productDetails = [...productDetails, ...arr];
      }
      let productDetailsLength = productDetails.length;
      let input = 0, processed = 0, unProcessed = 0;
      for(let j=0; j<productDetailsLength; j++) {
        input += parseInt(productDetails[j]["INPUT"]);
        processed += parseInt(productDetails[j]["PROCESSED"]);
        unProcessed += parseInt(productDetails[j]["UNPROCESSED"]);
      }
      let obj = {};
      obj["TYPE"] = productArr[i];
      obj["TOTAL INPUT"] = input;
      obj["TOTAL PROCESSED"] = processed;
      obj["TOTAL UNPROCESSED"] = unProcessed;
      sizeArray["TOTAL"].push(obj);
    }
  }
  productArr = typeArray;
  productArr.unshift("TOTAL");
  // sizeArray["TOTAL"].pop(); // REMOVES THE LAST ROW IN TOTAL ARRAY SINCE IT STORES NaN VALUES BY DEFAULT 
</script>
<?php
}

?>
<!DOCTYPE html>
<head>
<title>Performance Report</title>
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

h3 {
  text-align: center;
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
                      Performance-Count-Report (<b><?php echo $machineName; ?></b>)
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
           
                      <div class="row" id="all-product-div" style="width: 100%;">
                          
                      </div>


                    </div>
                </section>
            </div>
        </div>                      
    </div>
   
         
</section>

<!--main content end-->
</section>


<script type="text/javascript">
   
   var buildTable = function(tableId, resArr) {
        //var columns = addAllColumnHeaders(sizeArray);
        var columns = addAllColumnHeaders(tableId, resArr);
    
        for (var i = 0 ; i < resArr.length ; i++) {
            var row$ = $('<tr/>');
            for (var colIndex = 0 ; colIndex < columns.length ; colIndex++) {
                var cellValue = resArr[i][columns[colIndex]];
    
                if (cellValue == null) { cellValue = ""; }
    
                row$.append($('<td/>').html(cellValue));
            }
            $("#"+tableId+"-table").append(row$);
        }
        // let tbl = jQuery("#"+tableId+"-table");
        // let dateCol = columns.indexOf("DATE");
        // jQuery.moveColumn(tbl, dateCol, 0);
    }
 
    // Adds a header row to the table and returns the set of columns.
    // Need to do union of keys from all records as some records may not contain
    // all records
    var addAllColumnHeaders = function(tableId, resArr) {
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
        
        for (var i = 0 ; i < resArr.length ; i++) {
            var rowHash = resArr[i];
            for (var key in rowHash) {
                if ($.inArray(key, columnSet) == -1){
                    columnSet.push(key);
                    headerTr$.append($('<th/>').html(key));
                }
            }
        }
        $("#"+tableId+"-table").append(headerTr$);    
        return columnSet;
    };

    var createTables = function() {
      for(let i=0; i<productArr.length; i++) {
        let table = "<hr> <h3>"+productArr[i]+"</h3><hr> <div class='tableFixHead'><table class='table table-striped' id='"+productArr[i].split(" ")[0]+"-table'> </table> </div>";
        $("#all-product-div").append(table);
      }
    };

    var merge = function(divId) {
        $('#'+divId).margetable({
            type: 2,
            colindex: [0]
        });
    };

    var renderTables = function() {
      for(let i=0; i<productArr.length; i++) {
        let resArr = sizeArray[productArr[i]];
        // resArr = resArr[0];
        $.when(buildTable(productArr[i].split(" ")[0], resArr)).then(function() {
          merge(productArr[i].split(" ")[0] + "-table");
        });
      
      }
    };

    jQuery.moveColumn = function (table, from, to) {
        var rows = jQuery('tr', table);
        var cols;
        rows.each(function() {
            cols = jQuery(this).children('th, td');
            cols.eq(from).detach().insertBefore(cols.eq(to));
        });
    }

    $('#excelBtn').click(function () {
      productArrTableIds = [];
      let fileName = "Performance-Count-Report ("+ <?php echo '"'.$machineName.'"'; ?> + ").xls";
      productArr.forEach(rec => productArrTableIds.push(rec.split(" ")[0]+"-table"));
      tablesToExcel(productArrTableIds, productArr, fileName, 'Excel');
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
      //createTables();
      $.when(createTables()).then(function() {
        renderTables();
      });
    });





</script>
</body>
</html>
