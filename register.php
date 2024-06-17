<?php

$error = " ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "slezak";
    $password = "heslo123";
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
            $error = "User already exists";//"Error: " . $insert_sql . "<br>" . $conn->error;
        }
      }
    }

    $conn->close();
}

echo '<html>';
   echo '<head>';
   echo '<title>Registration form</title>';
   echo '<style>';
   echo 'body {';
   echo '    display: flex;';
   echo '    align-items: center;';
   echo '    justify-content: center;';
   echo '    height: 100vh;';
   echo '    margin: 0;';
   echo '    background-color: #f2f2f2;';
   echo '}';
   echo 'form {';
   echo '    background-color: #fff;';
   echo '    padding: 20px;';
   echo '    border-radius: 8px;';
   echo '    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);';
   echo '}';
   echo 'input {';
   echo '    width: 100%;';
   echo '    padding: 10px;';
   echo '    margin-bottom: 10px;';
   echo '    border: 1px solid #ccc;';
   echo '    border-radius: 4px;';
   echo '}';
   echo 'input[type="submit"] {';
   echo '    background-color: blue;';
   echo '    color: white;';
   echo '    cursor: pointer;';
   echo '}';
   echo 'p{';
   echo 'color: red;';
   echo 'text-align: center;';
   echo '}';
   echo '</style>';
   echo '</head>';
   echo '<body>';
   echo '<form action="register.php" method="post">';
   echo '<input type="text" name="username" placeholder="Username" required autofocus></br>';
   echo '<input type="email" name="email" placeholder="Email" required autofocus></br>';
   echo '<input type="password" name="password" placeholder="Password" required>';
   echo '<input type="submit" name="register" value="Register">';
   echo '<p>'.$error.'</p>';
   echo '<a href="index.php">Login</a>';
   echo '</form>';
   echo '</body>';
   echo '</html>';
  
?>
