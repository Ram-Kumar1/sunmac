<?php 
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$firstDay = date('Y-m-01'); // hard-coded '01' for first day
$lastDay = date('Y-m-t');

$quotationCount = 0;
$pendingAmtCount = 0;
$sampleInvoiceCount = 0;
$invoiceCount = 0;

$quotationQry = "SELECT COUNT(1) AS CNT FROM `quotation` WHERE Q_DATE BETWEEN '$firstDay' AND '$lastDay'";
$resultQ = mysqli_query($conn, $quotationQry);
while($row = mysqli_fetch_array($resultQ)) {
	$quotationCount = $row['CNT'];
}

$pendingAmtQry = "SELECT  COUNT(1) AS CNT
					FROM sample_pi S, transaction T, transaction_balance TB WHERE 1=1 
					AND S.SAMPLE_PI_ID = T.SAMPLE_PI_ID 
					AND S.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
					AND T.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
					AND S.INVOICE_STATUS != 0 
					AND TB.IS_PENDING_AMOUNT = 1 
					AND TB.SHOW_TO_ACCOUNTS = 1 
					GROUP BY T.SAMPLE_PI_ID";
$resultPending = mysqli_query($conn, $pendingAmtQry);
// while($row = mysqli_fetch_array($resultPending)) {
	$pendingAmtCount = mysqli_num_rows($resultPending);
// }
$samplePiQry = "SELECT COUNT(1) AS CNT FROM `sample_pi` WHERE DATE BETWEEN '$firstDay' AND '$lastDay'";
$resultSpi = mysqli_query($conn, $samplePiQry);
while($row = mysqli_fetch_array($resultSpi)) {
	$sampleInvoiceCount = $row['CNT'];
}
$piQry = "SELECT COUNT(1)  AS CNT FROM `sample_pi` WHERE INVOICE_STATUS > 1 AND DATE BETWEEN '$firstDay' AND '$lastDay'";
$resultPi = mysqli_query($conn, $piQry);
while($row = mysqli_fetch_array($resultPi)) {
	$invoiceCount = $row['CNT'];
}

$piStatusSql = "SELECT COUNT(1) AS CNT FROM `quotation` Q WHERE 1 = 1 AND Q.Q_STATUS = '1'";
$piStatusResult = mysqli_query($conn,$piStatusSql);
$piStatus = 0;
while($row = mysqli_fetch_array($piStatusResult)) {
	$piStatus = $row['CNT'];
}
date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date_cur = date('Y-m-d', strtotime($date_1));
	
$followupStatusSql = "SELECT DISTINCT F_ID, S_ID, S_NAME, S_MOBILE, S_CITY, S_ALTERNATE_MOBILE, S_MAIL FROM ( 
	SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_CITY,SC.S_ALTERNATE_MOBILE,SC.S_MAIL 
	FROM followup F, sales_customer SC 
	WHERE 1=1 
	AND F.S_ID = SC.S_ID 
	AND F.CUSTOMER_STATUS = 0 
	AND F.CURRENT_FOLLOWUP_DATE = '$date_cur' 
	UNION 
	SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_CITY,SC.S_ALTERNATE_MOBILE,SC.S_MAIL 
	FROM followup F, sales_customer SC 
	WHERE 1=1 
	AND F.S_ID = SC.S_ID 
	AND F.F_STATUS = \"\" 
	AND F.CURRENT_FOLLOWUP_DATE < '$date_cur' ) 
	AS T GROUP BY S_NAME, S_MOBILE"
	;
$followupStatusResult = mysqli_query($conn, $followupStatusSql);
$followupStatus = mysqli_num_rows($followupStatusResult);

$sqlRem = "SELECT F.F_ID, F.S_ID,SC.S_NAME, SC.S_MOBILE,SC.S_ALTERNATE_MOBILE, SC.S_CITY, SC.S_MAIL, SC.S_MANUFACTURER_PRODUCTS, SC.S_DEALER_PRODUCTS FROM remainder_followup F, sales_customer SC
WHERE 1=1
AND F.S_ID = SC.S_ID
AND F.CUSTOMER_STATUS = 0 
AND F.FOLLOWUP_DATE <= '$date_cur' ";
$resultRem = mysqli_query($conn, $sqlRem);
$followupStatus += mysqli_num_rows($resultRem);

