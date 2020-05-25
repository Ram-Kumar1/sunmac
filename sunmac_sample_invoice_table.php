<?php
session_start();
include 'db_connect.php';

?>
<!DOCTYPE html>
<head>
<title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
<style type="text/css">

#tableInvoice td, #tableInvoice th ,#tableInvoice tr {
  border: 1px solid #0c1211 !important;
  color:#0c1211;
}



</style>
</head>
<body>
<?php include 'header.php'; ?>

<section id="main-content">
	<section class="wrapper">
       <div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Billing Address
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                           ddewsd
                        </div>

  <table class="table table-bordered" id="tableInvoice" style="height: 600px;">
      <tr>
        <td rowspan="2">John</td>
        <td >Doe</td>
        <td >Doe</td>
        
      </tr>
      <tr>
        <td colspan="2">Sample date</td>
      </tr>
      <tr>
        <td>Sample date</td>
        <td colspan="2">Sample date</td>
      </tr>
      <tr>
        <td colspan="3">
          <table class="table table-bordered">
              <tr>
                <th>S.NO</th>
                <th>Descripttion Of Goods</th>
                <th>HSN/SAC</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Per</th>
                <th>Amount</th>
              </tr>
              <tr>
                <td>S.NO</td>
                <td>Descripttion Of Goods</td>
                <td>HSN/SAC</td>
                <td>Qty</td>
                <td>Rate</td>
                <td>Per</td>
                <td>Amount</td>
              </tr>
              <tr>
                <td></td>
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Amount</td>
              </tr>
              <tr>
                <td colspan="7">hello</td>
              </tr>

          </table>
        </td>
      </tr>
      <tr>
        <td colspan="3">
            Declaration:
        </td>
      </tr>

      <tr>
        <td>
        </td>
        <td colspan="2">
            <h4 style="text-align: right;">For SUNMAC ENTERPRISES</h4>
             <br>
             <br>
            <h6 style="text-align: right;">Authorised Signatory</h6>
        </td>
      </tr>



  </table>

<center>
<input type="button" class="btn btn-success" id="btnExport" value="Export" onclick="Export()" />
</center>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<script type="text/javascript">
        
  function Export() {
    html2canvas(document.getElementById('tableInvoice'), {
        onrendered: function (canvas) {
            var data = canvas.toDataURL();
            var docDefinition = {
                content: [{
                    image: data,
                    width: 500
                }]
            };
            pdfMake.createPdf(docDefinition).download("Table.pdf");
        }
    });
}

</script>

                    </div>
                </section>
            </div>
        </div>                      
    </div>
</section>
</section>

         
</section>

<!--main content end-->
</section>

</body>
</html>
