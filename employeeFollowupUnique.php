<?php
session_start();
include 'db_connect.php';
$empName = $_SESSION['userName'];
$empSql = 'SELECT EMPLOYEE_NAME FROM employee_details WHERE USER_NAME = "' . $empName . '"';
$resultQueryProcess = mysqli_query($conn, $empSql);
while ($row = mysqli_fetch_array($resultQueryProcess)) {
    $empName = $row['EMPLOYEE_NAME'];
}

$sql = 'SELECT COUNT(1) AS CNT, DATE_FORMAT(Q_DATE, "%Y-%m") AS DTE
                        FROM quotation Q
                        WHERE 1=1
                        AND Q.FOLLOWED_BY_PERSON LIKE "%-' . $empName . '"
                        GROUP BY DATE_FORMAT(Q_DATE, "%Y-%m-01")
                        ORDER BY DATE_FORMAT(Q_DATE, "%Y-%m-01") DESC
                    ';
$resultQueryProcess = mysqli_query($conn, $sql);
$quotationArr = array();
$dateArr = array();
while ($row = mysqli_fetch_array($resultQueryProcess)) {
    array_push($dateArr, $row['DTE']);
    $quotationArr[$row['DTE']] = $row['CNT'];
}

// print_r($quotationArr);

$sql = 'SELECT COUNT(1) AS CNT, DATE_FORMAT(DATE, "%Y-%m") AS DTE
                        FROM sample_pi SPI
                        WHERE 1=1
                        AND SPI.FOLLOWED_BY_PERSON  LIKE "%-' . $empName . '"
                        GROUP BY DATE_FORMAT(DATE, "%Y-%m-01")
                        ORDER BY DATE_FORMAT(DATE, "%Y-%m-01") DESC
                    ';
$resultQueryProcess = mysqli_query($conn, $sql);
$piArr = array();
while ($row = mysqli_fetch_array($resultQueryProcess)) {
    $piArr[$row['DTE']] = $row['CNT'];
}

$sql = 'SELECT COUNT(1) AS CNT, DATE_FORMAT(DATE, "%Y-%m") AS DTE
                        FROM sample_pi SPI
                        WHERE 1=1
                        AND SPI.INVOICE_STATUS > 0
                        AND SPI.FOLLOWED_BY_PERSON  LIKE "%-' . $empName . '"
                        GROUP BY DATE_FORMAT(DATE, "%Y-%m-01")
                        ORDER BY DATE_FORMAT(DATE, "%Y-%m-01") DESC
                    ';
$resultQueryProcess = mysqli_query($conn, $sql);
$invoiceArr = array();
while ($row = mysqli_fetch_array($resultQueryProcess)) {
    $invoiceArr[$row['DTE']] = $row['CNT'];
}

$resArr = array();
for ($i = 0; $i < sizeof($dateArr); $i++) {
    $data = array();
    $data['Date'] = $dateArr[$i];
    $data['Quotation'] = $quotationArr[$dateArr[$i]];
    $data['P.I'] = $piArr[$dateArr[$i]];
    $data['Invoice'] = $invoiceArr[$dateArr[$i]];
    array_push($resArr, $data);
}

?>

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
                                <!-- <button type="button" class="btn btn-primary pull-left" onclick="location.href = 'fr_home.php';" style="margin: 0.5em;">
                                    <i class="fas fa-chevron-circle-left"></i>
                                    Back
                                </button> -->

                                <!-- <button type="button" class="btn btn-success pull-right" id="pdfBtn" style="margin: 0.5em;">
                                    <i class="far fa-file-excel"></i>
                                    EXPORT
                                </button> -->
                            </header>

                            <div class="panel-body">
                                <div>

                                    <div class="table-responsive cus-tbl notify-w3ls panel panel-primary filterable">
                                        <div class="pull-right">
                                            <button class="btn btn-default btn-xs btn-filter"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
                                        </div>
                                        <table class="table tableFixHead table-striped table-hover">
                                            <thead>
                                                <tr style="color:#0c1211" ;>
                                                <tr class="filters">
                                                    <th style="color:#0c1211; background: #428bca;"><input type="text" class="form-control col-sm-1" placeholder="Date" disabled></th>
                                                    <th style="color:#0c1211; background: #428bca;">Quotation</th>
                                                    <th style="color:#0c1211; background: #428bca;">P.I</th>
                                                    <th style="color:#0c1211; background: #428bca;">Status</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            for ($i = 0; $i < sizeof($resArr); $i++) {
                                            ?>
                                                <tbody>
                                                    <tr>
                                                        <td style="color:#0c1211" ;><?php echo $resArr[$i]["Date"]; ?></td>
                                                        <td style="color:#0c1211;"><?php echo $resArr[$i]["Quotation"]; ?></td>
                                                        <td style="color:#0c1211" ;><?php echo $resArr[$i]["P.I"] ?></td>
                                                        <td style="color:#0c1211" ;><?php echo $resArr[$i]["Invoice"] ?></td>
                                                    </tr>
                                                </tbody>
                                            <?php
                                            }
                                            ?>
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



</body>

</html>