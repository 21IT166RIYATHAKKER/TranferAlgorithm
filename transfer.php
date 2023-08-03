<!DOCTYPE html>
<html lang="en">
<head>
  <title>Transfer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <link rel="icon" href="https://www.google.com/favicon.ico" type="image/gif" sizes="16x16"> 
</head>


<?php      

$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "gpayy";  

$con = mysqli_connect($host, $user, $password, $db_name);  
if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}  
$from= $_POST['from'];
$to = $_POST['to'];
$pin = $_POST['pin'];
$amt= $_POST['amt'];
$bns=0;
if($amt>149)
{
  $bt = ($bns==0) ? "Better Luck Next Time" : $bns;
}
else{
  $bns=0;
}

$sql="SELECT balance  FROM profile WHERE pid='$from' AND pin='$pin'";
$result = mysqli_query($con,$sql);
if($row = mysqli_fetch_array($result)) {
$balance= $row['balance'];

$fb=$balance-$amt;
           
$min=0;
if($fb<$min)
{
    $sql="INSERT INTO `activity` VALUES ('$from', '$to', '$amt', 'INSUFFICIENT BALANCE') ";

    if ($con->query($sql) === TRUE) {
        echo "Record inserted Succesfully <br>";
        
    }
    echo "INSUFFICIENT BALANCE";
}

else
    {
      $fb=$fb+$bns;
        $sql = "UPDATE `profile` SET balance='$fb' WHERE pid='$from'"; 

    if ($con->query($sql) === TRUE) {
        echo "Amount Debited Successfully <br>";
        if($bns>0)
        {
          
        $sql="INSERT INTO `activity` (`from`, `to`, `amt`, `status`) VALUES ('$from', '$to', '$bns', 'Bonus Credited') ";
        if ($con->query($sql) === TRUE) {
          echo "Bonus credited Sucesfully<br>";
          
      }
        }
    }
    else 
    {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $sql="SELECT balance  FROM `profile` WHERE pid='".$to."'";
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
    $balance= $row['balance'];
    $tb=$balance+$amt;
    }         
    $sql = "UPDATE profile SET balance='$tb' WHERE pid='$to'"; 
    if ($con->query($sql) === TRUE) {
        echo "Amount credited Successfully <br>";
        $sql="INSERT INTO `activity` (`from`, `to`, `amt`, `status`) VALUES ('$from', '$to', '$amt', 'successfull') ";      
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
}
else{
    $sql="INSERT INTO `activity` (`from`, `to`, `amt`, `status`) VALUES ('$from', '$to', '$amt', 'Pin ERROR') ";
    echo "<p style='margin-left: 10px; font-size: 25px; color: red; font-weight: bold;'>Pin error</p>";

}
echo "<h3><a href=\"send.html\" style='margin-left: 10px;'> Go to profile</a></h3>";
$con->close();
       
?>  

</html>