$accountSql = "SELECT S.SAMPLE_PI_ID, S.REFERENCE_NO, S.CUSTOMER_NAME, S.MOBILE, S.DATE, (S.TOTAL_AMOUNT - S.GST_AMOUNT) AS PRODUCT_AMOUNT, S.TOTAL_AMOUNT, S.GST_AMOUNT, 
				(S.TOTAL_AMOUNT - TB.BALANCE) AS ADVANCE, TB.BALANCE, S.INVOICE_STATUS, T.TRANSACTION_ID 
				FROM sample_pi S, transaction T, transaction_balance TB WHERE 1=1 
				AND S.SAMPLE_PI_ID = T.SAMPLE_PI_ID 
				AND S.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
				AND T.SAMPLE_PI_ID = TB.SAMPLE_PI_ID
				AND S.INVOICE_STATUS != 0 
				AND TB.SHOW_TO_ADMIN = 1 
				AND TB.IS_PENDING_AMOUNT = 0 
				GROUP BY T.SAMPLE_PI_ID 
				";
//$salesSql = "SELECT * FROM `quotation` WHERE `SHOW_TO_ADMIN`=1";
$salesSql = "SELECT q.QUOTATION_ID, s.S_NAME AS CUSTOMER_NAME, s.S_MOBILE AS CUSTOMER_MOBILE, q.Q_STATUS FROM quotation_followup q, sales_customer s WHERE 1 =1 
				and s.S_ID = q.CUSTOMER_ID
				and q.SHOW_TO_ADMIN = 1";

$piSql = "SELECT * FROM sample_pi s WHERE 1 = 1 
			and INVOICE_STATUS IN (1, 2, 3) 
			and `SHOW_TO_ADMIN`=1
			ORDER BY INVOICE_STATUS
			";

$noResponceSql = "SELECT * FROM sales_customer s, followup f WHERE 1 = 1
			and f.S_ID = s.S_ID
			and f.F_STATUS = 'noResponce'
			and `SHOW_TO_ADMIN`=1";

$follwUpSql = "SELECT * FROM sales_customer s, remainder_followup f WHERE 1 = 1
			and f.S_ID = s.S_ID 
			and f.CUSTOMER_STATUS = 0
			and `SHOW_TO_ADMIN`=1";
			//and f.FOLLOWUP_DATE <= CURDATE()
			

$irrelaventSql = "SELECT * FROM sales_customer s, followup f WHERE 1 = 1
			and f.S_ID = s.S_ID
			and f.F_STATUS = 'irrelevant'
			and `SHOW_TO_ADMIN`=1";

$refNoStatusSql = 'SELECT Q.REFERENCE_NO, Q.CUSTOMER_NAME, Q.Q_STATUS, SPI.INVOICE_STATUS,
					CASE WHEN Q.Q_STATUS = 1 THEN "Quotation"
					WHEN Q.Q_STATUS = 0 AND SPI.INVOICE_STATUS = 0 THEN "PI"
					WHEN Q.Q_STATUS = 0 AND SPI.INVOICE_STATUS = 1 THEN "PPI"
					WHEN Q.Q_STATUS = 0 AND SPI.INVOICE_STATUS = 2 THEN "Production Complete"
					WHEN Q.Q_STATUS = 0 AND SPI.INVOICE_STATUS = 3 THEN "Sales PPI"
					WHEN Q.Q_STATUS = 0 AND SPI.INVOICE_STATUS = 4 THEN "Invoice"
					END AS STATUS
					FROM quotation Q 
					LEFT JOIN sample_pi SPI ON Q.REFERENCE_NO = SPI.REFERENCE_NO 
					ORDER BY Q_DATE DESC';

?>
<!DOCTYPE html>
<head>
<title>SUNMAC Admin Pannel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js"></script>

<script src="https://cdn.rawgit.com/mkoryak/floatThead/master/dist/jquery.floatThead.min.js"></script>
<?php
include './demo.css';
?>
<?php
include './demo.js';
?>
</head>
<style>
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
.m-1 {
	margin-top: 1em;
}


.notify-w3ls {
	max-height: 500px !important;
    min-height: 500px !important;
    overflow: auto;
}

