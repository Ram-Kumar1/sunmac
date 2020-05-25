<?php
include_once 'db_connect.php';
session_start();
$fId = 0;
date_default_timezone_set('Asia/Kolkata');
$date_1 =  date('d-m-Y H:i');
$today_date = date('Y-m-d', strtotime($date_1));
if(isset($_GET['edit_id']))
{
  $fId = $_GET['edit_id'];
  $isFromRemainderTable = $_GET['isFromRemainderTable'];
	$sql_query="SELECT * FROM followup WHERE F_ID=".$_GET['edit_id'];
	$result_set=mysqli_query($conn,$sql_query);
	$fetched_row=mysqli_fetch_array($result_set);
  $S_ID = $fetched_row['S_ID'];
    //$S_NAME = $fetched_row['S_NAME'];

}

if(isset($_POST['update']))
{

  date_default_timezone_set('Asia/Kolkata');
	$date_1 =  date('d-m-Y H:i');
	$today_date = date('Y-m-d', strtotime($date_1));

  $remarks=$_POST['remarks'];
  $next_date= $_POST['next_date'];
  $status= $_POST['status'];
  $isFromRemainderTable = $_POST['isFromRemainderTable'];

  
if ($status == 'followUp') {
  $followUpDate = date('Y-m-d', strtotime($next_date));
  $insertFollowUp = "INSERT INTO `remainder_followup`(`F_ID`, `S_ID`, `FOLLOWUP_DATE`) VALUES ($fId, $S_ID, '$followUpDate')";
  mysqli_query($conn, $insertFollowUp);
}

if($isFromRemainderTable == 1) {
  $sql = "UPDATE remainder_followup SET CUSTOMER_STATUS = 1 WHERE F_ID = $fId";
  mysqli_query($conn, $sql);
  $sql = "UPDATE followup SET SHOW_TO_ADMIN = 1 WHERE F_ID = $fId";
  mysqli_query($conn, $sql);
}

  
if ($status == 'sales') {
  $date = date('Y-m-d');
  $sales_insert = "INSERT INTO `quotation_followup`( `CUSTOMER_ID`, `Q_STATUS`, `Q_DATE`,REMARKS) VALUES ('$S_ID','0', '$date','$remarks')";
  mysqli_query($conn, $sales_insert);
}
 
 $next_date;

$sql_update = "UPDATE `followup` SET `F_STATUS`= '$status' ,`NEXT_FOLLOWUP_DATE`='$next_date',`CURRENT_FOLLOWUP_DATE`= '$today_date',`CUSTOMER_STATUS`='1',`F_REMARKS`= '$remarks' WHERE F_ID =".$_GET['edit_id'];


	  if (mysqli_query($conn, $sql_update)) {

               ?>
    <script type="text/javascript">
		  alert('Data Are Add Successfully');
		  window.location.href='followup.php';
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
<title>Follow Up Update</title>
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
                        CUSTOMER FOLLOWUP
                    </header>

                    <?php if($fetched_row['CUSTOMER_STATUS'] == '1') { ?>
                      <div class="table-responsive">
                            <table class="table" style="display: none;">
                              <thead>
                               <tr style="color:#0c1211";>
                                    <th style="color:#0c1211";>Followup Id</th>
                                    <th style="color:#0c1211";>Previous Followup Date</th>
                                    <th style="color:#0c1211";>Remark</th>
                                    <th style="color:#0c1211";>STATUS</th>  
                                </tr>
                             </thead>
            
                           <tbody>
                              <tr>
                                   <td style="color:#0c1211";><?php echo $fetched_row['F_ID']?></td>
                                   <td style="color:#0c1211";><?php echo $fetched_row['CURRENT_FOLLOWUP_DATE']?></td>
                                   <td style="color:#0c1211";><?php echo $fetched_row['F_REMARKS']?></td>
                                   <td style="color:#0c1211";><?php echo $fetched_row['F_STATUS']?></td>
                                  
                               </tr>
                            </tbody>

                      <?php
                      } 
                      ?>

                            </table>                    
                            <br>
                            <br>
                    
                    <div class="panel-body">
                        <div class="position-center">
                            <form action=" " method="post" role="form">
                        <div class="form-group"  style="display: none;">
                          <label for="mail">isFromRemainderTable</label>
                          <input id="isFromRemainderTable" class="form-control" name="isFromRemainderTable" placeholder="Date" class="form-control input-md" type="text">     
                        </div>
                        <div class="form-group">
                          <label for="mail">Company Name</label>
                          <input disabled id="company-name" class="form-control" name="company_date" placeholder="Date" class="form-control input-md" type="text" >     
                        </div>
                        <div class="form-group">
                            <label for="mail">Status</label>
                             <select class="form-control" name="status" onchange="demo(this.value);" required>
                                  <option value="">Select status</option>
                                  <option value="noResponce">No Responce</option>
                                  <option value="followUp">Follow Up</option>
                                  <option value="sales">Enquiry</option>
                                  <option value="irrelevant">Irrelevant</option>
                              </select>
                        </div>   

                        <script type="text/javascript">
                          function demo(val){

                            if(val == 'noResponce' || val == 'sales' || val == 'irrelevant'){
                             document.getElementById("panel").disabled = true;
                            } else {
                             document.getElementById("panel").disabled = false;
                            }

                            if(val != "sales") {
                              document.getElementById("remarks").disabled = true;
                              $("#remarks").prop('required',false);
                            } else {
                              // document.getElementById("remarks").disabled = false;
                              $("#remarks").attr('readonly',false);
                              $("#remarks").prop('required',true);
                            }


                          }
                        </script>
                                                        
                                <div class="form-group">
                                    <label for="mail">Followup Date</label>
                                    <input  type="text" class="form-control" value="<?php echo $today_date;?>" name="today_date" disabled>
                                </div>


                                <div class="form-group">
                                    <label for="mail">Next Followup Date</label>
                                    <input disabled id="panel" class="form-control" id="textinput-name" name="next_date" placeholder="Date" class="form-control input-md" type="date" >
                                </div>                                

                                <div class="form-group">
                                    <label for="mail">Remark</label>
                                    <input type="text" name="remarks" class="form-control" id="remarks" readonly="true">
                                </div>     

                               

                                <button type="submit" class="btn btn-info" name="update">Submit</button>
                            </form>
                            <br>
                            <br>
                        </div>

      </div>
    </section>
  </div>
</div>
</div>


</section>

<script type="text/javascript">

$( document ).ready(function() {
  let params = new window.URLSearchParams(window.location.search);
  let companyName = params.get('name');
  $("#company-name").val(companyName);
  let isFromRemainderTable = params.get('isFromRemainderTable');
  $("#isFromRemainderTable").val(isFromRemainderTable);
});

// function state(val)
// {
//  $.ajax({
//  type: 'post',
//  url: 'fetch_data.php',
//  data: {
//   state:val
//  },
//  success: function (response) {
//   document.getElementById("city").innerHTML=response; 
//  }
//  });
// }
</script>


</section>

</body>
</html>


