<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<head>
<title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
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
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
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

</style>

<script>
  var reportSelectBoxChange = function(selectBox) {
    let val = $(selectBox).val();
    if(val == "daily") {
      $("#daily-report").show();
      $("#size-wise-div").hide();
      $("#machine-name-div").hide();
      $("#product-name-div").hide();
      $("#all-product-div").hide();
      $("#machine-wise-with-type-div").hide();
      $("#performance-div").hide();
      $("#stock-div").hide();
    } else if (val == "product-wise") {
      $("#product-name-div").show();
      $("#size-wise-div").hide();
      $("#machine-name-div").hide();
      $("#daily-report").hide();
      $("#all-product-div").hide();
      $("#machine-wise-with-type-div").hide();
      $("#performance-div").hide();
      $("#stock-div").hide();
    } else if(val == "size-wise") {
      $("#size-wise-div").show();
      $("#machine-name-div").hide();
      $("#product-name-div").hide();
      $("#daily-report").hide();
      $("#all-product-div").hide();
      $("#machine-wise-with-type-div").hide();
      $("#performance-div").hide();
      $("#stock-div").hide();
    } else if(val == "machine-wise") {
      $("#machine-name-div").show();
      $("#product-name-div").hide();
      $("#size-wise-div").hide();
      $("#daily-report").hide();
      $("#all-product-div").hide();
      $("#machine-wise-with-type-div").hide();
      $("#performance-div").hide();
      $("#stock-div").hide();
    } else if(val == "all-product") {
      $("#all-product-div").show();
      $("#size-wise-div").hide();
      $("#machine-name-div").hide();
      $("#product-name-div").hide();
      $("#daily-report").hide();
      $("#machine-wise-with-type-div").hide();
      $("#performance-div").hide();
      $("#stock-div").hide();
    } else if(val == "machine-wise-with-type") {
      $("#machine-wise-with-type-div").show();
      $("#all-product-div").hide();
      $("#size-wise-div").hide();
      $("#machine-name-div").hide();
      $("#product-name-div").hide();
      $("#daily-report").hide();
      $("#performance-div").hide();
      $("#stock-div").hide();
    } else if(val == "performance") {
      $("#performance-div").show();
      $("#machine-wise-with-type-div").hide();
      $("#all-product-div").hide();
      $("#size-wise-div").hide();
      $("#machine-name-div").hide();
      $("#product-name-div").hide();
      $("#daily-report").hide();
      $("#stock-div").hide();
    } else if(val == "stock") {
      $("#stock-div").show();
      $("#performance-div").hide();
      $("#machine-wise-with-type-div").hide();
      $("#all-product-div").hide();
      $("#size-wise-div").hide();
      $("#machine-name-div").hide();
      $("#product-name-div").hide();
      $("#daily-report").hide();
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
                      Report
                    </header>

                    <div class="panel-body">
                       <div>
           

<div class="row position-center" style="width: 100%;">
  <div class="col-sm-12">
    <div class="form-group">
      <label for="sel1">Select Report Type:</label>
      <select class="form-control" id="reports" onchange="reportSelectBoxChange(this)">
        <option value="">-- SELECT REPORT TYPE --</option>
        <option value="daily">Daily</option>
        <option value="all-product">All Product</option>
        <option value="product-wise">Product Wise</option>
        <option value="size-wise">Size Wise</option>
        <option value="machine-wise">Performance Count</option>
        <option value="machine-wise-with-type">Machine Wise</option>
        <option value="performance">Performance Length</option>
        <option value="stock">Product Stock</option>
      </select>
    </div>
  </div>
</div>

<div class="row" style="width: 100%; display: none;">
  <div class="col-sm-3">
    <label class="container">All Products
      <input type="radio" checked="checked" value="all-products" name="radio" onclick="sizeWise(this);">
      <span class="checkmark"></span>
    </label>
  </div>
  <div class="col-sm-3">
    <label class="container">Product Wise
      <input type="radio" checked="checked" value="product-wise" name="radio" onclick="showProductDropDown(this);">
      <span class="checkmark"></span>
    </label>
  </div>

  <div class="col-sm-3">
    <label class="container">Size Wise
      <input type="radio" checked="checked" value="size-wise" name="radio" onclick="sizeWise(this);">
      <span class="checkmark"></span>
    </label>
  </div>

 <div class="col-sm-3">
    <label class="container">Machine Wise
      <input type="radio" checked="checked" value="machine-wise" name="radio" onclick="showMachineDropDown(this);">
      <span class="checkmark"></span>
    </label>
  </div>

</div>



        <div class="row position-center"  style="width: 100%;">
            <div class="col-sm-12" id="product-name-div" style="display: none;">
                 <div class="row">
                   <div class="col-sm-4">
                      <div class="form-group">
                        <label for="sel1">PRODUCT NAME</label>
                          <select class="form-control" id="productNameSelect" > 
                          <option value="">-- SELECT PRODUCT --</option>
                          <?php
                          $sqlSelect = "SELECT PRODUCT_ID, PRODUCT_NAME FROM `category` ORDER BY 2";
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

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="sel1">TYPE</label>
                             <select class="form-control" id="productTypeSelect" > 
                              <option value="">-- SELECT TYPE --</option>
                              <?php
                              $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                              $result = mysqli_query($conn, $sqlSelect);
                              if(mysqli_num_rows($result) > 0){ 
                              while($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['type_name']?>" ><?php echo $row['type_name'] ?></option>
                                <?php
                                }
                                }
                              ?>
                              </select>
                          </div>
                        </div>

                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="sel1">THICKNESS</label>
                             <select class="form-control" id="productThicknessSelect" > 
                              <option value="">-- SELECT THICKNESS --</option>
                              <?php
                              $sqlSelect = "SELECT `thickness` FROM `production_thickness` ORDER BY 1";
                              $result = mysqli_query($conn, $sqlSelect);
                              if(mysqli_num_rows($result) > 0){ 
                              while($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['thickness']?>" ><?php echo $row['thickness'] ?></option>
                                <?php
                                }
                                }
                              ?>
                              </select>
                          </div>
                        </div> 

                        <div class="col-sm-3">&nbsp;</div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="example-date-input">From Date</label>
                          <input class="form-control" type="date" id="fromDate">
                        </div>              
                      </div>
                      <div class="col-sm-3">
                          <div class="form-group">
                            <label for="example-date-input">To Date</label>
                            <input class="form-control" type="date" id="toDate">
                          </div>  
                      </div>
                      <div class="col-sm-3">&nbsp;</div>
                 </div>
              </div>     
                


              <div class="row position-center"  style="width: 100%;">
                <div class="col-sm-12" id="size-wise-div" style="display: none;"> 
                 <div class="row">
                 <div class="col-sm-4">&nbsp;</div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="sel1">TYPE</label>
                            <select class="form-control" id="size-wise-type" > 
                            <option value="">-- SELECT TYPE --</option>
                            <?php
                            $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                            $result = mysqli_query($conn, $sqlSelect);
                            if(mysqli_num_rows($result) > 0){ 
                            while($row = mysqli_fetch_array($result)) {
                              ?>
                              <option value="<?php echo $row['type_name']?>" ><?php echo $row['type_name'] ?></option>
                              <?php
                              }
                              }
                            ?>
                            </select>
                      </div>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                          <div class="form-group">
                            <label for="example-date-input">Date</label>
                            <input class="form-control" type="date" id="size-date">
                          </div>  
                      </div>
                    <div class="col-sm-4">&nbsp;</div>
                  </div>
                </div>
              </div>


              <div class="row position-center"  style="width: 100%;">
                <div class="col-sm-12" id="machine-wise-with-type-div" style="display: none;"> 
                 <div class="row">
                 <div class="col-sm-4">
                         <div class="form-group">
                            <label for="sel1">Machine NAME</label>
                                <select class="form-control" id="machineNameSelect-machine" > 
                                    <option value="">-- SELECT MACHINE --</option>
                                    <?php
                                    $sqlSelect = "SELECT * FROM `machine_details` ORDER BY 2";
                                    $result = mysqli_query($conn, $sqlSelect);
                                    if(mysqli_num_rows($result) > 0){ 
                                    while($row = mysqli_fetch_array($result)) {
                                      ?>
                                    <option value="<?php echo $row['MACHINE_ID']?>" ><?php echo $row['MACHINE_NAME'] ?></optio n>
                                    <?php
                                    }
                                    }
                                    ?>
                              </select>
                        </div>
                 </div>
                    
                 <div class="col-sm-4">
                    <div class="form-group">
                        <label for="sel1">TYPE</label>
                            <select class="form-control" id="size-wise-machine-type" > 
                            <option value="">-- SELECT TYPE --</option>
                            <?php
                            $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                            $result = mysqli_query($conn, $sqlSelect);
                            if(mysqli_num_rows($result) > 0){ 
                            while($row = mysqli_fetch_array($result)) {
                              ?>
                              <option value="<?php echo $row['type_name']?>" ><?php echo $row['type_name'] ?></option>
                              <?php
                              }
                              }
                            ?>
                            </select>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="sel1">SIZE</label>
                              <select class="form-control" id="size-wise-machine-size" > 
                              <option value="">-- SELECT SIZE --</option>
                              <?php
                              $sqlSelect = "SELECT `SIZE` FROM `production_size` ORDER BY 1";
                              $result = mysqli_query($conn, $sqlSelect);
                              if(mysqli_num_rows($result) > 0){ 
                              while($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['SIZE']?>" ><?php echo $row['SIZE'] ?></option>
                                <?php
                                }
                                }
                              ?>
                              </select>
                        </div>
                    </div> 

                    <div class="col-sm-2" style="display: none">
                      <div class="form-group">
                          <label for="sel1">THICKNESS</label>
                              <select class="form-control" id="size-wise-machine-thickness" > 
                              <option value="">-- SELECT THICKNESS --</option>
                              <?php
                              $sqlSelect = "SELECT `thickness` FROM `production_thickness` ORDER BY 1";
                              $result = mysqli_query($conn, $sqlSelect);
                              if(mysqli_num_rows($result) > 0){ 
                              while($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['thickness']?>" ><?php echo $row['thickness'] ?></option>
                                <?php
                                }
                                }
                              ?>
                              </select>
                        </div>
                    </div>
                    <div class="col-sm-3">&nbsp;</div>      
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="example-date-input">From Date</label>
                          <input class="form-control" type="date" id="fromDate-machine">
                        </div>  
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="example-date-input">To Date</label>
                          <input class="form-control" type="date" id="toDate-machine">
                        </div>  
                    </div>
                    <div class="col-sm-3">&nbsp;</div>

                  </div>
                </div>
              </div>



              <div class="row position-center"  style="width: 100%;">
                <div class="col-sm-12" id="performance-div" style="display: none;"> 
                 <div class="row">
                 <div class="col-sm-4">
                         <div class="form-group">
                            <label for="sel1">Machine NAME</label>
                                <select class="form-control" id="machineNameSelect-performance" > 
                                    <option value="">-- SELECT MACHINE --</option>
                                    <?php
                                    $sqlSelect = "SELECT * FROM `machine_details` ORDER BY 2";
                                    $result = mysqli_query($conn, $sqlSelect);
                                    if(mysqli_num_rows($result) > 0){ 
                                    while($row = mysqli_fetch_array($result)) {
                                      ?>
                                    <option value="<?php echo $row['MACHINE_ID']?>" ><?php echo $row['MACHINE_NAME'] ?></optio n>
                                    <?php
                                    }
                                    }
                                    ?>
                              </select>
                        </div>
                 </div>
                    <div class="col-sm-3" style="display: none;">
                      <div class="form-group">
                        <label for="sel1">TYPE</label>
                            <select class="form-control" id="performance-type"> 
                            <option value="">-- SELECT TYPE --</option>
                            <?php
                            $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                            $result = mysqli_query($conn, $sqlSelect);
                            if(mysqli_num_rows($result) > 0){ 
                            while($row = mysqli_fetch_array($result)) {
                              ?>
                              <option value="<?php echo $row['type_name']?>" ><?php echo $row['type_name'] ?></option>
                              <?php
                              }
                              }
                            ?>
                            </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="example-date-input">From Date</label>
                          <input class="form-control" type="date" id="fromDate-performance">
                        </div>  
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="example-date-input">To Date</label>
                          <input class="form-control" type="date" id="toDate-performance">
                        </div>  
                    </div>

                  </div>
                </div>
              </div>


          <div class="row position-center"  style="width: 100%;">
            <div class="col-sm-12" id="machine-name-div" style="display: none;">
                 
                 <div class="row">
                   <div class="col-sm-4">
                      <div class="form-group">
                            <label for="sel1">Machine NAME</label>
                                    <select class="form-control" id="machineNameSelect" > 
                                    <option value="">-- SELECT MACHINE --</option>
                                    <?php
                                    $sqlSelect = "SELECT * FROM `machine_details` ORDER BY 2";
                                    $result = mysqli_query($conn, $sqlSelect);
                                    if(mysqli_num_rows($result) > 0){ 
                                    while($row = mysqli_fetch_array($result)) {
                                      ?>
                                    <option value="<?php echo $row['MACHINE_ID']?>" ><?php echo $row['MACHINE_NAME'] ?></optio n>
                                    <?php
                                    }
                                    }
                                    ?>
                                  </select>
                          </div>
                   </div>
                   <div class="col-sm-4">
                      <div class="form-group">
                        <label for="example-date-input">From Date</label>
                        <input class="form-control" type="date" id="fromDateMachine">
                      </div>              
                   </div>
                   <div class="col-sm-4">
                      <div class="form-group">
                      <label for="example-date-input">To Date</label>
                      <input class="form-control" type="date" id="toDateMachine">
                      </div>  
                   </div>
                 </div>

                        

                </div>
              </div>

              <div class="row position-center" id="daily-report" style="width: 100%; display: none;">
                  <div class="col-sm-3">&nbsp;</div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="example-date-input">Date</label>
                      <input class="form-control" type="date" id="daily-report-to-date">
                    </div> 
                  </div>
                  <div class="col-sm-3">&nbsp;</div>
              </div>
                
              <div class="row position-center"  style="width: 100%;">
                <div class="col-sm-12" id="all-product-div" style="display: none;"> 
                  <div class="row">
                    <div class="col-sm-2">
                                  &nbsp;
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="productTypeAllSelect" > 
                          <option value="">-- SELECT TYPE --</option>
                          <?php
                          $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                          $result = mysqli_query($conn, $sqlSelect);
                          if(mysqli_num_rows($result) > 0){ 
                          while($row = mysqli_fetch_array($result)) {
                            ?>
                            <option value="<?php echo $row['type_name']?>" ><?php echo $row['type_name'] ?></option>
                            <?php
                            }
                            }
                          ?>
                        </select>
                    </div>
                    <div class="col-sm-1">
                                  &nbsp;
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select class="form-control" id="productThicknessAllSelect" > 
                          <option value="">-- SELECT THICKNESS --</option>
                          <?php
                          $sqlSelect = "SELECT `thickness` FROM `production_thickness` ORDER BY 1";
                          $result = mysqli_query($conn, $sqlSelect);
                          if(mysqli_num_rows($result) > 0){ 
                          while($row = mysqli_fetch_array($result)) {
                            ?>
                            <option value="<?php echo $row['thickness']?>" ><?php echo $row['thickness'] ?></option>
                            <?php
                            }
                            }
                          ?>
                        </select>
                    </div>
                    <div class="col-sm-3">&nbsp;</div>

                  </div>
                </div>
              </div>
              
              <div class="row position-center"  style="width: 100%;">
                  <div class="col-sm-12" id="stock-div" style="display: none;"> 
                      <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group">
                              <label for="sel1">PRODUCT NAME</label>
                              <select class="form-control" id="productName-stock" > 
                                  <option value="">-- SELECT PRODUCT --</option>
                                  <?php
                                  $sqlSelect = "SELECT PRODUCT_ID, PRODUCT_NAME FROM `category` ORDER BY 2";
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
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label for="sel1">TYPE</label>
                                      <select class="form-control" id="product-type-stock" > 
                                      <option value="">-- SELECT TYPE --</option>
                                      <?php
                                      $sqlSelect = "SELECT `type_name` FROM `production_type` ORDER BY 1";
                                      $result = mysqli_query($conn, $sqlSelect);
                                      if(mysqli_num_rows($result) > 0){ 
                                      while($row = mysqli_fetch_array($result)) {
                                          ?>
                                          <option value="<?php echo $row['type_name']?>" ><?php echo $row['type_name'] ?></option>
                                          <?php
                                          }
                                          }
                                      ?>
                                      </select>
                              </div>
                          </div>

                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label for="sel1">SIZE</label>
                                          <select class="form-control" id="product-size-stock" > 
                                          <option value="">-- SELECT SIZE --</option>
                                          <?php
                                          $sqlSelect = "SELECT `SIZE` FROM `production_size` ORDER BY 1";
                                          $result = mysqli_query($conn, $sqlSelect);
                                          if(mysqli_num_rows($result) > 0){ 
                                          while($row = mysqli_fetch_array($result)) {
                                          ?>
                                          <option value="<?php echo $row['SIZE']?>" ><?php echo $row['SIZE'] ?></option>
                                          <?php
                                          }
                                          }
                                          ?>
                                          </select>
                                  </div>
                              </div>
                          </div>                     
              </div>

              </div>
              </br></br>
              <button type="submit" class="btn btn-info" name="submit" onclick="page()" style="margin-left: 45%;">Show Report</button>
              
                </section>
            </div>
        </div>                      
    </div>
   
         
</section>

<!--main content end-->
</section>


<script type="text/javascript">
    function page() {
      //let selectValue = $('input[name="radio"]:checked').val();
      let selectValue = $('#reports').val();
      if(selectValue == "daily") {
          window.location.replace("dailyReport.php?date="+$("#daily-report-to-date").val());

      } else if(selectValue == "size-wise") {
          let sizeDate= "" ;//$("#size-date").val();
          window.location.replace("size_report.php?type="+$("#size-wise-type").val()+"&date="+sizeDate);

      } else if( selectValue == 'all-product') {
          window.location.replace("allProductReport.php?type="+$("#productTypeAllSelect").val());

      } else if( selectValue == 'product-wise') {
          let from = $("#fromDate").val();
          let to = $("#toDate").val();
          let id = document.getElementById('productNameSelect').value; 
          let type = document.getElementById('productTypeSelect').value;
          let thickness = $("#productThicknessSelect").val();
          window.location.replace("production_product_report.php?from="+from+"&to="+to+"&id="+id+"&type="+type+"&thickness="+thickness);

      } else if( selectValue == 'machine-wise') {
          let from = $("#fromDateMachine").val();
          let to = $("#toDateMachine").val();
          let id = document.getElementById('machineNameSelect').value; 
          window.location.replace("production_machine_report.php?from="+from+"&to="+to+"&id="+id);

      } else if(selectValue == 'machine-wise-with-type') {
          let from = $("#fromDate-machine").val();
          let to = $("#toDate-machine").val();
          let type = $("#size-wise-machine-type").val();
          let size = $("#size-wise-machine-size").val();
          let thickness = $("#size-wise-machine-thickness").val();
          let id = document.getElementById('machineNameSelect-machine').value; 
          window.location.replace("machineReportWithType.php?from="+from+"&to="+to+"&machineId="+id+"&type="+type+"&size="+size+"&thickness="+thickness);
      } else if(selectValue == 'performance') {
          let from = $("#fromDate-performance").val();
          let to = $("#toDate-performance").val();
          let type = $("#performance-type").val();
          let id = document.getElementById('machineNameSelect-performance').value; 
          window.location.replace("performanceReport.php?from="+from+"&to="+to+"&machineId="+id+"&type="+type);
      } else if(selectValue == 'stock') {
        let type = $("#product-type-stock").val();
        let size = $("#product-size-stock").val();
        let id = document.getElementById('productName-stock').value; 
        window.location.replace("stockReport.php?productId="+id+"&type="+type+"&size="+size);
      }
    }
</script>
</body>
</html>