.cus-tbl {
	/* width: 150% !important; */
	min-height: 20em;
}

.spi-0 {
	color: red !important;
}

.spi-1 {
	color: red !important;
}

.spi-2 {
	color: red !important;
}

.spi-3 {
	color: limegreen !important;
}

.quo-0 {
	color: red !important;
}

.quo-1 {
	color: limegreen !important;
}

.table-responsive1 {
	width: 156% !important;
}

.min-report {
	width: 100%;
	min-height: 350px !important;
	max-height: 350px !important;
    overflow: auto !important;
}

td.color-condition.red {
    color: red !important;
}

#report-table > tbody > tr:nth-child(1) {
  color: beige;
}

.bal-0 {
  color: limegreen !important;
}
</style>

<body>


<?php include 'header.php'; ?>
<!--main content start-->

<section id="main-content">
	<section class="wrapper">
		<!-- //market-->
		<div class="market-updates">
			<div class="col-md-3 market-update-gd" id="quotation-col">
				<div class="market-update-block clr-block-2">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-eye"> </i>
					</div>
					 <div class="col-md-8 market-update-left">
					 <h4>Quotation</h4>
					<h3><?php echo $quotationCount; ?></h3>
					<p>No of quotation <br>sent this month</p>
				  </div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-3 market-update-gd" id="performa-col">
				<div class="market-update-block clr-block-1">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-users" ></i>
					</div>
					<div class="col-md-8 market-update-left">
					<h4>P.I</h4>
						<h3><?php echo $sampleInvoiceCount; ?></h3>
						<p>No of P.I <br>sent this month</p>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-3 market-update-gd" id="invoice-col">
				<div class="market-update-block clr-block-4">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					</div>
					<div class="col-md-8 market-update-left">
						<h4>Invoice</h4>
						<h3><?php echo $invoiceCount; ?></h3>
						<p>Number of Invoice created this month</p>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			<div class="col-md-3 market-update-gd" id="accounts-col">
				<div class="market-update-block clr-block-3">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-usd"></i>
					</div>
					<div class="col-md-8 market-update-left">
						<h4>Accounts</h4>
						<h3><?php echo $pendingAmtCount; ?></h3>
						<p>Total Accounts<br>(Pending)</p>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
			
		   <div class="clearfix"> </div>
		</div>	
		<div class="row market-updates">
			<div class="col-md-6 market-update-gd" id="pi-status">
				<div class="market-update-block clr-block-3"  style="background: #54f52cd4;">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-mobile" style="font-size: 3em; color: #fff; text-align: left;"></i>
					</div>
					<div class="col-md-8 market-update-left">
						<h4>PI Status</h4>
						<h3><?php echo $piStatus; ?></h3>
						<p></p>
					</div>
				<div class="clearfix"> </div>
				</div>
			</div>

			<div class="col-md-6 market-update-gd" id="followup-status">
				<div class="market-update-block clr-block-3" style="background: #8214fb;">
					<div class="col-md-4 market-update-right">
						<i class="fa fa-mobile" style="font-size: 3em; color: #fff; text-align: left;"></i>
					</div>
					<div class="col-md-8 market-update-left">
						<h4>Followup Status</h4>
						<h3><?php echo $followupStatus; ?></h3>
						<p></p>
					</div>
				  <div class="clearfix"> </div>
				</div>
			</div>
		</div>
		<!-- //market-->
		<div class="row" id="accounts-row">
			<div class="panel-body">
				<div class="col-md-12 w3ls-graph">
					<!--agileinfo-grap-->
						<div class="agileinfo-grap">
							<div class="agileits-box">
								<header class="agileits-box-header clearfix">
									<h3>Account Statements</h3>
										<div class="toolbar">
											
											
										</div>
								</header>
								<div class="agileits-box-body clearfix">
								<?php
