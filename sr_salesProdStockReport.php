<?php
session_start();
include 'db_connect.php';

function getSalesValueFromArray($productConf, $arr)
{
    $salesQty = 0;
    for ($j = 0; $j < sizeof($arr); $j++) {
        $obj = $arr[$j];
        $keys = array_keys($obj);
        if ($keys[0] == $productConf) {
            $salesQty = $obj[$productConf];
            break;
        }
    }
    return $salesQty;
}

if (isset($_GET['fromDate'])) {
    $trueFromDate = $_GET['fromDate'];
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $type = $_GET['type'];
    $isCont = false;
    do {
        $resultQuery = "SELECT 
                            DPT.DATE, C.PRODUCT_NAME, DPT.TYPE, DPT.SIZE, DPT.THICKNESS, SUM(DPT.PRODUCTION) AS TOTAL_PRODUCTION, MAX(DPT.TOTAL_STOCK) AS TOTAL_STOCK
                            FROM `daily_production_tracker` DPT, `category` C 
                            WHERE 1=1 
                            AND C.PRODUCT_ID = DPT.PRODUCT_ID 
                            AND DPT.TYPE = '$type' 
                            AND DPT.DATE BETWEEN '$fromDate' AND '$toDate' 
                            GROUP BY DPT.DATE, DPT.PRODUCT_ID, DPT.TYPE, DPT.SIZE, DPT.THICKNESS 
                            ORDER BY DPT.DATE, C.PRODUCT_NAME, DPT.TYPE, DPT.SIZE, DPT.THICKNESS
                        ";
        $resultQueryProcess = mysqli_query($conn, $resultQuery);
        $numRow = mysqli_num_rows($resultQueryProcess);
        // echo "numRows = $numRow";
        if ($numRow == 0) {
            $isCont = true;
            $fromDate = date('Y-m-d', strtotime($fromDate . ' -1 day'));
        } else {
            $isCont = false;
        }
    } while ($isCont);

    $totalProductionArr = array();
    $resArr = array();
    $productionDateSet = array();
    $i = 0;
    while ($row = mysqli_fetch_array($resultQueryProcess)) {
        $data = array();
        $data["DATE"] = $row['DATE'];
        $data['TYPE'] = $row['TYPE'];
        $data['PRODUCT'] = $row['PRODUCT_NAME'];
        $data['SIZE'] = $row['SIZE'];
        $data['THICKNESS'] = $row['THICKNESS'];
        $data["PRODUCTION"] = $row['TOTAL_PRODUCTION'];
        $data["STOCK"] = $row['TOTAL_STOCK'];
        $data["SALES"] = 0;
        $productionDateSet[$i] = $row['DATE'] . "?" . $row['TYPE'] . "?" . $row['PRODUCT_NAME'] . "?" . $row['SIZE'] . "?" . $row['THICKNESS'];
        $totalProductionArr[$i] = $row['DATE'] . "?" . $row['TYPE'] . "?" . $row['PRODUCT_NAME'] . "?" . $row['SIZE'] . "?" . $row['THICKNESS'];
        array_push($resArr, $data);
        $i++;
    }
    $productionDateSet = array_unique($productionDateSet);

    $salesSql = "SELECT 
                SPI.DISPATCH_DATE, SPID.PRODUCT, SPID.TYPE, SPID.SIZE, SPID.THICKNESS, SUM(SPID.QUANTITY) AS TOTAL_SALES
                FROM `sample_pi_details` SPID, sample_pi SPI 
                WHERE 1 = 1 
                AND SPI.SAMPLE_PI_ID = SPID.SAMPLE_PI_ID  
                AND SPID.TYPE = '$type'
                AND SPI.DISPATCH_DATE BETWEEN '$fromDate' AND '$toDate'
                GROUP BY SPI.DISPATCH_DATE, SPID.PRODUCT, SPID.TYPE, SPID.SIZE, SPID.THICKNESS 
                ORDER BY SPI.DISPATCH_DATE, SPID.PRODUCT, SPID.TYPE, SPID.SIZE, SPID.THICKNESS
    ";
    $resultQueryProcess = mysqli_query($conn, $salesSql);

    $resArrSales = array();
    $salesDateSet = array();
    $i = 0;
    while ($row = mysqli_fetch_array($resultQueryProcess)) {
        $data = array();
        $data[$row['DISPATCH_DATE'] . "?" . $row['TYPE'] . "?" . $row['PRODUCT'] . "?" . $row['SIZE'] . "?" . $row['THICKNESS']] = $row['TOTAL_SALES'];
        $salesDateSet[$i] = $row['DISPATCH_DATE'] . "?" . $row['TYPE'] . "?" . $row['PRODUCT'] . "?" . $row['SIZE'] . "?" . $row['THICKNESS'];
        array_push($resArrSales, $data);
        $i++;
    }

    /*  
        Logic to calculate the production stock in which the product was sold on that day 
        but the production doen't happens that day  
    */
    // print_r($resArrSales); 
    $salesDateSet = array_unique($salesDateSet);

    $dateToAddInSizeArray = array_diff($salesDateSet, $productionDateSet);
    // print_r($dateToAddInSizeArray);
    $keys = array_keys($dateToAddInSizeArray); // gets the index value 
    // print_r(array_keys($dateToAddInSizeArray));
    // print_r(sizeof($dateToAddInSizeArray));
    for ($i = 0; $i < sizeof($dateToAddInSizeArray); $i++) {
        $productConfStr = $dateToAddInSizeArray[$keys[$i]];
        $productConfArr = explode('?', $productConfStr);
        $date           = $productConfArr[0];
        $type           = $productConfArr[1];
        $productName    = $productConfArr[2];
        $size           = $productConfArr[3];
        $thickness      = $productConfArr[4];
        $salesQty       = getSalesValueFromArray($productConfStr, $resArrSales);

        $isContinue     = false;
        $dayBefore = date('Y-m-d', strtotime($date . ' -1 day'));
        do {
            $queryDate = $dayBefore;
            $resultQuery = "SELECT 
                            DPT.DATE, C.PRODUCT_NAME, DPT.TYPE, DPT.SIZE, DPT.THICKNESS, SUM(DPT.PRODUCTION) AS TOTAL_PRODUCTION, MAX(DPT.TOTAL_STOCK) AS TOTAL_STOCK
                            FROM `daily_production_tracker` DPT, `category` C 
                            WHERE 1=1 
                            AND C.PRODUCT_ID = DPT.PRODUCT_ID 
                            AND DPT.TYPE = '$type' 
                            AND DPT.SiZE = '$size' 
                            AND DPT.THICKNESS = '$thickness' 
                            AND C.PRODUCT_NAME = '$productName' 
                            AND DPT.DATE = '$queryDate' 
                            GROUP BY DPT.DATE, DPT.PRODUCT_ID, DPT.TYPE, DPT.SIZE, DPT.THICKNESS 
                            ORDER BY DPT.DATE, C.PRODUCT_NAME, DPT.TYPE, DPT.SIZE, DPT.THICKNESS
                        ";
            $resultQueryProcess = mysqli_query($conn, $resultQuery);
            $queryCount = mysqli_num_rows($resultQueryProcess);
            $queryCount = 1;
            if ($queryCount == 0) {
                $isContinue = true;
                $dayBefore = date('Y-m-d', strtotime($dayBefore . ' -1 day'));
            } else {
                $isContinue = false;
                // echo "Query Executed"; 
                $productStockConf = $queryDate . "?" . $type . "?" . $productName . "?" . $size . "?" . $thickness;
                $beforeDaysSales  = getSalesValueFromArray($productStockConf, $resArrSales);
                while ($row = mysqli_fetch_array($resultQueryProcess)) {
                    $data = array();
                    $data["DATE"] = $date;
                    $data['TYPE'] = $row['TYPE'];
                    $data['PRODUCT'] = $row['PRODUCT_NAME'];
                    $data['SIZE'] = $row['SIZE'];
                    $data['THICKNESS'] = $row['THICKNESS'];
                    $data["PRODUCTION"] = 0;
                    $data["STOCK"] = $row['TOTAL_STOCK'] - $beforeDaysSales;
                    $data["SALES"] = $salesQty;
                    $data["BALANCE"] = $data["STOCK"] - $salesQty;
                    // $productionDateSet[$i] = $row['DATE']."?".$row['TYPE']."?".$row['PRODUCT_NAME']."?".$row['SIZE']."?".$row['THICKNESS'];
                    // $totalProductionArr[$i] = $row['DATE']."?".$row['TYPE']."?".$row['PRODUCT_NAME']."?".$row['SIZE']."?".$row['THICKNESS'];
                    array_push($resArr, $data);
                }
            }
        } while ($isContinue);
    }

?>
    <script type="text/javascript">
        var convertObjectToArray = function(obj) {
            let keys = Object.keys(obj);
            let resArr = Array();
            for (let i = 0; i < keys.length; i++) {
                resArr[i] = obj[keys[i]];
            }
            return resArr;
        };

        var sizeArray = <?php echo json_encode($resArr); ?>;
        var totalProductionArr = <?php echo json_encode($totalProductionArr); ?>;
        var salesArray = <?php echo json_encode($resArrSales); ?>;
        var productionDateSet = <?php echo json_encode($productionDateSet); ?>;
        var productionDateArr = Array();
        var salesDateSet = <?php echo json_encode($salesDateSet); ?>;
        var salesDateArr = Array();

        // let lengthOfArr         = productionDateSet.length;
        // productionDateArr       = lengthOfArr == undefined ? convertObjectToArray(productionDateSet) : productionDateSet;
        // lengthOfArr             = salesDateSet.length;
        // salesDateArr            = lengthOfArr == undefined ? convertObjectToArray(salesDateSet) : salesDateSet;
        // var dateToAddInSizeArray= salesDateArr.filter( function( el ) {
        //                             return productionDateArr.indexOf( el ) < 0;
        //                           }); 

        for (let i = 0; i < totalProductionArr.length; i++) {
            let obj = salesArray.filter(rec => rec[totalProductionArr[i]])[0];
            let value = obj && obj[totalProductionArr[i]] ? obj[totalProductionArr[i]] : 0;
            sizeArray[i]["SALES"] = value;
            sizeArray[i]["BALANCE"] = sizeArray[i]["STOCK"] - sizeArray[i]["SALES"];
        }

        let ed = new Date("<?php echo $toDate; ?>");
        let sd = new Date("<?php echo $trueFromDate; ?>");
        sizeArray = sizeArray.filter(d => {
            var time = new Date(d["DATE"]);
            return (time >= sd && time <= ed);
        });

        // To Sort the array based on date
        sizeArray.sort(function(date1, date2) {
            let d1 = new Date(date1.DATE);
            let d2 = new Date(date2.DATE);
            return d1 - d2;
        });
        var result = {};
    </script>
<?php
}

