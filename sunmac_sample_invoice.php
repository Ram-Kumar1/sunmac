<?php
session_start();
include 'db_connect.php';


?>


<!-- sizeValue -->

<script type="text/javascript">
  var sizeValue = [];
</script> 
<?php
$customerName = "";
$address = "";
$mobile = "";
// TO GET CUSTOMER NAME AND ADDRESS WHILE LOADING
if(isset($_GET['quotationId'])) {
  $quotationId = $_GET['quotationId'];
  $quotationSql = "SELECT Q.QUOTATION_ID, Q.Q_DATE, Q.CUSTOMER_NAME, Q.CUSTOMER_MOBILE, Q.CUSTOMER_ADDRESS, Q.FOLLOWED_BY_PERSON, Q.REFERENCE_NO, Q.REMARKS, Q.NOTE_1, Q.NOTE_2 FROM `quotation` Q WHERE 1 = 1 AND Q.QUOTATION_ID=".$quotationId;
  $resultQuotation = mysqli_query($conn, $quotationSql);
  while ($row=mysqli_fetch_array($resultQuotation)) {
    $customerName = $row['CUSTOMER_NAME'];
    $address = $row['CUSTOMER_ADDRESS'];
    $mobile = $row['CUSTOMER_MOBILE'];
    $refNo = $row['REFERENCE_NO'];
    $followedBy = $row['FOLLOWED_BY_PERSON'];
    $remarks = $row['REMARKS'];
    $note1 = $row['NOTE_1'];
    $note2 = $row['NOTE_2'];
  }

}

$sql = "SELECT * FROM `production_size`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  sizeValue.push('<?php echo $row['size']; ?>');
  var customerName = <?php echo "'".$customerName."'"; ?>;
  var mobile = <?php echo "'".$mobile."'"; ?>;
  var address = <?php echo json_encode($address); ?>;
  var refNo = <?php echo json_encode($refNo); ?>;
  var followedBy = <?php echo json_encode($followedBy); ?>;
  var remarks = <?php echo json_encode($remarks); ?>;
  var note1 = <?php echo json_encode($note1); ?>;
  var note2 = <?php echo json_encode($note2); ?>;
  // var address
</script>
<?php 
}
?>

<!-- finishing -->

<script type="text/javascript">
  var finishing = [];
</script> 
<?php

$sql = "SELECT * FROM `production_finishing`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  finishing.push('<?php echo $row['finishing']; ?>');
</script>
<?php 
}
?>

<!-- type -->
<script type="text/javascript">
  var type = [];
</script> 
<?php

$sql = "SELECT * FROM `production_type`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  type.push('<?php echo $row['type_name']; ?>');
</script>
<?php 
}
?>

<!-- thickness -->
<script type="text/javascript">
  var thickness = [];
</script> 
<?php

$sql = "SELECT * FROM `production_thickness`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  thickness.push('<?php echo $row['thickness']; ?>');
</script>
<?php 
}
?>

<!-- product -->
<script type="text/javascript">
  var product = [];
</script> 
<?php

$sql = "SELECT * FROM `category`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  product.push('<?php echo $row['PRODUCT_NAME']; ?>');
</script>
<?php 
}
?>


<!-- product weight -->

<script type="text/javascript">
  var productWeight = [];
</script> 
<?php

$sql = "SELECT PW.`size`, PW.`type`, PW.`thickness`, C.PRODUCT_NAME FROM `product_weight` PW, category C WHERE 1=1 AND PW.`product_id` = C.PRODUCT_ID";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  productWeight.push('<?php echo $row['size'] . "" . $row['type'] . "" .$row['thickness'] . "" . $row['PRODUCT_NAME']; ?>');
</script>
<?php 
}
?>



<script type="text/javascript">

var validateProductWeight = function(select) {
      if(!select) {
        return;
      }
      dataChange(select);
      let rowId = $(select)[0].id.split("-")[1];
      let size = $("#size-"+rowId).val();
      let type = $("#Type-"+rowId).val();
      let thickness = $("#Thickness-"+rowId).val();
      let product = $("#Product-"+rowId).val();
      let as = size + type + thickness + product;
      if(productWeight.indexOf(as)>-1) {
        // nothing
      } else {
        alert("Chosen Product with given configuration is not there.\nKindly Choose the valid one!");
        $(select).val("None");
      }
    };

