<?php
session_start();
include 'db_connect.php';
$refNo = 0;

date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$date = date('Y-m-d', strtotime($date_1));

$refrenceSql = "SELECT * FROM `refrence_po` WHERE date = '$date'";
  $resultRef = mysqli_query($conn,$refrenceSql);
  if($row = mysqli_fetch_array($resultRef)) {
    $refNo = $row['INC_NO'] + 1;
  } else {
    $refNo = 1;
  }

?>

<!DOCTYPE html>
  <head>
  <title>Generate PO</title>
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
  
  <style>
.form-control:focus {
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(126, 239, 104, 0.6);
  outline: 0 none;
}

.btn:focus,.btn:active {
   outline: none !important;
   box-shadow: none;
}

#btn-create {
  margin-top: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.material-icons-fonts {
  font-size: 16px;
}
</style>

<script type="text/javascript">
  var product = [];;
  function replaceAll(searchString, replaceString, str) {
    return str.split(searchString).join(replaceString);
  }

  var sizeValue = [];
  var refNo = (new Date()).toISOString().split('T')[0];
  refNo = replaceAll("-", "", refNo);
  refNo = 'PO'+refNo + "-" + <?php echo $refNo; ?>
</script>

<script>
// function createRow() {
//    var table = document.getElementById('product-table');
//    var tableBody = document.getElementById('table-body');
//    var tr = document.createElement('TR');

//    var tdId = document.createElement('TD');
//    var td = document.createElement('TD');
//    var tdQty = document.createElement('TD');
//    var tdAmt = document.createElement('TD');
//    var tdDelBtn = document.createElement('TD');

//    let sel = document.getElementById("productNameSelect");
//    let cellId = document.createTextNode(document.getElementById('productNameSelect').value);
//    let cellText = document.createTextNode(sel.options[sel.selectedIndex].text);
//    let cellTextQty = document.createTextNode(document.getElementById('quantity').value);
//    let cellTextAmt = document.createTextNode(document.getElementById('amount').value);
   
//    let totalAmount = document.getElementById('totalAmount').value;
//     try {
//       debugger;
//       totalAmount = parseInt(totalAmount);
//       let productAmt = parseInt(document.getElementById('amount').value);
//       document.getElementById('totalAmount').value = (totalAmount + productAmt);
//     } catch(err) {

//     }

//    var btn = document.createElement("BUTTON");
//      btn.className ="btn btn-primary btn-xs";
//    btn.onclick = function() {
//     deleteRow(this);
//    };
//    btn.setAttribute('id', 'btn-create');
//    let i = document.createElement('i');
//    i.className = 'material-icons material-icons-fonts';
//    let text = document.createTextNode('delete');
//    i.appendChild(text);
//    btn.appendChild(i);
   
//    tdId.appendChild(cellId);
//    td.appendChild(cellText);
//    tdQty.appendChild(cellTextQty);
//    tdAmt.appendChild(cellTextAmt);
//    tdDelBtn.appendChild(btn);
   
//    tr.appendChild(tdId);
//    tr.appendChild(td);
//    tr.appendChild(tdQty);
//    tr.appendChild(tdAmt);
//    tr.appendChild(tdDelBtn)
   
//    tableBody.appendChild(tr);
//    table.appendChild(tableBody);
// }

// function deleteRow(row) {
//   var i = row.parentNode.parentNode.rowIndex;
//   let productTable = document.getElementById('product-table');
//   let rowCells = productTable.rows.item(i).cells;
//   let productAmount = rowCells.item(2).innerHTML;
//   let totalAmount = document.getElementById('totalAmount').value;
//   try {
//     totalAmount = parseInt(totalAmount);
//     productAmount = parseInt(productAmount);
//     document.getElementById('totalAmount').value = (totalAmount - productAmount);
//   } catch(err) {}
//   document.getElementById('product-table').deleteRow(i);
// }

