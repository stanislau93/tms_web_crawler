<?php

const PEPPER = 'egorletov';

session_start();

# Создаём уникальный токен, который не сможет угадать хакер
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwd_repeat'];

    $errors = [];

    if ($pwd !== $pwdRepeat) {
        $errors[] = 'Passwords do not match!';
    }

    // some password check...

    if (empty($errors)) {
        $salt = base64_encode(random_bytes(12));

        $hash = password_hash($pwd.$salt.PEPPER, PASSWORD_BCRYPT);

        $f = fopen('users', 'w+');
        fwrite($f, $uname.' '.$hash.' '.$salt.PHP_EOL);
        fclose($f);
        
        # изменить айди сессии - для безопасности
        # а также уничтожь предыдущую сессию (это не обязательно)
        session_regenerate_id();
        $_SESSION['identity'] = $uname;
        header('Location: /');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>LogIn</title>
</head>

<body>
    <div class="wrapper">
        <div class="content">
            <div class="wrapper-form">
                <form class="form" action="/register.php" method="POST">
                    <div class="wrapper-flex">
                        <div class="login">
                            <label for="uname">username</label><br>
                            <input type="text" id="uname" name="uname" placeholder="username" />
                        </div>
                        <div class="password">
                            <label for="pwd">password</label><br>
                            <input type="password" id="pwd" name="pwd" placeholder="password" />
                        </div>
                        <div class="password">
                            <label for="pwd_repeat">repeat password</label><br>
                            <input type="password" id="pwd_repeat" name="pwd_repeat" />
                        </div>
                    </div>

                    <input type="hidden" id="csrf" name="csrf" value="<?php echo $_SESSION['csrf_token'] ?>" />

                    <button class="btn" type="submit">REGISTER</button>
                </form>
            </div>
        </div>
    </div>

    <div class="errors">
        <?php
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        ?>
    </div>

</body>

</html>