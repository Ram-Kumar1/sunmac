<?php
session_start();
include 'db_connect.php';

if(isset($_POST['SIZE'])){

  $size= $_POST['SIZE'];

  $delete = "DELETE FROM `production_thickness` WHERE thickness = '$size'";
  mysqli_query($conn,$delete);
  print json_encode("success");
}

    if(isset($_POST['submit'])){
        
        $size= $_POST['size'];
        $sql = "INSERT INTO production_thickness(thickness) VALUES('$size')";

       if (mysqli_query($conn, $sql)) {
                ?>
        <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='production_thickness.php';
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
<title>Product Thickness</title>
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
                                    <label for="city">Product Thickness</label>
                                    <input type="text" class="form-control" id="city" placeholder="Enter Production size" name="size">
                                </div>

                                <button type="submit" name="submit" class="btn btn-info" style="margin-left: 35%;width: 30%;">Submit</button>
                            </form>
                        </div>

                        <div class="table-responsive" style="padding: 3em;">
                                <table class="table">
                                  <thead>
                                   <tr style="color:#0c1211";>
                                        <th style="color:#0c1211";>Production size</th>
                                         <th style="color:#0c1211";>Delete</th> 
                                    </tr>
                                 </thead>
                               <?php 
                               $selectCity = 'SELECT * FROM `production_thickness` ORDER BY 1';
                               if($result = mysqli_query($conn, $selectCity)) {
                                          if(mysqli_num_rows($result) > 0) { 
                                            while($row = mysqli_fetch_array($result)) {
                               ?>
                               <tbody>
                                  <tr>
                                       <td style="color:#0c1211";><?php echo $row['thickness']?></td>
                                       <td>
                                        <a>
                                          <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-size="<?php echo $row['thickness']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
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
    debugger;
    let size = $(deleteButton).attr('data-size');
     $.ajax({
       type: 'post',
       url: 'production_thickness.php',
       data: {
        SIZE: size
       },
       success: function (response) {
       alert('Thickness('+size+') is deleted Successfully');
       window.location.reload();
       //window.location.href = "sales_customer_all.php"
       }
    });
  }

</script>

</body>
</html>
