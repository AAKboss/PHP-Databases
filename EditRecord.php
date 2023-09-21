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
        margin-left: auto;
        margin-right: auto;
        text-align: left;
    }

    #DOB {
        width: 153px;
        text-align: center;
    }
</style>

<head>
    <title>PHP-Assignment</title>
</head>

<body>
    <h2>Edit Record</h2>
    <form action='EditRecord.php' method='POST'>
        <table>
            <tr>
                <td>Enter Enrollment Number:</td>
                <td><input type='text' name='e_num' id='e_num'></td>
            </tr>
            <tr>
                <td>Enter New Enrollment Number:</td>
                <td><input type='text' name='new_e_num' id='new_e_num'></td>
            </tr>
            <tr>
                <td>Enter Name:</td>
                <td><input type='text' name='name' id='name'></td>
            </tr>
            <tr>
                <td>Enter Date of Birth:</td>
                <td><input type='date' name='DOB' id='DOB'></td>
            </tr>
            <tr>
                <td>Enter Contact Number:</td>
                <td><input type='text' name='num' id='num'></td>
            </tr>
            <tr>
                <td>Enter Email:</td>
                <td><input type='email' name='email' id='email'></td>
            </tr>
        </table>
        <br><button type='submit'>Submit</button>
        <button formaction="Editing.php">Go Back</button>
    </form>

</body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data 
    if (isset($_POST['e_num'])) {
        $e_num = htmlspecialchars($_POST['e_num']);
    }
    if (isset($_POST['new_e_num'])) {
        $new_e_num = htmlspecialchars($_POST['new_e_num']);
    }
    if (isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
    }
    if (isset($_POST['DOB'])) {
        $DOB = htmlspecialchars($_POST['DOB']);
    }
    if (isset($_POST['num'])) {
        $num = htmlspecialchars($_POST['num']);
    }
    if (isset($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);
    }

    // Connection details
    $servername = "localhost";
    $username = "AAK";
    $password = "---------";
    $dbname = "Students";

    try {
        // Connection to the database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the Enrollment number is in use
        $checkQueryNewENum = "SELECT COUNT(*) FROM student WHERE student_enrollment_number = :new_e_num";
        $stmtCheck = $conn->prepare($checkQueryNewENum);
        $stmtCheck->bindParam(':new_e_num', $new_e_num);
        $stmtCheck->execute();
        $numRows = $stmtCheck->fetchColumn();
        if ($numRows > 0) {
            echo "<h3>The new enrollment number is already in use. Please choose a different one.</h3>";
            exit; // Exit the script to prevent further execution
        }

        // The SQL UPDATE query
        $updateQuery = "UPDATE student SET ";
        $updates = array();

        // Check each field for empty
        if (!empty($new_e_num)) {
            $updates[] = "student_enrollment_number = :new_e_num";
        }
        if (!empty($name)) {
            $updates[] = "name = :name";
        }
        if (!empty($DOB)) {
            $updates[] = "birth_date = :DOB";
        }
        if (!empty($num)) {
            $updates[] = "contact_number = :num";
        }
        if (!empty($email)) {
            $updates[] = "email = :email";
        }

        // Check if any updates were specified
        if (!empty($updates)) {
            $updateQuery .= implode(", ", $updates);
            $updateQuery .= " WHERE student_enrollment_number = :e_num";

            // Prepare and execute the query, binding parameters as needed
            $stmt = $conn->prepare($updateQuery);

            if (!empty($new_e_num)) {
                $stmt->bindParam(':new_e_num', $new_e_num);
            }
            if (!empty($name)) {
                $stmt->bindParam(':name', $name);
            }
            if (!empty($DOB)) {
                $stmt->bindParam(':DOB', $DOB);
            }
            if (!empty($num)) {
                $stmt->bindParam(':num', $num);
            }
            if (!empty($email)) {
                $stmt->bindParam(':email', $email);
            }

            $stmt->bindParam(':e_num', $e_num);

            if ($stmt->execute()) {
                echo "<h3>Record updated successfully.</h3>";
            } else {
                echo "<h3>Error updating record: " . $stmt->errorInfo()[2] . "</h3>";
            }
        } else {
            echo "<h3>No updates specified.</h3>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    // Invalid request
    echo "Invalid edit request.";
}
?>

</html>
