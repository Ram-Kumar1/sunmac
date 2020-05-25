<?php
session_start();
include 'db_connect.php';


         if(isset($_POST['submit'])) {
           $STATE_NAME= $_POST['STATE_NAME'];
           $CITY_NAME= $_POST['city'];
           $sql="INSERT INTO city(STATE_NAME,CITY_NAME)VALUES('$STATE_NAME','$CITY_NAME')";
         

          if (mysqli_query($conn, $sql)) {
?>
                 <script type="text/javascript">
                 alert('Data Are Inserted Successfully');
                 window.location.href='city.php';
                 </script>      
           <?php
               } else {
                  echo "Error: " . $sql . "" . mysqli_error($conn);
               $conn->close();
              }
          }
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
                        CITY
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                          <?php
                            // $link = mysqli_connect("localhost", "root", "", "sunmac");
                            // if($link === false){
                            // die("ERROR: Could not connect. " . mysqli_connect_error());
                            // }


                            $selectCity = 'SELECT DISTINCT(STATE_NAME) FROM `state`';

                          ?>
                            <form action="#" method="post" role="form">
                        
                                  <div class="form-group">
                                  <label for="sel1">State</label>
                                  <select type="text" class="form-control" id="sel1" name="STATE_NAME">
                                    <option value="">-- SELECT STATE --</option>
                                    <?php
                                      if($result = mysqli_query($conn, $selectCity)){
                                        if(mysqli_num_rows($result) > 0){ 
                                          while($row = mysqli_fetch_array($result)) {
                                    ?>
                                            <option value="<?php echo $row['STATE_NAME']?>" ><?php echo $row['STATE_NAME'] ?></option>
                                    <?php
                                          }
                                        }
                                      }
                                    ?>
                                  </select>
                                  </div>
                                <div class="form-group">
                                  <label for="usr">Distruct Name:</label>
                                  <input type="text" class="form-control" id="city" name="city">
                                </div>
                                
                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
                            </form>
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

</body>
</html>