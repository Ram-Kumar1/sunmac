<?php
session_start();
include 'db_connect.php';

// if(isset($_POST['CITY_NAME'])){

//   $cityName= $_POST['CITY_NAME'];

//   $delete = "DELETE FROM `city` WHERE CITY_NAME = '$cityName'";
//   mysqli_query($conn,$delete);
//   print json_encode("success");
// }

    if(isset($_POST['submit'])){
        $address= $_POST['address'];
        $sql = "UPDATE `billing_address` SET `address`='$address' WHERE `address_id`= '1' ";


       if (mysqli_query($conn, $sql)) {
                ?>
        <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='billing_address.php';
        </script>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }
            $conn->close();
         }
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
                            <form action=" " role="form" method="post">
                        
                            <div class="form-group">
                                    <label for="city">Billing Address</label>
                                    <textarea class="form-control" rows="5" id="comment"  placeholder="Enter Billing Address" name="address"></textarea>
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-info">Submit</button>
                            </form>
                        </div>

                        <div class="table-responsive" style="padding: 3em;">
                                <table class="table">
                                  <thead>
                                   <tr style="color:#0c1211";>
                                        <th style="color:#0c1211";>Billing Address</th>
                                 <!--        <th style="color:#0c1211";>Delete</th> -->
                                    </tr>
                                 </thead>
                               <?php 
                               $selectCity = 'SELECT DISTINCT(address) FROM `billing_address`';
                               if($result = mysqli_query($conn, $selectCity)) {
                                          if(mysqli_num_rows($result) > 0) { 
                                            while($row = mysqli_fetch_array($result)) {
                               ?>
                               <tbody>
                                  <tr>
                                       <td style="color:#0c1211";><?php echo $row['address']?></td>
                                      <!--  <td>
                                        <a>
                                          <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-city-name="<?php echo $row['CITY_NAME']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
                                              <i class="material-icons" style="margin-left: -5px;">delete_forever</i>
                                          </button>
                                        </a>
                                      </td> -->
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

<!-- <script type="text/javascript">
    var deleteRecords = function(deleteButton) {
    debugger;
    let cityName = $(deleteButton).attr('data-city-name');
     $.ajax({
       type: 'post',
       url: 'production_type.php',
       data: {
        CITY_NAME: cityName,
       },
       success: function (response) {
       alert('production type is deleted Successfully');
       window.location.reload();
       //window.location.href = "sales_customer_all.php"
       }
    });
  }

</script> -->

</body>
</html>