if($result = mysqli_query($conn, $accountSql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive" style="max-height: 25em;">
                            <table class="table tableFixHead table-striped">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>S.No</th>
                                    <th style="color:#0c1211";>Refrence Id</th>
                                    <th style="color:#0c1211";>Date</th>
                                    <th style="color:#0c1211";>Total Amount</th>
                                    <th style="color:#0c1211";>Advance</th>
                                    <th style="color:#0c1211";>Balance</th>
                                    <th style="color:#0c1211";>Status</th>
									<th style="color:#0c1211";><i class="fa fa-trash" aria-hidden="true"></i></th>
                                </tr>
                             </thead>
<?php 
$i=0;
while($row = mysqli_fetch_array($result)){
	$i++;
?>
                           <tbody>
                              <tr id="account-id-<?php echo $row['SAMPLE_PI_ID']; ?>">
                                    <td style="color:#0c1211";>
                                      <!-- <a href="accounts_registery.php?invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" > -->
                                        <?php echo $i;?>
                                      <!--</a> -->
                                    </td>
                                    <td style="color:#0c1211"; id="custName-<?php echo $row['SAMPLE_PI_ID']; ?>">
										<a data-toggle="modal" class="refNo-info" id="refNo-<?php echo $row['SAMPLE_PI_ID']; ?>" href="">
                                        	<?php echo $row['REFERENCE_NO']?>
                                      	</a>
									</td>
                                    <td style="color:#0c1211";><?php echo $row['DATE']?></td>        
                                    <td style="color:#0c1211";><?php echo $row['TOTAL_AMOUNT']?></td>
                                    <td style="color:#0c1211";>
                                    <!-- href="#myModal" -->
                                      <a data-toggle="modal" class="transaction-info" id="transaction-<?php echo $row['SAMPLE_PI_ID']; ?>" href="">
                                        <?php echo $row['ADVANCE']?>
                                      </a>
                                    </td>
                                    <td style="color:<?php echo $row['BALANCE'] != 0 ? "red" : "limegreen"?>"><?php echo $row['BALANCE']?></td>
                                    <td style="color: limegreen;"; class="color-condition" data-balace=<?php echo $row['BALANCE']?>>
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <?php echo $row['BALANCE'] != 0 ? "Pending" : "Settled"?>
                                    </td>
                                    <td>
                                      <span class="<?php echo "bal-".$row['BALANCE'];?>" data-spiId="<?php echo $row['SAMPLE_PI_ID']; ?>" onclick="deleteAccounts(this);">
                                        <i class="fa fa-times <?php echo "bal-".$row['BALANCE'];?>" style="color: red;" aria-hidden="true"></i>
                                      </span>
                                    </td>
                               </tr>
                            </tbody>
 <?php
}
?>


                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
}
?> 
</div>
							</div>
							</div>
						</div>
	<!--//agileinfo-grap-->

				</div>
			</div>
		</div>
		<div class="agil-info-calendar">
		<!-- calendar -->
		<div class="col-md-6 w3agile-notifications" id="ppi-status">
			<div class="notifications">
				<!--notification start-->
				
					<header class="panel-heading">
						PPI Status 
					</header>
					<div class="notify-w3ls">
					<?php
if($result = mysqli_query($conn, $piSql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive">
                            <table class="table tableFixHead table-striped table-hover max-10">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211;">Customer Name</th>
                                    <th style="color:#0c1211";>Mobile</th>
									<th style="color:#0c1211";><i class="fa fa-trash" aria-hidden="true"></i></th>
                                </tr>
                             </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>

                           <tbody>
                              <tr id="sample-pi-id-<?php echo $row['SAMPLE_PI_ID']; ?>">
                                <td id="custName-<?php echo $row['CUSTOMER_NAME']; ?>" class="cust-name-ppi <?php echo "spi-".$row['INVOICE_STATUS'];?>">
									<a href="productionTeamView.php?invoiceId=<?php echo $row['SAMPLE_PI_ID']; ?>" >
										<?php echo $row['CUSTOMER_NAME']?>
									</a>
								</td>
                                <td class="<?php echo "spi-".$row['INVOICE_STATUS'];?>"><?php echo $row['MOBILE']?></td> 
								<td>
									<span class="<?php echo "spi-".$row['INVOICE_STATUS'];?>" data-spiId="<?php echo $row['SAMPLE_PI_ID']; ?>" onclick="deleteInvoice(this);">
										<i class="fa fa-times <?php echo "spi-".$row['INVOICE_STATUS'];?>" aria-hidden="true"></i>
									</span>
								</td>      
                               </tr>
                            </tbody>
 <?php
}
?>
                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
}
?> 
</div>
						
					</div>
				
				
				</div>
			</div>
		<!-- //calendar -->
		<div class="col-md-6 w3agile-notifications" id="enquiry">
			<div class="notifications">
				<!--notification start-->
				
					<header class="panel-heading">
						Enquiry 
					</header>
					<div class="notify-w3ls">
					<?php
if($result = mysqli_query($conn, $salesSql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive">
                            <table class="table tableFixHead table-striped table-hover max-10">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>Customer Name</th>
                                    <th style="color:#0c1211";>Mobile</th>
									<th style="color:#0c1211";><i class="fa fa-trash" aria-hidden="true"></i></th>
                                </tr>
                             </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>

                           <tbody>
                              <tr id="quotation-<?php echo $row['QUOTATION_ID']; ?>">
                                <td id="custName-<?php echo $row['CUSTOMER_NAME']; ?>" class="<?php echo "quo-".$row['Q_STATUS'];?>">
									<?php echo $row['CUSTOMER_NAME']?>
								</td>
                                <td class="<?php echo "quo-".$row['Q_STATUS'];?>"><?php echo $row['CUSTOMER_MOBILE']?></td> 
								<td>
									<span class="<?php echo "quo-".$row['Q_STATUS'];?>" data-quoId="<?php echo $row['QUOTATION_ID']; ?>" onclick="deleteQuotation(this);">
										<i class="fa fa-times <?php echo "quo-".$row['Q_STATUS'];?>" aria-hidden="true"></i>
									</span>
								</td>      
                               </tr>
                            </tbody>
 <?php
}
?>
                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
}
?> 
</div>
						
					</div>
				
				<!--notification end-->
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
			<!-- tasks -->
			
				<div class="col-md-6 agile-last-left agile-last-middle m-1" id="no-responce">
					<div class="agile-last-grid">
						<div class="area-grids-heading">
							<h3>No Responce</h3>
						</div>
						<div id="graph8">
						<?php
if($result = mysqli_query($conn, $noResponceSql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive cus-tbl notify-w3ls">
                            <table class="table tableFixHead table-striped table-hover">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>Customer Name</th>
                                    <th style="color:#0c1211";>Mobile</th>
									<th style="color:#0c1211";><i class="fa fa-trash" aria-hidden="true"></i></th>
                                </tr>
                             </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>
                           <tbody>
                              <tr id="followup-<?php echo $row['F_ID']; ?>">
                                <td style="color:#0c1211"; id="custName-<?php echo $row['SAMPLE_PI_ID']; ?>"><?php echo $row['S_NAME']?></td>
                                <td style="color:#0c1211";><?php echo $row['S_MOBILE']?></td>
								<td>
									<span data-fId="<?php echo $row['F_ID']; ?>" onclick="deleteFollowup(this);">
										<i style="color:#0c1211;" class="fa fa-times" aria-hidden="true"></i>
									</span>
								</td>        
                               </tr>
                            </tbody>
 <?php
}
?>
                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
}
?> 
</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 agile-last-left agile-last-right m-1" id="followup">
					<div class="agile-last-grid">
						<div class="area-grids-heading">
							<h3>Follow Up</h3>
						</div>
						<div id="graph9" >
						<?php
if($result = mysqli_query($conn, $follwUpSql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive cus-tbl notify-w3ls">
                            <table class="table tableFixHead table-striped table-hover">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211; min-width: 8em;">Customer Name</th>
									<th style="color:#0c1211; min-width: 8em;">Date</th>
                                    <th style="color:#0c1211";>Mobile</th>
									<!-- <th style="color:#0c1211";><i class="fa fa-trash" aria-hidden="true"></i></th> -->
                                </tr>
                             </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>
                           <tbody>
                              <tr id="followup-<?php echo $row['F_ID']; ?>">
                                <td style="color: red;"; id="custName-<?php echo $row['F_ID']; ?>"><?php echo $row['S_NAME']?></td>
                                <td style="color: red;";><?php echo $row['FOLLOWUP_DATE']?></td>
								<td style="color: red;";><?php echo $row['S_MOBILE']?></td>
								<!-- <td>
									<span data-fId="<?php echo $row['F_ID']; ?>" onclick="deleteFollowup(this, 1);">
										<i style="color:#0c1211;" class="fa fa-times" aria-hidden="true"></i>
									</span>
								</td>          -->
                               </tr>
                            </tbody>
 <?php
}
?>
                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records found.";
    }
}
?> 
</div>
						
						</div>
						
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		<!-- //tasks -->
		<div class="agileits-w3layouts-stats m-1">
					<div class="col-md-6 stats-info widget" id="irrelevant">
						<div class="stats-info-agileits">
							<div class="stats-title">
								<h4 class="title">Irrelevant</h4>
							</div>
							<div id="graph9">
						<?php
