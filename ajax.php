<?php
$type = $_GET['type'];
$nameP = $_GET['name'];
$password = $_GET['password'];
$message = $_GET['message'];

$servername = "sql.njit.edu";
$username = "jp47";
$dbpassword = "Pjimit-2167";
$dbname = "jp47";
$result4 = '';

$conn = new mysqli($servername, $username, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($type == 'write') {
    $sql2 = "SELECT * FROM chats WHERE `name`='" . $nameP . "'";
    $result = $conn->query($sql2);
    if ($result->num_rows > 0) {
        $sql = "UPDATE chats SET `Content` = '". $message ."' WHERE `name`='" . $nameP . "' AND `password`='" . $password . "'";
        if($conn->query($sql)) {
            $result4 = 'Success';
        } else {
            $result4 = 'Error: ' . $sql . ' ' . $conn->error;
        }
    } else {
        $sql = "INSERT INTO chats (`name`, `password`, `Content`) VALUES ('".$nameP."','".$password."','".$content."')";
        if($conn->query($sql)) {
            $result4 = 'Success';
        } else {
            $result4 = 'Error: ' . $sql . ' ' . $conn->error;
        }
    }
} else if ($type == 'read'){
    $result = $conn->prepare("SELECT content FROM chats WHERE `name` = ?");
    $result->bind_param("s", $nameP);
    $result->execute();
    $result->store_result();
    $result->bind_result($cont);
    $result->fetch();
    $result->close();
    $result4 = $cont;
} else if ($type == 'name') {
    $result = $conn->query("SELECT `name` FROM chats");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $result4 .= (" " . $row['name']);
        }
    }
}

echo $result4;

$conn->close();