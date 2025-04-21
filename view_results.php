<?php
// viewresult.php
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Assessment Results</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        table th {
            cursor: pointer;
        }
        #searchInput {
            max-width: 300px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Student Assessment Results</h2>

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by name...">

    <div class="table-responsive">
        <?php
        if ($result->num_rows > 0) {
            echo "<table id='studentTable' class='table table-bordered table-hover table-striped'>";
            echo "<thead class='table-dark'><tr>
                    
                    <th onclick='sortTable(1)'>Name</th>
                    <th onclick='sortTable(2)'>Attendance (%)</th>
                    <th onclick='sortTable(3)'>Unit Test</th>
                    <th onclick='sortTable(4)'>Achievements</th>
                    <th onclick='sortTable(5)'>Mock Practical</th>
                    <th onclick='sortTable(6)'>Term Work</th>
                </tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["attendance"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["unit_test_score"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["achievements"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["mock_practical_score"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["term_work"]) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-center text-muted'>No records found.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<!-- JavaScript for sorting and searching -->
<script>
    function sortTable(columnIndex) {
        const table = document.getElementById("studentTable");
        let rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        switching = true;
        dir = "asc";

        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[columnIndex];
                y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
                if (dir === "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                } else if (dir === "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

    document.getElementById("searchInput").addEventListener("keyup", function () {
        const input = this.value.toLowerCase();
        const rows = document.querySelectorAll("#studentTable tbody tr");
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            row.style.display = name.includes(input) ? "" : "none";
        });
    });
</script>

</body>
</html>
