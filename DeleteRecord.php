<!DOCTYPE html>
<html>
<style type="text/css">
    html {
        background-color: silver;
        margin-left: 25px;
        margin-right: 25px;
        text-align: center;
    }
</style>

<head>
    <title>PHP-Assignment</title>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_record'])) {
    // Details gathering
    $delete_id = $_POST['delete_id'];
    $name = $_POST['delete_id_name'];

    // Connection details
    $servername = "localhost";
    $username = "AAK";
    $password = "---------";
    $dbname = "Students";

    try {
        // Connection to the database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to delete the record based on student enrollment number
        $deleteQuery = "DELETE FROM student WHERE student_enrollment_number = :delete_id";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);

        // Execute delete 
        $stmt->execute();

        // Check if any rows/ the record was successfully deleted
        if ($stmt->rowCount() > 0) {
            echo "Record with Enrollment Number $delete_id (Name: $name) has been deleted successfully.";
        } else {
            echo "Record with Enrollment Number $delete_id (Name: $name) not found.";
        }

        echo "<form action='Form Page.html'>";
        echo "<BR><button type='submit'>Go Back</button>";
        echo "</form>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    // Delete not handled probably
    echo "Invalid delete request.";
}
?>

</html>
