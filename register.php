<?php

$error = " ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "oliver";
    $password = "koberec";
    $dbname = "slezak3a2";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $input_username = $_POST['username'];
    $input_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $input_email = $_POST['email'];

    $check_username_sql = "SELECT * FROM t_user WHERE username='$input_username'";
    $result = $conn->query($check_username_sql);
    $check_email_sql = "SELECT * FROM t_user WHERE email='$input_email'";
    $result2 = $conn->query($check_email_sql);

    if ($result->num_rows > 0) {
        $error = "Username already exists. Please choose a different username.";
    } else {
      if($result2->num_rows > 0){
        $error = "E-mail already in use";
      }
      else{
        $insert_sql = "INSERT INTO t_user (username, password, email) VALUES ('$input_username', '$input_password', '$input_email')";

        if ($conn->query($insert_sql) === TRUE) {
            $error = "New login created";
        } else {
            $error = "User already exists";
        }
      }
    }

    $conn->close();
}

echo '<html>';
   echo '<head>';
   echo '<title>Registration form</title>';
   echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
   echo '<style>';
   echo 'body {';
   echo '    background-color: #e0f7fa;';
   echo '    display: flex;';
   echo '    justify-content: center;';
   echo '    align-items: center;';
   echo '    height: 100vh;';
   echo '    margin: 0;';
   echo '}';
   echo '.container {';
   echo '    background-color: #ffffff;';
   echo '    padding: 30px;';
   echo '    border-radius: 15px;';
   echo '    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);';
   echo '    max-width: 400px;';
   echo '    width: 100%;';
   echo '}';
   echo 'h2 {';
   echo '    text-align: center;';
   echo '    margin-bottom: 20px;';
   echo '    color: #00796b;';
   echo '}';
   echo '.form-control {';
   echo '    border-radius: 30px;';
   echo '    padding: 10px 20px;';
   echo '}';
   echo '.btn-primary {';
   echo '    background-color: #00796b;';
   echo '    border-color: #00796b;';
   echo '    border-radius: 30px;';
   echo '    padding: 10px 20px;';
   echo '    width: 100%;';
   echo '}';
   echo '.btn-primary:hover {';
   echo '    background-color: #004d40;';
   echo '    border-color: #004d40;';
   echo '}';
   echo '.error {';
   echo '    color: red;';
   echo '    text-align: center;';
   echo '    margin-bottom: 20px;';
   echo '}';
   echo 'p {';
   echo '    text-align: center;';
   echo '}';
   echo 'p a {';
   echo '    color: #00796b;';
   echo '}';
   echo '</style>';
   echo '</head>';
   echo '<body>';
   echo '<div class="container">';
   echo '<h2>Register</h2>';
   echo '<form action="register.php" method="post">';
   echo '<div class="form-group">';
   echo '<input type="text" class="form-control" name="username" placeholder="Username" required autofocus>';
   echo '</div>';
   echo '<div class="form-group">';
   echo '<input type="email" class="form-control" name="email" placeholder="Email" required>';
   echo '</div>';
   echo '<div class="form-group">';
   echo '<input type="password" class="form-control" name="password" placeholder="Password" required>';
   echo '</div>';
   echo '<button type="submit" name="register" class="btn btn-primary">Register</button>';
   echo '</form>';
   echo '<p class="mt-3">';
   echo '<a href="index.php">Login</a>';
   echo '</p>';
   echo '<div class="error">'.$error.'</div>';
   echo '</div>';
   echo '</body>';
   echo '</html>';
?>