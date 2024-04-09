<?php
$servername = "localhost";
$username = "root";
$password = "wilocd7893";
$dbname = "notification_list";
 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>
