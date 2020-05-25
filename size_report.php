<?php
session_start();
include 'db_connect.php';

$type = $_GET['type'];
// $sizeDate = $_GET['date'];
// $query = "SELECT PS.SIZE, C.PRODUCT_NAME, S.`THICKNESS`, S.`TOTAL_STOCK` FROM category C, `daily_production_tracker` S, production_size PS WHERE 1=1 AND S.TYPE = '$type' AND PS.SIZE = S.SIZE AND C.PRODUCT_ID = S.PRODUCT_ID AND S.DATE='$sizeDate' ORDER BY PS.SIZE, C.PRODUCT_NAME, S.`THICKNESS`";
$query = "SELECT PS.SIZE, C.PRODUCT_NAME, S.`THICKNESS`, S.`STOCK_VALUE` AS TOTAL_STOCK FROM category C, `product_stock` S, production_size PS WHERE 1=1 AND S.TYPE = '$type' AND PS.SIZE = S.SIZE AND C.PRODUCT_ID = S.PRODUCT_ID ORDER BY PS.SIZE, C.PRODUCT_NAME, S.`THICKNESS`";
$mysql = mysqli_query($conn,$query);
// $resNum = mysqli_num_rows($mysql);
$resArr = array();
$total = 0;
// if($resNum > 0) {
  while ($row = mysqli_fetch_array($mysql)) {
    $data = array();
    $data["SIZE"] = $row['SIZE'];
    $data["PRODUCT NAME"] = $row['PRODUCT_NAME'];
    $data["THICKNESS"] = $row['THICKNESS'];
    $data["NUMBERS"] = $row['TOTAL_STOCK'];
  
    array_push($resArr, $data); 
  }
// }

?>
<script type="text/javascript">
  var sizeArray = <?php echo json_encode($resArr); ?>;
  var result = {};

  sizeArray.reduce(function(res, value) {
      if (!result[value.SIZE]) {
        result[value.SIZE] = 0;
        //result.push(res[value.SIZE])
      }
      result[value.SIZE] += parseInt(value.NUMBERS);
      return result;
    }, {});

  sizeArray.forEach((rec)=>{
    rec["TOTAL STOCK"] = result[rec["SIZE"]];
  });
  
</script>
<?php
?>
<!DOCTYPE html>
<head>
<title>Size Wise Report</title>
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

/* .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1)  {
   background-color: #ddede0;
} */

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
                      Size Report
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

var buildTable = function() {
        var columns = addAllColumnHeaders(sizeArray);
    
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

    var merge = function() {
        $('#report-table').margetable({
            type: 2,
            colindex: [0, 1, 4]
        });
    };

    $("#excelBtn").click(function(e){
          var table = $("#report-table");
          let php = "SizeReport";
          let fileName = php + ".xls";
            
        //  tablesToExcel(["report-table"], [php], fileName, 'Excel');

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
      $.when(buildTable()).then(function() {
        merge();
      });
      
    });

</script>
</body>
</html>