var deleteRow = function(button) {
  debugger;
  let rowId = $(button)[0].id.split("-")[1];

let size = $("#size-"+rowId).val();
    let finishing = $("#finishing-"+rowId).val();
    let type = $("#Type-"+rowId).val();
    let thickness = $("#Thickness-"+rowId).val();
    let product = $("#Product-"+rowId).val();
    let as = size + finishing + type + thickness + product;
    isDuplicate.splice(as);
  


  $("#size-"+rowId).closest('.col-sm-1').remove();
  $("#finishing-"+rowId).closest('.col-sm-2').remove();
  $("#Type-"+rowId).closest('.col-sm-1').remove();
  $("#Thickness-"+rowId).closest('.col-sm-1').remove();
  $("#Product-"+rowId).closest('.col-sm-2').remove();
  $("#QuantityAdd-"+rowId).closest('.col-sm-1').remove();
  $("#RateAdd-"+rowId).closest('.col-sm-2').remove();
  $("#salAdd-"+rowId).closest('.col-sm-1').remove();
  $("#del-"+rowId).closest('.col-sm-1').remove();



};

    function createAddTextBox() {
     
    let hiddenValueInput = document.getElementById('addSalaryHiddenInput');
    let hiddenVal = 0;
    try {
      hiddenVal = parseInt(hiddenValueInput.value);
      hiddenVal++;
      hiddenValueInput.value = hiddenVal;

    } catch(err) { 

    }

   var div = document.getElementById('addSalary');
  
//  for size
   let colDiv = document.createElement('div');
   colDiv.className = 'col-sm-1';
   let formGroupDiv = document.createElement('div');
   formGroupDiv.className = 'form-group';
   let label = document.createElement('label');
   label.innerHTML = "Size";
    var option = "";
        option += "<option value='None'>Select Size</option>";
    for(var val in sizeValue) {
        option += "<option>"+sizeValue[val]+"</option>";
    } //last value is append
   let input = document.createElement('select');
   input.className = "form-control"; 
   //input.className = "w-10";
   input.setAttribute("id", "size-"+hiddenVal);
   input.setAttribute("name", "size");
   input.setAttribute("onchange", "dataChange(this)");
  //  formGroupDiv.append(label);
   formGroupDiv.append(input);
   colDiv.append(formGroupDiv);

// for finishing

   let colDivFinishing = document.createElement('div');
   colDivFinishing.className = 'col-sm-2';
   let formGroupDivFinishing = document.createElement('div');
   formGroupDivFinishing.className = 'form-group';
   let labelFinishing = document.createElement('label');
   labelFinishing.innerHTML = "Finishing";

      let optionFinishing = "";
        optionFinishing += "<option value='None'>Select Finishing</option>";
    for(var val in finishing) {
        optionFinishing += "<option>"+finishing[val]+"</option>";
    }
   let inputFinishing = document.createElement('select');
   inputFinishing.className = "form-control"; 
   inputFinishing.setAttribute("id", "finishing-"+hiddenVal);
   inputFinishing.setAttribute("name", "Finishing");
   inputFinishing.setAttribute("onchange", "dataChange(this)");
  //  formGroupDivFinishing.append(labelFinishing);
   formGroupDivFinishing.append(inputFinishing);
   colDivFinishing.append(formGroupDivFinishing);

// for type
   let colDivType = document.createElement('div');
   colDivType.className = 'col-sm-1';
   let formGroupDivType = document.createElement('div');
   formGroupDivType.className = 'form-group';
   let labelType = document.createElement('label');
   labelType.innerHTML = "Type";

     let optionType = "";
        optionType += "<option value='None'>Select Type</option>";
    for(var val in type) {
        optionType += "<option>"+type[val]+"</option>";
    }
   let inputType = document.createElement('select');
   inputType.className = "form-control"; 
   inputType.setAttribute("id", "Type-"+hiddenVal);
   inputType.setAttribute("name", "Type");
   inputType.setAttribute("onchange", "dataChange(this)");
  //  formGroupDivType.append(labelType);
   formGroupDivType.append(inputType);
   colDivType.append(formGroupDivType);

   // for thickness
   let colDivThickness = document.createElement('div');
   colDivThickness.className = 'col-sm-1';
   formGroupDivType = document.createElement('div');
   formGroupDivType.className = 'form-group';
   labelType = document.createElement('label');
   labelType.innerHTML = "Type";

   optionThickness = "";
   optionThickness += "<option value='None'>Select Thickness</option>";
   for(var val in thickness) {
       optionThickness += "<option>"+thickness[val]+"</option>";
   }
   inputType = document.createElement('select');
   inputType.className = "form-control"; 
   inputType.setAttribute("id", "Thickness-"+hiddenVal);
   inputType.setAttribute("name", "Thickness");
   inputType.setAttribute("onchange", "dataChange(this)");
  //  formGroupDivType.append(labelType);
   formGroupDivType.append(inputType);
   colDivThickness.append(formGroupDivType);

// for product
   let colDivProduct = document.createElement('div');
   colDivProduct.className = 'col-sm-2';
   let formGroupDivProduct = document.createElement('div');
   formGroupDivProduct.className = 'form-group';
   let labelProduct = document.createElement('label');
   labelProduct.innerHTML = "Product";

     optionProduct = "";
        optionProduct += "<option value='None'>Select Product</option>";
    for(var val in product) {
        optionProduct += "<option>"+product[val]+"</option>";
    }
   let inputProduct = document.createElement('select');
   inputProduct.className = "form-control"; 
   inputProduct.setAttribute("id", "Product-"+hiddenVal);
   inputProduct.setAttribute("name", "Product");
   inputProduct.setAttribute("required", "");
   inputProduct.setAttribute("onchange", "validateProductWeight(this)");
  //  formGroupDivProduct.append(labelProduct);
   formGroupDivProduct.append(inputProduct);
   colDivProduct.append(formGroupDivProduct);

// for Quantity
   
   let colDivQuantity = document.createElement('div');
   colDivQuantity.className = 'col-sm-1';
   let formGroupDivQuantity = document.createElement('div');
   formGroupDivQuantity.className = 'form-group';
   let labelQuantity = document.createElement('label');
   labelQuantity.innerHTML = "Quantity";

   let inputQuantity = document.createElement('input');
   inputQuantity.type = "number";
   inputQuantity.className = "form-control";
   inputQuantity.placeholder = "Quantity";
   inputQuantity.setAttribute("id", "QuantityAdd-"+hiddenVal);
   inputQuantity.setAttribute("onchange", "dataChange(this)");
  //  formGroupDivQuantity.append(labelQuantity);
   formGroupDivQuantity.append(inputQuantity);
   colDivQuantity.append(formGroupDivQuantity);

// for perRate
   
   let colDivRate = document.createElement('div');
   colDivRate.className = 'col-sm-2';
   let formGroupDivRate = document.createElement('div');
   formGroupDivRate.className = 'form-group';
   let labelRate = document.createElement('label');
   labelRate.innerHTML = "Rate";

   let inputRate = document.createElement('input');
   inputRate.type = "number";
   inputRate.className = "form-control";
   inputRate.placeholder = "Per Rate";
   inputRate.setAttribute("id", "RateAdd-"+hiddenVal);
   inputRate.setAttribute("onchange", "perRate(this);");

  //  formGroupDivRate.append(labelRate);
   formGroupDivRate.append(inputRate);
   colDivRate.append(formGroupDivRate);

// for price
   
   let colDivSal = document.createElement('div');
   colDivSal.className = 'col-sm-1';
   let formGroupDivSal = document.createElement('div');
   formGroupDivSal.className = 'form-group';
   let labelSal = document.createElement('label');
   labelSal.innerHTML = "Price";
   let inputSal = document.createElement('h4');
   inputSal.setAttribute("id", "salAdd-"+hiddenVal);

  //  formGroupDivSal.append(labelSal);
   formGroupDivSal.append(inputSal);
   colDivSal.append(formGroupDivSal);
   

   let html = '<div class="col-sm-1"> ' +
    ' <div class="form-group"> '+
        // '<label>Delete</label> ' +
         '<button type="button" id="del-'+hiddenVal+'"onclick="deleteRow(this)" class="btn btn-warning"><i class="material-icons">delete_outline</i></button> ' +
     '</div>' +
     '</div>';

   div.append(colDiv);
   div.append(colDivFinishing);
   div.append(colDivType);
   div.append(colDivThickness);
   div.append(colDivProduct);
   div.append(colDivQuantity);
   div.append(colDivRate);
   div.append(colDivSal);
   $(div).append(html);
  

    $('#size-'+hiddenVal).append(option);
    $('#finishing-'+hiddenVal).append(optionFinishing);
    $('#Type-'+hiddenVal).append(optionType);
    $('#Thickness-'+hiddenVal).append(optionThickness);
    $('#Product-'+hiddenVal).append(optionProduct);

    $("#gst-btn").attr("disabled", false);
  }

