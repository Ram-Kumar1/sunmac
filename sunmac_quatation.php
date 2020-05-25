<?php
session_start();
include 'db_connect.php';
$resultQId = null;
$quotationId = 0;
$refNo = 0;
if(isset($_GET['quotationId'])) {
  $quotationId = $_GET['quotationId'];
  $sqlQId = "SELECT C.`S_NAME`, C.`S_ADDRESS`,C.`S_CITY`,C.S_MOBILE,Q.REMARKS FROM sales_customer C, quotation_followup Q WHERE 1=1 AND C.S_ID = Q.CUSTOMER_ID AND Q.QUOTATION_ID = ".$quotationId;
  $resultQId = mysqli_query($conn,$sqlQId);
  date_default_timezone_set('Asia/Kolkata');
  $date_1 =  date('d-m-Y H:i');
  $date = date('Y-m-d', strtotime($date_1));
  $refrenceSql = "SELECT * FROM `refrence` WHERE date = '$date'";
  $resultRef = mysqli_query($conn,$refrenceSql);
  if($row = mysqli_fetch_array($resultRef)) {
    $refNo = $row['INC_NO'] + 1;
  } else {
    $refNo = 1;
  }

}

if(isset($_POST['count']))
{
	$quotationId = $_POST['quotationId'];

  $updateSQL = "UPDATE quotation_followup SET Q_STATUS = 1 WHERE QUOTATION_ID=".$quotationId;
  mysqli_query($conn, $updateSQL);
  
 $custName = $_POST['custName'];
 $mobile = $_POST['mobile'];
 $remarks = $_POST['remarks'];
 $toAddress = $_POST['toAddress'];
 $note1 = $_POST['note1'];
 $note2 = $_POST['note2'];
 $followedBy = $_POST['followedBy'];
 $reference = $_POST['reference'];
 $count = $_POST['count'];
 $size = $_POST['size'];
 $finishing = $_POST['finishing'];
 $type = $_POST['type'];
 $thickness = $_POST['thickness'];
 $product = $_POST['product'];
 $price = $_POST['price'];
//  $date = $_POST['date'];
 $refVal = $_POST['refNo'];
 
 date_default_timezone_set('Asia/Kolkata');
 $date_1 =  date('d-m-Y H:i');
 $date = date('Y-m-d', strtotime($date_1));
 

 $sizeArray = explode(',', $size);
 $finishingArray = explode(',', $finishing);
 $typeArray = explode(',', $type);
 $thicknessArray = explode(',', $thickness);
 $productArray = explode(',', $product);
 $priceArray = explode(',', $price);

 $qutation =[];
 $insertSQL = "INSERT INTO `quotation` 
 (`Q_DATE`, `CUSTOMER_NAME`, `CUSTOMER_MOBILE`, `CUSTOMER_ADDRESS`, `Q_STATUS`, `NEXT_FOLLOWUP_DATE`, `REMARKS`, `NOTE_1`, `NOTE_2`, `FOLLOWED_BY_PERSON`, `REFERENCE_NO`)
  VALUES 
  ('$date','$custName','$mobile','$toAddress',1,'$date','$remarks','$note1','$note2','$followedBy','$reference')";
 mysqli_query($conn, $insertSQL);
$j =1;
 for($i=0;$i<$count;$i++) {
    $insertQuotationDetail = "INSERT INTO `quotation_details`
        (`QUOTATION_ID`, `SIZE`, `FINISHING`, `TYPE`, `PRODUCT`, `PRICE`, `thickness`) 
        VALUES 
        ((SELECT max(QUOTATION_ID) from quotation),'$sizeArray[$i]','$finishingArray[$i]','$typeArray[$i]','$productArray[$i]',$priceArray[$i],'$thicknessArray[$i]')";
    mysqli_query($conn, $insertQuotationDetail);
    $qutation[$i] = $j.") ".$sizeArray[$i]."M Long ".$finishingArray[$i]." ".$typeArray[$i]." ".$productArray[$i]." Rs =  ".$priceArray[$i];
    $j++;
 }

 if($refVal == 1) {
  $updateSQL = "INSERT INTO `refrence`(`DATE`, `INC_NO`) VALUES ('$date',$refVal)";
 } else  {
  $updateSQL = "UPDATE `refrence` SET `INC_NO`=$refVal WHERE `DATE`='$date'";
 }
 mysqli_query($conn, $updateSQL);

$_SESSION["toAddress"] = $toAddress;
$_SESSION["qutation"] = $qutation;

}

?>


<!-- sizeValue -->

<script type="text/javascript">
  function replaceAll(searchString, replaceString, str) {
    return str.split(searchString).join(replaceString);
  }

  var sizeValue = [];
  var refNo = (new Date()).toISOString().split('T')[0];
  refNo = replaceAll("-", "", refNo);
  refNo = refNo + "-" + <?php echo $refNo; ?>
</script> 
<?php

