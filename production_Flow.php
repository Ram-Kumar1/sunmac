<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<head>
<title>Production Flow</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>  

<?php
include 'demo.css';
?>
<?php
include 'demo.js';
?>
</head>

<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; -moz-appearance: none; appearance: none; margin: 0; }
  .Length {
    color: red !important;
  }

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

  .m-10 {
    margin-top: 10px;
  }

  .m-20 {
    margin-top: 20px;
  }

  hr {
    margin-top: 40px !important;
  }
</style>

<script type="text/javascript">
  /*  VARIABLE DECALRATIONS */
  isFlowCompleted = 0;
  var availableWeight = 0;
  var productWeight = 0;
  var remainingWeight = 0;
  var enteredMachineIds = [];
</script>



<script type="text/javascript">
  var userType = null;
  var zeroOutputArray = [];
  var dataInputChange = function(input) {
    if($("#productNameSelect").attr("disabled") != "disabled") {
      $("#productNameSelect").attr("disabled", true);
    }

    if(userType != "productionManager") {
      if($("#date").val() == "") {
        alert("Please Choose the date before entring the input!");
        $(input).val('');
        return false;
      }
      $("#date").attr("disabled", true);
    }
    
    let inputId = $(input)[0].id;
    let currentMachineId = inputId.split("-")[1];
    let beforeMachineId = $(input).attr("data-beforemachineid");
    let nextMachineId = $(input).attr("data-aftermachineid");
    let val = parseInt($(input).val());
    debugger;

    if(beforeMachineId == "0") {
      let totalGivenWeight = val * productWeight;
      if(totalGivenWeight > availableWeight) {
        alert('Given weight is greater than available weight!');
        $(input).val('');
        return false;
      } else {
        remainingWeight = availableWeight - totalGivenWeight;
      }
    }

    if(beforeMachineId != "0" && isNaN(parseInt($("#label-totalProcessed-"+beforeMachineId).text()))) {
      $(input).val('');
      alert("Please fill the details for the above machine");
      return false;
    }
    if(beforeMachineId != "0" && val > parseInt($("#label-totalProcessed-"+beforeMachineId).text())) {
      $(input).val('');
      alert("Input must be lesser than Total Stock! ");
      return false;
    } else {
      let unProcessed = parseInt($("#label-unProcessedInput-"+currentMachineId).text());
      if(isNaN(unProcessed)) {
        unProcessed = 0;
      }
      let totInput = val + unProcessed;
      $("#label-currentTotal-"+currentMachineId).text(totInput);
      // today stock
      let totalProcessed =  $("#label-totalProcessed-"+beforeMachineId).text();
      let oldTotalStock = parseInt(totalProcessed -val);
      $("#todayStock-"+beforeMachineId).text(oldTotalStock);
      if(beforeMachineId == "0") {
        $("#output-"+currentMachineId).val(totInput);
        $("#output-"+currentMachineId).attr("disabled", true);
        dataOutputChange($("#output-"+currentMachineId)[0]);
      }
    }
    $(input).attr("disabled", true);
  };

    /**
        Calculate the stock based on the given value and update it in the current machine stock input element.
    */
  var dataOutputChange = function(input) {
    
    if($("#productNameSelect").attr("disabled") != "disabled") {
      $("#productNameSelect").attr("disabled", true);
    }

    if(userType != "productionManager") {
        if($("#date").val() == "") {
          alert("Please Choose the date before entring the input!");
          $(input).val('');
          return false;
        }
        $("#date").attr("disabled", true);
    }
    
    let inputId = $(input)[0].id;
    let currentMachineId = inputId.split("-")[1];
    let beforeMachineId = $(input).attr("data-beforemachineid");
    let nextMachineId = $(input).attr("data-aftermachineid");
    let val = parseInt($(input).val());
    if(isNaN(val)) {
      val = 0;
      $(input).val('0');
    }
    let totalProcessed ;

    if(isNaN(parseInt($("#input-"+currentMachineId).val()))) {
      $(input).val('');
      alert("Please fill the input before filling the output");
      return false;
    }

    if(val > parseInt($("#label-currentTotal-"+currentMachineId).text())) {
      $(input).val('');
      alert("Output must be lesser than total input");
      return false;
    } else {
      $("#label-processed-"+currentMachineId).text(val);
      let oldStock = parseInt($("#label-oldStock-"+currentMachineId).text());
      if(isNaN(oldStock)) {
        oldStock = 0;
      }
      totalProcessed = val + oldStock;
      if(val == 0) {
        zeroOutputArray.push(currentMachineId);
      }
      $("#label-totalProcessed-"+currentMachineId).text(totalProcessed);
      $("#todayStock-"+currentMachineId).text(totalProcessed);
      let upProcessed = parseInt($("#label-currentTotal-"+currentMachineId).text()) - val;
      $("#unProcessed-"+currentMachineId).text(upProcessed);

    }


    if(nextMachineId == "0") {
      
      let productName;
        if($("#sizeMachine").val().startsWith('J-')) {
        //if($("#productNameSelect").attr("disabled") == "disabled") {
         productName =  $("#productNameSelectJob option:selected").text();
        } else {
          productName = $("#productNameSelect option:selected").text();
        }

      $("#productNameId").text(productName);
      $("#productNameIdWeight").text("New Weight");
      $("#productStockId").text(totalProcessed);
      let todayWeight = totalProcessed * parseInt($('#productWeight').val());
      $("#productStockIdWeight").text(todayWeight);
      $("#productTotalLabel").text("Total");
      $("#productTotalLabelWeight").text("Total Weight");
      let totalVal = parseInt($("#productStockIdView").text()) + parseInt(totalProcessed);
      $("#productTotalValue").text(totalVal);
      let totalWeight = parseInt($("#productStockIdViewWeight").text()) + parseInt($("#productStockIdWeight").text());
      $("#productTotalValueWeight").text(totalWeight);
      isFlowCompleted = 1;
      $("#machine-time").attr("disabled", false);
    }
    enteredMachineIds.push(currentMachineId);
    $(input).attr("disabled", true);
  };

  var typeChanged = function(select) {
     $("#thickness").attr("disabled", false);
     $('#type').attr("disabled", true);
     $("#thickness").val('none');
     $("#productNameSelectJob").val('');
     $("#productNameSelect").val('');
     $('#machines-input').html('');
     $('#productNameIdView').text('');
     $('#productNameIdViewWeight').text('');
     $('#productStockIdView').text('');
     $('#productStockIdViewWeight').text('');
     $('#productTotalLabel').text('');
     $('#productTotalValue').text('');
     $("#sizeMachine").attr("disabled", true);
     $("#sizeMachine").val('none');
     $("#productNameSelect").attr("disabled", true);
     $("#productNameSelectJob").attr("disabled", true);
     if(userType != "productionManager") {
        $("#date").attr("disabled", true);
     }
  };

  var sizeChanged = function(select) {
    $('#type').attr("disabled", true);
    $("#thickness").attr("disabled", true);
    $("#sizeMachine").attr("disabled", true);
    if(select.value.toString().startsWith('J-')){
      $("#productNameSelectJob").attr("disabled", false);  
      $("#productNameSelect").val('');
      $('#machines-input').html('');
      $('#productNameIdView').text('');
      $('#productNameIdViewWeight').text('');
      $('#productStockIdView').text('');
      $('#productStockIdViewWeight').text('');
      $('#productTotalLabel').text('');
      $('#productTotalValue').text('');
      $("#productNameSelect").attr("disabled", true); 
      if(userType != "productionManager") {
        $("#date").attr("disabled", true);
     }
      
    } else {
       $("#productNameSelect").attr("disabled", false);
       $("#productNameSelectJob").val('');
       $('#machines-input').html('');
       $('#productNameIdView').text('');
       $('#productNameIdViewWeight').text('');
       $('#productStockIdView').text('');
       $('#productStockIdViewWeight').text('');
       $('#productTotalLabel').text('');
       $('#productTotalValue').text('');
       $("#productNameSelectJob").attr("disabled", true);  
      
    }
   
  };

  var thicknessChanged = function(select) {
    $('#type').attr("disabled", true);
    $("#thickness").attr("disabled", true);
    $("#sizeMachine").attr("disabled", false);
    $("#sizeMachine").val('none');
    $("#productNameSelectJob").val('');
    $("#productNameSelect").val('');
    $('#machines-input').html('');
    $('#productNameIdView').text('');
    $('#productNameIdViewWeight').text('');
    $('#productStockIdView').text('');
    $('#productStockIdViewWeight').text('');
    $('#productTotalLabel').text('');
    $('#productTotalValue').text('');
    $("#productNameSelect").attr("disabled", true);
    $("#productNameSelectJob").attr("disabled", true);
    if(userType != "productionManager") {
        $("#date").attr("disabled", true);
     }
  };