var dataChange = function(input) {
  $(input).attr("disabled", true);
};

var isDuplicate = [];
var perRate = function(demo){
  let perRateValue = demo.value;
  let id  = demo.id;
  let res = id.replace("RateAdd-","");
  let Quantity = $("#QuantityAdd-"+res).val();
  let price = Quantity * perRateValue; 
  $("#salAdd-"+res).text(price);
  let totalAmtInt = parseInt($("#totalAmt").val());
  totalAmtInt = totalAmtInt + price;
  $("#totalAmt").val(totalAmtInt);


   let size = $("#size-"+res).val();
    let finishing = $("#finishing-"+res).val();
    let type = $("#Type-"+res).val();
    let thickness = $("#Thickness-"+res).val();
    let product = $("#Product-"+res).val();
    let as = size + finishing + type + thickness + product;
    
  if(isDuplicate.indexOf(as)>-1) {
    alert("Product already exists!");
    $(demo).val("");
    return false;
  }
  dataChange(demo);
  
   isDuplicate.push(as);

}

</script>

<!DOCTYPE html>
<head>
<title>SUNMAC</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

<style type="text/css">
  .w-10 {
    min-width: 9em;
  }

  .w-5 {
    max-width: 5.5em;
  }

  .ml-1 {
    margin-left: 1em;
  }

  .txt-center {
    text-align: center;
  }

  hr.custom {
    margin-top: 0px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #f0bcb4;
  }
