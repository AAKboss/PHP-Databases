<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP-Assignment</title>
</head>

<style>
    table {
        border: solid 1px black;
    }

    table td {
        border: solid 1px black;
    }

    #cntalign {
        text-align: center;
    }
</style>

<body>
    <h1>Simple Calculator</h1>
    <form method="post" action="Assignment1-2.php">
        <table>
            <tr>
                <td><b>Your result:</b></td>
                <td name="result" id="result"></td>
            </tr>
            <tr>
                <td><B>First digit:</B></td>
                <td><input value="420" type="number" name="num1" id="num1"></td>
            </tr>
            <tr>
                <td><b>Second digit: </b></td>
                <td><input value="246" type="number" name="num2" id="num2"></td>
            </tr>
            <tr>
                <td><B>Choose operation:</B></td>
                <td id="cntalign"><select name="operation">
                        <option value="add">Addition</option>
                        <option value="sub">Subtraction</option>
                        <option value="mult">Multiplication</option>
                        <option value="divi">Division</option>
                    </select></td>
            </tr>
            <tr>
                <td id="cntalign" colspan="2"><button type="submit">Show Result</button></td>
            </tr>
        </table>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];
        $operation = $_POST["operation"];
        $result = 0;
        
        if ($num1 != null) {
            if ($num2 != null) {
                switch ($operation) {
                    case "add":
                        $result = $num1 + $num2;
                        break;
                    case "sub":
                        $result = $num1 - $num2;
                        break;
                    case "mult":
                        $result = $num1 * $num2;
                        break;
                    case "divi":
                        if ($num2 != 0) {
                            $result = $num1 / $num2;
                        } else {
                            echo "Cannot divide by zero!";
                            $num1 = $num2 = null;
                        }
                        break;
                    default:
                        echo "Invalid operation selected";
                }
            }
            else {
                echo "Cannot compute result";
                $num1 = $num2 = null;
            }
        }
        else {
            echo "Cannot compute result";
            $num1 = $num2 = null;
        }
        echo '<script>document.getElementById("result").textContent="' . $result . '";</script>';
        echo '<script>document.getElementById("num1").value="' . $num1 . '";</script>';
        echo '<script>document.getElementById("num2").value="' . $num2 . '";</script>';
    }
    ?>
</body>

</html>