</script>

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
                        PRODUCTION FLOW
                    </header>

                    <div class="panel-body">
                       <div>
           
              <div class="row position-center" style="width: 100%;">
                <div class="col-sm-3">
                  <div class="form-group">
                     <label for="sel1">TYPE</label>
                          <select class="form-control" id="type"  onchange="typeChanged(this)"> 
                             <option value="none">select value</option>
                             <?php
                             $sqlSelect = "SELECT type_name FROM `production_type` ORDER BY 1";
                             $result = mysqli_query($conn, $sqlSelect);
                             if(mysqli_num_rows($result) > 0){ 
                             while($row = mysqli_fetch_array($result)) {
                              ?>
                            <option><?php echo $row['type_name'] ?></option>
                            <?php
                             }
                             }
                             ?>
                          </select>
                  </div>
                </div>
                
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="sel1">THICKNESS</label> 
                          <select disabled class="form-control" id="thickness"  onchange="thicknessChanged(this)"> 
                            <option value="none">-- SELECT VALUE --</option>
                            <?php
                            $sqlSelect = "SELECT thickness FROM `production_thickness` ORDER BY 1";
                            $result = mysqli_query($conn, $sqlSelect);
                            if(mysqli_num_rows($result) > 0){ 
                            while($row = mysqli_fetch_array($result)) {
                              ?>
                            <option><?php echo $row['thickness'] ?></option>
                            <?php
                            }
                            }
                            ?>
                          </select>
                  </div>   
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                     <label for="sel1">SIZE</label> 
                          <select disabled class="form-control" id="sizeMachine"  onchange="sizeChanged(this)"> 
                             <option value="none">select value</option>
                             <?php
                             $sqlSelect = "SELECT size FROM `production_size` ORDER BY 1";
                             $result = mysqli_query($conn, $sqlSelect);
                             if(mysqli_num_rows($result) > 0){ 
                             while($row = mysqli_fetch_array($result)) {
                              ?>
                            <option><?php echo $row['size'] ?></option>
                            <?php
                             }
                             }
                             ?>
                          </select>
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                      <label for="sel1">Date</label>
                      <input type="date" class="form-control" id="date" />
                  </div>
                </div>

                        </div>
                        <div class="row  position-center" style="width: 100%">

                            
                <div class="col-sm-3">
                  <div class="form-group">
                     <label for="sel1">PRODUCT NAME</label>
                             <select disabled class="form-control" id="productNameSelect"  onchange="machine(this.value);"> 
                             <option value="">-- SELECT PRODUCT_NAME --</option>
                             <?php
                             $sqlSelect = "SELECT PRODUCT_ID, PRODUCT_NAME FROM `category` where JOB_WORKERS = 0 ORDER BY 1";
                             $result = mysqli_query($conn, $sqlSelect);
                             if(mysqli_num_rows($result) > 0){ 
                             while($row = mysqli_fetch_array($result)) {
                              ?>
                            <option value="<?php echo $row['PRODUCT_ID']?>" ><?php echo $row['PRODUCT_NAME'] ?></option>
                            <?php
                             }
                             }
                             ?>
                          </select>
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                     <label for="sel1">JOB WORKERS</label>
                             <select disabled class="form-control" id="productNameSelectJob"  onchange="machine(this.value);"> 
                             <option value="">-- SELECT PRODUCT_NAME --</option>
                             <?php
                             $sqlSelect = "SELECT PRODUCT_ID, PRODUCT_NAME FROM `category` where JOB_WORKERS = 1 ORDER BY 1";
                             $result = mysqli_query($conn, $sqlSelect);
                             if(mysqli_num_rows($result) > 0){ 
                             while($row = mysqli_fetch_array($result)) {
                              ?>
                            <option value="<?php echo $row['PRODUCT_ID']?>" ><?php echo $row['PRODUCT_NAME'] ?></option>
                            <?php
                             }
                             }
                             ?>
                          </select>
                  </div>
                </div>
              


                          <div class="col-sm-3">
                            <div class="form-group">
                               <label for="sel1">AVAILABEL STOCK</label>
                                <select class="form-control" id="machineStockSelect"  onchange="calcFirstMachineInput(this)">
                                <option value="none">select value</option>
                                </select> 
                            </div>
                          </div>

                         
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label style="margin-top: 1.5em;" for="sel1">Available Weight: <span id="available-weight"> </span></label>
                              <label for="sel1">Product Weight: <span id="product-weight"> </span></label>
                              <A HREF="production_Flow.php"><button style="float: right;" id="reload" type="button" class="btn btn-danger">Reload</button></A>
                            </div>
                          </div>

                         

                        </div>
                        <div class="row top-25 row-border position-center" style="width:100%;">
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label>MACHINE</label>
                            </div>
                          </div>

                          <div class="col-sm-5">

                             <div class="col-sm-3 ">
                                <div class="form-group">
                                  <label>U.P</label>
                                </div>
                              </div>

                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>T.I</label>
                                </div>
                              </div>

                              <div class="col-sm-3">
                                <div class="form-group">
                                  <label>TOT</label>
                                </div>
                              </div>

                             <div class="col-sm-2">
                                <div class="form-group">
                                  <label>O/P</label>
                                </div>
                              </div>


                          </div>
                         

                     
                          <div class="col-sm-5">
                            <div class="row">
                              <div class="col-sm-7">
                               <div class="row">

                                  <div class="col-sm-4">
                                    <label>PRO</label>
                                  </div>

                                  <div class="col-sm-4">
                                    <label>O.S</label>
                                  </div>

                                  <div class="col-sm-4">
                                    <label>T.P</label>
                                  </div>
                               </div>
                              </div>

                              <div class="col-sm-5">
                              <div class="row">

                                  <div class="col-sm-6">
                                    <label>T.S</label>
                                  </div>

                                  <div class="col-sm-6">
                                    <label>U.P</label>
                                  </div>

                               </div>
                              </div>

                            </div>
                          </div>

                        </div>

                        <div id="machines-input">

                        </div>
                        <br><br>
                        <hr>
                        <div id="old_stock">
                          <div class="col-sm-3 m-10">
                            <h4 id="productNameIdView"></h4>
                          </div>

                          <div class="col-sm-3 m-10">
                              <h4 id="productStockIdView"></h4>
                          </div>

                          <div class="col-sm-3 m-10">
                            <h4 id="productNameIdViewWeight"></h4>
                          </div>

                          <div class="col-sm-3 m-10">
                              <h4 id="productStockIdViewWeight"></h4>
                          </div>
                            
                          <div class="col-sm-3 m-20">
                              <h4 id="productNameId"></h4>
                          </div>

                          <div class="col-sm-3 m-20">
                              <h4 id="productStockId"></h4>
                          </div>

                          <div class="col-sm-3 m-20">
                              <h4 id="productNameIdWeight"></h4>
                          </div>

                          <div class="col-sm-3 m-20">
                              <h4 id="productStockIdWeight"></h4>
                          </div>
                             
                        </div>

                        <br><br>
                        <hr>
                          

                        <div class="col-sm-3">
                             <h3 id="productTotalLabel"></h3>
                        </div>

                        <div class="col-sm-3">
                            <h3 id="productTotalValue"></h3>
                        </div>
                        
                        <div class="col-sm-3">
                             <h3 id="productTotalLabelWeight"></h3>
                        </div>

                        <div class="col-sm-3">
                            <h3 id="productTotalValueWeight"></h3>
                        </div>

                        <br><br>
                        <br><br>
                        <input type="text" id="productWeight" style="display: none;" />
                         <!-- Button trigger modal -->
                        <button type="button" id="machine-time" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                          <i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp;Machine Time
                        </button>
                         <button type="submit" id="submit-button" class="btn btn-info pull-right" disabled onclick="saveData()" name="submit" style="margin-left: 45%;">Submit</button>
                        </div>

                        <br><br>
                        <br><br>
                        <br><br>

                    </div>
                </section>
            </div>
        </div>                      
    </div>
   