</style>

  <body>

  <?php include 'header.php'; ?>

  <!-- sidebar menu end-->
<section id="main-content">
  	<section class="wrapper">
         <div class="form-w3layouts">
          <div class="row">
              <div class="col-lg-12">
                  <header class="panel-heading">
                          Performa Invoice
                      </header>


     <br><br> 

     <div class="row">
              <div class="col-sm-2">
              </div>
              <div class="col-sm-8">
                    <div class="form-group">
                      <label for="comment">Customer Name:</label>
                      <input type="text" class="form-control" id="customerName" readonly />
                    </div>

                    <div class="form-group">
                      <label for="comment">Mobile:</label>
                      <input type="text" class="form-control" id="mobile" readonly/>
                    </div>

<!-- 
                   <div class="form-group">
                      <label for="comment">From Address:</label>
                      <textarea class="form-control" rows="2" id="from" name="from"></textarea>
                    </div> -->
                    
                    <div class="form-group">
                      <label for="comment">To Address:</label>
                      <textarea class="form-control" rows="2" id="to" name="to"></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="comment">Delivery Address:</label>
                      <textarea class="form-control" rows="2" id="delivery" name="delivery"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="comment">Refrence No:</label>
                      <input type="text" class="form-control" id="refNo" readonly />
                    </div>

                    <div class="form-group">
                      <label for="comment">Followed By:</label>
                      <input type="text" class="form-control" id="followedBy" readonly />
                    </div>
                    
                    <div class="form-group">
                      <label for="comment">Remarks:</label>
                      <input type="text" class="form-control" id="remarks" readonly/>
                    </div>

                    <div class="form-group">
                      <label for="comment">Note 1:</label>
                      <input type="text" class="form-control" id="note1" readonly/>
                    </div>

                    <div class="form-group">
                      <label for="comment">Note 2:</label>
                      <input type="text" class="form-control" id="note2"/>
                    </div>

                    <!-- <div class="form-group">
                      <label for="comment">References:</label>
                      <textarea class="form-control" rows="2" id="references" name="references"></textarea>
                    </div> -->
               </div>
           </div>

              <br><br>

    <input type="hidden" class="form-control" id="addSalaryHiddenInput" name="addSalaryHiddenInput" value="0">

          <div class="row" id="addSalary" style="width:100%">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="pwd"></label>
                <button type="button" class="btn btn-info btn-sm" id="btn-create" onclick="createAddTextBox()" style="margin: 0 auto; display:block;" >
                <i class="fa fa-plus" aria-hidden="true"></i>
                    &nbsp;&nbsp;ADD PRODUCTS
                </button>
              </div>      
            </div>
            
            <div class="col-sm-1">
              <div class="form-group txt-center">
                <label for="pwd">SIZE</label>
              </div>      
            </div>

            <div class="col-sm-2">
              <div class="form-group txt-center">
                <label for="pwd">FINISHING</label>
              </div>      
            </div>

            <div class="col-sm-1">
              <div class="form-group txt-center">
                <label for="pwd">TYPE</label>
              </div>      
            </div>

            <div class="col-sm-1">
              <div class="form-group txt-center">
                <label for="pwd">THICKNESS</label>
              </div>      
            </div>

            <div class="col-sm-2">
              <div class="form-group txt-center">
                <label for="pwd">PRODUCT</label>
              </div>      
            </div>

            <div class="col-sm-1">
              <div class="form-group txt-center">
                <label for="pwd">QUANTITY</label>
              </div>      
            </div>

            <div class="col-sm-2">
              <div class="form-group txt-center">
                <label for="pwd">RATE</label>
              </div>      
            </div>

            <div class="col-sm-1">
              <div class="form-group txt-center">
                <label for="pwd">PRICE</label>
              </div>      
            </div>

            <div class="col-sm-1">
              <div class="form-group txt-center">
                <label for="pwd">DELETE</label>
              </div>      
            </div>

            <div class="col-sm-12">
              <hr class="custom">     
            </div>

       </div>


