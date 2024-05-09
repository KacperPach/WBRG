<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
</head>
<body>
    <?php
        $username = isset($_COOKIE["username"]) ? $_COOKIE["username"] :"";
        $password = isset($_COOKIE["password"]) ? $_COOKIE["password"] :"";
    ?>

    <div class="login-container">
        <h2>Login Form</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" value="<?php echo $username?>" required>
            <input type="password" name="password" placeholder="Password" value="<?php echo $password?>" required>
            <input type="submit" value="Login">
        </form>
    </div>

    <?php
        function getValue( $key ) {
            $value = isset($_POST[$key])? $_POST[$key]: '';
            if ( $value != '' ) {
                setcookie($key, $value, time() + (86400 * 30));
            }
            return $value;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = getValue('username');
            $password = getValue('password');

            if ($username == "admin" && $password == "admin") {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;

                header('Location: form.php');
                exit;
            } else {
                echo "login or password is incorrect";
            }
        }

    ?>


</body>
</html>