<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 80%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button> -->
        <h4 class="modal-title" id="exampleModalLabel">Modal title</h4>
        
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="emptyModalInputs()">Reload</button>
        <button type="button" class="btn btn-secondary" onclick="closeModel()" id="modal-close-btn" >Close</button>
        <button type="button" class="btn btn-primary" id="submit--btn-time" onclick="saveTime();">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  var emptyModalInputs = function() {
    if(enteredMachineIds && enteredMachineIds.length > 0) {
      for(let i=0; i<enteredMachineIds.length; i++) {
        $("#machine-time-"+enteredMachineIds[i]).val('');
        $("#machine-time-"+enteredMachineIds[i]).attr("disabled", false);
      }
    }
  };

  var dataTimeNoChanged = function(machineId) {

	$("#modal-close-btn").attr("disabled", true);
    let val = $("#machine-time-"+machineId).val();
    if(val == 0 && zeroOutputArray.indexOf(machineId) > -1) {
      $("#machine-time-"+machineId).val("00");
    } else if(val == 0) {
      alert("Minutes may not be zero!");
      $("#machine-time-"+machineId).val("");
      return false;
    }
    $("#machine-time-"+machineId).attr("disabled", true);
  };

 // $('#exampleModal').on('hidden.bs.modal', function (e) {
   var closeModel = function() {  
     let machineIdArray = machineArray.id;
    // debugger;
       for(let i=0; i<machineIdArray.length; i++) {
         let machineNoInput = $("#machine-nos-"+machineIdArray[i]).val();
         if(machineNoInput != undefined && machineNoInput != null && machineNoInput != "" && parseInt(machineNoInput) > 0) {
           let machineMin = $("#machine-time-"+machineIdArray[i]).val();
           if(machineMin == undefined || machineMin == null || machineMin == "" || machineMin == "0") {
             alert("Enter value for '" + machineArray.name[i] + "' before closing");
             return false;
           }
         }
      }
      $(".modal-body").html('');
      $("#reload").attr('disabled', true);
      $("#machine-time").attr('disabled', true);
      $("#submit-button").attr('disabled', false);
      $(".modal-body").html('');
      $('#exampleModal').modal('hide');
  //});
   };

  var saveTime = function() {
    let confirmSave = confirm("Sure to save!");
    if(!confirmSave) {
      return false;
    }
    
    for(let i=0; i<enteredMachineIds.length; i++) {
      let machineVal = $("#machine-time-"+enteredMachineIds[i]).val();
      if(machineVal == undefined || machineVal == null || machineVal == "" || machineVal == "0") {
        alert("Please enter value in all the enabled minutes input before saving!");
        return false;
      }
    }

    $("#submit--btn-time").attr("disabled", true); // Disable the submit btn while saving
    let lastUpdatedDate = $("#date").val();
    if(lastUpdatedDate == undefined || lastUpdatedDate == null || lastUpdatedDate == "") {
      lastUpdatedDate = new Date().toJSON().slice(0,10).replace(/-/g,'-');
    }
    let size = $('#sizeMachine').val();
    let macineNameArr = [];
    let minutesArr = [];
    let numbersArr = [];
    let countArr = [];
    let lenghtArr = [];
    let machineIdArray = machineArray.id;
    for(let i=0; i<machineIdArray.length; i++) {
      let machineName = $("#machine-name-"+machineIdArray[i]).text();
      let minutes = $("#machine-time-"+machineIdArray[i]).val();
      let numbers = $("#machine-nos-"+machineIdArray[i]).val();
      let count = $("#machine-cnt-"+machineIdArray[i]).text();
      let length = $("#machine-length-"+machineIdArray[i]).text();
      macineNameArr.push(!machineName ? "" : machineName);
      minutesArr.push(!minutes ? 0 : minutes);
      numbersArr.push(!numbers ? 0 : numbers);
      countArr.push(!count ? 0 : count);
      lenghtArr.push(!length ? 0 : length);
    }
    let type = $("#type option:selected").text();
    let thickness = $("#thickness option:selected").text();
    let categoryId;
    if($("#sizeMachine").val().startsWith('J-')) {
      categoryId =  document.getElementById("productNameSelectJob").value;
    } else {
      categoryId = document.getElementById("productNameSelect").value;
    }

      if(machineIdArray.length != 0){
            $.ajax({
              type: 'post',
              url: 'saveProductionFlow.php',
              data: {
                forTime: 'forTime',
                lastUpdatedDate: lastUpdatedDate,
                categoryId1: categoryId,
                type: type,
                thickness: thickness,
                size: size,
                isFlowCompleted: isFlowCompleted,
                arrayLength: machineIdArray.length,
                machineIdArray: machineIdArray.toString(),
                macineNameArray: macineNameArr.toString(),
                minutesArray: minutesArr.toString(),
                numbersArray: numbersArr.toString(),
                countArray: countArr.toString(),
                lengthArray: lenghtArr.toString()
              },
              success: function (response) {  
               alert('Data Are Inserted Successfully');
				$('#exampleModal').modal('hide');			   
            //   $("button[data-dismiss='modal']").click();   
              }
            });
			$("#reload").attr('disabled', true);
			$("#machine-time").attr("disabled", true);
			$("#submit-button").attr('disabled', false);
      }

    

  };

  function saveData() {
    let confirmSave = confirm("Do you need to save the record!");
    if (confirmSave) {
        $("#submit-button").attr("disabled", true); // Disable the submit btn while saving
        let machineIdArray = machineArray.id;
        debugger;
        for (let i = 0; i < machineIdArray.length; i++) {
            let input = $("#input-" + machineIdArray[i]).val();
            let output = $("#output-" + machineIdArray[i]).val();
            if (input != "") {
                if (output == undefined || output == null || output == "") {
                    $("#input-" + machineIdArray[i]).val('0');
                    dataInputChange($("#input-" + machineIdArray[i]));
                }
            }
        }

        //      let categoryId = document.getElementById("productNameSelect").value; //PRODUCT ID
        let categoryId;
        if ($("#sizeMachine").val().startsWith('J-')) {
            //if($("#productNameSelect").attr("disabled") == "disabled") {
            categoryId = document.getElementById("productNameSelectJob").value;
        } else {
            categoryId = document.getElementById("productNameSelect").value;
        }

        let unProcessedArray = [];
        let stockArray = [];
        let upInputArray = [];
        let givenInputArray = [];
        let totalInputArray = [];
        let givenOutputArray = [];
        let processedArray = [];
        let totalProccesedArray = [];
        let oldStockArray = [];
        let type = $("#type option:selected").text();
        let size = $("#sizeMachine option:selected").text();
        let thickness = $("#thickness option:selected").text();

        for (let i = 0; i < machineIdArray.length; i++) {
            let unProcessed = isNaN(parseInt($("#unProcessed-" + machineIdArray[i]).text())) ? 0 : $("#unProcessed-" + machineIdArray[i]).text();
            let stock = isNaN(parseInt($("#todayStock-" + machineIdArray[i]).text())) ? 0 : $("#todayStock-" + machineIdArray[i]).text();

            // for new 
            let upInput = isNaN(parseInt($("#label-unProcessedInput-" + machineIdArray[i]).text())) ? 0 : $("#label-unProcessedInput-" + machineIdArray[i]).text();
            let givenInput = isNaN(parseInt($("#input-" + machineIdArray[i]).val())) ? 0 : $("#input-" + machineIdArray[i]).val();
            let totalInput = isNaN(parseInt($("#label-currentTotal-" + machineIdArray[i]).text())) ? 0 : $("#label-currentTotal-" + machineIdArray[i]).text();
            let givenOutput = isNaN(parseInt($("#output-" + machineIdArray[i]).val())) ? 0 : $("#output-" + machineIdArray[i]).val();
            let processed = isNaN(parseInt($("#label-processed-" + machineIdArray[i]).text())) ? 0 : $("#label-processed-" + machineIdArray[i]).text();
            let totalProccesed = isNaN(parseInt($("#label-totalProcessed-" + machineIdArray[i]).text())) ? 0 : $("#label-totalProcessed-" + machineIdArray[i]).text();
            let oldStock = isNaN(parseInt($("#label-oldStock-" + machineIdArray[i]).text())) ? 0 : $("#label-oldStock-" + machineIdArray[i]).text();

            unProcessedArray[i] = unProcessed;
            stockArray[i] = stock;
            // for new
            upInputArray[i] = upInput;
            givenInputArray[i] = givenInput;
            totalInputArray[i] = totalInput;
            givenOutputArray[i] = givenOutput;
            processedArray[i] = processed;
            totalProccesedArray[i] = totalProccesed;
            oldStockArray[i] = oldStock;


        }

        let lastUpdatedDate = $("#date").val();
        if (lastUpdatedDate == undefined || lastUpdatedDate == null || lastUpdatedDate == "") {
            lastUpdatedDate = new Date().toJSON().slice(0, 10).replace(/-/g, '-');
        }
        let productStock = isNaN(parseInt($("#label-totalProcessed-" + machineIdArray[machineIdArray.length - 1]).text())) ? 0 : parseInt($("#label-totalProcessed-" + machineIdArray[machineIdArray.length - 1]).text());
        let productStockWeight = isNaN(parseInt($("#productStockIdWeight").text())) ? 0 : parseInt($("#productStockIdWeight").text());
        let oldCatName = $('#machineStockSelect').val() == "none" ? "NILL" : $('#machineStockSelect').val();
        let updateTabelName = machineArray["updateTabelName"][oldCatName] == undefined ? "NILL" : machineArray["updateTabelName"][oldCatName];
        if (machineIdArray.length != 0) {
            $.ajax({
                type: 'post',
                url: 'saveProductionFlow.php',
                data: {
                    categoryId: categoryId,
                    type: type,
                    size: size,
                    thickness: thickness,
                    arrayLength: machineIdArray.length,
                    machineIdArray: machineIdArray.toString(),
                    unProcessedArray: unProcessedArray.toString(),
                    stockArray: stockArray.toString(),
                    productStock: productStock,
                    productStockWeight: productStockWeight,
                    upInputArray: upInputArray.toString(),
                    givenInputArray: givenInputArray.toString(),
                    totalInputArray: totalInputArray.toString(),
                    givenOutputArray: givenOutputArray.toString(),
                    processedArray: processedArray.toString(),
                    totalProccesedArray: totalProccesedArray.toString(),
                    oldStockArray: oldStockArray.toString(),
                    isFlowCompleted: isFlowCompleted,
                    oldCatName: oldCatName,
                    updateTabelName: updateTabelName,
                    lastUpdatedDate: lastUpdatedDate,
                    remainingWeight: remainingWeight,
                    oldStock: $("#productStockIdView").text(),
                    producedStock: $("#productStockId").text(),
                    totalStock: $("#productTotalValue").text(),
                    oldWeight: $("#productStockIdViewWeight").text(),
                    producedWeight: $("#productStockIdWeight").text(),
                    totalWeight: $("#productTotalValueWeight").text()
                },
                success: function (response) {
                    console.log(response);
                    alert('Data Are Inserted Successfully');
                    debugger;
                    window.location.href = 'production_Flow.php';
                }
            });
        }
    } else {
        return false;
    }
} //EOSave    