<div class = "col-sm-12">
  <center>
    <br><br>
    
          <div class="row">
          <div class="col-sm-2">
              <div class="form-group">
                  <label for="usr">Total Amount:</label>
                  <input type="text" class="form-control" id="totalAmt" name="totalAmt" value="0" disabled>
                </div>
            </div>  
            <div class="col-sm-1">
                <div class="form-group">
                  <label for="usr">&nbsp;</label>
                  <button type="button" id="gst-btn" class="btn btn-success" onclick="enableGst(this)" disabled>Enable GST</button>
                </div>
            
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                  <label for="comment">Select GST</label>
                      <select id="gstValue"  class="form-control input-search" onchange="gst(this)" disabled>
                          <option value="None"> Select GST </option>
                          <option value="5"> 5% </option>
                          <option value="12"> 12% </option>
                          <option value="18"> 18% </option>
                          <option value="28"> 28% </option>
                      </select>
                </div>
            </div>
            
            <div class="col-sm-3">
                <div class="form-group">
                  <label for="usr">GST Amount:</label>
                  <input type="text" class="form-control" id="totalGstCalcAmount" name="totalGstCalcAmount" disabled>
                </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                  <label for="usr">Grand Total:</label>
                  <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled>
                </div>
            </div>
           
            <div class="col-sm-3">
              <div class="form-group">
                <label for="usr">State GST:</label>
                <input type="text" class="form-control" id="state" name="state" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="usr">State GST Amount:</label>
                <input type="text" class="form-control" id="state-amt" name="state" disabled>
              </div>
            </div>
            
            

            <div class="col-sm-3">
              <div class="form-group">
                <label for="usr">Central GST:</label>
                <input type="text" class="form-control" id="central" name="central" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="usr">Central GST Amount:</label>
                <input type="text" class="form-control" id="central-amt" name="central" disabled>
              </div>
            </div>
            <div class="col-sm-12">
            <!-- <input type="submit" class="btn btn-info"  name="submit" value="Submit" onclick="saveData()"> -->
            <button type="button" id="save-btn" class="btn btn-info" name="submit" value="Submit" onclick="saveData()" disabled>
              <i class="fa fa-floppy-o" aria-hidden="true"></i>
              Submit
            </button>
            </div>
       
  </center>
</div>
</div>

</div>

<br><br><br><br><br>


</section>
<!--main content end-->
</section>

</body>

<script type="text/javascript">
var enableGst = function(btn) {
  let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
  for(i=0; i<addSalaryHiddenInput; i++) {
    let j=i+1;
    let value = $("#RateAdd-"+j).val();
    if(value != undefined && value != null && value == "") {
      alert("Fill all the rates before enabling GST!");
      return false;
    }
  }

  $("#gstValue").attr('disabled', false);
};

function calc(){
let total = 0;
let values;
let j;
let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
   for(i=0; i<addSalaryHiddenInput; i++) {
    j=i+1;
    values = parseInt($("#salAdd-"+j).text());
    total = total + values;
  }
   $("#gst").text("Total Value = "+total);
}

