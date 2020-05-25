<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>

<head>
    <title>Accounts Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js"></script>
<script src="https://cdn.rawgit.com/mkoryak/floatThead/master/dist/jquery.floatThead.min.js"></script>
<?php
include './demo.css';
?>
<?php
include './demo.js';
?>
<style type="text/css">
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
                                Accounts Report
                            </header>
                            <div class="panel-body">
                                <div>
                                    <div class="row position-center" style="width: 100%;">
                                        <div class="col-sm-12">
                                            <div id="from-to-date-div">
                                            <div class="col-sm-2">&nbsp;</div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="usr">From Date:</label>
                                                        <input type="date" class="form-control" id="from-date-input">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="usr">To Date:</label>
                                                        <input type="date" class="form-control" id="to-date-input">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">&nbsp;</div>
                                            </div>
                                        </div>
                                        </br></br>
                                        <button type="submit" class="btn btn-info" name="submit" onclick="showReport()" style="margin-left: 45%;">Show Report</button>

                                    </div>
                                </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <script>
        var validate = function(fromDate, toDate) {
            if (fromDate == undefined || fromDate == null || fromDate == "") {
                alert("Fromdate is mandatory!");
                return false;
            }
            if (toDate == undefined || toDate == null || toDate == "") {
                alert("Todate is mandatory!");
                return false;
            }
            return true;
        };

        var showReport = function() {
            let fromDate = $("#from-date-input").val();
            let toDate = $("#to-date-input").val();
            let canShowReport = validate(fromDate, toDate);
            if (canShowReport) {
                window.location.replace("ar_transaction.php?fromDate=" + fromDate + "&toDate=" + toDate);
            } else {
                return false;
            }
        };
    </script>
</body>

</html>