var createInputBox = function(machineArray,machineId, oldStockArr, unProcessedStock, machineArrayHole) {
  let machineTypeArr = machineArrayHole['machineType'];
  for(i=0; i<machineArray.length; i++) {

    let unProcessedInput = i==0 ? 0 : unProcessedStock[i];
    let oldStock = oldStockArr[i];

    let beforeMachineId = "";
    let afterMachineId = "";

    if(i != 0) {
      beforeMachineId = machineId[i-1];
    } else {
      beforeMachineId = 0;
    }
    if(i != (machineArray.length-1)) {
      afterMachineId = machineId[i+1];
    } else {
      afterMachineId = 0;
    }

     let htmlDesign = '' +
     '<div class="row top-25" style="width: 100%;"> ' +
      '<div class="col-sm-2"> ' +
        '<div class="form-group">'+
          '<label class="'+machineTypeArr[i]+'">'+machineArray[i]+'</label>'+
        '</div>'+
       '</div>'+
       '<div class="col-sm-5">'+
        '<div class="row">'+
          '<div class="col-sm-2" style="background:#B2F9DB;text-align: center;">'+
            '<div class="form-group"  >'+
              '<label class="cs-label" id="label-unProcessedInput-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+unProcessedInput+'</label>'+
             '</div>'+
          '</div> '+
          '<div class="col-sm-4">'+
            '<div class="form-group">'+
              '<input type="number" class="form-control machineclass" id="input-'+machineId[i]+'" onchange="dataInputChange(this)"  data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+' >'+
            '</div>'+
          '</div>'+
          '<div class="col-sm-2" style="background:#B2F9DB;text-align: center;">'+
            '<div class="form-group">'+
              '<label class="mt-5" id="label-currentTotal-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'></label>'+
            '</div>'+
          '</div>'+
          '<div class="col-sm-4">'+
          '<div class="form-group">'+
            '<input type="number" class="form-control machineclass" placeholder="DESCRIPTION" id="output-'+machineId[i]+'" onchange="dataOutputChange(this)" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+
          '</div>'+
        '</div>'+
         '</div>'+
        '</div>'+
        '<div class="col-sm-5">'+
          '<div class="row">'+
            '<div class="col-sm-7">'+
               '<div class="row">'+
            '<div class="col-sm-4" style="background:#F9CDCB;height:43px;text-align: center;">'+
              '<label class="mt-5" id="label-processed-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'></label>'+
            '</div>'+
            '<div class="col-sm-4" style="background:#BDF0A5;height:43px;text-align: center;">'+
              '<label class="mt-5" id="label-oldStock-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+oldStock+'</label>'+
            '</div>'+
            '<div class="col-sm-4" style="background:#ECC8F3;height:43px;text-align: center;">'+
              '<label class="mt-5" id="label-totalProcessed-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'></label>'+
            '</div>'+
          '</div>'+
        '</div>'+
         '<div class="col-sm-5">'+
         '<div class="row">'+
            '<div class="col-sm-6" style="background:#D3B6FA;height:43px;text-align: center;">'+
              '<label class="mt-5" id="todayStock-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'></label>'+
            '</div>'+
            '<div class="col-sm-6" style="background:#ABEDF6;height:43px;text-align: center;">'+
              '<label class="mt-5" id="unProcessed-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'></label>'+
            '</div>'+
            '</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
        '</div>'+
      '</div>';
      $("#machines-input").append(htmlDesign);
      
      if(i == (machineArray.length-1)) {
        $("#label-unProcessedInput-"+machineId[i]).text(unProcessedStock[i]);
        $("#label-oldStock-"+machineId[i]).text('0');
        $("#todayStock-"+machineId[i] ).text('0');
      }
     // let parentDiv = document.getElementById('machines-input');
     // parentDiv.append(rowDiv);
  }
  
};


