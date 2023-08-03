<!DOCTYPE html>
<html lang="en">
    <!-- Image and text -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<?php      

$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "gpayy";  
  
$con = mysqli_connect($host, $user, $password, $db_name);  
if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}  
    $pid=  $_POST['pid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $phno = $_POST['phno'];
    $address= $_POST['address']; 
    $balance= $_POST['balance']; 
    $lang=$_POST['lang'];
    $atype=$_POST['atype'];
    $pin =$_POST['pin'];
        $sql = "INSERT INTO profile (pid,name,country,address,balance,email,phno,pin,lang,atype) VALUES ('$pid','$name', '$country','$address',$balance,'$email','$phno',$pin,'$lang','$atype')"; 
        
      if ($con->query($sql) === TRUE) {
    echo "New record created successfully";
           } 
    else 
    {
    echo "Error: " . $sql . "<br>" . $con->error;
    }
    echo "<br><h3><a href=\"send.html\" > Go to profile</a></h3>";

$con->close();
        
?>  

</html>