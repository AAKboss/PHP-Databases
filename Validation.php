<!DOCTYPE html>
<style>
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Gather vars and include special html characters
    $e_num = htmlspecialchars($_POST['e-num']);
    $name = htmlspecialchars($_POST['name']);
    $DOB = htmlspecialchars($_POST['DOB']);
    $num = htmlspecialchars($_POST['num']);
    $email = htmlspecialchars($_POST['email']);

    //Validation code
    if (empty($e_num) || empty($name) || empty($email) || empty($DOB) || empty($num)) {
        $errors[] = "All fields required";
        $e_num = $name = $DOB = $num = $email = "";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif (!ctype_digit($num)) {
        $errors[] = "Contact number should contain numbers only.<BR>Remove spaces if any.";
    } elseif (!ctype_digit($e_num)) {
        $errors[] = "Enrollment Number should contain numbers only.";
    }

    //Displaying errors
    if (!empty($errors)) {
        foreach ($errors as $value) {
            echo $value . "<br>";

        }
        echo "<button onclick='goback()'>Go Back</button>";
    } else {
        //Displaying used to be here.
        //Now we do actual sql here
        $servername = "localhost";
        $username = "AAK";
        $password = "---------";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=Students", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if data already exists (based on enrollment number)
            $checkQuery = "SELECT * FROM student WHERE student_enrollment_number = :e_num";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bindParam(':e_num', $e_num, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                // Data does not exist, insert it
                $insertQuery = "INSERT INTO student (student_enrollment_number, name, birth_date, contact_number, email)
                        VALUES (:e_num, :name, :DOB, :num, :email)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bindParam(':e_num', $e_num, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':DOB', $DOB, PDO::PARAM_STR);
                $stmt->bindParam(':num', $num, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                echo "Data inserted successfully!";
                echo "<form method='GET' action='View Tables.php'>";
                echo "<Button type='submit'>View Tables</button>";
                echo "</form>";
            } else {
                echo "Data with the same enrollment number already exists.<BR>";
                echo "Want to view it or select a different number?";
                echo "<br>";
                echo "<form method='GET' action='View Tables.php'>";
                echo "<Button type='submit'>View Tables</button>&nbsp;&nbsp;";
                echo "<button onclick='goback()'>Go Back</button>";
                echo "</form>";
            }

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage() . "<BR>";
        }

        $conn = null;
    }
}

?>

<script>
    function goback() {
        window.history.back();
    }
</script>
</html>
