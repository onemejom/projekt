<?php
session_start(); //otvorenie session

//kontrola ci uz bol potvrdeny formular a ci boli vyplnene obidva udaje aj username aj password
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {

    //connect string do DB
    $servername = "localhost";
    $username = "Jozko";
    $password = "123";
    $dbname = "slezak3a2";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //echo "Connected successfully";

    //vyber hesla z DB podla usera, ktory sa prihlasuje
    $sql = "SELECT password FROM t_user where username ='" . $_POST['username'] . "'";
    $result = $conn->query($sql);

    //ak vrati select viac ako 0 riadkov, user existuje
    if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        //if($row["password"]==$_POST['password']) {
        if (password_verify($_POST['password'], $row["password"])) {
            $_SESSION['valid'] = true; //ulozenie session
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $_POST['username'];

            //presmerovanie na dalsiu stranku
            header("Location: welcome.php", true, 301);
            exit();
        } else {
            $login_error = "wrong password";
        }
    } else {
        $login_error = "wrong username";
    }

    $conn->close();
}

//formular            
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 5%;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container col-md-4">
        <h2 class="mb-4">Login</h2>
        <?php if (isset($login_error)) { ?>
            <div class="error"><?php echo $login_error; ?></div>
        <?php } ?>
        <form action="index.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>

</html>