var deleteRow = function(button) {
  debugger;
  let rowId = $(button)[0].id.split("-")[1];
  $("#Product-"+rowId).closest('.col-sm-3').remove();
  $("#QuantityAdd-"+rowId).closest('.col-sm-3').remove();
  $("#RateAdd-"+rowId).closest('.col-sm-3').remove();
  $("#salAdd-"+rowId).closest('.col-sm-2').remove();
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
  
// for product
   let colDivProduct = document.createElement('div');
   colDivProduct.className = 'col-sm-3';
   let formGroupDivProduct = document.createElement('div');
   formGroupDivProduct.className = 'form-group';
   let labelProduct = document.createElement('label');
   labelProduct.innerHTML = "Product";

     optionProduct = "";
        optionProduct += "<option value='None'>Select None</option>";
    for(var val in product) {
        optionProduct += "<option>"+product[val]+"</option>";
    }
  //  let inputProduct = document.createElement('select');
  //  inputProduct.className = "form-control"; 
  //  inputProduct.setAttribute("id", "Product-"+hiddenVal);
  //  inputProduct.setAttribute("name", "Product");
  //  inputProduct.setAttribute("required", "");
   let inputProduct = document.createElement('input');
   inputProduct.className = "form-control"; 
   inputProduct.setAttribute("id", "Product-"+hiddenVal);
   inputProduct.setAttribute("name", "Product");
   inputProduct.setAttribute("required", "");
   inputProduct.setAttribute("onchange", "dataChange(this)");
  //  formGroupDivProduct.append(labelProduct);
   formGroupDivProduct.append(inputProduct);
   colDivProduct.append(formGroupDivProduct);

// for Quantity
   
   let colDivQuantity = document.createElement('div');
   colDivQuantity.className = 'col-sm-3';
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
   colDivRate.className = 'col-sm-3';
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
   colDivSal.className = 'col-sm-2';
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

   div.append(colDivProduct);
   div.append(colDivQuantity);
   div.append(colDivRate);
   div.append(colDivSal);
   $(div).append(html);
  

      $('#Product-'+hiddenVal).append(optionProduct);

  }

var dataChange = function(input) {
  $(input).attr("disabled", true);
};

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
  $("#gst-btn").attr("disabled", false);   
  dataChange(demo);
}