if($result = mysqli_query($conn, $irrelaventSql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive cus-tbl notify-w3ls">
                            <table class="table tableFixHead table-striped table-hover">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211; min-width: 8em;">Customer Name</th>
									<th style="color:#0c1211";>Mobile</th>
									<th style="color:#0c1211";><i class="fa fa-trash" aria-hidden="true"></i></th>
                                </tr>
                             </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>
                           <tbody> 
                              <tr id="followup-<?php echo $row['F_ID']; ?>">
                                <td style="color:#0c1211"; id="custName-<?php echo $row['SAMPLE_PI_ID']; ?>"><?php echo $row['S_NAME']?></td>
                                <td style="color:#0c1211";><?php echo $row['S_MOBILE']?></td>
								<td>
									<span data-fId="<?php echo $row['F_ID']; ?>" onclick="deleteFollowup(this);">
										<i style="color:#0c1211;" class="fa fa-times" aria-hidden="true"></i>
									</span>
								</td>           
                               </tr>
                            </tbody>
 <?php
}
?>
                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
}
?> 
</div>
						
						</div>
						
					</div>
				</div>
				<!-- <div class="clearfix"> </div> -->
			</div>

			<div class="agileits-w3layouts-stats m-1">
					<div class="col-md-6 stats-info widget" id="ref-status">
						<div class="stats-info-agileits">
							<div class="stats-title">
								<h4 class="title">Status</h4>
							</div>
							<div id="graph9">
						<?php
