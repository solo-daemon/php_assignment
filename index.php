<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }

        label {
            display: block;
            padding: 15px 0px;
            color: rgb(73, 38, 73);
        }

        input {
            outline: none;
            display: block;
            padding-top: 7px;
            border-width: 0 0 2px 0;
            border-color: rgb(245, 17, 245);
        }

        .container {
            margin: 15% auto;
            border: 2px solid purple;
            padding: 20px 0;
            border-radius: 5px;
            width: 20%;
            display: flex;
            align-items: center;
            flex-direction: column;
            box-shadow: 1px 1px 4px 1px rgb(140, 3, 145);
        }

        .signup {
            width: 100%;
            justify-content: left;

            padding: 0 33px;
        }

        button {
            background-color: rgb(163, 21, 132);
            color: white;
            border-radius: 5px;
            padding: 6px 6px;
            margin: 10px 0;
        }

        span {
            color: red;
            font-size: 75%;
        }
    </style>

</head>

<body>
    <?php
    $ver = 0;
    $err = 0;
    $redir = 0;
    $user = $pass = $user_err = $pass_err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["user"])) {
            $user_err = "Required";
            $err += 1;
        } else {
            $user = test_input($_POST["user"]);
        }
        if (empty($_POST["pass"])) {
            $pass_err = "Required";
        } else {
            $pass = hash('sha256', test_input($_POST["pass"]), true);
        }
        if ($err == 0) {
            require './MODULES/connect.php';
            $sql = 'select * from auth where username="' . $user . '";';
            $sql_1 = 'select Role from users where username="' . $user . '";';
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_array();
                if ($row["password"] == $pass) {
                    echo "successfull login !";
                    $_SESSION["id"] = $user;
                    $result_1 = $conn->query($sql_1);
                    include './MODULES/objects.php';
                    echo "hello";
                    echo $result_1->num_rows;
                    $row_1 = $result_1->fetch_array();
                    if ($row_1["Role"] == "Student") {
                        echo "student";
                        $obj = new Student();
                        $_SESSION['role'] = $row_1["Role"];
                        $redir = 1;
                        header("Location: http://localhost:8001/TEMPLATES/dashboard_student.php", true, 301);
                    } else if ($row_1["Role"] == "Reviewer") {
                        echo "Reviewer";
                        $obj = new Reviewer();
                        $_SESSION['role'] = $row_1["Role"];
                        $redir = 2;
                        header("Location: http://localhost:8001/TEMPLATES/dashboard_reviewer.php", true, 301);
                    }
                }
            } else {
                $ver = 1;
            }
        } else {
            $ver = 1;
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form">
            <?php
            if ($ver == 1) {
                echo "<span>* Invalid username or password</span>";
            }
            ?>
            <label for="username">Username :</label>
            <input type="text" id="username" name="user" placeholder="30 cahracters">
            <label for="password">Password :</label>
            <input type="password" id="password" name="pass">
            <button type="submit">Log-in</button>
        </form>
        <div class="signup">
            <a href="./WEBSITE/signup.php"> <button type="button">signup</button></a>
        </div>
    </div>
    ?>
</body>

</html>