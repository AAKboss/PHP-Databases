<!DOCTYPE html>
<style type="text/css">
    html {
        background-color: silver;
        margin-left: 25px;
        margin-right: 25px;
        text-align: center;
    }
    
    table {
        position: relative;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<head>
    <title>PHP-Assignment</title>
</head>

<?php
$servername = "localhost";
$username = "AAK";
$password = "---------";
$dbname = "Students";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to retrieve all rows from the database
    $selectQuery = "SELECT * FROM student";
    $stmt = $conn->query($selectQuery);

    // Display the retrieved data
    echo "<h2>The Database</h2>";
    echo "<style>table {border: solid 1px black;}</style>";

    echo "<table>";
    echo "<tr><th><u>Enrollment Number</u></th><th><u>Name</u></th><th><u>Date of Birth</u></th><th><u>Contact Number</u></th><th><u>Email</u></th></tr>";
    foreach ($stmt as $row) {
        echo "<tr>";
        echo "<td>" . $row['student_enrollment_number'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['birth_date'] . "</td>";
        echo "<td>" . $row['contact_number'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<button onclick='goback2()'>Back to Form</button>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

?>
<script>
    function goback2() {
        window.history.back();
        window.history.back();
    }
</script>

</html>
