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
    <h2>Delete Page</h2>
    <form action="Deletion.php" method="POST">
        <input type="text" name="name" id="name" placeholder="Enter Name">
        <input type="text" name="e_num" id="e_num" placeholder="Enter Enrollment Number">
        <BR><BR><button type="submit">Check</button>
    </form>
</body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'e_num' and 'name' exist
    if (isset($_POST['e_num'])) {
        $e_num = htmlspecialchars($_POST['e_num']);
    }
    if (isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
    }

    $servername = "localhost";
    $username = "AAK";
    $password = "---------";
    $dbname = "Students";

    if (!empty($e_num)) {
        if (!ctype_digit($e_num)) {
            echo "<h3>Enrollment Number should contain numbers only.</h3>";
        }
    }
    elseif (empty($e_num) && empty($name)) {
        echo "<h3>Enter at least a name or number.</h3>";
    }

    //Actual Code
    try {
        //Attempting connetion
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to retrieve data based on enrollment number
        $checkQuerye_num = "SELECT * FROM student WHERE student_enrollment_number = :e_num";
        $stmt1 = $conn->prepare($checkQuerye_num);
        $stmt1->bindParam(':e_num', $e_num); // Bind the value

        // Query to retrieve data based on name
        $checkQueryname = "SELECT * FROM student WHERE name = :name";
        $stmt2 = $conn->prepare($checkQueryname);
        $stmt2->bindParam(':name', $name); // Bind the value

        //Delete SQL E_num
        $delsqle_num = "DELETE FROM student WHERE student_enrollment_number = :e_num";
        $stmt3 = $conn->prepare($delsqle_num);
        $stmt3->bindParam(':e_num', $e_num);

        //Delete SQL Name
        $delsqlname = "DELETE FROM student WHERE name = :name";
        $stmt4 = $conn->prepare($delsqlname);
        $stmt4->bindParam(':name', $name);

        // Execute the queries
        $stmt1->execute();
        $stmt2->execute();

        // Display the retrieved data
        echo "<style>table {border: solid 1px black;}</style>";
        echo "<table>";
        echo "<tr><th><u>Enrollment Number</u></th><th><u>Name</u></th><th><u>Date of Birth</u></th><th><u>Contact Number</u></th><th><u>Email</u></th></tr>";

        foreach ($stmt1 as $row) {
            echo "<tr>";
            echo "<td>" . $row['student_enrollment_number'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['birth_date'] . "</td>";
            echo "<td>" . $row['contact_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td><form action='DeleteRecord.php' method='POST'>
                    <input type='hidden' name='delete_id' value='" . $row['student_enrollment_number'] . "'>
                    <input type='hidden' name='delete_id_name' value='" . $row['name'] . "'>
                    <button type='submit' name='delete_record'>Delete</button>
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
            echo "<td><form action='DeleteRecord.php' method='POST'>
                    <input type='hidden' name='delete_id' value='" . $row['student_enrollment_number'] . "'>
                    <input type='hidden' name='delete_id_name' value='" . $row['name'] . "'>
                    <button type='submit' name='delete_record'>Delete</button>
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
