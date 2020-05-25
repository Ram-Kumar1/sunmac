<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>

<head>
  <title>Purchase Entry</title>
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

  .btn:focus,
  .btn:active {
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

<script>
  function createRow() {
    var table = document.getElementById('product-table');
    var tableBody = document.getElementById('table-body');
    var tr = document.createElement('TR');

    var tdId = document.createElement('TD');
    var td = document.createElement('TD');
    var tdQty = document.createElement('TD');
    var tdAmt = document.createElement('TD');
    var tdDelBtn = document.createElement('TD');

    let sel = document.getElementById("productNameSelect");
    let cellId = document.createTextNode(document.getElementById('productNameSelect').value);
    let cellText = document.createTextNode(sel.options[sel.selectedIndex].text);
    let cellTextQty = document.createTextNode(document.getElementById('quantity').value);
    let cellTextAmt = document.createTextNode(document.getElementById('amount').value);

    let totalAmount = document.getElementById('totalAmount').value;
    try {
      debugger;
      totalAmount = parseInt(totalAmount);
      let productAmt = parseInt(document.getElementById('amount').value);
      document.getElementById('totalAmount').value = (totalAmount + productAmt);
    } catch (err) {

    }

    var btn = document.createElement("BUTTON");
    btn.className = "btn btn-primary btn-xs";
    btn.onclick = function() {
      deleteRow(this);
    };
    btn.setAttribute('id', 'btn-create');
    let i = document.createElement('i');
    i.className = 'material-icons material-icons-fonts';
    let text = document.createTextNode('delete');
    i.appendChild(text);
    btn.appendChild(i);

    tdId.appendChild(cellId);
    td.appendChild(cellText);
    tdQty.appendChild(cellTextQty);
    tdAmt.appendChild(cellTextAmt);
    tdDelBtn.appendChild(btn);

    tr.appendChild(tdId);
    tr.appendChild(td);
    tr.appendChild(tdQty);
    tr.appendChild(tdAmt);
    tr.appendChild(tdDelBtn)

    tableBody.appendChild(tr);
    table.appendChild(tableBody);
  }

  function deleteRow(row) {
    var i = row.parentNode.parentNode.rowIndex;
    let productTable = document.getElementById('product-table');
    let rowCells = productTable.rows.item(i).cells;
    let productAmount = rowCells.item(2).innerHTML;
    let totalAmount = document.getElementById('totalAmount').value;
    try {
      totalAmount = parseInt(totalAmount);
      productAmount = parseInt(productAmount);
      document.getElementById('totalAmount').value = (totalAmount - productAmount);
    } catch (err) {}
    document.getElementById('product-table').deleteRow(i);
  }

  function getTableDatas() {
    let cnf = confirm("Sure to Save?")
    if (!cnf) {
      return;
    }
    $("#btn-create").attr("disabled", true);
    let productId = [];
    let productName = [];
    let productQty = [];
    let productAmount = [];
    let arrVal = 0;

    var productTable = document.getElementById('product-table');
    //gets rows of table
    var rowLength = productTable.rows.length;

    //loops through rows    
    // for (i = 1; i < rowLength; i++) {

    //   //gets cells of current row  
    //    var productCells = productTable.rows.item(i).cells;
    //    //gets amount of cells of current row
    //    var cellLength = productCells.length;
    //    //loops through each cell in current row
    //    for(var j = 0; j < (cellLength-1); j++){
    //           // get your cell info here
    //           if(j == 0) {
    //             productId[arrVal] = productCells.item(j).innerHTML;
    //           } else if(j == 1) {
    //             productName[arrVal] = productCells.item(j).innerHTML;
    //           } else if(j == 2) {
    //             productQty[arrVal] = productCells.item(j).innerHTML;
    //           } else if(j == 3) {
    //             productAmount[arrVal] = productCells.item(j).innerHTML;
    //           }

    //           //var cellVal = productCells.item(j).innerHTML;

    //     }
    //     arrVal++;
    // }
    productId[0] = $("#productNameSelect").val();
    productName[0] = $("#productNameSelect option:selected").text();
    console.log("productId", productId);
    console.log("productName", productName);
    // console.log("productQty", productQty);
    // console.log("productAmount", productAmount);

    saveRecords(productId, productName);
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
                <div class="position-center">
                  <form action=" " method="post" role="form">
                    <div class="form-group">
                      <label for="sel1">Customer list:</label>
                      <select class="form-control" id="customerListSelect" onchange="getDataFromDBForThisCustomer(this.value);">
                        <option value="">-- SELECT CUSTOMER --</option>
                        <?php
                        $sqlSelect = "SELECT P_ID, P_COMPANY_NAME FROM `purchase_customer`";
                        $result = mysqli_query($conn, $sqlSelect);
                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <option value="<?php echo $row['P_ID'] ?>"><?php echo $row['P_COMPANY_NAME'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="qty">Mobile:</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" required>
                    </div>

                    <div class="form-group">
                      <label for="qty">Email:</label>
                      <input type="text" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                      <label for="qty">Address:</label>
                      <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="form-group">
                      <label for="qty">GST Number:</label>
                      <input type="text" class="form-control" id="gst" name="gst" required>
                    </div>

                    <div class="form-group">
                      <label for="qty">Bill Number:</label>
                      <!-- <input type="text" class="form-control" id="billNumber" name="billNumber" required> -->
                      <select class="form-control" id="billNumber" name="billNumber" required>
                        <option value="">-- SELECT VALUE --</option>
                        <?php
                        $sqlSelect = "SELECT `REFERENCE_NO` FROM `sample_po` ORDER BY `DATE` DESC";
                        $result = mysqli_query($conn, $sqlSelect);
                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <option value="<?php echo $row['REFERENCE_NO'] ?>"><?php echo $row['REFERENCE_NO'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="qty">Purchased Date:</label>
                      <input type="date" class="form-control" id="purchasedDate" name="purchasedDate" required>
                    </div>

                    <div class="form-group">
                      <label for="qty">Weight:</label>
                      <input type="number" class="form-control" id="weight" name="weight" required>
                    </div>

                    <div class="form-group">
                      <label for="pro-name">Product Name:</label>
                      <select class="form-control" id="productNameSelect">

                      </select>
                    </div>

                    <div class="form-group">
                      <label for="qty">Type:</label>
                      <select class="form-control" id="type-select" onchange="" required>
                        <option value="">-- SELECT TYPE --</option>
                        <?php
                        $sqlSelect = "SELECT * FROM `production_type`";
                        $result = mysqli_query($conn, $sqlSelect);
                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <option><?php echo $row['type_name'] ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="qty">Payment:</label>
                      <select class="form-control" id="payment-select" onchange="paymentChanged(this)" required>
                        <option value="">-- CHOOSE VALUE --</option>
                        <option value="Outstanding">Outstanding</option>
                        <option value="Payment Done">Payment Done</option>
                      </select>
                    </div>

                    <div class="form-group" id="remaining-payment-div" style="display: none;">
                      <label for="qty">Remaining Amount:</label>
                      <input type="number" class="form-control" id="remaining-amount" name="remaining-amount">
                    </div>

                    <!-- <div class="form-group">
        <label for="pro-name">Product Name:</label>
        <select class="form-control" id="productNameSelect" required>
        
        </select>
  </div> -->
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
    </div> -->
                    <!-- 
    <div class="col-sm-12">
      <div class="form-group">
        <label for="amt">Total Amount:</label>
        <input type="text" class="form-control" id="totalAmount" name="totalAmount" required>
      </div>
    </div>
    <div id="productIdSelect">
    </div> -->

                </div>
                <!--End Of Row -->
                </form>
              </div>
          </div>
          <table class="table" id="product-table" style="display: none;">
            <thead>
              <tr>
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody id='table-body'>
              <!-- ROWS ARE GENERATED DYNAMICAALY -->
            </tbody>
          </table>
          <button type="button" class="btn btn-info btn-sm" id="btn-create" onclick="getTableDatas()" style="margin-left: 50%;">
            SAVE
          </button>
        </div>

        <script type="text/javascript">
          var paymentChanged = function(select) {
            let value = $(select).val();
            if (value == "Outstanding") {
              $("#remaining-payment-div").show();
            } else {
              $("#remaining-payment-div").hide();
            }
          };
          var getDataFromDBForThisCustomer = function(val) {
            $.ajax({
              type: 'post',
              url: 'get_purchase_customer_products.php',
              data: {
                customerId: val
              },
              success: function(response) {
                response = JSON.parse(response);
                $("#mobile").val(response["MOBILE"]);
                $("#mobile").attr("disabled", true);
                $("#address").val(response["ADDRESS"]);
                $("#address").attr("disabled", true);
                $("#gst").val(response["GST"]);
                $("#gst").attr("disabled", true);
                $("#email").val(response["EMAIL"]);
                $("#email").attr("disabled", true);
                let products = response && response["PRODUCTS"] ? response["PRODUCTS"] : null;
                if (null != products) {
                  let keys = Object.keys(products);
                  let option = "<option value=''>-- SELECT PRODUCTS --</option>";
                  for (let i = 0; i < keys.length; i++) {
                    //  product.push(products[keys[i]]);
                    option += '<option value="' + keys[i] + '">' + products[keys[i]] + '</options>';
                  }
                  document.getElementById("productNameSelect").innerHTML = option;
                }
              }
            });
          }

          function saveRecords(productId, productName, productQty, productAmount) {
            let customerId = document.getElementById('customerListSelect').value;
            let billNumber = document.getElementById('billNumber').value;
            let purchasedDate = document.getElementById('purchasedDate').value; //YYYY-MM-DD
            // let totalAmount = document.getElementById('totalAmount').value;
            let type = document.getElementById('type-select').value;
            let weight = $("#weight").val();
            let product = $("#productNameSelect").val();
            let productCount = productName.length;
            let paymentOption = $("#payment-select").val();
            let remainingAmount = 0;
            if (paymentOption == undefined || paymentOption == null || paymentOption == "") {
              alert("Payment Option is mandatory");
              $("#btn-create").attr("disabled", false);
              return;
            }
            if (paymentOption == "Outstanding") {
              remainingAmount = $("#remaining-amount").val();
              if (remainingAmount == "" || remainingAmount == undefined) {
                alert("Remaining Amount is mandatory field");
                $("#btn-create").attr("disabled", false);
                return;
              }
            }

            if (customerId == undefined || customerId == null || customerId == "") {
              alert("Customer Name is mandatory");
              $("#btn-create").attr("disabled", false);
              return;
            } else if (billNumber == undefined || billNumber == null || billNumber == "") {
              alert("Enter the value for bill number");
              $("#btn-create").attr("disabled", false);
              return;
            } else if (purchasedDate == undefined || purchasedDate == null || purchasedDate == "") {
              alert("Enter the Purchase date");
              $("#btn-create").attr("disabled", false);
              return;
            } else if (weight == undefined || weight == null || weight == "") {
              alert("Enter the value for weight");
              $("#btn-create").attr("disabled", false);
              return;
            } else if (isNaN(parseInt(weight)) == false && parseInt(weight) == 0) {
              alert("Weight must be greater than 0");
              $("#btn-create").attr("disabled", false);
              return;
            } else if (type == undefined || type == null || type == "") {
              alert("Choose the type");
              $("#btn-create").attr("disabled", false);
              return;
            } else if (product == undefined || product == null || product == "") {
              alert("Choose the product");
              $("#btn-create").attr("disabled", false);
              return;
            }

            $.ajax({
              type: 'post',
              url: 'savePurchaseEntry.php',
              data: {
                customerId: customerId,
                billNumber: billNumber,
                type: type,
                weight: weight,
                purchasedDate: purchasedDate,
                // totalAmount: totalAmount,
                // productCount: productCount,
                productIdArray: productId.toString(),
                productNameArray: productName.toString(),
                paymentOption: paymentOption,
                remainingAmount: remainingAmount
                // productQtyArray: productQty.toString(),
                // productAmountArray: productAmount.toString() 
              },
              success: function(response) {
                alert("Record Saved!")
                // window.location.href = 'purchase_Entry.php';
              }
            });

          }
        </script>
    </section>
</body>

</html>