<?php
include_once 'db_connect.php';
session_start();

if(isset($_GET['edit_id1']))
{
              $id3 = $_GET['edit_id1'];  

	$sql_query="SELECT * FROM sales_customer WHERE S_ID=".$_GET['edit_id1'];
	$result_set=mysqli_query($conn,$sql_query);
	$fetched_row=mysqli_fetch_array($result_set);
  
}

if(isset($_POST['Update'])){

       $S_NAME= $_POST['S_NAME'];
       $S_MOBILE= $_POST['S_MOBILE'];
       $S_ALTERNATE_MOBILE= $_POST['S_ALTERNATE_MOBILE'];
       $S_MAIL= $_POST['S_MAIL'];
       $S_ADDRESS= $_POST['S_ADDRESS'];
       $S_CITY= $_POST['S_CITY'];

 $sql = "UPDATE `sales_customer` SET `S_NAME`='$S_NAME',`S_MOBILE`='$S_MOBILE',`S_ALTERNATE_MOBILE`='$S_ALTERNATE_MOBILE',`S_MAIL`='$S_MAIL',`S_ADDRESS`='$S_ADDRESS',`S_CITY`='$S_CITY'   WHERE S_ID = '$id3' ";

if (mysqli_query($conn, $sql)) {
      
header("Location: sales_customer.php");

            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
            }

       }


?>
<!DOCTYPE html>
<heaaaad>
<title>Visitors aaaan aaaadmin Paaaanel Caaaategory Bootstrap Responsive Website Template | Form_component :: w3layouts</title>
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
                        CUSTOMER Edit
                    </header>
                    <div class="panel-body">
                        <div class="position-center"> 

                            <form  method="post"  action="" role="form" >
                                <div class="form-group">
                                    <label for="mail">Customer Name</label>
                          <input type="text" class="form-control" value="<?php echo $fetched_row['S_NAME']; ?>" name="S_NAME" required >
                                     <input type="hidden" class="form-control"  name="S_ID" value="<?php echo $fetched_row['S_ID']; ?>" disabled >
                                </div>

                                <div class="form-group">
                                    <label for="mail">Customer Mobile no1</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_MOBILE']; ?>" name="S_MOBILE" required >
                                </div>

                                <div class="form-group">
                                    <label for="mail">Customer Mobile no2</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_ALTERNATE_MOBILE']; ?>" name="S_ALTERNATE_MOBILE"  >
                                </div>

                                <div class="form-group">
                                    <label for="mail">Customer Mail</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_MAIL']; ?>" name="S_MAIL" required >
                                </div>
                                      
                                  <div class="form-group">
                                    <label for="mail">Customer Address</label>
                                    <input type="text" class="form-control" value="<?php echo $fetched_row['S_ADDRESS']; ?>" name="S_ADDRESS" required >
                                </div>


<?php
$selectCity = 'SELECT DISTINCT(CITY_NAME) FROM `city`';
?>
                                <div class="form-group">
                                    <label for="sel1">LOCATION</label>
                                    <select type="text" class="form-control" id="city" name="S_CITY">
                                      <option value="">-- SELECT LOCATION --</option>
                                      <?php
                                        if($result = mysqli_query($conn, $selectCity)){
                                          if(mysqli_num_rows($result) > 0){ 
                                            while($row = mysqli_fetch_array($result)) {
                                      ?>
                                              <option value="<?php echo $row['CITY_NAME']?>" ><?php echo $row['CITY_NAME'] ?></option>
                                      <?php
                                            }
                                          }
                                        }
                                      ?>
                                    </select>
                              </div>
<script type="text/javascript">
  $("#city").val('<?php echo $fetched_row['CITY_NAME']; ?>');
</script>

                                
                                    
                            <button type="submit"  class="btn btn-info" name="Update" > Submit</button>

                    </form>



                            <br>
                            <br>
                        </div>
<p id="city"></p>
      </div>
    </section>
  </div>
</div>
</div>


</section>

<?php
include 'demo.css';
?>
<?php
include 'demo.js';
?>

</section>

<script type="text/javascript">
  $(document).ready(function(){
    $("#city").val('<?php echo $fetched_row['S_CITY']; ?>');
  });
</script>

</body>
</html>