if($result = mysqli_query($conn, $refNoStatusSql)) {
    if(mysqli_num_rows($result) > 0) {
?>
                 <div class="table-responsive cus-tbl notify-w3ls panel panel-primary filterable">
					<div class="pull-right">
						<button class="btn btn-default btn-xs btn-filter"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
					</div>
                            <table class="table tableFixHead table-striped table-hover">
                              <thead>
                               <tr style="color:#0c1211";>
							   <tr class="filters">
							   	<th style="color:#0c1211; background: #428bca;"><input type="text" class="form-control col-sm-1" placeholder="Refrence No" disabled></th>	
							   	<th style="color:#0c1211; background: #428bca;">Customer Name</th>
								<th style="color:#0c1211; background: #428bca;">Status</th>
								</tr>
                             </thead>
<?php 
while($row = mysqli_fetch_array($result)){
?>
                           <tbody> 
                              <tr>
							  	<td style="color:#0c1211";><?php echo explode("-", $row['REFERENCE_NO'])[0] ."-". str_pad(explode("-", $row['REFERENCE_NO'])[1], 3, '0', STR_PAD_LEFT)?></td>
                                <td style="color:#0c1211;"><?php echo $row['CUSTOMER_NAME']?></td>
                                <td style="color:#0c1211";><?php echo $row['STATUS']?></td>           
                               </tr>
                            </tbody>
 <?php
}
?>
                            </table>
<?php  
mysqli_free_result($result);
} 
else{
    echo "No records matching your query were found.";
    }
}
?> 
</div>
						
						</div>
						
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>

				<div class="container">
				
			    <div class="menu">
				  <ul>

                    <?php if (isset($_SESSION['usr_id'])) { ?>
                    <li><a href='#'>Signed in as <?php echo $_SESSION['USERNAME']; ?></a></li>
                    <li><a href="logout.php">Log Out</a></li>

                    <?php } else { ?>

                    


                    <?php } ?>
				  </ul>
				</div>	


				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">
					
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="modal-title">Transactions</h4>
						</div>
						<div class="modal-body">
						<div class="row" style="width: 100%;">
						<table class="table table-striped" id='report-table'>

						</table>
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
					
					</div>
				</div>

				<div class="modal fade" id="refNo-modal" role="dialog">
					<div class="modal-dialog">
					
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="modal-title-refNo">Transactions</h4>
						</div>
						<div class="modal-body">
						<div class="row" style="width: 100%;">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">Customer Name:</label>
									<input type="text" class="form-control" id="customer-name" readonly>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">Mobile:</label>
									<input type="text" class="form-control" id="customer-mobile" readonly>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">Date:</label>
									<input type="text" class="form-control" id="customer-date" readonly>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">Product Amount:</label>
									<input type="text" class="form-control" id="customer-productAmount" readonly>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">GST Amount:</label>
									<input type="text" class="form-control" id="customer-gstAmount" readonly>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">Total:</label>
									<input type="text" class="form-control" id="customer-total" readonly>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">Advance:</label>
									<input type="text" class="form-control" id="customer-advance" readonly>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="usr">Balance:</label>
									<input type="text" class="form-control" id="customer-balance" readonly>
								</div>
							</div>
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
					
					</div>
				</div>
			  
