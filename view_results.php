<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_assessment";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Attendance (%)</th><th>Unit Test</th><th>Achievements</th><th>Mock Practical</th><th>Term Work</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["attendance"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["unit_test_score"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["achievements"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["mock_practical_score"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["term_work"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found.</p>";
}

$conn->close();
?>