function getTableDatas() {
  let productId = [];
  let productName = [];
  let productQty = [];
  let productAmount = [];
  let arrVal = 0;

  var productTable = document.getElementById('product-table');
    //gets rows of table
    var rowLength = productTable.rows.length;
    
    //loops through rows    
    for (i = 1; i < rowLength; i++) {
      var canContinue = 0;
      //gets cells of current row  
       var productCells = productTable.rows.item(i).cells;
       //gets amount of cells of current row
       var cellLength = productCells.length;
       //loops through each cell in current row
       for(var j = 0; j < (cellLength-1); j++){
              // get your cell info here
              if(productCells.item(j).innerHTML == "" || productCells.item(j).innerHTML == undefined) {
                alert("Enter all values!");
                canContinue = 1;
                return false;
              }
              if(j == 0) {
                productId[arrVal] = productCells.item(j).innerHTML;
              } else if(j == 1) {
                productName[arrVal] = productCells.item(j).innerHTML;
              } else if(j == 2) {
                productQty[arrVal] = productCells.item(j).innerHTML;
              } else if(j == 3) {
                productAmount[arrVal] = productCells.item(j).innerHTML;
              }
              
              //var cellVal = productCells.item(j).innerHTML;

        }
        if(canContinue == 1) {
          return false;
        } else {
          arrVal++;
        }
        
    }
  console.log("productId", productId);
  console.log("productName", productName);
  console.log("productQty", productQty);
  console.log("productAmount", productAmount);

  saveRecords(productId,productName, productQty, productAmount);
}
</script>
<body>
  <?php include 'header.php'; ?>
  <!-- sidebar menu end-->

  <section id="main-content">
  	<section class="wrapper">
         <div class="form-w3layouts">
          <!-- page start-->
          <!-- page start-->
          <div class="row">
              <div class="col-lg-12">
                  <section class="panel">
                      <header class="panel-heading">
                          PURCHASE ENTRY
                      </header>
                      <div class="panel-body">
                          <div>
                                <form action=" " method="post" role="form">
                                  <div class="form-group">
    <label for="sel1">Supplier list:</label>
    <select class="form-control" id="customerListSelect" onchange="getDataFromDBForThisCustomer(this.value);" require>
      <option value="">-- SELECT CUSTOMER --</option>
     <?php
    $sqlSelect = "SELECT P_ID, P_COMPANY_NAME FROM `purchase_customer`";
    $result = mysqli_query($conn, $sqlSelect);
          if(mysqli_num_rows($result) > 0){ 
            while($row = mysqli_fetch_array($result)) {
    ?>
    <option value="<?php echo $row['P_ID']?>" ><?php echo $row['P_COMPANY_NAME'] ?></option>
  <?php
          }
        }
    ?>
    </select>
  </div>
  
  <div class="form-group">
    <label for="qty">Mobile:</label>
    <input type="text" class="form-control" id="mobile" name="mobile" require>
  </div>

  <div class="form-group">
    <label for="qty">Email:</label>
    <input type="text" class="form-control" id="email" name="email" require>
  </div>

  <div class="form-group">
    <label for="qty">Address:</label>
    <input type="text" class="form-control" id="address" name="address" require>
  </div>

  <div class="form-group">
    <label for="qty">GST Number:</label>
    <input type="text" class="form-control" id="gst" name="gst" require>
  </div>

  <div class="form-group">
    <label for="qty">Po No:*</label>
    <input type="text" class="form-control" id="refNo" name="refNo" require>
  </div>

   <!-- <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label for="pro-name">Product Name:</label>
        <select class="form-control" id="productNameSelect">
        
        </select>
      </div>
    </div>
    
    <div class="col-sm-3">
      <div class="form-group">
        <label for="qty">Qty:</label>
        <input type="text" class="form-control" id="quantity" name="quantity">
      </div>
    </div>
    
    <div class="col-sm-4">
      <div class="form-group">
        <label for="amt">Amount:</label>
        <input type="text" class="form-control" id="amount" name="amount">
      </div>
    </div>
    
    <div class="col-sm-1">
      <div class="form-group">
        <label for="pwd"></label>
        <button type="button" class="btn btn-info btn-sm" id="btn-create" onclick="createRow()">
        <i class="material-icons">add</i>
        </button>
      </div>
    </div>
    
   </div> End Of Row -->
  </form>

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
  
  <div class="col-sm-3">
    <div class="form-group txt-center">
      <label for="pwd">PRODUCT</label>
    </div>      
  </div>

  <div class="col-sm-3">
    <div class="form-group txt-center">
      <label for="pwd">QUANTITY</label>
    </div>      
  </div>

  <div class="col-sm-3">
    <div class="form-group txt-center">
      <label for="pwd">RATE</label>
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
<br><br>

<div class="row">
<div class="col-sm-2">
    <div class="form-group">
        <label for="usr">Total Amount:</label>
        <input type="text" class="form-control" id="totalAmt" name="totalAmt" value="0" disabled>
      </div>
  </div>  
  <div class="col-sm-1">
        <label for="usr">&nbsp;</label>
        <button type="button" class="btn btn-success" id="gst-btn" onclick="enableGst(this)" style="margin: -25px;" disabled>Enable GST</button>  
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
  <button type="button" class="btn btn-info" name="submit" value="Submit" onclick="saveData()" disabled>
    <i class="fa fa-floppy-o" aria-hidden="true"></i>
    Submit
  </button>
  </div>

</center>
</div>
</div>

</div>

<br><br><br><br><br>

  </div>
</div>

</div>