var createInputBoxUnProcessed = function(nameArr, machineId, unProcessedArr, givenInputArr, totalInputArr, givenOutputArr, processedArr, oldStockArr, totalProccesedArr, stockArr, unProcessedOutputArr, machineArray) {
  debugger;
  let machineType = machineArray['machineType'];
  for(i=0; i<nameArr.length; i++) {
    let beforeMachineId = "";
    let afterMachineId = "";

    if(i != 0) {
      beforeMachineId = machineId[i-1];
    } else {
      beforeMachineId = 0;
    }
    if(i != (nameArr.length-1)) {
      afterMachineId = machineId[i+1];
    } else {
      afterMachineId = 0;
    }

    let unProcessInput = unProcessedArr[i] == undefined ? "" : unProcessedArr[i];
    let givenInput = givenInputArr[i] == undefined ? "" : givenInputArr[i];
    let givenInputDisable = parseInt(givenInput) > 0 ? "disabled" : "";
    let totalInput = totalInputArr[i]  == undefined ? "" : totalInputArr[i];
    let givenOutput = givenOutputArr[i]  == undefined ? "" : givenOutputArr[i];
    let givenOutputDisable = parseInt(givenOutput) > 0 ? "disabled" : "";
    let processed = processedArr[i] == undefined ? "" : processedArr[i];
    let oldStock = oldStockArr[i] == undefined ? "" : oldStockArr[i];
    let stock = stockArr[i] == undefined ? "" : stockArr[i];
    let unProcessedOutput = unProcessedOutputArr[i] == undefined ? "" : unProcessedOutputArr[i];
    let totalProccesed = totalProccesedArr[i] == undefined ? "" : totalProccesedArr[i];
    
    let htmlDesign = '' +
   '<div class="row top-25" style="width: 100%;"> ' +
      '<div class="col-sm-2"> ' +
        '<div class="form-group">'+
          '<label class="'+machineType[i]+'">'+nameArr[i]+'</label>'+
        '</div>'+
       '</div>'+

       '<div class="col-sm-5">'+
        '<div class="row">'+
          '<div class="col-sm-2" style="background:#B2F9DB">'+
            '<div class="form-group">'+
              '<label class="cs-label" id="label-unProcessedInput-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+unProcessInput+'</label>'+
             '</div>'+
          '</div> '+
          '<div class="col-sm-4">'+
            '<div class="form-group">'+
              '<input type="number" '+givenInputDisable+' class="form-control machineclass" id="input-'+machineId[i]+'" onchange="dataInputChange(this)"  data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+' value="'+givenInput+'">'+
            '</div>'+
          '</div>'+
          '<div class="col-sm-2" style="background:#B2F9DB">'+
            '<div class="form-group">'+
              '<label class="mt-5" id="label-currentTotal-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+totalInput+'</label>'+
            '</div>'+
          '</div>'+
          '<div class="col-sm-4">'+
            '<div class="form-group">'+
              '<input type="number" '+givenOutputDisable+' class="form-control machineclass" placeholder="DESCRIPTION" id="output-'+machineId[i]+'" onchange="dataOutputChange(this)" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+' value="'+givenOutput+'">'+
            '</div>'+
          '</div>'+
         '</div>'+
        '</div>'+
      '<div class="col-sm-5">'+
          '<div class="row">'+
            '<div class="col-sm-7">'+
               '<div class="row">'+
            '<div class="col-sm-4" style="background:#F9CDCB;height:43px;text-align: center;">'+
              '<label class="mt-5" id="label-processed-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+processed+'</label>'+
            '</div>'+
            '<div class="col-sm-4" style="background:#BDF0A5;height:43px;text-align: center;">'+
              '<label class="mt-5" id="label-oldStock-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+oldStock+'</label>'+
            '</div>'+
            '<div class="col-sm-4" style="background:#ECC8F3;height:43px;text-align: center;">'+
              '<label class="mt-5" id="label-totalProcessed-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+totalProccesed+'</label>'+
            '</div>'+
          '</div>'+
        '</div>'+
         '<div class="col-sm-5">'+
         '<div class="row">'+
            '<div class="col-sm-6" style="background:#D3B6FA;height:43px;text-align: center;">'+
              '<label class="mt-5" id="todayStock-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+stock+'</label>'+
            '</div>'+
            '<div class="col-sm-6" style="background:#ABEDF6;height:43px;text-align: center;">'+
              '<label class="mt-5" id="unProcessed-'+machineId[i]+'" data-beforeMachineId='+beforeMachineId+' data-afterMachineId='+afterMachineId+'>'+unProcessedOutput+'</label>'+
            '</div>'+
            '</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
        '</div>'+
      '</div>';
      $("#machines-input").append(htmlDesign);
      
      /*
      if(i == (machineArray.length-1)) {
        $("#label-unProcessedInput-"+machineId[i]).text(unProcessedInput[i]);
        $("#label-oldStock-"+machineId[i]).text('0');
        $("#todayStock-"+machineId[i] ).text('0');
      }
      */

  }
};

