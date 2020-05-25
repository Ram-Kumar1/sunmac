<?php
session_start();
include 'db_connect.php';
if(isset($_GET['productId'])){
  $productId = $_GET['productId'];
  $type = $_GET['type'];
  $size = $_GET['size'];
  $productName = "";

$resultQuery = "SELECT C.PRODUCT_NAME, S.thickness, S.STOCK_VALUE, S.STOCK_VALUE AS STOCK_WEIGHT 
FROM `product_stock_weight` S, `category` C WHERE 1=1 
AND S.TYPE='$type' 
AND S.SIZE='$size' 
AND S.PRODUCT_ID=$productId 
AND S.PRODUCT_ID=C.PRODUCT_ID
";
$resultQueryProcess = mysqli_query($conn,$resultQuery);
$resArrStock = array();
while ($row = mysqli_fetch_array($resultQueryProcess)) {
  $resArrStock[$row['thickness']] = $row['STOCK_WEIGHT'];
}

$resultQuery = "SELECT C.PRODUCT_NAME, S.thickness, S.STOCK_VALUE, S.TYPE, S.SIZE 
FROM `product_stock` S, `category` C WHERE 1=1 
AND S.TYPE='$type' 
AND S.SIZE='$size' 
AND S.PRODUCT_ID=$productId 
AND S.PRODUCT_ID=C.PRODUCT_ID
";
$resultQueryProcess = mysqli_query($conn,$resultQuery);
$resArr = array();
while ($row = mysqli_fetch_array($resultQueryProcess)) {
  $data = array();
  $data["Product Name"] = $row['PRODUCT_NAME'];
  $productName = $row['PRODUCT_NAME'];
  $data["Type"] = $row['TYPE'];
  $data["Size"] = $row['SIZE'];
  $data["Thickness"] = $row['thickness'];  
  $data["Total Stock"] = $row['STOCK_VALUE'];
  $data["Total Weight"] = $resArrStock[$row['thickness']];

  array_push($resArr, $data); 
}

?>
<script type="text/javascript">
  var sizeArray = <?php echo json_encode($resArr); ?>;
  var result = {};
</script>
<?php
}




?>
<!DOCTYPE html>
<head>
<title>Stock Report</title>
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
                      Stock Report - <?php echo $productName; ?>
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
					  <input style="float:right;margin-top:6px" type="button" id="btnExport" class="btn btn-info" value="Export" onclick="Export()"/>
                    </header>

                    <div class="panel-body">
                       <div>
           
<div class="row tableFixHead" style="width: 100%;">
  <table class="table table-striped tblCustomers" id='report-table-all'>

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
        $('#' + divId).margetable({
            type: 2,
            colindex: [0,1,2]
        });
    };
    $(document).ready(function(){
      $.when(buildTable(sizeArray, 'report-table-all')).then(function() {
        merge('report-table-all');
      });

      // $.when(buildTable(sizeArray1, 'report-table-product')).then(function() {
      //   merge('report-table-product');
      // });
      
    });




</script>
<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="new_js/table2excel.js" type="text/javascript"></script>
    <script type="text/javascript">
        function Export() {
            $(".tblCustomers").table2excel({
                filename: "Table.xls"
            });
        }
    </script> -->
</body>
</html>
