<?php
session_start();
include 'db_connect.php';

if(isset($_POST['designation'])){

  $designation= $_POST['designation'];
  $delete = "DELETE FROM `employee_designation` WHERE designation = '$designation'";
  mysqli_query($conn,$delete);
  print json_encode("success");
  ?>
<?php
}

    if(isset($_POST['submit'])){

        $designation= $_POST['designation'];

        $sql = "INSERT INTO employee_designation (designation) VALUES('$designation')";


       if (mysqli_query($conn, $sql)) {
                ?>
        <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='designation.php';
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
                            Designation
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form action=" " role="form" method="post">
                        
                            <div class="form-group">
                                    <label for="city">Designation Name </label>
                                    <input type="text" class="form-control" id="designation" placeholder="Enter Description" name="designation">
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-info">Submit</button>
                            </form>
                        </div>

                        <div class="table-responsive" style="padding: 3em;">
                                <table class="table">
                                  <thead>
                                   <tr style="color:#0c1211";>
                                        <th style="color:#0c1211";>Designation NAME</th>
                                        <th style="color:#0c1211";>Delete</th>
                                    </tr>
                                 </thead>
                               <?php 
                               $selectCity = 'SELECT DISTINCT(designation) FROM `employee_designation`';
                               if($result = mysqli_query($conn, $selectCity)) {
                                          if(mysqli_num_rows($result) > 0) { 
                                            while($row = mysqli_fetch_array($result)) {
                               ?>
                               <tbody>
                                  <tr>
                                       <td style="color:#0c1211";><?php echo $row['designation']?></td>
                                       <td>
                                        <a>
                                          <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-city-name="<?php echo $row['designation']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
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
</section>

<script type="text/javascript">
    var deleteRecords = function(deleteButton) {
    debugger;
    let cityName = $(deleteButton).attr('data-city-name');
     $.ajax({
       type: 'post',
       url: 'designation.php',
       data: {
        designation: cityName,
       },
       success: function (response) {
       alert('designation is deleted Successfully');
       window.location.reload();
       }
    });
  }

</script>
</body>
</html>