function machine(val) {
    let type = $("#type option:selected").text();
    let size = $("#sizeMachine option:selected").text();
    let thickness = $("#thickness option:selected").text();
    $("#sizeMachine").attr("disabled", true);
    $("#productNameSelect").attr("disabled", true);
    $("#productNameSelectJob").attr("disabled", true);
    if(userType != "productionManager") {
      $("#date").attr("disabled", false);
    }
    $.ajax({
       type: 'post',
       url: 'machine.php',
       data: {
       categoryId: val,
       type: type,
       size: size,
       thickness: thickness
       },
       success: function (response) {
          console.log(response);
          
          document.getElementById('machines-input').innerHTML = '';
          machineArray = JSON.parse(response);
          productWeight = machineArray['productWeight'];
          availableWeight = machineArray['availableWeight'];
          remainingWeight = availableWeight;
          $("#available-weight").text(availableWeight);
          $("#product-weight").text(productWeight);
          if(productWeight == "0") {
            alert("Weight is not configured for the choosen product. \nPlease configure it and try again!");
            location.reload();
            return false;
          }
          
          //for create machine stock old view
          createAlreadyMachineStock(machineArray['firstMachineId'],machineArray['firstproductId'],machineArray['firstMachinestockUP'],machineArray['firstproductName'],machineArray['firstMachineNameAndUnprocessed'],machineArray['firstMachineNameAndStock']);

          if(machineArray["isFlowCompleted"] == "YES" || machineArray["isFlowCompleted"] == "0") {
            createInputBox(machineArray['name'],machineArray['id'], machineArray['stock'], machineArray['unProcessed'], machineArray);  
          } else {
            createInputBoxUnProcessed(machineArray['name'], machineArray['id'], machineArray["unProcessed"], machineArray["givenInput"], machineArray["totalInput"], machineArray["givenOutput"], machineArray["processed"], machineArray["oldStock"], machineArray["totalProccesed"], machineArray["stock"], machineArray["unProcessedOutput"], machineArray);
          }
        let productName;
        if($("#sizeMachine").val().startsWith('J-')) {
        //if($("#productNameSelect").attr("disabled") == "disabled") {
         productName =  $("#productNameSelectJob option:selected").text();
        } else {
          productName = $("#productNameSelect option:selected").text();
        }
        let STOCK_VALUE = machineArray['stockValue'] ? machineArray['stockValue'] : 0 ;
        let STOCK_VALUE_WEIGHT = machineArray['stockValueWeight'] ? machineArray['stockValueWeight'] : 0 ;
        $("#productNameIdView").text("Old Stock ");
        $("#productNameIdViewWeight").text("Present Weight Stock ");
        $("#productStockIdView").text(STOCK_VALUE);
        $("#productStockIdViewWeight").text(STOCK_VALUE_WEIGHT);
        $("#productWeight").val(machineArray['productWeight']);
       }
    });
}
</script>
<script type="text/javascript">
  
  var createAlreadyMachineStock = function(firstMachineId,firstproductId,firstMachinestockUP,firstproductName,firstMachineNameAndUnprocessed,firstMachineNameAndStock) {

  $('#machineStockSelect')
      .empty()
      .append('<option selected="selected">Select Value</option>');

    if(firstMachineId.length == 0) {
      $("#machineStockSelect").attr("disabled", true);
    } else {
      $("#machineStockSelect").attr("disabled", false);
    }

  for(i=0; i<firstMachineId.length; i++) {
      firstMachineId[i];
      firstproductId[i];
      firstproductName[i];
      firstMachinestockUP[i];
      firstMachineNameAndUnprocessedKey= Object.keys(firstMachineNameAndUnprocessed);
      let htmlDesign = '' +
      '<option>'+firstMachineNameAndUnprocessedKey[i]+'</option>';
      $("#machineStockSelect").append(htmlDesign);
  }

setTimeout(function(){
  let length = $('#machineStockSelect').children('option').length;
  if(length > 1) {
    let firstMachineId = machineArray["id"][0];
    $("#input-"+firstMachineId).attr("disabled", true);
    $("#output-"+firstMachineId).attr("disabled", true);
  }
}, 1000);
  
};