$sql = "SELECT * FROM `production_size`";
$result = mysqli_query($conn, $sql);
while ($row=mysqli_fetch_array($result)) {
?>
<script type="text/javascript">
  sizeValue.push('<?php echo $row['size']; ?>');
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
      $(select).attr("disabled", true);
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


    function createAddTextBox() {
     
    let hiddenValueInput = document.getElementById('addSalaryHiddenInput');
    let hiddenVal = 0;
    try {
      hiddenVal = parseInt(hiddenValueInput.value);
      hiddenVal++;
      hiddenValueInput.value = hiddenVal;

    } catch(err) { }

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
    for(var val in  finishing) {
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
   colDivThickness.className = 'col-sm-2';
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
   colDivProduct.className = 'col-sm-3';
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

// for price
   
   let colDivSal = document.createElement('div');
   colDivSal.className = 'col-sm-2';
   let formGroupDivSal = document.createElement('div');
   formGroupDivSal.className = 'form-group';
   let labelSal = document.createElement('label');
   labelSal.innerHTML = "Price";

   let inputSal = document.createElement('input');
   inputSal.type = "number";
   inputSal.className = "form-control";
   inputSal.placeholder = "AMOUNT";
   inputSal.setAttribute("id", "salAdd-"+hiddenVal);
   inputSal.setAttribute("onchange", "validateInput(this)"); 

  //  formGroupDivSal.append(labelSal);
   formGroupDivSal.append(inputSal);
   colDivSal.append(formGroupDivSal);

  // FOR DELETE BTN
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
   div.append(colDivSal);
   $(div).append(html);
   
    $('#size-'+hiddenVal).append(option);
    $('#finishing-'+hiddenVal).append(optionFinishing);
    $('#Type-'+hiddenVal).append(optionType);
    $('#Thickness-'+hiddenVal).append(optionThickness);
    $('#Product-'+hiddenVal).append(optionProduct);

  }

var isDuplicate = [];
var validateInput=function(input) {
  if(!input) {
    return;
  }
    dataChange(input);
    let rowId = $(input)[0].id.split("-")[1];
    let size = $("#size-"+rowId).val();
    let finishing = $("#finishing-"+rowId).val();
    let type = $("#Type-"+rowId).val();
    let thickness = $("#Thickness-"+rowId).val();
    let product = $("#Product-"+rowId).val();
    let as = size + finishing + type + thickness + product;
    
  if(isDuplicate.indexOf(as)>-1) {
    alert("Product already exists!");
    $(input).val("");
    return false;
  }

   isDuplicate.push(as);
    
};

var dataChange = function(input) {
  $(input).attr("disabled", true);
};

var deleteRow = function(button) {
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
  $("#Thickness-"+rowId).closest('.col-sm-2').remove();
  $("#Product-"+rowId).closest('.col-sm-3').remove();
  $("#salAdd-"+rowId).closest('.col-sm-2').remove();
  $("#del-"+rowId).closest('.col-sm-1').remove();

};

  var address = "";
  var remarks = "";
  var custName = "";
  var mobile = "";

</script>

<?php 
   while($row = mysqli_fetch_array($resultQId)) {
?>

<script>
  address = <?php echo "'".$row['S_NAME']."- ADS - ".$row['S_ADDRESS'].$row['S_CITY']."'"?>;
  remarks = <?php echo "'".$row['REMARKS']."'"?>;
  custName = <?php echo "'".$row['S_NAME']."'"?>;
  mobile = <?php echo "'".$row['S_MOBILE']."'"?>;
</script>

<?php
   }
?>

<!DOCTYPE html>
<head>
<title>SUNMAC</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="sunmac.css">

<?php
include 'demo.css';
?>
<?php
include 'demo.js';
?>
  
  </head>

<style type="text/css">

/* input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0; 
}

input[type=number] {
    -moz-appearance:textfield; 
} */

  hr.custom {
    margin-top: 0px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #f0bcb4;
  }

  span.mandatory {
    color: red;
  }

  .w-10 {
    min-width: 9em;
  }

  .w-5 {
    max-width: 5.5em;
  }

  .ml-1 {
    margin-left: 1em;
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
                  <section class="panel">
                      <header class="panel-heading">
                          QUOTATION
                      </header>
                      <div class="panel-body">
                          <div class="position-center">


 <div class="form-group" style="display:none;">
      <label for="pwd">To Address</label>
      <textarea class="form-control" rows="5"  id="toAddress" name="toAddress"></textarea>
  </div>
  <div class="form-group">
    <label for="usr">Customer Name:</label>
    <input type="text" class="form-control" id="customerName" readonly>
  </div>
  <div class="form-group">
    <label for="usr">Mobile Number:</label>
    <input type="text" class="form-control" id="mobile" readonly>
  </div>
  <div class="form-group">
    <label for="usr">Address:</label>
    <input type="text" class="form-control" id="address">
  </div>
  <div class="form-group">
    <label for="usr">Reference Number:<span class="mandatory">*</span></label>
    <input type="text" class="form-control" id="reference" readonly>
  </div>
  <div class="form-group">
    <label for="sel1">Followed By:<span class="mandatory">*</span></label>
    <select class="form-control" id="followedBy">
    <option value="">-- SELECT NAME --</option>
      <?php
      $sqlSelect = "SELECT `EMPLOYEE_ID`, EMP_IDENTIFY, `EMPLOYEE_NAME` FROM `employee_details` ORDER BY 2";
      $result = mysqli_query($conn, $sqlSelect);
      if(mysqli_num_rows($result) > 0){ 
      while($row = mysqli_fetch_array($result)) {
        ?>
        <option value="<?php echo $row['EMP_IDENTIFY']."-".$row['EMPLOYEE_NAME']?>" ><?php echo $row['EMP_IDENTIFY']." - ".$row['EMPLOYEE_NAME'] ?></option>
        <?php
        }
        }
      ?>
      </select>
  </div>
  <div class="form-group">
    <label for="usr">Note 1:</label>
    <input type="text" class="form-control" id="note1">
  </div>
  <div class="form-group">
    <label for="usr">Note 2:</label>
    <input disabled type="text" class="form-control" id="note2">
  </div>
  <div class="form-group">
      <label for="pwd">Remarks:<span class="mandatory">*</span></label>
      <textarea class="form-control" rows="5"  id="remarks" name="remarks" readonly></textarea>
  </div>

  <!-- <div class="form-group">
      <label for="sel1">Date</label>
      <input type="date" class="form-control" id="date" />
  </div> -->
    </div>                     
                                
    <input type="hidden" class="form-control" id="addSalaryHiddenInput" value="0">

          <div class="row" id="addSalary">
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

            <div class="col-sm-2">
              <div class="form-group txt-center">
                <label for="pwd">THICKNESS</label>
              </div>      
            </div>

            <div class="col-sm-3">
              <div class="form-group txt-center">
                <label for="pwd">PRODUCT</label>
              </div>      
            </div>

            <div class="col-sm-2">
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
  <button type="button" class="btn btn-info"  onclick="saveData()" id="submit-btn" name="submit">Submit</button>
  </center>
</div>

</div>
</div>
  

</section>
</section>
<!--main content end-->
</section>

</body>

<script type="text/javascript">
function saveData() {
     let cnf = confirm("Sure to save?");
     if(!cnf){
        return;
     }
     else{


    let custName = $('#customerName').val();
    if(!custName || custName.length == 0) {
      alert('Customer Name is mandatory!');
      return;
    }
    let mobile = $('#mobile').val();
    if(!mobile || mobile.length == 0) {
      alert('Mobile No is mandatory!');
      return;
    }
    let address = $('#address').val();
    if(!address || address.length == 0) {
      alert('Address is mandatory!');
      return;
    }
    let followedByPerson = $('#followedBy').val();
    if(!followedByPerson || followedByPerson.length == 0) {
      alert('Followed By Person is mandatory!');
      return;
    }

    if(isDuplicate.length == 0) {
      alert('Please enter atleast one product!');
      return;
    }

    let toAddress = document.getElementById("toAddress").value;
    let size = [];
    let finishing = [];
    let type = [];
    let thickness = [];
    let product = [];
    let price = [];
    let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
 
    let note1 = $("#note1").val();
    let note2 = $("#note2").val();
    let followedBy = $("#followedBy").val();
    let reference = $("#reference").val();
    
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
          let productVal = $("#Product-"+(i+1)).val();
          let priceVal = $("#salAdd-"+(i+1)).val();
        if(priceVal != '' && sizeVal != 'None' && typeVal != 'None' && productVal != 'None') {
          size[inc] = sizeVal;
          finishing[inc] = finishingVal;
          type[inc] = typeVal;
          thickness[inc] = thicknessVal;
          product[inc] = productVal;
          price[inc] = priceVal;
          inc = inc + 1;
        }else{
          alert("Please insert all value...");
          return false;
        }
      }
    } else {
      alert("Kindly add the required products!");
      return false;
    }
    
    let params = new window.URLSearchParams(window.location.search);
    let quotationId = params.get('quotationId');
    $("#submit-btn").attr("disabled",true);
    $.ajax({
       type: 'post',
       url: 'sunmac_quatation.php',
       data: {
          custName:custName,
          quotationId: quotationId,
          mobile:mobile,
          remarks:remarks,
          toAddress:toAddress,
          note1:note1,
          note2:note2, 
          followedBy:followedBy,
          reference:reference,
          count:addSalaryHiddenInput,
          note1: note1,
          size:size.toString(),
          finishing:finishing.toString(),
          type:type.toString(),
          thickness: thickness.toString(),
          product:product.toString(),
          price:price.toString(),
          refNo: refNo.split("-")[1]
       },
       success: function (response) {
        console.log(response);
        window.location.href="sales_quotation.php";
        // window.open('sales_quotation.php');
       }
    });
}
  }

  $(document).ready(function(){
    $(".fa-bars").click();
    $("#toAddress").val(address.split("- ADS - ")[0] + "\n" + address.split("- ADS - ")[1]);
    $("#remarks").val(remarks);
    $("#customerName").val(custName);
    $("#mobile").val(mobile);
    $("#address").val(address);
    $("#reference").val(refNo);
  });

</script>
</html>







