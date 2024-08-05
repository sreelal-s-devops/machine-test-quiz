<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_quiz";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$name = $_POST['name']; 
$sql = "SELECT q.id AS question_id, q.question, o.id AS option_id, o.options, o.answer 
        FROM questions q
        JOIN options o ON q.id = o.question_id";
$result = $conn->query($sql);
?>