var calcFirstMachineInput = function(selectBox){
  $(selectBox).attr("disabled", true);
  let selectedValue = selectBox.value;
  let machineStock = machineArray.firstMachineNameAndStock[selectedValue];
  let unProcessed = machineArray.firstMachineNameAndUnprocessed[selectedValue];
  let l = $("label[data-beforemachineid="+0+"]")[0];
  $(l).text(unProcessed);
  l = $("label[data-beforemachineid="+0+"]")[3];
  $(l).text(machineStock);
  l = $("input[data-beforemachineid="+0+"]")[0];
  $(l).val('0');
  $(l).attr("readonly", "true");
  l = $("label[data-beforemachineid="+0+"]")[1];
  $(l).text(unProcessed);
  l = $("input[data-beforemachineid="+0+"]")[1];
  // $(l).val('0');
  // $(l).attr("disabled", "false");
  $(l).removeAttr("disabled");
  // dataOutputChange($("input[data-beforemachineid="+0+"]")[1]);
}

var dataInitialInputChange = function(demo){
  let givenStockValue = demo.value;
  let selectStockValue = $("#remaining-stock").val();
  if(selectStockValue >= givenStockValue){
    // $("#remaining-stock").val(selectStockValue - givenStockValue);
    alert("error");
  }   
}