?>
<!DOCTYPE html>

<head>
    <title>Sales Vs Production Vs Stock Report</title>
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
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked~.checkmark:after {
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
        margin: 50px;
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
</style>


<link rel="stylesheet" href="https	://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script> -->
<!-- <script src="js/jquery.table2excel.min.js"></script> -->

<body>
    <?php include 'header.php'; ?>

    <section id="main-content">
        <section class="wrapper">
            <div class="form-w3layouts">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Sales Vs Production Vs Stock Report
                                <button type="button" class="btn btn-primary pull-left" onclick="location.href = 'sr_home.php';" style="margin: 0.5em;">
                                    <i class="fas fa-chevron-circle-left"></i>
                                    Back
                                </button>

                                <button type="button" class="btn btn-success pull-right" id="pdfBtn" style="margin: 0.5em;">
                                    <i class="far fa-file-excel"></i>
                                    EXPORT
                                </button>
                            </header>

                            <div class="panel-body">
                                <div>

                                    <center>
                                        <h3>Report between (<?php echo $trueFromDate; ?> to <?php echo $toDate; ?>)</h3>
                                    </center>

                                    <div class="row tableFixHead" style="width: 100%; overflow: auto; max-height: 500px;">
                                        <table class="table table-striped table2excel_with_colors" id='report-table-all'>

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
        var buildTable = function(arr, divId) {
            var columns = addAllColumnHeaders(arr, divId);

            for (var i = 0; i < arr.length; i++) {
                var row$ = $('<tr/>');
                for (var colIndex = 0; colIndex < columns.length; colIndex++) {
                    var cellValue = arr[i][columns[colIndex]];

                    if (cellValue == null) {
                        cellValue = "";
                    }

                    row$.append($('<td/>').html(cellValue));
                }
                $("#" + divId).append(row$);
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

            for (var i = 0; i < arr.length; i++) {
                var rowHash = arr[i];
                for (var key in rowHash) {
                    if ($.inArray(key, columnSet) == -1) {
                        columnSet.push(key);
                        headerTr$.append($('<th/>').html(key));
                    }
                }
            }

            $("#" + divId).append(headerTr$);

            return columnSet;
        }

        $("#pdfBtn").click(function(e) {
            var table = $("#report-table-all");
            let php = "" + <?php echo "'" . str_replace("-", "/", $fromDate) . "'"; ?> + "".toString();
            let fileName = "DailyReport(" + php.toString() + ").xls";

            // tablesToExcel(["report-table-all"], [php], fileName, 'Excel');

        });

        //   var tablesToExcel = (function() {
        //     var uri = 'data:application/vnd.ms-excel;base64'
        //     , tmplWorkbookXML = <?php echo '<?xml version="1.0" encoding="utf-8" ?> <?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'; ?>
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


        var merge = function(divId) {
            $('#' + divId).margetable({
                type: 2,
                colindex: [0, 1, 2, 3, 4]
            });
        };

        jQuery.moveColumn = function(table, from, to) {
            var rows = jQuery('tr', table);
            var cols;
            rows.each(function() {
                cols = jQuery(this).children('th, td');
                cols.eq(from).detach().insertBefore(cols.eq(to));
            });
        }

        $(document).ready(function() {
            $.when(buildTable(sizeArray, 'report-table-all')).then(function() {
                //MOVE THE U.P COLUMN TO THE LAST OF THE TABLE
                //  let columns = addAllColumnHeaders(sizeArray);
                //  let tbl = jQuery('#report-table');
                //  let upCol = columns.indexOf("U.P");
                //  jQuery.moveColumn(tbl, upCol, 0);

                merge('report-table-all', 0);
                merge('report-table-all', 1);
                merge('report-table-all', 2);
            });

        });
    </script>
</body>

</html>