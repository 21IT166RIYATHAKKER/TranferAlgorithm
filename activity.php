<!DOCTYPE html>
<html lang="en">
    <!-- Image and text -->

<link rel="stylesheet" href="css/bootstrap.min.css">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPAY</title>
   <link rel="icon" href="https://www.google.com/favicon.ico" type="image/gif" sizes="16x16">  
</head>
<style>
 
.my-form
{
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
}

.my-form .row
{
    margin-left: 0;
    margin-right: 0;
}

.login-form
{
    padding-top: 1.5rem;
    padding-bottom: 1.5rem;
}

.login-form .row
{
    margin-left: 0;
    margin-right: 0;
}
    .topnav {
        
      overflow: hidden;
      background-color: white;
      border-bottom: 0.5px solid lightgray;
    }
    
    .topnav a {
       
      float: left;

      justify-content: center;
      display: block;
      color: black;
      text-align: center;
      padding: 8px 18px;
      text-decoration: none;
      font-size: 17px;
      border-bottom: 3px solid transparent;
    }
    
    .topnav a:hover {
        background-color: whitesmoke;
        
      border-bottom: 3px solid royalblue;
    }
    .topnav a.active:hover
    {
        background-color: rgba(226, 238, 255, 0.788);
    }
    .topnav a.active {
      color: royalblue;
      border-bottom: 3px solid royalblue;
    }
    </style>
<body>
    <nav class="navbar navbar-light ">
        <div class="container-fluid">
          

<?php
$con = mysqli_connect('localhost','root','','gpayy');
if (!$con) 
{
  die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"gpayy");
$sql="SELECT *  FROM profile";
$result = mysqli_query($con,$sql);
$q=1;
?>
<div class="inline">
<form class="list-inline-item" name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
   <select name="users"  class="form-control" id="users"   onchange="myform.submit();">

  <option value="">Select USER</option>
  
<?php
while($row = mysqli_fetch_array($result)) {
  echo "<option value=\"" . $row['pid'] . "\">";
  echo "" . $row['name'] . "</option>";
}
?>  

  </select>
</form>
</div>
  </select>



        </div>
      </nav>
      <span style="align-items: center;">
      <div class="topnav d-flex justify-content-center ">
        <a href="Activity.php"class="active"  >Activity</a>
        <a href="send.html" >Tranfer Money</a>
        <a href="register.html">Register</a>
        
      </div>
    </span>

    <div class="row mt-5">
    <div class="col-1"></div>
   <div class="col col-10" style="border-style: groove; border-color: whitesmoke;">
    <table class="table">
        <thead>
          <tr>
            
            <th scope="col">FROM</th>
            <th scope="col">TO</th>
            <th scope="col">AMOUNT</th>
            <th scope="col">STATUS</th>
            
          </tr>
        </thead>
        <tbody>
            <?php      
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "gpayy";  
$q=1;
$con = mysqli_connect($host, $user, $password, $db_name);  
if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}        
if (isset($_POST['users'])) {
  $q= $_POST['users'];
}

        $sql = "select * from `activity` WHERE `from` = ".$q."";  
        $result = mysqli_query($con, $sql);  
        if ($result) {
          
        if ($result->num_rows > 0) 
         {
          
            // output data of each row
            while($row = $result->fetch_assoc()) 
            {
              echo "<tr>";
              $sts=$row['status'];
              if($sts=='successfull')
              {
                echo "<th scope=\"row\">" .$row["from"]. "</td>  <td> " .$row["to"]. " </td> <td> $" .$row["amt"]. "</td> <td class=\"\" style=\"color:rgb(66,195,88)\"> ".$row["status"]."<br>";
              }
            
              else{

              
              echo "<th scope=\"row\">".$row["from"]. "</td>  <td> " .$row["to"]. " </td> <td> $" .$row["amt"]. "</td> <td style=\"color:rgb(255,58,49)\"> ".$row["status"]."<br>";
            }
              echo "</tr>";
                    }
          }
           else
         {
            echo "0 Transactions in this account";
          }
        }
        else{
          echo "Error executing the query: " . mysqli_error($con);
        }

          $con->close();
?>  
        </tbody>
      </table>
    </div>
</div>
</body>
</html>