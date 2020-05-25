<?php
session_start();
include 'db_connect.php';

if(isset($_POST['weightId'])){

  $weightId= $_POST['weightId'];

  echo $delete = "DELETE FROM `product_weight` WHERE production_weight_id = $weightId";
  mysqli_query($conn,$delete);
  print json_encode("success");
}

    if(isset($_POST['submit'])){
        $type= $_POST['type'];
        $size= $_POST['size'];
        $productId= $_POST['product'];
        $weight= $_POST['weight'];
        $thickness = $_POST['thickness'];
        
        $cnt = 0;
        $sqlSelect1 = "SELECT count(*) AS CNT FROM `product_weight` WHERE type='$type' AND size='$size' AND product_id=$productId AND thickness='$thickness'";
        $result1 = mysqli_query($conn, $sqlSelect1);
        if(mysqli_num_rows($result1) > 0){
          while($row = mysqli_fetch_array($result1)) {
            $cnt = $row['CNT'];
          }
        }
        
        if($cnt == 0) {
          $sql = "INSERT INTO `product_weight`(`type`, `size`, `product_id`, `thickness`, `weight`) VALUES ('$type','$size',$productId,'$thickness','$weight')";

          if (mysqli_query($conn, $sql)) {
                    ?>
            <script type="text/javascript">
            alert('Data Are Inserted Successfully');
            window.location.href='production_weight.php';
            </script>
            <?php
                } else {
                  echo "Error: " . $sql . "" . mysqli_error($conn);
                }
                print json_encode("success");  
        } else {
          ?>
          <script type="text/javascript">
          alert('Already Configured !');
          window.location.href='production_weight.php';
          </script>
          <?php
        }       
            $conn->close();
         }
      ?>

<!DOCTYPE html>
<head>
<title>Product Weight</title>
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
</head>

<style type="text/css"><

.tableFixHead {
  overflow-y: auto;
  max-height: 400px !important;
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

/* The container-checkbox */
.container-checkbox {
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

/* Hide the browser's default checkbox */
.container-checkbox input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container-checkbox:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container-checkbox input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container-checkbox input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container-checkbox .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}



</style>


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
Production size
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form action=" " role="form" method="post">
                                <div class="form-group">
                                    <label for="city">Product Type</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="none">-- SELECT TYPE --</option>
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

                                <div class="form-group">
                                    <label for="city">Product Height</label>
                                    <select class="form-control" id="size" name="size">
                                    <option value="none">-- SELECT SIZE --</option>
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

                                <div class="form-group">
                                    <label for="city">Product Name</label>
                                    <select class="form-control" id="name" placeholder="Enter Production size" name="product">
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

                                <div class="form-group">
                                    <label for="city">Product Thickness</label>
                                    <select class="form-control" id="name" placeholder="Enter Production size" name="thickness">
                                        <option value="">-- SELECT THICKNESS --</option>
                                        <?php
                                        $sqlSelect = "SELECT * FROM `production_thickness` ORDER BY 1";
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

                                <div class="form-group">
                                    <label for="city">Product Weight</label>
                                    <input type="number" step="0.01" class="form-control" id="weight" placeholder="Enter Production size" name="weight">
                                </div>
             
                                <button type="submit" name="submit" class="btn btn-info" style="margin-left: 35%;width: 30%;">Submit</button>
                            </form>
                        </div>
                        </br></br>
                        <div class="table-responsive" style="max-height: 30em;">
                                <table class="table tableFixHead">
                                  <thead>
                                   <tr style="color:#0c1211";>
                                   <th style="color:#0c1211";>S.No</th>
                                        <th style="color:#0c1211";>Type</th>
                                        <th style="color:#0c1211";>Thickness</th>
                                        <th style="color:#0c1211";>Size</th>
                                        <th style="color:#0c1211";>Product Name</th>
                                        <th style="color:#0c1211";>Weight</th>
                                        <th style="color:#0c1211";>Delete</th> 
                                    </tr>
                                 </thead>
                               <?php 
                               $selectCity = 'SELECT pw.production_weight_id, pw.type, pw.size, pw.thickness, pw.weight, c.product_name FROM `product_weight` pw, `category` c WHERE 1=1 and pw.product_id=c.product_id ORDER BY 6, 2, 4, 3';
                               if($result = mysqli_query($conn, $selectCity)) {
                                          if(mysqli_num_rows($result) > 0) { 
                                            $i=1;
                                            while($row = mysqli_fetch_array($result)) {
                               ?>
                               <tbody>
                                  <tr>
                                  <td style="color:#0c1211";><?php echo $i++; ?></td>
                                    <td style="color:#0c1211";><?php echo $row['type']?></td>
                                    <td style="color:#0c1211";><?php echo $row['thickness']?></td>
                                    <td style="color:#0c1211";><?php echo $row['size']?></td>
                                    <td style="color:#0c1211";><?php echo $row['product_name']?></td>
                                    <td style="color:#0c1211";><?php echo $row['weight']?></td>
                                       <td>
                                        <a>
                                          <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-weight="<?php echo $row['production_weight_id']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
                                              <i class="material-icons" style="margin-left: -5px;">delete_forever</i>
                                          </button>
                                        </a>
                                      </td>
                                   </tr>
                                </tbody>

                            <?php
                                        } 
                                    }
                                }
                            ?>
                                </table>
                        </div>

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

<script type="text/javascript">
    var deleteRecords = function(deleteButton) {
    
    let weightId = $(deleteButton).attr('data-weight');
     $.ajax({
       type: 'post',
       url: 'production_weight.php',
       data: {
        weightId: weightId
       },
       success: function (response) {
       alert('Data Deleted Successfully');
        window.location.reload();
       //window.location.href = "sales_customer_all.php"
       }
    });
  }

</script>

</body>
</html>