</section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© Sunmac Enterprises</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<!-- morris JavaScript -->	
<script>

var buildTable = function(sizeArray) {
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
 
var addAllColumnHeaders = function(sizeArray) {
    var columnSet = [];
    var headerTr$ = $('<tr/>');

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
};

	$(document).ready(function() {

		let userType = <?php echo "'".$_SESSION['admin']. "'"; ?>;
        console.log('userType: ' + userType);

		if(userType == "generalManager") {
            
        } else if(userType == "HR") {
            
        } else if(userType == "followUp" || userType == "marketingManager") {
            $("#quotation-col").hide();
			$("#performa-col").hide();
			$("#invoice-col").hide();
			$("#accounts-col").hide();
			$("#accounts-row").hide();
			$("#ppi-status").hide();
			$("#enquiry").show();
			$("#no-responce").show();
			$("#followup").show();
			$("#irrelevant").show();

			$("#followup-status").show();
			$("#pi-status").hide();
			
        } else if(userType == "salesManager") {
            $("#quotation-col").hide();
			$("#performa-col").hide();
			$("#invoice-col").hide();
			$("#accounts-col").hide();
			$("#accounts-row").hide();
			$("#ppi-status").show();
			$("#enquiry").show();
			$("#no-responce").hide();
			$("#followup").hide();
			$("#irrelevant").hide();

			$("#followup-status").hide();
			$("#pi-status").show();

      		$('.cust-name-ppi').bind('click', false);
        } else if(userType == "accountsManager") {
            $("#quotation-col").hide();
			$("#performa-col").hide();
			$("#invoice-col").hide();
			$("#accounts-col").hide();
			$("#accounts-row").show();
			$("#ppi-status").hide();
			$("#enquiry").hide();
			$("#no-responce").hide();
			$("#followup").hide();
			$("#irrelevant").hide();

			$("#followup-status").hide();
			$("#pi-status").hide();
        } else if(userType == "purchaseManager") {
            $("#quotation-col").hide();
			$("#performa-col").hide();
			$("#invoice-col").hide();
			$("#accounts-col").hide();
			$("#accounts-row").hide();
			$("#ppi-status").hide();
			$("#enquiry").hide();
			$("#no-responce").hide();
			$("#followup").hide();
			$("#irrelevant").hide();

			$("#followup-status").hide();
			$("#pi-status").hide();
        } else if(userType == "employee") {
            $("#quotation-col").hide();
			$("#performa-col").hide();
			$("#invoice-col").hide();
			$("#accounts-col").hide();
			$("#accounts-row").hide();
			$("#ppi-status").hide();
			$("#enquiry").hide();
			$("#no-responce").hide();
			$("#followup").hide();
			$("#irrelevant").hide();

			$("#followup-status").hide();
			$("#pi-status").hide();
        } else if(userType == "productionManager") {
			$("#quotation-col").hide();
			$("#performa-col").hide();
			$("#invoice-col").hide();
			$("#accounts-col").hide();
			$("#accounts-row").hide();
			$("#ppi-status").show();
			$("#enquiry").hide();
			$("#no-responce").hide();
			$("#followup").hide();
			$("#irrelevant").hide();

			$("#followup-status").hide();
			$("#pi-status").hide();
		}

		
		$('.refNo-info').click(function(){

			var id = this.id;
			var splitid = id.split('-');
			var samplePiId = splitid[1];
			// AJAX request
			$.ajax({
				url: 'account_transaction.php',
				type: 'post',
				data: {samplePiId: samplePiId},
				success: function(response){ 
				// Add response in Modal body
				$("#modal-title").html('');
				$("#report-table tr").detach();
				let res = JSON.parse(response);
				console.log(res[1]);
				res = res[0][0];
				$("#modal-title-refNo").html(res["REFERENCE_NO"]);
				
				$("#customer-name").val(res["CUSTOMER_NAME"]);
				$("#customer-mobile").val(res["MOBILE"]);
				$("#customer-date").val(res["DATE"]);
				$("#customer-productAmount").val(res["PRODUCT_AMOUNT"]);
				$("#customer-gstAmount").val(res["GST_AMOUNT"]);
				$("#customer-total").val(res["TOTAL_AMOUNT"]);
				$("#customer-advance").val(res["ADVANCE"]);
				$("#customer-balance").val(res["BALANCE"]);

				// Display Modal
				$('#refNo-modal').modal('show'); 
				}
			});
		});

		$('.transaction-info').click(function(){
      var id = this.id;
      var splitid = id.split('-');
      var userid = splitid[1];

      // AJAX request
      $.ajax({
        url: 'account_transaction.php',
        type: 'post',
        data: {userid: userid},
        success: function(response){ 
          // Add response in Modal body
          $("#modal-title").html('');
          $("#report-table tr").detach();
          let res = JSON.parse(response);
          $("#modal-title").html($("#custName-"+res[1]).text());
          console.log(res[1]);
          buildTable(res[0]);

          // Display Modal
          $('#myModal').modal('show'); 
        }
      });
    });

    $('.color-condition').each(function() {
        var $this = $(this);
        var value = $this.text().trim();
        if(value == "Pending") {
            $(this).children().removeClass("fa-check").addClass("fa-times");
            $this.addClass('red');
        } else {

        }
        console.log(value);
    });


		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="js/monthly.js"></script>
	<script type="text/javascript">
		var deleteQuotation = function(span) {
			if($(span).hasClass("quo-0")) {
				return false;
			} else {
				console.log("quotationId: ", span);
				$.ajax({
					type: 'post',
					url: 'index_backend.php',
					data: {
						quotationId: $(span).attr("data-quoId")
					},
					success: function (response) {
						$("#quotation-"+$(span).attr("data-quoId")).hide();
					}
				});
			}
			
		};

		var deleteAccounts = function(span) {
			if(!$(span).hasClass("bal-0")) {
				return false;
			} else {
				console.log("quotationId: ", span);
				$.ajax({
					type: 'post',
					url: 'index_backend.php',
					data: {
						invoiceIdForAccountInIndex: $(span).attr("data-spiid")
					},
					success: function (response) {
						$("#account-id-"+$(span).attr("data-spiid")).hide();
					}
				});
			}
			
		};

		var deleteInvoice = function(span) {
			if($(span).hasClass("spi-1") || $(span).hasClass("spi-2")) {
				return false;
			} else {
				console.log("quotationId: ", span);
				$.ajax({
					type: 'post',
					url: 'index_backend.php',
					data: {
						invoiceId: $(span).attr("data-spiid")
					},
					success: function (response) {
						$("#sample-pi-id-"+$(span).attr("data-spiid")).hide();
					}
				});
			}
			
		};

		var deleteFollowup = function(span, isForFollowUp) {
			if(isForFollowUp) {
				$.ajax({
					type: 'post',
					url: 'index_backend.php',
					data: {
						followupIdForRemainder: $(span).attr("data-fId")
					},
					success: function (response) {
						$("#followup-"+$(span).attr("data-fId")).hide();
					}
				});
			} else {
				$.ajax({
					type: 'post',
					url: 'index_backend.php',
					data: {
						followupId: $(span).attr("data-fId")
					},
					success: function (response) {
						$("#followup-"+$(span).attr("data-fId")).hide();
					}
				});
			}	
		};

		$(window).load( function() {

			// var $table = $('table.max-10');
			// $table.floatThead();

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
</body>
</html>
