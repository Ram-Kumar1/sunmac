<?php 

include 'db_connect.php';

  if(isset($_POST['EMPLOYEE_NAME'])){    
         $EMPLOYEE_NAME= $_POST['EMPLOYEE_NAME'];
         $EMPLOYEE_MOBILE= $_POST['EMPLOYEE_MOBILE'];
         $EMPLOYEE_ALTERNATE_MOBILE= $_POST['EMPLOYEE_ALTERNATE_MOBILE'];
         $EMPLOYEE_BLOOD_GROUP= $_POST['EMPLOYEE_BLOOD_GROUP'];
         $EMPLOYEE_MAIL= $_POST['EMPLOYEE_MAIL'];
         $EMPLOYEE_ADDRESS= $_POST['EMPLOYEE_ADDRESS'];
         $SALARY= $_POST['SALARY'];
         $LOGIN_TYPE= $_POST['LOGIN_TYPE'];
         $USER_NAME= $_POST['USER_NAME'];
         $PASSWORD= $_POST['PASSWORD'];
         $CITY= $_POST['CITY'];
   $sql = "INSERT INTO employee_details(EMPLOYEE_NAME,EMPLOYEE_MOBILE,EMPLOYEE_ALTERNATE_MOBILE,EMPLOYEE_BLOOD_GROUP,EMPLOYEE_ADDRESS,SALARY,LOGIN_TYPE,USER_NAME,PASSWORD,CITY,MAIL) VALUES ('$EMPLOYEE_NAME','$EMPLOYEE_MOBILE','$EMPLOYEE_ALTERNATE_MOBILE','$EMPLOYEE_BLOOD_GROUP','$EMPLOYEE_ADDRESS','$SALARY','$LOGIN_TYPE','$USER_NAME','$PASSWORD','$CITY','$EMPLOYEE_MAIL')";


$query = "SELECT * FROM `employee_details` WHERE MAIL = '$EMPLOYEE_MAIL'  ";
$result = mysqli_query($conn, $query);

$query1 = "SELECT * FROM `employee_details` WHERE EMPLOYEE_MOBILE = $EMPLOYEE_MOBILE ";
$result1 = mysqli_query($conn, $query1);
$demo = mysqli_num_rows ( $result );
$demo1 = mysqli_num_rows ( $result1 );

if ( mysqli_num_rows ( $result ) == 0 && mysqli_num_rows ( $result1 ) == 0 )
{

  if (mysqli_query($conn, $sql)) {


$lastrecord = "SELECT MAX(`EMPLOYEE_ID`) from `employee_details";
$result = mysqli_query($conn, $lastrecord);
$rows = mysqli_fetch_array($result);
$last_id = $rows[0];

$last_id_update = $last_id + 1000;
$demo_demo = "SM";
$last_id_update = $demo_demo.$last_id_update;

$query = "UPDATE `employee_details` SET `EMP_IDENTIFY`= '$last_id_update' WHERE EMPLOYEE_ID = '$last_id'";
mysqli_query($conn , $query);

          echo 'Data Are Inserted Successfully';
        
              } else {
                 echo "Error: " . $sql . "" . mysqli_error($conn);
              }
            }else{

if ( mysqli_num_rows ( $result ) > 0){
echo 'This Employee Mail already exists';
}
if ( mysqli_num_rows ( $result1 )  > 0 ) {
echo 'This Employee Mobile No already exists';
}  
}
}
?>