<script type="text/javascript">

  function getDataFromDBForThisCustomer(val) {
    $.ajax({
       type: 'post',
       url: 'get_purchase_customer_products.php',
       data: {
        customerId:val
       },
       success: function (response) {
         debugger;
         response = JSON.parse(response);
         $("#mobile").val(response["MOBILE"]);
         $("#mobile").attr("disabled", true);
         $("#address").val(response["ADDRESS"]);
         $("#address").attr("disabled", true);
         $("#gst").val(response["GST"]);
         $("#gst").attr("disabled", true);
         $("#email").val(response["EMAIL"]);
         $("#email").attr("disabled", true);
         $("#refNo").val(refNo);
         $("#refNo").attr("disabled", true);
         let products = response && response["PRODUCTS"] ? response["PRODUCTS"] : null;
         if(null != products) {
           let keys = Object.keys(products);
           let option = "<option value=''>-- SELECT PRODUCTS --</option>";
           for(let i=0; i<keys.length; i++) {
             product.push(products[keys[i]]);
             option += '<option value="'+keys[i]+'">'+products[keys[i]]+'</options>';
           }
          //  document.getElementById("productNameSelect").innerHTML=option;
         }
         
       }
       });
  }

  function saveRecords(productId,productName, productQty, productAmount) {
    let customerId = document.getElementById('customerListSelect').value;
    let billNumber = document.getElementById('billNumber').value;
    let purchasedDate = document.getElementById('purchasedDate').value; //YYYY-MM-DD
    let totalAmount = document.getElementById('totalAmount').value;
    let productCount = productName.length;
    $.ajax({
       type: 'post',
       url: 'savePurchaseEntry.php',
       data: {
        customerId: customerId,
        billNumber: billNumber,
        purchasedDate: purchasedDate,
        totalAmount: totalAmount,
        productCount: productCount,
        productIdArray: productId.toString(),
        productNameArray: productName.toString(),
        productQtyArray: productQty.toString(),
        productAmountArray: productAmount.toString() 
       },
       success: function (response) {
        alert("Record Saved!")
        window.location.href='purchase_Entry.php'; 
       }
       });

  }

  var enableGst = function(btn) {
    let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
    if(addSalaryHiddenInput == 0) {
      alert("Kindly add the products");
      return false;
    }
  $("#gstValue").attr('disabled', false);
  $("button[name='submit']").attr('disabled', false);
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
  debugger;
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
  let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
  for(i=0; i<addSalaryHiddenInput; i++) {
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
}

function saveData() {

  if (!confirm("Are you sure to Submit!")) {
    return;
  } else {
    // let toAddress = document.getElementById("toAddress").value;
    let productName = [];
    let quantity = [];
    let rate = []
    let price = [];
    let addSalaryHiddenInput = parseInt(document.getElementById("addSalaryHiddenInput").value);
    if(addSalaryHiddenInput == 0) {
      alert("Kindly add the products");
      return false;
    }
    if(addSalaryHiddenInput > 0){
      let inc = 0;
      for(i=0; i<addSalaryHiddenInput; i++) {
        
        let currentProductName = $("#Product-"+(i+1)).val();
        let qty = $("#QuantityAdd-"+(i+1)).val();
        let currentRate = $("#RateAdd-"+(i+1)).val();
        var priceVal = $("#salAdd-"+(i+1)).text();
        if(currentProductName != '' || qty != '' || currentRate != '' || priceVal != '') {
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
    
    let customerName = $("#customerListSelect option:selected").text();
    let mobile = $("#mobile").val();
    let email = $("#email").val();
    let address = $("#address").val();
    let gst = $("#gst").val();
    let refNo = $("#refNo").val();

    if(customerName == null || customerName == "" || customerName == "-- SELECT CUSTOMER --") {
      alert("Customer Name is mandatory!");
      return false;
    } else if(mobile == null || mobile == "") {
      alert("Mobile is mandatory!");
      return false;
    } else if(email == null || email == "") {
      alert("Email is mandatory!");
      return false;
    } else if(address == null || address == "") {
      alert("Address is mandatory!");
      return false;
    } else if(gst == null || gst == "") {
      alert("GST is mandatory!");
      return false;
    } else if($("#gstValue").val() == "None") {
      alert("Choose the GST");
      return false;
    }

    $.ajax({
       type: 'post',
       url: 'generatePoSave.php',
       data: {
          customerName: customerName,
          mobile: mobile,
          refNo: refNo,
          address: address,
          count:addSalaryHiddenInput, 
          productName:productName.toString(),
          quantity: quantity.toString(),
          rate: rate.toString(),
          price:price.toString(),
          gst:  $("#central").val() * 2,
          totalAmount: $("#totalAmount").val(),
          gstAmount: $("#totalGstCalcAmount").val(),
          refrenceNo: refNo.split("-")[1]
       },
       success: function (response) {
        console.log(response);
        alert("Inserted Successfully");
        window.location = "generatePo.php";
       }
    });

  }
   
  }


</script>
</section>
</body>
</html>






