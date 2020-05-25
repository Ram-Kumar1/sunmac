<?php
session_start();
include 'db_connect.php';

if (isset($_GET['fromDate'])) {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];

    $sql = "SELECT Q.FOLLOWED_BY_PERSON, COUNT(1) AS CNT
                        FROM quotation Q 
                        WHERE 1=1
                        AND Q.Q_DATE BETWEEN '$fromDate' AND '$toDate'
                        GROUP BY FOLLOWED_BY_PERSON
                        ORDER BY FOLLOWED_BY_PERSON
                    ";
    $resultQueryProcess = mysqli_query($conn, $sql);
    $quotationArr = array();
    while ($row = mysqli_fetch_array($resultQueryProcess)) {
        $quotationArr[$row['FOLLOWED_BY_PERSON']] = $row['CNT'];
    }
    
    $sql = "SELECT SPI.FOLLOWED_BY_PERSON, COUNT(1) AS CNT
                        FROM sample_pi SPI
                        WHERE 1=1
                        AND SPI.DATE BETWEEN '$fromDate' AND '$toDate'
                        GROUP BY FOLLOWED_BY_PERSON
                        ORDER BY FOLLOWED_BY_PERSON
                    ";
    $resultQueryProcess = mysqli_query($conn, $sql);
    $piArr = array();
    while ($row = mysqli_fetch_array($resultQueryProcess)) {
        $piArr[$row['FOLLOWED_BY_PERSON']] = $row['CNT'];
    }

    $sql = "SELECT SPI.FOLLOWED_BY_PERSON, COUNT(1) AS CNT
                        FROM sample_pi SPI
                        WHERE 1=1
                        AND SPI.INVOICE_STATUS > 0
                        AND SPI.DATE BETWEEN '$fromDate' AND '$toDate'
                        GROUP BY FOLLOWED_BY_PERSON
                        ORDER BY FOLLOWED_BY_PERSON
                    ";
    $resultQueryProcess = mysqli_query($conn, $sql);
    $invoiceArr = array();
    while ($row = mysqli_fetch_array($resultQueryProcess)) {
        $invoiceArr[$row['FOLLOWED_BY_PERSON']] = $row['CNT'];
    }

    $accQry = "SELECT SPI.FOLLOWED_BY_PERSON, SPI.CUSTOMER_NAME, SPI.REFERENCE_NO, SPI.TOTAL_AMOUNT, SPI.GST_AMOUNT, TB.BALANCE
                    FROM sample_pi SPI, transaction_balance TB
                    WHERE 1=1
                    AND SPI.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
                    AND SPI.INVOICE_STATUS = 4
                    AND SPI.DISPATCH_DATE BETWEEN  '$fromDate' AND '$toDate'
                    ORDER BY SPI.FOLLOWED_BY_PERSON, SPI.CUSTOMER_NAME
                ";
    
    $resArr = array();
    $resultQueryProcess = mysqli_query($conn, $accQry);
    while ($row = mysqli_fetch_array($resultQueryProcess)) {
        $data = array();
        $data['Followed By'] = $row['FOLLOWED_BY_PERSON'];
        $data['Quotation'] = isset($quotationArr[$row['FOLLOWED_BY_PERSON']]) ? $quotationArr[$row['FOLLOWED_BY_PERSON']] : "";
        $data['P.I'] = $piArr[$row['FOLLOWED_BY_PERSON']];
        $data['Invoice'] = $invoiceArr[$row['FOLLOWED_BY_PERSON']];
        $data['Customer'] = $row['CUSTOMER_NAME'];
        $data['Refrence No'] = $row['REFERENCE_NO'];
        $data['Product Value'] = $row['TOTAL_AMOUNT'] - $row['GST_AMOUNT'];
        $data['STATUS'] = $row['BALANCE'];
        array_push($resArr, $data);
    }

}

?>
<script type="text/javascript">
    var sizeArray = <?php echo json_encode($resArr); ?>;
    var result = {};
</script>

<!DOCTYPE html>

<head>
    <title>Followup Report</title>
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

    td {
        color: red !important;
    }

    td.balance0 {
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

    td.total-cell {
        /* color: aqua; */
        background: #eee;
    }

    i.fa.fa-check {
        color: greenyellow !important;
    }

    /* td {
        min-width: 10em;
    }

    td.Followed.By {
        min-width: 15em;
    }

    td.Customer {
        min-width: 18em;
    }

    td.pending {
        color: red !important;
    } */
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
                                Followup
                                <button type="button" class="btn btn-primary pull-left" onclick="location.href = 'fr_home.php';" style="margin: 0.5em;">
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
                                        <h3>Report between (<?php echo $fromDate; ?> to <?php echo $toDate; ?>)</h3>
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
                    let columnHeader = columns[colIndex];
                    if (cellValue == null) {
                        cellValue = "";
                    }
                    let color = arr[i][columns[7]] > 0 ? "red" : "black";
                    if(colIndex == 7 && arr[i][columns[7]] == 0) {
                        cellValue = '<i class="fa fa-check" aria-hidden="true"></i>';
                    } else if(colIndex == 7 && arr[i][columns[7]] > 0) {
                        cellValue = '<i class="fa fa-times" aria-hidden="true"></i>';
                    } else {
                        cellValue = cellValue
                    }
                    row$.append($('<td style="color:  '+color+' !important" />').html(cellValue));
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
            let php = "" + <?php echo "Quotation"; ?> + "".toString();
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
                colindex: [0, 1, 2, 3]
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

        var calculateColumnTotal = function(tableId) {
            /*  TO CALCULATE THE TOTAL OF ALL COLUMNS  */
            var result = [];
            $('#' + tableId + ' tr').each(function() {
                $('td', this).each(function(index, val) {
                    if (index <= 3 || index == 10) {
                        result[index] = '';
                    } else {
                        if (!result[index]) {
                            result[index] = 0;
                        }
                        result[index] += parseFloat($(val).text());
                    }
                });
            });

            $('#' + tableId).append('<tr></tr>');
            $(result).each(function() {
                $('table tr').last().append('<td class="total-cell">' + this + '</td>')
            });
            /*  ADD COLUMN TOTAL ENDS HERE */
        };

        $(document).ready(function() {
            $.when(buildTable(sizeArray, 'report-table-all')).then(function() {
                //MOVE THE U.P COLUMN TO THE LAST OF THE TABLE
                //  let columns = addAllColumnHeaders(sizeArray);
                //  let tbl = jQuery('#report-table');
                //  let upCol = columns.indexOf("U.P");
                //  jQuery.moveColumn(tbl, upCol, 0);
                merge('report-table-all', 0);
                $(".fa-bars").click();
                // calculateColumnTotal('report-table-all');
            });

        });
    </script>
</body>

</html>