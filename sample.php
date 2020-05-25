<?php
session_start();
include 'db_connect.php';
if(isset($_POST['submit'])){

       $S_NAME= $_POST['S_NAME'];
       $S_MOBILE= $_POST['S_MOBILE'];
       $S_ALTERNATE_MOBILE= $_POST['S_ALTERNATE_MOBILE']; 
       $S_MAIL= $_POST['S_MAIL'];
       $S_ADDRESS= $_POST['S_ADDRESS'];
       $S_CITY= $_POST['S_CITY'];
	   
	   date_default_timezone_set('Asia/Kolkata');
	   $date_1 =  date('d-m-Y H:i');
	   $S_REGISTRATION_DATE = date('Y-m-d', strtotime($date_1));

          
 $sql = "INSERT INTO sales_customer(S_NAME, S_MOBILE,S_ALTERNATE_MOBILE,S_MAIL,S_ADDRESS,S_CITY,S_NEED_TO_FOLLOWED,S_REGISTRATION_DATE) VALUES ('$S_NAME','$S_MOBILE','$S_ALTERNATE_MOBILE','$S_MAIL','$S_ADDRESS','$S_CITY','0', '$S_REGISTRATION_DATE')";
if (mysqli_query($conn, $sql)) {
                ?>
      <script type="text/javascript">
        alert('Data Are Inserted Successfully');
        window.location.href='sales_customer.php';
      </script>
        
        <?php
            } else {
               echo "Error: " . $sql . "" . mysqli_error($conn);
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
<script type="text/javascript">
  var validateInput = function(input) {
    debugger;
    let parentElement = input.parentElement;
    let inputId = input.id;
    let inputValue = input.value;

    if(inputId == "mob_no" || inputId == "alter_mob_no") {
      if(inputValue.length != 10) {
        parentElement.className += " has-error";
      } else {
        parentElement.classList.remove("has-error");
      }

    } else if(inputId == "s_mail") {
      let reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
       if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(inputValue) == false) {
            parentElement.className += " has-error";
        } else {
            parentElement.classList.remove("has-error");
        }

    }

  };

  var validate = function() {
    debugger;
    let mobile = document.getElementById('mob_no').value;
    let alternateMobile = document.getElementById('alter_mob_no').value;
    let mail = document.getElementById('s_mail').value;
     if(mobile.length != 10 || alternateMobile.length != 10) {
        alert('Please correct the error');
        return false;
     }

     let reg = /(.+)@(.+){2,}\.(.+){2,}/;
     if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail) == false) {
        alert('Please correct the error');
        return false;
     } 
     return true;

  };
</script>

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
                           CUSTOMER 
                    </header>
                    <div class="panel-body">


                        <div class="position-center">
                            <form  name="myForm" action="#" method="post" role="form" onsubmit="return validate(this)">
                                
                              <div class="form-group">
                                    <label for="s_name">Customer Name</label>
                                    <input required type="text" class="form-control" id="s_custname" placeholder="Enter customername" name="S_NAME">
                                </div>
                                <div class="form-group">
                                    <label for="mob_no">Mobile Number</label>
                                    <input type="number" class="form-control" id="mob_no" onchange="validateInput(this);" placeholder="Enter mobile number" name="S_MOBILE" required="true">
                                </div>

                                <div class="form-group">
                                    <label for="mob_no">Alternate Mobile Number</label>
                                    <input required type="number" class="form-control" id="alter_mob_no" placeholder="Enter mobile number" name="S_ALTERNATE_MOBILE" onchange="validateInput(this);">
                                </div>

                                <div class="form-group">
                                    <label for="mail">Email</label>
                                    <input required type="email" class="form-control" id="s_mail" placeholder="Enter email" name="S_MAIL" onchange="validateInput(this);" required="true">
                                </div>
                                <div class="form-group">
                                    <label for="adrress">Adress</label>
                                    <input required type="text" class="form-control" id="address" placeholder="Enter address" name="S_ADDRESS">
                                </div>
<?php
$selectCity = 'SELECT DISTINCT(CITY_NAME) FROM `city`';
?>
                                <div class="form-group">
                                    <label for="sel1">City</label>
                                    <select type="text" class="form-control" id="sel1" name="S_CITY">
                                      <option value="">-- SELECT CITY --</option>
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
                              <button type="submit" class="btn btn-info" name="submit" onClick="return validate();" >Submit</button>
                            </form>
                            <br>
                            <br>
                        </div>
<?php
$sql = "SELECT S_ID,S_NAME,S_MOBILE,S_MAIL,S_ADDRESS FROM sales_customer where S_NEED_TO_FOLLOWED = '0' ";
if($result = mysqli_query($conn, $sql)){
    //if(mysqli_num_rows($result) > 0){ 
?>
<div class="table-responsive">
        <table class="table">
          <thead>
           <tr style="color:#0c1211";>
                <th style="color:#0c1211";>SALES CUSTOMER NAME</th>
                <th style="color:#0c1211";>MOBILE NUMBER</th>
                <th style="color:#0c1211";>EMAIL</th>
                <th style="color:#0c1211";>ADDRESS</th>
                <th style="color:#0c1211";>Manufacture & Dealer</th>
                
            </tr>
         </thead>
       <?php 
       while($row = mysqli_fetch_array($result)){
       ?>
       <tbody>
          <tr>
               <td style="color:#0c1211";><?php echo $row['S_NAME']?></td>
               <td style="color:#0c1211";><?php echo $row['S_MOBILE']?></td>
               <td style="color:#0c1211";><?php echo $row['S_MAIL']?></td>
               <td style="color:#0c1211";><?php echo $row['S_ADDRESS']?></td>
               <td><a href="javascript:edt_id('<?php echo $row["S_ID"]; ?>')"><button type="button" class="btn btn-primary">Update</button></a></td>

           </tr>
        </tbody>

<?php
} }
?>
        </table>
</div>
 </div>

      </div>
    </section>
  </div>
</div>
</div>

<script>

function edt_id(id)
{
    if(confirm('Sure to GO ?'))
    {
        window.location.href='S_manufacture_dealer.php?edit_id='+id;
    }
}

</script>

</section>


<script type="text/javascript">

function state(val)
{
 $.ajax({
 type: 'post',
 url: 'fetch_data.php',
 data: {
  state:val
 },
 success: function (response) {
  document.getElementById("city").innerHTML=response; 
 }
 });
}
</script>


</section>

</body>
</html>


