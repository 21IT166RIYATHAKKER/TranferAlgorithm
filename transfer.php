<?php

$host = "localhost";
$user = "root";
$password = '';
$db_name = "gpayy";

$con = mysqli_connect($host, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("Failed to connect with MySQL: " . mysqli_connect_error());
}

if (isset($_POST['from']) && isset($_POST['to']) && isset($_POST['pin']) && isset($_POST['amt'])) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $pin = $_POST['pin'];
    $amt = $_POST['amt'];
    
    $sql = "SELECT balance FROM profile WHERE pid='$from' AND pin='$pin'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_array($result)) {
        $balance = $row['balance'];
        $fb = $balance - $amt;

        $min = 0;
        if ($fb < $min) {
            $sql = "INSERT INTO `activity` (`from`, `to`, `amt`, `status`) VALUES ('$from', '$to', '$amt', 'INSUFFICIENT BALANCE')";
            if ($con->query($sql) === TRUE) {
                echo "Record inserted Succesfully <br>";
            }
            echo "INSUFFICIENT BALANCE";
        } else {
            $sql = "UPDATE `profile` SET balance='$fb' WHERE pid='$from'";
            if ($con->query($sql) === TRUE) {
                echo "Amount Debited Successfully from ID:$from<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }

            $sql = "SELECT balance FROM profile WHERE pid='$to'";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $balance = $row['balance'];
                $tb = $balance + $amt;
            }

            $sql = "UPDATE profile SET balance='$tb' WHERE pid='$to'";
            if ($con->query($sql) === TRUE) {
                echo "Amount credited Successfully to ID:$to<br>";
                $sql = "INSERT INTO activity (`from`, `to`, `amt`, `status`) VALUES ('$from', '$to', '$amt', 'successfull')";
                if ($con->query($sql) === TRUE) {
                    
                }
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        }
    } else {
        $sql = "INSERT INTO `activity` (`from`, `to`, `amt`, `status`) VALUES ('$from', '$to', '$amt', 'Pin ERROR')";
        echo "<p style='margin-left: 10px; font-size: 25px; color: red; font-weight: bold;'>Pin error</p>";
    }
} else {
    echo "One or more required values are missing.";
}

echo "<h3><a href=\"send.html\" style='margin-left: 10px;'> Go to profile</a></h3>";
$con->close();

?>
