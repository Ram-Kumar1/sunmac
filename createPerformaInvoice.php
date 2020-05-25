<?php
session_start();
include 'db_connect.php';

function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? 'INR ' . $Rupees . ' only' : '') . $paise;
}
if(isset($_GET['invoiceId'])) {
    $invoiceIdSql = "SELECT MAX_NUMBER FROM invoice_tracker WHERE COLUMN1='SAMPLE_INV'";
    $invoiceIdRes = mysqli_query($conn, $invoiceIdSql);
    while($row = mysqli_fetch_array($invoiceIdRes)) {
        $invoiceId = $row['MAX_NUMBER'];
        $invoiceIdStr = "PI-" . $invoiceId;
    }
    $invoiceId++;
    $updateInvoiceIdSql = "update invoice_tracker set MAX_NUMBER = $invoiceId where COLUMN1='SAMPLE_INV'";
    mysqli_query($conn, $updateInvoiceIdSql);

    $invoiceDetails = "SELECT * FROM sample_pi WHERE SAMPLE_PI_ID=".$_GET['invoiceId'];
    $invoiceResult = mysqli_query($conn, $invoiceDetails);
    while($row = mysqli_fetch_array($invoiceResult)) {
        $customerName = $row['CUSTOMER_NAME'];
        $mobile = $row['MOBILE'];
        $toAddress = $row['TO_ADDRESS'];
        $deliveryAddress = $row['DELIVERY_ADDRESS'];
        $date = $row['DATE'];
        $referenceNo = $row['REFERENCE_NO'];
		$followedBy = $row['FOLLOWED_BY_PERSON'];
		date_default_timezone_set('Asia/Kolkata');
		$date_1 =  date('d-m-Y H:i');
		$curDate = date('Y-m-d', strtotime($date_1));
		
        $note2 = $row['NOTE_2'];
    }

    $ssql = "SELECT `Q_DATE` FROM `quotation` WHERE `REFERENCE_NO`='$referenceNo'";
    $quotationDateRes = mysqli_query($conn, $ssql);
    while($row1 = mysqli_fetch_array($quotationDateRes)) {
        $quotationDate = $row1['Q_DATE'];
    }

    $sql = "SELECT * FROM sample_pi_details WHERE SAMPLE_PI_ID=".$_GET['invoiceId'];
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT TOTAL_AMOUNT, (TOTAL_AMOUNT-GST_AMOUNT) as tot, (gst / 2) as gst, (GST_AMOUNT / 2) as gst_amt FROM sample_pi WHERE SAMPLE_PI_ID=".$_GET['invoiceId'];
    $result1 = mysqli_query($conn,$sql1);



?>

  <!DOCTYPE html>
  <head>
  <title>Production View</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    
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
  
  </head>

<style>
.red {
    color: red !important;
}

.m-1 {
    margin: 1px;
}

.max-30 {
    max-width: 15em;
}

.b-r {
    border-right: 1px solid;
}

</style>

  <body>
  <?php include 'header.php'; ?>
  <!-- sidebar menu end-->

  <section id="main-content">
    <section class="wrapper">
      <div class="form-w3layouts">
          <!-- page start-->
     <button type="button" class="btn btn-success" onclick="CreatePDFfromHTML(<?php echo "'" . $customerName . "'" ?>)">
      <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
        Export
     </button>
     <button type="button" name="button" class="btn btn-default pull-right" onclick="location.href = 'view_performa_invoice.php';">
        <i class="fa fa-backward" aria-hidden="true" style="color: black"></i>
        Back
    </button>
 <div class="row html-content">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading" style="background: #eef9f0;">
                           Performa Invoice
                    </header>
                    <br>
                    <div class="row m-1">
                        <div class="col-sm-6 b-r">
                            <b>SUNMAC ENTERPRICES</b></br>
                            325, NANJUNDAPURAM ROAD,</br>
                            NEAR PARSAN APARMENTS,</br>
                            COIMBATORE 641 036.</br>
                            GSTIN: 33AA12345</br>
                            Phone: 9877654331</br>
                            Cell No: 324324324, 3242344</br>
                            E-Mail: admin@sunmac.co.in</br>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-6">
                                    <b>PI.NO: </b><?php echo $referenceNo; ?></br>
                                </div>
                                <div class="col-xs-6">
                                    &nbsp;</br>
                                </div>
                                <div class="col-xs-6">
                                    <b>DATE: </b><?php echo $curDate;?></br>
                                </div>
                                <div class="col-xs-6">
                                    &nbsp;</br>
                                </div>
                                <div class="col-xs-6">
                                    <b>Followed By: </b><?php echo $followedBy; ?></br>
                                </div>
                                <!-- <div class="col-xs-6">
                                    Suplier Ref: QTN</br>
                                </div> -->
                                
                            </div>
                            
                        </div>
                    </div><!--  END OF 1ST ROW -->
                    </br>
                    <div class="row m-1">
                        <div class="col-sm-6 b-r">
                        <b>CUSTOMER: </b><?php echo $customerName;?></br>
                            <b>ADDRESS: </b> </br>
                            <?php echo $toAddress; ?> </br>
                            Phone: <?php echo $mobile; ?></br>
                        </div>

                        <div class="col-sm-6">
                            <b>Delivary At </b><br>
                            <?php echo $deliveryAddress; ?>
                        </div>
                    </div><!--  END OF 2ST ROW -->
                    <br>
                    <div class="row m-1">
                    <div class="table-responsive">
                    <table class="table">
                    <thead>
                    <tr style="color:#0c1211";>
                        <th class="col-xs-1" style="color:#0c1211;">S. NO</th>
                        <th class="col-xs-6" style="color:#0c1211;">Description Of Goods</th>
                        <th class="col-xs-1" style="color:#0c1211;">HSN</th>
                        <th class="col-xs-1" style="color:#0c1211;">Qty</th>
                        <th class="col-xs-1" style="color:#0c1211;">Rate</th>
                        <th class="col-xs-1" style="color:#0c1211;">Per</th>
                        <th class="col-xs-1" style="color:#0c1211;">Amount</th>
                    </tr>
                    </thead>
                    <?php 
$i = 1;
while($row = mysqli_fetch_array($result)) {
  
?>
                           <tbody>
                              <tr>
                                    <td class="col-xs-1" ><?php echo $i; ?></td>
                                    <td class="col-xs-6" style="color:#0c1211";>
                                        <?php echo $row['SIZE']."M ".$row['FINISHING']." ".$row['THICKNESS']."mm ".$row['TYPE']." ".$row['PRODUCT']; ?>
                                    </td>
                                    <td class="col-xs-1"  style="color:#0c1211";><?php echo "7306" ?></td> 
                                    <td class="col-xs-1"  style="color:#0c1211";><?php echo $row['QUANTITY']; ?></td>       
                                    <td class="col-xs-1"  style="color:#0c1211";><?php echo $row['RATE']; ?></td>        
                                    <td class="col-xs-1"  style="color:#0c1211";><?php echo "Each"; ?></td> 
                                    <td class="col-xs-1"  style="color:#0c1211";><?php echo $row['PRICE']; ?></td> 


                               </tr>
                          
 <?php
 $lastProduct = $row['PRODUCT'];
 ++$i;
}
?>

<tr>
    <td class="col-xs-1" >&nbsp;</td>
    <td class="col-xs-1"  style="color:#0c1211";>Note: <?php echo $note2; ?></td> 
    <td class="col-xs-6" style="color:#0c1211";>&nbsp;</td>
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>       
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>        
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
</tr>
<?php 
while($row = mysqli_fetch_array($result1)) {
  
?>
                           
                              <tr>
                                <td class="col-xs-1" >&nbsp;</td>
                                <td class="col-xs-6" style="color:#0c1211";>&nbsp;</td>
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>       
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>        
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>
                                <td class="col-xs-1"  style="color:#0c1211";>
                                <?php echo $row['tot']; ?>
                                </td>
                               </tr>
                            
 <?php
 $tot =  $row['tot'];
 $gst = round($row['gst'],1);
 $gstAmt = intval($row['gst_amt']);
 $totalAmt = $row['TOTAL_AMOUNT'];
 $totalAmtInWords = getIndianCurrency($totalAmt);
}
?>

                          
                              <tr>
                                <td class="col-xs-1" >&nbsp;</td>
                                <td class="col-xs-6" style="color:#0c1211";>CGST @<?php echo $gst; ?> % </td>
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>       
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>        
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>
                                <td class="col-xs-1"  style="color:#0c1211";>
                                <?php echo intval($gstAmt); ?>
                                </td>
                               </tr>
                               <tr>
                                <td class="col-xs-1" >&nbsp;</td>
                                <td class="col-xs-6" style="color:#0c1211";>SGST @<?php echo $gst; ?> % </td>
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>       
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>        
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>
                                <td class="col-xs-1"  style="color:#0c1211";>
                                <?php echo intval($gstAmt); ?>
                                </td>
                               </tr>
                               
<tr>
    <td class="col-xs-1" >&nbsp;</td>
    <td class="col-xs-6" style="color:#0c1211";>&nbsp;</td>
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>       
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>        
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
    <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
</tr>
                               <tr>
                                <td class="col-xs-1" >&nbsp;</td>
                                <td class="col-xs-6 pull-right" style="color:#0c1211";>Total</td>
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td> 
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>       
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>        
                                <td class="col-xs-1"  style="color:#0c1211";>&nbsp;</td>
                                <td class="col-xs-1"  style="color:#0c1211";>
                                <?php echo $totalAmt; ?>
                                </td>
                               </tr>
                            </tbody>

                    </table>
                    </div>
                    </div><!--  END OF 3ST ROW -->

        <div class="row m-1">
            <div class="col-sm-12">
                Amount (in words)
                <b><?php echo $totalAmtInWords; ?> </b>
            </div>
        </div><!--  END OF 4th ROW -->
        <br><br>
        <div class="row m-1">
            <div class="col-sm-4">
               <b> HSN/SAC </b>
            </div>
            <div class="col-sm-3">
                <b> Taxable Value </b>
            </div>
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-xs-3"><b>SGST Rate</b></div>
                    <div class="col-xs-3"><b>Amt</b></div>
                    <div class="col-xs-3"><b>CGST Rate</b></div>
                    <div class="col-xs-3"><b>Amt</b></div>
                </div>
            </div>
        </div><!--  END OF 5th ROW -->

        <div class="row m-1">
            <div class="col-sm-4">
                <?php echo $lastProduct . " - 7306"; ?>
            </div>
            <div class="col-sm-3">
            <?php echo $tot; ?>
            </div>
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-xs-3"><?php echo $gst; ?></div>
                    <div class="col-xs-3"><?php echo $gstAmt; ?></div>
                    <div class="col-xs-3"><?php echo $gst; ?></div>
                    <div class="col-xs-3"><?php echo $gstAmt; ?></div>
                </div>
            </div>
        </div><!--  END OF 6th ROW -->

        <div class="row m-1">
            <div class="col-sm-4">
                <div class="pull-right">
                <b> Total </b>
                </div>
            </div>
            <div class="col-sm-3">
            <?php echo $tot; ?>
            </div>
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-xs-3">&nbsp;</div>
                    <div class="col-xs-3"><?php echo $gstAmt; ?></div>
                    <div class="col-xs-3">&nbsp;</div>
                    <div class="col-xs-3"><?php echo $gstAmt; ?></div>
                </div>
            </div>
        </div><!--  END OF 7th ROW -->
<br><br>
        <div class="row m-1">
            <div class="col-sm-12">
                Tax Amount (in Words) <b> <?php echo getIndianCurrency(($gstAmt*2)); ?> </b>
                <br>
                <b>Decalration:</b> <br>
                We declare that this invoice shows that actual price of the goods described and that all particulars true and correct.
            </div>
        </div>
        <br><br>
        <div class="row m-1">
            <div class="col-sm-6">
                <b>Customers Seal & Signature </b>
            </div>
            <div class="col-sm-6" style="text-align: end;">
                <b>for SUNMAC ENTERPRICES </b>
            </div>
        </div>
        <br><br><br><br><br><br>
                    <br>
                    <br>
          <div class="row m-1">
            <div class="col-sm-1">E&O.E </div>
            <div class="col-sm-11" style="text-align: center">This Is Computer Generated Invoice </div>
          </div>          
        </div>
      </div>
      
    </section>
  </div>
</div>
</div>
</body>

<script>

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    return str;
}

var updateDetails = function(id) {
    var conform = confirm("Sure to create?");
    if(!conform) {
        return;
    }
    //window.location.href='createPPF.php?id='+id; 
    
};

function CreatePDFfromHTML(custName) {
    var HTML_Width = $(".html-content").width();
    var HTML_Height = $(".html-content").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($(".html-content")[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save(custName + ".pdf");
    });
}

$(document).ready(function(){
        $(".fa-bars").click();
    });

</script>

</html>
<?php 
} //end of isset if
?>