function gst(gst){
  //debugger;
  var gstChoosenVal = $(gst).val();
  var central = 0;
  var state = 0;
  if(gstChoosenVal == "5") {
    central = 2.5;
    state = 2.5;
  } else if(gstChoosenVal == "12") {
    central = 6;
    state = 6;
  } else if(gstChoosenVal == "18") {
    central = 9;
    state = 9;
  } else if(gstChoosenVal == "28") {
    central = 14;
    state = 14;
  }
 
  $("#central").val(central);
  $("#state").val(state);
  
  let total = 0;
  let values;
  let j;
  let salHiddenInput=$("#addSalaryHiddenInput").val();
  //let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
  for(i=0; i<parseInt(salHiddenInput); i++) {
    j=i+1;
    values = parseInt($("#salAdd-"+j).text());
    if(isNaN(values)) {
      total += 0;
    } else {
      total = total + values;  
    }
    
  }
  let percent = total * (central * 2) / 100;
  percent = Math.round(percent * 100) / 100
  $("#totalGstCalcAmount").val(percent);
  let totAmt = total + percent; 
  $("#totalAmount").val(totAmt);
  $("#state-amt").val(percent/2);
  $("#central-amt").val(percent/2);

  $("#save-btn").attr("disabled", false);

}

function saveData() {

  if (!confirm("Are you sure to Submit!")) {
    return;
  } else {
    // let toAddress = document.getElementById("toAddress").value;
    let size = [];
    let finishing = [];
    let type = [];
    let thickness = [];
    let productName = [];
    let quantity = [];
    let rate = []
    let price = [];
    let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
    note2 = $("#note2").val();
    if(addSalaryHiddenInput > 0){
      let inc = 0;
      for(i=0; i<addSalaryHiddenInput; i++) {
        let sizeVal = $("#size-"+(i+1)).val();
        if(!sizeVal) {
          continue;
        }
        let finishingVal = $("#finishing-"+(i+1)).val();
        let typeVal = $("#Type-"+(i+1)).val();
        let thicknessVal = $("#Thickness-"+(i+1)).val();
        let currentProductName = $("#Product-"+(i+1)).val();
        let qty = $("#QuantityAdd-"+(i+1)).val();
        let currentRate = $("#RateAdd-"+(i+1)).val();
        var priceVal = $("#salAdd-"+(i+1)).text();
        if(sizeVal != 'None' && finishingVal != 'None' && typeVal != 'None' && currentProductName != 'None' && qty != '' && currentRate != '' && priceVal != '') {
          size[inc] = sizeVal;
          finishing[inc] = finishingVal;
          type[inc] = typeVal;
          thickness[inc] = thicknessVal;
          productName[inc] = currentProductName;
          quantity[inc] = qty;
          rate[inc] = currentRate;
          price[inc] = priceVal;
          inc = inc + 1;
        } else {
          alert("Please insert all value...");
          return;
        }
      }
    }

    if(isDuplicate.length == 0) {
      alert('Please enter atleast one product!');
      return;
    }
    
    const urlParams = new URLSearchParams(window.location.search);
    const quotationId = urlParams.get('quotationId');
    $("#save-btn").attr("disabled", true);
    $.ajax({
       type: 'post',
       url: 'sunmac_samplePI_save.php',
       data: {
          customerName: customerName,
          quotationId: quotationId,
          mobile: mobile,
          refNo: refNo,
          followedBy: followedBy,
          remarks: remarks,
          note1: note1,
          note2: note2,
          address: $("#to").val(),
          delivary: $("#delivery").val(),
          count:addSalaryHiddenInput, 
          size:size.toString(),
          finishing:finishing.toString(),
          type:type.toString(),
          thickness: thickness.toString(),
          productName:productName.toString(),
          quantity: quantity.toString(),
          rate: rate.toString(),
          price:price.toString(),
          gst:  $("#central").val() * 2,
          totalAmount: $("#totalAmount").val(),
          gstAmount: $("#totalGstCalcAmount").val()
       },
       success: function (response) {
        console.log(response);
        // alert("Salary Inserted Successfully");
        window.location = "view_performa_invoice.php";
       }
    });

  }
   
  }

  $(document).ready(function(){
    $("#customerName").val(!customerName ? "" : customerName);
    $("#mobile").val(!mobile ? "" : mobile);
    $("#to").val(!address ? "" : address);
    $("#delivery").val(!address ? "" : address);
    $("#refNo").val(!refNo ? "" : refNo);
    $("#followedBy").val(!followedBy ? "" : followedBy);
    $("#remarks").val(!remarks ? "" : remarks);
    $("#note1").val(!note1 ? "" : note1);
    $("#note2").val(!note2 ? "" : note2);
    $(".fa-bars").click();

  });

</script>
</html>







