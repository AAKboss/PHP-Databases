<!DOCTYPE html>
<html>
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

<body>
    <h2>Edit Page</h2>
    <form action="Editing.php" method="POST">
        <input type="text" name="name" id="name" placeholder="Enter Name">
        <input type="text" name="e_num" id="e_num" placeholder="Enter Enrollment Number">
        <BR><BR><button type="submit">Check</button>
    </form>
</body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['e_num'])) {
        $e_num = htmlspecialchars($_POST['e_num']);
    }
    if (isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
    }
    
    if (!empty($e_num)) {
        if (!ctype_digit($e_num)) {
            echo "<h3>Enrollment Number should contain numbers only.</h3>";
        }
    }
    elseif (empty($e_num) && empty($name)) {
        echo "<h3>Enter at least a name or number.</h3>";
    }

    $servername = "localhost";
    $username = "AAK";
    $password = "Azgar Ali";
    $dbname = "Students";
    
    try {
        $conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $checkQuerye_num = "SELECT * FROM student WHERE student_enrollment_number = :e_num";
        $stmt1 = $conn->prepare($checkQuerye_num);
        $stmt1->bindParam(":e_num", $e_num);
        
        $checkQueryname = "SELECT * FROM student WHERE name = :name";
        $stmt2 = $conn->prepare($checkQueryname);
        $stmt2->bindParam(":name", $name);

        $stmt1->execute();
        $stmt2->execute();

        // Display 
        echo "<style>table {border: solid 1px black;}</style>";
        echo "<table>";
        echo "<tr><th><u>Enrollment Number</u></th><th><u>Name</u></th><th><u>Date of Birth</u></th><th><u>Contact Number</u></th><th><u>Email</u></th><th>Edit</th></tr>";

        foreach ($stmt1 as $row) {
            echo "<tr>";
            echo "<td>" . $row['student_enrollment_number'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['birth_date'] . "</td>";
            echo "<td>" . $row['contact_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td><form action='EditRecord.php' method='POST'>
            <input type='hidden' name='edit_id' value='" . $row['student_enrollment_number'] . "'>
            <input type='hidden' name='edit_id_name' value='" . $row['name'] . "'>
            <button type='submit' name='edit_record'>Edit</button>
            </form></td>";
            echo "</tr>";
        }

        foreach ($stmt2 as $row) {
            echo "<tr>";
            echo "<td>" . $row['student_enrollment_number'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['birth_date'] . "</td>";
            echo "<td>" . $row['contact_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td><form action='EditRecord.php' method='POST'>
            <input type='hidden' name='edit_id' value='" . $row['student_enrollment_number'] . "'>
            <input type='hidden' name='edit_id_name' value='" . $row['name'] . "'>
            <button type='submit' name='edit_record'>Edit</button>
            </form></td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<form action='Form Page.html'>";
        echo "<BR><button type='submit'>Go Back</button>";
        echo "</form>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}
?>
</html>