var saveFirstMachineData = function(){
let productId;
let machineId;
let machineStockUP;
productId = $("#machineStockSelect").find(':selected').attr('data-productId');
machineId = $("#machineStockSelect").find(':selected').attr('data-machineId');
machineStockUP = 10;

   $.ajax({
       type: 'post',
       url: 'saveProductionFlow.php',
       data: {
       productId:productId,
       machineId:machineId,
       machineStockUP:machineStockUP
       },
       success: function (response) {
          console.log(response);
        
       }
    });
} 

$('#exampleModal').on("show.bs.modal", function (e) {
  $(".modal-body").html('');
  $("#exampleModalLabel").text("Size: " + $('#sizeMachine').val());
  let html = '<div class="row">' +
          '<div class="col-sm-2">Machine Name</div>' +
          '<div class="col-sm-3">Minutes</div>' +
          '<div class="col-sm-3">Numbers</div>' +
          '<div class="col-sm-2">Count</div>' +
          '<div class="col-sm-2">Length</div>' +
          '</div>';
  $(".modal-body").append(html);

  let size = $('#sizeMachine').val();
  let machineIdLength = machineArray["id"].length;
  let machineIdArr = machineArray["id"];
  let machineNameArr = machineArray["name"];
  let machineTypeArr = machineArray['machineType'];
  let machineMinutes = machineArray["machineMinutes"];
  let machineNumbers = machineArray["machineNumbers"];
  let machineTimeCount = machineArray["machineTimeCount"];
  let machineTimeLength = machineArray["machineTimeLength"];

  for (let i=0; i<machineIdLength; i++) {
    let numberValue = machineMinutes[i];
    let givenDisabled = "";
    let givenMachineDisabled = "disabled";
    try {
      if(parseInt(numberValue) > 0) {
        givenDisabled = "disabled";
      }
    } catch (err) { }
    if(enteredMachineIds.indexOf(machineIdArr[i]) > -1) {
      givenMachineDisabled = "";
    }
    let minutesValue = machineMinutes[i];
    let minutesDisabled = "disabled";
    try {
      if(parseInt(numberValue) > 0) {
        minutesDisabled = "";
      }
    } catch (err) { }
    // let machineCount = !machineTimeCount[i] ? "" : machineTimeCount[i];
    let machineCount = $("#output-"+machineIdArr[i]).val();
    machineCount = !machineCount ? "" : machineCount;
    let machineLength = $("#output-"+machineIdArr[i]).val();
    // let machineLength = !machineTimeLength[i] ? "" : machineTimeLength[i];
    machineLength = !machineLength ? "" : machineLength * size;

    html = '<div class="row" style="margin-top: 2em;"><div class="col-sm-2">' +
      '<div class="form-group">' +
        '<label class="'+machineTypeArr[i]+'" for="usr">'+machineNameArr[i]+'</label>' +
        ' &nbsp;' +
      '</div> </div>' +
      '<div class="col-sm-3">' +
    '<div class="form-group">' +
      '<input type="number" '+givenMachineDisabled+' value="'+numberValue+'" '+givenDisabled+' class="form-control" onchange="dataTimeNoChanged(\''+machineIdArr[i]+'\');" id="machine-time-'+machineIdArr[i]+'" data-machineId="'+machineIdArr[i]+'">' +
    '</div></div>' +
    '<div class="col-sm-3">' +
    '<div class="form-group">' +
      '<input type="number" disabled value="'+machineCount+'" class="form-control" id="machine-nos-'+machineIdArr[i]+'" data-machineId="'+machineIdArr[i]+'">' +
    '</div></div>' +
    '<div class="col-sm-2">' +
    '<div class="form-group">' +
      '<label for="pwd" id="machine-cnt-'+machineIdArr[i]+'">'+machineCount+'</label>' +
      '</div></div>' +
      '<div class="col-sm-2">' +
    '<div class="form-group">' +
      '<label for="usr"  id="machine-length-'+machineIdArr[i]+'">'+machineLength+'</label>' +
    '</div></div>' +
    '</div>';
    $(".modal-body").append(html);
    
  }
    
});


$(document).ready(function() {
  userType = <?php echo "'".$_SESSION['admin']. "'"; ?>;
  if(userType == "productionManager") {
    $("#date").attr("disabled", true);
  }

});

</script>
         
</section>

<!--main content end-->
</section>

</body>
</html>
