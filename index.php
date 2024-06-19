<?php
session_start(); // otevření session

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    // connect string do DB
    $servername = "localhost";
    $username = "oliver";
    $password = "koberec";
    $dbname = "slezak3a2";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // vyber hesla z DB podle usera, který se přihlašuje
    $sql = "SELECT password FROM t_user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    // pokud vrátí select více než 0 řádků, user existuje
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($_POST['password'], $row["password"])) {
            $_SESSION['valid'] = true; // uložení session
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $_POST['username'];

            // přesměrování na další stránku
            header("Location: welcome.php");
            exit();
        } else {
            $login_error = "Wrong password";
        }
    } else {
        $login_error = "Wrong username";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e0f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00796b;
        }

        .form-control {
            border-radius: 30px;
            padding: 10px 20px;
        }

        .btn-primary {
            background-color: #00796b;
            border-color: #00796b;
            border-radius: 30px;
            padding: 10px 20px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #004d40;
            border-color: #004d40;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
        }

        p a {
            color: #00796b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
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