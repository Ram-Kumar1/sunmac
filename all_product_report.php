<?php
session_start();
include 'db_connect.php';
if(isset($_GET['type'])) {
  $type = $_GET['type'];
  $thickness = $_GET['thickness'];
  $produtSelectQuery = "SELECT  PRODUCT_ID, PRODUCT_NAME FROM category WHERE JOB_WORKERS != 1";
  $produtSelectQueryRes = mysqli_query($conn,$produtSelectQuery);
  $productIdArray = [];
  $productArrray = [];
  $i = 0;
  while ($row = mysqli_fetch_array($produtSelectQueryRes)) {
    $productIdArray[$i] = $row['PRODUCT_ID'];
    $productArrray[$i] = $row['PRODUCT_NAME'];
    $i++;
  }

  $resArr = array();
  $resObj = array();

  for($i=0; $i<sizeof($productArrray); $i++) {
    $resObj = array();

    $queryName = 'SELECT `PRODUCT_NAME` FROM `category` WHERE `PRODUCT_ID`='.$productIdArray[$i];
    $queryRuns = mysqli_query($conn,$queryName);
    while($rowsName = mysqli_fetch_array($queryRuns)) {
      $productName =  $rowsName[0];
    }
    
    $query = 'SELECT `MACHINE_ALLOCATION` FROM `category_machine` WHERE `CATEGORY_ID`='.$productIdArray[$i];
    $queryRun = mysqli_query($conn,$query);
    while($rowss = mysqli_fetch_array($queryRun)){
      $machineArray =  explode(",", $rowss[0]);  
    }
    $lastMachine = end($machineArray);
  
    $sizeQry = "SELECT DISTINCT SIZE FROM production_stock_report WHERE CATEGORY_ID=".$productIdArray[$i];
    $queryRun1 = mysqli_query($conn,$sizeQry);
    $sizeString = "'";  
    while ($rowsss = mysqli_fetch_array($queryRun1)) {
      $sizeString = $sizeString.$rowsss[0]."','";
    }
    $sizeString = substr($sizeString, 0, -2);

    /*$resultQuery = "SELECT `LAST_UPDATED_DATE`,`SIZE`, SUM(`TOTAL_PROCESSED`) AS TOTAL_PROCESSED from production_stock_report where 1=1 AND `CATEGORY_ID` = '$productIdArray[$i]' AND TYPE LIKE '$type' AND thickness = '$thickness' AND `MACHINE_ID` = $lastMachine AND `SIZE` IN ( $sizeString ) GROUP BY SIZE, LAST_UPDATED_DATE";*/
    // $resultQuery = "SELECT `LAST_UPDATED_DATE`,`SIZE`, SUM(`TOTAL_PROCESSED`) AS TOTAL_PROCESSED from production_stock_report where 1=1 AND `CATEGORY_ID` = '$productIdArray[$i]' AND TYPE LIKE '$type' AND `MACHINE_ID` = $lastMachine AND `SIZE` IN ( $sizeString )";
    $resultQuery = "SELECT SIZE, STOCK_VALUE AS STOCK from product_stock where 1=1 AND `PRODUCT_ID` = $productIdArray[$i] AND TYPE LIKE '$type' AND `SIZE` IN ( $sizeString )";
    if($thickness != null && $thickness != "") {
      $resultQuery = $resultQuery . " AND thickness = '$thickness' " . " GROUP BY SIZE ORDER BY SIZE";
    } else {
      $resultQuery = $resultQuery . " GROUP BY SIZE ORDER BY SIZE";  
    }
    $resultQuery;
    $resultQueryProcess = mysqli_query($conn,$resultQuery);
    // $rowsCount = mysqli_num_rows($resultQueryProcess);
    if($resultQueryProcess = mysqli_query($conn,$resultQuery)) {
      while ($row = mysqli_fetch_array($resultQueryProcess)) {
        $data = array();
        // $data["DATE"] = $row['LAST_UPDATED_DATE'];
        // $data[$row['SIZE']] = $row['TOTAL_PROCESSED'];
        // $data["SIZE"] = $row['SIZE'];
        $data[$row['SIZE']] = $row['STOCK'];
        
        //$data["TOTAL_PROCESSED"] = $row['TOTAL_PROCESSED'];
        array_push($resObj, $data); 
      }
    }
    // echo("resObj: \n");
    // print_r($resObj);
    $resArr[$productArrray[$i]] = array();
    array_push($resArr[$productArrray[$i]], $resObj);
  }

?>
<script type="text/javascript">
  var sizeArray = <?php echo json_encode($resArr); ?>;
  
</script>
<?php
}
?>
<!DOCTYPE html>
<head>
<title>All Product Report</title>
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

  h3 {
    text-align: center;
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

th {
    background-color: #5181ec;
    color: black !important;
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
                      Report
                      <button type="button" class="btn btn-primary pull-left"
                          onclick="location.href = 'production_flow_report.php';" style="margin: 0.5em;">
                        <i class="fas fa-chevron-circle-left"></i>
                        Back
                      </button>

                      <!-- <button type="button" class="btn btn-success pull-right"
                          id="pdfBtn" style="margin: 0.5em;">
                          <i class="far fa-file-pdf"></i>
                          PDF
                      </button> -->

                      <button type="button" class="btn btn-success pull-right"
                          id="excelBtn" style="margin: 0.5em;">
                          <i class="far fa-file-excel"></i>
                          EXCEL
                      </button>
                    </header>

                    <div class="panel-body">
                       <div>
           

                       <div class="row" id="all-product-div" style="width: 100%;">
                          
                       </div> 
                       <div id="editor"></div>

                    </div>
                </section>
            </div>
        </div>                      
    </div>
   
         
</section>

<!--main content end-->
</section>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script> -->
<script type="text/javascript">
    function showProductDropDown(select){  
      $("#product-name-div").show();
      $("#machine-name-div").hide();
    }
    function showMachineDropDown(select){
      $("#machine-name-div").show();
      $("#product-name-div").hide();
    }


    function sizeWise(select){
      $("#machine-name-div").hide();
      $("#product-name-div").hide();
    }

    function page(){
     let selectValue = $('input[name="radio"]:checked').val();
     if(selectValue == "size-wise"){
      window.location.replace("size_report.php");
     }
    }

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
        let tbl = jQuery("#"+tableId+"-table");
        let dateCol = columns.indexOf("DATE");
        jQuery.moveColumn(tbl, dateCol, 0);
    }

    var calculateTotal = function(tableId) {
    $('#'+tableId+'-table').find('tr').each(function() { 
      $(this).find('th').eq(-1).after('<th>TOTAL</th>'); 
      $(this).find('td').eq(-1).after('<td class="total-cell"></td>'); 
    });

    $('#'+tableId+'-table').find('tr').each(function (index) {
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

  };

  var calculateColumnTotal = function(tableId) {
    /*  TO CALCULATE THE TOTAL OF ALL COLUMNS  */
        var result = [];
        $('#'+tableId+'-table tr').each(function(){
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

        $('#'+tableId+'-table').append('<tr></tr>');
        $(result).each(function(){
          $('table tr').last().append('<td class="total-cell">'+this+'</td>')
        });
        /*  ADD COLUMN TOTAL ENDS HERE */
  };
 
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
    }

    var merge = function() {
        $('#report-table').margetable({
            type: 2,
            colindex: [0]
        });
    };

    var productArr = Object.keys(sizeArray);
    var createTables = function() {
      for(let i=0; i<productArr.length; i++) {
        let table = "<hr> <h3>"+productArr[i]+"</h3><hr> <div class='tableFixHead'><table class='table table-striped' id='"+productArr[i].split(" ")[0]+"-table'> </table> </div>";
        $("#all-product-div").append(table);
      }
    };

    var renderTables = function() {
      for(let i=0; i<productArr.length; i++) {
        let sizeArrayArr = sizeArray[productArr[i]];
        sizeArrayArr = sizeArrayArr[0];
        var array = [];
        var resArr = [];
        sizeArrayArr.forEach(rec => {
          array.indexOf(rec.DATE) === -1 ? array.push(rec.DATE) : console.log("");
        });
        
        for(let m=0; m<array.length; m++) {
            let resObj = {};
            let dateArr = sizeArrayArr.filter((record) => record.DATE == array[m]);
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
         $.when(buildTable(productArr[i].split(" ")[0], resArr)).then(function() {
            $.when(calculateTotal(productArr[i].split(" ")[0])).then(function() {
              calculateColumnTotal(productArr[i].split(" ")[0]);
            }); 
         });
         //buildTable(productArr[i].split(" ")[0], resArr);
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

    // var doc = new jsPDF("l"),
    //             margins = {
    //                 top: 30,
    //                 bottom: 40,
    //                 left: 35,
    //                 width: 600
    //             };
    // var specialElementHandlers = {
    //     '#editor': function (element, renderer) {
    //         return true;
    //     }
    // };

    // $('#pdfBtn').click(function () {
    //   doc.setFont("helvetica");
    //   doc.setFontType("bold");
    //   doc.setFontSize(5);
    
    //     doc.fromHTML($('#all-product-div').html(),  
    //              margins.left // x coord
    //             , margins.top // y coord
    //             , {
    //                 'width': margins.width,
    //                 'elementHandlers': specialElementHandlers
    //               });
    //     doc.save('AllProductReport.pdf');
    // });
    
    // $('#excelBtn').click(function () {
    //   productArrTableIds = [];
    //   productArr.forEach(rec => productArrTableIds.push(rec.split(" ")[0]+"-table"));
    //   // tablesToExcel(productArrTableIds, productArr, 'AllProductReport.xls', 'Excel');
    // });

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
      //createTables();
      $.when(createTables()).then(function() {
        renderTables();
      });
      /*
      $.when(buildTable()).then(function() {
        merge();
      });
      */
    });


// var result = [];

//   sizeArray.reduce(function(res, value) {
//   if (!res[value.SIZE]) {
//     res[value.SIZE] = { SIZE: value.SIZE, STOCK: 0 };
//     result.push(res[value.SIZE])
//   }
//   res[value.SIZE].STOCK += parseInt(value.STOCK_VALUE);
//   return res;
// }, {});

</script>
</body>
</html>
