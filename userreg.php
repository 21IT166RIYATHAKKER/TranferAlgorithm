<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<?php
$host = "localhost";
$user = "root";
$password = '';
$db_name = "gpayy";
$con = mysqli_connect($host, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("Failed to connect with MySQL: " . mysqli_connect_error());
}
if (isset($_POST['pid']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['country']) && isset($_POST['phno']) && isset($_POST['address']) && isset($_POST['balance']) && isset($_POST['lang']) && isset($_POST['atype']) && isset($_POST['pin'])) {
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $phno = $_POST['phno'];
    $address = $_POST['address'];
    $balance = $_POST['balance'];
    $lang = $_POST['lang'];
    $atype = $_POST['atype'];
    $pin = $_POST['pin'];
    $sql = "INSERT INTO profile (pid, name, country, address, balance, email, phno, pin, lang, atype) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ssssdsssss", $pid, $name, $country, $address, $balance, $email, $phno, $pin, $lang, $atype);

        if ($stmt->execute()) {
            echo "New record created successfully";
            echo "<h3><a href=\"send.html\" style='margin-left: 10px;'> Go to profile</a></h3>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $con->error;
    }
} else {
    echo "One or more required values are missing in the POST data.";
}

$con->close();
?>
</html>
