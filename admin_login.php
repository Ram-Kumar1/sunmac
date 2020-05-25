 <?php
session_start();
include 'db_connect.php';

date_default_timezone_set('Asia/Kolkata');
$date_1 =  date('d-m-Y H:i');
$date = date('Y-m-d', strtotime($date_1));
$firstDay = date('Y-m-01'); // hard-coded '01' for first day
$lastDay = date('Y-m-t');

// echo "date: $date";
$isCurrentDateInsertedSql = "select count(*) as CNT from followup where CURRENT_FOLLOWUP_DATE='$date'";
$isCurrentDateInserted = 0;
if($result = mysqli_query($conn, $isCurrentDateInsertedSql)) {
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result)) {
        $isCurrentDateInserted = $row['CNT'];
      }
    }
} 

if($isCurrentDateInserted == 0) {
  $follwedCustomerIdSql = "SELECT COUNT(*) AS CNT FROM sales_customer C WHERE 1=1 AND S_MANUFACTURER_PRODUCTS != '' AND S_ID NOT IN (SELECT DISTINCT S_ID FROM followup WHERE CURRENT_FOLLOWUP_DATE BETWEEN '$firstDay' AND '$lastDay')"; 
  $remaingFollowUp = -1;
  if($result = mysqli_query($conn, $follwedCustomerIdSql)) {
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
          $remaingFollowUp = $row['CNT'];
        }
    }
  }
  // echo "remaingFollowUp: $remaingFollowUp";
  if($remaingFollowUp > 0) {
    // echo "\nInserting..";
    $today = new DateTime();
    $lastDayOfThisMonth = new DateTime('last day of this month');
    $nbOfDaysRemainingThisMonth = $lastDayOfThisMonth->diff($today)->format('%a days');
    $totalCntPerDay = ceil((int) $remaingFollowUp / (int) $nbOfDaysRemainingThisMonth);
    // $totalCntPerDay = ceil((int) $remaingFollowUp / 30);
    // $totalCntPerDay = 30;
    $insertQuery = 
        "INSERT INTO followup (S_ID, CURRENT_FOLLOWUP_DATE, CUSTOMER_STATUS)  
            (SELECT S_ID, '$date', 0 FROM sales_customer WHERE 1=1 AND S_MANUFACTURER_PRODUCTS != '' AND S_ID NOT IN (SELECT DISTINCT S_ID FROM followup WHERE CURRENT_FOLLOWUP_DATE BETWEEN '$firstDay' AND '$lastDay') LIMIT $totalCntPerDay)";
    mysqli_query($conn, $insertQuery);
}

}

// if(isset($_SESSION['admin'])) {
// header('Location:index.php');
// }

if (isset($_POST['signin'])) {
$usr_name = mysqli_real_escape_string($conn, $_POST['usr_name']);
$pswd = mysqli_real_escape_string($conn, $_POST['pswd']);
$loginType = $_POST['logintype'];
  if ($pswd == 'admin' && $usr_name == 'admin' ) {
     $_SESSION['admin'] = 'admin';
     $_SESSION['userName'] = $usr_name; 
     header('Location:index.php');
  } else {
    /*echo '<script> alert("Incorrect email or password")  </script>';*/
    $sql = "select count(*) as CNT from employee_details where USER_NAME LIKE '$usr_name' AND PASSWORD LIKE '$pswd' AND LOGIN_TYPE LIKE '$loginType'";
    $loginCount = 0;
    if($result = mysqli_query($conn, $sql)) {
      while($row = mysqli_fetch_array($result)) {
        $loginCount = $row['CNT'];
      }

      if($loginCount > 0) {
          $_SESSION['admin'] = $loginType; 
          $_SESSION['userName'] = $usr_name;
          header('Location:index.php');
      } else {
          echo '<script> alert("Incorrect user name or password")  </script>';
      }
    } 

  }
}
?>
<!DOCTYPE html>
<head>
<title></title>
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
<div class="w3layouts-main">
  <h2>Sign In Now</h2>
    <form action="" method="post">
      <input type="text" class="ggg" name="usr_name" placeholder="User Name" required="" value="">
      <input type="password" class="ggg" name="pswd" placeholder="Password" required="" value="">
      <select class="form-control" id="loginSelect" name="logintype">
        <!-- <option value="">-- SELECT LOGIN TYPE --</option> -->
        <option value="admin">Admin</option>
        <option value="generalManager">General Manager</option>
        <option value="HR">HR</option>
        <option value="followUp">Follow up</option>
        <option value="salesManager">Sales</option>
        <option value="accountsManager">Accounts</option>
        <option value="purchaseManager">Purchase</option>
        <option value="productionManager">Production</option>
        <option value="marketingManager">Marketing</option>
        <option value="employee">Employee</option>
      </select>
        <input type="submit" value="Sign In" name="signin">
    </form>
</div>
</body>
</html>