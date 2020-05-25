<?php
session_start();
include 'db_connect.php';

if(isset($_POST['Description'])){

  $Description= $_POST['Description'];
  $delete = "DELETE FROM `salary_description` WHERE description = '$Description'";
  mysqli_query($conn,$delete);
  print json_encode("success");
  ?>
<?php
}

    if(isset($_POST['submit'])){

        $Description= $_POST['Description'];
        $status= $_POST['status'];
      
        $sql = "INSERT INTO salary_description (description,statuses) VALUES('$Description','$status')";
       if (mysqli_query($conn, $sql)) {
                ?>
        <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='description.php';
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
                            Description
                    </header>
                    <div class="panel-body">
                        <div class="position-center">
                            <form action=" " role="form" method="post" onsubmit="return validateForm();">
                        
                            <div class="form-group">
                                    <label for="city">Description Name </label>
                                    <input required="true" type="text" class="form-control" id="Description" placeholder="Enter Description" name="Description">
                                     <label for="city">Description Status </label>
                                       <select id="city" name="status" class="form-control input-search" required="true" >
                                        <option value=""> Select status </option>
                                        <option value="ADDITION">ADDITION</option>
                                        <option value="DETUCTION"> DETUCTION </option>
                                        </select>
                                    
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-info">Submit</button>
                            </form>
                        </div>

                        <div class="table-responsive" style="padding: 3em;">
                                <table class="table">
                                  <thead>
                                   <tr style="color:#0c1211";>
                                        <th style="color:#0c1211";>S.No</th>
                                        <th style="color:#0c1211";>Description NAME</th>
                                        <th style="color:#0c1211";>Description Status</th>
                                        
                                        <th style="color:#0c1211";>Delete</th>
                                    </tr>
                                 </thead>
                               <?php 
                               $selectCity = 'SELECT DISTINCT(description),statuses FROM `salary_description`';
                               if($result = mysqli_query($conn, $selectCity)) {
                                          if(mysqli_num_rows($result) > 0) { 
                                            $i=1;
                                            while($row = mysqli_fetch_array($result)) {
                               ?>
                               <tbody>
                                  <tr>
                                    <td style="color:#0c1211";><?php echo $i++; ?></td>
                                       <td style="color:#0c1211";><?php echo $row['description']?></td>
                                       <td style="color:#0c1211";><?php echo $row['statuses']?></td>
                                       
                                       <td>
                                        <a>
                                          <button type="submit" name="submit" name="Delete" onclick="deleteRecords(this)" data-city-name="<?php echo $row['description']; ?>" class="btn btn-primary" style="max-width: 40px; max-height: 40px;">
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

    var validateForm = function() {
      let selectVal = $("#city").val();
      if(selectVal == "") {
        alert("Description Status is mandatory!");
        return false;
      }
    };

    var deleteRecords = function(deleteButton) {
    let cnf = confirm("Sure to delete!");
    if(cnf) {
      let cityName = $(deleteButton).attr('data-city-name');
      $.ajax({
        type: 'post',
        url: 'description.php',
        data: {
          Description: cityName,
        },
        success: function (response) {
        alert('Description is deleted Successfully');
        window.location.reload();
        //window.location.href = "sales_customer_all.php"
        }
      });
    } else {
      return false;
    }
    
  }

</script>
</body>
</html>
